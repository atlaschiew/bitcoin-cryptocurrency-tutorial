<?php
$_HTML['title'] = 'Cryptocoin QR Code Generator';
$_HTML['meta']['keywords'] = "Cryptocoin QR Code Generator,Cryptocoin QR Code in PHP";
include_once "../common.php";
include_once("html_header.php");

?>
<h2 class="mt-3">Cryptocoin QR Code Generator</h2>
<hr/>
	<p>
		In this article, btcschool applies google QR service for rapid display. In production, it is advise to have local generator library for better performance.
	</p>
<hr/>

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
		<iframe src="qr_code_form.php" width="100%" scrolling="no" frameborder="no"></iframe>
	</div>
	<div id="form1_tabitem2" class="tab-pane fade">
<pre style='border-radius:none;'><?php echo htmlentities(file_get_contents("qr_code_form.php"));?></pre> 		
	</div>
</div>

<hr/>
	<p>
		In case app scanner doesn't work to meet your expectation, such as ethereum's ERC20 token, you may consider to input recipient address only.
	</p>
<hr/>

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
		<iframe src="qr_code_address_form.php" width="100%" scrolling="no" frameborder="no"></iframe>
	</div>
	<div id="form2_tabitem2" class="tab-pane fade">
<pre style='border-radius:none;'><?php echo htmlentities(file_get_contents("qr_code_address_form.php"));?></pre> 		
	</div>
</div>
<?php
include_once("html_footer.php");