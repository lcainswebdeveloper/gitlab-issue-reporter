<?php

namespace Gitlab;

use Gitlab\Client\Guzzle;

class Gitlab
{
    public function __construct($baseUri, $apiKey)
    {
        $this->client = new Guzzle($baseUri, $apiKey);
    }

    public function getUsers()
    {
        $response = $this->client->get('users.json');

        return $response->getApiResponse();
    }

    /*
    Refer to https://www.Gitlab.org/projects/Gitlab/wiki/Rest_Issues#Creating-an-issue
    for request details, also LogIssueTest.php for a working example
    */
    public function createIssue($issue)
    {
        $response = $this->client->post('issues.json', [
            'issue' => $issue,
        ]);

        return $response->getApiResponse();
    }
}
