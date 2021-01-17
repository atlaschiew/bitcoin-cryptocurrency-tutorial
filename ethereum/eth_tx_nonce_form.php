<?php 

include_once "../libraries/vendor/autoload.php";
$supportChains = ['1'=>"Ethereum Mainnet", '3'=>"Ethereum Testnet Ropsten"];

include_once("html_iframe_header.php");
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	try {
		
		if (!preg_match('/^https\:\/\/([a-z]+)\.infura\.io/', $_POST['url'])) {
			throw new Exception("Please provide valid INFURA full URL with project ID.");
		}
		
		$ch = curl_init();
		
		$params = [];
		$params['jsonrpc']= "2.0";
		$params['method'] = 'eth_getTransactionCount';
		
		//set block parameter = pending to make query include pending transactions
		$params['params'] = [$_POST['address'],'pending'];
		$params['id'] = $_POST['chain'];
		
		curl_setopt($ch, CURLOPT_URL,$_POST['url']);
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
		$result = $result['result'];
		
		curl_close ($ch);
		
		?>
		<div class="alert alert-success">
			<h6 class="mt-3">Request</h6>
			<textarea class="form-control" rows="5" id="comment" readonly><?php echo $req;?></textarea>
			<h6 class="mt-3">Response</h6>
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
        <label for="url">INFURA full URL (with project ID):</label>
        <input class="form-control" type='text' name='url' id='url' value='<?php echo $_POST['url']?>'>
		<small>e.g https://mainnet.infura.io/v3/11223344556677889900aabbccdd</small>
    </div>
	
	<div class="form-group">
        <label for="address">Address:</label>
        <input class="form-control" type='text' name='address' id='address' value='<?php echo $_POST['address']?>'>
    </div>
		
    <input type='submit' class="btn btn-success btn-block"/>
</form>
<?php
include_once("html_iframe_footer.php");