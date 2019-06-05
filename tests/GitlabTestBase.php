<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Faker\Factory as FakerFactory;

class GitlabTestBase extends TestCase
{
    protected function setUp(): void
    {
        $this->baseUri = env('GITLAB_BASE_URL');
        $this->projectId = env('GITLAB_PROJECT_ID');
        $this->assigneeId = env('GITLAB_ASSIGNEE_ID');
        $this->accessToken = env('GITLAB_ACCESS_TOKEN');

        $this->faker = FakerFactory::create();
    }
}
