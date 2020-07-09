<?php

$_HTML['title'] = 'Bitwasp MULTISIG';
$_HTML['meta']['keywords'] = "Bitwasp,MULTISIG,Pay To Multi Signature,Pay To Multisig wrapped in P2SH,P2MS,P2SH Multisig,PHP";

if ($_GET['tab'] == 'no_tab' AND $_SERVER['REQUEST_METHOD'] == 'GET' AND $_GET['ajax'] == '1') {
	$data = [];
	if (!is_numeric($_GET['m']) OR !is_numeric($_GET['n'])) {
		$data = ["error"=>"M & N must be numeric."];
	} else {
		function get_array_combination($arr) {
			$results = array(array( ));

			foreach ($arr as $values)
				foreach ($results as $combination)
						array_push($results, array_merge($combination, array($values))); // Get new values and merge to your previous combination. And push it to your results array
			return $results;
		}
		$set = range(1, $_GET['n']);
		$final_array = array_values(array_filter(get_array_combination($set)));
		
		$result = [];
		foreach($final_array as $k=>$array) {
			if (count($array) >= $_GET['m']) {
				$array = array_map(function($v) {return "<sig{$v}>";},$array);
				$result[] = implode(" ", $array);
				implode(",", $array);
			} 
		}
		
		$data['result'] = $result;
	}
	die(json_encode($data));
}

include_once "../common.php";
include_once("html_header.php");

?>
<script>
	var p2sh_timer = null;
	var backup_p2ms_scriptsig = "<?php echo htmlentities('OP_0 < ... >')?>";
	var backup_p2ms_scriptpubkey = "<?php echo htmlentities('M < ... > N OP_CHECKMULTISIG')?>";
	
</script>
<h2 class="mt-3">Bitwasp MULTISIG</h2>
<hr/>
In reality, some organization may require more than 1 director's cheque signature in order to release the fund. Same thing accomplish this in bitcoin is using MULTISIG mechanism.
<hr/>
P2SH.Multisig (Multisig wrapped in P2SH)
<ul>
	<li>Most common way to use multisig.</li>
	<li>Described in <a href='https://github.com/bitcoin/bips/blob/master/bip-0067.mediawiki' target='_blank'>BIP67</a>.</li>	
	<li>Exist after P2MS.</li>	
	<li>Use of P2SH address implies that spender no longer bear for high tx fees as compare to P2MS below.</li>	
</ul>

P2MS
<ul>
	<li>Stands for "Pay To Multi Signature"</li>
	<li>M-of-N Standard Transactions described in BIP11.</li>
	<li>Not common as P2MS has no address format and limited to 3 public keys.</li>
	<li>In this tutorial, you are able to fund into P2MS's ScriptPubKey for better understanding to bitcoin script.</li>
	
