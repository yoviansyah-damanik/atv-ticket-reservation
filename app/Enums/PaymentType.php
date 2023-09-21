<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class PaymentType extends Enum
{
    const PaidOff = 'paid_off';
    const DownPayment = 'down_payment';
    const Rejected = 'rejected';
    const WaitingForConfirmation = 'wait_for_confirmation';
}
