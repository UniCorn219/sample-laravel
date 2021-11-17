<?php

namespace App\ValueObjects;

use JetBrains\PhpStorm\Pure;
use JsonSerializable;

class Amount implements JsonSerializable
{
    private string $amount;
    private int $scale = 2;

    public function __construct(int|float|string $amount)
    {
        $this->amount = (string)$amount;
    }

    #[Pure]
    public static function create(int|float|string $amount): Amount
    {
        return new self($amount);
    }

    public function amount(): string
    {
        return $this->amount;
    }

    public function jsonSerialize()
    {
        return $this->amount;
    }

    public function add(mixed $amount)
    {
        $this->bcmath('bcadd', $amount);
    }

    public function sub(mixed $amount)
    {
        $this->bcmath('bcsub', $amount);
    }

    public function multiply(mixed $amount)
    {
        $this->bcmath('bcmul', $amount);
    }

    public function divide(mixed $amount)
    {
        $this->bcmath('bcdiv', $amount);
    }

    protected function bcmath(callable $callback, mixed $amount)
    {
        if ($amount instanceof Amount) {
            $amount = $amount->amount();
        }

        $this->amount = call_user_func($callback, $this->amount, (string)$amount, $this->scale);
    }
}
