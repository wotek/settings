<?php

namespace Wtk\Settings\Storage\Redis;

use Wtk\Settings\SettingsRepositoryInterface;

use Wtk\Redis\Hash\HashInterface;

/**
 * Redis settings repository
 *
 * @author Wojtek Zalewski <wojtek@neverbland.com>
 */
class Repository implements SettingsRepositoryInterface
{
    /**
     * @var Wtk\Redis\Hash
     */
    protected $hash;

    /**
     *
     * @param  HashInterface $hash
     */
    public function __construct(HashInterface $hash)
    {
        $this->hash = $hash;
    }

    /**
     * @return Wtk\Redis\HashInterface
     */
    protected function getHash()
    {
        return $this->hash;
    }

    /**
     * Returns pattern for nested keys
     *
     * @param  string     $key
     *
     * @return string
     */
    protected function getPattern($key)
    {
        return sprintf("%s.*", $key);
    }

    /**
     * Returns an array with path value if found
     *
     * @param  string     $key
     *
     * @return array
     */
    public function get($key)
    {
        $value = $this->getHash()->get($key);

        if(null !== $value)
        {
            return array($key => $value);
        }

        list($cursor, $paths) =
            $this->getHash()->fields($this->getPattern($key));

        return $paths;
    }

    /**
     * Removes given path
     *
     * @param  string     $key
     *
     * @return string
     */
    public function remove($key)
    {
        /**
         * There are two cases to be considered:
         *
         * - Given key is a complete path and don;t have nested childs.
         * - It have them.
         *
         * So, what we are going to do, is try do delete first.
         * If we succeed we just break the flow. Otherwise we will
         * carry on with nested keys/paths.
         */
        if(true === $this->getHash()->remove($key))
        {
            return true;
        }

        list($cursor, $paths) =
            $this->getHash()->fields($this->getPattern($key));

        $fields = array_keys($paths);

        return $this->getHash()->mremove($fields);
    }

    /**
     * Sets given path value
     *
     * @param  string     $key
     * @param  mixed      $value
     */
    public function set($key, $value)
    {
        return $this->getHash()->set($key, $value);
    }
}
