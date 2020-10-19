<?php
$_HTML['title'] = 'Ethereum Transaction';
$_HTML['meta']['keywords'] = "Ethereum Transaction,Ethereum Transaction in PHP,PHP";
include_once "../common.php";
include_once("html_header.php");

?>
<h2 class="mt-3">Ethereum Erc20 Transaction</h2>
<hr/>
	<p>
	ERC-20 tokens is smart contract built on top of Ethereum. User can create new crypto assets without need to setup a complex blockchain cryptocoin infastructure.
	</p>
<hr/>
<ul>
	<li>ERC stands for Ethereum Request for Comment, and 20 is the proposal identifier.</li>
	<li>3 optional rules. Token Name, Symbol & Decimal (up to 18)</li>
	<li>6 mandatory functions. totalSupply, balanceOf, transfer, transferFrom, approve & allowance</li>
</ul>


<h3 class="mt-3" id='hashtag3'>Raw Erc20 Tx Generator</h3>
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
		<iframe src="eth_erc20_tx_form.php" width="100%" scrolling="no" frameborder="no"></iframe>
	</div>
	<div id="form1_tabitem2" class="tab-pane fade">
<pre style='border-radius:none;'><?php echo htmlentities(file_get_contents("eth_erc20_tx_form.php"));?></pre> 		
	</div>
</div>
<?php
include_once("html_footer.php");