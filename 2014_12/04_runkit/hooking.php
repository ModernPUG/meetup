<?php
class Foo
{
    public function bar($n)
    {
        return $n + 1;
    }
}

class Hooking
{
    public function __call($name, $args)
    {
        echo "Before {$name}!\n";
        $r = call_user_func_array([$this, "_hook_{$name}"], $args);
        echo "After {$name}!\n";
        return $r;
    }
    
    public static function hook($name)
    {
        runkit_method_rename(
            get_called_class(),
            $name,
            "_hook_{$name}"
        );
    }
}

runkit_class_adopt('Foo', 'Hooking');

Foo::hook('bar');

$foo = new Foo();

echo $foo->bar(10);
echo "\n";

