<?php 
use kornrunner\Keccak;

include_once "../libraries/vendor/autoload.php";

class BtcschoolsABI {
	private $abi;
	
	public function __construct(array $abi)
    {
		$this->abi = $abi;
	}
	
	public function hexDec(string $hex): string
    {
        $dec = 0;
        $len = strlen($hex);
        for ($i = 1; $i <= $len; $i++) {
            $dec = bcadd($dec, bcmul(strval(hexdec($hex[$i - 1])), bcpow('16', strval($len - $i))));
        }
        return $dec;
    }

    public function decHex($dec): string
    {
        $last = bcmod($dec, 16);
        $remain = bcdiv(bcsub($dec, $last), 16);

        if ($remain == 0) {
            return dechex($last);
        } else {
            return self::DecHex($remain) . dechex($last);
        }
    }
	
	public function str2Hex(string $str): string
    {
        $hex = "";
        for ($i = 0; $i < strlen($str); $i++) {
            $hex .= dechex(ord($str[$i]));
        }
		
        return $hex;
    }

    public function hex2Str(string $hex): string
    {
        $str = "";
        for ($i = 0; $i < strlen($hex) - 1; $i += 2) {
            $str .= chr(hexdec($hex[$i] . $hex[$i + 1]));
        }

        return $str;
    }
	
	public function encodeSimpleType(string $type, $value) {
		
		$simpleType = preg_replace('/[^a-z]/', '', $type);
		
		if (in_array($simpleType, ["address", "uint", "int", "bool"])) {
			switch ($simpleType) {
				case "address":
					if (substr($value, 0, 2) === "0x") {
						$value = substr($value, 2);
					}
				break;
				
				case "uint":
				case "int":
					$value = $this->decHex($value);
				break;
				
				case "bool":
					$value = $value === true ? 1 : 0;
				break;
			}
			
			return substr(str_pad(strval($value), 64, "0", STR_PAD_LEFT), 0, 64);
			
		} else if (in_array($simpleType, ["bytes"])) {
			
			if (substr($value, 0, 2) === "0x") {
				$value = substr($value, 2);
			}
			
			switch($simpleType) {
				case "bytes";
					return substr(str_pad(strval($value), 64, "0", STR_PAD_RIGHT), 0, 64);
				break;
			}
		}
		
		throw new Exception(sprintf('Cannot encode value of type "%s"', $type));
	}
	
