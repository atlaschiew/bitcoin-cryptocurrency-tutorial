<?php 
use IEXBase\TronAPI\Tron;
use IEXBase\TronAPI\Support;
use kornrunner\Keccak;
use Web3\Contracts\Ethabi;
use Web3\Contracts\Types\{Address, Boolean, Bytes, DynamicBytes, Integer, Str, Uinteger};

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
		
		$tx = $tron->getTransaction($_POST['tx_hash']);
		$txInfo = $tron->getTransactionInfo($_POST['tx_hash']);
		$humanTxInfo = $txInfo;
		
		if (isset($humanTxInfo['resMessage'])) 
			$humanTxInfo['resMessage'] = hex2str($humanTxInfo['resMessage']);
		
		if (isset($humanTxInfo['contract_address'])) 
			$humanTxInfo['contract_address'] = hexString2Base58check($humanTxInfo['contract_address']);
		
		if (isset($humanTxInfo['fee'])) 
			$consumedFeeLimit = bcmul($humanTxInfo['fee'], SUN_TO_TRX, 6);
			$totalFeeLimit = bcmul($tx['raw_data']['fee_limit'], SUN_TO_TRX, 6);
			
			$humanTxInfo['fee'] = "{$consumedFeeLimit} TRX / {$totalFeeLimit} TRX";
			$humanTxInfo['fee'] .= ", consumed ".bcmul(bcdiv($consumedFeeLimit,$totalFeeLimit,6), "100", 2)."% of fee limit";
		
		if (isset($humanTxInfo['receipt']['energy_fee'])) {
			$humanTxInfo['receipt']['energy_fee'] =  bcmul($humanTxInfo['receipt']['energy_fee'], SUN_TO_TRX, 6). " TRX or {$humanTxInfo['receipt']['energy_fee']} SUN";
		}
		
		if (isset($humanTxInfo['receipt']['origin_energy_usage'])) {
			$humanTxInfo['receipt']['origin_energy_usage'] .= " Energy";
		}
		
		if (isset($humanTxInfo['receipt']['energy_usage_total'])) {
			$humanTxInfo['receipt']['energy_usage_total'] .= " Energy";
		}
		
		if (isset($humanTxInfo['receipt']['energy_usage'])) {
			$humanTxInfo['receipt']['energy_usage'] .= " Energy";
		}
		
		if (isset($humanTxInfo['receipt']['net_usage'])) {
			$humanTxInfo['receipt']['net_usage'] .= " Bandwidth";
		}
		
		if (isset($humanTxInfo['receipt']['net_fee'])) {
			$humanTxInfo['receipt']['net_fee'] =  bcmul($humanTxInfo['receipt']['net_fee'], SUN_TO_TRX, 6). " TRX or {$humanTxInfo['receipt']['net_fee']} SUN";
		}
		
		$contractDetails = [];
		$ethAbi = new Ethabi(['address' => new Address,'bool' => new Boolean,'bytes' => new Bytes,'dynamicBytes' => new DynamicBytes,'int' => new Integer,'string' => new Str,'uint' => new Uinteger,]);
		
		if (is_array($humanTxInfo['log'])) {
			//refer to https://developers.tron.network/docs/vm-event about how to decode this
			foreach($humanTxInfo['log'] as $k=>$log) {
				if (isset($humanTxInfo['log'][$k]['address'])) {
					$humanTxInfo['log'][$k]['address'] = hexString2Base58check($contractAddress = "41" . $humanTxInfo['log'][$k]['address']);
					
					if (!$contractDetails[$contractAddress]) {
						$contractDetail = $tron->getManager()->request("wallet/getcontract", ["value"=>$contractAddress], "post");
						$contractDetails[$contractAddress] = $contractDetail;
					}
					
					//decode
					$topicPointer = 0;
					$targetFunction = $humanTxInfo['log'][$k]['topics'][ $topicPointer++ ];
					$abiItems = $contractDetails[$contractAddress]['abi']['entrys'];
					
					foreach($abiItems as $item) {
						if ($item['type'] == 'Event') {
							$functionParams = [];
							if (@count($item['inputs']) > 0)  {
								foreach($item['inputs'] as $input) {
									$functionParams[] = $input['type'];
								}
							}
							
							$compareFunction = Keccak::hash($plain = "{$item['name']}(".implode(",",$functionParams).")",256);
							
							if ($compareFunction == $targetFunction) {
								$humanTxInfo['log'][$k]['topics'][0] = $plain;
								$functionNames = $functionParams = [];
								
								if (@count($item['inputs']) > 0)  {
									foreach($item['inputs'] as $input) {
										
										if($input['indexed'] === true) {
											$thisTopic = $topicPointer++;
											$paramValue = $humanTxInfo['log'][$k]['topics'][ $thisTopic ];
											$decodedValue = $ethAbi->decodeParameter($input['type'], $paramValue);
											if ($input['type'] == 'address') {
												$humanTxInfo['log'][$k]['topics'][ $thisTopic ] = hexString2Base58check("41".substr($decodedValue, 2));
											}
										} else {
											$functionParams[] = $input['type'];
											$functionNames[] = $input['name'];
										}
									}
								}
								
								$nonIndexedData = $humanTxInfo['log'][$k]['data'];
								if (count($functionParams) > 0 AND strlen($nonIndexedData) > 0) {
									$decodedValues = $ethAbi->decodeParameters($functionParams, $nonIndexedData);
									
									if (@count($decodedValues) > 0) {
										$humanTxInfo['log'][$k]['decodedData'] = [];
										foreach($decodedValues as $k2=>$decodedValue) {
											
											if (is_bool($decodedValue)) {
												$decodedValue = ($decodedValue === true) ? "true" : "false";
											}
											
											$humanTxInfo['log'][$k]['decodedData'][] = "Parameter Details - Name: {$functionNames[$k2]}, Data Type: {$functionParams[$k2]}, Value: {$decodedValue}";
											
										}
									}
								}
							} 
						}
					}
				}
			}
		}
		

		if ($txInfo['result'] == 'FAILED') {
			$label = "danger";
		} else {
			$label = "success";
		}
    ?>
        <div class="alert alert-<?php echo $label?>">
			<h6 class="mt-3">Function Return Result (Original)</h6>
			<textarea class="form-control" rows="10" id="comment" readonly><?Php print_r($txInfo)?></textarea>
		</div>
		
		<div class="alert alert-<?php echo $label?>">
			<h6 class="mt-3">Function Return Result (Human Readable)</h6>
			<textarea class="form-control" rows="20" id="comment" readonly><?Php print_r($humanTxInfo)?></textarea>
		</div>
		
		
		<!--
		This is a contract created by another contract. So there's no chance for the developer to set an ABI.
		You should refer to the creator contract's code.
		-->
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
		<label for="chain">Description:</label>
		<table class='table table-bordered table-sm' >
		<tr><td style="width:30%;">$txInfo[fee]:</td><td>Consumption of fee, capped at fee limit.</td></tr>
			<tr><td style="width:30%;">$txInfo[receipt][energy_usage]:</td><td>Consumption of Energy by contract caller (not include energy_fee).</td></tr>
			<tr><td>$txInfo[receipt][energy_fee]:</td><td>Consumption of TRX (SUN) by contract caller due to insufficient Energy.</td></tr>
			<tr><td>$txInfo[receipt][origin_energy_usage]:</td><td>Consumption of Energy provided by contract owner.</td></tr>
			<tr><td>$txInfo[receipt][energy_usage_total]:</td><td>The total amount of Energy consumed in contract(including the number of Energy corresponding to energy_usage, origin_energy_usage, and energy_fee).</td></tr>
			
			<tr><td>$txInfo[receipt][net_usage]:</td><td>Consumption of Bandwith by contract caller (not include net_fee).</td></tr>
			<tr><td>$txInfo[receipt][net_fee]:</td><td>Consumption of TRX (SUN) by contract caller due to insufficient Bandwith.</td></tr>
		</table>
	</div>
	
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
        <label for="tx_hash">Transaction Hash:</label>
        <input class="form-control" type='text' name='tx_hash' id='tx_hash' value='<?php echo $_POST['tx_hash']?>'>
    </div>
	
    <input type='submit' class="btn btn-success btn-block"/>
</form>
<?php
include_once("html_iframe_footer.php");