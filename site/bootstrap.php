<?php


require_once(__DIR__ . '/vendor/autoload.php');

new iRAP\Autoloader\Autoloader([
    __DIR__,
    __DIR__ . '/models',
    __DIR__ . '/views',
    __DIR__ . '/controllers',
    __DIR__ . '/libs',
]);

$dotenv = new Symfony\Component\Dotenv\Dotenv();
$dotenv->overload('/.env');

$requiredEnvVars = array(
    'DB_HOST',
    'DB_NAME',
    'DB_USER',
    'DB_PASSWORD',
);

foreach ($requiredEnvVars as $requiredEnvVar)
{
    if (!isset($_ENV[$requiredEnvVar]))
    {
        throw new Exception("Missing required environment variable: {$requiredEnvVar}");
    }
}

define('DB_HOST', $_ENV['DB_HOST']);
define('DB_NAME', $_ENV['DB_NAME']);
define('DB_USER', $_ENV['DB_USER']);
define('DB_PASSWORD', $_ENV['DB_PASSWORD']);