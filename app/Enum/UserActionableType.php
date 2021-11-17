<?php


namespace App\Enum;

use BenSampo\Enum\Enum;

final class UserActionableType extends Enum
{
    const ENTITY_STORE   = 1;
    const ENTITY_PRODUCT = 2;
    const ENTITY_USER    = 3;

    const ACTION_USER_LIKE   = 0;
    const ACTION_USER_FOLLOW = 1;

    /*
     * User action for increase of decrease battery point
     * */
    const USER_REVIEW_STORE = 'USER_REVIEW_STORE';
    const USER_SIGN_UP = 'USER_SIGN_UP';
    const USER_REVIEW_TRANSACTION = 'USER_REVIEW_TRANSACTION';
    const GOOD_REPLY_MESSAGE = 'GOOD_REPLY_MESSAGE';
    const OFFENSIVE_WORD = 'OFFENSIVE_WORD';
    const USER_WAS_REPORTED = 'USER_WAS_REPORTED';
    const USER_WAS_REPORTED_5_TIME_IN_A_ROW = 'USER_WAS_REPORTED_5_TIME_IN_A_ROW';
    const PRODUCT_OF_USER_WAS_REPORTED = 'PRODUCT_OF_USER_WAS_REPORTED';
    const LOCALINFO_OF_USER_WAS_REPORTED = 'LOCALINFO_OF_USER_WAS_REPORTED';
    const USER_WAS_REPORTED_THROTTLE = 'USER_WAS_REPORTED_THROTTLE'; // 5 time
    const REVIEW_OF_USER_WAS_REPORTED = 'REVIEW_OF_USER_WAS_REPORTED';

    /* Reward when user complete a mission*/
    const BATTERY_UP_TO_LEVEL_5_WITHIN_100_DAY = 'BATTERY_UP_TO_LEVEL_5_WITHIN_100_DAY';
    const REVIEW_TRANSACTION_100_TIME = 'REVIEW_TRANSACTION_100_TIME';
    const PURCHASE_OLD_PHONE_50_TIME = 'PURCHASE_OLD_PHONE_50_TIME';
    const PURCHASE_NEW_PHONE_30_TIME = 'PURCHASE_NEW_PHONE_30_TIME';
    const WRITE_100_COMMENT_OR_100_LOCAL_POST = 'WRITE_100_COMMENT_OR_100_LOCAL_POST';
    const REGISTER_100_PRODUCT = 'REGISTER_100_PRODUCT';
    const HAVE_10_FOLLOWER = 'HAVE_10_FOLLOWER';
    const HAVE_100_FOLLOWER = 'HAVE_100_FOLLOWER';
    const USED_APP_1_YEAR = 'USED_APP_1_YEAR';
    const FOLLOW_10_PERSON = 'FOLLOW_10_PERSON';
    const REPORT_50_PERSON = 'REPORT_50_PERSON';
    const REVIEW_SELLER_100_TIME = 'REVIEW_SELLER_100_TIME';

    const USER_BATTERY = [
        self::USER_REVIEW_STORE => 25,
        self::USER_SIGN_UP => 600,
        self::USER_REVIEW_TRANSACTION => 25,
        self::GOOD_REPLY_MESSAGE => 10,
        self::OFFENSIVE_WORD => -20,
        self::USER_WAS_REPORTED => -10,
        self::PRODUCT_OF_USER_WAS_REPORTED => -10,
        self::LOCALINFO_OF_USER_WAS_REPORTED => -10,
        self::REVIEW_OF_USER_WAS_REPORTED => -20,
        self::BATTERY_UP_TO_LEVEL_5_WITHIN_100_DAY => 100,
        self::REVIEW_TRANSACTION_100_TIME => 10,
        self::PURCHASE_OLD_PHONE_50_TIME => 50,
        self::PURCHASE_NEW_PHONE_30_TIME => 50,
        self::WRITE_100_COMMENT_OR_100_LOCAL_POST => 20,
        self::REGISTER_100_PRODUCT => 30,
        self::HAVE_10_FOLLOWER => 30,
        self::HAVE_100_FOLLOWER => 20,
        self::USED_APP_1_YEAR => 100,
        self::FOLLOW_10_PERSON => 50,
        self::REPORT_50_PERSON => 50,
        self::REVIEW_SELLER_100_TIME => 50,
        self::USER_WAS_REPORTED_5_TIME_IN_A_ROW => 0,
    ];

    /**
     * @return int[]
     */
    public static function getActionType(): array
    {
        return [
            self::ACTION_USER_LIKE,
            self::ACTION_USER_FOLLOW
        ];
    }

    /**
     * @return int[]
     */
    public static function getType(): array
    {
        return [
            self::ENTITY_STORE,
            self::ENTITY_PRODUCT,
            self::ENTITY_USER
        ];
    }
}
