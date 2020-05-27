<?php

namespace Catgento\Bizum\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use Catgento\Bizum\Model\BizumApi;
use Catgento\Bizum\Model\BizumFactory;
use Catgento\Bizum\Model\ConfigInterface;

/**
 * Class Redirect
 * @package Catgento\Bizum\Block
 */
class Redirect extends Template
{

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var BizumFactory
     */
    protected $bizumFactory;

    /**
     * @var BizumApi
     */
    protected $bizumObj;

    /**
     * Redirect constructor.
     * @param Context $context
     * @param ScopeConfigInterface $scopeConfig
     * @param BizumFactory $bizumFactory
     * @param array $data
     */
    public function __construct(
        Context $context,
        ScopeConfigInterface $scopeConfig,
        BizumFactory $bizumFactory,
        array $data = []
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->bizumFactory = $bizumFactory;
        parent::__construct($context, $data);
    }

    /**
     * @return string
     */
    public function getEnvironment()
    {
        $environment = $this->scopeConfig->getValue(ConfigInterface::XML_PATH_ENVIRONMENT, ScopeInterface::SCOPE_STORE);
        $action = ($environment == ConfigInterface::BIZUM_PRODUCTION_ENVIRONMENT) ? ConfigInterface::BIZUM_PRODUCTION_URI : ConfigInterface::BIZUM_DEVELOPMENT_URI;
        return $action;
    }

    /**
     * @return string
     */
    public function getSignatureVersion()
    {
        return ConfigInterface::BIZUM_SIGNATURE_VERSION;
    }

    /**
     * @return BizumApi
     */
    private function getBizumObject()
    {
        if (is_null($this->bizumObj)) {
            $this->bizumObj = $this->bizumFactory->createBizumObject();
        }
        return $this->bizumObj;
    }

    /**
     * @return string
     */
    public function getParameters()
    {
        $bizumObj = $this->getBizumObject();
        return $bizumObj->createMerchantParameters();
    }

    /**
     * @return string
     */
    public function getSignature()
    {
        $bizumObj = $this->getBizumObject();
        $key256 = $this->scopeConfig->getValue(ConfigInterface::XML_PATH_KEY256, ScopeInterface::SCOPE_STORE);
        return $bizumObj->createMerchantSignature($key256);
    }

}
