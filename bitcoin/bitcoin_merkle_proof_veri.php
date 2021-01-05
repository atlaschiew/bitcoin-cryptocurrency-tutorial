<?php 

use BitWasp\Buffertools\Buffer;

include_once "../libraries/vendor/autoload.php";
include_once("html_iframe_header.php");

$result = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	
	try {
		
		$merkleProofs = json_decode($_POST['proofs']);
		if (json_last_error() != JSON_ERROR_NONE) {
			throw new Exception("Merkle Proofs (JSON) has error.");
		}
		
		$txId = Buffer::hex($_POST['txid'])->flip()->getHex();
		$toBeConcatHash = $txId;//tx id in litle endian
		foreach($merkleProofs as $proof) {
			$hash = $proof[0];
			$dir = $proof[1];
	
			if ($dir == 'left') {
				$toBeConcatHash = hash('sha256', hex2bin(hash('sha256', hex2bin($hash.$toBeConcatHash))));
			} else {
				$toBeConcatHash = hash('sha256', hex2bin(hash('sha256', hex2bin($toBeConcatHash.$hash ))));
			}
		}
		$merkleRoot = Buffer::hex($toBeConcatHash)->flip()->getHex();//merkle root in big endian

		
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
			<tr>
				<td>Merkle Root</td>
				<?php 
				if ($merkleRoot == $_POST['root']) { 
				?>
				<td style='color:green'>
					<?php echo $merkleRoot;?> <b>Matched!</b>
				</td>
				<?php
				} else {
				?>
				<td style='color:red'>
					<?php echo $merkleRoot;?> <b>Not Matched!</b>
				</td>
				<?php
				}
				?>
			</tr>
			
		</table>
	</div>

<?php
}
?>
<form action='' method='post'>

	<div class="form-group">
		<label for="root">Merkle Root:</label>
		<input class="form-control" type='text' name='root' id='root' value='<?php echo $_POST['root']?>'>
	</div>
	
	<div class="form-group">
		<label for="txid">Target Tx id:</label>
		<input class="form-control" type='text' name='txid' id='txid' value='<?php echo $_POST['txid']?>'>
	</div>
	
	<div class="form-group">
		<label for="proofs">Merkle Proofs (JSON):</label>
		<input class="form-control" name='proofs' id='proofs' value='<?php echo $_POST['proofs']?>'/>
	</div>

	<input type='submit' class="btn btn-success btn-block"/>
</form>
<?php 
include_once("html_iframe_footer.php");