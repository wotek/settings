<?php

namespace Wtk\Settings\Tests\Provider;

use Wtk\Settings\Tests\SettingsTestCase;

use Wtk\Settings\Provider\PredefinedProvider;

class PredefinedProviderTest extends SettingsTestCase
{
    public function testSet()
    {
        $this->setExpectedException('RuntimeException');

        $provider = new PredefinedProvider();
        $provider->set('foo', 'bar');
    }

    public function testGet()
    {
        $predefined = array('predefined' => array(
            'foo' => 'bar',
            'nested' => array(
                'array' => array(
                    'value' => true
                )
            ),
        ));

        $provider = new PredefinedProvider($predefined);

        $this->assertSame('bar', $provider->get('predefined.foo'));
        $this->assertSame(
            true, $provider->get('predefined.nested.array.value')
        );
    }

    public function testGetDefault()
    {
        $provider = new PredefinedProvider();
        $default = 'neverbland';

        $this->assertSame(
            $default, $provider->get('not_existing_value', $default)
        );
    }

    public function testRemove()
    {
        $this->setExpectedException('RuntimeException');

        $provider = new PredefinedProvider();
        $provider->remove('foo');
    }

    public function testGetNamespace()
    {
        $provider = new PredefinedProvider();
        $this->assertSame('predefined', $provider->getNamespace());
    }
}
