<?php 
use kornrunner\Keccak;

include_once "../libraries/vendor/autoload.php";
include_once("html_iframe_header.php");

$result = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	try {
		$result = Keccak::hash(hex2bin($_POST['string']), 256);
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
			<tr><td>String</td><td><?php echo $_POST['string']?></td></tr>
			<tr><td>Keccak 256</td><td><?php echo $result;?></td></tr>
		</table>
	</div>
<?php
}
?>
<form action='' method='post'>
	<div class="form-group">
		<label for="string">String In Hex:</label>
		<input class="form-control" type='text' name='string' id='string' value='<?php echo $_POST['string']?>'>
		
	</div>

	<input type='submit' class="btn btn-success btn-block"/>
</form>
<?php 
include_once("html_iframe_footer.php");