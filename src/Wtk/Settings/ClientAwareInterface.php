<?php

namespace Wtk\Settings;

interface ClientAwareInterface
{
    /**
     * Returns current instance client id
     *
     * @return string
     */
    function getClientId();

    /**
     * Set current client id
     *
     * @param  string     $client_id
     */
    function setClientId($client_id);
}
