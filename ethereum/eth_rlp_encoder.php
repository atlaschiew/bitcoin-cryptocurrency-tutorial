<?php 
use Web3p\RLP\RLP;
use kornrunner\Keccak;
include_once "../libraries/vendor/autoload.php";
include_once("html_iframe_header.php");

$url = "https://ropsten.infura.io";
var_dump(preg_match('/^https\:\/\/([a-z]+)\.infura\.io/', $url));

$rlp = new RLP;
// c483646f67
$encoded = $rlp->encode(['0x6ac7ea33f8831ea9dcc53393aaa88b25a785dbf0', 1]);



$hash = Keccak::hash(hex2bin($encoded->toString('hex')), 256);

echo '0x' . substr($hash, -40);
echo "<br/>";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	
} 

if ($errmsg) {
?>
    <div class="alert alert-danger">
        <strong>Error!</strong> <?php echo $errmsg?>
    </div>
<?php
}

?>
<form id='this_form' action='?action=submit' method='post'>

	
		
    <input type='submit' class="btn btn-success btn-block"/>
</form>
<?php
include_once("html_iframe_footer.php");