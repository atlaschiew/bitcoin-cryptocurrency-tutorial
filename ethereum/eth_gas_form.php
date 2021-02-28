<?php 

include_once "../libraries/vendor/autoload.php";
include_once("eth_utils.php");

define("GWEI_TO_WEI",'1000000000');
define("ETH_TO_WEI",'1000000000000000000');

$hosts = ["https://mainnet.infura.io"=>"https://mainnet.infura.io","https://ropsten.infura.io"=>"https://ropsten.infura.io", "https://cloudflare-eth.com"=>"https://cloudflare-eth.com"];


include_once("html_iframe_header.php");
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	try {
		
		if (!in_array($_POST['host'], array_keys($hosts))) {
			throw new Exception("Please provide valid host.");
		}
		
		$url = $_POST['host'] . "/" . $_POST['path'];
		
		$gasPrice = "0x".bcdechex(bcmul($_POST['gas_price'],GWEI_TO_WEI, 18));
		$gasLimit = "0x".bcdechex($_POST['gas_limit']);
		$to = $_POST['to'];
		$from = $_POST['from'];
		$data = $_POST['data'];
		$value = "0x".bcdechex(bcmul($_POST['value'],ETH_TO_WEI, 18));
		
		$ch = curl_init();
		$requestId = time();
		
		$params = [];
		$params['jsonrpc']= "2.0";
		$params['method'] = 'eth_estimateGas';
		$params['params'] = [["from"=>$from, "to"=>$to, "gas"=>$gasLimit, "gasPrice"=>$gasPrice,"value"=>$value, "data"=>$data]];
		$params['id'] = $requestId;
		
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$req = json_encode($params));
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
		
		$result = json_decode($resp,true); 
		if ($result['id'] != $requestId) {
			throw new Exception("Invalid request id.");
		}
		$result = $result['result'];
		
		curl_close ($ch);
		
		?>
		<div class="alert alert-success">
			<h6 class="mt-3">Host</h6>
			<textarea class="form-control" rows="1" readonly><?php echo $url;?></textarea>
			
			<h6 class="mt-3">JSON-RPC Request</h6>
			<textarea class="form-control" rows="5" readonly><?php echo $req;?></textarea>
			
			<h6 class="mt-3">JSON-RPC Response</h6>
			<textarea class="form-control" rows="1" readonly><?php echo $resp;?></textarea>
			
			<small>
				NOTE: Even if a transaction fails due to non-gas issues, it consider a failure as insufficient gas. Then it will return 0 with an error message in the end.
			</small>
			
			<h6 class="mt-3">Result</h6>
			Gas limit is <?php echo hexdec($result);?>.
			
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
		<label for="host">Host To Receive RPC:</label>
		
		<div class="input-group mb-3">
			<select id="host" name="host" class="form-control" >
			<?php
			foreach($hosts as $k=>$v) {
				echo "<option value='{$k}'".($k == $_POST['host'] ? " selected": "").">{$v}</option>";
			}
			?>
			</select>
			<div class="input-group-append">
				<span class="input-group-text">
					/
				</span>
			</div>
			
			<input class="form-control" type='text' name='path' id='path' value='<?php echo $_POST['path']?>' placeholder="Put extra path or blank if it does not.">
			
		</div>
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
        <input class="form-control" type='text' name='gas_limit' id='gas_limit' value='<?php echo $_POST['gas_limit'] ?? "60000"?>'>
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