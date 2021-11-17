<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * \App\Models\OTPToken
 *
 * @property int $id
 * @property int $user_id
 * @property int $type
 * @property string $token
 * @property int $validity
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|OTPToken newModelQuery()
 * @method static Builder|OTPToken newQuery()
 * @method static Builder|OTPToken query()
 * @method static Builder|OTPToken whereCreatedAt($value)
 * @method static Builder|OTPToken whereId($value)
 * @method static Builder|OTPToken whereToken($value)
 * @method static Builder|OTPToken whereType($value)
 * @method static Builder|OTPToken whereUpdatedAt($value)
 * @method static Builder|OTPToken whereUserId($value)
 * @method static Builder|OTPToken whereValidity($value)
 * @mixin Eloquent
 */
class OTPToken extends AbstractModel
{
    protected $table = 'otp_tokens';

    protected $fillable = [
        'user_id',
        'token',
        'type',
        'validity',
    ];
}
