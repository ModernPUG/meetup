<?php
$s1 = chr(176).chr(161);

$s2 = mb_convert_encoding($s1, 'UTF-8', 'EUC-KR');

echo $s1;
echo "\n";

echo $s2;
echo "\n";
