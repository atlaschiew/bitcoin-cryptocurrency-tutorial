<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="keywords" content="<?php echo $_HTML['meta']['keywords']?>">
	<meta property="og:image" content="https://www.btcschools.net/media/images/logo/logo_portrait_200x200.png">
	<meta property="og:title" content="PHP & Cryptocurrencies Collections.">
	<meta property="og:url" content="https://www.btcschools.net/">
	<meta property="og:description" content="Btcschools is practical oriented tutorial site come with best PHP & Cryptocurrencies Collections.">

	<title><?php echo $_HTML['title']?></title>

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

    <!-- Sidebar -->
    <div class="bg-light " id="sidebar-wrapper">
		<div class="sidebar-heading"><a style='color:white;text-decoration:none;' href="<?php echo $_SERVER['HTTPS'] ? 'https' : 'http'?>://<?php echo $_SERVER['HTTP_HOST']?>">btcschools.net</a></div>
	  
		<div class="list-group-header">Bitcoin</div>
		<div class="list-group list-group-flush">
			<a href="/bitcoin" class="list-group-item list-group-item-action bg-light">Learn Bitcoin</a>
			<a href="/bitwasp" class="list-group-item list-group-item-action bg-light">Learn Bitwasp, includes</a>
			<a href="#" class="list-group-item list-group-item-action bg-light disabled">&nbsp;&nbsp;<img src='media/images/git_fork.png' style="width:16px;height:16px;"/> Litecoin</a>
			<a href="#" class="list-group-item list-group-item-action bg-light disabled">&nbsp;&nbsp;<img src='media/images/git_fork.png' style="width:16px;height:16px;"/> Dash</a>
			<a href="#" class="list-group-item list-group-item-action bg-light disabled">&nbsp;&nbsp;<img src='media/images/git_fork.png' style="width:16px;height:16px;"/> Doge</a>
			
			<a href="#" class="list-group-item list-group-item-action bg-light disabled">&nbsp;&nbsp;<img src='media/images/git_fork.png' style="width:16px;height:16px;"/> Zcash</a>
			
		</div>
		
		<div class="list-group-header">Ethereum</div>
		<div class="list-group list-group-flush">
			
			<a href="/ethereum" class="list-group-item list-group-item-action bg-light">Learn Ethereum</a>
			<a href="/eth_js" class="list-group-item list-group-item-action bg-light">Learn Eth Js</a>
			<a href="/eth_smartcontract" class="list-group-item list-group-item-action bg-light">Learn Smart Contract</a>
		</div>
		
		<div class="list-group-header">Tron</div>
		<div class="list-group list-group-flush">
			
			<a href="/tron" class="list-group-item list-group-item-action bg-light">Learn Tron</a>
	
		</div>
		
		<div class="list-group-header">Others</div>
		<div class="list-group list-group-flush">
			<a href="/others/qr_code.php" class="list-group-item list-group-item-action bg-light">QR Code Generator</a>
		</div>
		
		
    </div>
    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <div id="page-content-wrapper" >

      <nav class="navbar navbar-expand-lg navbar-light border-bottom" style='background-color:#5F5F5F;'>
        <button class="btn btn-success" id="menu-toggle">Index</button>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent" >
          <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
			<li class="nav-item">
              <a class="nav-link" href="/bitcoin">Bitcoin</a>
            </li>
            <li class="nav-item active">
              <a class="nav-link" href="/bitwasp">Bitwasp</a>
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