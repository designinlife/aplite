<?php
namespace APLite\Base;

use APLite\Interfaces\IProcess;
use GetOptionKit\OptionParser;
use GetOptionKit\OptionPrinter\ConsoleOptionPrinter;

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
     * 解析参数选项。
     *
     * @param array $argv
     * @return \GetOptionKit\Option[]|\GetOptionKit\OptionResult|null
     * @throws \Exception
     */
    final function parse(array $argv = NULL) {
        $options = $this->getOptions();

        if ($options) {
            $parser = new OptionParser($options);

            $r = $parser->parse($argv);

            if (isset($r['help']) && $r['help']->value === true) {
                $printer = new ConsoleOptionPrinter();
                echo $printer->render($options);
                exit(2);
            }

            return $r;
        }

        return NULL;
    }
}