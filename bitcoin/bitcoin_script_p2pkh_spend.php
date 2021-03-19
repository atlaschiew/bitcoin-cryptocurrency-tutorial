<?php 
use BitWasp\Buffertools\Buffer;
use BitWasp\Bitcoin\Network\NetworkFactory;
use BitWasp\Bitcoin\Address\AddressCreator;
use BitWasp\Bitcoin\Address\PayToPubKeyHashAddress;
use BitWasp\Bitcoin\Bitcoin;
use BitWasp\Bitcoin\Key\Factory\PrivateKeyFactory;
use BitWasp\Bitcoin\Transaction\Factory\Signer;
use BitWasp\Bitcoin\Transaction\TransactionFactory;
use BitWasp\Bitcoin\Transaction\TransactionOutput;
use BitWasp\Bitcoin\Script\Classifier\OutputClassifier;
use BitWasp\Bitcoin\Script\ScriptType;
use BitWasp\Bitcoin\Script\ScriptFactory;
use BitWasp\Bitcoin\Signature\TransactionSignature;

include_once "../libraries/vendor/autoload.php";

$noOfInputs = 10;
$noOfOutputs = 10;

if ($_SERVER['REQUEST_METHOD'] == 'GET' AND $_GET['ajax'] == '1') {
	$data = [];
	if (!ctype_xdigit($_GET['utx'])) {
		$data = ["error"=>"UTX must be hex."];
	} else {
		$utxHex = $_GET['utx'];
		$utx = TransactionFactory::fromHex($utxHex);
		$outputs = $utx->getOutputs();
		
		$data['txHash'] = $utx->getTxHash()->flip()->getHex();//swap endianess
		$data['outputs'] = [];
		if (@count($outputs)) {
			foreach($outputs as $k=>$output) {
				if ($k < 10) { //limit to retrieve max 10 inputs only
				
					$decodeScript = (new OutputClassifier())->decode($output->getScript());
						
					if ($decodeScript->getType() != ScriptType::P2PKH) {
						$data = ["error"=>"Load fail! Your unspent transaction output (utxo) can only contain P2PKH ScriptPubKey."];
						break;
					}
					$data['outputs'][] = ["amount"=>$output->getValue(), "n"=>$k, "scriptPubKey"=>$output->getScript()->getHex()];
				}
			}
		}
	}
	
	die(json_encode($data));
}

