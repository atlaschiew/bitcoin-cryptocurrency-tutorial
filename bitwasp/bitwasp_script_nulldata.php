<?php
$_HTML['title'] = 'Bitwasp NULL DATA';
$_HTML['meta']['keywords'] = "Bitwasp,NULL DATA,NULLDATA,OP_RETURN,PHP";

include_once "../common.php";
include_once("html_header.php");

?>
<h2 class="mt-3">Bitwasp NULL DATA</h2>
<hr/>
ScriptPubKey must contains OP_RETURN which is used to end script execution, therefore any outputs with OP_RETURN are provably unspendable.
<hr/>
<ul>
	<li>ScriptPubKey must contains OP_RETURN.</li>
	<li>Aims to embed user own defined data in the bitcoin.</li>
	<li>Data size limit is 40 bytes.</li>	
	
</ul>

<div class='vertical-line-green'>
	<h6 class="mt-3">Script Pair of NULL DATA</h6>
	<table>
		<tr>
			<td>ScriptPubKey</td><td>: <?php echo htmlentities("OP_RETURN <dataToEmbed>");?></td>
		</tr>
		<tr>
			<td>ScriptSig</td><td>: <small><i>(Empty as OP_RETURN utxo is unspendable.)</i></small></td>
		</tr>
		
	</table>
</div>
<hr/>
<h3 class="mt-3" id='hashtag3'>NULL DATA Address</h3>
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
		<iframe src="bitwasp_script_nulldata_address.php" width="100%" scrolling="no" frameborder="no"></iframe>
	</div>
	<div id="form1_tabitem2" class="tab-pane fade">
		<pre style='border-radius:none;'>
<?php echo htmlentities(file_get_contents("bitwasp_script_nulldata_address.php"));?>
		</pre> 		
	</div>
</div>
<hr/>
<h3 class="mt-3" id='hashtag2'>Fund & Spend NULL DATA</h3>
<ul class="nav nav-tabs">
	<li class="nav-item dropdown">
		<a class="nav-link dropdown-toggle active" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Fund</a>
		<div class="dropdown-menu">
			<a data-toggle="tab" class="dropdown-item" href="#form2_tabitem1">Visual</a>
			<a data-toggle="tab" class="dropdown-item" href="#form2_tabitem2">Coding</a>
		</div>
	</li>
</ul>
<div class="tab-content">
	<div id="form2_tabitem1" class="tab-pane fade show active">
		<iframe src="bitwasp_script_nulldata_fund.php" width="100%" scrolling="no" frameborder="no"></iframe>
	</div>
	<div id="form2_tabitem2" class="tab-pane fade">
		<pre style='border-radius:none;'>
<?php echo htmlentities(file_get_contents("bitwasp_script_nulldata_fund.php"));?>
		</pre> 
	</div>
</div>
<?php
include_once("html_footer.php");