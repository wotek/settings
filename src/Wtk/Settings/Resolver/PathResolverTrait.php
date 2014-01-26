<?php

namespace Wtk\Settings\Resolver;

use Wtk\Settings\Resolver\ResolverInterface;

trait PathResolverTrait
{
    /**
     * Settings path's resolver
     *
     * @var ResolverInterface
     */
    protected $resolver;

    /**
     * Sets settings path resolver
     *
     * @param  ResolverInterface $resolver
     */
    public function setResolver(ResolverInterface $resolver)
    {
        $this->resolver = $resolver;
    }

    /**
     * Returns resolver for settings names
     *
     * @return ResolverInterface
     */
    protected function getResolver()
    {
        if(null === $this->resolver)
        {
            throw new \RuntimeException(
                "No default settings path resolver found."
            );
        }

        return $this->resolver;
    }
}
