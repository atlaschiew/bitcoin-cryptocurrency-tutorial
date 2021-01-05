<?php
include_once "../common.php";
include_once("html_header.php");

?>
<h2 class="mt-3">Private Key</h2>
<hr/>
	Private key is result of random generation and it is big numbers. Private key can derive public key and it must be known only by owner otherwise your bitcoin amount will be stolen by others.
<hr/>
<ul>
	<li>Always 32 bytes long.</li>
	
</ul>

<h2 class="mt-3">Public Key</h2>
<hr/>
	Public key derived from private key. In turn, public can drive address.
<hr/>
<ul>
	<li>Always 65 bytes long for uncompressed public key.</li>
	<li>Always 33 bytes long for compressed public key.</li>
	<li>In hex representation. Value 0x02 and 0x03 are meant to compressed version while 0x04 is meant to uncompressed version.</li>
</ul>

<small>* Please note that length in byte mentioned above is all meant to binary data. However, in hex representation, you have to times 2. e.g, 32 bytes long in hex presentation is 64 bytes.</small>
<?php
include_once("html_footer.php");