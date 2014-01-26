<?php
namespace Wtk\Settings\Provider;

use Wtk\Settings\Storage\StorageInterface;

/**
 * StorageAware Provider implementation. Nothing fancy here.
 *
 * @author Wojtek Zalewski <wojtek@neverbland.com>
 */
abstract class StorageAwareProvider implements StorageAwareProviderInterface
{
    /**
     * @var StorageInterface
     */
    protected $storage;

    /**
     *
     * @param  StorageInterface $storage
     */
    public function __construct(StorageInterface $storage)
    {
        $this->storage = $storage;
    }

    /**
     * Returns settings storage
     *
     * @return StorageInterface
     */
    protected function getStorage()
    {
        return $this->storage;
    }
}
