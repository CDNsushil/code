<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
/**
 * 
 * Todasquare frontend Controller Class
 *
 *  Manage Media Player Page (Player Only)
 * 
 *  @package	Toadsquare
 *  @subpackage	Module
 *  @category	Controller
 *  @author		Gurutva Singh
 *  @link		http://toadsquare.com/
 *
 **/
 // TODO :: This controlar must must have to apply check for the paid meida if any.
class player extends MX_Controller {
	private $data = array();
	private $dirCacheMedia = '';
	private $dirUploadMedia = '';
	
	private $loginUserID = null;
	private $IndustryId = 0;
    private $player = array();
	/**
	 * Constructor
	 */
	 
	 function __construct() {
		//Load required Model, Library, language and Helper files
		$load = array(
			'model'		=> 'player/model_player',  	
			'library' 	=> 'player/lib_player',
			'language' 	=> 'media',							
			'config'	=>	'media/media + mediafrontend/mediafrontend'     		
		);
		parent::__construct($load);		
		
		//$this->head->add_css($this->config->item('system_css').'frontend.css');
	
		// Load  path of css and cache file path
		$this->dirCacheMedia = ROOTPATH.'cache/player/';  
		$this->dirUploadMedia = 'media/'.LoginUserDetails('username').'/player/'; 
		$this->data['dirUploadMedia'] = $this->dirUploadMedia; 
	}
		
