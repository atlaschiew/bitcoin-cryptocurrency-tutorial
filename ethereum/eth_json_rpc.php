<?php
$_HTML['title'] = 'Eth JSON RPC';
$_HTML['meta']['keywords'] = "Eth JSON RPC,Eth JSON RPCe in PHP,PHP";
include_once "../common.php";
include_once("html_header.php");

?>
<h2 class="mt-3">Ethereum JSON RPC</h2>
<hr/>
	<p>
		JSON is a lightweight data-interchange format. It can represent numbers, strings, ordered sequences of values, and collections of name/value pairs.
	</p>
	
	<p>
		JSON-RPC is a stateless, light-weight remote procedure call (RPC) protocol. Primarily this specification defines several data structures and the rules around their processing. It is transport agnostic in that the concepts can be used within the same process, over sockets, over HTTP, or in many various message passing environments. It uses JSON (RFC 4627) as data format.
	</p>
	
	<p>
		Source from <a href="https://eth.wiki/json-rpc/api" target="_blank">https://eth.wiki/json-rpc/api</a>.
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
								<iframe src="eth_json_rpc_form.php?method=<?php echo $_GET['method']?>&params=<?php echo urlencode($_GET['params'])?>" width="100%" scrolling="no" frameborder="no"></iframe>
							</div>
							<div id="form1_tabitem2" class="tab-pane fade">
						<pre style='border-radius:none;'><?php echo htmlentities(file_get_contents("eth_json_rpc_form.php"));?></pre> 	
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
								<iframe src="https://www.btcschools.net:2053/ethereum/eth_json_rpc.go" width="100%" scrolling="no" frameborder="no"></iframe>
							</div>
							<div id="form1_tabitem2_go" class="tab-pane fade">
								
								<h5>go/eth_json_rpc.go</h5><hr/>
								<pre style='border-radius:none;'><?php echo htmlentities(file_get_contents("go/eth_json_rpc.go"));?></pre> 		
								
								<hr/><h5>go/templates/eth_json_rpc.html</h5><hr/>
								<pre style='border-radius:none;'><?php echo htmlentities(file_get_contents("go/templates/eth_json_rpc.html"));?></pre> 		
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