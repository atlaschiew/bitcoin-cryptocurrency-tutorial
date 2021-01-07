<?php 

session_start();

$supportCoins = ['btc/main'=>"Bitcoin Mainnet", 'btc/test3'=>"Bitcoin Testnet3", 'dash/main'=>"Dash Mainnet", 'doge/main'=>"Dogecoin Mainnet", 'ltc/main'=>"Litecoin Mainnet",'bcy/test'=>"Blockcypher Testnet"];
$hasResult = false;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	
	try { 
	
		if(md5($_POST['captcha']) != $_SESSION['CAPTCHA_FORM1']){
			throw new Exception("CAPTCHA verification failed.");
		} else if (!isset($supportCoins[$_POST['network']])) {
			throw new Exception('Network not found.');
		} else {
			$networkName = $_POST['network'];
		}

		$url = "https://api.blockcypher.com/v1/{$networkName}/addrs/{$_POST['address']}?unspentOnly=true&includeHex=true";
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

		$rawUtxos = curl_exec($ch);
		$rawUtxos = json_decode($rawUtxos,true);
		
		if ($rawUtxos['error']) {
			throw new Exception("URL: {$url}, Error: {$rawUtxos['error']}.");
		}
		
		$utxos = $rawUtxos['txrefs'];
		
		if (!@count($utxos)) {
			throw new Exception("UTXO not found.");
		}
		
		curl_close($ch);
		
		foreach($utxos as $k=>$utxo) {
			$url = "https://api.blockcypher.com/v1/{$networkName}/txs/{$utxo['tx_hash']}?outstart={$utxo['tx_output_n']}&instart=99999999&limit=1";

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

			$prevOutput = curl_exec($ch);
			$prevOutput = json_decode($prevOutput,true);
			
			if ($prevOutput['error']) {
				throw new Exception("URL: {$url}, Error: {$prevOutput['error']}.");
			}
		
			$prevOutput = $prevOutput['outputs'][0];
			$utxos[$k]['script'] = $prevOutput['script'];
			
			curl_close($ch);
		}

		$hasResult = true;
		
	} catch (Exception $e) {
		$errmsg .= "Problem found. " . $e->getMessage();

	}
}

include_once("html_iframe_header.php");
if ($errmsg) {
?>
	<div class="alert alert-danger">
		<strong>Error!</strong><br/><?php echo $errmsg?>
	</div>
<?php
}

if ($hasResult) {
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
			foreach($supportCoins as $k=>$v) {
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