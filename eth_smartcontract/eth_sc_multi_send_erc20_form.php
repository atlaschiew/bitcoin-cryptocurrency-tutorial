<?Php
$abi = '[ { "inputs": [], "payable": false, "stateMutability": "nonpayable", "type": "constructor" }, { "constant": true, "inputs": [], "name": "getOwner", "outputs": [ { "internalType": "address", "name": "", "type": "address" } ], "payable": false, "stateMutability": "view", "type": "function" }, { "constant": true, "inputs": [ { "internalType": "contract IERC20", "name": "token", "type": "address" } ], "name": "getTokenBalance", "outputs": [ { "internalType": "uint256", "name": "", "type": "uint256" } ], "payable": false, "stateMutability": "view", "type": "function" }, { "constant": false, "inputs": [ { "internalType": "contract IERC20", "name": "token", "type": "address" }, { "internalType": "address[]", "name": "recipients", "type": "address[]" }, { "internalType": "uint256[]", "name": "values", "type": "uint256[]" } ], "name": "multiSendArrayAmount", "outputs": [], "payable": false, "stateMutability": "nonpayable", "type": "function" }, { "constant": false, "inputs": [ { "internalType": "contract IERC20", "name": "token", "type": "address" }, { "internalType": "address[]", "name": "recipients", "type": "address[]" }, { "internalType": "uint256", "name": "values", "type": "uint256" } ], "name": "multiSendFixedAmount", "outputs": [], "payable": false, "stateMutability": "nonpayable", "type": "function" }, { "constant": true, "inputs": [], "name": "owner", "outputs": [ { "internalType": "address", "name": "", "type": "address" } ], "payable": false, "stateMutability": "view", "type": "function" }, { "constant": false, "inputs": [ { "internalType": "contract IERC20", "name": "token", "type": "address" } ], "name": "withdraw", "outputs": [], "payable": false, "stateMutability": "nonpayable", "type": "function" } ]';

