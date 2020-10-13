<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Common()
 * @method static static Shopkeeper()
 */
final class UserType extends Enum
{
    const Common = 1;
    const Shopkeeper = 2;
}
