<?php
namespace APLite\Router;

use APLite\Base\AbstractWebBase;
use APLite\Interfaces\IRouteParser;
use APLite\Utility\Util;

/**
 * Class UriParser
 *
 * @package       APLite\Router
 * @author        Lei Lee <web.developer.network@gmail.com>
 * @version       1.0.0
 * @copyright (c) 2013-2016, Lei Lee
 */
class UriParser extends AbstractWebBase implements IRouteParser {
    /**
     * 解析路由。
     *
     * @return RouteResponse
     */
    function parse() {
        $uri = $_SERVER['REQUEST_URI'];

        $uris    = explode('/', $uri);
        $uri_len = count($uris);

        $c = 'Index';
        $m = 'defaults';

        if ($uri_len >= 1)
            $c = Util::toCamelCase($uris[0], true);
        if ($uri_len >= 2)
            $m = Util::toCamelCase($uris[1]);

        return new RouteResponse($c, $m, NULL);
    }
}