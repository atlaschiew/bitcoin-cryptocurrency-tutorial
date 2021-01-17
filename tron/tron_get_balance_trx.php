<?php 

include_once "../libraries/vendor/autoload.php";
include_once("html_iframe_header.php");
include_once("tron_utils.php");

$supportChains = ['main'=>"Tron Mainnet", 'shasta'=>"Shasta Testnet"];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
		
		if ($_POST['chain'] == 'main') {
            $fullNode = new \IEXBase\TronAPI\Provider\HttpProvider('https://api.trongrid.io');
            $solidityNode = new \IEXBase\TronAPI\Provider\HttpProvider('https://api.trongrid.io');
            $eventServer = new \IEXBase\TronAPI\Provider\HttpProvider('https://api.trongrid.io');
        } else {
            $fullNode = new \IEXBase\TronAPI\Provider\HttpProvider('https://api.shasta.trongrid.io');
            $solidityNode = new \IEXBase\TronAPI\Provider\HttpProvider('https://api.shasta.trongrid.io');
            $eventServer = new \IEXBase\TronAPI\Provider\HttpProvider('https://api.shasta.trongrid.io');
        }
		
		$tron = new \IEXBase\TronAPI\Tron($fullNode, $solidityNode, $eventServer);
		
		$balance = $tron->getBalance($_POST['address']/**/, true /*convert from SUN to TRX*/);
		
    ?>
	<div class="alert alert-success">
		<p>
			TRX balance is <b><?php echo $balance?> TRX</b>.
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
<form action='' method='post'>
	
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
        <label for="address">Address:</label>
        <input class="form-control" type='text' name='address' id='address' value='<?php echo $_POST['address']?>'>
    </div>
	
    <input type='submit' class="btn btn-success btn-block"/>
</form>
<?php
include_once("html_iframe_footer.php");