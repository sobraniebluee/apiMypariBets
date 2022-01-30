<?php


class Database
{
    private static $host;
    private static $dbname;
    private static $user;
    private static $passwd;
    public static $db;

    public static function enabled($host, $dbname, $user, $passwd, $charset)
    {
        self::$host = $host;
        self::$dbname = $dbname;
        self::$user = $user;
        self::$passwd = $passwd;
        self::$db = new PDO('mysql:dbname=' . self::$dbname . ';host=' . self::$host,
                self::$user,
            self::$passwd
        );
    }

    public static function disabled()
    {
        self::$db = null;
    }
}
