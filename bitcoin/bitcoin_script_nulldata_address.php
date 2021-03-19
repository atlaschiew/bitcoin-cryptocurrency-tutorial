<?php 
use BitWasp\Bitcoin\Bitcoin;
use BitWasp\Bitcoin\Network\NetworkFactory;
use BitWasp\Buffertools\Buffer;
use BitWasp\Bitcoin\Key\Factory\PublicKeyFactory;
use BitWasp\Bitcoin\Script\ScriptFactory;
use BitWasp\Bitcoin\Script\P2shScript;
use BitWasp\Bitcoin\Script\Opcodes;

include_once "../libraries/vendor/autoload.php";
include_once("html_iframe_header.php");
    
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	try {
		
		if ($_POST['encoding'] == 'string') {
			$data = new Buffer($_POST['user_data']);
		} else if ($_POST['encoding'] == 'hex') {
			$data = Buffer::hex($_POST['user_data']);
		} else {
			throw new Exception("Please select proper encoding.");
		}
		
		$scriptPubKey = ScriptFactory::create()->op('OP_RETURN')->push($data)->getScript();
		$opcodes = $scriptPubKey->getOpcodes();
	?>
		<div class="table-responsive">
			<table border=0 class='table'>
				<tr><td>ScriptPubKey Hex </td><td><?php echo $scriptPubKey->getHex();?></td></tr>
				
				<tr><td>ScriptPubKey Asm</td>
					<td>
						<?php 
						foreach( $scriptPubKey->getScriptParser()->decode() as $operation ) {
							if ($operation->isPush()) {
								
								echo htmlentities("<{$operation->getData()->getHex()}> ");
							} else {
								echo $opcodes->getOp($operation->getOp()) . " " ;
							}
						}
						?>
					</td>
				</tr>
			</table>
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
		<label>Encoding:</label>
		
		<div class="form-check">
		  <label class="form-check-label">
			<input type="radio" class="form-check-input" name="encoding" value="string"<?php echo $_POST['encoding']=='string' ? ' checked': ''?>>String
		  </label>
		</div>
		<div class="form-check">
		  <label class="form-check-label">
			<input type="radio" class="form-check-input" name="encoding" value="hex"<?php echo $_POST['encoding']=='hex' ? ' checked': ''?>>Hex
		  </label>
		</div>
	</div>
	<div class="form-group">
		<label for="user_data">Data to embed:</label>
		<input class="form-control" type='text' name='user_data' id='user_data' value='<?php echo $_POST['user_data']?>'>
	</div>
	
	<input type='submit' class="btn btn-success btn-block"/>
</form>
<?php
include_once("html_iframe_footer.php");