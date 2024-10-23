<?php

declare(strict_types=1);

namespace lindesbs\userobject\DTO\VCard\Enum;

enum AddressType: string
{
    case HOME = 'home';
    case WORK = 'work';
    case DOM = 'dom';
    case INTL = 'intl';
    case POSTAL = 'postal';
    case PARCEL = 'parcel';
    case PREF = 'pref';
}
