<?php
return [
    'force_blacklist_check' => env('FORCE_BLACKLIST_CHECK', true),
    'user_grade' => [
        1 => '일반',
        2 => '실버',
        3 => '골드',
        4 => 'VIP',
        5 => 'VIP실버',
        6 => 'VIP골드',
        7 => 'VIP블랙',
        8 => 'VVIP',
        9 => '특판A',
        10 => '특판B',
        11 => '특판C'
    ],
    'phone_fake_ios' => env('PHONE_FAKE_IOS', '01021938168'),
    'dynamic-link' => [
        'firebase_api_key'                => env('FIREBASE_API_KEY', null),
        'firebase_dynamic_links_domain'   => env('FIREBASE_DYNAMIC_LINKS_DOMAIN', null),
        'firebase_dynamic_links_deep_url' => env('FIREBASE_DYNAMIC_LINKS_DEEP_URL', null),
        'firebase_android_package_name'   => env('ANDROID_PACKAGE_NAME', null),
        'firebase_ios_bundle_id'          => env('IOS_BUNDLE_ID', null),
        'firebase_ios_app_store_id'       => env('IOS_APP_STORE_ID', null)
    ]
];
