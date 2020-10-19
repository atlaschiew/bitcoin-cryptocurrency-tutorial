<?php 
use BitWasp\Bitcoin\Network\NetworkFactory;
use BitWasp\Bitcoin\Bitcoin;
use BitWasp\Buffertools\Buffer;
use BitWasp\Bitcoin\Key\Factory\PrivateKeyFactory;
use BitWasp\Bitcoin\Address\AddressCreator;
use BitWasp\Bitcoin\Address\Base58AddressInterface;
use BitWasp\Bitcoin\Transaction\Factory\TxBuilder;
use BitWasp\Bitcoin\Transaction\TransactionFactory;
use BitWasp\Bitcoin\Transaction\TransactionOutput;
use BitWasp\Bitcoin\Transaction\Factory\Signer;
use BitWasp\Bitcoin\Script\ScriptFactory;
use BitWasp\Bitcoin\Script\Classifier\OutputClassifier;
use BitWasp\Bitcoin\Script\ScriptType;

include_once "../libraries/vendor/autoload.php";

include_once("html_iframe_header.php");

$no_of_inputs = 10;
$no_of_outputs = 10;

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
			
		foreach(range(1,$_POST['no_of_inputs']) as $this_input) {
			$utxo_hash = trim($_POST["utxo_hash_{$this_input}"]);
			$utxo_n_output = trim($_POST["utxo_n_{$this_input}"]);
			$privkeyhex = trim($_POST["privkey_{$this_input}"]);
			$utxo_script = trim($_POST["utxo_script_{$this_input}"]);
			
			if (strlen($utxo_hash)>0 AND strlen($utxo_n_output) > 0 AND strlen($privkeyhex) > 0) {
				$spendTx = $spendTx->input($utxo_hash, $utxo_n_output);
				$signItems[] = [$privkeyhex, $utxo_script];
			} else {
				throw new Exception("Error in 'input#{$this_input}'.");
			}
		}
		
		foreach(range(1,$_POST['no_of_outputs']) as $this_output) {
			
			$address = trim($_POST["address_{$this_output}"]);
			
			$amount = trim($_POST["amount_{$this_output}"]);
			$recipient = $addrCreator->fromString($address);
			
			if (!strlen($address) or !strlen($amount)) {
				throw new Exception("Error in 'output#{$this_output}'.");
			}
			
			if (!$recipient instanceof Base58AddressInterface) {
				throw new Exception("Invalid P2PKH address in 'output#{$this_output}' (Check base58Address).");
			} 
			
			$decodeScript = (new OutputClassifier())->decode($recipient->getScriptPubKey());
			
			if ($decodeScript->getType() != ScriptType::P2PKH) {
				throw new Exception("Invalid P2PKH address in 'output#{$this_output}' (Check scriptPubKey).");
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
			
			
			//chiew continue here tmr
			$input = $signer->input($nIn, $txOutput);
			
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
						foreach(range(1,$no_of_inputs) as $this_input) {
							echo "<option value='{$this_input}'".($this_input == $_POST['no_of_inputs'] ? " selected": "").">{$this_input}</option>";
						}
						?>
					</select>
				</div>
			</div>
			
			<?php
			$selected_n_inputs = is_numeric($_POST['no_of_inputs']) ? $_POST['no_of_inputs'] : 1;
			
			foreach(range(1,$no_of_inputs) as $this_input) {
			?>
			
				<div class="form-row" id='row_input_<?php echo $this_input?>' style="<?php echo ($this_input > $selected_n_inputs) ? "display:none" : "display:;"?>">
				
					<div class="form-group  col-sm-1">
						#<?php echo $this_input?> 
					</div>
					<div class="form-group  col-sm-3">
						
						<input class="form-control" title="UTXO Tx Hash" placeholder='UTXO Tx Hash' type='text' name='utxo_hash_<?php echo $this_input?>' value='<?php echo $_POST["utxo_hash_{$this_input}"]?>'>
					</div>
					<div class="form-group  col-sm-1">
						<input class="form-control" title="UTXO N Output" placeholder='N' type='text' name='utxo_n_<?php echo $this_input?>' value='<?php echo $_POST["utxo_n_{$this_input}"]?>'>
					</div>
					
					<div class="form-group  col-sm-3">
						<input class="form-control" title="UTXO ScriptPubKey" placeholder='UTXO ScriptPubKey' type='text' name='utxo_script_<?php echo $this_input?>' value='<?php echo $_POST["utxo_script_{$this_input}"]?>'>
					</div>
					<div class="form-group  col-sm-4">
						<input class="form-control" title="Private Key Hex, for signing purpose." placeholder='Private Key Hex' type='text' name='privkey_<?php echo $this_input?>' value='<?php echo $_POST["privkey_{$this_input}"]?>'>
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
						foreach(range(1,$no_of_outputs) as $this_output) {
							echo "<option value='{$this_output}'".($this_output == $_POST['no_of_outputs'] ? " selected": "").">{$this_output}</option>";
						}
						?>
					</select>
				</div>
			</div>
			<?php
			$selected_n_outputs = is_numeric($_POST['no_of_outputs']) ? $_POST['no_of_outputs'] : 1;
			
			
			foreach(range(1,$no_of_outputs) as $this_output) {
			?>
				<div class="form-row" id='row_output_<?php echo $this_output?>' style="<?php echo ($this_output > $selected_n_outputs) ? "display:none" : "display:;"?>">
					<div class="form-group col-sm-1">
						#<?php echo $this_output?> 
					</div>
					
					<div class="form-group col-sm-6">
						<input class="form-control" placeholder='P2PKH Address' type='text' name='address_<?php echo $this_output?>' value='<?php echo $_POST["address_{$this_output}"]?>'>
					</div>
					<div class="form-group col-sm-5">
						<input class="form-control" placeholder='Amount' type='text' name='amount_<?php echo $this_output?>' value='<?php echo $_POST["amount_{$this_output}"]?>'>
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