<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tmail extends MX_Controller
{
	public $_userid="";
	
	function __construct()
	{
		$load = array(	//load messagecenter library and module for getting user profile image through common helper
			'model'		=> 'tmail/model_tmail + messagecenter/model_message_center',
			'library' 	=> 'tmail/Tmail_messaging + form_validation + upload + messagecenter/lib_message_center',
			'language' 	=> 'tmail'
		);
		parent::__construct($load);
		$this->head->add_css($this->config->item('system_css').'tmail.css');
		$this->_userid=$this->isLoginUser();
	}

	function index(){
		$this->inbox();		
	}
	function inbox($limit='',$view='',$perPage=''){
		
		$userId=isloginUser();
		$limit= (!empty($limit))? $limit :0 ;
		$perPageI=(!empty($perPage)) ? $perPage :$this->config->item('perPageRecordInbox');		
		$perPageS=(!empty($perPage)) ? $perPage :$this->config->item('perPageRecordSend');		
		$perPageT=(!empty($perPage)) ? $perPage :$this->config->item('perPageRecordTrash'); 
		
		
		/* INBOX */		
		$countInbox = $this->tmail_messaging->get_user_Inbox_Count($this->_userid);
		$countInbox = isset($countInbox['inbox_count'])?$countInbox['inbox_count']:0 ; 
		$pages = new Pagination_ajax;
		$pages->items_total = $countInbox; // this is the COUNT(*) query that gets the total record count from the table you are querying
		//$pages->items_per_page=10;
		
		// Add by amit to set drop down value for user by cookie
		$inboxPerPageVal = $this->input->cookie($userId.'inboxPerPageVal', TRUE);
		
		if($inboxPerPageVal!=''){
			$pages->items_per_page = $inboxPerPageVal;
		}else {				
		   $pages->items_per_page=10;
		}
		//End		
		$pages->paginate();
		
		//$limit=' LIMIT '.$pages->limit.' OFFSET '.$pages->offst.' ';
					
		$data['items_total'] = $pages->items_total;
		$data['items_per_page'] = $pages->items_per_page;
		$data['pagination_links'] = $pages->display_pages();			
	    $user_inbox=$this->tmail_messaging->get_user_Inbox($this->_userid,$limit,$pages->items_per_page);
		
		/* FOR SENT MAIL */ 
		
		//$countSent = $this->model_tmail->getSentCount($this->_userid);
		$countSentArray = $this->tmail_messaging->get_user_sent_count($this->_userid);
		$countSent = isset($countSentArray['sent_count'])?$countSentArray['sent_count']:0 ; 
		$sent = new Pagination_ajax;
		$sent->items_total = $countSent ; 
		//$sent->items_per_page=10;
		
		// Add by amit to set drop down value for user by cookie
		$sentPerPageVal = $this->input->cookie($userId.'sentPerPageVal', TRUE);
		
		if($sentPerPageVal!=''){
			$sent->items_per_page = $sentPerPageVal;
		}else {				
		    $sent->items_per_page=10;
		}
		//End 
		
		$sent->paginate(); 
	
		$data['items_total_sent'] = $sent->items_total;
		$data['items_per_page_sent'] = $sent->items_per_page;
		$data['pagination_links_sent'] = $sent->display_pages();
	
	   $user_sent=$this->tmail_messaging->get_user_sent($this->_userid,$limit,$sent->items_per_page);
	   
	   	
	 // $countTrash = $this->model_tmail->getTrashCount($this->_userid);
	 
		$countTrashArray=$this->tmail_messaging->get_user_trash_count($this->_userid);
		$countTrash = isset($countTrashArray['trash_count'])?$countTrashArray['trash_count']:0 ; 
				
		if(array_key_exists("retval",$user_inbox)){
			// -- Only Message List Will be pased to View as result --
			//$data["user_inbox"]=$user_inbox["retval"];
			
			//add receiver id here
			$i=0;
			
			foreach($user_inbox["retval"] as $user_inbox_list)
			{
				$get_data=$this->model_tmail->get_tmail_sender_details($user_inbox_list['thread_id']);
				$user_inbox["retval"][$i]['reciever_id'] =  $get_data;
				$i++;
			}
			
			// -- Only Message List Will be pased to View as result --
			$data["user_inbox"]=$user_inbox["retval"];
			
			
		} else {
			$data["user_inbox"]="";
		}
		
			
	$data['label']=$this->lang->language; 
	$tamil['tmailHeading']=$data['tmailHeading']='Inbox';
	$data['cravedUser']=$this->model_tmail->getcravedUser($this->_userid);
	
	$data["countInbox"] = $countInbox;
	$data['perPage']=$perPageI;
	
	$data["countSent"] =$countSent;
	$data['perPageS'] = $perPageS;
	
	$data["countTrash"] = $countTrash;
	$data['perPageT'] = $perPageT;
	
	if($this->input->get('show'))
	{
		$data['show_div'] =  $this->input->get('show');
	}else
	{
		$data['show_div'] =  'inbox';
	}
	
	//Get Sent User Data
	//$user_sent=$this->tmail_messaging->get_user_sent($this->_userid,$perPageS,$limit);
		
		/* Trash */
		
		$trash = new Pagination_ajax;
		$trash->items_total = $countTrash; // this is the COUNT(*) query that gets the total record count from the table you are querying
		//$trash->items_per_page=10;
		
		// Add by amit to set drop down value for user by cookie
		$trashPerPageVal = $this->input->cookie($userId.'trashPerPageVal', TRUE);
		
		if($trashPerPageVal!=''){
			$trash->items_per_page = $trashPerPageVal;
		}else {				
		    $trash->items_per_page =10;
		}
		//End 
		
		$trash->paginate();
		
		//$limit=' LIMIT '.$pages->limit.' OFFSET '.$pages->offst.' '; 
					
		$data['items_total_trash'] = $trash->items_total;
		$data['items_per_page_trash'] = $trash->items_per_page;
		$data['pagination_links_trash'] = $trash->display_pages();				
			
		$user_trash=$this->tmail_messaging->get_user_trash($this->_userid,$trash->offst,$trash->items_per_page);		
		
		
		if(array_key_exists("retval",$user_sent))
		{ 
			//add receiver id here
			$i=0;
			foreach($user_sent["retval"] as $user_sent_list)
			{
				$get_data=$this->model_tmail->get_tmail_sender_details($user_sent_list['thread_id']);
				$user_sent["retval"][$i]['reciever_id'] =  $get_data;
				$i++;
			}
			
			// -- Only Message List Will be pased to View as result --
			$data["user_sent"]=$user_sent["retval"];
			
			
		} else {
			$data["user_sent"]="";
		}
		//Get Sent User Data
		
		//Get Trashed User Data
		//$user_trash=$this->tmail_messaging->get_user_trash($this->_userid,$limit,$perPageT);
			// -- Only Message List Will be pased to View as result --
			if(array_key_exists("retval",$user_trash)){
				
				//add receiver id here
				$i=0;
				foreach($user_trash["retval"] as $user_trash_list)
				{
					$get_data=$this->model_tmail->get_tmail_sender_details($user_trash_list['thread_id']);
					$user_trash["retval"][$i]['reciever_id'] =  $get_data;
					$i++;
				}
				
				
				// -- Only Message List Will be pased to View as result --
				$data["user_trash"]=$user_trash["retval"];
			} else {
				$data["user_trash"]="";
			}
		//Get Trashed User Data
		if(isset($view) && $view!='')
		$this->isAjaxRequest($limit,$view,$data);
				
		
		if($view=='')
		{
		   $tamil['tmailContent']=$this->load->view("tmail_inbox",$data, true);
		   $breadcrumbItem=array('messagecenter','tmail');
		   $breadcrumbURL=array('tmail','tmail');
		   $breadcrumbString=set_breadcrumb($delimiter_config = '', $exclude = '',$breadcrumbItem,$breadcrumbURL);
		   $tamil['breadcrumbString']=$breadcrumbString;
		   //$this->template->load("template","template_tmail",$tamil);
		    $leftData=array(
							'welcomelink'=>base_url(lang().'/dashboard'),
							'isDashButton'=>true
				  );
			$leftView='dashboard/help_tmail';
			$tamil['leftContent']=$this->load->view($leftView,$leftData,true);
			
			$this->template->load('backend_template','template_tmail',$tamil);
	   }
	}
	
	
	function isAjaxRequest($count,$view,$data){
			
		if($view=='inbox_view'){		
		   $this->load->view("inbox_view",$data);
	    }
	    else if($view=='sent_view'){					
		   $this->load->view("sent_view",$data);
	    } 
	    else if($view=='trash_view'){			
		$this->load->view("trash_view",$data);		
	    } 
	    
	}
	
	
		
	function tmailList($messageId,$user_id)
	{
		
		// -- Display Detailed Thread Of user ---
		$result=$this->tmail_messaging->get_full_thread($messageId,$user_id);
		// -- Only Message List Will be pased to View as result --
		$data["result"]=$result["retval"];
		$data['label']=$this->lang->language; 
		$tamil['tmailHeading']=$data['tmailHeading']='Inbox';
		$tamil['tmailContent']=$this->load->view("tmail_List",$data, true);
		//$this->template->load("template","template_tmail",$tamil);
		$leftData=array(
						'welcomelink'=>base_url(lang().'/dashboard'),
						'isDashButton'=>true
				);
		$leftView='dashboard/help_tmail';
		$tamil['leftContent']=$this->load->view($leftView,$leftData,true);
		
		$this->template->load('backend_template','template_tmail',$tamil);
	}

	
	/* Send Mail */
	function sendTmail(){
		
		if($this->input->post("recipientsId"))
		{
			$recipients=$this->input->post("recipientsId");
			$subject=$this->input->post("subject");
			$body=$this->input->post("body");
			$type=$this->input->post("type");
			$type=($type >0)?$type:1;
			$msg = $this->tmail_messaging->send_new_message($this->_userid,$recipients, $subject,$body,$type);
			if($this->input->post("ajaxHit")){
				echo 1;
			}else{
				$this->index();
			}
		}
	}

	
			
	/* Read View of tmail
	 * id is unique id in participant table to get record
	 * */	
	function viewTmail($id,$type,$isAjaxRequest='')	{
		
		$curentUid = $this->_userid;
		/* Add to check id belongs to specified user */		
		$is_sender = (isset($type) && ($type=='Inbox')) ? 'f' : 't';
		
		if(isset($type) && ($type!='Trash')){
		$whereField=array('is_sender'=>$is_sender,'msg_id'=>$id,'user_id'=>$curentUid);
	    }else {
			    $whereField=array('msg_id'=>$id,'user_id'=>$curentUid);
			   } 
		
		 //set attachment data
	    $data['attachmentData']=$this->model_tmail->getAttachmentData($id);
			   
		//Redirect if user is trying to access tmail of another user
		if(isset($id) && $id >0 && isset($curentUid)){
			$userDataWhere = $whereField;
			checkUsersProjects('tmail_participants',$userDataWhere);
		}
			
		/* End */	
		
		
		$getsenderId=$this->model_tmail->getSenderId($id);
		//if sender is 0 then redirect to  viewTmailNew
		if($getsenderId==0)
		{
			redirect(base_url(lang().'/tmail/viewTmailNew/'.$id.'/'.$type));
			
		}
		
				
		if($type=='Inbox') 
		$this->model_tmail->isRead($id,$curentUid);
		$getUserMessageData=$this->model_tmail->getUserMessage($id,$curentUid);
		$get_data=$this->model_tmail->get_tmail_sender_details($getUserMessageData[0]->thread_id);
		
		$getUserMessageData[0]->get_sender_id =  $get_data;
		$data['data'] 	 = $getUserMessageData;
		$data['max_id']=$this->model_tmail->getMaxNo($curentUid,$type);
		$data['min_id']=$this->model_tmail->getMinNo($curentUid,$type);
		$data['type'] =$type;
		$data['curentUid']=$curentUid;
				
		$msgType = $data['data'][0]->type;
		
		if($data['data'])
		$data['data'] = $data['data'][0];
		
		//print_r($data);die;
		if($isAjaxRequest==true) {
		  return $this->load->view('viewTmail',$data);		  
	     } 
	     
	     if($type=='Sent'){
		      return $this->viewSentTmail($data,$id);			 
		 }elseif($type=='Trash'){
			return $this->viewDeleteTmail($data);
			}
	     
	     $data['loadView'] = 'tmail_details'; 
	     
	     $threadId = $this->model_tmail->getThreadId($id);
	
	     $data['mailThreadData'] = $this->model_tmail->getMailThread($threadId,$curentUid,$id);   
	     
	     
	    $breadcrumbItem=array('tmail','Inbox');
		$breadcrumbURL=array('tmail','tmail');
		$breadcrumbString=set_breadcrumb($delimiter_config = '', $exclude = '',$breadcrumbItem,$breadcrumbURL);
		$data['breadcrumbString']=$breadcrumbString;
	     
	   // echo $msgType;die; 
	   
		
		/************This section showing attachment start ***********/
		/*if($type=='Inbox')
		{
			$curentUid = isLoginUser();
			if(isset($id) && $id!='')
			$attachInfo = $this->model_tmail->getWorkProfileAttach($id,$curentUid);		
			if( isset($attachInfo['sender_id']) && $attachInfo['sender_id']!='')
			$data['isWorkprofile'] = encode($attachInfo['sender_id'].'-'.$attachInfo['elementid'].'-'.$attachInfo['access_token']); 
		}*/
		
	   
		/************This section showing attachment start ***********/
		
	     
	     if(isset($msgType) && ($msgType==6) && ($type=='Inbox')){
			  return $this->productTmailView($id,$data);			  		   
	      }
	     
	     if(isset($msgType) && ($msgType==4) && ($type=='Inbox')){
			  return $this->workTmailView($id,$data);			  		   
		 }else{
			 // $this->template->load("template","viewTmail",$data);
			$leftData=array(
							'welcomelink'=>base_url(lang().'/dashboard'),
							'isDashButton'=>true
					);
			$leftView='dashboard/help_tmail';
			$data['leftContent']=$this->load->view($leftView,$leftData,true);
			
			$this->template->load('backend_template','viewTmail',$data);			 
		 }	 
		
   }		
		
		
	/* Read View of tmail
	 * This function only for which user message type is 9
	 * */	
	function viewTmailNew($id,$type,$isAjaxRequest='')	{		
		
		
		$curentUid = $this->_userid;
		
		
		/* Add to check id belongs to specified user */		
		$is_sender = (isset($type) && ($type=='Inbox')) ? 'f' : 't';
		
		if(isset($type) && ($type!='Trash')){
		$whereField=array('is_sender'=>$is_sender,'msg_id'=>$id,'user_id'=>$curentUid);
	    }else {
			    $whereField=array('msg_id'=>$id,'user_id'=>$curentUid);
			   } 
		
		//Redirect if user is trying to access post of another user
		if(isset($id) && $id >0 && isset($curentUid)){
			$userDataWhere = $whereField;
			checkUsersProjects('tmail_participants',$userDataWhere);
		}		   
			
		/* End */	
		
		
		
		if($type=='Inbox') 
		$this->model_tmail->isRead($id,$curentUid);
		//$getUserMessageData=$this->model_tmail->getUserMessage($id,$curentUid);
		
		
		//$get_data=$this->model_tmail->get_tmail_sender_details($getUserMessageData[0]->thread_id);
		//print_r($get_data);die;
		//$getUserMessageData[0]->get_sender_id =  $get_data;
	//	$data['data'] 	 = $getUserMessageData;
		$data['max_id']=$this->model_tmail->getMaxNo($curentUid,$type);
		
		$data['min_id']=$this->model_tmail->getMinNo($curentUid,$type);
		$data['type'] =$type;
		$data['curentUid']=$curentUid;
		$data['data'] ="";		
		$msgType = '9';
		
	//	if($data['data'])
	//	$data['data'] = $data['data'][0];
		
		//print_r($data);die;
		if($isAjaxRequest==true) {
		  return $this->load->view('viewTmail',$data);		  
	     } 
	     
	    /* if($type=='Sent'){
		      return $this->viewSentTmail($data,$id);			 
		 }elseif($type=='Trash'){
			return $this->viewDeleteTmail($data);
			}*/
	     
	     $data['loadView'] = 'tmail_details_for_self'; 
	     
	     $threadId = $this->model_tmail->getThreadId($id);
	     
	    //set attachment data
	    $data['attachmentData']=$this->model_tmail->getAttachmentData($id);
		
	     $data['mailThreadData'] = $this->model_tmail->getMailDetailsNewUser($threadId,$curentUid,$id);   
	     
	    if($type=='Inbox')
	    {  
	    	$breadcrumbItem=array('tmail','Inbox');
			$breadcrumbURL=array('tmail','tmail');
			$breadcrumbString=set_breadcrumb($delimiter_config = '', $exclude = '',$breadcrumbItem,$breadcrumbURL);
			$data['breadcrumbString']=$breadcrumbString;
	    }
	    
	    if($type=='Trash')
	    {  
	    	$breadcrumbItem=array('tmail','Trash');
			$breadcrumbURL=array('tmail','tmail');
			$breadcrumbString=set_breadcrumb($delimiter_config = '', $exclude = '',$breadcrumbItem,$breadcrumbURL);
			$data['breadcrumbString']=$breadcrumbString;
	    }
	    
	   // echo $msgType;die; 
	     
	    //$this->template->load("template","viewTmail",$data); 
	    $leftData=array(
						'welcomelink'=>base_url(lang().'/dashboard'),
						'isDashButton'=>true
			  );
		$leftView='dashboard/help_tmail';
		$data['leftContent']=$this->load->view($leftView,$leftData,true);
		
		$this->template->load('backend_template','viewTmail',$data);
		
   }		
		
		
	function workTmailView ($tmailId,$data) {
		
		$curentUid = isLoginUser();
		if(isset($tmailId) && $tmailId!='')
		$attachInfo = $this->model_tmail->getAttacmentDetails($tmailId,$curentUid);		
		
		if($attachInfo)
		  $attachInfo = $attachInfo[0]	;
		
		$data['loadView'] = 'work_tmail_view';  
		 
		if( isset($attachInfo['sender_id']) && $attachInfo['sender_id']!='')
		$data['isWorkprofile'] = encode($attachInfo['sender_id'].'-'.$attachInfo['elementid'].'-'.$attachInfo['access_token']); 
		  
		//$this->template->load("template","viewTmail",$data); 	
		$leftData=array(
						'welcomelink'=>base_url(lang().'/dashboard'),
						'isDashButton'=>true
			  );
		$leftView='dashboard/help_tmail';
		$data['leftContent']=$this->load->view($leftView,$leftData,true);
		
		$this->template->load('backend_template','viewTmail',$data);	
		
		
	}
	
	
	 /* Product View Inbox */
	 function productTmailView ($tmailId,$data) {		
		$curentUid = isLoginUser();
		if(isset($tmailId) && $tmailId!='')
		$attachInfo = $this->model_tmail->getProductAttacment($tmailId);		
		
		if($attachInfo)
		  $attachInfo = $attachInfo[0]	;  
		
		$data['loadView'] = 'work_tmail_view';  
		 
		if( isset($attachInfo['elementid']) && $attachInfo['elementid']!='')
		$data['isProductAttachment'] = $attachInfo; 		  
		//$this->template->load("template","viewTmail",$data); 	
		$leftData=array(
						'welcomelink'=>base_url(lang().'/dashboard'),
						'isDashButton'=>true
			  );
		$leftView='dashboard/help_tmail';
		$data['leftContent']=$this->load->view($leftView,$leftData,true);
		
		$this->template->load('backend_template','viewTmail',$data);	
	}
	
		
	function viewWork($id,$isWorkprofile=''){		
		$curentUid = $this->_userid; 
	//	$this->model_tmail->isRead($id,$curentUid);
		$data['data']=$this->model_tmail->getUserMessage($id,$curentUid);
		
		$data['curentUid']=$curentUid;
		$data['type']='Inbox';
		
		$threadId = $this->model_tmail->getThreadId($id);	
	    $data['mailThreadData'] = $this->model_tmail->getMailThread($threadId,$curentUid,$id); 		
		$msgType = $data['data'][0]->type;
		
		if(isset($isWorkprofile) && $isWorkprofile!='')
		 $data['isWorkprofile']=$isWorkprofile;
		
		if($data['data'])
		$data['data'] = $data['data'][0];
		
		
		$breadcrumbItem=array('tmail','ViewTmail');
		$breadcrumbURL=array('tmail','tmail');
		$breadcrumbString=set_breadcrumb($delimiter_config = '', $exclude = '',$breadcrumbItem,$breadcrumbURL);
		$data['breadcrumbString']=$breadcrumbString;		
	     
		//$this->template->load("template","view_work_applications",$data);
		$leftData=array(
						'welcomelink'=>base_url(lang().'/dashboard'),
						'isDashButton'=>true
			  );
		$leftView='dashboard/help_tmail';
		$data['leftContent']=$this->load->view($leftView,$leftData,true);
		
		$this->template->load('backend_template','view_work_applications',$data);
		
   }
   
   function viewSentTmail($data,$id){		
		$curentUid = isloginUser();
		
		if($data['data']->thread_id!=''){
			
			$threadId = $data['data']->thread_id;		
			$replId = $this->model_tmail->getReceiverId($curentUid,$threadId);
					
			 if($replId[0]->user_id!='')
			   $data['replyId'] = $replId[0]->user_id;	
		 }	
		 
		 $breadcrumbItem=array('tmail','Sent');
		$breadcrumbURL=array('tmail','tmail');
		$breadcrumbString=set_breadcrumb($delimiter_config = '', $exclude = '',$breadcrumbItem,$breadcrumbURL);
		$data['breadcrumbString']=$breadcrumbString;
		
		$data['mailThreadData'] = $this->model_tmail->getMailThread($threadId,$curentUid,$id);
				
		$data['loadView'] = 'sent_tmail_view'; 	     
		//$this->template->load("template","viewTmail",$data);
		
		$leftData=array(
						'welcomelink'=>base_url(lang().'/dashboard'),
						'isDashButton'=>true
			  );
		$leftView='dashboard/help_tmail';
		$data['leftContent']=$this->load->view($leftView,$leftData,true);
		
		$this->template->load('backend_template','viewTmail',$data);
		
   }
   
   	function viewDeleteTmail($data){
		
		$breadcrumbItem=array('tmail','Trash');
		$breadcrumbURL=array('tmail','tmail');
		$breadcrumbString=set_breadcrumb($delimiter_config = '', $exclude = '',$breadcrumbItem,$breadcrumbURL);
		$data['breadcrumbString']=$breadcrumbString;
				
		$data['loadView'] = 'delete_tmail_view'; 	     
		//$this->template->load("template","viewTmail",$data);	
		$leftData=array(
						'welcomelink'=>base_url(lang().'/dashboard'),
						'isDashButton'=>true
			  );
		$leftView='dashboard/help_tmail';
		$data['leftContent']=$this->load->view($leftView,$leftData,true);
		
		$this->template->load('backend_template','viewTmail',$data);	
   }
		
		/* Tmail view */
	function showTmailReplay($id,$type)
	{
		$curentUid = $this->_userid; 
		$data['data']=$this->model_tmail->getUserMessage($id,$curentUid);
		$data['max_id']=$this->model_tmail->getMaxNo($curentUid,$type);
		$data['min_id']=$this->model_tmail->getMinNo($curentUid,$type);
		$data['type'] =$type;
		$data['curentUid']=$curentUid;
		
		if($data['data'])
		$data['data'] = $data['data'][0];		
		//print_r($data);die;
		$this->load->view('tmail_reply_view',$data);		
		
	}	
	
	/* Send new tmail (Compose) */	
	
	 function compose ($userId=0) {		 
		//$this->template->load("template","tmail_compose"); 
		$leftData=array(
						'welcomelink'=>base_url(lang().'/dashboard'),
						'isDashButton'=>true
			  );
		$leftView='dashboard/help_tmail';
		$data['leftContent']=$this->load->view($leftView,$leftData,true);
		if(!empty($userId) && $userId > 0) {
            //get user's data
            $userData  = $this->model_common->gettmailuserdata($userId);
            if(!empty($userData)) {
                // set user's deials
                $data['recipientsId'] = $userId;
                $data['receiverEmail'] = $userData[0]->email;
                $data['receiverName'] = $userData[0]->firstName.' '.$userData[0]->lastName;
                $data['recommendationSubject'] = "Recommendation Request";
            }     
        }
		$this->template->load('backend_template','tmail_compose',$data);
	 }			
		
		
/* Show View in ajax request */	
	function inbox_view() {
		
		$userId=isloginUser();
		$countInbox = $this->tmail_messaging->get_user_Inbox_Count($this->_userid);
		
		$countInbox = isset($countInbox['inbox_count'])?$countInbox['inbox_count']:0 ;
			
		$pages = new Pagination_ajax;
		$pages->items_total = $countInbox; // this is the COUNT(*) query that gets the total record count from the table you are querying
		//$pages->items_per_page=10;
		//$pages->paginate();		
		
		// Add by amit to set drop down value for user 		
		$isCokkie = $this->input->cookie($userId.'inboxPerPageVal', TRUE);
		
		if($this->input->post('ipp')!=''){			
			setcookie($userId."inboxPerPageVal", $this->input->post('ipp'), time()+(3600*24*365),"/");					
		}else if(($isCokkie=='') && ($this->input->post('ipp')=='')) {		
			setcookie($userId."inboxPerPageVal", $this->config->item('perPageRecordInbox'), time()+(3600*24*365),"/");
		  }
        	
		//$pages->items_per_page=($this->input->post('ipp')!='')?$this->input->post('ipp'):10;
		$pages->items_per_page=($this->input->post('ipp')!='')?$this->input->post('ipp'):$isCokkie;
		$pages->paginate();	
			
		$data['items_total'] = $pages->items_total;
		$data['items_per_page'] = $pages->items_per_page;
		//$data['items_per_page'] = 5;
		$data['pagination_links'] = $pages->display_pages();					
			
		$user_inbox=$this->tmail_messaging->get_user_Inbox($this->_userid,$pages->offst,$pages->items_per_page);			 
		if(array_key_exists("retval",$user_inbox)){
			// -- Only Message List Will be pased to View as result --
			//$data["user_inbox"]=$user_inbox["retval"];
			
			$i=0;
			foreach($user_inbox["retval"] as $user_inbox_list)
			{
				$get_data=$this->model_tmail->get_tmail_sender_details($user_inbox_list['thread_id']);
				$user_inbox["retval"][$i]['reciever_id'] =  $get_data;
				$i++;
			}
			
			// -- Only Message List Will be pased to View as result --
			$data["user_inbox"]=$user_inbox["retval"];
			
		} else {
			$data["user_inbox"]="";
		}
		
		$data['perPage']=$pages->items_per_page;	
		$data['label']=$this->lang->language; 
		$data['tmailHeading']='Inbox';
		//$data['currentPage']=$currentPage;
		//echo  $countInbox;
		$data["countInbox"] = $countInbox;	
			
		$this->load->view("inbox_view",$data);				
		
	}
	
	
  function sent_view(){
	  
		$userId=isloginUser();
		$countSentArray = $this->tmail_messaging->get_user_sent_count($this->_userid);
		
		$countSentArray = isset($countSentArray['sent_count'])?$countSentArray['sent_count']:0 ;
		
		$countSent = $countSentArray; 
		$sent = new Pagination_ajax;
		$sent->items_total = $countSent ; // this is the COUNT(*) query that gets the total record count from the table you are querying
		//$pagesS->items_per_page=5;
		//$sent->paginate();	
				
		// Add by amit to set drop down value for user 		
		$isCokkie = $this->input->cookie($userId.'sentPerPageVal', TRUE);
		
		if($this->input->post('ipp')!=''){			
			setcookie($userId."sentPerPageVal", $this->input->post('ipp'), time()+(3600*24*365),"/");							
		}else if(($isCokkie=='') && ($this->input->post('ipp')=='')) {		
			setcookie($userId."sentPerPageVal", $this->config->item('perPageRecordSend'), time()+(3600*24*365),"/");			
		  }
        	
		//$pages->items_per_page=($this->input->post('ipp')!='')?$this->input->post('ipp'):10;
		$sent->items_per_page=($this->input->post('ipp')!='')?$this->input->post('ipp'):$isCokkie;
					
		$sent->paginate();		
			
		//$countSent = $this->model_tmail->getSentCount($this->_userid);		
		$data['items_total_sent'] = $sent->items_total;
		$data['items_per_page_sent'] = $sent->items_per_page;
		$data['pagination_links_sent'] = $sent->display_pages();
			
	    $user_sent=$this->tmail_messaging->get_user_sent($this->_userid,$sent->offst,$sent->items_per_page);
	   
			$data['perPageS'] = '';
			$data["countSent"] = $countSent;			
			//$data['currentPage']=$currentPage;
			
			if(array_key_exists("retval",$user_sent))
			{ 
				//add reciever id here
				$i=0;
				foreach($user_sent["retval"] as $user_sent_list)
				{
					$get_data=$this->model_tmail->get_tmail_sender_details($user_sent_list['thread_id']);
					$user_sent["retval"][$i]['reciever_id'] =  $get_data;
					$i++;
				}
				
				$data["user_sent"]=$user_sent["retval"];				
			} else {
				$data["user_sent"]="";
			}
			
			$data['label']=$this->lang->language; 
			$tamil['tmailHeading']=$data['tmailHeading']='Inbox';
			
			$this->load->view("sent_view",$data);					
			
	 }
	
		
	 function trash_view(){
		
		$userId=isloginUser();
		$countTrashArray=$this->tmail_messaging->get_user_trash_count($this->_userid);
		
		$countTrashArray = isset($countTrashArray['trash_count'])?$countTrashArray['trash_count']:0 ;
		
		$countTrash = $countTrashArray; 			 
		$trash = new Pagination_ajax;
		$trash->items_total = $countTrash; // this is the COUNT(*) query that gets the total record count from the table you are querying
		//$trash->items_per_page=1;
		//$trash->paginate();
		
		
		// Add by amit to set drop down value for user 		
		$isCokkie = $this->input->cookie($userId.'trashPerPageVal', TRUE);
		
		if($this->input->post('ipp')!=''){			
			setcookie($userId."trashPerPageVal", $this->input->post('ipp'), time()+(3600*24*365),"/");							
		}else if(($isCokkie=='') && ($this->input->post('ipp')=='')) {		
			setcookie($userId."trashPerPageVal", $this->config->item('perPageRecordTrash'), time()+(3600*24*365),"/");			
		  }
        	
		//$pages->items_per_page=($this->input->post('ipp')!='')?$this->input->post('ipp'):10;
		$trash->items_per_page=($this->input->post('ipp')!='')?$this->input->post('ipp'):$isCokkie;
		
		$trash->paginate();
		
		//echo $limit=' LIMIT '.$trash->limit.' OFFSET '.$trash->offst.' '; 
					
		$data['items_total_trash'] = $trash->items_total;
		$data['items_per_page_trash'] = $trash->items_per_page;
		$data['pagination_links_trash'] = $trash->display_pages();				
			
		$user_trash=$this->tmail_messaging->get_user_trash($this->_userid,$trash->offst,$trash->items_per_page);
		
		$data['perPageT'] = '';
		$data["countTrash"] = $countTrash;			
		//$data['currentPage']=$currentPage;
					
			if(array_key_exists("retval",$user_trash))
			{ 
				//add receiver id here
				$i=0;
				foreach($user_trash["retval"] as $user_trash_list)
				{
					$get_data=$this->model_tmail->get_tmail_sender_details($user_trash_list['thread_id']);
					$user_trash["retval"][$i]['reciever_id'] =  $get_data;
					$i++;
				}
				
				$data["user_trash"]=$user_trash["retval"];				
			} else {
				$data["user_trash"]="";
			}
						
			$data['label']=$this->lang->language; 
			$tamil['tmailHeading']=$data['tmailHeading']='Inbox';
			$this->load->view("trash_view",$data);
	 }
		
			
		function trashTmailMessage($delItems,$perPage,$offSet,$view,$currentPage=0)
		{
			$limit =0;	
			$perPage=(!empty($perPage)) ? $perPage :8;
			$offSet=(!empty($offSet)) ? $offSet :0; 
			
			 $items = explode(',',$delItems);		 
					 
			 $curentUid = $this->_userid;
					foreach($items as $delItem)
					 { 	
						
					 $this->model_tmail->trashTmailMessage($delItem,$curentUid,$view);
					 }	
			if($view=='Inbox')		 
			$this->inbox_view($perPage,$offSet,$currentPage);
			
			if($view=='Sent')		 
			$this->sent_view($perPage,$offSet,$currentPage);
			
			if($view=='Trash')		 
			$this->trash_view($perPage,$offSet,$currentPage);			
			 			
		}	
		
		
		
		function trashTmailPopupMessage($delItem,$view,$nxtRecord='') {
								 
			$curentUid = $this->_userid;			
			$this->model_tmail->trashTmailMessage($delItem,$curentUid,$view);
			return true;						
			//return $this->showTmailPopup($nxtRecord,$view,$ajaxHit=true);				 			
		}
	
		
	
	
	    function getNextTmailDetail($id,$type) {  
		    $curentUid = $this->_userid; 
			$data['data']= $this->model_tmail->getnexTmail($id,$curentUid,$type); 
			
			$data['max_id']=$this->model_tmail->getMaxNo($curentUid,$type);
		    $data['min_id']=$this->model_tmail->getMinNo($curentUid,$type);
		    $data['type'] =$type;
		    $data['curentUid']=$curentUid;
			
			if($data['data'])
		     $data['data'] = $data['data'][0];
		     //print_r($data);die;
			$this->load->view('tmail_details',$data);			
		}
	  
	
	    function getPrevTmailDetail($id,$type) {  
		    $curentUid = $this->_userid; 
			$data['data'] = $this->model_tmail->getprevTmail($id,$curentUid,$type); 
			
			$data['max_id']=$this->model_tmail->getMaxNo($curentUid,$type);
		    $data['min_id']=$this->model_tmail->getMinNo($curentUid,$type);
		    $data['type'] =$type;
		    $data['curentUid']=$curentUid;
			
			if($data['data'])
	          $data['data'] = $data['data'][0];
	       // print_r($data);die;  			
			$this->load->view('tmail_details',$data);			
		}
		
		
	 /**
	 *  Function to send work application request 
	 * 
	 **/
	
	function sendWorkApplication(){
		
		$curentUid = $this->_userid;
		$isAttachProfile =$this->input->post("isWorkProfile") ; 	
		$isWorkProfile = (!empty($isAttachProfile)) ? $isAttachProfile : 'f' ;
		
		//echo $isWorkProfile;die;
		$workId = $this->input->post("workId");			 

		if($this->input->post("recipientsId")){

				$recipients=$this->input->post("recipientsId");				
				$result = $this->model_tmail->send_new_message($this->input->post("senderId"),$recipients, $this->input->post("subject"),$this->input->post("body"),1,4);				
							
				if($result)	{
					 $expiryDate = date ('Y-m-d ', strtotime ( '+15 days' .date('Y-m-d')));		  
					 $WorkApplicationData['workId'] 	         = $workId;
					 $WorkApplicationData['tdsUid'] 	         = $curentUid;
					 $WorkApplicationData['tmailId']             = $result;
					 $WorkApplicationData['isAttachedProfile']   = $isWorkProfile;
					 $WorkApplicationData['expirydate']          = $expiryDate;
					 $WorkApplicationData['workOwnerId']          = $recipients;
					 $res = $this->model_common->addDataIntoTabel('WorkApplication', $WorkApplicationData);	
				 }				 
				 
	 if($isAttachProfile) {

					if($res){
							$attchment_id = $this->model_tmail->insert_work_request($this->_userid,$recipients)	;	
							$entityId = getMasterTableRecord('WorkProfileUrlRequest');					

							$attachDataInsert=array(  									
							"msg_id"=>$result,								
							"attachment.title"=>'Work Profile', 
							"attachment.entityid"=>$entityId, 
							"attachment.elementid"=>$attchment_id								
							);								  

							$this->model_tmail->insertAttachmentIntoObject('tmail_attachment', $attachDataInsert);
					}  

					if($this->input->post("ajaxHit"))
					echo 1;	 

				}
		}      
	}
	  	
	
		
	/**
	 *   Function for Request Work Profile 
	 * 
	 **/
	
	function requestWorkProfile(){
		$senderId=isloginUser();
		$recipients = $this->input->post("recipientsId");
		$subject = $this->input->post("subject");
		$body = $this->input->post("body");		
			
			if($recipients)	{
			   $msg_id = $this->model_tmail->send_new_message($senderId,$recipients,$subject,$body,1,2);				
			}

			if($this->input->post("ajaxHit"))
			echo 1;			  
						  		 
	}
		      
		      
	 /**
	  *   Function for Replay Request Work Profile 
	  *   add attachment info if attachment find
	  **/
	
	function replyrequestWP($reply_msg_id='',$body='',$subject='',$receiverid=''){
		
		    $senderId=isloginUser();		
			$reply_msg_id=$this->input->post('reply_msg_id');
			$body=$this->input->post('body');
			$subject=$this->input->post('subject');
			$receiverid=$this->input->post('receiverid');
		
			if($reply_msg_id)	{
			   $msg_id =  $this->model_tmail->reply_to_message($reply_msg_id,$senderId,$receiverid,$body,1,$subject,2);				
			}

			if($msg_id){
			   $attchment_id = $this->model_tmail->insert_work_request($senderId,$receiverid);	
			} 

				if($attchment_id){
					$entityId = getMasterTableRecord('WorkProfileUrlRequest');	
					
					$attachDataInsert=array(
					"msg_id"=>$msg_id,								
					"attachment.title"=>'Work Profile', 
					"attachment.entityid"=>$entityId, 
					"attachment.elementid"=>$attchment_id								
					);	

					$this->model_tmail->insertAttachmentIntoObject('tmail_attachment', $attachDataInsert);										  
					if($this->input->post("ajaxHit"))
					echo 1;	

				}				

			}
			
		/* Get information of mail receipent user  */
			
	 function replyTmail()	{
				
		$currentUser            = isLoginUser(); 
		$data['senderId']       = $currentUser; 			 
		$data['subject']        = $this->input->post('subject');
		$data['reply_msg_id']   = $this->input->post('reply_msg_id');
		$receiverid             = $this->input->post('receiverid'); 				
		$data['replyName']      = $this->input->post('userName'); 
		$data['msgType']        = $this->input->post('msgType');
		$threadId               = $this->input->post('threadId');
		$data['viewType']       = $this->input->post('viewType');				
		$data['replyEmailId']   = $this->model_tmail->getEmailId($receiverid);
		$msg_id                 = $this->input->post('reply_msg_id');
		$data['status_id']      = $this->input->post('currentRecordId');
		
	
		
		if( isset($data['replyEmailId'][0]->email) && $data['replyEmailId'][0]->email!=''){
			$data['replyrName'] = isGetUserName($receiverid); 
			$data['replyEmailId'] = $data['replyEmailId'][0]->email;
			
		}else {			
			redirect(base_url(lang().'/tmail'));
			}
		
		$data['receiverid'] = $receiverid;		
		$data['mailThreadData'] = $this->model_tmail->getMailThread($threadId,$currentUser,$msg_id);				
		$data['threadId']        = $threadId;
		
		//$this->template->load("template","tmail_reply",$data); 
		$leftData=array(
						'welcomelink'=>base_url(lang().'/dashboard'),
						'isDashButton'=>true
			  );
		$leftView='dashboard/help_tmail';
		$data['leftContent']=$this->load->view($leftView,$leftData,true);
		
		$this->template->load('backend_template','tmail_reply',$data);
				 
	 }
	 
	 
		
	/* Save tmail reply in database */
		
	function saveReplyTmail() {
				
		$currentUser   = isLoginUser(); 
		$senderId      = $this->input->post('senderId'); 			 
		$subject       = $this->input->post('subject');
		$reply_msg_id   = $this->input->post('reply_msg_id');						
		$receiverid    = $this->input->post('receiverid');
		$msgType       = $this->input->post('msgType');
		$body          = $this->input->post('replymsg',FALSE);	
		$threadId      = $this->input->post('threadId');		
		
		$reply =  $this->model_tmail->reply_to_message($reply_msg_id,$senderId,$receiverid,$body,1,$subject,$msgType);
		
		$data['mailThreadData'] = $this->model_tmail->getMailThread($threadId,$currentUser,$reply_msg_id);
				
		if($reply) {			
				 $this->load->view('show_thread',$data);		
			}			 
		 
	 }	
	 
	 
	  /* Get Users Craved on Current User
	   * sortVal if defined get result by searched string
	  * */
	  
	   function getCravedUser($sortVal='') {		   
		   if($sortVal == $this->lang->line('searchMembers'))
		   	  $sortVal='';
		   	  
		   	  $data['cravedList']=$this->model_tmail->getcravedUser($this->_userid,$sortVal); 
		   
		   $this->load->view('craved_user_list',$data);		   
		   
		   }
	 
		/* 
	function showTmailPopup($id,$type,$isAjaxRequest='')
	{		
		$curentUid = $this->_userid; 
		$this->model_tmail->isRead($id,$curentUid);
		$data['data']=$this->model_tmail->getUserMessage($id,$curentUid);
		$data['max_id']=$this->model_tmail->getMaxNo($curentUid,$type);
		$data['min_id']=$this->model_tmail->getMinNo($curentUid,$type);
		$data['type'] =$type;
		$data['curentUid']=$curentUid;
		
		if($data['data'])
		$data['data'] = $data['data'][0];
		
		//print_r($data);die;
		if($isAjaxRequest==true) {
		  return $this->load->view('viewTmail',$data);		  
	     }
	     
		 $this->template->load("template","viewTmail",$data);
		
		
		
   }		
			 
	
		
	function testAttch(){
		echo $entityId = getMasterTableRecord('WorkProfileUrlRequest');
	// $data = $this->model_tmail->getProductAttacment(276,21)	;
	$data=$this->model_tmail->getProductAttacment(77);
	echo "<pre/>";
	print_r($data);die;
	}	
*/


  function testAttch(){
		echo $data =  $this->model_tmail->getMailThread(151,85,192);
	// $data = $this->model_tmail->getProductAttacment(276,21)	;
	//$data=$this->model_tmail->getProductAttacment(77);
	echo "<pre/>";
	print_r($data);die;
	}	

	
	 /**
	 *  Function to Send product request
	 *  Productshowcase/product_offer_popup accessing this function to insert data in tmail 
	 * 
	 **/
	
	function offerProductWanted(){		

		$curentUid = $this->_userid;
		$isAttachProfile =$this->input->post("isWorkProfile") ; 	
		$isWorkProfile = (!empty($isAttachProfile)) ? $isAttachProfile : 'f' ;
		$productId = $this->input->post("productId");			 

		if($this->input->post("recipientsId")){

			$recipients=$this->input->post("recipientsId");				
			$result = $this->model_tmail->send_new_message($this->input->post("senderId"),$recipients, $this->input->post("subject"),$this->input->post("body"),1,6);				


			if($isAttachProfile) {

				if($result){
					$entityId = getMasterTableRecord('Product');						

					$attachDataInsert=array(  									
					"msg_id"=>$result,								
					"attachment.title"=>'Product offered', 
					"attachment.entityid"=>$entityId, 
					"attachment.elementid"=>$productId								
					);								  

					$this->model_tmail->insertAttachmentIntoObject('tmail_attachment', $attachDataInsert);
				}  

				if($this->input->post("ajaxHit"))
				echo 1;	 

			} 
		}      
	}
	
	
	
	
	 function testMail(){
     
     
	 $r =  $this->input->post('mc_gross');
              
      //  $r =  $this->input->post('payment_status') ; 	 
	   $this->email->from('your@example.com', 'Your Name');
		$this->email->to('amitwali@cdnsol.com');
		$this->email->subject('subject');
		$this->email->message($r);
		$this->email->send();
	 }
	
	
	function test_mail()
	{
		$expDays = '+'.$this->config->item('setExpiryWorkProfile').'days';
		echo $expiryDate = date ('Y-m-d ', strtotime ( $expDays.date('Y-m-d')));	
		die;
		$msg = $this->tmail_messaging->send_new_message(0,85, "testing direct","body testing direct",1,9);
	//	echo "message sent.";
		print_r($msg);
	}
	
	 
							  
		      
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
