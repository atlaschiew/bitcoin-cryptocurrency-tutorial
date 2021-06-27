<?php
$_HTML['title'] = 'Eth Transaction Nonce';
$_HTML['meta']['keywords'] = "Eth Transaction Nonce,Eth Transaction Nonce in PHP,PHP";
include_once "../common.php";
include_once("html_header.php");

?>
<h2 class="mt-3">Ethereum Transaction Nonce</h2>
<hr/>
	<p>
		By manual way. One can search sender address in block explorer and get its nonce from last send tx, new nonce = last nonce + 1 or nonce start new at 0.
	</p>
<hr/>

<div class="row">
	<div class="vertical-tabs-left">
		<ul class="nav nav-tabs left-tabs sideways-tabs">
			<li class="nav-item">
				<a class="nav-link active" href="#form1_php" data-toggle="tab">PHP</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#form1_go" data-toggle="tab">Go</a>
			</li>
		</ul>
	</div>

	<div class="vertical-tabs-right" >

		<div class="">
			<div class="tab-content" >
				<article class="tab-pane  active" id="form1_php" >
					<section >
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
								<iframe src="eth_tx_nonce_form.php" width="100%" scrolling="no" frameborder="no"></iframe>
							</div>
							<div id="form1_tabitem2" class="tab-pane fade">
						<pre style='border-radius:none;'><?php echo htmlentities(file_get_contents("eth_tx_nonce_form.php"));?></pre> 		
							</div>
						</div>
					</section>
				</article>
				<article class="tab-pane " id="form1_go">
					<section>
						<ul class="nav nav-tabs">
							<li class="nav-item">
								<a data-toggle="tab" class="nav-link active" href="#form1_tabitem1_go">Visual</a>
							</li>
							<li class="nav-item">
								<a data-toggle="tab" class="nav-link" href="#form1_tabitem2_go">Coding</a>
							</li>
						</ul>
						<div class="tab-content">
							<div id="form1_tabitem1_go" class="tab-pane fade show active">
								<iframe src="https://www.btcschools.net:2053/ethereum/eth_tx_nonce.go" width="100%" scrolling="no" frameborder="no"></iframe>
							</div>
							<div id="form1_tabitem2_go" class="tab-pane fade">
								
								<h5>go/eth_tx_nonce.go</h5><hr/>
								<pre style='border-radius:none;'><?php echo htmlentities(file_get_contents("go/eth_tx_nonce.go"));?></pre> 		
								
								<hr/><h5>go/templates/eth_tx_nonce.html</h5><hr/>
								<pre style='border-radius:none;'><?php echo htmlentities(file_get_contents("go/templates/eth_tx_nonce.html"));?></pre> 		
								
							</div>
						</div>
					</section>
				</article>
			</div>
		</div>
	</div>
</div>
<?php
include_once("html_footer.php");