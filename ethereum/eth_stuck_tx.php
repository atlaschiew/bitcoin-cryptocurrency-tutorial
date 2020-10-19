<?php
$_HTML['title'] = 'Ethereum Stuck Transaction';
$_HTML['meta']['keywords'] = "Ethereum Stuck Transaction,Ethereum Stuck Transaction in PHP,PHP";
include_once "../common.php";
include_once("html_header.php");

?>
<h2 class="mt-3">Ethereum Stuck Transaction</h2>
<hr/>
	<p>Transaction can be stuck as long as tx gas price is not interest by miner.</p>
	
	<p>
		You have 2 ways to solve this problem. To cancel or to proceed.
	</p>
	
	<p>
	<ul>
		<li>To cancel, please follow this article <a href='eth_cancel_tx.php'>Ethereum Cancel Tx</a>.</li>
		
		<li>
			To proceed you have to set higher gas price (GWEI) follow ideal gas price from <a href='https://etherscan.io/gastracker'>Gas Tracker</a>. Remember you must use same <b>nonce</b>, otherwise ethereum network consider it as new tx.
		</li>
	</p>


<?php
include_once("html_footer.php");