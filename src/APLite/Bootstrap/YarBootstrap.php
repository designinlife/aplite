<?php
namespace APLite\Bootstrap;

/**
 * 基于 Yar-RPC 服务的 YarBootstrap 对象。
 *
 * @package       APLite\Bootstrap
 * @author        Lei Lee <web.developer.network@gmail.com>
 * @version       1.0.0
 * @copyright (c) 2013-2016, Lei Lee
 */
class YarBootstrap extends AbstractBootstrap {
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
     * 执行控制器行为。
     */
    protected function execute() {
        $cls_n = $this->controller_ns . '\\' . $this->route_response->getController();
        $cls_o = new $cls_n($this);

        $service = new \Yar_Server($cls_o);
        $service->handle();
    }
}