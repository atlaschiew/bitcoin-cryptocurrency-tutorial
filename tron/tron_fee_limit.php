<?php
$_HTML['title'] = 'Tron Fee Limit';
$_HTML['meta']['keywords'] = "Tron Fee Limit,Tron Fee Limit In PHP,PHP";
include_once "../common.php";
include_once("html_header.php");

?>
<h2 class="mt-3">Tron Fee Limit</h2>
<hr/>
	<p>
		It is highly recommended to set an appropriate fee limit before deploying/triggering a contract to Mainnet. The fee limit refers to the upper limit of the smart contract deploy/execution cost, in TRX.
	</p>
<hr/>
<ul>
	<li>Measured in SUN.</li>
	<li>The maximum limit is 1000 TRX, or 1e9 SUN.</li>
	<li>Fee limit include both caller's energy by freezing and burning TRX.</li>
	<li>Fee limit not include energy contributed by contract creator.</li>
	<li>More details and out of energy solution in <a href="https://tronfoundation.medium.com/tron-developer-guide-energy-consumption-mechanism-fef83cb25fa5">tron-developer-guide-energy-consumption-mechanism</a>.</li>
</ul>


<h3 class="mt-3" id='hashtag3'>Fee Limit Calculator</h3>
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
		<iframe src="tron_fee_limit_calc.php" width="100%" scrolling="no" frameborder="no"></iframe>
	</div>
	<div id="form1_tabitem2" class="tab-pane fade">
<pre style='border-radius:none;'><?php echo htmlentities(file_get_contents("tron_fee_limit_calc.php"));?></pre> 		
	</div>
	
</div>


<?php
include_once("html_footer.php");