<?php

use App\Article;

include_once "vendor/autoload.php";

print_r(Article::where('body','=','example body')->get()->toArray());