<?php 

session_start();

include_once "../common.php";
$supportCoins = ['btc/main'=>"Bitcoin Mainnet", 'btc/test3'=>"Bitcoin Testnet3", 'dash/main'=>"Dash Mainnet", 'doge/main'=>"Dogecoin Mainnet", 'ltc/main'=>"Litecoin Mainnet",'bcy/test'=>"Blockcypher Testnet"];
$hasResult = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	
	try { 
		
		if(md5($_POST['captcha']) != $_SESSION['CAPTCHA_FORM1']){
			throw new Exception("CAPTCHA verification failed.");
		} else if (!isset($supportCoins[$_POST['network']])) {
			throw new Exception('Network not found.');
		} else {
			$networkName = $_POST['network'];
		}
		
		$updateFields = $dt = [];
		
		if (strlen($_POST['height']) > 0) {
			if (!is_numeric($_POST['height'])) {
				throw new Exception('Invalid height value.');
			}
			
			$toHeight = (int)$_POST['height'];;
			$fromHeight = $toHeight - 11;
			
		} else {
			$url = "https://api.blockcypher.com/v1/{$networkName}";
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

			$chain = curl_exec($ch);
			$chain = json_decode($chain,true);		
			
			if ($chain['error']) {
				throw new Exception("URL: {$url}, Error: {$chain['error']}.");
			}
			curl_close($ch);
			
			$updateFields['network_height'] = $chain['height'];
			$updateFields['network_data'] = json_encode($chain);
			$updateFields['network_last_update'] = date("Y-m-d H:i:s");
			
			$fromHeight = ($chain['height'] + 1) - 11;		
			$toHeight = $chain['height'];
		}
		
		foreach(range($fromHeight,$toHeight) as $newHeight) {
			
			if (!mysqli_num_rows($r= DB::query("SELECT * FROM block WHERE block_height='".DB::esc($newHeight)."' AND network_name='".DB::esc($networkName)."' LIMIT 1"))) {
			
				$url = "https://api.blockcypher.com/v1/{$networkName}/blocks/{$newHeight}?txstart=1&limit=1";
				
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

				$block = curl_exec($ch);
				$block = json_decode($block,true);
				
				if ($block['error']) {
					throw new Exception("URL: {$url}, Error: {$block['error']}.");
				}
				
				curl_close($ch);
			
				$blockTime =  date("Y-m-d H:i:s", strtotime($block['time']));
				
				DB::query("INSERT INTO block SET network_name='".DB::esc($networkName)."', block_height='".DB::esc($block['height'])."', block_time='".DB::esc($blockTime)."', block_data='".DB::esc(json_encode($block))."'");
			
			} else {
				$rBlock = mysqli_fetch_assoc($r);
				$blockTime = $rBlock['block_time'];
			}
	
			$dt[] = $blockTime;
		}
		sort($dt);
		$mtp = $dt[$median = 5];
		
		if (@count($updateFields) > 0) {
			$updateFields['network_mtp'] = $mtp;
			$updateQuery = "";
			foreach($updateFields as $updateField=>$updateValue) {
				$updateQuery .= "`{$updateField}` = '".DB::esc($updateValue)."', ";
			}
			$updateQuery = rtrim($updateQuery, ", ");
			DB::query("UPDATE network_status SET {$updateQuery} WHERE network_name='".DB::esc($networkName)."'");
		}
		
		$hasResult = true;
		
		if ($_POST['ajax'] == '1') {
			die(json_encode(['mtp'=>$mtp. " (UTC 0)", 'height'=>$toHeight ]));
		}
		
	} catch (Exception $e) {
		$errmsg .= "Problem found. " . $e->getMessage();

	}
}

include_once("html_iframe_header.php");
if ($errmsg) {
?>
	<div class="alert alert-danger">
		<strong>Error!</strong><br/><?php echo $errmsg?>
	</div>
<?php
}

if ($hasResult) {
?>
	<div class="table-responsive">
		<table border=0 class='table'>
			<tr><td>Median Time Past</td><td><?php echo $mtp. " (UTC 0)";?></td></tr>
			<tr><td>Block Height</td><td><?php echo $toHeight;?></td></tr>
		</table>
	</div>
<?php
}
?>
<form action='' method='post'>
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
	<div class="form-group">
		<label for="height">Block Height:</label>
		<input class="form-control" type='text' name='height' id='height' value='<?php echo $_POST['height']?>'>
		Put blank if you want system to calculate current chain's MTP.
	</div>

	<div class="form-group">
		<label for="captcha">CAPTCHA:</label>
		<img style='border:1px solid black' src='../verificationimage.php?key=CAPTCHA_FORM1'/>
		<input name="captcha" type="captcha" class="form-control" placeholder="CAPTCHA" id="captcha" value="">
	</div>
	
	<input type='submit' class="btn btn-success btn-block"/>
</form>
<?php 
include_once("html_iframe_footer.php");