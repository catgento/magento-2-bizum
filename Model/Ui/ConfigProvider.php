<?php

namespace Catgento\Bizum\Model\Ui;

use Magento\Checkout\Model\ConfigProviderInterface;
use Magento\Framework\Session\SessionManagerInterface;
use Catgento\Bizum\Gateway\Config\Config;
use Catgento\Bizum\Model\ConfigInterface;

/**
 * Class ConfigProvider
 */
final class ConfigProvider implements ConfigProviderInterface
{
    const CODE = 'bizum';

    /**
     * @var Config
     */
    private $config;

    /**
     * @var SessionManagerInterface
     */
    private $session;

    /**
     * ConfigProvider constructor.
     * @param Config $config
     * @param SessionManagerInterface $session
     */
    public function __construct(
        Config $config,
        SessionManagerInterface $session
    ) {
        $this->config = $config;
        $this->session = $session;
    }

    /**
     * Retrieve assoc array of checkout configuration
     *
     * @return array
     */
    public function getConfig()
    {
        $storeId = $this->session->getStoreId();

        return [
            'payment' => [
                self::CODE => [
                    'isActive' => $this->config->isActive($storeId),
                    'redirectUrl' => ConfigInterface::BIZUM_REDIRECT_URI
                ]
            ]
        ];
    }

}
