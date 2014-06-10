<?php

namespace Wtk\Settings\Provider;

use Wtk\Settings\Provider\ProviderInterface,
    Wtk\Settings\Provider\StorageAwareProvider,
    Wtk\Settings\Storage\StorageInterface;

/**
 * Default providers stores data in settings table.
 *
 * @author Wojtek Zalewski <wojtek@neverbland.com>
 */
class DefaultProvider extends StorageAwareProvider implements ProviderInterface
{
    /**
     * Providers namespace
     *
     * @var string
     */
    protected $namespace;

    /**
     *
     * @param  string           $namespace
     * @param  StorageInterface $storage
     */
    public function __construct($namespace, StorageInterface $storage)
    {
        $this->namespace = $namespace;
        $this->storage = $storage;
    }

    /**
     * Sets key value in storage.
     *
     * @param  string     $key
     * @param  mixed      $value
     *
     * @return boolean
     */
    public function set($key, $value)
    {
        $storage = $this->getStorage();

        return $storage->set($key, $value);
    }

    /**
     * Returns key value if found. If not, returns default.
     *
     * @param  string     $key
     * @param  mixed      $default
     *
     * @return mixed
     */
    public function get($key, $default = null)
    {
        $value = $this->getStorage()->get($key);

        if(null === $value)
        {
            return $default;
        }

        return $value;
    }

    /**
     * Removes given settings key
     *
     * @param  string     $key
     *
     * @return bool
     */
    public function remove($key)
    {
        $storage = $this->getStorage();

        return $storage->remove($key);
    }

    /**
     * Defaults settings namespace
     *
     * @return string
     */
    public function getNamespace()
    {
        return $this->namespace;
    }
}
