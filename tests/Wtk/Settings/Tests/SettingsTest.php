<?php

namespace Wtk\Settings\Tests;

use Wtk\Settings\Tests\SettingsTestCase;

use Wtk\Settings\Resolver\NamespacedItemResolver,
    Wtk\Settings\Provider\DefaultProvider,
    Wtk\Settings\Provider\Blackhole,
    Wtk\Settings\Settings;

class SettingsTest extends SettingsTestCase
{
    public function testSetDataProvider()
    {
        return array(
            array(
                'path' => 'provider_namespace.module.group.name',
                'value' => true,
                'namespace' => 'provider_namespace',
                'resolved_path' => 'provider_namespace.module.group.name',
            ),
            array(
                'path' => 'provider_namespace.module.group.name',
                'value' => array(1,2,3),
                'namespace' => 'provider_namespace',
                'resolved_path' => 'provider_namespace.module.group.name',
            ),
            array(
                'path' => 'provider_namespace.module.group.name',
                'value' => 1,
                'namespace' => 'provider_namespace',
                'resolved_path' => 'provider_namespace.module.group.name',
            ),
            array(
                'path' => 'provider_namespace.module.group.name',
                'value' => 'string',
                'namespace' => 'provider_namespace',
                'resolved_path' => 'provider_namespace.module.group.name',
            ),
        );
    }

    /**
     * @dataProvider testSetDataProvider
     */
    public function testSet($path, $value, $namespace, $resolved_path) {
        $provider = $this->getProviderMock();

        $provider
        ->expects($this->any())
        ->method('getNamespace')
        ->will($this->returnValue('provider_namespace'))
        ;

        $provider
        ->expects($this->once())
        ->method('set')
        ->with($resolved_path, $value)
        ->will($this->returnValue(true))
        ;

        $settings = $this->getSettingsStub(
            array($provider),
            new NamespacedItemResolver
        );

        $result = $settings->set($path, $value);

        $this->assertSame(true, $result);
    }

    public function testRemove()
    {
        $key = 'namespace.group.key_name';

        $provider = $this->getProviderMock();

        $provider
        ->expects($this->any())
        ->method('getNamespace')
        ->will($this->returnValue('namespace'))
        ;

        $provider
        ->expects($this->once())
        ->method('remove')
        ->with($key)
        ->will($this->returnValue(true))
        ;

        $settings = $this->getSettingsStub(
            array($provider),
            new NamespacedItemResolver
        );

        $result = $settings->remove($key);

        $this->assertSame(true, $result);
    }

    public function testSetFailedAttempt()
    {
        /**
         * Scenario:
         *
         * We have:
         *
         * foo.bar.0 = sth
         * foo.bar.1 = sth_else
         *
         * And someone tries to change `foo.bar` to `some_value`
         *
         * It should fail because foo.bar have childs: 0 and 1.
         *
         * Force user to remove it knowingly before setting up new value.
         */
        $this->setExpectedException('InvalidArgumentException');

        $provider = $this->getProviderMock();

        $provider
        ->expects($this->any())
        ->method('getNamespace')
        ->will($this->returnValue('a'))
        ;

        $provider
        ->expects($this->once())
        ->method('set')
        ->with('a.b.c', 'does_not_matter')
        //
        // Failed provider write will trigger Settings class Exception:
        //
        ->will($this->returnValue(false))
        ;

        $settings = $this->getSettingsStub(
            array($provider),
            new NamespacedItemResolver
        );

        $result = $settings->set('a.b.c', 'does_not_matter');
    }

    public function testGet() {
        $provider = $this->getProviderMock();
        // Lets have just one option there
        $path = 'default.foo.bar';
        $expected_value =  1;

        $provider
        ->expects($this->once())
        ->method('get')
        ->with($path)
        ->will($this->returnValue($expected_value))
        ;

        $provider
        ->expects($this->any())
        ->method('getNamespace')
        ->will($this->returnValue('default'))
        ;

        $settings = $this->getSettingsStub(
            array($provider),
            new NamespacedItemResolver
        );

        $this->assertSame(
            $expected_value,
            $settings->get($path)
        );
    }

    public function testGetDefault()
    {
        $storage = $this->getStorageMock();

        $provider = new DefaultProvider('default', $storage);

        $settings = $this->getSettingsStub(
            array($provider),
            new NamespacedItemResolver
        );

        $this->assertSame(
            'default_one',
            $settings->get('default.not_existing', 'default_one')
        );
    }

    public function testGetNotExistingNamespace()
    {
        $this->setExpectedException('OutOfBoundsException');

        $storage = $this->getStorageMock();

        $provider = new DefaultProvider('default', $storage);

        $settings = $this->getSettingsStub(
            array($provider),
            new NamespacedItemResolver
        );

        $settings->get('not_existing_provider_namespace');
    }

    public function testRuntimeExeptionWhenNoResolverFound()
    {
        $this->setExpectedException('RuntimeException');

        $settings = new Settings;
        $settings->addProvider(new Blackhole());

        $settings->get('
            this_should_throw_exception
            _couse_no_resolver_was_attached_to_object'
        );
    }

}
