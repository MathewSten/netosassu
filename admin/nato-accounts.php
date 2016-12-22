<?php
    include_once('header.php');
    include_once('sidebar.php');
    $sql = "SELECT * FROM `neto_accounts`";
    $data = $conn->query($sql); 
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
                              <h3 class="box-title">Neto Account List</h3>
							  <a href="nato-account-add.php" class="btn btn-info" style="margin:10px 10px 0 0; float:right;">Add New Account</a>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-footer">
									<?php if (isset($_SESSION['msg']) && $_SESSION['msg']!="") { 
										echo $_SESSION['msg']; 
										unset($_SESSION['msg']);
									} ?>
							</div>
                            <div class="box-body table-responsive">
                              <table class="table table-bordered table-hover" id="example2">
                                <thead>
                                  <tr>
                                    <th>No</th>
                                    <th>Neto Site</th>
                                    <th>Neto Api</th>
                                    <th>Action</th>
                                  </tr>
                                </thead>
                                
                                <tbody>
                                <?php 
                                if ($data->num_rows > 0) {
                                    $i=1;
                                   while($row = $data->fetch_assoc()) { ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $row['netosite']; ?></td>
                                            <td><?php echo $row['netoapi']; ?></td>
                                            <td>
				<a href="nato-account-add.php?id=<?php echo $row['id'] ?>" title="Edit"><img src="img/edit-icon.gif"></a>
				&nbsp;&nbsp;
				<a href="nato-accounts-delete.php?id=<?php echo $row['id'] ?>" title="Delete"><img src="img/cross.gif"></a>
                                            </td>
                                        </tr>
                                    <?php
                                            $i++;
                                    }
                                }
                                ?>
                                </tbody>
                                <tfoot>
                                  <tr> </tr>
                                </tfoot>
                              </table>
                            </div>
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
		<img alt="Loading" src="ring-alt.gif"></p>
<?php include_once('footer.php'); ?>
<script src="js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script> 
<script src="js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script> 
<script type="text/javascript">
    $(function() {
        $("#example1").dataTable();
        $('#example2').dataTable({
            "bPaginate": true,
            "bLengthChange": false,
            "bFilter": true,
            "bSort": true,
            "bInfo": true,
            "bAutoWidth": false
        });
		$('.loadingblock').click(function(){
			$('#loadingblock').show();
		});
    });
</script>