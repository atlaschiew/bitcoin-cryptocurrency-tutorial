<?php 
use BitWasp\Bitcoin\Transaction\TransactionFactory;

include_once "../common.php"; //include this just to derive $_ELECTRUM_CONFIG[...] variable
include_once "../libraries/vendor/autoload.php";

$supportCoins = ['btc/main'=>"Bitcoin Mainnet", 'btc/test'=>"Bitcoin Testnet"];
$hasResult = false;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	
	try { 
		$postFields = [
			'id'=>'curltext',
			'method'=>'getaddressunspent',
			'params'=> [$_POST['address']]
		];
		
		$electrumRpcProtocol = "http";
		$electrumRpcHost = $_ELECTRUM_CONFIG['electrum_rpc_host'];

		if ($_POST['network'] == 'btc/test') {
			$electrumRpcPort = "7778";
			
		} else {
			$electrumRpcPort = "7777";
		}
		
		$electrumRpcUser = $_ELECTRUM_CONFIG['electrum_rpc_user'];
		$electrumRpcPwd = $_ELECTRUM_CONFIG['electrum_rpc_pwd'];
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url = "{$electrumRpcProtocol}://{$electrumRpcHost}:{$electrumRpcPort}");
		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_POST , 1);
		curl_setopt($ch, CURLOPT_USERPWD , "{$electrumRpcUser}:{$electrumRpcPwd}");
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postFields));

		$rawResult = curl_exec($ch);
		
		if (curl_errno($ch)) { 
			throw new Exception('CURL Error: ' . curl_error($ch). "#" . curl_errno($ch));
		} else if (!($result = json_decode($rawResult,true))) {
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
				curl_setopt($ch, CURLOPT_URL, "{$electrumRpcProtocol}://{$electrumRpcHost}:{$electrumRpcPort}");
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
				curl_setopt($ch, CURLOPT_POST , 1);
				curl_setopt($ch, CURLOPT_USERPWD , "{$electrumRpcUser}:{$electrumRpcPwd}");
				curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
				curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['id'=>'curltext','method'=>'gettransaction','params'=> [$utxo['tx_hash']]]));

				$thisRawResult = curl_exec($ch);
		
				if (curl_errno($ch)) { 
					throw new Exception('CURL Error: ' . curl_error($ch). "#" . curl_errno($ch));
				} else if (!($thisResult = json_decode($thisRawResult,true))) {
					throw new Exception('Invalid JSON format.');
				} else if (is_array($thisResult['error']) AND $thisResult['error'] !='null') {
					throw new Exception('Electrum Error: ' . $thisResult['error']['message'] . "#" . $thisResult['error']['code']);
				} else {
					$utxhex = $thisResult['result']['hex'];
					
					$utx = TransactionFactory::fromHex($utxhex);
					$result['result'][$k]['script_pub_key'] = $utx->getOutputs()[$utxo['tx_pos']]->getScript()->getHex();
				}
				
				
				curl_close($ch);
			}
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
		<strong>Error!</strong> <?php echo $errmsg?>
	</div>
<?php
}

if ($hasResult) {
?>
	<div class="table-responsive">
		<table border=0 class='table'>
			<tr><td style='width:20%;'>Raw Electrum Result </td><td style='width:80%;'><textarea class="form-control" readonly rows=8><?php echo $rawResult;?></textarea></td></tr>
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

	<input type='submit' class="btn btn-success btn-block"/>
</form>
<?php 
include_once("html_iframe_footer.php");