<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Users Controller
 * Display the user list and manage the user deletions/banning/purge
 */
class Settings extends MX_Controller
{

	/**
	 * Setup the required permissions
	 *
	 * @return void
	 */
	public function __construct()
    {
		parent::__construct();
		$this->load->language('admin_template'); //you can delete it if you have translation for you language
	
		$this->load->model(array('model_manage_users'));
		$this->head->add_css($this->config->item('default_css').'template.css');
		$this->head->add_css($this->config->item('system_css').'frontend.css');
	}//end __construct()

	//--------------------------------------------------------------------

	/*
	 *
	 * @access public
	 *
	 * @return  void
	 */
	public function index()
	{
		$this->manage_users();
	}//end index()
	
	public function manage_users()
	{		
		
		$data['users'] = $this->model_manage_users->get_users();
		$this->toad_admin_template->load('toad_admin_template','users/manage_user_list',$data);
		
	}//end manage_users()

	
	/*
	 ***********************************************
	 * This function is used to all export sales for Admin
	 ***********************************************  
	 */ 

		function AllSalesExportToCSV()
		{
			$this->load->helper('csv');
			$this->load->helper('inflector');
			$userId=$this->isloginUser();
			$getPurchaseDetails=$this->model_manage_users->AllSalesDetailsForExport();
			
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
					$sellerInfo= json_decode($resultPurchase['sellername']);
					if(isset($sellerInfo) && $sellerInfo!="") { $sellerName = $sellerInfo->firstName.' '.$sellerInfo->lastName; }else { $sellerName ==""; }
					$itemPrice = ($resultPurchase['price']*$resultPurchase['qty']);
					$totalAmount= $itemPrice + $resultPurchase['tsCommissionValue'];
					$currencySign = ($resultPurchase['currency']==1)?"Dollar":"Euro";
					$RowArray[$count][0] = date("d-F-Y",strtotime($resultPurchase['date']));
					$RowArray[$count][1] = getInvoiceId($resultPurchase['invoice']);
					$RowArray[$count][2] = ucwords($resultPurchase['buyer']);
					$RowArray[$count][3] = $resultPurchase['item'];
					$RowArray[$count][4] = $resultPurchase['qty'];
					$RowArray[$count][5] = ucwords($sellerName);
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
			
			$filename="sales_".date("d_M_Y").".csv";
			array_to_csv($RowArray, $filename);
		}
		
		
		
		/*
		 ***********************************************
		 * This function is used to export all membership for admin
		 ***********************************************  
		 */ 

		function AllMembershipExportToCSV()
		{
			$this->load->helper('csv');
			$this->load->helper('inflector');
			$userId=$this->isloginUser();
			
			$getPurchaseDetails=$this->model_manage_users->all_export_purchased_details();
			
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
					$RowArray[$count][1] = $resultPurchase['invoice'];
					$RowArray[$count][2] = $resultPurchase['customername'];
					$RowArray[$count][3] = $resultPurchase['paypalEmail'];
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
			
			$filename="purchase_".date("d_M_Y").".csv";
			array_to_csv($RowArray, $filename);
		}
		
		
		/*
		 ************************************
		 * This function is used to export all sales and membership  
		 ************************************ 
		 */ 
		
		
		function adminExport(){
		
			echo '<a href="'.base_url('admin/settings/users/AllSalesExportToCSV').'">All Sales Export</a>';
			echo '<br><br><a href="'.base_url('admin/settings/users/AllMembershipExportToCSV').'">All Membership Export</a>';
		
		}
	


}//end Settings

// End of Admin User Controller
/* End of file settings.php */
/* Location: ./application/core_modules/controllers/settings.php */
