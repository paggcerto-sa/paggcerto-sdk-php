<?php

namespace Paggcerto\Tests;

use Paggcerto\Paggcerto;

class PaggcertoTest extends TestCase
{
    public function testProvisore()
    {
        $this->assertEquals("http://account.sandbox.paggcerto.com.br/api/", Paggcerto::ACCOUNT_ENDPOINT_SANDBOX);
    }
}
