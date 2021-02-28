<?php 
use Web3\Contracts\Ethabi;
use Web3\Contracts\Types\{Address, Boolean, Bytes, DynamicBytes, Integer, Str, Uinteger};

include_once "../libraries/vendor/autoload.php";

$ethAbi = new Ethabi(['address' => new Address,'bool' => new Boolean,'bytes' => new Bytes,'dynamicBytes' => new DynamicBytes,'int' => new Integer,'string' => new Str,'uint' => new Uinteger,]);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$ajaxData = [];
	if ($_GET['action'] == 'parse_abi' OR ($_GET['action'] == 'submit' AND isset($_POST['abi']))) {
		$ajaxData['functions'] = [];
		$abiBlocks = json_decode($_POST['abi'], true);
		if (@count($abiBlocks) > 0) {
			foreach($abiBlocks as $abiBlock) {
				if ($abiBlock['type'] == 'function') {
					if (count($abiBlock['outputs']) > 0) {
						$ajaxData['functions'][] = $abiBlock['name'];
					}
				}
			}
		} else {
			$errmsg .= "Invalid ABI.";
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
$results = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	try {
		
		if (!$_POST['function'] OR !$_POST['abi']) {
			throw new Exception("Abi with selected function is needed.");
		}

		$abiBlocks = json_decode($_POST['abi'], true);
		
		if (@count($abiBlocks) > 0) {
			foreach($abiBlocks as $abiBlock) {
				
				if ($abiBlock['type'] == 'function' and $abiBlock['name'] == $_POST['function']) {		
					$totalOutputs = count($abiBlock['outputs']);
					
					if ($totalOutputs) {
						$encoded = $_POST['response'];
						
						// Remove 0x prefix
						if (substr($encoded, 0, 2) === '0x') {
							$encoded = substr($encoded, 2);
						}
						
						if (strlen($encoded) != 64 * $totalOutputs) {
							throw new Exception("Response length is not valid.");
						}
						
						$decodeds = str_split($encoded, 64);
						foreach($decodeds as $k=> $decoded) {
							
							$result['name']  = $abiBlock['outputs'][$k]['name'];
							$result['type']  = $abiBlock['outputs'][$k]['type'];
							$result['hex']   = "0x". $decoded;
							$result['value'] = $ethAbi->decodeParameter($abiBlock['outputs'][$k]['type'], $decoded);
							
							$results[] = $result;
						}
					}
				}
			}
		}
	?>
    <div class="alert alert-success">
		<?php echo $totalOutputs?> outputs have been decoded.
	</div>
	<div class="table-responsive">
		<table class="table table-bordered">
			<tr><th>Name</th><th>Type</th><th>Hex</th><th>Decoded Value</th></tr>
			<?php
			foreach($results as $result) {
			?>
				<tr>
					<td><?Php echo $result['name']?></td>
					<td><?Php echo $result['type']?></td>
					<td><?Php echo $result['hex']?></td>
					<td><?Php echo $result['value']?></td>
				</tr>
			<?Php
			}
			?>
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
<form id='this_form' action='?action=submit' method='post'>
	
	<div class="form-group">
        <label for="response">Response To Decode:</label>
        <input class="form-control" type='text' name='response' id='response' value='<?php echo $_POST['response']?>'>
		<small>You may get this response from <a href="eth_call.php" target='_blank'>Ethereum Eth Call</a> to decode.</small>
    </div>
	
	<div class="form-group">
        <label for="function">Function:</label>
        <select class="form-control" type='text' name='function' id='function' value='<?php echo $_POST['function']?>'>
			<?php
			
			if (@count($ajaxData['functions']) > 0) {
			?>
				<option value=''>Please select ...</option>
				<?php
				foreach($ajaxData['functions'] as $function_name) {
					
					$optionSelected = $function_name == $_POST['function'] ? " selected='selected'" : "";
				?>
					<option value='<?php echo $function_name?>'<?php echo $optionSelected?>><?php echo $function_name?></option>
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
							
							if ('error' in j && j.error.length>0) {
								var error = true;
							} else {
								var error = false;
							}
							
							if (!error) {
								
								var functions = j.functions;
								
								if (functions.length > 0) {
									$('select#function',form).append('<option value=\'\' selected=\'selected\'>Please select ...</option>');
									
									var x;    
									for (x in functions) {
										$('select#function',form).append('<option value=\''+functions[x]+'\'>'+functions[x]+'</option>');
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

<?php
include_once("html_iframe_footer.php");