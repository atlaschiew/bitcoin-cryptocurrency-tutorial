<?Php
$abi = '[{"inputs":[],"payable":false,"stateMutability":"nonpayable","type":"constructor"},{"payable":true,"stateMutability":"payable","type":"fallback"},{"constant":true,"inputs":[],"name":"getEthBalance","outputs":[{"internalType":"uint256","name":"","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[],"name":"getOwner","outputs":[{"internalType":"address","name":"","type":"address"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"internalType":"address payable[]","name":"recipients","type":"address[]"},{"internalType":"uint256[]","name":"amounts","type":"uint256[]"}],"name":"multiSendDiffEth","outputs":[],"payable":true,"stateMutability":"payable","type":"function"},{"constant":false,"inputs":[{"internalType":"address payable[]","name":"recipients","type":"address[]"},{"internalType":"uint256[]","name":"amounts","type":"uint256[]"}],"name":"multiSendDiffEthFromContract","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":false,"inputs":[{"internalType":"address payable[]","name":"recipients","type":"address[]"},{"internalType":"uint256","name":"amount","type":"uint256"}],"name":"multiSendFixedEth","outputs":[],"payable":true,"stateMutability":"payable","type":"function"},{"constant":false,"inputs":[{"internalType":"address payable[]","name":"recipients","type":"address[]"},{"internalType":"uint256","name":"amount","type":"uint256"}],"name":"multiSendFixedEthFromContract","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[],"name":"owner","outputs":[{"internalType":"address","name":"","type":"address"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[],"name":"withdraw","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"}]';

