<?php 
	include_once('../common/config.php');	
	include_once('function.php');
	include_once('exportNeto.php');
	/* Check Admin Login */
	if(!isset($_SESSION['admin_email']) && $_SESSION['admin_id']=='')
	{
		//header('Location: '.SITE_URL_ADMIN.'login.php');
	}	
	if(isset($_SESSION['admin_name']) && $_SESSION['admin_name']!='' )
	{
		$username = $_SESSION['admin_name'];
		$adminId = $_SESSION['admin_id'];
	}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>AdminLTE | Data Tables</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

        <link href="<?php echo SITE_URL_ADMIN; ?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo SITE_URL_ADMIN; ?>css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo SITE_URL_ADMIN; ?>css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo SITE_URL_ADMIN; ?>css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo SITE_URL_ADMIN; ?>css/AdminLTE.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo SITE_URL_ADMIN; ?>fonts/fonts/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        
		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->

        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->

        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>

	<header class="header">
		<a href="<?php echo SITE_URL_ADMIN; ?>" class="logo">Admin</a>
		<!-- Header Navbar: style can be found in header.less -->
		
		<nav class="navbar navbar-static-top" role="navigation">
			<!-- Sidebar toggle button-->
			<!--<a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>-->
			
			<div class="navbar-right">
				<ul class="nav navbar-nav">
					<!-- User Account: style can be found in dropdown.less -->
					<li class="dropdown user user-menu">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<i class="glyphicon glyphicon-user"></i>
							<span><?php echo $_SESSION['admin_name'];?> <i class="caret"></i></span>
						</a>
						
						<ul class="dropdown-menu">
							<!-- User image -->
							<li class="user-header bg-light-blue">
								<img src="<?php echo SITE_URL_ADMIN; ?>img/avatar3.png" class="img-circle" alt="User Image" />
								<p>
									<?php echo $_SESSION['admin_name'];?>
									<small>Admin Manager</small>
								</p>
							</li>
							
							<!-- Menu Footer-->
							<li class="user-footer">
								<div class="pull-left">
									<a href="<?php echo SITE_URL_ADMIN?>admin_manager.php" class="btn btn-default btn-flat">Profile</a>
								</div>
									
								<div class="pull-right">
									<a href="<?php echo SITE_URL_ADMIN?>logout.php" class="btn btn-default btn-flat">Sign out</a>
								</div>
							</li>
						</ul>
					</li>
				</ul>
			</div>
		</nav>
	</header>

    
