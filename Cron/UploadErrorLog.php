<?php

namespace EcomCoders\Loggly\Cron;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\HTTP\Client\Curl;
use Psr\Log\LoggerInterface;

class UploadErrorLog
{

    const LOGGLY_ENDPOINT = 'https://logs-01.loggly.com';

    /**
     * ScopeCongigInterface
     *
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var Curl
     */
    private $curl;

    /**
     * UploadErrorLog constructor.
     *
     * @param ScopeConfigInterface $scopeConfig
     * @param LoggerInterface      $logger
     * @param Curl                 $curl
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        LoggerInterface $logger,
        Curl $curl
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->logger = $logger;
        $this->curl = $curl;
    }

    public function execute()
    {
        if (false === is_writable(pathinfo($this->getErrorLogPath(), PATHINFO_DIRNAME))) {
            $this->logger->notice(
                'PHP error logfile directory is not writable: ' . pathinfo($this->getErrorLogPath(), PATHINFO_DIRNAME)
            );

            return;
        }

        if (is_file($this->getErrorLogPath())) {
            $this->postFileToLoggly();
            unlink($this->getErrorLogPath());
        }
    }

    /**
     * GetAppName
     *
     * @return string
     */
    private function getAppName()
    {
        return $this->scopeConfig->getValue('dev/ecomcoders_loggly/app_name');
    }

    /**
     * GetToken
     *
     * @return string
     */
    private function getToken()
    {
        return $this->scopeConfig->getValue('dev/ecomcoders_loggly/loggly_token');
    }

    /**
     * GetErrorLogPath
     *
     * @return string
     */
    private function getErrorLogPath()
    {
        return $this->scopeConfig->getValue('dev/ecomcoders_loggly/path_to_error_log');
    }

    /**
     * PostFileToLoggly
     *
     * @return void
     */
    private function postFileToLoggly()
    {
        $uri = \sprintf(
            self::LOGGLY_ENDPOINT . '/bulk/%s/tag/%s-error-log', $this->getToken(), $this->getAppName()
        );

        $this->curl->post(
            $uri, [
                'error_message' => \file_get_contents($this->getErrorLogPath())
            ]
        );

        if ('{"response" : "ok"}' !== $this->curl->getBody()) {
            $this->logger->critical('Error occurred posting log file to Loggly: ' . $this->curl->getBody());
        }
    }
}