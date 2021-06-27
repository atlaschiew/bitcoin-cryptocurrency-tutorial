<?php 

use BitWasp\Buffertools\Buffer;
use BitWasp\Bitcoin\Bitcoin;
use BitWasp\Bitcoin\Key\Factory\PrivateKeyFactory;
use BitWasp\Bitcoin\Signature\TransactionSignature;
use BitWasp\Bitcoin\Crypto\EcAdapter\Impl\PhpEcc\Signature\CompactSignature;


include_once "../libraries/vendor/autoload.php";
include_once("html_iframe_header.php");

$errmsg = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
		
		$ecAdapter = Bitcoin::getEcAdapter();
		$r = Buffer::hex($_POST["R"],32);
		$R = $r->getGmp();
		
		$s = Buffer::hex($_POST["S"],32);
		$S = $s->getGmp();
		
		$recoveryFlag = (int)$_POST["V"];
		$recoveryId = $recoveryFlag - 27 - ($_POST['compression']=="y" ? 4 : 0);
		
		$cs = new CompactSignature($ecAdapter, $R, $S, $recoveryId, $_POST['compression']=="y");
		
		$publicKey = $ecAdapter->recover(Buffer::hex($_POST["msg"]), $cs);
		
		?>
		<div class="alert alert-success">
			<b>Recovered Public Key</b>: <?php echo $publicKey->getHex();?>
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
        <label for="V">V (Int):</label>
        <input class="form-control" type='text' name='V' id='V' value='<?php echo $_POST['V']?>'>
    </div>
	
    <div class="form-group">
        <label for="R">R (Hex):</label>
        <input class="form-control" type='text' name='R' id='R' value='<?php echo $_POST['R']?>'>
    </div>
	<div class="form-group">
        <label for="S">S (Hex):</label>
        <input class="form-control" type='text' name='S' id='S' value='<?php echo $_POST['S']?>'>
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