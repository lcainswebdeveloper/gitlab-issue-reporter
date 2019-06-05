# Gitlab
Small service for logging issues in Gitlab.   

## Please note this is still a work in progress

### Installation from Composer
- `composer require lcainswebdeveloper/gitlab-issue-reporter`

### Configuration
- All you will need to do is set a `GITLAB_BASE_URL` (eg `https://gitlab.com/api/v4/projects/`) for your Gitlab instance, your `GITLAB_PROJECT_ID`, `GITLAB_ASSIGNEE_ID` which is your gitlab user id and can be found in you user setting, and finally your `GITLAB_ACCESS_TOKEN` which you can create inside of your Gitlab UI at the following url: [https://gitlab.com/profile/personal_access_tokens]. Be sure to create this token with API access. 
Once created, i'd recommend you put these in an env file. Please see .env.example for details. Ultimately these just get used as values to get passed into our Gitlab class so feel free to set to your requirements.

### To create an issue
This service delegates straight to the Gitlab API itself so arguments can be passed as expected for all calls. Please feel free to look at the tests for usage also.   
Creating an issue (simple example):
```
use Gitlab\Gitlab;
$client = new Gitlab(GITLAB_BASE_URL, GITLAB_ACCESS_TOKEN);
$validIssue = $client->createIssue([
    'title' => 'Your title',
    'description' => 'Your description',
    'confidential' => true,
    'labels' => 'aaa,bbb,ccc',
    etc ...
]);
```
The response mirrors the response from the API itself

### Local Development
The easiest means is to use in a Docker environment but if you have >= php 7.2 and composer installed on your system, you should be good to go.

A docker-compose file has been provided for easy development so if you simply clone the repo into your project and then run `docker-compose up -d` the environment will build itself.

Once this is done, you just need to run composer install `docker-compose exec gitlab-php composer install` and tests can be run: `docker-compose exec gitlab-php vendor/bin/phpunit --colors`(please note before running tests make sure you have some kind of sandbox repository setup in gitlab and that you update your environment vars accordingly).

Once your environment is built you should be able to visit `http://localhost:8011` in your browser and view a sample form for use of this app.

### FEEDBACK, COMMENTS, ISSUES ETC ALL WELCOME. ENJOY ...
