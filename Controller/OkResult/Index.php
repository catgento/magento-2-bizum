<?php

namespace Catgento\Bizum\Controller\OkResult;

use Magento\Framework\App\Action\Action;

/**
 * Class Index
 * @package Catgento\Bizum\Controller\OkResult
 */
class Index extends Action
{

    public function execute()
    {
        $this->_redirect('checkout/onepage/success');
    }

}