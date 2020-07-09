<?php 
use BitWasp\Bitcoin\Bitcoin;
use BitWasp\Buffertools\Buffer;
use BitWasp\Bitcoin\Network\NetworkFactory;
use BitWasp\Bitcoin\Key\Factory\PrivateKeyFactory;
use BitWasp\Bitcoin\Address\AddressCreator;
use BitWasp\Bitcoin\Address\ScriptHashAddress;
use BitWasp\Bitcoin\Transaction\Factory\TxBuilder;
use BitWasp\Bitcoin\Transaction\TransactionFactory;
use BitWasp\Bitcoin\Transaction\TransactionOutput;
use BitWasp\Bitcoin\Transaction\Factory\Signer;
use BitWasp\Bitcoin\Transaction\Factory\SignData;
use BitWasp\Bitcoin\Script\ScriptType;
use BitWasp\Bitcoin\Script\ScriptFactory;
use BitWasp\Bitcoin\Script\Classifier\OutputClassifier;
use BitWasp\Bitcoin\Script\ScriptInfo\Multisig;
use BitWasp\Bitcoin\Script\P2shScript;
    
include_once "../libraries/vendor/autoload.php";

$no_of_inputs = 10;
$no_of_outputs = 1;

if ($_SERVER['REQUEST_METHOD'] == 'GET' AND $_GET['ajax'] == '1') {
	
	$data = [];
	
	if ($_GET['action'] == 'load_utx') {
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
						
						$reqSigs = -1;
						if ($decodeScript->getType() == ScriptType::P2SH) {
							$type = "p2sh.multisig";
						} else if ($decodeScript->getType() == ScriptType::MULTISIG) {
							$type = "p2ms";
							
							$multiSig = Multisig::fromScript($output->getScript());
							$reqSigs = $multiSig->getRequiredSigCount();
						} else {
							$data = ["error"=>"Load fail! Your unspent transaction output (utxo) can only contain P2SH or P2MS ScriptPubKey."];
							break;
						}
						
						$data['outputs'][] = ["amount"=>$output->getValue(), "n"=>$k, "scriptPubKey"=>$output->getScript()->getHex(), "type"=>$type,'reqSigs'=>$reqSigs];
					}
				}
			}
		}
	} else if ($_GET['action'] == 'load_redeemscript') {
		if (!ctype_xdigit($_GET['redeemscript'])) {
			$errmsg .= "Redeem script must be hex.";
		} else if (!ctype_xdigit($_GET['scriptpubkey'])) {
			$errmsg .= "Redeem script must be hex.";
		} else  {
			$redeemScript = ScriptFactory::fromHex($_GET['redeemscript']);
			$p2sh = new ScriptHashAddress($redeemScript->getScriptHash());
			$scriptPubKeyFromRS = $p2sh->getScriptPubKey()->getHex();
			
			if ($scriptPubKeyFromRS != $_GET['scriptpubkey']) {
				$errmsg .= "Redeem script not match to UTXO ScriptPubKey.";
			} else {
				$decodeScript = (new OutputClassifier())->decode($redeemScript);
			
				if ($decodeScript->getType() != ScriptType::MULTISIG) {
					$errmsg .= "Redeem script is not MULTISIG script.";
				} else {
					$multiSig = Multisig::fromScript($redeemScript);
					$reqSigs = $multiSig->getRequiredSigCount();
					$data = ['reqSigs' => $reqSigs];
				}
			}
		}
		
		if ($errmsg) {
			$data = ["error"=>$errmsg];
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
			$privkeyhexCount = count($_POST["privkey_" . ($k+1)]);
			$utxo_script = $utxo->getScript()->getHex();
			$redeemScript = $_POST["redeemscript_" . ($k+1)];
			
			
			if ($privkeyhexCount > 0) {
				if (strlen($redeemScript) > 0) { //p2sh.multisig
				
					$redeemScript = new P2shScript(ScriptFactory::fromHex($redeemScript));
					$signData = new SignData();
					$signData->p2sh($redeemScript);
					for($i=0; $i<$privkeyhexCount; $i++) {
						$signItems[] = [ $_POST["privkey_" . ($k+1)][$i], $utxo_script, $k, $signData];
					}
				} else {
					for($i=0; $i<$privkeyhexCount; $i++) {
						$signItems[] = [ $_POST["privkey_" . ($k+1)][$i], $utxo_script, $k];
					}
				}
			}
		}
		
		foreach(range(1,$_POST['no_of_outputs']) as $this_output) {
			
			$address = trim($_POST["address_{$this_output}"]);
			$amount = trim($_POST["amount_{$this_output}"]);
			
			if (strlen($address)>0 AND strlen($amount)>0) {
				$recipient = $addrCreator->fromString($address);
				$spendTx = $spendTx->payToAddress($amount, $recipient);
			} else {
				throw new Exception("Error in 'output#{$this_output}'.");
			}
			
		}
		$thisTx = $spendTx->get();
		$signer = new Signer($thisTx, $ecAdapter);
		foreach($signItems as $nIn=>$signItem) {
			$privateKey = $privKeyFactory->fromHexCompressed($signItem[0]);
			$scriptPubKey = ScriptFactory::fromHex($signItem[1]);
			$nIn = $signItem[2];
			$signData = $signItem[3];
			
			$txOutput = new TransactionOutput(0, $scriptPubKey );
			
			$signer = $signer->sign($nIn, $privateKey, $txOutput,$signData);
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
	<div class="form-group">
		<label for="utx">Unspent Transaction (Hex):</label>
		
		<div class="input-group mb-3">
			<input class="form-control" type='text' name='utx' id='utx' value='<?php echo $_POST['utx']?>'>
			<div class="input-group-append">
				<input class="btn btn-success" type="button" value="Load" onclick="
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
					url: '?ajax=1&action=load_utx&utx=' + $('input#utx',form).val(), 
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
										var reqSigs = parseInt(outputs[x].reqSigs);
										var type = outputs[x].type;
										
										totalInputs += amount;
										
										$('div#row_input_' + divid             ,form).show();
										$('input[name=utxo_hash_' + divid+']'  ,form).val(txHash);
										$('input[name=utxo_n_' + divid+']'     ,form).val(outputs[x].n);
										$('input[name=utxo_script_' + divid+']',form).val(outputs[x].scriptPubKey);
										$('input[name=utxo_amount_' + divid+']',form).val(amount);
										
										var privKeySelector = $('input[name=\'privkey_'+divid+'[]\']'      ,form);
										var firstPrivKeyInput = privKeySelector.filter(':first');
										privKeySelector.not(':first').remove();
										
										if (type == 'p2ms') {
											firstPrivKeyInput.removeAttr('readonly');    
											reqSigs--;
											
											if (reqSigs > 0) {
												for(var i=0; i<reqSigs;i++) {
													firstPrivKeyInput.closest('div').append(firstPrivKeyInput.clone());
												}
											}
											
											$('input[name=redeemscript_' + divid+']',form).parent('div').parent('div').hide();
										} else {
											$('input[name=redeemscript_' + divid+']',form).parent('div').parent('div').show();
											
											firstPrivKeyInput.attr('readonly','readonly');    
										}
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
		<!--* This sample will extract UTX Outputs from provided UTX Hex-->
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
								function($carry, $key) use ($_POST) { 
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
			$selected_n_inputs = is_numeric($_POST['no_of_inputs']) ? $_POST['no_of_inputs'] : 0;
			
			foreach(range(1,$no_of_inputs) as $this_input) {
			?>
			
				<div class="form-row" id='row_input_<?php echo $this_input?>' style="<?php echo ($this_input > $selected_n_inputs) ? "display:none" : "display:;"?>">
					<input type='hidden' name='utxo_amount_<?php echo $this_input?>' value='<?php echo $_POST["utxo_amount_{$this_input}"]?>'/>
					
					<div class="form-group  col-sm-1">
						#<?php echo $this_input?> 
					</div>
					<div class="form-group  col-sm-3">    
						<input class="form-control" title="UTXO Tx Hash" placeholder='UTXO Tx Hash' type='text' name='utxo_hash_<?php echo $this_input?>' value='<?php echo $_POST["utxo_hash_{$this_input}"]?>' readonly>
					</div>
					<div class="form-group  col-sm-1">
						<input class="form-control" title="UTXO N Output" placeholder='N' type='text' name='utxo_n_<?php echo $this_input?>' value='<?php echo $_POST["utxo_n_{$this_input}"]?>' readonly>
					</div>
					<div class="form-group  col-sm-3">
						<input class="form-control" title="UTXO ScriptPubKey" placeholder='UTXO ScriptPubKey' type='text' name='utxo_script_<?php echo $this_input?>' value='<?php echo $_POST["utxo_script_{$this_input}"]?>' readonly>
					</div>
					<div class="form-group  col-sm-4">
						
						<?php
						
						$count = count($_POST["privkey_{$this_input}"]);
						$count = $count > 0 ? $count : 1;
						
						foreach(range(0, $count-1) as $arrayIdx) {
						?>
						<input class="form-control" title="Private Key Hex, for signing purpose." placeholder='Private Key Hex' type='text' name='privkey_<?php echo $this_input?>[]' value='<?php echo $_POST["privkey_{$this_input}"][$arrayIdx]?>'>
						<?php
						}
						?>
					</div>
					
					<div class="form-group  col-sm-1" >
					
					</div>
					<div class="form-group  col-sm-11">
						<div class="input-group mb-3">
							<input class="form-control" title="Enter Redeem Script to reveal number of required signature." placeholder='Enter Redeem Script to reveal number of required signature.' type='text' name='redeemscript_<?php echo $this_input?>' value='<?php echo $_POST["redeemscript_{$this_input}"]?>'/>
							<div class="input-group-append">
								<input class="btn btn-success" type="button" value="" onclick="
									var self = $(this);
									self.val('......'); 
									
									var form = self.closest('form');
									var formrow = self.closest('.form-row');
									
									var scriptpubkey = $('input[name^=utxo_script_]', formrow).val();
									var redeemscript = $('input[name^=redeemscript_]', formrow).val();
									
									$.ajax({
										url: '?ajax=1&action=load_redeemscript&scriptpubkey='+ scriptpubkey+ '&redeemscript=' + redeemscript, 
										success:function(result){
											try {
												j = eval('(' + result + ')');
												
												if ('error' in j && j.error.length>0) {
													var error = true;
												} else {
													var error = false;
												}
												
												if (!error) {
													var reqSigs = parseInt(j.reqSigs);
													
													var privKeySelector = $('input[name^=\'privkey_\']',formrow);
													var firstPrivKeyInput = privKeySelector.filter(':first');
													
													firstPrivKeyInput.removeAttr('readonly');
													privKeySelector.not(':first').remove();
													reqSigs--;
													if (reqSigs > 0) {
														for(var i=0; i<reqSigs;i++) {
															firstPrivKeyInput.closest('div').append(firstPrivKeyInput.clone());
														}
													}
											
													
												} else {
													alert(j.error);
												}
											} catch(e) {
												alert('Invalid Json Format.');
											}
										},
										complete:function() {
											self.val('Reveal');
										}
									});
								"/>
							</div>
						</div>
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
						<input class="form-control" placeholder='Any Address' type='text' name='address_<?php echo $this_output?>' value='<?php echo $_POST["address_{$this_output}"]?>'>
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