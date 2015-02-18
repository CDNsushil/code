<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Todasquare upcomingproject Controller Class
 *
 *  Manage upcomingproject details (Posts,Comments,Published/Unpublished,Archived/Unarchived,Insert/Update etc)
 *  @package	Toadsquare
 *  @subpackage	Module
 *  @category	Controller
 *  @author		Sapna Jain
 *  @link		http://toadsquare.com/
 */

class upcomingprojects extends MX_Controller {
	private $userId = NULL;
	private $data = array();
	private $mediaPath = '';
	private $dirCacheUpcoming = '';
	private $upcomingProjectMediaTableName = 'UpcomingProjectMedia';
	private $upcomingProjectTableName = 'UpcomingProject';

	private $promoImageField = array('mediaId',
			'mediaType',
			'mediaTitle',
			'mediaDescription',
			'fileId',
			'projId',
			'isMain');
	/**
	 * Constructor
	**/
	function __construct(){
	  //My own constructor code
	  $load = array(
			'model'		=> 'model_upcomingprojects',
			'library' 	=> 'form_validation + upload + session + Lib_upcomingprojects + Lib_upcomingprojectsImages + Lib_masterMedia + lib_sub_master_media + lib_image_config',
			'language' 	=> 'upcomingprojects',
			'helper' 	=> 'form + file'			
	  );
	parent::__construct($load); 
	$this->userId= $this->isLoginUser();
	$this->dirCacheUpcoming = 'cache/upcoming/';  
	$this->mediaPath = "media/".LoginUserDetails('username')."/upcomingProjects/" ;
	$cmd = 'chmod -R 777 $this->mediaPath';
	exec($cmd);
	//$this->head->add_js(base_url().'templates/frontend/js/jquery.pagegalery.1.0.min.js');
		
	}

	/**
	 * Index fucntion by default call when module get initialised
	 *
	 * by default call fetchs the upcommingproject data 
	 *
	 * @access	public
	 * @param	null
	 * @return	array
	**/

	function index($isArchive='f')
	{
		$userId = $this->userId;
		$data['userNavigations']=$userNavigations=$this->model_common->userNavigations($this->userId,false);
		
		if(isset($userNavigations) && is_array($userNavigations) && count($userNavigations) > 0 &&(in_arrayr( 'upcoming', $userNavigations, $key='section', $is_object=0 ))){ 
			
		}else{
			redirect('dashboard/upcoming');
		}
		if($isArchive !== 't'){$isArchive='f' ;}
		
		$this->data['isArchive']=$isArchive;
		$this->data['entityId']= getMasterTableRecord('UpcomingProject');
		
		
		$this->data['countResult']=$this->model_common->countResult('UpcomingProject',array('tdsUid'=>$userId,'projArchived'=>$isArchive));
		
		$pages = new Pagination_ajax;
		$pages->items_total = $this->data['countResult']; // this is the COUNT(*) query that gets the total record count from the table you are querying
		$this->data['perPageRecord'] =$this->config->item('perPageRecordUpcoming');
		//$pages->items_per_page=(isset($_REQUEST['ipp']) && $_REQUEST['ipp'] > 0) ? $_REQUEST['ipp']:$this->data['perPageRecord'];		
		
		// Add by Amit to set cookie for Results per page
		if($this->input->post('ipp')!=''){
			$isCookie = setPerPageCookie('upcomingPerPageVal',$this->data['perPageRecord']);	
		}else {
			$isCookie = getPerPageCookie('upcomingPerPageVal',$this->data['perPageRecord']);		
		}
					
		$pages->items_per_page=($this->input->post('ipp') > 0) ? $this->input->post('ipp'):$isCookie ;		
		
		$pages->paginate();
		$this->data['items_total'] = $pages->items_total;
		$this->data['items_per_page'] = $pages->items_per_page;
		$this->data['pagination_links'] = $pages->display_pages();
		
		$data = $this->lib_upcomingprojects->getValuesFromDB($userId,0,1,$isArchive,$pages->offst,$pages->limit); //Fetch all the record from upcoming 
		$this->data['recodrSetUpcomingProejct'] = $data;
		
		if(!is_dir($this->dirCacheUpcoming)){
				@mkdir($this->dirCacheUpcoming, 777, true);
		}
			
		$cmd3 = 'chmod -R 777 '.$this->dirCacheUpcoming;
		exec($cmd3);
				
		foreach($this->data['recodrSetUpcomingProejct'] as $pcount => $upcomingDetail)
		{			
			$cacheFileupcoming = $this->dirCacheUpcoming.'upcoming_'.$upcomingDetail['projId'].'_'.$userId.'.php';
			
			if(!is_file($cacheFileupcoming))
			{							
			
			$dataupcoming = str_replace("'","&apos;",json_encode($upcomingDetail));	//encode data in json format			
			$stringDataupcoming = '<?php $ProjectData=\''.$dataupcoming.'\';?>';
				
				if (!write_file($cacheFileupcoming, $stringDataupcoming)){					// write cache file
					echo 'Unable to write the file';
				}
				
			}
		}
		$this->data['label']=$this->lang->language;
		$this->data['userId']=$userId;		

		
		//Load Listing file
		$ajaxRequest = $this->input->post('ajaxRequest');
		if($ajaxRequest){
			 $this->load->view('upcoming_listing',$this->data) ;
		}			   
		else{
			$this->data['header'] = $this->load->view('navigationMenu',$this->lib_upcomingprojects->keys,true);
			//$this->template->load('template','upcomingProjectsListing',$this->data); 
			
			$leftData=array(
							'welcomelink'=>base_url(lang().'/dashboard/upcoming'),
							'isDashButton'=>true,
							'isUpcomingTool'=>1
				  );
			$leftView='dashboard/help_upcoming';
			$this->data['leftContent']=$this->load->view($leftView,$leftData,true);
			
			$this->template->load('backend_template','upcomingProjectsListing',$this->data);
		}	  
	}

