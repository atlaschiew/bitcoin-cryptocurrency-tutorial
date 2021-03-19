<?php

$_HTML['title'] = 'Bitwasp Install';
$_HTML['meta']['keywords'] = "Bitwasp,Install,PHP";

include_once "../common.php";
include_once("html_header.php");

?>
<h2 class="mt-3">Bitwasp Installation</h2>

<ul>
	<li>Via composer: composer require bitwasp/bitcoin</li>
	
</ul>
<h3 class="mt-3">For this tutorial, we are using:</h3>
<ul>
	<li>bitwasp/bitcoin v1.0.1</li>
	<li>bitwasp/bech32 v0.0.1</li>
	<li>bitwasp/buffertools v0.5.6</li>
</ul>

<?php
include_once("html_footer.php");