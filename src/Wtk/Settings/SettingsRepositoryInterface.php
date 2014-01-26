<?php

namespace Wtk\Settings;

interface SettingsRepositoryInterface
{
    function get($key);

    function remove($key);

    function set($key, $value);
}
