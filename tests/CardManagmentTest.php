<?php
/**
 * User: erick.antunes
 * Date: 03/10/2018
 * Time: 15:02
 */

namespace Paggcerto\Tests;


use Paggcerto\Auth\Auth;
use Paggcerto\Paggcerto;

class CardManagmentTest extends TestCase
{
    public function testShouldRegister()
    {
        $paggcerto = new Paggcerto(new Auth("sandbox-php@paggcerto.com.br", "95625845"));

        $card = $paggcerto->cardManagement()
            ->setHolderName("Maria das Graças")
            ->setNumber("4929915748910899")
            ->setExpirationMonth(12)
            ->setExpirationYear(2018)
            ->setSecurityCode("998")
            ->cardRegister();

        $this->assertEquals("492991******0899", $card->number);
        $this->assertEquals("Maria das Graças", $card->holderName);
        $this->assertEquals(12, $card->expirationMonth);
        $this->assertEquals(2018, $card->expirationYear);

        return $card;
    }

    public function testShouldList()
    {
        $paggcerto = new Paggcerto(new Auth("sandbox-php@paggcerto.com.br", "95625845"));

        $cards = $paggcerto->cardManagement()
            ->setBrands(["visa"])
            ->setFinals(["0899"])
            ->cardList();

        $this->assertGreaterThanOrEqual(0, count($cards));
    }

    /**
     * @depends testShouldRegister
     */
    public function testShouldFind($card)
    {
        $paggcerto = new Paggcerto(new Auth("sandbox-php@paggcerto.com.br", "95625845"));

        $card = $paggcerto->cardManagement()
            ->setCardId($card->id)
            ->cardFind();

        $this->assertEquals("492991******0899", $card->number);
        $this->assertEquals("Maria das Graças", $card->holderName);
        $this->assertEquals(12, $card->expirationMonth);
        $this->assertEquals(2018, $card->expirationYear);
    }

    /**
     * @depends testShouldRegister
     */
    public function testShouldDelete($card)
    {
        $paggcerto = new Paggcerto(new Auth("sandbox-php@paggcerto.com.br", "95625845"));

        $card = $paggcerto->cardManagement()
            ->setCardId($card->id)
            ->cardDelete();

        $this->assertEquals("492991******0899", $card->number);
        $this->assertEquals("Maria das Graças", $card->holderName);
        $this->assertEquals(12, $card->expirationMonth);
        $this->assertEquals(2018, $card->expirationYear);
    }
}