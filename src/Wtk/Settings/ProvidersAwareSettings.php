<?php

namespace Wtk\Settings;

use Wtk\Settings\Provider\ProviderInterface;

abstract class ProvidersAwareSettings
{
    /**
     * Available providers
     *
     * @var array An array of ProviderInterface's
     */
    protected $providers = array();

    /**
     * Adds settings provider
     *
     * @param  ProviderInterface $provider
     *
     * @throws InvalidArgumentException
     *
     * @return Settings
     */
    public function addProvider(ProviderInterface $provider)
    {
        /**
         * We assume that each provider has its own and unique namespace.
         */
        if(array_key_exists($provider->getNamespace(), $this->providers))
        {
            throw new \InvalidArgumentException(
                sprintf(
                    "Provider's namespace %s is already registered",
                    $provider->getNamespace()
                )
            );
        }

        $this->providers[$provider->getNamespace()] = $provider;

        return $this;
    }

    /**
     * Returns namespace's provider
     *
     * @param  string     $namespace
     *
     * @throws OutOfBoundsException
     *
     * @return ProviderInterface
     */
    public function getProvider($namespace)
    {
        $providers = $this->getProviders();

        if(null === $namespace)
        {
            /**
             * This needs to be rethought
             */
            return $this->getProvider('default');
        }

        if(array_key_exists($namespace, $providers))
        {
            return $providers[$namespace];
        }

        throw new \OutOfBoundsException(
            sprintf(
                "Not recognized namespace: %s given. Not found.",
                $namespace
            )
        );
    }

    /**
     * Bulk add providers
     *
     * @param  array      $providers
     */
    public function addProviders(array $providers = array())
    {
        foreach($providers as $provider)
        {
            $this->addProvider($provider);
        }
    }

    /**
     * Returns providers array
     *
     * @return array
     */
    public function getProviders()
    {
        return $this->providers;
    }
}
