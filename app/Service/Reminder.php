<?php

namespace App\Service;

use App\Service\Github\GithubApi;
use App\Service\Notification\NotificationBuilder;
use App\Service\Notification\Sender\NotificationSenderInterface;

class Reminder
{
    private $githubApi;
    private $notificationSender;


    public function __construct(GithubApi $githubApi, NotificationSenderInterface $notificationSender)
    {
        $this->githubApi = $githubApi;
        $this->notificationSender = $notificationSender;
    }


    public function remindAboutOpenPullRequests(): void
    {
        $pullRequests = $this->githubApi->getActualPullRequests();

        $this->remindAll($pullRequests);
    }


    private function remindAll($pullRequests): void
    {
        $notification = new NotificationBuilder();

        foreach ($pullRequests as $pullRequest) {
            $notification->addPullRequest($pullRequest);
        }

        $this->notificationSender->send($notification->getContent());
    }
}