<?php 
use BitWasp\Bitcoin\Script\ScriptFactory;
use BitWasp\Bitcoin\Transaction\TransactionFactory;
use BitWasp\Bitcoin\Script\Interpreter\InterpreterInterface as I;

include_once "../libraries/vendor/autoload.php";
include_once("html_iframe_header.php");

$result = false;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	
	try {
		$flags = I::VERIFY_NONE;
		$scriptSig = ScriptFactory::fromHex($_POST['script_sig']);
		
		$scriptPubKey = ScriptFactory::fromHex($_POST['script_pub_key']);
		
		//build empty tx for quick test purpose
		$tx = TransactionFactory::build()
			->input(str_pad('', 64, '0'), 0, $scriptSig)
			->get();
		$consensus = ScriptFactory::consensus();
		$nIn = 0;
		$amount = 0;
		
		if (!$consensus->verify($tx, $scriptPubKey, $nIn, $flags, $amount)) {
			throw new Exception("Consensus verification failed.");
		}
		
		$result = true;
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
		<strong>Success!</strong>
	</div>
<?php
}
?>
<form action='' method='post'>
	<div class="form-group">
		<label for="script_sig">ScriptSig (In Hex):</label>
		<input class="form-control" type='text' name='script_sig' id='script_sig' value='<?php echo $_POST['script_sig']?>'>
	</div>
	
	<div class="form-group">
		<label for="script_pub_key">UTXO's ScriptPubKey (In Hex):</label>
		<input class="form-control" type='text' name='script_pub_key' id='script_pub_key' value='<?php echo $_POST['script_pub_key']?>'>
	</div>

	<input type='submit' class="btn btn-success btn-block"/>
</form>
<?php 
include_once("html_iframe_footer.php");