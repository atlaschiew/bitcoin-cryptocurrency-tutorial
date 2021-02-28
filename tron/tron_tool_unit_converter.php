<?php

$_HTML['title'] = 'Tron Unit Converter';
$_HTML['meta']['keywords'] = "Tron,Unit Converter,PHP Tron Unit Converter";

include_once "../common.php";
include_once("html_header.php");

?>
<h2 class="mt-3">Tron Unit Converter</h2>
<hr/>
	Unit conversion between TRX and SUN.
<hr/>

<h3 class="mt-3" id='hashtag3'>Unit Converter</h3>
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
		<iframe src="tron_tool_unit_converter_form.php" width="100%" scrolling="no" frameborder="no"></iframe>
	</div>
	<div id="form1_tabitem2" class="tab-pane fade">
		<pre style='border-radius:none;'><?php
			echo htmlentities(file_get_contents("tron_tool_unit_converter_form.php"));
		?>
		</pre> 		
	</div>
</div>
<?php
include_once("html_footer.php");