<?php
namespace APLite\Web;

use APLite\Base\AbstractWebBase;
use APLite\Bootstrap\WebBootstrap;
use APLite\Interfaces\ITemplate;

/**
 * Twig 模板代理对象。
 *
 * @package       APLite\Web
 * @author        Lei Lee <web.developer.network@gmail.com>
 * @version       1.0.0
 * @copyright (c) 2013-2016, Lei Lee
 */
class TwigTemplate extends AbstractWebBase implements ITemplate {
    /**
     * Twig 实例。
     *
     * @var \Twig_Environment
     */
    private $twig;

    /**
     * 数据集合。
     *
     * @var array
     */
    private $data = [];

    /**
     * 构造函数。
     *
     * @param WebBootstrap $bootstrap 指定 WebBootstrap 上下文实例。
     */
    function __construct(WebBootstrap $bootstrap) {
        parent::__construct($bootstrap);

        $opts = array(
            'auto_reload' => $bootstrap->isTemplateAutoReload(),
            'autoescape'  => false,
            'cache'       => $bootstrap->getTemplateCacheDirectory(),
        );

        $loader     = new \Twig_Loader_Filesystem($bootstrap->getTemplateDirectory());
        $this->twig = new \Twig_Environment($loader, $opts);
    }

    /**
     * 模板变量赋值。
     *
     * @param string $key
     * @param mixed  $value
     * @return ITemplate
     */
    function assign($key, $value) {
        $this->data[$key] = $value;

        return $this;
    }

    /**
     * 输出模板内容。
     *
     * @param string $tpl_file 模板文件名称。
     * @return void
     */
    function display($tpl_file) {
        $this->data['envs'] = &$_SERVER;
        $this->data['gets'] = &$_GET;

        $this->twig->display($tpl_file, $this->data);
    }

    /**
     * 模板渲染。
     *
     * @param string $name
     * @param array  $context
     * @return mixed
     */
    function render($name, array $context = []) {
        $this->twig->render($name, $context);
    }

    /**
     * 添加扩展。
     *
     * @param \Twig_Extension $extension
     */
    function addExtension(\Twig_Extension $extension) {
        $this->twig->addExtension($extension);
    }
}