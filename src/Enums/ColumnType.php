<?php

namespace Rizkhal\Inertable\Enums;

use Rizkhal\Inertable\Enums\Concerns\InvokeableCases;

enum ColumnType: string
{
    use InvokeableCases;

    case ACTION = 'action';

    case CHECKBOX = 'checkbox';
}
