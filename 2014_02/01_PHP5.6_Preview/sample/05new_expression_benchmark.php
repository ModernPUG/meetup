<?php
include "functions.php";

function average1() {
	$args = func_get_args();

	$total = 0;
	$count = 0;
	foreach ( $args as $arg ) {
		$total += $arg;
		$count++;
	}
	return $total/$count;
}

function average2(...$args) {
	$total = 0;
	$count = 0;
	foreach ( $args as $arg ) {
		$total += $arg;
		$count++;
	}
	return $total/$count;
}

$arr = [1,2,3,4,5];

echo "Step1. func_get_args() vs ... \n";

echo benchmark(function() {

	average1(1,2,3,4,5);

}, 10000), "\n";

echo benchmark(function() {

	average2(1,2,3,4,5);

}, 10000), "\n";

echo "Step2. call_user_func_array() vs ... \n";
echo benchmark(function() use($arr) {
	
	call_user_func_array('average2', $arr);

}, 10000), "\n";

echo benchmark(function() use($arr) {

	average2(...$arr);

}, 10000), "\n";



