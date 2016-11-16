<?php
namespace APLite\Web;

use APLite\Base\AbstractWebBase;
use APLite\Interfaces\IController;
use APLite\Interfaces\ITemplate;

/**
 * 基于 Web 开发的控制器基类。
 *
 * @package       APLite\Web
 * @author        Lei Lee <web.developer.network@gmail.com>
 * @version       1.0.0
 * @copyright (c) 2013-2016, Lei Lee
 */
class WebControllerBase extends AbstractWebBase implements IController {
    /**
     * ITemplate 对象引用。
     *
     * @var ITemplate
     */
    protected $template = NULL;

    /**
     * 析构函数。
     */
    function __destruct() {
        parent::__destruct();

        unset($this->template);
    }

    /**
     * 控制器初始化事件。
     */
    function initialize() {
        $this->template = $this->bootstrap->getTemplate();
    }

    /**
     * 释放资源。
     */
    function dispose() {
    }

    /**
     * 模板变量赋值。
     *
     * @param string $key
     * @param mixed  $value
     * @return ITemplate
     */
    function assign($key, $value) {
        $this->template->assign($key, $value);

        return $this->template;
    }

    /**
     * 输出模板内容。
     *
     * @param string $tpl_file 模板文件名称。
     * @return void
     */
    function display($tpl_file) {
        $this->template->display($tpl_file);
    }
}