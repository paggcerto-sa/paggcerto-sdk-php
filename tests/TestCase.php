<?php

namespace Paggcerto\Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    const sandbox = "sandbox";

    protected $paggcerto;
    protected $date_format = "Y-m-d";
    protected $date_string = "1988-04-06";

}
