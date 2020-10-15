<?php

namespace App;
use Log;
class WebUtils {

    const LOCAL_HOSTS = [
       'localhost',
        '127.0.0.1'
    ];
    const VIRTUAL_HOSTS = [
        'nick.oviattassistant.com',
        'tyler.oviattassistant.com',
        'arteen.oviattassistant.com',
    ];
    const DEV_HOST = [
        'dev.oviattassistant.com',
    ];
    const PROD_HOST = [
        'https://oviattassistant.com',
    ];

    public static function is_prod() {
        return self::check_host(self::LOCAL_HOSTS);
    }

    public static function is_local() {
        return self::check_host(self::LOCAL_HOSTS);
    }

    public static function is_dev() {
        return self::check_host(self::DEV_HOST);
    }

    public static function is_vhost() {
        return self::check_host(self::VIRTUAL_HOSTS);
    }

    private static function check_host($hosts) {
        foreach ($hosts as $host) {
            Log::debug("Checking host " . $host . " against server " . $_SERVER['SERVER_NAME']);
            if (strpos($_SERVER['SERVER_NAME'], $host) !== false) {
                return true;
            }
        }
        return false;
    }
}
