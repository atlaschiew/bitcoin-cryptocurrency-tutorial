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
		<iframe src="eth_tx_form.php" width="100%" scrolling="no" frameborder="no"></iframe>
	</div>
	<div id="form1_tabitem2" class="tab-pane fade">
<pre style='border-radius:none;'><?php echo htmlentities(file_get_contents("eth_tx_form.php"));?></pre> 		
	</div>
</div>
<?php
include_once("html_footer.php");