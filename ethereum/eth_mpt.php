<?php
set_time_limit(5);
/* due to version conflict with the one in vendor/, so i manually clone this package to new folder and include without autoload*/
include_once("../libraries/web3p/rlp/Types/Str.php");
include_once("../libraries/web3p/rlp/Types/Numeric.php");
include_once("../libraries/web3p/rlp/RLP.php");
include_once "../libraries/vendor/autoload.php";
include_once("html_iframe_header.php");

use Web3p\RLP\RLP;
use kornrunner\Keccak;

class levelDbMockOnly {
	
	private $storage = [];
	
	function get($k) {
		return $this->storage[$k];
	}
	
	function put($k, $v) {
		$this->storage[$k] = $v;
		
		return $this;
	}
	
	function delete($k) {
		unset($this->storage[$k]);
	}
	
	function dump() {
		echo "<pre>";
		print_r($this->storage);
		echo "</pre>";
		echo "<h1>".count($this->storage)."</h1>";
	}
}

class Utils {
	static function debug($var) {
		echo "<pre>"; print_r($var);echo "</pre>";
	}
	
	static function hexToNibbles($hex) {
		
		$bin = hex2bin($hex);//accept only even length hex string,otherwise error thrown
		$nibbles = [];

		for ($i = 0; $i < strlen($bin); $i++) {
			$q = $i * 2;
			$nibbles[$q] = ord($bin[$i]) >> 4;
			++$q;
			$nibbles[$q] = ord($bin[$i]) % 16;
		}

		return $nibbles;
	}
	
	static function nibblesToHex($nibbles) {
		$buf = [];
		for ($i = 0; $i < count($nibbles) / 2; $i++) {
			$q = $i * 2;
			$buf[$i] = dechex(($nibbles[$q] << 4) + $nibbles[++$q]);
		}
		return implode("",$buf);
	}
	
	static function matchNibbleLength($match, $with) {
		$i = 0;
		$totalMatch = count($match);
		while ($match[$i] === $with[$i] && $totalMatch > $i) {
			$i++;
		}
		return $i;
	}
	
	static function addHexPrefix($nibbles, $terminator) {
		// odd
		if (count($nibbles) % 2) {
			array_unshift($nibbles, 1);
		} else {
			// even
			array_unshift($nibbles, 0);
			array_unshift($nibbles, 0);
		}

		if ($terminator === true) {
			$nibbles[0] += 2;
		}

		return $nibbles;
	}
	
	static function removeHexPrefix($nibbles) {
		if ($nibbles[0] % 2) {
			$newNibbles = array_slice($nibbles, 1);
		}
		else {
			$newNibbles = array_slice($nibbles, 2);
		}
		return $newNibbles;
	}
	
	static function isTerminator($nibbles) {
		return $nibbles[0] > 1;
	}
	
	static function getType($dbValues) {
		
		if (count($dbValues) == 17) {
			$type = "BranchNode";
		} else if (count($dbValues) == 2) {
			$encodedPath = $dbValues[0];
			$nibbles = Utils::hexToNibbles($encodedPath);
			
			if (Utils::isTerminator($nibbles)) {
				$type = "LeafNode";
			} else {
				$type = "ExtensionNode";
			}
		} else {
			//error
		}
		return $type;
	}
	
	static function decode($input /* $rlpedDbValue | dbValues[] */) {
		$rlp = new RLP;
		
		if (is_string($input)) {
			$dbValues = $rlp->decode($input);
		} else {
			$dbValues = $input;
		}
		
		$classNode = Utils::getType($dbValues);
		
		if ($classNode == 'LeafNode' OR $classNode == 'ExtensionNode') {
			$encodedPath = $dbValues[0];
			$nibblesPath = Utils::removeHexPrefix(Utils::hexToNibbles($encodedPath));
			$rlpedNodeValue = $dbValues[1];
			
		
			$node = new $classNode($nibblesPath, $rlpedNodeValue);
		} else {
			$node = new BranchNode();
			
			foreach($dbValues as $k=>$dbValue) {
				$node->setBranch($k, $dbValue);
			}
			
		}
		return $node;
	}
	
