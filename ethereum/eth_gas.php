<?php
$_HTML['title'] = 'Eth Gas';
$_HTML['meta']['keywords'] = "Eth Gas,Eth Gas in PHP,PHP";
include_once "../common.php";
include_once("html_header.php");

?>
<h2 class="mt-3">Ethereum Gas</h2>


<h3 class="mt-3">Understand Gas</h3>
<table class="table table-bordered table-sm">
    <thead>
      <tr>
        <th style="width:10%;">Terms</th>
        <th>Explaination</th>
        
      </tr>
    </thead>
    <tbody>
		<tr>
        <td>Block Gas Limit</td>
        <td>Blocks also have total gas limits to prevent runaway computation/keep the network decentralized. Up to time, it is 10,000,000 gas.</td>
        
      </tr>
      <tr>
        <td>Gas Limit</td>
        <td>
			<p>Normal transfer eth to <a href="eth_address.php">EOA address</a> always require 21,000 gas limit, but gas limit might be higher for contract function send. Therefore, you can use <a href="#hashtag_estgas">tool</a> to estimate gas limit.</p>
		
			<p>ETH wastage can happen when gas limit is too low thus cause the transaction fail.</p>
		</td>
      </tr>
      <tr>
        <td>Gas Used</td>
        <td>The actual gas amount used by this transaction.</td>
        
      </tr>
      <tr>
        <td>Gas Price</td>
        <td>The price of gas (unit in wei) in this transaction.</td>
        
      </tr>
	  
    </tbody>
  </table>
<hr/>
<h3 class="mt-3" id='hashtag_estgas'>Estimate Gas Limit</h3>
<hr/>
	<p>
	EstimateGas tries to find a minimal gas to run this transaction on the given block number. It do a binary search between 21000 and 'gas limit'. For example, if 'gas limit' is 79000, it tries to run this transaction with the gas limit, 50000 = (21000 + 79000) / 2. If it failed, it tries with 64500 = (50000 + 79000) / 2, and so on. If it failed with 'gas limit', it returns 0 and error message, "gas required exceeds allowance or always failing transaction".
	</p>
	
	<p>
	NOTE: Even if a transaction fails due to non-gas issues, it consider a failure as insufficient gas. Then it will return 0 with an error message in the end.
	</p>
<hr/>
<h4 class="mt-3" id='hashtag3'>infura.io</h4>
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