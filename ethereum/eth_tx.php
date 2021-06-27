<?php
$_HTML['title'] = 'Ethereum Transaction';
$_HTML['meta']['keywords'] = "Ethereum Transaction,Ethereum Transaction in PHP,PHP";
include_once "../common.php";
include_once("html_header.php");

?>
<h2 class="mt-3">Ethereum Transaction</h2>
<hr/>
	<p>Ethereum uses an accounting system where values in WEI (which is smallest unit of ethereum, 1 WEI = 0.000000000000000001 ETH) are debited from accounts and credited to another, as opposed to Bitcoin's UTXO system, which is more analogous to spending cash and receiving change in return.</p>
	
	
	<p>
	Generally, What makes Ethereum different is that the transaction also has a DATA field. This DATA field enables three types of transactions:
	</p>
	
	<p>

		<h6>Transfer of ETH value</h6>
		<ul>
			<li>TO recipient address</li>
			<li>DATA field empty or containing any message you want to attach</li>
			<li>FROM you</li>
			<li>VALUE is ETH amount you want to send</li>
			<li>GAS LIMIT varies<br/>
			1) For normal ETH send to EOA address, gas limit is fixed with 21,000.<br/>
			2) For ETH send to contract address with simplest form of accept ETH deposit <span class="grey_info">function() external payable { }</span>, gas limit consume 21,076 <a target="_blank" href="https://ropsten.etherscan.io/tx/0x63fd8ffcd5ef4e9fefbc0a389b9b34762b7e8241fd9a4cbbca4a72069896a290"><img style='width:12px;height:12px;' src='../media/images/external_link.png'/></a>.<br/>
			3) Continue point no. 2. The more complicated the ETH deposit function, the higher the gas will be used. you may use <a href="https://www.btcschools.net/ethereum/eth_gas.php#hashtag_estgas" target="_blank">tool</a> to estimate it.
			
			</li>
			
		</ul>
		
		<h6>Create smart contract</h6>
		<ul>
			<li>TO field is empty (this is what triggers the creation of a smart contract)</li>
			<li>DATA field contains smart contract code compiled to byte-code</li>
			<li>FROM you</li>
			<li>VALUE can be zero or ETH amount you might want to give to your contract</li>
		</ul>
		
		
		<h6>Call smart contract</h6>
		<ul>
			<li>TO field is the address of the smart contract account</li>
			<li>DATA field contains function name and parameters - how to call the smart contract</li>
			<li>FROM you</li>
			<li>VALUE can be zero or ETH amount you want pay for contract service.</li>
		</ul>
	</p>
<hr/>

<h3 class="mt-3" id='hashtag3'>Raw Tx Generator</h3>
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
								<iframe src="eth_tx_form.php" width="100%" scrolling="no" frameborder="no"></iframe>
							</div>
							<div id="form1_tabitem2_php" class="tab-pane fade">
						<pre style='border-radius:none;'><?php echo htmlentities(file_get_contents("eth_tx_form.php"));?></pre> 		
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
								<iframe src="https://www.btcschools.net:2053/ethereum/eth_tx_form.go" width="100%" scrolling="no" frameborder="no"></iframe>
							</div>
							<div id="form1_tabitem2_go" class="tab-pane fade">
								
								<h5>go/eth_tx_form.go</h5><hr/>
								<pre style='border-radius:none;'><?php echo htmlentities(file_get_contents("go/eth_tx_form.go"));?></pre> 		
								
								<hr/><h5>go/templates/eth_tx_form.html</h5><hr/>
								<pre style='border-radius:none;'><?php echo htmlentities(file_get_contents("go/templates/eth_tx_form.html"));?></pre> 		
								
							</div>
						</div>
					</section>
				</article>
			</div>
		</div>
	</div>
</div>

<?php
include_once("html_footer.php");