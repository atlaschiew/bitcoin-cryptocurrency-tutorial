<?php
$_HTML['title'] = 'Ethereum Deploy Contract';
$_HTML['meta']['keywords'] = "Ethereum Deploy Contract,Btcschools Deploy Contract In PHP,PHP";
include_once "../common.php";
include_once("html_header.php");

?>
<h2 class="mt-3">Ethereum Deploy Contract</h2>
<hr/>
	<p>
		Deployment of contract just push like normal ETH transaction but with few difference. 
		
		
		<ul>
			<li>Empty in <b>To</b>.</li>	
			<li>Empty in ETH <b>Value</b> unless contract's constructor require it.</li>
			<li>Put compiled bytecode in <b>Data (Hex)</b> .</li>
		</ul>
		
	</p>
	
	
<hr/>


<h3 class="mt-3" id='hashtag3'>Raw Tx Generator</h3>
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
		<iframe src="../ethereum/eth_tx_form.php?<?php echo $_SERVER['QUERY_STRING']?>" width="100%" scrolling="no" frameborder="no"></iframe>
	</div>
	<div id="form1_tabitem2" class="tab-pane fade">
<pre style='border-radius:none;'><?php echo htmlentities(file_get_contents("../ethereum/eth_tx_form.php"));?></pre> 		
	</div>
</div>	
	

<?php
include_once("html_footer.php");