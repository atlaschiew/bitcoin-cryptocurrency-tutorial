<?php 
use BitWasp\Bitcoin\Bitcoin;

use BitWasp\Bitcoin\Key\Factory\HierarchicalKeyFactory;
use BitWasp\Bitcoin\Mnemonic\Bip39\Bip39Mnemonic;
use BitWasp\Bitcoin\Mnemonic\Bip39\Bip39SeedGenerator;
use BitWasp\Bitcoin\Mnemonic\MnemonicFactory;
use BitWasp\Buffertools\Buffer;
use BitWasp\Bitcoin\Key\Deterministic\HierarchicalKey;
use BitWasp\Bitcoin\Network\NetworkFactory;
use BitWasp\Bitcoin\Address\PayToPubKeyHashAddress;

include_once "../libraries/vendor/autoload.php";
include_once("html_iframe_header.php");


$addresses = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	
	try {
		$networkClass   = $_POST['network'];
        Bitcoin::setNetwork(NetworkFactory::$networkClass());
        $network        = Bitcoin::getNetwork();
		$hdFactory = new HierarchicalKeyFactory();
		
		$key = $hdFactory->fromExtended($_POST['xpub'], $network);
		
		$indexes = range((int)$_POST['from_index'],(int)$_POST['to_index']);
		$addresses = [];
		foreach($indexes as $index) {
			$relativePath = strlen($_POST['relative_path']) >0 ? $_POST['relative_path'] . "/"  : "";
			
			$childKey = $key->derivePath( $relativePath . $index);
            $pubKeyHash = $childKey->getPublicKey()->getPubKeyHash();
            $addresses[$relativePath . $index] = (new PayToPubKeyHashAddress($pubKeyHash))->getAddress();
		}
		
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

if ($addresses) {
?>
	<h5>Address Array</h5>
	<div class="table-responsive">
		<table class="table table-bordered">
			<tr><th>Full Relative Path</th><th>Address</th></tr>
		<?php 
		foreach($addresses as $index => $address) {
		?>
			<tr><td><?php echo $index?></td><td><?php echo $address?></td></tr>
		<?php
		}
		?>
		</table>
	</div>
<?php
}
?>
<form action='' method='post'>
	<div class="form-group">
        <label for="network">Network *:</label>
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
		<label for="xpub">Bip32 Extended Public Key (Xpub) *:</label>
		
		<div class="input-group mb-3">
			<input class="form-control" type='text' name='xpub' id='xpub' value='<?php echo $_POST['xpub']?>'>
		</div>
	</div>
	
	<div class="form-group">
        <label for="from_index">From Index *:</label>
        <input class="form-control" type='text' name='from_index' id='from_index' value='<?php echo $_POST['from_index']?>'>
        
    </div>
	
	<div class="form-group">
        <label for="to_index">To Index *:</label>
        <input class="form-control" type='text' name='to_index' id='to_index' value='<?php echo $_POST['to_index']?>'>
    </div>
	
	<div class="form-group">
		<label for="relative_path">Relative Path :</label>
		<input class="form-control" type='text' name='relative_path' id='relative_path' value='<?php echo htmlentities($_POST['relative_path'],ENT_QUOTES)?>'>
		* Do not start with /, this field is optional.
	</div>
	
	
	<input type='submit' class="btn btn-success btn-block"/>
</form>
<?php 
include_once("html_iframe_footer.php");