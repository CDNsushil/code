<?php 
/**
 * Reports_Rma extension
 * Report helper
 *
 * @category	Request
 * @package		Request_Rma
 * @author 		Tosif Qureshi
 */
class Request_Rma_Helper_Request extends Mage_Core_Helper_Abstract {
	
	/**
	 * check if breadcrumbs can be used
	 * @access public
	 * @return bool
	 * @author Tosif Qureshi
	 */
	public function getUseBreadcrumbs() {
		return Mage::getStoreConfigFlag('rma/request/breadcrumbs');
	}
	
	/**
	 * get the url to the rma list page
	 * @access public
	 * @return string
	 * @author Tosif Qureshi
	 */
	public function getRmaUrl() {
		return Mage::getUrl('rma/request/index');
	}
	
	/**
	 * get the url to the rma form page
	 * @access public
	 * @return string
	 * @author Tosif Qureshi
	 */
	public function getRmaFormUrl() {
		return Mage::getUrl('rma/request/rmaform');
	}
	
		/**
	 * get the status of rma 
	 * @access public
	 * @return status string
	 * @author Tosif Qureshi
	 */
	public function getRmaStatus($status='') {
		/* Set default rma status as pending */
		$rma_status = 'Pending';
		if ($status==1) :
			/* Set rma status as approved */
			$rma_status = 'Approved';
		elseif($status==2) :
			/* Set rma status as denied */
			$rma_status = 'Denied';
		endif;
		return $rma_status;
	}
	
	/**
	 * get the status of rma 
	 * @access public
	 * @return status string
	 * @author Tosif Qureshi
	 */
	public function getRmaType($type_id='') {
		$rma_type = Mage::getModel('rma/type')->load($type_id);
		return $rma_type->getType();
	}
	
	/**
	 * get date in date time formate 
	 * @access public
	 * @return date string
	 * @author Tosif Qureshi
	 */
	public function getDateFormate($created_at='') {
		/* Set day name from datetime */
		$day  = date('l', strtotime( $created_at));
		/* Set time from datetime */
		$time = date('h:ia', strtotime($created_at));
		/* Set time from datetime */
		$date = date('jS F Y',strtotime($created_at));
		return $time.' on '.$day.' '.$date;
	}
	
	/**
	 * get product data from order 
	 * @access public
	 * @return array of product data
	 * @author Tosif Qureshi
	 */
	 public function getProductItemData($order_id=0) {
		$order = Mage::getModel('sales/order')->load($order_id);
		#get all items
		$items = $order->getAllItems();

		$item_product_data = array();
		#loop for all order items
		foreach ($items as $itemId => $item) {
			$product_data = array();
			$product_data['product_name']  = $item->getName();
			$product_data['product_price'] = $item->getPrice();  
			$product_data['product_sku']   = $item->getSku();
			$product_data['product_id']    = $item->getProductId();
			$product_data['product_qty']   = $item->getQtyToInvoice();
			$item_product_data[] = $product_data;
		}
		return $item_product_data;
	 }
	 
	 /**
	 * get rma form type title
	 * @access public
	 * @return void
	 * @author Tosif Qureshi
	 */
	 public function setRmaTypeTitle($rma_type='') {
		$rma_type_title = 'Complaints - Defective / wrong item(s)';
		if($rma_type==2) {
			$rma_type_title = 'Request for return of item(s)';
		}
		Mage::register('rma_type_title', $rma_type_title);
		return $rma_type_title;
	 }
	 
	 /**
	 * get all order product data from order 
	 * @access public
	 * @return array of product data
	 * @author Tosif Qureshi
	 */
	 public function getOrderProductItemData($order_id=0) {
		$order = Mage::getModel('sales/order')->load($order_id);
		#get all items
		return  $order->getAllItems();
	 }
	 
