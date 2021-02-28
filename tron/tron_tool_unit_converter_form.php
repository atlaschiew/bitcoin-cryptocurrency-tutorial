<?php 

session_start();

include_once "../common.php";

//lowest bitcoin value is 1 sun
$trxDecimalPlaces = 6;

$min_sun = "1";
$min_trx = bcdiv("1", bcpow("10", (string)$trxDecimalPlaces), $trxDecimalPlaces);

function isValidDecimal($input, $decimalPoints) {
	if (!preg_match($pattern = '/^(-)?[0-9]+(\.[0-9]{1,'.$decimalPoints.'})?$/', $input)) {
		return false;
	}
	
	return true;	
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' AND $_GET['ajax'] == '1') {
	$data = [];
	
	$sun  = $_GET['sun'];
	$trx  = $_GET['trx'];
	
	try {
		if(is_numeric($sun)) {
			if (bccomp($sun, $min_sun) < 0) {
				throw new Exception("Minimum value is {$min_sun} sun.");
			}
			
			
			$sun_to_trx  = $min_trx;
			
			$to_sun  = $sun;
			$to_trx  = bcmul($sun, $sun_to_trx, $trxDecimalPlaces );
			
		} else if (is_numeric($trx)) {
			
			if (!isValidDecimal($trx, $trxDecimalPlaces)) {
				throw new Exception("Minimum value is {$min_trx} trx.");
			} else if (bccomp($trx, $min_trx,$trxDecimalPlaces ) < 0) {
				throw new Exception("Minimum value is {$min_trx} trx.");
			}
			
			$trx_to_sun = bcdiv($min_sun, $min_trx);
			
			$to_sun  = bcmul($trx, $trx_to_sun );
			$to_trx  = $trx;
			
		} else {
			$data = ["error"=>"Value not valid."];
		}
		
		$data = ["to_sun"=>$to_sun, "to_trx"=>$to_trx];
	} catch (Exception $e) {
		$data = ["error"=>$e->getMessage()];
	}

	die(json_encode($data));
}

include_once("html_iframe_header.php");
?>
<form action='' method='post'>
	
	<div class="form-group">
		<label for="sun">Sun:</label>
		<input class="form-control" type='text' name='sun' id='sun' value='<?php echo $_POST['sun']?>' onkeyup="
					
				var errorHolder = $(this).closest('div').find('span');
				errorHolder.empty();
				
				$.ajax({
					url: '?ajax=1&sun=' + $(this).val(), 
					success:function(result){
						try {
							j = eval('(' + result + ')');
							if ('error' in j && j.error.length>0) {
								var error = true;
							} else {
								var error = false;
							}
							
							if (!error) {
								var to_sun = j.to_sun;
								var to_trx = j.to_trx;
								
								$('input[name=sun]').val(to_sun);
								$('input[name=trx]').val(to_trx);
								
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
		<label for="trx">Trx:</label>
		<input class="form-control" type='text' name='trx' id='trx' value='<?php echo $_POST['trx']?>' onkeyup="
		
				var errorHolder = $(this).closest('div').find('span');
				errorHolder.empty();
				
				$.ajax({
					url: '?ajax=1&trx=' + $(this).val(), 
					success:function(result){
						
						try {
							j = eval('(' + result + ')');
							if ('error' in j && j.error.length>0) {
								var error = true;
							} else {
								var error = false;
							}
							
							if (!error) {
								var to_sun = j.to_sun;
								var to_trx = j.to_trx;
								
								$('input[name=sun]').val(to_sun);
								$('input[name=trx]').val(to_trx);
								
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