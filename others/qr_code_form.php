<?php 

include_once "../libraries/vendor/autoload.php";
include_once("html_iframe_header.php");

$supportChains = ['bitcoin'=>"Bitcoin", 'bitcoincash'=>"Bitcoin Cash", 'ethereum'=>"Ethereum"];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
       $ch1 = urlencode("{$_POST['chain']}:{$_POST['recipient']}?amount={$_POST['amount']}&message={$_POST['message']}");
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
		<label for="chain">Chain:</label>		
		<?php
		foreach($supportChains as $k=>$v) {
		?>
			<div class="form-check-inline">
				<label class="form-check-label">
				<?php
				echo "<input type='radio' class='form-check-input' name='chain' value='{$k}'".($k == $_POST['chain'] ? " checked": "")."/>{$v}";
				?>
				</label>
			</div>
		<?php
		}
		?>
	</div>
	
	<div class="form-group">
        <label for="recipient">Recipient Address:</label>
        <input class="form-control" type='text' name='recipient' id='recipient' value='<?php echo $_POST['recipient']?>'>
    </div>
	
	<div class="form-group">
        <label for="amount">Amount:</label>
        <input class="form-control" type='text' name='amount' id='amount' value='<?php echo $_POST['amount']?>'>
    </div>
	
	<div class="form-group">
        <label for="message">Message:</label>
        <input class="form-control" type='text' name='message' id='message' value='<?php echo $_POST['message']?>'>
    </div>
   
    <input type='submit' class="btn btn-success btn-block"/>
</form>
<?php
include_once("html_iframe_footer.php");