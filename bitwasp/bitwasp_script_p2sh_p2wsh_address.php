<?php 
use BitWasp\Bitcoin\Address\ScriptHashAddress;
use BitWasp\Bitcoin\Bitcoin;
use BitWasp\Buffertools\Buffer;
use BitWasp\Bitcoin\Network\NetworkFactory;
use BitWasp\Bitcoin\Script\WitnessProgram;
use BitWasp\Bitcoin\Script\ScriptFactory;

include_once "../libraries/vendor/autoload.php";
include_once("html_iframe_header.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	try {
		
		$networkClass   = $_POST['network'];
		Bitcoin::setNetwork(NetworkFactory::$networkClass());
		$network        = Bitcoin::getNetwork();
		
		$witnessScript = ScriptFactory::fromHex($_POST['redeem_script']);
		$witnessScriptHash = $witnessScript->getWitnessScriptHash();/*sha256*/
		$p2wshWP = WitnessProgram::v0($witnessScriptHash);
		
		$p2shRedeemScript = $p2wshWP->getScript();
		
		
		$p2shRedeemScriptHash = $p2shRedeemScript->getScriptHash();
		$p2shP2wsh = new ScriptHashAddress($p2shRedeemScriptHash);
		
	?>
		<div class="table-responsive">
			<table border=0 class='table'>
				<tr style='background-color:#f0f0f0'><td>Base58 Address</td><td><?php echo $p2shP2wsh->getAddress()?></td></tr>
				<tr><td><span data-toggle="tooltip" title="Witness script is redeem script in P2WSH version" class='explaination'>Witness Script Hex</span></td><td><?php echo $witnessScript->getHex()?></td></tr>
				<tr><td>Witness Script Asm</td>
					<td>
					<?php
					$opcodes = $witnessScript->getOpcodes();
					
					foreach( $witnessScript->getScriptParser()->decode() as $operation ) {
							
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
				<tr><td>Witness Version</td><td><?php echo $p2wshWP->getVersion()?></td></tr>
				<tr><td>Witness Program</td><td><?php echo $p2wshWP->getProgram()->getHex()?></td></tr>
				
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
				<tr><td>ScriptPubKey Hex </td><td><?php echo $p2shP2wsh->getScriptPubKey()->getHex()?></td></tr>
				<tr><td>ScriptPubKey Asm</td>
					<td>
						<?php 
						$opcodes = $p2shP2wsh->getScriptPubKey()->getOpcodes();
						
						foreach( $p2shP2wsh->getScriptPubKey()->getScriptParser()->decode() as $operation ) {
							
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
		<label for="redeem_script"><span data-toggle="tooltip" title="Witness script is redeem script in P2WSH version" class='explaination'>Witness Script Hex</span>: </label>
		
		<input class="form-control" type='text' name='redeem_script' id='redeem_script' value='<?php echo $_POST['redeem_script']?>'>
		* This script should be saved and should be shared with all the participants before a payment is made, so they may validate the authenticity of the address, it will also be used later to release the bitcoins.
	</div>
	
	<input type='submit' class="btn btn-success btn-block"/>
</form>
<?php
include_once("html_iframe_footer.php");