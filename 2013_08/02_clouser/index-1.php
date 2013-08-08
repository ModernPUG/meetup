<?php
$n = 1;

$fn = function ($age) use ($n) {
    echo "Modern PHP {$n} {$age}\n";
};

$fn(12);
