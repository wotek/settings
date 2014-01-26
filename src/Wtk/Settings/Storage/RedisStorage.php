<?php

namespace Wtk\Settings\Storage;

use Wtk\Settings\ArrayUtils;

use Wtk\Settings\SettingsRepositoryInterface;

/**
 * Redis settings storage
 *
 * @author Wojtek Zalewski <wojtek@neverbland.com>
 */
class RedisStorage implements StorageInterface
{
    protected $repository;

    public function __construct(SettingsRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return SettingsRepositoryInterface
     */
    protected function getRepository()
    {
        return $this->repository;
    }

    public function get($key)
    {
        $paths = $this->getRepository()->get($key);

        $expanded = ArrayUtils::expand($paths);

        return ArrayUtils::get($expanded, $key, null);
    }

    public function remove($key)
    {
        return $this->getRepository()->remove($key);
    }

    public function set($key, $value)
    {
        return $this->getRepository()->set($key, $value);
    }
}
