<?php
$_HTML['title'] = 'Abi Data Encoding';
$_HTML['meta']['keywords'] = "Abi Data Encoding PHP,Abi PHP";
include_once "../common.php";
include_once("html_header.php");

?>
<h2 class="mt-3">Abi Data Encoding</h2>
<hr/>
	<p>
		ABI stands for application binary interface, it is the standard way to interact with contracts in the Ethereum ecosystem, both from outside the blockchain and for contract-to-contract interaction. 
	</p>
	<p>
		Data is encoded according to its type.
	</p>

<hr/>

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
		<iframe src="eth_abi_data_encoding_form.php" width="100%" scrolling="no" frameborder="no"></iframe>
	</div>
	<div id="form1_tabitem2" class="tab-pane fade">
<pre style='border-radius:none;'><?php echo htmlentities(file_get_contents("eth_abi_data_encoding_form.php"));?></pre> 		
	</div>
</div>
<?php
include_once("html_footer.php");