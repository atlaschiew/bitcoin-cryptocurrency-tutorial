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
		
		if ($_POST['action'] == 'by_words') {
				
			// Generate mnemonic
			$wordInBytes = ($_POST['words'] / 3)  * 4 ; //3 words per 32 bits (4 bytes);
			
			$random = new Random();
			$entropy = $random->bytes($wordInBytes);
			
			$bip39 = MnemonicFactory::bip39();
			$seedGenerator = new Bip39SeedGenerator();
			$displayMnemonicCode = $bip39->entropyToMnemonic($entropy);
			
			// Derive a seed from mnemonic/password
			$seed = $seedGenerator->getSeed($displayMnemonicCode, $_POST['passphase']);
			
			$HdFactory = new HierarchicalKeyFactory();
			$bip32Root = $HdFactory->fromEntropy($seed);
			$displaySeed = $seed->getHex();
		} else if ($_POST['action'] == 'by_mnemonic_code') {

			$seedGenerator = new Bip39SeedGenerator();
			$seed = $seedGenerator->getSeed( $_POST['mnemonic_code'], $_POST['passphase']);
			$HdFactory = new HierarchicalKeyFactory();
			$bip32Root = $HdFactory->fromEntropy($seed);
			
			$displayMnemonicCode = $_POST['mnemonic_code'];
			$displaySeed = $seed->getHex();
		} else if ($_POST['action'] == 'by_seed') {
			
			$seed = Buffer::hex($_POST['seed']);
			
			$HdFactory = new HierarchicalKeyFactory();
			$bip32Root = $HdFactory->fromEntropy($seed);
			
			$displaySeed = $seed->getHex();
			
		} else if ($_POST['action'] == 'by_mpriv') {
			$HdFactory = new HierarchicalKeyFactory();
			
			$bip32Root = $HdFactory->fromExtended($_POST['mpriv']);
			$displaySeed = "";
		}
		
		$display_dpat = $displayPubkey = $displayPrikey = "";
		if ($_POST['derivation_path']) {
			$_POST['derivation_path']  = ltrim($_POST['derivation_path'], 'm/');
			
			$key = $bip32Root->derivePath($_POST['derivation_path']);
			
			$displayDpath = "m/{$_POST['derivation_path']}";
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
	<h5>Mnemonic</h5>
	<div class="table-responsive">
		<table border=0 class='table'>
			<tr><td>Word Length</td><td><?php echo $_POST['words']?></td></tr>
			<tr><td>Passphase</td><td><?php echo $_POST['passphase'];?></td></tr>
			<tr><td>Seed</td><td><?php echo $displaySeed?></td></tr>
			<tr><td>Mnemonic Code</td><td><?php echo $displayMnemonicCode;?></td></tr>
			<tr><td>Bip32 Root Extended Private Key</td><td><?php echo $bip32Root->toExtendedKey();?>  <!-- same output also if use $bip32Root->toExtendedPrivateKey(); --></td></tr>
			<tr><td>Bip32 Root Extended Public Key</td><td><?php echo $bip32Root->toExtendedPublicKey();?></td></tr>
			
		</table>
	</div>
	<h5>Derivation</h5>
	<div class="table-responsive">
		<table border=0 class='table'>
			<tr><td>Derivation Path</td><td><?php echo $displayDpath?></td></tr>
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
	<input type='hidden' name='action'/>
	<div class="form-group">
		<label for="words">Words Length:</label>
		
		<div class="input-group mb-3">
			<select id="words" name="words" class="form-control" >
				<?php
				$words = [12,15,18,21,24];
				foreach($words as $word) {
					echo "<option value='{$word}'".($word == $_POST['words'] ? " selected": "").">{$word}</option>";
				}
				?>
			</select>
			<div class="input-group-append">
				<input class="btn btn-success" type="submit" value="Retrieve" name='action_type' onclick="this.form.action.value='by_words'"/>
			</div>
		</div>
	</div>
	
	<div class="form-group">
		<label for="mnemonic_code">Mnemonics Code:</label>
		
		<div class="input-group mb-3">
			<input class="form-control" type='text' name='mnemonic_code' id='mnemonic_code' value='<?php echo $_POST['mnemonic_code']?>'>
			<div class="input-group-append">
				<input class="btn btn-success" type="submit" value="Retrieve" name='action_type' onclick="this.form.action.value='by_mnemonic_code'"/>
			</div>
		</div>
	</div>
	
	<div class="form-group">
		<label for="seed">Seed:</label>
		
		<div class="input-group mb-3">
			<input class="form-control" type='text' name='seed' id='seed' value='<?php echo $_POST['seed']?>'>
			<div class="input-group-append">
				<input class="btn btn-success" type="submit" value="Retrieve" name='action_type' onclick="this.form.action.value='by_seed'"/>
			</div>
		</div>
	</div>
	
	
	<div class="form-group">
		<label for="mpriv">Bip32 Root Extended Private Key:</label>
		
		<div class="input-group mb-3">
			<input class="form-control" type='text' name='mpriv' id='mpriv' value='<?php echo $_POST['mpriv']?>'>
			<div class="input-group-append">
				<input class="btn btn-success" type="submit" value="Retrieve" name='action_type' onclick="this.form.action.value='by_mpriv'"/>
			</div>
		</div>
	</div>
	
	<div class="form-group">
		<label for="passphase">Passphase:</label>
		<input class="form-control" type='text' name='passphase' id='passphase' value='<?php echo $_POST['passphase']?>'>
		* Only applicable if you click retrieve from words length or mnemonic code.
	</div>
	
	<div class="form-group">
		<label for="derivation_path">Derivation Path:</label>
		<div class="input-group mb-3">
			<div class="input-group-prepend">
				<span class="input-group-text">m/</span>
			</div>
			<input class="form-control" type='text' name='derivation_path' id='derivation_path' value='<?php echo htmlentities($_POST['derivation_path'],ENT_QUOTES)?>'>
		</div>
		* BIP32 path sample: m/0/0, BIP44 path sample: m/44'/0'/0'/0/0
		
	</div>
  
</form>
<?php 
include_once("html_iframe_footer.php");