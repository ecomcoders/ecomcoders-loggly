<?php

namespace EcomCoders\Loggly;

use Magento\Cron\Model\ConfigInterface;
use Magento\TestFramework\ObjectManager;

class CronTabConfigTest extends \PHPUnit_Framework_TestCase
{
    public function testCronTabJobIsDefined()
    {
        /** @var ObjectManager $objectManager */
        $objectManager = ObjectManager::getInstance();

        $jobConfig = $objectManager->get(ConfigInterface::class)->getJobs();
        $this->assertArrayHasKey('ecomcoders_loggly_upload_errorlog', $jobConfig['default']);
    }
}