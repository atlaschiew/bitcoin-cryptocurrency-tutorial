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

<h3 class="mt-3" id='hashtag1'>EOA Address Generator</h3>
<div class="row">
	<div class="vertical-tabs-left">
		<ul class="nav nav-tabs left-tabs sideways-tabs">
			<li class="nav-item">
				<a class="nav-link active" href="#form1_php" data-toggle="tab">PHP</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#form1_go" data-toggle="tab">Go</a>
			</li>
		</ul>
	</div>

	<div class="vertical-tabs-right" >

		<div class="">
			<div class="tab-content" >
				<article class="tab-pane  active" id="form1_php" >
					<section >
						<ul class="nav nav-tabs">
							<li class="nav-item">
								<a data-toggle="tab" class="nav-link active" href="#form1_tabitem1_php">Visual</a>
							</li>
							<li class="nav-item">
								<a data-toggle="tab" class="nav-link" href="#form1_tabitem2_php">Coding</a>
							</li>
						</ul>
						<div class="tab-content">
							<div id="form1_tabitem1_php" class="tab-pane fade show active">
								<iframe src="eth_address_form.php" width="100%" scrolling="no" frameborder="no"></iframe>
							</div>
							<div id="form1_tabitem2_php" class="tab-pane fade">
						<pre style='border-radius:none;'><?php echo htmlentities(file_get_contents("eth_address_form.php"));?></pre> 		
							</div>
						</div>
					</section>
				</article>
				<article class="tab-pane " id="form1_go">
					<section>
						<ul class="nav nav-tabs">
							<li class="nav-item">
								<a data-toggle="tab" class="nav-link active" href="#form1_tabitem1_go">Visual</a>
							</li>
							<li class="nav-item">
								<a data-toggle="tab" class="nav-link" href="#form1_tabitem2_go">Coding</a>
							</li>
						</ul>
						<div class="tab-content">
							<div id="form1_tabitem1_go" class="tab-pane fade show active">
								<iframe src="https://www.btcschools.net:2053/ethereum/eth_address_form.go" width="100%" scrolling="no" frameborder="no"></iframe>
							</div>
							<div id="form1_tabitem2_go" class="tab-pane fade">
								
								<h5>go/eth_address_form.go</h5><hr/>
								<pre style='border-radius:none;'><?php echo htmlentities(file_get_contents("go/eth_address_form.go"));?></pre> 		
								
								<hr/><h5>go/templates/eth_address_form.html</h5><hr/>
								<pre style='border-radius:none;'><?php echo htmlentities(file_get_contents("go/templates/eth_address_form.html"));?></pre> 		
								
							</div>
						</div>
					</section>
				</article>
			</div>
		</div>
	</div>
</div>


<h3 class="mt-3" id='hashtag2'>Address Validator</h3>
<p>
	Address checksum was described in <a href="https://eips.ethereum.org/EIPS/eip-55" target="_blank">EIP-55</a>.
</p>

<div class="row">
	<div class="vertical-tabs-left">
		<ul class="nav nav-tabs left-tabs sideways-tabs">
			<li class="nav-item">
				<a class="nav-link active" href="#form2_php" data-toggle="tab">PHP</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#form2_go" data-toggle="tab">Go</a>
			</li>
		</ul>
	</div>

	<div class="vertical-tabs-right" >

		<div class="">
			<div class="tab-content" >
				<article class="tab-pane  active" id="form2_php" >
					<section >
						<ul class="nav nav-tabs">
							<li class="nav-item">
								<a data-toggle="tab" class="nav-link active" href="#form2_tabitem1_php">Visual</a>
							</li>
							<li class="nav-item">
								<a data-toggle="tab" class="nav-link" href="#form2_tabitem2_php">Coding</a>
							</li>
						</ul>
						<div class="tab-content">
							<div id="form2_tabitem1_php" class="tab-pane fade show active">
								<iframe src="eth_address_validator.php" width="100%" scrolling="no" frameborder="no"></iframe>
							</div>
							<div id="form2_tabitem2_php" class="tab-pane fade">
						<pre style='border-radius:none;'><?php echo htmlentities(file_get_contents("eth_address_validator.php"));?></pre> 		
							</div>
						</div>
					</section>
				</article>
				<article class="tab-pane " id="form2_go">
					<section>
						<ul class="nav nav-tabs">
							<li class="nav-item">
								<a data-toggle="tab" class="nav-link active" href="#form2_tabitem1_go">Visual</a>
							</li>
							<li class="nav-item">
								<a data-toggle="tab" class="nav-link" href="#form2_tabitem2_go">Coding</a>
							</li>
						</ul>
						<div class="tab-content">
							<div id="form2_tabitem1_go" class="tab-pane fade show active">
								<iframe src="https://www.btcschools.net:2053/ethereum/eth_address_validator.go" width="100%" scrolling="no" frameborder="no"></iframe>
							</div>
							<div id="form2_tabitem2_go" class="tab-pane fade">
								
								<h5>go/eth_address_validator.go</h5><hr/>
								<pre style='border-radius:none;'><?php echo htmlentities(file_get_contents("go/eth_address_validator.go"));?></pre> 		
								
								<hr/><h5>go/templates/eth_address_validator.html</h5><hr/>
								<pre style='border-radius:none;'><?php echo htmlentities(file_get_contents("go/templates/eth_address_validator.html"));?></pre> 		
								
							</div>
						</div>
					</section>
				</article>
			</div>
		</div>
	</div>
