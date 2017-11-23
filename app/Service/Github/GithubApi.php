<?php

namespace App\Service\Github;

use App\Entity\PullRequest;
use Github\Api\Search;
use Github\Client;

class GithubApi
{
    private $token;
    private $repoUserName;
    private $repoName;

    private $client;


    public function __construct($token, $repoUserName, $repoName)
    {
        $this->token = $token;
        $this->repoUserName = $repoUserName;
        $this->repoName = $repoName;

        $this->client = new Client();
        $this->client->authenticate($this->token, '', Client::AUTH_URL_TOKEN);
    }


    /**
     * @return PullRequest[]
     */
    public function getActualPullRequests(): array
    {
        $notReviewedPullRequestsItems = $this->getNotReviewedPullRequestsItems();
        $requestsChangesPullRequestsItems = $this->getChangesRequestedPullRequestsItems();

        $pullRequestsItems = array_merge($notReviewedPullRequestsItems, $requestsChangesPullRequestsItems);

        $pullRequests = [];
        foreach ($pullRequestsItems as $item) {
            $pullRequests[] = PullRequest::createFromArray($item);
        }

        return $pullRequests;
    }


    private function getNotReviewedPullRequestsItems(): array
    {
        return $this->getPullRequestsItemsByCondition('type:pr state:open review:none sort:updated_at');
    }


    private function getChangesRequestedPullRequestsItems(): array
    {
        return $this->getPullRequestsItemsByCondition('type:pr state:open review:changes_requested sort:updated_at');
    }


    private function getPullRequestsItemsByCondition(string $condition): array
    {
        /** @var Search $search */
        $search = $this->client->api('search');

        $result = $search->issues(
            'repo:' . $this->repoUserName . '/' . $this->repoName . ' ' . $condition
        );

        return $result['items'];
    }
}