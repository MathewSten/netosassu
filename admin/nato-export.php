<?php
    include_once('header.php');
    include_once('sidebar.php');
    $sql = "SELECT * FROM `neto_accounts`";
    $data = $conn->query($sql); 
	$netodata = array();
	while($row = $data->fetch_assoc()){
		$netodata[$row['id']] = $row;
	}
	$autoImport = array('Not Allowed', 'Allowed');
?>
    <body class="skin-blue">
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <aside class="right-side">
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12" style="min-height:500px;">
                          <div class="box">
                            <div class="box-header">
                              <h3 class="box-title">Export Neto Items</h3>
                            </div>
                            <!-- /.box-header --> 
							<?php if(isset($orderDataArr)){
								//echo '<pre>'; print_r($orderDataArr); echo '</pre>';
							} ?>
							<?php if (isset($_SESSION['msg']) && $_SESSION['msg']!="") { 
								echo '<div class="box-footer">'.$_SESSION['msg'].'</div>'; 
								unset($_SESSION['msg']);
							} ?>
							<?php if (isset($msgBox) && $msgBox!="") { ?>                           
							<div class="box-footer">
								 <?php echo $msgBox; ?>
							</div>
							<?php } ?>
							<form role="form" method="post" action="" enctype="multipart/form-data">
								<div class="box-body col-md-12">
									<div class="row">
									<div class="col-md-6 form-group">
										<label for="exampleInputEmail1">Select Neto Account</label>
										<select class="form-control" required name="netoId">
											<option value="">--Select Neto Account--</option>
											<?php foreach($netodata as $row){ ?>
												<option value="<?php echo $row['id']; ?>">
													<?php echo $row['netosite']; ?>
												</option>
											<?php } ?> 
										</select>
									</div>
									<?php /*?><div class="col-md-6 form-group">
										<label for="exampleInputEmail1">Select Page No</label>
										<select class="form-control" required name="page_no">
											<?php for($i=1;$i<=100;$i++){ ?>
												<option value="<?php echo $i; ?>">
													<?php echo $i; ?>
												</option>
											<?php } ?> 
										</select>
									</div><?php */?>
									</div>
								</div>
								
								
								<div class="box-footer">
									<button type="submit" id="loadingblockBtn" class="btn btn-primary" name="netoexport" value="submit">Export</button>
									<a href="<?php echo SITE_URL_ADMIN; ?>dashboard.php" class="btn btn-primary">Back</a>
								</div>
							</form>
                            <!-- /.box-body --> 
                            
                          </div>
                          <!-- /.box --> 
                          
                          <!-- /.box --> 
                          
                        </div>
                      </div>
                </section>
            </aside>
        </div>
    </body>
<p style="text-align: center; position: fixed; width: 100%; z-index: 99999; background: rgba(255, 255, 255, 0.5); left: 0px; top: 0px; height: 100%;display: none; padding-top:5%;" id="loadingblock">
		<img alt="Loading" src="ripple.gif"></p>
<?php include_once('footer.php'); ?>
<script src="js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script> 
<script src="js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.js" type="text/javascript"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.blockUI/2.70/jquery.blockUI.js" type="text/javascript"></script> 

<script type="text/javascript">
    $(function() {
		//lodingDisable();
        $("#example1").dataTable();
        $('#example2').dataTable({
            "bPaginate": true,
            "bLengthChange": false,
            "bFilter": true,
            "bSort": true,
            "bInfo": true,
            "bAutoWidth": false
        });
		$('#loadingblockBtn').click(function(){
			if($('[name="netoId"]').val() != ''){
				$('#loadingblock').show();
				blockUIForDownload();
			}
		});
		  var fileDownloadCheckTimer;
		  function blockUIForDownload() {
			var token = new Date().getTime(); //use the current timestamp as the token value
			//$('#download_token_value_id').val(token);
			//$.blockUI();
			fileDownloadCheckTimer = window.setInterval(function () {
			  var cookieValue = $.cookie('fileDownloadTokenFile');
			  console.log(cookieValue);
			  if (cookieValue == 'Complete')
			   finishDownload();
			}, 1000);
		  }
		  function finishDownload() {
			 window.clearInterval(fileDownloadCheckTimer);
			 $.removeCookie('fileDownloadTokenFile'); //clears this cookie value
			 $('#loadingblock').hide();
			 location.reload();
			 //$.unblockUI();
		  }
    });
</script>