<?php

namespace Wtk\Settings\Provider;

use Wtk\Settings\Provider\ProviderInterface;
use Wtk\Settings\ArrayUtils;

class PredefinedProvider implements ProviderInterface
{
    /**
     * Predefined values
     *
     * @var array
     */
    protected $values = array('predefined' => array(
        //
        // Here we are going to have predefined values
        // Hardcoded array since there is no global redis set up.
        //
        // When application cluster will be ready, we will switch it over
        // to redis storage
        //
        'vimeo' => array(
            'consumer_key' => 'key',
            'consumer_secret' => 'secret',
        ),
        'twitter' => array(
            'consumer_key' => 'key',
            'consumer_secret' => 'secret',
        ),
        // ... etc
    ));

    public function __construct(array $values = array())
    {
        if(0 < count($values))
        {
            $this->values = $values;
        }
    }

    public function set($key, $value)
    {
        throw new \RuntimeException(
            "This is just read only provider."
        );
    }

    public function get($key, $default = null)
    {
        return ArrayUtils::get($this->values, $key, $default);
    }

    public function remove($key)
    {
        throw new \RuntimeException(
            "This is just read only provider."
        );
    }

    public function getNamespace()
    {
        return 'predefined';
    }
}
