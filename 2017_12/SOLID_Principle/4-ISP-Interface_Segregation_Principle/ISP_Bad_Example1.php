<?php

namespace App\SOLID\ISP;

interface WorkerInterface
{

    public function work();

    public function sleep();
}

class HumanWorker implements WorkerInterface
{

    public function work()
    {
        return 'human working';
    }

    public function sleep()
    {
        return 'human sleeping';
    }
}

class AndroidWorker implements WorkerInterface
{

    public function work()
    {
        return 'Android working';
    }

    public function sleep()
    {
        return null;
    }
}

class Captain
{

    public function manage(WorkerInterface $worker)
    {
        $worker->work();
        $worker->sleep();
    }
}