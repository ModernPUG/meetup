<?php
set_error_handler(function ($code, $message, $file, $line) {
    throw new ErrorException($message, 0, $code, $file, $line);
});
set_exception_handler(function (\Exception $exception) {
    $str = $exception->getMessage() . PHP_EOL;
    $str .= $exception->getTraceAsString() . PHP_EOL;
    send_bug_reporting($str);
});
function send_bug_reporting($str)
{
    echo "dummy sms was sent" . PHP_EOL;
    echo "---- S M S ----" . PHP_EOL;
    echo "($str)";
}
