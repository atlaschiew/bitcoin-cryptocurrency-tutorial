<?php 

use BitWasp\Bitcoin\Bitcoin;
use BitWasp\Bitcoin\Network\NetworkFactory;
use BitWasp\Bitcoin\Key\Factory\PrivateKeyFactory;

include_once "../libraries/vendor/autoload.php";
include_once("html_iframe_header.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $networkClass   = $_POST['network'];
        Bitcoin::setNetwork(NetworkFactory::$networkClass());
        $network        = Bitcoin::getNetwork();
        $privKeyFactory = new PrivateKeyFactory();

		if ($_POST['compression'] == 'y') {
			$privateKey = $privKeyFactory->fromHexCompressed($_POST['privkey']);
		} else {
			$privateKey = $privKeyFactory->fromHexUncompressed($_POST['privkey']);
		}

    ?>
        <div class="table-responsive">
            <table border=0 class='table'>
                <tr><td>Wif</td><td><?php echo $privateKey->toWif()?></td></tr>
            </table>
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
        <label for="network">Network:</label>
        <select id="network" name="network" class="form-control" >
            <?php
            $networks = get_class_methods(new NetworkFactory());
            foreach($networks as $network) {
                echo "<option value='{$network}'".($network == $_POST['network'] ? " selected": "").">{$network}</option>";
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="privkey">Private Key (Hex):</label>

        <input class="form-control" type='text' name='privkey' id='privkey' value='<?php echo $_POST['privkey']?>'>
        
    </div>
    <div class="form-group">
        <label for="compression" >Compression:</label>
        <select name="compression" class="form-control" id='compression'>
            <?php
            $yesno = array("y"=>"Yes", "n"=>"No");
            foreach($yesno as $yesno_k=>$yesno_v) {
                echo "<option value='{$yesno_k}'".($yesno_k == $_POST['compression'] ? " selected": "").">{$yesno_v}</option>";
            }
            ?>
        </select>
    </div>
    <input type='submit' class="btn btn-success btn-block"/>
</form>
<?php
include_once("html_iframe_footer.php");