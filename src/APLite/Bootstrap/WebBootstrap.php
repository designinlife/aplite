<?php
namespace APLite\Bootstrap;

use APLite\Interfaces\ITemplate;

/**
 * 基于 Web 网页开发的 Bootstrap 对象。
 *
 * @package       APLite\Bootstrap
 * @author        Lei Lee <web.developer.network@gmail.com>
 * @version       1.0.0
 * @copyright (c) 2013-2016, Lei Lee
 */
class WebBootstrap extends AbstractBootstrap {
    /**
     * ITemplate 模板管理对象实例。
     *
     * @var ITemplate
     */
    protected $template = NULL;

    /**
     * 模板目录。
     *
     * @var string
     */
    protected $template_directory = '';

    /**
     * 模板编译缓存目录。
     *
     * @var string
     */
    protected $template_cache_directory = '';

    /**
     * 是否自动重载模板？
     *
     * @var bool
     */
    protected $template_auto_reload = true;

    /**
     * 初始化事件。
     */
    function initialize() {
        // TODO: Implement initialize() method.
    }

    /**
     * 初始化完成事件。
     */
    function initializeComplete() {
        // TODO: Implement initializeComplete() method.
    }

    /**
     * 获取模板管理对象。
     *
     * @return ITemplate
     */
    function getTemplate() {
        return $this->template;
    }

    /**
     * 设置模板管理对象。
     *
     * @param ITemplate $template
     * @return WebBootstrap
     */
    function setTemplate($template) {
        $this->template = $template;

        return $this;
    }

    /**
     * 获取模板目录。
     *
     * @return string
     */
    function getTemplateDirectory() {
        return $this->template_directory;
    }

    /**
     * 设置模板目录。
     *
     * @param string $template_directory
     * @return WebBootstrap
     */
    function setTemplateDirectory($template_directory) {
        $this->template_directory = $template_directory;

        return $this;
    }

    /**
     * 获取模板编译缓存目录。
     *
     * @return string
     */
    function getTemplateCacheDirectory() {
        return $this->template_cache_directory;
    }

    /**
     * 设置模板编译缓存目录。
     *
     * @param string $template_cache_directory
     * @return WebBootstrap
     */
    function setTemplateCacheDirectory($template_cache_directory) {
        $this->template_cache_directory = $template_cache_directory;

        return $this;
    }

    /**
     * 指示模板是否自动重载？
     *
     * @return boolean
     */
    function isTemplateAutoReload() {
        return $this->template_auto_reload;
    }

    /**
     * 指示模板是否自动重载？
     *
     * @param boolean $template_auto_reload
     * @return WebBootstrap
     */
    function setTemplateAutoReload($template_auto_reload) {
        $this->template_auto_reload = $template_auto_reload;

        return $this;
    }
}