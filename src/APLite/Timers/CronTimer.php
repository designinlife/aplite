<?php
namespace APLite\Timers;

use APLite\Bootstrap\ProcessBootstrap;

/**
 * CronTimer - 定时器对象。
 *
 * @package       APLite\Timers
 * @author        Lei Lee <web.developer.network@gmail.com>
 * @version       1.0.0
 * @copyright (c) 2013-2016, Lei Lee
 */
class CronTimer extends \EvTimer {
    /**
     * ProcessBootstrap 上下文实例。
     *
     * @var ProcessBootstrap
     */
    protected $bootstrap = NULL;

    /**
     * 构造函数。
     *
     * @param ProcessBootstrap $bootstrap 指定 ProcessBootstrap 上下文实例。
     * @param double           $after
     * @param double           $repeat
     * @param callable         $callback
     * @param mixed            $data
     * @param int              $priority
     */
    function __construct(ProcessBootstrap $bootstrap, $after, $repeat, callable $callback, $data = NULL, $priority = 0) {
        $this->bootstrap = $bootstrap;

        parent::__construct($after, $repeat, $callback, $data, $priority);
    }

    /**
     * 析构函数。
     */
    function __destruct() {
        unset($this->bootstrap);
    }
}