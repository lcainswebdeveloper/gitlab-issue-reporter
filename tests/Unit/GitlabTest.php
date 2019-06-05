<?php

namespace Tests\Unit;

use Gitlab\Gitlab;
use Tests\GitlabTestBase;

class GitlabTest extends GitlabTestBase
{
    /** @test **/
    public function we_should_be_setting_the_gitlab_issue_correctly()
    {
        $gl = new Gitlab($this->baseUri, $this->accessToken, $this->projectId, $this->assigneeId);

        $expected = $this->baseUri.'/'.$this->projectId.'/issues';

        $this->assertEquals($expected, $gl->getGitlabIssueBaseUrl());

        //make sure the baseUrl will rtrim any / provided
        $gl = new Gitlab($this->baseUri.'/', $this->accessToken, $this->projectId, $this->assigneeId);

        $expected = $this->baseUri.'/'.$this->projectId.'/issues';

        $this->assertEquals($expected, $gl->getGitlabIssueBaseUrl());
    }
}
