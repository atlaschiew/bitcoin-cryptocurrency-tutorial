<?php 

session_start();

$support_coins = ['btc/main'=>"Bitcoin Mainnet", 'btc/test3'=>"Bitcoin Testnet3", 'dash/main'=>"Dash Mainnet", 'doge/main'=>"Dogecoin Mainnet", 'ltc/main'=>"Litecoin Mainnet",'bcy/test'=>"Blockcypher Testnet"];
$has_result = false;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	
	try { 
	
		if(md5($_POST['captcha']) != $_SESSION['CAPTCHA_FORM1']){
			throw new Exception("CAPTCHA verification failed.");
		} else if (!isset($support_coins[$_POST['network']])) {
			throw new Exception('Network not found.');
		} else {
			$network_name = $_POST['network'];
		}

		$url = "https://api.blockcypher.com/v1/{$network_name}/txs/{$_POST['txhash']}?includeHex=true";
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

		$tx = curl_exec($ch);
		$tx = json_decode($tx,true);
		$txhex = $tx['hex'];
		
		if (!ctype_xdigit($txhex)) {
			throw new Exception("Tx Hex not found.");
		}

		$has_result = true;
		
	} catch (Exception $e) {
		$errmsg .= "Problem found. " . $e->getMessage();
	}
}

include_once("html_iframe_header.php");
if ($errmsg) {
?>
	<div class="alert alert-danger">
		<strong>Error!</strong> <?php echo $errmsg?>
	</div>
<?php
}

if ($has_result) {
?>
	<div class="table-responsive">
		<table border=0 class='table'>
			<tr><td style='width:20%;'>Tx Hex</td><td style='width:80%;'><textarea class="form-control" readonly rows=8><?php echo $txhex;?></textarea></td></tr>
		</table>
	</div>
<?php
}
?>
<form action='' method='post'>
	<div class="form-group">
		<label for="network">Network:</label>
		<select id="network" name="network" class="form-control" >
			<?php
			foreach($support_coins as $k=>$v) {
				echo "<option value='{$k}'".($k == $_POST['network'] ? " selected": "").">{$v}</option>";
			}
			?>
		</select>
	</div>
	<div class="form-group">
		<label for="txhash">Tx Hash:</label>
		<input class="form-control" type='text' name='txhash' id='txhash' value='<?php echo $_POST['txhash']?>'>
	</div>
	
	<div class="form-group">
		<label for="captcha">CAPTCHA:</label>
		<img style='border:1px solid black' src='../verificationimage.php?key=CAPTCHA_FORM1'/>
		<input name="captcha" type="captcha" class="form-control" placeholder="CAPTCHA" id="captcha" value="">
	</div>

	<input type='submit' class="btn btn-success btn-block"/>
</form>
<?php 
include_once("html_iframe_footer.php");