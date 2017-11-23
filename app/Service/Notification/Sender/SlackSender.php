<?php

namespace App\Service\Notification\Sender;

use GuzzleHttp\ClientInterface;

class SlackSender implements NotificationSenderInterface
{
    private $client;
    private $hook_url;
    private $channel;
    private $username;
    private $icon;


    public function __construct(
        ClientInterface $client,
        string $hook_url,
        string $channel,
        string $username,
        string $icon
    ) {
        $this->client = $client;
        $this->hook_url = $hook_url;
        $this->channel = $channel;
        $this->username = $username;
        $this->icon = $icon;
    }


    public function send(string $notification_text): void
    {
        $payload = json_encode(
            [
                'channel' => $this->channel,
                'username' => $this->username,
                'text' => $notification_text,
                'icon_emoji' => $this->icon,
            ]
        );

        $this->client->request('POST', $this->hook_url, ['body' => $payload]);
    }
}