<?php
set_error_handler(function ($code, $message, $file, $line) {
    $error_string = "oh my god!" . PHP_EOL;
    $error_string .= "code is $code" . PHP_EOL;
    $error_string .= "message is $message" . PHP_EOL;
    $error_string .= "file is $file" . PHP_EOL;
    $error_string .= "line is $line" . PHP_EOL;
    send_bug_reporting($error_string);
    exit();
});
function send_bug_reporting($str)
{
    echo "dummy sms was sent" . PHP_EOL;
    echo "---- S M S ----" . PHP_EOL;
    echo "($str)";
}

