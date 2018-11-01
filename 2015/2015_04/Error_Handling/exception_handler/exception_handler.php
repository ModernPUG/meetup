<?php
set_exception_handler(function (\Exception $exception) {
    $str = $exception->getMessage();
    send_bug_reporting($str);
});
function send_bug_reporting($str)
{
    echo "dummy sms was sent" . PHP_EOL;
    echo "---- S M S ----" . PHP_EOL;
    echo "($str)";
}
