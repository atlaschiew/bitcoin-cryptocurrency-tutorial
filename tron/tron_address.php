<?php
$_HTML['title'] = 'Tron Address';
$_HTML['meta']['keywords'] = "Tron Address,Tron Address in PHP,PHP";

define("TRX_TO_SUN",'1000000');
define("SUN_TO_TRX", '0.000001');

include_once "../libraries/vendor/autoload.php";
include_once "../common.php";
include_once("html_header.php");
include_once("tron_utils.php");

?>
<h2 class="mt-3">Tron Address</h2>
<hr/>
	<p>
	The terms wallet, account & address are usually equivalent to each other but instead we use address herein. An address must be associated with its private key otherwise your fund will just lost!
	</p>
	
<hr/>
<ul>
	<li>Start with 'T' or 41 in hex string representation.</li>
	
</ul>

<h3 class="mt-3" id='hashtag1'>Tron Address Generate Locally (Account Not Activated)</h3>
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
		<iframe src="tron_address_form.php" width="100%" scrolling="no" frameborder="no"></iframe>
	</div>
	<div id="form1_tabitem2" class="tab-pane fade">
<pre style='border-radius:none;'><?php echo htmlentities(file_get_contents("tron_address_form.php"));?></pre> 		
	</div>
</div>

<hr id='hashtag2'/>

<p>
	Tron new address is inactive after created. There are few ways to activate address.
	
	<ul>
		<li>Transfer TRX or TRC10 to newly created address and this will burn initiator's <?php echo "0.1"?> Trx for bandwidth (<small>Bandwidth consumed by byte size will be waived automatically.</small>)</li>
		<li>When transferring TRX or TRC10 from a contract to an inactive address, an additional 25,000 energy is consumed. (<small>Creation fee of 0.1 TRX is exempted.</small>)</li>
		<li>Call the CreateAccount contract and this will burn initiator's <?php echo "0.1"?> Trx for bandwidth.</li>
	</ul>
	
	Once address activated, energy and bandwidth will be shown in address resource page.
</p>


<h3 class="mt-3">Activate Tron Address</h3>
<ul class="nav nav-tabs">
	<li class="nav-item">
		<a data-toggle="tab" class="nav-link active" href="#form2_tabitem1">Visual</a>
	</li>
	<li class="nav-item">
		<a data-toggle="tab" class="nav-link" href="#form2_tabitem2">Coding</a>
	</li>
	<li class="nav-item">
		<a data-toggle="tab" class="nav-link" href="#form2_tabitem3">Protobuf Message</a>
	</li>
	<li class="nav-item">
		<a data-toggle="tab" class="nav-link" href="#form2_tabitem4">PHP Built By Protoc</a>
	</li>
</ul>
<div class="tab-content">
	<div id="form2_tabitem1" class="tab-pane fade show active">
		<iframe src="tron_activate_address_form.php" width="100%" scrolling="no" frameborder="no"></iframe>
	</div>
	<div id="form2_tabitem2" class="tab-pane fade">
<pre style='border-radius:none;'><?php echo htmlentities(file_get_contents("tron_activate_address_form.php"));?></pre> 		
	</div>
	
	<div id="form2_tabitem3" class="tab-pane fade">
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
	<div id="form2_tabitem4" class="tab-pane fade">
<pre style='border-radius:none;'><?php echo htmlentities(file_get_contents("protobuf/core/contract/Protocol/AccountCreateContract.php"));?></pre> 		
	</div>
</div>


<?php
include_once("html_footer.php");