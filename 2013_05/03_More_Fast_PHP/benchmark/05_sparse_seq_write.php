<?php

ini_set('memory_limit', '1G');

const ARRAY_SIZE = 5000000;
const GAP = 100000;

function benchmark($arr)
{
    $start = microtime(true);
    for ($i = 0; $i < ARRAY_SIZE; $i++) {
        $arr[$i * GAP] = $i;
    }

    return microtime(true) - $start;
}

$a1 = array();
print benchmark($a1)."\n";;
unset($a1);

$a3 = new Judy(Judy::INT_TO_INT);
print benchmark($a3)."\n";;
unset($a3);

?>