	function deletedItems()
	{
		$this->index($isArchive='t');	  
	}

	/**
	*	Function to render form for New project
	*   Very frist this function get calld the render entry form for new project
	*
	* @Access Public
	**/

	function newupcomingprojects($projId='')
	{
		$showForEvent_Class = '';		
		$userId = $this->userId;
		//If upcoming record not exist then redirect to nofound page
		if(isset($projId) && $projId >0 && isset($userId)){
			$userDataWhere = array('projId'=>$projId,'tdsUid'=>$userId);
			checkUsersProjects('UpcomingProject',$userDataWhere);
		}	
				
		$entityId = getMasterTableRecord('UpcomingProject');
		$upcominDataListing = $this->lib_upcomingprojects->getValuesFromDB($userId,0,1,'f','','');	
		$upcominDataCount = count($upcominDataListing);
		if($this->input->post('save')=="Save")
		{
			$dataSetValue = $this->lib_upcomingprojects->setValues($this->input->post());
			$data= $this->lib_upcomingprojects->getValues();
			
			$data['projUpType'] = $this->input->post('projUpType');
			
			if($this->input->post('isEducationMaterial')=="accept")
			{
				$data['isEducationMaterial']='t';
			}
			else 
			{
				$data['isEducationMaterial']='f';
			}

			if($this->input->post('isEvent')=="accept"){
				$data['isEvent']='t';
			} else {
				$data['isEvent']='f';
			}
			if($this->input->post('projType')=="other"){
				$data['projType'] = 0;
				$data['projTypeOther'] = $this->input->post('projTypeOther');
				$data['projGenreOther'] = $this->input->post('projGenreOther');
			} else {
				$data['projType'] = $this->input->post('projType');
			}

			if($this->input->post('askForDonation')=="accept"){
				$data['askForDonation']='t';
			} else {
				$data['askForDonation']='f';
			}
			$data['tdsUid'] =   $this->userId;

			$data['projRating'] =   '1';
			$data['projStatus'] =   '1';
			
			
			$projReleaseDate=$this->input->post('projReleaseDate');
			$data['projReleaseDate']=date('Y-m-d',strtotime($projReleaseDate));
			
			//Temp change
				unset($data['projGenreFree']);
				//unset($data['projZip']);
				unset($data['projStreet']);
				//unset($data['projAddress']);
				unset($data['projGenreFree']);
				unset($data['projType']);
				unset($data['projTypeOther']);
				unset($data['projCategory']);
				$data['isPublished']='f';
				
			if($projId > 0) {
				//Edit mode
				unset($data['projCreateDate']);
				unset($data['projPublisheDate']);
				unset($data['projEntryTime']);
				$upcomingprojId = $this->lib_upcomingprojects->save($data);
				$msg = $this->lang->language['upcomingProjectUpdatedSuccessfully'];
			}else {
				//Insert mode
				
				$sectionId=$this->config->item('upcomingSectionId');
				$userContainerId=$this->lib_package->getUserContainerId($sectionId);
				$data['userContainerId'] = $userContainerId;
				
				unset($data['projId']);
				$data['projCreateDate'] =   date("Y-m-d H:i:s");
				$data['projPublisheDate'] =   date("Y-m-d H:i:s");
				$data['projEntryTime'] =   date("Y-m-d H:i:s");
				
				$upcomingprojId = $this->lib_upcomingprojects->save($data);
				if($upcomingprojId > 0){
					$this->lib_package->updateUserContainer($userContainerId,$entityId,$upcomingprojId,$sectionId,$sectionId);
				}
				//Deleted to get created again wioth updated values from DB
				
				$cacheFileupcoming = $this->dirCacheUpcoming.'upcoming_'.$upcomingprojId.'_'.$userId.'.php';
					
				if(is_file($cacheFileupcoming)){
					@unlink($cacheFileupcoming);
				}
				
				$msg = $this->lang->language['upcomingProjectSavedSuccessfully'];
			}		
			//echo 'upcomingprojId:'.$upcomingprojId;die;
				
		if($upcomingprojId>0)
		{
			
			$cacheFileupcoming = $this->dirCacheUpcoming.'upcoming_'.$upcomingprojId.'_'.$userId.'.php'; 			
			$upcomingtoWritedata = $this->model_upcomingprojects->getupcomingdetail($userId,$upcomingprojId);			
			
			if($upcomingtoWritedata && is_array($upcomingtoWritedata) && count($upcomingtoWritedata) > 0)
			{
				
				$entityId = getMasterTableRecord('UpcomingProject');					
				$upcomingData = $upcomingtoWritedata[0];
				
				$enterpriseName=pg_escape_string($upcomingData['enterpriseName']);
				$enterpriseName=trim($enterpriseName);
				$creative_name=($upcomingData['enterprise']=='t')?$enterpriseName:pg_escape_string($upcomingData['firstName'].' '.$upcomingData['lastName']);
				
				$searchDataInsert=array(
						"entityid"=>$entityId,
						"elementid"=>$upcomingData['projId'],
						"projectid"=>$upcomingData['projId'],
						"sectionid"=>$upcomingData['projIndustry']>0?$upcomingData['projIndustry']:0, 
						"section"=>'upcoming',
						"ispublished"=>$upcomingData['isPublished']=='t'?'t':'f',
						"cachefile"=>$cacheFileupcoming,
						"item.title"=>pg_escape_string($upcomingData['projTitle']), 
						"item.tagwords"=>pg_escape_string($upcomingData['projTag']), 
						"item.online_desctiption"=>pg_escape_string($upcomingData['proShortDesc']),
						"item.userid"=>$this->userId, 
						"item.self_ratingid"=>$upcomingData['rating']>0?$upcomingData['rating']:0,  
						"item.self_rating"=>$upcomingData['rating'], 
						"item.creative_name"=>$creative_name, 
						"item.creative_area"=>pg_escape_string($upcomingData['optionAreaName']),
						"item.languageid"=>$upcomingData['projLanguage']>0?$upcomingData['projLanguage']:0,  
						"item.language"=>$upcomingData['Language_local'],
						"item.countryid"=>$upcomingData['projCountry']>0?$upcomingData['projCountry']:0, 
						"item.country"=>$upcomingData['countryName'], 
						"item.industryid"=>$upcomingData['projIndustry']>0?$upcomingData['projIndustry']:0, 
						"item.industry"=>$upcomingData['IndustryName'], 
						"item.sell_option"=>'free',
						"item.creation_date"=>$upcomingData['projCreateDate'], 
						"item.publish_date"=>$upcomingData['projReleaseDate'] != '' ? $upcomingData['projReleaseDate']:$upcomingData['projCreateDate']
						
					);
					$this->model_common->addUpdateDataIntoObject('search', $searchDataInsert);
			}
			
			if(!is_dir($this->dirCacheUpcoming)){
				@mkdir($this->dirCacheUpcoming, 777, true);
			}
			
			$cmd3 = 'chmod -R 777 '.$this->dirCacheUpcoming;
			exec($cmd3);
			
			$dataupcoming = str_replace("'","&apos;",json_encode($upcomingtoWritedata));	//encode data in json format			
			$stringDataupcoming = '<?php $ProjectData=\''.$dataupcoming.'\';?>';
				
				if (!write_file($cacheFileupcoming, $stringDataupcoming)){					// write cache file
					echo 'Unable to write the file';
				}
				
		}
		//Set isShowcasePopup session
		if($upcominDataCount==0){
			$this->session->set_userdata('isShowUpcomingPopup',1);
		}
			set_global_messages($msg, 'success');
			redirect("upcomingprojects/newupcomingprojects/".$upcomingprojId);
		}
		
		
		if($projId > 0)
		{
			$data = $this->lib_upcomingprojects->getValueToUpdate($projId); // Set the Value of the record in the SetValues to make a recordset.
			
			if($this->lib_upcomingprojects->keys['projUpType']=='3')
				$isMediaIndustry = 't';
			else
				$isMediaIndustry = ''; 
			
			if($this->lib_upcomingprojects->keys['projUpType']=='2')
				$showForEvent_Class = '';
			else
				$showForEvent_Class = 'dn'; 
				
			$industry = loadIndustry($isMediaIndustry);
			
			$this->data['industry'][''] =  $this->lang->language['selectIndustry'];
			
			foreach ($industry as $resultIndustry)
			{
				$this->data['industry'][$resultIndustry->IndustryId] = $resultIndustry->IndustryName;
			}
			$this->lib_upcomingprojects->keys['mode'] = 'edit';
		}else
		{
			$this->data['sectionId']=$sectionId=$this->input->post('sectionId');
			$this->lib_package->setUserContainerId($sectionId);
			
			
		
		$this->lib_upcomingprojects->keys['mode'] = 'new';
		
		$isMediaIndustry = 't';
		
		$industry = loadIndustry($isMediaIndustry);
		
		$this->data['industry'][''] =  $this->lang->language['selectIndustry'];
		
			foreach ($industry as $resultIndustry)
			{
				$this->data['industry'][$resultIndustry->IndustryId] = $resultIndustry->IndustryName;
			}
		}
		
		//FOR CREATING THE RATING DROP DOWN
		$ratingList = getRatingList();
		
		$this->lib_upcomingprojects->keys['ratingList'] = $ratingList;
		$this->lib_upcomingprojects->keys['industry'] = $this->data['industry'];
		$this->lib_upcomingprojects->keys['showForEvent_Class'] = $showForEvent_Class;
		
		$this->lib_upcomingprojects->keys['language'] = getlanguageList();
		$this->lib_upcomingprojects->keys['location'] = getCountryList();
		$this->lib_upcomingprojects->keys['entityId'] = getMasterTableRecord($this->upcomingProjectTableName);
		
		$this->lib_upcomingprojects->keys['label']=$this->lang->language;
		$this->lib_upcomingprojects->keys['header']=$this->load->view('navigationMenu',$this->lib_upcomingprojects->keys,true);
		
		//$this->lib_upcomingprojects->keys['upcomingDataCount'] = $upcominDataCount;
		//$this->template->load('template','addNewUpcomingProject', $this->lib_upcomingprojects->keys); 
	
		$leftData=array(
						'welcomelink'=>base_url(lang().'/dashboard/upcoming'),
						'isDashButton'=>true,
						'isUpcomingTool'=>1
			  );
		$leftView='dashboard/help_upcoming';
		$this->lib_upcomingprojects->keys['leftContent']=$this->load->view($leftView,$leftData,true);
		
		$this->template->load('backend_template','addNewUpcomingProject',$this->lib_upcomingprojects->keys);
	}

