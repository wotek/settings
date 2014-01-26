<?php

namespace Wtk\Settings\Provider;

use Wtk\Settings\Storage\StorageInterface;

/**
 * StorageAware Provider interface.
 *
 * @author Wojtek Zalewski <wojtek@neverbland.com>
 */
interface StorageAwareProviderInterface
{
    /**
     *
     * @param  StorageInterface $storage
     */
    function __construct(StorageInterface $storage);
}
