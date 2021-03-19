<?php 
use BitWasp\Bitcoin\Address\PayToPubKeyHashAddress;
use BitWasp\Bitcoin\Bitcoin;
use BitWasp\Bitcoin\Crypto\Random\Random;
use BitWasp\Bitcoin\Key\Factory\PrivateKeyFactory;
use BitWasp\Buffertools\Buffer;
use BitWasp\Bitcoin\Network\NetworkFactory;
use BitWasp\Bitcoin\Script\Opcodes;

include_once "../libraries/vendor/autoload.php";
include_once("html_iframe_header.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $networkClass   = $_POST['network'];
        Bitcoin::setNetwork(NetworkFactory::$networkClass());
        $network        = Bitcoin::getNetwork();
        $privKeyFactory = new PrivateKeyFactory();

        if (!$_POST['input'] OR ctype_xdigit($_POST['input'])) 
        {
            if (!$_POST['input']) 
            { 
                $rbg = new Random();

                if ($_POST['compression'] == 'y') {
                    $privateKey = $privKeyFactory->generateCompressed($rbg);
                } else {
                    $privateKey = $privKeyFactory->generateUncompressed($rbg);
                }
            } else {
                if ($_POST['compression'] == 'y') {
                    $privateKey = $privKeyFactory->fromHexCompressed($_POST['input']);
                } else {
                    $privateKey = $privKeyFactory->fromHexUncompressed($_POST['input']);
                }
            }
        } else {
            $privateKey = $privKeyFactory->fromWIF($_POST['input'], $network);
        }

        $publicKey  = $privateKey->getPublicKey();
        $pubKeyHash = $publicKey->getPubKeyHash();
        $p2pkh      = new PayToPubKeyHashAddress($pubKeyHash);

    ?>
        <div class="table-responsive">
            <table border=0 class='table'>
                <tr style='background-color:#f0f0f0'><td>Base58 Address</td><td><?php echo $p2pkh->getAddress()?></td></tr>
                <tr><td>Private Key Hex</td><td><?php echo $privateKey->getHex()?></td></tr>
                <tr><td>Private Key Wif</td><td><?php echo $privateKey->toWif()?></td></tr>
                <tr><td>Has Compression?</td><td><?php echo $privateKey->isCompressed() ? "Yes" : "No"?></td></tr>
                <tr style='background-color:#f0f0f0'><td>Public Key Hex</td><td><?php echo $publicKey->getHex()?></td></tr>
                <tr style='background-color:#f0f0f0'><td>Has Compression?</td><td><?php echo $publicKey->isCompressed()? "Yes" : "No"?></td></tr>
                <tr style='background-color:#f0f0f0'><td>Public Key Hash Hex</td><td><?php echo $pubKeyHash->getHex()?></td></tr>
                <tr><td>ScriptPubKey Hex </td><td><?php echo $p2pkh->getScriptPubKey()->getHex()?></td></tr>
                <tr><td>ScriptPubKey Asm</td>
                    <td>
                        <?php 
                        $opcodes = $p2pkh->getScriptPubKey()->getOpcodes();

                        foreach( $p2pkh->getScriptPubKey()->getScriptParser()->decode() as $operation ) {

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
        <label for="network">Network:</label>
        <select id="network" name="network" class="form-control" >
            <?php
            $networks = get_class_methods(new NetworkFactory());
            foreach($networks as $network) {
                echo "<option value='{$network}'".($network == $_POST['network'] ? " selected": "").">{$network}</option>";
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="input">Private Key (Hex) / WIF:</label>
        <input class="form-control" type='text' name='input' id='input' value='<?php echo $_POST['input']?>'>
        * Put empty if you want system assign you a random private key.
    </div>
    <div class="form-group">
        <label for="compression" >Compression:</label>
        <select name="compression" class="form-control" id='compression'>
            <?php
            $yesno = array("y"=>"Yes", "n"=>"No");
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