<?php 
include_once "../libraries/vendor/autoload.php";

use Web3\Contracts\Ethabi;
use Web3\Contracts\Types\{Address, Boolean, Bytes, DynamicBytes, Integer, Str, Uinteger};

$hosts = ["https://mainnet.infura.io"=>"https://mainnet.infura.io","https://ropsten.infura.io"=>"https://ropsten.infura.io", "https://cloudflare-eth.com"=>"https://cloudflare-eth.com"];

function bcdechex($dec) {

	$last = bcmod($dec, 16);
	$remain = bcdiv(bcsub($dec, $last), 16);

	if($remain == 0) {
		return dechex($last);
	} else {
		return bcdechex($remain).dechex($last);
	}	
}

$ethAbi = new Ethabi(['address' => new Address,'bool' => new Boolean,'bytes' => new Bytes,'dynamicBytes' => new DynamicBytes,'int' => new Integer,'string' => new Str,'uint' => new Uinteger,]);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$ajaxData = [];
	if ($_GET['action'] == 'parse_abi' OR ($_GET['action'] == 'submit' AND isset($_POST['abi']))) {
		$ajaxData['functions'] = [];
		$abiBlocks = json_decode($_POST['abi'], true);
		if (@count($abiBlocks) > 0) {
			foreach($abiBlocks as $abiBlock) {
				if ($abiBlock['type'] == 'event') {
					$types = [];
					if ($abiBlock['inputs']) {
						foreach($abiBlock['inputs'] as $input) {
							$types[] = $input['type'];
						}
					}
					
					$eventSignature = $ethAbi->encodeEventSignature($plain = "{$abiBlock['name']}(".implode(",",$types).")");
					
					$ajaxData['functions'][$abiBlock['name']] = $abiBlock['name'] . " (".$eventSignature.")";
				}
			}
			
		} else {
			if ($_GET['ajax'] == '1') {
				$errmsg .= "Invalid ABI.";
			}
		}
		
		if ($_GET['ajax'] == '1') {
			if ($errmsg) {
				$ajaxData['error'] = $errmsg;
			} 
			
			die(json_encode($ajaxData));
		}
	} 
	
	if ($_GET['action'] == 'get_args' OR ($_GET['action'] == 'submit' AND isset($_POST['abi']) AND isset($_POST['function'])) ) {
		$ajaxData['args'] = [];
		$abiBlocks = json_decode($_POST['abi'], true);
		$topicCounter = 1;
		if (@count($abiBlocks) > 0) {
			foreach($abiBlocks as $abiBlock) {
				if ($abiBlock['type'] == 'event' and $abiBlock['name'] == $_POST['function']) {					
					if ($abiBlock['inputs']) {
						foreach($abiBlock['inputs'] as $input) {
							if ($input['indexed'] === true) {
								$ajaxData['args'][] = "<span class='grey_info'>topic {$topicCounter }</span> ".$input['name'] .  " ({$input['type']})";
								$topicCounter++;
							}
						}
					}
				}
			}
		}
		
		if ($_GET['ajax'] == '1') {
			if ($errmsg) {
				$ajaxData['error'] = $errmsg;
			} 
			
			die(json_encode($ajaxData));
		}
	}
}

