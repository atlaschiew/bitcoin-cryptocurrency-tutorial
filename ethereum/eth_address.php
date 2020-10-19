<?php
$_HTML['title'] = 'Ethereum Address';
$_HTML['meta']['keywords'] = "Ethereum Address,Ethereum Address in PHP,PHP";
include_once "../common.php";
include_once("html_header.php");

?>
<h2 class="mt-3">Ethereum Address</h2>
<hr/>
	<p>
	Ethereum addresses are composed of the prefix "0x", a common identifier for hexadecimal, concatenated with the rightmost 20 bytes of the Keccak-256 hash (big endian) of the ECDSA public key (the curve used is the so-called secp256k1, the same as Bitcoin)
	</p>
	
	<p>
		There are 2 types of account in ETH network, externally owned account (EOA) and contract account. Remember account just simply mean an address.
	</p>
	
	<p>
		<b>Externally owned account (EOA)</b>
		<ul>
			<li>Controlled by private key.</li>
			<li>Has ETH balance state</li>			
		</ul>
	</p>
	
	<p>
		<b>Contract account</b>
		<ul>
			<li>No private key, controlled by codes written in contract.</li>
			<li>Has ETH balance state</li>
			<li>Has associated code and state of variables declared in contract.</li>
			<li>Learn more about <a href="../eth_smartcontract">Smart Contract</a>.</li>
		</ul>
	</p>
<hr/>

<h3 class="mt-3" id='hashtag3'>EOA Address Generator</h3>
<ul class="nav nav-tabs">
	<li class="nav-item">
		<a data-toggle="tab" class="nav-link active" href="#form1_tabitem1">Visual</a>
	</li>
	<li class="nav-item">
		<a data-toggle="tab" class="nav-link" href="#form1_tabitem2">Coding</a>
	</li>
</ul>
<div class="tab-content">
	<div id="form1_tabitem1" class="tab-pane fade show active">
		<iframe src="eth_address_form.php" width="100%" scrolling="no" frameborder="no"></iframe>
	</div>
	<div id="form1_tabitem2" class="tab-pane fade">
<pre style='border-radius:none;'><?php echo htmlentities(file_get_contents("eth_address_form.php"));?></pre> 		
	</div>
</div>

<h3 class="mt-3" id='hashtag3'>Contract Address Generator</h3>
<p>
	Contract address will be auto generated (without private key) when contract-type tx publish to ETH network.
</p>
<ul class="nav nav-tabs">
	<li class="nav-item">
		<a data-toggle="tab" class="nav-link active" href="#form2_tabitem1">Visual</a>
	</li>
	<li class="nav-item">
		<a data-toggle="tab" class="nav-link" href="#form2_tabitem2">Coding</a>
	</li>
</ul>
<div class="tab-content">
	<div id="form2_tabitem1" class="tab-pane fade show active">
		<iframe src="eth_contract_address_form.php" width="100%" scrolling="no" frameborder="no"></iframe>
	</div>
	<div id="form2_tabitem2" class="tab-pane fade">
<pre style='border-radius:none;'><?php echo htmlentities(file_get_contents("eth_contract_address_form.php"));?></pre> 		
	</div>
</div>



<h3 class="mt-3" id='hashtag3'>How To Determine Address Type?</h3>
<p>
	You can call JSON-RPC with getcode method.
	if the address is representing an EOA you will get 0x as response otherwise you will get the contract's bytecode.
</p>
<ul class="nav nav-tabs">
	<li class="nav-item">
		<a data-toggle="tab" class="nav-link active" href="#form3_tabitem1">Visual</a>
	</li>
	<li class="nav-item">
		<a data-toggle="tab" class="nav-link" href="#form3_tabitem2">Coding</a>
	</li>
</ul>
<div class="tab-content">
	<div id="form3_tabitem1" class="tab-pane fade show active">
		<iframe src="eth_check_address_form.php" width="100%" scrolling="no" frameborder="no"></iframe>
	</div>
	<div id="form3_tabitem2" class="tab-pane fade">
<pre style='border-radius:none;'><?php echo htmlentities(file_get_contents("eth_check_address_form.php"));?></pre> 		
	</div>
</div>
<?php
include_once("html_footer.php");