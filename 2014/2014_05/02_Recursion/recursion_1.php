<?php
function foo($x)
{
    if ($x > 1) {
        $y = $x - 1;
        foo($y);
    }
    
    echo "{$x}\n";
}

foo(3);

