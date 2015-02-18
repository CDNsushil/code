<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Todasquare mediatheme Controller Class
 *
 *  @package	Toadsquare
 *  @subpackage	Module
 *  @category	Controller
 *  @author		Gurutva Singh
 *  @link		http://toadsquare.com/
**/

class mediatheme extends MX_Controller {

	private $userId = NULL;
	private $data = array();
	/**
	 * Constructor
	**/
	function __construct(){
	  //My own constructor code
	  $load = array(
			'library' 	=> 'Lib_masterMedia + lib_sub_master_media',
			//'language' 	=> 'upcomingprojects',
			'helper' 	=> 'form + file'				
	  );
	parent::__construct($load);
	$this->userId= $this->isLoginUser();
	}

	function index($entityId,$action='',$listArray,$flag=0,$returnUrl='',$browseId='_imgJs')
	{
		$isMainArr=array();
		//print_r(echo count($listArray['listValues']));
	//	echo count($listArray['listValues']);
		if(@$listArray['listValues']!=""){
			foreach ($listArray['listValues'] as $key=>$value)
			{
				array_push($isMainArr,$value['isMain']);
			}
		}
		$userId = $this->userId;
		$listArray['currentEntityId'] = $entityId;
		$listArray['delMediaAction'] = $action;
		$listArray['showDelFlag'] = $flag;
		$listArray['browseId'] = $browseId;
		$listArray['tableName'] = $listArray['promoElementTable'];
		$listArray['returnUrl'] = $returnUrl;
		$listArray['label'] = $this->lang->language;	
		
		if(is_array(@$listArray['listValues']))
		{
			$recCount=count($listArray['listValues']);
			
			$fieldNameWorkId=array_key_exists('workId',$listArray['listValues'][0]);
			$fieldNamePId=array_key_exists('prodId',$listArray['listValues'][0]);
			$fieldNameUpId=array_key_exists('projId',$listArray['listValues'][0]);
			$fieldNameEventId=array_key_exists('eventId',$listArray['listValues'][0]);
			$fieldNameUserId=array_key_exists('userId',$listArray['listValues'][0]);
			
			if($fieldNameWorkId)
			$fieldName='workId';
			if($fieldNamePId)
			$fieldName='prodId';
			if($fieldNameUpId)
			$fieldName='projId';
			if($fieldNameEventId)
			$fieldName='eventId';
			if($fieldNameUserId)
			$fieldName='userId';		
			
			$promotionImageId=$listArray['listValues'][0]['mediaId'];
			$promotionMediaTable=$listArray['promoElementTable'];		
			
			if($recCount==1 || !(in_array('t',$isMainArr))){
				$this->model_common->changePromotionMediaStatus($promotionMediaTable,$promotionImageId,$fieldName,$entityId);
			}
		
			$listValues[$fieldName]=$listArray['listValues'][0][$fieldName];
		}
	//	echo count($listArray['listValues']);
		$this->load->view('promoMediaList',$listArray);
	}

	function promoMediaForm($entityId,$action,$tableName,$mediaType)
	{		
		$this->head->add_css($this->config->item('system_css').'upload_file.css');
		$this->head->add_js($this->config->item('system_js').'jquery-upload/plupload.js');
		$this->head->add_js($this->config->item('system_js').'jquery-upload/plupload.html5.js');
		$this->head->add_js($this->config->item('system_js').'jquery-upload/plupload.flash.js');
		
		
		$userId = $this->userId;
		//echo get_global_messages();
		$entityData['currentEntityId'] = $entityId;
		$entityData['mediaAction'] = $action;
		$entityData['tableName'] = $tableName;
		$entityData['mediaType'] = $mediaType;
		$entityData['label'] = $this->lang->language;
		$this->load->view('promoMediaForm',$entityData);
	}
	
	function mediaForm()
	{		
		$this->load->view('mediaForm');
	}
	
