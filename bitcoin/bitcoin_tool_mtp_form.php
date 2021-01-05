<?php 

session_start();

include_once "../common.php";
$support_coins = ['btc/main'=>"Bitcoin Mainnet", 'btc/test3'=>"Bitcoin Testnet3", 'dash/main'=>"Dash Mainnet", 'doge/main'=>"Dogecoin Mainnet", 'ltc/main'=>"Litecoin Mainnet",'bcy/test'=>"Blockcypher Testnet"];
$has_result = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	
	try { 
		
		if(md5($_POST['captcha']) != $_SESSION['CAPTCHA_FORM1']){
			throw new Exception("CAPTCHA verification failed.");
		} else if (!isset($support_coins[$_POST['network']])) {
			throw new Exception('Network not found.');
		} else {
			$network_name = $_POST['network'];
		}
		
		$update_fields = $dt = [];
		
		if (strlen($_POST['height']) > 0) {
			if (!is_numeric($_POST['height'])) {
				throw new Exception('Invalid height value.');
			}
			
			$to_height = (int)$_POST['height'];;
			$from_height = $to_height - 11;
			
		} else {
			$url = "https://api.blockcypher.com/v1/{$network_name}";
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

			$chain = curl_exec($ch);
			$chain = json_decode($chain,true);		
			
			curl_close($ch);
			
			$update_fields['network_height'] = $chain['height'];
			$update_fields['network_data'] = json_encode($chain);
			$update_fields['network_last_update'] = date("Y-m-d H:i:s");
			
			$from_height = ($chain['height'] + 1) - 11;		
			$to_height = $chain['height'];
		}
		
		foreach(range($from_height,$to_height) as $new_height) {
			
			if (!mysqli_num_rows($r= DB::query("SELECT * FROM block WHERE block_height='".DB::esc($new_height)."' AND network_name='".DB::esc($network_name)."' LIMIT 1"))) {
			
				$url = "https://api.blockcypher.com/v1/{$network_name}/blocks/{$new_height}?txstart=1&limit=1";
				
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

				$block = curl_exec($ch);
				$block = json_decode($block,true);
				
				curl_close($ch);
			
				$block_time =  date("Y-m-d H:i:s", strtotime($block['time']));
				
				DB::query("INSERT INTO block SET network_name='".DB::esc($network_name)."', block_height='".DB::esc($block['height'])."', block_time='".DB::esc($block_time)."', block_data='".DB::esc(json_encode($block))."'");
			
			} else {
				$r_block = mysqli_fetch_assoc($r);
				$block_time = $r_block['block_time'];
			}
	
			$dt[] = $block_time;
		}
		sort($dt);
		$mtp = $dt[$median = 5];
		
		if (@count($update_fields) > 0) {
			$update_fields['network_mtp'] = $mtp;
			$update_q = "";
			foreach($update_fields as $update_field=>$update_value) {
				$update_q .= "`{$update_field}` = '".DB::esc($update_value)."', ";
			}
			$update_q = rtrim($update_q, ", ");
			DB::query("UPDATE network_status SET {$update_q} WHERE network_name='".DB::esc($network_name)."'");
		}
		
		$has_result = true;
		
		if ($_POST['ajax'] == '1') {
			die(json_encode(['mtp'=>$mtp. " (UTC 0)", 'height'=>$to_height ]));
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

if ($has_result) {
?>
	<div class="table-responsive">
		<table border=0 class='table'>
			<tr><td>Median Time Past</td><td><?php echo $mtp. " (UTC 0)";?></td></tr>
			<tr><td>Block Height</td><td><?php echo $to_height;?></td></tr>
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
			foreach($support_coins as $k=>$v) {
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