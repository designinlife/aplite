<?php
namespace APLite\Interfaces;

use APLite\Logger\Logger;

/**
 * Memcached/Redis 缓存对象接口声明。
 *
 * @package       APLite\Interfaces
 * @author        Lei Lee <web.developer.network@gmail.com>
 * @version       1.0.0
 * @copyright (c) 2013-2016, Lei Lee
 */
interface ICache {
    /**
     * 构造函数。
     *
     * @param string $host
     * @param int    $port
     * @param string $passwd
     * @param Logger $logger
     */
    function __construct($host, $port, $passwd, Logger $logger = NULL);

    /**
     * 连接缓存服务器。
     */
    function connect();

    /**
     * 断开连接。
     */
    function close();

    /**
     * 登录验证。
     *
     * @return bool
     */
    function auth();

    /**
     * 切换缓存数据库。
     *
     * @param int $db_index
     * @return bool
     */
    function select($db_index = 0);

    /**
     * 设置服务器选项参数。
     *
     * @param string     $key
     * @param int|string $value
     */
    function setOption($key, $value);

    /**
     * 获取服务器选项参数。
     *
     * @param string $key
     * @return int|string
     */
    function getOption($key);

    /**
     * 获取服务器信息列表。
     *
     * @return array
     */
    function info();

    /**
     * 清空缓存数据库。
     *
     * @return bool
     */
    function flushDb();

    /**
     * 清空缓存数据库。
     *
     * @return bool
     */
    function flushAll();

    /**
     * 设置缓存数据过期时间。
     *
     * @param string $key 指定缓存键名。
     * @param int    $ttl 指定过期时间。(单位: 秒)
     * @return bool
     */
    function expire($key, $ttl);

    /**
     * 设置缓存数据过期时间。
     *
     * @param string $key       指定缓存键名。
     * @param int    $expire_ts 指定过期的时间戳。
     * @return bool
     */
    function expireAt($key, $expire_ts);

    /**
     * 设置缓存数据。
     *
     * @param string $key   指定缓存键名。
     * @param mixed  $value 指定数据值对象。
     * @param int    $ttl   指定过期时间。(单位: 秒 | 默认值: 0,永不过期)
     * @return bool
     */
    function set($key, $value, $ttl = 0);

    /**
     * 获取缓存数据。
     *
     * @param string $key 指定缓存键名。
     * @return mixed
     */
    function get($key);

    /**
     * 删除缓存。
     *
     * @param string $key 指定缓存键名。
     * @return bool
     */
    function del($key);

    /**
     * 检查缓存键是否存在？
     *
     * @param string $key 指定缓存键名。
     * @return bool
     */
    function exists($key);

    /**
     * 指示是否 Redis 缓存？
     *
     * @return bool
     */
    function isRedis();

    /**
     * 指示是否 Memcached 缓存？
     *
     * @return bool
     */
    function isMemcached();
}