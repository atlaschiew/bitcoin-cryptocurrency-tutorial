<?php

$_HTML['title'] = 'Bitcoin HASH160';
$_HTML['meta']['keywords'] = "Bitcoin,HASH160,Bitcoin Tool,PHP";

include_once "../common.php";
include_once("html_header.php");

?>
<h2 class="mt-3">Bitcoin HASH160</h2>
<hr/>
	The HASH160(Public Key) is a hashed version of your public key. It’s also neccessary steps to carry out in midst of BASE58 address generation. Please refer to <a href='https://en.bitcoin.it/wiki/Technical_background_of_version_1_Bitcoin_addresses' target='_blank'>Technical background of version 1 Bitcoin addresses.</a>
<hr/>
<ul>
	<li>Behind the scene, HASH160 = RIPEMD160(SHA256($publicKey))</li>
	<li>Compare to give out public key directly, hash160 provide extra security and size shorten for relay efficiency.
</ul>
<h3 class="mt-3" id='hashtag3'>Find HASH160</h3>
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
		<iframe src="bitcoin_tool_hash160_form.php" width="100%" scrolling="no" frameborder="no"></iframe>
	</div>
	<div id="form1_tabitem2" class="tab-pane fade">
		<pre style='border-radius:none;'><?php
			echo htmlentities(file_get_contents("bitcoin_tool_hash160_form.php"));
		?>
		</pre> 		
	</div>
</div>
<?php
include_once("html_footer.php");