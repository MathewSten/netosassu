<?php
    include_once('header.php');
		
	if(isset($_GET['id']) && $_GET['id'] != ''){
		$id = $_GET['id'];
		$sql = "SELECT * FROM `nato_saasu` WHERE id = '".$id."'";
   		$data = $conn->query($sql); 
		$accountData = $data->fetch_assoc();		
		$natoapi = trim($accountData['netoapi']);
		$natosite = trim($accountData['netosite']);
		$sassufileid = trim($accountData['saasufile']);
		$sassukey = trim($accountData['saasukey']);		
		
		$sql = "SELECT * FROM `sassu_items` WHERE sassu_file = '".$sassufileid."'";
   		$items = $conn->query($sql);
		$sassu_items = array(); 
		if($items->num_rows > 0){
			while($item = $items->fetch_assoc()){
				$sassu_items[$item['item_code']] = $item;
			}
		}
		//echo '<pre>'; print_r($sassu_items); echo '</pre>';	
		$sql = "SELECT * FROM `sassu_contacts` WHERE sassu_file = '".$sassufileid."'";
   		$contacts = $conn->query($sql);
		$sassu_contacts = array(); 
		if($contacts->num_rows > 0){
			while($contact = $contacts->fetch_assoc()){
				$sassu_contacts[$contact['contact_email']] = $contact;
			}
		}
		//echo '<pre>'; print_r($sassu_contacts); echo '</pre>';	
	//"DateRequiredFrom": "'.date('Y-m-d').' 00:00:00",
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
		//echo '<pre>'; print_r($orderDataArr); echo '</pre>';//die;
		if($orderDataArr->Ack != 'Error'){
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
		//echo '<pre>'; print_r($sassudatalistData); die;
		$sassuInvoices = array();
		$sassuContactsCont = array();
		$sassuIitemsCont = array();
		foreach($sassudatalistData->Invoices as $invoices){
			$sassuInvoices[$invoices->TransactionId] = $invoices->PurchaseOrderNumber;
		}
		
		$sassuInsert = array();
		//$okinsert = 0;
		foreach($orderDataArr->Order as $order){
			if(!in_array($order->OrderID,$sassuInvoices)){
				if(trim($accountData['ebaystore']) != '' && isset($order->eBay->eBayStoreName) && isset($order->eBay)){
				if($order->eBay->eBayStoreName != trim($accountData['ebaystore'])){
					continue;
				}
			}
			if(!isset($sassu_contacts[$order->Email]['contact_id'])){
				$sassuContactsCont[] = $order->Email;
				continue;
			}
				/*if($okinsert == 1){
					continue;
				}*/
				$LineItems = array();
				//$itemsIds = array('4843131','4843132','4843133');
				foreach($order->OrderLine as $kyi => $lineItem){
					if(!isset($sassu_items[$lineItem->SKU]['item_id'])){
						$sassuIitemsCont[] = $lineItem->SKU;
						continue;
					}
					$LineItems[] = array(
									  "Id"=>$lineItem->OrderLineID,
									  "Description"=>$lineItem->ProductName,
									  "AccountId"=>$lineItem->WarehouseID,
									  "TaxCode"=>"G1",
									  "TotalAmount"=>($lineItem->UnitPrice*$lineItem->Quantity),
									  "Quantity"=>$lineItem->Quantity,
									  "UnitPrice"=>$lineItem->UnitPrice,
									  "PercentageDiscount"=>$lineItem->PercentDiscount,
									  "InventoryId"=>$sassu_items[$lineItem->SKU]['item_id'],
									  "ItemCode"=>$lineItem->SKU);
				}
				if(empty($LineItems)){
					continue;
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
						    "BillingContactId"=>$sassu_contacts[$order->Email]['contact_id'],
						    "CreatedDateUtc"=>$order->DatePlaced,
						    "LastModifiedDateUtc"=>$order->DatePlaced,
						    "PaymentStatus"=>"U",
						    "DueDate"=>NULL,
						    "InvoiceStatus"=>"O",
						    "PurchaseOrderNumber"=>$order->OrderID,
						    "PaymentCount"=>0);
			//echo '<pre>'; print_r($sassuInsert); echo '</pre>';			
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
			//echo '<pre>'; print_r(json_decode($sassudatadd)); echo '</pre>'; //die;
			//$okinsert = 1;
			}
		}
		//echo '<pre>'; print_r(array_unique($sassuIitemsCont)); echo '</pre>';
		//echo '<pre>'; print_r(array_unique($sassuContactsCont)); echo '</pre>';
		$msgBox = alertBox("Data successfully imported", "<i class='fa fa-ban'></i>", "success");
		} else {
		$errors = $orderDataArr->Messages;
		$errmsg = $errors[0]->Error->Message;
		$msgBox = alertBox($errmsg, "<i class='fa fa-ban'></i>", "danger");
		}
		$_SESSION['msg'] = $msgBox;	
		header("Location:".SITE_URL_ADMIN.'nato-saasu.php');
}
?>