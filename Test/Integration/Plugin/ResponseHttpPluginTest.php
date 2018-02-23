<?php

namespace EcomCoders\Loggly\Plugin;


use Magento\TestFramework\Interception\PluginList;
use Magento\TestFramework\ObjectManager;

class ResponseHttpPluginTest extends \PHPUnit\Framework\TestCase
{
    public function testPluginIsDefined()
    {
        /** @var PluginList $pluginList */
        $pluginList = ObjectManager::getInstance()->get(PluginList::class);
        $plugins = $pluginList->get(\Magento\Framework\App\Http::class, []);

        $this->assertSame(Http::class, $plugins['ecomcoders_loggly']['instance']);
    }
}