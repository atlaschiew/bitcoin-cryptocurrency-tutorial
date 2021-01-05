<?php

$_HTML['title'] = 'Bitcoin Cli, Bitcoin CLI Find Blockchain';
$_HTML['meta']['keywords'] = "Blockchain,Bitcoin CLI,Blocks";

include_once "../common.php";
include_once("html_header.php");

?>
<h2 class="mt-3">Bitcoin's Blockchain</h2>
<hr/>
	Blockhain is type of distributed database that store number of blocks to form a chain.
<hr/>
<ul>
	<li>Distributed database.</li>
	<li>Consists number of blocks, each block stores number of data.</li>
	<li>Blocks linked up each other by hash.</li>
</ul>

<h3 class="mt-3" id='hashtag3'>Bitcoin-CLI Find Blockchain Stats</h3>
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
		<iframe src="bitcoin_statform_bitcoincli.php" width="100%" scrolling="no" frameborder="no"></iframe>
	</div>
	<div id="form1_tabitem2" class="tab-pane fade">
		<pre style='border-radius:none;'><?php
			echo htmlentities(safe_bitcoincli_source(file_get_contents("bitcoin_statform_bitcoincli.php")));
		?>
		</pre> 		
	</div>
</div>
<h3 class="mt-3" id='hashtag3'>Bitcoin-CLI Find Blockchain</h3>
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
		<iframe src="bitcoin_form_bitcoincli.php" width="100%" scrolling="no" frameborder="no"></iframe>
	</div>
	<div id="form2_tabitem2" class="tab-pane fade">
		<pre style='border-radius:none;'><?php
			echo htmlentities(safe_bitcoincli_source(file_get_contents("bitcoin_form_bitcoincli.php")));
		?>
		</pre> 		
	</div>
</div>
<?php
include_once("html_footer.php");