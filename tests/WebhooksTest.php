<?php
/**
 * User: erick.antunes
 * Date: 18/10/2018
 * Time: 11:55
 */

namespace Paggcerto\Tests;

use Paggcerto\Auth\Auth;
use Paggcerto\Paggcerto;

class WebhooksTest extends TestCase
{
    public function testShouldCreate()
    {
        $paggcerto = new Paggcerto(new Auth("sandbox-php@paggcerto.com.br", "95625845"));

        $url = "http://www.paggcerto.com.br";
        $events = ["PAYMENTS.CREATED", "PAYMENTS.CANCELLED"];

        $webhookResult = $paggcerto->webhooksManagement()
            ->setUrl($url)
            ->setEvents($events)
            ->create();

        $this->assertEquals($url, $webhookResult->url);
        $this->assertEquals($events[0], $webhookResult->events[0]);
        $this->assertEquals($events[1], $webhookResult->events[1]);
        $this->assertNotNull($webhookResult->links);

        return $webhookResult;
    }

    public function testShouldList()
    {
        $paggcerto = new Paggcerto(new Auth("sandbox-php@paggcerto.com.br", "95625845"));

        $webhooksListResult = $paggcerto->webhooksManagement()
            ->setUrls(["http://www.paggcerto.com.br"])
            ->setEvents(["PAYMENTS.CANCELLED"])
            ->setIndex(0)
            ->setLength(50)
            ->wehooksList();

        $this->assertNotNull($webhooksListResult);
        $this->assertEquals("http://www.paggcerto.com.br", $webhooksListResult->webHooks[0]->url);
        $this->assertEquals("PAYMENTS.CANCELLED", $webhooksListResult->webHooks[0]->events[1]);
        $this->assertEquals(1, $webhooksListResult->count);
    }

    /**
     * @depends testShouldCreate
     * @param $webhook
     */
    public function testShouldFind($webhook)
    {
        $paggcerto = new Paggcerto(new Auth("sandbox-php@paggcerto.com.br", "95625845"));

        $webhookResult = $paggcerto->webhooksManagement()
            ->setId($webhook->id)
            ->find();

        $this->assertEquals($webhook->url, $webhookResult->url);
        $this->assertEquals($webhook->events[0], $webhookResult->events[0]);
        $this->assertEquals($webhook->events[1], $webhookResult->events[1]);
        $this->assertNotNull($webhookResult->links);
    }

    /**
     * @depends testShouldCreate
     * @param $webhook
     */
    public function testShouldUpdate($webhook)
    {
        $paggcerto = new Paggcerto(new Auth("sandbox-php@paggcerto.com.br", "95625845"));

        $webhookResult = $paggcerto->webhooksManagement()
            ->setId($webhook->id)
            ->setUrl("http://www.google.com")
			->setEvents(["PAYMENTS.CANCELLED"])
            ->update();

        $this->assertEquals("http://www.google.com", $webhookResult->url);
        $this->assertEquals($webhook->events[1], $webhookResult->events[0]);
        $this->assertNotNull($webhookResult->links);
    }

    /**
     * @depends testShouldCreate
     * @param $webhook
     */
    public function testShouldDelete($webhook)
    {
        $paggcerto = new Paggcerto(new Auth("sandbox-php@paggcerto.com.br", "95625845"));

        $webhookResult = $paggcerto->webhooksManagement()
            ->setId($webhook->id)
            ->delete();

        $this->assertEquals("http://www.google.com", $webhookResult->url);
        $this->assertEquals($webhook->events[1], $webhookResult->events[0]);
        $this->assertNotNull($webhookResult->links);
    }
}