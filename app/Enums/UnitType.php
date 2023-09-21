<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class UnitType extends Enum
{
    const Ready = 'ready';
    const Used = 'used';
    const InRepair = 'in_repair';
    const Expired = 'expired';
}
