<?php
$_HTML['title'] = 'Bitcoin DER Signature';
$_HTML['meta']['keywords'] = "Bitcoin,DER Signature,Distinguished Encoding Rules,Bitcoin Tool,PHP";

include_once "../common.php";
include_once("html_header.php");

?>
<h2 class="mt-3">Bitcoin DER Signature</h2>
<hr/>
	Distinguished Encoding Rules (DER) signature is required when dealing with script opcodes such as OP_CHECKSIG, OP_CHECKSIGVERIFY, OP_CHECKMULTISIG & OP_CHECKMULTISIGVERIFY.
<hr/>

<h3 class="mt-3" id='hashtag3'>Find DER Signature</h3>
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
		<iframe src="bitcoin_tool_dersign_form.php" width="100%" scrolling="no" frameborder="no"></iframe>
	</div>
	<div id="form1_tabitem2" class="tab-pane fade">
		<pre style='border-radius:none;'><?php
			echo htmlentities(file_get_contents("bitcoin_tool_dersign_form.php"));
		?>
		</pre> 		
	</div>
</div>

<?php
include_once("html_footer.php");