<?php
$_HTML['title'] = 'Multi Send ERC20 (Contract)';
$_HTML['meta']['keywords'] = "Multi Send ERC20, Btcschools Smart Contract, Btcschools Solidity";
include_once "../common.php";
include_once("html_header.php");

?>
<h2 class="mt-3">Multi Send ERC20 (Contract)</h2>
<hr/>
	<p>
		This contract is useful when you want to save gas to send ERC20 token to multiple recipient. It works to send from contract's token balance, so make sure you have deposit enough token into contract.
	</p>
<hr/>
<p>
	Few things worth to take note:
	
	<ul>
		<li>Gas used to deposit contract with token balance is cheaper than zero token balance contract.</li>
		<li>Gas consumption for normal send ERC20 is 37,179.</li>
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
		<iframe src="eth_sc_multi_send_erc20_form.php" width="100%" scrolling="no" frameborder="no"></iframe>
	</div>
	
	<div id="form1_tabitem2" class="tab-pane fade">
<pre style='border-radius:none;'><?php echo htmlentities(file_get_contents("eth_sc_multi_send_erc20_form.php"));?></pre> 		
	</div>
	
	<div id="form1_tabitem3" class="tab-pane fade">
<pre style='border-radius:none;'><?php echo htmlentities(file_get_contents("eth_sc_multi_send_erc20.sol"));?></pre> 		
	</div>
</div>
<?php
include_once("html_footer.php");