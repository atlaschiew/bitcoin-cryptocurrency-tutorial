<?php
$_HTML['title'] = 'Tron Address';
$_HTML['meta']['keywords'] = "Tron Address,Tron Address in PHP,PHP";
include_once "../common.php";
include_once("html_header.php");

?>
<h2 class="mt-3">Tron Address</h2>
<hr/>
	<p>
	Tron address
	</p>
	
<hr/>
<ul>
	<li>Start with 'T' or 41 in hex string representation.</li>
	
</ul>

<h3 class="mt-3" id='hashtag3'>Tron Address Generate Locally</h3>
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
		<iframe src="tron_address_form.php" width="100%" scrolling="no" frameborder="no"></iframe>
	</div>
	<div id="form1_tabitem2" class="tab-pane fade">
<pre style='border-radius:none;'><?php echo htmlentities(file_get_contents("tron_address_form.php"));?></pre> 		
	</div>
</div>


<?php
include_once("html_footer.php");