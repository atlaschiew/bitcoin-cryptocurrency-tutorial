<?php


include_once "../libraries/vendor/autoload.php";
use BitWasp\Buffertools\Buffer;

$txIds = ["ef1d870d24c85b89d92ad50f4631026f585d6a34e972eaf427475e5d60acf3a3", "f9fc751cb7dc372406a9f8d738d5e6f8f63bab71986a39cf36ee70ee17036d07","db60fb93d736894ed0b86cb92548920a3fe8310dd19b0da7ad97e48725e1e12e","220ebc64e21abece964927322cba69180ed853bb187fbc6923bac7d010b9d87a",
"71b3dbaca67e9f9189dad3617138c19725ab541ef0b49c05a94913e9f28e3f4e","fe305e1ed08212d76161d853222048eea1f34af42ea0e197896a269fbf8dc2e0","21d2eb195736af2a40d42107e6abd59c97eb6cffd4a5a7a7709e86590ae61987","dd1fd2a6fc16404faf339881a90adbde7f4f728691ac62e8f168809cdfae1053","74d681e0e03bafa802c8aa084379aa98d9fcd632ddc2ed9782b586ec87451f20"];
  
//convert into little endian 
$txIds = array_map(function ($v) { $result = Buffer::hex($v);return $result->flip()->getHex(); },$txIds);

if (count($txIds) == 1) {
	$merkleRoot = $txIds[0];
} else {
	$merkleRoot = createMerkleRoot($txIds);
}

//convert into big endian for better human readibility
$result = Buffer::hex($merkleRoot);
echo $result->flip()->getHex();

function createMerkleRoot($txIds) {
	
	$results = [];
	
	$totalTxIds = @count($txIds);
	
	if ($totalTxIds % 2 > 0) {
		$txIds[ $totalTxIds ] = $txIds[ $totalTxIds - 1 ];
	}
	
	$groupArray = array_chunk($txIds, 2);
	
	foreach($groupArray as $singleArray) {
		$results[] = hash('sha256', hex2bin(hash('sha256', hex2bin( implode("", $singleArray) ))));
	}
	
	if (@count($results) == 1) {
		return $results[0];
	} else {
		return createMerkleRoot($results);
	}
}