<?php

$_HTML['title'] = 'Ethereum Javascript Work With Web3 Browser';
$_HTML['meta']['keywords'] = "Ethereum Javascript Work With Web3 Browser";

include_once "../common.php";
include_once("html_header.php");

?>

<h2 class="mt-3" id='hashtag3'>Inject Web3</h2>
<hr/>
<p>
The Chrome plugin Metamask inject a global variable web3 in your browser. You can see it in your console browser, you have this message MetaMask - injected web3 and you can see the web3 object by taping web3 in your console. MetaMask is a proxy between the server side and your browser interface. Your program can see this variable only when it's loading with your browser.
</p>
<div class="table-responsive">
	<table class="table table-bordered">
		<tr><th style='width:5%;'>Variable Name</th><th>Description</th></tr>
		<tr><td>window.ethereum</td><td>Modern ethereum provider. Specified in <a href="https://eips.ethereum.org/EIPS/eip-1102">EIP-1102</a> & <a href="https://eips.ethereum.org/EIPS/eip-1193">EIP-1193</a>.</td></tr>
		<tr><td>window.web3</td><td>Legacy ethereum provider.</td></tr>
	</table>
</div>

<h3 class="mt-3">Web3 Browsers</h3>
<hr/>
	<p>There are a list of web3 browsers that can be used to interact with decentralized application (Dapp):</p>
<hr/>
<ul>
	<li>Meta Mask</li>
	<li>Opera</li>
	<li>Status</li>
	<li>Tenta Browser</li>
	<li>Trust Wallet's Dapp Browser</li>
	<li>Mist Browser (deprecated)</li>
</ul>


<h3 class="mt-3" id='hashtag3'>Access Dapp Via Web3 Browser</h3>
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
		<iframe src="eth_js_access_inject_web3.html?<?php echo time()?>" width="100%" scrolling="no" frameborder="no"></iframe>
	</div>
	<div id="form1_tabitem2" class="tab-pane fade">
<pre style='border-radius:none;'><?php echo htmlentities(file_get_contents("eth_js_access_inject_web3.html")  );vb ?></pre> 		
	</div>
</div>
      
<?php
include_once("html_footer.php");