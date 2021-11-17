<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * \App\Models\UserDeliveryAddress
 *
 * @property int $id
 * @property int $user_id
 * @property string $recipient_name
 * @property string $recipient_phone
 * @property bool $is_default
 * @property bool $address
 * @property bool $note
 * @property string $post_code
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
class UserDeliveryAddress extends AbstractModel
{
    const MAX_ADDRESS = 5;

    protected $table = 'user_delivery_address';

    protected $fillable = [
        'user_id',
        'recipient_name',
        'recipient_phone',
        'is_default',
        'post_code',
        'address',
        'address_detail',
        'note'
    ];
}
