<?php 
use kornrunner\Ethereum\Transaction;
use kornrunner\Keccak;

include_once "../libraries/vendor/autoload.php";
include_once("html_iframe_header.php");
include_once("eth_utils.php");

define("GWEI_TO_WEI",'1000000000');
define("ETH_TO_WEI",'1000000000000000000');

$supportChains = ['1'=>"Ethereum Mainnet", '3'=>"Ethereum Testnet Ropsten"];

unset($_REQUEST);
$_REQUEST = array("chain"=>"","nonce"=>"","gas_price"=>"","gas_limit"=>"","to"=>"","data"=>"","value"=>"","privkey"=>"");
$disableFields = explode(",", $_GET["disable_fields"]);
foreach($_REQUEST as $k=>$v) {
	if (isset($_POST[$k])) {
		$_REQUEST[$k] = $_POST[$k];
	} else {
		$_REQUEST[$k] = $_GET[$k];
	}
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
		
		$nonce = bcdechex($_REQUEST['nonce']);
		$gasPrice = bcdechex(bcmul($_REQUEST['gas_price'],GWEI_TO_WEI, 18));
		$gasLimit = bcdechex($_REQUEST['gas_limit']);
		$to = $_REQUEST['to'];
		$value = bcdechex(bcmul($_REQUEST['value'],ETH_TO_WEI, 18));
		
		if (strlen(trim($_REQUEST['data']))) {
			$data = trim($_REQUEST['data']);
		} else {
			$data = "";
		}
		
		$transaction = new Transaction ($nonce, $gasPrice, $gasLimit, $to, $value,$data);
		$rawTx = $transaction->getRaw($_REQUEST['privkey'], $_REQUEST['chain']);
		$txHash = Keccak::hash(hex2bin($rawTx), 256);
    ?>
       <div class="alert alert-success">
			<h6 class="mt-3">Final TX Hex</h6>
			<textarea class="form-control" rows="5" id="comment"><?php echo $rawTx;?></textarea>
			<p>
			<?php
			
			if ($_REQUEST['chain'] == "1") {
			?>
				* <a href="https://etherscan.io/pushTx" target="_blank">https://etherscan.io/pushTx</a>
			<?php
			} else {
			?>
			
				* <a href="https://ropsten.etherscan.io/pushTx" target="_blank">https://ropsten.etherscan.io/pushTx</a>
				
			<?php
			}
			?>
			</p>
			
			<h6 class="mt-3">TX Hash</h6>
			<input class="form-control" readonly value="<?php echo $txHash?>"/>
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
<form action='<?php echo $_SERVER['QUERY_STRING'] ? '?'.$_SERVER['QUERY_STRING'] : ""?>' method='post'>

	
	<div class="form-group">
		<label for="chain">Chain:</label>
		<select id="chain" name="chain" class="form-control"<?php echo in_array("chain", $disableFields) ? " readonly" : ""?>>
			<?php
			foreach($supportChains as $k=>$v) {
				echo "<option value='{$k}'".($k == $_REQUEST['chain'] ? " selected": "").">{$v}</option>";
			}
			?>
		</select>
	</div>
	
	 <div class="form-group">
        <label for="nonce">Nonce:</label>
        <input class="form-control" type='text' name='nonce' id='nonce' value='<?php echo $_REQUEST['nonce']?>' <?php echo in_array("nonce", $disableFields) ? " readonly" : ""?>>
		
		<small>
			Learn more <a href='eth_tx_nonce.php' target='_blank'>here</a>.
		</small>
    </div>
	
	<div class="form-group">
		<label for="gas_price">Gas Price:</label>
		
		<div class="input-group mb-3">
			<input class="form-control" type='text' name='gas_price' id='gas_price' value='<?php echo $_REQUEST['gas_price']?>' <?php echo in_array("gas_price", $disableFields) ? " readonly" : ""?>>
			<div class="input-group-append">
			  <span class="input-group-text">GWEI</span>
			</div>
		</div>
	</div>
	
	 <div class="form-group">
        <label for="gas_limit">Gas Limit:</label>
        <input class="form-control" type='text' name='gas_limit' id='gas_limit' value='<?php echo $_REQUEST['gas_limit']?>' <?php echo in_array("gas_limit", $disableFields) ? " readonly" : ""?>>
    </div>
	
	
    <div class="form-group">
        <label for="to">To:</label>
        <input placeholder="Address" class="form-control" type='text' name='to' id='to' value='<?php echo $_REQUEST['to']?>' <?php echo in_array("to", $disableFields) ? " readonly" : ""?>>
    </div>
	
	<div class="form-group">
        <label for="data">Data (Hex):</label>
        <input class="form-control" type='text' name='data' id='data' value='<?php echo $_REQUEST['data']?>' <?php echo in_array("data", $disableFields) ? " readonly" : ""?>>
    </div>
   
   <div class="form-group">
		<label for="value">ETH Value:</label>
		
		<div class="input-group mb-3">
			<input class="form-control" type='text' name='value' id='value' value='<?php echo $_REQUEST['value']?>' <?php echo in_array("value", $disableFields) ? " readonly" : ""?>>
			<div class="input-group-append">
			  <span class="input-group-text">ETH</span>
			</div>
		</div>
	</div>
	
    <div class="form-group">
        <label for="privkey">From:</label>
        <input placeholder="Sender's Private Key (Hex)" class="form-control" type='text' name='privkey' id='privkey' value='<?php echo $_REQUEST['privkey']?>' <?php echo in_array("privkey", $disableFields) ? " readonly" : ""?>>
    </div>
   
    <input type='submit' class="btn btn-success btn-block"/>
</form>
<?php
include_once("html_iframe_footer.php");