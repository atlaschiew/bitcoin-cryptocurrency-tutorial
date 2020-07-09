<?php

$_HTML['title'] = 'Blockchain UTXO';
$_HTML['meta']['keywords'] = "Blockchain,UTXO,Unspent Transaction Output,PHP";

include_once "../common.php";
include_once("html_header.php");

?>
<h2 class="mt-3">Blockchain UTXO</h2>
<hr/>

	Unspent transaction outputs (UTXOs) is created when new transaction is stored in blockchain and as its name mean to, these outputs are haven't spent. To spend, UTXO is required and must fill in as input of new transaction, once new transaction stores in blockchain, this fill in UTXO will be removed from database and new UTXO will be created. From block to block, transaction to transaction, this process starts over and over again.

<hr/>
<h3 class="mt-3" id='hashtag3'>Blockcypher Find UTXO</h3>
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
		<iframe src="blockchain_tool_utxo_form.php" width="100%" scrolling="no" frameborder="no"></iframe>
	</div>
	<div id="form1_tabitem2" class="tab-pane fade">
		<pre style='border-radius:none;'><?php
			echo htmlentities(file_get_contents("blockchain_tool_utxo_form.php"));
		?>
		</pre> 		
	</div>
</div>


<h3 class="mt-3" id='hashtag3'>Electrum Find UTXO</h3>
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
		<iframe src="blockchain_tool_utxo_form_electrum.php" width="100%" scrolling="no" frameborder="no"></iframe>
	</div>
	<div id="form2_tabitem2" class="tab-pane fade">
		<pre style='border-radius:none;'><?php
			echo htmlentities(safe_electrum_source(file_get_contents("blockchain_tool_utxo_form_electrum.php")));
		?>
		</pre> 		
	</div>
</div>
<?php
include_once("html_footer.php");