	/**
	 * Index fucntion by default call when Controller initialised
	 *
	 * by default call function for Media Player
	 *
	 * @access	public
	 * @param	
	 * @return	
	 */// TODO :: This controlar must must have to apply check for the paid meida if any.
	public function getPlayer($mediaArray='') {		
		
		if(is_array($mediaArray) && count($mediaArray) > 0){
		
			$mediaId = $mediaArray['mediaId'];
			
			if(isLoginUser() == false) // login user Id
			{
				$loginUserID=0;
			}else
			{
				$loginUserID=isLoginUser();
			}
			$entityId = $mediaArray['entityID'];
			$elementId = $mediaArray['elementID'];
			$projectId = $mediaArray['projectID'];
			
			$player = array();
			
			if(isset($mediaArray['width']))
				{
					$this->player['width'] = $mediaArray['width'].'px';
				}else
				{
					$this->player['width'] = 'auto';
				}
				if(isset($mediaArray['height']))
				{
					$this->player['height'] = $mediaArray['height'].'px';
				}else
				{
					$this->player['height'] = 'auto';
				}
			
			if($this->checkAccess($mediaId, $loginUserID, $entityId, $elementId, $projectId))
			{
				//set URL variables 
				$playerIdChunks = explode("_", $mediaId);
				$entityId = @$playerIdChunks[0];
				$playMode = isset($playerIdChunks[1]) ? $playerIdChunks[1]: 'clip';
				$container = isset($playerIdChunks[2]) ? $playerIdChunks[2]: 'videoFile';
				
				// TODO :: Check for the paid meida if any.
				$this->player['media'] = $this->lib_player->loadPlayer($entityId,$container,$playMode);
				
				
				//get media table name 
				$tableName = getMasterTableName('42');
				
				$mediaTableName= $tableName[0];
				 
				//get media file type 
				$getType= $this->model_common->getDataFromTabelWhereIn($mediaTableName, $field='fileType,isExternal,filePath',  $whereField='fileId', $whereValue=$entityId, $orderBy='fileId', $order='ASC', $whereNotIn=0);
				
				//check internal video
				//Here check type of medie the load view
					switch($getType[0]['fileType'])
					{
				
						case 2:	
						case 4:
						case 'video':
						case 'VIDEO':
						case 'text':
						case 'TEXT':
						
							$this->load->view('player_latest',$this->player);
							
						break;
						
						case 3:
						case 'audio':
						case 'AUDIO':
						
							$this->load->view('player_audio',$this->player);
							
						break;
					
					}
			}else
			{
				$this->load->view('errorMessage',$this->player);	
			}
		}
	}
	
	
	/**
	 * @access public
	 * @use this function is used to show player in iframe
	 * @access	public
	 * @parameter hint : mediaId/loginUserID/entityId/projectId/width/height
	 * @return	
	 * 
	 */ 
	public function getPlayerIframe($mediaId,$entityId,$elementId,$projectId) {		
		
		
				
			
				$this->player['width'] = 'auto';
				$this->player['height'] = 'auto';
				
				if(isLoginUser() == false) // login user Id
				{
					$loginUserID=0;
				}else
				{
					$loginUserID=isLoginUser();
				}
			
				//set URL variables 
				$playerIdChunks = explode("_", $mediaId);
				$fileId = @$playerIdChunks[0];// this is fileID 
				$playMode = isset($playerIdChunks[1]) ? $playerIdChunks[1]: 'clip';
				$container = isset($playerIdChunks[2]) ? $playerIdChunks[2]: 'videoFile';
				
				// TODO :: Check for the paid meida if any.
				$this->player['media'] = $this->lib_player->loadPlayer($fileId,$container,$playMode);
				
				//get media table name 
				$tableName = getMasterTableName('42');
				
				$mediaTableName= $tableName[0];
				 
				//get media file type 
				$getType= $this->model_common->getDataFromTabelWhereIn($mediaTableName, $field='fileType',  $whereField='fileId', $whereValue=$fileId, $orderBy='fileId', $order='ASC', $whereNotIn=0);
				
				//Here check type of medie the load view
				switch($getType[0]['fileType']){
			
					case 2:	
					case 4:
					case 'video':
					case 'VIDEO':
					case 'text':
					case 'TEXT':
					
						$this->load->view('iframe_video',$this->player);
						
					break;
					
					case 3:
					case 'audio':
					case 'AUDIO':
					
						$this->load->view('iframe_audio',$this->player);
						
					break;
				}
		
			
		
	}
	
	
	/**
	 * @access public
	 * @use this function show frontend palyer  in music & audio and educational material section 
	 * apply check paid and free media play only
	 * @access	public
	 * @parameter hint : mediaId/loginUserID/entityId/elementId/projectId
	 * @return	
	 * 
	 */ 
	public function getMainPlayerIframe($mediaId=0,$entityId=0,$elementId=0,$projectId=0) {
		
			$this->player['width'] = 'auto';
			$this->player['height'] = 'auto';
			
			if(isLoginUser() == false) // login user Id
			{
				$loginUserID=-1;
			}else
			{
				$loginUserID=isLoginUser();
			}
			
			if($this->checkAccess($mediaId, $loginUserID, $entityId, $elementId, $projectId))
			{
				//set URL variables 
				$playerIdChunks = explode("_", $mediaId);
				$fileId = @$playerIdChunks[0];// this is fileID 
				$playMode = isset($playerIdChunks[1]) ? $playerIdChunks[1]: 'clip';
				$container = isset($playerIdChunks[2]) ? $playerIdChunks[2]: 'videoFile';
				
				// TODO :: Check for the paid meida if any.
				$this->player['media'] = $this->lib_player->loadPlayer($fileId,$container,$playMode);
				
				//get media table name 
				$tableName = getMasterTableName('42');
				
				$mediaTableName= $tableName[0];
				 
				//get media file type 
				$getType= $this->model_common->getDataFromTabelWhereIn($mediaTableName, $field='fileType',  $whereField='fileId', $whereValue=$fileId, $orderBy='fileId', $order='ASC', $whereNotIn=0);
				
				//Here check type of medie the load view
				switch($getType[0]['fileType']){
			
					case 2:	
					case 4:
					case 'video':
					case 'VIDEO':
					case 'text':
					case 'TEXT':
                        
                        //call media image method
                        $this->getmediafileimage($entityId, $elementId, $projectId);
                        
						$this->load->view('iframe_video',$this->player);
						
					break;
					
					case 3:
					case 'audio':
					case 'AUDIO':
					
						$this->load->view('iframe_main_audio',$this->player);
						
					break;
				}
		
			}else
			{
				$this->load->view('paid_video_erro',$this->player);	
			}
		
	}
    
    //----------------------------------------------------------------------
    
    /*
    * @access: private
    * @description: This method is use to media file image data get
    * @auther: lokendra meena
    * @return: void
    */ 
    
