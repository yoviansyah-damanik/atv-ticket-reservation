<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class ReservationType extends Enum
{
    const Completed = 'completed';
    const Canceled = 'canceled';
    const ReadyForAction = 'ready_for_action';
    const WaitingForPayment = 'waiting_for_payment';
}
