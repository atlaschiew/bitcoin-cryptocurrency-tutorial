<?php 
use kornrunner\Keccak;

include_once "../libraries/vendor/autoload.php";
include_once "eth_utils.php";
include_once "../libraries/bcbitwise.php";
include_once "html_iframe_header.php";

class BtcschoolsBloomFilter {
	
	private $value = "0";
	private $storageBits = 2048;
	private $requiredBits = 3;
	
	public function getLogsBloom(): string {
		$hexStringLen = ($this->storageBits / 8) * 2;
		return str_pad(bcdechex($this->value),$hexStringLen, "0", STR_PAD_LEFT); 
	}
	
	private function getBits(string $value): array {
		$hashValue = Keccak::hash(hex2bin($value), 256);
		
		$chunks = [];
		for($i=0; $i < $this->requiredBits;$i++) {
			$offset = ($i * 4);
			$chunks[] = substr($hashValue,$offset,4);
		}
		
		$bits = [];
		
		foreach($chunks as $chunk) {
			
			list($high, $low) = str_split($chunk, 2);
	
			$high = hexdec($high);
			$low  = hexdec($low);
			
			$bits[] = bcBitwise::bcLeftShift("1", (string)(($low + ($high << 8)) & $this->storageBits-1));
		}
		
		return $bits;
	}
	
	public function insert(string $value): void {
		
		$bits = $this->getBits($value);
		
		foreach($bits as $bit) {
			$this->value = bcBitwise::bcOR($this->value, $bit);
		}
		
	}
	
	public function contain($logsBloom, $value): bool {
		
		$bits = $this->getBits($value);
		$checkPass = 0;
		foreach($bits as $bit) {
			
			if (bccomp(bcbitwise::bcAND(bchexdec($logsBloom),$bit), $bit) === 0) {
				$checkPass++;
			} 
			
		}	
		
		return $checkPass == $this->requiredBits;
	}
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	
	$bf = new BtcschoolsBloomFilter();
	
	try {
		
		if ($_GET['type'] == 'generate') {
			$items = explode("\n", trim($_POST['items']));
			
			foreach($items as $k=>$item) {
				$item = trim($item);
				if (!ctype_xdigit($item)) {
					throw new Exception("Item[".($k+1)."] must be hex string without 0x prefix.");
				}
				$bf->insert($item);
			}
			
			$result = $bf->getLogsBloom();
?>
			<div class="alert alert-success">
				<h6 class="mt-3">logsBloom</h6>
				<textarea class="form-control" rows="5" id="comment" readonly><?php echo $result;?></textarea>
			</div>
			<?php	
			
		} else if ($_GET['type'] == 'search') {
			
			if (!ctype_xdigit($_POST['logs_bloom'])) {
				throw new Exception("logsBloom must be hex string without 0x prefix.");
			} else if (!ctype_xdigit($_POST['search_item'])) {
				throw new Exception("Search item must be hex string without 0x prefix.");
			}
			
			if ($bf->contain($_POST['logs_bloom'], $_POST['search_item']) === true) {
			?>
				
				<div class="alert alert-success">
					Result has found!
				</div>
			<?php
			} else {
			?>
				<div class="alert alert-danger">
					Result not found!
				</div>
			<?php
			}
		}
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
<form id='this_form' action='?<?php echo $_SERVER['QUERY_STRING']?>' method='post'>
	<?php
	if ($_GET['type'] == 'generate') {
	?>
	<div class="form-group">
		<label for="items">Items To Insert:</label>
		<textarea rows=10 class="form-control" name='items' id='items'><?php echo $_POST['items']?></textarea>
		<small>
		Each item must key in by press "Enter" and place it as new line and insert item is not order-dependent.

		</small>
	</div>
	<?php
	} else if ($_GET['type'] == 'search') {
	?>
	<div class="form-group">
        <label for="logs_bloom">logsBloom:</label>
        <input class="form-control" type='text' name='logs_bloom' id='logs_bloom' value='<?php echo $_POST['logs_bloom']?>'>
    </div>
	
	<div class="form-group">
        <label for="search_item">Search Item:</label>
        <input class="form-control" type='text' name='search_item' id='search_item' value='<?php echo $_POST['search_item']?>'>
    </div>
	<?php
	}
	?>
    <input type='submit' class="btn btn-success btn-block"/>
</form>
<?php
include_once("html_iframe_footer.php");