    private function getmediafileimage($entityId, $elementId, $projectId){
       
        //get project data
        $whereCondition =   array('projId'=>$projectId);
        $getProjectDetails =   getDataFromTabel('TDS_Project', 'projectType',  $whereCondition, '', $orderBy='', '', 1 );
        $getProjectDetails   =    $getProjectDetails['0'];
        $industryType        =    $getProjectDetails->projectType; 
        
        //get element table name
        $tableName = getMasterTableName($entityId);
        //get element table data
        $whereCondition     =   array('elementId'=>$elementId);
        $getElementDetails  =   getDataFromTabel($tableName[0], 'imagePath,fileId',  $whereCondition, '', $orderBy='', '', 1 );
        $getElementDetails  =   $getElementDetails[0];
        $imagePath  =  $getElementDetails->imagePath;
        $fileId     =  $getElementDetails->fileId;
       
        //image config by industry type 
        $fileConfig               =   $this->config->item($industryType.'FileConfig');	//load language data
        //default image path
        $imagetype_l            =   $fileConfig['defaultImage_l'];
        
        //get media table name 
        $tableName      =  getMasterTableName('42');
        $mediaTableName =  $tableName[0];
        $getFileData    =  $this->model_common->getDataFromTabelWhereIn($mediaTableName, $field='filePath,fileName',  $whereField='fileId', $whereValue=$fileId, $orderBy='fileId', $order='ASC', $whereNotIn=0);
        $getFileData    =   $getFileData[0];
        $filePath = $getFileData['filePath'];
        $fileName = $getFileData['fileName'];
        
        //paid video image here 
        if(empty($imagePath)){	
            $thumbImage         = getVideoThumbFolder($filePath.$fileName,'_xxl');	
            $showElementImage   = getImage($thumbImage,$imagetype_l);	
        }else{
            $thumbImage         = addThumbFolder($imagePath,'_xxl');	
            $showElementImage   = getImage($thumbImage,$imagetype_l);
        }
        
        
         //get image file 
        /*$imageInfo          =  pathinfo($this->player['media']);
        $mediaFileImage     =  $filePath.'thumb/'.$imageInfo['filename'].'_l.jpg';
        
        if(file_exists($mediaFileImage)){
            $mediaFileImage  = base_url().$mediaFileImage;
        }else{
             $mediaFileImage  = $showElementImage;
        }*/
        
        $mediaFileImage  = $showElementImage;
        
       
        $this->player['mediaFileImage']  =  $mediaFileImage;
    }
    
    //----------------------------------------------------------------------
    
    /**
	 * @access public
	 * @use this function show frontend palyer  in music & audio and educational material section 
	 * apply check paid and free media play only
	 * @access	public
	 * @parameter hint : mediaId/loginUserID/entityId/elementId/projectId
	 * @return	
	 * 
	 */ 
	public function mainplayeriframenew($mediaId=0,$entityId=0,$elementId=0,$projectId=0) {
		
		
			$player = array();
			
			$this->player['width'] = 'auto';
			$this->player['height'] = 'auto';
			
			if(isLoginUser() == false) // login user Id
			{
				$loginUserID=-1;
			}else
			{
				$loginUserID=isLoginUser();
			}
			
			if($this->checkAccess($mediaId, $loginUserID, $entityId, $elementId, $projectId))
			{
				//set URL variables 
				$playerIdChunks = explode("_", $mediaId);
				$entityId = @$playerIdChunks[0];// this is fileID 
				$playMode = isset($playerIdChunks[1]) ? $playerIdChunks[1]: 'clip';
				$container = isset($playerIdChunks[2]) ? $playerIdChunks[2]: 'videoFile';
				
				// TODO :: Check for the paid meida if any.
				$this->player['media'] = $this->lib_player->loadPlayer($entityId,$container,$playMode);
				
				//get media table name 
				$tableName = getMasterTableName('42');
				
				$mediaTableName= $tableName[0];
				 
				//get media file type 
				$getType= $this->model_common->getDataFromTabelWhereIn($mediaTableName, $field='fileType',  $whereField='fileId', $whereValue=$entityId, $orderBy='fileId', $order='ASC', $whereNotIn=0);
				
				//Here check type of medie the load view
				switch($getType[0]['fileType']){
			
					case 2:	
					case 4:
					case 'video':
					case 'VIDEO':
					case 'text':
					case 'TEXT':
                    
                        //call media image method
                        $this->getmediafileimage($entityId, $elementId, $projectId);
					
						$this->load->view('iframe_video',$this->player);
						
					break;
					
					case 3:
					case 'audio':
					case 'AUDIO':
					
						$this->load->view('iframe_main_audio_new',$this->player);
						
					break;
				}
		
			}else
			{
				$this->load->view('paid_video_erro',$this->player);	
			}
		
	}
	
	
	
