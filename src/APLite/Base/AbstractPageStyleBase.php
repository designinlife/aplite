<?php
namespace APLite\Base;

use APLite\Interfaces\IPageStyle;
use APLite\Utility\Pagination;

/**
 * Class AbstractPageStyleBase
 *
 * @package       APLite\Base
 * @author        Lei Lee <web.developer.network@gmail.com>
 * @version       1.0.0
 * @copyright (c) 2013-2016, Lei Lee
 */
abstract class AbstractPageStyleBase implements IPageStyle {
    /**
     * 分页查询对象。
     *
     * @var Pagination
     */
    protected $pagination = NULL;

    /**
     * 分页 HTML 代码模式。
     *
     * @var string
     */
    protected $page_pattern = NULL;

    /**
     * 设置分页查询对象。
     *
     * @param Pagination $pagination
     * @return IPageStyle
     */
    function setPagination(Pagination $pagination) {
        $this->pagination = $pagination;

        return $this;
    }

    /**
     * 构建分页链接地址。
     *
     * @param int $page
     * @return string
     */
    protected function _build($page) {
        if ($this->page_pattern != NULL) {
            return sprintf($this->page_pattern, $page);
        } else {
            if (empty($_SERVER['QUERY_STRING'])) {
                return $_SERVER['REQUEST_URI'] . '?' . $this->pagination->getPageName() . '=' . $page;
            } else {
                if (preg_match('/(\?|&)' . $this->pagination->getPageName() . '=[\-0-9]*/i', $_SERVER['REQUEST_URI'])) {
                    return preg_replace('/(\?|&)' . $this->pagination->getPageName() . '=[\-0-9]*/is', '\\1' . $this->pagination->getPageName() . '=' . $page, $_SERVER['REQUEST_URI']);
                } else {
                    return $_SERVER['REQUEST_URI'] . '&' . $this->pagination->getPageName() . '=' . $page;
                }
            }
        }
    }
}