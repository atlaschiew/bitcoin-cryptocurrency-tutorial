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
	  
		<div class="list-group-header">Eth Js Menu</div>
	
		<div class="list-group list-group-flush">
			<a href="eth_js_intro.php" class="list-group-item list-group-item-action bg-light">Intro</a>
		</div>
		
		<div class="list-group list-group-flush">
			<a href="eth_js_inject_web3.php" class="list-group-item list-group-item-action bg-light">Inject Web3</a>
		</div>
	
    </div>
    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <div id="page-content-wrapper" >

      <nav class="navbar navbar-expand-lg navbar-light border-bottom" style='background-color:#5F5F5F;'>
        <button class="btn btn-success" id="menu-toggle">Eth Js Menu</button>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent" >
          <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
		  
			<li class="nav-item">
              <a class="nav-link" href="../ethereum">Ethereum</a>
            </li>
            <li class="nav-item active">
              <a class="nav-link" href="../eth_smartcontract">Smart Contract</a>
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