<?Php
$abi = '[{"inputs":[],"payable":false,"stateMutability":"nonpayable","type":"constructor"},{"constant":true,"inputs":[],"name":"getOwner","outputs":[{"internalType":"address","name":"","type":"address"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[{"internalType":"contract IERC20","name":"token","type":"address"}],"name":"getTokenBalance","outputs":[{"internalType":"uint256","name":"","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"internalType":"contract IERC20","name":"token","type":"address"},{"internalType":"address[]","name":"recipients","type":"address[]"},{"internalType":"uint256[]","name":"amounts","type":"uint256[]"}],"name":"multiSendDiffToken","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":false,"inputs":[{"internalType":"contract IERC20","name":"token","type":"address"},{"internalType":"address[]","name":"recipients","type":"address[]"},{"internalType":"uint256[]","name":"amounts","type":"uint256[]"}],"name":"multiSendDiffTokenFromContract","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":false,"inputs":[{"internalType":"contract IERC20","name":"token","type":"address"},{"internalType":"address[]","name":"recipients","type":"address[]"},{"internalType":"uint256","name":"amount","type":"uint256"}],"name":"multiSendFixedToken","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":false,"inputs":[{"internalType":"contract IERC20","name":"token","type":"address"},{"internalType":"address[]","name":"recipients","type":"address[]"},{"internalType":"uint256","name":"amount","type":"uint256"}],"name":"multiSendFixedTokenFromContract","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[],"name":"owner","outputs":[{"internalType":"address","name":"","type":"address"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"internalType":"contract IERC20","name":"token","type":"address"}],"name":"withdraw","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"}]';

