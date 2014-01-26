<?php

namespace Wtk\Settings\Tests\Provider;

use Wtk\Settings\Tests\SettingsTestCase;

use Wtk\Settings\Provider\Blackhole;

class BlackholeProviderTest extends SettingsTestCase
{

    public function getProvider()
    {
        return new Blackhole();
    }

    public function testGet()
    {
        $this->assertSame(
            $this->getProvider()->set('foo', 'bar'),
            true
        );
    }

    public function testSet()
    {
        $this->assertSame(
            $this->getProvider()->get('foo'),
            false
        );
    }

    public function testGetNamespace()
    {
        $this->assertSame(
            $this->getProvider()->getNamespace(),
            'blackhole'
        );
    }

    public function testRemove()
    {
        $this->assertSame(
            $this->getProvider()->remove('foo'),
            true
        );
    }
}
