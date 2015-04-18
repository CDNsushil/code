<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
	 Description:
	 * The controller class "messagecenter" is meant to handle the processing of "Work Profile" section
	 * It include functionality to fetch/add/edit work address,sicaol media links,employment history,etc
	 *
	 * @package	Toadsquare
	 * @subpackage	Module
	 * @category	Controller
	 * Author Name: Gurutva Singh
	 * Date Created: 7 Februray 2012
	 * Date Modified: 27 Februray 2012
*/

class messagecenter extends MX_Controller {
	private $data = array();
	private $mediaPath = '';
	private $userId = null;

	private $userContactsTable = 'UserContacts';

	function __construct(){
		$load = array(
				'model'		=> 'model_message_center',
				'library' 	=> 'form_validation + upload + session + head + lib_message_center + csvreader + inviter + Pagination_new_ajax',	 	
				'language' 	=> 'message_center + tmail',
				'helper' 	=> 'form + file + common'				
			);
		parent::__construct($load);	
		$this->head->add_css($this->config->item('system_css').'tmail.css');
		$this->userId=$this->isLoginUser();
		$this->mediaPath = "media/".LoginUserDetails('username')."/messagecenter/" ;		
	}

    public function index() {
        $this->contacts();
    }
	/*public function index() {
		
		if($this->input->post('go')=='Save'){
			
			$mediaPath = $this->mediaPath;
			if(!is_dir($mediaPath)){
				mkdir($mediaPath, 0777, true);
			}

			$config['upload_path'] =  $this->mediaPath;
			$config['allowed_types'] = 'csv|tsv';
			$config['max_size']  = '1024';
			$replace = '"';
			$with = ' ';

			$this->upload->initialize($config);
			$this->upload->set_upload_path($mediaPath);
			$this->load->library('upload', $config);
			if (!$this->upload->do_upload()){
					$data['error'] = array('error' => $this->upload->display_errors());
			}else{
				$data = array('upload_data' => $this->upload->data());
				$userfile = $data['upload_data']['file_name'];
			}

			$this->load->library('csvreader');
			$filePath1 = $this->mediaPath;
			$filePath2 = $data['upload_data']['file_name'];
			$filePath = $filePath1 . $filePath2;
			$data['csvData'] = $this->csvreader->parse_file($filePath);
			//$createProperCsv = $this->lib_message_center->createProperCsv($data['csvData']);
			$table = 'UserContacts';

			foreach($data['csvData'] as $cd){
			$results_array = array(
			   'tdsUid' => $this->userId,
			   'firstName' => str_replace($replace, $with, $cd['firstName']),
			   'lastName' => str_replace($replace, $with, $cd['lastName']),
			   'emailId' => str_replace($replace, $with, $cd['emailId'])
               );
               
               $checkForEmail = $this->lib_message_center->checkForEmail($cd['emailId'],$this->userId);
				if($checkForEmail > 0){

				}else
				{
					 $id = $this->model_common->addDataIntoTabel($table, $results_array);
				}
              }
            $msg = 'Contact Saved Successfully';
			set_global_messages($msg, 'success');
			redirect('messagecenter/contacts');
		}
		
		$val1 = $this->input->post('val1');

		if($val1['save'] == "Save"){

			$dataSetValue = $this->lib_message_center->setValues($val1);
			
			$data= $this->lib_message_center->getValues();
			
			$emailId = $val1['emailId'];
			
			$checkForUserContactEmail = $this->lib_message_center->checkForUserContactEmail($emailId);
			if(count($checkForUserContactEmail) > 0)
			{
				$data['UserContactId'] = $checkForUserContactEmail['0']->tdsUid;
				//$data['toadsquareUrl'] = "en/showcase/index/".$checkForUserContactEmail['0']->tdsUid;
			}
			else
			{
				$data['UserContactId'] = "0";				
				//$data['toadsquareUrl'] = "";
			}
			
			$data['tdsUid']=$this->userId;
			unset($data['toadUid']);
			unset($data['imagePath']);

			if($val1['contId']==""){
				$emailId = $val1['emailId'];
				$checkForEmail = $this->lib_message_center->checkForEmail($emailId,$this->userId);
				
				if($checkForEmail > 0){
				}else
				{
					unset($data['contId']);
					$this->lib_message_center->save($data);
				}
			}else
			{
                unset($data['contId']);
				$this->lib_message_center->save($data);
			}
			echo $msg = 'Contact Saved Successfully';
			//set_global_messages($msg, 'success');
			//redirect('messagecenter/contacts');
		}

		$userId= $this->userId;
		if($this->uri->segment(4)=="")
		{
			$sort = "";
			$data = $this->lib_message_center->getValuesFromDB($userId,$sort);
			$this->lib_message_center->keys['contactList'] = $data;
			
			$this->lib_message_center->keys['label'] = $this->lang->language;	

			$this->data['tmailContent'] = $this->load->view('contactPanel',$this->lib_message_center->keys,true);
			$this->data['tmailHeading'] = "";
			$this->data['label'] = $this->lang->language;
			$this->data['tdsUid'] = $this->userId;
			//$this->template->load('template','tmail/template_tmail',$this->data);	
			//$this->template->load('template','messagecenter/contactPanel',$this->lib_message_center->keys);
			
			$leftData=array(
							'welcomelink'=>base_url(lang().'/dashboard'),
							'isDashButton'=>true
				  );
			$leftView='dashboard/help_tmail';
			$this->lib_message_center->keys['leftContent']=$this->load->view($leftView,$leftData,true);
			
			$this->template->load('backend_template','messagecenter/contactPanel',$this->lib_message_center->keys);
		}
		else
		{
			$sort = $this->uri->segment(4);
			$data = $this->lib_message_center->getValuesFromDB($userId,$sort);
			$this->lib_message_center->keys['contactList'] = $data;
			$this->lib_message_center->keys['label'] = $this->lang->language;	

			$this->data['tmailContent'] = $this->load->view('contactPanel',$this->lib_message_center->keys,true);
			$this->data['tmailHeading'] = "";
			$this->data['label'] = $this->lang->language;
			$this->data['tdsUid'] = $this->userId;
			//$this->template->load('template','tmail/template_tmail',$this->data);	
			//$this->template->load('template','messagecenter/contactPanel',$this->lib_message_center->keys);
			
			$leftData=array(
							'welcomelink'=>base_url(lang().'/dashboard'),
							'isDashButton'=>true
				  );
			$leftView='dashboard/help_tmail';
			$this->lib_message_center->keys['leftContent']=$this->load->view($leftView,$leftData,true);
			
			$this->template->load('backend_template','messagecenter/contactPanel',$this->lib_message_center->keys);
		}
	}*/

function sortedContacts()
{
	$letter = $this->input->post('letter');
	$userId= $this->userId;
	
	$sort = $letter;
	$data = $this->lib_message_center->getValuesFromDB($userId,$sort);
	$this->lib_message_center->keys['contactList'] = $data;
	$this->lib_message_center->keys['label'] = $this->lang->language;	
	$this->data['tmailContent'] = $this->load->view('contactPanel',$this->lib_message_center->keys,true);
	$this->data['tmailHeading'] = "";
	$this->data['label'] = $this->lang->language;
	$this->data['tdsUid'] = $this->userId;
	//print_r($this->lib_message_center->keys['contactList']);
	
	$this->load->view('messagecenter/sortedData',$this->lib_message_center->keys['contactList']);
}


function getUserContactDetail_forsearch($filter)
	{
		
		@$filter_data	= explode(",",$filter);
		
		@$contId = $filter_data['0'];
		@$max_id_filter =  $filter_data['1']; 
	    @$min_id_filter =  $filter_data['2'];
	    @$letter_search      =    $filter_data['3'];
	     
		$data['data'] = $this->lib_message_center->getUserValuesFromDB($contId);	
	    $data['data']['max_filter'] = $max_id_filter;
	    $data['data']['min_filter'] = $min_id_filter;
		$data['data']['letter_search'] = $letter_search;
	    $data['filter'] = $filter;
		$this->load->view('sortedDataList',$data);
	}




function check_already_exist_email()
{
	$emailId = $this->input->post('emailId');
	$userId= $this->userId;
	
	$checkForEmail = $this->lib_message_center->checkForEmail($emailId,$userId);
				/*if($checkForEmail > 0)
				{
					echo "exists";
				}
				else
				{
					 echo "not_exists";
				}*/
		echo $checkForEmail;				
}

