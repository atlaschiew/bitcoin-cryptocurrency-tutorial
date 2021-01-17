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
	  
		<div class="list-group-header">Tron Menu</div>
		<div class="list-group list-group-flush">
			<a href="tron_start_intro.php" class="list-group-item list-group-item-action bg-light">Tron Intro</a>
			<a href="tron_start_install.php" class="list-group-item list-group-item-action bg-light">Installation</a>
			<a href="tron_address.php" class="list-group-item list-group-item-action bg-light">Tron Address</a>
			<a href="tron_protobuf.php" class="list-group-item list-group-item-action bg-light">Tron Protobuf</a>
			
			
		</div>

		<div class="list-group-header">Tron Resources</div>
		<div class="list-group list-group-flush">
			<a href="tron_station.php" class="list-group-item list-group-item-action bg-light">Tron Station</a>
			<a href="tron_account_resources.php" class="list-group-item list-group-item-action bg-light">Tron Account Resources</a>
			<a href="tron_fee_limit.php" class="list-group-item list-group-item-action bg-light">Tron Fee Limit</a>
		</div>
			
		<div class="list-group-header">Tron System Contract</div>
		<div class="list-group list-group-flush">
			<a href="tron_sysc_intro.php" class="list-group-item list-group-item-action bg-light">Intro</a>
			<a href="tron_sysc_accountcreate.php" class="list-group-item list-group-item-action bg-light">Account Create Contract</a>
			<a href="tron_sysc_transfercontract.php" class="list-group-item list-group-item-action bg-light">Transfer Contract</a>
			<a href="tron_sysc_triggersmartcontract.php" class="list-group-item list-group-item-action bg-light">Trigger Smart Contract</a>
			<a href="tron_sysc_transferassetcontract.php" class="list-group-item list-group-item-action bg-light">Transfer Asset Contract</a>
		</div>
		
		<div class="list-group-header">Tron Transaction</div>
		<div class="list-group list-group-flush">
			<a href="tron_create_tx.php" class="list-group-item list-group-item-action bg-light">Create Raw Transaction</a>
			<a href="tron_create_trc20_tx.php" class="list-group-item list-group-item-action bg-light">Create Send TRC20 Tx</a>
			<a href="tron_create_trc10_tx.php" class="list-group-item list-group-item-action bg-light">Create Send TRC10 Tx</a>
			<a href="tron_sign_raw_data.php" class="list-group-item list-group-item-action bg-light">Sign Raw Data</a>
			<a href="tron_broadcast_tx.php" class="list-group-item list-group-item-action bg-light">Broadcast Raw Tx</a>
			<a href="tron_get_tx_info.php" class="list-group-item list-group-item-action bg-light">Get Transaction Info</a>
			<a href="tron_get_balance.php" class="list-group-item list-group-item-action bg-light">Get Balance</a>
		</div>
		
		<div class="list-group-header">Tron Tool</div>
		<div class="list-group list-group-flush">
			<a href="tron_tool_base58check_hex.php" class="list-group-item list-group-item-action bg-light">Base58check Hex</a>
			
		</div>
    </div>
    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <div id="page-content-wrapper" >

      <nav class="navbar navbar-expand-lg navbar-light border-bottom" style='background-color:#5F5F5F;'>
        <button class="btn btn-success" id="menu-toggle">Tron Menu</button>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent" >
          <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
		  
			<li class="nav-item">
              <a class="nav-link" href="../tron">Tron</a>
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