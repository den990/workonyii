<?php

class CurrencyExchange
{
    private array $courses = [];

    public function setExchangeRate(string $from, string $to, float $course): void {
        $this->courses[$from][$to] = $course;
        $this->courses[$to][$from] = 1 / $course;
    }

    public function getExchangeRate(string $from, string $to): float {
        if (isset($this->courses[$from]) && isset($this->courses[$from][$to]))
            return $this->courses[$from][$to];
        if ($from == $to)
            return 1;
        throw new Exception('Not found');
    }
}