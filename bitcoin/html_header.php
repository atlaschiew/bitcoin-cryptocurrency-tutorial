<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="keywords" content="<?php echo $_HTML['meta']['keywords']?>">
	<title><?php echo $_HTML['title']?></title>

	<!-- Bootstrap core CSS -->
	<link href="../media/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="../media/vendor/enlighter/css/enlighterjs.min.css?<?php echo time()?>" rel="stylesheet">
	<!-- Custom styles for this template -->
	<link href="../media/css/simple-sidebar.css?<?php echo time()?>" rel="stylesheet">
	<!-- Bootstrap core JavaScript -->
	<script src="../media/vendor/jquery/jquery.min.js"></script>
	<script src="../media/vendor/iframeresizer/js/iframeResizer.min.js"></script>
</head>
<body>

  <div class="d-flex" id="wrapper">

    <!-- Sidebar -->
    <div class="bg-light " id="sidebar-wrapper">
		<div class="sidebar-heading"><a style='color:white;text-decoration:none;' href="<?php echo $_SERVER['HTTPS'] ? 'https' : 'http'?>://<?php echo $_SERVER['HTTP_HOST']?>">btcschools.net</a></div>
	  
		<div class="list-group-header">Bitcoin Intro</div>
		<div class="list-group list-group-flush">
			<a href="bitcoin_start_install.php" class="list-group-item list-group-item-action bg-light">Bitwasp Install</a>
			<a href="bitcoin_start_blockchain.php" class="list-group-item list-group-item-action bg-light">Bitcoin Blockchain</a>
			<a href="bitcoin_start_key.php" class="list-group-item list-group-item-action bg-light">Private/Public Key</a>
		</div>
		
		<div class="list-group-header">Bitcoin Client</div>
		<div class="list-group list-group-flush">
			<a href="bitcoin_client_electrum.php" class="list-group-item list-group-item-action bg-light">Electrum</a>
		</div>
		
		<div class="list-group-header">Bitcoin Script Types</div>
		<div class="list-group list-group-flush">
			<a href="bitcoin_script_p2pkh.php" class="list-group-item list-group-item-action bg-light">Bitcoin P2PKH</a>
			<a href="bitcoin_script_p2sh.php" class="list-group-item list-group-item-action bg-light">Bitcoin P2SH</a>
			<a href="bitcoin_script_multisig.php" class="list-group-item list-group-item-action bg-light">Bitcoin MULTISIG</a>
			<a href="bitcoin_script_nulldata.php" class="list-group-item list-group-item-action bg-light">Bitcoin NULL DATA</a>
			<a href="bitcoin_script_p2wpkh.php" class="list-group-item list-group-item-action bg-light">Bitcoin P2WPKH</a>
			<a href="bitcoin_script_p2wsh.php" class="list-group-item list-group-item-action bg-light">Bitcoin P2WSH</a>
			<a href="bitcoin_script_p2sh_p2wpkh.php" class="list-group-item list-group-item-action bg-light">Bitcoin P2SH.P2WPKH</a>
			<a href="bitcoin_script_p2sh_p2wsh.php" class="list-group-item list-group-item-action bg-light">Bitcoin P2SH.P2WSH</a>
			<a href="bitcoin_script_p2sh_locktime.php" class="list-group-item list-group-item-action bg-light">Bitcoin P2SH.LOCKTIME</a>
		</div>
		
		<div class="list-group-header">Bitcoin HD Wallet</div>
		<div class="list-group list-group-flush">
			<a href="bitcoin_hd_mnemonic_code.php" class="list-group-item list-group-item-action bg-light">Bitcoin Mnemonic Code</a>
		</div>
		<div class="list-group list-group-flush">
			<a href="bitcoin_hd_derivation_path.php" class="list-group-item list-group-item-action bg-light">Bitcoin Derivation Paths</a>
		</div>
		
		<div class="list-group-header">Bitcoin Tools</div>
		<div class="list-group list-group-flush">
			<a href="bitcoin_tool_hash160.php" class="list-group-item list-group-item-action bg-light">Bitcoin HASH160</a>
			<a href="bitcoin_tool_sha256d.php" class="list-group-item list-group-item-action bg-light">Bitcoin SHA256D</a>
			<a href="bitcoin_tool_sha256.php" class="list-group-item list-group-item-action bg-light">Bitcoin SHA256</a>
			<a href="bitcoin_tool_ripemd160.php" class="list-group-item list-group-item-action bg-light">Bitcoin RIPEMD160</a>
			<a href="bitcoin_tool_base58.php" class="list-group-item list-group-item-action bg-light">Bitcoin BASE58</a>
			<a href="bitcoin_tool_wif.php" class="list-group-item list-group-item-action bg-light">Bitcoin WIF</a>
			<a href="bitcoin_tool_verify_script.php" class="list-group-item list-group-item-action bg-light">Bitcoin Verify Script</a>
			<a href="bitcoin_tool_little_endian.php" class="list-group-item list-group-item-action bg-light">Bitcoin Little-Endian</a>
			<a href="bitcoin_tool_ecdsa.php" class="list-group-item list-group-item-action bg-light">Bitcoin ECDSA Signature</a>
			
			<a href="bitcoin_tool_ecrecover.php" class="list-group-item list-group-item-action bg-light">Bitcoin EC Recover</a>
			
		</div>
	  
		<div class="list-group-header">Bitcoin Others</div>
		<div class="list-group list-group-flush">
			<a href="bitcoin_cancel_tx.php" class="list-group-item list-group-item-action bg-light">Bitcoin Cancel Tx (RBF)</a>
		</div>
		
		
		<div class="list-group-header">Bitcoin Advance</div>
		<div class="list-group list-group-flush">
			<a href="bitcoin_merkle_root.php" class="list-group-item list-group-item-action bg-light">Merkle Root</a>
		</div>
		
		<div class="list-group-header">Bitcoin Tools</div>
		<div class="list-group list-group-flush">
			<a href="bitcoin_tool_utxo.php" class="list-group-item list-group-item-action bg-light">Bitcoin Get UTXO</a>
			<a href="bitcoin_tool_txhex.php" class="list-group-item list-group-item-action bg-light">Bitcoin Get Tx Hex</a>
			<a href="bitcoin_tool_mtp.php" class="list-group-item list-group-item-action bg-light">Bitcoin Median Time Past</a>
			<a href="bitcoin_tool_unit_converter.php" class="list-group-item list-group-item-action bg-light">Bitcoin Unit Converter</a>
		</div>
    </div>
    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <div id="page-content-wrapper" >
		
      <nav class="navbar navbar-expand-lg navbar-light border-bottom" style='background-color:#5F5F5F;'>
        <button class="btn btn-success" id="menu-toggle">Bitcoin Menu</button>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent" >
          <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
            <li class="nav-item">
              <a class="nav-link" href="../bitcoin">Bitcoin</a>
            </li>
          </ul>
        </div>
      </nav>

      <div class="container-fluid" >
			<?php if ($errmsg) {?>
				<p>
					<div class="alert alert-danger">
						<strong>Error!</strong> <?php echo $errmsg?>
					</div>
				</p>
			<?php
			}
			?>