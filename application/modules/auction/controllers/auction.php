<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Todasquare Auction Controller Class
 *
 *  @package	Toadsquare
 *  @subpackage	Module
 *  @category	Controller
 *  @author		Tosif Qureshi
 *  @link		http://toadsquare.com/
 */
 
class auction extends MX_Controller {

	/**
	 * Constructor
	 */
	function __construct() {
		//Load required Model, Library, language and Helper files
		$load = array(
			'model'		=> 'model_common + auction/model_auction',  	
			'library' 	=> 'form_validation + upload + session + Lib_masterMedia + lib_sub_master_media + lib_image_config',		 	
			'helper' 	=> 'form + file',   		
		);
		parent::__construct($load);
        //$this->userId = $this->isLoginUser();
		$this->userId = isLoginUser();
	}

	/**
	 * Index fucntion by default call when Controller initialised
	 *
	 * by default call function for auction form
	 *
	 * @access	public
	 * @param	
	 * @return	
	 */
	public function index() {
		redirectToNorecord404(); //redirect to no record page
	}
	
	/*
	 * Function to load auction form view
	 */ 
	public function auctionForm($projectData='') {
		$data['entityId'] = $projectData['entityId'];
		$data['projectId'] = $projectData['projectId'];
		$data['elementId'] = $projectData['elementId'];
		$this->load->view('auctionForm',$data);
	}
	
	/*
	 * Function used to set auctions data
	 */
	public function setAuctionData() {
		//Set post values
		$auctionData['startDate']  	 = $this->input->post('auctionStartDate');
		$auctionData['endDate']      = $this->input->post('auctionEndDate');
		$auctionData['minBidPrice']  = $this->input->post('minimumBidPrice');
		$auctionData['projectId']	 = $this->input->post('projectId');
		$auctionData['entityId'] 	 = $this->input->post('entityId');
		$auctionData['elementId']	 = $this->input->post('elementId');
		$auctionData['tdsUid']	     = $this->userId;
		$auctionId	 				 = $this->input->post('auctionId');
		if(isset($auctionId) && $auctionId>0) {
			//Update auction record of project
			$auctionId = $this->model_auction->auctionInformationInsert($auctionData,$auctionId);
		} else {
			//Add auction record of project
			$auctionId = $this->model_auction->auctionInformationInsert($auctionData);
		}
		echo json_encode($auctionId);
		echo $auctionId;
	}
	
	/*
	 * This funciton is used for set product bids
	 */
	public function setProductBid() {
		$productId = $this->input->get('val1');
		$productTitle = $this->input->get('val2');
		$data['productId'] = $productId;
		$data['productTitle'] = $productTitle;
		$this->load->view('projectBid',$data);		//load template with product bid view	
	}
	
	/*
	 * This funciton is used to save users bid price
	 */
	public function postBidPrice() {
		$this->userId = isLoginUser();
		//Set bidding post values
		$data['auctionId']   =  $this->input->post('auctionId');
		$data['userId']  	 =  $this->userId;
		$data['price']  	 =  $this->input->post('bidPrice');
		$data['date']  	     =  date("Y-m-d H:i:s");
		$data['modifiedDate']=  date("Y-m-d H:i:s");
		$bidId               =  $this->input->post('bidId');
		$msg =array('msg'=>$this->lang->line('errorInUsersBid'),''); //set default error msg
		
		if(isset($bidId) && !empty($bidId)) {
			//Update users bid
			$updateBid['price']       = $data['price'];
			$updateBid['modifiedDate']=  date("Y-m-d H:i:s");
			$this->model_common->editDataFromTabel('AuctionBids', $updateBid, 'bidId', $bidId);
			$msg =array('msg'=>$this->lang->line('updateUsersBid'),''); //set update msg
		} else {
			//Add users bid
			$insertBid = $this->model_auction->addUserBid($data);
			if(isset($insertBid) && !empty($insertBid)) {
				$msg =array('msg'=>$this->lang->line('addUsersBid'),''); //set insert msg
			}
		}
			
		echo json_encode($msg);
	}
	
