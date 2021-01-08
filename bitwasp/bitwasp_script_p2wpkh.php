<?php

$_HTML['title'] = 'Bitwasp P2WPKH';
$_HTML['meta']['keywords'] = "Bitwasp,P2WPKH,Pay To Witness Public Key Hash,PHP";

include_once "../common.php";
include_once("html_header.php");

$var_int = "A var_int is most commonly a 1 byte hexadecimal value.";
?>
<h2 class="mt-3">Bitwasp P2WPKH</h2>
<hr/>
In 2015, Bitcoin developers came up with major improvements that known as Segregated Witness – SegWit and it has been mainly mentioned in BIP141 & BIP143. This improvement aims to solve 
<ul>
<li>Scalability of bitcoin network.</li><li>Malleability transaction for lightning network solution.</li><li>Increase block size limit.</li>
</ul>
<hr/>
<ul>
	<li>P2WPKH stands for "Pay To Witness Public Key Hash".</li>
	<li>Address applies BECH32 encoding.</li>
	<li>In Bitcoin, bc represents mainnet and tb represents testnet.</li>
</ul>
<div class='vertical-line-green'>
	<h6 class="mt-3">Script Pair of P2WPKH</h6>
	<table>
		<tr>
			<td>ScriptPubKey</td><td>: <span data-toggle="tooltip" title="Witness Version" class='explaination'>OP_0</span> <span data-toggle="tooltip" title="0x14 Bytes is length of Witness Program. While <?php echo htmlentities("<20 Bytes PublicKeyHash>");?> is Witness Program." class='explaination'>14<?php echo htmlentities("<20 Bytes PublicKeyHash>");?></span></td>
		</tr>
		<tr>
			<td>ScriptSig</td><td>: <small><i>(Empty as ScriptSig has been moved to witness field.)</i></small></td>
		</tr>
		
		<tr>
			<td>Witness Field</td><td>: <?php echo htmlentities("<Signature> <PublicKey>");?></td>
		</tr>
	</table>
</div>

<h3 class="mt-3" id='hashtag3'>Witness Structure</h3>

The witness is a serialization of all witness data of the transaction. Each txin is associated with a witness field. A witness field starts with a <span class='explaination' data-toggle='tooltip' title="<?php echo $var_int?>">var_int</span> to indicate the number of stack items for the txin. It is followed by stack items, with each item starts with a <span class='explaination' data-toggle='tooltip' title="<?php echo $var_int?>">var_int</span> to indicate the length. Witness data is NOT script. See <a href='https://github.com/bitcoin/bips/blob/master/bip-0141.mediawiki' target='_blank'>BIP 141</a>.
<p>
	<div class="table-responsive">
		<table class='table'>
			<tr><td>Witness</td><td>Serialization of Witness Data.</td></tr>
			<tr><td>Witness Data</td><td>All Witness Fields.</td></tr>
			<tr><td>Witness Field</td><td>Witness field can refer to its txIn, start with <span class='explaination' data-toggle='tooltip' title="<?php echo $var_int?>">var_int</span> to indicate number of stack items.</td></tr>
			<tr><td>Stack Item</td><td>Starts with a <span class='explaination' data-toggle='tooltip' title="<?php echo $var_int?>">var_int</span> to indicate the length.</td></tr>
		</table>
	</div>
</p>
<hr/>
<h3 class="mt-3" id='hashtag3'>P2WPKH Address</h3>
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
		<iframe src="bitwasp_script_p2wpkh_address.php" width="100%" scrolling="no" frameborder="no"></iframe>
	</div>
	<div id="form1_tabitem2" class="tab-pane fade">
		<pre style='border-radius:none;'>
<?php echo htmlentities(file_get_contents("bitwasp_script_p2wpkh_address.php"));?>
		</pre> 		
	</div>
</div>
<hr/>


<h3 class="mt-3" id='hashtag2'>Fund & Spend P2WPKH</h3>
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
		<iframe src="bitwasp_script_p2wpkh_fund.php" width="100%" scrolling="no" frameborder="no"></iframe>
	</div>
	<div id="form2_tabitem2" class="tab-pane fade">
		<pre style='border-radius:none;'>
<?php echo htmlentities(file_get_contents("bitwasp_script_p2wpkh_fund.php"));?>
		</pre> 
	</div>
	
	<div id="form2_tabitem3" class="tab-pane fade">
		<iframe src="bitwasp_script_p2wpkh_spend.php" width="100%" scrolling="no" frameborder="no"></iframe>
	</div>
	<div id="form2_tabitem4" class="tab-pane fade">
		<pre style='border-radius:none;'>
<?php echo htmlentities(file_get_contents("bitwasp_script_p2wpkh_spend.php"));?>
		</pre> 
	</div>
</div>
<?php
include_once("html_footer.php");