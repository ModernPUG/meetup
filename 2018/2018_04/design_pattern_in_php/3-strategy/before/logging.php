<?php

$strategy = "db";
$data = "some information";

if ($strategy == "file") {
    var_dump($data);
    var_dump("fopen");
    var_dump("log to file");
} elseif ($strategy == "db") {
    var_dump($data);
    var_dump("Eloquent");
    var_dump("log to database");
} elseif ($strategy == "slack") {
    var_dump($data);
    var_dump("webhook");
    var_dump("log to slack");
}