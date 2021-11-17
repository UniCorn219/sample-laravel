<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * \App\Models\UserBankAccount
 *
 * @property int $id
 * @property int $user_id
 * @property string $bank_name
 * @property string $account_holder
 * @property int $account_number
 * @property bool $is_default
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|UserSetting newModelQuery()
 * @method static Builder|UserSetting newQuery()
 * @method static Builder|UserSetting query()
 * @method static Builder|UserSetting whereActiveTime($value)
 * @method static Builder|UserSetting whereActiveTimeEnd($value)
 * @method static Builder|UserSetting whereActiveTimeStart($value)
 * @method static Builder|UserSetting whereAllowAlertMarketing($value)
 * @method static Builder|UserSetting whereAllowAlertMessage($value)
 * @method static Builder|UserSetting whereAllowSearchEngine($value)
 * @method static Builder|UserSetting whereCreatedAt($value)
 * @method static Builder|UserSetting whereDeletedAt($value)
 * @method static Builder|UserSetting whereId($value)
 * @method static Builder|UserSetting whereLanguage($value)
 * @method static Builder|UserSetting whereUpdatedAt($value)
 * @method static Builder|UserSetting whereUserId($value)
 * @mixin Eloquent
 */
class UserBankAccount extends AbstractModel
{
    const MAX_INFO = 3;

    protected $table = 'user_bank_accounts';

    protected $fillable = [
        'user_id',
        'bank_name',
        'account_holder',
        'account_number',
        'is_default'
    ];
}
