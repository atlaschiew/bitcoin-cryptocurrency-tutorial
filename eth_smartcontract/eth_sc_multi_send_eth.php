<?php
$_HTML['title'] = 'Multi Send ETH (Contract)';
$_HTML['meta']['keywords'] = "Multi Send ETH, Btcschools Smart Contract, Btcschools Solidity";
include_once "../common.php";
include_once("html_header.php");

?>
<h2 class="mt-3">Multi Send ETH (Contract)</h2>
<hr/>
	<p>
		This contract is useful when you want to save gas to send ETH to multiple recipient. There are 2 ways to execute, one is send based on right in ETH value, another way is send from contract's ETH balance.
	</p>
<hr/>
<p>
	Few things worth to take note:
	<ul>
		<li>Gas used send to new address (or any zero ETH balance address) is higher than address with ETH balance.</li>
		<li>The more the recipient, the cheaper the cost per ETH transfer as in compare to normal send which consume 21,000 gas.</li>
		
		<li>
			If send one ETH transfer only , then apparently gas cost is expensive than normal send ETH.
		</li>
	</ul>
</p>


<ul class="nav nav-tabs">
	<li class="nav-item">
		<a data-toggle="tab" class="nav-link active" href="#form1_tabitem1">Visual</a>
	</li>
	<li class="nav-item">
		<a data-toggle="tab" class="nav-link" href="#form1_tabitem2">Coding</a>
	</li>
	<li class="nav-item">
		<a data-toggle="tab" class="nav-link" href="#form1_tabitem3">Solidity</a>
	</li>
</ul>
<div class="tab-content">
	<div id="form1_tabitem1" class="tab-pane fade show active">
		<iframe src="eth_sc_multi_send_eth_form.php" width="100%" scrolling="no" frameborder="no"></iframe>
	</div>
	
	<div id="form1_tabitem2" class="tab-pane fade">
<pre style='border-radius:none;'><?php echo htmlentities(file_get_contents("eth_sc_multi_send_eth_form.php"));?></pre> 		
	</div>
	
	<div id="form1_tabitem3" class="tab-pane fade">
<pre style='border-radius:none;'><?php echo htmlentities(file_get_contents("eth_sc_multi_send_eth.sol"));?></pre> 		
	</div>
</div>
<?php
include_once("html_footer.php");