	public function projectPromotionalImages($projId=0)
	{		
		$this->head->add_css($this->config->item('system_css').'upload_file.css');
		$this->head->add_js($this->config->item('system_js').'jquery-upload/plupload.js');
		$this->head->add_js($this->config->item('system_js').'jquery-upload/plupload.html5.js');
		$this->head->add_js($this->config->item('system_js').'jquery-upload/plupload.flash.js');
		$ImgConfig = $this->lib_image_config->getImgConfigValue();
		$eventFurtherDesc['title']='';
		
		//Redirect if user is trying to access project of another user
		if(isset($projId) && $projId >0 && isset($this->userId)){
			$userDataWhere = array('projId'=>$projId,'tdsUid'=>$this->userId);
			checkUsersProjects('UpcomingProject',$userDataWhere);
		}	
		
		
		
		$formType = $this->input->post('formtype');
		//To make default display for accordin none,display mode get changed on saving 
		if(strcmp($formType,'promoImage')==0){
			$eventFurtherDesc['promoDisplayStyle'] = 'style="display:block;"';
		}
		else{
			$eventFurtherDesc['promoDisplayStyle'] = 'style="display:none;"';
		}
			
		
		$this->data['projId'] = $projId;
		$this->data['projId'] = $this->input->post('EntityId')>0?$this->input->post('EntityId'):$this->data['projId'];//Checks if eventId is set or not
		$imagePath = $this->mediaPath.$this->data['projId'].'/images/';
		$filePath = $this->mediaPath.$this->data['projId'].'/';
		$audioPath = $this->mediaPath.$this->data['projId'].'/audio/';
		$videoPath = $this->mediaPath.$this->data['projId'].'/video/';
		$textPath = $this->mediaPath.$this->data['projId'].'/text/';
		$eventFurtherDesc['label'] = $this->lang->language;
		
		//To make directory and set permission
		if(!is_dir($imagePath)){
				if (!mkdir($imagePath,0777, true)) {
					die('Failed to create folders...');
				}
			}
		$cmd = 'chmod -R 777 '.$imagePath;
		exec($cmd);
		
		
		if($this->data['projId']>0)
		{			
			$upcomingPromotionalImages['count'] =  $this->lib_sub_master_media->countPromotionMedia($this->upcomingProjectMediaTableName,'projId',$this->data['projId'],'1','');

			if(strcmp($this->input->post('submit'),'Save')==0)
			{				
				$fileType = $this->input->post('fileType');
				$promoMediaFieldValues['mediaId'] = $this->input->post('mediaId');
				$promoMediaFieldValues['mediaTitle'] = $this->input->post('mediaTitle');
				$promoMediaFieldValues['mediaDescription'] = $this->input->post('mediaDescription');
				$promoMediaFieldValues['mediaType'] = $fileType;
				$promoMediaFieldValues['projId'] = $this->data['projId'];				
				
				if(!is_dir($this->mediaPath)){
					mkdir($this->mediaPath, 777, true);
				}
				$cmd1 = 'chmod -R 777 '.$this->mediaPath;
				exec($cmd1);
				
				if(!is_dir($this->mediaPath.$this->data['projId'])){
					mkdir($this->mediaPath.$this->data['projId'], 777, true);
				}
				$cmd2 = 'chmod -R 777 '.$this->mediaPath.$this->data['projId'];
				exec($cmd2);
				
				if(!is_dir($this->mediaPath.$this->data['projId'].'/images/')){
					mkdir($this->mediaPath.$this->data['projId'].'/images/', 777, true);
				}
				$cmd3 = 'chmod -R 777 '.$this->mediaPath.$this->data['projId'].'/images/';
				exec($cmd3);
				
				if(!is_dir($imagePath)){
					mkdir($imagePath, 777, true);
				}
				$cmd = 'chmod -R 777 '.$imagePath;
				exec($cmd);

				if($promoMediaFieldValues['mediaId'] > 0){
					$promoMediaFieldValues['isMain'] = $this->input->post('isMain');
					}
				else if($eventFurtherDesc['count'] <=0){
					$promoMediaFieldValues['isMain'] = 't';
				}
				else
				{
					$promoMediaFieldValues['isMain'] = 'f';
				}
				$returnUrl = "upcomingprojects/projectPromotionalImages/".$this->data['projId'];
				//echo $returnUrl; die;
				$uploadArray = $_FILES;

				saveUploadPromoMedia($this->upcomingProjectMediaTableName,$this->promoImageField,$promoMediaFieldValues,$imagePath,$uploadArray,$this->data['projId'],$fileType,$returnUrl,$ImgConfig);
				redirect("upcomingprojects/projectPromotionalImages/".$this->data['projId']);
			}
			
			$orderBy = 'isMain';
			
			//New code start			
			$upcomingPromotionalImages['mediaType'] = $ImgConfig['mediaConfig']['mediaType'];
			$upcomingPromotionalImages['eventPromoImages']['listValues'] = $this->lib_sub_master_media->entitypromotionmedialist($this->upcomingProjectMediaTableName,$this->promoImageField,'projId',$projId,1,$orderBy,'');//we pass the table name,defined fields of given table, the filename on the basis which want to fetch the listing records,MediaType and orderBy clause
			
			$upcomingPromotionalImages['promoElementTable'] = $this->upcomingProjectMediaTableName;
			$upcomingPromotionalImages['projId'] = $projId;
			$upcomingPromotionalImages['entityMediaType'] = '';
			$upcomingPromotionalImages['header'] = $this->load->view('navigationMenu',$upcomingPromotionalImages,true);
			
			$upcomingPromotionalData['promoElementTable'] = $this->upcomingProjectMediaTableName;
			$upcomingPromotionalData['promoElementFieldId'] = 'mediaId';
			
			$upcomingPromotionalData['promoImageId'] = $projId;
			$upcomingPromotionalData['promoImagePath'] = $imagePath;
			$upcomingPromotionalData['filePath'] = $filePath;
			$upcomingPromotionalData['audioPath'] = $audioPath;
			$upcomingPromotionalData['videoPath'] = $videoPath;
			$upcomingPromotionalData['textPath'] = $textPath;
			
			$upcomingPromotionalImages['label'] = $this->lang->language;
			$upcomingPromotionalImages['makeFeatured'] = 1;
			$upcomingPromotionalImages['eventPromoImages']['defaultImage'] = $this->config->item('defaultUpcomingImg_s');
			$upcomingPromotionalData['upcomingPromotionalImages'] = $upcomingPromotionalImages;
			//print_r($workPromotionalImages);
			
			$upcomingPromotionalData['promoElementTable']=$this->upcomingProjectMediaTableName;
			$upcomingPromotionalData['promoElementFieldId']='mediaId';
			$upcomingPromotionalData['promoImagePath'] = $imagePath;
			$upcomingPromotionalData['entityId'] = $projId;
			$upcomingPromotionalData['promoEntityField'] = 'projId';
			$upcomingPromotionalData['browseImgJs'] = '_imgJs';	
			$upcomingPromotionalData['entityMediaType'] = '';
			
			
			$fileMaxSize=$this->config->item('defaultContainerSize');
			$upcomingPromotionalData['containerDetails'] = $this->model_common->getContainerDetails('UpcomingProject',array('projId'=>$this->data['projId']));
			if(isset($productPromotionalData['containerDetails'][0]['containerSize']) && $productPromotionalData['containerDetails'][0]['containerSize'] > 0 ){
				$containerSize=$productPromotionalData['containerDetails'][0]['containerSize'];
				
				$dirname=$this->mediaPath;
				$dirSize=getFolderSize($dirname);
				$remainingBytes =($containerSize - $dirSize);
				if(!$remainingBytes > 0){
					$remainingBytes =0;
				}
				
				$containerSize=bytestoMB($containerSize,'mb');
				
				$dirSize=bytestoMB($dirSize,'mb');
				$remainingSize=($containerSize-$dirSize);
				if($remainingSize < 0){
						$remainingSize = 0;
				}
				$dirSize = number_format($dirSize,2,'.','');
				$remainingSize = number_format($remainingSize,2,'.','');
				$fileMaxSize=$remainingBytes;
			}
			$upcomingPromotionalData['fileMaxSize']= $fileMaxSize;
			$upcomingPromotionalData['userId'] = $this->userId;
			
			$this->config->set_item("projectPromotionalImages", $this->lang->line('promotionalMaterial'), $index="replacer");
			//$this->template->load('template','upcomingProjectPromotionalImages',$upcomingPromotionalData);
			$leftData=array(
							'welcomelink'=>base_url(lang().'/dashboard/upcoming'),
							'isDashButton'=>true,
							'isUpcomingTool'=>1
				  );
			$leftView='dashboard/help_upcoming';
			$upcomingPromotionalData['leftContent']=$this->load->view($leftView,$leftData,true);
			
			$this->template->load('backend_template','upcomingProjectPromotionalImages',$upcomingPromotionalData);
			
		} else { 
			$msg =  $this->lang->language['enterUpcomingProject'];
			set_global_messages($msg, 'error');
			redirect("upcomingprojects/newupcomingprojects");
		}
		
	}


