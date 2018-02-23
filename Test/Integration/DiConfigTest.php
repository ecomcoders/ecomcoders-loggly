<?php

namespace EcomCoders\Loggly;

use Magento\Framework\ObjectManager\ConfigInterface as ObjectManagerConfig;
use Magento\TestFramework\ObjectManager;
use Monolog\Logger;

class DiConfigTest extends \PHPUnit\Framework\TestCase
{
    /**
     * GetDiConfig
     *
     * @return ObjectManagerConfig
     */
    private function getDiConfig()
    {
        return ObjectManager::getInstance()->get(ObjectManagerConfig::class);
    }

    public function testDiConfigArgumentsHttp()
    {
        $type = \Magento\Framework\Logger\Monolog::class;
        $arguments = $this->getDiConfig()->getArguments($type);

        $this->assertArrayHasKey('ecomcoders-loggly', $arguments['handlers']);
        $this->assertSame(\EcomCoders\Loggly\Handler\LogglySyslogUdp::class, $arguments['handlers']['ecomcoders-loggly']['instance']);
    }
}