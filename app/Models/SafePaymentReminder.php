<?php

namespace App\Models;


class SafePaymentReminder extends AbstractModel
{
    protected $table = 'safe_payment_reminders';

    protected $fillable = [
        'transactionable_id',
        'day_diff',
    ];
}
