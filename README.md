# Gitlab
Small service for logging issues in Gitlab.   

### Installation from Composer
- `composer require lcainswebdeveloper/gitlab-issue-reporter`

### Configuration
- All you will need to do is set a `GITLAB_BASE_URL` (eg `https://gitlab.com/api/v4/projects/`) for your Gitlab instance, your `GITLAB_PROJECT_ID` and your `GITLAB_ACCESS_TOKEN` which you can create inside of your Gitlab UI at the following url: [https://gitlab.com/profile/personal_access_tokens]. Be sure to create this taken with API access. 
Once created, i'd recommend you put these in an env file.

### To create an issue
This service delegates straight to the Gitlab API itself so arguments can be passed as expected for all calls. Please feel free to look at the tests for usage also.   
Creating an issue (simple example):
```
use Gitlab\Gitlab;
$client = new Gitlab(GITLAB_BASE_URL, GITLAB_ACCESS_TOKEN);
$validIssue = $client->createIssue([
    ... to be fleshed out
]);
```
The response mirrors the response from the API itself
