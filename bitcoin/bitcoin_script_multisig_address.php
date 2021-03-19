<?php 
use BitWasp\Bitcoin\Bitcoin;
use BitWasp\Bitcoin\Network\NetworkFactory;
use BitWasp\Buffertools\Buffer;
use BitWasp\Bitcoin\Key\Factory\PublicKeyFactory;
use BitWasp\Bitcoin\Script\ScriptFactory;
use BitWasp\Bitcoin\Script\P2shScript;
use BitWasp\Bitcoin\Script\Opcodes;

include_once "../libraries/vendor/autoload.php";

$M_N_Range = range(1,15);

include_once("html_iframe_header.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	try {
		
		$networkClass   = $_POST['network'];
		Bitcoin::setNetwork(NetworkFactory::$networkClass());
		$network        = Bitcoin::getNetwork();
		$pubKeys = [];
		
		$publicKeyFactory = new PublicKeyFactory();
		if (!in_array($_POST['reqsig'], $M_N_Range)) {
			throw new Exception("'Required Signature' value is not valid.");
		} else {
			foreach($_POST['pubkey'] as $pubkey_hex) {
				if (strlen($pubkey_hex) > 0 AND !ctype_xdigit($pubkey_hex)) {
					throw new Exception("Public key must be hex.");
				}
				
				if (strlen($pubkey_hex) > 0 AND ctype_xdigit($pubkey_hex)) {
					$validPubKeys[] = $publicKeyFactory->fromHex($pubkey_hex);;
				}
			}
		}
		
		if ($_POST['reqsig'] > count($validPubKeys)) {
			throw new Exception("Required signature value should not exceed number of public key.");
		}  
		
		// make a n-of-m multisignature script
		$multisig = ScriptFactory::scriptPubKey()->multisig($_POST['reqsig'], $validPubKeys, $sort = false);
		
		// use the P2shScript 'decorator' to 'extend' script with extra functions relevant to a P2SH script
		$redeemScript = new P2shScript($multisig);
		
		$scriptPubKey = $redeemScript->getOutputScript();
		
		$opcodes = $scriptPubKey->getOpcodes();
	
	?>
		<div class="table-responsive">
			<h6 class="mt-3">P2SH.Multisig</h6>
			<table border=0 class='table'>
				<tr style='background-color:#f0f0f0'><td>Base58 address</td><td><?php echo $redeemScript->getAddress()->getAddress();?></td></tr>
				<tr><td>Redeem Script Hex </td><td><?php echo $redeemScript->getHex();?></td></tr>
				<tr><td>Redeem Script Asm</td>
					<td>
						<?php 
						foreach( $redeemScript->getScriptParser()->decode() as $operation ) {
							if ($operation->isPush()) {
								echo htmlentities("<{$operation->getData()->getHex()}> ");
							} else {
								echo $opcodes->getOp($operation->getOp()) . " " ;
							}
						}
						?>
					</td>
				</tr>
				
				<tr><td>Redeem Script Hash Hex</td><td><?php echo $redeemScript->getScriptHash()->getHex();?></td></tr>
				
				<tr style='background-color:#f0f0f0'><td>ScriptPubKey Hex </td><td><?php echo $scriptPubKey->getHex()?></td></tr>
				<tr style='background-color:#f0f0f0'><td>ScriptPubKey Asm</td>
					<td>
						<?php 
						foreach( $scriptPubKey->getScriptParser()->decode() as $operation ) {
							if ($operation->isPush()) {								
								echo htmlentities("<{$operation->getData()->getHex()}> ");
							} else {
								echo $opcodes->getOp($operation->getOp()) . " " ;
							}
						}
						?>
					</td>
				</tr>
			</table>
			
			<?php
			if (@count($validPubKeys) <= 3) {
			?>
				<h6 class="mt-3">P2MS</h6>
				<table border=0 class='table'>
					<tr><td>ScriptPubKey Hex </td><td><?php echo $redeemScript->getHex();?></td></tr>
					
					<tr><td>ScriptPubKey Asm</td>
						<td>
							<?php 
							foreach( $redeemScript->getScriptParser()->decode() as $operation ) {
								if ($operation->isPush()) {
									
									echo htmlentities("<{$operation->getData()->getHex()}> ");
								} else {
									echo $opcodes->getOp($operation->getOp()) . " " ;
								}
							}
							?>
						</td>
					</tr>
				</table>
			<?php
			}
			?>
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
<form action='' method='post'>
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
		<label for="pubkey">Public Key Hex:</label>
		
		<div class="input-group mb-3">
			<input class="form-control" type='text' name='pubkey[]' id='pubkey' value='<?php echo $_POST['pubkey'][0]?>'>
			<div class="input-group-append">
				<input class="btn btn-success" type="button" value="+" onclick="$('#multisig-pubkey-holder').find('div').first().clone().appendTo('#multisig-pubkey-holder')"/>
			</div>
		</div>
	</div>
	<?php
	$displayPublickey = count($_POST['pubkey'])-1;
	$displayPublickey = max(1, $displayPublickey);
	?>
	<div id="multisig-pubkey-holder" class="form-group">
		
		<?php
		foreach(range(1, $displayPublickey) as $n) {
		?>
		<div class="input-group mb-3">
			<input class="form-control" type='text' name='pubkey[]' value='<?php echo $_POST['pubkey'][$n]?>'>
			<div class="input-group-append">
				<input class="btn btn-success" type="button" value=" - " onclick="
					var length = $(this).closest('#multisig-pubkey-holder').find('input[value=\' - \']').length;
					if (length > 1) {
						$(this).parent('div').parent('div').remove();
					} else {
						alert('At least 2 public keys are required');
					}
				"/>
			</div>
		</div>
		<?Php
		}
		?>
		
	</div>
	
	<div class="form-group">
		<label for="reqsig">Required Signature To Spend:</label>
		<select id="reqsig" name="reqsig" class="form-control" >
			<?php
			foreach($M_N_Range as $k) {
				echo "<option value='{$k}'".($k == $_POST['reqsig'] ? " selected": "").">{$k}</option>";
			}
			?>
		</select>
	</div>
	
	
	<input type='submit' class="btn btn-success btn-block"/>
</form>
<?php
include_once("html_iframe_footer.php");