	/**
	 * @access public
	 * @(Embed player)use this function is used show embed, embeded and object code player
	 * @access	public
	 * @parameter hint : mediaId/loginUserID/entityId/projectId
	 * @return	
	 * 
	 */ 
	public function commonPlayerIframe($mediaId,$entityId,$elementId,$projectId) {		
		
				$player = array();
				
				if(isLoginUser() == false) // login user Id
				{
					$loginUserID=0;
				}else
				{
					$loginUserID=isLoginUser();
				}
			
				//set URL variables 
				$playerIdChunks = explode("_", $mediaId);
				$entityId = @$playerIdChunks[0];// this is fileID 
				
				//get media table name 
				$tableName = getMasterTableName('42');
				
				$mediaTableName= $tableName[0];
				 
				//get media file type 
				$getType= $this->model_common->getDataFromTabelWhereIn($mediaTableName, $field='fileType,isExternal,filePath',  $whereField='fileId', $whereValue=$entityId, $orderBy='fileId', $order='ASC', $whereNotIn=0);
				
				
				$this->player['src'] = $getType[0]['filePath'];
					
				$this->load->view('embed_player',$this->player);
	}
	
	
	/*
	 *  @access  public 
	 *  @use this method is used to show video error message
	 *  
	 */ 
	
	function videoError()
	{
		$this->player['width'] = 'auto';
		$this->player['height'] = 'auto';
		$this->player['media'] = NULL;
		$this->load->view('iframe_video',$this->player);
	}
	
	
	/*
	 *  @access  public 
	 *  @use this method is used to show audio error message
	 *  
	 */ 
	
	function audioError()
	{
		$this->player['width'] = 'auto';
		$this->player['height'] = 'auto';
		$this->player['media'] = NULL;
		$this->load->view('iframe_audio',$this->player);
	}
	
	/*
	 * @access  private
	 * @use  This method will be check. Is file free or Paid 
	 * @return true and false 
	 * @param  entityId, elementId, projectId, userId, mediaId
	 * 
	 */ 
	 
	private function checkAccess($mediaId, $userId, $entityId, $elementId, $projectId)
		{
			if($mediaId!="" && $userId!="" && $entityId!="" && $elementId!="" && $projectId!="")
			{
				//get industryId by projectId
				$sectionType = getSectionId($projectId);
				
				switch($sectionType)
				{
					case 'filmNvideo':
					
						$whereCondition     =   array('projId'=>$projectId);
								
						$getProjectData     =   getDataFromTabel('TDS_Project', 'tdsUid ,projCategory, projSellstatus, isprojPpvPrice',  $whereCondition, '', $orderBy='', '', 1 );
					
						//check project sells status 
						if(isset($getProjectData[0]->projSellstatus) && $getProjectData[0]->projSellstatus!='')
						{
							//get protect owner id
							$projOwnerId = $getProjectData[0]->tdsUid;
							
							// This condition is used to for check vidoe paid status
							if($getProjectData[0]->projSellstatus=='f')
							{
								$isAccess = true;
								
							}else
							{
                                
								$paidVideoDataByProjectId = $this->model_player->getElementPaidStatus($elementId);
                                $getElementPaidStatus = $paidVideoDataByProjectId['get_result'];
                                
                                if($getElementPaidStatus->elementType=="1" || $getElementPaidStatus->elementType=="2"){
                                    $isAccess = true;
                                }else{
                                    if($getElementPaidStatus->isPerViewPrice=="t")
                                    {
                                       // This function call for pay per view video	
                                       $isAccess = $this->payPerViewAccess($userId, $entityId, $elementId, $projectId);
                                    }else
                                    {
                                        $isAccess = true;
                                    }
                                }
							}
							
						}else
						{
							// This for free video view
							$isAccess = true;
							
						}
					
					break;
					
					case 'musicNaudio':
						$isAccess = true;
					break;
					
					case 'writingNpublishing':
						$isAccess = true;
					break;
					
					case 'educationMaterial':
					
						$getMediaArray = explode("_",$mediaId);
						$media_id = $getMediaArray[0];
						
						$mediaCondition=array('fileId'=>$media_id);
								
						$getProjectData=getDataFromTabel('TDS_MediaFile', 'fileType',  $mediaCondition, '', $orderBy='', '', 1 );
					
						if(isset($getProjectData[0]->fileType) && $getProjectData[0]->fileType!="")
						{
							if($getProjectData[0]->fileType=="2")
							{
								
								$whereCondition=array('projId'=>$projectId);
								
								$getProjectData=getDataFromTabel('TDS_Project', 'tdsUid ,projCategory, projSellstatus, isprojPpvPrice',  $whereCondition, '', $orderBy='', '', 1 );
								
								//check project sells status 
								if(isset($getProjectData[0]->projSellstatus) && $getProjectData[0]->projSellstatus!='')
								{
									//get protect owner id
									$projOwnerId = $getProjectData[0]->tdsUid;
									
									// This condition is used to for check vidoe paid status
									if($getProjectData[0]->projSellstatus=='f')
									{
										$isAccess = true;
										
									}else
									{
										
										// This section check if project is collection category Type
										
										$paidVideoDataByProjectId = $this->model_player->getEMElementPaidStatus($elementId);
                                        $getElementPaidStatus = $paidVideoDataByProjectId['get_result'];
                                        
                                        if($getElementPaidStatus->elementType=="1" || $getElementPaidStatus->elementType=="2"){
                                            $isAccess = true;
                                        }else{
                                            if($getElementPaidStatus->isPerViewPrice=="t")
                                            {
                                               // This function call for pay per view video	
                                               $isAccess = $this->payPerViewAccess($userId, $entityId, $elementId, $projectId);
                                            }else
                                            {
                                                $isAccess = true;
                                            }
                                        }
										
										
									}
									
								}else
								{
									// This for free video view
									$isAccess = true;
									
								}
						
							}else
							{
								$isAccess = false;
							}
								
						}else
						{
							$isAccess = false;
						}
						
					break;
					
					default:
					$isAccess = true;
				
				}
			
			}
			else
			{
			
				$isAccess = false;
			}
		
			return 	$isAccess;
			
		}	
	
