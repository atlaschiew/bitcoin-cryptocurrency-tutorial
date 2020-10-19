<?php 

include_once "../libraries/vendor/autoload.php";
$support_chains = ['1'=>"Ethereum Mainnet", '3'=>"Ethereum Testnet Ropsten"];

define("GWEI_TO_WEI",'1000000000');
define("ETH_TO_WEI",'1000000000000000000');

include_once("html_iframe_header.php");
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	try {
		
		if (!preg_match('/^https\:\/\/([a-z]+)\.infura\.io/', $_POST['url'])) {
			throw new Exception("Please provide valid INFURA full URL with project ID.");
		}
		
		$gasPrice = "0x".dechex(bcmul($_POST['gas_price'],GWEI_TO_WEI, 18));
		$gasLimit = "0x".dechex($_POST['gas_limit']);
		$to = $_POST['to'];
		$from = $_POST['from'];
		$data = $_POST['data'];
		$value = "0x".dechex(bcmul($_POST['value'],ETH_TO_WEI, 18));
		
		$ch = curl_init();
		
		$req = <<<EOF
{"jsonrpc":"2.0","method":"eth_estimateGas","params": [{"from": "{$from}","to": "{$to}","gas": "{$gasLimit}","gasPrice": "{$gasPrice}","value": "{$value}","data": "{$data}"}],"id":{$_POST['chain']}}
EOF;
		curl_setopt($ch, CURLOPT_URL,$_POST['url']);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$req);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);

		$resp = curl_exec($ch);
		
		if ($resp === false) {
			throw new Exception("curl_exec return false");
		}
		
		if (strlen($err = @curl_error($ch)) > 0) {
			$errno = @curl_errno($ch);
			throw new Exception( "{$err} ({$errno})" );
		}
		
		curl_close ($ch);
		
		?>
		<div class="alert alert-success">
		
			<h6 class="mt-3">Requset</h6>
			<textarea class="form-control" rows="5" id="comment" readonly><?php echo $req;?></textarea>
			<h6 class="mt-3">Response</h6>
			<textarea class="form-control" rows="1" id="comment" readonly><?php echo $resp;?></textarea>
			Gas limit = <?php $resp_json = json_decode($resp,true); echo hexdec($resp_json['result']);?>
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
<form id='this_form' action='?action=submit' method='post'>

	<div class="form-group">
		<label for="chain">Chain:</label>
		<select id="chain" name="chain" class="form-control" >
			<?php
			foreach($support_chains as $k=>$v) {
				
				echo "<option value='{$k}'".($k == $_POST['chain'] ? " selected": "").">{$v}</option>";
			}
			?>
		</select>
	</div>
	
	 <div class="form-group">
        <label for="url">INFURA full URL (with project ID):</label>
        <input class="form-control" type='text' name='url' id='url' value='<?php echo $_POST['url']?>'>
		e.g https://mainnet.infura.io/v3/11223344556677889900aabbccdd
    </div>
	
	<div class="form-group">
        <label for="from">From Address:</label>
        <input class="form-control" type='text' name='from' id='from' value='<?php echo $_POST['from']?>'>
    </div>
	
    <div class="form-group">
        <label for="to">To Address:</label>
        <input class="form-control" type='text' name='to' id='to' value='<?php echo $_POST['to']?>'>
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
        <label for="data">Data (Hex):</label>
        <input class="form-control" type='text' name='data' id='data' value='<?php echo $_POST['data']?>'>
    </div>
	
	 <div class="form-group">
		<label for="value">ETH Value:</label>
		
		<div class="input-group mb-3">
			<input class="form-control" type='text' name='value' id='value' value='<?php echo $_POST['value']?>'>
			<div class="input-group-append">
			  <span class="input-group-text">ETH</span>
			</div>
		</div>
	</div>
	
		
    <input type='submit' class="btn btn-success btn-block"/>
</form>
<?php
include_once("html_iframe_footer.php");