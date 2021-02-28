<?php 

include_once "../libraries/vendor/autoload.php";

$hosts = ["https://mainnet.infura.io"=>"https://mainnet.infura.io","https://ropsten.infura.io"=>"https://ropsten.infura.io", "https://cloudflare-eth.com"=>"https://cloudflare-eth.com"];
$blockParams = ['pending'=>'Pending','latest'=>'Latest', 'earliest'=>'Earliest'];

include_once("html_iframe_header.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	try {
		
		if (!in_array($_POST['host'], array_keys($hosts))) {
			throw new Exception("Please provide valid host.");
		}
		
		$url = $_POST['host'] . "/" . $_POST['path'];
		
		$ch = curl_init();
		$requestId = time();
		
		$params = [];
		$params['jsonrpc']= "2.0";
		$params['method'] = 'eth_getTransactionCount';
		
		//set block parameter = pending to make query include pending transactions
		$params['params'] = [$_POST['address'],$_POST['blockparam']];
		$params['id'] = $requestId;
		
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$req = json_encode($params));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);

		$resp = curl_exec($ch);
		
		if ($resp === false) {
			throw new Exception("curl_exec return false.");
		}
		
		if (strlen($err = @curl_error($ch)) > 0) {
			$errno = @curl_errno($ch);
			throw new Exception( "{$err} ({$errno})." );
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
			<textarea class="form-control" rows="5" id="comment" readonly><?php echo $req;?></textarea>
			
			<h6 class="mt-3">JSON-RPC Response</h6>
			<textarea class="form-control" rows="1" id="comment" readonly><?php echo $resp;?></textarea>
			
			<?Php
			if ($result) {
			?>
			<h6 class="mt-3">Result</h6>
			Nonce is <?php echo hexdec($result)?> in decimal.
			<?php
			}
			?>
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
		<label for="blockparam">Block Parameter:</label>
		<select id="blockparam" name="blockparam" class="form-control" >
			<?php
			foreach($blockParams as $k=>$v) {
				echo "<option value='{$k}'".($k == $_POST['blockparam'] ? " selected": "").">{$v}</option>";
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