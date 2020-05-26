<?php

namespace Catgento\Bizum\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Sales\Model\OrderFactory;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\UrlInterface;
use Magento\Sales\Api\Data\OrderInterface;
use Catgento\Bizum\Logger\Logger;
use Catgento\Bizum\Helper\Helper;

/**
 * Class BizumFactory
 * @package Catgento\Bizum\Model
 */
class BizumFactory
{

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var CheckoutSession
     */
    protected $checkoutSession;

    /**
     * @var OrderFactory
     */
    protected $orderFactory;

    /**
     * @var UrlInterface
     */
    protected $url;

    /**
     * @var Logger
     */
    protected $logger;

    /**
     * @var OrderInterface
     */
    protected $order = null;

    /**
     * BizumFactory constructor.
     * @param ScopeConfigInterface $scopeConfig
     * @param CheckoutSession $checkoutSession
     * @param OrderFactory $orderFactory
     * @param Helper $helper
     * @param UrlInterface $url
     * @param Logger $logger
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        CheckoutSession $checkoutSession,
        OrderFactory $orderFactory,
        Helper $helper,
        UrlInterface $url,
        Logger $logger
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->checkoutSession = $checkoutSession;
        $this->orderFactory = $orderFactory;
        $this->helper = $helper;
        $this->url = $url;
        $this->logger = $logger;
    }

    /**
     * @return OrderInterface
     */
    private function getOrder()
    {
        if (is_null($this->order)) {
            $orderId = $this->checkoutSession->getLastRealOrderId();
            $this->order = $this->orderFactory->create()->loadByIncrementId($orderId);
        }
        return $this->order;
    }

    /**
     * @return float
     */
    private function getBizumAmount()
    {
        $transaction_amount = number_format($this->getOrder()->getBaseGrandTotal(), 2, '', '');
        return (float)$transaction_amount;
    }

    /**
     * @return string
     */
    private function getBizumOrderNumber()
    {
        $orderId = $this->getOrder()->getIncrementId();
        return strval($orderId);
    }

    /**
     * @return string
     */
    private function getBizumProducts()
    {
        $order = $this->getOrder();
        $products = '';
        foreach ($order->getAllVisibleItems() as $itemId => $item) {
            $products .= $item->getName();
            $products .= "X" . $item->getQtyToInvoice();
            $products .= "/";
        }
        return $products;
    }

    /**
     * @return string
     */
    private function getBizumCustomer()
    {
        $order = $this->getOrder();
        return $order->getCustomerFirstname()." ".$order->getCustomerLastname()."/ ".__("Email: ").$order->getCustomerEmail();
    }

    /**
     * @return \Catgento\Bizum\Model\BizumApi
     */
    public function createBizumObject()
    {
        // Get all module Configurations
        $commerce_name = $this->scopeConfig->getValue(ConfigInterface::XML_PATH_COMMERCE_NAME, ScopeInterface::SCOPE_STORE);
        $commerce_num = $this->scopeConfig->getValue(ConfigInterface::XML_PATH_COMMERCE_NUM, ScopeInterface::SCOPE_STORE);
        $terminal = $this->scopeConfig->getValue(ConfigInterface::XML_PATH_TERMINAL, ScopeInterface::SCOPE_STORE);
        $trans = $this->scopeConfig->getValue(ConfigInterface::XML_PATH_TRANSACTION_TYPE, ScopeInterface::SCOPE_STORE);

        // Redirect Result URL
        $orderId = $this->getOrder()->getIncrementId();
        $commerce_url = $this->url->getUrl('bizum/result', ['order_id' => $orderId]);
        $KOcommerce_url = $this->url->getUrl('bizum/koresult', ['order_id' => $orderId]);
        $OKcommerce_url = $this->url->getUrl('bizum/okresult', ['order_id' => $orderId]);

        // Setting Parameters to Bizum
        $bizumObj = new BizumApi();
        $bizumObj->setParameter("DS_MERCHANT_AMOUNT", $this->getBizumAmount());
        $bizumObj->setParameter("DS_MERCHANT_ORDER", $this->getBizumOrderNumber());
        $bizumObj->setParameter("DS_MERCHANT_MERCHANTCODE", $commerce_num);
        $bizumObj->setParameter("DS_MERCHANT_CURRENCY", $this->helper->getCurrency($this->getOrder()));
        $bizumObj->setParameter("DS_MERCHANT_TRANSACTIONTYPE", $trans);
        $bizumObj->setParameter("DS_MERCHANT_TERMINAL", $terminal);
        $bizumObj->setParameter("DS_MERCHANT_MERCHANTURL", $commerce_url);
        $bizumObj->setParameter("DS_MERCHANT_URLOK", $OKcommerce_url);
        $bizumObj->setParameter("DS_MERCHANT_URLKO", $KOcommerce_url);
        $bizumObj->setParameter("Ds_Merchant_ConsumerLanguage", $this->helper->getLanguage());
        $bizumObj->setParameter("Ds_Merchant_ProductDescription", $this->getBizumProducts());
        $bizumObj->setParameter("Ds_Merchant_Titular", $this->getBizumCustomer());
        $bizumObj->setParameter("Ds_Merchant_MerchantData", sha1($commerce_url));
        $bizumObj->setParameter("Ds_Merchant_MerchantName", $commerce_name);
        $bizumObj->setParameter("Ds_Merchant_PayMethods", ConfigInterface::BIZUM_PAYMETHODS);
        $bizumObj->setParameter("Ds_Merchant_Module", "Catgento_Bizum");

        return $bizumObj;
    }

}