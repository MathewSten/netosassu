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
		$postData = '{
  "Filter": {
    "OrderStatus": [
      "New",
      "Pick",
      "Pack"
    ],
    "OutputSelector": [
      "ShippingOption",
      "DeliveryInstruction",
      "Username",
      "Email",
      "ShipAddress",
      "BillAddress",
      "CustomerRef1",
      "CustomerRef2",
      "CustomerRef3",
      "CustomerRef4",
      "SalesChannel",
      "GrandTotal",
      "ShippingTotal",
      "ShippingDiscount",
      "OrderType",
      "OrderStatus",
      "OrderPayment",
      "OrderPayment.PaymentType",
      "OrderPayment.DatePaid",
      "DatePlaced",
      "DateRequired",
      "DateInvoiced",
      "DatePaid",
      "OrderLine",
      "OrderLine.ProductName",
      "OrderLine.PickQuantity",
      "OrderLine.BackorderQuantity",
      "OrderLine.UnitPrice",
      "OrderLine.WarehouseID",
      "OrderLine.WarehouseName",
      "OrderLine.WarehouseReference",
      "OrderLine.Quantity",
      "OrderLine.PercentDiscount",
      "OrderLine.ProductDiscount",
      "OrderLine.CostPrice",
      "OrderLine.ShippingMethod",
      "OrderLine.ShippingTracking",
      "ShippingSignature",
      "eBay.eBayUsername",
      "eBay.eBayStoreName",
      "OrderLine.eBay.eBayTransactionID",
      "OrderLine.eBay.eBayAuctionID",
      "OrderLine.eBay.ListingType",
      "OrderLine.eBay.DateCreated",
      "OrderLine.eBay.DatePaid"
    ],
    "UpdateResults": { "ExportStatus": "Exported" }
  }
}';
		$request_headers = array();
		$request_headers[] = 'NETOAPI_ACTION: GetOrder';
		$request_headers[] = 'NETOAPI_KEY: '.$natoapi;
		$request_headers[] = 'Accept: application/json';
		$request_headers[] = 'Content-Type:application/json';
		$natourl = 'http://'.$natosite.'.neto.com.au/do/WS/NetoAPI';
		$ch = curl_init($natourl);             
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");           
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);     
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);            
		curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);   
		$orderdata = curl_exec($ch);
		curl_close($ch);
		$orderDataArr = json_decode($orderdata);
	
		/*$request_headers = array();
		$request_headers[] = 'Content-Type:application/json';
		$sassuauth = 'https://api.saasu.com/authorisation/token';
		$sassuDetails = '{  
							"grant_type":"password",
							"username":'.$sassuuser.',
							"password":'.$sassupass.',
							"scope":"full"
						}';
		$ch = curl_init($sassuauth);             
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");           
		curl_setopt($ch, CURLOPT_POSTFIELDS, $sassuDetails);     
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);            
		curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);   
		$sassudata = curl_exec($ch);
		curl_close($ch); */
		
		
		
		$request_headers = array();
		$request_headers[] = 'Content-Type:application/json';
		$sassuauth = 'https://api.saasu.com/Invoices?FileId='.$sassufileid.'&wsAccessKey='.$sassukey;
		$ch = curl_init($sassuauth);                
		//curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);            
		curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);   
		$sassudatalist = curl_exec($ch);
		curl_close($ch); 
		
		$sassudatalistData = json_decode($sassudatalist);
		$sassuInvoices = array();
		foreach($sassudatalistData->Invoices as $invoices){
			$sassuInvoices[$invoices->TransactionId] = $invoices->PurchaseOrderNumber;
		}
		
		$sassuInsert = array();
		foreach($orderDataArr->Order as $order){
			if(!in_array($order->OrderID,$sassuInvoices)){
				$LineItems = array();
				foreach($order->OrderLine as $lineItem){
					$LineItems[] = array(
									  "Id"=>$lineItem->OrderLineID,
									  "Description"=>$lineItem->ProductName,
									  "AccountId"=>$lineItem->WarehouseID,
									  "TaxCode"=>"G1",
									  "TotalAmount"=>($lineItem->UnitPrice*$lineItem->Quantity),
									  "Quantity"=>$lineItem->Quantity,
									  "UnitPrice"=>$lineItem->UnitPrice,
									  "PercentageDiscount"=>$lineItem->PercentDiscount,
									  "InventoryId"=>4830008,
									  "ItemCode"=>$lineItem->SKU);
				}
				$sassuInsert = array(
							"LineItems"=>$LineItems,
							"Currency"=>"AUD", 
							"InvoiceType"=>"Sale Order",
							"TransactionType"=>"S",
							"Layout"=>"I",
							"Summary"=>"Invoice for Order ".$order->OrderID,
							"TotalAmount"=>$order->GrandTotal,
							"TotalTaxAmount"=>NULL,
							"IsTaxInc"=>true,						
						    "AmountPaid"=>0.0,
						    "AmountOwed"=>$order->GrandTotal,
							"FxRate"=>1.0,
						    "AutoPopulateFxRate"=>false,
						    "RequiresFollowUp"=>false,
						    "SentToContact"=>false,							
						    "TransactionDate"=>$order->DatePlaced,
						    "BillingContactId"=>12987638,
						    "CreatedDateUtc"=>$order->DatePlaced,
						    "LastModifiedDateUtc"=>$order->DatePlaced,
						    "PaymentStatus"=>"U",
						    "DueDate"=>NULL,
						    "InvoiceStatus"=>"O",
						    "PurchaseOrderNumber"=>$order->OrderID,
						    "PaymentCount"=>0);
						
			$sassuDetails = json_encode($sassuInsert);  
			$request_headers = array();
			$request_headers[] = 'Content-Type:application/json';
			$sassuauth = 'https://api.saasu.com/Invoice?FileId='.$sassufileid.'&wsAccessKey='.$sassukey;
			$ch = curl_init($sassuauth);      
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");  
			curl_setopt($ch, CURLOPT_POSTFIELDS, $sassuDetails);               
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);            
			curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);   
			$sassudatadd = curl_exec($ch);
			curl_close($ch); 
			}
		}
		$msgBox = alertBox("Order successfully added", "<i class='fa fa-ban'></i>", "success");	
		}
