<?php

namespace Wtk\Settings\Tests\Provider;

use Wtk\Settings\Tests\SettingsTestCase;

use Wtk\Settings\Provider\DefaultProvider;

class DefaultProviderTest extends SettingsTestCase
{

    public function getProvider($storage)
    {
        return new DefaultProvider($storage);
    }

    public function testGet()
    {
        $lookup_key = 'some_key';
        $expected_value = false;

        $storage = $this->getStorageMock();
        // On $lookup_key return me false
        $storage
        ->expects($this->once())
        ->method('get')
        ->with($lookup_key)
        ->will($this->returnValue($expected_value))
        ;

        $provider = $this->getProvider($storage);

        $value = $provider->get($lookup_key);

        $this->assertSame($value, $expected_value);
    }

    public function testGetDefault()
    {
        $storage = $this->getStorageMock();
        $provider = $this->getProvider($storage);

        $this->assertSame(
            $provider->get('not_existing_value', array()),
            array()
        );
    }

    public function testSet()
    {
        $key = 'foo';
        $value = 'bar';

        $storage = $this->getStorageMock();

        $storage
        ->expects($this->once())
        ->method('set')
        ->with($key, $value)
        ->will($this->returnValue(true))
        ;

        $provider = $this->getProvider($storage);

        $result = $provider->set($key, $value);
        $this->assertTrue($result);
    }

    public function testRemove()
    {
        $key = 'foo';

        $storage = $this->getStorageMock();

        $storage
        ->expects($this->once())
        ->method('remove')
        ->with($key)
        ->will($this->returnValue(true))
        ;

        $provider = $this->getProvider($storage);

        $result = $provider->remove($key);
        $this->assertTrue($result);
    }

    public function testGetNamespace()
    {
        $storage = $this->getStorageMock();
        $provider = $this->getProvider($storage);

        $this->assertSame('default', $provider->getNamespace());
    }

    public function testSetNamespace()
    {
        $storage = $this->getStorageMock();
        $provider = $this->getProvider($storage);

        $provider->setNamespace('Neverbland');

        $this->assertSame('Neverbland', $provider->getNamespace());
    }
}
