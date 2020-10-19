<?php
$_HTML['title'] = 'Eth Gas';
$_HTML['meta']['keywords'] = "Eth Gas,Eth Gas in PHP,PHP";
include_once "../common.php";
include_once("html_header.php");



?>
<h2 class="mt-3">Recursive Length Prefix (RLP)</h2>


<hr/>
<h4 class="mt-3" id='hashtag3'>RLP Encoder</h4>
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
		<iframe src="eth_rlp_encoder.php" width="100%" scrolling="no" frameborder="no"></iframe>
	</div>
	<div id="form1_tabitem2" class="tab-pane fade">
<pre style='border-radius:none;'><?php echo htmlentities(file_get_contents("eth_rlp_encoder.php"));?></pre> 		
	</div>
</div>
<?php
include_once("html_footer.php");