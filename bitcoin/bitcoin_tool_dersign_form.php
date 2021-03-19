<?php 

use BitWasp\Buffertools\Buffer;
use BitWasp\Bitcoin\Bitcoin;
use BitWasp\Bitcoin\Key\Factory\PrivateKeyFactory;
use BitWasp\Bitcoin\Signature\TransactionSignature;

include_once "../libraries/vendor/autoload.php";
include_once("html_iframe_header.php");

$errmsg = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
		$sigHashType = $_POST['sighashtype'];
		
		$ecAdapter = Bitcoin::getEcAdapter();

		$privKeyFactory = new PrivateKeyFactory($ecAdapter);
		$privKey = $privKeyFactory->fromHexCompressed($_POST['privatekey']);
		
		$sig = new TransactionSignature($ecAdapter, $privKey->sign(Buffer::hex($_POST['data'])), $sigHashType);

    ?>
        <div class="table-responsive">
            <table border=0 class='table'>
                <tr><td>DER Signature Hex</td><td><?php echo $sig->getSignature()->getBuffer()->getHex() . Buffer::int($sigHashType, 1)->getHex()?></td></tr>
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
        <label for="data">Data To Sign (Hex):</label>
        <input class="form-control" type='text' name='data' id='data' value='<?php echo $_POST['data']?>'>
    </div>
	 <div class="form-group">
        <label for="privatekey">Private Key Hex:</label>
        <input class="form-control" type='text' name='privatekey' id='privatekey' value='<?php echo $_POST['privatekey']?>'>
    </div>
    <div class="form-group">
        <label for="sighashtype">SigHashType:</label>
        <select name="sighashtype" class="form-control" id='sighashtype'>
			<?php
			$sighashtypes = [1=>"ALL",2=>"NONE",3=>"SINGLE",128=>"ANYONECANPAY"];
			
			foreach($sighashtypes as $sighashkey=>$sighashtype) {
				echo "<option value='{$sighashkey}'".($sighashkey == $_POST['sighashtype'] ? " selected": "").">{$sighashtype}</option>";
			}
			?>			
        </select>
    </div>
    <input type='submit' class="btn btn-success btn-block"/>
</form>
<?php
include_once("html_iframe_footer.php");