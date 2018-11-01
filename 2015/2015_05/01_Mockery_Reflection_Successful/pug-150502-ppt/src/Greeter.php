<?php
namespace Wandu\PugSample;

use Closure;

class Greeter
{
    /** @var Customer */
    private $customer;

    /**
     * @param Customer $customer
     */
    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    /**
     * @return string
     */
    public function sayHelloPublic()
    {
        return "Hello, {$this->customer->getName()}! (public)";
    }

    /**
     * @return string
     */
    private function sayHelloPrivate()
    {
        return "Hello, {$this->customer->getName()}! (private)";
    }

    /**
     * @param callable $handler
     * @return mixed
     */
    public function doSomethingWithCustomer(Closure $handler)
    {
        return $handler->__invoke($this->customer);
    }
}
