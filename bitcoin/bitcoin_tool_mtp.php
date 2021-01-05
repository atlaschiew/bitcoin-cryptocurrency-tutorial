<?php

$_HTML['title'] = 'Bitcoin Median Time Past';
$_HTML['meta']['keywords'] = "Bitcoin,Median Time Past,MTP,PHP";

include_once "../common.php";
include_once("html_header.php");

?>
<h2 class="mt-3">Bitcoin Median Time Past</h2>
<hr/>
	From block to block, block time is not always in order. To solve this time order problem, Median Time Past (MTP) has been introduced. Practically, to find MTP of particular block, you have to find median of sorted block time of previous 11 blocks of that particular block.
<hr/>

<h3 class="mt-3" id='hashtag3'>Blockcypher Find Median Time Past</h3>
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
		<iframe src="bitcoin_tool_mtp_form.php" width="100%" scrolling="no" frameborder="no"></iframe>
	</div>
	<div id="form1_tabitem2" class="tab-pane fade">
		<pre style='border-radius:none;'><?php
			echo htmlentities(file_get_contents("bitcoin_tool_mtp_form.php"));
		?>
		</pre> 		
	</div>
</div>
<?php
include_once("html_footer.php");