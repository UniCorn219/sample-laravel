<?php

namespace App\Enum;

use BenSampo\Enum\Enum;

class OTPCodeLogStatus extends Enum
{
    public const VALIDATED = 1; // validate success
    public const CHANGED   = 2; // change by another resend
    public const EXPIRED   = 3; // expired by command console clear otp token
}
