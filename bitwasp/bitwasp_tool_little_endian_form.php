<?php 
use BitWasp\Buffertools\Buffer;

include_once "../libraries/vendor/autoload.php";
include_once("html_iframe_header.php");

$result = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	try {
		if ($_POST['encoding']=='hex') {
			if (!ctype_xdigit($_POST['input'])) {
				throw new Exception('Input must be hex string.');
			}
			
			$bf = Buffer::hex($_POST['input']);
		} else {
			if (!ctype_digit($_POST['input'])) {
				throw new Exception('Input must be integer.');
			}
			
			$bf = Buffer::int($_POST['input']);
		}
		
		$result   = $bf->flip()->getHex();
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
			<tr><td>Input Encoding</td><td><?php echo ucfirst($_POST['encoding'])?></td></tr>
			<tr><td>Little Endian (Hex)</td><td><?php echo $result;?></td></tr>
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
	
	<div class="form-group">
		<label>Input Encoding:</label>
		
		<div class="form-check">
		  <label class="form-check-label">
			<input type="radio" class="form-check-input" name="encoding" value="hex"<?php echo $_POST['encoding']=='hex' ? ' checked': ''?>>Hex
		  </label>
		</div>
		
		<div class="form-check">
		  <label class="form-check-label">
			<input type="radio" class="form-check-input" name="encoding" value="integer"<?php echo $_POST['encoding']=='integer' ? ' checked': ''?>>Integer
		  </label>
		</div>
		
	</div>

	<input type='submit' class="btn btn-success btn-block"/>
</form>
<?php 
include_once("html_iframe_footer.php");