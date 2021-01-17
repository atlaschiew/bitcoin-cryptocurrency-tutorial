<?php 
include_once "../common.php"; //include this just to derive $_BITCOINCLI_CONFIG[...] variable
$supportCoins = ['btc/main'=>"Bitcoin Mainnet"];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	
	try { 
	
		$postFields = [
			'jsonrpc' => '1.0',
			'id'=>'curltest',
			'method'=>'getblockchaininfo',
			'params'=> []
		];
		
		$bitcoincliRpcProtocol = "http";
		$bitcoincliRpcHost = $_BITCOINCLI_CONFIG['bitcoincli_rpc_host'];

		$bitcoincliRpcPort = "8332";
		
		$bitcoincliRpcUser = $_BITCOINCLI_CONFIG['bitcoincli_rpc_user'];
		$bitcoincliRpcPwd = $_BITCOINCLI_CONFIG['bitcoincli_rpc_pwd'];
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url = "{$bitcoincliRpcProtocol}://{$bitcoincliRpcHost}:{$bitcoincliRpcPort}");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_POST , 1);
		curl_setopt($ch, CURLOPT_USERPWD , "{$bitcoincliRpcUser}:{$bitcoincliRpcPwd}");
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $CURLOPT_POSTFIELDS = json_encode($postFields));

		$rawResult = curl_exec($ch);
		
		$displayRawResults[] = [$CURLOPT_POSTFIELDS, $rawResult];
		
		if (curl_errno($ch)) { 
			throw new Exception('CURL Error: ' . curl_error($ch). "#" . curl_errno($ch));
		} else if (!($result = json_decode($rawResult,true))) {
			throw new Exception('Invalid JSON format.');
		} else if (is_array($result['error']) AND $result['error'] !='null') {
			throw new Exception('Bitcoin CLI Error: ' . $result['error']['message'] . "#" . $result['error']['code']);
		}  else {
						
			curl_close($ch);
		}
		
	} catch (Exception $e) {
		$errmsg .= "Problem found. " . $e->getMessage();
	}
}

include_once("html_iframe_header.php");
if ($errmsg) {
?>
	<div class="alert alert-danger">
		<strong>Error!</strong> <?php echo $errmsg?>
	</div>
<?php
}

