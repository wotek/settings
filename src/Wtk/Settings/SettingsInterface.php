<?php

namespace Wtk\Settings;

interface SettingsInterface
{
    /**
     * Returns given settings key name
     *
     * @param string $name Name of the setting.
     * @param string $default[optional] Default value.
     * @return mixed
     */
    function get($key, $default = null);

    /**
     * Sets given key value
     *
     * @param string $name Name of the setting.
     * @param mixed $value Value to be set.
     */
    function set($key, $value);

    /**
     * Removes key
     *
     * @param  string     $key
     *
     * @return bool
     */
    function remove($key);
}
