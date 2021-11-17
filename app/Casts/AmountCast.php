<?php

namespace App\Casts;

use App\ValueObjects\Amount;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use JetBrains\PhpStorm\Pure;

class AmountCast implements CastsAttributes
{
    #[Pure]
    public function get($model, string $key, $value, array $attributes): Amount
    {
        return new Amount((int)$value);
    }

    #[Pure]
    public function set($model, string $key, $value, array $attributes)
    {
        if (!$value instanceof Amount) {
            $value = Amount::create((string)$value);
        }

        return $value->amount();
    }
}
