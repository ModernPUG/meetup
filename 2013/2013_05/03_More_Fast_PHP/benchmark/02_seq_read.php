<?php

ini_set('memory_limit', '1G');

const ARRAY_SIZE = 5000000;

function benchmark($arr)
{
    for ($i = 0; $i < ARRAY_SIZE; $i++) {
        $arr[$i] = $i;
    }

    $start = microtime(true);
    for ($i = 0; $i < ARRAY_SIZE; $i++) {
        $k = $arr[$i];
    }

    return microtime(true) - $start;
}

$a1 = array();
print benchmark($a1)."\n";;
unset($a1);

$a2 = new SplFixedArray(ARRAY_SIZE);
print benchmark($a2)."\n";;
unset($a2);

$a3 = new Judy(Judy::INT_TO_INT);
print benchmark($a3)."\n";;
unset($a3);

?>
