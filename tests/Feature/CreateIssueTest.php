<?php

namespace Tests\Feature;

use Tests\GitlabTestBase;
use Gitlab\Gitlab;

class CreateIssueTest extends GitlabTestBase
{
    /** @test **/
    public function we_should_have_to_provide_valid_data_to_create_an_issue()
    {
        $gl = new Gitlab($this->baseUri, $this->accessToken, $this->projectId, $this->assigneeId);
        $create = $gl->createIssue(); //send no title or description
        $this->assertEquals($create->code, 400);

        $gl = new Gitlab($this->baseUri, $this->accessToken, $this->projectId, $this->assigneeId);
        $create = $gl->createIssue([
            'description' => $description = $this->faker->paragraph(2),
        ]);
        $this->assertEquals($create->code, 400);
    }

    /** @test **/
    public function we_should_be_able_to_get_a_create_an_issue_with_an_assignee()
    {
        $gl = new Gitlab($this->baseUri, $this->accessToken, $this->projectId, $this->assigneeId);
        $create = $gl->createIssue([
            'title' => $title = $this->faker->sentence(3),
            'description' => $description = $this->faker->paragraph(2),
        ]);
        $this->assertEquals($create->code, 201);
        $this->assertEquals($create->data->title, $title);
        $this->assertEquals($create->data->description, $description);
        $this->assertEquals($create->data->project_id, $this->projectId);
        $this->assertEquals($create->data->assignees[0]->id, $this->assigneeId);
    }

    /** @test **/
    public function we_should_be_able_to_get_a_create_an_issue_with_no_assignee_if_null()
    {
        $gl = new Gitlab($this->baseUri, $this->accessToken, $this->projectId);
        $create = $gl->createIssue([
            'title' => $title = $this->faker->sentence(3),
            'description' => $description = $this->faker->paragraph(2),
        ]);
        $this->assertEquals($create->code, 201);
        $this->assertEquals($create->data->title, $title);
        $this->assertEquals($create->data->description, $description);
        $this->assertEquals($create->data->project_id, $this->projectId);
        $this->assertCount(0, $create->data->assignees);
    }

    /** @test **/
    public function we_should_be_able_to_send_any_data_from_the_gitlab_issue_api()
    {
        $gl = new Gitlab($this->baseUri, $this->accessToken, $this->projectId);
        $create = $gl->createIssue([
            'title' => $title = $this->faker->sentence(3),
            'description' => $description = $this->faker->paragraph(2),
            'confidential' => true,
            'labels' => 'aaa,bbb,ccc',
        ]);
        $this->assertEquals($create->code, 201);
        $this->assertEquals($create->data->confidential, true);
        $this->assertEquals($create->data->description, $description);
        $this->assertEquals($create->data->project_id, $this->projectId);
        $this->assertEquals($create->data->labels[0], 'aaa');
        $this->assertEquals($create->data->labels[1], 'bbb');
        $this->assertEquals($create->data->labels[2], 'ccc');
        $this->assertCount(0, $create->data->assignees);
    }

    /** @test **/
    public function we_should_be_able_to_delete_an_issue()
    {
        $gl = new Gitlab($this->baseUri, $this->accessToken, $this->projectId);
        $created = $gl->createIssue([
            'title' => $title = $this->faker->sentence(3),
            'description' => $description = $this->faker->paragraph(2),
        ]);

        $gl = new Gitlab($this->baseUri, $this->accessToken, $this->projectId);
        $deleted = $gl->deleteIssue($created->data->iid);
        $this->assertEquals($deleted->code, 204);

        $gl = new Gitlab($this->baseUri, $this->accessToken, $this->projectId, $this->assigneeId);
        $issues = $gl->getIssues();
        foreach ($issues->data as $issue):
            $this->issueId = $issue->iid;
        $this->assertNotEquals($issue->iid, $created->data->iid);
        endforeach;
    }
}
