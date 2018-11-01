<?php
function foo($data)
{
    foreach ($data as $value) {
        if (is_array($value)) {
            foo($value);
        } else {
            echo "{$value}\n";
        }
    }
}

$data = array(
    array(1, 2),
    array(
        3,
        array(4, 5),
    ),
    6,
    array(
        array(
            7,
            array(
                8,
                array(8.1, 8.2),
            ),
        ),
        9
    ),
    10,
    11,
    array('끝!')
);

foo($data);









