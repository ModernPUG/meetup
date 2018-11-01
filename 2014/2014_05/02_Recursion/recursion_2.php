<?php
$data = array(
    array(1, 2),
    array(3, 4),
    5,
    6,
    array(7, 8, 9),
    10,
);

// 배열속의 모든 숫자 출력하기
foreach ($data as $value1) {
    if (is_array($value1)) {
        foreach ($value1 as $value2) {
            echo "{$value2}\n";
        }
    } else {
        echo "{$value1}\n";
    }
}


// HOW?
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
            array(8),
        ),
        9
    ),
    10,
);










