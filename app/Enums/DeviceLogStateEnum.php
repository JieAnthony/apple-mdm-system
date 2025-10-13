<?php

namespace App\Enums;

enum DeviceLogStateEnum: int
{
    case PENDING = 0;

    case ACKNOWLEDGED = 1;

    case ERROR = 2;
}