	/*
	 * This funciton is used to get bids listing in popup view
	 */
	function bidList() {
		$auctionId = $this->input->get('val1');
		$projectTitle = $this->input->get('val2');
		$limit = 5;
		$perPage = 5;
		//Get users auction bid records count
		$whereAuction = array(
			'auctionId'=>$auctionId										
		);
		$countTotal = countResult('AuctionBids',$whereAuction);

		$pages = new Pagination_ajax;
		$pages->items_total = $countTotal; // this is the COUNT(*) query that gets the total record count from the table you are querying
		$pages->items_per_page=(isset($_REQUEST['ipp']) && $_REQUEST['ipp'] > 0) ? $_REQUEST['ipp']:$perPage;
		$pages->paginate();
		$data['items_total'] = $pages->items_total;
		$data['items_per_page'] = $pages->items_per_page;
		$data['pagination_links'] = $pages->display_pages();	
		$data['countTotal'] = $countTotal;
		if(!empty($projectTitle))
		$data['projectTitle'] = $projectTitle;
		else
		$data['projectTitle'] = '';
		
		$bidList = $this->model_auction->getBidList($pages->limit,$pages->offst,$auctionId);
		if(isset($bidList) && !empty($bidList)){
			$data['bidList'] = $bidList;
		}else {
			$data['bidList'] = '';
		}
		
		if(isset($_POST['ajaxRequest']) && $_POST['ajaxRequest']==1){
			$this->load->view('bidPagingView',$data);
		}else{
			$this->load->view('bidListing',$data);
		}
	}
	
	/*
	 * This function is used to set auctions winner
	 */	
	public function acceptInvitation($userId=0,$invitationKey=0) {
		
		//Check users winning record
		if(isset($userId) && !empty($userId) && isset($invitationKey) && !empty($invitationKey) && $userId==$this->userId) {
			//Get auction winners record
			$where = array('userId'=>$userId,'key'=>$invitationKey);
			$winnerResult = getDataFromTabel('AuctionWinners','*',  $where, '','', '', 1 );
			
			if(is_array($winnerResult) && count($winnerResult)>0) {
				$currentDate = date("Y-m-d");
				$expDate  = date("Y-m-d", strtotime($winnerResult[0]->expDate));
				if($expDate>=$currentDate) {
					$data['invitationStatus'] = 1;
					//Update status of bid winner 
					$winnerRes = $this->model_auction->updateWinnerStatus($data,$winnerResult[0]->winnerId);
					if(isset($winnerRes)) {
						//Get auction record of project
						$auctionBidRes = $this->model_auction->getAuctionsBidRecord($winnerResult[0]->bidId);

						//Set purchase 
						switch($auctionBidRes['entityId']) {
							case 49:
							$purchaseType = 1;
							break;
							default:
							$purchaseType = 1; //set default type as shipping temporary
						}
						
						
						$auctionDate['basePrice'] 	 = $auctionBidRes['price'];
						$auctionDate['price']        = $auctionBidRes['price'];
						$auctionDate['elementId']    = $auctionBidRes['elementId'];
						$auctionDate['entityId']     = $auctionBidRes['entityId'];
						$auctionDate['projId']       = $auctionBidRes['projectId'];
						$auctionDate['sectionId']    = '';
						$auctionDate['ownerId']      = $auctionBidRes['tdsUid'];
						$auctionDate['purchaseType'] = $purchaseType;
						
						//$msg = 'Successfully change invitation status.';
						//set_global_messages($msg, 'success', $is_multiple=true);
						$this->template_front_end->load('template_front_end','buyProject',$auctionDate);	
						//$this->load->view('buyProject');
					}else{
						$msg = 'Error during changes in invitation status.';
						set_global_messages($msg, 'error', $is_multiple=true);
						redirectToNorecord404(); //redirect to no record page
					}
				} else{
					
					$msg = 'Your invitation end date has expired.';
					set_global_messages($msg, 'error', $is_multiple=true);	
					redirectToNorecord404(); //redirect to no record page
				}
			} else {
				$msg = 'Check your invitation link.';
				set_global_messages($msg, 'error', $is_multiple=true);	
				redirectToNorecord404(); //redirect to no record page
			}
		} else {
			$msg = 'Error in your invitation link.';
			set_global_messages($msg, 'error', $is_multiple=true);
			redirectToNorecord404(); //redirect to no record page
		}	
	}
	
