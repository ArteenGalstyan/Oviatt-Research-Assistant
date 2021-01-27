<?php
namespace App;

class Environment {
    const KEY_FILE_PATH = '/etc/oa/oa-keys';
    const KEY = 0;
    const VALUE = 1;

    /**
     * Helper to extract secrets and keys from the file listed above. Keys are
     * named similar to an .env file, except these keys do not change with the
     * environment and as a result do not go in the .env file
     *
     * @param $key - Key name
     * @return string|null - Value for key
     */
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
