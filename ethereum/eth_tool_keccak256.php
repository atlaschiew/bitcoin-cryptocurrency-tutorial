<?php

$_HTML['title'] = 'Ethereum Keccak 256';
$_HTML['meta']['keywords'] = "Ethereum Keccak 256, Ethereum Keccak 256 In PHP";

include_once "../common.php";
include_once("html_header.php");

?>
<h2 class="mt-3">Keccak 256 (Sha 3)</h2>
<hr/>
	Ethereum applied Keccak-256 cryptographic hash function in many places, such as address generation, consensus engine and protocol work.
<hr/>
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
		<iframe src="eth_tool_keccak256_form.php" width="100%" scrolling="no" frameborder="no"></iframe>
	</div>
	<div id="form1_tabitem2" class="tab-pane fade">
		<pre style='border-radius:none;'><?php
			echo htmlentities(file_get_contents("eth_tool_keccak256_form.php"));
		?>
		</pre> 		
	</div>
</div>
<?php
include_once("html_footer.php");