<?php 
use BitWasp\Bitcoin\Bitcoin;
use BitWasp\Buffertools\Buffer;
use BitWasp\Bitcoin\Network\NetworkFactory;
use BitWasp\Bitcoin\Address\ScriptHashAddress;
use BitWasp\Bitcoin\Script\ScriptFactory;

include_once "../libraries/vendor/autoload.php";
include_once("html_iframe_header.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	try {
		
		$networkClass   = $_POST['network'];
		Bitcoin::setNetwork(NetworkFactory::$networkClass());
		$network        = Bitcoin::getNetwork();
		
		if (ctype_xdigit($_POST['redeem_script'])) {
			$script_pub_key = ScriptFactory::fromHex($_POST['redeem_script']);
			$opcodes = $script_pub_key->getOpcodes();
	
			$p2sh = new ScriptHashAddress($script_pub_key->getScriptHash());
			$p2sh_address = $p2sh->getAddress();
		} else {
			throw new Exception("Redeem script must be hex.");
		}
		
	
	?>
		<div class="table-responsive">
			<table border=0 class='table'>
				<tr style='background-color:#f0f0f0'><td>Base58 address</td><td><?php echo $p2sh_address;?></td></tr>
				<tr><td>Redeem Script Hex </td><td><?php echo $script_pub_key->getHex();?></td></tr>
				<tr><td>Redeem Script Asm</td>
					<td>
						<?php echo $script_pub_key->getScriptParser()->getHumanReadable();?>
					</td>
				</tr>
				
				<tr><td>Redeem Script Hash Hex</td><td><?php echo $script_pub_key->getScriptHash()->getHex();?></td></tr>
				
				<tr style='background-color:#f0f0f0'><td>ScriptPubKey Hex </td><td><?php echo $p2sh->getScriptPubKey()->getHex()?></td></tr>
				<tr style='background-color:#f0f0f0'><td>ScriptPubKey Asm</td>
					<td>
						<?php 
						foreach( $p2sh->getScriptPubKey()->getScriptParser()->decode() as $operation ) {
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
		<label for="redeem_script">Redeem Script (Hex)</label>
		
		<input class="form-control" type='text' name='redeem_script' id='redeem_script' value='<?php echo $_POST['redeem_script']?>'>
		
		* This script should be saved and should be shared with all the participants before a payment is made, so they may validate the authenticity of the address, it will also be used later to release the bitcoins.
		
	</div>
	<input type='submit' class="btn btn-success btn-block"/>
</form>
<?php
include_once("html_iframe_footer.php");