	function contactEntryForm()
	{
		$this->load->view('contactEntryForm');
	}
	function contactList()
	{
		$this->load->view('contactList');
	}
	function contactImportForm()
	{
		$this->load->view('contactImport');
	}
	
	
	function contactTemplate()
	{
		//$this->template->load('template','contactTemplate');
		$leftData=array(
						'welcomelink'=>base_url(lang().'/dashboard'),
						'isDashButton'=>true
			  );
		$leftView='dashboard/help_tmail';
		$data['leftContent']=$this->load->view($leftView,$leftData,true);
		
		$this->template->load('backend_template','contactTemplate',$data);
	}

    //----------------------------------------------------------------------
    
    /*
    *  @access: public
    *  @description: This method is use to show contact list
    *  @auther: lokendra meena
    *  @return: void
    */ 
    
	function contacts()
	{
        
        //load css and js
        $this->_pluploadjsandcss();
        
		//$this->template->load('template','contactTemplate');
		if($this->input->post('go')){

			$mediaPath = $this->mediaPath;
			if(!is_dir($mediaPath)){
				mkdir($mediaPath, 0777, true);
			}

			$config['upload_path'] =  $this->mediaPath;
			$config['allowed_types'] = 'csv|tsv';
			$config['max_size']  = '1024';
			$replace = '"';
			$with = ' ';

			$this->upload->initialize($config);
			$this->upload->set_upload_path($mediaPath);
			$this->load->library('upload', $config);
			if (!$this->upload->do_upload()){
					$data['error'] = array('error' => $this->upload->display_errors());
			}else{
				$data = array('upload_data' => $this->upload->data());
				$userfile = $data['upload_data']['file_name'];
			}

			$this->load->library('csvreader');
			$filePath1 = $this->mediaPath;
			$filePath2 = $data['upload_data']['file_name'];
			$filePath = $filePath1 . $filePath2;
			$file = fopen($filePath,'r');
			$i=0;
			$table = 'UserContacts';
			
			while ($cd = fgetcsv($file))
			{
				$csv_data = explode(",",$cd[0]);
				//print_r($cd);
				if(!empty($cd)){
					$rs_array = array('tdsUid' => $this->userId,'firstName'=>$cd[0],'lastName'=>$cd[1],'profession'=>$cd[2],'company'=>$cd[3],'emailId'=>$cd[4],'phone'=>$cd[5],'address'=>$cd[6]);
				
					$checkForEmail = $this->lib_message_center->checkForEmail($cd[4],$this->userId);
					 
						if($checkForEmail > 0)
						{

						}
						else
						{
							 $id = $this->model_common->addDataIntoTabel($table, $rs_array);
						}
										
				}  
			$i++;       
			}
			//die;  
            $msg = 'Contact Saved Successfully';
			set_global_messages($msg, 'success');
			redirect('messagecenter/contacts');
			fclose($file);
        }

		/*if($this->input->post('save')=='Save'){
			
			$dataSetValue = $this->lib_message_center->setValues($this->input->post());
			$data= $this->lib_message_center->getValues();
			
			$data['tdsUid']=$this->userId;
			unset($data['toadUid']);
			unset($data['imagePath']);

			if($this->input->post('contId')==''){
				$emailId = $this->input->post('emailId');
				$checkForEmail = $this->lib_message_center->checkForEmail($emailId,$this->userId);
				if($checkForEmail > 0){
				}else
				{
					unset($data['contId']);
					$this->lib_message_center->save($data);
				}
			}else
			{
				$this->lib_message_center->save($data);
			}
			$msg = 'Contact Saved Successfully';
			set_global_messages($msg, 'success');
			redirect('messagecenter/contacts');
		}*/
        
        

		$userId= $this->userId;
		
		$sort = $this->input->post('letter');
		$searchContacts=$this->lang->line('searchContacts');
		$sort = (strlen($sort)>0)?$sort:"";
		if($searchContacts==$sort){
				$sort = '';
		}
	
		/* get contact listing*/
		if($sort == "" || $sort == "#"){
			$getContactData     =  $this->model_message_center->getContactList($userId,0,0);
            $contactDataCount   =  count($getContactData);
		}else{
			$getContactData     = $this->model_message_center->getSortedContactList($userId,$sort,0,0);
            $contactDataCount   =  count($getContactData);
		}
        
        //Paginaation functionality
        $pages                           =  new Pagination_new_ajax;
        $pages->items_total              =  $contactDataCount; // this is the COUNT(*) query that gets the total record count from the table you are querying
        $this->lib_message_center->keys['perPageRecord']           = $this->config->item('perPageRecord');
        
        
         // Add by Amit to set cookie for Results per page
        if($this->input->post('ipp')!=''){
            $isCookie = setPerPageCookie('ContactPerPageVal',$this->data['perPageRecord']);	
        }else {
            $isCookie = getPerPageCookie('ContactPerPageVal',$this->data['perPageRecord']);		
        }
    
        $pages->items_per_page=($this->input->post('ipp') > 0) ? $this->input->post('ipp'):$isCookie ;
        $pages->paginate();
        $this->lib_message_center->keys['items_total']        =  $pages->items_total;
        $this->lib_message_center->keys['items_per_page']     =  $pages->items_per_page;
        $this->lib_message_center->keys['pagination_links']   =  $pages->display_pages();
        
        
        /* get contact listing*/
		if($sort == "" || $sort == "#"){
			$contactData     =  $this->model_message_center->getContactList($userId,$pages->offst,$pages->limit);
     	}else{
			$contactData     = $this->model_message_center->getSortedContactList($userId,$sort,$pages->offst,$pages->limit);
     	}
        
        
	
		$this->lib_message_center->keys['contactDataCount']  =  $contactDataCount;
		$this->lib_message_center->keys['contactList']       =  $contactData;
		$this->lib_message_center->keys['label']             =  $this->lang->language;	
	
    
    	$this->data['tmailContent'] = $this->load->view('contactPanel',$this->lib_message_center->keys,true);
		$this->data['tmailHeading'] = "";
		$this->data['label'] = $this->lang->language;
		$this->data['tdsUid'] = $this->userId;
		//$this->template->load('template','tmail/template_tmail',$this->data);	
		$ajaxHit=$this->input->post('ajaxHit');
        $ajaxRequest=$this->input->post('ajaxRequest');
		if($ajaxHit==1|| $ajaxRequest==1){
			$this->load->view('messagecenter/searchedData',$this->lib_message_center->keys);
		}else{
			//$this->template->load('template','messagecenter/contactPanel',$this->lib_message_center->keys);
			$leftData=array(
							'welcomelink'=>base_url(lang().'/dashboard'),
							'isDashButton'=>true
				  );
			$leftView='dashboard/help_tmail';
			$this->lib_message_center->keys['leftContent']=$this->load->view($leftView,$leftData,true);
			
            
            
			$this->new_version->load('new_version','messagecenter/contactPanel',$this->lib_message_center->keys);
		}
	}
    