	static function add0xPrefix($input) {
		
		if (is_array($input)) {
			$input = array_map('Utils::add0xPrefix', $input);
		} else if (is_string($input)) {
			$input = "0x" . $input;
		} else {
			$input = null;
		}
		return $input;
	}
	
	static function verifyProof($root, $inputPathNibbles, $proofs) {
		
		$db = new levelDbMockOnly();
		$newTrie = new Trie($root, $db);
		
		foreach($proofs as $rlpedDbValue) {
			$dbKey = Keccak::hash(hex2bin($rlpedDbValue), 256); 
			$newTrie->db->put($dbKey, $rlpedDbValue);
		}
		
		$result = $newTrie->get($inputPathNibbles);
		return $result === false ? false : $result;
		
	}
	
	static function createProof($trie, $inputPathNibbles) {
		$root = $trie->root;
		if ($root AND ($findPathResult = $trie->findPath($inputPathNibbles)) !== false) {
			extract($findPathResult);
			
			$newStack = array_map(function($node) {
				return $node->info()['rlpedDbValue'];
			}, $stack);
			
			return $newStack;
		}
		
		return false;
		
	}
}

class LeafNode {
	
	protected $nibblesPath = [];
	protected $encodedPath = "";    //add hex prefix, even length
	protected $rlpedNodeValue = "";   //rlp encoded string
	protected $rlpedDbValue = ""; //rlp encoded string to store as value in level db
	protected $dbValues = [];
	protected $dbKey = "";         //sha3 dbKey string to store as key in level db
	protected $nodeRef = "";       //node reference to be refer by parent node

	function __construct($nibblesPath,$rlpedNodeValue ) {
		
		
		$this->nibblesPath = $nibblesPath;
		
		$this->rlpedNodeValue = $rlpedNodeValue;
		$this->encodePath();
		$this->dbValues = [$this->encodedPath, $this->rlpedNodeValue];
		$this->hash();
		$this->encodeDbValue();
		
	}
	
	function encodePath() {
		
		$nibbles = Utils::addHexPrefix($this->nibblesPath, true);
		$this->encodedPath = Utils::nibblesToHex($nibbles);
		
		return;
	}
	
	function hash() {
		
		$toBeEncoded = Utils::add0xPrefix($this->dbValues);
		
		$rlp = new RLP;
		$this->dbKey = Keccak::hash(hex2bin($rlp->encode($toBeEncoded)),256);
		return;
	}
	
	function encodeDbValue() {

		$toBeEncoded = Utils::add0xPrefix($this->dbValues);
		
		$rlp = new RLP;
		$this->rlpedDbValue = $rlp->encode($toBeEncoded);
		return;
	}
	
	function info() {
		if (strlen($this->rlpedDbValue) >= 64) {
			$this->nodeRef = $this->dbKey;
		} else {
			$this->nodeRef = $this->dbValues;
		}
		
		return ["nodeRef"        => $this->nodeRef,
			    "nibblesPath"     => $this->nibblesPath, 
		        "encodedPath"    => $this->encodedPath, 
				"rlpedNodeValue"   => $this->rlpedNodeValue, 
				"rlpedDbValue" => $this->rlpedDbValue,  
				"dbKey"         => $this->dbKey,
				"dbValues" => $this->dbValues
			   ];
	}
}

class ExtensionNode Extends LeafNode {
	function encodePath() {
		$nibbles = Utils::addHexPrefix($this->nibblesPath, false);
		$this->encodedPath = Utils::nibblesToHex($nibbles);
		return;
	}
}

class BranchNode {
	
