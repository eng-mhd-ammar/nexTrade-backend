<?php

namespace Modules\Core\Enums;

enum TokenType: string
{
    case ACCESS  = 'ACCESS';
    case REFRESH = 'REFRESH';
    case RESET = 'RESET';
}
