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

		$url = "https://api.blockcypher.com/v1/{$network_name}/addrs/{$_POST['address']}?unspentOnly=true&includeHex=true";
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

		$utxos = curl_exec($ch);
		$utxos = json_decode($utxos,true);
		$utxos = $utxos['txrefs'];
		
		if (!@count($utxos)) {
			throw new Exception("UTXO not found.");
		}
		
		curl_close($ch);
		
		foreach($utxos as $k=>$utxo) {
			$url = "https://api.blockcypher.com/v1/{$network_name}/txs/{$utxo['tx_hash']}?outstart={$utxo['tx_output_n']}&instart=99999999&limit=1";

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

			$prev_output = curl_exec($ch);
			$prev_output = json_decode($prev_output,true);
			$prev_output = $prev_output['outputs'][0];

			$utxos[$k]['script'] = $prev_output['script'];
			
			curl_close($ch);
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
			<tr><th>Tx Hash</th><th>Index</th><th>Script</th><th>Amount</th></tr>
			<?php
			foreach($utxos as $utxo) {
				echo "<tr><td>{$utxo['tx_hash']}</td><td>{$utxo['tx_output_n']}</td><td>{$utxo['script']}</td><td>{$utxo['value']}</td></tr>";
			}
			?>
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
		<label for="address">Address:</label>
		<input class="form-control" type='text' name='address' id='address' value='<?php echo $_POST['address']?>'>
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