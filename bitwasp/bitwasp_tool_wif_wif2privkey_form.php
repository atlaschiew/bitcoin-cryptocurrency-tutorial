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
		$privateKey = $privKeyFactory->fromWIF($_POST['wif'], $network);
    ?>
        <div class="table-responsive">
            <table border=0 class='table'>
                <tr><td>Private Key Hex</td><td><?php echo $privateKey->getHex()?></td></tr>
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
        <label for="wif">Wif:</label>
        <input class="form-control" type='text' name='wif' id='wif' value='<?php echo $_POST['wif']?>'>
    </div>
    <input type='submit' class="btn btn-success btn-block"/>
</form>
<?php
include_once("html_iframe_footer.php");