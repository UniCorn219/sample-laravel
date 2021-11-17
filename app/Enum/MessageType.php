<?php

namespace App\Enum;

use BenSampo\Enum\Enum;

class MessageType extends Enum
{
    const TEXT                  = 'text';
    const IMAGE                 = 'image';
    const LOCATION              = 'location';
    const STICKER               = 'sticker';
    const RESERVATION           = 'reservation';
    const SHIPPING_ADDRESS      = 'shipping_address';
    const BANK_ACCOUNT          = 'bank_account';
    const PAYCOIN               = 'paycoin';
    const SYSTEM                = 'system';
    const SYSTEM_CANCEL_PAYMENT = 'system_cancel_payment';

    const USER_PAYED             = 'user_payed';
    const SELLER_REJECT_PAYMENT  = 'seller_reject_payment';
    const SELLER_APPROVE_PAYMENT = 'seller_approve_payment';
    const SHIPPING_COMPANY       = 'shipping_company';
    const ORDER_RECEIVED         = 'order_received';

    const REVIEW = 'review';
    const REVIEWED = 'reviewed';

    const USER_CANCEL_PAYMENT = 'user_cancel_payment';

    const RESERVATION_SUCCESS  = 'reservation_success';
    const RESERVATION_CANCELED = 'reservation_canceled';
    const RESERVATION_UPDATED  = 'reservation_updated';

    /**
     * Get all message types.
     *
     * @return array
     */
    public static function getMessageTypes(): array
    {
        return [
            self::TEXT,
            self::IMAGE,
            self::LOCATION,
            self::RESERVATION,
            self::STICKER,
            self::SYSTEM
        ];
    }

    /**
     * Get valid message types.
     *
     * @return array
     */
    public static function getValidTypes(): array
    {
        return [
            self::TEXT,
            self::IMAGE,
            self::LOCATION,
            self::STICKER,
            self::RESERVATION,
            self::SHIPPING_ADDRESS,
            self::BANK_ACCOUNT,
            self::SHIPPING_COMPANY
        ];
    }

    /***
     * Get reservation state.
     *
     * @return array
     */
    public static function getReservationState(): array
    {
        return [
            self::RESERVATION_SUCCESS,
            self::RESERVATION_UPDATED,
            self::RESERVATION_CANCELED,
        ];
    }
}