	 /**
	 * get invoice number of order 
	 * @access public
	 * @return json of invoice
	 * @author Tosif Qureshi
	 */
	 public function getInvoiceNumbers($order_id=0) {
		 /* Load order model and get details */
		$order = Mage::getModel('sales/order')->load($order_id);
		$invIncrementIDs = array();
		if ($order->hasInvoices()) {
			foreach ($order->getInvoiceCollection() as $inv) {
				$invoice_data['id']   = $inv->getIncrementId();
				$invoice_data['name'] = $inv->getIncrementId();
				$invIncrementIDs[] = $invoice_data;
			//other invoice details...
			} Mage::log($invIncrementIDs);
		}
		// JSON-encode the response
		$json_invoice_response = json_encode($invIncrementIDs);
		return $json_invoice_response;
	}
	
	 /**
	 * get invoice number of order 
	 * @access public
	 * @return mix country data
	 * @author Tosif Qureshi
	 */
	 public function getCountryListing($order_id=0) {
		$_countries = Mage::getResourceModel('directory/country_collection')
										->loadData()
										->toOptionArray(false);
		return $_countries;
	}
	
	/**
	 * get the product name data
	 * @access public
	 * @return product name
	 * @author Tosif Qureshi
	 */
	public function getProductName($sku_number=''){
		
		/* Set rma product name by sku */
		$product = Mage::getModel('catalog/product')->loadByAttribute('sku',$sku_number); 
		return $product->getName();
	}
	
	 /**
	 * get product quantity of order
	 * @access public
	 * @input $product_id
	 * @return product quantity int
	 * @author Tosif Qureshi
	 */
 	public function getProductQuantity($product_id=0) {
		/* Get order id */
		$order_id = Mage::registry('order_id');
		/* Get order details by order id */
		$orderCollection = Mage::getModel('sales/order')->load($order_id);
		/* Get order mix collection data*/
		$data = $orderCollection->getItemsCollection();
		/* Get orders product array */
		$item_data = $orderCollection->getItemsCollection()->getData();
		/* Set default quantity of product */
		$product_qty = 1;
		for($i=0;$i<count($item_data);$i++) {
			if($item_data[$i]['product_id']==$product_id) {
				$product_qty = intval($item_data[$i]['qty_ordered']);
			}
		}
		return $product_qty;
	}
	
	/**
	 * get the increamented real order id
	 * @access public
	 * @input $rma_id
	 * @return id string
	 * @author Tosif Qureshi
	 */
	public function getRealOrderId($rma_id=0) {
		/* Load items model and get order id */
		$rma_item = Mage::getModel('rma/request')->load($rma_id);
		/* Load order model and get order incremented id */
		$order = Mage::getModel('sales/order')->load($rma_item->getOrder_id());
		return $this->__('#').$order->getIncrement_id();
	}
	
	
	public function getStatusLink($status,$link){
		$statusString = '';
		switch($status){
			  case 0:
					$approvedlink=$link.'1';
					$deniedlink=$link.'2';
					$statusString = '<a href="'.$approvedlink.'" onclick="return confirm(\'Are you really want to approve this??\')"><button class="scalable" type="button"><span><span><span>Accept</span></span></span></button></a> &nbsp; <a href="'.$deniedlink.'" onclick="return confirm(\'Are you really want to deny this??\')"><button class="scalable" type="button"><span><span><span>Deny</span></span></span></button></a>';
				break;
				
			  case 1:
					$statusString = 'Approved';
				break;
				
			  case 2:
					$statusString = 'Denied';
				break;
			  
		  }
		  return $statusString;
	}
	
	public function checkDateWithinYear($purchaceDate){
          $purchaceDate = strtotime($purchaceDate);
          $date = strtotime("-1 year");
          if($date < $purchaceDate){
			 $image = 'images/rule_component_apply.gif';
		  }else{
			  $image ='images/rule_component_remove.gif';
		  }
		  return $image; 
	}
	public function checkWarranty_period($purchaceDate,$warranty_period){
		  $warrantyDate = strtotime("+".$warranty_period." months", strtotime($purchaceDate));
          $date =time();
          if($date < $warrantyDate){
			 $image = 'images/rule_component_apply.gif';
		  }else{
			  $image ='images/rule_component_remove.gif';
		  }
		  return $image; 
	}
	
