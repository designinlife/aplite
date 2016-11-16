# APlite
An simple abstract-based framework.

# Required
PHP >= 5.6.x  
apache/log4php: 2.3  
twig/twig: 1.2.x

# Composer
{
    "require": {
        "designinlife/aplite": "~1.0"
    }
}

# Usage
```php
<?php
define('DS', DIRECTORY_SEPARATOR);
define('SYS_ROOT', __DIR__ . DS);
define('SYS_PARENT_ROOT', dirname(__DIR__) . DS);

require SYS_PARENT_ROOT . 'vendor/autoload.php';
require SYS_ROOT . 'config.inc.php';

$app = new \APLite\Bootstrap\WebBootstrap();
$app->setTemplateAutoReload(true)
    ->setTemplateDirectory(SYS_ROOT . 'tpl')
    ->setTemplateCacheDirectory(SYS_ROOT . 'tpl_c')
    ->setTemplate(new \APLite\Web\TwigTemplate($app))
    ->setTimezone('Asia/Shanghai')
    ->setErrorReporting(E_ALL & ~E_NOTICE)
    ->setControllerNs('Application\Controller')
    ->setRouteParser(new \APLite\Router\CommandParser($app, SYS_ROOT . 'cmd.inc.php'))
    ->setLoggerConfiguration(SYS_ROOT . 'log4php.xml')
    ->dispatch($cfgs, $argv);
```
