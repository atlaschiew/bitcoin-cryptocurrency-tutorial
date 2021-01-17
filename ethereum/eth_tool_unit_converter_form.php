<?php 

session_start();

include_once "../common.php";

//lowest bitcoin value is 1 wei
$gweiDecimalPlaces = 9;
$ethDecimalPlaces = 18;

$min_wei = "1";
$min_gwei = bcdiv("1", bcpow("10", (string)$gweiDecimalPlaces), $gweiDecimalPlaces);
$min_eth = bcdiv("1", bcpow("10", (string)$ethDecimalPlaces), $ethDecimalPlaces);

function isValidDecimal($input, $decimalPoints) {
	if (!preg_match($pattern = '/^(-)?[0-9]+(\.[0-9]{1,'.$decimalPoints.'})?$/', $input)) {
		
		return false;
	}
	
	return true;	
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' AND $_GET['ajax'] == '1') {
	$data = [];
	
	$wei  = $_GET['wei'];
	$gwei = $_GET['gwei'];
	$eth  = $_GET['eth'];
	
	try {
		if(is_numeric($wei)) {
			if (bccomp($wei, $min_wei) < 0) {
				throw new Exception("Minimum value is {$min_wei} wei.");
			}
			
			$wei_to_gwei = $min_gwei;
			$wei_to_eth  = $min_eth;
			
			$to_wei  = $wei;
			$to_gwei = bcmul($wei, $wei_to_gwei, $gweiDecimalPlaces );
			$to_eth  = bcmul($wei, $wei_to_eth, $ethDecimalPlaces );
			
			
		} else if (is_numeric($gwei)) {
			
			if (!isValidDecimal($gwei, $gweiDecimalPlaces)) {
				throw new Exception("Minimum value is {$min_gwei} gwei.");
			} else if (bccomp($gwei, $min_gwei, $gweiDecimalPlaces) < 0) {
				throw new Exception("Minimum value is {$min_gwei} gwei.");
			}
			
			$gwei_to_wei = bcdiv($min_wei , $min_gwei);
			$gwei_to_eth = bcdiv($min_eth, $min_gwei, $ethDecimalPlaces);

			$to_wei  = bcmul($gwei, $gwei_to_wei );
			$to_gwei = $gwei;
			$to_eth  = bcmul($gwei, $gwei_to_eth, $ethDecimalPlaces );
			
		} else if (is_numeric($eth)) {
			
			if (!isValidDecimal($eth, $ethDecimalPlaces)) {
				throw new Exception("Minimum value is {$min_eth} eth.");
			} else if (bccomp($eth, $min_eth,$ethDecimalPlaces ) < 0) {
				throw new Exception("Minimum value is {$min_eth} eth.");
			}
			
			$eth_to_wei = bcdiv($min_wei, $min_eth);
			$eth_to_gwei = bcdiv($min_gwei, $min_eth, $gweiDecimalPlaces);
			
			$to_wei  = bcmul($eth, $eth_to_wei );
			$to_gwei = bcmul($eth, $eth_to_gwei, $gweiDecimalPlaces );
			$to_eth  = $eth;
			
		} else {
			$data = ["error"=>"Value not valid."];
		}
		
		$data = ["to_wei"=>$to_wei, "to_eth"=>$to_eth, "to_gwei"=>$to_gwei];
	} catch (Exception $e) {
		$data = ["error"=>$e->getMessage()];
	}

	die(json_encode($data));
}

include_once("html_iframe_header.php");
?>
<form action='' method='post'>
	
	<div class="form-group">
		<label for="wei">Wei:</label>
		<input class="form-control" type='text' name='wei' id='wei' value='<?php echo $_POST['wei']?>' onkeyup="
					
				var errorHolder = $(this).closest('div').find('span');
				errorHolder.empty();
				
				$.ajax({
					url: '?ajax=1&wei=' + $(this).val(), 
					success:function(result){
						try {
							j = eval('(' + result + ')');
							if ('error' in j && j.error.length>0) {
								var error = true;
							} else {
								var error = false;
							}
							
							if (!error) {
								var to_wei = j.to_wei;
								var to_gwei = j.to_gwei;
								var to_eth = j.to_eth;
								
								$('input[name=wei]').val(to_wei);
								$('input[name=gwei]').val(to_gwei);
								$('input[name=eth]').val(to_eth);
								
							} else {
								
								errorHolder.html(j.error);
							}
						} catch(e) {
							
						}
					},
					complete:function() {
						
					}
				});">
		<span style='color:red'></span>
	</div>

	<div class="form-group">
		<label for="gwei">Gwei:</label>
		<input class="form-control" type='text' name='gwei' id='gwei' value='<?php echo $_POST['gwei']?>' onkeyup="
		
				var errorHolder = $(this).closest('div').find('span');
				errorHolder.empty();
				
				$.ajax({
					url: '?ajax=1&gwei=' + $(this).val(), 
					success:function(result){
						
						try {
							j = eval('(' + result + ')');
							if ('error' in j && j.error.length>0) {
								var error = true;
							} else {
								var error = false;
							}
							
							if (!error) {
								var to_wei = j.to_wei;
								var to_gwei = j.to_gwei;
								var to_eth = j.to_eth;
								
								$('input[name=wei]').val(to_wei);
								$('input[name=gwei]').val(to_gwei);
								$('input[name=eth]').val(to_eth);
								
							} else {
								
								errorHolder.html(j.error);
							}
						} catch(e) {
							
						}
					},
					complete:function() {
						
					}
				});">
		<span style='color:red'></span>
	</div>
	
	<div class="form-group">
		<label for="eth">ETH:</label>
		<input class="form-control" type='text' name='eth' id='eth' value='<?php echo $_POST['eth']?>' onkeyup="
		
				var errorHolder = $(this).closest('div').find('span');
				errorHolder.empty();
				
				$.ajax({
					url: '?ajax=1&eth=' + $(this).val(), 
					success:function(result){
						try {
							j = eval('(' + result + ')');
							if ('error' in j && j.error.length>0) {
								var error = true;
							} else {
								var error = false;
							}
							
							if (!error) {
								var to_wei = j.to_wei;
								var to_gwei = j.to_gwei;
								var to_eth = j.to_eth;
								
								$('input[name=wei]').val(to_wei);
								$('input[name=gwei]').val(to_gwei);
								$('input[name=eth]').val(to_eth);
								
							} else {
								
								errorHolder.html(j.error);
							}
						} catch(e) {
							
						}
					},
					complete:function() {
						
					}
				});">
		<span style='color:red'></span>
	</div>
</form>

<?php 
include_once("html_iframe_footer.php");