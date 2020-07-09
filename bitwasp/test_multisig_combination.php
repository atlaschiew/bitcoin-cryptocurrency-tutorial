<?php
$m = 2;
$n = 3;

$combination = [];
foreach(range(1, $n) as $v1) {
	$c = $v1;
	
	
	for($v2=$v1+1; $v2<= $n; $v2++) {
		$c .= "-{$v2}";
		
		
		echo $c . "<br/>";
		
		if (count(explode("-", $c)) >= $m) {
			$combination[] = $c;
		}
	}
}

print_r($combination);
?>