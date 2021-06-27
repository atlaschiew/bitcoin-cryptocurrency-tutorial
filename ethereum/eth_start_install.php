<?php

$_HTML['title'] = 'Ethereum PHP Client Installation';
$_HTML['meta']['keywords'] = "Ethereum PHP Client,PHP";

include_once "../common.php";
include_once("html_header.php");

?>
<h2 class="mt-3">Ethereum PHP Client Installation</h2>

<ul>
	<li>Via composer:<br/>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;composer require bitwasp/bitcoin<br/>
		
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;composer require kornrunner/keccak<br/>
		
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;composer require furqansiddiqui/erc20-php
		
	</li>
	
</ul>
<h3 class="mt-3">For this tutorial, we are using:</h3>
<ul>
	<li>bitwasp/bitcoin v1.0.1</li>
	<li>bitwasp/bech32 v0.0.1</li>
	<li>bitwasp/buffertools v0.5.6</li>
	<li>kornrunner/keccak v1.0.3</li>
	<li>kornrunner/ethereum-offline-raw-tx v0.2.3</li>
	<li>furqansiddiqui/erc20-php v0.1.4</li>
</ul>


<h3 class="mt-3">Other Required Scripts:</h3>

<ul class="nav nav-tabs">
	<li class="nav-item">
		<a data-toggle="tab" class="nav-link active" href="#form1_tabitem1">PHP</a>
	</li>
	<li class="nav-item">
		<a data-toggle="tab" class="nav-link" href="#form1_tabitem2">Go</a>
	</li>
</ul>
<div class="tab-content">
	<div id="form1_tabitem1" class="tab-pane fade show active">
		<p>
			<ul>
				<li><a href="show_source.php?file=eth_utils.php">eth_utils.php</a></li>
				<li><a href="show_source.php?file=../libraries/bcbitwise.php">bcbitwise.php</a></li>
			</ul>
		</p>
	</div>
	<div id="form1_tabitem2" class="tab-pane fade">
		<p>
			<ul>
				<li><a href="show_source.php?file=go/main.go">go/main.go</a></li>
				<li><a href="show_source.php?file=go/eth_utils.go">go/eth_utils.go</a></li>
			</ul>
		</p>
	</div>
</div>

<?php
include_once("html_footer.php");