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
		<div class="sidebar-heading" onmouseover="this.style.cursor='pointer'" onclick="document.location='<?php echo $_SERVER['HTTPS'] ? 'https' : 'http'?>://<?php echo $_SERVER['HTTP_HOST']?>';">btcschools.net</div>
	  
		<div class="list-group-header">Bitwasp Get Started</div>
		<div class="list-group list-group-flush">
			<a href="bitwasp_start_intro.php" class="list-group-item list-group-item-action bg-light">Bitwasp Intro</a>
			<a href="bitwasp_start_install.php" class="list-group-item list-group-item-action bg-light">Bitwasp Install</a>
		</div>

		<div class="list-group-header">Bitwasp Script Types</div>
		<div class="list-group list-group-flush">
			<a href="bitwasp_script_p2pkh.php" class="list-group-item list-group-item-action bg-light">Bitwasp P2PKH</a>
			<a href="bitwasp_script_p2sh.php" class="list-group-item list-group-item-action bg-light">Bitwasp P2SH</a>
			<a href="bitwasp_script_multisig.php" class="list-group-item list-group-item-action bg-light">Bitwasp MULTISIG</a>
			<a href="bitwasp_script_nulldata.php" class="list-group-item list-group-item-action bg-light">Bitwasp NULL DATA</a>
			<a href="bitwasp_script_p2wpkh.php" class="list-group-item list-group-item-action bg-light">Bitwasp P2WPKH</a>
			<a href="bitwasp_script_p2wsh.php" class="list-group-item list-group-item-action bg-light">Bitwasp P2WSH</a>
			<a href="bitwasp_script_p2sh_p2wpkh.php" class="list-group-item list-group-item-action bg-light">Bitwasp P2SH.P2WPKH</a>
			<a href="bitwasp_script_p2sh_p2wsh.php" class="list-group-item list-group-item-action bg-light">Bitwasp P2SH.P2WSH</a>
			<a href="bitwasp_script_p2sh_locktime.php" class="list-group-item list-group-item-action bg-light">Bitwasp P2SH.LOCKTIME</a>
		</div>
		
		
		<div class="list-group-header">Bitwasp Tools</div>
		<div class="list-group list-group-flush">
			<a href="bitwasp_tool_hash160.php" class="list-group-item list-group-item-action bg-light">Bitwasp HASH160</a>
			<a href="bitwasp_tool_sha256d.php" class="list-group-item list-group-item-action bg-light">Bitwasp SHA256D</a>
			<a href="bitwasp_tool_sha256.php" class="list-group-item list-group-item-action bg-light">Bitwasp SHA256</a>
			<a href="bitwasp_tool_ripemd160.php" class="list-group-item list-group-item-action bg-light">Bitwasp RIPEMD160</a>
			<a href="bitwasp_tool_base58.php" class="list-group-item list-group-item-action bg-light">Bitwasp BASE58</a>
			<a href="bitwasp_tool_wif.php" class="list-group-item list-group-item-action bg-light">Bitwasp WIF</a>
			<a href="bitwasp_tool_verify_script.php" class="list-group-item list-group-item-action bg-light">Bitwasp Verify Script</a>
			<a href="bitwasp_tool_little_endian.php" class="list-group-item list-group-item-action bg-light">Bitwasp Little-Endian</a>
			<a href="bitwasp_tool_dersign.php" class="list-group-item list-group-item-action bg-light">Bitwasp DER Signature</a>
			
		</div>
	  
	  
		<div class="list-group-header">Blockchain Tools</div>
		<div class="list-group list-group-flush">
			<a href="../blockchain/blockchain_tool_utxo.php" class="list-group-item list-group-item-action bg-light">Blockchain Get UTXO</a>
			
			<a href="../blockchain/blockchain_tool_txhex.php" class="list-group-item list-group-item-action bg-light">Blockchain Get Tx Hex</a>
			
			<a href="../blockchain/blockchain_tool_mtp.php" class="list-group-item list-group-item-action bg-light">Blockchain Median Time Past</a>
		</div>
				
    </div>
    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <div id="page-content-wrapper" >

      <nav class="navbar navbar-expand-lg navbar-light border-bottom" style='background-color:#5F5F5F;'>
        <button class="btn btn-success" id="menu-toggle">Bitwasp Menu</button>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent" >
          <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
		  
			<li class="nav-item">
              <a class="nav-link" href="../blockchain">Blockchain</a>
            </li>
            <li class="nav-item active">
              <a class="nav-link" href="../bitwasp">Bitwasp</a>
            </li>
            
			<?php if(0) {?>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Dropdown
              </a>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="#">Action</a>
                <a class="dropdown-item" href="#">Another action</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">Something else here</a>
              </div>
            </li>
			<?php }?>
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