	/*
	 * This function is used to send invitation to auction winner
	 */	
	public function sendAuctionInvitation() {
		//Get auction record after finish end date
		$auctionRes = $this->model_auction->getFinalAuctionData();
		
		if(is_array($auctionRes) && count($auctionRes)>0) {
			foreach($auctionRes as $auctionRes) {
				//Get auction expire count
				$whereCount = array('auctionId'=>$auctionRes['auctionId'],'isWinnerExpire'=>'t');
				$countBidResult = countResult('AuctionBids',$whereCount);
				
				if($countBidResult<=5) {
					//Get entity table name 
					$getElementTable = getMasterTableName($auctionRes['entityId']);
					$getElementTable = $getElementTable[0];
					$isTable = true;
					//Set project where clause and fields name
					switch($getElementTable) {
						case 'TDS_Product':
						$projectWhere = array('productId'=>$auctionRes['projectId']);
						$field = 'productTitle';
						break;
						default:
						$isTable = false;
					}
					
					if($isTable == true) {
						//Get project record
						$projectRes   = getDataFromTabel($getElementTable, $field, $projectWhere, '','', '', 1 );
						$projectTitle = $projectRes[0]->$field;
					} else {
						$projectTitle = '';
					}
					//Get max bid of auction
					$getMaxBidRecord = $this->model_auction->getMaxBid($auctionRes['auctionId']);
					
					if(isset($getMaxBidRecord['bidId']) && !empty($getMaxBidRecord['bidId']) && isset($getMaxBidRecord['userId']) && !empty($getMaxBidRecord['userId'])) {
						//get auction winners record if exist
						$existWinnerRes = $this->model_auction->getWinnerData($getMaxBidRecord['bidId'],$getMaxBidRecord['userId']);
						
						if(is_array($existWinnerRes) && !empty($existWinnerRes)) {
							//set current date
							$currentDate = date('Y-m-d H:i:s');
							if($currentDate>$existWinnerRes['expDate'] && $existWinnerRes['invitationStatus']<2) {
								
								//update auction expire status
								$data['modifiedDate']   = $currentDate;
								$data['isWinnerExpire'] = 't';
								$winnerRes = $this->model_auction->updateAuctionBid($data,$getMaxBidRecord['bidId']);
								//Get max bid of auction
								$getMaxBidRecord = $this->model_auction->getMaxBid($auctionRes['auctionId']);
							}
						}
						
						//insert record and send mail to winner
						$winnerRes = $this->setAuctionWinners($getMaxBidRecord['bidId'],$getMaxBidRecord['userId'],$projectTitle);
						echo $winnerRes;
					}
				}
			}
		}
	}
	
	/*
	 * This function is used to set auctions winner
	 */
	public function setAuctionWinners($bidId=0,$userId=0,$projectTitle='') {
		//Get winner record if exist
		$winnerWhere = array('bidId'=>$bidId,'userId'=>$userId);
		$winnerRes = $this->model_common->getDataFromTabel('AuctionWinners', 'winnerId',  $winnerWhere, '', '', '', 1 );
		
		$flag = 0; //set default flag value
		if(empty($winnerRes)) {
			
			$data['bidId']   = $bidId; 
			$data['userId']	 = $userId;
			$data['key']	 = md5(rand().microtime());
			$data['sendDate']= date('Y-m-d H:i:s');
			$data['expDate'] = date('Y-m-d H:i:s', strtotime($data['sendDate']. ' + 7 days'));
			//Insert winners record
			$bidWinnerRes = $this->model_auction->saveAuctionWinners($data);
			
			//Get users email record
			$userWhere = array('tdsUid'=>$data['userId']);
			$userRes = $this->model_common->getDataFromTabel('UserAuth', 'email',  $userWhere, '', '', '', 1 );
			
			if(isset($bidWinnerRes) && !empty($bidWinnerRes) && !empty($userRes[0]->email)) {
				
				/* Set Follow us link*/
				$facebookUrl = $this->config->item('facebook_follow_url');
				$linkedinUrl = $this->config->item('linkedin_follow_url');
				$twitterUrl  = $this->config->item('twitter_follow_url');
				$gPlusUrl    = $this->config->item('google_follow_url');
				$craveUrl    = $this->config->item('crave_us');
				/* while we don't remove restriction (username, password) in .htacess file  from live site*/
				$imageBaseUrl = site_base_url().'images/email_images/';
				
				$msg       = $this->lang->line('setAuctionWinners');
				$fromEmail = $this->config->item('webmaster_email', '');
				$endDate   = date('j F Y', strtotime($data['sendDate']. ' + 7 days'));
				$invitationAcceptUrl = site_url('auction/acceptInvitation/'.$data['userId'].'/'.$data['key']); 
				//Get template record
				$where = array('purpose'=>'auctionwinmail','active'=>1);
				$winnerTemplateRes = getDataFromTabel('EmailTemplates','templates,subject',  $where, '','', '', 1 );
				if(!empty($winnerTemplateRes)) {
					$auctionWinTemplate = $winnerTemplateRes[0]->templates;
					$searchArray = array("{project_title}","{end_date}","{invitation_accept_url}","{image_base_url}","{crave_us}","{facebook_url}","{linkedin_url}","{twitter_url}","{gPlus_url}");
					$replaceArray = array($projectTitle,$endDate,$invitationAcceptUrl,$imageBaseUrl,$craveUrl,$facebookUrl,$linkedinUrl,$twitterUrl,$gPlusUrl);
					$auctionBodyTemplate=str_replace($searchArray, $replaceArray, $auctionWinTemplate);
					$auctionBodySubject=$winnerTemplateRes[0]->subject;
					//Send mail to user
					$this->email->from($fromEmail, $this->config->item('website_name', ''));
					$this->email->to($userRes[0]->email);
					$this->email->subject(sprintf($auctionBodySubject));
					$this->email->message($auctionBodyTemplate);
					$flag = $this->email->send();	
				}
			}
		}
		return $flag;  
	}
    
