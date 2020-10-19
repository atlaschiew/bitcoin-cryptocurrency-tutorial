<?Php
$abi = '[{"constant":true,"inputs":[],"name":"getBalance","outputs":[{"name":"","type":"uint256"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"name":"addresses","type":"address[]"},{"name":"amount","type":"uint256"}],"name":"multiSendFixedAmountFromContract","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":false,"inputs":[],"name":"withdraw","outputs":[],"payable":false,"stateMutability":"nonpayable","type":"function"},{"constant":true,"inputs":[],"name":"getOwner","outputs":[{"name":"","type":"address"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":true,"inputs":[],"name":"owner","outputs":[{"name":"","type":"address"}],"payable":false,"stateMutability":"view","type":"function"},{"constant":false,"inputs":[{"name":"addresses","type":"address[]"},{"name":"amounts","type":"uint256[]"}],"name":"multiSendArrayAmount","outputs":[],"payable":true,"stateMutability":"payable","type":"function"},{"constant":false,"inputs":[{"name":"addresses","type":"address[]"},{"name":"amount","type":"uint256"}],"name":"multiSendFixedAmount","outputs":[],"payable":true,"stateMutability":"payable","type":"function"},{"inputs":[],"payable":false,"stateMutability":"nonpayable","type":"constructor"},{"payable":true,"stateMutability":"payable","type":"fallback"}]';

$bytecode = "608060405234801561001057600080fd5b50336000806101000a81548173ffffffffffffffffffffffffffffffffffffffff021916908373ffffffffffffffffffffffffffffffffffffffff1602179055506106f7806100606000396000f300608060405260043610610083576000357c0100000000000000000000000000000000000000000000000000000000900463ffffffff16806312065fe014610097578063171347d2146100c25780633ccfd60b14610132578063893d20e8146101495780638da5cb5b146101a05780638dd931a5146101f7578063e294418c14610293575b60008036905014151561009557600080fd5b005b3480156100a357600080fd5b506100ac6102f6565b6040518082815260200191505060405180910390f35b3480156100ce57600080fd5b506101306004803603810190808035906020019082018035906020019080806020026020016040519081016040528093929190818152602001838360200280828437820191505050505050919291929080359060200190929190505050610315565b005b34801561013e57600080fd5b50610147610414565b005b34801561015557600080fd5b5061015e6104cf565b604051808273ffffffffffffffffffffffffffffffffffffffff1673ffffffffffffffffffffffffffffffffffffffff16815260200191505060405180910390f35b3480156101ac57600080fd5b506101b56104f8565b604051808273ffffffffffffffffffffffffffffffffffffffff1673ffffffffffffffffffffffffffffffffffffffff16815260200191505060405180910390f35b610291600480360381019080803590602001908201803590602001908080602002602001604051908101604052809392919081815260200183836020028082843782019150505050505091929192908035906020019082018035906020019080806020026020016040519081016040528093929190818152602001838360200280828437820191505050505050919291929050505061051d565b005b6102f46004803603810190808035906020019082018035906020019080806020026020016040519081016040528093929190818152602001838360200280828437820191505050505050919291929080359060200190929190505050610616565b005b60003073ffffffffffffffffffffffffffffffffffffffff1631905090565b6000806000809054906101000a900473ffffffffffffffffffffffffffffffffffffffff1673ffffffffffffffffffffffffffffffffffffffff163373ffffffffffffffffffffffffffffffffffffffff1614151561037357600080fd5b6000845111151561038357600080fd5b60008311151561039257600080fd5b83519150600090505b8181101561040e5783818151811015156103b157fe5b9060200190602002015173ffffffffffffffffffffffffffffffffffffffff166108fc849081150290604051600060405180830381858888f19350505050158015610400573d6000803e3d6000fd5b50808060010191505061039b565b50505050565b6000809054906101000a900473ffffffffffffffffffffffffffffffffffffffff1673ffffffffffffffffffffffffffffffffffffffff163373ffffffffffffffffffffffffffffffffffffffff1614151561046f57600080fd5b3373ffffffffffffffffffffffffffffffffffffffff166108fc3073ffffffffffffffffffffffffffffffffffffffff16319081150290604051600060405180830381858888f193505050501580156104cc573d6000803e3d6000fd5b50565b60008060009054906101000a900473ffffffffffffffffffffffffffffffffffffffff16905090565b6000809054906101000a900473ffffffffffffffffffffffffffffffffffffffff1681565b6000806000806000865111151561053357600080fd5b8451865114151561054357600080fd5b8551935060009250600091505b8382101561060057848281518110151561056657fe5b90602001906020020151905060008111151561058157600080fd5b808301925034831115151561059557600080fd5b85828151811015156105a357fe5b9060200190602002015173ffffffffffffffffffffffffffffffffffffffff166108fc829081150290604051600060405180830381858888f193505050501580156105f2573d6000803e3d6000fd5b508180600101925050610550565b348314151561060e57600080fd5b505050505050565b6000806000845111151561062957600080fd5b60008311151561063857600080fd5b348385510214151561064957600080fd5b83519150600090505b818110156106c557838181518110151561066857fe5b9060200190602002015173ffffffffffffffffffffffffffffffffffffffff166108fc849081150290604051600060405180830381858888f193505050501580156106b7573d6000803e3d6000fd5b508080600101915050610652565b505050505600a165627a7a723058203a876db5068e91f2eb23127519a93d1e23092311dea7f3675c3263132eaba8d90029";
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
						<li>Contract deployment <a target="_blank" href="https://ropsten.etherscan.io/address/0x04365d35ccbf70cfee1efd9464acf2fd4f926d20"><img style='width:12px;height:12px;' src='../media/images/external_link.png'/></a>
						, gas consumed 459,627.
						
						</li>
						<li>
							&#10004; Call multiSendFixedAmount with input of 2 <b>addresses with ETH balance</b> <a target="_blank" href="https://ropsten.etherscan.io/tx/0x79a69fe9d16fe4d436500be2ff2831634ec76a5e858e6f9c28b66cf9286208da"><img style='width:12px;height:12px;' src='../media/images/external_link.png'/></a>. Gas consumed 38,160, with 19,080 gas per ETH transfer.
						</li>
						<li>
							&#10006; Call multiSendFixedAmount with input of 2 <b>zero ETH balance address</b> <a target="_blank" href="https://ropsten.etherscan.io/tx/0x259d97ee503dd1d7da421a48ac5bdc2712958da975c073abdb43e624b2a39ed7"><img style='width:12px;height:12px;' src='../media/images/external_link.png'/></a>. Gas consumed 88,160, with 44,080 gas per ETH transfer.
						
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