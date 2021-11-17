<?php

namespace App\Enum;

use App\Models\User;
use BenSampo\Enum\Enum;
use Illuminate\Database\Eloquent\Relations\Relation;

class ActorType extends Enum
{
    public const USER = 'user';

    public static function morphMap()
    {
        Relation::morphMap([
            self::USER => User::class,
        ]);
    }
}
