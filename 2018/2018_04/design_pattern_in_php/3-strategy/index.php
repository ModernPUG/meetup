<?php
// strategy design pattern
//
use App\LoggerInterface;
use App\LogToDatabase;
use App\LogToFile;
use App\LogToSlack;

require "./vendor/autoload.php";

class App
{
    public function log($data, LoggerInterface $logger = null)
    {
        $logger->log($data);
    }
}

/** @var LoggerInterface[] $loggerArr */
$loggerArr = [
    "file" => new LogToFile(), "db" => new LogToDatabase(), "slack" => new LogToSlack(),
//    'email' => new LogEmail()
];

$strategy = "slack";

(new App)->log('some info', $loggerArr[$strategy]);
