<?php

function bcdechex($dec) {

	$last = bcmod($dec, 16);
	$remain = bcdiv(bcsub($dec, $last), 16);

	if($remain == 0) {
		return dechex($last);
	} else {
		return bcdechex($remain).dechex($last);
	}
	
}