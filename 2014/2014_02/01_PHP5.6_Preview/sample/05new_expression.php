<?php

class FooClass {}
class BarClass {}

// Type &...$values
// Type ...&$values (Not Allowed!!)

function func1( ...$args ) {}

function func2( FooClass ...$args ) {}

function func3( FooClass &...$args ) {
	foreach($args as &$arg) {
		$arg->x = "hi";
	}
}


$foo1 = new FooClass;
$foo2 = new FooClass;
$foo3 = new FooClass;

$bar = new BarClass;

func1( $foo1, $bar, $foo2 );

/* Error, Type!!
// func2( $foo1, $bar, $foo2 );
Catchable fatal error: Argument 2 passed to func2() must be an instance of FooClass, instance of BarClass given, called in /usr/share/nginx/www/sample/05new_expression.php on line 28 and defined in /usr/share/nginx/www/sample/05new_expression.php on line 10
*/

func3( $foo1, $foo2, $foo3 );
// = func3( ...[$foo1, $foo2, $foo3] );

var_dump($foo1);
var_dump($foo2);
var_dump($foo3);
/*
object(FooClass)#1 (1) {
  ["x"]=>
  string(2) "hi"
}
object(FooClass)#2 (1) {
  ["x"]=>
  string(2) "hi"
}
object(FooClass)#3 (1) {
  ["x"]=>
  string(2) "hi"
}
*/
