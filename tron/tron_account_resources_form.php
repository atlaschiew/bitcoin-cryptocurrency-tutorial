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
		$result = $tron->getAccountResources($_POST['address']);
		$trxBalance = (string)$tron->getBalance($_POST['address']);
		$chainParams = $tron->getManager()->request("wallet/getchainparameters", [], "get");
		
        $energyBurnTrxFee = (string)getChainParamValue($chainParams['chainParameter'], $key = "getEnergyFee");
		$energyByBurnTrx = bcdiv($trxBalance, $energyBurnTrxFee);
		
		$bandwidthBurnTrxFee = (string)getChainParamValue($chainParams['chainParameter'], $key = "getTransactionFee");
		$bandwidthByBurnTrx = bcdiv($trxBalance, $bandwidthBurnTrxFee);
    ?>
		
			<h6 class="mt-3">Account Energy</h6>
			<table class='table table-bordered table-sm' >
				<tr><td style="width:30%;">Account Energy From Freezing TRX:</td><td><?php echo $energyByFreezeTRX = (string)(int)$result['EnergyLimit']?></td></tr>
				<tr><td>Account Energy Used:</td><td><?php echo $energyUsedByFreezeTRX = (string)(int)$result['EnergyUsed']?></td></tr>
				<tr><td></td><td><b><?php echo $remainingEnergyByFreezeTRX = bcsub($energyByFreezeTRX, $energyUsedByFreezeTRX)?></b></td></tr>
				<tr><td>Energy By Burning All <?php echo bcmul($trxBalance, SUN_TO_TRX,6)?> TRX:</td><td><b><?php echo $energyByBurnTrx?></b></td></tr>
				<tr style='font-weight:bold;background-color:#FFFFCC;'><td>Account Remaining Energy:</td><td><?php echo bcadd($remainingEnergyByFreezeTRX, $energyByBurnTrx)?></td></tr>
			</table>
			
			<h6 class="mt-3">Account Bandwidth</h6>
			<table class='table table-bordered table-sm' >
				<tr><td style="width:30%;">Free BP:</td><td><?php echo $bandwidthByFree = (string)(int)$result['freeNetLimit']?></td></tr>
				<tr><td>Free BP Used:</td><td><?php echo $bandwidthUsedByFree = (string)(int)$result['freeNetUsed']?></td></tr>
				<tr><td></td><td><b><?php echo $remainingBandwidthByFree = bcsub($bandwidthByFree, $bandwidthUsedByFree)?></b></td></tr>
				<tr><td>Frozen Trx BP:</td><td><?php echo $bandwidthByFreezeTRX = (string)(int)$result['NetLimit'] ?></td></tr>
				<tr><td>Frozen Trx BP Used:</td><td><?php echo $bandwidthUsedByFreezeTRX = (string)(int)$result['NetUsed'] ?></td></tr>
				<tr><td></td><td><b><?php echo $remainingBandwidthByFreezeTRX = bcsub($bandwidthByFreezeTRX, $bandwidthUsedByFreezeTRX)?></b></td></tr>
				<tr><td>Bandwidth By Burning All <?php echo bcmul($trxBalance, SUN_TO_TRX,6)?> TRX:</td><td><b><?php echo $bandwidthByBurnTrx?></b></td></tr>
				<tr style='font-weight:bold;background-color:#FFFFCC;'><td>Account Remaining Bandwidth:</td><td><?php echo bcadd(bcadd($remainingBandwidthByFree,$remainingBandwidthByFreezeTRX),$bandwidthByBurnTrx)?></td></tr>
			</table>
			
			<h6 class="mt-3">Function Return Result (Original)</h6>
			<textarea class="form-control" rows="12" id="comment" readonly><?Php print_r($result)?></textarea>
		
		
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
        <label for="address">Address:</label>
        <input class="form-control" type='text' name='address' id='address' value='<?php echo $_POST['address']?>'>
    </div>
	
    <input type='submit' class="btn btn-success btn-block"/>
</form>
<?php
include_once("html_iframe_footer.php");