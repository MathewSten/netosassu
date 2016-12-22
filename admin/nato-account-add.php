<?php
    include_once('header.php');
    include_once('sidebar.php');
		
	$msg = '';
	$claimant = '';
	$first_respondent = '';
	$second_respondent = '';
	$accident = '';
	

	if(isset($_POST['submit']) && !empty($_POST['submit'])){		
		$natoapi = trim($_POST['natoapi']);
		$natosite = trim($_POST['natosite']);
		if(isset($_GET['id']) && $_GET['id'] != ''){
			$id = $_GET['id'];
			$sql = "UPDATE `neto_accounts` SET `netoapi` = '".$natoapi."', `netosite` = '".$natosite."'  WHERE id = '".$id."'";
			$conn->query($sql);
			$msgBox = alertBox("Account successfully Updated", "<i class='fa fa-ban'></i>", "success");	
			$_SESSION['msg'] = $msgBox;
		} else {
			$sql = "INSERT INTO `neto_accounts` SET `netoapi` = '".$natoapi."', `netosite` = '".$natosite."'";
			$conn->query($sql);
			$msgBox = alertBox("Account successfully added", "<i class='fa fa-ban'></i>", "success");
			$_SESSION['msg'] = $msgBox;
		}
		echo '<script>window.location.href="'.SITE_URL_ADMIN.'nato-accounts.php"</script>';
	}
	$accountData = array();
	if(isset($_GET['id']) && $_GET['id'] != ''){
		$id = $_GET['id'];
		$sql = "SELECT * FROM `neto_accounts` WHERE id = '".$id."'";
   		$data = $conn->query($sql); 
		$accountData = $data->fetch_assoc();
	}
?>

	<body class="skin-blue">
		<div class="wrapper row-offcanvas row-offcanvas-left">
			<aside class="right-side">
				<section class="content-header">
					<h1> Neto Account Details </h1>
					<ol class="breadcrumb">
						<li><a href="<?php echo SITE_URL_ADMIN; ?>index.php"><i class="fa fa-dashboard"></i> Home</a></li>
						<li class="active">Neto Account Details </li>
					</ol>
				</section>
                
				<section class="content">
					<div class="row">
						<div class="col-md-12">
							<div class="box box-primary">
								<div class="box-header">
									<h3 class="box-title">Neto Account Details</h3>
								</div><!-- /.box-header -->
								
								<div class="box-footer">
									<?php if (isset($msgBox) && $msgBox!="") { echo $msgBox; } ?>
								</div>

								<form role="form" method="post" action="" enctype="multipart/form-data">
									<div class="box-body">
										<?php
											if(isset($orderdata)){
												/*echo '<pre>';
												print_r(json_decode($orderdata));
												echo '</pre>';	
												echo '<pre>';
												print_r($sassuInvoices);
												echo '</pre>';*/
												/*echo '<pre>';
												print_r(json_decode($sassudatalist));
												echo '</pre>';		
												echo '<pre>';
												print_r(json_decode($sassudatadd));
												echo '</pre>';
												echo '<pre>';
												print_r($sassuInsert);
												echo '</pre>';*/																				
											}
										?>
										<div class="col-md-6 form-group">
											<label for="exampleInputEmail1">Nato API ID</label>
			<input type="text" required value="<?php echo @$accountData['netoapi']; ?>" class="form-control" id="natoapi" name="natoapi" placeholder="">
										</div>
										<div class="col-md-6 form-group">
											<label for="exampleInputEmail1">NATO Site</label>
			<input type="text" required value="<?php echo @$accountData['netosite']; ?>" class="form-control" id="natosite" name="natosite" placeholder="">
										</div> 
									</div>
									
									
									<div class="box-footer">
										<button type="submit" class="btn btn-primary" name="submit" value="submit">Save</button>
										<a href="<?php echo SITE_URL_ADMIN; ?>dashboard.php" class="btn btn-primary">Back</a>
									</div>
								</form>
							</div>
						</div>
					</div>
				</section>
			</aside><!-- /.right-side -->
		</div><!-- ./wrapper -->

<script src="../includes/ckeditor/ckeditor.js"></script>

        
<?php include("footer.php");?>
<script src="http://code.jquery.com/jquery-1.10.2.js"></script>        
<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css"> 
<script> 
  $(function() { 
      $( "#accident" ).datepicker();
  });
</script>

<style>
.box .box-footer{
clear:both;
}
</style>
    </body>
</html>
