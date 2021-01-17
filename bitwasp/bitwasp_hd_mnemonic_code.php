<?php

$_HTML['title'] = 'Bitwasp Mnemonic Code (BIP39)';
$_HTML['meta']['keywords'] = "Bitwasp,Bitwasp Mnemonic Code,Bitwasp BIP39,Bitwasp BIP32,PHP Mnemonic Code,PHP BIP39,PHP BIP32";

include_once "../common.php";
include_once("html_header.php");

?>
<h2 class="mt-3">Bitwasp Mnemonic Code (BIP39)</h2>
<hr/>
	Bitcoin private key either in hex or wif is hard to memory. Mnemonic code overcome this by given better entropy with at least 12 human readable words. This 12 words will then convert into seed for generation of hierarchical deterministic (HD) wallet. 
	
<hr/>
<ul>
	<li>At least 12 words, could be lower than it but lead to low entropy and therefore easy guess by attacker.</li>
	<li>Can accept different language.</li>
</ul>
<h3 class="mt-3">BIP32</h3>
<hr/>
	Deprecated. First version of HD wallet generation method with ability of hierarchical-like wallet structure generation become possible, where a group of addresses actually derive from a single seed.
<hr/>
<ul>
	<li>Storage saving, since application only store a single seed.</li>
	<li>Convenience, for each new private key, create, backup and secure are not required.</li>
	<li>Standard derivation path: m/0'/0'/k' (m/wallet account/wallet chain/address index).</li>
</ul>
<h3 class="mt-3" id='hashtag3'>Find Mnemonic & Derivation</h3>
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
		<iframe src="bitwasp_hd_mnemonic_code_form.php" width="100%" scrolling="no" frameborder="no"></iframe>
	</div>
	<div id="form1_tabitem2" class="tab-pane fade">
		<pre style='border-radius:none;'><?php
			echo htmlentities(file_get_contents("bitwasp_hd_mnemonic_code_form.php"));
		?>
		</pre> 		
	</div>
</div>

<?php
include_once("html_footer.php");