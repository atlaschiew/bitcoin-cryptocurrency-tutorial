<?php
$_HTML['title'] = 'Show Source';
$_HTML['meta']['keywords'] = "Tron, PHP";
include_once "../common.php";
include_once("html_header.php");

if (!in_array($_GET['file'], ['eth_mpt.php','eth_utils.php','../libraries/bcbitwise.php'])) {
	die("Illegal Access");
}

?>
<h2 class="mt-3"><?Php echo $_GET['file']?></h2>
<hr/>
<pre style='border-radius:none;'><?php echo htmlentities(file_get_contents($_GET['file']));?></pre> 		
<?php
include_once("html_footer.php");