if (@count($displayRawResults) > 0) {
	$json_string = json_encode($result['result'], JSON_PRETTY_PRINT);
?>
	<div class="row">
		<div class="col-sm-6">
			<pre style='border-radius:none;'><?php echo $json_string;?></pre>
		</div>
		<div class="col-sm-6">
			<table border=0 class='table table-bordered'>		
				<tr>
					<th style='width:15%'>Params</th><th style='width:15%'>Data Type</th><th style='width:70%'>Explaination</th>
				</tr>
				<tr>
					<td>chain</td><td>String</td><td>Current network name as defined in BIP70 (main, test, regtest).</td>
				</tr>
				
				<tr>
					<td>blocks</td><td>Numeric</td><td>The current number of blocks processed in the server.</td>
				</tr>
				
				<tr>
					<td>headers</td><td>Numeric</td><td>The current number of headers we have validated.</td>
				</tr>
				
				<tr>
					<td>bestblockhash</td><td>String</td><td>The hash of the currently best block.</td>
				</tr>
				
				<tr>
					<td>difficulty</td><td>Numeric</td><td>The current difficulty.</td>
				</tr>
				
				<tr>
					<td>mediantime</td><td>Numeric</td><td>Median time for the current best block.</td>
				</tr>
				
				<tr>
					<td>verificationprogress</td><td>Numeric</td><td>estimate of verification progress [0 - 1].</td>
				</tr>
				
				<tr>
					<td>initialblockdownload</td><td>Boolean</td><td>Estimate of whether this node is in Initial Block Download mode. (debug information)</td>
				</tr>
				
				<tr>
					<td>chainwork</td><td>String</td><td>Total amount of work in active chain, in hexadecimal.</td>
				</tr>
				
				<tr>
					<td>size_on_disk</td><td>Numeric</td><td>The estimated size of the block and undo files on disk.</td>
				</tr>
				
				<tr>
					<td>pruned</td><td>Boolean</td><td>If the blocks are subject to pruning.</td>
				</tr>
				
				<tr>
					<td>pruneheight</td><td>Numeric</td><td>Lowest-height complete block stored (only present if pruning is enabled).</td>
				</tr>
				
				<tr>
					<td>automatic_pruning</td><td>Boolean</td><td>Whether automatic pruning is enabled (only present if pruning is enabled).</td>
				</tr>
				
				<tr>
					<td>prune_target_size</td><td>Numeric</td><td>The target size used by pruning (only present if automatic pruning is.</td>
				</tr>
				
				<tr>
					<td>pruneheight</td><td>Numeric</td><td>Lowest-height complete block stored (only present if pruning is enabled).</td>
				</tr>
				
				<tr>
					<td>softforks</td><td>Array</td><td>Status of softforks in progress.</td>
				</tr>
				<tr>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;id</td><td>String</td><td>Name of softfork.</td>
				</tr>
				
				<tr>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;version</td><td>Numeric</td><td>Block version.</td>
				</tr>
				
				<tr>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;reject</td><td>Object</td><td>Progress toward rejecting pre-softfork blocks.</td>
				</tr>
				
				<tr>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Status</td><td>Boolean</td><td>True if threshold reached.</td>
				</tr>
				
				<tr>
					<td>bip9_softforks</td><td>Array</td><td>Status of BIP9 softforks in progress.</td>
				</tr>
				<tr>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;$softfork_name</td><td>String (Variable)</td><td>Name of softfork.</td>
				</tr>
				
				<tr>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Status</td><td>String</td><td>One of "defined", "started", "locked_in", "active", "failed".</td>
				</tr>
				<tr>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;bit</td><td>Numeric</td><td>The bit (0-28) in the block version field used to signal this softfork (only for "started" status).</td>
				</tr>
				<tr>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;startTime</td><td>Numeric</td><td>The minimum median time past of a block at which the bit gains its meaning.</td>
				</tr>
				<tr>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;timeout</td><td>Numeric</td><td>The median time past of a block at which the deployment is considered failed if not yet locked in.</td>
				</tr>
				
				<tr>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;since</td><td>Numeric</td><td>Height of the first block to which the status applies.</td>
				</tr>
				
				<tr>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;statistics</td><td>Object</td><td>Numeric statistics about BIP9 signalling for a softfork (only for "started" status).</td>
				</tr>
				
				<tr>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;period</td><td>Numeric</td><td>The length in blocks of the BIP9 signalling period.</td>
				</tr>
				<tr>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;threshold</td><td>Numeric</td><td>The number of blocks with the version bit set required to activate the feature.</td>
				</tr>
				<tr>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;elapsed</td><td>Numeric</td><td>The number of blocks elapsed since the beginning of the current period.</td>
				</tr>
				<tr>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;count</td><td>Numeric</td><td>The number of blocks with the version bit set in the current period.</td>
				</tr>
				<tr>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;possible</td><td>Boolean</td><td>Returns false if there are not enough blocks left in this period to pass activation threshold.</td>
				</tr>
				
				<tr>
					<td>warnings</td><td>String</td><td>Any network and blockchain warnings.</td>
				</tr>
			</table>
		</div>		
	</div>
	
	<div class="table-responsive">
		<table border=0 class='table'>		
			<tr>
				<th style='width:30%;'>Params</th>
				<th style='width:70%;'>Raw Result</th>
			</tr>
			<?php 
			foreach($displayRawResults as $thisResult) {
			?>
			<tr>
				<td style='width:30%;'><?php echo htmlentities($thisResult[0])?></td>
				<td style='width:70%;'>
					<textarea class="form-control" readonly rows=4><?php echo htmlentities($thisResult[1]);?></textarea>
				</td>
			</tr>
			<?php
			}
			?>
		</table>
	</div>
<?php
}
?>
<form id='this_form' action='' method='post'>
	<div class="form-group">
		<label for="network">Network:</label>
		<select id="network" name="network" class="form-control" >
			<?php
			foreach($supportCoins as $k=>$v) {
				echo "<option value='{$k}'".($k == $_POST['network'] ? " selected": "").">{$v}</option>";
			}
			?>
		</select>
	</div>
	
	<input type='submit' class="btn btn-success btn-block"/>
</form>
<?php 
include_once("html_iframe_footer.php");