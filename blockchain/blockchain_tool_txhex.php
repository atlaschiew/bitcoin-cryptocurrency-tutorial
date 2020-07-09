<?php

$_HTML['title'] = 'Blockchain Tx Hex';
$_HTML['meta']['keywords'] = "Blockchain,Blockcypher,Electrum,Tx Hex,Tx Serialization,PHP";

include_once "../common.php";
include_once("html_header.php");

?>
<h2 class="mt-3">Blockchain Tx Hex</h2>
<hr/>
	Final bitcoin transaction always serialized into binary format and represented as hexadecimal for readability. This tool aims to return you serialized transaction based on tx hash.
<hr/>
<h3 class="mt-3" id='hashtag3'>Blockcypher Find Tx Hex</h3>
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
		<iframe src="blockchain_tool_txhex_form.php" width="100%" scrolling="no" frameborder="no"></iframe>
	</div>
	<div id="form1_tabitem2" class="tab-pane fade">
		<pre style='border-radius:none;'><?php
			echo htmlentities(file_get_contents("blockchain_tool_txhex_form.php"));
		?>
		</pre> 		
	</div>
</div>


<h3 class="mt-3" id='hashtag3'>Electrum Find Tx Hex</h3>
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
		<iframe src="blockchain_tool_txhex_form_electrum.php" width="100%" scrolling="no" frameborder="no"></iframe>
	</div>
	<div id="form2_tabitem2" class="tab-pane fade">
		<pre style='border-radius:none;'><?php
			echo htmlentities(safe_electrum_source(file_get_contents("blockchain_tool_txhex_form_electrum.php")));
		?>
		</pre> 		
	</div>
</div>
<?php
include_once("html_footer.php");