<?php
$_HTML['title'] = 'Tron Get Transaction Info';
$_HTML['meta']['keywords'] = "Tron Get Transaction Info,Tron Get Transaction Info In PHP,PHP";
include_once "../common.php";
include_once("html_header.php");

?>
<h2 class="mt-3">Tron Get Transaction Info</h2>
<hr/>
	<p>
		Retrieve transaction info and display in human readable form for ease of read.
	</p>
<hr/>

<h3 class="mt-3" id='hashtag3'>Get Transaction Info</h3>
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
		<iframe src="tron_get_tx_info_form.php" width="100%" scrolling="no" frameborder="no"></iframe>
	</div>
	<div id="form1_tabitem2" class="tab-pane fade">
<pre style='border-radius:none;'><?php echo htmlentities(file_get_contents("tron_get_tx_info_form.php"));?></pre> 		
	</div>
	
</div>


<?php
include_once("html_footer.php");