include_once("html_iframe_header.php");

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
		
		if (!strlen($_POST['utx']) or !ctype_xdigit($_POST['utx'])) {                    
			throw new Exception("UTX must be hex.");
		} 
		
		if (!is_numeric($_POST['no_of_inputs']) OR !is_numeric($_POST['no_of_outputs'])) {
			throw new Exception("Error in 'no_of_inputs' or 'no_of_outputs'.");
		}
		
		$utxHex = $_POST['utx'];
		$utx = TransactionFactory::fromHex($utxHex);    
		$utxos = $utx->getOutputs();
		
		foreach($utxos as $k=>$utxo) {
			$spendTx = $spendTx->spendOutputFrom($utx, $k);
			
			$privkeyhex = trim($_POST["privkey_" . ($k+1)]);
			$utxoScript = $utxo->getScript()->getHex();
			
			$signItems[] = [$privkeyhex, $utxoScript];
		}

		foreach(range(1,$_POST['no_of_outputs']) as $thisOutput) {
			
			$address = trim($_POST["address_{$thisOutput}"]);
			$amount = trim($_POST["amount_{$thisOutput}"]);
			
			if (strlen($address)>0 AND strlen($amount)>0) {
				$recipient = $addrCreator->fromString($address);
				$spendTx = $spendTx->payToAddress($amount, $recipient);
			} else {
				throw new Exception("Error in 'output#{$thisOutput}'.");
			}
			
		}
		$thisTx = $spendTx->get();
		$signer = new Signer($thisTx, $ecAdapter);
		$signInfo = [];
		foreach($signItems as $nIn=>$signItem) {
			
			$privateKey = $privKeyFactory->fromHexCompressed($signItem[0]);
			$scriptPubKey = ScriptFactory::fromHex($signItem[1]);
			$txOutput = new TransactionOutput(0, $scriptPubKey );
			$signer = $signer->sign($nIn, $privateKey, $txOutput);
			
			//not important, it's extra information about signature
			$inputSigner = $signer->input($nIn,$txOutput);
			$sigHashType = 1;
			$sigVersion = 0;
			$dataToSign = $inputSigner->calculateSigHashUnsafe($txOutput->getScript(),$sigHashType, $sigVersion);
			
			$sig = new TransactionSignature($ecAdapter, $privateKey->sign($dataToSign), $sigHashType);
			$signInfo[] = ['dataToSign'=>$dataToSign->getHex(), 'signature'=>$sig->getSignature()->getBuffer()->getHex().Buffer::int($sigHashType, 1)->getHex()];
			
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
<form action='?tab=form2_tabitem3#hashtag2' method='post'>
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
	<div class="form-group">
		<label for="utx">Unspent Transaction (Hex):</label>
		
		<div class="input-group mb-3">
			<input class="form-control" type='text' name='utx' id='utx' value='<?php echo $_POST['utx']?>'>
			<div class="input-group-append">
				<input class="btn btn-success" type="button" id="form2_tabitem3_load" value="Load" onclick="
				var self = $(this);
				self.val('......'); 
				
				var form = self.closest('form');
				var allInputDivs = form.find('div[id^=row_input_]');
				var allInputs = $( ':input', allInputDivs );
				allInputs.val('');
				allInputDivs.hide();
				$('select#no_of_inputs',form).empty();
				$('span#total_inputs',form).html('0');
				$.ajax({
					url: '?ajax=1&utx=' + $('input#utx',form).val(), 
					
					error:function() {
						
					},
					
					success:function(result){
						try {
							j = eval('(' + result + ')');
							
							if ('error' in j && j.error.length>0) {
								var error = true;
							} else {
								var error = false;
							}
							
							if (!error) {
								var txHash = j.txHash;
								var outputs = j.outputs;
								var totalInputs = 0;
								
								if (outputs.length > 0) {
									
									
									$('select#no_of_inputs',form).prepend('<option value=\''+outputs.length+'\' selected=\'selected\'>'+outputs.length+'</option>');
									
									var x;    
									for (x in outputs) {
										var divid = parseInt(x) + 1;
										var amount = parseInt(outputs[x].amount);
										totalInputs += amount;
										
										$('div#row_input_' + divid             ,form).show();
										$('input[name=utxo_hash_' + divid+']'  ,form).val(txHash);
										$('input[name=utxo_n_' + divid+']'     ,form).val(outputs[x].n);
										$('input[name=utxo_script_' + divid+']',form).val(outputs[x].scriptPubKey);
										$('input[name=utxo_amount_' + divid+']',form).val(amount);
										$('input[name=privkey_'+divid+']'      ,form).removeAttr('readonly');
									}
								}
								
								$('span#total_inputs',form).html(totalInputs);
							} else {
								alert(j.error);
							}
						} catch(e) {
							alert('Invalid Json Format.');
						}
					},
					complete:function() {
						self.val('Load');
					}
				});
				"/>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-6">
			
			<div class="form-row">
				<div class="form-group col">
					<label for="no_of_inputs">Inputs: <i>Max 10 inputs only. Please load them from UTX above.</i></label> 
					
					<div class="row">
						<div class="col-sm-2">
							<select class="form-control" id="no_of_inputs" name='no_of_inputs' style='width:auto;' onchange="
							var self = $(this);
							var thisvalue = self.val();
							var form = self.closest('form');
							$('div[id^=row_input_]',form).hide();
							for(var i=1; i<= thisvalue; i++) { 
								$('div[id=row_input_'+  i + ']',form).show();
							}
							" readonly>
								<?php
								$optionval = $_POST['no_of_inputs']?$_POST['no_of_inputs'] : 0;
								
								if ($optionval > 0) {
								?>
								<option value='<?php echo $optionval?>'><?php echo $optionval?></option>
								<?php
								}
								?>
							</select>
						</div>
						
						<div class="col-sm-10">
							Total Sathoshi: 
							<span id='total_inputs'>
							<?php echo 
							array_reduce(
								array_keys($_POST),
								function($carry, $key) { 
									if (preg_match('/^utxo_amount_/', $key)) {
										return $carry + (int)$_POST[$key];
									} else {                    
										return $carry;
									}
								}, 0
							);?>
							</span>
						</div>
					</div>
				</div>
			</div>
			<?php
			$selectedNInputs = is_numeric($_POST['no_of_inputs']) ? $_POST['no_of_inputs'] : 0;
			
			foreach(range(1,$noOfInputs) as $k=>$thisInput) {
			?>
			
				<div class="form-row" id='row_input_<?php echo $thisInput?>' style="<?php echo ($thisInput > $selectedNInputs) ? "display:none" : "display:;"?>">
					<input type='hidden' name='utxo_amount_<?php echo $thisInput?>' value='<?php echo $_POST["utxo_amount_{$thisInput}"]?>'/>
					
					<div class="form-group  col-sm-1">
						#<?php echo $thisInput?> 
					</div>
					<div class="form-group  col-sm-3">    
						<input class="form-control" title="UTXO Tx Hash" placeholder='UTXO Tx Hash' type='text' name='utxo_hash_<?php echo $thisInput?>' value='<?php echo $_POST["utxo_hash_{$thisInput}"]?>' readonly>
					</div>
					<div class="form-group  col-sm-1">
						<input class="form-control" title="UTXO N Output" placeholder='N' type='text' name='utxo_n_<?php echo $thisInput?>' value='<?php echo $_POST["utxo_n_{$thisInput}"]?>' readonly>
					</div>
					<div class="form-group  col-sm-3">
						<input class="form-control" title="UTXO ScriptPubKey" placeholder='UTXO ScriptPubKey' type='text' name='utxo_script_<?php echo $thisInput?>' value='<?php echo $_POST["utxo_script_{$thisInput}"]?>' readonly>
					</div>
					<div class="form-group  col-sm-4">
						<?php if (isset($signInfo[$k])) {  ?>
							<div class="input-group mb-3">
								<input class="form-control" title="Private Key Hex, for signing purpose." placeholder='Private Key Hex' type='text' name='privkey_<?php echo $thisInput?>' value='<?php echo $_POST["privkey_{$thisInput}"]?>'>
								<div class="input-group-append">
									<button type="button" class="btn btn-primary btn-sm" rel="<?php echo implode("|", $signInfo[$k])?>" onclick="
									var data = $(this).attr('rel').split('|');
									var dataToSign = data[0];
									var signature = data[1];
									
									$('#my-model').find('.modal-title').html('Signature Info');
									$('#my-model').find('.modal-body').html('<p>');
									$('#my-model').find('.modal-body').append('Data To Sign: ');
									$('#my-model').find('.modal-body').append('<input class=\'form-control\' type=\'text\' value=\''+ dataToSign +'\'>');
									
									$('#my-model').find('.modal-body').append('<small>To sign, you may also try this <a href=\'bitcoin_tool_dersign.php\' target=\'_blank\'>tool</a>.</small>');
									$('#my-model').find('.modal-body').append('</p>');
									
									$('#my-model').find('.modal-body').append('<p>');
									$('#my-model').find('.modal-body').append('Signature: ');
									$('#my-model').find('.modal-body').append('<input class=\'form-control\' type=\'text\' value=\''+ signature +'\'>');
									$('#my-model').find('.modal-body').append('</p>');
									
									$('#my-model').modal({backdrop: false});
									" >More</button>
								</div>
							</div>
							
						<?php
						} else {
						?>
							<input class="form-control" title="Private Key Hex, for signing purpose." placeholder='Private Key Hex' type='text' name='privkey_<?php echo $thisInput?>' value='<?php echo $_POST["privkey_{$thisInput}"]?>'>
						<?php
						}
						?>
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
						<input class="form-control" placeholder='Any Address' type='text' name='address_<?php echo $thisOutput?>' value='<?php echo $_POST["address_{$thisOutput}"]?>'>
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

<!-- The Modal -->
<div class="modal" id="my-model">
	<div class="modal-dialog">
		<div class="modal-content">
	  
			<!-- Modal Header -->
			<div class="modal-header">
			  <h4 class="modal-title"></h4>
			  <button type="button" class="close" data-dismiss="modal">×</button>
			</div>
			
			<!-- Modal body -->
			<div class="modal-body"></div>
		
			<!-- Modal footer -->
			<div class="modal-footer">
			  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
			</div>
		
		</div>
	</div>
</div>
<?php
include_once("html_iframe_footer.php");