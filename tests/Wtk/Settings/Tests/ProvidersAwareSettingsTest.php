<?php

namespace Wtk\Settings\Tests;

use Wtk\Settings\Tests\SettingsTestCase;

use Wtk\Settings\Settings;

class ProvidersAwareSettingsTest extends SettingsTestCase
{
    public function testAddProvider()
    {
        $provider = $this->getProviderMock();

        $example_namespace = 'foo';

        $provider
            ->expects($this->any())
            ->method('getNamespace')
            ->will($this->returnValue($example_namespace))
        ;

        $settings = new Settings;

        $settings->addProvider($provider);

        $this->assertSame(
            $settings->getProvider($example_namespace),
            $provider
        );
    }

    public function testAddAlreadyExistingProvider()
    {
        $this->setExpectedException('InvalidArgumentException');

        $provider = $this->getProviderMock();
        $provider
            ->expects($this->any())
            ->method('getNamespace')
            ->will($this->returnValue('foo'))
        ;

        $settings = new Settings;
        $settings->addProvider($provider);

        // This should throw exception
        $settings->addProvider($provider);
    }

    public function testGetProvider()
    {
        $provider = $this->getProviderMock();
        // Register provider namespace:
        $provider
            ->expects($this->any())
            ->method('getNamespace')
            ->will($this->returnValue('foo'))
        ;

        $settings = new Settings;
        $settings->addProvider($provider);

        // Now. try to get provider null
        $this->assertSame(
            $provider, $settings->getProvider('foo')
        );
    }

    public function testGetProviderFallbackToDefault()
    {
        $provider = $this->getProviderMock();
        // Register default provider:
        $provider
            ->expects($this->any())
            ->method('getNamespace')
            ->will($this->returnValue('default'))
        ;

        $settings = new Settings;
        $settings->addProvider($provider);

        // Now. try to get provider null
        $this->assertSame(
            $provider, $settings->getProvider(null)
        );
    }

    public function testGetNotExistingProvider()
    {
        $this->setExpectedException('OutOfBoundsException');

        $settings = new Settings;

        // No providers, try to access anything.
        $settings->getProvider('not_existing_provider');
    }
}