?>

	<body class="skin-blue">
		<div class="wrapper row-offcanvas row-offcanvas-left">
			<aside class="right-side">
				<section class="content-header">
					<h1> Neto to Saasu </h1>
					<ol class="breadcrumb">
						<li><a href="<?php echo SITE_URL_ADMIN; ?>index.php"><i class="fa fa-dashboard"></i> Home</a></li>
						<li class="active">Neto to Saasu</li>
					</ol>
				</section>
                
				<section class="content">
					<div class="row">
						<div class="col-md-12">
							<div class="box box-primary">
								<div class="box-header">
									<h3 class="box-title">Import Neto to Saasu</h3>
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
			<input type="text" required value="" class="form-control" id="natoapi" name="natoapi" placeholder="">
										</div>
										<div class="col-md-6 form-group">
											<label for="exampleInputEmail1">NATO Site</label>
			<input type="text" required value="" class="form-control" id="natosite" name="natosite" placeholder="">
										</div> 
										<div class="col-md-6 form-group">
											<label for="exampleInputEmail1">Sassu File Id</label>
			<input type="text" required value="" class="form-control" id="sassufileid" name="sassufileid" placeholder="">
										</div>
										<div class="col-md-6 form-group">
											<label for="exampleInputEmail1">Sassu Web Services Access Key</label>
			<input type="text" required value="" class="form-control" id="sassukey" name="sassukey" placeholder="">
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
										<button type="submit" class="btn btn-primary" name="submit" value="submit">Import</button>
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
