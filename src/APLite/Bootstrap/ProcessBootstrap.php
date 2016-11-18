<?php
namespace APLite\Bootstrap;

/**
 * 基于命令行脚本开发的 Bootstrap 对象。
 *
 * @package       APLite\Bootstrap
 * @author        Lei Lee <web.developer.network@gmail.com>
 * @version       1.0.0
 * @copyright (c) 2013-2016, Lei Lee
 */
class ProcessBootstrap extends AbstractBootstrap {
    /**
     * 进程别名前缀。
     *
     * @var string
     */
    protected $alias_prefix = '';

    /**
     * 初始化事件。
     */
    function initialize() { }

    /**
     * 初始化完成事件。
     */
    function initializeComplete() { }

    /**
     * 获取进程别名前缀。
     *
     * @return string
     */
    function getAliasPrefix() {
        return $this->alias_prefix;
    }

    /**
     * 设置进程别名前缀。
     *
     * @param string $alias_prefix
     * @return ProcessBootstrap
     */
    function setAliasPrefix($alias_prefix) {
        $this->alias_prefix = $alias_prefix;

        return $this;
    }
}