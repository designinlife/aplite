<?php
namespace APLite\Base;

/**
 * 多进程基类。
 *
 * @package       APLite\Base
 * @author        Lei Lee <web.developer.network@gmail.com>
 * @version       1.0.0
 * @copyright (c) 2013-2016, Lei Lee
 */
abstract class MultiProcessBase extends ProcessBase {
    /**
     * 工作进程数量。
     *
     * @var int
     */
    protected $worker_num = 2;

    /**
     * 子进程实例列表。
     *
     * @var \Swoole\Process[]
     */
    protected $workers = [];

    /**
     * 执行命令。
     */
    final function run() {
        $this->configure();

        for ($i = 0; $i < $this->worker_num; $i++) {
            $this->workers[$i] = new \Swoole\Process([$this, 'subprocess']);
            $this->workers[$i]->start();
        }
    }

    /**
     * 配置进程参数。
     */
    abstract function configure();

    /**
     * 启动子进程。
     */
    abstract function subprocess();
}