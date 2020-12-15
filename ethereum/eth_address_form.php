<?php 
use kornrunner\Keccak;
use BitWasp\Bitcoin\Key\Factory\PrivateKeyFactory;
use BitWasp\Bitcoin\Crypto\Random\Random;

include_once "../libraries/vendor/autoload.php";
include_once("html_iframe_header.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
       
        $privKeyFactory = new PrivateKeyFactory();

        if (!$_POST['input'] OR ctype_xdigit($_POST['input'])) 
        {
            if (!$_POST['input']) 
            { 
                $rbg = new Random();
                $privateKey = $privKeyFactory->generateUncompressed($rbg);
                
            } else {
                
                $privateKey = $privKeyFactory->fromHexUncompressed($_POST['input']);
            }
        } 
       
		$publicKey = $privateKey->getPublicKey();
		$madeUpEthAddress = substr($publicKey->getHex(), 2);
		
		$hash = Keccak::hash(hex2bin($madeUpEthAddress), 256);
		// Ethereum address has 20 bytes length. (40 hex characters long)
		// We only need the last 20 bytes as Ethereum address
		$ethAddress = '0x' . substr($hash, -40);
		
    ?>
        <div class="table-responsive">
            <table border=0 class='table'>
                <tr style='background-color:#f0f0f0'><td>Address</td><td><?php echo $ethAddress?></td></tr>
                <tr><td>Private Key Hex</td><td><?php echo $privateKey->getHex()?></td></tr>               
                <tr style='background-color:#f0f0f0'><td>Public Key Hex</td><td><?php echo $publicKey->getHex()?></td></tr>
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
        <label for="input">Private Key (Hex):</label>
        <input class="form-control" type='text' name='input' id='input' value='<?php echo $_POST['input']?>'>
        * Put empty if you want system assign you a random private key.
    </div>
   
    <input type='submit' class="btn btn-success btn-block"/>
</form>
<?php
include_once("html_iframe_footer.php");