<?php 

include_once "../libraries/vendor/autoload.php";
include_once("html_iframe_header.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
       $ch1 = urlencode($_POST['recipient']);
    ?>
	<div class="alert alert-success">
       <img src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=<?php echo $ch1?>&choe=UTF-8"/>
	</div>
<?php 
    } catch (Exception $e) {
        $errmsg .= "Problem found. " . $e->getMessage();

    }
} 

if ($errmsg) {
?>
    <div class="alert alert-danger">
        <strong>Error!</strong> <?php echo $errmsg?>
    </div>
<?php
}
?>
<form action='' method='post'>
   
	
	<div class="form-group">
        <label for="recipient">Recipient Address:</label>
        <input class="form-control" type='text' name='recipient' id='recipient' value='<?php echo $_POST['recipient']?>'>
    </div>
	
    <input type='submit' class="btn btn-success btn-block"/>
</form>
<?php
include_once("html_iframe_footer.php");