<?php

namespace Jsadways\DataApi\Core\Parameter\Notification\Enums;

enum Platform: string
{
    case Email = 'email';
    case Jandi = 'jandi';
    case Slack = 'slack';
    case Line  = 'line';
}
