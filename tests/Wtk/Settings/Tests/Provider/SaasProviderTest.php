<?php

namespace Wtk\Settings\Tests\Provider;

use Wtk\Settings\Tests\SettingsTestCase;

use Wtk\Settings\Provider\SaasProvider;

class SaasProviderTest extends SettingsTestCase
{
    public function testNamespace()
    {
        $provider = new SaasProvider($this->getStorageMock());

        $this->assertSame('saas', $provider->getNamespace());
    }

}