	public function addPromotionalVideo($projId=0)
	{		
		$this->data['File'] = '';
		$this->lib_upcomingprojectsimages->keyimages['projId'] = $projId;

		if($projId > 0){
			$projectPromotionMedia = $this->lib_sub_master_media->countPromotionMedia($this->upcomingProjectMediaTableName,'projId',$projId,'1','flag');
			
			$orderBy = '';
			$eventFurtherDesc['eventPromoImages']['listValues'] = $this->lib_sub_master_media->entitypromotionmedialist($this->upcomingProjectMediaTableName,$this->promoImageField,'projId',$projId,1,$orderBy,'flag');
			//echo 'event promo images:'.$this->db->last_query();die;
			$this->data['projectPromotionVideo'] = $eventFurtherDesc['eventPromoImages']['listValues'];
			
			$updateMediaId = $this->input->post('mediaId');
			
			$this->data['videoPath'] = $this->mediaPath.$projId.'/video/';
			$this->data['audioPath'] = $this->mediaPath.$projId.'/audio/';
			$this->data['documentsPath'] = $this->mediaPath.$projId.'/documents/';
			$this->data['elementTable'] = $this->upcomingProjectMediaTableName;
			$this->data['elementFieldId'] = 'mediaId';
			$this->data['totalMediaFile'] = $projectPromotionMedia;
			$this->data['label'] = $this->lang->language;
			$this->lib_upcomingprojectsimages->keyimages['label'] = $this->lang->language;
			$this->data['header']=$this->load->view('navigationMenu',$this->lib_upcomingprojectsimages->keyimages,true);
		
			$this->load->view('upcomingProjectPromotionalVideo',$this->data);
			//$this->template->load('template','upcomingProjectPromotionalVideo',$this->data);
		}else{
			$msg = $this->lang->language['enterUpcomingProject'];
			set_global_messages($msg, 'error');
			redirect("upcomingprojects/newupcomingprojects");
		}
	}
	
	
	function uploadMediaView()
	{		
		$mediaType = $this->input->post('val1');
		$fileSize = $this->input->post('val2');
		$fileType = $this->input->post('val3');
		$filePath = $this->input->post('val4');
		$isEmbed = $this->input->post('val5');
		$embedPath = $this->input->post('val6');
		$browseId = $this->input->post('val7')?$this->input->post('val7'):'';
		
		if($mediaType !=2) $showEmbed = 1;
		else  $showEmbed = 0;
		
		//$data = array('fileType'=>$fileType,'fileMaxSize'=>$fileSize,'isEmbed'=>$isEmbed,'fileName'=>'','fileSize'=>$fileSize,'filePath'=>$filePath,'embedCode'=>$embedPath, 'label'=>$this->lang->line('file'), 'view'=>'uploadFileForm','flag'=>$showEmbed);
		if($mediaType==1) $mediaTypeToShow = 1;
		if($mediaType==2) $mediaTypeToShow = 2;
		if($mediaType==3) $mediaTypeToShow = 3;
		if($mediaType==4) $mediaTypeToShow = 4;
		$data = array('browseId'=>$browseId,'fileType'=>$fileType,'fileMaxSize'=>$fileSize,'isEmbed'=>$isEmbed,'fileName'=>'','required'=>'required','fileSize'=>$fileSize,'filePath'=>$filePath,'embedCode'=>$embedPath, 'label'=>$this->lang->line('file'),'view'=>'uploadFileForm','flag'=>$showEmbed,'editFlag'=>false,'mediaTypeToShow'=>$mediaTypeToShow,'nouploader'=>0);
		//echo '<pre />';
		//print_r($data);
		echo Modules::run("common/formInputField",$data);
	}
	