    //--------------------------------------------------------------------
    
    function saveusercontact(){
        
        $val1 = $this->input->post('val1');

        if($val1['save'] == "Save"){

            $dataSetValue = $this->lib_message_center->setValues($val1);
            
            $data= $this->lib_message_center->getValues();
            
            $emailId = $val1['emailId'];
            
            $checkForUserContactEmail = $this->lib_message_center->checkForUserContactEmail($emailId);
            if(count($checkForUserContactEmail) > 0)
            {
                $data['UserContactId'] = $checkForUserContactEmail['0']->tdsUid;
                //$data['toadsquareUrl'] = "en/showcase/index/".$checkForUserContactEmail['0']->tdsUid;
            }
            else
            {
                $data['UserContactId'] = "0";				
                //$data['toadsquareUrl'] = "";
            }
            
            $data['tdsUid']=$this->userId;
            unset($data['toadUid']);
            unset($data['imagePath']);
            
            if($val1['contId']=="0" || $val1['contId']==""){
                $emailId = $val1['emailId'];
                $checkForEmail = $this->lib_message_center->checkForEmail($emailId,$this->userId);
                
                if($checkForEmail > 0){
                }else
                {
                    unset($data['contId']);
                    $this->lib_message_center->save($data);
                }
            }else
            {
                $this->lib_message_center->save($data);
            }
            echo $msg = 'Contact Saved Successfully';
            //set_global_messages($msg, 'success');
            //redirect('messagecenter/contacts');
        }
    }
    
    
	
