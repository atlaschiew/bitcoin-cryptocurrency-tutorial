<?php
$_HTML['title'] = 'Tron System Contract - Account Create Contract';
$_HTML['meta']['keywords'] = "Tron Account Create Contract,Tron Account Create Contract In PHP,PHP";
include_once "../common.php";
include_once("html_header.php");

?>
<h2 class="mt-3">Tron System Contract . Account Create Contract</h2>
<hr/>
	<p>
	Account create contract (system contract) is used to activate address.
	</p>
	
	<p>
	Once address activated, energy and bandwidth will be shown in address resource page.
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
		<iframe src="tron_activate_address_form.php" width="100%" scrolling="no" frameborder="no"></iframe>
	</div>
	<div id="form1_tabitem2" class="tab-pane fade">
<pre style='border-radius:none;'><?php echo htmlentities(file_get_contents("tron_activate_address_form.php"));?></pre> 		
	</div>
	<div id="form1_tabitem3" class="tab-pane fade">
<pre style='border-radius:none;'>
message AccountCreateContract {
	
	#The owner of the current account
	bytes owner_address = 1;
	
	#The target address to create
	bytes account_address = 2;
	
	#Account type. 0 = normal account, 1 = asset issue genesis account, 2 = contract account
	AccountType type = 3;
}
</pre> 		
	</div>
	
	<div id="form1_tabitem4" class="tab-pane fade">
<pre style='border-radius:none;'><?php echo htmlentities(file_get_contents("protobuf/core/contract/Protocol/AccountCreateContract.php"));?></pre> 		
	</div>
</div>


<?php
include_once("html_footer.php");