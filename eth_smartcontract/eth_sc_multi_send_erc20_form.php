<?Php
$abi = '[{"constant":false,"inputs":[{"name":"token","type":"address"},{"name":"recipients","type":"address[]"},{"name":"values","type":"uint256[]"}],"name":"multiSendArrayAmount","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":false,"inputs":[{"name":"token","type":"address"}],"name":"withdraw","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[],"name":"getEthBalance","outputs":[{"name":"","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[],"name":"getOwner","outputs":[{"name":"","type":"address"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[],"name":"owner","outputs":[{"name":"","type":"address"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[],"name":"withdrawEth","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":false,"inputs":[{"name":"token","type":"address"},{"name":"recipients","type":"address[]"},{"name":"values","type":"uint256"}],"name":"multiSendFixedAmount","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"inputs":[],"payable":false,"stateMutability":"nonpayable","type":"constructor"},{"payable":true,"stateMutability":"payable","type":"fallback"}]';

$bytecode = "608060405234801561001057600080fd5b50336000806101000a81548173ffffffffffffffffffffffffffffffffffffffff021916908373ffffffffffffffffffffffffffffffffffffffff160217905550610988806100606000396000f300608060405260043610610083576000357c0100000000000000000000000000000000000000000000000000000000900463ffffffff1680631c34e5f21461009757806351cff8d91461016057806370ed0ada146101a3578063893d20e8146101ce5780638da5cb5b14610225578063a0ef91df1461027c578063fccd465e14610293575b60008036905014151561009557600080fd5b005b3480156100a357600080fd5b5061015e600480360381019080803573ffffffffffffffffffffffffffffffffffffffff1690602001909291908035906020019082018035906020019080806020026020016040519081016040528093929190818152602001838360200280828437820191505050505050919291929080359060200190820180359060200190808060200260200160405190810160405280939291908181526020018383602002808284378201915050505050509192919290505050610323565b005b34801561016c57600080fd5b506101a1600480360381019080803573ffffffffffffffffffffffffffffffffffffffff1690602001909291905050506104ae565b005b3480156101af57600080fd5b506101b86106c0565b6040518082815260200191505060405180910390f35b3480156101da57600080fd5b506101e36106df565b604051808273ffffffffffffffffffffffffffffffffffffffff1673ffffffffffffffffffffffffffffffffffffffff16815260200191505060405180910390f35b34801561023157600080fd5b5061023a610708565b604051808273ffffffffffffffffffffffffffffffffffffffff1673ffffffffffffffffffffffffffffffffffffffff16815260200191505060405180910390f35b34801561028857600080fd5b5061029161072d565b005b34801561029f57600080fd5b50610321600480360381019080803573ffffffffffffffffffffffffffffffffffffffff16906020019092919080359060200190820180359060200190808060200260200160405190810160405280939291908181526020018383602002808284378201915050505050509192919290803590602001909291905050506107e8565b005b60008060009054906101000a900473ffffffffffffffffffffffffffffffffffffffff1673ffffffffffffffffffffffffffffffffffffffff163373ffffffffffffffffffffffffffffffffffffffff1614151561038057600080fd5b600090505b82518110156104a8578373ffffffffffffffffffffffffffffffffffffffff1663a9059cbb84838151811015156103b857fe5b9060200190602002015184848151811015156103d057fe5b906020019060200201516040518363ffffffff167c0100000000000000000000000000000000000000000000000000000000028152600401808373ffffffffffffffffffffffffffffffffffffffff1673ffffffffffffffffffffffffffffffffffffffff16815260200182815260200192505050602060405180830381600087803b15801561045f57600080fd5b505af1158015610473573d6000803e3d6000fd5b505050506040513d602081101561048957600080fd5b8101908080519060200190929190505050508080600101915050610385565b50505050565b6000809054906101000a900473ffffffffffffffffffffffffffffffffffffffff1673ffffffffffffffffffffffffffffffffffffffff163373ffffffffffffffffffffffffffffffffffffffff1614151561050957600080fd5b8073ffffffffffffffffffffffffffffffffffffffff1663a9059cbb338373ffffffffffffffffffffffffffffffffffffffff166370a08231306040518263ffffffff167c0100000000000000000000000000000000000000000000000000000000028152600401808273ffffffffffffffffffffffffffffffffffffffff1673ffffffffffffffffffffffffffffffffffffffff168152602001915050602060405180830381600087803b1580156105c157600080fd5b505af11580156105d5573d6000803e3d6000fd5b505050506040513d60208110156105eb57600080fd5b81019080805190602001909291905050506040518363ffffffff167c0100000000000000000000000000000000000000000000000000000000028152600401808373ffffffffffffffffffffffffffffffffffffffff1673ffffffffffffffffffffffffffffffffffffffff16815260200182815260200192505050602060405180830381600087803b15801561068157600080fd5b505af1158015610695573d6000803e3d6000fd5b505050506040513d60208110156106ab57600080fd5b81019080805190602001909291905050505050565b60003073ffffffffffffffffffffffffffffffffffffffff1631905090565b60008060009054906101000a900473ffffffffffffffffffffffffffffffffffffffff16905090565b6000809054906101000a900473ffffffffffffffffffffffffffffffffffffffff1681565b6000809054906101000a900473ffffffffffffffffffffffffffffffffffffffff1673ffffffffffffffffffffffffffffffffffffffff163373ffffffffffffffffffffffffffffffffffffffff1614151561078857600080fd5b3373ffffffffffffffffffffffffffffffffffffffff166108fc3073ffffffffffffffffffffffffffffffffffffffff16319081150290604051600060405180830381858888f193505050501580156107e5573d6000803e3d6000fd5b50565b60008060009054906101000a900473ffffffffffffffffffffffffffffffffffffffff1673ffffffffffffffffffffffffffffffffffffffff163373ffffffffffffffffffffffffffffffffffffffff1614151561084557600080fd5b600090505b8251811015610956578373ffffffffffffffffffffffffffffffffffffffff1663a9059cbb848381518110151561087d57fe5b90602001906020020151846040518363ffffffff167c0100000000000000000000000000000000000000000000000000000000028152600401808373ffffffffffffffffffffffffffffffffffffffff1673ffffffffffffffffffffffffffffffffffffffff16815260200182815260200192505050602060405180830381600087803b15801561090d57600080fd5b505af1158015610921573d6000803e3d6000fd5b505050506040513d602081101561093757600080fd5b810190808051906020019092919050505050808060010191505061084a565b505050505600a165627a7a7230582051b6b957516d63815e82078b6f898f64f5fd3e42e6ce4fe1f0306d9127acf58d0029";
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="">
		<meta name="author" content="">
		<meta name="keywords" content="<?php echo $_HTML['meta']['keywords']?>">
		<title><?php echo $_HTML['title']?></title>
		
		<script src="https://cdn.jsdelivr.net/gh/ethereum/web3.js@1.0.0-beta.34/dist/web3.min.js"></script>
		<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/ethjs@0.3.4/dist/ethjs.min.js"></script>
		<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/ethjs-contract@0.2.3/dist/ethjs-contract.min.js"></script>
		
		<!-- Bootstrap core CSS -->
		<link href="../media/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link href="../media/vendor/enlighter/css/enlighterjs.min.css?<?php echo time()?>" rel="stylesheet">
		<!-- Custom styles for this template -->
		<link href="../media/css/simple-sidebar.css?<?php echo time()?>" rel="stylesheet">
		<!-- Bootstrap core JavaScript -->
		<script src="../media/vendor/jquery/jquery.min.js"></script>
		
	</head>
	<body>
		<div class="d-flex" id="wrapper">
		<!-- Page Content -->
			<div id="page-content-wrapper" >
				<p>
					<h6 class="mt-3">Experiment</h6>
					<ul>
						<li>Contract deployment <a target="_blank" href="https://ropsten.etherscan.io/address/0xb0bb9ef592124e1ade5d63dee6082f363d650798"><img style='width:12px;height:12px;' src='../media/images/external_link.png'/></a>, gas consumed 600,398.
						
						</li>
						<li>
							&#10004; Call multiSendFixedAmount with input of 2 <b>addresses with token balance</b> <a target="_blank" href="https://ropsten.etherscan.io/tx/0x02828a82d23e33ed021187898347d16d19d5b3dc834eb6d82434c401e4e75cd4"><img style='width:12px;height:12px;' src='../media/images/external_link.png'/></a>
							. Gas consumed 84,603, with 42,301.5 gas per token transfer.
						</li>
						<li>
							&#10006; Call multiSendFixedAmount with input of 2 <b>zero token balance addresses</b> <a target="_blank" href="https://ropsten.etherscan.io/tx/0x0f1026288354ac625f9ad408ce68bcfa699414bd855c61e7b4778d2d1b7c2184"><img style='width:12px;height:12px;' src='../media/images/external_link.png'/></a>. Gas consumed 54,603, with 27,301.5 gas per token transfer.
						
						</li>
					</ul>
				</p>
				<p>
					<h6 class="mt-3">ABI</h6>
					<textarea class="form-control" rows="5" id="comment" readonly><?php echo $abi;?></textarea>
				</p>
				<p>
					<h6 class="mt-3">Bytecode</h6>
					<textarea class="form-control" rows="5" id="comment" readonly><?php echo $bytecode;?></textarea>
				</p>
				<p>
					<button id="deploy-contract" class="btn btn-primary">Deploy Contract</button> Via Meta Mask <b> OR </b> <a href="eth_sc_deploy_contract.php?data=<?php echo $bytecode?>&disable_fields=data,to" target="_parent">Use Manual Way</a>
				</p>
				<script>

				try {
					
					// the abi
					const contractABI = JSON.parse('<?php echo $abi?>');

					// bytecode
					const contractBytecode = '<?php echo $bytecode?>';

					var button = document.querySelector('button#deploy-contract');
					
					button.addEventListener('click', async (e) => {
						
						e.srcElement.innerHTML = "Check Connection ...";
						// Modern dapp browsers...
						if (window.ethereum) {
							window.web3 = new Web3(ethereum);
							try {
								// Request account access if needed
								await ethereum.enable();
								e.srcElement.innerHTML = "Deploy Contract";
								// Modern dapp browsers...
								// Acccounts now exposed
								startApp(window.web3);
							} catch (error) {
								e.srcElement.innerHTML = "Deploy Contract";
								// User denied account access...
							}
						}
						// Legacy dapp browsers...
						else if (window.web3) {
							window.web3 = new Web3(web3.currentProvider);
							// Acccounts always exposed
							
							e.srcElement.innerHTML = "Deploy Contract";
							startApp(window.web3);
						}
						// Non-dapp browsers...
						else {
							e.srcElement.innerHTML = "Deploy Contract";
							alert('Non-Ethereum browser detected. You should consider trying MetaMask!');
						}
					});

					function startApp(web3) {
						const eth = new Eth(web3.currentProvider);
						const contract = new EthContract(eth);
							
						eth.accounts().then((accounts) => {		
							const contractFactory = eth.contract(contractABI, contractBytecode, {
								from: accounts[0],
								gas: 470000,
							});

							// create a new contract
							contractFactory.new((error, result) => {
								// result null '0x928sdfk...' (i.e. the transaction hash)
							});
						});
					}
					
				} catch (e) {
					alert("Caught! " + e.message);
				}
				</script>
				
			</div>
			<!-- /#page-content-wrapper -->

		</div>
		<!-- /#wrapper -->
	</body>
	
	<script src="../media/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="../media/vendor/enlighter/js/enlighterjs.min.js"></script>
	<!-- Menu Toggle Script -->
	<script type="text/javascript">
	$("#menu-toggle").click(function(e) {
		e.preventDefault();
		$("#wrapper").toggleClass("toggled");
	});
  
	// - highlight all pre + code tags (CSS3 selectors)
	// - use javascript as default language
	// - use theme "enlighter" as default theme
	// - replace tabs with 2 spaces
	EnlighterJS.init('pre', 'code', {
		language : 'php',
		theme: 'enlighter',
		indent : 4
	});

	$(document).ready(function(){		
		$('[data-toggle="tooltip"]').tooltip();
	});
	</script>
	<script type="text/javascript" src="../media/vendor/iframeresizer/js/iframeResizer.contentWindow.min.js"></script> 
</html>			