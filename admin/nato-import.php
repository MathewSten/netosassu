<?php
    include_once('header.php');
    include_once('sidebar.php');
    $sql = "SELECT * FROM `neto_accounts`";
    $data = $conn->query($sql); 
	$netodata = array();
	while($row = $data->fetch_assoc()){
		$netodata[$row['id']] = $row;
	}
	if(isset($_POST['netoimport'])){
		require_once dirname(__FILE__) . '/../xlsxReader/PHPExcel/IOFactory.php';
		//$orderDataArr = $_POST;
		//echo '<pre>'; print_r($_FILES); echo '</pre>';
		$inputFileName = __DIR__.$_FILES["netoxlsx"]["name"];
		if (move_uploaded_file($_FILES["netoxlsx"]["tmp_name"], $inputFileName)) {
			//$inputFileName = $_FILES['netoxlsx']['temp_name'];
			//$inputFileName = './sampleData/example1.xls';
			$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
			$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
			//$importDatas = array();
			foreach($sheetData as $ky => $data){
				if($ky == 1){
					continue;
				}
				$sku = trim($data['A']);
				if(trim($data['C']) != ''){
					$sku = trim($data['C']);
				}
				$quintityes = explode('|',trim($data['E']));
				/*$kitedPost = '{
							  "Filter": {
								"SKU":"'.$kittedData->ComponentSKU.'",
								"IsActive":true,
								"Visible":true,
								"OutputSelector": [
								  "ID",
								  "SKU",
								  "ParentSKU",
								  "Name",
								  "Group",
								  "PriceGroups",
								  "KitComponents",
								  "WarehouseQuantity",
								  "CommittedQuantity",
								  "QuantityPerScan",
								  "BuyUnitQuantity",
								  "SellUnitQuantity",
								  "PreorderQuantity",
								  "DefaultPrice",
								  "PromotionPrice"
								]
							  }
							}';
				$request_headers = array();
				$request_headers[] = 'NETOAPI_ACTION: GetItem';
				$request_headers[] = 'NETOAPI_KEY: '.$natoapi;
				$request_headers[] = 'Accept: application/json';
				$request_headers[] = 'Content-Type:application/json';
				$natourl = 'http://'.$natosite.'.neto.com.au/do/WS/NetoAPI';
				$ch = curl_init($natourl);             
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");           
				curl_setopt($ch, CURLOPT_POSTFIELDS, $kitedPost);     
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);            
				curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);   
				$kitteddatajson = curl_exec($ch);
				curl_close($ch);
				$kittedDataArr = json_decode($kitteddatajson);
				$WarehouseQuantity = 0;
				foreach($kittedDataArr->Item->WarehouseQuantity as $kitqyt){
					$WarehouseQuantity = $WarehouseQuantity + $kitqyt;
				}*/
				
				$importDatas = '<?xml version="1.0" encoding="utf-8"?>
								<UpdateItem>
								  <Item>
									<SKU>'.$sku.'</SKU>
									<Name>'.trim($data['B']).'</Name>
									<Group>'.trim($data['D']).'</Group>
									<DefaultPrice>'.trim($data['H']).'</DefaultPrice>';
									if(!empty($quintityes)){
										foreach($quintityes as $ky => $qty){
											$i = $ky + 1;
											$importDatas .= '<WarehouseQuantity>
															  <WarehouseID>'.$i.'</WarehouseID>
															  <Quantity>'.$qty.'</Quantity>
															  <Action>Set</Action>
															</WarehouseQuantity>';
										}
									}
				$importDatas .= '</Item>
								</UpdateItem>';
				$netoId = $_POST['netoId'];
				$natoapi = $netodata[$netoId]['netoapi'];
				$natosite = $netodata[$netoId]['netosite'];
				$request_headers = array();
				$request_headers[] = 'NETOAPI_ACTION: UpdateItem';
				$request_headers[] = 'NETOAPI_KEY: '.$natoapi;
				$request_headers[] = 'Accept: application/json';
				$request_headers[] = 'Content-Type:application/json';
				$natourl = 'http://'.$natosite.'.neto.com.au/do/WS/NetoAPI';
				$ch = curl_init($natourl);             
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");           
				curl_setopt($ch, CURLOPT_POSTFIELDS, $importDatas);     
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);            
				curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);   
				$orderdata = curl_exec($ch);
				curl_close($ch);
				$orderDataArr = json_decode($orderdata);
				$msgBox = alertBox("Import successfully", "<i class='fa fa-ban'></i>", "success");
			}
			//echo '<pre>'; print_r($sheetData);	echo '</pre>';	
		}
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
                              <h3 class="box-title">Import Neto Items</h3>
                            </div>
                            <!-- /.box-header --> 
							<?php if(isset($orderDataArr)){
								//echo '<pre>'; print_r($sheetData); echo '</pre>';
								//echo '<pre>'; print_r($orderDataArr); echo '</pre>';
							} ?>
							<?php
								//$json = '';
							//echo '<pre>'; print_r(json_decode($json)); echo '</pre>';
							?>
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
									<div class="col-md-6 form-group">
										<label for="exampleInputEmail1">Select Neto Account</label>
										<input type="file" required name="netoxlsx" class="form-control" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"/>
									</div>
									</div>
								</div>
								
								
								<div class="box-footer">
									<button type="submit" id="loadingblockBtn" class="btn btn-primary" name="netoimport" value="submit">Import</button>
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
		$('#loadingblockBtn').click(function(){
			if($('[name="netoId"]').val() != '' && $('[name="netoxlsx"]').val() != ''){
				$('#loadingblock').show();
			}
		});
    });
</script>