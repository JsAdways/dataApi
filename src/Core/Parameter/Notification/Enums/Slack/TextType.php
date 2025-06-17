<?php

namespace Jsadways\DataApi\Core\Parameter\Notification\Enums\Slack;

enum TextType: string
{
    case markdown = 'mrkdwn';
    case plain_text = 'plain_text';
}
