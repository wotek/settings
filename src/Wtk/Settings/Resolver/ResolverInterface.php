<?php
namespace Wtk\Settings\Resolver;

interface ResolverInterface
{
    /**
     * Resolves given path string to an array of:
     * array(NAMESPACE, PATH, ...)
     *
     * @param  string     $path
     *
     * @return array
     */
    function resolve($path);
}
