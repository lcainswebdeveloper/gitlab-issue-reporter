<?php

namespace Tests\Feature;

use Tests\GitlabTestBase;
use Gitlab\Gitlab;

class GetProjectIssueTest extends GitlabTestBase
{
    protected $issueId = null;

    /** @test **/
    public function we_should_be_able_to_get_a_projects_issues()
    {
        $gl = new Gitlab($this->baseUri, $this->accessToken, $this->projectId, $this->assigneeId);
        $issues = $gl->getIssues();
        $this->assertTrue($issues->code == 200);
        foreach ($issues->data as $issue):
            $this->issueId = $issue->iid;
        $this->assertEquals($issue->project_id, $this->projectId);
        endforeach;

        if (!is_null($this->issueId)) {
            $gl = new Gitlab($this->baseUri, $this->accessToken, $this->projectId, $this->assigneeId);
            $issue = $gl->getIssue($this->issueId);

            $this->assertTrue($issue->code == 200);
            $this->assertEquals($issue->data->iid, $this->issueId);
            $this->assertEquals($issue->data->project_id, $this->projectId);
        }
    }
}
