<?php

$_HTML['title'] = 'Bitwasp P2SH.P2WSH';
$_HTML['meta']['keywords'] = "Bitwasp,Pay To Witness Script Hash Wrapped In P2SH,P2SH P2WSH,PHP";

include_once "../common.php";
include_once("html_header.php");

?>
<h2 class="mt-3">Bitwasp P2SH.P2WSH</h2>
<hr/>
<?php echo $explaination['segwit']?>
<hr/>
<ul>
	<li>P2SH.P2WSH stands for "Pay To Witness Script Hash Wrapped In P2SH".</li>
	<li>Encodes in BASE58 address.</li>
	<li>Allows non-SegWit wallets to generate a SegWit transaction.</li>
	<li>Allows non-SegWit client accept SegWit transaction.</li>
	
</ul>
<div class='vertical-line-green'>
	<h6 class="mt-3">Script Pair of P2SH.P2WSH</h6>
	<table>
		<tr>
			<td>ScriptPubKey</td><td>: OP_HASH160 <?php echo htmlentities("20<32 Bytes RedeemScriptHash>")?> OP_EQUAL</td>
		</tr>
		<tr>
			<td>ScriptSig</td><td>: <?php echo htmlentities("<00 20<32 Bytes RedeemScriptHash>>")?></td>
		</tr>
		<tr>
			<td>Redeem Script</td><td>: <?php echo htmlentities("<00 20<32 Bytes WitnessScriptHash>>")?></td>
		</tr>
		<tr>
			<td>Witness Field</td><td>: <?php echo htmlentities("<witness items> <WitnessScript>");?></td>
		</tr>
	</table>
</div>

<h3 class="mt-3" id='hashtag3'>Witness Structure</h3>

The witness is a serialization of all witness data of the transaction. Each txin is associated with a witness field. A witness field starts with a <span class='explaination' data-toggle='tooltip' title="<?php echo $explaination['var_int']?>">var_int</span> to indicate the number of stack items for the txin. It is followed by stack items, with each item starts with a <span class='explaination' data-toggle='tooltip' title="<?php echo $explaination['var_int']?>">var_int</span> to indicate the length. Witness data is NOT script. See <a href='https://github.com/bitcoin/bips/blob/master/bip-0141.mediawiki' target='_blank'>BIP 141</a>.
<p>
	<div class="table-responsive">
		<table class='table'>
			<tr><td>Witness</td><td>Serialization of Witness Data.</td></tr>
			<tr><td>Witness Data</td><td>All Witness Fields.</td></tr>
			<tr><td>Witness Field</td><td>Witness field can refer to its txIn, start with <span class='explaination' data-toggle='tooltip' title="<?php echo $explaination['var_int']?>">var_int</span> to indicate number of stack items.</td></tr>
			<tr><td>Stack Item</td><td>Starts with a <span class='explaination' data-toggle='tooltip' title="<?php echo $explaination['var_int']?>">var_int</span> to indicate the length.</td></tr>
		</table>
	</div>
</p>
<hr/>
<h3 class="mt-3" id='hashtag3'>P2SH.P2WSH Address</h3>
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
		<iframe src="bitwasp_script_p2sh_p2wsh_address.php" width="100%" scrolling="no" frameborder="no"></iframe>
	</div>
	<div id="form1_tabitem2" class="tab-pane fade">
		<pre style='border-radius:none;'>
<?php echo htmlentities(file_get_contents("bitwasp_script_p2sh_p2wsh_address.php"));?>
		</pre> 		
	</div>
</div>
<hr/>


<h3 class="mt-3" id='hashtag2'>Fund & Spend P2SH.P2WSH</h3>
<ul class="nav nav-tabs">
	<li class="nav-item dropdown">
		<a class="nav-link dropdown-toggle<?php echo ($_GET['tab'] == 'form2_tabitem1' or strtok($_GET['tab'], "_")!='form2') ?  ' active':''?>" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Fund</a>
		<div class="dropdown-menu">
			<a data-toggle="tab" class="dropdown-item" href="#form2_tabitem1">Visual</a>
			<a data-toggle="tab" class="dropdown-item" href="#form2_tabitem2">Coding</a>
		</div>
	</li>
	
	<li class="nav-item dropdown">
		<a class="nav-link dropdown-toggle<?php echo ($_GET['tab'] == 'form2_tabitem3') ?  ' active':''?>" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Spend</a>
		<div class="dropdown-menu">
			<a data-toggle="tab" class="dropdown-item" href="#form2_tabitem3">Visual</a>
			<a data-toggle="tab" class="dropdown-item" href="#form2_tabitem4">Coding</a>
		</div>
	</li>
	
</ul>
<div class="tab-content">
	<div id="form2_tabitem1" class="tab-pane fade show active">
		<iframe src="bitwasp_script_p2sh_p2wsh_fund.php" width="100%" scrolling="no" frameborder="no"></iframe>
	</div>
	<div id="form2_tabitem2" class="tab-pane fade">
		<pre style='border-radius:none;'>
<?php echo htmlentities(file_get_contents("bitwasp_script_p2sh_p2wsh_fund.php"));?>
		</pre> 
	</div>
	
	<div id="form2_tabitem3" class="tab-pane fade">
		<iframe src="bitwasp_script_p2sh_p2wsh_spend.php" width="100%" scrolling="no" frameborder="no"></iframe>
	</div>
	<div id="form2_tabitem4" class="tab-pane fade">
		<pre style='border-radius:none;'>
<?php echo htmlentities(file_get_contents("bitwasp_script_p2sh_p2wsh_spend.php"));?>
		</pre> 
	</div>
</div>
<?php
include_once("html_footer.php");