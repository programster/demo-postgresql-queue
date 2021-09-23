<?php


class SiteSpecific
{
    public static function getDb() : \Programster\PgsqlObjects\PgSqlConnection
    {
        static $db = null;

        if ($db === null)
        {
           // die("HOST: "  . DB_HOST . PHP_EOL);
            $db = \Programster\PgsqlObjects\PgSqlConnection::create(
                DB_HOST,
                DB_NAME,
                DB_USER,
                DB_PASSWORD
            );
        }

        return $db;
    }
}

