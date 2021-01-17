<?php 

include_once "../libraries/vendor/autoload.php";
include_once("html_iframe_header.php");
include_once("tron_utils.php");

$supportChains = ['main'=>"Tron Mainnet", 'shasta'=>"Shasta Testnet"];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
		
		if ($_POST['chain'] == 'main') {
            $fullNode = new \IEXBase\TronAPI\Provider\HttpProvider('https://api.trongrid.io');
            $solidityNode = new \IEXBase\TronAPI\Provider\HttpProvider('https://api.trongrid.io');
            $eventServer = new \IEXBase\TronAPI\Provider\HttpProvider('https://api.trongrid.io');
        } else {
            $fullNode = new \IEXBase\TronAPI\Provider\HttpProvider('https://api.shasta.trongrid.io');
            $solidityNode = new \IEXBase\TronAPI\Provider\HttpProvider('https://api.shasta.trongrid.io');
            $eventServer = new \IEXBase\TronAPI\Provider\HttpProvider('https://api.shasta.trongrid.io');
        }
		
		$tron = new \IEXBase\TronAPI\Tron($fullNode, $solidityNode, $eventServer);
		
		$abi = '[{"constant":true,"inputs":[],"name":"name","outputs":[{"name":"","type":"string"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"name":"spender","type":"address"},{"name":"value","type":"uint256"}],"name":"approve","outputs":[{"name":"","type":"bool"}],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[],"name":"totalSupply","outputs":[{"name":"","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"name":"sender","type":"address"},{"name":"recipient","type":"address"},{"name":"amount","type":"uint256"}],"name":"transferFrom","outputs":[{"name":"","type":"bool"}],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[],"name":"decimals","outputs":[{"name":"","type":"uint8"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"name":"spender","type":"address"},{"name":"addedValue","type":"uint256"}],"name":"increaseAllowance","outputs":[{"name":"","type":"bool"}],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[{"name":"account","type":"address"}],"name":"balanceOf","outputs":[{"name":"","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[],"name":"symbol","outputs":[{"name":"","type":"string"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"name":"spender","type":"address"},{"name":"subtractedValue","type":"uint256"}],"name":"decreaseAllowance","outputs":[{"name":"","type":"bool"}],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":false,"inputs":[{"name":"recipient","type":"address"},{"name":"amount","type":"uint256"}],"name":"transfer","outputs":[{"name":"","type":"bool"}],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[{"name":"owner","type":"address"},{"name":"spender","type":"address"}],"name":"allowance","outputs":[{"name":"","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"inputs":[],"payable":false,"stateMutability":"nonpayable","type":"constructor"},{"anonymous":false,"inputs":[{"indexed":true,"name":"from","type":"address"},{"indexed":true,"name":"to","type":"address"},{"indexed":false,"name":"value","type":"uint256"}],"name":"Transfer","type":"event"},{"anonymous":false,"inputs":[{"indexed":true,"name":"owner","type":"address"},{"indexed":true,"name":"spender","type":"address"},{"indexed":false,"name":"value","type":"uint256"}],"name":"Approval","type":"event"}]';
		$abiAry = json_decode($abi, true);
		
		//get symbol
		$function = "symbol";
		$params = [];
		$result = $tron->getTransactionBuilder()->triggerConstantContract($abiAry, base58check2HexString($_POST['contract_address']),$function, $params, base58check2HexString($_POST['owner_address']));
		$symbol = $result[0];
		
		//get decimals
		$function = "decimals";
		$params = [];
		$result = $tron->getTransactionBuilder()->triggerConstantContract($abiAry, base58check2HexString($_POST['contract_address']),$function, $params, base58check2HexString($_POST['owner_address']));
		$decimals = $result[0]->toString();
		
		if (!is_numeric($decimals)) {
			throw new Exception("Token decimals not found");
		}
		
		//get balance 
		$function = "balanceOf";
		$params = [ str_pad(base58check2HexString($_POST['owner_address']),64,"0", STR_PAD_LEFT) ];
		$result = $tron->getTransactionBuilder()->triggerConstantContract($abiAry, base58check2HexString($_POST['contract_address']),$function, $params, base58check2HexString($_POST['owner_address']));
		$balance = $result[0]->toString();
		if (!is_numeric($balance)) {
			throw new Exception("Token balance not found");
		}
		
		$balance = bcdiv($balance, bcpow("10", $decimals), $decimals);
		
		
		
    ?>
	<div class="alert alert-success">
		<p>
			TRC20 balance is <b><?php echo $balance?> <?php echo $symbol?></b>.
		</p>
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
<form action='' method='post'>
	
	<div class="form-group">
		<label for="chain">Chain:</label>
		<select id="chain" name="chain" class="form-control" >
			<?php
			foreach($supportChains as $k=>$v) {
				echo "<option value='{$k}'".($k == $_POST['chain'] ? " selected": "").">{$v}</option>";
			}
			?>
		</select>
	</div>
	
    <div class="form-group">
        <label for="contract_address">Contract Address:</label>
        <input class="form-control" type='text' name='contract_address' id='contract_address' value='<?php echo $_POST['contract_address']?>'>
    </div>
	
	 <div class="form-group">
        <label for="owner_address">Owner Address:</label>
        <input class="form-control" type='text' name='owner_address' id='owner_address' value='<?php echo $_POST['owner_address']?>'>
    </div>
	
    <input type='submit' class="btn btn-success btn-block"/>
</form>
<?php
include_once("html_iframe_footer.php");