$bytecode = "608060405234801561001057600080fd5b50336000806101000a81548173ffffffffffffffffffffffffffffffffffffffff021916908373ffffffffffffffffffffffffffffffffffffffff1602179055506114bc806100606000396000f3fe608060405234801561001057600080fd5b50600436106100885760003560e01c80637fb7e3f81161005b5780637fb7e3f814610377578063893d20e8146104595780638da5cb5b146104a3578063f0558aa2146104ed57610088565b80633aecd0e31461008d578063513e8d29146100e557806351cff8d9146101c757806377bb004e1461020b575b600080fd5b6100cf600480360360208110156100a357600080fd5b81019080803573ffffffffffffffffffffffffffffffffffffffff169060200190929190505050610659565b6040518082815260200191505060405180910390f35b6101c5600480360360608110156100fb57600080fd5b81019080803573ffffffffffffffffffffffffffffffffffffffff1690602001909291908035906020019064010000000081111561013857600080fd5b82018360208201111561014a57600080fd5b8035906020019184602083028401116401000000008311171561016c57600080fd5b919080806020026020016040519081016040528093929190818152602001838360200280828437600081840152601f19601f8201169050808301925050505050505091929192908035906020019092919050505061071a565b005b610209600480360360208110156101dd57600080fd5b81019080803573ffffffffffffffffffffffffffffffffffffffff169060200190929190505050610898565b005b6103756004803603606081101561022157600080fd5b81019080803573ffffffffffffffffffffffffffffffffffffffff1690602001909291908035906020019064010000000081111561025e57600080fd5b82018360208201111561027057600080fd5b8035906020019184602083028401116401000000008311171561029257600080fd5b919080806020026020016040519081016040528093929190818152602001838360200280828437600081840152601f19601f820116905080830192505050505050509192919290803590602001906401000000008111156102f257600080fd5b82018360208201111561030457600080fd5b8035906020019184602083028401116401000000008311171561032657600080fd5b919080806020026020016040519081016040528093929190818152602001838360200280828437600081840152601f19601f8201169050808301925050505050505091929192905050506109d6565b005b6104576004803603606081101561038d57600080fd5b81019080803573ffffffffffffffffffffffffffffffffffffffff169060200190929190803590602001906401000000008111156103ca57600080fd5b8201836020820111156103dc57600080fd5b803590602001918460208302840111640100000000831117156103fe57600080fd5b919080806020026020016040519081016040528093929190818152602001838360200280828437600081840152601f19601f82011690508083019250505050505050919291929080359060200190929190505050610bbc565b005b610461610d57565b604051808273ffffffffffffffffffffffffffffffffffffffff1673ffffffffffffffffffffffffffffffffffffffff16815260200191505060405180910390f35b6104ab610d80565b604051808273ffffffffffffffffffffffffffffffffffffffff1673ffffffffffffffffffffffffffffffffffffffff16815260200191505060405180910390f35b6106576004803603606081101561050357600080fd5b81019080803573ffffffffffffffffffffffffffffffffffffffff1690602001909291908035906020019064010000000081111561054057600080fd5b82018360208201111561055257600080fd5b8035906020019184602083028401116401000000008311171561057457600080fd5b919080806020026020016040519081016040528093929190818152602001838360200280828437600081840152601f19601f820116905080830192505050505050509192919290803590602001906401000000008111156105d457600080fd5b8201836020820111156105e657600080fd5b8035906020019184602083028401116401000000008311171561060857600080fd5b919080806020026020016040519081016040528093929190818152602001838360200280828437600081840152601f19601f820116905080830192505050505050509192919290505050610da5565b005b60008173ffffffffffffffffffffffffffffffffffffffff166370a08231306040518263ffffffff1660e01b8152600401808273ffffffffffffffffffffffffffffffffffffffff1673ffffffffffffffffffffffffffffffffffffffff16815260200191505060206040518083038186803b1580156106d857600080fd5b505afa1580156106ec573d6000803e3d6000fd5b505050506040513d602081101561070257600080fd5b81019080805190602001909291905050509050919050565b6000339050600083511161072d57600080fd5b6000821161073a57600080fd5b8373ffffffffffffffffffffffffffffffffffffffff1663dd62ed3e82306040518363ffffffff1660e01b8152600401808373ffffffffffffffffffffffffffffffffffffffff1673ffffffffffffffffffffffffffffffffffffffff1681526020018273ffffffffffffffffffffffffffffffffffffffff1673ffffffffffffffffffffffffffffffffffffffff1681526020019250505060206040518083038186803b1580156107eb57600080fd5b505afa1580156107ff573d6000803e3d6000fd5b505050506040513d602081101561081557600080fd5b810190808051906020019092919050505082845102111561083557600080fd5b60008090505b8351811015610891576108848285838151811061085457fe5b6020026020010151858873ffffffffffffffffffffffffffffffffffffffff16610f68909392919063ffffffff16565b808060010191505061083b565b5050505050565b6000809054906101000a900473ffffffffffffffffffffffffffffffffffffffff1673ffffffffffffffffffffffffffffffffffffffff163373ffffffffffffffffffffffffffffffffffffffff16146108f157600080fd5b6109d3338273ffffffffffffffffffffffffffffffffffffffff166370a08231306040518263ffffffff1660e01b8152600401808273ffffffffffffffffffffffffffffffffffffffff1673ffffffffffffffffffffffffffffffffffffffff16815260200191505060206040518083038186803b15801561097257600080fd5b505afa158015610986573d6000803e3d6000fd5b505050506040513d602081101561099c57600080fd5b81019080805190602001909291905050508373ffffffffffffffffffffffffffffffffffffffff1661106e9092919063ffffffff16565b50565b6000809054906101000a900473ffffffffffffffffffffffffffffffffffffffff1673ffffffffffffffffffffffffffffffffffffffff163373ffffffffffffffffffffffffffffffffffffffff1614610a2f57600080fd5b6000825111610a3d57600080fd5b8051825114610a4b57600080fd5b600082519050600080905060008573ffffffffffffffffffffffffffffffffffffffff166370a08231306040518263ffffffff1660e01b8152600401808273ffffffffffffffffffffffffffffffffffffffff1673ffffffffffffffffffffffffffffffffffffffff16815260200191505060206040518083038186803b158015610ad557600080fd5b505afa158015610ae9573d6000803e3d6000fd5b505050506040513d6020811015610aff57600080fd5b8101908080519060200190929190505050905060008090505b83811015610bb3576000858281518110610b2e57fe5b6020026020010151905060008111610b4557600080fd5b610b58818561113f90919063ffffffff16565b935082841115610b6757600080fd5b610ba5878381518110610b7657fe5b6020026020010151828a73ffffffffffffffffffffffffffffffffffffffff1661106e9092919063ffffffff16565b508080600101915050610b18565b50505050505050565b6000809054906101000a900473ffffffffffffffffffffffffffffffffffffffff1673ffffffffffffffffffffffffffffffffffffffff163373ffffffffffffffffffffffffffffffffffffffff1614610c1557600080fd5b6000825111610c2357600080fd5b60008111610c3057600080fd5b8273ffffffffffffffffffffffffffffffffffffffff166370a08231306040518263ffffffff1660e01b8152600401808273ffffffffffffffffffffffffffffffffffffffff1673ffffffffffffffffffffffffffffffffffffffff16815260200191505060206040518083038186803b158015610cad57600080fd5b505afa158015610cc1573d6000803e3d6000fd5b505050506040513d6020811015610cd757600080fd5b8101908080519060200190929190505050818351021115610cf757600080fd5b60008090505b8251811015610d5157610d44838281518110610d1557fe5b6020026020010151838673ffffffffffffffffffffffffffffffffffffffff1661106e9092919063ffffffff16565b8080600101915050610cfd565b50505050565b60008060009054906101000a900473ffffffffffffffffffffffffffffffffffffffff16905090565b6000809054906101000a900473ffffffffffffffffffffffffffffffffffffffff1681565b6000825111610db357600080fd5b8051825114610dc157600080fd5b600033905060008473ffffffffffffffffffffffffffffffffffffffff1663dd62ed3e83306040518363ffffffff1660e01b8152600401808373ffffffffffffffffffffffffffffffffffffffff1673ffffffffffffffffffffffffffffffffffffffff1681526020018273ffffffffffffffffffffffffffffffffffffffff1673ffffffffffffffffffffffffffffffffffffffff1681526020019250505060206040518083038186803b158015610e7957600080fd5b505afa158015610e8d573d6000803e3d6000fd5b505050506040513d6020811015610ea357600080fd5b81019080805190602001909291905050509050600080905060008090505b8551811015610f5f576000858281518110610ed857fe5b6020026020010151905060008111610eef57600080fd5b610f02818461113f90919063ffffffff16565b925083831115610f1157600080fd5b610f5185888481518110610f2157fe5b6020026020010151838b73ffffffffffffffffffffffffffffffffffffffff16610f68909392919063ffffffff16565b508080600101915050610ec1565b50505050505050565b611068848573ffffffffffffffffffffffffffffffffffffffff166323b872dd905060e01b858585604051602401808473ffffffffffffffffffffffffffffffffffffffff1673ffffffffffffffffffffffffffffffffffffffff1681526020018373ffffffffffffffffffffffffffffffffffffffff1673ffffffffffffffffffffffffffffffffffffffff1681526020018281526020019350505050604051602081830303815290604052907bffffffffffffffffffffffffffffffffffffffffffffffffffffffff19166020820180517bffffffffffffffffffffffffffffffffffffffffffffffffffffffff83818316178352505050506111c7565b50505050565b61113a838473ffffffffffffffffffffffffffffffffffffffff1663a9059cbb905060e01b8484604051602401808373ffffffffffffffffffffffffffffffffffffffff1673ffffffffffffffffffffffffffffffffffffffff16815260200182815260200192505050604051602081830303815290604052907bffffffffffffffffffffffffffffffffffffffffffffffffffffffff19166020820180517bffffffffffffffffffffffffffffffffffffffffffffffffffffffff83818316178352505050506111c7565b505050565b6000808284019050838110156111bd576040517f08c379a000000000000000000000000000000000000000000000000000000000815260040180806020018281038252601b8152602001807f536166654d6174683a206164646974696f6e206f766572666c6f77000000000081525060200191505060405180910390fd5b8091505092915050565b6111e68273ffffffffffffffffffffffffffffffffffffffff16611412565b611258576040517f08c379a000000000000000000000000000000000000000000000000000000000815260040180806020018281038252601f8152602001807f5361666545524332303a2063616c6c20746f206e6f6e2d636f6e74726163740081525060200191505060405180910390fd5b600060608373ffffffffffffffffffffffffffffffffffffffff16836040518082805190602001908083835b602083106112a75780518252602082019150602081019050602083039250611284565b6001836020036101000a0380198251168184511680821785525050505050509050019150506000604051808303816000865af19150503d8060008114611309576040519150601f19603f3d011682016040523d82523d6000602084013e61130e565b606091505b509150915081611386576040517f08c379a00000000000000000000000000000000000000000000000000000000081526004018080602001828103825260208152602001807f5361666545524332303a206c6f772d6c6576656c2063616c6c206661696c656481525060200191505060405180910390fd5b60008151111561140c578080602001905160208110156113a557600080fd5b810190808051906020019092919050505061140b576040517f08c379a000000000000000000000000000000000000000000000000000000000815260040180806020018281038252602a81526020018061145e602a913960400191505060405180910390fd5b5b50505050565b60008060007fc5d2460186f7233c927e7db2dcc703c0e500b653ca82273b7bfad8045d85a47060001b9050833f91506000801b82141580156114545750808214155b9250505091905056fe5361666545524332303a204552433230206f7065726174696f6e20646964206e6f742073756363656564a265627a7a723158207aa02d49990637bbfb25e348c229befd3c663f0b5d1a211d058d50474666675364736f6c63430005110032";
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
						<li>Contract deployment <a target="_blank" href="https://ropsten.etherscan.io/address/0x2273784639770fbf67908c3ecd460f3b14fbec84"><img style='width:12px;height:12px;' src='../media/images/external_link.png'/></a>.
						
						</li>
						<li>
							&#10004; Call multiSendFixedToken with input of 2 <b>addresses with token balance</b> <a target="_blank" href="https://ropsten.etherscan.io/tx/0xc252c2eb6ed670c92a0d165642abc17ec60bc2b7e29eff8a192690ed0c703839"><img style='width:12px;height:12px;' src='../media/images/external_link.png'/></a>
							. Gas consumed 43,208, with 21,604 gas per token transfer.
						</li>
						<li>
							&#10006; Call multiSendFixedToken with input of 2 <b>zero token balance addresses</b> <a target="_blank" href="https://ropsten.etherscan.io/tx/0xb24e53d750fa2c94c261d44a83b12d5fa53511b844d5436eed6b9002b5b4e3f7"><img style='width:12px;height:12px;' src='../media/images/external_link.png'/></a>. Gas consumed 82,208, with 41,104 gas per token transfer.
						
						</li>
					</ul>
					Please be noted  that use of multiSendFixedToken requires approval of contract as spender
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