	function mediaList($toggleId)
	{		
		$this->load->view($toggleId.'MediaList');	
	}
		
	function promoVideoForm($data,$required=1)
	{
		$userId = $this->userId;
		
		//echo get_global_messages();

		$videoData['videoLabel'] = $data['videoLabel'];
		$videoData['imgSrc'] = $data['imgInterviewSrc'];
		$videoData['embedArray'] = $data['embedArray'];
		
		$videoData['title']    = $data['title'];
		$videoData['description'] = $data['description'];

		$videoData['inputArray'] = $data['inputArray'];
		$videoData['fileType'] = $data['fileType'];
		$videoData['fileMaxSize'] = $data['fileMaxSize'];
		$videoData['videoType'] = $data['videoType'];
		$videoData['browseId'] = $data['browseId'];
		$videoData['required'] = $required;
		$videoData['filePath'] = $data['filePath'];
		
		if(isset($data['checkButton']) && $data['checkButton']!="")
			$videoData['checkButton'] = $data['checkButton'];
		
		$this->load->view('promoVideoForm',$videoData);
		
	}
	
	
	function promoImageForm($label,$imgSrc,$uploadArray=array(),$inputArray=array(),$browseId=0,$stockImageFlag=0,$required=1)
	{		
		
		
		$userId = $this->userId;
		//echo get_global_messages();
		$data['label'] = $label;
		$data['imgSrc'] = $imgSrc;
		$data['uploadArray'] = $uploadArray;
		$data['inputArray'] = $inputArray;
		$data['browseId'] = $browseId;
		$data['stockImageFlag'] = $stockImageFlag;
		$data['required'] = $required;
		$this->load->view('promoImageForm',$data);
	}
	
	function promoImageFormAcc($label,$imgSrc,$uploadArray=array(),$inputArray=array(),$browseId=0,$stockImageFlag=0,$required=1)
	{		
		$this->head->add_css($this->config->item('system_css').'upload_file.css');
		$this->head->add_js($this->config->item('system_js').'jquery-upload/plupload.js');
		$this->head->add_js($this->config->item('system_js').'jquery-upload/plupload.html5.js');
		$this->head->add_js($this->config->item('system_js').'jquery-upload/plupload.flash.js');
		
		$userId = $this->userId;
		//echo get_global_messages();
		$data['label'] = $label;
		$data['imgSrc'] = $imgSrc;
		$data['uploadArray'] = $uploadArray;
		$data['inputArray'] = $inputArray;
		$data['browseId'] = $browseId;
		$data['stockImageFlag'] = $stockImageFlag;
		$data['required'] = $required;
		$this->load->view('promoImageFormAcc',$data);
	}
	
	function promoImgFrmJs($label,$imgSrc,$uploadArray=array(),$inputArray=array(),$browseId=0,$stockImageFlag=0,$required=1,$norefresh=0,$checksection='',$imgext='_s')
	{
		$userId = $this->userId;
		$data['label'] = $label;
		$data['imgSrc'] = $imgSrc;
		$data['uploadArray'] = $uploadArray;
		$data['inputArray'] = $inputArray;
		$data['browseId'] = $browseId;
		$data['stockImageFlag'] = $stockImageFlag;
		$data['required'] = $required;
		$data['norefresh'] = $norefresh;
		$data['checksection'] = $checksection;
		$data['imgext'] = $imgext;
		//echo '<pre />';print_r($data);
		$this->load->view('promoImgFrmJs',$data);
	}
	
	function promoImageAccFrmJs($label,$imgSrc,$uploadArray=array(),$inputArray=array(),$browseId=0,$stockImageFlag=0,$required=1)
	{
		$userId = $this->userId;
		
		//echo get_global_messages();
		
		$data['label'] = $label;
		$data['imgSrc'] = $imgSrc;
		$data['uploadArray'] = $uploadArray;
		$data['inputArray'] = $inputArray;
		$data['browseId'] = $browseId;
		$data['stockImageFlag'] = $stockImageFlag;
		$data['required'] = $required;
		
		$this->load->view('promoImageAccFrmJs',$data);
	}
	
