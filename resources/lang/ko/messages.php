<?php

/**
 *
 * Forum translation file.
 *
 */
return [
    'point' => [
        'info_setting' => '포인트는 최소 :minPointUserP ~ 최대 :maxPointUserP 까지 사용 가능합니다'
    ],
    'user' => [
        'profile' => [
            'nickname' => [
                'have_been_use' => '중복된 닉네임입니다',
                'offensive'     => '저속한 단어를 사용하여 닉네임을 만들지 마십시오.'
            ]
        ],
    ],
    'password' => [
        'old_password_wrong' => '현재 비밀번호가 틀렸습니다'
    ],
    'promotion' => [
        'cannot_accept' => '해당 홍보를 승인할 수 없습니다',
        'cannot_reject' => '해당 홍보를 취소할 수 없습니다',
    ],
    'product' => [
        'product_status_cannot_update_when_ordering' => '주문 시 제품 상태를 업데이트할 수 없습니다',
        'only_author_can_accept' => '판매자만 결제 승인 가능합니다',
        'only_author_can_reject' => '판매자만 결제 거부 가능합니다',
        'only_author_can_add_logistics' => '판매자만 배송정보를 추가 가능합니다',
        'only_buyer_can_cancel' => '구매자만 취소 가능합니다',
        'only_buyer_can_complete' => '구매자만 수령 확인 가능합니다',
        'only_accept_when_status_ordering' => '결제중인 경우만 승인 가능합니다',
        'only_reject_when_status_ordering' => '결제중인 경우만 승인 가능합니다',
        'only_cancel_when_status_ordering' => '결제중인 경우만 취소 가능합니다',
        'only_complete_when_status_ordering' => '결제중인 경우만 수령 확인 가능합니다',
        'only_accept_when_order_status_processing' => '배송중인 경우만 승인 가능합니다',
        'only_reject_when_order_status_processing' => '배송중인 경우만 거부 가능합니다',
        'only_cancel_when_order_status_processing_or_accepted' => '배송중인 경우만 취소 가능합니다',
        'only_complete_when_order_status_sent_logistics' => '배송중인 경우만 수령 확인 가능합니다',
        'only_add_logistics_when_status_ordering' => '결제가 완료된 경우만 배송정보를 추가 가능합니다',
        'only_add_logistics_when_order_status_accepted' => '결제 승인된 경우만 배송정보를 추가 가능합니다',
    ],
    'payment' => [
        'transfer_transaction_is_not_valid' => '해당 입금거래가 유효하지 않습니다',
        'update_point_fail' => '포인트 업데이트 실패했습니다. 다시 시도하세요',
        'update_balance_token_fail' => '보유한 토큰 업데이트가 실패했습니다. 다시 시도하세요',
        'point_not_enough_to_create_promotion' => '포인트가 부족합니다 충전하러 가시겠어요?',
        'product_not_accept_payment_method' => '이 제품을 해당결제방식을 지원하지 없습니다',
        'product_status_can_not_buy' => '다른 구매자가 결제했습니다',
        'token_can_not_get_rate' => '환율을 확인할 수 없습니다',
        'create_safe_payment_fail' => '결제가 실패되었습니다.',
        'cancel_wallet_payment_fail' => '결제 취소가 실패되었습니다',
        'complete_wallet_payment_fail' => '결제 승인이 싪패되었습니다',
        'balance_ftsy_not_enough' => '보유중인 FTSY가 부족합니다',
    ],
    'max_store_main_menu' => '상점프로필을 3개만 생성 가능합니다',
    'can_not_create_because_of_offensive' => '게시글에 부적절한 단어가 있어서 차단되었습니다.',
    'product_not_create_because_of_offensive' => '게시글에 부적절한 단어가 있어서 차단되었습니다.',
    'notification' => [
        'base_title' => '신박한 중고거래 떴다마켓',
        'title_reservation' => '예약시간입니다',
        'reservation' => ':nickname님과 거래 약속시간이 되었어요!',
        'nickname' => '채팅',
        'chatting' => [
            'text' => [
                'content' => ':nickname 님에게 메시지가 왔어요.'
            ],
            'system' => [
                'auto_cancel_payment' => '3일 승인 없어서 자동 취소되었습니다'
            ],
            'sticker' => [
                'content' => ':nickname 님에게 메시지가 왔어요.',
                'last_message_receiver' => ':nickname 님에게 메시지가 왔어요.',
                'last_message_sender' => '스티커를 보냈습니다',
            ],
            'image' => [
                'content' => ':nickname 님에게 메시지가 왔어요.',
                'message_thread' => '이미지를 보냈습니다',
                'last_message_receiver' => ':nickname 님에게 메시지가 왔어요.',
                'last_message_sender' => '당신 이미지 공유했습니다',
            ],
            'location' => [
                'content' => ':nickname 님에게 메시지가 왔어요.',
                'last_message_receiver' => ':nickname 님에게 메시지가 왔어요.',
                'last_message_sender' => '당신 장고 공유했습니다',
            ],
            'gif' => [
                'content' => ':nickname 님에게 메시지가 왔어요.',
            ],
            'shipping_address' => [
                'content' => ':nickname 님에게 메시지가 왔어요.',
                'last_message_receiver' => ':nickname 님에게 메시지가 왔어요.',
                'last_message_sender' => '당신이 배송지를 공유했습니다',
            ],
            'bank_account' => [
                'content' => ':nickname 님에게 메시지가 왔어요.',
                'last_message_receiver' => ':nickname 님에게 메시지가 왔어요.',
                'last_message_sender' => '당신이 계좌번호를 공유했습니다',
            ],
            'reservation' => [
                'message_thread_create' => '예약을 설정했습니다',
                'title'  => '채팅',
                'create' => ':nickname 님에게 메시지가 왔어요.',
                'update' => ':nickname 님에게 메시지가 왔어요.',
                'delete' => ':nickname 님에게 메시지가 왔어요.'
            ],
            'user_payed' => [
                'content'         => ':nickname님이 :fantasyAmountFTSY(₩:moneyAmount)으로 결제했습니다',
                'approve_payment' => ':nickname님이 상품 포장후 배송 준비중입니다',
                'reject_payment'  => ':nickname님이 판매 거부했습니다',
            ],
            'shipping_company' => [
                'content' => '판매자가 상품을 배송했습니다',
            ],
            'order_received' => [
                'content' => '구매자가 배송 받았습니다',
            ],
            'review' => [
                'content' => '판매자를 평가하세요',
            ],
            'reviewed' => [
                'content' => '평가 완료되었습니다',
            ],
            'user_cancel_payment' => [
                'content' => ':nickname님이 결제 취소했습니다'
            ]
        ],
        'mission' => [
            'title' => '배치 달성',
            'content' => '새로운 배치를 달성하셨습니다. 확인해보세요~'
        ],
        'introduce_member' => '축가합니다! 방금 친구분이 공유링크로 회원가입되었습니다. 리워드를 확인해보세요!!!',
        'review' => [
            'transaction' => '님이 거래후기를 님겼습니다. 확인해보세요~!',
            'store' => '님이 당신의 상점 후기를 남겼습니다'
        ],
        'user' => [
            'follow_user' => '님 팔로우하기 시작했습니다.',
            'invite_member_title' => '축하합니다! 방금 친구분이 공유링크로 회원가입되었습니다.',
            'invite_member_content' => '리워드를 확인해보세요!!!',
            'invite_9_member_title' => '친구 초대미션을 성공하였습니다!!',
            'invite_9_member_content' => '리워드를 바로 확인해보세요!!!',
            'level_up_title' => '축하합니다!',
            'level_up_content' => '배터리 등급이 올라갔습니다!!!',
        ],
        'keyword' => [
            'title' => ':keyword 키워드 알림',
        ],
        'product' => [
            'change_price' => [
                'title' => ':productName 좋아요한',
                'content' => ':productName 좋아요한 가격 변경되었습니다!',
            ]
        ],
        'safe_payment' => [
            'buyer_buy_product' => [
                'title' => ':productName 결제 완료',
                'content' => ':buyerName 님이 해당 제품을 결제했습니다',
            ],
            'buyer_cancel_product' => [
                'title' => ':productName 결제취소',
                'content' => ':buyerName 님이 해당 제품을 결제 취소했습니다',
            ],
            'seller_accept' => [
                'title' => ':productName 배송 준비',
                'content' => ':sellerName 님이 배송준비중입니다',
            ],
            'seller_reject' => [
                'title' => ':productName 판매 거부',
                'content' => ':sellerName 님이 판매 취소했습니다. 자동 환불되었습니다',
            ],
            'seller_add_logistics' => [
                'title' => ':productName 송장번호 확인',
                'content' => ':sellerName 님이 송장번호 전달했습니다',
            ],
            'buyer_complete_product' => [
                'title' => ':productName 수령 확인됨',
                'content' => ':sellerName 님이 수령되고 :amount FTSY 자동 지급되었습니다',
            ],
            'reminder_seller_accept' => [
                'title' => ':productName 판매 확인',
                'content' => ':productName 판매 승인 기다리고 있어요~',
            ],
            'auto_cancel_product' => [
                'title' => ':productName 결제 자동 취소',
                'content' => ':productName 3일 승인 없어서 자동 취소되었습니다',
            ],
        ],
    ],
    'dynamic_links' => [
        'user' => [
            'socialTitle'       => '사용자 프로필 공유',
            'socialDescription' => '사용자 프로필화면으로 이동합니다'
        ],
        'store' => [
            'socialTitle'       => '상점프로필 공유',
            'socialDescription' => '상점프로필 화면으로 이동합니다'
        ],
        'local_info' => [
            'socialTitle'       => '근처소식 공유',
            'socialDescription' => '근처소식 상세화면으로 이동합니다'
        ],
        'local_post' => [
            'socialTitle'       => '주변꿀팁 공유',
            'socialDescription' => '주변꿀팁 상세화면으로 이동합니다'
        ],
        'internet_shop' => [
            'socialTitle'       => '주변꿀팁 공유',
            'socialDescription' => '주변꿀팁 상세화면으로 이동합니다'
        ],
        'product' => [
            'socialTitle'       => '중고거래 제품 공유',
            'socialDescription' => '중고거래 제품 화면으로 이동합니다 '
        ]
    ],
    'chatting' => [
        'reservation' => [
            'create' => ':date :noon :time 약속 알림이 설정 되었습니다',
            'update' => ':user 님이 예약시간을 :month 월 :date 일 (:dayOfWeek) :time 로 변경 됐습니다',
            'delete' => '예약이 취소 되었어요ㅠ.ㅠ'
        ],
        'paycoin' => [
            'create' => ':nickname님 :tokenNo FTSY를 입금하셨습니다',
            'last_message_receiver' => ':nickname님 :tokenNo FTSY를 송금했습니다',
            'last_message_sender' => '당신이 :tokenNo FTSY를 송금했습니다',
        ]
    ],
    'date' => [
        'noon' => [
            // $datetime->format('a') => string
            'am' => '아침',
            'pm' => '오후',
        ],
        'day_of_week' => [
            // $datetime->format('N') => string
            1 => '월', // 월요일 : Thứ 2
            2 => '화', // 화요일 : Thứ 3
            3 => '수', // 수요일 : Thứ 4
            4 => '목', // 목요일 : Thứ 5
            5 => '금', // 금요일 : Thứ 6
            6 => '토', // 토요일 : Thứ 7
            7 => '일', // 일요일 : CN
        ]
    ],
    'internet_shop' => [
        'review_exists' => '이 인터넷 상점에 대한 리뷰가 이미 있습니다.'
    ],
    'otp' => [
        'wait_before_resend' => ':seconds 초를 기다리고 재전송하세요',
        'code_has_been_expired' => '인증번호가 만료되었습니다',
        'code_is_invalid' => '인증번호가 일치하지 않습니다',
        'send_code_fail' => 'OTP 전송이 실패했습니다',
        'content' => 'OTP 가 [:code] 입니다 :seconds 초 후에 만료됩니다'
    ],
];
