<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * \App\Models\TransferBank
 *
 * @property int $id
 * @property string $name
 * @property string $account_number
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|TransferBank newModelQuery()
 * @method static Builder|TransferBank newQuery()
 * @method static Builder|TransferBank query()
 * @method static Builder|TransferBank whereAccountNumber($value)
 * @method static Builder|TransferBank whereCreatedAt($value)
 * @method static Builder|TransferBank whereId($value)
 * @method static Builder|TransferBank whereName($value)
 * @method static Builder|TransferBank whereUpdatedAt($value)
 * @mixin Eloquent
 */
class TransferBank extends AbstractModel
{
    protected $table = 'transfer_banks';

    protected $fillable = [
        'name',
        'account_number',
    ];
}