	function barcode($text = '')
	{
		$size = 20;
		$orientation = "horizontal";
		$code_type = "code128";
		
		$code_string = "";

		// Translate the $text into barcode the correct $code_type
		if ( strtolower($code_type) == "code128" ) {
			$chksum = 104;
			// Must not change order of array elements as the checksum depends on the array's key to validate final code
			$code_array = array(" "=>"212222","!"=>"222122","\""=>"222221","#"=>"121223","$"=>"121322","%"=>"131222","&"=>"122213","'"=>"122312","("=>"132212",")"=>"221213","*"=>"221312","+"=>"231212",","=>"112232","-"=>"122132","."=>"122231","/"=>"113222","0"=>"123122","1"=>"123221","2"=>"223211","3"=>"221132","4"=>"221231","5"=>"213212","6"=>"223112","7"=>"312131","8"=>"311222","9"=>"321122",":"=>"321221",";"=>"312212","<"=>"322112","="=>"322211",">"=>"212123","?"=>"212321","@"=>"232121","A"=>"111323","B"=>"131123","C"=>"131321","D"=>"112313","E"=>"132113","F"=>"132311","G"=>"211313","H"=>"231113","I"=>"231311","J"=>"112133","K"=>"112331","L"=>"132131","M"=>"113123","N"=>"113321","O"=>"133121","P"=>"313121","Q"=>"211331","R"=>"231131","S"=>"213113","T"=>"213311","U"=>"213131","V"=>"311123","W"=>"311321","X"=>"331121","Y"=>"312113","Z"=>"312311","["=>"332111","\\"=>"314111","]"=>"221411","^"=>"431111","_"=>"111224","\`"=>"111422","a"=>"121124","b"=>"121421","c"=>"141122","d"=>"141221","e"=>"112214","f"=>"112412","g"=>"122114","h"=>"122411","i"=>"142112","j"=>"142211","k"=>"241211","l"=>"221114","m"=>"413111","n"=>"241112","o"=>"134111","p"=>"111242","q"=>"121142","r"=>"121241","s"=>"114212","t"=>"124112","u"=>"124211","v"=>"411212","w"=>"421112","x"=>"421211","y"=>"212141","z"=>"214121","{"=>"412121","|"=>"111143","}"=>"111341","~"=>"131141","DEL"=>"114113","FNC 3"=>"114311","FNC 2"=>"411113","SHIFT"=>"411311","CODE C"=>"113141","FNC 4"=>"114131","CODE A"=>"311141","FNC 1"=>"411131","Start A"=>"211412","Start B"=>"211214","Start C"=>"211232","Stop"=>"2331112");
			$code_keys = array_keys($code_array);
			$code_values = array_flip($code_keys);
			for ( $X = 1; $X <= strlen($text); $X++ ) {
				$activeKey = substr( $text, ($X-1), 1);
				$code_string .= $code_array[$activeKey];
				$chksum=($chksum + ($code_values[$activeKey] * $X));
			}
			$code_string .= $code_array[$code_keys[($chksum - (intval($chksum / 103) * 103))]];

			$code_string = "211214" . $code_string . "2331112";
		} elseif ( strtolower($code_type) == "code39" ) {
			$code_array = array("0"=>"111221211","1"=>"211211112","2"=>"112211112","3"=>"212211111","4"=>"111221112","5"=>"211221111","6"=>"112221111","7"=>"111211212","8"=>"211211211","9"=>"112211211","A"=>"211112112","B"=>"112112112","C"=>"212112111","D"=>"111122112","E"=>"211122111","F"=>"112122111","G"=>"111112212","H"=>"211112211","I"=>"112112211","J"=>"111122211","K"=>"211111122","L"=>"112111122","M"=>"212111121","N"=>"111121122","O"=>"211121121","P"=>"112121121","Q"=>"111111222","R"=>"211111221","S"=>"112111221","T"=>"111121221","U"=>"221111112","V"=>"122111112","W"=>"222111111","X"=>"121121112","Y"=>"221121111","Z"=>"122121111","-"=>"121111212","."=>"221111211"," "=>"122111211","$"=>"121212111","/"=>"121211121","+"=>"121112121","%"=>"111212121","*"=>"121121211");

			// Convert to uppercase
			$upper_text = strtoupper($text);

			for ( $X = 1; $X<=strlen($upper_text); $X++ ) {
				$code_string .= $code_array[substr( $upper_text, ($X-1), 1)] . "1";
			}

			$code_string = "1211212111" . $code_string . "121121211";
		} elseif ( strtolower($code_type) == "code25" ) {
			$code_array1 = array("1","2","3","4","5","6","7","8","9","0");
			$code_array2 = array("3-1-1-1-3","1-3-1-1-3","3-3-1-1-1","1-1-3-1-3","3-1-3-1-1","1-3-3-1-1","1-1-1-3-3","3-1-1-3-1","1-3-1-3-1","1-1-3-3-1");

			for ( $X = 1; $X <= strlen($text); $X++ ) {
				for ( $Y = 0; $Y < count($code_array1); $Y++ ) {
					if ( substr($text, ($X-1), 1) == $code_array1[$Y] )
						$temp[$X] = $code_array2[$Y];
				}
			}

			for ( $X=1; $X<=strlen($text); $X+=2 ) {
				if ( isset($temp[$X]) && isset($temp[($X + 1)]) ) {
					$temp1 = explode( "-", $temp[$X] );
					$temp2 = explode( "-", $temp[($X + 1)] );
					for ( $Y = 0; $Y < count($temp1); $Y++ )
						$code_string .= $temp1[$Y] . $temp2[$Y];
				}
			}

			$code_string = "1111" . $code_string . "311";
		} elseif ( strtolower($code_type) == "codabar" ) {
			$code_array1 = array("1","2","3","4","5","6","7","8","9","0","-","$",":","/",".","+","A","B","C","D");
			$code_array2 = array("1111221","1112112","2211111","1121121","2111121","1211112","1211211","1221111","2112111","1111122","1112211","1122111","2111212","2121112","2121211","1121212","1122121","1212112","1112122","1112221");

			// Convert to uppercase
			$upper_text = strtoupper($text);

			for ( $X = 1; $X<=strlen($upper_text); $X++ ) {
				for ( $Y = 0; $Y<count($code_array1); $Y++ ) {
					if ( substr($upper_text, ($X-1), 1) == $code_array1[$Y] )
						$code_string .= $code_array2[$Y] . "1";
				}
			}
			$code_string = "11221211" . $code_string . "1122121";
		}

		// Pad the edges of the barcode
		$code_length = 20;
		for ( $i=1; $i <= strlen($code_string); $i++ )
			$code_length = $code_length + (integer)(substr($code_string,($i-1),1));

		if ( strtolower($orientation) == "horizontal" ) {
			$img_width = $code_length;
			$img_height = $size;
		} else {
			$img_width = $size;
			$img_height = $code_length;
		}

		$image = imagecreate($img_width, $img_height);
		$black = imagecolorallocate ($image, 0, 0, 0);
		$white = imagecolorallocate ($image, 255, 255, 255);

		imagefill( $image, 0, 0, $white );

		$location = 10;
		for ( $position = 1 ; $position <= strlen($code_string); $position++ ) {
			$cur_size = $location + ( substr($code_string, ($position-1), 1) );
			if ( strtolower($orientation) == "horizontal" )
				imagefilledrectangle( $image, $location, 0, $cur_size, $img_height, ($position % 2 == 0 ? $white : $black) );
			else
				imagefilledrectangle( $image, 0, $location, $img_width, $cur_size, ($position % 2 == 0 ? $white : $black) );
			$location = $cur_size;
		}
		//header ('Content-type: image/png');
		
		$root    = Mage::getBaseDir();
		$barcodeDir = $root.'/barcode/';
		
		if(!$barcodeDir){
			if (!mkdir($barcodeDir, 0777, true)) {
				die('Failed to create folders...');
			}
		}
		$barcodeImage=$barcodeDir.$text.'.png';
		imagepng($image, $barcodeImage);
		imagedestroy($image);
		return $barcodeImage;
		
	}	
}
