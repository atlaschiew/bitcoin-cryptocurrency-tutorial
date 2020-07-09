<?php 
include_once "../common.php"; //include this just to derive $_BITCOINCLI_CONFIG[...] variable
$support_coins = ['btc/main'=>"Bitcoin Mainnet"];

$load_blocks = 10;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	
	try { 
	
		if (!in_array($_POST['way'], ['after','before'])) {
			throw new Exception("Please select one of 'Block Generation Way'.");
		}
		
		$display_raw_results = $blocks = [];
		if (!ctype_digit($_POST['height'])) {
			$post_fields = [
				'jsonrpc' => '1.0',
				'id'=>'curltest',
				'method'=>'getbestblockhash',
				'params'=> []
			];
		} else {
			$post_fields = [
				'jsonrpc' => '1.0',
				'id'=>'curltest',
				'method'=>'getblockhash',
				'params'=> [(int)$_POST['height']]
			];
		}
		
		$bitcoincli_rpc_protocol = "http";
		$bitcoincli_rpc_host = $_BITCOINCLI_CONFIG['bitcoincli_rpc_host'];

		$bitcoincli_rpc_port = "8332";
		
		$bitcoincli_rpc_user = $_BITCOINCLI_CONFIG['bitcoincli_rpc_user'];
		$bitcoincli_rpc_pwd = $_BITCOINCLI_CONFIG['bitcoincli_rpc_pwd'];
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url = "{$bitcoincli_rpc_protocol}://{$bitcoincli_rpc_host}:{$bitcoincli_rpc_port}");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_POST , 1);
		curl_setopt($ch, CURLOPT_USERPWD , "{$bitcoincli_rpc_user}:{$bitcoincli_rpc_pwd}");
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $CURLOPT_POSTFIELDS = json_encode($post_fields));

		$raw_result = curl_exec($ch);
		
		$display_raw_results[] = [$CURLOPT_POSTFIELDS, $raw_result];
		
		if (curl_errno($ch)) { 
			throw new Exception('CURL Error: ' . curl_error($ch). "#" . curl_errno($ch));
		} else if (!($result = json_decode($raw_result,true))) {
			throw new Exception('Invalid JSON format.');
		} else if (is_array($result['error']) AND $result['error'] !='null') {
			throw new Exception('Bitcoin CLI Error: ' . $result['error']['message'] . "#" . $result['error']['code']);
		}  else {
			$info = curl_getinfo($ch);
			
			curl_close($ch);
			
			$block_hash = $result['result'];
			
			/*
			verbosity = 0, returns a string that is serialized, hex-encoded data for block 'hash'.
			verbosity = 1, returns an Object with information about block .
			verbosity = 2, returns an Object with information about block  and information about each transaction. 
			*/
			$verbosity = 1;
			while($load_blocks > 0 AND $block_hash) {
				
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $url = "{$bitcoincli_rpc_protocol}://{$bitcoincli_rpc_host}:{$bitcoincli_rpc_port}");
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
				curl_setopt($ch, CURLOPT_POST , 1);
				curl_setopt($ch, CURLOPT_USERPWD , "{$bitcoincli_rpc_user}:{$bitcoincli_rpc_pwd}");
				curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $CURLOPT_POSTFIELDS = json_encode(['jsonrpc' => '1.0','id'=>'curltest','method'=>'getblock','params'=> [$block_hash,$verbosity ]]));
				
				$raw_result = curl_exec($ch);
				if (curl_errno($ch)) { 
					throw new Exception('CURL Error: ' . curl_error($ch). "#" . curl_errno($ch));
				} else if (!($result = json_decode($raw_result,true))) {
					throw new Exception('Invalid JSON format.');
				} else if (is_array($result['error']) AND $result['error'] !='null') {
					throw new Exception('Bitcoin CLI Error: ' . $result['error']['message'] . "#" . $result['error']['code']);
				} else {
					
					$display_raw_results[] = [$CURLOPT_POSTFIELDS, $raw_result];
				
					$block = $result['result'];
					$blocks[] = $block;
					if ($_POST['way'] == 'before') {
						$block_hash = $block['previousblockhash'];
					} else {
						$block_hash = $block['nextblockhash'];
						
					}
					
					$load_blocks--;
				}
			}
			
			krsort($blocks);
			$blocks = array_values($blocks);
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

