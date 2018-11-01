<?php

namespace Foo\Bar {

	const MY_CONST = 30;

	function myMethod() {
		return __FUNCTION__;
	}

}

namespace {
	use const \Foo\Bar\MY_CONST as OTHERCONST;
	use function \Foo\Bar\myMethod as otherMethod;

	echo OTHERCONST, otherMethod();

}
