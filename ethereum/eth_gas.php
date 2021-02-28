<?php
$_HTML['title'] = 'Eth Gas';
$_HTML['meta']['keywords'] = "Eth Gas,Eth Gas in PHP,PHP";
include_once "../common.php";
include_once("html_header.php");

?>
<h2 class="mt-3">Ethereum Gas</h2>
<hr/>
On the ethereum blockchain, gas refers to the necessary cost to perform a transaction on the network and in turn this cost will be rewarded to the miner. Miners can set minimum gas price so transaction with gas price below the limit will not be propagated and included in the pending block.
<hr/>
<h5 class="mt-3">Block Gas Limit</h5>
Blocks also have total gas limits to prevent runaway computation/keep the network decentralized. Up to time, it is 10,000,000 gas.

<h5 class="mt-3">Gas Limit</h5>
			
<p>Normal transfer eth to <a href="eth_address.php">EOA address</a> always require 21,000 gas limit, but gas limit interact with contract might be higher. Therefore, you can use <a href="#hashtag_estgas">tool</a> below to estimate it.</p>
		
<p>ETH wastage can be happen when gas limit is too low thus cause the transaction fail.</p>

<div class='vertical-line-yellow'>
	
	<b>Q:</b> Could i specify exact gas limit according to previous gas used?<br/>
	<b>A:</b> If contract call Tx trigger <a href="https://ethereum.stackexchange.com/questions/594/how-do-gas-refunds-work" target="_blank">Refund Gas <img style='width:12px;height:12px;' src='../media/images/external_link.png'/></a> mechanism, then eventually you will trigger out-of-gas error.
	
	<br/><br/>
	<b>Q:</b> Which opcodes trigger refund?<br/>
	<b>A:</b> <span class="grey_info">SELFDESTRUCT</span> refunds 24,000 and <span class="grey_info">SSTORE[x] = 0</span> (deletion) refunds 15,000 gas. 
	
	<br/><br/>
	<b>Q:</b> How to calculate refunded gas in the Tx?<br/>
	<b>A:</b> Take <a href='https://etherscan.io/tx/0x3aadf68c900ead2682b212708c638efa841477eb36719aa25aea40a2192970a1' target="_blank">0x3aadf68c900ead2682b212708c638efa841477eb36719aa25aea40a2192970a1</a> (<a target="_blank" href="https://etherscan.io/vmtrace?txhash=0x3aadf68c900ead2682b212708c638efa841477eb36719aa25aea40a2192970a1">vmtrace</a>) as an example. Refunded gas = (Gas limit - Last executed gas) - Gas used = (60,000 - 18,791) - 26,209 = 15,000.
</div>

<h5 class="mt-3">Gas Used</h5>			
The actual gas amount used by this transaction.
		
<h5 class="mt-3">Gas Price</h5>
The price of gas (unit in wei) in this transaction.
		
<h5 class="mt-3">Transaction Fees</h5>
Tx Fees = Gas used * gas price. Remaining ETH will be refunded to initiator's account.

<h3 class="mt-3" id='hashtag_estgas'>Estimate Gas Limit</h3>
<hr/>
<p>
	<B>eth_estimateGas</B> tries to find a minimal gas to run this transaction on the given block number. It do a binary search between 21000 and 'gas limit'. For example, if 'gas limit' is 79000, it tries to run this transaction with the gas limit, 50000 = (21000 + 79000) / 2. If it failed, it tries with 64500 = (50000 + 79000) / 2, and so on. If it failed with 'gas limit', it returns 0 and error message, "gas required exceeds allowance or always failing transaction".
</p>
	
<div class='vertical-line-yellow'>
	eth_estimateGas as the name implied, it is estimation and not always accurate. So it is advised to specify a higher gasLimit than estimateGas.
</div>


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
		<iframe src="eth_gas_form.php" width="100%" scrolling="no" frameborder="no"></iframe>
	</div>
	<div id="form1_tabitem2" class="tab-pane fade">
<pre style='border-radius:none;'><?php echo htmlentities(file_get_contents("eth_gas_form.php"));?></pre> 		
	</div>
</div>
<?php
include_once("html_footer.php");