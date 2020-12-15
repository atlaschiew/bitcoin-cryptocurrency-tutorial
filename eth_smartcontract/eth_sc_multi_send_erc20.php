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
		<li>
			Gas consumption for normal send ERC20 using transfer() method.<br/>
			- Send to has balance address, gas consume about ~36,163 <a target="_blank" href="https://ropsten.etherscan.io/tx/0x1109260c56c6d521b0ee617e3ab092d0067653b258baa612befc74b79f3ef211"><img style='width:12px;height:12px;' src='../media/images/external_link.png'/></a>.<br/>
			- Send to zero balance address, gas consume about ~51,163  <a target="_blank" href="https://ropsten.etherscan.io/tx/0x40d3b0ed7d987b1078d76a1e6d5cb01e8c945f0897d70abf42ee00434b485fe5"><img style='width:12px;height:12px;' src='../media/images/external_link.png'/></a>.<br/>
			
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