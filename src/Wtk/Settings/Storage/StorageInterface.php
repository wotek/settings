<?php
namespace Wtk\Settings\Storage;

/**
 * Interface which can be used when implementing settings storage
 * engine.
 *
 * @author Wojtek Zalewski <wojtek@neverbland.com>
 */
interface StorageInterface
{
    /**
     * Fetches storage for key
     *
     * @param  string     $key
     *
     * @return mixed
     */
    function get($key);

    /**
     * Sets key value
     *
     * @param  string     $key
     * @param  mixed      $value
     *
     * @return bool
     */
    function set($key, $value);

    /**
     *
     * @param  string     $key
     *
     * @return void
     */
    function remove($key);
}
