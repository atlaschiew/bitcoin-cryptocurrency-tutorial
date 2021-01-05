<?php 
use BitWasp\Bitcoin\Bitcoin;
use BitWasp\Bitcoin\Address\ScriptHashAddress;
use BitWasp\Bitcoin\Script\ScriptFactory;
use BitWasp\Bitcoin\Script\Opcodes;
use BitWasp\Bitcoin\Key\Factory\PublicKeyFactory;
use BitWasp\Bitcoin\Network\NetworkFactory;
use BitWasp\Buffertools\Buffer;
use BitWasp\Bitcoin\Locktime;
use BitWasp\Bitcoin\Transaction\TransactionInputInterface;

include_once "../libraries/vendor/autoload.php";

$placeholder['locktypevalue']['default'] = 'Please choose either relative time or relative height.';
$placeholder['locktypevalue']['timestamp'] = 'Accept only seconds (integer).';
$placeholder['locktypevalue']['timestamp_extra'] = "Granularity of 512 seconds. Spend is allow once chain\'s MTP >= UTXO\'s block MTP + Relative Time.";
$placeholder['locktypevalue']['blockheight'] = 'Relative height must be integer.';
$placeholder['locktypevalue']['blockheight_extra'] = "";

include_once("html_iframe_header.php");
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	try {
		
		$lockTimeObject = new Locktime();
		$networkClass   = $_POST['network'];
		Bitcoin::setNetwork(NetworkFactory::$networkClass());
		$publicKeyFactory = new PublicKeyFactory();
		
		if ($_POST['lock_type'] == 'timestamp') {
			$lockTypeValue = (int)$_POST['lock_type_value'];
			
			//enable granularity of 512 seconds
			$lockTypeValue = TransactionInputInterface::SEQUENCE_LOCKTIME_TYPE_FLAG | $lockTypeValue;
		} else if($_POST['lock_type'] == 'blockheight') {
			$lockTypeValue = (int)$_POST['lock_type_value'];
		} else {
			throw new Exception('Please choose either Relative Time or Relative Height.');
		}
		
		$opcodes = new Opcodes();
		
		if ($lockTypeValue >= 1 AND $lockTypeValue <= 16) {
			$opCodeName = "OP_{$lockTypeValue}";
			$locktimev = $opcodes->getOpByName($opCodeName);
			$isRelativeTime = false;
		} else {
			$lockTimeInt = (Buffer::int($lockTypeValue));
			$locktimev = $lockTimeInt->flip();
			$isRelativeTime = ($lockTimeInt->getInt() >> 22 & 0x1);
		}
		
		
		$publicKey = $publicKeyFactory->fromHex($_POST['public_key']);
		
		$redeemScript = ScriptFactory::sequence([$locktimev, Opcodes::OP_CHECKSEQUENCEVERIFY,Opcodes::OP_DROP, Opcodes::OP_DUP, Opcodes::OP_HASH160, $publicKey->getPubKeyHash(), Opcodes::OP_EQUALVERIFY, Opcodes::OP_CHECKSIG]);
		
		
		$p2sh = new ScriptHashAddress($redeemScript->getScriptHash());
	
	?>
		<div class="table-responsive">
			<table border=0 class='table'>
				<tr style='background-color:#f0f0f0'><td>Base58 address</td><td><?php echo $p2sh->getAddress();?></td></tr>
				<tr><td>Redeem Script Hex </td><td><?php echo $redeemScript->getHex();?></td></tr>
				<tr><td>Redeem Script Asm</td>
					<td>
						<?php 
						$opcodes = $redeemScript->getOpcodes();
						foreach( $redeemScript->getScriptParser()->decode() as $operation ) {
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
				
				<tr style='background-color:#f0f0f0'><td>Lock Type</td><td>Relative <?php echo !$isRelativeTime ? "Height" : "Time"  ?></td></tr>
				
				
				
				<tr><td>ScriptPubKey Hex </td><td><?php echo $p2sh->getScriptPubKey()->getHex()?></td></tr>
				<tr><td>ScriptPubKey Asm</td>
					<td>
						<?php 
						
						$opcodes = $redeemScript->getOpcodes();
						
						foreach( $p2sh->getScriptPubKey()->getScriptParser()->decode() as $operation ) {
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
		<label for="network">Network:</label> <a href="../bitcoin/bitcoin_tool_mtp.php" target="_blank">Check Height & Median Time Past (MTP).</a>
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
		<label for="public_key">Public Key Hex:</label>
		<input class="form-control" type='text' name='public_key' id='public_key' value='<?php echo $_POST['public_key']?>'>
	</div>
	
	<div class="form-group">
		<label>Lock Type:</label>
		
		<div class="form-check form-check-inline">
			<label class="form-check-label">
				<input type="radio" class="form-check-input" name="lock_type" value="timestamp"<?php echo $_POST['lock_type']=='timestamp' ? ' checked': ''?> onclick="
				var self = $(this);
				var lockTypeValueE = $('#lock_type_value');
				var lockTypeExtraE = $('#lock_type_extra');
				lockTypeValueE.attr('placeholder', '<?php echo $placeholder['locktypevalue']['timestamp']?>');				
				lockTypeExtraE.html('<?php echo htmlentities($placeholder['locktypevalue']['timestamp_extra'],ENT_QUOTES)?>');	
				">Relative Time
			</label>
		</div>
		<div class="form-check form-check-inline">
			<label class="form-check-label">
				<input type="radio" class="form-check-input" name="lock_type" value="blockheight"<?php echo $_POST['lock_type']=='blockheight' ? ' checked': ''?> onclick="
				var self = $(this);
				var lockTypeValueE = $('#lock_type_value');
				var lockTypeExtraE = $('#lock_type_extra');
				lockTypeValueE.attr('placeholder', '<?php echo $placeholder['locktypevalue']['blockheight']?>');				
				lockTypeExtraE.html('<?php echo $placeholder['locktypevalue']['blockheight_extra']?>');	
				">Relative Height
			</label>
		</div>
		
		<input class="form-control" type='text' name='lock_type_value' id='lock_type_value' value='<?php echo $_POST['lock_type_value']?>' placeholder="<?php echo $placeholder['locktypevalue'][ $_POST['lock_type']?$_POST['lock_type']:'default' ]?>">
		
		<span id='lock_type_extra'></span>
	</div>
	<input type='submit' class="btn btn-success btn-block"/>
</form>
<?php
include_once("html_iframe_footer.php");