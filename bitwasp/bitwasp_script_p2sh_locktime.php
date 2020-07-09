<?php

$_HTML['title'] = 'Bitwasp P2SH.LOCKTIME';
$_HTML['meta']['keywords'] = "Bitwasp,P2SH LOCKTIME,P2SH CheckLockTimeVerify,P2SH CheckSequenceVerify,PHP";
include_once "../common.php";
include_once("html_header.php");

?>
<h2 class="mt-3">Bitwasp P2SH.LOCKTIME</h2>
<hr/>
A script level locktime mechanism aims to restrict spending of bitcoin until condition reach future time or block height. Today, it is commonly applied in Hash Time-Locked Contracts (HTLC).
<hr/>

P2SH.CheckLockTimeVerify (CLTV)
<ul>
	<li>Absolute Locktime.</li>
	<li>Described in <a href='https://github.com/bitcoin/bips/blob/master/bip-0065.mediawiki' target='_blank'>BIP 65</a>.</li>	
</ul>

<div class='vertical-line-green'>
	<h6 class="mt-3">Script Pair of CLTV</h6>
	<table>
		
		<tr>
			<td>ScriptPubKey</td><td>: <?php echo htmlentities("<expiry time> OP_CHECKLOCKTIMEVERIFY OP_DROP OP_DUP OP_HASH160 <pubKeyHash> OP_EQUALVERIFY OP_CHECKSIG");?></td>
		</tr>
		<tr>
			<td>ScriptSig</td><td>: <?php echo htmlentities("<Signature> <PublicKey>")?></td>
		</tr>
		
	</table>
</div>
P2SH.CheckSequenceVerify (CSV)
<ul>
	<li>Relative Locktime.</li>
</ul>

<div class='vertical-line-green'>
	<h6 class="mt-3">Script Pair of CSV</h6>
	<table>
		
		<tr>
			<td>ScriptPubKey</td><td>: <?php echo htmlentities("<expiry time> OP_CHECKLOCKTIMEVERIFY OP_DROP OP_DUP OP_HASH160 <pubKeyHash> OP_EQUALVERIFY OP_CHECKSIG");?></td>
		</tr>
		<tr>
			<td>ScriptSig</td><td>: <?php echo htmlentities("<Signature> <PublicKey>")?></td>
		</tr>
		
	</table>
</div>


<hr/>
<h3 class="mt-3" id='hashtag3'>P2SH.LOCKTIME Address</h3>
<ul class="nav nav-tabs">
	
	<li class="nav-item dropdown">
		<a class="nav-link dropdown-toggle active" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">CLTV</a>
		<div class="dropdown-menu">
			<a data-toggle="tab" class="dropdown-item" href="#form1_tabitem1">Visual</a>
			<a data-toggle="tab" class="dropdown-item" href="#form1_tabitem2">Coding</a>
		</div>
	</li>
	
	<li class="nav-item dropdown">
		<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">CSV</a>
		<div class="dropdown-menu">
			<a data-toggle="tab" class="dropdown-item" href="#form1_tabitem3">Visual</a>
			<a data-toggle="tab" class="dropdown-item" href="#form1_tabitem4">Coding</a>
		</div>
	</li>
	
</ul>
<div class="tab-content">
	<div id="form1_tabitem1" class="tab-pane fade show active">
		<iframe src="bitwasp_script_p2sh_cltv_address.php" width="100%" scrolling="no" frameborder="no"></iframe>
	</div>
	<div id="form1_tabitem2" class="tab-pane fade">
		<pre style='border-radius:none;'>
<?php echo htmlentities(file_get_contents("bitwasp_script_p2sh_cltv_address.php"));?>
		</pre> 		
	</div>
	
	<div id="form1_tabitem3" class="tab-pane fade">
		<iframe src="bitwasp_script_p2sh_csv_address.php" width="100%" scrolling="no" frameborder="no"></iframe>
	</div>
	<div id="form1_tabitem4" class="tab-pane fade">
		<pre style='border-radius:none;'>
<?php echo htmlentities(file_get_contents("bitwasp_script_p2sh_csv_address.php"));?>
		</pre> 		
	</div>
</div>
<hr/>


<h3 class="mt-3" id='hashtag2'>Fund & Spend P2SH.LOCKTIME</h3>

<ul class="nav nav-tabs">
	<li class="nav-item dropdown">
		<a class="nav-link dropdown-toggle active" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">OP_CLTV Fund</a>
		<div class="dropdown-menu">
			<a data-toggle="tab" class="dropdown-item" href="#form2_tabitem1">Visual</a>
			<a data-toggle="tab" class="dropdown-item" href="#form2_tabitem2">Coding</a>
		</div>
	</li>
	
	<li class="nav-item dropdown">
		<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">OP_CLTV Spend</a>
		<div class="dropdown-menu">
			<a data-toggle="tab" class="dropdown-item" href="#form2_tabitem3">Visual</a>
			<a data-toggle="tab" class="dropdown-item" href="#form2_tabitem4">Coding</a>
		</div>
	</li>
	<li class="nav-item dropdown">
		<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">OP_CSV Fund</a>
		<div class="dropdown-menu">
			<a data-toggle="tab" class="dropdown-item" href="#form2_tabitem5">Visual</a>
			<a data-toggle="tab" class="dropdown-item" href="#form2_tabitem6">Coding</a>
		</div>
	</li>
	
	<li class="nav-item dropdown">
		<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">OP_CSV Spend</a>
		<div class="dropdown-menu">
			<a data-toggle="tab" class="dropdown-item" href="#form2_tabitem7">Visual</a>
			<a data-toggle="tab" class="dropdown-item" href="#form2_tabitem8">Coding</a>
		</div>
	</li>
</ul>
<div class="tab-content">
	<div id="form2_tabitem1" class="tab-pane fade show active">
		<iframe src="bitwasp_script_p2sh_cltv_fund.php" width="100%" scrolling="no" frameborder="no"></iframe>
	</div>
	<div id="form2_tabitem2" class="tab-pane fade">
		<pre style='border-radius:none;'>
<?php echo htmlentities(file_get_contents("bitwasp_script_p2sh_cltv_fund.php"));?>
		</pre> 
	</div>
	
	<div id="form2_tabitem3" class="tab-pane fade">
		<iframe src="bitwasp_script_p2sh_cltv_spend.php" width="100%" scrolling="no" frameborder="no"></iframe>
	</div>
	<div id="form2_tabitem4" class="tab-pane fade">
		<pre style='border-radius:none;'>
<?php echo htmlentities(file_get_contents("bitwasp_script_p2sh_cltv_spend.php"));?>
		</pre> 
	</div>
	
	<div id="form2_tabitem5" class="tab-pane fade">
		<iframe src="bitwasp_script_p2sh_csv_fund.php" width="100%" scrolling="no" frameborder="no"></iframe>
	</div>
	<div id="form2_tabitem6" class="tab-pane fade">
		<pre style='border-radius:none;'>
<?php echo htmlentities(file_get_contents("bitwasp_script_p2sh_csv_fund.php"));?>
		</pre> 
	</div>
	
	<div id="form2_tabitem7" class="tab-pane fade">
		<iframe src="bitwasp_script_p2sh_csv_spend.php" width="100%" scrolling="no" frameborder="no"></iframe>
	</div>
	<div id="form2_tabitem8" class="tab-pane fade">
		<pre style='border-radius:none;'>
<?php echo htmlentities(file_get_contents("bitwasp_script_p2sh_csv_spend.php"));?>
		</pre> 
	</div>
</div>
<?php
include_once("html_footer.php");