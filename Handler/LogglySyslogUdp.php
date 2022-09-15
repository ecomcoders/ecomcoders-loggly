<?php

namespace EcomCoders\Loggly\Handler;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Monolog\Handler\SyslogUdpHandler;
use Monolog\Logger;

class LogglySyslogUdp extends SyslogUdpHandler
{
    const SYSLOG_VERSION = 1;

    /**
     * Hostname
     *
     * @var string
     */
    protected $host = 'logs-01.loggly.com';

    /**
     * ScopeConfig
     *
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * LogglySyslogUdp constructor.
     *
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        parent::__construct(
            $this->host);
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Make common syslog header (see rfc5424)
     *
     * @param int $severity
     * @return string
     */
    protected function makeCommonSyslogHeader($severity, $datetime)
    {
        $priority       = $severity + $this->facility;
        $appname        = $this->scopeConfig->getValue('dev/ecomcoders_loggly/app_name');
        $server         = parse_url($this->scopeConfig->getValue('web/unsecure/base_url'), PHP_URL_HOST);
        $token          = sprintf('[%s@41058]', $this->scopeConfig->getValue('dev/ecomcoders_loggly/loggly_token'));

        return sprintf('<%s>%d %s %s %s - - %s', $priority, self::SYSLOG_VERSION, gmdate(DATE_RFC3339), $server, $appname, $token);
    }
}
