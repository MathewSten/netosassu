<?php	
	if(isset($_POST['netoexport'])){ 
		//echo '<pre>'; print_r($_POST); echo '</pre>'; die;
		$netoId = $_POST['netoId'];
		//$page_no = $_POST['page_no'];
		$sql = "SELECT * FROM `neto_accounts` where id = ".$netoId;
		$data = $conn->query($sql); 
		$netodata = array();
		while($row = $data->fetch_assoc()){
			$netodata[$row['id']] = $row;
		}		
		require_once dirname(__FILE__) . '/../xlsxReader/PHPExcel.php';
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator("Pawan Goyal")
									 ->setLastModifiedBy("Pawan Goyal")
									 ->setTitle("Neto Items")
									 ->setSubject("Neto Items")
									 ->setDescription("Neto Items")
									 ->setKeywords("Neto Items")
									 ->setCategory("Neto Items");		
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A1', 'SKU')
					->setCellValue('B1', 'Name')
					->setCellValue('C1', 'Kitted SKU')
					->setCellValue('D1', 'Group Name')
					->setCellValue('E1', 'Quantity')
					->setCellValue('F1', 'Minimum Quantity')
					->setCellValue('G1', 'Maximum Quantity')
					->setCellValue('H1', 'Price');
		$autoImport = array('Not Allowed', 'Allowed');
		$natoapi = $netodata[$netoId]['netoapi'];
		$natosite = $netodata[$netoId]['netosite'];
		$i = 2;
		$itemDatsArrayExport = array();
		for($page_no=1;$page_no<=100;$page_no++){
		$postData = '{
		  "Filter": {
			"IsActive":true,
			"Visible":true,
			"Page":'.$page_no.',
			"Limit":200,
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
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);     
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);            
		curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);   
		$orderdata = curl_exec($ch);
		curl_close($ch);
		$orderDataArr = json_decode($orderdata);
		ob_start();
		if(empty($orderDataArr->Item)){
			break;
		}
		//echo '<pre>'; print_r($orderDataArr->Item); echo '</pre>'; die;
		foreach($orderDataArr->Item as $ky => $item){
		//$i = $ky + 2;
		
		/*if(!empty($item->KitComponents[0]->KitComponent)){
		echo '<pre>'; print_r($item); echo '</pre>';
		}*/
		$group = '';
		if($item->Group != 0){
			$group = $item->Group; 
		}
		$kittedSKu = '';
		if(!empty($item->KitComponents[0]->KitComponent)){
			if(is_array($item->KitComponents[0]->KitComponent)){
				//$kittedSKu = $item->KitComponents[0]->KitComponent[0]->ComponentSKU;
				foreach($item->KitComponents[0]->KitComponent as $kittedData){
					$i++;
					$kitedPost = '{
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
					if(is_array($kittedDataArr->Item[0]->WarehouseQuantity)){
						$WarehouseQuantityarr = array();
						foreach($kittedDataArr->Item[0]->WarehouseQuantity as $kitqyt){
							$WarehouseQuantityarr[] = $WarehouseQuantity + $kitqyt->Quantity;
						}
						$WarehouseQuantity = implode('|',$WarehouseQuantityarr);
					} else if(is_object($kittedDataArr->Item[0]->WarehouseQuantity)){
						$WarehouseQuantity = $WarehouseQuantity + $kittedDataArr->Item[0]->WarehouseQuantity->Quantity;
					}
					$peritemData = array($item->SKU,$item->Name,$kittedData->ComponentSKU,$group,$WarehouseQuantity,$kittedData->MinimumQuantity,$kittedData->MaximumQuantity,$kittedDataArr->Item[0]->DefaultPrice);
					$itemDatsArrayExport[] = $peritemData;
				}
			} else if(is_object($item->KitComponents[0]->KitComponent)){
				//$kittedSKu = $item->KitComponents[0]->KitComponent->ComponentSKU;
				$i++;
				$kitedPost = '{
		  "Filter": {
		  	"SKU":"'.$item->KitComponents[0]->KitComponent->ComponentSKU.'",
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
					if(is_array($kittedDataArr->Item[0]->WarehouseQuantity)){
						$WarehouseQuantityarr = array();
						foreach($kittedDataArr->Item[0]->WarehouseQuantity as $kitqyt){
							$WarehouseQuantityarr[] = $WarehouseQuantity + $kitqyt->Quantity;
						}
						$WarehouseQuantity = implode('|',$WarehouseQuantityarr);
					} else if(is_object($kittedDataArr->Item[0]->WarehouseQuantity)){
						$WarehouseQuantity = $WarehouseQuantity + $kittedDataArr->Item[0]->WarehouseQuantity->Quantity;
					}
					$peritemData = array($item->SKU,$item->Name,$item->KitComponents[0]->KitComponent->ComponentSKU,$group,$WarehouseQuantity,$item->KitComponents[0]->KitComponent->MinimumQuantity,$item->KitComponents[0]->KitComponent->MaximumQuantity,$kittedDataArr->Item[0]->DefaultPrice);
					$itemDatsArrayExport[] = $peritemData;
			}
		} else {
		$i++;
		$WarehouseQuantity = 0;
		if(is_array($kittedDataArr->Item[0]->WarehouseQuantity)){
			$WarehouseQuantityarr = array();
			foreach($kittedDataArr->Item[0]->WarehouseQuantity as $kitqyt){
				$WarehouseQuantityarr[] = $WarehouseQuantity + $kitqyt->Quantity;
			}
			$WarehouseQuantity = implode('|',$WarehouseQuantityarr);
		} else if(is_object($kittedDataArr->Item[0]->WarehouseQuantity)){
			$WarehouseQuantity = $WarehouseQuantity + $kittedDataArr->Item[0]->WarehouseQuantity->Quantity;
		}
		$peritemData = array($item->SKU,$item->Name,'',$group,$WarehouseQuantity,$item->PriceGroups[0]->PriceGroup->MinimumQuantity,$item->PriceGroups[0]->PriceGroup->MaximumQuantity,$item->DefaultPrice);
		$itemDatsArrayExport[] = $peritemData;
		}
		}
		}
		if(!empty($itemDatsArrayExport)){
			foreach($itemDatsArrayExport as $ky => $itemDta){
				$i = $ky + 2;
				$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue('A'.$i, $itemDta[0])
						->setCellValue('B'.$i, $itemDta[1])
						->setCellValue('C'.$i, $itemDta[2])
						->setCellValue('D'.$i, $itemDta[3])
						->setCellValue('E'.$i, $itemDta[4])
						->setCellValue('F'.$i, $itemDta[5])
						->setCellValue('G'.$i, $itemDta[6])
						->setCellValue('H'.$i, $itemDta[7]);
			}
		}
		//echo '<pre>'; print_r($itemDatsArrayExport); die;
		$objPHPExcel->getActiveSheet()->setTitle('Dig Options');
		$objPHPExcel->setActiveSheetIndex(0);
		$filename = "NETO_".strtoupper($natosite)."_ITEMS.xlsx";
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');
		header('Cache-Control: max-age=1');
		// If you're serving to IE over SSL, then the following may be needed
		#header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		#header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		#header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		#header ('Pragma: public'); // HTTP/1.0
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');
		setcookie('fileDownloadTokenFile', 'Complete', time() + (2), "/");
		$msgBox = alertBox("Export successfully", "<i class='fa fa-ban'></i>", "success");
		$_SESSION['msg'] = $msgBox;
	}
?>