</div>

<h3 class="mt-3" id='hashtag3'>Contract Address Generator</h3>
<p>
	Contract address will be auto generated (without private key) when contract-type tx publish to ETH network.
</p>


<div class="row">
	<div class="vertical-tabs-left">
		<ul class="nav nav-tabs left-tabs sideways-tabs">
			<li class="nav-item">
				<a class="nav-link active" href="#form3_php" data-toggle="tab">PHP</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#form3_go" data-toggle="tab">Go</a>
			</li>
		</ul>
	</div>

	<div class="vertical-tabs-right" >

		<div class="">
			<div class="tab-content" >
				<article class="tab-pane  active" id="form3_php" >
					<section >
						<ul class="nav nav-tabs">
							<li class="nav-item">
								<a data-toggle="tab" class="nav-link active" href="#form3_tabitem1_php">Visual</a>
							</li>
							<li class="nav-item">
								<a data-toggle="tab" class="nav-link" href="#form3_tabitem2_php">Coding</a>
							</li>
						</ul>
						<div class="tab-content">
							<div id="form3_tabitem1_php" class="tab-pane fade show active">
								<iframe src="eth_contract_address_form.php" width="100%" scrolling="no" frameborder="no"></iframe>
							</div>
							<div id="form3_tabitem2_php" class="tab-pane fade">
						<pre style='border-radius:none;'><?php echo htmlentities(file_get_contents("eth_contract_address_form.php"));?></pre> 		
							</div>
						</div>
					</section>
				</article>
				<article class="tab-pane " id="form3_go">
					<section>
						<ul class="nav nav-tabs">
							<li class="nav-item">
								<a data-toggle="tab" class="nav-link active" href="#form3_tabitem1_go">Visual</a>
							</li>
							<li class="nav-item">
								<a data-toggle="tab" class="nav-link" href="#form3_tabitem2_go">Coding</a>
							</li>
						</ul>
						<div class="tab-content">
							<div id="form3_tabitem1_go" class="tab-pane fade show active">
								<iframe src="https://www.btcschools.net:2053/ethereum/eth_contract_address_form.go" width="100%" scrolling="no" frameborder="no"></iframe>
							</div>
							<div id="form3_tabitem2_go" class="tab-pane fade">
								
								<h5>go/eth_contract_address_form.go</h5><hr/>
								<pre style='border-radius:none;'><?php echo htmlentities(file_get_contents("go/eth_contract_address_form.go"));?></pre> 		
								
								<hr/><h5>go/templates/eth_contract_address_form.html</h5><hr/>
								<pre style='border-radius:none;'><?php echo htmlentities(file_get_contents("go/templates/eth_contract_address_form.html"));?></pre> 		
								
							</div>
						</div>
					</section>
				</article>
			</div>
		</div>
	</div>
</div>

<h3 class="mt-3" id='hashtag4'>How To Determine Address Type?</h3>
<p>
	You can call JSON-RPC with getcode method.
	if the address is representing an EOA you will get 0x as response otherwise you will get the contract's bytecode.
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
		<iframe src="eth_check_address_form.php" width="100%" scrolling="no" frameborder="no"></iframe>
	</div>
	<div id="form4_tabitem2" class="tab-pane fade">
<pre style='border-radius:none;'><?php echo htmlentities(file_get_contents("eth_check_address_form.php"));?></pre> 		
	</div>
</div>
<?php
include_once("html_footer.php");