<?php

namespace App\Entity;

class PullRequest
{
    public $title;
    public $created_at;
    public $requested_reviewers;
    public $user;
    public $url;


    public static function createFromArray(array $data): PullRequest
    {
        $pullRequest = new PullRequest();

        $pullRequest->title = $data['title'];
        $pullRequest->created_at = new \DateTime($data['created_at']);
        $pullRequest->requested_reviewers = $data['requested_reviewers'];
        $pullRequest->user = $data['user'];
        $pullRequest->url = $data['html_url'];

        return $pullRequest;
    }
}