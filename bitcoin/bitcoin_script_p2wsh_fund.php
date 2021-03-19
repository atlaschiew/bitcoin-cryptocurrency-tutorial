<?php 
use BitWasp\Bitcoin\Bitcoin;
use BitWasp\Buffertools\Buffer;
use BitWasp\Bitcoin\Key\Factory\PrivateKeyFactory;
use BitWasp\Bitcoin\Network\NetworkFactory;
use BitWasp\Bitcoin\Address\AddressCreator;
use BitWasp\Bitcoin\Address\Bech32AddressInterface;
use BitWasp\Bitcoin\Transaction\Factory\TxBuilder;
use BitWasp\Bitcoin\Transaction\TransactionFactory;
use BitWasp\Bitcoin\Transaction\TransactionOutput;
use BitWasp\Bitcoin\Transaction\Factory\Signer;
use BitWasp\Bitcoin\Script\ScriptFactory;
use BitWasp\Bitcoin\Script\Classifier\OutputClassifier;
use BitWasp\Bitcoin\Script\ScriptType;

include_once "../libraries/vendor/autoload.php";
include_once("html_iframe_header.php");

$noOfInputs = 10;
$noOfOutputs = 10;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	try {
		$networkClass   = $_POST['network'];
		
		
		Bitcoin::setNetwork(NetworkFactory::$networkClass());
		
		$network        = Bitcoin::getNetwork();
		$ecAdapter      = Bitcoin::getEcAdapter();
		$privKeyFactory = new PrivateKeyFactory();
		
		$addrCreator = new AddressCreator();
		
		$spendTx = TransactionFactory::build();
		
		$signItems = [];
		
		
		if (!is_numeric($_POST['no_of_inputs']) OR !is_numeric($_POST['no_of_outputs'])) {
			throw new Exception("Error in 'no_of_inputs' or 'no_of_outputs'.");
		}
			
		foreach(range(1,$_POST['no_of_inputs']) as $thisInput) {
			$utxoHash = trim($_POST["utxo_hash_{$thisInput}"]);
			$utxoNOutput = trim($_POST["utxo_n_{$thisInput}"]);
			$privkeyhex = trim($_POST["privkey_{$thisInput}"]);
			$utxoScript = trim($_POST["utxo_script_{$thisInput}"]);
			
			if (strlen($utxoHash)>0 AND strlen($utxoNOutput) > 0 AND strlen($privkeyhex) > 0) {
				$spendTx = $spendTx->input($utxoHash, $utxoNOutput);
				$signItems[] = [$privkeyhex, $utxoScript];
			} else {
				throw new Exception("Error in 'input#{$thisInput}'.");
			}
		}
		
		foreach(range(1,$_POST['no_of_outputs']) as $thisOutput) {
			
			$address = trim($_POST["address_{$thisOutput}"]);
			$amount = trim($_POST["amount_{$thisOutput}"]);
			
			$recipient = $addrCreator->fromString($address);
			
			if (!strlen($address) or !strlen($amount)) {
				throw new Exception("Error in 'output#{$thisOutput}'.");
			}
			
			if (!$recipient instanceof Bech32AddressInterface) {
				throw new Exception("Invalid P2WSH address in 'output#{$thisOutput}' (Check bech32Address).");
			} 
			
			$decodeScript = (new OutputClassifier())->decode($recipient->getScriptPubKey());
			
			if ($decodeScript->getType() != ScriptType::P2WSH) {
				throw new Exception("Invalid P2WSH address in 'output#{$thisOutput}' (Check scriptPubKey).");
			}
			
			$spendTx = $spendTx->payToAddress($amount, $recipient);
		}
		
		$thisTx = $spendTx->get();
		
		$signer = new Signer($thisTx, $ecAdapter);
		
		foreach($signItems as $nIn=>$signItem) {
			$privateKey = $privKeyFactory->fromHexCompressed($signItem[0]);
			
			$scriptPubKey = ScriptFactory::fromHex($signItem[1]);
			
			
			$txOutput = new TransactionOutput(0, $scriptPubKey );
			$signer = $signer->sign($nIn, $privateKey, $txOutput);
			
		}
		
	?>
		<div class="alert alert-success">
			<h6 class="mt-3">Final TX Hex</h6>
			
			<textarea class="form-control" rows="5" id="comment" readonly><?php echo $signer->get()->getHex();?></textarea>
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
		<label for="network">Network: </label>
		<select name="network" id="network" class="form-control">
			<?php
			$networks = get_class_methods(new NetworkFactory());
			foreach($networks as $network) {
				echo "<option value='{$network}'".($network == $_POST['network'] ? " selected": "").">{$network}</option>";
			}
			?>
		</select>
	</div>
	
	<div class="row">
		<div class="col-sm-6">
			
			<div class="form-row">
				<div class="form-group col">
					<label for="no_of_inputs">Inputs: </label> 
					<select class="form-control" id="no_of_inputs" name='no_of_inputs' style='width:auto;' onchange="
					var self = $(this);
					var thisvalue = self.val();
					var form = self.closest('form');
					$('div[id^=row_input_]',form).hide();
					for(var i=1; i<= thisvalue; i++) { 
						$('div[id=row_input_'+  i + ']',form).show();
					}
					">
						<?php
						foreach(range(1,$noOfInputs) as $thisInput) {
							echo "<option value='{$thisInput}'".($thisInput == $_POST['no_of_inputs'] ? " selected": "").">{$thisInput}</option>";
						}
						?>
					</select>
				</div>
			</div>
			
			<?php
			$selectedNInputs = is_numeric($_POST['no_of_inputs']) ? $_POST['no_of_inputs'] : 1;
			
			foreach(range(1,$noOfInputs) as $thisInput) {
			?>
			
				<div class="form-row" id='row_input_<?php echo $thisInput?>' style="<?php echo ($thisInput > $selectedNInputs) ? "display:none" : "display:;"?>">
				
					<div class="form-group  col-sm-1">
						#<?php echo $thisInput?> 
					</div>
					<div class="form-group  col-sm-3">
						
						<input class="form-control" title="UTXO Tx Hash" placeholder='UTXO Tx Hash' type='text' name='utxo_hash_<?php echo $thisInput?>' value='<?php echo $_POST["utxo_hash_{$thisInput}"]?>'>
					</div>
					<div class="form-group  col-sm-1">
						<input class="form-control" title="UTXO N Output" placeholder='N' type='text' name='utxo_n_<?php echo $thisInput?>' value='<?php echo $_POST["utxo_n_{$thisInput}"]?>'>
					</div>
					
					<div class="form-group  col-sm-3">
						<input class="form-control" title="UTXO ScriptPubKey" placeholder='UTXO ScriptPubKey' type='text' name='utxo_script_<?php echo $thisInput?>' value='<?php echo $_POST["utxo_script_{$thisInput}"]?>'>
					</div>
					<div class="form-group  col-sm-4">
						<input class="form-control" title="Private Key Hex, for signing purpose." placeholder='Private Key Hex' type='text' name='privkey_<?php echo $thisInput?>' value='<?php echo $_POST["privkey_{$thisInput}"]?>'>
					</div>
				</div>
			<?php
			}
			?>
		</div>
		<div class="col-sm-6">
			<div class="form-row">
				<div class="form-group col">
					<label for="no_of_outputs">Outputs:</label> <select class="form-control" id="no_of_outputs" name='no_of_outputs' style='width:auto;' onchange="
					var self = $(this);
					var thisvalue = self.val();
					var form = self.closest('form');
					$('div[id^=row_output_]',form).hide();
					for(var i=1; i<= thisvalue; i++) { 
						$('div[id=row_output_'+  i + ']',form).show();
					}
					">
						<?php
						foreach(range(1,$noOfOutputs) as $thisOutput) {
							echo "<option value='{$thisOutput}'".($thisOutput == $_POST['no_of_outputs'] ? " selected": "").">{$thisOutput}</option>";
						}
						?>
					</select>
				</div>
			</div>
			<?php
			$selectedNOutputs = is_numeric($_POST['no_of_outputs']) ? $_POST['no_of_outputs'] : 1;
			
			
			foreach(range(1,$noOfOutputs) as $thisOutput) {
			?>
				<div class="form-row" id='row_output_<?php echo $thisOutput?>' style="<?php echo ($thisOutput > $selectedNOutputs) ? "display:none" : "display:;"?>">
					<div class="form-group col-sm-1">
						#<?php echo $thisOutput?> 
					</div>
					
					<div class="form-group col-sm-6">
						<input class="form-control" placeholder='P2WSH Address' type='text' name='address_<?php echo $thisOutput?>' value='<?php echo $_POST["address_{$thisOutput}"]?>'>
					</div>
					<div class="form-group col-sm-5">
						<input class="form-control" placeholder='Amount' type='text' name='amount_<?php echo $thisOutput?>' value='<?php echo $_POST["amount_{$thisOutput}"]?>'>
					</div>
				</div>
	<?php
			}
	?>
		</div>
	</div>
	<input type='submit' class="btn btn-success btn-block"/>
</form>
<?php
include_once("html_iframe_footer.php");