<?php
namespace APLite\Logger;

use LoggerConfigurator;

/**
 * Apache Logger Proxy.
 *
 * @package       APLite\Logger
 * @author        Lei Lee <web.developer.network@gmail.com>
 * @version       1.0.0
 * @copyright (c) 2013-2016, Lei Lee
 */
class Logger {
    /**
     * Configures log4php.
     *
     * This method needs to be called before the first logging event has
     * occured. If this method is not called before then the default
     * configuration will be used.
     *
     * @param string|array              $configuration Either a path to the configuration
     *                                                 file, or a configuration array.
     *
     * @param string|LoggerConfigurator $configurator  A custom
     *                                                 configurator class: either a class name (string), or an object which
     *                                                 implements the LoggerConfigurator interface. If left empty, the default
     *                                                 configurator implementation will be used.
     */
    static function configure($configuration = NULL, $configurator = NULL) {
        \Logger::configure($configuration, $configurator);
    }

    /**
     * Returns a Logger by name. If it does not exist, it will be created.
     *
     * @param string $name The logger name
     * @return \Logger
     */
    static function getLogger($name) {
        return \Logger::getLogger(str_replace(['\\'], ['.'], $name));
    }
}