$bytecode = "608060405234801561001057600080fd5b50336000806101000a81548173ffffffffffffffffffffffffffffffffffffffff021916908373ffffffffffffffffffffffffffffffffffffffff160217905550610b7d806100606000396000f3fe608060405234801561001057600080fd5b50600436106100625760003560e01c80631c34e5f2146100675780633aecd0e3146101d357806351cff8d91461022b578063893d20e81461026f5780638da5cb5b146102b9578063fccd465e14610303575b600080fd5b6101d16004803603606081101561007d57600080fd5b81019080803573ffffffffffffffffffffffffffffffffffffffff169060200190929190803590602001906401000000008111156100ba57600080fd5b8201836020820111156100cc57600080fd5b803590602001918460208302840111640100000000831117156100ee57600080fd5b919080806020026020016040519081016040528093929190818152602001838360200280828437600081840152601f19601f8201169050808301925050505050505091929192908035906020019064010000000081111561014e57600080fd5b82018360208201111561016057600080fd5b8035906020019184602083028401116401000000008311171561018257600080fd5b919080806020026020016040519081016040528093929190818152602001838360200280828437600081840152601f19601f8201169050808301925050505050505091929192905050506103e5565b005b610215600480360360208110156101e957600080fd5b81019080803573ffffffffffffffffffffffffffffffffffffffff1690602001909291905050506104b1565b6040518082815260200191505060405180910390f35b61026d6004803603602081101561024157600080fd5b81019080803573ffffffffffffffffffffffffffffffffffffffff169060200190929190505050610572565b005b6102776106b0565b604051808273ffffffffffffffffffffffffffffffffffffffff1673ffffffffffffffffffffffffffffffffffffffff16815260200191505060405180910390f35b6102c16106d9565b604051808273ffffffffffffffffffffffffffffffffffffffff1673ffffffffffffffffffffffffffffffffffffffff16815260200191505060405180910390f35b6103e36004803603606081101561031957600080fd5b81019080803573ffffffffffffffffffffffffffffffffffffffff1690602001909291908035906020019064010000000081111561035657600080fd5b82018360208201111561036857600080fd5b8035906020019184602083028401116401000000008311171561038a57600080fd5b919080806020026020016040519081016040528093929190818152602001838360200280828437600081840152601f19601f820116905080830192505050505050509192919290803590602001909291905050506106fe565b005b6000809054906101000a900473ffffffffffffffffffffffffffffffffffffffff1673ffffffffffffffffffffffffffffffffffffffff163373ffffffffffffffffffffffffffffffffffffffff161461043e57600080fd5b60008090505b82518110156104ab5761049e83828151811061045c57fe5b602002602001015183838151811061047057fe5b60200260200101518673ffffffffffffffffffffffffffffffffffffffff166107b79092919063ffffffff16565b8080600101915050610444565b50505050565b60008173ffffffffffffffffffffffffffffffffffffffff166370a08231306040518263ffffffff1660e01b8152600401808273ffffffffffffffffffffffffffffffffffffffff1673ffffffffffffffffffffffffffffffffffffffff16815260200191505060206040518083038186803b15801561053057600080fd5b505afa158015610544573d6000803e3d6000fd5b505050506040513d602081101561055a57600080fd5b81019080805190602001909291905050509050919050565b6000809054906101000a900473ffffffffffffffffffffffffffffffffffffffff1673ffffffffffffffffffffffffffffffffffffffff163373ffffffffffffffffffffffffffffffffffffffff16146105cb57600080fd5b6106ad338273ffffffffffffffffffffffffffffffffffffffff166370a08231306040518263ffffffff1660e01b8152600401808273ffffffffffffffffffffffffffffffffffffffff1673ffffffffffffffffffffffffffffffffffffffff16815260200191505060206040518083038186803b15801561064c57600080fd5b505afa158015610660573d6000803e3d6000fd5b505050506040513d602081101561067657600080fd5b81019080805190602001909291905050508373ffffffffffffffffffffffffffffffffffffffff166107b79092919063ffffffff16565b50565b60008060009054906101000a900473ffffffffffffffffffffffffffffffffffffffff16905090565b6000809054906101000a900473ffffffffffffffffffffffffffffffffffffffff1681565b6000809054906101000a900473ffffffffffffffffffffffffffffffffffffffff1673ffffffffffffffffffffffffffffffffffffffff163373ffffffffffffffffffffffffffffffffffffffff161461075757600080fd5b60008090505b82518110156107b1576107a483828151811061077557fe5b6020026020010151838673ffffffffffffffffffffffffffffffffffffffff166107b79092919063ffffffff16565b808060010191505061075d565b50505050565b610883838473ffffffffffffffffffffffffffffffffffffffff1663a9059cbb905060e01b8484604051602401808373ffffffffffffffffffffffffffffffffffffffff1673ffffffffffffffffffffffffffffffffffffffff16815260200182815260200192505050604051602081830303815290604052907bffffffffffffffffffffffffffffffffffffffffffffffffffffffff19166020820180517bffffffffffffffffffffffffffffffffffffffffffffffffffffffff8381831617835250505050610888565b505050565b6108a78273ffffffffffffffffffffffffffffffffffffffff16610ad3565b610919576040517f08c379a000000000000000000000000000000000000000000000000000000000815260040180806020018281038252601f8152602001807f5361666545524332303a2063616c6c20746f206e6f6e2d636f6e74726163740081525060200191505060405180910390fd5b600060608373ffffffffffffffffffffffffffffffffffffffff16836040518082805190602001908083835b602083106109685780518252602082019150602081019050602083039250610945565b6001836020036101000a0380198251168184511680821785525050505050509050019150506000604051808303816000865af19150503d80600081146109ca576040519150601f19603f3d011682016040523d82523d6000602084013e6109cf565b606091505b509150915081610a47576040517f08c379a00000000000000000000000000000000000000000000000000000000081526004018080602001828103825260208152602001807f5361666545524332303a206c6f772d6c6576656c2063616c6c206661696c656481525060200191505060405180910390fd5b600081511115610acd57808060200190516020811015610a6657600080fd5b8101908080519060200190929190505050610acc576040517f08c379a000000000000000000000000000000000000000000000000000000000815260040180806020018281038252602a815260200180610b1f602a913960400191505060405180910390fd5b5b50505050565b60008060007fc5d2460186f7233c927e7db2dcc703c0e500b653ca82273b7bfad8045d85a47060001b9050833f91506000801b8214158015610b155750808214155b9250505091905056fe5361666545524332303a204552433230206f7065726174696f6e20646964206e6f742073756363656564a265627a7a723158202d7353414d9dda6bec67c9fe9a5fad5df1e406d5f91a263bee120dddb78391a864736f6c63430005110032";
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
						<li>Contract deployment <a target="_blank" href="https://ropsten.etherscan.io/address/0xb0bb9ef592124e1ade5d63dee6082f363d650798"><img style='width:12px;height:12px;' src='../media/images/external_link.png'/></a>, gas consumed 709,057.
						
						</li>
						<li>
							&#10004; Call multiSendFixedAmount with input of 2 <b>addresses with token balance</b> <a target="_blank" href="https://ropsten.etherscan.io/tx/0x904890396e59f43e8efd155313af0ea6d25be8b9862b4cc8ecf6233b34f01474"><img style='width:12px;height:12px;' src='../media/images/external_link.png'/></a>
							. Gas consumed 54,478, with 27,239 gas per token transfer.
						</li>
						<li>
							&#10006; Call multiSendFixedAmount with input of 2 <b>zero token balance addresses</b> <a target="_blank" href="https://ropsten.etherscan.io/tx/0x0f1026288354ac625f9ad408ce68bcfa699414bd855c61e7b4778d2d1b7c2184"><img style='width:12px;height:12px;' src='../media/images/external_link.png'/></a>. Gas consumed 84,478, with 42,239 gas per token transfer.
						
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