include_once("html_iframe_header.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	try {
		
		if (!in_array($_POST['host'], array_keys($hosts))) {
			throw new Exception("Please provide valid host.");
		}
		
		$_POST['args'] = is_array($_POST['args']) ? $_POST['args'] : [];
		
		$abiBlocks = json_decode($_POST['abi'], true);
		
		$eventSignature = "";
		$inputTypes = [];
		$topics = [];
		if (@count($abiBlocks) > 0) {
			foreach($abiBlocks as $abiBlock) {
				if ($abiBlock['type'] == 'event' and $abiBlock['name'] == $_POST['function']) {					
					if ($abiBlock['inputs']) {
						foreach($abiBlock['inputs'] as $input) {
							$inputTypes[] = $input['type'];
						}
					}
					
					$eventSignature = $ethAbi->encodeEventSignature($plain = "{$abiBlock['name']}(".implode(",",$inputTypes).")");
					
					$topics[0] = $eventSignature;
		
					foreach($_POST['args'] as $k=>$arg) {
						if (strlen($_POST['args'][$k]) > 0) {
							$topics[$k+1] = $ethAbi->encodeParameter($inputTypes[$k], $_POST['args'][$k]);
						} else {
							//null, tell filter to ignore this position of topic
							$topics[$k+1] = null;
						}
					}
				}
			}
		}
		
		
		$url = $_POST['host'] . "/" . $_POST['path'];
		
		$ch = curl_init();
		$requestId = time();
			
		$params = [];
		$params['jsonrpc']= "2.0";
		$params['method'] = 'eth_getLogs';
		$params['params'] = [["address"=>$_POST['contract_address'], "fromBlock"=>"0x".bcdechex($_POST["block_num"]), "toBlock"=>"0x".bcdechex($_POST["block_num"]), "topics"=>$topics]];
		$params['id'] = $requestId;
		
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$req = json_encode($params));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);

		$resp = curl_exec($ch);
		
		if ($resp === false) {
			throw new Exception("curl_exec return false.");
		}
		
		if (strlen($err = @curl_error($ch)) > 0) {
			$errno = @curl_errno($ch);
			throw new Exception( "{$err} ({$errno})." );
		}
		
		$result = json_decode($resp,true); 
		if ($result['id'] != $requestId) {
			throw new Exception("Invalid request id.");
		}
		$result = $result['result'];
		
		curl_close ($ch);
		
		?>
		<div class="alert alert-success">
			<h6 class="mt-3">Host</h6>
			<textarea class="form-control" rows="1" readonly><?php echo $url;?></textarea>
			
			<h6 class="mt-3">JSON-RPC Request</h6>
			<textarea class="form-control" rows="5" id="comment" readonly><?php echo $req;?></textarea>
			
			<h6 class="mt-3">JSON-RPC Response</h6>
			<textarea class="form-control" rows="1" id="comment" readonly><?php echo $resp;?></textarea>

		</div>
		<?Php
		if ($result) {
		?>
		<h6 class="mt-3"><?php echo (int)count($result) ?> Log(s) Found</h6>
		<pre><?php print_r($result);}?></pre>
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
<form id='this_form' action='?action=submit' method='post'>

	<div class="form-group">
		<label for="host">Host To Receive RPC:</label>
		
		<div class="input-group mb-3">
			<select id="host" name="host" class="form-control" >
			<?php
			foreach($hosts as $k=>$v) {
				echo "<option value='{$k}'".($k == $_POST['host'] ? " selected": "").">{$v}</option>";
			}
			?>
			</select>
			<div class="input-group-append">
				<span class="input-group-text">
					/
				</span>
			</div>
			
			<input class="form-control" type='text' name='path' id='path' value='<?php echo $_POST['path']?>' placeholder="Put extra path or blank if it does not.">
			
		</div>
	</div>
	
	<div class="form-group">
        <label for="block_num">Block Number:</label>
        <input class="form-control" type='text' name='block_num' id='block_num' value='<?php echo $_POST['block_num']?>'>
    </div>
	
	<div class="form-group">
        <label for="contract_address">Contract Address:</label>
        <input class="form-control" type='text' name='contract_address' id='contract_address' value='<?php echo $_POST['contract_address']?>'>
    </div>
	
	<div class="form-group">
        <label for="function"><span class='grey_info'>topic 0</span> Event Function:</label>
        <select class="form-control" type='text' name='function' id='function' value='<?php echo $_POST['function']?>' onchange="
				var self = $(this);
				var form = self.closest('form');
				$('p#args_panel',form).empty();
				$('p#args_panel',form).html('');
				$.ajax({
					url: '?ajax=1&action=get_args', 
					type: 'post',
					data: $('#this_form :input'),
					success:function(result){
						
						try {
							j = eval('(' + result + ')');
							
							if ('error' in j && j.error.length>0) {
								var error = true;
							} else {
								var error = false;
							}
							
							if (!error) {
								
								var args = j.args;
								
								if (args.length > 0) {
									
									var x;    
									for (x in args) {
										$('p#args_panel',form).append('<div class=\'form-group\'>'+ args[x] +':<input class=\'form-control\' type=\'text\' name=\'args[]\'/></div>');
										
									}
									
								} else {
									$('p#args_panel',form).html('&nbsp;&nbsp;&nbsp;&nbsp;No arguments');
								}
							} else {
								alert(j.error);
							}
						} catch(e) {
							alert('Invalid Json Format.');
						}
					},
					complete:function() {
					}
				});
				">
			
			
			<?php
			
			if (@count($ajaxData['functions']) > 0) {
				
			?>
				<option value=''>Please select ...</option>
				<?php
				foreach($ajaxData['functions'] as $k => $v) {
					
					$optionSelected = ($k == $_POST['function'] ? " selected='selected'" : "");
				?>
					<option value='<?php echo $k?>'<?php echo $optionSelected?>><?php echo $v?></option>
				<?php
				}
			} else {
			?>
				<option value="">Please load from ABI ...</option>
			<?php
			}
			?>
		</select>
    </div>
	
	<div class="form-group">
        <label for="args">Indexed Inputs:</label>
		<p id='args_panel'>
			
		</p>
    </div>
	
	<div class="form-group">
		<label for="gas_price">ABI:</label>
		
		<div class="input-group mb-3">
			<textarea class="form-control" rows="10" name='abi' id='abi'><?php echo $_POST['abi']?></textarea>
			<div class="input-group-append">
			 <input class="btn btn-success" type="button" value="Load" onclick="
				var self = $(this);
				self.val('...'); 
				
				var form = self.closest('form');
				
				$('select#function',form).empty();
				
				$.ajax({
					url: '?ajax=1&action=parse_abi', 
					type: 'post',
					data: $('#this_form :input'),
					success:function(result){
						
						try {
							j = eval('(' + result + ')');
							console.log(j);
							if ('error' in j && j.error.length>0) {
								var error = true;
							} else {
								var error = false;
							}
							
							if (!error) {
								
								var functions = j.functions;
								
								if (functions !== undefined) {
									$('select#function',form).append('<option value=\'\' selected=\'selected\'>Please select ...</option>');
									var x;    
									for (x in functions) {
										$('select#function',form).append('<option value=\''+x+'\'>'+functions[x]+'</option>');
									}
									
									
								}
							} else {
								
								$('select#function',form).prepend('<option value=\'\' selected=\'selected\'>Please load from ABI ...</option>');
								alert(j.error);
							}
						} catch(e) {
							
							$('select#function',form).prepend('<option value=\'\' selected=\'selected\'>Please load from ABI ...</option>');
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
    <input type='submit' class="btn btn-success btn-block"/>
</form>

<script>
<?php

if ($_GET['action'] == 'submit') {
	if (@count($ajaxData['args']) > 0) {
		foreach($ajaxData['args'] as $k=>$arg) {
		?>
			$('p#args_panel').append("<div class='form-group'><?php echo $arg?>:<input class='form-control' type='text' name='args[]' value='<?php echo $_POST['args'][$k]?>'/></div>");
		<?php
		}
	} else {
	?>
		$('p#args_panel').html("&nbsp;&nbsp;&nbsp;&nbsp;No arguments");
	<?php
	}
} 
?>
</script>
<?php
include_once("html_iframe_footer.php");