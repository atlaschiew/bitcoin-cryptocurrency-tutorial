<?php 

session_start();

include_once "../common.php";

//lowest bitcoin value is 1 sat
$mbtcDecimalPlaces = 5;
$btcDecimalPlaces = 8;

$min_sat = "1";
$min_mbtc = bcdiv("1", bcpow("10", (string)$mbtcDecimalPlaces), $mbtcDecimalPlaces);
$min_btc = bcdiv("1", bcpow("10", (string)$btcDecimalPlaces), $btcDecimalPlaces);

function isValidDecimal($input, $decimalPoints) {
	if (!preg_match($pattern = '/^(-)?[0-9]+(\.[0-9]{1,'.$decimalPoints.'})?$/', $input)) {
		
		return false;
	}
	
	return true;	
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' AND $_GET['ajax'] == '1') {
	$data = [];
	
	$sat  = $_GET['sat'];
	$mbtc = $_GET['mbtc'];
	$btc  = $_GET['btc'];
	
	try {
		if(is_numeric($sat)) {
			if (bccomp($sat, $min_sat) < 0) {
				throw new Exception("Minimum value is {$min_sat} sat.");
			}
			
			$sat_to_mbtc = $min_mbtc;
			$sat_to_btc  = $min_btc;
			
			$to_sat  = $sat;
			$to_mbtc = bcmul($sat, $sat_to_mbtc, $mbtcDecimalPlaces );
			$to_btc  = bcmul($sat, $sat_to_btc, $btcDecimalPlaces );
			
			
		} else if (is_numeric($mbtc)) {
			
			if (!isValidDecimal($mbtc, $mbtcDecimalPlaces)) {
				throw new Exception("Minimum value is {$min_mbtc} mbtc.");
			} else if (bccomp($mbtc, $min_mbtc, $mbtcDecimalPlaces) < 0) {
				throw new Exception("Minimum value is {$min_mbtc} mbtc.");
			}
			
			$mbtc_to_sat = bcdiv($min_sat , $min_mbtc);
			$mbtc_to_btc = bcdiv($min_btc, $min_mbtc, $btcDecimalPlaces);

			$to_sat  = bcmul($mbtc, $mbtc_to_sat );
			$to_mbtc = $mbtc;
			$to_btc  = bcmul($mbtc, $mbtc_to_btc, $btcDecimalPlaces );
			
		} else if (is_numeric($btc)) {
			
			if (!isValidDecimal($btc, $btcDecimalPlaces)) {
				throw new Exception("Minimum value is {$min_btc} btc.");
			} else if (bccomp($btc, $min_btc,$btcDecimalPlaces ) < 0) {
				throw new Exception("Minimum value is {$min_btc} btc.");
			}
			
			$btc_to_sat = bcdiv($min_sat, $min_btc);
			$btc_to_mbtc = bcdiv($min_mbtc, $min_btc, $mbtcDecimalPlaces);
			
			$to_sat  = bcmul($btc, $btc_to_sat );
			$to_mbtc = bcmul($btc, $btc_to_mbtc, $mbtcDecimalPlaces );
			$to_btc  = $btc;
			
		} else {
			$data = ["error"=>"Value not valid."];
		}
		
		$data = ["to_sat"=>$to_sat, "to_btc"=>$to_btc, "to_mbtc"=>$to_mbtc];
	} catch (Exception $e) {
		$data = ["error"=>$e->getMessage()];
	}

	die(json_encode($data));
}

include_once("html_iframe_header.php");
?>
<form action='' method='post'>
	
	<div class="form-group">
		<label for="sat">Satoshi:</label>
		<input class="form-control" type='text' name='sat' id='sat' value='<?php echo $_POST['sat']?>' onkeyup="
					
				var errorHolder = $(this).closest('div').find('span');
				errorHolder.empty();
				
				$.ajax({
					url: '?ajax=1&sat=' + $(this).val(), 
					success:function(result){
						try {
							j = eval('(' + result + ')');
							if ('error' in j && j.error.length>0) {
								var error = true;
							} else {
								var error = false;
							}
							
							if (!error) {
								var to_sat = j.to_sat;
								var to_mbtc = j.to_mbtc;
								var to_btc = j.to_btc;
								
								$('input[name=sat]').val(to_sat);
								$('input[name=mbtc]').val(to_mbtc);
								$('input[name=btc]').val(to_btc);
								
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
		<label for="mbtc">mBTC (millibitcoins):</label>
		<input class="form-control" type='text' name='mbtc' id='mbtc' value='<?php echo $_POST['mbtc']?>' onkeyup="
		
				var errorHolder = $(this).closest('div').find('span');
				errorHolder.empty();
				
				$.ajax({
					url: '?ajax=1&mbtc=' + $(this).val(), 
					success:function(result){
						
						try {
							j = eval('(' + result + ')');
							if ('error' in j && j.error.length>0) {
								var error = true;
							} else {
								var error = false;
							}
							
							if (!error) {
								var to_sat = j.to_sat;
								var to_mbtc = j.to_mbtc;
								var to_btc = j.to_btc;
								
								$('input[name=sat]').val(to_sat);
								$('input[name=mbtc]').val(to_mbtc);
								$('input[name=btc]').val(to_btc);
								
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
		<label for="btc">BTC:</label>
		<input class="form-control" type='text' name='btc' id='btc' value='<?php echo $_POST['btc']?>' onkeyup="
		
				var errorHolder = $(this).closest('div').find('span');
				errorHolder.empty();
				
				$.ajax({
					url: '?ajax=1&btc=' + $(this).val(), 
					success:function(result){
						try {
							j = eval('(' + result + ')');
							if ('error' in j && j.error.length>0) {
								var error = true;
							} else {
								var error = false;
							}
							
							if (!error) {
								var to_sat = j.to_sat;
								var to_mbtc = j.to_mbtc;
								var to_btc = j.to_btc;
								
								$('input[name=sat]').val(to_sat);
								$('input[name=mbtc]').val(to_mbtc);
								$('input[name=btc]').val(to_btc);
								
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