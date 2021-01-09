<?php
$_HTML['title'] = 'Tron Create Send TRC10 Tx';
$_HTML['meta']['keywords'] = "Tron Create Send TRC10 Transaction,Tron Create Send TRC10 Transaction In PHP,PHP";
include_once "../common.php";
include_once("html_header.php");

?>
<h2 class="mt-3">Tron Create Send TRC10 Tx</h2>
<hr/>
	<p>
	TRC10
	</p>
	
<hr/>


<h3 class="mt-3" id='hashtag3'>Generate Send TRC10 Raw Tx</h3>
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
		<iframe src="tron_create_send_trc10_form.php" width="100%" scrolling="no" frameborder="no"></iframe>
	</div>
	<div id="form1_tabitem2" class="tab-pane fade">
<pre style='border-radius:none;'><?php echo htmlentities(file_get_contents("tron_create_send_trc10_form.php"));?></pre> 		
	</div>
	
	<div id="form1_tabitem3" class="tab-pane fade">
<pre style='border-radius:none;'>
message TransferAssetContract {
  #
  bytes asset_name = 1;
  
  #
  bytes owner_address = 2;
  
  #
  bytes to_address = 3;
  
  #
  int64 amount = 4;
}
</pre> 		
	</div>
	
	<div id="form1_tabitem4" class="tab-pane fade">
<pre style='border-radius:none;'><?php echo htmlentities(file_get_contents("protobuf/core/contract/Protocol/TransferAssetContract.php"));?></pre> 		
	</div>
	
</div>


<?php
include_once("html_footer.php");