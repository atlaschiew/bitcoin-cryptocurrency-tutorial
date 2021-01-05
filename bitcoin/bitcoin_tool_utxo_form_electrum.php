<?php 
use BitWasp\Bitcoin\Transaction\TransactionFactory;

include_once "../common.php"; //include this just to derive $_ELECTRUM_CONFIG[...] variable
include_once "../libraries/vendor/autoload.php";

$support_coins = ['btc/main'=>"Bitcoin Mainnet", 'btc/test'=>"Bitcoin Testnet"];
$has_result = false;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	
	try { 
		$post_fields = [
			'id'=>'curltext',
			'method'=>'getaddressunspent',
			'params'=> [$_POST['address']]
		];
		
		$electrum_rpc_protocol = "http";
		$electrum_rpc_host = $_ELECTRUM_CONFIG['electrum_rpc_host'];

		if ($_POST['network'] == 'btc/test') {
			$electrum_rpc_port = "7778";
			
		} else {
			$electrum_rpc_port = "7777";
		}
		
		$electrum_rpc_user = $_ELECTRUM_CONFIG['electrum_rpc_user'];
		$electrum_rpc_pwd = $_ELECTRUM_CONFIG['electrum_rpc_pwd'];
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url = "{$electrum_rpc_protocol}://{$electrum_rpc_host}:{$electrum_rpc_port}");
		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_POST , 1);
		curl_setopt($ch, CURLOPT_USERPWD , "{$electrum_rpc_user}:{$electrum_rpc_pwd}");
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_fields));

		$raw_result = curl_exec($ch);
		
		if (curl_errno($ch)) { 
			throw new Exception('CURL Error: ' . curl_error($ch). "#" . curl_errno($ch));
		} else if (!($result = json_decode($raw_result,true))) {
			throw new Exception('Invalid JSON format.');
		} else if (is_array($result['error']) AND $result['error'] !='null') {
			throw new Exception('Electrum Error: ' . $result['error']['message'] . "#" . $result['error']['code']);
		} else if (!@count($result['result'])) {
			throw new Exception("UTXO not found.");
		} else {
			
			curl_close($ch);
			
			//find utxo's scriptpubkey
			foreach($result['result'] as $k=> $utxo) {
				
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, "{$electrum_rpc_protocol}://{$electrum_rpc_host}:{$electrum_rpc_port}");
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
				curl_setopt($ch, CURLOPT_POST , 1);
				curl_setopt($ch, CURLOPT_USERPWD , "{$electrum_rpc_user}:{$electrum_rpc_pwd}");
				curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
				curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['id'=>'curltext','method'=>'gettransaction','params'=> [$utxo['tx_hash']]]));

				$this_raw_result = curl_exec($ch);
		
				if (curl_errno($ch)) { 
					throw new Exception('CURL Error: ' . curl_error($ch). "#" . curl_errno($ch));
				} else if (!($this_result = json_decode($this_raw_result,true))) {
					throw new Exception('Invalid JSON format.');
				} else if (is_array($this_result['error']) AND $this_result['error'] !='null') {
					throw new Exception('Electrum Error: ' . $this_result['error']['message'] . "#" . $this_result['error']['code']);
				} else {
					$utxhex = $this_result['result']['hex'];
					
					$utx = TransactionFactory::fromHex($utxhex);
					$result['result'][$k]['script_pub_key'] = $utx->getOutputs()[$utxo['tx_pos']]->getScript()->getHex();
				}
				
				
				curl_close($ch);
			}
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
			<tr><td style='width:20%;'>Raw Electrum Result </td><td style='width:80%;'><textarea class="form-control" readonly rows=8><?php echo $raw_result;?></textarea></td></tr>
		</table>
		<table border=0 class='table'>
			
			<tr><th>Tx Hash</th><th>Index</th><th>Script</th><th>Amount</th></tr>
			<?php
			foreach($result['result'] as $utxo) {
				echo "<tr><td>{$utxo['tx_hash']}</td><td>{$utxo['tx_pos']}</td><td>{$utxo['script_pub_key']}</td><td>{$utxo['value']}</td></tr>";
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

	<input type='submit' class="btn btn-success btn-block"/>
</form>
<?php 
include_once("html_iframe_footer.php");