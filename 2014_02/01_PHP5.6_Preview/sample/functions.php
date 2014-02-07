<?php

function benchmark( $callback, $times = 100 ) {
	if ( !($callback instanceof Closure) ) return false;
	$st = explode(" ", microtime());

	for ($i = 0; $i < $times; $i++) {
		$ret = $callback( $i );
	}

	$et = explode(" ", microtime());

	echo sprintf("Running Time : %d.%08ds\n",
			$et[1]- $st[1],
			( (int)substr($et[0], 2)-(int)substr($st[0],2)+100000000 )%100000000 );

	return $ret;
}

