<?php

$_HTML['title'] = 'Bitcoin P2SH';
$_HTML['meta']['keywords'] = "Bitcoin,P2SH,Pay To Script Hash,PHP";
include_once "../common.php";
include_once("html_header.php");
?>
<h2 class="mt-3">Bitcoin P2SH</h2>
<hr/>
	P2SH (Pay To Script Hash) allows you to easily customize both standard script & non stardard script into client accepted script. To spend it, you must provide corresponded redeem script. 
<hr/>
<ul>
	<li>In bitcoin, P2SH address start with 3.</li>
	<li>Address encoded in BASE58 format.</li>
	<li>Stands for "Pay To Script Hash".</li>
	<li>Introduced in <a href='https://github.com/bitcoin/bips/blob/master/bip-0016.mediawiki' target='_blank'>BIP16</a>.</li>
	<li>Redeem script is script's script and you could consider it as new locking script.</li>
	<li>High transaction fee is bear by redeemer rather than spender because this is redeemer's willingness to use more functional scripts.</li>
</ul>
<div class='vertical-line-green'>
	<h6 class="mt-3">Script Pair of P2SH</h6>
	<table>
		<tr>
			<td>ScriptPubKey</td><td>: <?php echo htmlentities("OP_HASH160 <redeemScriptHash> OP_EQUAL");?></td>
		</tr>
		<tr>
			<td>ScriptSig</td><td>: <?php echo htmlentities("<redeemScript>");?></td>
		</tr>
	</table>
</div>
<hr/>
<h3 class="mt-3" id='hashtag1'>P2SH Address</h3>
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
		<iframe id='iframe_p2sh_address' src="bitcoin_script_p2sh_address.php" width="100%" scrolling="no" frameborder="no"></iframe>
	</div>
	<div id="form1_tabitem2" class="tab-pane fade">
		<pre style='border-radius:none;'>
<?php echo htmlentities(file_get_contents("bitcoin_script_p2sh_address.php"));?>
		</pre> 		
	</div>
</div>
<hr/>
<h3 class="mt-3" id='hashtag2'>Redeem Script Types</h3>
<div class='vertical-line-yellow'>
	Learn to test. Firstly, you have to create P2SH address based on <b>Redeem Script</b> and fund money into it. Secondly, to test spend, you got to apply <b>Unlock Script</b> and fill <b>ScriptSig</b> field within ANY P2SH TX form.
</div>
<ul class="nav nav-tabs">
	<li class="nav-item dropdown">
		<a class="nav-link dropdown-toggle active" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Non-standard Redeem Script Type</a>
		<div class="dropdown-menu">
			<a data-toggle="tab" class="dropdown-item" href="#sample1_info">1 + 5 = 6</a>
			<a data-toggle="tab" class="dropdown-item" href="#sample2_info">Hashlock wrapped in P2SH</a>
		</div>
	</li>
	
	<li class="nav-item dropdown">
		<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Stardard Redeem Script Type</a>
		<div class="dropdown-menu">
			<a data-toggle="tab" class="dropdown-item" href="#sample3_info">P2PKH wrapped in P2SH</a>
			<a data-toggle="tab" class="dropdown-item" href="#sample4_info">Multisig wrapped in P2SH</a>
			<a data-toggle="tab" class="dropdown-item" href="#sample5_info">P2WPKH wrapped in P2SH</a>
			<a data-toggle="tab" class="dropdown-item" href="#sample6_info">P2WSH wrapped in P2SH</a>
		</div>
	</li>
</ul>
<div class="tab-content">
	<div id="sample1_info" class="tab-pane fade show active">
		
		<h4 class="mt-3">1 + 5 = 6</h4>
		
		<ul class="nav nav-tabs">
			<li class="nav-item">
				<a data-toggle="tab" class="nav-link active" href="#sample1_tabitem1">Visual</a>
			</li>
			<li class="nav-item">
				<a data-toggle="tab" class="nav-link" href="#sample1_tabitem2">Coding</a>
			</li>
		</ul>
		
		<div class="tab-content">
			<div id="sample1_tabitem1" class="tab-pane fade show active">
				<iframe src="bitcoin_script_p2sh_simplemath.php" width="100%" scrolling="no" frameborder="no"></iframe>
			</div>
			
			<div id="sample1_tabitem2" class="tab-pane fade">
				<pre style='border-radius:none;'>
