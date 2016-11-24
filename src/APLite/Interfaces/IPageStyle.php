<?php
namespace APLite\Interfaces;

use APLite\Utility\Pagination;

/**
 * 数据分页样式渲染器接口。
 *
 * @package       APLite\Interfaces
 * @author        Lei Lee <web.developer.network@gmail.com>
 * @version       1.0.0
 * @copyright (c) 2013-2016, Lei Lee
 */
interface IPageStyle {
    /**
     * 设置分页查询对象。
     *
     * @param Pagination $pagination
     * @return IPageStyle
     */
    function setPagination(Pagination $pagination);

    /**
     * 输出分页 HTML 代码。
     *
     * @return string
     */
    function apply();
}