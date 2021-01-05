<?php 
use kornrunner\Ethereum\Transaction;
use EthereumRPC\Contracts;
use kornrunner\Keccak;

include_once "../libraries/vendor/autoload.php";
include_once("html_iframe_header.php");

define("GWEI_TO_WEI",'1000000000');

function bcdechex($dec) {

	$last = bcmod($dec, 16);
	$remain = bcdiv(bcsub($dec, $last), 16);

	if($remain == 0) {
		return dechex($last);
	} else {
		return bcdechex($remain).dechex($last);
	}
	
}

$supportChains = ['1'=>"Ethereum Mainnet", '3'=>"Ethereum Testnet Ropsten"];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
		
		$nonce = bcdechex($_POST['nonce']);
		$gasPrice = bcdechex(bcmul($_POST['gas_price'],GWEI_TO_WEI, 18));
		$gasLimit = bcdechex($_POST['gas_limit']);
		$to = $_POST['contract_addr'];
		$amount = "0";
		
		$source = file_get_contents('erc20.abi');
		$decoded = json_decode($source, true);
		$abi = new Contracts\ABI($decoded);
		
		$recipient = $_POST['recipient'];
		$tokenAmount = bcmul($_POST['token_amount'], bcpow("10", $_POST['token_decimals'], 0), 0);
		$data = $abi->encodeCall("transfer", [$recipient, $tokenAmount]);
		
		$transaction = new Transaction ($nonce, $gasPrice, $gasLimit, $to, $amount,$data);
		$rawTx = $transaction->getRaw($_POST['privkey'], $_POST['chain']);
		$txHash = Keccak::hash(hex2bin($rawTx), 256);
    ?>
       <div class="alert alert-success">
			<h6 class="mt-3">Final TX Hex</h6>
			<textarea class="form-control" rows="5" id="comment" readonly><?php echo $rawTx;?></textarea>
			<p>
			<?php
			
			if ($_POST['chain'] == "1") {
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
			
			<h6 class="mt-3">Data (Hex)</h6>
			<textarea class="form-control" rows="5" id="comment" readonly><?php echo $data;?></textarea>
			
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
        <label for="nonce">Nonce:</label>
        <input class="form-control" type='text' name='nonce' id='nonce' value='<?php echo $_POST['nonce']?>'>
		
		 * Search sender address in <a href='https://blockchair.com/ethereum/'>block explorer</a> then find last transaction and get its nonce. Shortly new nonce = last nonce + 1, otherwise if last nonce not found then new nonce start with 0.
    </div>
	
	<div class="form-group">
		<label for="gas_price">Gas Price:</label>
		
		<div class="input-group mb-3">
			<input class="form-control" type='text' name='gas_price' id='gas_price' value='<?php echo $_POST['gas_price']?>'>
			<div class="input-group-append">
			  <span class="input-group-text">GWEI</span>
			</div>
		</div>
	</div>
	
	 <div class="form-group">
        <label for="gas_limit">Gas Limit:</label>
        <input class="form-control" type='text' name='gas_limit' id='gas_limit' value='<?php echo $_POST['gas_limit']?>'>
    </div>
	
	
    <div class="form-group">
        <label for="contract_addr">To:</label>
        <input placeholder="Token's Contract Address" class="form-control" type='text' name='contract_addr' id='contract_addr' value='<?php echo $_POST['contract_addr']?>'>
    </div>
	
	<div class="form-group">
        <label for="token_amount">Send Token Amount:</label>
        <input class="form-control" type='text' name='token_amount' id='token_amount' value='<?php echo $_POST['token_amount']?>'>
    </div>
	
	
	<div class="form-group">
        <label for="token_decimals">Token Decimal Places:</label>
        <input class="form-control" type='text' name='token_decimals' id='token_decimals' value='<?php echo $_POST['token_decimals']?>'>
    </div>
	
	<div class="form-group">
        <label for="recipient">Recipient:</label>
        <input class="form-control" type='text' name='recipient' id='recipient' value='<?php echo $_POST['recipient']?>'>
    </div>
   
     <div class="form-group">
        <label for="privkey">From:</label>
        <input placeholder="Sender's Private Key (Hex)" class="form-control" type='text' name='privkey' id='privkey' value='<?php echo $_POST['privkey']?>'>
    </div>
   
    <input type='submit' class="btn btn-success btn-block"/>
</form>
<?php
include_once("html_iframe_footer.php");