<?php

namespace Catgento\Bizum\Model\System\Config\Source;

use Magento\Framework\Option\ArrayInterface;
use Catgento\Bizum\Model\ConfigInterface;

class Environment implements ArrayInterface
{

	/**
	* Options getter
	*
	* @return array
	*/
	public function toOptionArray()
	{
		return [
			['value' => ConfigInterface::BIZUM_DEVELOPMENT_ENVIRONMENT, 'label' => __('Test Enviroment')],
			['value' => ConfigInterface::BIZUM_PRODUCTION_ENVIRONMENT, 'label' => __('Real Enviroment')]
		];
	}

	public function toArray()
	{
		return [
			ConfigInterface::BIZUM_DEVELOPMENT_ENVIRONMENT => __('Test Enviroment'),
			ConfigInterface::BIZUM_PRODUCTION_ENVIRONMENT => __('Real Enviroment'),
		];
	}
}
