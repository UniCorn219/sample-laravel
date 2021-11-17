<?php

namespace App\Enum;

use BenSampo\Enum\Enum;

class BusinessExceptionCode extends Enum
{
    public const OTP_CODE_IS_INVALID               = 1000;
    public const OTP_CODE_HAS_BEEN_EXPIRED         = 1001;
    public const PRODUCT_NOT_ACCEPT_PAYMENT_METHOD = 1002;
    public const PRODUCT_CAN_NOT_BUY               = 1003;
    public const BALANCE_NOT_ENOUGH                = 1004;
    public const CREATE_SAFE_PAYMENT_FAIL          = 1005;
    public const TOKEN_CAN_NOT_GET_RATE            = 1006;
    public const OTP_MUST_WAIT_BEFORE_RESEND       = 1007;
    public const OTP_SEND_CODE_FAIL                = 1008;
}
