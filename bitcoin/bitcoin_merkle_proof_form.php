<?php 

use BitWasp\Buffertools\Buffer;

include_once "../libraries/vendor/autoload.php";
include_once("html_iframe_header.php");

$result = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	try {
		$txIds = explode("\n", $_POST['txids']);
		$merkleRoot = "";
		
		function createMerkleProof($txId, $txIds) {
			
			$proofs = [];
			
			//convert to little endian
			$txId = Buffer::hex(trim($txId))->flip()->getHex();
			$txIds = array_map(function ($v) { return Buffer::hex(trim($v))->flip()->getHex(); },$txIds);
			
			function createMerkleBranch($targetHash, $hashes, &$proofs) {
				
				$newHashes = [];
	
				$totalTxIds = @count($hashes);
				
				if ($totalTxIds % 2 > 0) {
					$hashes[ $totalTxIds ] = $hashes[ $totalTxIds - 1 ];
				}
				
				$groupHashes = array_chunk($hashes, 2);
				
				foreach($groupHashes as $twoHash) {
					$newHash = hash('sha256', hex2bin(hash('sha256', hex2bin( implode("", $twoHash) ))));
					
					if ($twoHash[0] == $targetHash OR $twoHash[1] == $targetHash) {
						if ($twoHash[0] == $targetHash) {
							$proofs[] = [$twoHash[1], "right"];
						} else {
							$proofs[] = [$twoHash[0], "left"];
						}
						$targetHash = $newHash;
					}
					
					$newHashes[] = $newHash;
				}
				
				if (@count($newHashes) == 1) {
					return $newHashes[0];
				} else {
					return createMerkleBranch($targetHash, $newHashes,$proofs);
				}
			}
			
			if (count($txIds) > 1) {
				createMerkleBranch($txIds);
			}
			
			return $proofs;
		}
		
		$merkleProofs = createMerkleProof($_POST['txid'], $txIds);
	} catch (Exception $e) {
        $errmsg .= "Problem found. " . $e->getMessage();
    }
}

if ($errmsg) {
?>
	<div class="alert alert-danger">
		<strong>Error!</strong> <?php echo $errmsg?>
	</div>
<?php
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if ($merkleProofs) {
	?>
		<div class="alert alert-success">
			<h6 class="mt-3">Merkle Proofs</h6>
			<textarea class="form-control" rows="5" id="comment" readonly><?php echo json_encode($merkleProofs)?></textarea>
		</div>
	<?php
	} else {
	?>
		<div class="alert alert-success">
			<h6 class="mt-3">Merkle Proofs</h6>
			N/A
		</div>
	<?php 
	}
}
?>

<form action='' method='post'>

	<div class="form-group">
		<label for="txid">Target Tx id:</label>
		<input class="form-control" type='text' name='txid' id='txid' value='<?php echo $_POST['txid']?>'>
	</div>
	
	<div class="form-group">
		<label for="txids">Tx Ids (Follow TX order in block):</label>
		<textarea rows=10 class="form-control" name='txids' id='txids'><?php echo $_POST['txids']?></textarea>
		Each tx id must key in by press "Enter" and place as new line. For example, you can copy all tx ids from <a href="https://api.blockcypher.com/v1/btc/main/blocks/0000000000013b8ab2cd513b0261a14096412195a72a0c4827d229dcc7e0f7af" target="_blank"><img style='width:12px;height:12px;' src='../media/images/external_link.png'/></a>.
	</div>

	<input type='submit' class="btn btn-success btn-block"/>
</form>
<?php 
include_once("html_iframe_footer.php");