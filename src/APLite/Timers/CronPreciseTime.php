<?php
namespace APLite\Timers;

use APLite\Bootstrap\ProcessBootstrap;
use APLite\Exceptions\ArgumentException;

/**
 * 基于 EvPeriodic 的精准时间点单次执行定时器。
 *
 * @package       APLite\Timers
 * @author        Lei Lee <web.developer.network@gmail.com>
 * @version       1.0.0
 * @copyright (c) 2013-2016, Lei Lee
 */
class CronPreciseTime extends \EvPeriodic {
    /**
     * ProcessBootstrap 上下文实例。
     *
     * @var ProcessBootstrap
     */
    protected $bootstrap = NULL;

    /**
     * 执行时间。
     *
     * @var int
     */
    protected $execute_time = NULL;

    /**
     * 时间偏移值。
     *
     * @var int
     */
    private $offset_sec = 0;

    /**
     * 自定义数据参数。
     *
     * @var mixed
     */
    private $args = NULL;

    /**
     * 回调函数引用。
     *
     * @var callable
     */
    private $callback = NULL;

    /**
     * 构造函数。
     *
     * @param ProcessBootstrap $bootstrap    指定 ProcessBootstrap 上下文实例。
     * @param int|string       $execute_time 指定任务执行的时间。
     * @param callable         $callback     指定回调函数。
     * @param mixed            $args         自定义数据参数。
     * @param int              $offset_sec   时间偏移值。(秒)
     * @throws ArgumentException
     */
    function __construct(ProcessBootstrap $bootstrap, $execute_time, $callback, $args = NULL, $offset_sec = 0) {
        $this->bootstrap = $bootstrap;

        if (is_int($execute_time))
            $this->execute_time = $execute_time;
        elseif (is_string($execute_time))
            $this->execute_time = strtotime($execute_time);
        else
            throw new ArgumentException('参数类型不支持。(' . gettype($execute_time) . ')');

        $this->offset_sec = $offset_sec;
        $this->args       = $args;
        $this->callback   = $callback;

        parent::__construct(0, 0, [$this, 'doRescheduleHandler'], [$this, 'doBackhandler'], NULL, 0);
    }

    /**
     * 析构函数。
     */
    function __destruct() {
        unset($this->bootstrap, $this->callback);
    }

    /**
     * 回调函数。
     *
     * @param \EvWatcher $w
     */
    function doBackhandler($w) {
        try {
            call_user_func_array($this->callback, [$w, $this->args]);
        } catch (\Exception $ex) {
            $this->bootstrap->getLogger()->error($ex->getMessage(), $ex);
        }

        $w->stop();
    }

    /**
     * 重新计划事件回调。
     *
     * @param \EvWatcher $w
     * @param float      $now
     * @return float
     */
    function doRescheduleHandler($w, $now) {
        $cts = time();

        if ($cts >= $this->execute_time) {
            $s = $now + 315360000;

            $this->bootstrap->getLogger()->trace('[CronPreciseTime][Reschedule] 设定的时间已过期, 定时器停止工作! | TS: ' . date('Y-m-d H:i:s', $s));

            return $s;
        } else {
            $s = $now + ($this->execute_time - $cts) + $this->offset_sec;

            $this->bootstrap->getLogger()->trace('[CronPreciseTime][Reschedule] TS: ' . date('Y-m-d H:i:s', $s));

            return $s;
        }
    }
}