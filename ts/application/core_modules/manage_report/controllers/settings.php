<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class settings extends MX_Controller {
	private $data = array();
	private $userId = null;
	
	/** Constructor **/
	function __construct() {
			$load = array(
				'model' 	=> 'model_cart',
				'language' 	=> 'admin_template'				
			);
			parent::__construct($load);				
	}

 	
	
	function index()
	{
		$data = "";
		$this->toad_admin_template->load('toad_admin_template','manage_invoice', $data);
	}
	
	
	/*
	 ********************************** 
	 * This function is used to show all invoice list
	 **********************************
	 */  
	
	
	
	function manage_invoice($limit=0,$perPage=10){
		
		$countTotal=$this->model_cart->get_purchased_listing(0,0,true);
		$perPage=(!empty($perPage)) ? $perPage :$this->config->item('perPageAdminInvoice');
		$pages = new Pagination_ajax;
		$pages->items_total = $countTotal; // this is the COUNT(*) query that gets the total record count from the table you are querying
		
		// Add by Amit to set cookie for Results per page
		if($this->input->post('ipp')!=''){
			$isCookie = setPerPageCookie('manage_invoicePerPageVal',$perPage);	
		}else {
			$isCookie = getPerPageCookie('manage_invoicePerPageVal',$perPage);		
		}
					
		$pages->items_per_page=($this->input->post('ipp') > 0) ? $this->input->post('ipp'):$isCookie ;		
		
		$pages->paginate();
		$data['items_total'] = $pages->items_total;
		$data['items_per_page'] = $pages->items_per_page;
		$data['pagination_links'] = $pages->display_pages();	
		$data['countTotal'] = $countTotal;	
		
		
		$getPurchaseDetails = $this->model_cart->get_purchased_listing($pages->offst,$pages->items_per_page);
		
		$data['purchaseDetails'] = $getPurchaseDetails;
		
		$ajaxRequest = $this->input->post('ajaxRequest');
		if($ajaxRequest)
		{   
			$this->load->view('invoice_listing_view',$data) ;				
		}else{
			$this->toad_admin_template->load('toad_admin_template','invoice_listing', $data);
		}
	}
	
	
	/*
	 ***********************************************
	 * This function is used to export all invoice into cvs file 
	 ***********************************************  
	 */ 

	function invoiceExport()
	{
		$this->load->helper('csv');
		$this->load->helper('inflector');
		$userId=$this->isloginUser();
		
		$getPurchaseDetails=$this->model_cart->export_invoice_details();
		$RowArray="";
		$count=0;
		foreach($getPurchaseDetails['get_first_row']  as $rowOfHeader)
		{
			$RowArray[0][$count] =  humanize($rowOfHeader); 
			$count++;
		}
		$RowArray[0][10] =  humanize('seller'); 
		// This code for  listing of record
		if($getPurchaseDetails['get_num_rows'] > 0)
		{
			$serialNumber=1;	
			$count=1;
			foreach($getPurchaseDetails['get_result']  as $resultPurchase)
			{
				$RowArray[$count][0] = date("d-F-Y",strtotime($resultPurchase['date']));
				$RowArray[$count][1] = getInvoiceId($resultPurchase['invoice'],1);
				$RowArray[$count][2] = $resultPurchase['paypalEmail'];
				$RowArray[$count][3] = $resultPurchase['buyer'];
				$RowArray[$count][4] = $resultPurchase['title'];
				$RowArray[$count][5] = bytestoMB($resultPurchase['size'] + getItemSize($resultPurchase['memItemId'])).' MB';
				$RowArray[$count][6] = ($resultPurchase['type']=="1")?"Tool":"Space";
				$RowArray[$count][7] = $resultPurchase['totalPrice'];
				$RowArray[$count][8] = $resultPurchase['taxPercent'];
				$RowArray[$count][9] = $resultPurchase['taxValue'];
				$RowArray[$count][10] = 'Toadsquare';
				$count++;
			}
		}
		
		$filename="invoice_reports_".date("d_M_Y").".csv";
		array_to_csv($RowArray, $filename);
	}
	

	/*
	 ************************************************ 
	 * This function is used to show all sales record
	 ************************************************
	 */ 


	
	function sales_record($limit='',$perPage='')
 	{
		$countTotalArray=$this->model_cart->get_sales_details(0,0);
		$perPage=(!empty($perPage)) ? $perPage :$this->config->item('perPageAdminSalesRecord');
		$pages = new Pagination_ajax;
		$countTotal = $countTotalArray['get_num_rows'];
		$pages->items_total = $countTotal; // this is the COUNT(*) query that gets the total record count from the table you are querying
		
		// Add by Amit to set cookie for Results per page
		if($this->input->post('ipp')!=''){
			$isCookie = setPerPageCookie('sales_recordPerPageVal',$perPage);	
		}else {
			$isCookie = getPerPageCookie('sales_recordPerPageVal',$perPage);		
		}
					
		$pages->items_per_page=($this->input->post('ipp') > 0) ? $this->input->post('ipp'):$isCookie ;		
		
		$pages->paginate();
		$data['items_total'] = $pages->items_total;
		$data['items_per_page'] = $pages->items_per_page;
		$data['pagination_links'] = $pages->display_pages();	
		$data['countTotal'] = $countTotal;	
		
		$getPurchaseDetails = $this->model_cart->get_sales_details($pages->offst,$pages->items_per_page);
		
		/*echo "<pre>";
		print_r($getPurchaseDetails);die;
		*/
		$data['purchaseDetails'] = $getPurchaseDetails['get_result'];
		
		$ajaxRequest = $this->input->post('ajaxRequest');
		if($ajaxRequest)
		{   
			$this->load->view('purchases_listing_view',$data) ;				
		}else{
			$this->toad_admin_template->load('toad_admin_template','purchases_listing', $data);
		}
	}	
	
	
	
	/*
	 ***********************************************
	 * This function is used to export sales record into cvs file 
	 ***********************************************  
	 */ 

		function sales_record_export()
		{
			$this->load->helper('csv');
			$this->load->helper('inflector');
			$getPurchaseDetails=$this->model_cart->salesDetailsForExport();
			$RowArray="";
			$count=0;
			foreach($getPurchaseDetails['get_first_row']  as $rowOfHeader)
			{
				$RowArray[0][$count] =  humanize($rowOfHeader); 
				$count++;
			}
			$RowArray[0][$count] =  humanize("Total"); 
			// This code for  listing of record
			if($getPurchaseDetails['get_num_rows'] > 0)
			{
				$serialNumber=1;	
				$count=1;
				foreach($getPurchaseDetails['get_result']  as $resultPurchase)
				{
					$itemPrice = ($resultPurchase['price']*$resultPurchase['qty']);
					$totalAmount= $itemPrice + $resultPurchase['tsCommissionValue'];
					$currencySign = ($resultPurchase['currency']==1)?"Dollar":"Euro";
					$sellerInfo = json_decode($resultPurchase['seller']);
					$RowArray[$count][0] = date("d-F-Y",strtotime($resultPurchase['date']));
					$RowArray[$count][1] = getInvoiceId($resultPurchase['invoice']);
					$RowArray[$count][2] = ucwords($resultPurchase['buyer']);
					$RowArray[$count][3] = (isset($sellerInfo->firstName))?ucwords($sellerInfo->firstName.' '.$sellerInfo->lastName):"";
					$RowArray[$count][4] = $resultPurchase['item'];
					$RowArray[$count][5] = $resultPurchase['qty'];
					$RowArray[$count][6] = $currencySign;
					$RowArray[$count][7] = $resultPurchase['price'];
					$RowArray[$count][8] = $resultPurchase['taxName'];
					$RowArray[$count][9] = $resultPurchase['taxPercent'];
					$RowArray[$count][10] = $resultPurchase['taxValue'];
					$RowArray[$count][11] = $resultPurchase['shipping'];
					$RowArray[$count][12] = $resultPurchase['tsCommissionPercent'];
					$RowArray[$count][13] = $resultPurchase['tsCommissionValue'];
					$RowArray[$count][14] = $resultPurchase['tsVatPercent'];
					$RowArray[$count][15] = $resultPurchase['tsVatValue'];
					$RowArray[$count][16] = $resultPurchase['tsGrossCommision'];
					$RowArray[$count][17] = getPurchaseType($resultPurchase['purchaseType']);
					$RowArray[$count][18] = $totalAmount;
					$count++;
				}
			}
			
			$filename="sales_record_".date("d_M_Y").".csv";
			array_to_csv($RowArray, $filename);
		}	
	

} 
