<?php

$_HTML['title'] = 'Tron PHP Client Installation';
$_HTML['meta']['keywords'] = "Tron PHP Client,PHP";

include_once "../common.php";
include_once("html_header.php");

?>
<h2 class="mt-3">Tron PHP Client Installation</h2>

<ul>
	<li>Via composer:<br/>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;composer require iexbase/tron-api<br/>
		
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;composer require google/protobuf<br/>
		
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;composer require kornrunner/keccak<br/>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;composer require bitwasp/bitcoin
		
	</li>
	
</ul>
<h3 class="mt-3">For this tutorial, we are using:</h3>
<ul>
	<li>iexbase/tron-api v3.0</li>
	<li>google/protobuf v4.0.0RC2</li>
	<li>bitwasp/bitcoin v1.0.1</li>
	<li>bitwasp/bech32 v0.0.1</li>
	<li>bitwasp/buffertools v0.5.6</li>
	<li>kornrunner/keccak v1.0.3</li>
</ul>

<h3 class="mt-3">Other Required PHP Scripts:</h3>
<ul>
	<li><a href="show_source.php?file=tron_utils.php">tron_utils.php</a></li>

</ul>
<?php
include_once("html_footer.php");