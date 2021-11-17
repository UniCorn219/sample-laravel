<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * \App\Models\UserSetting
 *
 * @property int $id
 * @property int $user_id
 * @property bool $active_time
 * @property string $active_time_start
 * @property string $active_time_end
 * @property bool $allow_search_engine
 * @property bool $allow_alert_message
 * @property bool $allow_alert_marketing
 * @property bool $allow_suggest_keyword
 * @property bool $disturb_setting
 * @property bool $chat_alert
 * @property bool $keyword_alert
 * @property bool $activity_alert
 * @property bool $transaction_alert
 * @property bool $marketing_alert
 * @property string $disturb_start_time
 * @property string $disturb_end_time
 * @property string $language
 * @property string|null $deleted_at
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
class UserSetting extends AbstractModel
{
    use SoftDeletes;

    protected $table = 'user_settings';

    protected $fillable = [
        'user_id',
        'active_time',
        'active_time_start',
        'active_time_end',
        'allow_search_engine',
        'allow_alert_message',
        'allow_alert_marketing',
        'allow_suggest_keyword',
        'disturb_setting',
        'disturb_start_time',
        'disturb_end_time',
        'chat_alert',
        'keyword_alert',
        'activity_alert',
        'transaction_alert',
        'marketing_alert',
        'language',
    ];
}
