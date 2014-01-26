<?php

namespace Wtk\Settings\Tests\Storage;

use Wtk\Settings\Storage\RedisStorage;
use Wtk\Settings\Tests\SettingsTestCase;

class RedisStorageTest extends SettingsTestCase
{
    public function testInstantiate()
    {
        $repository = $this->getRepositoryMock();

        $storage = new RedisStorage($repository);

        $this->assertInstanceOf(
            'Wtk\Settings\Storage\StorageInterface',
            $storage
        );
    }

    public function testGet()
    {
        $paths = array(
            'foo.bar.baz' => 'value',

            'foo.bar.bat' => 'value',

            'foo.bar.boo' => 'value',
        );

        $looking_for = 'foo.bar';

        $repository = $this->getRepositoryMock();

        $repository
            ->expects($this->once())
            ->method('get')
            ->with($looking_for)
            ->will($this->returnValue($paths))
        ;

        $storage = new RedisStorage($repository);

        $expected = array(
            'baz' => 'value',
            'bat' => 'value',
            'boo' => 'value',
        );

        $this->assertSame(
            $expected, $storage->get($looking_for)
        );
    }

    public function testRemove()
    {
        $repository = $this->getRepositoryMock();

        $key = 'some_key';

        $repository
            ->expects($this->once())
            ->method('remove')
            ->with($key)
            ->will($this->returnValue(true))
        ;

        $storage = new RedisStorage($repository);

        $this->assertTrue($storage->remove($key));
    }

    public function testSet()
    {
        $repository = $this->getRepositoryMock();

        $key = 'some_key';
        $value = 'some_value';

        $repository
            ->expects($this->once())
            ->method('set')
            ->with($key, $value)
            ->will($this->returnValue(true))
        ;

        $storage = new RedisStorage($repository);

        $this->assertTrue($storage->set($key, $value));
    }
}
