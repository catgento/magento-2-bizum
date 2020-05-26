<?php

namespace Catgento\Bizum\Model;

/**
 * Interface ConfigInterface
 */
interface ConfigInterface 
{

	const BIZUM_DEVELOPMENT_ENVIRONMENT    = 0;
	const BIZUM_PRODUCTION_ENVIRONMENT     = 1;
    const BIZUM_REDIRECT_URI               = 'bizum/redirect/';
    const BIZUM_DEVELOPMENT_URI            = 'https://sis-t.redsys.es:25443/sis/realizarPago/utf-8';
    const BIZUM_PRODUCTION_URI             = 'https://sis.redsys.es/sis/realizarPago/utf-8';
    const BIZUM_SIGNATURE_VERSION          = 'HMAC_SHA256_V1';
    const BIZUM_PAYMETHODS                 = 'C';
    const BIZUM_DEFAULT_LANGUAGE           = '002';
    const BIZUM_DEFAULT_CURRENCY           = '978';

    const XML_PATH_ACTIVE                   = 'payment/bizum/active';
    const XML_PATH_TITLE                    = 'payment/bizum/title';
    const XML_PATH_ENVIRONMENT              = 'payment/bizum/environment';
    const XML_PATH_COMMERCE_NAME            = 'payment/bizum/commerce_name';
    const XML_PATH_COMMERCE_NUM             = 'payment/bizum/commerce_num';
    const XML_PATH_KEY256                   = 'payment/bizum/key256';
    const XML_PATH_TERMINAL                 = 'payment/bizum/terminal';
    const XML_PATH_TRANSACTION_TYPE         = 'payment/bizum/transaction_type';
    const XML_PATH_LANGUAGES                = 'payment/bizum/languages';
    const XML_PATH_AUTOINVOICE              = 'payment/bizum/autoinvoice';
    const XML_PATH_SENDINVOICE              = 'payment/bizum/sendinvoice';
    const XML_PATH_RECOVERY_CART            = 'payment/bizum/recovery_cart';
    const XML_PATH_DEBUG                    = 'payment/bizum/debug';
    const XML_PATH_ALLOWSPECIFIC            = 'payment/bizum/allowspecific';
    const XML_PATH_SPECIFICCOUNTRY          = 'payment/bizum/specificcountry';
    const XML_PATH_SORT_ORDER               = 'payment/bizum/sort_order';

}