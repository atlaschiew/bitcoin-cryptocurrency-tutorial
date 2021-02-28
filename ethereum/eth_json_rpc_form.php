<?php 

include_once "../libraries/vendor/autoload.php";

$hosts = ["https://mainnet.infura.io"=>"https://mainnet.infura.io","https://ropsten.infura.io"=>"https://ropsten.infura.io", "https://cloudflare-eth.com"=>"https://cloudflare-eth.com"];

include_once("html_iframe_header.php");

$apis = ['web3_clientVersion','web3_sha3','net_version','net_peerCount','net_listening','eth_protocolVersion','eth_syncing','eth_coinbase','eth_mining','eth_hashrate','eth_gasPrice','eth_accounts','eth_blockNumber','eth_chainId','eth_getBalance','eth_getStorageAt','eth_getTransactionCount','eth_getBlockTransactionCountByHash','eth_getBlockTransactionCountByNumber','eth_getUncleCountByBlockHash','eth_getUncleCountByBlockNumber','eth_getCode','eth_sign','eth_sendTransaction','eth_sendRawTransaction','eth_call','eth_estimateGas','eth_getBlockByHash','eth_getBlockByNumber','eth_getTransactionByHash','eth_getTransactionByBlockHashAndIndex','eth_getTransactionByBlockNumberAndIndex','eth_getTransactionReceipt','eth_pendingTransactions','eth_getUncleByBlockHashAndIndex','eth_getUncleByBlockNumberAndIndex','eth_getCompilers','eth_compileLLL','eth_compileSolidity','eth_compileSerpent','eth_newFilter','eth_newBlockFilter','eth_newPendingTransactionFilter','eth_uninstallFilter','eth_getFilterChanges','eth_getFilterLogs','eth_getLogs','eth_getWork','eth_submitWork','eth_submitHashrate','eth_getProof'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	try {
		
		if (!in_array($_POST['host'], array_keys($hosts))) {
			throw new Exception("Please provide valid host.");
		}
		
		$url = $_POST['host'] . "/" . $_POST['path'];
		
		$ch = curl_init();
		$requestId = time();
		$paramsParams = json_decode($_POST['params'], true);
		
		$params = [];
		$params['jsonrpc']= $_POST['jsonver'];
		$params['method'] = $_POST['method'];
		
		$params['params'] = $paramsParams;
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
		
		curl_close ($ch);
		
		?>
		<div class="alert alert-success">
			<h6 class="mt-3">Host</h6>
			<textarea class="form-control" rows="1" readonly><?php echo $url;?></textarea>
			
			<h6 class="mt-3">JSON-RPC Request</h6>
			<textarea class="form-control" rows="5" id="comment" readonly><?php echo $req;?></textarea>
			
			<h6 class="mt-3">JSON-RPC Response</h6>
			<textarea class="form-control" rows="5" id="comment" readonly><?php echo $resp;?></textarea>
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
        <label for="jsonver">Json RPC version:</label>
        <input class="form-control" type='text' name='jsonver' id='jsonver' value='<?php echo $_POST['jsonver']?$_POST['jsonver']: "2.0"?>'>
    </div>

	<div class="form-group">
	<label for="jsonver">Method:</label>
		<div class="input-group">
			<input class="form-control" type='text' name='method' id='method' value='<?php echo $_POST['method']?>'>
			<div class="input-group-append">
				<button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Select</button>
				<ul class="dropdown-menu w-100 shadow p-0" id="navbarDropdownMega">
					<li class="dropdown-item">
						<?php 
						$itemsPerRow = 4;
						foreach($apis as $k=> $api) {
							if ($k%$itemsPerRow == 0) {
							?>
							<div class="row">
							<?php
							}
							?>
								<div class="col-sm-3">
									<?php 
									if ($api) {
									?>
									<a href="#" onclick="$('input#method').val(this.innerHTML);return false;"><?php echo $api?></a>
									<?php
									}
									?>
								</div>
							<?php
							if (($k+1)%$itemsPerRow == 0) {
							?>
							</div>
							<?Php
							}
						}
						?>
					</li>
				</ul>
			</div>
		</div>
    </div>
	
	<div class="form-group">
        <label for="params">Params:</label>
		<textarea class="form-control" rows="10" name='params' id='params'><?php echo $_POST['params']?></textarea>
		<ol>
			<li>
				<small>
				Must be JSON encoded string or you can generate it from <a href="https://www.functions-online.com/json_encode.html" target="_blank">here</a> or <a href="http://php.fnlist.com/php/json_encode" target="_blank">here</a>.
				</small>
			</li>
			
			<li>
				<small>
				<a href="https://eth.wiki/json-rpc/api" target="_blank">Refer to</a> <span class='grey_info'>Parameters</span> part under your selected method about required value and string pattern.
				</small>
			</li>
			
			<li>
				<small>
				String pattern.
				<div class="table-responsive">
					<table class="table table-bordered">
						<tr><th>Params</th><th>Description</th></tr>
						
						<tr>
							<td>[]</td>
							<td>Empty params object.</td>
						</tr>
						
						<tr>
							<td>["0x5cf1bdA8757b9c501190B0FcbC6B4ab8a4Bd04a5"]</td>
							<td>Params object with 1 address item.</td>
						</tr>
						
						<tr>
							<td>["0x5cf1bdA8757b9c501190B0FcbC6B4ab8a4Bd04a5","latest"]</td>
							<td>Params object with 2 items.</td>
						</tr>
						
						<tr>
							<td>[{"from":"0x5cf1bdA8757b9c501190B0FcbC6B4ab8a4Bd04a5","to":"0xd46e8dd67c5d32be8058bb8eb970870f07244567"}]</td>
							<td>Params object with 1 object item.</td>
						</tr>
					</table>
					</small>
				</div>
			</li>
		</ol>
    </div>
	
	
		
    <input type='submit' class="btn btn-success btn-block"/>
</form>
<?php
include_once("html_iframe_footer.php");