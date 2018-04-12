<?php
namespace App;
/**
 * Created by PhpStorm.
 * User: ost
 * Date: 2018. 4. 3.
 * Time: AM 12:05
 */
class LogToDatabase implements LoggerInterface
{
    public function log($data)
    {
        var_dump($data);
        var_dump("Eloquent");
        var_dump("log to database");
    }
}