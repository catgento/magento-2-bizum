<?php

namespace Catgento\Bizum\Block;

use Magento\Framework\Phrase;
use Magento\Payment\Model\Config as PaymentConfig;
use Magento\Payment\Block\ConfigurableInfo;

/**
 * Class Info
 * @package Catgento\Bizum\Block
 */
class Info extends ConfigurableInfo
{

    /**
     * Returns label
     *
     * @param string $field
     * @return Phrase
     */
    protected function getLabel($field)
    {
        return __($field);
    }

}
