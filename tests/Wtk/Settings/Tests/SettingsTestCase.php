<?php

namespace Wtk\Settings\Tests;

use Wtk\Settings\Settings;

abstract class SettingsTestCase extends \PHPUnit_Framework_TestCase
{

    public function getResolverMock(array $methods = array())
    {
        return $this->getMock(
            '\Wtk\Settings\Resolver\ResolverInterface',
             $methods
        );
    }

    public function getProviderMock(array $methods = array())
    {
        return $this->getMock(
            '\Wtk\Settings\Provider\ProviderInterface',
             $methods
        );
    }

    public function getStorageMock(array $methods = array())
    {
        return $this->getMock(
            'Wtk\Settings\Storage\StorageInterface'
        );
    }

    public function getRepositoryMock(array $methods = array())
    {
        $builder = $this->getMockBuilder(
            'Wtk\Settings\SettingsRepositoryInterface'
        );
        $builder->setMethods($methods);

        return $builder->getMock();

    }

    public function getHashMock(array $methods = array())
    {
        $builder = $this->getMockBuilder('Wtk\Redis\Hash\HashInterface');
        $builder->setMethods($methods);

        return $builder->getMock();
    }

    public function getSettingsStub(array $providers, $resolver)
    {
        $settings = new Settings;

        $settings->addProviders($providers);
        $settings->setResolver($resolver);

        return $settings;
    }
}