	function mediaFrmJs($label,$imgSrc,$uploadArray=array(),$inputArray=array(),$browseId=0,$stockImageFlag=0,$required=1)
	{
		$userId = $this->userId;
		//echo get_global_messages();
		$data['label'] = $label;
		$data['imgSrc'] = $imgSrc;
		$data['uploadArray'] = $uploadArray;
		$data['inputArray'] = $inputArray;
		$data['browseId'] = $browseId;
		$data['stockImageFlag'] = $stockImageFlag;
		$data['required'] = $required;
		$this->load->view('mediaFrmJs',$data);
	}
	
	
	function UpdatePromoMedia()
	{		
		$elements = false;
		$files = false;
		
		$data['MediaFile'] = $this->input->post('val1');
		$data['dataProject'] = $this->input->post('val2');
		$data['fileId'] = $this->input->post('val3');
		$data['elementId'] = $this->input->post('val4');
		$data['elemetTable'] = $this->input->post('val5');
		$data['elementFieldId'] = $this->input->post('val6');
		$data['src'] = $this->input->post('val7');
		$data['isDefaultElement'] = $this->input->post('val8');		
		$browseId = $this->input->post('val9');		
		$data['deleteCache'] = $this->input->post('val10');	
		$data['dataMediaFields'] = $data['dataProject'];
		$pKey = $data['dataProject']['entityField'];		
		//echo '<pre />';print_r($data);die;
		$entityMediaType = $data['dataProject']['entityMediaType'];		
		
		//unset($data['entityMediaType']);
		
		$data['dataMediaFields'][$pKey] = $data['dataProject']['entityId'];
		unset($data['dataMediaFields']['entityField']);
		unset($data['dataMediaFields']['entityId']);
		unset($data['dataMediaFields']['entityMediaType']);
		
		
		if(is_array($data['MediaFile']) && count($data['MediaFile'])>0){
			$fileSize=strtolower($data['MediaFile']['fileSize']);		
			if(strstr($fileSize, 'gb')){
				$size=explode(' ',$fileSize);
				$fileSize=(int)($size[0]*1073741824);
			}elseif(strstr($fileSize, 'mb')){
				$size=explode(' ',$fileSize);
				$fileSize=(int)($size[0]*1048576);
			}elseif(strstr($fileSize, 'kb')){
				$size=explode(' ',$fileSize);
				$fileSize=(int)($size[0]*1024);
			}
			
			$data['MediaFile']['fileSize']=$fileSize;
			
			if($data['fileId']>0){
				
				$result=$this->model_common->getDataFromTabel('MediaFile','fileName,filePath,isExternal,fileType','fileId',$data['fileId'],'','',1);
				//echo '<pre />';
				//print_r($result);die;
				if($result){
					
					if($result[0]->isExternal != 't'){
					
						$filePath = trim($result[0]->filePath.''.$result[0]->fileName);
						//echo 'Time to unlink'.$filePath;
						if(!empty($filePath) && is_file($filePath)){
						//echo 'Time to unlink3'.$filePath;
						 @unlink($filePath);
						 
						 //If file is image
							 if($result[0]->fileType == 1 || strcmp($result[0]->fileType,'image')==0)
							 {
							 //Deleting the all vesion of file
							 $thumbImgversion_b = addThumbFolder(@$filePath,'_b');
							 if(!empty($thumbImgversion_b) && is_file($thumbImgversion_b)) @unlink($thumbImgversion_b);
							 
							 $thumbImgversion_l = addThumbFolder(@$filePath,'_l');
							 if(!empty($thumbImgversion_l) && is_file($thumbImgversion_l)) @unlink($thumbImgversion_l);
							
							 $thumbImgversion_m = addThumbFolder(@$filePath,'_m'); 
							 if(!empty($thumbImgversion_m) && is_file($thumbImgversion_m)) @unlink($thumbImgversion_m);
							 
							 $thumbImgversion_s = addThumbFolder(@$filePath,'_s');
							 if(!empty($thumbImgversion_s) && is_file($thumbImgversion_s)) @unlink($thumbImgversion_s);
							 
							 $thumbImgversion_xs = addThumbFolder(@$filePath,'_xs');
							 if(!empty($thumbImgversion_xs) && is_file($thumbImgversion_xs)) @unlink($thumbImgversion_xs);
							 
							 $thumbImgversion_xxs = addThumbFolder(@$filePath,'_xxs');
							 if(!empty($thumbImgversion_xxs) && is_file($thumbImgversion_xxs)) @unlink($thumbImgversion_xxs);
							}//End if fileType
						}
					}
					$files=true;
				}
				//die;
			}
			
			if($files)
			{
				$this->model_common->editDataFromTabel('MediaFile', $data['MediaFile'], 'fileId', $data['fileId']);			
			}else
			{			
				 $data['MediaFile']['jobStsatus']='UPLOADING';
				
				 $data['fileId']=$this->model_common->addDataIntoTabel('MediaFile', $data['MediaFile']);				
			}
			
		}else{			
			$data['fileId']=0;			
		}
		
		if(@$data['dataProject']['mediaId']>0)
		{			
			$countResult = $this->model_common->countResult($data['elemetTable'],$data['elementFieldId'],$data['dataProject']['mediaId'],1);			
			if($countResult > 0) $elements=true;					
		}
		
		//For Ismain image
		//echo 'count main image:'.$countMainImageResult=$this->model_common->countResult($data['elemetTable'],$pKey,$data['dataProject']['entityId']);
		if($entityMediaType==1)
			$mainCheckArr = array('isMain'=>'t',$pKey=>$data['dataProject']['entityId']);
		else
			$mainCheckArr = array($pKey=>$data['dataProject']['entityId']);
			
		$countMainImageResult = countResult($data['elemetTable'],$mainCheckArr);
				
		if($data['fileId'] > 0){			
			$data['dataMediaFields']['fileId'] = $data['fileId'];			
		}
		
		if($elements){						
			$data['elementId'] = $data['dataProject']['mediaId'];
			if($entityMediaType==1){
				//If no main img then the resultant image record is main image
				if($countMainImageResult==0 || @$data['dataMediaFields']['isMain']=='t') $data['dataMediaFields']['isMain']='t';
				else $data['dataMediaFields']['isMain']='f';
			}else unset($data['dataMediaFields']['isMain']);
			//echo '<pre />';print_r($data['dataMediaFields']);die;
			$this->model_common->editDataFromTabel($data['elemetTable'], $data['dataMediaFields'], $data['elementFieldId'], $data['dataProject']['mediaId']);					
	
		}	
		else{							
			$data['append'] = true;
			if($entityMediaType==1){
				//If no main img then the resultant image record is main image
				if($countMainImageResult==0) $data['dataMediaFields']['isMain']='t';
				else $data['dataMediaFields']['isMain']='f';
			}else unset($data['dataMediaFields']['isMain']);
			$data['elementId'] = $this->model_common->addDataIntoTabel($data['elemetTable'], $data['dataMediaFields']);						
			addDataIntoLogSummary($data['elemetTable'],$data['elementId']);			
		}
		
		if(!empty($data['deleteCache'])){			
			$sectionCache = $data['deleteCache'];
			$this->session->set_userdata($sectionCache,1);				
		}			
		
		$data['currentEntityId'] = $data['dataProject']['entityId'];
		$data['tableName'] = $data['elemetTable'];		
		$data['mediaType'] = '';
		
		if(isset($browseId) && $browseId!=''){
			$data['toggleId'] = $data['browseImgJs'] = $browseId;
		}
		else
			$data['toggleId'] = $data['browseImgJs'] = '_imgJs';
		
		$data['label'] = $this->lang->language;		
		
		$data['delMediaAction'] = '';
		$data['showDelFlag'] = '';
		$data['returnUrl'] = '';
		$data['label'] = $this->lang->language;
		//$data['entityMediaType']=$entityMediaType;
		
		if(is_array($data['MediaFile']) && count($data['MediaFile'])>0){ $data['latestImgSrc'] = base_url().$data['MediaFile']['filePath'].$data['MediaFile']['fileName'];}
		if($pKey == 'launchEventId'){
			$postLaunchPR = 1;
			$data['addPromoheading'] = $this->lang->line('addpostLaunchPRImages');
			$data['listValues'] = $this->lib_sub_master_media->entitypromotionmedialist($data['elemetTable'],$data['dataProject'],$data['dataProject']['entityField'],$data['dataProject']['entityId'],$data['dataProject']['mediaType'],'','',$postLaunchPR);//we pass the table name,defined fields of given table, the filename on the basis which want to fetch the listing records,MediaType and orderBy clause
		}
		else
			$data['listValues'] = $this->lib_sub_master_media->entitypromotionmedialist($data['elemetTable'],$data['dataProject'],$data['dataProject']['entityField'],$data['dataProject']['entityId'],$data['dataProject']['mediaType'],'','');//we pass the table name,defined fields of given table, the filename on the basis which want to fetch the listing records,MediaType and orderBy clause
		
		$data[$pKey] = $data['dataProject']['entityId'];
		//echo print_r($data);die;
		if(isset($data['browseImgJs']) && $data['browseImgJs'] != '' && $data['browseImgJs'] != '_imgJs'){
			if(!isset($data['browseImgJs']) || $data['browseImgJs'] =='') $data['toggleId'] = $data['browseImgJs'] = 'promo';
				//echo "mediatheme/".$data['browseImgJs']."MediaList";
				$this->load->view("mediatheme/".$data['browseImgJs']."MediaList",$data);
		}	
		else	
			$this->load->view("mediatheme/promoMediaList",$data);
		//$this->load->view("mediatheme/currentMediaList",$data);
	}
	
