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
		$sassufileid = trim($_POST['sassufileid']);
		$sassukey = trim($_POST['sassukey']);
		$ebaystore = trim($_POST['ebaystore']);
		
		$autorun = 0;
		if(isset($_POST['autorun']) && $_POST['autorun'] == 1){
			$autorun = 1;
		}
		if(isset($_GET['id']) && $_GET['id'] != ''){
			$id = $_GET['id'];
			$sql = "UPDATE `nato_saasu` SET `netoapi` = '".$natoapi."', `netosite` = '".$natosite."',`saasufile` = '".$sassufileid."', `saasukey` = '".$sassukey."', `autostart` = '".$autorun."', `ebaystore` = '".$ebaystore."'  WHERE id = '".$id."'";
			$conn->query($sql);
			$msgBox = alertBox("Account successfully Updated", "<i class='fa fa-ban'></i>", "success");	
			$_SESSION['msg'] = $msgBox;
		} else {
			$sql = "INSERT INTO `nato_saasu` SET `netoapi` = '".$natoapi."', `netosite` = '".$natosite."',`saasufile` = '".$sassufileid."', `saasukey` = '".$sassukey."', `autostart` = '".$autorun."', `ebaystore` = '".$ebaystore."'";
			$conn->query($sql);
			$msgBox = alertBox("Account successfully added", "<i class='fa fa-ban'></i>", "success");
			$_SESSION['msg'] = $msgBox;
		}
		if(isset($_SESSION['msg'])){
			$sql = "DELETE FROM `sassu_items` WHERE `sassu_file` = '".$sassufileid."'";
			$conn->query($sql);
			$sql = "DELETE FROM `sassu_contacts` WHERE `sassu_file` = '".$sassufileid."'";
			$conn->query($sql);
			for($i=1;$i<=100;$i++){
				$request_headers = array();
				$request_headers[] = 'Content-Type:application/json';
				$sassuauth = 'https://api.saasu.com/Items?FileId='.$sassufileid.'&wsAccessKey='.$sassukey.'&PageSize=100&Page='.$i;
				$ch = curl_init($sassuauth);      
				//curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");  
				//curl_setopt($ch, CURLOPT_POSTFIELDS, $sassuDetails);               
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);            
				curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);   
				$sassu_itemsJson = curl_exec($ch);
				curl_close($ch);
				$sassu_items = json_decode($sassu_itemsJson); 
				if(empty($sassu_items->Items)){
					break;
				}
				foreach($sassu_items->Items as $sassu_item){
					$sql = "INSERT INTO `sassu_items` SET `sassu_file` = '".$sassufileid."', `item_name` = '".$sassu_item->Description."',`item_code` = '".$sassu_item->Code."', `item_sku` = '".$sassu_item->Code."', `item_id` = '".$sassu_item->Id."', `other` = '".$sassu_item->Type."'";
					$conn->query($sql);
				}
			}
			for($j=1;$j<=100;$j++){
				$request_headers = array();
				$request_headers[] = 'Content-Type:application/json';
				$sassuauth = 'https://api.saasu.com/Contacts?FileId='.$sassufileid.'&wsAccessKey='.$sassukey.'&PageSize=100&Page='.$j;
				$ch = curl_init($sassuauth);      
				//curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");  
				//curl_setopt($ch, CURLOPT_POSTFIELDS, $sassuDetails);               
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);            
				curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);   
				$sassu_contactsJson = curl_exec($ch);
				curl_close($ch); 
				$sassu_contacts = json_decode($sassu_contactsJson); 
				if(empty($sassu_contacts->Contacts)){
					break;
				}
				foreach($sassu_contacts->Contacts as $sassu_contact){
					$sql = "INSERT INTO `sassu_contacts` SET `sassu_file` = '".$sassufileid."', `contact_name` = '".$sassu_contact->GivenName."',`contact_id` = '".$sassu_contact->Id."', `contact_email` = '".$sassu_contact->EmailAddress."', `contact_phone` = '".$sassu_contact->PrimaryPhone."', `contactid` = '".$sassu_contact->ContactId."'";
					$conn->query($sql);
				}
			}
		}
		echo '<script>window.location.href="'.SITE_URL_ADMIN.'nato-saasu.php"</script>';
	}
	$accountData = array();
	if(isset($_GET['id']) && $_GET['id'] != ''){
		$id = $_GET['id'];
		$sql = "SELECT * FROM `nato_saasu` WHERE id = '".$id."'";
   		$data = $conn->query($sql); 
		$accountData = $data->fetch_assoc();
	}
?>

	<body class="skin-blue">
		<div class="wrapper row-offcanvas row-offcanvas-left">
			<aside class="right-side">
				<section class="content-header">
					<h1> Neto & Saasu Account Details </h1>
					<ol class="breadcrumb">
						<li><a href="<?php echo SITE_URL_ADMIN; ?>index.php"><i class="fa fa-dashboard"></i> Home</a></li>
						<li class="active">Neto & Saasu Account Details </li>
					</ol>
				</section>
                
				<section class="content">
					<div class="row">
						<div class="col-md-12">
							<div class="box box-primary">
								<div class="box-header">
									<h3 class="box-title">Neto & Saasu Account Details</h3>
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
										<div class="col-md-6 form-group">
											<label for="exampleInputEmail1">Sassu File Id</label>
			<input type="text" required value="<?php echo @$accountData['saasufile']; ?>" class="form-control" id="sassufileid" name="sassufileid" placeholder="">
										</div>
										<div class="col-md-6 form-group">
											<label for="exampleInputEmail1">Sassu Web Services Access Key</label>
			<input type="text" required value="<?php echo @$accountData['saasukey']; ?>" class="form-control" id="sassukey" name="sassukey" placeholder="">
										</div>
										<div class="col-md-6 form-group">
											<label for="exampleInputEmail1">Ebay Store Name</label>
			<input type="text" required value="<?php echo @$accountData['ebaystore']; ?>" class="form-control" id="ebaystore" name="ebaystore" placeholder="">
										</div>
										<div class="col-md-6 form-group" style="margin-left:20px;">
											<div class="checkbox">
											  <label><input type="checkbox" value="1" id="autorun" name="autorun" <?php if(isset($accountData['autostart']) && $accountData['autostart'] == 1){ echo 'checked="checked"';} ?>>Allow TO Auto Schedule</label>
											</div>
										</div>
										<!--<div class="col-md-6 form-group">
											<label for="exampleInputEmail1">Sassu UserName</label>
			<input type="text" required value="" class="form-control" id="sassuuser" name="sassuuser" placeholder="">
										</div>
										<div class="col-md-6 form-group">
											<label for="exampleInputEmail1">Sassu Password</label>
			<input type="text" required value="" class="form-control" id="sassupass" name="sassupass" placeholder="">
										</div>-->
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
