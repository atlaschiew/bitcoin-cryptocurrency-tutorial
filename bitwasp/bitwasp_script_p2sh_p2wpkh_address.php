<?php 
use BitWasp\Buffertools\Buffer;
use BitWasp\Bitcoin\Address\ScriptHashAddress;
use BitWasp\Bitcoin\Bitcoin;
use BitWasp\Bitcoin\Crypto\Random\Random;
use BitWasp\Bitcoin\Key\Factory\PrivateKeyFactory;
use BitWasp\Bitcoin\Network\NetworkFactory;
use BitWasp\Bitcoin\Script\WitnessProgram;

include_once "../libraries/vendor/autoload.php";
include_once("html_iframe_header.php");

if ($_GET['tab'] == 'form1_tabitem1' AND $_SERVER['REQUEST_METHOD'] == 'POST') {
	try {
		
		$networkClass   = $_POST['network'];
		Bitcoin::setNetwork(NetworkFactory::$networkClass());
		$network        = Bitcoin::getNetwork();
		$privKeyFactory = new PrivateKeyFactory();
	
		if (!$_POST['input'] OR ctype_xdigit($_POST['input'])) 
		{
			if (!$_POST['input']) 
			{ 
				$rbg = new Random();
				
				if ($_POST['compression'] == 'y') {
					$privateKey = $privKeyFactory->generateCompressed($rbg);
				} else {
					$privateKey = $privKeyFactory->generateUncompressed($rbg);
				}
			} else {
				if ($_POST['compression'] == 'y') {
					$privateKey = $privKeyFactory->fromHexCompressed($_POST['input']);
				} else {
					$privateKey = $privKeyFactory->fromHexUncompressed($_POST['input']);
				}
			}
		} else {
			$privateKey = $privKeyFactory->fromWIF($_POST['input'], $network);
		}
		
		$publicKey  = $privateKey->getPublicKey();
		$publicKeyHash = $publicKey->getPubKeyHash();
		$p2wpkhWP = WitnessProgram::v0($publicKeyHash);
		$p2shRedeemScript = $p2wpkhWP->getScript();
		$p2shRedeemScriptHash = $p2shRedeemScript->getScriptHash();
		$p2shP2wpkh = new ScriptHashAddress($p2shRedeemScriptHash);
	
	?>
		<div class="table-responsive">
			<table border=0 class='table'>
				<tr style='background-color:#f0f0f0'><td>Base58 Address</td><td><?php echo $p2shP2wpkh->getAddress()?></td></tr>
				<tr><td>Private Key Hex</td><td><?php echo $privateKey->getHex()?></td></tr>
				<tr><td>Private Key Wif</td><td><?php echo $privateKey->toWif()?></td></tr>
				<tr><td>Has Compression?</td><td><?php echo $privateKey->isCompressed() ? "Yes" : "No"?></td></tr>
				<tr style='background-color:#f0f0f0'><td>Public Key Hex</td><td><?php echo $publicKey->getHex()?></td></tr>
				<tr style='background-color:#f0f0f0'><td>Has Compression?</td><td><?php echo $publicKey->isCompressed()? "Yes" : "No"?></td></tr>
				
				<tr style='background-color:#f0f0f0'><td><span data-toggle="tooltip" title="HASH160 (Publiy Key Hex)" class='explaination'>Publiy Key Hash Hex</span></td><td><?php echo $publicKey->getPubKeyHash()->getHex()?></td></tr>
				
				<tr><td>Witness Version</td><td><?php echo $p2wpkhWP->getVersion()?></td></tr>
				<tr><td>Witness Program</td><td><?php echo $p2wpkhWP->getProgram()->getHex()?></td></tr>
				
				<tr style='background-color:#f0f0f0'><td>Redeem Script Hex</td><td><?php echo $p2shRedeemScript->getHex()?></td></tr>
				<tr style='background-color:#f0f0f0'>
					<td>Redeem Script Asm</td>
					<td>
						<?php 
						$opcodes = $p2shRedeemScript->getOpcodes();
						
						foreach( $p2shRedeemScript->getScriptParser()->decode() as $operation ) {
							
							try {
								$op = $opcodes->getOp($operation->getOp());
							} catch (\RuntimeException $e) {
								$op = "";
							}
							
							echo $op ? $op . " " : "";
							
							if ($op != 'OP_0' AND $operation->isPush()) {
								$bytes = (int)ltrim($op, 'OP_PUSHDATA');
								$bytes = $bytes > 0 ? $bytes : 1;
								
								$hexsize = Buffer::int($operation->getDataSize(), $bytes)->getHex();
								echo htmlentities("{$hexsize}<{$operation->getData()->getHex()}> ");
							} 
						}
						?>
					</td>
				</tr>
				<tr style='background-color:#f0f0f0'><td>Redeem Script Hash</td><td><?php echo $p2shRedeemScriptHash->getHex()?></td></tr>
				<tr><td>ScriptPubKey Hex </td><td><?php echo $p2shP2wpkh->getScriptPubKey()->getHex()?></td></tr>
				<tr><td>ScriptPubKey Asm</td>
					<td>
						<?php 
						$opcodes = $p2shP2wpkh->getScriptPubKey()->getOpcodes();
						
						foreach( $p2shP2wpkh->getScriptPubKey()->getScriptParser()->decode() as $operation ) {
							
							try {
								$op = $opcodes->getOp($operation->getOp());
							} catch (\RuntimeException $e) {
								$op = "";
							}
							
							echo $op ? $op . " " : "";
							
							if ($op != 'OP_0' AND $operation->isPush()) {
								$bytes = (int)ltrim($op, 'OP_PUSHDATA');
								$bytes = $bytes > 0 ? $bytes : 1;
								
								$hexsize = Buffer::int($operation->getDataSize(), $bytes)->getHex();
								echo htmlentities("{$hexsize}<{$operation->getData()->getHex()}> ");
							} 
						}
						?>
					</td>
				</tr>
			</table>
		</div>
<?php 
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
?>
<form action='?tab=form1_tabitem1#hashtag1' method='post'>
	<div class="form-group">
		<label for="network">Network:</label>
		<select id="network" name="network" class="form-control" >
			<?php
			$networks = get_class_methods(new NetworkFactory());
			foreach($networks as $network) {
				echo "<option value='{$network}'".($network == $_POST['network'] ? " selected": "").">{$network}</option>";
			}
			?>
		</select>
	</div>
	<div class="form-group">
		<label for="input">Private Key (Hex) / WIF:</label>
		
		<input class="form-control" type='text' name='input' id='input' value='<?php echo $_POST['input']?>'>
		* Put empty if you want system assign you a random private key.
	</div>
	<div class="form-group">
		<label for="compression" >Compression:</label>
		<select name="compression" class="form-control"  id='compression'>
			<?php
			$yesno = array("y"=>"Yes", "n"=>"No");
			foreach($yesno as $yesno_k=>$yesno_v) {
				echo "<option value='{$yesno_k}'".($yesno_k == $_POST['compression'] ? " selected": "").">{$yesno_v}</option>";
			}
			?>
		</select>
	</div>
	<input type='submit' class="btn btn-success btn-block"/>
</form>
<?php
include_once("html_iframe_footer.php");