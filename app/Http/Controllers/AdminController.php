<?php


namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;


class AdminController extends Controller {

    const LOG_PATH = '/oa/storage/logs';

    public function home() {
        return view('admin.admin_home', ['page' => 'home']);
    }

    public function logs() {
        return view('admin.admin_home', ['page' => 'logs']);
    }

    public static function log_statistics_overview() {

        $hosts = [
            'prod'   => ['/var/www' . self::LOG_PATH, null],
            'dev'    => ['/home/dev' . self::LOG_PATH, null],
            'nick'   => ['/home/nick' . self::LOG_PATH, null],
            'arteen' => ['/home/arteen' . self::LOG_PATH, null],
            'tyler'  => ['/home/tyler' . self::LOG_PATH, null]
        ];


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

    public static function get_messages($level) {
        return ['Example message. Later form a SQL query against admin_messages'];
    }

}
