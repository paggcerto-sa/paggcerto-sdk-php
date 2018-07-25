<?php

namespace Paggcerto\Tests;

use Paggcerto\Paggcerto;

class PaggcertoTest extends TestCase
{
    public function testProvisore()
    {
        $this->assertEquals("https://account.sandbox.paggcerto.com.br/", Paggcerto::ACCOUNT_ENDPOINT_SANBOX);
    }
}
