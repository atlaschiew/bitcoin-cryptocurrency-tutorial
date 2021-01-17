<?php

$_HTML['title'] = 'Bitwasp Derivation Path';
$_HTML['meta']['keywords'] = "Bitwasp Derivation Path,PHP Derivation Path,PHP BIP44,BIP49,BIP84";

include_once "../common.php";
include_once("html_header.php");

?>
<h2 class="mt-3">Bitwasp Derivation Path</h2>
<hr/>
	The cool thing about extended keys is that they can derive children, and these child keys can derive more children, and so on. This allows you to create a tree of extended keys, with each key having its own unique derivation path from the master key.
<hr/>
<table class="table table-bordered">
	<tr><th style='width:5%;'>Notation</th><th>Description</th></tr>
	<tr><td>/</td><td>Indicate a new branch with number of new child.</td></tr>
	<tr><td>'</td><td>Hardened Child means that no new child can be derived by extended public key, unless you derived from extended private key. Index range from 2147483648 to 4294967296.</td></tr>
	<tr><td>without '</td><td>Normal Child is the inverse of Hardened Child. Index range from 0 to 2147483647.</td></tr>
</table>

<h3 class="mt-3" id='hashtag1'>Derive From Extended Private Key</h3>
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
		<iframe src="bitwasp_hd_extended_xpriv_form.php" width="100%" scrolling="no" frameborder="no"></iframe>
	</div>
	<div id="form1_tabitem2" class="tab-pane fade">
		<pre style='border-radius:none;'><?php
			echo htmlentities(file_get_contents("bitwasp_hd_extended_xpriv_form.php"));
		?>
		</pre> 		
	</div>
</div>

<h3 class="mt-3" id='hashtag1'>Address Array From Xpub</h3>
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
		<iframe src="bitwasp_hd_xpub_address_array_form.php" width="100%" scrolling="no" frameborder="no"></iframe>
	</div>
	<div id="form1_tabitem2" class="tab-pane fade">
		<pre style='border-radius:none;'><?php
			echo htmlentities(file_get_contents("bitwasp_hd_xpub_address_array_form.php"));
		?>
		</pre> 		
	</div>
</div>
<?php
include_once("html_footer.php");