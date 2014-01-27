<?php
$o = new stdClass;
$o->n = 1;

$fn = function () use ($o) {
    echo "n: {$o->n}\n";
};

$fn();
++$o->n;
$fn();