    //----------------------------------------------------------------------
    
    /*
    *  @description: This method is use to show bid for collection button 
    *  @parram: array
    *  @auther: lokendra meena
    *  @return: string
    */ 
    
    public function bidforcollection($bidCollectionData=false){
        
        if($bidCollectionData){
            
            $projectId       =   $bidCollectionData['projectId'];
            $entityId        =   $bidCollectionData['entityId'];
            $elementId       =   $bidCollectionData['elementId'];
            $sectionId       =   $bidCollectionData['sectionId'];
            $ownerId         =   $bidCollectionData['ownerId'];
            $currencySign    =   $bidCollectionData['currencySign'];
            $sellerCurrency  =   $bidCollectionData['sellerCurrency'];
            $showview        =   $bidCollectionData['showview'];
            $loggedUserId    =   (isLoginUser())?isLoginUser():0;
            
            
            $whereAuction = array('projectId'=>$projectId,'entityId'=>$entityId,'elementId'=>$projectId,'isAuctionClosed'=>'f');
            $auctionData = getDataFromTabel('Auction','*',  $whereAuction, '','', '', 1 ); 
            if(!empty($auctionData[0])) {

                //prepare auction data
                $auctionData     =   $auctionData[0];
                $auctionId       =   (!empty($auctionData->auctionId))?$auctionData->auctionId:0;
                
                //get current bid data 
                $currentBidCondi = array('auctionId'=>$auctionId);
                $currentBidData  = $this->model_common->getDataFromTabel('AuctionBids', 'bidId,price', $currentBidCondi, '', 'bidId', 'DESC', 1);
                
                //Get LoggedIN Users bid data if exist
                $userBidCondi = array('auctionId'=>$auctionId,'userId'=>$loggedUserId);
                $userBidData  = $this->model_common->getDataFromTabel('AuctionBids', 'bidId,price', $userBidCondi, '', 'bidId', 'DESC', 1);
                    
                //Get users auction bid count
                $whereAuction   = array('auctionId'=>$auctionId);
                $userBidCount   = countResult('AuctionBids',$whereAuction);    
                $userBidCount = (!empty($userBidCount))?$userBidCount:0;
                    
                //prepare view data    
                $bidData['auctionData']     = $auctionData;
                $bidData['currentBidData']  = $currentBidData;
                $bidData['userBidData']     = $userBidData;
                $bidData['ownerId']         = $ownerId;
                $bidData['section']         = 'section';
                $bidData['currencySign']    = $currencySign;
                $bidData['sellerCurrency']  = $sellerCurrency;
                $bidData['userBidCount']    = $userBidCount;
                $bidData['loggedUserId']    = $loggedUserId;
                $bidData['elementId']       = $elementId;
                $bidData['projectId']       = $projectId;
                $bidData['showview']        = $showview;
                
                //Load bid button
                $this->load->view('auction/bidPriceButton_New',$bidData);	

            }
        }
    }
    
    
    //----------------------------------------------------------------------
    
    /*
    * @access: public
    * @description: This method is use to show auction bid popup 
    * @return: void
    * @auther: lokendra meena
    */ 
    
    public function bidforcollectionpopup(){
            echo "test";
    }
    
	
}

/* End of file auction.php */
/* Location: ./application/module/auction/controllers/auction.php */
