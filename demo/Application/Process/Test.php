<?php
namespace Application\Process;

use APLite\Base\ProcessBase;
use GetOptionKit\OptionCollection;

/**
 * Class Test
 *
 * @package       Application\Process
 * @author        Lei Lee <web.developer.network@gmail.com>
 * @version       1.0.0
 * @copyright (c) 2013-2016, Lei Lee
 */
class Test extends ProcessBase {
    /**
     * 获取命令行参数选项列表。
     *
     * @return \GetOptionKit\OptionCollection|null
     */
    function getOptions() {
        $options = new OptionCollection();
        $options->add('i|id:=number', '进程序号');
        $options->add('n|num:=number', '开启的子进程数量');
        $options->add('h|help', '显示帮助信息');

        return $options;
    }

    /**
     * 执行命令。
     */
    function run() {
        var_dump($this->opt('num')->value);
    }
}