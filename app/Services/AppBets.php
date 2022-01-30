<?php
namespace AppBets\Services;

class AppBets
{
    public static function run()
    {
        self::db();
        self::headers();
        self::assets();
    }
    private static function db()
    {
        $configDB = require_once 'config/db.php';

        if ($configDB['enable'] == true) {
            \Database::enabled($configDB['host'],$configDB['dbname'],$configDB['user'],$configDB['password'],$configDB['charset']);
        } else {
            echo 'Database is disabled!';
        }
    }
    private static function assets()
    {
        require_once 'config/assets.php';
    }
    private static function headers ()
    {
        $headersConfig = require_once 'config/headers.php';

        header('Access-Control-Allow-Origin:' . $headersConfig['host']);
        header('Access-Control-Allow-Credentials:' . $headersConfig['withCredentials']);
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type');
    }
}