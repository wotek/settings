<?php

namespace Wtk\Settings\Resolver;

use Wtk\Settings\Resolver\ResolverInterface;

/**
 * Resolves dot notation to array
 *
 * @author Wojtek Zalewski <wojtek@neverbland.com>
 */
class NamespacedItemResolver implements ResolverInterface
{
    const SEPARATOR = '.';

    /**
     * Idea is to be able to use this set of possible key names:
     *
     * ! This bit is prohibited:
     * name = value
     *
     * Shortest possible notation are:
     *
     * provider_namespace.name = value
     * bundle.name = value
     *
     * -- This bit will be tricky:
     * bundle.name = value
     * group.name = value
     * -- Other
     * bundle.group.name = value
     * bundle.group.group.name = value
     * bundle.group.group.group.name = value
     *
     * Resolver should return an array with:
     * array(NAMESPACE, PATH)
     *
     * @param  string     $path
     *
     * @return array
     */
    public function resolve($path)
    {
        $segments = explode(self::SEPARATOR, $path);
        /**
         * Just one segment.
         * Which means -> Namespace
         */
        if (count($segments) == 1)
        {
            return array($segments[0], null);
        }

        $path = implode(
            self::SEPARATOR,
            array_slice($segments, 1)
        );

        return array($segments[0], $path);
    }
}
