<?php

namespace Kalicr\CustomCheckoutProcess\Logger;

use Monolog\Logger;

class Handler extends \Magento\Framework\Logger\Handler\Base
{
    protected $loggerType = 200;
    protected $fileName = '/var/log/orders.log';
}