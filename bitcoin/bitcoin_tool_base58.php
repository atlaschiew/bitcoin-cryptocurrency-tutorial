<?php

$_HTML['title'] = 'Bitcoin Base58';
$_HTML['meta']['keywords'] = "Bitcoin,Base58,Bitcoin Tool,PHP";

include_once "../common.php";
include_once("html_header.php");

?>
<h2 class="mt-3">Bitcoin Base58</h2>
<hr/>
	Base58 provides compressed version of data for relay and storage efficiency.
<hr/>
<ul>
	<li>Behind the scene, SHA256D = SHA256(SHA256($string))</li>
	<li>Usage 1: <a href='https://en.bitcoin.it/wiki/Wallet_import_format' target='_blank'>WIF (Private Key)</a> generation.</li>
	<li>Usage 2: <a href='https://en.bitcoin.it/wiki/Technical_background_of_version_1_Bitcoin_addresses'>P2PKH</a> & P2SH address generation.</li>
</ul>
<h3 class="mt-3" id='hashtag3'>Base85 encode</h3>
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
		<iframe src="bitcoin_tool_base85encode_form.php" width="100%" scrolling="no" frameborder="no"></iframe>
	</div>
	<div id="form2_tabitem2" class="tab-pane fade">
		<pre style='border-radius:none;'><?php
			echo htmlentities(file_get_contents("bitcoin_tool_base85encode_form.php"));
		?>
		</pre> 		
	</div>
</div>
<h3 class="mt-3" id='hashtag3'>Base85 decode</h3>
<ul class="nav nav-tabs">
	<li class="nav-item">
		<a data-toggle="tab" class="nav-link active" href="#form3_tabitem1">Visual</a>
	</li>
	<li class="nav-item">
		<a data-toggle="tab" class="nav-link" href="#form3_tabitem2">Coding</a>
	</li>
</ul>

<div class="tab-content">
	<div id="form3_tabitem1" class="tab-pane fade show active">
		<iframe src="bitcoin_tool_base85decode_form.php" width="100%" scrolling="no" frameborder="no"></iframe>
	</div>
	<div id="form3_tabitem2" class="tab-pane fade">
		<pre style='border-radius:none;'><?php
			echo htmlentities(file_get_contents("bitcoin_tool_base85decode_form.php"));
		?>
		</pre> 		
	</div>
</div>

<h3 class="mt-3" id='hashtag3'>Base85 encodeCheck</h3>
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
		<iframe src="bitcoin_tool_base85encodecheck_form.php" width="100%" scrolling="no" frameborder="no"></iframe>
	</div>
	<div id="form1_tabitem2" class="tab-pane fade">
		<pre style='border-radius:none;'><?php
			echo htmlentities(file_get_contents("bitcoin_tool_base85encodecheck_form.php"));
		?>
		</pre> 		
	</div>
</div>
<?php
include_once("html_footer.php");