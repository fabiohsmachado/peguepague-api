<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static CPF()
 * @method static static CNPJ()
 */
final class DocumentType extends Enum
{
    const CPF = 1;
    const CNPJ = 2;
}