	function searchedContacts()
	{
		$letter = $this->input->post('letter');
		$userId= $this->userId;
		$search = $letter;
		$data = $this->lib_message_center->getSearchedValuesFromDB($userId,$search);
		$this->lib_message_center->keys['contactList'] = $data;
		$this->lib_message_center->keys['label'] = $this->lang->language;	
		
		$this->data['tmailContent'] = $this->load->view('contactPanel',$this->lib_message_center->keys,true);
		$this->data['tmailHeading'] = "";
		$this->data['label'] = $this->lang->language;
		$this->data['tdsUid'] = $this->userId;
		//print_r($this->lib_message_center->keys['contactList']);die;
		$this->load->view('messagecenter/searchedData',$this->lib_message_center->keys['contactList']);
	}

	
	function getUserContactDetail($contId)
	{
		$data['data'] = $this->lib_message_center->getUserValuesFromDB($contId);	
		$this->load->view('user_detail', $data);
	}
	
	function getnextUserContactDetail($contId)
	{
		$data['data'] = $this->lib_message_center->getnextUserValuesFromDB($contId);	
		$this->load->view('user_detail', $data);
	}
	
	function getpreviousUserContactDetail($contId)
	{
		$data['data'] = $this->lib_message_center->getpreviousUserValuesFromDB($contId);	
		$this->load->view('user_detail', $data);
	}
	
