<?php

class CurrencyAccount
{
    private array $balances = [];
    private string $baseCurrency;
    private CurrencyExchange $exchange;

    public function __construct(string $baseCurrency, CurrencyExchange $exchange) {
        $this->baseCurrency = $baseCurrency;
        $this->exchange = $exchange;
        $this->balances[$baseCurrency] = 0;
    }

    public function addCurrency(string $currency): void {
        if (!isset($this->balances[$currency])) {
            $this->balances[$currency] = 0;
        }
    }

    public function setBaseCurrency(string $currency): void {
        $this->baseCurrency = $currency;
    }

    public function deposit(string $currency, float $amount): void {
        if (!isset($this->balances[$currency])) {
            throw new Exception("Currency not supported.");
        }
        $this->balances[$currency] += $amount;
    }

    public function withdraw(string $currency, float $amount): void {
        if (!isset($this->balances[$currency]) || $this->balances[$currency] < $amount) {
            throw new Exception("Insufficient funds or currency not supported.");
        }
        $this->balances[$currency] -= $amount;
    }

    public function getBalance(string $currency = null): float {
        $currency = $currency ?? $this->baseCurrency;
        $total = 0;
        foreach ($this->balances as $curr => $amount) {
            $total += $amount * $this->exchange->getExchangeRate($curr, $currency);
        }
        return $total;
    }

    public function getAllCurrencies(): array {
        return array_keys($this->balances);
    }

    public function removeCurrency(string $currency): void {
        if ($currency === $this->baseCurrency) {
            throw new Exception("Cannot remove the base currency.");
        }

        if (!isset($this->balances[$currency])) {
            throw new Exception("Currency not supported.");
        }

        $amount = $this->balances[$currency];
        unset($this->balances[$currency]);


        if ($amount > 0) {
            $convertedAmount = $amount * $this->exchange->getExchangeRate($currency, $this->baseCurrency);
            $this->balances[$this->baseCurrency] += $convertedAmount;
        }
    }
}