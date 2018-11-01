<?php

interface ConnectionInterface
{
    public function connect();
}

class MysqlDBConnection implements ConnectionInterface
{

    public function connect()
    {
        // Mysql DB connect
    }
}

class MongoDBConnection implements ConnectionInterface
{

    public function connect()
    {
        // Mongo DB connect
    }
}

class PasswordReminder
{
    /**
     * @var ConnectionInterface
     */
    private $dbConnection;

    public function __construct(ConnectionInterface $dbConnection)
    {
        $this->dbConnection = $dbConnection;
    }

    public function dbConnect()
    {
        $this->dbConnection->connect();
    }
}