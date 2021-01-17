<?php 
use BitWasp\Bitcoin\Bitcoin;
use BitWasp\Bitcoin\Crypto\Random\Random;
use BitWasp\Bitcoin\Key\Factory\HierarchicalKeyFactory;
use BitWasp\Bitcoin\Mnemonic\Bip39\Bip39Mnemonic;
use BitWasp\Bitcoin\Mnemonic\Bip39\Bip39SeedGenerator;
use BitWasp\Bitcoin\Mnemonic\MnemonicFactory;
use BitWasp\Buffertools\Buffer;
use BitWasp\Bitcoin\Key\Deterministic\HierarchicalKey;

include_once "../libraries/vendor/autoload.php";
include_once("html_iframe_header.php");

$result = 0;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	
	try {
		
		$hdFactory = new HierarchicalKeyFactory();
			
		$bip32Root = $hdFactory->fromExtended($_POST['extended_priv']);
		
		if ($_POST['relative_path']) {
			
			$key = $bip32Root->derivePath($_POST['relative_path']);
			
			$displayPubkey = $key->getPublicKey()->getHex();
			$displayPrikey = $key->getPrivateKey()->getHex();
			$displayExtendedPrikey = $key->toExtendedKey();
			$displayExtendedPubkey = $key->toExtendedPublicKey();
		}
		
		$result = 1;
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
	<h5>Derivation</h5>
	<div class="table-responsive">
		<table border=0 class='table'>
			<tr><td>Relative Path</td><td><?php echo $_POST['relative_path']?></td></tr>
			<tr><td>Public Key</td><td><?php echo $displayPubkey?></td></tr>
			<tr><td>Private Key</td><td><?php echo $displayPrikey?></td></tr>
			<tr><td>Bip32 Extended Private Key</td><td><?php echo $displayExtendedPrikey?></td></tr>
			<tr><td>Bip32 Extended Public Key</td><td><?php echo $displayExtendedPubkey?></td></tr>
		</table>
	</div>
<?php
}
?>
<form action='' method='post'>
	
	<div class="form-group">
		<label for="extended_priv">Bip32 Extended Private Key (Extend From):</label>
		
		<div class="input-group mb-3">
			<input class="form-control" type='text' name='extended_priv' id='extended_priv' value='<?php echo $_POST['extended_priv']?>'>
		</div>
	</div>
	
	<div class="form-group">
		<label for="relative_path">Relative Path (Extend To):</label>
		<input class="form-control" type='text' name='relative_path' id='relative_path' value='<?php echo htmlentities($_POST['relative_path'],ENT_QUOTES)?>'>
		* Do not start with /
	</div>
	
	<input type='submit' class="btn btn-success btn-block"/>
</form>
<?php 
include_once("html_iframe_footer.php");