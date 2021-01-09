<?php
$_HTML['title'] = 'Tron Station';
$_HTML['meta']['keywords'] = "Tron Station,Tron Station In PHP,PHP";
include_once "../common.php";
include_once("html_header.php");

?>
<h2 class="mt-3">Tron Station</h2>
<hr/>
	<p>
		This page aims to simulate calculator from <a href="https://tronstation.io/">https://tronstation.io/</a>.
	</p>
<hr/>
<h3>Bandwidth</h3>
<p>
Bandwidth is used to transport transaction over the network, it is calculated by byte size. Daily free 5000 bandwiths is available to your address.
</p>
<h3>Energy</h3>
<p>
This is a special resource used to process smart contracts on the TRON network. Smart contracts consume Energy in addition to Bandwidth. According to TRON’s official document, 1 Energy represents 1 microsecond passed while executing smart contracts. 
	
	<h6>The Consumption Process</h6>
	<ol>
		<li>Consume the energy gained by the contract creator from freezing TRX, according to the consume_user_resource_percent ratio set in the contract. If that energy is not enough, continue consuming the contract creator's remaining energy. Any remaining energy shortage is provided by the contract caller.</li>
		
		<li>
		Contract caller consumption process: (First consume the Energy acquired by the caller via freezing TRX, to ensure the contract can be executed normally, and the insufficient part is offset by destroying the TRX).
		</li>
		
		<li>
		If the contract creator does not freeze TRX for the Energy resource, all consumption is required by the caller.
		</li>
	</ol>
	
</p>
<h3>Both Above</h3>
<p>
	<ul>
		<li>You can freeze TRX to gain any one of resource above but not both and TRON POWER will be rewarded in addition to the resource (1 TRX : 1 TRON POWER).</li>
		<li>TRX will be burn if shortage of resource encounter.</li>
	</ul>
</p>

<hr/>
<h3 class="mt-3" id='hashtag3'>Energy By Burning TRX:</h3>
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
		<iframe src="tron_station_energy_burn_trx.php" width="100%" scrolling="no" frameborder="no"></iframe>
	</div>
	<div id="form1_tabitem2" class="tab-pane fade">
<pre style='border-radius:none;'><?php echo htmlentities(file_get_contents("tron_station_energy_burn_trx.php"));?></pre> 		
	</div>
</div>


<h3 class="mt-3" id='hashtag3'>Bandwidth By Burning TRX:</h3>
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
		<iframe src="tron_station_bandwidth_burn_trx.php" width="100%" scrolling="no" frameborder="no"></iframe>
	</div>
	<div id="form2_tabitem2" class="tab-pane fade">
<pre style='border-radius:none;'><?php echo htmlentities(file_get_contents("tron_station_bandwidth_burn_trx.php"));?></pre> 		
	</div>
</div>

<h3 class="mt-3" id='hashtag3'>Energy By Freezing TRX:</h3>
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
		<iframe src="tron_station_energy_freeze_trx.php" width="100%" scrolling="no" frameborder="no"></iframe>
	</div>
	<div id="form3_tabitem2" class="tab-pane fade">
<pre style='border-radius:none;'><?php echo htmlentities(file_get_contents("tron_station_energy_freeze_trx.php"));?></pre> 		
	</div>
</div>

<h3 class="mt-3" id='hashtag3'>Bandwidth By Freezing TRX:</h3>
<ul class="nav nav-tabs">
	<li class="nav-item">
		<a data-toggle="tab" class="nav-link active" href="#form4_tabitem1">Visual</a>
	</li>
	<li class="nav-item">
		<a data-toggle="tab" class="nav-link" href="#form4_tabitem2">Coding</a>
	</li>
</ul>
<div class="tab-content">
	<div id="form4_tabitem1" class="tab-pane fade show active">
		<iframe src="tron_station_bandwidth_freeze_trx.php" width="100%" scrolling="no" frameborder="no"></iframe>
	</div>
	<div id="form4_tabitem2" class="tab-pane fade">
<pre style='border-radius:none;'><?php echo htmlentities(file_get_contents("tron_station_bandwidth_freeze_trx.php"));?></pre> 		
	</div>
</div>

<?php
include_once("html_footer.php");