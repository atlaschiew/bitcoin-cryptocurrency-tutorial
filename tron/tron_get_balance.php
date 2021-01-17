<?php
$_HTML['title'] = 'Tron Get Balances';
$_HTML['meta']['keywords'] = "Tron Get Balances,Tron Get Balances In PHP,Tron Get TRX balance, Tron Get TRC20 Balance, Tron Get TRC10 Balance";
include_once "../common.php";
include_once("html_header.php");

?>
<h2 class="mt-3">Tron Get Balances</h2>
<hr/>
	<p>
		Ways to query TRX, TRC10 or TRC20 balance.
	</p>
<hr/>
<h3 class="mt-3" id='hashtag3'>Get TRX Balance:</h3>
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
		<iframe src="tron_get_balance_trx.php" width="100%" scrolling="no" frameborder="no"></iframe>
	</div>
	<div id="form1_tabitem2" class="tab-pane fade">
<pre style='border-radius:none;'><?php echo htmlentities(file_get_contents("tron_get_balance_trx.php"));?></pre> 		
	</div>
</div>


<h3 class="mt-3" id='hashtag3'>Get TRC10 Balance:</h3>
<ul class="nav nav-tabs">
	<li class="nav-item">
		<a data-toggle="tab" class="nav-link active" href="#form2_tabitem1">Visual</a>
	</li>
	<li class="nav-item">
		<a data-toggle="tab" class="nav-link" href="#form2_tabitem2">Coding</a>
	</li>
</ul>
<div class="tab-content">
	<div id="form2_tabitem1" class="tab-pane fade show active">
		<iframe src="tron_get_balance_trc10.php" width="100%" scrolling="no" frameborder="no"></iframe>
	</div>
	<div id="form2_tabitem2" class="tab-pane fade">
<pre style='border-radius:none;'><?php echo htmlentities(file_get_contents("tron_get_balance_trc10.php"));?></pre> 		
	</div>
</div>

<h3 class="mt-3" id='hashtag3'>Get TRC20 Balance:</h3>
<ul class="nav nav-tabs">
	<li class="nav-item">
		<a data-toggle="tab" class="nav-link active" href="#form3_tabitem1">Visual</a>
	</li>
	<li class="nav-item">
		<a data-toggle="tab" class="nav-link" href="#form3_tabitem2">Coding</a>
	</li>
</ul>
<div class="tab-content">
	<div id="form3_tabitem1" class="tab-pane fade show active">
		<iframe src="tron_get_balance_trc20.php" width="100%" scrolling="no" frameborder="no"></iframe>
	</div>
	<div id="form3_tabitem2" class="tab-pane fade">
<pre style='border-radius:none;'><?php echo htmlentities(file_get_contents("tron_get_balance_trc20.php"));?></pre> 		
	</div>
</div>

<?php
include_once("html_footer.php");