if ($total_blocks = @count($display_raw_results) > 0) {
	
	echo "<center>";
	?>
		<p><a href='#this_form' onclick="
		var self = $(this);
		$('#height', $('#this_form')).val('<?php echo ($blocks[0]['height']) + 1?>');
		$('input[name=way][value=after]').prop('checked',true);
		$('#height', $('#this_form')).focus();
		">Load More ...</a></p>
		<img src='../media/images/link.png'/>
	<?php
	echo "<div id='blockchain'>";
	
	
	foreach($blocks as $k=>$block) {
		$txs = $block['tx'];
		unset($block['tx']);
?>
		<div class='card' style='margin-top:10px;width:300px;'>
			<div class='card-header'>
				<?php echo $block['hash']?>
				<table border=0 class='table-borderless'>	
					<tr>
						<td>Height</td>
						<td><?php echo $block['height']?></td>
					</tr>
				</table>
			</div>
			<div class='card-body'>
				<div class='table-responsive'>
					<h6>Header:</h6>
					<table border=0 class='table-borderless'>	
						<tr>
							<td>Version</td>
							<td><?php echo $block['version']?></td>
						</tr>
						
						<tr>
							<td>HashPrevBlock</td>
							<td><?php echo $block['previousblockhash']?></td>
						</tr>
						
						<tr>
							<td>MerkleRoot</td>
							<td><?php echo $block['merkleroot']?></td>
						</tr>
						
						<tr>
							<td>Time</td>
							<td><?php echo $block['time']?></td>
						</tr>
						
						<tr>
							<td>Bits</td>
							<td><?php echo $block['bits']?></td>
						</tr>
						
						<tr>
							<td>Nonce</td>
							<td><?php echo $block['nonce']?></td>
						</tr>
					</table>
				</div>
			</div> 
			
			<div class='card-footer'>
				<h6>Body:</h6>
				Total <a href='blockchain_start_block.php?block_hash=<?php echo $block['hash']?>'><?php echo $block['nTx']?></a> Transaction(s)
			</div>
		</div>
		<img src='../media/images/link.png'/>
<?php
	}
?>
	</div>
	<p><a href='#this_form' onclick="
		var self = $(this);
		$('#height', $('#this_form')).val('<?php echo ($blocks[count($blocks)-1]['height']) - 1?>');
		$('input[name=way][value=before]').prop('checked',true);
		$('#height', $('#this_form')).focus();
		$('input[type=submit]', $('#this_form')).val('Submit To Load More');
		
		">Load More ...</a></p>
	</center>
	<div class="table-responsive">
		<table border=0 class='table'>		
			<tr>
				<th style='width:30%;'>Params</th>
				<th style='width:70%;'>Raw Result</th>
			</tr>
			<?php 
			foreach($display_raw_results as $this_result) {
			?>
			<tr>
				<td style='width:30%;'><?php echo htmlentities($this_result[0])?></td>
				<td style='width:70%;'>
					<textarea class="form-control" readonly rows=4><?php echo htmlentities($this_result[1]);?></textarea>
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
			foreach($support_coins as $k=>$v) {
				echo "<option value='{$k}'".($k == $_POST['network'] ? " selected": "").">{$v}</option>";
			}
			?>
		</select>
	</div>
	<div class="form-group">
		<label for="height">Block Height:</label>
		<input class="form-control" type='text' name='height' id='height' value='<?php echo $_POST['height']?>'>
		
		 * Put empty if you want latest block height.
	</div>
	
	<div class="form-group">
		<label for="height">Block Generation Way:</label>
		<div class="form-check-inline">
			<label class="form-check-label">
			<input type="radio" class="form-check-input" name="way" value="after"<?php echo $_POST['way']=='after' ? ' checked': ''?>>After Block Height
			</label>
		</div>
		<div class="form-check-inline">
			<label class="form-check-label">
				<input type="radio" class="form-check-input" name="way" value="before"<?php echo $_POST['way']=='before' ? ' checked': ''?>>Before Block Height
			</label>
		</div>
	</div>

	<input type='submit' class="btn btn-success btn-block"/>
</form>
<?php 
include_once("html_iframe_footer.php");