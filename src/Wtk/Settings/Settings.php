<?php

namespace Wtk\Settings;

use Wtk\Settings\SettingsInterface;
use Wtk\Settings\Resolver\PathResolverTrait;

/**
 *
 * @todo: CachedSettings and DebugCachedSettings
 *
 * @author Wojtek Zalewski <wojtek@neverbland.com>
 */
class Settings extends ProvidersAwareSettings implements SettingsInterface
{
    /**
     * Trait provides support for settings path resolver.
     * Used to select proper namespace settings provider.
     *
     * If not re-used anywhere anytime soon should be pulled back in here.
     */
    use PathResolverTrait;

    /**
     * Returns value of the called key.
     * If key does not exists in one of registered provider,
     * will return default.
     *
     * It should be possible to return values using just prefix.
     *
     * Ie:
     *     params.db.foo = 1
     *     params.db.bar = 2
     *
     *     get('params.db') -> array('foo' => 1, 'bar' => 2)
     *     get('params') -> array('db' => array('foo' => 1, 'bar' => 2))
     *
     * @param string $name              Path to the the setting.
     * @param string $default[optional] Default value if not found
     *
     * @return mixed
     */
    public function get($key, $default = null)
    {
        $provider = $this->resolve($key);

        return $provider->get($key, $default);
    }

    /**
     * Resolves path's to namespace and returns proper Provider
     * for it. If not found it should fallback to default one.
     *
     * @param  string     $key
     *
     * @return ProviderInterface
     */
    private function resolve($key)
    {
        list($namespace, $path) = $this->getResolver()->resolve($key);

        return $this->getProvider($namespace);
    }

    /**
     * Sets the setting with the given value.
     *
     * If the setting doesn't exist then it will create and persist it.
     *
     * @param string $name          Path to the setting.
     * @param mixed  $value         Value to be set.
     */
    public function set($key, $value)
    {
        $provider = $this->resolve($key);

        //
        // Namespace is used just to point to the right provider
        // and validate it's existence.
        //
        // Path should contain given namespace because we want
        // to re-use default database provider amongst bundles.
        // And don't want them when pulling out all settings keys values
        // from given provider, to return other bundle key's.
        //

        $state = $provider->set($key, $value);

        if(false === $state)
        {
            //
            // This is sth to be discussed. Do we want it to fail?
            // Or just remove conflicted paths?
            //
            // @author Wojtek Zalewski <wojtek@neverbland.com>
            //
            throw new \InvalidArgumentException(sprintf(
                "Invalid key given. Given path exists (%s) and have nested keys'. \nRemove it before and try to set it up again.",
                $key
            ));
        }

        return true;
    }

    /**
     * Removes key and it childs if found
     *
     * @param  string     $key
     *
     * @return bool
     */
    public function remove($key)
    {
        $provider = $this->resolve($key);

        return $provider->remove($key);
    }

}