	// for promo image add/update
	function UpdatePromoImage()
	{		
		$elements=false;
		$promofiles=false;
		$countImgExists=0;
		
		$data['MediaFile']=$this->input->post('val1');
		$data['dataProject']=$this->input->post('val2');
		$data['fileId']=$this->input->post('val3');
		$data['elementId']=$this->input->post('val4');
		$data['elemetTable']=$this->input->post('val5');
		$data['elementFieldId']=$this->input->post('val6');
		$data['src']=$this->input->post('val7');
		$data['isDefaultElement']=$this->input->post('val8');		
		$browseId = $this->input->post('val9');		
		$data['deleteCache']=$this->input->post('val10');	
		$data['dataMediaFields']=$data['dataProject'];
		$pKey = $data['dataProject']['entityField'];		
		$entityMediaType = $data['dataProject']['entityMediaType'];			
		$data['dataMediaFields'][$pKey] = $data['dataProject']['entityId'];
		
		unset($data['dataMediaFields']['entityField']);
		unset($data['dataMediaFields']['entityId']);
		unset($data['dataMediaFields']['entityMediaType']);		
		
		if(is_array($data['MediaFile']) && count($data['MediaFile'])>0){
			
			$fileSize=strtolower($data['MediaFile']['fileSize']);		
			if(strstr($fileSize, 'gb')){
				$size=explode(' ',$fileSize);
				$fileSize=(int)($size[0]*1073741824);
			}elseif(strstr($fileSize, 'mb')){
				$size=explode(' ',$fileSize);
				$fileSize=(int)($size[0]*1048576);
			}elseif(strstr($fileSize, 'kb')){
				$size=explode(' ',$fileSize);
				$fileSize=(int)($size[0]*1024);
			}			
			$data['MediaFile']['fileSize']=$fileSize;
			
			if($data['fileId']>0){
				
				$result = $this->model_common->getDataFromTabel('MediaFile','fileName,filePath,isExternal','fileId',$data['fileId'],'','',1);
				//Count for image exists or not
				$imgExistsArray = array('fileId'=>$data['fileId']);
				$countImgExists = countResult('MediaFile',$imgExistsArray);
				
				if($countImgExists >0)
				{
					//print_r($result[0]);
					//echo 'gfgfhsdf'.$this->db->last_query();
					$promofiles=true;
					if($result[0]->isExternal != 't'){
					
						$filePath = trim($result[0]->filePath.''.$result[0]->fileName);
						//echo 'Time to unlink'.$filePath;
						if(!empty($filePath) && is_file($filePath)){
						//echo 'Time to unlink3'.$filePath;
						@unlink($filePath);
						$thumbImgversion_b = addThumbFolder(@$filePath,'_b');
						$thumbImgversion_l = addThumbFolder(@$filePath,'_l');
						$thumbImgversion_m = addThumbFolder(@$filePath,'_m'); 
						$thumbImgversion_s = addThumbFolder(@$filePath,'_s');
						$thumbImgversion_xs = addThumbFolder(@$filePath,'_xs');
						$thumbImgversion_xxs = addThumbFolder(@$filePath,'_xxs');

						 //Deleting the all vesion of file						
						 if(!empty($thumbImgversion_b) && is_file($thumbImgversion_b)) @unlink($thumbImgversion_b);
						 if(!empty($thumbImgversion_l) && is_file($thumbImgversion_l)) @unlink($thumbImgversion_l);
						 if(!empty($thumbImgversion_m) && is_file($thumbImgversion_m)) @unlink($thumbImgversion_m);						
						 if(!empty($thumbImgversion_s) && is_file($thumbImgversion_s)) @unlink($thumbImgversion_s);						 
						 if(!empty($thumbImgversion_xs) && is_file($thumbImgversion_xs)) @unlink($thumbImgversion_xs);					
						 if(!empty($thumbImgversion_xxs) && is_file($thumbImgversion_xxs)) @unlink($thumbImgversion_xxs);
						}
					}
					
				}
				//die;
			}
			
			if($promofiles)
			{
				$data['fileId']=$this->model_common->editDataFromTabel('MediaFile', $data['MediaFile'], 'fileId', $data['fileId']);			
			}
			else
			{					
				 $data['fileId']=$this->model_common->addDataIntoTabel('MediaFile', $data['MediaFile']);				
			}
			
		}else{			
			$data['fileId']=0;			
		}
		
		if(@$data['dataProject']['mediaId']>0){
			
			$countResult = $this->model_common->countResult($data['elemetTable'],$data['elementFieldId'],$data['dataProject']['mediaId'],1);
			
			if($countResult > 0){				
				$elements=true;				
			}			
		}
		
		//For Ismain image
		//echo 'count main image:'.$countMainImageResult=$this->model_common->countResult($data['elemetTable'],$pKey,$data['dataProject']['entityId']);
		$mainCheckArr = array('isMain'=>'t',$pKey=>$data['dataProject']['entityId']);
		$countMainImageResult=countResult($data['elemetTable'],$mainCheckArr);
				
		if($data['fileId'] > 0){			
			$data['dataMediaFields']['fileId'] = $data['fileId'];			
		}
		
		if($elements){						
			$data['elementId'] = $data['dataProject']['mediaId'];
			
			//If no main img then the resultant image record is main image
			if($countMainImageResult==0 || (isset($data['dataMediaFields']['isMain']) && $data['dataMediaFields']['isMain']=='t')) $data['dataMediaFields']['isMain']='t';
			else $data['dataMediaFields']['isMain']='f';
			//echo '<pre />';print_r($data['dataMediaFields']);die;
			$this->model_common->editDataFromTabel($data['elemetTable'], $data['dataMediaFields'], $data['elementFieldId'], $data['dataProject']['mediaId']);					
		}	
		else{							
			$data['append'] = true;
			//If no main img then the resultant image record is main image
			if($countMainImageResult==0) $data['dataMediaFields']['isMain']='t';
			else $data['dataMediaFields']['isMain']='f';
			
			if(isset($data['dataMediaFields']['blogId']) && !isset($data['dataMediaFields']['userId'])){
				$data['dataMediaFields']['userId']=$this->userId;
			}
			
			$data['elementId'] = $this->model_common->addDataIntoTabel($data['elemetTable'], $data['dataMediaFields']);						
			addDataIntoLogSummary($data['elemetTable'],$data['elementId']);			
		}
		
		if(!empty($data['deleteCache'])){			
			$sectionCache = $data['deleteCache'];
			$this->session->set_userdata($sectionCache,1);				
		}			
		
		$data['currentEntityId'] = $data['dataProject']['entityId'];
		$data['tableName'] = $data['elemetTable'];		
		$data['mediaType'] = '';
		
		if(isset($browseId) && $browseId!='')
			$data['toggleId'] = $data['browseImgJs'] = $browseId;
		else
			$data['toggleId'] = $data['browseImgJs'] = '_imgJs';
		
		$data['label'] = $this->lang->language;		
		
		$data['delMediaAction'] = '';
		$data['showDelFlag'] = '';
		$data['returnUrl'] = "";
		$data['label'] = $this->lang->language;
		
		$data['entityMediaType']=$entityMediaType;
		
		if(is_array($data['MediaFile']) && count($data['MediaFile'])>0){ $data['latestImgSrc'] = base_url().$data['MediaFile']['filePath'].$data['MediaFile']['fileName'];}
		$data['listValues'] = $this->lib_sub_master_media->entitypromotionmedialist($data['elemetTable'],$data['dataProject'],$data['dataProject']['entityField'],$data['dataProject']['entityId'],$data['dataProject']['mediaType'],'mediaId','');//we pass the table name,defined fields of given table, the filename on the basis which want to fetch the listing records,MediaType and orderBy clause
		
		$data[$pKey] = $data['dataProject']['entityId'];
		
		if(strcmp($data['elemetTable'],'PostGallery') == 0) $data['showaddbutton'] = 1;
		if((strcmp($data['elemetTable'],'UpcomingProjectMedia') == 0)  || (strcmp($data['elemetTable'],'ProductPromotionMedia') == 0) || (strcmp($data['elemetTable'],'workPromotionMedia') == 0) ) $data['makeFeatured'] = 1;
	
		if(isset($data['browseImgJs']) && $data['browseImgJs'] != ''&& $data['browseImgJs'] != 0 && $data['browseImgJs'] != '_imgJs'){
			if(!isset($data['browseImgJs']) || $data['browseImgJs'] =='') $data['toggleId'] = $data['browseImgJs'] = 'media';
				//echo "mediatheme/".$data['browseImgJs']."MediaList";
				$this->load->view("mediatheme/".$data['browseImgJs']."MediaList",$data);
		}	
		else	
			$this->load->view("mediatheme/promoMediaList",$data);
		//$this->load->view("mediatheme/currentMediaList",$data);
	}
	
