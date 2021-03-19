<?php

$_HTML['title'] = 'Bitcoin Cancel Tx';
$_HTML['meta']['keywords'] = "Bitcoin Cancel Tx,PHP Bitcoin Cancel Tx";

include_once "../common.php";
include_once("html_header.php");

?>
<h2 class="mt-3">Bitcoin Cancel Transaction</h2>
<hr/>
	<p>
	The trick to “cancel” your pending transaction is by replacing the transaction with BTC amount send back to yourself but with higher transaction fees. 
	
	</p>
	
	<p>
	This is useful also when your transaction stuck in mempool. Replace it with new transaction with higher transaction fees.
	</p>
	
	<p>
	Theorically you just have around 10 minutes interval to carry out this action before transaction comfirmation turn to 1.
	</p>
	
<hr/>

<h3 class="mt-3">Enable opt-in RBF (replace by fees)</h3>
<p>
	nSequence in any input with value of &lt;= 0xfffffffd will enable RBF.
</p>

<h6>$tx->input(...)</h6>
<pre style='border-radius:none;'>
$tx = $tx->input($utxo_hash, $utxo_n_output, null, 4294967293);
</pre> 

<h6>$tx->spendOutputFrom(...)</h6>
<pre style='border-radius:none;'>
$tx = $tx->spendOutputFrom($utxo_hash, $utxo_n_output, null, 4294967293);
</pre> 
<p>
Above codings nSequence 4294967293 equal to 0xfffffffd.
</p>


<?php
include_once("html_footer.php");