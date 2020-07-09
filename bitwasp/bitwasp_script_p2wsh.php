<?php
$_HTML['title'] = 'Bitwasp P2WSH';
$_HTML['meta']['keywords'] = "Bitwasp,P2WSH,Pay To Witness Script Hash,PHP";

include_once "../common.php";
include_once("html_header.php");

$no_of_inputs = 10;
$no_of_outputs = 10;

?>
<h2 class="mt-3">Bitwasp P2WSH</h2>
<hr/>
<?php echo $explaination['segwit']?>
<hr/>
<ul>
	<li>P2WSH stands for "Pay To Witness Script Hash".</li>
	<li>Address applies BECH32 encoding.</li>
	<li>In Bitcoin, bc represents mainnet and tb represents testnet.</li>
</ul>
<div class='vertical-line-green'>
	<h6 class="mt-3">Script Pair of P2WSH</h6>
	<table>
		<tr>
		 
			<td>ScriptPubKey</td><td>: OP_HASH160 <span data-toggle="tooltip" title="0x20 Bytes is length of Witness Program. While <?php echo htmlentities("<32 Bytes RedeemScriptHash>");?> is Witness Program." class='explaination'>20<?php echo htmlentities("<32 Bytes RedeemScriptHash>");?></span> OP_EQUAL</td>
		</tr>
		<tr>
			<td>ScriptSig</td><td>: <small><i>(Empty as ScriptSig has been moved to witness field.)</i></small></td>
		</tr>
		
		<tr>
			<td>Witness Field</td><td>: <?php echo htmlentities("<Witness Items> <RedeemScript>");?></td>
		</tr>
	</table>
</div>


<h3 class="mt-3" id='hashtag3'>Witness Structure</h3>

The witness is a serialization of all witness data of the transaction. Each txin is associated with a witness field. A witness field starts with a var_int to indicate the number of stack items for the txin. It is followed by stack items, with each item starts with a var_int to indicate the length. Witness data is NOT script, therefore you cannot use OPCODES. See <a href='https://github.com/bitcoin/bips/blob/master/bip-0141.mediawiki' target='_blank'>BIP 141</a>.
<p>
	<div class="table-responsive">
		<table class='table'>
			<tr><td>Witness</td><td>Serialization of Witness Data.</td></tr>
			<tr><td>Witness Data</td><td>All Witness Fields.</td></tr>
			<tr><td>Witness Field</td><td>Witness field can refer to its txIn, start with var_int to indicate number of stack items.</td></tr>
			<tr><td>Stack Item</td><td>Starts with a var_int to indicate the length.</td></tr>
		</table>
	</div>
</p>
<hr/>
<h3 class="mt-3" id='hashtag3'>P2WSH Address</h3>
<ul class="nav nav-tabs">
	<li class="nav-item">
		<a data-toggle="tab" class="nav-link<?php echo ($_GET['tab'] == 'form1_tabitem1' or strtok($_GET['tab'], "_")!='form1') ?  ' active':''?>" href="#form1_tabitem1">Visual</a>
	</li>
	<li class="nav-item">
		<a data-toggle="tab" class="nav-link" href="#form1_tabitem2">Coding</a>
	</li>
</ul>
<div class="tab-content">
	<div id="form1_tabitem1" class="tab-pane fade show active">
		<iframe src="bitwasp_script_p2wsh_address.php" width="100%" scrolling="no" frameborder="no"></iframe>
	</div>
	<div id="form1_tabitem2" class="tab-pane fade">
		<pre style='border-radius:none;'>
<?php echo htmlentities(file_get_contents("bitwasp_script_p2wsh_address.php"));?>
		</pre> 		
	</div>
</div>
<hr/>
<h3 class="mt-3" id='hashtag2'>Fund & Spend P2WSH</h3>
<ul class="nav nav-tabs">
	<li class="nav-item dropdown">
		<a class="nav-link dropdown-toggle active" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Fund</a>
		<div class="dropdown-menu">
			<a data-toggle="tab" class="dropdown-item" href="#form2_tabitem1">Visual</a>
			<a data-toggle="tab" class="dropdown-item" href="#form2_tabitem2">Coding</a>
		</div>
	</li>
	
	<li class="nav-item dropdown">
		<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Spend</a>
		<div class="dropdown-menu">
			<a data-toggle="tab" class="dropdown-item" href="#form2_tabitem3">Visual</a>
			<a data-toggle="tab" class="dropdown-item" href="#form2_tabitem4">Coding</a>
		</div>
	</li>
	
</ul>
<div class="tab-content">
	<div id="form2_tabitem1" class="tab-pane fade show active">
		<iframe src="bitwasp_script_p2wsh_fund.php" width="100%" scrolling="no" frameborder="no"></iframe>
	</div>
	<div id="form2_tabitem2" class="tab-pane fade">
		<pre style='border-radius:none;'>
<?php echo htmlentities(file_get_contents("bitwasp_script_p2wsh_fund.php"));?>
		</pre> 
	</div>
	
	<div id="form2_tabitem3" class="tab-pane fade">
		<iframe src="bitwasp_script_p2wsh_spend.php" width="100%" scrolling="no" frameborder="no"></iframe>
	</div>
	<div id="form2_tabitem4" class="tab-pane fade">
		<pre style='border-radius:none;'>
<?php echo htmlentities(file_get_contents("bitwasp_script_p2wsh_spend.php"));?>
		</pre> 
	</div>
</div>
<?php
include_once("html_footer.php");