	//Added by vikas to set feature image in mediatheme
	public function makeFeatured($fName,$mediaId,$entityId,$mediaType,$workType,$promotionMediaTable)
	{
		$userId = isLoginUser();	
		$promotionImageId =  $mediaId;
		$promotionImageDataArr=$this->input->post('val2');
		$makeFeatured=$this->input->post('val3');
		$chcekFeaturedImage = chcekFeaturedImageChangeStatus($promotionMediaTable,$fName,$entityId,$mediaType);
		$this->model_common->changePromotionMediaStatus($promotionMediaTable,$promotionImageId,$fName,$entityId);
		$data['listValues'] = $this->lib_sub_master_media->entitypromotionmedialist($promotionMediaTable,$promotionImageDataArr,$fName,$entityId,1,'isMain','');//we pass the table name,defined fields of given table, the filename on the basis which want to fetch the listing records,MediaType and orderBy clause   
      
       if(isset($mediaId) && ($fName=='prodId')){		  
         $this->productWriteCacheFile($userId,$entityId);
	   }else {
		   $this->workWriteCacheFile($userId,$entityId);
		     }
	   
		$data['tableName']=$promotionMediaTable;
		$data['entityMediaType']=$promotionImageDataArr['entityMediaType'];
		$data['makeFeatured']=$makeFeatured;
		$this->load->view('promoMediaList',$data);
	}
	
	
	function productWriteCacheFile($userId=243,$productId=85){
			$this->load->model('product/model_product');
		//set directory path
		$dirCachePath = 'cache/product/'; 
		if(!is_dir($dirCachePath)){
			@mkdir($dirCachePath, 777, true);
		}
		$cmd3 = 'chmod -R 777 '.$dirCachePath;
		exec($cmd3);
		
		//Get Work result data
		$projectData['products'] = $this->model_product->getproductdetail($userId,$productId);
		if(!empty($projectData['products']) && $userId>0){
			if(isset($productId) && !empty($productId))
			{
				$cacheFile = $dirCachePath.'product_'.$productId.'_'.$userId.'.php';
				//Write data in cache file
				$this->writeDataInFile($projectData,$cacheFile);
			}
			else
			{
				foreach($projectData['products'] as $pcount => $productDetail)
				{
					if($productDetail['catId']=1) $productDetail['productType']='Wanted';
					if($productDetail['catId']=2) $productDetail['productType']='For Sale';
					if($productDetail['catId']=3) $productDetail['productType']='Free';
					
					if($userId>0) {	
						$cacheFile = $dirCachePath.'product_'.$productDetail['productId'].'_'.$userId.'.php';	
						//Write data in cache file
						$this->writeDataInFile($productDetail,$cacheFile);
					}	
				}//End Foreach	
			}
		}else{
			return false;
		}
	}
	
	
	
