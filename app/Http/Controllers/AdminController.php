<?php


namespace App\Http\Controllers;
use App\WebUtils;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller {

    const LOG_PATH = '/oa/storage/logs';

    /**
     * Admin panel endpoint. Builds blade template based on supplied 'page' parameter
     */
    public function home() {

        if (Request::has('page')) {
            switch (Request::get('page')) {
                case 'logs':
                    return view('admin.layout', ['page' => Request::get('page')]);
                default:
                    return view('admin.layout', ['page' => 'home']);
            }
        }
        return view('admin.layout', ['page' => 'home']);
    }

    /**
     * Generates a line count (total and per level) for each respective
     * virtual host logfile.
     * @return array[] - Full of hosts/counts
     */
    public static function log_statistics_overview() {

        if (!WebUtils::is_local()) {
            $hosts = [
                'prod'   => ['/var/www' . self::LOG_PATH, null],
                'dev'    => ['/var/www' . self::LOG_PATH, null],
                'nick'   => ['/home/nick' . self::LOG_PATH, null],
                'arteen' => ['/home/arteen' . self::LOG_PATH, null],
                'tyler'  => ['/home/tyler' . self::LOG_PATH, null]
            ];
        }
        else {
            $hosts = [
                'local' => [getcwd() . '/../storage/logs', null]
            ];
        }


        foreach ($hosts as $host => $host_out) {

            $log_levels = [
                '.INFO' => 0,
                '.NOTICE' => 0,
                '.DEBUG' => 0,
                '.WARNING' => 0,
                '.ERROR' => 0,
                '.TOTAL' => 0,
            ];
            $log_path = $host_out[0];

            if ($log_files = scandir($log_path)) {
                foreach ($log_files as $log_file) {
                    $log_handle = fopen($log_path . '/' . $log_file, 'r');
                    while (($line = fgets($log_handle)) !== false) {
                        foreach ($log_levels as $log_level => $val) {
                            if (strpos($line, $log_level) !== false) {
                                $log_levels[$log_level]++;
                            }
                        }
                    }
                }
            }
            $log_levels['.TOTAL'] = array_sum(array_values($log_levels));
            $hosts[$host] = $log_levels;
        }
        return $hosts;
    }


    /**
     * Returns the actual contents of the specified hosts logfile
     * @return string
     */
    public static function get_logs() {
        if (!(Auth::user() && Auth::user()->admin)) {
            http_response_code(401);
            return 'Not authorized';
        }
        if (!Request::has('host')) {
            http_response_code(400);
            return 'Please specify host';
        }
        if (!WebUtils::is_local()) {
            $hosts = [
                'prod'   => '/var/www' . self::LOG_PATH,
                'dev'    => '/home/dev' . self::LOG_PATH,
                'nick'   => '/home/nick' . self::LOG_PATH,
                'arteen' => '/home/arteen' . self::LOG_PATH,
                'tyler'  => '/home/tyler' . self::LOG_PATH,
            ];
        }
        else {
            $hosts = [
                'local' => getcwd() . '/../storage/logs'
            ];
        }
        if (!in_array(Request::get('host'), array_keys($hosts))) {
            http_response_code(400);
            return 'Invalid host';
        }
        $log_lines = [];
        if ($log_files = scandir($hosts[Request::get('host')])) {
            foreach ($log_files as $log_file) {
                $handle = fopen($hosts[Request::get('host')] . '/' . $log_file, 'r');
                while (($line = fgets($handle)) !== false) {
                    array_push($log_lines, $line);
                }
            }
        }
        $log_lines = array_reverse($log_lines);
        foreach ($log_lines as $line) {
            echo $line;
        }
    }

    /**
     * Returns unread messages in the admin_message table
     * @param $level - Message level to retrieve
     * @return array - Array of message strings
     */
    public static function get_unread_messages($level) {
        $res = DB::table('admin_messages')
            ->where('level', $level)
            ->where('read', 'N')
            ->get()
            ->toArray();
        $out = [];
        if (count($res)) {
            foreach ($res as $row) {
                array_push($out, $row->message);
            }
        }
        return $out;
    }

}