<?php echo htmlentities(file_get_contents("bitcoin_script_p2sh_simplemath.php"));?>
				</pre> 		
			</div>
		</div>		
	</div>

	<div id="sample4_info" class="tab-pane fade">
		<?php 
		
		?>
		<h4 class="mt-3">Multisig wrapped in P2SH</h4>
		<div class='row'>
			<div class="col-sm-12">
				This page is alias of <a href="bitcoin_script_multisig.php">Bitcoin MULTISIG</a>.
				
				An example below is <b>2-of-3</b> multisig redeem script.
				
			</div>
		</div>
		
		<ul class="nav nav-tabs">
			<li class="nav-item">
				<a data-toggle="tab" class="nav-link active" href="#sample4_tabitem1">Visual</a>
			</li>
			<li class="nav-item">
				<a data-toggle="tab" class="nav-link" href="#sample4_tabitem2">Coding</a>
			</li>
		</ul>
		
		<div class="tab-content">
			<div id="sample4_tabitem1" class="tab-pane fade show active">
				<div class="col-sm-12">
					<h6 class="mt-3" title="Redeem script plays important roles in both lock and unlock tx. That is, unlock tx requires redeem script while lock tx requires redeem script hash.">Redeem Script</h6>
					
					<div class='vertical-line-green'>
						<?php echo htmlentities("2 <PubKey1> <PubKey2> <PubKey3> 3 OP_CHECKMULTISIG")?>
					</div>
					
					<iframe src="bitcoin_script_p2sh_multisig.php" width="100%" scrolling="no" frameborder="no"></iframe>
				
				
				</div>
			</div>
			<div id="sample4_tabitem2" class="tab-pane fade">
				<pre style='border-radius:none;'>
<?php echo htmlentities(file_get_contents("bitcoin_script_p2sh_multisig.php"));?>
				</pre> 	
			</div>		
		</div>
	</div>
	
	<div id="sample5_info" class="tab-pane fade">
		
		<h4 class="mt-3">P2WPKH wrapped in P2SH</h4>
		<div class='row'>
			<div class="col-sm-12">
				This page is alias of <a href="bitcoin_script_p2sh_p2wpkh.php">Bitcoin P2SH.P2WPKH</a>.
			</div>
		</div>
	</div>
	
	<div id="sample6_info" class="tab-pane fade">
		
		<h4 class="mt-3">P2WSH wrapped in P2SH</h4>
		<div class='row'>
			<div class="col-sm-12">
				This page is alias of <a href="bitcoin_script_p2sh_p2wsh.php">Bitcoin P2SH.P2WSH</a>.
			</div>
		</div>
	</div>
</div>
<hr/>
<h3 class="mt-3" id='hashtag3'>Any P2SH TX</h3>
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
		<iframe src="bitcoin_script_p2sh_fund.php" width="100%" scrolling="no" frameborder="no"></iframe>
	</div>
	<div id="form2_tabitem2" class="tab-pane fade">
		<pre style='border-radius:none;'>
<?php echo htmlentities(file_get_contents("bitcoin_script_p2sh_fund.php"));?>
		</pre> 
	</div>
	
	<div id="form2_tabitem3" class="tab-pane fade">
		<iframe src="bitcoin_script_p2sh_spend.php" width="100%" scrolling="no" frameborder="no"></iframe>
	</div>
	<div id="form2_tabitem4" class="tab-pane fade">
		<pre style='border-radius:none;'>
<?php echo htmlentities(file_get_contents("bitcoin_script_p2sh_spend.php"));?>
		</pre> 
	</div>
</div>
<script>
	function moveData(value, targetIframeID, inputID) {
		
		var targetInput = $("iframe#"+targetIframeID).contents().find("input#"+inputID)
		targetInput.val(value);
		setTimeout(function() { targetInput.focus(); }, 300);
		
	}
</script>
<?php
include_once("html_footer.php");