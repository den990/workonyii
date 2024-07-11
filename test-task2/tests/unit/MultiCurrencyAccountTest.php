<?php

use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../../src/CurrencyAccount.php';
require_once __DIR__ . '/../../src/CurrencyExchange.php';

class MultiCurrencyAccountTest extends TestCase
{
    private CurrencyAccount $account;
    private CurrencyExchange $exchange;

    protected function setUp(): void {
        $this->exchange = new CurrencyExchange();
        $this->exchange->setExchangeRate('EUR', 'RUB', 80);
        $this->exchange->setExchangeRate('USD', 'RUB', 70);
        $this->exchange->setExchangeRate('EUR', 'USD', 1);
        $this->account = new CurrencyAccount('RUB', $this->exchange);
        $this->account->addCurrency('EUR');
        $this->account->addCurrency('USD');
    }

    //тесты из примера
    public function testTestCasesOnSite() {
        $this->account->deposit('RUB', 1000);
        $this->account->deposit('EUR', 50);
        $this->account->deposit('USD', 40);

        $this->assertEquals(['RUB', 'EUR', 'USD'], $this->account->getAllCurrencies());

        $this->assertEquals(7800, $this->account->getBalance());
        $this->assertEquals(102.5, $this->account->getBalance('EUR'));
        $this->assertEquals(104.29, round($this->account->getBalance('USD'), 2));

        $this->exchange->setExchangeRate('EUR', 'RUB', 150);
        $this->exchange->setExchangeRate('USD', 'RUB', 100);
        $this->assertEquals(12500, $this->account->getBalance());

        $this->account->setBaseCurrency('EUR');
        $this->assertEquals(96.67, round($this->account->getBalance(), 2));

        $this->account->withdraw('RUB', 1000);
        $this->assertEquals(90, $this->account->getBalance());

        $this->exchange->setExchangeRate('EUR', 'RUB', 120);
        $this->assertEquals(90, $this->account->getBalance());

        $this->account->setBaseCurrency('RUB');

        $this->account->removeCurrency('EUR');
        $this->account->removeCurrency('USD');
        $this->assertEquals(10000, $this->account->getBalance());

        $this->assertEquals(['RUB'], $this->account->getAllCurrencies());
    }


    public function testWithdraw() {
        $this->account->deposit('USD', 40);
        $this->account->withdraw('USD', 10);
        $this->assertEquals(30, $this->account->getBalance('USD'));

        $this->expectException(Exception::class);
        $this->account->withdraw('USD', 50);
    }


    public function testGetAllCurrency()
    {
        $this->assertEquals(['RUB', 'EUR', 'USD'], $this->account->getAllCurrencies());
    }

    public function testSetBaseCurrency()
    {
        $this->account->deposit('RUB', 1000);
        $this->account->deposit('EUR', 50);
        $this->account->deposit('USD', 40);

        $this->account->setBaseCurrency('EUR');
        $this->assertEquals(102.5, $this->account->getBalance());
    }

    public function testDeleteDefaultCurrency()
    {
        $this->expectException(Exception::class);
        $this->account->removeCurrency('RUB');
    }

    public function testDeleteCurrency()
    {
        $this->account->removeCurrency('EUR');
        $this->assertEquals(['RUB', 'USD'], $this->account->getAllCurrencies());
    }

    public function testChangeCurrency()
    {
        $this->account->deposit('RUB', 1000);
        $this->account->deposit('EUR', 50);
        $this->account->deposit('USD', 40);

        $this->exchange->setExchangeRate('EUR', 'RUB', 500);
        $this->assertEquals(28800, $this->account->getBalance());
    }

    public function testGetExchange()
    {
        $this->assertEquals(0.014, round($this->exchange->getExchangeRate('RUB', 'USD'), 3));
    }

    public function testBadGetExchange()
    {
        $this->expectException(Exception::class);
        $this->exchange->getExchangeRate('RUB', 'USDGD');
    }
}