	private $rlpedDbValue = ""; //rlp encoded string to store as value in level db
	private $dbValues = [];
	private $dbKey = "";         //sha3 dbKey string to store as key in level db
	private $branches = []; // index#[0-F] is path nibble, index#16 is value, total 17 items
	private $nodeRef = "";
	
	function __construct() {
		$this->branches = array_fill(0, 17, null);
	}
	
	function setBranch($index, $value) {
		$this->branches[$index] = $value;
		$this->info();
	}
	
	function getBranch($index) {
		return $this->branches[$index];
	}
	
	function setNodeValue($value) {
		$this->setBranch(16, $value);
	}
	
	function hash() {
		$toBeEncoded = Utils::add0xPrefix($this->dbValues);
		
		$rlp = new RLP;
		$this->dbKey = Keccak::hash(hex2bin($rlp->encode($toBeEncoded)),256);
		return;
	}
	
	function encodeDbValue() {
		
		$toBeEncoded = Utils::add0xPrefix($this->dbValues);
		
		$rlp = new RLP;
		$this->rlpedDbValue = $rlp->encode($toBeEncoded);
		return;
	}
	
	function info() {
		
		$this->dbValues = $this->branches;
		$this->hash();
		$this->encodeDbValue();
		
		if (strlen($this->rlpedDbValue) >= 64) {
			$this->nodeRef = $this->dbKey;
		} else {
			$this->nodeRef = $this->dbValues;
		}
		
		return ["nodeRef"        => $this->nodeRef,
				"rlpedNodeValue"   => $this->getBranch(16), 
				"rlpedDbValue" => $this->rlpedDbValue,  
				"dbKey"         => $this->dbKey,
				"dbValues" => $this->dbValues
			   ];
	}
}

class Trie {
	
	public $root = "";
	public $db;
	
	function __construct($root, $db) { 
		$this->root = $root;
		$this->db = $db;
	}
	
	//find node by traverse trie from up down and store into stack
	function findPath($inputPathNibbles) {
		$root = $this->root;
		if ($root) {
			$encodedNode = $this->db->get($root);
			$newNode = Utils::decode($encodedNode);//decoded node
			$stack = [];
			do {
				$stack[] = $newNode;
				$matchLen = Utils::matchNibbleLength($pathProgress, $inputPathNibbles);
				$pathReminder = array_slice($inputPathNibbles, $matchLen);
				$pathProgress = array_slice($inputPathNibbles, 0, $matchLen);
				
				$thisNode = $newNode;
				unset($newNode);
				if (get_class($thisNode) == 'LeafNode') {
					$matchLen = Utils::matchNibbleLength($pathReminder, $thisNode->info()['nibblesPath']);
					
					if ($matchLen == count($pathReminder) AND $matchLen == count($thisNode->info()['nibblesPath'])) {
						$pathReminder = [];
					} 
					
				} else if (get_class($thisNode) == 'ExtensionNode') {
					$matchLen = Utils::matchNibbleLength($pathReminder, $thisNode->info()['nibblesPath']);
					
					if ($matchLen == count($thisNode->info()['nibblesPath'])) {
						
						$pathProgress = array_merge($pathProgress, $thisNode->info()['nibblesPath']);
						$childNode = $thisNode->info()['dbValues'][1];
						
						if (is_string($childNode)) {
							$encodedNode = $this->db->get($childNode);
							$newNode = Utils::decode($encodedNode);//decoded node
						} else {
							$newNode = Utils::decode($childNode);//decoded node
						}
					}
				} else if (get_class($thisNode) == "BranchNode") {
					
					if(count($pathReminder)) {
						
						$brandIndex = $pathReminder[0];
						$childNode = $thisNode->getBranch($brandIndex);
						if($childNode) {
							if (is_string($childNode)) {
								$encodedNode = $this->db->get($childNode);
								$newNode = Utils::decode($encodedNode);//decoded node
							} else {
								$newNode = Utils::decode($childNode);//decoded node
							}
							$pathProgress[] = $brandIndex;
						}
					}
				}
			} while($newNode);
			
			return ['pathReminder'=>$pathReminder,'stack' =>$stack];
		}
		
		return false;
	}
	
