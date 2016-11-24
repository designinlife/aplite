<?php
namespace APLite\Utility;

use APLite\Base\AbstractPageStyleBase;

/**
 * 基本分页样式类。
 *
 * @package       APLite\Utility
 * @author        Lei Lee <web.developer.network@gmail.com>
 * @version       1.0.0
 * @copyright (c) 2013-2016, Lei Lee
 */
class PageStyle extends AbstractPageStyleBase {
    /**
     * 输出分页 HTML 代码。
     *
     * @return string
     */
    function apply() {
        $html = '';

        if ($this->pagination->getCurrentPage() > 1) {
            $html .= '<a href="' . $this->_build(1) . '" class="first">首页</a>';
            $html .= '<a href="' . $this->_build($this->pagination->getCurrentPage() - 1) . '" class="first">上一页</a>';
        }
        if ($this->pagination->getCurrentPage() < $this->pagination->getPageCount()) {
            $html .= '<a href="' . $this->_build($this->pagination->getCurrentPage() + 1) . '" class="first">下一页</a>';
            $html .= '<a href="' . $this->_build($this->pagination->getPageCount()) . '" class="first">最后一页</a>';
        }

        return $html;
    }
}