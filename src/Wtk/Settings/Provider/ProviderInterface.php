<?php

namespace Wtk\Settings\Provider;

/**
 * Interface for settings provider classes.
 *
 * @author Wojtek Zalewski <wojtek@neverbland.com>
 */
interface ProviderInterface
{
    /**
     * Returns value of the called key.
     * If key does not exists in one of registered provider,
     * will return default.
     *
     * @param string $name Name of the setting.
     * @param string $default[optional] Default value.
     *
     * @return mixed
     */
    function get($key, $default = null);

    /**
     * Sets the setting with the given value.
     * If the setting doesn't exist then it will create and persist it.
     *
     * @param string $name Name of the setting.
     * @param mixed $value Value to be set.
     *
     * @return bool Return state of write attempt. False when failed.
     */
    function set($key, $value);

    /**
     * Removes given settings key
     *
     * @param  string     $key
     *
     * @return bool
     */
    function remove($key);

    /**
     * Returns given provider's supported namespace
     *
     * @return string
     */
    function getNamespace();
}
