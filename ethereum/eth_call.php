<?php
$_HTML['title'] = 'Eth Call';
$_HTML['meta']['keywords'] = "Eth Call,Eth Call in PHP,PHP";
include_once "../common.php";
include_once("html_header.php");

?>
<h2 class="mt-3">Ethereum Eth Call</h2>
<hr/>
	<p>
	eth_call executes a new message call immediately without creating a transaction on the block chain.
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
		<iframe src="eth_call_form.php" width="100%" scrolling="no" frameborder="no"></iframe>
	</div>
	<div id="form1_tabitem2" class="tab-pane fade">
<pre style='border-radius:none;'><?php echo htmlentities(file_get_contents("eth_call_form.php"));?></pre> 		
	</div>
</div>
<?php
include_once("html_footer.php");