<?php
namespace APLite\Queue;

use APLite\Bootstrap\AbstractBootstrap;

/**
 * 消息队列静态管理类。
 *
 * @package       APLite\Queue
 * @author        Lei Lee <web.developer.network@gmail.com>
 * @version       1.0.0
 * @copyright (c) 2013-2016, Lei Lee
 */
class SQ {
    /**
     * AbstractBootstrap 上下文实例。
     *
     * @var AbstractBootstrap
     */
    static private $bootstrap = NULL;

    /**
     * 初始化对象。
     *
     * @param AbstractBootstrap $bootstrap
     */
    static function initialize(AbstractBootstrap $bootstrap) {
        self::$bootstrap = $bootstrap;
    }

    /**
     * 投递消息。
     *
     * @param string $tube
     * @param string $msg
     * @param int    $delay
     */
    static function send($tube, $msg, $delay = 0) {
        self::$bootstrap->sqs->putInTube($tube, $msg, 1024, $delay, 60);
    }
}