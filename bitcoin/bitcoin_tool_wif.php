<?php
$_HTML['title'] = 'Bitcoin WIF';
$_HTML['meta']['keywords'] = "Bitcoin,WIF,Wallet Import Format,Bitcoin Tool,PHP";

include_once "../common.php";
include_once("html_header.php");

?>
<h2 class="mt-3">Bitcoin WIF</h2>
<hr/>
	Wallet Import Format (WIF, also known as Wallet Export Format) is a way of BASE58 encoding a private ECDSA key so as to make it easier to copy. <a href="https://en.bitcoin.it/wiki/Wallet_import_format" target="_blank">https://en.bitcoin.it/wiki/Wallet_import_format</a>
<hr/>
<h3 class="mt-3" id='hashtag3'>Find WIF From Private Key</h3>
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
		<iframe src="bitcoin_tool_wif_privkey2wif_form.php" width="100%" scrolling="no" frameborder="no"></iframe>
	</div>
	<div id="form1_tabitem2" class="tab-pane fade">
		<pre style='border-radius:none;'><?php
			echo htmlentities(file_get_contents("bitcoin_tool_wif_privkey2wif_form.php"));
		?>
		</pre> 		
	</div>
</div>


<h3 class="mt-3" id='hashtag3'>Find Private Key From WIF</h3>
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
		<iframe src="bitcoin_tool_wif_wif2privkey_form.php" width="100%" scrolling="no" frameborder="no"></iframe>
	</div>
	<div id="form2_tabitem2" class="tab-pane fade">
		<pre style='border-radius:none;'><?php
			echo htmlentities(file_get_contents("bitcoin_tool_wif_wif2privkey_form.php"));
		?>
		</pre> 		
	</div>
</div>
<?php
include_once("html_footer.php");