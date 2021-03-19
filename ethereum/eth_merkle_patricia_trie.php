<?php
$_HTML['title'] = 'Eth Merkle Patricia Trie';
$_HTML['meta']['keywords'] = "Eth Merkle Patricia Trie,Eth Merkle Patricia Trie in PHP";
include_once "../common.php";
include_once("html_header.php");

?>
<h2 class="mt-3">Ethereum Merkle Patricia Trie</h2>
<hr/>
	<p>
		Ethereum store address state, contract state, transaction and receipt in key-value mapping but structured by merkle patricia trie structure. There are 3 tries in block header, name <span class='grey_info'>Transaction Trie</span>, <span class='grey_info'>Receipt Trie</span> and <span class='grey_info'>State Trie</span> respectively, each record with their own root hash of trie.
	</p>
	
<hr/>

Some benefits of using merkle patricia trie:
<ul>
	<li>Data Consistency / Verification.</li>
	<li>Merkle Trie proofs are computationally easy and fast.</li>
	<li>Merkle Trie proofs require only a small chunks of data to be broadcasted across a network.</li>
</ul>
Source code available at <a href="show_source.php?file=eth_mpt.php" target="_blank">here</a>.

<h3 class="mt-3" id='hashtag1'>Check Match To TransactionRoot</h3>
<div class='vertical-line-yellow'>
	<u><b>How To Check</b></u><br/>
	For this example, i pick <a href="https://api.etherscan.io/api?module=proxy&action=eth_getBlockByNumber&tag=0xA1A489&boolean=true&apikey=YourApiKeyToken" target="_blank">Block#10593417</a>, get `transactionRoot` from api response and fill in `TransactionRoot (HEX)` field. Next, there are 4 txes in the block, find their raw Tx by navigating to 
	[<a href="https://etherscan.io/getRawTx?tx=0xb0c43213c86c2cacce8ceef965b881529d31e5be93ad6cefcef2f319a20ef1b5" target="_blank">1</a>],
	[<a href="https://etherscan.io/getRawTx?tx=0x5bbbf64bd0f08465acbe30adb2be807488c3847c94a7dfabaffa3e25ab3a604a" target="_blank">2</a>],
	[<a href="https://etherscan.io/getRawTx?tx=0x7d965a103dbb8e2027682e45bd371cf92bb9e15b84d5b2fa0dfa45333879ed12" target="_blank">3</a>] & 
	[<a href="https://etherscan.io/getRawTx?tx=0x0b41fc4c1d8518cdeda9812269477256bdc415eb39c4531885ff9728d6ad096b" target="_blank">4</a>] and fill them line by line in `List Of Raw Tx` field.
</div>
<ul class="nav nav-tabs">
	<li class="nav-item">
		<a data-toggle="tab" class="nav-link active" href="#form2_tabitem1">Visual</a>
	</li>
</ul>
<div class="tab-content">
	<div id="form2_tabitem1" class="tab-pane fade show active">
		<iframe src="eth_mpt.php?type=checktxroot" width="100%" scrolling="no" frameborder="no"></iframe>
	</div>
</div>

<h4 class="mt-3" id='hashtag2'>Verify Merkle Proofs</h4>
<ul class="nav nav-tabs">
	<li class="nav-item">
		<a data-toggle="tab" class="nav-link active" href="#form2_tabitem1">Visual</a>
	</li>
</ul>
<div class="tab-content">
	<div id="form2_tabitem1" class="tab-pane fade show active">
		<iframe src="eth_mpt.php?type=checktxroot_verify" width="100%" scrolling="no" frameborder="no"></iframe>
	</div>
</div>

<?php
include_once("html_footer.php");