<?php
namespace App;

class Environment {
    const KEY_FILE_PATH = '/etc/oa/oa-keys';
    const KEY = 0;
    const VALUE = 1;

    public static function get_env($key) {
        $env_handle = fopen(self::KEY_FILE_PATH, "r");
        while (!feof($env_handle)){
            $line = explode("=", fgets($env_handle));
            if ($line[self::KEY] == $key) {
                fclose($env_handle);
                return trim($line[trim(self::VALUE)]);
            }
        }
        return null;
    }
}
