<?php
error_reporting(E_ALL & ~E_NOTICE | E_STRICT);

require_once './Traits/Property.php';

class Foo implements \IteratorAggregate
{
    use \Traits\Property;
    
    public $y = 4;
    public $z = 5;
    
    public function __construct()
    {
        $this->n = 1;
        $this->m = 2;
        $this->x = 3;
        
        $this->readwrite(['n', 'm']);

        $this->getterOnce('one', function () {
            return ++$this->n;
        });
        
        $this->getter('age', function () {
            return $this->_age . ' 입니다.';
        });
        
        $this->setter('age', function ($value) {
            $this->_age = $value * 3;
        });
    }
}

$foo = new Foo();

$foo->age = 10;
echo $foo->age . "\n";

echo $foo;

foreach ($foo as $k => $v) {
    echo "{$k} => {$v}\n";
}

echo "\n\n";

