<?php 
use BitWasp\Bitcoin\Base58;
use BitWasp\Buffertools\Buffer;

include_once "../libraries/vendor/autoload.php";

include_once("html_iframe_header.php");

$result = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	try {
		$result = Base58::decode($_POST['string']);
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
	<div class="table-responsive">
		<table border=0 class='table'>
			<tr><td>Base58 String</td><td><?php echo $_POST['string']?></td></tr>
			<tr><td>Decoded String (In Hex)</td><td><?php echo $result->getHex();?></td></tr>
		</table>
	</div>
<?php
}
?>
<form action='' method='post'>
	<div class="form-group">
		<label for="string">Base58 String:</label>
		<input class="form-control" type='text' name='string' id='string' value='<?php echo $_POST['string']?>'>
		
	</div>

	<input type='submit' class="btn btn-success btn-block"/>
</form>
<?php 
include_once("html_iframe_footer.php");