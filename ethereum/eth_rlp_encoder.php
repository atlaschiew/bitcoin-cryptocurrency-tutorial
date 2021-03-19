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
		
		$firstTag = substr($_POST['string'], 0, 1);
		$lastTag  = substr($_POST['string'], -1);
		
		if ($firstTag == '[' AND $lastTag == ']') {
			$toEncode = json_decode($_POST['string'],true);
		
			if (json_last_error() !== JSON_ERROR_NONE) {
				throw new Exception("Invalid JSON-ARRAY string.");
			}
		} else {
			
			//auto cast if integer or float is detected
			
			if (ctype_digit($_POST['string'])) {
				$toEncode = (int)$_POST['string'];
			} else if (is_numeric($_POST['string'])) {
				$toEncode = (float)$_POST['string'];
			} else {
				$toEncode = $_POST['string'];
			}
		}
		$result = $rlp->encode($toEncode);
		
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
?>
	<div class="alert alert-success">
		<?php echo $result;?>
	</div>
<?php
}
?>
<form action='' method='post'>


	<div class="form-group">
		<label for="string">Data To Encode:</label>
		<textarea class="form-control" type='text' name='string' id='string' rows=10><?php echo $_POST['string']?></textarea>
		<small>
			<ol style="padding-left: 0; list-style: inside decimal;">
				<li>
					To encode array, JSON-ARRAY serialized string must be applied and start with '[' and end with ']'.
				</li>
				
				<li>
					Numeric number will be casted to integer or float.
				</li>
			</ol>
		</small>
	</div>

	<input type='submit' class="btn btn-success btn-block"/>
</form>
<?php 
include_once("html_iframe_footer.php");