	/*
	 * Write cache file for Work
	 */	
	function workWriteCacheFile($userId=0,$workId=0){
		$this->load->model('work/model_work_offered');
		//set directory path
		$dirCachePath = 'cache/work/'; 
		if(!is_dir($dirCachePath)){
			@mkdir($dirCachePath, 777, true);
		}
		$cmd3 = 'chmod -R 777 '.$dirCachePath;
		exec($cmd3);
		
		//Get Work result data
		$projectData['work'] = $this->model_work_offered->getworkData($userId,$workId);
		if(!empty($projectData['work']) && $userId>0){
			if(isset($workId) && !empty($workId))
			{
				$cacheFile = $dirCachePath.'work_'.$workId.'_'.$userId.'.php';
				//Write data in cache file
				$this->writeDataInFile($projectData,$cacheFile);
			}
			else
			{
				foreach($projectData['work'] as $pcount => $workDetail)
				{
					if($userId>0) {	
						$cacheFile = $dirCachePath.'work_'.$workDetail['workId'].'_'.$userId.'.php';	
						//Write data in cache file
						$this->writeDataInFile($workDetail,$cacheFile);
					}	
				}//End Foreach	
			}
		}else{
			return false;
		}
	}
	
	
	function writeDataInFile($projectResult,$cacheFile){
		$data=str_replace("'","&apos;",json_encode($projectResult));	//encode data in json format
		$stringData = '<?php $ProjectData=\''.$data.'\';?>';
			if (!write_file($cacheFile, $stringData)){	//write cache file
				echo 'Unable to write the file';
			}
	}
	
		
	
			
}
?>
