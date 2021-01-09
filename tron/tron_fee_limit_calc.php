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
		
        $energyFeeForBurnTrx = (string)getChainParamValue($chainParams['chainParameter'], $key = "getEnergyFee");
		$energyByBurnTrx = bcdiv($trxBalance, $energyFeeForBurnTrx);
		
		$consumeEnergy = $_POST['consume_energy'];
		
		$userFeePercentage = 100;
		if (ctype_digit($_POST['contract_fee_percentage'])) {
			$userFeePercentage = 100 - (int)$_POST['contract_fee_percentage'];
			$consumeEnergy = bcmul($consumeEnergy, (string)($userFeePercentage / 100));
		} 
		
		$estFeeLimit = bcmul($consumeEnergy, $energyFeeForBurnTrx );
		$estFeeLimit = bcmul($estFeeLimit, SUN_TO_TRX, 6); 
		
    ?>
		<h6 class="mt-3">Account Energy</h6>
		<table class='table table-bordered table-sm' >
			<tr><td style="width:30%;">Account Energy From Freezing TRX:</td><td><?php echo $energyByFreezeTRX = (string)(int)$result['EnergyLimit']?></td></tr>
			<tr><td>Account Energy Used:</td><td><?php echo $energyUsedByFreezeTRX = (string)(int)$result['EnergyUsed']?></td></tr>
			<tr><td></td><td><b><?php echo $remainingEnergyByFreezeTRX = bcsub($energyByFreezeTRX, $energyUsedByFreezeTRX)?></b></td></tr>
			<tr><td>Energy By Burning All <?php echo bcmul($trxBalance, SUN_TO_TRX,6)?> TRX:</td><td><b><?php echo $energyByBurnTrx?></b></td></tr>
			<tr style='font-weight:bold;background-color:#FFFFCC;'><td>Account Remaining Energy:</td><td><?php echo $accountEnergy = bcadd($remainingEnergyByFreezeTRX, $energyByBurnTrx)?></td></tr>
		</table>			
		<?php
		
		if(bccomp($accountEnergy, $consumeEnergy) >= 0) {
			$isEnergySufficient = "YES";
		} else {
			$isEnergySufficient = "NO";
		}
		?>
		<h6 class="mt-3">Fee Limit Estimation</h6>
		<table class='table table-bordered table-sm' >
			<tr><td style="width:30%;">Energy Consumption Ratio:</td><td>Contract Creator: <?php echo (int)$_POST['contract_fee_percentage']?>%, Caller: <?php echo $userFeePercentage?>%</td></tr>
			<tr><td style="width:30%;">Fee Limit Estimation:</td><td><?php echo $estFeeLimit?> TRX</td></tr>
			<tr><td style="width:30%;">Energy Of Fee Limit:</td><td><?php echo $consumeEnergy?> Energy</td></tr>
			<tr><td style="width:30%;">Is Energy Sufficient:</td><td><?php echo $isEnergySufficient?></td></tr>
		</table>
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
		<label for="chain">Chain *:</label>
		<select id="chain" name="chain" class="form-control" >
			<?php
			foreach($supportChains as $k=>$v) {
				echo "<option value='{$k}'".($k == $_POST['chain'] ? " selected": "").">{$v}</option>";
			}
			?>
		</select>
	</div>
	
    <div class="form-group">
        <label for="address">Address *:</label>
        <input class="form-control" type='text' name='address' id='address' value='<?php echo $_POST['address']?>'>
    </div>
	
	
	<div class="form-group">
		<label for="consume_energy">Consume Energy By Deploy Or Trigger Contract *:</label>
		
		<div class="input-group mb-3">
			<input class="form-control" type='text' name='consume_energy' id='consume_energy' value='<?php echo $_POST['consume_energy']?>'>
			<div class="input-group-append">
				<span class="input-group-text">
					Energy
				</span>
			</div>
		</div>
		
		<small>
		For example, assume contract last execution consumes 18000 Energy, so estimate this time will consume 20000 Energy.
		</small>
	</div>
	
	<div class="form-group">
		<label for="contract_fee_percentage">Contract Creator Proportion Of Energy Consumption %:</label>
		
		<div class="input-group mb-3">
			<input class="form-control" type='text' name='contract_fee_percentage' id='contract_fee_percentage' value='<?php echo $_POST['contract_fee_percentage']?>'>
			<div class="input-group-append">
				<span class="input-group-text">
					%, [0,100]
				</span>
			</div>
		</div>
		
		<small>
		Put blank means caller takes 100% of energy consumption. This field assumes that contract creator has enough energy.
		</small>
	</div>
	
    <input type='submit' class="btn btn-success btn-block"/>
</form>
<?php
include_once("html_iframe_footer.php");