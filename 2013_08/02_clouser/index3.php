<?php
function get_clouser() {
    $o = new stdClass;
    $o->n = 1;

    $clouser = function () use ($o) {
        echo "n: {$o->n}\n";
        ++$o->n;
    };
    
    return $clouser;
}


$fn = get_clouser();
$fn();
$fn();

$fn1 = get_clouser();
$fn1();
$fn1();

