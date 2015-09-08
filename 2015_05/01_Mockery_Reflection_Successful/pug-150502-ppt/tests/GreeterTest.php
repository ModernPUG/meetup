<?php
namespace Wandu\PugSample;

use PHPUnit_Framework_TestCase;
use Mockery;
use ReflectionClass;
use Closure;

class GreeterTest extends PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        Mockery::close();
    }

    public function testSayHelloPublic()
    {
        $mockCustomer = Mockery::mock(Customer::class);
        $mockCustomer->shouldReceive('getName')->andReturn('Changwan');

        $greeter = new Greeter($mockCustomer);

        $this->assertAttributeInstanceOf(Customer::class, 'customer', $greeter);
        $this->assertAttributeEquals($mockCustomer, 'customer', $greeter);

        $this->assertEquals('Hello, Changwan! (public)', $greeter->sayHelloPublic());
    }

    public function testSayHelloPrivate()
    {
        $mockCustomer = Mockery::mock(Customer::class);
        $mockCustomer->shouldReceive('getName')->andReturn('Wandu');

        $greeter = new Greeter($mockCustomer);

        $classReflection = new ReflectionClass(Greeter::class);
        $sayHelloPrivateMethod = $classReflection->getMethod('sayHelloPrivate')->getClosure($greeter);

        $this->assertInstanceOf(Closure::class, $sayHelloPrivateMethod);
        $this->assertEquals('Hello, Wandu! (private)', $sayHelloPrivateMethod->__invoke());
    }

    public function testDoSomethingSimple()
    {
        $mockCustomer = Mockery::mock(Customer::class);
        $mockCustomer->shouldReceive('getName')->andReturn('Wandu');

        $greeter = new Greeter($mockCustomer);

        $this->assertEquals(30, $greeter->doSomethingWithCustomer(function ($param1) use ($mockCustomer) {
            $this->assertSame($mockCustomer, $param1);
            return 30;
        }));
    }

    public function testDoSomethingWithDummy()
    {
        $mockCustomer = Mockery::mock(Customer::class);
        $mockCustomer->shouldReceive('getName')->andReturn('Wandu');

        $mockHandler = Mockery::mock(Dummy::class);
        $mockHandler->shouldReceive('handler')->once()->with($mockCustomer)->andReturn(30);

        $greeter = new Greeter($mockCustomer);

        $classReflection = new ReflectionClass(get_class($mockHandler));
        $handler = $classReflection->getMethod('handler')->getClosure($mockHandler);

        $this->assertEquals(30, $greeter->doSomethingWithCustomer($handler));
    }
}