	public function encodeCall(string $name, ?array $args): string
    {
		
		$blocks = $this->abi;
		$encoded = "";
			
		foreach($blocks as $block) {
			if ($block['type'] == 'function' and $block['name'] == $name) {
				$dataParts = [];
				$methodParamsTypes = [];
	
				if(count($block['inputs']) > 0) {
					
					foreach($block['inputs'] as $inputIdx=>$input) {
						
						$methodParamsTypes[] = $input['type'];
						$arg = $args[$inputIdx];
						
						if (preg_match('/^((uint|int){1}(8|16|32|64|128|256)?|bool|address|(bytes[0-9]{1,2}))$/', $input['type'])) {
							
							$encoded .= $this->encodeSimpleType($input['type'], $arg);
						//specially handle string array type
						} else if ($input['type'] == "string") {
							
							$thisEncoded = $this->str2Hex($arg);
							$thisEncoded = $this->encodeSimpleType("uint", strlen($thisEncoded)/2).$thisEncoded;
							
							$lengthUpTo = ceil(strlen($thisEncoded) / 64) * 64;
							
							$dataParts[] = substr(str_pad(strval($thisEncoded), $lengthUpTo, "0", STR_PAD_RIGHT), 0, $lengthUpTo);
							
							$idx = count($dataParts);

							$encoded .= "[" . str_pad($idx, 62, "0", STR_PAD_LEFT) . "]";
						//specially handle byte array type
						} else if ($input['type'] == "bytes") {
							
							$thisEncoded = $arg;
							if (substr($thisEncoded, 0, 2) === "0x") {
								$thisEncoded = substr($thisEncoded, 2);
							}
							
							$thisEncoded = $this->encodeSimpleType("uint", strlen($thisEncoded)/2).$thisEncoded;
							
							$lengthUpTo = ceil(strlen($thisEncoded) / 64) * 64;
							
							$dataParts[] = substr(str_pad(strval($thisEncoded), $lengthUpTo, "0", STR_PAD_RIGHT), 0, $lengthUpTo);
							
							$idx = count($dataParts);

							$encoded .= "[" . str_pad($idx, 62, "0", STR_PAD_LEFT) . "]";
						//specially handle other array type
						} else if (preg_match('/^((uint|int){1}(8|16|32|64|128|256)?|bool|address|bytes[0-9]{1,2})\[[0-9]*\]$/', $input['type'])) {
							$items = json_decode($arg,true);
							
							if (!in_array(substr($arg, 0, 1), array('[')) OR !in_array(substr($arg, -1), array("]"))) {
								throw new Exception(
									sprintf('Invalid array-json input for param "%s" with type "%s" (1)', $block['name'], $input['type'])
								); 
							}
								
							if (json_last_error() != JSON_ERROR_NONE) {
								throw new Exception(
									sprintf('Invalid array-json input for param "%s" with type "%s" (2)', $block['name'], $input['type'])
								); 
							}
							
							$thisEncoded .= $this->encodeSimpleType("uint", count($items));
							
							foreach($items as $itemIdx=>$item) {
								$thisEncoded .= $this->encodeSimpleType($input['type'], $item);
							}
							
							$dataParts[] = $thisEncoded;
							
							$idx = count($dataParts);

							$encoded .= "[" . str_pad($idx, 62, "0", STR_PAD_LEFT) . "]";
						} else {
							throw new Exception(sprintf('Cannot encode value of type "%s"', $type));
						}
					}
				}
				
				foreach($dataParts as $k=>$dataPart) {
					$find = "[" . str_pad($k + 1, 62, "0", STR_PAD_LEFT) . "]";
					$replaceWith = $this->encodeSimpleType("uint", strlen($encoded) / 2);
					
					$encoded = str_replace($find, $replaceWith, $encoded);
					$encoded .= $dataPart;
				}

				$encodedMethodCall = Keccak::hash($plain = sprintf('%s(%s)', $name, implode(",", $methodParamsTypes)), 256);
				
				return '0x' . substr($encodedMethodCall, 0, 8) . $encoded;
				
			}
		}
		return "";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$ajaxData = [];
	if ($_GET['action'] == 'parse_abi' OR ($_GET['action'] == 'submit' AND isset($_POST['abi']))) {
		$ajaxData['functions'] = [];
		$blocks = json_decode($_POST['abi'], true);
		if (@count($blocks) > 0) {
			foreach($blocks as $block) {
				if ($block['type'] == 'function') {
					$ajaxData['functions'][] = $block['name'];
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
	
	if ($_GET['action'] == 'get_args' OR ($_GET['action'] == 'submit' AND isset($_POST['abi']) AND isset($_POST['function'])) ) {
		$ajaxData['args'] = [];
		$blocks = json_decode($_POST['abi'], true);
		
		if (@count($blocks) > 0) {
			foreach($blocks as $block) {
				
				if ($block['type'] == 'function' and $block['name'] == $_POST['function']) {					
					if ($block['inputs']) {
						foreach($block['inputs'] as $input) {
							$ajaxData['args'][] = $input['name'] .  " ({$input['type']})";
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
		
		if (!$_POST['function']) {
			throw new Exception("Function should not be blank.");
		}
		
		$_POST['args'] = is_array($_POST['args']) ? $_POST['args'] : [];
		
		$decoded = json_decode($_POST['abi'], true);
		$abi = new BtcschoolsABI($decoded);
		$data = $abi->encodeCall($_POST['function'], $_POST['args']);
		
		
	?>
	   <div class="alert alert-success">
			<h6 class="mt-3">Data (Hex)</h6>
			<textarea class="form-control" rows="5" id="comment" readonly><?php echo $data;?></textarea>
			
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
        <label for="function">Function:</label>
        <select class="form-control" type='text' name='function' id='function' value='<?php echo $_POST['function']?>' onchange="
				var self = $(this);
				var form = self.closest('form');
				$('p#args_panel',form).empty();
				
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
        <label for="args">Function Arguments:</label>
		<p id='args_panel'>
			<?php
			
			if ($_GET['action'] == 'submit') {
				if (@count($ajaxData['args']) > 0) {
					foreach($ajaxData['args'] as $k=>$arg) {
					?>
						<div class='form-group'><?php echo $arg?> :<input class='form-control' type='text' name='args[]' value='<?php echo $_POST['args'][$k]?>'/></div>
					<?php
					}
				} else {
					echo "&nbsp;&nbsp;&nbsp;&nbsp;No arguments";
				}
			} else {
				echo "&nbsp;&nbsp;&nbsp;&nbsp;Please select a function above ...";
			}
			?>
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