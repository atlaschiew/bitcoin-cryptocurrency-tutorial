<?php
$_HTML['title'] = 'Eth Bloom Filter';
$_HTML['meta']['keywords'] = "Eth Bloom Filter,Eth Bloom Filter in PHP";
include_once "../common.php";
include_once("html_header.php");

?>
<h2 class="mt-3">Ethereum Bloom Filter</h2>
<hr/>
	<p>
		Bloom Filter is probabilistic and space saving data structure used for quick query. Ethereum applied this to search for existence of log item within a block or a transaction receipt. 
	</p>
	<p>
		Search result of Bloom Filter could be false positive, which mean item possibly in storage, to meet accurancy, further check is required. 
	</p>
	
	<p>
		Cool thing is it guarantees false negative won't happen, which mean item not found absolutely won't exist. 
	</p>
	
	<p>
		In conclusion, we say that Bloom Filter aims to gain performance over accurancy.
	</p>
<hr/>
<ul>
	<li>Storage size is 2048 bits or 256 bytes.</li>
	<li>Each insert item consume 3 bits in storage.</li>
	
</ul>

<h3 class="mt-3" id='hashtag1'>Generate logsBloom</h3>
<div class="table-responsive">
	<table class="table table-bordered">
		<tr><th style='width:20%;'>logsBloom in</th><th>Items To Insert</th></tr>
		<tr>
			<td>Transaction Receipt</td>
			<td>Fill in address, topics[0], topics[1] and topics[3] from each log. You may call <a href="eth_json_rpc.php?method=eth_getTransactionReceipt&params=" target="_blank">eth_getTransactionReceipt</a> for this.</td>
		</tr>
		<tr>
			<td>Block</td>
			<td>Fill in each details of transaction receipt within the block. You may call <a href="eth_json_rpc.php?method=eth_getBlockByNumber&params=" target="_blank">eth_getBlockByNumber</a> for this.</td>
		</tr>
	</table>
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
		<iframe src="eth_bloom_filter_form.php?type=generate" width="100%" scrolling="no" frameborder="no"></iframe>
	</div>
	<div id="form1_tabitem2" class="tab-pane fade">
<pre style='border-radius:none;'><?php echo htmlentities(file_get_contents("eth_bloom_filter_form.php"));?></pre> 		
	</div>
</div>


<h3 class="mt-3" id='hashtag1'>Search Item</h3>
<ul class="nav nav-tabs">
	<li class="nav-item">
		<a data-toggle="tab" class="nav-link active" href="#form2_tabitem1">Visual</a>
	</li>
	<li class="nav-item">
		<a data-toggle="tab" class="nav-link" href="#form2_tabitem2">Coding</a>
	</li>
</ul>
<div class="tab-content">
	<div id="form2_tabitem1" class="tab-pane fade show active">
		<iframe src="eth_bloom_filter_form.php?type=search" width="100%" scrolling="no" frameborder="no"></iframe>
	</div>
	<div id="form2_tabitem2" class="tab-pane fade">
<pre style='border-radius:none;'><?php echo htmlentities(file_get_contents("eth_bloom_filter_form.php"));?></pre> 		
	</div>
</div>
<?php
include_once("html_footer.php");