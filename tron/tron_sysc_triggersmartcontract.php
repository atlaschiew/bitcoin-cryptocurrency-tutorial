<?php
$_HTML['title'] = 'Tron System Contract - Trigger Smart Contract';
$_HTML['meta']['keywords'] = "Tron Trigger Smart Contract,Tron Trigger Smart Contract In PHP,PHP";
include_once "../common.php";
include_once("html_header.php");

?>
<h2 class="mt-3">Tron System Contract . Trigger Smart Contract</h2>
<hr/>
	<p>
		A system contract used to interact with smart contract.
	</p>
	
<hr/>


<h3 class="mt-3" id='hashtag3'>Generate Contract Serialized Hex:</h3>
<ul class="nav nav-tabs">
	<li class="nav-item">
		<a data-toggle="tab" class="nav-link active" href="#form1_tabitem1">Visual</a>
	</li>
	<li class="nav-item">
		<a data-toggle="tab" class="nav-link" href="#form1_tabitem2">Coding</a>
	</li>
	<li class="nav-item">
		<a data-toggle="tab" class="nav-link" href="#form1_tabitem3">Protobuf Message</a>
	</li>
	<li class="nav-item">
		<a data-toggle="tab" class="nav-link" href="#form1_tabitem4">PHP Built By Protoc</a>
	</li>
</ul>
<div class="tab-content">
	<div id="form1_tabitem1" class="tab-pane fade show active">
		<iframe src="tron_sysc_triggersmartcontract_form.php" width="100%" scrolling="no" frameborder="no"></iframe>
	</div>
	<div id="form1_tabitem2" class="tab-pane fade">
<pre style='border-radius:none;'><?php echo htmlentities(file_get_contents("tron_sysc_triggersmartcontract_form.php"));?></pre> 		
	</div>
	<div id="form1_tabitem3" class="tab-pane fade">
<pre style='border-radius:none;'>
message TriggerSmartContract {
	
  #The owner of the current account
  bytes owner_address = 1;
  
  #A contract address to interact
  bytes contract_address = 2;
  
  #TRX value
  int64 call_value = 3;
  
  #Encoded data includes contract function and its params
  bytes data = 4;
}
</pre> 		
	</div>
	
	<div id="form1_tabitem4" class="tab-pane fade">
<pre style='border-radius:none;'><?php echo htmlentities(file_get_contents("protobuf/core/contract/Protocol/TriggerSmartContract.php"));?></pre> 		
	</div>
</div>


<?php
include_once("html_footer.php");