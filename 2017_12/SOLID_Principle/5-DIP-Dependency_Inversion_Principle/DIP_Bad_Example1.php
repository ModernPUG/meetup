<?php

namespace App\SOLID\DIP;

class MysqlDBConnection
{

    public function connect()
    {
        // Mysql DB connect
    }
}


class PasswordReminder
{
    /**
     * @var MysqlDBConnection
     */
    private $dbConnection;

    public function __construct(MysqlDBConnection $dbConnection)
    {
        $this->dbConnection = $dbConnection;
    }

    public function mongoDBConnect()
    {
        $this->dbConnection->connect();
    }
}



class MongoDBConnection
{

    public function mongoConnect()
    {
        // Mongo DB connect
    }
}


class MongoDBPasswordReminder
{
    /**
     * @var MysqlDBConnection
     */
    private $dbConnection;

    public function __construct(MongoDBConnection $dbConnection)
    {
        $this->dbConnection = $dbConnection;
    }

    public function mongoDBConnect()
    {
        $this->dbConnection->mongoConnect();
    }
}