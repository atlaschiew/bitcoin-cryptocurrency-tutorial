<?php 
use kornrunner\Keccak;

/* due to version conflict with the one in vendor/, so i manually clone this package to new folder and include without autoload*/
include_once("../libraries/web3p/rlp/Types/Str.php");
include_once("../libraries/web3p/rlp/Types/Numeric.php");
include_once("../libraries/web3p/rlp/RLP.php");

include_once("html_iframe_header.php");

use Web3p\RLP\RLP;

$result = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	try {
		$rlp = new RLP;
		$rlpedStr = ltrim($_POST['rlped_string'], "0x");
		$result = $rlp->decode("0x" . $rlpedStr);
		
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

if ($result) {

	if (is_array($result)) {
?>
		<div class="alert alert-success">Result is in Array</div>
<?php
		echo "<pre>";
		var_dump($result);
		echo "</pre>";
	} else {
?>
		<div class="alert alert-success">
			<?php echo $result;?>
		</div>
<?php	
	}
}
?>
<form action='' method='post'>
	<div class="form-group">
		<label for="rlped_string">Data To Decode:</label>
		<input class="form-control" type='text' name='rlped_string' id='rlped_string' rows=10 value="<?php echo $_POST['rlped_string']?>">
		
		<small>
			Result is in HEX. Below is conversion tool from HEX to your desired data types.
			<ol style="padding-left: 0; list-style: inside decimal;">
				<li><a href="https://www.rapidtables.com/convert/number/hex-to-decimal.html" target="blank">HEX To Decimal</a></li>
				<li><a href="http://string-functions.com/hex-string.aspx" target="blank">HEX To String</a></li>
			</ol>
		</small>
			
			
		
	</div>

	<input type='submit' class="btn btn-success btn-block"/>
</form>
<?php 
include_once("html_iframe_footer.php");