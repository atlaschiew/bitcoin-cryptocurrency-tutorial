<?php 

use BitWasp\Buffertools\Buffer;

include_once "../libraries/vendor/autoload.php";
include_once("html_iframe_header.php");

$result = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	try {
		$txIds = explode("\n", $_POST['txids']);
		$merkleRoot = "";
		
		function createMerkleRoot($txIds) {
			
			$txIds = array_map(function ($v) { $result = Buffer::hex(trim($v));return $result->flip()->getHex(); },$txIds);
			
			function createMerkleBranch($hashes) {
				
				$newHashes = [];
	
				$totalTxIds = @count($hashes);
				
				if ($totalTxIds % 2 > 0) {
					$hashes[ $totalTxIds ] = $hashes[ $totalTxIds - 1 ];
				}
				
				$groupHashes = array_chunk($hashes, 2);
				
				foreach($groupHashes as $twoHash) {
					$newHashes[] = hash('sha256', hex2bin(hash('sha256', hex2bin( implode("", $twoHash) ))));
				}
				
				if (@count($newHashes) == 1) {
					return $newHashes[0];
				} else {
					return createMerkleBranch($newHashes);
				}
			}
			
			if (count($txIds) == 1) {
				$merkleRoot = $txIds[0];
			} else {
				$merkleRoot = createMerkleBranch($txIds);
			}
			
			$result = Buffer::hex($merkleRoot);
			return $result->flip()->getHex();
		}
		
		$merkleRoot = createMerkleRoot($txIds);
		
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

if ($merkleRoot) {
?>
	<div class="table-responsive">
		<table border=0 class='table'>
			<tr><td>Merkle Root</td><td><?php echo $merkleRoot;?></td></tr>
		</table>
	</div>
<?php
}
?>
<form action='' method='post'>
	<div class="form-group">
		<label for="txids">Tx Ids (Follow TX order in block):</label>
		<textarea rows=10 class="form-control" name='txids' id='txids'><?php echo $_POST['txids']?></textarea>
		Each tx id must key in by press "Enter" and place as new line. For example, you can copy all tx ids from <a href="https://api.blockcypher.com/v1/btc/main/blocks/0000000000013b8ab2cd513b0261a14096412195a72a0c4827d229dcc7e0f7af" target="_blank"><img style='width:12px;height:12px;' src='../media/images/external_link.png'/></a> and match the generated merkle root with merkle root in block.
	</div>

	<input type='submit' class="btn btn-success btn-block"/>
</form>
<?php 
include_once("html_iframe_footer.php");