	/*
	 **************************************** 
	 *  This function is used to check if user purchase the Whole project or Element
	 **************************************** 
	 */ 
	
	
	
	public function payPerViewAccess($userId=0, $entityId=0, $elementId=0, $projectId=0)
	{
		
		// get video view data by projectId if user purchase whole project
		$paidVideoDataByProjectId = $this->model_player->paidVideoDataByProjectId($elementId,$userId,$entityId);
		
		if($paidVideoDataByProjectId['get_num_rows'] > 0)
		{
			$mainProjectData = $paidVideoDataByProjectId['get_result'];
			$dwnMaxday = $mainProjectData->dwnMaxday;
			$expiryDate= getPreviousOrFututrDate($mainProjectData->dwnDate, '+'.$dwnMaxday.' day' ,$format='Y-m-d');
			$currentData = date("Y-m-d");
			if(isset($paidVideoDataByProjectId['get_result']->itemInfo) && $paidVideoDataByProjectId['get_result']->itemInfo!="")
			{
			$itemInfo = json_decode($paidVideoDataByProjectId['get_result']->itemInfo);
			$isElementId = false;
			foreach($itemInfo as $itemInfoDetails)
			{
				if($itemInfoDetails->elementId==$elementId)
				{
					$isPurchaseElement = true;
				}
			}
				if($isPurchaseElement)
				{
					if($currentData <= $expiryDate)
						{
							$isAccess = true;
						}else
						{
							$isAccess = false;
						}
				}else
				{
					$isAccess = false;
				}	
			}else
			{
				$isAccess = false;
			}	
		}else
		{
			// get video view data by projectId and elementId if user purchase only element
			$paidVideoDataByElementId = $this->model_player->paidVideoDataByElementId($projectId,$elementId,$entityId,$userId);
			if($paidVideoDataByProjectId['get_num_rows'] > 0)
			{
				$elementData = $paidVideoDataByElementId['get_result'];
				$dwnMaxday = $elementData->dwnMaxday;
				$expiryDate= getPreviousOrFututrDate($elementData->dwnDate, '+'.$dwnMaxday.' day' ,$format='Y-m-d');
				$currentData = date("Y-m-d");
				if($currentData <= $expiryDate)
				{
					$isAccess = true;
				}else
				{
					$isAccess = false;
				}
			}else
			{
				$isAccess = false;
				
			}
		}
		
		return $isAccess;
		
	}
			
		
	/*
	 *  @access public
	 *  @use this function is used to show audio clip play
	 *  @return player code
	 */ 		
	function commonAudioPlayer()
	{
		$this->player['media'] = $this->lib_player->loadCommonPlayer();
		$this->load->view('common_audio',$this->player);
	}
	
	/*
	 *	date: 4-sep-2013
	 *  details: This function is used to play audio playlist  
	 *  return playlist code 
	 */ 
	
	function audioplaylistplay($isAutoPlay="0"){
		$this->player['media'] = $this->lib_player->loadAudioPlaylistPlayer($isAutoPlay);
		$this->load->view('audio_playlist_play',$this->player);
	}	
	
}
