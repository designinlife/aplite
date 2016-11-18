<?php
namespace APLite\Base;

use APLite\Timers\CronPeriodic;
use APLite\Timers\CronPreciseTime;
use APLite\Timers\CronTimer;

/**
 * 基于 Ev 定时器组件的进程基类。
 *
 * @package       APLite\Base
 * @author        Lei Lee <web.developer.network@gmail.com>
 * @version       1.0.0
 * @copyright (c) 2013-2016, Lei Lee
 */
abstract class TimerProcessBase extends ProcessBase {
    /**
     * Ev 定时器实例列表。
     *
     * @var array
     */
    protected $timers = [];

    /**
     * 执行命令。
     */
    final function run() {
        $this->configure();

        \Ev::run();
    }

    /**
     * 配置定时器。
     */
    abstract function configure();

    /**
     * 添加 EvTimer 定时器。
     *
     * @param float     $repeat   指定事件轮询周期。(单位: 秒)
     * @param callable  $callback 指定事件回调函数。
     * @param mixed     $data     自定义数据对象。(可选)
     * @param float|int $after    延迟启动。
     * @return TimerProcessBase
     */
    final function addTimer($repeat, callable $callback, $data = NULL, $after = 0) {
        $cts = time();

        if ($repeat > 60 && $after == 0)
            $after = 60 - ($cts % 60);

        $this->timers[] = new CronTimer($this->bootstrap, $after, $repeat, $callback, $data);

        return $this;
    }

    /**
     * 添加 EvPeriodic 定时器。
     *
     * @param string   $cron_expression 指定事件轮询的 Crontab 表达式。
     * @param callable $callback        指定事件回调函数。
     * @param int      $offset_sec      事件触发时间偏移值。(秒)
     * @param mixed    $data            自定义数据对象。(可选)
     * @return TimerProcessBase
     */
    final function addPeriodic($cron_expression, callable $callback, $offset_sec = 0, $data = NULL) {
        $this->timers[] = new CronPeriodic($this->bootstrap, $cron_expression, $callback, $offset_sec, $data);

        return $this;
    }

    /**
     * 添加精准时间点单次执行定时器。
     *
     * @param int|string $execute_time 指定任务执行的时间。
     * @param callable   $callback     指定回调函数。
     * @param mixed      $args         自定义数据参数。
     * @param int        $offset_sec   时间偏移值。(秒)
     * @return TimerProcessBase
     */
    final function addPreciseTime($execute_time, callable $callback, $args = NULL, $offset_sec = 0) {
        $this->timers[] = new CronPreciseTime($this->bootstrap, $execute_time, $callback, $args, $offset_sec);

        return $this;
    }
}