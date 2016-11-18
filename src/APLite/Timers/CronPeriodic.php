<?php
namespace APLite\Timers;

use APLite\Bootstrap\ProcessBootstrap;
use Cron\CronExpression;

/**
 * CronPeriodic - 定时器类。
 *
 * @package       APLite\Timers
 * @author        Lei Lee <web.developer.network@gmail.com>
 * @version       1.0.0
 * @copyright (c) 2013-2016, Lei Lee
 */
class CronPeriodic extends \EvPeriodic {
    /**
     * ProcessBootstrap 上下文实例。
     *
     * @var ProcessBootstrap
     */
    protected $bootstrap = NULL;

    /**
     * CronExpression 表达式解析对象。
     *
     * @var CronExpression
     */
    private $cron = NULL;

    /**
     * 时间偏移值。
     *
     * @var int
     */
    private $offset_sec = 0;

    /**
     * 构造函数。
     *
     * @param ProcessBootstrap $bootstrap       指定 ProcessBootstrap 上下文实例。
     * @param string           $cron_expression 指定事件 Cron 表达式。
     * @param callable         $callback        指定回调函数。
     * @param int              $offset_sec      时间偏移值。(秒)
     * @param mixed            $data            自定义数据对象。
     */
    function __construct(ProcessBootstrap $bootstrap, $cron_expression, callable $callback, $offset_sec = 0, $data = NULL) {
        $this->bootstrap = $bootstrap;
        $this->cron      = CronExpression::factory($cron_expression);

        $this->offset_sec = $offset_sec;

        parent::__construct(0, 0, [$this, 'doRescheduleHandler'], $callback, $data, 0);
    }

    /**
     * 析构函数。
     */
    function __destruct() {
        unset($this->bootstrap);
    }

    /**
     * 重新计划事件回调。
     *
     * @param \EvWatcher $w
     * @param float      $now
     * @return float
     */
    function doRescheduleHandler($w, $now) {
        $s = $now + ($this->cron->getNextRunDate()->getTimestamp() - time()) + $this->offset_sec;

        // $this->bootstrap->log->debug('[CronPeriodic] Next DateTime: ' . date('Y-m-d H:i:s', $s));

        return $s;
    }
}