	function get($inputPathNibbles) {
		$root = $this->root;
		if ($root AND ($findPathResult = $this->findPath($inputPathNibbles)) !== false) {
			
			extract($findPathResult);
			
			if (count($pathReminder) === 0) {
				$lastNode = array_pop($stack);
				return $lastNode->info()['rlpedNodeValue'];
			}
		}
		
		return false;
	}
	
	function put($inputPathNibbles, $inputRlpedNodeValue) {
		
		$root = $this->root;
		if (!$root) {
			//no root, create leaf node
			$node = new LeafNode($inputPathNibbles, $inputRlpedNodeValue);
			$nodeInfo = $node->info();
			$this->db->put($nodeInfo['dbKey'], $nodeInfo['rlpedDbValue']);
			$root = $nodeInfo['dbKey'];
		} else if(($findPathResult = $this->findPath($inputPathNibbles)) !== false) {
			
			extract($findPathResult);//extract $pathReminder and $stack
			
			//process remaining path, continue from last node from stack
			$lastNode = array_pop($stack);
			$lastNodeType = get_class($lastNode);
			if ($lastNodeType == 'BranchNode') {
				$stack[] = $lastNode;
				if (count($pathReminder) > 0) {
					$branchIndex = array_shift($pathReminder);
					$newLeafNode = new LeafNode($pathReminder, $inputRlpedNodeValue);
					$stack[] = $newLeafNode;
				} else {
					$lastNode->setNodeValue($inputRlpedNodeValue);
				} 
			} else {
				
				$matchLeaf = false;

				if ($lastNodeType == "LeafNode") {
					$prefixLen = 0;
					for ($i = 0; $i < count($stack); $i++) {
						$n = $stack[$i];
						if (get_class($n) == "BranchNode") {
							$prefixLen++;
						} else {
							$prefixLen += count($n->info()['nibblesPath']);
						}
					}

					if (Utils::matchNibbleLength($lastNode->info()['nibblesPath'], array_slice($inputPathNibbles,$prefixLen)) === count($lastNode->info()['nibblesPath']) AND count($pathReminder) === 0) {
						$matchLeaf = true;
					}
				}
					
				if ($matchLeaf) {	
					//update lastNode's value
					$newLeafNode = new LeafNode($lastNode->info()['nibblesPath'], $inputRlpedNodeValue);
					$stack[] = $newLeafNode;

				} else {
					
					$thisNodeNibbles = $lastNode->info()['nibblesPath'];

					//create new branch
					$newBranchNode = new BranchNode();
					
					//create new ext node
					$matchLen = Utils::matchNibbleLength($thisNodeNibbles, $pathReminder);
					
					if ($matchLen > 0) {
						
						$pathReminder = array_slice($pathReminder, $matchLen);
						
						$newExtNode = new ExtensionNode(array_slice($thisNodeNibbles, 0, $matchLen), null/*to be replace upon process stack*/);
						$thisNodeNibbles = array_slice($thisNodeNibbles, $matchLen);
						$stack[] = $newExtNode;
						
					}
					
					$stack[] = $newBranchNode;
					
					if (count($thisNodeNibbles) > 0) {
						$branchIndex = array_shift($thisNodeNibbles);
						
						if (count($thisNodeNibbles) > 0 OR $lastNodeType == 'LeafNode') {
							
							$newLeafOrExtNode = new $lastNodeType($thisNodeNibbles, $lastNode->info()['rlpedNodeValue']);
							$newBranchNode->setBranch($branchIndex, $newLeafOrExtNode->info()['nodeRef']);
							
							if (is_string($newLeafOrExtNode->info()['nodeRef'])) {
								
								$this->db->put($newLeafOrExtNode->info()['nodeRef'],$newLeafOrExtNode->info()['rlpedDbValue']);
							}
							
						} else {
							
							//remove extension node from db
							if (is_string($lastNode->info()['nodeRef'])) {
								$this->db->delete($lastNode->info()['nodeRef']);
							}
							
							$newBranchNode->setBranch($branchIndex, $lastNode->info()['nodeRef']);
						}
					} else {
						
						$newBranchNode->setNodeValue($lastNode->info()['rlpedNodeValue']);
					} 

					if (count($pathReminder) > 0) {
						
						array_shift($pathReminder);
						
						$newLeafNode = new LeafNode($pathReminder, $inputRlpedNodeValue); 
						$stack[] = $newLeafNode;
					} else {
						$newBranchNode->setNodeValue($inputRlpedNodeValue);
					}
				}
			}
			
			//process stack 
			$root = "";
			$unprocessedPathNibbles = $inputPathNibbles;
			do {
				$lastNode = array_pop($stack);
				
				if (get_class($lastNode) ==  'ExtensionNode') {
					
					$unprocessedPathNibbles = array_slice($unprocessedPathNibbles,0,count($unprocessedPathNibbles) - count($lastNode->info()['nibblesPath']));
					
					if ($root) {
						$lastNode = new ExtensionNode($lastNode->info()['nibblesPath'],$root);
					}
				} else if (get_class($lastNode) == 'LeafNode') {
					$unprocessedPathNibbles = array_slice($unprocessedPathNibbles, 0, count($unprocessedPathNibbles) - count($lastNode->info()['nibblesPath']));
					
				} else if (get_class($lastNode) == 'BranchNode') {
					
					if ($root) {
						$branchIndex = array_pop($unprocessedPathNibbles);
						$lastNode->setBranch($branchIndex, $root);
					}
				} 
				
				if (!count($stack)) { //reach top level
					$root = $lastNode->info()['dbKey'];
					$this->db->put($root, $lastNode->info()['rlpedDbValue']);
				} else {
					$root = $lastNode->info()['nodeRef'];
				
					if (is_string($root)) {
						$this->db->put($root, $lastNode->info()['rlpedDbValue']);
					}
				}
				
			} while(count($stack) > 0);
		}
		$this->root  = $root;
	}
}
?>
<form id='this_form' action='?<?php echo $_SERVER['QUERY_STRING']?>' method='post'>
<?php
if ($_GET['type'] == "checktxroot") {
	
	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		
		try {
			$rlp = new RLP;
			$db = new levelDbMockOnly();
			$trie = new Trie($root, $db);

			$rawTxs = explode("\n", trim($_POST['raw_txs']));
			
			$txHash4Proof = str_replace("0x", "", $_POST['txhash4proof']);
			$txIndex4Proof = null;
			foreach($rawTxs as $txIndex=>$rawTx) {
				$rawTx = str_replace("0x", "", trim($rawTx));
				$txHash = Keccak::hash(hex2bin($rawTx), 256);
				
				if ($txHash == $txHash4Proof) {
					$txIndex4Proof = $txIndex;
				}
				
				$trie->put(Utils::hexToNibbles($rlp->encode($txIndex)), $rawTx);
			}
			
			if (strlen($txHash4Proof) > 0 AND $txIndex4Proof === null) {
				throw new Exception("Tx hash not found in block.");
			}
			
			$matchTxRoot = str_replace("0x", "", $_POST['txroot']);
			
			if ($matchTxRoot != $trie->root) {
				throw new Exception("Transaction root not matched");
			}
			
			?>
				<div class="alert alert-success">
					<strong>Success</strong> TransactionRoot matched!
					
					<?php 
					if (strlen($txHash4Proof) > 0) { 
					?>
					<h6 class="mt-3">Merkle Proofs</h6>
					<?php
						$proofs = Utils::createProof($trie, Utils::hexToNibbles($rlp->encode($txIndex4Proof)));
					?>
						<textarea class="form-control" rows="5" readonly><?php foreach($proofs as $proof) echo trim($proof) . "\n";?></textarea>
						<small>Copy and click <a href="#hashtag2" target="_parent">here</a> to verify.</small>
					<?php
					}
					?>
				</div>
			<?php
		} catch (Exception $e) {
		?>		
			<div class="alert alert-danger">
				<strong>Error</strong> <?php echo $e->getMessage()?>
			</div>
		<?php 
		}
	}
