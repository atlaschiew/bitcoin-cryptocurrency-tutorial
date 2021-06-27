<?php
$_HTML['title'] = 'Bitcoin ECDSA Signature';
$_HTML['meta']['keywords'] = "Bitcoin ECDSA Signature,Bitcoin DER Signature,RS Signature,Distinguished Encoding Rules,Bitcoin Tool,PHP";

include_once "../common.php";
include_once("html_header.php");

?>
<h2 class="mt-3">Bitcoin ECDSA Signature</h2>
<hr/>
	<p>
	A signature in Bitcoin (as used to sign transactions inside scriptSigs and scriptWitnesses), consists of a DER encoding of an ECDSA signature, plus a sighash type byte.
	</p>

	<p>
	It is required when dealing with script opcodes such as OP_CHECKSIG, OP_CHECKSIGVERIFY, OP_CHECKMULTISIG & OP_CHECKMULTISIGVERIFY.
	</p>
<hr/>
<h3 class="mt-3" id='hashtag1'>Generate ECDSA Signature</h3>
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
		<iframe src="bitcoin_tool_ecdsa_form.php" width="100%" scrolling="no" frameborder="no"></iframe>
	</div>
	<div id="form1_tabitem2" class="tab-pane fade">
		<pre style='border-radius:none;'><?php
			echo htmlentities(file_get_contents("bitcoin_tool_ecdsa_form.php"));
		?>
		</pre> 		
	</div>
</div>

<?php
include_once("html_footer.php");