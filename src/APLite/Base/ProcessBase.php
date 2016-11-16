<?php
namespace APLite\Base;

use APLite\Interfaces\IProcess;
use GetOptionKit\Option;
use GetOptionKit\OptionParser;
use GetOptionKit\OptionPrinter\ConsoleOptionPrinter;
use GetOptionKit\OptionResult;

/**
 * 抽象命令行进程基类。
 *
 * @package       APLite\Base
 * @author        Lei Lee <web.developer.network@gmail.com>
 * @version       1.0.0
 * @copyright (c) 2013-2016, Lei Lee
 */
abstract class ProcessBase implements IProcess {
    /**
     * @var OptionResult
     */
    private $optionResult = NULL;

    /**
     * 控制器初始化事件。
     */
    function initialize() {
    }

    /**
     * 释放资源。
     */
    function dispose() {
    }

    /**
     * 获取命令行参数选项列表。
     *
     * @return \GetOptionKit\OptionCollection|null
     */
    function getOptions() {
        return NULL;
    }

    /**
     * 获取参数选项。
     *
     * @param string|int $key
     * @return Option
     */
    protected function opt($key) {
        return $this->optionResult[$key];
    }

    /**
     * 解析参数选项。
     *
     * @param array $argv
     */
    final function parse(array $argv = NULL) {
        $options = $this->getOptions();

        if ($options) {
            $parser = new OptionParser($options);

            $this->optionResult = $parser->parse($argv);

            if (isset($r['help']) && $r['help']->value === true) {
                $printer = new ConsoleOptionPrinter();
                echo $printer->render($options);
                exit(2);
            }
        }
    }
}