	function openinviter()
    {
    ini_set('display_errors',1);
    error_reporting(E_ALL);    
    $this->load->library('Inviter');    
    //$inviter->getPlugins();
    $plugin = $this->input->post('accountType');
    $username = $this->input->post('username');
    $password = $this->input->post('password');
    if(empty($username) || empty($password))
        {
			$msg = 'Fill UserName Password First.';
			set_global_messages($msg, 'error');
			redirect('messagecenter/contacts');
        }
    else
        {
			
			$users = $this->inviter->grab_contacts($plugin,$username,$password)   ;
			if($users=='ERROR on login.'){
				$message= "ERROR on login.";
				//$this->session->set_flashdata('error',$message);
				set_global_messages($message, 'error');
				redirect('messagecenter/contacts');
			}
			foreach($users as $k=>$val)
			{
				$table = 'UserContacts';
				$results_array = array(
				   'tdsUid' => $this->userId,
				   'firstName' => $val,
				   'emailId' => $k
				   );
				$checkForEmail = $this->lib_message_center->checkForEmail($k,$this->userId);
				//echo $checkForEmail ;
				if($checkForEmail > 0){

				}else
				{
					$id = $this->model_common->addDataIntoTabel($table, $results_array);
				}
			}
			$msg = 'Contact Saved Successfully';
			set_global_messages($msg, 'success');
			redirect('messagecenter/contacts');
        }   
    }

    function deleteContact($id)
    {
		$contId = $id;
		$this->model_message_center->deleteDataFromTabel($contId);
		$msg = 'Contact Deleted Successfully';
		//set_global_messages($msg, 'success');
		echo $msg;
		//redirect('messagecenter');
	}
	
	function download()
	{
		$this->load->view('messagecenter/download');	
	}
	
