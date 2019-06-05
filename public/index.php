<?php
require_once __DIR__.'/../bootstrap/autoload.php';
use Gitlab\Gitlab;

$response = null;
$success = false;
if (isset($_POST)) {
    $env = [
        'GITLAB_BASE_URL' => env('GITLAB_BASE_URL'),
        'GITLAB_PROJECT_ID' => env('GITLAB_PROJECT_ID'),
        'GITLAB_ASSIGNEE_ID' => env('GITLAB_ASSIGNEE_ID'),
        'GITLAB_ACCESS_TOKEN' => env('GITLAB_ACCESS_TOKEN'),
    ];

    //please sanitize in your own implementations
    $issue = $_POST;
    $gl = new Gitlab($env['GITLAB_BASE_URL'], $env['GITLAB_ACCESS_TOKEN'], $env['GITLAB_PROJECT_ID'], $env['GITLAB_ASSIGNEE_ID']);
    $create = $gl->createIssue([
        'title' => $issue['title'],
        'description' => $issue['description'],
        'confidential' => true,
        'labels' => $issue['description'],
    ]);

    $response = $create;
    $success = $create->code == 201;
    $_POST = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>GITLAB ISSUE REPORTER</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.5/css/bulma.min.css" integrity="sha256-vK3UTo/8wHbaUn+dTQD0X6dzidqc5l7gczvH+Bnowwk=" crossorigin="anonymous" />
    <style>
        .form-container{
            background:#f3f3f3;
            padding:40px;
            max-width:500px;
            margin:40px auto;
        }
        .select, .select select{
            width:100%;
        }
        .gitlab-response{
            border:1px solid white;
            font-size:12px;
            margin-bottom:40px;
            color:white;
        }
        .gitlab-response.is-valid pre{
            background:green;
            color:white
        }
        .gitlab-response.is-invalid pre{
            background:red;
            color:white
        }
    </style>
</head>

<body>
    <section class="section form-container">
        <div class="container">
            <h1 class="title">
                GITLAB ISSUE REPORTER
            </h1>
            <p class="subtitle">
                Send your issues to GITLAB
            </p>
            <?php
            if (!is_null($response)) {
                ?>
<div class="gitlab-response <?=($success == true) ? 'is-valid' : 'is-invalid'; ?>">
<pre>
<?php
print_r($response); ?>
</pre>
</div>
            <?php
            }
            ?>
            <form action="/" method="POST">
                <div class="field">
                    <label class="label">Title</label>
                    <div class="control">
                        <input name="title" class="input" type="text" placeholder="Please give a title for your issue">
                    </div>
                </div>

                

                <div class="field">
                    <label class="label">Description</label>
                    <div class="control">
                        <textarea name="description" required class="textarea" placeholder="Please provide a description for the issue"></textarea>
                    </div>
                </div>

                <div class="field">
                    <label class="label">Nature of issue</label>
                    <div class="control">
                        <div class="select">
                            <select name="labels">
                                <option>Bug</option>
                                <option>Feature Request</option>
                            </select>
                        </div>
                    </div>
                </div>


                <div class="field is-grouped">
                    <div class="control">
                        <button class="button is-link">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </section>

</body>

</html>