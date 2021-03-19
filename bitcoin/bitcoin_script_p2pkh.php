<?php
$_HTML['title'] = 'Bitcoin P2PKH';
$_HTML['meta']['keywords'] = "Bitcoin,P2PKH,Pay To Public Key Hash,PHP";
include_once "../common.php";
include_once("html_header.php");

?>
<h2 class="mt-3">Bitcoin P2PKH</h2>
<hr/>
	P2PKH (Pay To Public Key Hash) is the most common and widely use transaction type in the Bitcoin network. To spend
<hr/>
<ul>
	<li>In bitcoin, P2PKH address start with 1.</li>
	<li>Address encoded in BASE58 format.</li>
	<li>Most common type of bitcoin transaction.</li>
	<li>Stands for "Pay To Public Key Hash".</li>
	<li>Aim to replace P2PK for security and storage efficiency.</li>
</ul>
<div class='vertical-line-green'>
	<h6 class="mt-3">Script Pair of P2PKH</h6>
	<table>
		<tr>
			<td>ScriptPubKey</td><td>: <?php echo htmlentities("OP_DUP OP_HASH160 <PublicKeyHash> OP_EQUALVERIFY OP_CHECKSIG");?></td>
		</tr>
		<tr>
			<td>ScriptSig</td><td>: <?php echo htmlentities("<Signature> <PublicKey>");?></td>
		</tr>
	</table>
</div>
<hr/>
<h3 class="mt-3" id='hashtag3'>P2PKH Address</h3>
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
		<iframe src="bitcoin_script_p2pkh_address.php" width="100%" scrolling="no" frameborder="no"></iframe>
	</div>
	<div id="form1_tabitem2" class="tab-pane fade">
<pre style='border-radius:none;'><?php echo htmlentities(file_get_contents("bitcoin_script_p2pkh_address.php"));?></pre> 		
	</div>
</div>
<hr/>
<h3 class="mt-3" id='hashtag2'>Fund & Spend P2PKH</h3>
<ul class="nav nav-tabs">
	<li class="nav-item dropdown">
		<a class="nav-link dropdown-toggle active" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Fund</a>
		<div class="dropdown-menu">
			<a data-toggle="tab" class="dropdown-item" href="#form2_tabitem1">Visual</a>
			<a data-toggle="tab" class="dropdown-item" href="#form2_tabitem2">Coding</a>
		</div>
	</li>
	
	<li class="nav-item dropdown">
		<a class="nav-link dropdown-toggle " data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Spend</a>
		<div class="dropdown-menu">
			<a data-toggle="tab" class="dropdown-item" href="#form2_tabitem3">Visual</a>
			<a data-toggle="tab" class="dropdown-item" href="#form2_tabitem4">Coding</a>
		</div>
	</li>
	
</ul>
<div class="tab-content">
	<div id="form2_tabitem1" class="tab-pane fade show active">
		<iframe src="bitcoin_script_p2pkh_fund.php" width="100%" scrolling="no" frameborder="no"></iframe>
	</div>
	<div id="form2_tabitem2" class="tab-pane fade">
<pre style='border-radius:none;'><?php echo htmlentities(file_get_contents("bitcoin_script_p2pkh_fund.php"));?></pre> 
	</div>
	
	<div id="form2_tabitem3" class="tab-pane fade">
		<iframe src="bitcoin_script_p2pkh_spend.php" width="100%" scrolling="no" frameborder="no"></iframe>
	</div>
	<div id="form2_tabitem4" class="tab-pane fade">
<pre style='border-radius:none;'><?php echo htmlentities(file_get_contents("bitcoin_script_p2pkh_spend.php"));?></pre> 
	</div>
</div>
<?php
include_once("html_footer.php");