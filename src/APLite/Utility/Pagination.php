<?php
namespace APLite\Utility;

use APLite\Base\DataSerializable;
use APLite\Exceptions\ArgumentException;
use APLite\Interfaces\IDb;
use APLite\Interfaces\IPageStyle;

/**
 * 数据库分页查询工具类。
 *
 * @package       APLite\Utility
 * @author        Lei Lee <web.developer.network@gmail.com>
 * @version       1.0.0
 * @copyright (c) 2013-2016, Lei Lee
 */
class Pagination extends DataSerializable {
    /**
     * @var IDb
     */
    private $dbo = NULL;

    protected $page_html = '';

    /**
     * IPageStyle 对象。
     *
     * @var IPageStyle
     */
    protected $page_style = NULL;

    protected $page_name = 'page';

    protected $page_size = 10;

    protected $record_count = 0;

    protected $current_page = 1;

    protected $page_count = 1;

    protected $start_index = 0;

    protected $scalar_query = NULL;

    protected $list_query = NULL;

    /**
     * @var array|null
     */
    protected $data_set = NULL;

    /**
     * 构造函数。
     *
     * @param IDb    $dbo
     * @param string $page_name
     * @param int    $page_size
     */
    function __construct(IDb $dbo, $page_name = 'page', $page_size = 10) {
        $this->dbo       = $dbo;
        $this->page_name = $page_name;
        $this->page_size = $page_size;
    }

    /**
     * 析构函数。
     */
    function __destruct() {
        unset($this->dbo);
    }

    /**
     * 设置分页样式管理器。
     *
     * @param IPageStyle $page_style
     * @return Pagination
     */
    function setPageStyle($page_style) {
        $this->page_style = $page_style;

        return $this;
    }

    /**
     * 设置 Scalar 查询 SQL 语句。
     *
     * @param array $scalar_query
     * @return Pagination
     */
    function setScalarQuery(array $scalar_query) {
        $this->scalar_query = $scalar_query;

        return $this;
    }

    /**
     * 设置列表查询 SQL 语句。
     *
     * @param array $list_query
     * @return Pagination
     */
    function setListQuery(array $list_query) {
        $this->list_query = $list_query;

        return $this;
    }

    /**
     * 执行分页查询。
     *
     * @return string 返回分页 HTML 代码。
     * @throws ArgumentException
     */
    function exec() {
        if (!$this->page_style)
            throw new ArgumentException('未设置 IPageStyle 分页样式管理器。');

        $this->current_page = ( int ) $_GET[$this->page_name];

        if ($this->current_page < 1)
            $this->current_page = 1;

        $this->start_index = ($this->current_page - 1) * $this->page_size;

        $count = ( int ) $this->dbo->scalar($this->scalar_query[0], isset($this->scalar_query[1]) ? $this->scalar_query[1] : NULL);

        $this->record_count = $count;
        $this->page_count   = ( int ) ceil($this->record_count / $this->page_size);

        if ($this->page_count < 1)
            $this->page_count = 1;

        if ($this->current_page > $this->page_count)
            $this->current_page = $this->page_count;

        $this->data_set = $this->dbo->fetchAll($this->list_query[0] . ' LIMIT ' . $this->start_index . ',' . $this->page_size, isset($this->list_query[1]) ? $this->list_query[1] : NULL);

        return $this->page_style->setPagination($this)
                                ->apply();
    }

    /**
     * 获取分页变量名称。
     *
     * @return string
     */
    function getPageName() {
        return $this->page_name;
    }

    /**
     * 获取分页每页 X 条记录数。
     *
     * @return int
     */
    function getPageSize() {
        return $this->page_size;
    }

    /**
     * 获取总记录数。
     *
     * @return int
     */
    function getRecordCount() {
        return $this->record_count;
    }

    /**
     * 获取当前页码。
     *
     * @return int
     */
    function getCurrentPage() {
        return $this->current_page;
    }

    /**
     * 获取总页数。
     *
     * @return int
     */
    function getPageCount() {
        return $this->page_count;
    }

    /**
     * 获取数据起始索引值。
     *
     * @return int
     */
    function getStartIndex() {
        return $this->start_index;
    }

    /**
     * 获取查询的数据列表。
     *
     * @return array|null
     */
    function getDataSet() {
        return $this->data_set;
    }

    /**
     * 对象转换为数组。
     *
     * @param array $options
     * @return array
     */
    function toArray(array $options = []) {
        $d = array(
            'si' => $this->start_index,
            'ei' => $this->start_index + $this->page_size,
            'ps' => $this->page_size,
            'cp' => $this->current_page,
            'pc' => $this->page_count,
            'rc' => $this->record_count,
        );

        if ($d['ei'] > $this->record_count)
            $d['ei'] = $this->record_count;

        return $d;
    }

    /**
     * serialize() checks if your class has a function with the magic name __sleep.
     * If so, that function is executed prior to any serialization.
     * It can clean up the object and is supposed to return an array with the names of all variables of that object that should be serialized.
     * If the method doesn't return anything then NULL is serialized and E_NOTICE is issued.
     * The intended use of __sleep is to commit pending data or perform similar cleanup tasks.
     * Also, the function is useful if you have very large objects which do not need to be saved completely.
     *
     * @return array|NULL
     * @link http://php.net/manual/en/language.oop5.magic.php#language.oop5.magic.sleep
     */
    function __sleep() {
        return ['page_name', 'page_size', 'record_count', 'current_page', 'page_count', 'start_index'];
    }
}