	function notifications()
	{
		
		$breadcrumbItem=array('messagecenter','notifications');
		$breadcrumbURL=array('tmail','messagecenter/notifications');
		$breadcrumbString=set_breadcrumb($delimiter_config = '', $exclude = '',$breadcrumbItem,$breadcrumbURL);
		$data['breadcrumbString']=$breadcrumbString;
		//$this->template->load("template",'notifications',$data);
		$leftData=array(
						'welcomelink'=>base_url(lang().'/dashboard'),
						'isDashButton'=>true
			  );
		$leftView='dashboard/help_tmail';
		$data['leftContent']=$this->load->view($leftView,$leftData,true);
		
		$this->template->load('backend_template','notifications',$data);
	}
    
    //------------------------------------------------------------------------
    
    /*
    *  @access: public
    *  @description: This method is use to add/edit contact form
    *  @auther: lokendra meena
    *  @return: void
    */ 
    
    public function addeditcontact(){
        
        $ajaxHit = $this->input->get('ajaxHit');
        if($ajaxHit){
            $data = $this->input->get('val1');
            $data['tdsUid'] =  $this->userId;
            $this->load->view('contactEntryForm',$data);
        }
    }
    
    
    //-----------------------------------------------------------------------
    
    /*
    *  @access: public
    *  @description: This method is use to upload csv 
    *  @auther: lokendra meena
    *  @return: void
    */ 
    
    public function contactUploadForm()
    {
        $this->load->view('contactImportCsv');
    }
    
    
    //------------------------------------------------------------------------
    
    /*
    * @access: public
    * @description: This method is use to upload csv contact file
    * @auther: lokendra meena
    * @retun: void
    */
     
    public function uploadpostcsv(){
        
        $mediaPath = $this->mediaPath;
        if(!is_dir($mediaPath)){
            mkdir($mediaPath, 0777, true);
        }

        $config['upload_path'] =  $this->mediaPath;
        $config['allowed_types'] = 'csv|tsv';
        $config['max_size']  = '1024';
        $replace = '"';
        $with = ' ';

        $this->upload->initialize($config);
        $this->upload->set_upload_path($mediaPath);
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload()){
                $data['error'] = array('error' => $this->upload->display_errors());
        }else{
            $data = array('upload_data' => $this->upload->data());
            $userfile = $data['upload_data']['file_name'];
        }

        $this->load->library('csvreader');
        $filePath1 = $this->mediaPath;
        $filePath2 = $data['upload_data']['file_name'];
        $filePath = $filePath1 . $filePath2;
        $file = fopen($filePath,'r');
        $i=0;
        $table = 'UserContacts';

        while ($cd = fgetcsv($file))
        {
            $csv_data = explode(",",$cd[0]);
            //print_r($cd);
            if(!empty($cd)){
                
                if(checkEmailId($cd[4])){
                    $rs_array = array('tdsUid' => $this->userId,'firstName'=>$cd[0],'lastName'=>$cd[1],'profession'=>$cd[2],'company'=>$cd[3],'emailId'=>$cd[4],'phone'=>$cd[5],'address'=>$cd[6]);
                    $checkForEmail = $this->lib_message_center->checkForEmail($cd[4],$this->userId);
                        if($checkForEmail > 0)
                        {
                        }
                        else
                        {
                             $id = $this->model_common->addDataIntoTabel($table, $rs_array);
                        }
                    }                   
            }  
        $i++;       
        }
        
        //remove file 
        unlink($filePath);
        
        $msg = 'Contact Saved Successfully';
        set_global_messages($msg, 'success');
        redirect('messagecenter/contacts');
        fclose($file);
        
    } 
    
    //------------------------------------------------------------------------
    
    /*
    * @Description: This method is used to added plupload require js and css
    * @access: private
    * @return: void
    * @author: lokendra
    */
    
    private function _pluploadjsandcss(){
        $this->head->add_css($this->config->item('system_css').'upload_file.css');
        $this->head->add_js($this->config->item('system_js').'jquery-upload/plupload.js',NULL,'lastAdd');
        $this->head->add_js($this->config->item('system_js').'jquery-upload/plupload.html5.js',NULL,'lastAdd');
        $this->head->add_js($this->config->item('system_js').'jquery-upload/plupload.flash.js',NULL,'lastAdd'); 
    }
    
    
   
    
    
    
}//End Class
?>
