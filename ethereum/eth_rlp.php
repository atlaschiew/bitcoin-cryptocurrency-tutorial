<?php
$_HTML['title'] = 'Ethereum RLP (Recursive Length Prefix)';
$_HTML['meta']['keywords'] = "Ethereum RLP PHP,RLP PHP, Recursive Length Prefix";
include_once "../common.php";
include_once("html_header.php");

?>
<h2 class="mt-3">Ethereum RLP</h2>
<hr/>
	<p>
		RLP (Recursive Length Prefix) is the main encoding method used to serialize objects in Ethereum. Usages include generate raw transaction, data storage.
	</p>
<hr/>

<h3 class="mt-3" id='hashtag3'>RLP Encoder</h3>
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
								<a data-toggle="tab" class="nav-link active" href="#form1_tabitem1_php">Visual</a>
							</li>
							<li class="nav-item">
								<a data-toggle="tab" class="nav-link" href="#form1_tabitem2_php">Coding</a>
							</li>
						</ul>
						<div class="tab-content">
							<div id="form1_tabitem1_php" class="tab-pane fade show active">
								<iframe src="eth_rlp_encoder.php" width="100%" scrolling="no" frameborder="no"></iframe>
							</div>
							<div id="form1_tabitem2_php" class="tab-pane fade">
						<pre style='border-radius:none;'><?php echo htmlentities(file_get_contents("eth_rlp_encoder.php"));?></pre> 		
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
								<iframe src="https://www.btcschools.net:2053/ethereum/eth_rlp_encoder.go" width="100%" scrolling="no" frameborder="no"></iframe>
							</div>
							<div id="form1_tabitem2_go" class="tab-pane fade">
								
								<h5>go/eth_rlp_encoder.go</h5><hr/>
								<pre style='border-radius:none;'><?php echo htmlentities(file_get_contents("go/eth_rlp_encoder.go"));?></pre> 		
								
								<hr/><h5>go/templates/eth_rlp_encoder.html</h5><hr/>
								<pre style='border-radius:none;'><?php echo htmlentities(file_get_contents("go/templates/eth_rlp_encoder.html"));?></pre> 		
								
							</div>
						</div>
					</section>
				</article>
			</div>
		</div>
	</div>
</div>



<h3 class="mt-3" id='hashtag3'>RLP Decoder</h3>
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
		<iframe src="eth_rlp_decoder.php" width="100%" scrolling="no" frameborder="no"></iframe>
	</div>
	<div id="form2_tabitem2" class="tab-pane fade">
<pre style='border-radius:none;'><?php echo htmlentities(file_get_contents("eth_rlp_decoder.php"));?></pre> 		
	</div>
</div>
<?php
include_once("html_footer.php");