<?php
$_HTML['title'] = 'Ethereum Address';
$_HTML['meta']['keywords'] = "Ethereum Address,Ethereum Address in PHP,PHP";
include_once "../common.php";
include_once("html_header.php");

?>
<h2 class="mt-3">BSC Address</h2>
<hr/>
	<p>
	Since BSC is fork of ethereum. Therefore this page is alias of ethereum address page.
	</p>
	
	<p>
	BSC addresses are composed of the prefix "0x", a common identifier for hexadecimal, concatenated with the rightmost 20 bytes of the Keccak-256 hash (big endian) of the ECDSA public key (the curve used is the so-called secp256k1, the same as Bitcoin)
	</p>
	
	<p>
		There are 2 types of account in BSC network, externally owned account (EOA) and contract account. Remember account just simply mean an address.
	</p>
	
	<p>
		<b>Externally owned account (EOA)</b>
		<ul>
			<li>Controlled by private key.</li>
			<li>Has BNB balance state</li>			
		</ul>
	</p>
	
	<p>
		<b>Contract account</b>
		<ul>
			<li>No private key, controlled by codes written in contract.</li>
			<li>Has BNB balance state</li>
			<li>Has associated code and state of variables declared in contract.</li>
			<li>Learn more about <a href="../eth_smartcontract">Smart Contract</a>.</li>
		</ul>
	</p>
<hr/>


<h3 class="mt-3" id='hashtag1'>EOA Address Generator</h3>
<p>
	
</p>
<ul class="nav nav-tabs">
	<li class="nav-item">
		<a data-toggle="tab" class="nav-link active" href="#form4_tabitem1">Visual</a>
	</li>
	<li class="nav-item">
		<a data-toggle="tab" class="nav-link" href="#form4_tabitem2">Coding</a>
	</li>
</ul>
<div class="tab-content">
	<div id="form4_tabitem1" class="tab-pane fade show active">
		<iframe src="../ethereum/eth_address_form.php" width="100%" scrolling="no" frameborder="no"></iframe>
	</div>
	<div id="form4_tabitem2" class="tab-pane fade">
<pre style='border-radius:none;'><?php echo htmlentities(file_get_contents("../ethereum/eth_address_form.php"));?></pre> 		
	</div>
</div>


<h3 class="mt-3" id='hashtag2'>Address Validator</h3>
<p>
	Address checksum was described in <a href="https://eips.ethereum.org/EIPS/eip-55" target="_blank">EIP-55</a>.
</p>
<ul class="nav nav-tabs">
	<li class="nav-item">
		<a data-toggle="tab" class="nav-link active" href="#form4_tabitem1">Visual</a>
	</li>
	<li class="nav-item">
		<a data-toggle="tab" class="nav-link" href="#form4_tabitem2">Coding</a>
	</li>
</ul>
<div class="tab-content">
	<div id="form4_tabitem1" class="tab-pane fade show active">
		<iframe src="../ethereum/eth_address_validator.php" width="100%" scrolling="no" frameborder="no"></iframe>
	</div>
	<div id="form4_tabitem2" class="tab-pane fade">
<pre style='border-radius:none;'><?php echo htmlentities(file_get_contents("../ethereum/eth_address_validator.php"));?></pre> 		
	</div>
</div>
<?php
include_once("html_footer.php");