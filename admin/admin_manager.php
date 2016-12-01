<?php
    include_once('header.php');
    include_once('sidebar.php');
	
	$msg = '';


	if(isset($_POST['id']) && !empty($_POST['id'])){
		$id = $_POST['id'];
		$a_name = $_POST['name'];
		$a_email = $_POST['email'];
		$a_pass = $_POST['password'];
		$a_cpass = $_POST['conpassword'];
		
		if($a_name == ''){
			$msgBox = alertBox("Please enter name", "<i class='fa fa-ban'></i>", "danger");
		}
		else if($a_email == ''){
			$msgBox = alertBox("Please enter email", "<i class='fa fa-ban'></i>", "danger");
		}
		else if (!preg_match("/^[A-Z0-9._%-]+@[A-Z0-9][A-Z0-9.-]{0,61}[A-Z0-9]\.[A-Z]{2,6}$/i",$a_email))
		{
			$msgBox = alertBox("Please enter valid email address", "<i class='fa fa-ban'></i>", "danger");
		}
		else if(!empty($a_pass) && $a_cpass == ''){
			$msgBox = alertBox("Please enter Confirm Password", "<i class='fa fa-ban'></i>", "danger");
		}
		else if(!empty($a_pass) && $a_pass != $a_cpass){
			$msgBox = alertBox(" Password and Confirm Password must be same. ", "<i class='fa fa-ban'></i>", "danger");
		}
		else{
			if(!empty($a_pass)){
				$sql = "UPDATE `users` SET `name` = '".$a_name."', `email` = '".$a_email."', `password` = '".md5($a_pass)."' WHERE id = '".$id."'";	
			}
			else{
				$sql = "UPDATE `users` SET `name` = '".$a_name."', `email` = '".$a_email."' WHERE id = '".$id."'";
			}
			$qry = $conn->query($sql);
			
			$select = $conn->query("select * from users where email = '".$a_email."' AND role_id = 1");
			$count = mysqli_num_rows($select);
			$data = mysqli_fetch_array($select);

			if($count!=0)
			{
				$_SESSION['admin_email'] = $data['email'];
				$_SESSION['admin_name'] = $data['name'];
				$_SESSION['admin_id'] = $data['id'];
				$_SESSION['msg'] = "Record Update Successfully";
				
				
				$ur = SITE_URL_ADMIN.'client.php';
				echo "<script>window.location.href = '".$ur."'</script>";
			}
		}
	}
?>
	<body class="skin-blue">
		<div class="wrapper row-offcanvas row-offcanvas-left">
			<aside class="right-side">
				<section class="content-header">
					<h1> Admin Manager </h1>
					<ol class="breadcrumb">
						<li><a href="<?php echo SITE_URL_ADMIN; ?>index.php"><i class="fa fa-dashboard"></i> Home</a></li>
						<li><a href="<?php echo SITE_URL_ADMIN; ?>admin_manager.php">Admin Manager</a></li>
						<li class="active">Add admin User</li>
					</ol>
				</section>
                
				<section class="content">
					<div class="row">
						<div class="col-md-12">
							<div class="box box-primary">
								<div class="box-header">
									<h3 class="box-title">Update Info</h3>
								</div><!-- /.box-header -->
								
								<div class="box-footer">
									<?php if (isset($msgBox) && $msgBox!="") { echo $msgBox; } ?>
								</div>

								<form role="form" method="post" action="<?php echo SITE_URL_ADMIN; ?>admin_manager.php">
									<input type="hidden" name="id" value="<?php echo $adminId;?>" />
									<div class="box-body row">
										<div class="col-md-6">
										<div class="form-group">
											<label for="exampleInputEmail1">Name</label>
											<input type="text" value="<?php echo $_SESSION['admin_name']; ?>" class="form-control" id="name" name="name" placeholder="Enter name">
										</div>
										</div>
										<div class="col-md-6">
										<div class="form-group">
											<label for="exampleInputEmail1">Email</label>
											<input type="text" value="<?php  echo $_SESSION['admin_email'];?>" class="form-control" id="email" name="email" placeholder="Enter Email">
										</div>
										</div>
										<div class="col-md-6">
										<div class="form-group">
											<label for="exampleInputPassword1">Password</label>
											<input type="password" class="form-control" id="password" name="password" placeholder="Enter Password">
										</div>
										</div>
										<div class="col-md-6">
										<div class="form-group">
											<label for="exampleInputPassword1">Confrim Password</label>
											<input type="password" class="form-control" id="conpassword" name="conpassword"  placeholder="Retype Password">
										</div>
										</div>
									</div>
									
									<div class="box-footer">
										<button type="submit" class="btn btn-primary" name="submit" onClick="">Update</button>
										<a href="<?php echo SITE_URL_ADMIN; ?>dashboard.php" class="btn btn-primary">Back</a>
									</div>
								</form>
							</div>
						</div>
					</div>
				</section>
			</aside><!-- /.right-side -->
		</div><!-- ./wrapper -->

		<?php include("footer.php");?>
    </body>
</html>
