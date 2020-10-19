<?php 
use kornrunner\Keccak;
use Web3p\RLP\RLP;

include_once "../libraries/vendor/autoload.php";
include_once("html_iframe_header.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
       
        $rlp = new RLP;
		$normalizedAddress = "0x" . ltrim($_POST['address'], "0x");
		
		$encoded = $rlp->encode([$normalizedAddress, (int)$_POST['nonce']]);
		$hash = Keccak::hash(hex2bin($encoded->toString('hex')), 256);
		$ethAddress = '0x' . substr($hash, -40);
		
    ?>
        <div class="table-responsive">
            <table border=0 class='table'>
                <tr style='background-color:#f0f0f0'><td>Address</td><td><?php echo $ethAddress?></td></tr>
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
        <label for="address">Sender Address:</label>
        <input class="form-control" type='text' name='address' id='address' value='<?php echo $_POST['address']?>'>
    </div>
	
	<div class="form-group">
        <label for="nonce">Nonce:</label>
        <input class="form-control" type='text' name='nonce' id='nonce' value='<?php echo $_POST['nonce']?>'>
    </div>
   
    <input type='submit' class="btn btn-success btn-block"/>
</form>
<?php
include_once("html_iframe_footer.php");	