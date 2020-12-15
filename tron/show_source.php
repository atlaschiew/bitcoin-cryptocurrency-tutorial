<?php
$_HTML['title'] = 'Show Source';
$_HTML['meta']['keywords'] = "Tron, PHP";
include_once "../common.php";
include_once("html_header.php");

if (!in_array($_GET['file'], ['tron_utils.php'])) {
	die("Illegal Access");
}

?>
<h2 class="mt-3"><?Php echo $_GET['file']?></h2>

<pre style='border-radius:none;'><?php echo htmlentities(file_get_contents("tron_utils.php"));?></pre> 		
<?php
include_once("html_footer.php");