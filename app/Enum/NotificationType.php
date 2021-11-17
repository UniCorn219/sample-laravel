<?php

namespace App\Enum;

use App\Models\IntroduceMemberHistories;
use App\Models\LocalInfo;
use App\Models\LocalInfoComment;
use App\Models\LocalInfoLike;
use App\Models\LocalPost;
use App\Models\LocalPostComment;
use App\Models\LocalPostLike;
use App\Models\Mission;
use App\Models\Product;
use App\Models\ProductLike;
use App\Models\ProductTop;
use App\Models\Store;
use App\Models\User;
use App\Models\UserActionable;
use App\Models\UserReview;
use App\Models\UserReviewable;
use BenSampo\Enum\Enum;
use Illuminate\Database\Eloquent\Relations\Relation;

class NotificationType extends Enum
{
    const CHAT          = 'CHAT';
    const KEYWORD       = 'KEYWORD';
    const ACTIVITY      = 'ACTIVITY';
    const TRANSACTION   = 'TRANSACTION';
    const MARKETING     = 'MARKETING';
    const BATTERY       = 'BATTERY';
    const MISSION       = 'MISSION';
    const INVITE_MEMBER = 'INVITE_MEMBER';
    const PRODUCT       = 'PRODUCT';
    const SAFE_PAYMENT  = 'SAFE_PAYMENT';

    const NAVIGATE = [
        'TTUTA_BADGE'                 => 'TTUTA_BADGE_SCREEN',
        'TRANSACTION_HISTORY_SCREEN'  => 'TRANSACTION_HISTORY_SCREEN',
        'STORE_PROFILE_REVIEW_SCREEN' => 'STORE_PROFILE_REVIEW_SCREEN',
        'CHATTING_SCREEN'             => 'CHATTING_SCREEN',
        'USER_PROFILE_SCREEN'         => 'USER_PROFILE_SCREEN',
        'MISSION_SCREEN'              => 'MISSION_SCREEN',
        'INVITE_MEMBER_SCREEN'        => 'INVITE_MEMBER_SCREEN',
        'PRODUCT_SCREEN'              => 'PRODUCT_SCREEN',
    ];

    public static function morphMap()
    {
        Relation::morphMap([
            EntityMorphType::PRODUCT                  => Product::class,
            EntityMorphType::STORE                    => Store::class,
            EntityMorphType::USER                     => User::class,
            EntityMorphType::LOCAL_POST               => LocalPost::class,
            EntityMorphType::LOCAL_INFO               => LocalInfo::class,
            EntityMorphType::LOCAL_POST_COMMENT       => LocalPostComment::class,
            EntityMorphType::LOCAL_INFO_COMMENT       => LocalInfoComment::class,
            EntityMorphType::LOCAL_INFO_LIKE          => LocalInfoLike::class,
            EntityMorphType::LOCAL_POST_LIKE          => LocalPostLike::class,
            EntityMorphType::PRODUCT_LIKE             => ProductLike::class,
            EntityMorphType::PRODUCT_TOP              => ProductTop::class,
            EntityMorphType::USER_ACTION              => UserActionable::class,
            EntityMorphType::USER_REVIEWABLE          => UserReviewable::class,
            EntityMorphType::USER_REVIEW              => UserReview::class,
            EntityMorphType::MISSION                  => Mission::class,
            EntityMorphType::INTRODUCE_MEMBER_HISTORY => IntroduceMemberHistories::class,
        ]);
    }
}
