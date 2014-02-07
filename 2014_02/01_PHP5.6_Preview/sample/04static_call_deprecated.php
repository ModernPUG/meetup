<?php

class A {
    function f() {  }
}

class B {
    function f() { A::f(); }
}

(new B)->f();

/*
PHP 5.6
	Deprecated: Non-static method A::f() should not be called statically, assuming $this from incompatible context in /usr/share/nginx/www/sample/04static_call_deprecated.php on line 8

PHP 5.5
	Strict Standards: Non-static method A::f() should not be called statically, assuming $this from incompatible context in /Users/Shared/Sites/modernphp/www/sample/04static_call_deprecated.php on line 8