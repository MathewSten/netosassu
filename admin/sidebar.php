<aside class="left-side sidebar-offcanvas">
	<!-- sidebar: style can be found in sidebar.less -->
	<section class="sidebar">
		<!-- Sidebar user panel -->
		<div class="user-panel">
			<div class="pull-left image">
				<img src="<?php echo SITE_URL_ADMIN; ?>img/avatar3.png" class="img-circle" alt="User Image" />
			</div>
			
			<div class="pull-left info">
				<p>Hello, <?php echo $username; ?></p>
				<a href="#"><i class="fa fa-circle text-success"></i> Online</a>
			</div>
		</div>
		
		<ul class="sidebar-menu">
			<li>
				<a href="<?php echo SITE_URL_ADMIN; ?>admin_manager.php">
					<i class="fa fa-cog"></i>
					<span>Admin Manager</span>
				</a>
			</li>
			<li>
				<div class="dropdown">
					<a class="btn dropdown-toggle" style="box-shadow:none;" data-toggle="dropdown">
					<i class="fa fa-cog"></i><span style="padding:0px 14px;">Neto to Saasu</span>
					<span class="caret"></span></a>
					<ul class="dropdown-menu" style="width:100%;">
					  <li><a href="<?php echo SITE_URL_ADMIN; ?>nato-saasu.php">List Accounts</a></li>
					  <li><a href="<?php echo SITE_URL_ADMIN; ?>nato-saasu-add.php">Add Account</a></li>
					</ul>
				  </div>
			</li>
			<li>
				<div class="dropdown">
					<a class="btn dropdown-toggle" style="box-shadow:none;" data-toggle="dropdown">
					<i class="fa fa-cog"></i><span style="padding:0px 14px;">Neto Sync</span>
					<span class="caret"></span></a>
					<ul class="dropdown-menu" style="width:100%;">
					  <li><a href="<?php echo SITE_URL_ADMIN; ?>nato-accounts.php">List Neto Accounts</a></li>
					  <li><a href="<?php echo SITE_URL_ADMIN; ?>nato-account-add.php">Add Neto Account</a></li>
					  <li><a href="<?php echo SITE_URL_ADMIN; ?>nato-export.php">Export Neto Items</a></li>
					  <li><a href="<?php echo SITE_URL_ADMIN; ?>nato-import.php">Import Neto Items</a></li>
					</ul>
				  </div>
			</li>		
			<li>
				<a href="<?php echo SITE_URL_ADMIN; ?>logout.php">
					<i class="fa fa-lock"></i>
					<span>Logout</span>
				</a>
			</li>
		</ul>
	</section>
</aside>