	public function deleteUpcomingProejct()
	{
		$projId =  $this->input->post('projId');

		/*$idArray = array();
		$getPathDetail =  $this->model_upcomingprojects->getDetailToDelete($projId);

		$this->model_upcomingprojects->deleteUpcomingProejctMedia($projId);

		if(!empty($getPathDetail)){
			foreach($getPathDetail as $fileDetail)
			{
				$this->model_upcomingprojects->deleteTest($fileDetail);
			}
		}*/
		$cacheFileupcoming = $this->dirCacheUpcoming.'upcoming_'.$projId.'_'.$this->userId.'.php';
					
		if(is_file($cacheFileupcoming)){
			@unlink($cacheFileupcoming);
		}
				
		$this->model_upcomingprojects->deleteUpcomingProejct($projId);
		
		$entityId=getMasterTableRecord('UpcomingProject');
		if($projId > 0 && $entityId > 0){
			$whereField=array('entityid'=>$entityId,'elementid'=>$projId);
			$res=$this->model_common->getDataFromTabel('search', 'id',  $whereField, '', '', '', $limit=1 );
			if($res){
				$id=$res[0]->id;
				if($id > 0){
					$this->model_common->deleteRow('search',$where=array('id'=>$id));
				}
			}
		}

		//@rmdir($this->mediaPath.$projId);
		// to delete the Folder of images
		
		//delete_directory($this->mediaPath.$projId);

		$message = $this->lang->language['upcomingProjectDeletedSuccessfully'];
		set_global_messages($message, 'success');
		redirect("upcomingprojects");
	}

