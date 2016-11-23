<?php
namespace APLite;

/**
 * AP 常量配置类。
 *
 * @package       APLite
 * @author        Lei Lee <web.developer.network@gmail.com>
 * @version       1.0.0
 * @copyright (c) 2013-2016, Lei Lee
 */
class AP {
    const ROUTE_CONTINUE = 1;
    const ROUTE_END      = 2;

    # 适用于 IDb 接口的常量定义
    # -----------------------------------------------------
    const SQL_TYPE_INSERT    = 1;
    const SQL_TYPE_UPDATE    = 2;
    const SQL_TYPE_DELETE    = 3;
    const SQL_TYPE_FETCH     = 11;
    const SQL_TYPE_FETCH_ALL = 12;
    const SQL_TYPE_SCALAR    = 13;
    const QUERY_RESULT_SINGLE = 1;
    const QUERY_RESULT_MULTI  = 2;
    const QUERY_RESULT_SCALAR = 3;

    # 适用于 Enc 的常量定义
    # -----------------------------------------------------
    const ENC_NONE     = 0;
    const ENC_DEFAULTS = 2;
    const ENC_JSON     = 1;
    const ENC_MSGPACK  = 2;
    const ENC_IGBINARY = 3;
}