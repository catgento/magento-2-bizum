<?php

namespace Catgento\Bizum\Logger;

use Magento\Framework\Logger\Handler\Base;
use Monolog\Logger;

class Handler extends Base
{
    protected $fileName = '/var/log/bizum.log';
    protected $loggerType = Logger::INFO;
}