	function do_upload($imageFile,$projId,$mediaType=1)
	{
		$data = '';

		if($mediaType==1){
			$mediaType = 'images';
			$config['allowed_types'] = $this->config->item('imageAccept');
			$config['remove_spaces']= TRUE;
		}else if($mediaType==2){
			$mediaType = 'video';
			$config['allowed_types'] 	= $this->config->item('videoAccept');
			$config['max_size']		=  $this->config->item('videoSize');
		}else if($mediaType==3){
			$mediaType = 'audio';
			$config['allowed_types'] 	= $this->config->item('audioAccept');
		}else if($mediaType==4){
			$mediaType = 'documents';
			$config['allowed_types'] 	= $this->config->item('writtenMaterialAccept');
		}else {
			$mediaType = 'images';
			$config['allowed_types'] = $this->config->item('imageAccept');
			$config['remove_spaces']= TRUE;
		}

		$mediaPath = $this->mediaPath.$projId.'/'.$mediaType.'/';
		if(!is_dir($mediaPath)){
			mkdir($mediaPath, 0777, true);
		}

		$_FILES['userfile']['name']     = $imageFile['userfile']['name'];
		$_FILES['userfile']['type']     = $imageFile['userfile']['type'];
		$_FILES['userfile']['tmp_name'] = $imageFile['userfile']['tmp_name'];
		$_FILES['userfile']['error']    = $imageFile['userfile']['error'];
		$_FILES['userfile']['size']     = $imageFile['userfile']['size'];

		$this->upload->initialize($config);
		$this->upload->set_upload_path($mediaPath);
		$this->load->library('my_upload', $config);
		if (!$this->upload->do_upload()){
			$data = array('error' => $this->upload->display_errors());
		}
		else{
			$data = array('upload_data' => $this->upload->data());
		}
		return $data;
	}

	function deletePromotionMedia($mediaId, $projId)
	{
		$this->model_upcomingprojects->deleteMedia($mediaId, $projId);
		$message = $this->lang->language['upcomingProjectSupportedMediaDeletedSuccessfully'];
		set_global_messages($message, 'success');
		redirect("upcomingprojects/addPromotionalVideo/".$projId);
	}

