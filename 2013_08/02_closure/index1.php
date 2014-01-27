<?php
$n = 1;

$fn = function () use (&$n) {
    echo "n: {$n}\n";
};

$fn();
++$n;
$fn();
