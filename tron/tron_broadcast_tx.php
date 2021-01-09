<?php
$_HTML['title'] = 'Tron Broadcast Transaction';
$_HTML['meta']['keywords'] = "Tron Broadcast Transaction,Tron Broadcast Transaction In PHP,PHP";
include_once "../common.php";
include_once("html_header.php");

?>
<h2 class="mt-3">Tron Broadcast Transaction</h2>
<hr/>
	<p>
	Broadcast raw transaction to TRON network.
	</p>
	
<hr/>


<h3 class="mt-3" id='hashtag3'>Broadcast Raw Tx</h3>
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
		<iframe src="tron_broadcast_tx_form.php" width="100%" scrolling="no" frameborder="no"></iframe>
	</div>
	<div id="form1_tabitem2" class="tab-pane fade">
<pre style='border-radius:none;'><?php echo htmlentities(file_get_contents("tron_broadcast_tx_form.php"));?></pre> 		
	</div>
	
</div>


<?php
include_once("html_footer.php");