<?php

namespace Wtk\Settings\Storage;

use Wtk\Entity\Setting;
use Wtk\Settings\SettingsRepositoryInterface;

/**
 * Simple database settings storage
 *
 * @author Wojtek Zalewski <wojtek@neverbland.com>
 */
class DatabaseStorage implements StorageInterface
{
    /**
     * @var SettingsRepositoryInterface
     */
    protected $repository;

    /**
     *
     * @param  SettingsRepositoryInterface $repository
     */
    public function __construct(SettingsRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Returns Doctrine's repository
     *
     * @return SettingsRepositoryInterface
     */
    protected function getRepository()
    {
        return $this->repository;
    }

    /**
     * Fetches storage for key. If not found
     * return null.
     *
     * @param  string     $key
     *
     * @return mixed
     */
    public function get($key)
    {
        return $this->getRepository()->get($key);
    }

    /**
     * Removes given key from database
     *
     * @param  string     $key
     *
     * @return void
     */
    public function remove($key)
    {
        return $this->getRepository()->remove($key);
    }

    /**
     * Sets key value
     *
     * @param  string     $key
     * @param  mixed      $value
     *
     * @return bool
     */
    public function set($key, $value)
    {
        return $this->getRepository()->set($key, $value);
    }
}
