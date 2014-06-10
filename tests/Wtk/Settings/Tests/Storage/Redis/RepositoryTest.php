<?php

namespace Wtk\Settings\Tests\Storage\Redis;

use Wtk\Settings\Storage\Redis\Repository;
use Wtk\Settings\Tests\SettingsTestCase;

class RepositoryTest extends SettingsTestCase
{

    public function testInstantiate()
    {
        $hash = $this->getHashMock();

        $repository = new Repository($hash);

        $this->assertInstanceOf(
            'Wtk\Settings\SettingsRepositoryInterface',
            $repository
        );
    }

    public function testGetSimple()
    {
        $hash = $this->getHashMock();


        $key = 'some_key';
        $expected_return = 'some_final_value';

        $hash
            ->expects($this->once())
            ->method('get')
            ->with($key)
            ->will($this->returnValue($expected_return))
        ;

        $repository = new Repository($hash);

        $this->assertSame(
            array($key => $expected_return),
            $repository->get($key)
        );
    }

    public function testGetNested()
    {
        $hash = $this->getHashMock();


        $key = 'some.path.with.nested.paths';
        $pattern = 'some.path.with.nested.paths.*';

        $nested = array(
            'some.path.with.nested.paths.1' => true,
            'some.path.with.nested.paths.2' => false,
            'some.path.with.nested.paths.3' => 'foo',
            'some.path.with.nested.paths.other' => 123,
        );

        $paths_response = array(0, $nested);

        $hash
            ->expects($this->once())
            ->method('get')
            ->with($key)
            ->will($this->returnValue(null))
        ;

        $hash
            ->expects($this->once())
            ->method('fields')
            ->with($pattern)
            ->will($this->returnValue($paths_response))
        ;

        $repository = new Repository($hash);

        $result = $repository->get($key);

        $this->assertSame($nested, $result);
    }

    public function testRemoveSimple()
    {
        $hash = $this->getHashMock();


        $key = 'some.path.to.setting';

        $hash
            ->expects($this->once())
            ->method('remove')
            ->with($key)
            ->will($this->returnValue(true))
        ;

        $repository = new Repository($hash);

        $this->assertTrue($repository->remove($key));
    }

    public function testRemoveNested()
    {
        $hash = $this->getHashMock();


        $key = 'some.path.with.nested.paths';
        $pattern = 'some.path.with.nested.paths.*';

        $nested = array(
            'some.path.with.nested.paths.1' => true,
            'some.path.with.nested.paths.2' => false,
            'some.path.with.nested.paths.3' => 'foo',
            'some.path.with.nested.paths.other' => 123,
        );

        $fields = array_keys($nested);
        $deleted = count($fields);

        $paths_response = array(0, $nested);

        $hash
            ->expects($this->once())
            ->method('remove')
            ->with($key)
            ->will($this->returnValue(false))
        ;

        $hash
            ->expects($this->once())
            ->method('fields')
            ->with($pattern)
            ->will($this->returnValue($paths_response))
        ;

        $hash
            ->expects($this->once())
            ->method('mremove')
            ->with($fields)
            ->will($this->returnValue($deleted))
        ;

        $repository = new Repository($hash);

        $result = $repository->remove($key);

        $this->assertSame($deleted, $result);
    }

    public function testSet()
    {
        $hash = $this->getHashMock();


        $key = 'some_key';
        $value = 'value';

        $hash
            ->expects($this->once())
            ->method('set')
            ->with($key, $value)
            ->will($this->returnValue(true))
        ;

        $repository = new Repository($hash);

        $this->assertTrue($repository->set($key, $value));
    }

}
