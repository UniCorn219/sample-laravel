<?php


namespace App\Enum;


use BenSampo\Enum\Enum;

class NotificationAction extends Enum
{
    const REVIEW_COMPLETE_TRANSACTION = 1;
    const REVIEW_TRANSACTION          = 1;
    const REVIEW_STORE                = 2;
    // User
    const FOLLOW_USER = 3;
    // Product
    const PRODUCT_PUSH_TO_TOP = 4;
    const LIKE_PRODUCT        = 5;
    const MATCH_KEYWORD       = 14;
    const PRODUCT_CHANGED     = 26;
    // LocalPost
    const LIKE_LOCAL_POST          = 6;
    const LIKE_COMMENT_LOCAL_POST  = 7;
    const REPLY_COMMENT_LOCAL_POST = 8;
    const COMMENT_LOCAL_POST       = 9;
    // LocalInfo
    const LIKE_LOCAL_INFO          = 10;
    const LIKE_COMMENT_LOCAL_INFO  = 11;
    const REPLY_COMMENT_LOCAL_INFO = 12;
    const COMMENT_LOCAL_INFO       = 13;
    // Chat
    const CREATE_MESSAGE_IN_USER_AND_USER             = 15;
    const CREATE_MESSAGE_IN_USER_AND_USER_HAS_PRODUCT = 16;
    const CREATE_MESSAGE_IN_USER_AND_STORE            = 17;
    const CREATE_RESERVATION                          = 18;
    const DELETE_RESERVATION                          = 19;
    const UPDATE_RESERVATION                          = 20;
    const REMINDER_RESERVATION                        = 21;
    // Battery level up
    const BATTERY_LEVEL_UP = 22;
    // Done mission
    const DONE_MISSION = 23;
    // Invite new member
    const INVITE_MEMBER   = 24;
    const INVITE_9_MEMBER = 25;
    // Safe payment
    const BUYER_BUY_PRODUCT        = 27;
    const BUYER_CANCEL_PRODUCT     = 28;
    const SELLER_ACCEPT            = 29;
    const SELLER_REJECT            = 30;
    const SELLER_ADD_LOGISTICS     = 31;
    const BUYER_COMPLETE_PRODUCT   = 32;
    const REMINDER_SELLER          = 33;
    const AUTO_CANCEL_PRODUCT      = 34;
}
