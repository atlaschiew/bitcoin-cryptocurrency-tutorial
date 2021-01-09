<?php
$_HTML['title'] = 'Tron Get Account Resources';
$_HTML['meta']['keywords'] = "Tron Get Account Resources,Tron Get Account Resources In PHP,PHP";
include_once "../common.php";
include_once("html_header.php");

?>
<h2 class="mt-3">Tron Get Account Resources</h2>
<hr/>
	<p>
		Query the resource information of an account (bandwidth & energy).
	</p>
	
<hr/>


<h3 class="mt-3" id='hashtag3'>Get Account Resources</h3>
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
		<iframe src="tron_account_resources_form.php" width="100%" scrolling="no" frameborder="no"></iframe>
	</div>
	<div id="form1_tabitem2" class="tab-pane fade">
<pre style='border-radius:none;'><?php echo htmlentities(file_get_contents("tron_account_resources_form.php"));?></pre> 		
	</div>
	
</div>


<?php
include_once("html_footer.php");