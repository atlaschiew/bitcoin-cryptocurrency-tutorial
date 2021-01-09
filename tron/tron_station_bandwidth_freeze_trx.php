<?php 

include_once "../libraries/vendor/autoload.php";
include_once("html_iframe_header.php");
include_once("tron_utils.php");

define("TRX_TO_SUN",'1000000');
define("SUN_TO_TRX", '0.000001');

$supportChains = ['main'=>"Tron Mainnet", 'shasta'=>"Shasta Testnet"];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
		
		if (!is_numeric($_POST['input'])) {
			throw new Exception("Please fill in numeric.");
		}
		
		if ($_POST['chain'] == 'main') {
            $fullNode = new \IEXBase\TronAPI\Provider\HttpProvider('https://api.trongrid.io');
            $solidityNode = new \IEXBase\TronAPI\Provider\HttpProvider('https://api.trongrid.io');
            $eventServer = new \IEXBase\TronAPI\Provider\HttpProvider('https://api.trongrid.io');
			
			$anyActivatedAddress = "TRta2KsGxUBadKEffZFirTQypjkAyzFsFx";
        } else {
            $fullNode = new \IEXBase\TronAPI\Provider\HttpProvider('https://api.shasta.trongrid.io');
            $solidityNode = new \IEXBase\TronAPI\Provider\HttpProvider('https://api.shasta.trongrid.io');
            $eventServer = new \IEXBase\TronAPI\Provider\HttpProvider('https://api.shasta.trongrid.io');
			
			$anyActivatedAddress = "TFBjcM5pVqokCX3KRxCZbEorRTw8ZHc2Pw";
        }
		
		$tron = new \IEXBase\TronAPI\Tron($fullNode, $solidityNode, $eventServer);
		$networkResources = $tron->getAccountResources($anyActivatedAddress);
		
		$bandwidthPerTrx = bcdiv($networkResources['TotalNetLimit'],$networkResources['TotalNetWeight'],6);
		$trxPerBandwidth = bcdiv("1", $bandwidthPerTrx, 6);
    ?>
	<div class="alert alert-success">
		<p>
		Total TRX Frozen For Gaining Bandwidth: <b><?php echo $networkResources['TotalNetWeight']?></b><br/>
		Total bandwidth current limit is <b><?php echo $networkResources['TotalNetLimit']?></b> Bandwidth<br/>
		1 TRX equals to <?php echo $bandwidthPerTrx?> Bandwidth
		</p>
		<p>
			<?php
			if ($_POST['unit'] == 'TRX') {
				echo "<b>" . $_POST['input'] . " TRX equals to ".bcmul($_POST['input'], $bandwidthPerTrx , 6)." Bandwidth</b>";
			} else {
				echo "<b>" . $_POST['input'] . " Bandwidth equals to ".bcmul($_POST['input'], $trxPerBandwidth , 6)." TRX</b>";
			}
			?>
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
		<label for="input">TRX or Bandwidth:</label>
		
		<div class="input-group mb-3">
			<input class="form-control" type='text' name='input' id='input' value='<?php echo $_POST['input']?>'>
			<div class="input-group-append">
				<span class="input-group-text">
					<select name="unit">
						<option value="TRX"<?Php echo $_POST['unit'] == 'TRX' ? " selected" : ""?>>TRX</option>
						<option value="bandwidth"<?Php echo $_POST['unit'] == 'bandwidth' ? " selected" : ""?>>Bandwidth</option>
					</select>
				</span>
			</div>
		</div>
		<small>
		Bandwidth obtained = TRX frozen for gaining Bandwidth / total TRX frozen for gaining Bandwidth in the entire network * total bandwidth limit.
		</small>
	</div>
	
    <input type='submit' class="btn btn-success btn-block"/>
</form>
<?php
include_once("html_iframe_footer.php");