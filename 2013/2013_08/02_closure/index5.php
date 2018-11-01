<?php
$name = 'PHP';

$fn = function () use ($name) {
    include './sub.php';
};

for ($i = 0; $i < 2; $i++) {  
    $fn();
}
