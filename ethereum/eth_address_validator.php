<?php 
use kornrunner\Keccak;

include_once "../libraries/vendor/autoload.php";
include_once("html_iframe_header.php");

class EthAddressValidator
{
	private $addressValid = false;
	private $address = "";
	
	function __construct(string $address) 
	{
		$this->address = $address;
		if ($this->isPatternMatched()) {
			if (!$this->isAllSameCaps()) {
				$this->addressValid = $this->isValidChecksum();	
			} else {
				$this->addressValid = true;
			}
        }
	}
	
    public function isValidAddress(): bool
    {	
        return $this->addressValid;
    }
	
    protected function isPatternMatched(): int
    {
        return preg_match('/^(0x)?[0-9a-f]{40}$/i', $this->address);
    }

    public function isAllSameCaps(): bool
    {
        return preg_match('/^(0x)?[0-9a-f]{40}$/', $this->address) || preg_match('/^(0x)?[0-9A-F]{40}$/', $this->address);
    }

    protected function isValidChecksum(): bool
    {
        $address = str_replace('0x', '', $this->address);
        $hash = Keccak::hash(strtolower($address), 256);

        for ($i = 0; $i < 40; $i++ ) {
            if (ctype_alpha($address{$i})) {
                // Each uppercase letter should correlate with a first bit of 1 in the hash char with the same index,
                // and each lowercase letter with a 0 bit.
                $charInt = intval($hash{$i}, 16);

                if ((ctype_upper($address{$i}) && $charInt <= 7) || (ctype_lower($address{$i}) && $charInt > 7)) {
					
                    return false;
                }
            }
        }

        return true;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   
    $validator = new EthAddressValidator($_POST['address']);
	
	if ($validator->isAllSameCaps() === true) {
	?>
		<div class="alert alert-info">
			<strong>Notice!</strong> Address pattern valid but checksum cannot be verified.
		</div>
	<?php 
	} else if ($validator->isValidAddress() === true) {
?>
		<div class="alert alert-success">
			<strong>Success!</strong> Checksum validation was passed.
		</div>
<?php
	} else {
?>
		<div class="alert alert-danger">
			<strong>Error!</strong> Invalid address.
		</div>	
<?php	
	}
}
?>
<form action='' method='post'>
    <div class="form-group">
        <label for="address">Address:</label>
        <input class="form-control" type='text' name='address' id='address' value='<?php echo $_POST['address']?>'>
    </div>
   
    <input type='submit' class="btn btn-success btn-block"/>
</form>
<?php
include_once("html_iframe_footer.php");