$bytecode = "608060405234801561001057600080fd5b50336000806101000a81548173ffffffffffffffffffffffffffffffffffffffff021916908373ffffffffffffffffffffffffffffffffffffffff160217905550610b4d806100606000396000f3fe60806040526004361061007b5760003560e01c8063893d20e81161004e578063893d20e8146102605780638da5cb5b146102b75780639749c04a1461030e578063eaeb15df1461045a5761007b565b806331a933911461008d578063390430361461014f5780633ccfd60b1461021e57806370ed0ada14610235575b6000803690501461008b57600080fd5b005b61014d600480360360408110156100a357600080fd5b81019080803590602001906401000000008111156100c057600080fd5b8201836020820111156100d257600080fd5b803590602001918460208302840111640100000000831117156100f457600080fd5b919080806020026020016040519081016040528093929190818152602001838360200280828437600081840152601f19601f820116905080830192505050505050509192919290803590602001909291905050506105b3565b005b34801561015b57600080fd5b5061021c6004803603604081101561017257600080fd5b810190808035906020019064010000000081111561018f57600080fd5b8201836020820111156101a157600080fd5b803590602001918460208302840111640100000000831117156101c357600080fd5b919080806020026020016040519081016040528093929190818152602001838360200280828437600081840152601f19601f8201169050808301925050505050505091929192908035906020019092919050505061065e565b005b34801561022a57600080fd5b50610233610763565b005b34801561024157600080fd5b5061024a610805565b6040518082815260200191505060405180910390f35b34801561026c57600080fd5b5061027561080d565b604051808273ffffffffffffffffffffffffffffffffffffffff1673ffffffffffffffffffffffffffffffffffffffff16815260200191505060405180910390f35b3480156102c357600080fd5b506102cc610836565b604051808273ffffffffffffffffffffffffffffffffffffffff1673ffffffffffffffffffffffffffffffffffffffff16815260200191505060405180910390f35b6104586004803603604081101561032457600080fd5b810190808035906020019064010000000081111561034157600080fd5b82018360208201111561035357600080fd5b8035906020019184602083028401116401000000008311171561037557600080fd5b919080806020026020016040519081016040528093929190818152602001838360200280828437600081840152601f19601f820116905080830192505050505050509192919290803590602001906401000000008111156103d557600080fd5b8201836020820111156103e757600080fd5b8035906020019184602083028401116401000000008311171561040957600080fd5b919080806020026020016040519081016040528093929190818152602001838360200280828437600081840152601f19601f82011690508083019250505050505050919291929050505061085b565b005b34801561046657600080fd5b506105b16004803603604081101561047d57600080fd5b810190808035906020019064010000000081111561049a57600080fd5b8201836020820111156104ac57600080fd5b803590602001918460208302840111640100000000831117156104ce57600080fd5b919080806020026020016040519081016040528093929190818152602001838360200280828437600081840152601f19601f8201169050808301925050505050505091929192908035906020019064010000000081111561052e57600080fd5b82018360208201111561054057600080fd5b8035906020019184602083028401116401000000008311171561056257600080fd5b919080806020026020016040519081016040528093929190818152602001838360200280828437600081840152601f19601f820116905080830192505050505050509192919290505050610946565b005b60008251116105c157600080fd5b600081116105ce57600080fd5b3481835102146105dd57600080fd5b60008251905060008090505b81811015610658578381815181106105fd57fe5b602002602001015173ffffffffffffffffffffffffffffffffffffffff166108fc849081150290604051600060405180830381858888f1935050505015801561064a573d6000803e3d6000fd5b5080806001019150506105e9565b50505050565b6000809054906101000a900473ffffffffffffffffffffffffffffffffffffffff1673ffffffffffffffffffffffffffffffffffffffff163373ffffffffffffffffffffffffffffffffffffffff16146106b757600080fd5b60008251116106c557600080fd5b600081116106d257600080fd5b478183510211156106e257600080fd5b60008251905060008090505b8181101561075d5783818151811061070257fe5b602002602001015173ffffffffffffffffffffffffffffffffffffffff166108fc849081150290604051600060405180830381858888f1935050505015801561074f573d6000803e3d6000fd5b5080806001019150506106ee565b50505050565b6000809054906101000a900473ffffffffffffffffffffffffffffffffffffffff1673ffffffffffffffffffffffffffffffffffffffff163373ffffffffffffffffffffffffffffffffffffffff16146107bc57600080fd5b3373ffffffffffffffffffffffffffffffffffffffff166108fc479081150290604051600060405180830381858888f19350505050158015610802573d6000803e3d6000fd5b50565b600047905090565b60008060009054906101000a900473ffffffffffffffffffffffffffffffffffffffff16905090565b6000809054906101000a900473ffffffffffffffffffffffffffffffffffffffff1681565b600082511161086957600080fd5b805182511461087757600080fd5b600082519050600080905060008090505b8281101561093f57600084828151811061089e57fe5b60200260200101519050600081116108b557600080fd5b6108c88184610a9090919063ffffffff16565b9250348311156108d757600080fd5b8582815181106108e357fe5b602002602001015173ffffffffffffffffffffffffffffffffffffffff166108fc829081150290604051600060405180830381858888f19350505050158015610930573d6000803e3d6000fd5b50508080600101915050610888565b5050505050565b6000809054906101000a900473ffffffffffffffffffffffffffffffffffffffff1673ffffffffffffffffffffffffffffffffffffffff163373ffffffffffffffffffffffffffffffffffffffff161461099f57600080fd5b60008251116109ad57600080fd5b80518251146109bb57600080fd5b6000825190506000809050600047905060008090505b83811015610a885760008582815181106109e757fe5b60200260200101519050600081116109fe57600080fd5b610a118185610a9090919063ffffffff16565b935082841115610a2057600080fd5b868281518110610a2c57fe5b602002602001015173ffffffffffffffffffffffffffffffffffffffff166108fc829081150290604051600060405180830381858888f19350505050158015610a79573d6000803e3d6000fd5b505080806001019150506109d1565b505050505050565b600080828401905083811015610b0e576040517f08c379a000000000000000000000000000000000000000000000000000000000815260040180806020018281038252601b8152602001807f536166654d6174683a206164646974696f6e206f766572666c6f77000000000081525060200191505060405180910390fd5b809150509291505056fea265627a7a72315820ac6172173b7ecde67c3fbf5d0b36985128e0d511b9f1698f1471990324830cd664736f6c63430005110032";
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
						<li>Contract deployment <a target="_blank" href="https://ropsten.etherscan.io/address/0x4e58bd0521716a2da492165d58d83580190b9725"><img style='width:12px;height:12px;' src='../media/images/external_link.png'/></a>
						</li>
						<li>
							&#10004; Call multiSendFixedEth with input of 2 <b>addresses with ETH balance</b> <a target="_blank" href="https://ropsten.etherscan.io/tx/0x6c7952906daa4212c4b4dcf0ac3df661471ceb66f52bdd8f6aa068336ae48f8c"><img style='width:12px;height:12px;' src='../media/images/external_link.png'/></a>. Gas consumed 39,481, with 19,740.5 gas per ETH transfer.
						</li>
						<li>
							&#10006; Call multiSendFixedEth with input of 2 <b>zero ETH balance address</b> <a target="_blank" href="https://ropsten.etherscan.io/tx/0x1e6085f4cd6681b68e7789f81ef011e8cb322db4781184f845f25758b6385fea"><img style='width:12px;height:12px;' src='../media/images/external_link.png'/></a>. Gas consumed 91,981, with 45,990.5 gas per ETH transfer.
						
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