	public function previewupcomingprojects($projId)
	{
		$this->lib_upcomingprojects->getValueToUpdate($projId);
		$data = $this->lib_upcomingprojects->getValues();
		$data['label']=$this->lang->language;
		$isAjaxHit = $this->input->get('ajaxHit');
		if($isAjaxHit){
			$this->load->view('previewUpcomingProject',$data);
		}
		else{
			//$this->template->load('template','previewUpcomingProject',$data);
			
			$leftData=array(
							'welcomelink'=>base_url(lang().'/dashboard/upcoming'),
							'isDashButton'=>true
				  );
			$leftView='dashboard/help_upcoming';
			$data['leftContent']=$this->load->view($leftView,$leftData,true);
			
			$this->template->load('backend_template','previewUpcomingProject',$data);
		}	
	}

	/**
	 * getGenerList fucntion
	 *
	 * function call by  add new Upcoming Project view through ajax
	 *
	 * @access	public
	 * @param
	 * @return
	 */

	public function getTypeList() {
		$industryId=$this->input->post('val1');
		$typeId=$this->input->post('val2');
		$type = getTypeList($industryId,lang(),'selectProjectType');

		$html= form_dropdown('projType', $type, set_value('projGenre'),'id="projType" class="required" onclick="selectBox();"  onchange="getGenerListNew(\''.base_url(lang().'/upcomingprojects/getGenerList').'\',\'subGenreList\',this.value,1,\'projTypeOtherDiv\',\'projTypeOther\',1,\'subGenreList\',\'projGenreOtherDiv\',\'projGenreOther\'); addRemoveOther(this.value,\'projGenreOtherDiv\',\'projGenreOther\');"');
		$html.=" <script>selectBox();</script>";
		echo $html;
	}

	public function getGenerList() {
		$typeId=$this->input->post('val1');
		$genere =getGenerList($typeId, lang(), 'selectGenre');

		$html= form_dropdown('projGenre', $genere, set_value('projGenre'),'id="projGenre" class="required " onclick="selectBox();" addRemoveOther(this.value,\'projGenreOtherDiv\',\'projGenreOther\');"');
		$html.=" <script>selectBox();</script>";
		echo $html;
	}


	public function getTypeListNew() {
		$industryId=$this->input->post('val1');
		$type = getTypeList($industryId,lang(), 'selectProjectType');

		echo form_dropdown('projType', $type, set_value('projGenre'),'id="projType" class="required " onclick="selectBox()" onchange="getGenerListNew(\''.base_url(lang().'/upcomingprojects/getGenerList').'\',\'subGenreList\',this.value,1,\'projTypeOtherDiv\',\'projTypeOther\',1,\'subGenreList\',\'projGenreOtherDiv\',\'projGenreOther\'); addRemoveOther(this.value,\'projGenreOtherDiv\',\'projGenreOther\');"');
	}

	/**
	* Loads Additional Information Form on page
**/
function additionalInformation($projId,$type='News',$natureId=1)
{
	if($projId>0){
		$additionalInfoData['additionalInfoSection']=array('addInfoNewsPanel','addInfoInterviewsPanel'); 
		
		//Redirect if user is trying to access project of another user
		if(isset($projId) && $projId >0 && isset($this->userId)){
			$userDataWhere = array('projId'=>$projId,'tdsUid'=>$this->userId);
			checkUsersProjects('UpcomingProject',$userDataWhere);
		}	

		//$projId =  $this->input->post('projId');
		$this->lib_upcomingprojectsimages->keyimages['projId'] = $projId;
		
		$this->projId = $this->input->post('EntityId')>0?$this->input->post('EntityId'):$projId;//Checks if eventId is set or not
		$this->lib_upcomingprojectsimages->keyimages['label'] = $this->lang->language;
		$additionalInfoData['header'] = $this->load->view('navigationMenu',$this->lib_upcomingprojectsimages->keyimages,true);
		$additionalInfoData['recordId'] = $this->projId;
		
		$additionalInfoData['label'] = $this->lang->language;
		$additionalInfoData['eventNatureId'] = $natureId;
		$additionalInfoData['tableId'] = getMasterTableRecord($this->upcomingProjectTableName);
		
		//To make default display for accordin none,display mode get changed on saving 
		if(strcmp($type,'Reviews')==0){
			$additionalInfoData['reviewDisplayStyle'] = 'style="display:block;"';
		}
		else{
			$additionalInfoData['reviewDisplayStyle'] = 'style="display:none;"';
		}

		if(strcmp($type,'Interviews')==0){
			$additionalInfoData['interviewDisplayStyle'] = 'style="display:block;"';
		}
		else{
			$additionalInfoData['interviewDisplayStyle'] = 'style="display:none;"';
		}	
		
		
		$config = array();
		if(strcmp($this->input->post('formtype'),'News')==0)
		{
		$config = array(
			array(
					 'field'   => 'title',
					 'label'   =>  $additionalInfoData['label']['title'],
					 'rules'   => 'trim|required|xss_clean'
			),
		);
		}
		
		if(strcmp($this->input->post('formtype'),'Reviews')==0)
		{
		$config = array(
			array(
					 'field'   => 'reviewstitle',
					 'label'   =>  $additionalInfoData['label']['title'],
					 'rules'   => 'trim|required|xss_clean'
			),
		);
		}
		
		$this->form_validation->set_rules($config); 
		$this->form_validation->set_error_delimiters('<span class="clear_seprator "></span><label class="validation_error red">', '</label>');
		if($this->form_validation->run())
		{

			if(strcmp($this->input->post('submit'),'Save')==0){
				
			if(strcmp($this->input->post('formtype'),'News')==0){			      
				$additionalInfoData['newsDisplayStyle'] = 'style="display:block;"';
			}
			if(strcmp($this->input->post('formtype'),'Reviews')==0){
			
				$additionalInfoData['reviewDisplayStyle'] = 'style="display:block;"';
			}
				
			}//end if save
		}//End If form_validation->run
		else
		{		
			if(validation_errors())
			{
			$msg = array('errors' => validation_errors());	
			$data['values']['save'] = '';			
			}			
		}//End else
		//$this->template->load('template','additionalInfo/additional_info',$additionalInfoData);
		//$this->template->load('template','upcomingProject_additional_info',$additionalInfoData);
		
		$leftData=array(
						'welcomelink'=>base_url(lang().'/dashboard/upcoming'),
						'isDashButton'=>true,
						'isreviews'=>0
			  );
		$leftView='dashboard/help_pr_material';
		$additionalInfoData['leftContent']=$this->load->view($leftView,$leftData,true);
		
		$this->template->load('backend_template','additionalInfo/additional_info',$additionalInfoData);
	}else
	{
		$msg = $this->lang->language['enterUpcomingProject'];
		set_global_messages($msg, 'error');
		redirect("upcomingprojects/newupcomingprojects");
	}	
}
/**
		* Loads EVENTS Listing on page
	**/
	function eventsList()
	{
		//$projectNewsData['label'] = $this->lang->language;
		$eventData['events'] = array();			
		$this->load->view('events_list',$eventData);
	}

