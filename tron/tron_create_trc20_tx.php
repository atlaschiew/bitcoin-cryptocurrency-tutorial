<?php
$_HTML['title'] = 'Tron Create Send TRC20 Tx';
$_HTML['meta']['keywords'] = "Tron Create Send TRC20 Transaction,Tron Create Send TRC20 Transaction In PHP,PHP";
include_once "../common.php";
include_once("html_header.php");

?>
<h2 class="mt-3">Tron Create Send TRC20 Tx</h2>
<hr/>
	<p>
	TRC20 (TRC20 Token Standard) is a token standard based on the implementation of smart contract when using TRON network to issue a token.
	</p>
	<p>
	A TRC20 (smart contract compatible token) transfer consumes both bandwidth and energy.
	</p>
	
<hr/>


<h3 class="mt-3" id='hashtag3'>Generate Send TRC20 Raw Tx</h3>
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
		<iframe src="tron_create_send_trc20_form.php" width="100%" scrolling="no" frameborder="no"></iframe>
	</div>
	<div id="form1_tabitem2" class="tab-pane fade">
<pre style='border-radius:none;'><?php echo htmlentities(file_get_contents("tron_create_send_trc20_form.php"));?></pre> 		
	</div>
	
</div>


<?php
include_once("html_footer.php");