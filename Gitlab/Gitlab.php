<?php

namespace Gitlab;

use Gitlab\Client\Guzzle;

class Gitlab
{
    protected $gitlabIssueBaseUrl;
    protected $accessToken;
    protected $projectId;
    protected $assigneeId;

    public function __construct($baseUri, $accessToken, $projectId, $assigneeId = null)
    {
        $this->setGitlabIssueBaseUrl(rtrim($baseUri, '/').'/'.$projectId.'/issues');
        $this->setAccessToken($accessToken);
        $this->setProjectId($projectId);
        $this->setAssigneeId($assigneeId);
        $this->client = new Guzzle($this->getGitlabIssueBaseUrl(), $accessToken);
    }

    public function getIssues()
    {
        $response = $this->client->get($this->getGitlabIssueBaseUrl());

        return $response->getApiResponse();
    }

    public function getIssue($issueIid)
    {
        $response = $this->client->get($this->getGitlabIssueBaseUrl().'/'.$issueIid);

        return $response->getApiResponse();
    }

    /*
    Refer to https://docs.gitlab.com/ee/api/issues.html#new-issue
    for request details, also LogIssueTest.php for a working example
    */
    public function createIssue(array $issue = [])
    {
        $data = $issue + [
            'id' => $this->getProjectId(),
            'assignee_ids' => $this->getAssigneeId(),
        ];
        $response = $this->client->post($this->getGitlabIssueBaseUrl(), $data);

        return $response->getApiResponse();
    }

    public function deleteIssue($issueIid)
    {
        $response = $this->client->delete($this->getGitlabIssueBaseUrl().'/'.$issueIid);

        return $response->getApiResponse();
    }

    /**
     * Get the value of gitlabIssueBaseUrl.
     */
    public function getGitlabIssueBaseUrl()
    {
        return $this->gitlabIssueBaseUrl;
    }

    /**
     * Set the value of gitlabIssueBaseUrl.
     *
     * @return self
     */
    public function setGitlabIssueBaseUrl($gitlabIssueBaseUrl)
    {
        $this->gitlabIssueBaseUrl = $gitlabIssueBaseUrl;

        return $this;
    }

    /**
     * Get the value of accessToken.
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * Set the value of accessToken.
     *
     * @return self
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;

        return $this;
    }

    /**
     * Get the value of projectId.
     */
    public function getProjectId()
    {
        return $this->projectId;
    }

    /**
     * Set the value of projectId.
     *
     * @return self
     */
    public function setProjectId($projectId)
    {
        $this->projectId = $projectId;

        return $this;
    }

    /**
     * Get the value of assigneeId.
     */
    public function getAssigneeId()
    {
        return $this->assigneeId;
    }

    /**
     * Set the value of assigneeId.
     *
     * @return self
     */
    public function setAssigneeId($assigneeId)
    {
        $this->assigneeId = $assigneeId;

        return $this;
    }
}
