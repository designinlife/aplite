<?php
namespace Application\Controller;

use APLite\Web\WebControllerBase;

class Index extends WebControllerBase {
    function defaults() {
        $this->bootstrap->getLogger()->info('ha');

        $this->display('index.tpl');
    }
}