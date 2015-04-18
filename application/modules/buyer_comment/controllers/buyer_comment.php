<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Buyer_comment extends MX_Controller {
	private $data = array();
	private $userId = null;
	
	/** Constructor **/
	function __construct() {
			
		$load = array(
			
			'model' 	=> 'model_buyer_comment + cart/model_cart',
			 'library' 	=> 'Pagination_new_ajax',
				
		);
		parent::__construct($load);				
		//$this->head->add_css($this->config->item('system_css').'frontend.css');		
		//$this->head->add_css($this->config->item('default_css').'template.css');
		//add advertising module if exists
		if(is_dir(APPPATH.'modules/advertising')){
			$this->load->model(array('advertising/model_advertising'));
		}	
	}

 	
	public function index($userId){
	
	
		if($userId > 0 && isset($userId)){
			
		}else{
			redirect('home');
		}
	
		$showcaseRes=getUserShowcaseId($userId);
		
		/* get User Detail -(Craves , rating and View)  */

		/*
		 $showcaseId=$showcaseRes->showcaseId;
		 $entityId=getMasterTableRecord('UserShowcase');
		
				$this->data['entityId']=$entityId;
				$this->data['showcaseId']=$showcaseId;
		
		$logSummryDta=getDataFromTabel('LogSummary','craveCount,viewCount,ratingAvg,reviewCount',array('entityId'=>$entityId,'elementId'=>$showcaseId), '','','',1);
			if($logSummryDta){
				$logSummryDta=$logSummryDta[0];
				$this->data['craveCount']=$logSummryDta->craveCount;
				$this->data['viewCount']=$logSummryDta->viewCount;
				$this->data['ratingAvg']=$logSummryDta->ratingAvg;
				$this->data['reviewCount']=$logSummryDta->reviewCount;


			}else{
				$this->data['craveCount']=0;
				$this->data['viewCount']=0;
				$this->data['ratingAvg']=0;
				$this->data['reviewCount']=0;
			}
	*/
		////////////////////////////////////////////////////
		
		$Citywhere=array(
						'tdsUid'=>$userId
					);
		$resLogSummary=getDataFromTabel('UserProfile', 'firstName,lastName,cityName',  $Citywhere, '', $orderBy='', '', 1 );
		
		
		
		if($resLogSummary)
		{	
			$cityName = $resLogSummary[0]->cityName;
			$userFullName = ucwords($resLogSummary[0]->firstName.' '.$resLogSummary[0]->lastName);
			
		}else
		{
			$cityName = "";
			$userFullName = "";
		}
		
		$associatedProfessional = $getUserShowcase['associatedProfessional'];
		$enterprise = $getUserShowcase['enterprise'];
		
		if($associatedProfessional=='t'){
			$this->data['headerClass']='bg_Show_enter_asso';
			$this->data['headingClass']='CSEprise_cat Fright clr_3f585f mr13 text_shadow30';
			$this->data['sectionHeading']=$this->lang->line('associatedprofessional'); 
			$this->data['userArea']=$getUserShowcase['userArea'];
			$this->data['enterPriseName']=$userFullName;
			$this->data['countryName']=$getUserShowcase['countryName'];
			$this->data['cityName']=$cityName;
			$this->data['industryType']='associatedprofessionals';
			//$this->associatedprofessionals($userId,$showcaseId);
		}
		elseif($enterprise=='t'){
			$this->data['headerClass']='bg_Show_enter';
			$this->data['headingClass']='CSEprise_cat Fright clr_3e484a mr13';
			$this->data['sectionHeading']=$this->lang->line('enterpriseLower');
			$this->data['userArea']=$getUserShowcase['userArea'];
			$this->data['enterPriseName']=$getUserShowcase['enterpriseName'];
			$this->data['countryName']=$getUserShowcase['countryName'];
			$this->data['cityName']=$cityName;
			$this->data['industryType']='enterprise';
			//$this->enterprises($userId,$showcaseId);
		}else{
			$this->data['headerClass']='bg_Show_enter_dev';
			$this->data['headingClass']='CSEprise_cat Fright clr_484543 mr13';
			$this->data['sectionHeading']=$this->lang->line('creativeLower');
			$this->data['userArea']=$getUserShowcase['userArea'];
			$this->data['enterPriseName']=$userFullName;
			$this->data['countryName']=$getUserShowcase['countryName'];
			$this->data['cityName']=$cityName;
			$this->data['industryType']='creatives';
		}
		
		$limit= (!empty($limit))? $limit :0 ;
		$perPage=2;
		$countTotalArray = $this->model_buyer_comment->get_buyer_comments($userId,0,0);
		
		$countTotal = $countTotalArray['get_num_rows'];
	
		
		
		
		//Paginaation functionality
        $pages                           =  new Pagination_new_ajax;
        $pages->items_total              =  $countTotal; // this is the COUNT(*) query that gets the total record count from the table you are querying
        $this->data['perPageRecord']     =  $this->config->item('perPageRecord');
        
        
         // Add by Amit to set cookie for Results per page
        if($this->input->post('ipp')!=''){
            $isCookie = setPerPageCookie('buyerCommentPerPageVa',$this->data['perPageRecord']);	
        }else {
            $isCookie = getPerPageCookie('buyerCommentPerPageVa',$this->data['perPageRecord']);		
        }
        
        $pages->items_per_page=($this->input->post('ipp') > 0) ? $this->input->post('ipp'):$isCookie ;
        $pages->paginate();
        $this->data['items_total']        =  $pages->items_total;
        $this->data['items_per_page']     =  $pages->items_per_page;
        $this->data['pagination_links']   =  $pages->display_pages();
		$this->data['countTotal'] = $countTotal;	
		$this->data['userId'] = $userId;	
		
		
		$get_buyer_comments = $this->model_buyer_comment->get_buyer_comments($userId,$pages->items_per_page,$pages->offst);
		
		if($get_buyer_comments['get_num_rows'] > 0)
		{	
			foreach($get_buyer_comments['get_result'] as $buyerComments)
			{
				
				
				
					//$getItemTitleImage = $this->model_buyer_comment->getItemTitleImage($buyerComments->entityId,$buyerComments->elementId);
				
				/****************get product  image  start **************/
		
					$sectionWhere = array('itemId'=>$buyerComments->itemId);
					
					$entityId = $buyerComments->entityId;
					$elementId = $buyerComments->elementId;
					$sectionIdDetails=getDataFromTabel('SalesOrderItem', 'sectionId, itemName, sellerInfo, purchaseType',  $sectionWhere, '', $orderBy='', '', 1 );
					
					
					if($sectionIdDetails)
					{
						$sectionIdDetails = $sectionIdDetails[0];											
						$sectionId = $sectionIdDetails->sectionId;
						$itemTitle = $sectionIdDetails->itemName;
						$sellerInfoData = json_decode($sectionIdDetails->sellerInfo);
						$purchaseType = $sectionIdDetails->purchaseType;
						
						
					}else
					{										
						$sectionId = 0;
						$itemTitle = '';
						$sellerInfoData = $sectionIdDetails->sellerInfo;
						$purchaseType = $sectionIdDetails->purchaseType;
					}
				
					//this condition for if purchase type 5
					if($purchaseType=='5')
					{
						$entityId = $sellerInfoData->entityIdPE;
						$elementId = $sellerInfoData->eventORlaunchId;
					}
					
					$geMediaImage = $this->getImageInfo($entityId,$elementId,$sectionId);
					
					/****************get product  image  end **************/
								
				
				$buyerComments->itemImage = $geMediaImage ;
				
				//$buyerComments->get_type = 'file type';
				$buyerComments->get_type = getSectioName($sectionId);
				
				
				$getBuyerShowcase	= showCaseUserDetails($buyerComments->tdsUid);
				
				
				
				
				
				if($getBuyerShowcase['enterprise']=="t")
				{
					$buyerComments->custName = $getBuyerShowcase['enterpriseName'];
				}
				
				
			/*****************get product image end here*********************/	
					
		}
		
		}
		
		//manage advert types if exists
		if(is_dir(APPPATH.'modules/advertising')) {
			//Set advert section id
			$advertSectionId = $this->config->item('buyersCommentsSectionId');				    
		
			//Get banner records based on section and advert type
			$bannerType4 = $this->model_advertising->getBannerRecords($advertSectionId,4,1);
			
			$this->data['advertSectionId'] = $advertSectionId; //set advert section id
			//Load view of advert js functions
			$this->data['advertChangeView'] = $this->load->view('advertising/advertAutoChange',array('bannerType4'=>$bannerType4,'sectionId'=>$advertSectionId),true);	
		} 
		
		/*echo "<pre>";
		
		print_r($get_buyer_comments);die;*/
		
		$this->data['get_buyer_comments']=$get_buyer_comments;
		
		$checkIsView= $this->uri->segment('5');
		 
		//show view if clicked on pagination 
		if($this->input->post('ajaxRequest')){
			$this->load->view('buyer_comment_container',$this->data);
			
		}else
		{
			$this->new_version->load('new_version','view_buyer_comment',$this->data);
		}	
		
	
		
		
	}
	
	
	/* Get Media Type products image */

  function getImageInfo($entityId=0,$elementId=0,$sectionId=0){	

		if( $entityId >0 && $elementId > 0){
			$entity_tableName = getMasterTableName($entityId);
			$tableName= $entity_tableName[0];
			$isTableFound=true;	
			$thumbFolder= 'thumb';		
			switch ($tableName){	
				case 'TDS_Product':				
					$image = $this->model_cart->getProductImage($elementId);						
				break;
				
				case 'TDS_Project':
					$imagePath = 'projBaseImgPath as imagepath';					
					$whereId = 'projId';
					
					$selectfields =$imagePath;			
				    $where = array($whereId=>$elementId);
				    $getImage = $this->model_cart->getMediaImage($tableName,$selectfields,$where);	
				    /********make element image as project image code add********/
				    if(empty($getImage)){
						$image = getElementImageByType($elementId,$sectionId);
					}else{
						$image = $getImage;
					}	
					/********make element image as project image code add********/				    																		
					break;							
								
				case 'TDS_EmElement':
				case 'TDS_FvElement':
				case 'TDS_MaElement':			
				case 'TDS_WpElement':
					//$owner = 'tdsUid';
					$imagePath = 'imagePath as imagepath';					
					$whereId = 'projId';
					
					//$selectfields =$imagePath.','.$owner;	
					$selectfields =$imagePath;				
					$where = array($whereId=>$elementId);
					$image = $this->model_cart->getMediaImage($tableName,$selectfields,$where);	
					/********make video capture image as element image code add********/
						if($tableName=="TDS_FvElement"){
							if(empty($image)){
								$image = getProjectElementImage(0,$entityId,$elementId);
							}
						}
					/********make video capture image as element image code add********/											
				    break;
				    
				case 'TDS_WpElement':
					//$owner = 'tdsUid';
					$imagePath = 'imagePath as imagepath';					
					$whereId = 'projId';
					
					//$selectfields =$imagePath.','.$owner;				
					$selectfields =$imagePath;				
					$where = array($whereId=>$elementId);
					$image = $this->model_cart->getMediaImage($tableName,$selectfields,$where);											
				    break;
				
				case 'TDS_PaElement':
					$image = $this->model_cart-> getPnArtImage($tableName,'elementId',$elementId ,'fileId');
					$thumbFolder= 'watermark';		
				break;
				
				case 'TDS_Events':
					$eventImage = $this->model_cart-> getPnArtImage($tableName,'EventId',$elementId ,'FileId');
					if(!empty($eventImage) && file_exists($eventImage)) {
						$image = $eventImage;
					} else {
						$getProjectImage = getEventsPrimaryImage($elementId,'.eventId');
						if($getProjectImage){
							$image = $getProjectImage;
						}else{
							$image = '';				
						}
					}
				break;
				
				case 'TDS_LaunchEvent':
					$launchImage = $this->model_cart-> getPnArtImage($tableName,'LaunchEventId',$elementId ,'FileId');
					if(!empty($launchImage) && file_exists($launchImage)) {
						$image = $launchImage;
					} else {
						$getProjectImage = getEventsPrimaryImage($elementId,'.launchEventId');
						if($getProjectImage){
							$image = $getProjectImage;
						}else{
							$image = '';				
						}
					}
				break;				
				
				default:
					 $image = '';
				break;					
					
			}
						
		}
	
	$section=str_replace(':','_',$sectionId);
	
	if($this->config->item('sectionImage'.$section)){
		$imageType=$this->config->item('sectionImage'.$section);
	}else{
		$imageType=$this->config->item('sectionIdImage'.$section);
	}
	$imageType='images/default_thumb/'.$imageType;
	
	if(is_array($image)){
		$image = $image['filePath'];
	}else{
		if( $image !=''){
			$image=addThumbFolder($image,$suffix='_xs',$thumbFolder,$imageType); 
		} 	
		$image=getImage($image,$imageType);	
	}
	
	return $image;	  
	  
  }
	
	 
	 
	 


} 
