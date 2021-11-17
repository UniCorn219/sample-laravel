<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * \App\Models\OTPCodeLog
 *
 * @property int $id
 * @property int $user_id
 * @property int $type
 * @property int $status
 * @property string|null $code
 * @property string $token
 * @property Carbon|null $generated_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|OTPCodeLog newModelQuery()
 * @method static Builder|OTPCodeLog newQuery()
 * @method static Builder|OTPCodeLog query()
 * @method static Builder|OTPCodeLog whereCode($value)
 * @method static Builder|OTPCodeLog whereCreatedAt($value)
 * @method static Builder|OTPCodeLog whereGeneratedAt($value)
 * @method static Builder|OTPCodeLog whereId($value)
 * @method static Builder|OTPCodeLog whereStatus($value)
 * @method static Builder|OTPCodeLog whereToken($value)
 * @method static Builder|OTPCodeLog whereType($value)
 * @method static Builder|OTPCodeLog whereUpdatedAt($value)
 * @method static Builder|OTPCodeLog whereUserId($value)
 * @mixin Eloquent
 */
class OTPCodeLog extends AbstractModel
{
    protected $table = 'otp_code_logs';

    protected $fillable = [
        'user_id',
        'type',
        'status',
        'code',
        'token',
        'generated_at',
    ];

    protected $dates = ['generated_at'];
}