</ul>
<div class='vertical-line-green'>
	<h6 class="mt-3">Script Pair of P2SH.Multisig</h6>
	<table>
		<tr>
			<td>ScriptPubKey</td><td>: <?php echo htmlentities("OP_HASH160 <redeemScriptHash> OP_EQUAL");?></td>
		</tr>
		<tr>
			<td>ScriptSig</td><td>: OP_0 <span id='p2sh-scriptsig-placeholder'><?php echo htmlentities("< ... >");?></span> OP_PUSHDATA1 <?php echo htmlentities("<redeemScript>");?></td>
		</tr>
		<?php
		$m_n_range = range(1,15);
		?>
		<tr>
			<td>Redeem Script</td>
			<td>: 
				<select id='select_m' style='background-color:#DDFFDD' onchange="
				var self = $(this);
				var M = parseInt(self.val());
				var N = parseInt($('#select_n').val());
				var placeholder1 = $('span#p2sh-redeemscript-placeholder');
				var placeholder2 = $('span#p2sh-scriptsig-placeholder');
				var placeholder3 = $('span#p2ms-scriptsig-placeholder');
				var placeholder4 = $('span#p2ms-scriptpubkey-placeholder');
				placeholder1.text('&lt; ... &gt;');
				placeholder2.text('&lt; ... &gt;');
				placeholder3.html(backup_p2ms_scriptsig);
				placeholder4.html(backup_p2ms_scriptpubkey);
				
				clearInterval(p2sh_timer);
				if(!isNaN(M) && !isNaN(N)) {
					if (M  > N) {
						alert('M value must smaller than or equal to N.');
						self.val($('#'+self.attr('id')+' option:first').val());
						$('#select_n').val($('#'+$('#select_n').attr('id')+' option:first').val());
						return false;
					} else {
						var placeholder1 = $('span#p2sh-redeemscript-placeholder');
						var display = '';
						for(var i=1; i<= N; i++) { display+= '&lt;pubkey'+i+'&gt;';}
						placeholder1.text(display);
						
						
						placeholder4.text(M + display + ' ' + N + ' OP_CHECKMULTISIG');
						
						$.ajax({
							url: '?ajax=1&tab=no_tab&m='+M+'&n=' + N, 
							success:function(result){
								try {
									j = eval('(' + result + ')');
									
									var pointer = 0;
									placeholder2.text(j.result[pointer++]); 
									var content = placeholder2.closest('td').html().split(' OP_PUSHDATA1 ');
									placeholder3.html(content[0].replace(/^\:/, ''));
									
									p2sh_timer = setInterval(
										function(list, placeholder2){ 
										
											if (pointer >= list.length) {
												pointer = 0;
											}
											placeholder2.text(list[pointer++]); 
											
											var content = placeholder2.closest('td').html().split(' OP_PUSHDATA1 ');
											placeholder3.html(content[0].replace(/^\:/, ''));
											
										}, 1500, j.result, placeholder2,);
								} catch(e) {
									alert('Invalid Json Format.');
								}
							}
						});
					}
				}
				">
					<option>M</option>
					<?php
					foreach($m_n_range as $k) {
						echo "<option>{$k}</option>";
					}
					?>
				</select>
				<span id='p2sh-redeemscript-placeholder'><?php echo htmlentities(" < ... > ");?></span>
				<select id='select_n' style='background-color:#DDFFDD' onchange="
				var self = $(this);
				var N = parseInt(self.val());
				var M = parseInt($('#select_m').val());
				var placeholder1 = $('span#p2sh-redeemscript-placeholder');
				var placeholder2 = $('span#p2sh-scriptsig-placeholder');
				var placeholder3 = $('span#p2ms-scriptsig-placeholder');
				var placeholder4 = $('span#p2ms-scriptpubkey-placeholder');
				placeholder1.text('&lt; ... &gt;');
				placeholder2.text('&lt; ... &gt;');
				placeholder3.html(backup_p2ms_scriptsig);
				placeholder4.html(backup_p2ms_scriptpubkey);
				
				clearInterval(p2sh_timer);
				if(!isNaN(N) && !isNaN(M)) {
					if (N  < M) {
						alert('N value must larger than or equal to M.');
						
						self.val($('#'+self.attr('id')+' option:first').val());
						$('#select_m').val($('#'+$('#select_m').attr('id')+' option:first').val());
						return false;
					} else {
						var placeholder1 = $('span#p2sh-redeemscript-placeholder');
						var display = '';
						for(var i=1; i<= N; i++) { display+= '&lt;pubkey'+i+'&gt;';}
						placeholder1.text(display);
						placeholder4.text(M + display + ' ' + N + ' OP_CHECKMULTISIG');
						$.ajax({
							url: '?ajax=1&tab=no_tab&m='+M+'&n=' + N, 
							success:function(result){
								try {
									j = eval('(' + result + ')');
									
									var pointer = 0;
									placeholder2.text(j.result[pointer++]); 
									var content = placeholder2.closest('td').html().split(' OP_PUSHDATA1 ')
									placeholder3.html(content[0].replace(/^\:/, ''));
									
									p2sh_timer = setInterval(
										function(list, placeholder2){ 
										
											if (pointer >= list.length) {
												pointer = 0;
											}
											placeholder2.text(list[pointer++]); 
											
											var content = placeholder2.closest('td').html().split(' OP_PUSHDATA1 ');
											placeholder3.html(content[0].replace(/^\:/, ''));
											
										}, 1500, j.result, placeholder2,);
								} catch(e) {
									alert('Invalid Json Format.');
								}
							}
						});
					}
				}
				">
					<option>N</option>
					<?php
					foreach($m_n_range as $k) {
						echo "<option>{$k}</option>";
					}
					?>
				</select>
				OP_CHECKMULTISIG
			</td>
		</tr>
	</table>
	
	<h6 class="mt-3">Script Pair of P2MS</h6>
	<table>
		<tr>
			<td>ScriptSig</td><td>: <span id='p2ms-scriptsig-placeholder'><script>document.write(backup_p2ms_scriptsig);</script></span></td>
		</tr>
		<tr>
			<td>ScriptPubKey</td>
			<td>: 
				<span id='p2ms-scriptpubkey-placeholder'><script>document.write(backup_p2ms_scriptpubkey);</script></span>
			</td>
		</tr>
	</table>
</div>
<hr/>
<h3 class="mt-3" id='hashtag3'>Multisig Address</h3>
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
		<iframe src="bitwasp_script_multisig_address.php" width="100%" scrolling="no" frameborder="no"></iframe>
	</div>
	<div id="form1_tabitem2" class="tab-pane fade">
		<pre style='border-radius:none;'>
<?php echo htmlentities(file_get_contents("bitwasp_script_multisig_address.php"));?>
		</pre> 		
	</div>
</div>
<hr/>
<h3 class="mt-3" id='hashtag2'>Fund & Spend Multisig</h3>
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
		<iframe src="bitwasp_script_multisig_fund.php" width="100%" scrolling="no" frameborder="no"></iframe>
	</div>
	<div id="form2_tabitem2" class="tab-pane fade">
		<pre style='border-radius:none;'>
<?php echo htmlentities(file_get_contents("bitwasp_script_multisig_fund.php"));?>
		</pre> 
	</div>
	
	<div id="form2_tabitem3" class="tab-pane fade">
		<iframe src="bitwasp_script_multisig_spend.php" width="100%" scrolling="no" frameborder="no"></iframe>
	</div>
	<div id="form2_tabitem4" class="tab-pane fade">
		<pre style='border-radius:none;'>
<?php echo htmlentities(file_get_contents("bitwasp_script_multisig_address.php"));?>
		</pre> 
	</div>
</div>
<?php
include_once("html_footer.php");