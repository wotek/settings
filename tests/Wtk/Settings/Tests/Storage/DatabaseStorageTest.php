<?php

namespace Wtk\Settings\Tests\Storage;

use Wtk\Settings\Storage\DatabaseStorage;

class DatabaseStorageTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Unit testing Doctrine repositories in a Symfony project is not
     * recommended. When you're dealing with a repository, you're really
     * dealing with something that's meant to be tested against a real
     * database connection.
     *
     * @see http://symfony.com/doc/current/cookbook/testing/doctrine.html
     */
    public function getRepositoryMock()
    {
        return $this->getMock(
            'Wtk\Settings\SettingsRepositoryInterface'
        );
    }

    public function testGet()
    {
        /**
         * Lets say in db we have:
         * foo.bar.0 => true
         * foo.bar.1 => false
         */

        // We are quering for:
        $path = 'foo.bar';
        // We should get:
        $expected_return = array(
            0 => true,
            1 => false,
        );

        $repository_mock = $this->getRepositoryMock();
        // You should behave:
        $repository_mock
        ->expects($this->once())
        ->method('get')
        ->with($path)
        ->will($this->returnValue($expected_return))
        ;

        $storage = new DatabaseStorage($repository_mock);

        $this->assertSame($expected_return, $storage->get($path));
    }

    public function testSet()
    {
        // We are going to set some path
        $path = 'foo.bar';
        // with value:
        $value = 1;
        // Not expecting much this time
        $repository_mock = $this->getRepositoryMock();

        $repository_mock
        ->expects($this->once())
        ->method('set')
        ->with($path, $value)
        ->will($this->returnValue(true))
        ;

        $storage = new DatabaseStorage($repository_mock);

        $this->assertSame(true, $storage->set($path, $value));
    }

    public function testRemove()
    {
        // We are going to remove path
        $path = 'foo.bar';
        // Not expecting much this time
        $repository_mock = $this->getRepositoryMock();

        $repository_mock
        ->expects($this->once())
        ->method('remove')
        ->with($path)
        ;

        $storage = new DatabaseStorage($repository_mock);
        $storage->remove($path);
    }
}
