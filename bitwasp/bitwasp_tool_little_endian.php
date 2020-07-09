<?php

$_HTML['title'] = 'Bitwasp Little-Endian';
$_HTML['meta']['keywords'] = "Bitwasp,Little-Endian,Little Endian,Bitwasp Tool,PHP";

include_once "../common.php";
include_once("html_header.php");

?>
<h2 class="mt-3">Bitwasp Little-Endian</h2>
<hr/>
	Reading of little-endian is not friendly to human but friendly to computer. Most of fields in serialized transaction are in little-endian format.
<hr/>

<h3 class="mt-3" id='hashtag3'>Find Little-Endian</h3>
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
		<iframe src="bitwasp_tool_little_endian_form.php" width="100%" scrolling="no" frameborder="no"></iframe>
	</div>
	<div id="form1_tabitem2" class="tab-pane fade">
		<pre style='border-radius:none;'><?php
			echo htmlentities(file_get_contents("bitwasp_tool_little_endian_form.php"));
		?>
		</pre> 		
	</div>
</div>
<?php
include_once("html_footer.php");