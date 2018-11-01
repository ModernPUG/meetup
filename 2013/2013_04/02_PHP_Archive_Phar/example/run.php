<?php
include './build/dmc.phar';

echo file_get_contents('phar://build/dmc.phar/readme.txt');
?>
