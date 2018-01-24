<?php

namespace EcomCoders\Loggly\Plugin;

use Magento\Framework\App\Bootstrap;

class Http
{

    /**
     * @var \Magento\Framework\Logger\Monolog
     */
    private $logger;

    /**
     * Http constructor.
     *
     * @param \Magento\Framework\Logger\Monolog $logger
     */
    public function __construct(\Magento\Framework\Logger\Monolog $logger)
    {

        $this->logger = $logger;
    }

    /**
     * BeforeCatchException
     *
     * @param \Magento\Framework\App\Http $http
     * @param Bootstrap                   $bootstrap
     * @param \Exception                  $exception
     *
     * @return null
     */
    public function beforeCatchException(\Magento\Framework\App\Http $http, Bootstrap $bootstrap, \Exception $exception)
    {
        $this->logger->critical($exception);
        return null;
    }
}