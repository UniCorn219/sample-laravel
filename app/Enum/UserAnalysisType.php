<?php
namespace App\Enum;

use BenSampo\Enum\Enum;

class UserAnalysisType extends Enum
{
    const REVIEW_TRANSACTION = 'REVIEW_TRANSACTION';
    const PURCHASE_OLD_PHONES = 'PURCHASE_OLD_PHONES';
    const PURCHASE_NEW_PHONES = 'PURCHASE_NEW_PHONES';
    const COMMENT = 'COMMENT';
    const LOCAL_POST = 'LOCAL_POST';
    const REGISTER_PRODUCT = 'REGISTER_PRODUCT';
    const FOLLOWER = 'FOLLOWER';
    const FOLLOWING = 'FOLLOWING';
    const REPORT = 'REPORT';
    const REVIEW_SELLER = 'REVIEW_SELLER';
}
