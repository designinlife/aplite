<?php
namespace APLite\DB;

/**
 * IDb 连接参数对象。
 *
 * @package       APLite\DB
 * @author        Lei Lee <web.developer.network@gmail.com>
 * @version       1.0.0
 * @copyright (c) 2013-2016, Lei Lee
 */
class DbParameter {
    private $host = '';

    private $port = 3306;

    private $user = 'root';

    private $password = '';

    private $db = '';

    private $charset = 'utf8';

    private $sock = '';

    private $init_command = '';

    /**
     * DbParameter constructor.
     *
     * @param string $host
     * @param int    $port
     * @param string $user
     * @param string $password
     * @param string $db
     * @param string $charset
     * @param string $sock
     * @param string $init_command
     */
    function __construct($host, $port, $user, $password, $db, $charset = 'utf8', $sock = NULL, $init_command = NULL) {
        $this->host         = $host;
        $this->port         = $port;
        $this->user         = $user;
        $this->password     = $password;
        $this->db           = $db;
        $this->charset      = $charset;
        $this->sock         = $sock;
        $this->init_command = $init_command;
    }

    /**
     * 是否采用 UNIX-Sock 连接？
     *
     * @return bool
     */
    function hasSock() {
        return !empty($this->sock);
    }

    /**
     * 是否执行初始化指令？
     *
     * @return bool
     */
    function hasInitCommand() {
        return !empty($this->init_command);
    }

    /**
     * 获取主机地址。
     *
     * @return string
     */
    function getHost() {
        return $this->host;
    }

    /**
     * 获取连接端口。
     *
     * @return int
     */
    function getPort() {
        return $this->port;
    }

    /**
     * 获取登录帐号。
     *
     * @return string
     */
    function getUser() {
        return $this->user;
    }

    /**
     * 获取登录密码。
     *
     * @return string
     */
    function getPassword() {
        return $this->password;
    }

    /**
     * 获取数据库名称。
     *
     * @return string
     */
    function getDb() {
        return $this->db;
    }

    /**
     * 获取字符集。
     *
     * @return string
     */
    function getCharset() {
        return $this->charset;
    }

    /**
     * 获取 UNIX-Sock 文件路径。
     *
     * @return null|string
     */
    function getSock() {
        return $this->sock;
    }

    /**
     * 获取初始命令。
     *
     * @return null|string
     */
    function getInitCommand() {
        return $this->init_command;
    }
}