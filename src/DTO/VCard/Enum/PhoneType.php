<?php

declare(strict_types=1);

namespace lindesbs\userobject\DTO\VCard\Enum;

enum PhoneType: string
{
    case HOME = 'home';
    case WORK = 'work';
    case TEXT = 'text';
    case VOICE = 'voice';
    case FAX = 'fax';
    case CELL = 'cell';
    case VIDEO = 'video';
    case PAGER = 'pager';
    case TEXTPHONE = 'textphone';
    case PREF = 'pref';
}
