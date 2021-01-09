<?php 
use IEXBase\TronAPI\Tron;
use IEXBase\TronAPI\Support;

define("TRX_TO_SUN",'1000000');
define("SUN_TO_TRX", '0.000001');

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
		$result = $tron->getManager()->request("wallet/broadcasthex", ["transaction"=>$_POST['tx_hex']], "post");
		
		if ($result['result'] != '1') {
			throw new Exception(json_encode($result));
		} else if ($result['code'] != 'SUCCESS') {
			throw new Exception(json_encode($result));
		}
		
    ?>
        <div class="alert alert-success">
			<?php echo json_encode($result)?>
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
        <label for="tx_hex">Transaction Hex:</label>
        <input class="form-control" type='text' name='tx_hex' id='tx_hex' value='<?php echo $_POST['tx_hex']?>'>
    </div>
	
    <input type='submit' class="btn btn-success btn-block"/>
</form>
<?php
include_once("html_iframe_footer.php");