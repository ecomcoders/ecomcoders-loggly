<?php

namespace EcomCoders\Loggly\Adminhtml;

use Magento\Config\Model\Config\Structure\Reader as XmlConfigReader;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\TestFramework\ObjectManager;

class SystemConfigTest extends \PHPUnit\Framework\TestCase
{
    public function testConfigSectionAndGroupIsDefined()
    {
        /** @var XmlConfigReader $systemXmlConfigReader */
        $systemXmlConfigReader = ObjectManager::getInstance()->create(XmlConfigReader::class);
        $this->assertArrayHasKey('ecomcoders_loggly', $systemXmlConfigReader->read('adminhtml')['config']['system']['sections']['dev']['children']);
    }

    public function testDefaultValueForAppNameIsGiven()
    {
        /** @var ScopeConfigInterface $scopeConfig */
        $scopeConfig = ObjectManager::getInstance()->get(ScopeConfigInterface::class);
        $this->assertSame('your-app-identifier-here', $scopeConfig->getValue('dev/ecomcoders_loggly/app_name'));
    }

    public function testPhpErrorLogFilePathCanBeConfigured()
    {
        /** @var XmlConfigReader $systemXmlConfigReader */
        $systemXmlConfigReader = ObjectManager::getInstance()->create(XmlConfigReader::class);
        $this->assertArrayHasKey('path_to_error_log', $systemXmlConfigReader->read('adminhtml')['config']['system']['sections']['dev']['children']['ecomcoders_loggly']['children']);
    }
}