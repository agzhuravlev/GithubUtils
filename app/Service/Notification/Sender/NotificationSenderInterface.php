<?php

namespace App\Service\Notification\Sender;

interface NotificationSenderInterface
{
    public function send(string $notification_text): void;
}