?>
	<div class="form-group">
        <label for="txroot">TransactionRoot (Hex):</label>
        <input class="form-control" type='text' name='txroot' id='txroot' value='<?php echo $_POST['txroot']?>'>
    </div>
	
	<div class="form-group">
        <label for="raw_txs">List Of Raw Tx (order-dependent):</label>
        <textarea class="form-control" rows="10" name='raw_txs' id='raw_txs' placeholder=''><?php echo $_POST['raw_txs']?></textarea>
		<small>
		Press enter key to place new tx id in new line.
		</small>
    </div>
	
	<div class="form-group">
        <label for="txhash4proof">Transaction Hash Used To Create Merkle Proof (Optional):</label>
        <input class="form-control" type='text' name='txhash4proof' id='txhash4proof' value='<?php echo $_POST['txhash4proof']?>'>
		<small>
			Please ensure tx hash did exist in same block with filled in `TransactionRoot`.
		</small>
    </div>
	
	<input type='submit' class="btn btn-success btn-block"/>
<?php	
} else if ($_GET['type'] == 'checktxroot_verify') {
	
	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		
		try {
			$rlp = new RLP;
			$txHash4Proof = str_replace("0x", "", $_POST['txhash4proof']);
			$txRoot = str_replace("0x", "", $_POST['txroot']);
			$proofs = explode("\n", trim($_POST['proofs']));
			$proofs = array_map(function($item) { return str_replace("0x", "", trim($item));}, $proofs );
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL,"https://cloudflare-eth.com");
			curl_setopt($ch, CURLOPT_POSTFIELDS,'{"jsonrpc":"2.0","method":"eth_getTransactionByHash","params":["0x'.$txHash4Proof.'"],"id":1615977844}');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
			$resp = curl_exec($ch);
			
			$txIndex = json_decode($resp,true)['result']['transactionIndex'];
			$txIndex = hexdec($txIndex);
						
			curl_close($ch);
			
			$result = Utils::verifyProof($txRoot, Utils::hexToNibbles($rlp->encode($txIndex)),$proofs);
			
			
			if ($result === false ) {
				throw new Exception("Merkle proofs cannot be verified.");
			} 
			?>
				<div class="alert alert-success">
					Merkle proofs verified. Result is <?php echo $result?>.
				</div>
			<?php
		} catch(Exception $e) {
		?>
			<div class="alert alert-danger">
				<strong>Error</strong> <?php echo $e->getMessage()?>
			</div>
		<?php
		}
	}
?>
	<div class="form-group">
        <label for="txroot">TransactionRoot (Hex):</label>
        <input class="form-control" type='text' name='txroot' id='txroot' value='<?php echo $_POST['txroot']?>'>
    </div>
	
	<div class="form-group">
        <label for="proofs">List Of Proofs (order-dependent):</label>
        <textarea class="form-control" rows="10" name='proofs' id='proofs' placeholder=''><?php echo $_POST['proofs']?></textarea>
		<small>
		Press enter key to place new proof in new line.
		</small>
    </div>
	
	<div class="form-group">
        <label for="txhash4proof">Transaction Hash To Check:</label>
        <input class="form-control" type='text' name='txhash4proof' id='txhash4proof' value='<?php echo $_POST['txhash4proof']?>'>
    </div>
	
	<input type='submit' class="btn btn-success btn-block"/>
<?php	
}
?>
</form>
<?php
include_once("html_iframe_footer.php");