<?php
define('DS', DIRECTORY_SEPARATOR);
define('SYS_ROOT', __DIR__ . DS);
define('SYS_PARENT_ROOT', dirname(__DIR__) . DS);

require SYS_PARENT_ROOT . 'vendor/autoload.php';
require SYS_ROOT . 'config.inc.php';

$app = new \APLite\Bootstrap\ProcessBootstrap();
$app->setTimezone('Asia/Shanghai')
    ->setErrorReporting(E_ALL & ~E_NOTICE)
    ->setControllerNs('Application\Process')
    ->setRouteParser(new \APLite\Router\CliOptionParser($app))
    ->setLoggerConfiguration(SYS_ROOT . 'log4php.xml')
    ->dispatch($cfgs, $argv);