	/**
		* Loads NEWS In LIGHTBOX Listing on page
	**/
	function showEventsList()
	{
		$newsData['label'] = $this->lang->language;		
		$newsData['news'] = array();		
		$this->load->view('show_events_list',$newsData);
	}

	/**
		* Loads REVIEWS form (Entry) on page
	**/
	function eventForm()
	{
		$eventFormData['label'] = $this->lang->language;
		$this->load->view('event_form');
	}

	function previewVideo($videoId)
	{
		$this->data['getVideoDetail'] =  $this->model_upcomingprojects->getVideoDetail($videoId,2);
		$isAjaxHit = $this->input->get('ajaxHit');
		if($isAjaxHit){
			$this->load->view('previewVideo',$this->data);
		}
		else{
			//$this->template->load('template','previewVideo',$this->data);	
			
			$leftData=array(
							'welcomelink'=>base_url(lang().'/dashboard/upcoming'),
							'isDashButton'=>true
				  );
			$leftView='dashboard/help_upcoming';
			$this->data['leftContent']=$this->load->view($leftView,$leftData,true);
			
			$this->template->load('backend_template','previewVideo',$this->data);
		}	
	}

	function previewAudio($videoId)
	{
		$this->data['getAudioDetail'] =  $this->model_upcomingprojects->getVideoDetail($videoId,3);
		$isAjaxHit = $this->input->get('ajaxHit');
		if($isAjaxHit) {
			$this->load->view('previewAudio',$this->data);
		}	
		else {
			//$this->template->load('template','previewAudio',$this->data);	
			
			$leftData=array(
							'welcomelink'=>base_url(lang().'/dashboard/upcoming'),
							'isDashButton'=>true
				  );
			$leftView='dashboard/help_upcoming';
			$this->data['leftContent']=$this->load->view($leftView,$leftData,true);
			
			$this->template->load('backend_template','previewAudio',$this->data);
		}	
	}

////////////////////////////// Featured Image functionality//////////////////////////////////////


	public function makeFeatured($mediaId,$entityId,$mediaType,$productType)
	{
		$promotionImageId =  $mediaId;
		$chcekFeaturedImage = chcekFeaturedImageChangeStatus($this->upcomingProjectMediaTableName,'projId',$entityId,$mediaType);
		$this->model_common->changePromotionMediaStatus($this->upcomingProjectMediaTableName,$promotionImageId,'projId',$entityId);

		$message = $this->lang->language['featuredImageChanged'];
		set_global_messages($message, 'success');
		redirect("upcomingprojects/projectPromotionalImages/".$entityId);
	}

	//////////////////////////////// Delete Image Functionality ///////////////////////////////////////

	function deletePromotionImage($mediaId, $entityId,$productType='')
	{
		
		$getFileType=2;
		$result = $this->model_common->deleteMedia($this->upcomingProjectMediaTableName,$mediaId,'projId',$entityId);

		
		if($getFileType==1){
			$message = $this->lang->language['upcomingProjectImageDeleted'];
			
		}else
		{
			$message = $this->lang->language['upcomingProjectSupportedMediaDeleted'];
			
		}
			set_global_messages($message, 'success');
		//Go back to orignal page with error					
		if(isset($_SERVER['HTTP_REFERER']))
		{
			$baclLink=$_SERVER['HTTP_REFERER'];
		}
		else
		{
			$baclLink='';
		}

		redirect($baclLink);
	}

	function deletePermanently($projId)
	{
		$this->model_upcomingprojects->deletePermanently($projId);
		$message = $this->lang->language['upcomingProjectDeletedSuccessfully'];
		set_global_messages($message, 'success');
		redirect("upcomingprojects");
	}

	function restoreRecord($projId)
	{
		$this->model_upcomingprojects->restoreRecord($projId);
		$message = $this->lang->language['recordRestore'];
		set_global_messages($message, 'success');
		redirect("upcomingprojects");
	}
	/*Function to load how to publish popup */
	function howToPublish()
	{
		$this->load->view('upcomingHowToPublish') ;				
	}   

}//End Class
?>
