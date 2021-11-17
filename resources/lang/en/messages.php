<?php

/**
 *
 * Forum translation file.
 *
 */
return [
    'point' => [
        'info_setting' => 'points are at least :minPointUserP ~ maximum :maxPointUserP can be used up to'
    ],
    'user' => [
        'profile' => [
            'nickname' => [
                'have_been_use' => 'nickname have been use',
                'offensive'     => 'nickname is reject because  offensive'
            ]
        ],
    ],
    'password' => [
        'old_password_wrong' => 'old password wrong'
    ],
    'promotion' => [
        'cannot_accept' => 'can not accept promotion',
        'cannot_reject' => 'can not reject promotion',
    ],
    'product' => [
        'product_status_cannot_update_when_ordering' => 'Product status cannot update when ordering',
        'only_author_can_accept' => 'only author can accept',
        'only_author_can_reject' => 'only author can reject',
        'only_author_can_add_logistics' => 'only author can add logistics',
        'only_buyer_can_cancel' => 'only buyer can cancel payment',
        'only_buyer_can_complete' => 'only buyer can complete payment',
        'only_accept_when_status_ordering' => 'seller can only accept when product status is ordering',
        'only_reject_when_status_ordering' => 'seller can only reject when product status is ordering',
        'only_cancel_when_status_ordering' => 'buyer can only cancel when product status is ordering',
        'only_complete_when_status_ordering' => 'buyer can only complete when product status is ordering',
        'only_accept_when_order_status_processing' => 'seller can only accept when product transaction order status is processing',
        'only_reject_when_order_status_processing' => 'seller can only reject when product transaction order status is processing',
        'only_cancel_when_order_status_processing_or_accepted' => 'buyer can only cancel when product transaction order status is processing or accepted',
        'only_complete_when_order_status_sent_logistics' => 'buyer can only complete when product transaction order status is sent logistics',
        'only_add_logistics_when_status_ordering' => 'seller can only add logistics when product status ordering',
        'only_add_logistics_when_order_status_accepted' => 'seller can only add logistics when product transaction order status is accepted',
    ],
    'payment' => [
        'transfer_transaction_is_not_valid' => 'transfer transaction is not valid',
        'update_point_fail' => 'update point fail',
        'update_balance_token_fail' => 'update balance token fail',
        'point_not_enough_to_create_promotion' => 'point not enough to create promotion',
        'product_not_accept_payment_method' => 'product not accept payment method',
        'product_status_can_not_buy' => 'product status can not buy',
        'token_can_not_get_rate' => 'token can not get rate',
        'create_safe_payment_fail' => 'create safe payment fail',
        'cancel_wallet_payment_fail' => 'cancel wallet payment fail',
        'complete_wallet_payment_fail' => 'complete wallet payment fail',
        'balance_ftsy_not_enough' => 'Balance FTSY is not enough',
    ],
    'max_store_main_menu' => 'Max main menu is 3',
    'can_not_create_because_of_offensive' => 'Cannot create because of offensive content',
    'product_not_create_because_of_offensive' => 'Cannot create product, because of offensive content',
    'notification' => [
        'base_title' => 'o2o notification',
        'title_reservation' => 'o2o notification',
        'reservation' => 'o2o notification reservation content',
        'nickname' => ':nickname',
        'chatting' => [
            'text' => [
                'content' => ':nickname Sent a message'
            ],
            'system' => [
                'auto_cancel_payment' => 'auto cancel payment after three days'
            ],
            'sticker' => [
                'content' => ':nickname Sent a sticker'
            ],
            'image' => [
                'content' => ':nickname Sent a photo',
                'message_thread' => 'You sent a photo',
            ],
            'location' => [
                'content' => ':nickname Sent a location',
            ],
            'gif' => [
                'content' => ':nickname Sent a gift',
            ],
            'shipping_address' => [
                'content' => ':username You have entered a shipping address'
            ],
            'bank_account' => [
                'content' => ':username You have entered a shipping address'
            ],
            'reservation' => [
                'message_thread_create' => 'You have set up a reservation.',
                'title'  => 'Reservation',
                'create' => ':nickname Set a schedule with you',
                'update' => ':nickname Change a schedule with you',
                'delete' => ':nickname Cancel a schedule with you'
            ],
        ],
        'mission' => [
            'title' => "Congrats! You've got a badge",
            'content' => 'Check your reward now !!!'
        ],
        'introduce_member' => 'Congratulations! A friend just signed up with a shared link. Check out the rewards!!!',
        'review' => [
            'transaction' => 'Review after complete transaction',
            'store' => 'Review your store'
        ],
        'user' => [
            'follow_user' => 'Started following you',
            'invite_member_title' => 'Congrats! Your friend successfully register using your invitation link .',
            'invite_member_content' => 'Check your reward now!!!',
            'invite_9_member_title' => 'Congrats! you have completed friend referral mission',
            'invite_9_member_content' => 'Check your reward now!!!',
            'level_up_title' => 'Congrats!',
            'level_up_content' => 'You have just upgraded your level',
        ],
        'keyword' => [
            'title' => 'Keyword :keyword notifications',
        ],
        'product' => [
            'change_price' => [
                'title' => ':productName liked',
                'content' => 'Changed :productName price which you liked',
            ]
        ],
        'safe_payment' => [
            'buyer_buy_product' => [
                'title' => ':productName Payment finished',
                'content' => 'You paid for this product',
            ],
            'buyer_cancel_product' => [
                'title' => ':productName Cancel payment',
                'content' => 'You canceled the payment for this product',
            ],
            'seller_accept' => [
                'title' => ':productName Accepted',
                'content' => ':sellerName is preparing to ship',
            ],
            'seller_reject' => [
                'title' => ':productName Rejected',
                'content' => ':sellerName has canceled the sale. automatically refunded',
            ],
            'seller_add_logistics' => [
                'title' => ':productName Added invoice number',
                'content' => ':sellerName has delivered the invoice number',
            ],
            'buyer_complete_product' => [
                'title' => ':productName Receipt confirmed',
                'content' => ':sellerName received and :amount FTSY was automatically paid',
            ],
            'reminder_seller_accept' => [
                'title' => ':productName Cales confirmation',
                'content' => ':productName Waiting for sales approval',
            ],
            'auto_cancel_product' => [
                'title' => ':productName Cancel payment automatically',
                'content' => ':productName Automatically canceled without approval for 3 days',
            ],
        ],
    ],
    'dynamic_links' => [
        'socialTitle'       => 'Dynamic link title',
        'socialDescription' => 'Dynamic link Description'
    ],
    'internet_shop' => [
        'review_exists' => 'There are already reviews for this internet shop'
    ],
    'otp' => [
        'wait_before_resend' => 'You must wait :seconds seconds before resend.',
        'code_has_been_expired' => 'OTP code has been expired.',
        'code_is_invalid' => 'OTP code is invalid.',
        'send_code_fail' => 'Send OTP code fail.',
        'content' => 'Your OTP code is: :code, it will expired after :seconds seconds.'
    ],
];
