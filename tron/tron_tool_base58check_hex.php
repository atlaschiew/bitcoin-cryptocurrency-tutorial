<?php

$_HTML['title'] = 'Tron Tool Base58check To Hex';
$_HTML['meta']['keywords'] = "Tron,PHP,Base58check To Hex";

include_once "../common.php";
include_once("html_header.php");

?>
<h2 class="mt-3">Base58check Hex Conversion</h2>
<hr/>
	Address conversion usage.
<hr/>

<h3 class="mt-3" id='hashtag3'>Base58check To Hex</h3>
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
		<iframe src="tron_tool_base58check2hex_form.php" width="100%" scrolling="no" frameborder="no"></iframe>
	</div>
	<div id="form1_tabitem2" class="tab-pane fade">
		<pre style='border-radius:none;'><?php
			echo htmlentities(file_get_contents("tron_tool_base58check2hex_form.php"));
		?>
		</pre> 		
	</div>
</div>


<h3 class="mt-3" id='hashtag3'>Hex To Base58check</h3>
<ul class="nav nav-tabs">
	<li class="nav-item">
		<a data-toggle="tab" class="nav-link active" href="#form2_tabitem1">Visual</a>
	</li>
	<li class="nav-item">
		<a data-toggle="tab" class="nav-link" href="#form2_tabitem2">Coding</a>
	</li>
</ul>

<div class="tab-content">
	<div id="form2_tabitem1" class="tab-pane fade show active">
		<iframe src="tron_tool_hex2base58check_form.php" width="100%" scrolling="no" frameborder="no"></iframe>
	</div>
	<div id="form2_tabitem2" class="tab-pane fade">
		<pre style='border-radius:none;'><?php
			echo htmlentities(file_get_contents("tron_tool_hex2base58check_form.php"));
		?>
		</pre> 		
	</div>
</div>
<?php
include_once("html_footer.php");