<?php 
use BitWasp\Bitcoin\Base58;
use BitWasp\Buffertools\Buffer;

include_once "../libraries/vendor/autoload.php";
include_once("html_iframe_header.php");

$result = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	try {
		if (ctype_xdigit($_POST['input'])) {
			$bf = Buffer::hex($_POST['input']);
			$input_type = "Hex";
		} else if (preg_match('/^[1-9][0-9]*$/', $_POST['input'])) {
			$bf = Buffer::int($_POST['input']);
			$input_type = "Integer";
		} else {
			$bf = new Buffer($_POST['input']);
			$input_type = "String";
		}
		$result = Base58::encode($bf);
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
			<tr><td>Input</td><td><?php echo $_POST['input']?></td></tr>
			<tr><td>Input Encoding</td><td><?php echo $input_type;?></td></tr>
			<tr><td>Base58 String</td><td><?php echo $result;?></td></tr>
		</table>
	</div>
<?php
}
?>
<form action='' method='post'>
	<div class="form-group">
		<label for="input">Input:</label>
		<input class="form-control" type='text' name='input' id='input' value='<?php echo $_POST['input']?>'>
		
	</div>

	<input type='submit' class="btn btn-success btn-block"/>
</form>
<?php 
include_once("html_iframe_footer.php");