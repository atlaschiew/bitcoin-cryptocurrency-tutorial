<?php

function bcdechex(string $dec): string
{

	$last = bcmod($dec, 16);
	$remain = bcdiv(bcsub($dec, $last), 16);

	if($remain == 0) {
		return dechex($last);
	} else {
		return bcdechex($remain).dechex($last);
	}
	
}

function bchexdec(string $hex): string
{
    $dec = 0;
    $len = strlen($hex);
    for ($i = 1; $i <= $len; $i++) {
        $dec = bcadd($dec, bcmul(strval(hexdec($hex[$i - 1])), bcpow('16', strval($len - $i))));
    }
    return $dec;
}


function swapEndianness($hex) {
    return implode('', array_reverse(str_split($hex, 2)));
}