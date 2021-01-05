<?php 
include_once "../libraries/vendor/autoload.php";
$supportChains = ['1'=>"Ethereum Mainnet", '3'=>"Ethereum Testnet Ropsten"];

include_once("html_iframe_header.php");
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	try {
		
		$params = ["to" => $_POST['to'],"data" => $_POST['data']];
		$params = json_encode($params);
		
	?>
	   <div class="alert alert-success">
			<h6 class="mt-3">Final Params</h6>
			<textarea class="form-control" rows="5" id="comment" readonly><?php echo $params;?></textarea>
			<p>
				<b>JSON-RPC</b>
				<br/>
				curl localhost:8545 -X POST --data '{"jsonrpc":"2.0", "method":"eth_call", "params":[<?php echo $params;?>], "id":1}'
		
			</p>
			<p>
				<b>INFURA.io</b>
				<br/>
				
				curl https://<?php echo ($_POST['chain'] == "1") ? "mainnet" : "ropsten" ?>.infura.io/v3/YOUR-PROJECT-ID \
				-X POST \
				-H "Content-Type: application/json" \
				-d '{"jsonrpc":"2.0","method":"eth_call","params": [<?php echo $params;?>, "latest"],"id":1}'
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
        <label for="to">Contract Address:</label>
        <input class="form-control" type='text' name='to' id='to' value='<?php echo $_POST['to']?>'>
    </div>
	
	<div class="form-group">
        <label for="data">Data (Hex):</label>
        <input class="form-control" type='text' name='data' id='data' value='<?php echo $_POST['data']?>'>
    </div>
	
		
    <input type='submit' class="btn btn-success btn-block"/>
</form>
<?php
include_once("html_iframe_footer.php");