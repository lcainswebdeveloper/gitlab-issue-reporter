<?php

require __DIR__.'/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::create(__DIR__.'/../');
$dotenv->load();

function env($key)
{
    try {
        return getenv($key);
    } catch (\Exception $e) {
        die('ENV KEY '.$key.' DOES NOT EXIST.');
    }
}

function prepr($arr)
{
    echo '<pre>';
    print_r($arr);
    echo '</pre>';
}
