<?php

$_HTML['title'] = 'Bitwasp Verify Script';
$_HTML['meta']['keywords'] = "Bitwasp,Verify Script,Bitwasp Tool,PHP";

include_once "../common.php";
include_once("html_header.php");

?>
<h2 class="mt-3">Bitwasp Verify Script</h2>
<hr/>
	In this page, you can verify is your scriptSig (unlock script) able to unlock UTXO's ScriptPubKey (lock script). Bitcoin script contains OP_CHECKSIG, OP_CHECKSIGVERIFY, OP_CHECKMULTISIG or OP_CHECKMULTISIGVERIFY is not able to verify because we are using dummy transaction as you can see in coding tab.
<hr/>

<h3 class="mt-3" id='hashtag3'>Verification</h3>
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
		<iframe id="iframe_verify_form" src="bitwasp_tool_verify_script_form.php" width="100%" scrolling="no" frameborder="no"></iframe>
	</div>
	<div id="form1_tabitem2" class="tab-pane fade">
		<pre style='border-radius:none;'><?php
			echo htmlentities(file_get_contents("bitwasp_tool_verify_script_form.php"));
		?>
		</pre> 		
	</div>
</div>

<h3 class="mt-3" id='hashtag3'>Samples</h3>
<h6 class="mt-3">Simple Math Script</h6>
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
		<iframe src="bitwasp_tool_verify_script_math.php" width="100%" scrolling="no" frameborder="no"></iframe>
	</div>
	<div id="form2_tabitem2" class="tab-pane fade">
		<pre style='border-radius:none;'><?php
			echo htmlentities(file_get_contents("bitwasp_tool_verify_script_math.php"));
		?>
		</pre> 		
	</div>
</div>

<h6 class="mt-3">Simple Hashlock Script</h6>
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
		<iframe src="bitwasp_tool_verify_script_hashlock.php" width="100%" scrolling="no" frameborder="no"></iframe>
	</div>
	<div id="form3_tabitem2" class="tab-pane fade">
		<pre style='border-radius:none;'><?php
			echo htmlentities(file_get_contents("bitwasp_tool_verify_script_hashlock.php"));
		?>
		</pre> 		
	</div>
</div>

<script>
	function moveData(value, targetIframeID, inputID) {
		
		var targetInput = $("iframe#"+targetIframeID).contents().find("input#"+inputID)
		targetInput.val(value);
		setTimeout(function() { targetInput.focus(); }, 300);
		
	}
</script>
<?php
include_once("html_footer.php");