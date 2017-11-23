<?php

namespace App\Service\Notification;

use App\Entity\PullRequest;

class NotificationBuilder
{
    private $pullRequests = [];


    public function addPullRequest(PullRequest $pullRequest): void
    {
        $this->pullRequests[] = $pullRequest;
    }


    public function getContent(): string
    {
        $content = $this->getHeader();

        if (empty($this->pullRequests)) {
            $content .= 'There are no open pull requests. You are the best!' . PHP_EOL;
        } elseif (count($this->pullRequests) == 1) {
            $content .= 'There is the last open pull request:' . PHP_EOL . $this->getPullRequestText(
                $this->pullRequests[0]
            );
        } else {
            $content .= 'There are some open pull requests:' . PHP_EOL . PHP_EOL;

            foreach ($this->pullRequests as $key => $pullRequest) {
                $content .= ($key + 1) . ') ' . $this->getPullRequestText($pullRequest);
            }
        }

        $content .= $this->getFooter();

        return $content;
    }


    private function getHeader(): string
    {
        return 'Good morning, team!' . PHP_EOL . PHP_EOL;
    }


    private function getPullRequestText(PullRequest $pullRequest): string
    {
        $text = '<' . $pullRequest->url . '|' . $pullRequest->title . '> from ' . $pullRequest->user['login'] . ''
            . PHP_EOL;

        if (!empty($pullRequest->requested_reviewers)) {
            $reviewers_names = [];

            foreach ($pullRequest->requested_reviewers as $reviewer) {
                $reviewers_names[] = $reviewer['login'];
            }

            $text .= implode(', ', $reviewers_names) . ' please view it.';
        }

        $month_ago = (new \DateTime('-1 month'));
        if ($pullRequest->created_at < $month_ago) {
            $text .= ' _*It is very old!*_ :rage: View or delete and forget it forever';
        }

        $text .= PHP_EOL;

        return $text;
    }


    private function getFooter(): string
    {
        return 'Good luck!' . PHP_EOL . PHP_EOL;
    }
}