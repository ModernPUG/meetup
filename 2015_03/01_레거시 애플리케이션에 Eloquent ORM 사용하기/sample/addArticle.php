<?php

use App\Article;

include_once "vendor/autoload.php";

Article::create([
    'title' => 'example title',
    'body' => 'example body'
]);

