<?php
/** Observe design pattern.
 */

interface Subject
{
    public function attach($observer);

    public function detach($observer);

    public function notify();
}

// subscriber
interface Observer
{
    public function handle();
}


class Login implements Subject
{

    protected $observers;


    public function attach($observers)
    {
        if (is_array($observers)) {
            return $this->attachObservers($observers);
        }

        $this->observers[] = $observers;

        return $this;
    }


    public function fire()
    {
        $this->notify();
    }

    protected function attachObservers($observers)
    {
        foreach ($observers as $observer) {
            if (!$observer instanceof Observer) {
                throw new Exception;
            }

            $this->attach($observer);
        }
    }


    public function detach($index)
    {
        unset($this->observers[$index]);
    }

    public function notify()
    {

        foreach ($this->observers as $observer) {
            $observer->handle();
        }
    }

}



class EmailNotifer implements Observer
{

    public function handle()
    {
        echo 'email notify some important things.' . PHP_EOL;
    }

}


$login = new Login;


$login->attach([
    new EmailNotifer,
]);


$login->fire();
