<?php 

use BitWasp\Buffertools\Buffer;
use BitWasp\Bitcoin\Bitcoin;
use BitWasp\Bitcoin\Key\Factory\PrivateKeyFactory;
use BitWasp\Bitcoin\Signature\TransactionSignature;
use BitWasp\Bitcoin\Crypto\EcAdapter\Impl\PhpEcc\Signature\CompactSignature;
use BitWasp\Bitcoin\Crypto\EcAdapter\Impl\PhpEcc\Signature\Signature;

include_once "../libraries/vendor/autoload.php";
include_once("html_iframe_header.php");

$errmsg = '';
ini_set("display_errors", "1");
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
		$ecAdapter = Bitcoin::getEcAdapter();
		
		$derSign = Buffer::hex($_POST["der"]);
		if (!TransactionSignature::isDERSignature($derSign)) {
			throw new Exception("DER signature not valid.");
		}
		
		$binary = $derSign->getBinary();
        $nLenR = ord($binary[3]);
		
		$R = $derSign->slice(4, $nLenR)->getGmp();
		$r = ltrim(Buffer::int(gmp_strval($R,10), (int)$nLenR)->getHex(), "00");
		
        $nLenS = ord($binary[5 + $nLenR]);
        $S = $derSign->slice(6 + $nLenR, $nLenS)->getGmp();
		$s = Buffer::int(gmp_strval($S,10), (int)$nLenS)->getHex();
		
		$sigHash = $derSign->slice(6 + $nLenR + $nLenS, 1);
		
		$publicKeys = [];
		foreach(range(0,3) as $V) {
			try {
				$flag = (int)$V + 27 + ($_POST['compression']=="y" ? 4 : 0);
				
				$cs = new CompactSignature($ecAdapter, $R, $S, (int)$V, $_POST['compression']=="y");
				$publicKey = $ecAdapter->recover(Buffer::hex($_POST["msg"]), $cs);
				
				$publicKeys[] = $publicKey->getHex() . " (RecoveryId = {$V})";
				
			} catch (Exception $e) {
				
			}
		}
		
		//is low S
		//$isLowDerSignature = $ecAdapter->validateSignatureElement($S, true); 
		?>
		<div class="alert alert-success">
			<b>Recovered Public Key</b>: <br/>
			<?php echo implode("<br/>", $publicKeys);?>
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
        <label for="msg">Hash Message (Hex):</label>
        <input class="form-control" type='text' name='msg' id='msg' value='<?php echo $_POST['msg']?>'>
    </div>
	
	
	<div class="form-group">
        <label for="der">DER Signature:</label>
        <input class="form-control" type='text' name='der' id='der' value='<?php echo $_POST['der']?>'>
    </div>
    
	<div class="form-group">
        <label for="compression">Public Key:</label>
        <select name="compression" class="form-control" id='compression'>
            <?php
            $yesno = array("y"=>"Has Compression", "n"=>"Without Compression");
            foreach($yesno as $yesno_k=>$yesno_v) {
                echo "<option value='{$yesno_k}'".($yesno_k == $_POST['compression'] ? " selected": "").">{$yesno_v}</option>";
            }
            ?>
        </select>
    </div>
   
    <input type='submit' class="btn btn-success btn-block"/>
</form>
<?php
include_once("html_iframe_footer.php");