<?php

namespace Wtk\Settings\Provider;

use Wtk\Settings\Provider\ProviderInterface;

/**
 * Blackhole stores data nowhere ;)
 *
 * @author Wojtek Zalewski <wojtek@neverbland.com>
 */
class Blackhole implements ProviderInterface
{
    public function set($key, $value)
    {
        return true;
    }

    public function get($key, $default = null)
    {
        return false;
    }

    public function remove($key)
    {
        return true;
    }

    public function getNamespace()
    {
        return 'blackhole';
    }
}
