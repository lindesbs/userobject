<?php

declare(strict_types=1);

namespace lindesbs\userobject\DTO\VCard\Enum;

enum EmailType: string
{
    case HOME = 'home';
    case WORK = 'work';
    case PREF = 'pref';
}
