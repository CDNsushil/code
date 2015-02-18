<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Todasquare media Model Class
 *
 *  Fetch data for media (Film & Video, Music & Audio, Photography & Art,
 *	 Writing & publishing, Education Material)
 *
 *  @package	Toadsqure
 *  @subpackage	Module
 *  @category	Model
 *  @author		Sushil Mishra
 *  @link		http://toadsquare.com/
 */
class model_media extends CI_Model {
	
	/**
	 * Constructor
	 *
	 * Loads the calendar language file and sets the default time reference
	 */	
	
	private $tableProject 						= 'Project'; //Private Variable(Table Name) to get used at class level only
	private $tableProjCategory					= 'ProjCategory';
	private $tableMasterIndustry				= 'MasterIndustry';
	private $tableGenre							= 'Genre';
	private $tableOffers						= 'Offers';
	private $tableMasterRating					= 'MasterRating';	
	private $tableElement						= 'Element';	
	private $tableFvMediaType					= 'MediaType';	
	private $tableMediaFile						= 'MediaFile';
		
	private $tableProjectPromotion 				= 'ProjectPromotion';
	private $tableProjectShipping				= 'ProjectShipping';
	
	private $tableAssociativeCreatives			= 'AssociativeCreatives';
		
	private $tableLogSummary					= 'LogSummary';	
	private $tableLogInvite						= 'LogInvite';	
	private $tableLogCrave						= 'LogCrave';	
	private $tableLogRating						= 'LogRating';	
	private $tableLogShare						= 'LogShare';	
	private $tableLogShow						= 'LogShow';
	private $tableMediaEelementType				= 'MediaEelementType';
	private $tableProjectType					= 'MasterProjectType';
	
	private $tableUserAuth						= 'UserAuth';
	private $UserProfile						= 'UserProfile';
	private $tableUserShowcase					= 'UserShowcase';
    private $tableUserProfile                   = 'UserProfile';
	
	private $tableUserContainer					= 'UserContainer';
	private $tableMasterLang					= 'MasterLang';
	private $tableMasterCountry					= 'MasterCountry';
	
	private $tableReviewsElement                ='ReviewsElement' ;
	private $SupportLink                        ='SupportLink' ;
    private $tableMasterTsProduct	            ='MasterTsProduct' ;
    private $tableMaElement	            ='MaElement' ;

	private $UserBuyerSettings					= 'UserBuyerSettings';	
	private $UserSellerSettings					= 'UserSellerSettings';	
	private $UserSearchPreferences				= 'UserSearchPreferences';
	private $tableMembershipCart				= 'MembershipCart';
	private $tableMembershipCartItem			= 'MembershipCartItem';
	private $tableProjectShippingPickup			= 'ProjectShippingPickup';
    private $tableUserMembershipItem			= 'UserMembershipItem';
	
    private $tblShipping 		= 'ProjectShipping'; //Private Variable(Table Name) to get used at class level only
	private $tblShippingZone	= 'ProjectShippingZone';
	private $tblCountry			= 'MasterCountry';
	private $tblContinent		= 'MasterContinent';
	private $tableStockImages	= 'StockImages';
	private $tableMediaPlaylist	= 'MediaPlaylist';
	/**
	 * Constructor
	 *
	 * Loads the calendar language file and sets the default time reference
	 */
	public function __construct(){		
		parent::__construct();			// Call parent constructer
	}
	
	/**
	 * mediaLastInsertDtaData fucntion 
	 *
	 * mediaLastInsertDtaData call by  Media Controller 
	 *
	 * @access	public
	 * @param	string
	 * @return	Object
	 */
	public function mediaLastInsertDtaData($projectId=0, $tdsUid=0,$elementTblPrefix='Fv'){
			$elementTable=$elementTblPrefix.$this->tableElement;
			$this->db->select('*,'.$this->tableProject.'.projId as projectid, '.$this->tableProject.'.IndustryId as ProjectIndustryId');
			$this->db->from($this->tableProject);
			$this->db->join($this->tableProjCategory, $this->tableProjCategory.".catId = Project.projCategory", 'left');
			$this->db->join($this->tableProjectType, $this->tableProjectType.".typeId = Project.projType", 'left');
			$this->db->join($elementTable, $elementTable.".projId = Project.projId", 'left');
			$this->db->join($this->tableUserContainer, $this->tableUserContainer.".userContainerId = ".$this->tableProject.".userContainerId", 'left');
			$this->db->where($this->tableProject.'.projId',$projectId);
			$this->db->where($this->tableProject.'.tdsUid',$tdsUid);
			$this->db->limit(1);
			$query = $this->db->get();
			
			//echo $this->db->last_query();
			return $result=$query->result();
	}
	/**
	 * getProject fucntion 
	 *
	 * getProject call by  Media Controller 
	 *
	 * @access	public
	 * @param	string
	 * @return	Object
	 */
	public function getProject($UserId=0,$projectType='',$projectId=0,$elementTblPrefix='Fv',$orderby='order',$order='ASC',$limit=0,$cacheFile='',$isArchive='f'){		
		if($isArchive !== 't'){ $isArchive='f';}
		$result = $this->getProjectRecord($projectType,$UserId,$projectId,$limit,$isArchive);
		$entityId=getMasterTableRecord('Project');
		if($result){
			$elementTable=$elementTblPrefix.$this->tableElement;
			$elementEntityId=getMasterTableRecord($elementTable);
			foreach($result as $key=>$data){
				if($data->isPublished=='f'){
					$this->model_common->editDataFromTabel($elementTable, array('isPublished'=>'f'), array('projId'=>$data->projId));
				}
				if($projectType=='educationMaterial'){
					$sectionRes=$this->model_common->getDataFromTabel('MasterIndustry','IndustryId',  array('IndustryKey'=>'educationalmaterial'), '', '', '', 1 );
					if($sectionRes){
						$sectionId=$sectionRes[0]->IndustryId;
					}
				}else{
					$sectionId=($data->IndustryId > 0)?$data->IndustryId:0;
				}
				
				
				$projectCreated=($data->createDate!='')?$data->createDate:currntDateTime();
				$projPublisheDate=($data->projPublisheDate!='')?$data->projPublisheDate:$projectCreated;
				
				if(!empty($elementTblPrefix)){
					$elements=$this->getProjectElements($data->projId,$elementTblPrefix,0,$orderby,$order);
					//echo 'elements fetching';die;
					$result[$key]->elements=$elements;
					
						
						$enterpriseName=pg_escape_string($data->enterpriseName);
						$enterpriseName=trim($enterpriseName);
						$creative_name=($data->enterprise=='t')?$enterpriseName:pg_escape_string($data->firstName.' '.$data->lastName);
			
						
						if($elements){
							foreach($elements as $k=>$element){
								$searchDataInsertElement=array(
									"entityid"=>$elementEntityId,
									"elementid"=>$element->elementId,
									"projectid"=>$element->projId,
									"section"=>$projectType,
									"ispublished"=>($element->isPublished=='t')?'t':'f',
									"cachefile"=>$cacheFile,
									"item.title"=>pg_escape_string($element->title), 
									"item.tagwords"=>pg_escape_string($element->tags), 
									"item.online_desctiption"=>pg_escape_string($element->description),
									"item.userid"=>$UserId,
									"item.creative_name"=>$creative_name, 
									"item.creative_area"=>pg_escape_string($data->optionAreaName),
									"item.languageid"=>$data->projLanguage>0?$data->projLanguage:0,  
									"item.language"=>pg_escape_string($data->Language_local),
									"item.countryid"=>$data->producedInCountry>0?$data->producedInCountry:0,
									"item.country"=>pg_escape_string($data->countryName), 
									"item.city"=>pg_escape_string($data->cityName), 
									"item.sell_option"=>($data->projSellstatus=='t' && isset($element->isPrice) && ($element->isPrice=='t'))?'paid':'free', 
									"item.industryid"=>(isset($element->IndustryId) && $element->IndustryId >0)?($element->IndustryId):($data->IndustryId>0?$data->IndustryId:0), 
									"item.industry"=>isset($element->IndustryName)?$element->IndustryName:$data->IndustryName, 
									"item.categoryid"=>$data->projCategory>0?$data->projCategory:0, 
									"item.category"=>pg_escape_string($data->category), 
									"item.typeid"=>$data->projType>0?$data->projType:0,
									"item.type"=>pg_escape_string($data->projectTypeName),
									"item.genreid"=>$data->projGenre>0?$data->projGenre:0, 
									"item.genre"=>pg_escape_string($data->Genre), 
									"item.subgenre"=>pg_escape_string($data->projGenreFree), 
									"item.element_type"=>pg_escape_string($element->type), 
									"item.publisher"=>pg_escape_string($element->productionCompany),
									"item.self_ratingid"=>$data->ratId>0?$data->ratId:0,
									"item.self_rating"=>pg_escape_string($data->otpion), 
									"item.creation_date"=>($element->createDate != '')?$element->createDate:$projectCreated, 
									"item.publish_date"=>$projPublisheDate
								);
								
								if($projectType=='news' || $projectType=='reviews'){
									$elementSectionId=(isset($element->IndustryId) && $element->IndustryId >0)?($element->IndustryId):0;
								}else{
									$elementSectionId=$sectionId;
								}
								$searchDataInsertElement['sectionid']=$elementSectionId;
								$this->model_common->addUpdateDataIntoObject('search', $searchDataInsertElement);
							}
						}else{
							$this->model_common->editDataFromTabel('Project', array('isPublished'=>'f'), array('projId'=>$data->projId));
							$data->isPublished='f';
							$result[$key]->isPublished='f';
						}
						
						$searchDataInsert=array(
							"entityid"=>$entityId,
							"elementid"=>$data->projId,
							"projectid"=>$data->projId,
							"section"=>$projectType,
							"ispublished"=>$data->isPublished=='t'?'t':'f',
							"cachefile"=>$cacheFile,
							"item.title"=>pg_escape_string($data->projName), 
							"item.tagwords"=>pg_escape_string($data->projTag), 
							"item.online_desctiption"=>pg_escape_string($data->projShortDesc),
							"item.userid"=>$UserId, 
							"item.creative_name"=>$creative_name, 
							"item.creative_area"=>pg_escape_string($data->optionAreaName),
							"item.languageid"=>$data->projLanguage>0?$data->projLanguage:0,  
							"item.language"=>pg_escape_string($data->Language_local),
							"item.countryid"=>$data->producedInCountry>0?$data->producedInCountry:0, 
							"item.country"=>pg_escape_string($data->countryName), 
							"item.city"=>pg_escape_string($data->cityName), 
							"item.sell_option"=>$data->projSellstatus=='t'?'paid':'free', 
							"item.industryid"=>$data->IndustryId>0?$data->IndustryId:0, 
							"item.industry"=>pg_escape_string($data->IndustryName), 
							"item.categoryid"=>$data->projCategory>0?$data->projCategory:0, 
							"item.category"=>pg_escape_string($data->category),
							"item.typeid"=>$data->projType>0?$data->projType:0,
							"item.type"=>pg_escape_string($data->projectTypeName),
							"item.genreid"=>$data->projGenre>0?$data->projGenre:0, 
							"item.genre"=>pg_escape_string($data->Genre), 
							"item.subgenre"=>pg_escape_string($data->projGenreFree), 
							"item.element_type"=>"", 
							"item.publisher"=>pg_escape_string($data->productionHouse),
							"item.self_ratingid"=>$data->ratId>0?$data->ratId:0,
							"item.self_rating"=>pg_escape_string($data->otpion), 
							"item.creation_date"=>$projectCreated,
							"item.publish_date"=>$projPublisheDate
						);
						$searchDataInsert['sectionid']=$sectionId;
						$this->model_common->addUpdateDataIntoObject('search', $searchDataInsert);
					
				}
				
			}
		}
		return $result;
	}
	
	/**
	 * getProjectRecord fucntion 
	 *
	 * get Project detail from database
	 *
	 * @access	private
	 * @param	string
	 * @return	Object
	 */
	public function getProjectRecord($projectType='',$UserId=0,$projectId=0,$limit=0,$isArchive='f'){
		
			$table=$this->db->dbprefix($this->tableProject);
			$entityId=getMasterTableRecord($table);	
			$tableLogSummary=$this->db->dbprefix($this->tableLogSummary);
						
			$entityId=getMasterTableRecord($this->tableProject);			
			
			$this->db->select($this->tableProject.'.*');
			$this->db->select($this->tableUserShowcase.'.showcaseId,'.$this->tableUserShowcase.'.creative,'.$this->tableUserShowcase.'.associatedProfessional,'.$this->tableUserShowcase.'.enterprise,'.$this->tableUserShowcase.'.enterpriseName,'.$this->tableUserShowcase.'.optionAreaName');
			$this->db->select($this->UserProfile.'.*');
			$this->db->select($this->tableGenre.'.*');
			$this->db->select($this->tableProjectType.'.*');
			$this->db->select($this->tableProjCategory.'.*');
			$this->db->select($this->tableUserContainer.'.*');
			$this->db->select($this->tableMasterRating.'.*');
			$this->db->select($this->tableMasterIndustry.'.*');
			$this->db->select($this->tableMasterLang.'.*');
			$this->db->select('c1.*');
			$this->db->select('c2.Language_local as "projSubtitle1"');
			$this->db->select('c3.Language_local as "projSubtitle2"');
			$this->db->select('c4.Language_local as "projDubbing1"');
			$this->db->select('c5.Language_local as "projDubbing2"');
			$this->db->select($this->tableLogSummary.'.*');
			$this->db->select($this->tableProject.'.projId as projectid, '.$this->tableProject.'.IndustryId as projectIndustryId, '.$this->tableProject.'.isPublished as "isPublished", '.$this->tableProject.'.isExpired as "isExpired", '.$this->tableProject.'.isBlocked as "isBlocked"');
			
			$this->db->from($this->tableProject);
			
			$this->db->join($this->tableUserShowcase, $this->tableUserShowcase.".tdsUid = ".$this->tableProject.".tdsUid", 'left');
			$this->db->join($this->UserProfile, $this->UserProfile.".tdsUid = ".$this->tableProject.".tdsUid", 'left');
			$this->db->join($this->tableGenre, $this->tableGenre.".GenreId = ".$this->tableProject.".projGenre", 'left');
			$this->db->join($this->tableProjectType, $this->tableProjectType.".typeId = ".$this->tableProject.".projType", 'left');
			$this->db->join($this->tableProjCategory, $this->tableProjCategory.".catId = ".$this->tableProject.".projCategory", 'left');
			$this->db->join($this->tableUserContainer, $this->tableUserContainer.".userContainerId = ".$this->tableProject.".userContainerId", 'left');
			$this->db->join($this->tableMasterLang, $this->tableMasterLang.".langId = ".$this->tableProject.".projLanguage", 'left');
			$this->db->join($this->tableMasterCountry." c1", "c1.countryId = ".$this->tableProject.".producedInCountry", 'left');
			$this->db->join($this->tableMasterLang." c2", "c2.langId = ".$this->tableProject.".projSubtitle1", 'left');
			$this->db->join($this->tableMasterLang." c3", "c3.langId = ".$this->tableProject.".projSubtitle2", 'left');
			$this->db->join($this->tableMasterLang." c4", "c4.langId = ".$this->tableProject.".projDubbing1", 'left');
			$this->db->join($this->tableMasterLang." c5", "c5.langId = ".$this->tableProject.".projDubbing1", 'left');
			
			$this->db->join($this->tableMasterRating, $this->tableMasterRating.".ratId = ".$this->tableProject.".projRating", 'left');
			$this->db->join($this->tableMasterIndustry, $this->tableMasterIndustry.".IndustryId = ".$this->tableProject.".IndustryId", 'left');
			
			$this->db->join($this->tableLogSummary, $this->tableLogSummary.'.elementId = '.$this->tableProject.'.projId AND  "'.$tableLogSummary.'"."entityId"='.$entityId.' ', 'left');
			
			$this->db->where($this->tableProject.'.isArchive',$isArchive);
			if(!empty($projectType)){
				$this->db->where($this->tableProject.'.projectType',$projectType);				
			}
			if($UserId > 0){
				$this->db->where($this->tableProject.'.tdsUid',$UserId);						
			}
			if($projectId > 0){
				$this->db->where($this->tableProject.'.projId',$projectId);						
			}
			$this->db->order_by($this->tableProject.'.projLastModifyDate', 'DESC'); 
			if($limit > 0){
				$this->db->limit($limit);						
			}
			$query = $this->db->get();
			//echo $this->db->last_query();
			return $result=$query->result();
		
		
	}
    
    public function getProjectInfo($projectId=0,$IndustryId=0,$UserId=0){
		
            if((int)$projectId > 0){
                $this->db->select($this->tableProject.'.*');
                $this->db->select($this->tableProjCategory.'.category');
                
                $this->db->from($this->tableProject);
                $this->db->join($this->tableProjCategory, $this->tableProjCategory.".catId = ".$this->tableProject.".projCategory", 'left');
                
                if((int)$IndustryId > 0){
                    $this->db->where($this->tableProject.'.IndustryId',$IndustryId);				
                }
                if((int)$UserId > 0){
                    $this->db->where($this->tableProject.'.tdsUid',$UserId);						
                }
                
                $this->db->where($this->tableProject.'.projId',$projectId);
                $this->db->limit(1);
                $result = $this->db->get();
                if($result){
                     return $result->result_array();	
                }
			}
            return false;
	}
	/**
	 * getProjectElements fucntion 
	 *
	 * getProjectElements call by  getProject function 
	 *
	 * @access	private
	 * @param	string
	 * @return	Object
	 */
	public function getProjectElements($projId=0,$elementTblPrefix='Fv', $elementId=0,$orderby='order',$order='ASC',$offSet=0,$perPage=0,$isResultInArray=false)
	{
	   //  Get Project elemnet data from table : (FvMedia, MaSong), ProjActivity, MediaFile
		$elementTable=$elementTblPrefix.$this->tableElement;
		$table=$this->db->dbprefix($elementTable);			
		$tableLogSummary=$this->db->dbprefix($this->tableLogSummary);			
		$entityId=getMasterTableRecord($table);			

			
		
		$this->db->select($this->tableMediaEelementType.'.*');
		$this->db->select($this->tableLogSummary.'.*');
		$this->db->select($elementTable.'.*');
		$this->db->select($this->tableMediaFile.'.*');
		$this->db->from($elementTable);
		$this->db->join($this->tableMediaEelementType, $this->tableMediaEelementType.".elementTypeId = ".$elementTable.".mediaTypeId", 'left');
		$this->db->join($this->tableLogSummary, $this->tableLogSummary.'.elementId = '.$elementTable.'.elementId AND  "'.$tableLogSummary.'"."entityId"='.$entityId.' ', 'left');
		$this->db->join($this->tableMediaFile, $this->tableMediaFile.".fileId = ".$elementTable.".fileId", 'left');
		if($elementTable=='NewsElement' || $elementTable=='ReviewsElement'){
			if($elementTable=='ReviewsElement'){
				$this->db->select($elementTable.'.userId as "fromUserId"');	
			}
			$this->db->select($this->tableMasterIndustry.'.*');
			$this->db->join($this->tableMasterIndustry, $this->tableMasterIndustry.".IndustryId = ".$elementTable.".industryId", 'left');
		}else{
			$this->db->where($elementTable.'.mediaTypeId >',0);
		}
		
		$this->db->where($elementTable.'.projId',$projId);
		
		if($elementId>0){	
			$this->db->where($elementTable.'.elementId',$elementId);
		}		
		
		
		if($orderby=='order'){
			$this->db->order_by($this->tableMediaEelementType.".".$orderby, $order);
		}else{
			$this->db->order_by($elementTable.".".$orderby, $order);
		}
		
		if($perPage > 0 || $offSet > 0){
			$this->db->limit($perPage,$offSet);
		} 
		$query = $this->db->get();
		$result=$isResultInArray?$query->result_array():$query->result();
		return $result;
	}
	
	public function getPojectElementsNmedia($projId=0,$elementTable='',$elementId=0)
	{
		$result =false;
		
		if($projId >0 && $elementTable !=''){
			$this->db->select($this->tableMediaFile.'.*, '.$this->tableMediaFile.'.fileId as "mediaFileId", '.$this->tableMediaFile.'.rawFileName as "mediaRawFileName"');
			$this->db->select($elementTable.'.*');
			$this->db->from($elementTable);
			$this->db->join($this->tableMediaFile, $this->tableMediaFile.".fileId = ".$elementTable.".fileId", 'left');
			$this->db->where($elementTable.'.projId',$projId);
			if(is_numeric($elementId) && ($elementId>0)){
				$this->db->where($elementTable.'.elementId',$elementId);
			}
			$query = $this->db->get();
			$result=$query->result_array();
		}
		return $result;
	}
	
    public function getPojectNewsNReview($projId=0,$elementTable='',$elementId=0)
	{
		$result =false;
		
		if($projId >0 && $elementTable !=''){
			$this->db->select($elementTable.'.*');
			$this->db->from($elementTable);
			$this->db->where($elementTable.'.projId',$projId);
			if(is_numeric($elementId) && ($elementId>0)){
				$this->db->where($elementTable.'.elementId',$elementId);
			}
			$query = $this->db->get();
			$result=$query->result_array();
		}
		return $result;
	}
    
	/**
	 * getProjectOffer fucntion 
	 *
	 * getProjectOffer call by  getProject function 
	 *
	 * @access	private
	 * @param	string
	 * @return	Object
	 */
	private function getProjectOffer($projId=0, $offerTable){
		//  Get Project offer data from table : (FvOffer, MaOffer)
		$date=date('Y-m-d');
		$this->db->select('*');
		$this->db->from($offerTable);
		$this->db->where('projId',$projId);
		$this->db->where('offerEndDate >=',$date);
		$this->db->order_by("offerEndDate", "desc"); 
		$query = $this->db->get();
		$result=$query->result();
		return $result;
	}
	
	
	/**
	 * Function to Add Review 
	 *
	 * addReview call by  updateReview function 
	 * Amit Wali
	 * @access	public
	 * @param	string
	 * @return	Object
	 */
	
	public function addReview($data){	
		$this->db->insert($this->tableReviewsElement, $data); 		
		return $this->db->insert_id(); 
	}
		
	/**
	 * Function to Edit Review 
	 *
	 * addReview call by  updateReview function 
	 * Amit Wali
	 * @access	public
	 * @param	string
	 * @return	Object
	 */
	
	public function editReview($data,$elementId,$projectId)	{	
	    $this->db->where('elementId',$elementId);
	    $this->db->where('projId',$projectId);		
		$this->db->update($this->tableReviewsElement, $data);		
		$data=array('msg' =>$this->lang->line('msgReviewUpdated'),"projId"=>$projectId,"elemId"=>$elementId);
		echo json_encode($data);			 
	}
	
	
	/**
	 * Function to getReviewId 
	 * Check wheather review is already created or not for user in project table
	 * addReview call by  updateReview function 
	 * Amit Wali
	 * @access	public
	 * @param	string
	 * @return	Object
	 */
		
	public function getReviewId($userId){		
		$this->db->select('projId');
		$this->db->from($this->tableProject);			
		$this->db->where('tdsUid',$userId);			
		$this->db->where('projectType','reviews');
		$query = $this->db->get();
         
		if($query->num_rows()>0)  {     
				return  $query->row()->projId;		
		  } else {			  
		
		 // Get Section belongs to review from MasterTsProduct with duration    
		 $section= $this->model_media->getReviewSection();
		 if(isset($section[0]->allowedSections) && $section[0]->allowedSections!=''){
			 		  
	      $sectionId = $section[0]->allowedSections;
	       // Get Container Id	    
	      $containerId = $this->model_media->getContainerId($sectionId,$userId);	  
		  }	  
			
			if($containerId!='') { 				 
				 $curDate  =  currntDateTime();						 
				 $data=array(								
						'tdsUid'      =>$userId,
						'projCreateDate' =>$curDate ,
						'projCategory' =>'16',
						'projectType' =>'reviews',	
						'userContainerId' =>$containerId		
					  ); 
				//  print_r($data);die;
			   $this->db->insert($this->tableProject,$data);
			   $ID =  $this->db->insert_id(); 
			   $this->updateReviewContainer($ID,$containerId);
		       return $ID;  			   
		  } 		  
	   }
	}	
	
	
	/* Update Container For Reviews*/
	
	function updateReviewContainer($Id,$containerId){		
		$data=array(		
			'elementId' =>$Id, 
			'entityId' =>'54'				
			  ); 			  
		 $this->db->where('userContainerId', $containerId);		
		 $this->db->update($this->tableUserContainer, $data);
		 return true;
		}
	
	
	/* Check Log Summary */
	
	public function checkLogSummary($elemId,$proId){
			
		//$entityId = getMasterTableRecord('Product');	
		$this->db->select('reviewCount');
		$this->db->from($this->tableLogSummary);			
		$this->db->where('entityId',95);			
		$this->db->where('elementId',$elemId);
		$query = $this->db->get();
		
		if($query->num_rows()>0)  {			
				  $rCount = $query->row()->reviewCount;			          
				  $rCount = $rCount+1;			          
				  $data=array('reviewCount'=>$rCount);
					//  print_r($data);die;
					  $this->db->update($this->tableLogSummary,$data);
					  $this->db->where('entityId',95);			
					  $this->db->where('elementId',$elemId);		
		  } else {				   
			 $curDate  =  date('Y-m-d h:i:s');						 
				 $data=array(				
					'entityId'  =>95,
					'elementId'  =>$elemId,						
					'reviewCount' =>1,
					'createDate'  =>$curDate				
				);					
			$this->db->insert($this->tableLogSummary,$data);						
			}
		 $data= array("projId"=>$proId,"elemId"=>$elemId,'msg' =>'');
		 echo json_encode($data);				
	}
	
	
	/* Check Review Section detail */
	 
	function getReviewSection(){		
		 $this->db->select('duration,allowedSections');
		 $this->db->from($this->tableMasterTsProduct);				
		 $this->db->where('tsProductId','4');
		 $query = $this->db->get();		 	
		 $result=$query->result();
		 return $result;
	}
	
	/* Check User Container ID */
	function getContainerId($section,$id){		
		$this->db->select('userContainerId');
		$this->db->from($this->tableUserContainer);				
		$this->db->where('pkgSections',$section);
		$this->db->where('tdsUid',$id);
		$query = $this->db->get();		 	
	    return $query->row()->userContainerId;		
		}
	
	
		
	/**
	 * Function to get all Review's  
	 * 
	 * addReview call by  getReviewList function 
	 * Amit Wali
	 * @access	public
	 * @param	string
	 * @return	Object
	 */
	
	 function getAllReview ($entityId,$projectElementId,$offSet=0,$perPage=0) {
		 
		 $table=$this->db->dbprefix('TDS');
		 $tableLogSummary = $this->db->dbprefix($this->tableLogSummary);	
		 $tableReviewsElement = $this->db->dbprefix($this->tableReviewsElement);		
		$this->db->select($this->tableReviewsElement.'.*, '.$this->tableUserShowcase.'.profileImageName, '.$this->tableUserAuth.'.username, '.$this->tableLogSummary.'.craveCount, '.$this->tableLogSummary.'.viewCount');		
		$this->db->select($this->UserProfile.'.firstName,'.$this->UserProfile.'.lastName');	
		$this->db->from($this->tableReviewsElement);
		$this->db->join($this->tableProject, $this->tableProject.".projId = ".$this->tableReviewsElement.".projId", 'left');
		$this->db->join($this->tableUserShowcase, $this->tableUserShowcase.".tdsUid = ".$this->tableReviewsElement.".userId", 'left');
		$this->db->join($this->UserProfile, $this->UserProfile.".tdsUid = ".$this->tableReviewsElement.".userId", 'left');
		$this->db->join($this->tableUserAuth, $this->tableUserAuth.".tdsUid = ".$this->tableReviewsElement.".userId", 'left');
				
		$this->db->join($this->tableLogSummary, $this->tableLogSummary.'.entityId = '.$this->tableReviewsElement.'.entityId AND "'.$tableLogSummary.'"."elementId" ="'.$tableReviewsElement.'"."elementId"' ,'left');
		$this->db->where($this->tableProject.'.projectType','reviews');
		$this->db->where($this->tableReviewsElement.'.entityId',$entityId); 
		$this->db->where($this->tableReviewsElement.'.projectElementId',$projectElementId);
		$this->db->where($this->tableReviewsElement.'.isPublished','t');
		$this->db->order_by($this->tableReviewsElement.'.elementId','desc'); 
		
		if($offSet>0 || $perPage>0){
			$this->db->limit($perPage,$offSet);
		}	
		
			
		$query = $this->db->get();
		//echo $this->db->last_query(); die;
		return $result=$query->result();		 
	 }
	
	
	function getAllReviewCount ($entityId,$projectElementId) {
		 
		 $table=$this->db->dbprefix('TDS');
		 $tableLogSummary = $this->db->dbprefix($this->tableLogSummary);	
		 $tableReviewsElement = $this->db->dbprefix($this->tableReviewsElement);
		$this->db->select($this->tableReviewsElement.'.*, '.$this->tableUserShowcase.'.profileImageName, '.$this->tableUserAuth.'.username, '.$this->tableLogSummary.'.craveCount, '.$this->tableLogSummary.'.viewCount');
		$this->db->select($this->UserProfile.'.firstName,'.$this->UserProfile.'.lastName');	
		$this->db->from($this->tableReviewsElement);
		$this->db->join($this->tableProject, $this->tableProject.".projId = ".$this->tableReviewsElement.".projId", 'left');
		$this->db->join($this->tableUserShowcase, $this->tableUserShowcase.".tdsUid = ".$this->tableReviewsElement.".userId", 'left');
		$this->db->join($this->UserProfile, $this->UserProfile.".tdsUid = ".$this->tableReviewsElement.".tdsUid", 'left');
		
		$this->db->join($this->tableUserAuth, $this->tableUserAuth.".tdsUid = ".$this->tableReviewsElement.".userId", 'left');
		$this->db->join($this->tableLogSummary, $this->tableLogSummary.'.entityId = '.$this->tableReviewsElement.'.entityId AND "'.$tableLogSummary.'"."elementId" ="'.$tableReviewsElement.'"."elementId"' ,'left');
		
		//$this->db->join($this->tableLogSummary, $this->tableLogSummary.".elementId = ".$this->tableReviewsElement.".elementId", 'left');
				
		$this->db->where($this->tableProject.'.projectType','reviews');
		$this->db->where($this->tableReviewsElement.'.entityId',$entityId); 
		$this->db->where($this->tableReviewsElement.'.projectElementId',$projectElementId);
		$this->db->where($this->tableReviewsElement.'.isPublished','t');
		$this->db->order_by($this->tableReviewsElement.'.elementId','desc'); 
		
		$query = $this->db->get();
		//echo $this->db->last_query(); die;
		return $result=$query->result();
		 
	 }
	 
	 
	 function suportLinks ($where) {
		
		$this->db->select($this->SupportLink.'.*');
		$this->db->from($this->SupportLink);
		$this->db->where($where);
		$this->db->order_by($this->SupportLink.'.order','ASC'); 
		
		$query = $this->db->get();
		
		//echo $this->db->last_query(); die;
		$results = $query->result_array();
		
		
		
		if($results){
			foreach($results as $key=>$res){
				$result[$res['order']]=$res;
				$table = getMasterTableName($entityId=$res['entityid_from']);
				if(isset($table[0])){
					$table=$table[0];
				}else{
					$table='Project';
				}
				
				
				if(strstr($table,'Project')){
						$field='projName as title,projBaseImgPath as image, projectType as section, projId';
						$whereCondition=array('projId'=>$res['elementid_from'],'isPublished' =>'t');
				}elseif(strstr($table,'Events') || strstr($table,'LaunchEvent')){
					if(strstr($table,'Events')){
						$field='"Title" as title, "posterImage" as image, "FileId" as "fileId", "EventId" as "projId"';
						$whereCondition=array('EventId'=>$res['elementid_from'],'isPublished' =>'t');
					}else{
						$field='"Title" as title, "posterImage" as image, "FileId" as "fileId", "LaunchEventId" as "projId"';
						$whereCondition=array('LaunchEventId'=>$res['elementid_from'],'isPublished' =>'t');
					}
						
				}else{
						$field='title, imagePath as image, fileId, projId';
						$whereCondition=array('elementId'=>$res['elementid_from'],'isPublished' =>'t');
				}
				$sectionRes=$this->model_common->getDataFromTabel($table,$field,  $whereCondition, '', '', '', 1 );
				
				if($sectionRes){
					$result[$res['order']]['title']=$sectionRes[0]->title;
					$result[$res['order']]['image']=$sectionRes[0]->image;
					$result[$res['order']]['projId']=$sectionRes[0]->projId;
					if(isset($sectionRes[0]->section)){
						$result[$res['order']]['section']=$sectionRes[0]->section;
					}else{
						$result[$res['order']]['section']=$table;
					}
					if(strstr($table,'PaElement')){
						$result[$res['order']]['fileId']=$sectionRes[0]->fileId;
					}else{
						$result[$res['order']]['fileId']=0;
					}
				}else{
					unset($result[$res['order']]);
				}
			}
			return $result;
		}else{
			return false;
		}
		 
	 }
	 
	 function getCurrentElemSection($elementId,$elementTable)
	 {		 
		 $this->db->select($elementTable.'.industryId');
		 $this->db->from($elementTable);
		 $this->db->where('elementId',$elementId);
		 $this->db->limit(1);
		 $query = $this->db->get();
		 $result=$query->result();
		 if($result){
			 return $result[0]->industryId;
		 }
		//echo $this->db->last_query(); die;
		return  0;		 
	 }
	 
	 public function getDownloadFile($FD =''){
		
		if(isset($FD['elementTable'])){
			$tableLogSummary=$this->db->dbprefix($this->tableLogSummary);
			$this->db->select($this->tableProject.'.projPrice, '.$this->tableProject.'.projId, '.$this->tableProject.'.tdsUid, '.$this->tableProject.'.projName, '.$this->tableProject.'.projDownloadPrice, '.$this->tableProject.'.projSellstatus, '.$this->tableProject.'.isprojPrice, '.$this->tableProject.'.isprojDownloadPrice');
			$this->db->select($FD['elementTable'].'.*');
			$this->db->select($this->tableLogSummary.'.craveCount,'.$this->tableLogSummary.'.viewCount,'.$this->tableLogSummary.'.ratingAvg,'.$this->tableLogSummary.'.reviewCount,'.$this->tableLogSummary.'.dwnCount,'.$this->tableLogSummary.'.ppvCount');
			$this->db->select('MediaFile.*');

			
			$this->db->from($this->tableProject);
			$this->db->join($FD['elementTable'], $FD['elementTable'].'.projId  = '.$this->tableProject.'.projId', 'left');
			$this->db->join($this->tableLogSummary, $this->tableLogSummary.'.elementId = '.$FD['elementTable'].'.elementId AND  "'.$tableLogSummary.'"."entityId"='.$FD['entityId'].' ', 'left');
			$this->db->join('MediaFile','MediaFile.fileId  = '.$FD['elementTable'].'.fileId', 'left');
			
			
			if($FD['elementTable'] !='NewsElement' && $FD['elementTable'] !='ReviewsElement'){
				$this->db->join($this->tableMediaEelementType, $this->tableMediaEelementType.".elementTypeId = ".$FD['elementTable'].".mediaTypeId", 'left');
				$this->db->where($FD['elementTable'].'.mediaTypeId >',0);
				$this->db->order_by($this->tableMediaEelementType.".order", 'ASC');
			}else{
				$this->db->order_by($FD['elementTable'].".elementId", 'DESC');
			}
			
			$this->db->where($this->tableProject.'.projId',$FD['projectId']);
			$this->db->where($this->tableProject.'.tdsUid',$FD['userId']);
			
			if(!(is_numeric($FD['dwnId']) && $FD['dwnId'] > 0)){
				$this->db->where($FD['elementTable'].'.isDownloadPrice','f');
				$this->db->where($this->tableProject.'.isPublished','t');
				$this->db->where($FD['elementTable'].'.isPublished','t');
			}
			if(isset($FD['isPPV']) && is_numeric($FD['isPPV']) && $FD['isPPV'] ==1){
				if(isset($FD['elementId']) && is_numeric($FD['elementId']) && $FD['elementId'] >0){
					$this->db->where($FD['elementTable'].'.elementId',$FD['elementId']);
				}
			}else{
				$this->db->where('MediaFile.isExternal','f');
			}
			$query = $this->db->get();
			return $result=$query->result_array();
		}else{
			return false;
		}
	}
	
	/*
	 * Function to get media project data 
	 */
	public function getProjectData($UserId=0,$projectType='',$projectId=0,$elementTblPrefix='Fv',$orderby='order',$order='ASC',$limit=0,$isArchive='f'){		
		if($isArchive !== 't'){ $isArchive='f';}
		$result = $this->getProjectRecord($projectType,$UserId,$projectId,$limit,$isArchive);
		$entityId=getMasterTableRecord('Project');
		if($result){
			$elementTable=$elementTblPrefix.$this->tableElement;
			$elementEntityId=getMasterTableRecord($elementTable);
			foreach($result as $key=>$data){
				if(!empty($elementTblPrefix)){
					$elements=$this->getProjectElements($data->projId,$elementTblPrefix,0,$orderby,$order);
					$result[$key]->elements=$elements;
				}
			}
		}
		return $result;
	}
	
	
	/*
	 ********************************* 
	 * This function is used to get craved data by userId 
	 ********************************* 
	 */ 
	
	function getUserCravedData($userId){
		
		$entityId=getMasterTableRecord('MaElement'); // set entity Id
		$projType='12'; // music category= music set proj Type
		$tableLogSummary=$this->db->dbprefix($this->tableLogSummary);
		$tableMediaFile=$this->db->dbprefix($this->tableMediaFile);
		$this->db->select($this->tableLogCrave.'.*');
		$this->db->select($this->tableMaElement.'.*');
		$this->db->select($this->tableLogSummary.'.viewCount,'.$this->tableLogSummary.'.craveCount');
		$this->db->select($this->tableMediaFile.'.*');
		
		$this->db->from($this->tableLogCrave);
		$this->db->join($this->tableMaElement, $this->tableMaElement.'.elementId  = '.$this->tableLogCrave.'.elementId');
		$this->db->join($this->tableProject, $this->tableProject.'.projId  = '.$this->tableMaElement.'.projId');
		$this->db->join($this->tableLogSummary, $this->tableLogSummary.'.elementId = '.$this->tableMaElement.'.elementId AND  "'.$tableLogSummary.'"."entityId"='.$entityId);
		$this->db->join($this->tableMediaFile, $this->tableMediaFile.'.fileId  = '.$this->tableMaElement.'.fileId AND "'.$tableMediaFile.'"."isExternal" = false');	
				
		$this->db->where($this->tableLogCrave.'.tdsUid',$userId);
		$this->db->where($this->tableLogCrave.'.entityId',$entityId);
		$this->db->where($this->tableLogCrave.'.deletedPlayList','f');
		$this->db->where($this->tableProject.'.isPublished','t');
		$this->db->where($this->tableMaElement.'.isPublished','t');
		//$this->db->where($this->tableMaElement.'.isPrice','f');
		$this->db->where($this->tableProject.'.projType',$projType);
		$query = $this->db->get();
		return $result=$query->result_array();
	}
	
	//----------------------------------------------------------------------

	/*
	 * @access: public
	 * @description: This function is used to get user's profile data 
	 * @return array
	 */ 
	public function getUserProfileData($userId)
	{
		$this->db->select($this->UserSearchPreferences.'.*');
		$this->db->select($this->UserSellerSettings.'.*, '.$this->UserSellerSettings.'.id as "userSellerSettingsId"');
		$this->db->select($this->UserBuyerSettings.'.*, '.$this->UserSellerSettings.'.id as "userBuyerSettingsId"');
		$this->db->select($this->UserProfile.'.*');
		$this->db->select($this->tableUserAuth.'.password,'.$this->tableUserAuth.'.email,'.$this->tableUserAuth.'.new_email,'.$this->tableUserAuth.'.new_email_key,');
		$this->db->from($this->UserProfile);
		$this->db->join($this->tableUserAuth, $this->tableUserAuth.'.tdsUid = '.$this->UserProfile.'.tdsUid','left');
		$this->db->join($this->UserSearchPreferences, $this->UserSearchPreferences.'.tdsUid = '.$this->tableUserAuth.'.tdsUid','left');
		$this->db->join($this->UserSellerSettings, $this->UserSellerSettings.'.tdsUid = '.$this->tableUserAuth.'.tdsUid','left');
		$this->db->join($this->UserBuyerSettings, $this->UserBuyerSettings.'.tdsUid = '.$this->tableUserAuth.'.tdsUid','left');
		$this->db->where($this->UserProfile.'.tdsUid', $userId);
		$query = $this->db->get();
		//echo $this->db->last_query();
		if ($query->num_rows()) return $query->result();
		return false;
	}
	
	//----------------------------------------------------------------------

	/*
	 * @access: public
	 * @description: This function is used to update cart billing data 
	 * @return array
	 */ 
	public function updateBillingData($billingData,$cartId) {
		$this->db->where('cartId', $cartId);		
		$this->db->update($this->tableMembershipCart, $billingData);
		return true;
	}
	
	//----------------------------------------------------------------------

	/*
	 * @access: public
	 * @description: This function is used to get current cart details
	 * @return array
	 */ 
	function getCurrentCartData($cartId) {	
		
		$this->db->select($this->tableMembershipCart.'.totalPrice,'.$this->tableMembershipCart.'.totalTaxAmt');
		$this->db->select($this->tableMembershipCartItem.'.price,'.$this->tableMembershipCartItem.'.size');	
		$this->db->from($this->tableMembershipCart);
		$this->db->join($this->tableMembershipCartItem,$this->tableMembershipCartItem.'.cartId = '.$this->tableMembershipCart.'.cartId');
		$this->db->where($this->tableMembershipCart.'.cartId',$cartId);	
		$this->db->where($this->tableMembershipCartItem.'.type','2');
		$this->db->order_by('cartItemId','asc');	
		$query = $this->db->get();
		//echo $this->db->last_query();
		$result = $query->row();		
		return $result;
   }
   
   //----------------------------------------------------------------------

	/* 
	 * @access: public
	 * @description: This function is used to get user's global pickup data data 
	 * @return array
	 */ 
	public function getGlobalPickupData($userId) {
		$this->db->select('uss.pickup_country as pickupCountry, uss.pickup_state as pickupState, uss.pickup_city as pickupCity, uss.pickup_subrub as pickupSubrub, uss.pickup_zip as pickupZip, uss.pickup_requirements as pickupRequirements');
		$this->db->from($this->UserSellerSettings. ' uss');
		$this->db->where('uss.tdsUid', $userId);
		$query = $this->db->get();
		if ($query->num_rows()) return $query->result();
		return false;
	}	
	
	
   //----------------------------------------------------------------------

	/* 
	 * @access: public
	 * @description: This function is used to add pickup data
	 * @return array
	 */ 
	public function addPickup($data){	
		$this->db->insert($this->tableProjectShippingPickup, $data); 		
		return $this->db->insert_id(); 
	}
	
    //----------------------------------------------------------------------

	/* 
	 * @access: public
	 * @description: This function is used to update pickup data
	 * @return array
	 */ 
	public function updatePickup($pickupId,$pickupData) {
        $this->db->where('pickupId',$pickupId);		
		$this->db->update($this->tableProjectShippingPickup, $pickupData); 		
		return true; 
	}
    
    //----------------------------------------------------------------------

    /* 
    * @access: public
    * @description: This function is used to get project's pickup data data 
    * @return array
    */ 
    public function getProjectPickupData($elementId,$userId,$entityId='') {
        $this->db->select('psp.pickupId,psp.pickupCountry as pickupcountry, psp.pickupState as pickupstate, psp.pickupCity as pickupcity, psp.pickupSubrub as pickupsubrub, psp.pickupZip as pickupzip, psp.pickupRequirements as pickuprequirements');
        $this->db->from($this->tableProjectShippingPickup. ' psp');
        $this->db->where('psp.elementId', $elementId);
        if(!empty($entityId)) {
            $this->db->where('psp.entityId', $entityId);
        }
        $this->db->where('psp.tdsUid', $userId);
        $query = $this->db->get();
        if ($query->num_rows()) return $query->result();
        return false;
    }
    
    //----------------------------------------------------------------------

	/* 
	 * @access: public
	 * @description: This function is used to get user's global internation shippings
	 * @return array
	 */ 
    function globalShippingList($userId=0,$elementId=0,$spId=0,$entityId=''){
		$result = false;
		if($userId > 0) {
			$whereField=array(
				'userId'=>$userId,
				'isGlobal'=>'f',
			);
			if($spId) {
				$whereField['spId'] = $spId;
            }
            if($elementId) {
				$whereField['elementId'] = $elementId;
            }
            if(!empty($entityId)) {
                $whereField['entityId'] = $entityId;
            }
			$this->db->select('*');
			$this->db->from($this->tblShipping);
			$this->db->where($whereField);
			$this->db->order_by('spId', 'ASC');
			
			$query 	= $this->db->get();
			$result = $query->result_array();
	  }
		return $result;
	}
    
    function globalShippingCountryList($userId=0,$elementId=0,$spId=0) {
		$countirsInZone=false;
		$where=array(
            'userId'=>$userId,
            'spId'=>$spId,
            //'elementId'=>$elementId,
            'isGlobal'=>'f',
		);
		
		$this->db->select('countriesId');
		$this->db->from($this->tblShipping);
		$this->db->where($where);
		if(is_numeric($spId) && ($spId>0) ) {
			//$this->db->where_not_in('spId',$spId);
            //$this->db->where('spId',$spId);
		}
		
		$query 	= $this->db->get();
		$result = $query->result();
		if($result){
			foreach($result as $k=>$countries){
				$countriesId=$countries->countriesId;
				$countriesId=explode('|',$countriesId);
				if($k==0){
					$countirsInZone=$countriesId;
				}else{
					$countirsInZone = array_merge((array)$countirsInZone, (array)$countriesId);
				}
			}
			$countirsInZone=array_diff($countirsInZone, array(''));
		}
		
		$tblCountry = $this->db->dbprefix($this->tblCountry);
		$where = array($tblCountry.'.status'=>1);
		
		$this->db->select('countryName,countryId,continentId,continent');
		$this->db->from($this->tblCountry);
		$this->db->join($this->tblContinent, $this->tblContinent.".id = ".$this->tblCountry.".continentId");
		$this->db->where($where);
		if($countirsInZone && is_array($countirsInZone) && !empty($countirsInZone)){
			//$this->db->where_not_in('countryId',$countirsInZone);
		}
		$this->db->order_by('continent', 'ASC');
		$this->db->order_by('countryName', 'ASC');
		$query 	= $this->db->get();
		//echo $this->db->last_query(); die;
		$res = $query->result();
		return $res;
	}
    
    function globalShippingZoneCountryList($userId=0,$elementId=0,$spId=0) {
        $where=array(
            'userId'=>$userId,
            //'elementId'=>$elementId,
             'spId'=>$spId,
            'isGlobal'=>'f',
		);
        
		
		$this->db->select('countriesId');
		$this->db->from($this->tblShipping);
		$this->db->where($where);
		if(is_numeric($spId) && ($spId>0) ){
			//$this->db->where_not_in('spId',$spId);
            $this->db->where('spId',$spId);
		}
		
		$query 	= $this->db->get();
		$result = $query->result();
		if($result){
            $zoneCountries = array();
			foreach($result as $k=>$countries){
				$countriesId=$countries->countriesId;
				$countriesId=explode('|',$countriesId);
				if($k==0){
					$countirsInZone=$countriesId;
				}else{
					$countirsInZone = array_merge((array)$countirsInZone, (array)$countriesId);
				}
			}
			$countirsInZone=array_diff($countirsInZone, array(''));
            //$countirsInZone = array_push($zoneCountries,$countirsInZone);
		}
        return $countirsInZone;
     }
     
    //----------------------------------------------------------------------

    /* 
    * @access: public
    * @description: This function is used to get project's pickup data data 
    * @return array
    */ 
    public function getToadUsersData($profileType=0,$keyword='',$firstName='',$lastName='',$limit=0,$offset=0) {
        $this->db->select('*');
        $this->db->from($this->tableUserShowcase);
        // get result on the basis of profile type
        if($profileType == 1) {
            $this->db->where('creative', 't');
        } else if($profileType == 2) {
            $this->db->where('associatedProfessional', 't');
        } else if($profileType == 3) {
            $this->db->where('enterprise', 't');
        }
        // get result by the keayword if exists 
        if(!empty($keyword)) {
            $keyword = pg_escape_string(trim(strtolower($keyword)));
            $this->db->like('LOWER("firstName")', $keyword);
            $this->db->or_like('LOWER("lastName")', $keyword);
            $this->db->or_like('LOWER("tagwords")', $keyword);
            $this->db->or_like('LOWER("creativeFocus")', $keyword);
        }
        // like first name 
        if(!empty($firstName)) {
            $this->db->like('LOWER("firstName")', trim(strtolower($firstName)));
        }
         // like last name
        if(!empty($lastName)) {
            $this->db->like('LOWER("lastName")', trim(strtolower($lastName)));
        }
        
        $this->db->where('isBlocked', 'f');
        if(!empty($limit) && !empty($offset)) {
            $this->db->limit($limit);
            $this->db->offset($offset);
        }
        $query = $this->db->get();
       
        return $query->result(); 
    }
    
    //----------------------------------------------------------------------

    /* 
    * @access: public
    * @description: This function is used to user's showcase details
    * @return array
    */ 
    function getshowcasedetail($showcaseId=0,$userId=0) {
        
        $userId = ($userId>0)?$userId:isLoginUser();
        
        if($showcaseId > 0 || $userId>0) {
            $entityId = getMasterTableRecord('UserShowcase');
            $tableLogSummary=$this->db->dbprefix($this->tableLogSummary);
            $this->db->select('*,'.$this->tableUserShowcase.'.tdsUid as "tdsUid",'.$this->tableUserShowcase.'.creativePath as "creativePath",'.$this->tableUserShowcase.'.creativeFocus as "creativeFocus",'.$this->tableUserShowcase.'.enterpriseName as "enterpriseName" ,'.$this->tableUserShowcase.'.tagwords as "tagwords",'.$this->tableUserShowcase.'.creativePath as "creativePath"');
            $this->db->select($this->tableUserProfile.'.firstName as "firstName",'.$this->tableUserProfile.'.lastName as "lastName"');
            $this->db->from($this->tableUserShowcase);
            $this->db->join($this->tableStockImages, $this->tableStockImages.".stockImgId = ".$this->tableUserShowcase.".stockImageId", 'left');
            $this->db->join($this->tableUserAuth, $this->tableUserAuth.'.tdsUid = '.$this->tableUserShowcase.'.tdsUid','left');
            $this->db->join($this->tableUserProfile, $this->tableUserProfile.'.tdsUid = '.$this->tableUserShowcase.'.tdsUid','left');
            $this->db->join("MediaFile", "MediaFile.fileId = ".$this->tableUserShowcase.".interviewFileId", 'left');	
            $this->db->join($this->tableMasterCountry, $this->tableMasterCountry.".countryId = ".$this->tableUserProfile.".countryId", 'left');
            $this->db->join($this->tableMasterIndustry, $this->tableMasterIndustry.".IndustryId = ".$this->tableUserProfile.".industryId", 'left');
            $this->db->join('AssociatedEnterprise',"AssociatedEnterprise.to_showcaseid = ".$this->tableUserShowcase.".showcaseId", 'left');	
            //$this->db->join($this->tableLogSummary, $this->tableLogSummary.'.elementId = '.$this->tableUserShowcase.'.showcaseId AND "'.$tableLogSummary.'"."entityId"='.$entityId.'', 'left');
            
            if($showcaseId > 0){
                $this->db->where($this->tableUserShowcase.'.showcaseId', $showcaseId);
            }
            if($userId > 0){
                $this->db->where($this->tableUserShowcase.'.tdsUid',$userId);
            }
            
            $query = $this->db->limit(1);
            $query = $this->db->get();
            //echo $this->db->last_query();
            if ($query->num_rows() > 0){
                return $query->result();
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
    
    //----------------------------------------------------------------------

    /* 
    * @access: public
    * @description: This function is used to get media's element data if creative members exists
    * @return array
    */ 
    function getMediaCreativeElements($projectId,$elementTblPrefix,$elementId=0) {
        // get media element table name
        $mediaElementTbl = $elementTblPrefix.'Element';
        // get entity id
        $entityId = getMasterTableRecord($mediaElementTbl);
        $this->db->select($this->tableAssociativeCreatives.'.elementId');
        $this->db->from($this->tableAssociativeCreatives);  
        $this->db->join($mediaElementTbl, $mediaElementTbl.".elementId = ".$this->tableAssociativeCreatives.".elementId");
        $this->db->where($this->tableAssociativeCreatives.'.entityId', $entityId);
        $this->db->where( $mediaElementTbl.'.projId', $projectId);
        if($elementId > 0) {
            $this->db->where( $mediaElementTbl.'.elementId != ', $elementId);
        }
        $this->db->distinct();
        $query = $this->db->get();
        return $query->result();  
    }
    

    //--------------------------------------------------------------------------
    
    /*
    * @access: public 
    * @descripton: This method is use to show all project list
    * @param: $userId
    * @param: $projectType
    * @param: $projectId
    * @param: $elementTblPrefix
    * @param: $isArchive
    * @return: object 
    * @auther: lokendra meena
    */ 

     //----------------------------------------------------------------------

    public function projectlist($userId,$projectType,$projectId=0,$isArchive='f'){
        
        $table              =   $this->db->dbprefix($this->tableProject); //get db prefix
        $entityId           =   getMasterTableRecord($table);	// get entityId of project table
        $tableLogSummary    =   $this->db->dbprefix($this->tableLogSummary); // get db prefix
                    
        $this->db->select($this->tableProject.'.*');
        $this->db->select($this->tableUserShowcase.'.showcaseId,'.$this->tableUserShowcase.'.creative,'.$this->tableUserShowcase.'.associatedProfessional,'.$this->tableUserShowcase.'.enterprise,'.$this->tableUserShowcase.'.enterpriseName,'.$this->tableUserShowcase.'.optionAreaName');
        $this->db->select($this->UserProfile.'.*');
        $this->db->select($this->tableGenre.'.*');
        $this->db->select($this->tableProjectType.'.*');
        $this->db->select($this->tableProjCategory.'.*');
        $this->db->select($this->tableUserContainer.'.*');
        $this->db->select($this->tableMasterRating.'.*');
        $this->db->select($this->tableMasterIndustry.'.*');
        $this->db->select($this->tableMasterLang.'.*');
        $this->db->select('c1.*');
        $this->db->select('c2.Language_local as "projSubtitle1"');
        $this->db->select('c3.Language_local as "projSubtitle2"');
        $this->db->select('c4.Language_local as "projDubbing1"');
        $this->db->select('c5.Language_local as "projDubbing2"');
        $this->db->select($this->tableLogSummary.'.*');
        $this->db->select($this->tableProject.'.projId as projectid, '.$this->tableProject.'.IndustryId as projectIndustryId, '.$this->tableProject.'.isPublished as "isPublished", '.$this->tableProject.'.isExpired as "isExpired", '.$this->tableProject.'.isBlocked as "isBlocked"');
        
        $this->db->from($this->tableProject);
        
        $this->db->join($this->tableUserShowcase, $this->tableUserShowcase.".tdsUid = ".$this->tableProject.".tdsUid", 'left');
        $this->db->join($this->UserProfile, $this->UserProfile.".tdsUid = ".$this->tableProject.".tdsUid", 'left');
        $this->db->join($this->tableGenre, $this->tableGenre.".GenreId = ".$this->tableProject.".projGenre", 'left');
        $this->db->join($this->tableProjectType, $this->tableProjectType.".typeId = ".$this->tableProject.".projType", 'left');
        $this->db->join($this->tableProjCategory, $this->tableProjCategory.".catId = ".$this->tableProject.".projCategory", 'left');
        $this->db->join($this->tableUserContainer, $this->tableUserContainer.".userContainerId = ".$this->tableProject.".userContainerId", 'left');
        $this->db->join($this->tableMasterLang, $this->tableMasterLang.".langId = ".$this->tableProject.".projLanguage", 'left');
        $this->db->join($this->tableMasterCountry." c1", "c1.countryId = ".$this->tableProject.".producedInCountry", 'left');
        $this->db->join($this->tableMasterLang." c2", "c2.langId = ".$this->tableProject.".projSubtitle1", 'left');
        $this->db->join($this->tableMasterLang." c3", "c3.langId = ".$this->tableProject.".projSubtitle2", 'left');
        $this->db->join($this->tableMasterLang." c4", "c4.langId = ".$this->tableProject.".projDubbing1", 'left');
        $this->db->join($this->tableMasterLang." c5", "c5.langId = ".$this->tableProject.".projDubbing1", 'left');
        
        $this->db->join($this->tableMasterRating, $this->tableMasterRating.".ratId = ".$this->tableProject.".projRating", 'left');
        $this->db->join($this->tableMasterIndustry, $this->tableMasterIndustry.".IndustryId = ".$this->tableProject.".IndustryId", 'left');
        
        $this->db->join($this->tableLogSummary, $this->tableLogSummary.'.elementId = '.$this->tableProject.'.projId AND  "'.$tableLogSummary.'"."entityId"='.$entityId.' ', 'left');
        
        $this->db->where($this->tableProject.'.isArchive',$isArchive);
        $this->db->where($this->tableProject.'.isPublished','t');
         
        if(!empty($projectType)):
            $this->db->where($this->tableProject.'.projectType',$projectType);				
        endif;
        if($userId > 0):
            $this->db->where($this->tableProject.'.tdsUid',$userId);						
        endif;
        if($projectId > 0):
            $this->db->where($this->tableProject.'.projId',$projectId);						
        endif;
        $this->db->order_by($this->tableProject.'.projLastModifyDate', 'DESC'); 
        
        if($limit > 0):
            $this->db->limit($limit);						
        endif;
        $query = $this->db->get();
        
        //echo $this->db->last_query();die();

        return $result=$query->result_array();
    }
    
    
    //-------------------------------------------------------------------------
    
    /*
    * @access: public
    * @description: this method is use to get media project element list 
    * @param:  $projId
    * @param:  $elementTblPrefix
    * @param:  $elementId
    * @return: array
    * @auther: lokendra meena
    */
     
    public function projectelementslist($projId=0,$elementTable, $elementId=0)
    {
        $table=$this->db->dbprefix($elementTable);			
        $tableLogSummary=$this->db->dbprefix($this->tableLogSummary);			
        $entityId=getMasterTableRecord($table);			
        
        $this->db->select($this->tableMediaEelementType.'.*');
        $this->db->select($this->tableLogSummary.'.*');
        $this->db->select($elementTable.'.*');
        $this->db->select($this->tableMediaFile.'.*');
        $this->db->select($this->tableGenre.'.Genre as genrename');
        $this->db->select('c1.*');
        $this->db->select('pc.category as categoryname, pc.catId');
        $this->db->select($this->tableMasterRating.'.*');
        $this->db->select($this->tableProjectType.'.projectTypeName');
        $this->db->from($elementTable);
        $this->db->join($this->tableMediaEelementType, $this->tableMediaEelementType.".elementTypeId = ".$elementTable.".mediaTypeId", 'left');
        $this->db->join($this->tableLogSummary, $this->tableLogSummary.'.elementId = '.$elementTable.'.elementId AND  "'.$tableLogSummary.'"."entityId"='.$entityId.' ', 'left');
        $this->db->join($this->tableMediaFile, $this->tableMediaFile.".fileId = ".$elementTable.".fileId", 'left');
        $this->db->join($this->tableGenre, $this->tableGenre.".GenreId = ".$elementTable.".projGenre", 'left');
        $this->db->join($this->tableMasterCountry." c1", "c1.countryId = ".$elementTable.".producedInCountry", 'left');
        $this->db->join($this->tableProject." proj", "proj.projId = ".$elementTable.".projId", 'left');
        $this->db->join($this->tableProjCategory." pc", "pc.catId = proj.projCategory", 'left');
        $this->db->join($this->tableMasterRating, $this->tableMasterRating.".ratId = proj.projRating", 'left');
        $this->db->join($this->tableProjectType, $this->tableProjectType.".typeId = ".$elementTable.".projType", 'left');
           
       
        $this->db->where($elementTable.'.projId',$projId);
        
        $this->db->where($elementTable.'.isPublished','t');
        $this->db->where($elementTable.'.fileId >','1');
        
        if($elementId>0){	
            $this->db->where($elementTable.'.elementId',$elementId);
        }		
        
        $query = $this->db->get();
        $result=$query->result_array();
        return $result;
    }
    
    //---------------------------------------------------------------------
    
    /*
    * @access: public
    * @description: this method is use to get news and review element list 
    * @param:  $projId
    * @param:  $elementTblPrefix
    * @param:  $elementId
    * @return: array
    * @auther: lokendra meena
    */
    
    public function newsreviewelementslist($projId=0,$elementTable, $elementId=0,$offSet=0,$perPage=0)
    {
        $table=$this->db->dbprefix($elementTable);			
        $tableLogSummary=$this->db->dbprefix($this->tableLogSummary);			
        $entityId=getMasterTableRecord($table);			
        
        $this->db->select($this->tableLogSummary.'.*');
        $this->db->select($elementTable.'.*');
        $this->db->select($this->tableMediaFile.'.*');
        $this->db->select('c1.*');
        $this->db->select('pc.category as categoryname, pc.catId');
        $this->db->select($this->tableMasterRating.'.*');
        $this->db->select($this->tableMasterIndustry.'.*');
        $this->db->select($this->tableMasterLang.'.*');
        $this->db->from($elementTable);
        $this->db->join($this->tableMediaEelementType, $this->tableMediaEelementType.".elementTypeId = ".$elementTable.".mediaTypeId", 'left');
        $this->db->join($this->tableLogSummary, $this->tableLogSummary.'.elementId = '.$elementTable.'.elementId AND  "'.$tableLogSummary.'"."entityId"='.$entityId.' ', 'left');
        $this->db->join($this->tableMediaFile, $this->tableMediaFile.".fileId = ".$elementTable.".fileId", 'left');
        $this->db->join($this->tableMasterCountry." c1", "c1.countryId = ".$elementTable.".producedInCountry", 'left');
        $this->db->join($this->tableProject." proj", "proj.projId = ".$elementTable.".projId", 'left');
        $this->db->join($this->tableProjCategory." pc", "pc.catId = proj.projCategory", 'left');
        $this->db->join($this->tableMasterRating, $this->tableMasterRating.".ratId = proj.projRating", 'left');
        $this->db->join($this->tableMasterIndustry, $this->tableMasterIndustry.".IndustryId = ".$elementTable.".industryId", 'left');
        $this->db->join($this->tableMasterLang, $this->tableMasterLang.".langId = ".$elementTable.".languageId", 'left');
        
        $this->db->where($elementTable.'.projId',$projId);
        
        $this->db->where($elementTable.'.isPublished','t');
        
        if($elementId>0){	
            $this->db->where($elementTable.'.elementId',$elementId);
        }
        
        if($offSet>0 || $perPage>0){
            $this->db->limit($perPage,$offSet);
        }			
        
        $query = $this->db->get();
        $result=$query->result_array();
        
        return $result;
    }
    

    /* 
    * @access: public
    * @description: This function is used to get media's element data
    * @return array
    */ 
    function getMediaElementsGenres($projectId=0,$mediaElementTbl,$elementId=0) {
        
        $this->db->select('elementId');
        $this->db->from($mediaElementTbl);
        $this->db->where( 'projId', $projectId);
        $this->db->where( 'elementId != ', $elementId);
        $this->db->where( 'projGenre != ', 0);
        $query = $this->db->get();
        return $query->result();  
    }
    
    //----------------------------------------------------------------------
    
     function getAllReviewNew($entityId,$projectElementId,$reviewEntityId,$offSet=0,$perPage=0) {
         
        $table=$this->db->dbprefix('TDS');
        $tableLogSummary = $this->db->dbprefix($this->tableLogSummary);	
        $tableReviewsElement = $this->db->dbprefix($this->tableReviewsElement);		
        $this->db->select($this->tableReviewsElement.'.*, '.$this->tableUserShowcase.'.profileImageName, '.$this->tableUserAuth.'.username, '.$this->tableLogSummary.'.craveCount, '.$this->tableLogSummary.'.viewCount, '.$this->tableLogSummary.'.ratingAvg');		
        $this->db->select($this->UserProfile.'.firstName,'.$this->UserProfile.'.lastName');	
        $this->db->from($this->tableReviewsElement);
        $this->db->join($this->tableProject, $this->tableProject.".projId = ".$this->tableReviewsElement.".projId", 'left');
        $this->db->join($this->tableUserShowcase, $this->tableUserShowcase.".tdsUid = ".$this->tableReviewsElement.".userId", 'left');
        $this->db->join($this->UserProfile, $this->UserProfile.".tdsUid = ".$this->tableReviewsElement.".userId", 'left');
        $this->db->join($this->tableUserAuth, $this->tableUserAuth.".tdsUid = ".$this->tableReviewsElement.".userId", 'left');
        $this->db->join($this->tableLogSummary, $this->tableLogSummary.".elementId = ".$this->tableReviewsElement.".elementId", 'left');
        
        $this->db->where($this->tableProject.'.projectType','reviews');
        $this->db->where($this->tableReviewsElement.'.entityId',$entityId); 
        $this->db->where($this->tableReviewsElement.'.projectElementId',$projectElementId);
        $this->db->where($this->tableLogSummary.'.entityId',$reviewEntityId);  // review entity id
        $this->db->where($this->tableReviewsElement.'.isPublished','t');
        $this->db->order_by($this->tableReviewsElement.'.elementId','desc'); 
        
        if($offSet>0 || $perPage>0){
            $this->db->limit($perPage,$offSet);
        }	
            
        $query = $this->db->get();
        
        //echo $this->db->last_query();die();
         
        return $result=$query->result();		 
     }
    
    //----------------------------------------------------------------------

    /* 
    * @access: public
    * @description: This function is used to get containers sizes
    * @return array
    */ 
    function getItemContainerSize($mediaContainerId=0) { 
       
        $this->db->select($this->tableUserContainer.'.containerSize');
        $this->db->select($this->tableUserMembershipItem.'.size');
        $this->db->from($this->tableUserContainer);  
        $this->db->join($this->tableUserMembershipItem, $this->tableUserMembershipItem.".userContainerId = ".$this->tableUserContainer.".userContainerId");
        $this->db->where($this->tableUserContainer.'.userContainerId', $mediaContainerId);
        $this->db->order_by($this->tableUserMembershipItem.'.memItemId', 'DESC'); 
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->result();  
    }
    
    //----------------------------------------------------------------------

    /* 
    * @access: public
    * @description: This function is used update project's elements
    * @return array
    */ 
    public function updateProjectElements($projectId,$projectId)	{	
	    $this->db->where('fileId !',$elementId);
	    $this->db->where('projId',$projectId);		
		$this->db->update($this->tableReviewsElement, $data);		
		$data=array('msg' =>$this->lang->line('msgReviewUpdated'),"projId"=>$projectId,"elemId"=>$elementId);
		echo json_encode($data);			 
	}
    
     //----------------------------------------------------------------------

    /* 
    * @access: public
    * @description: This function is used to get news or reviews data
    * @return array
    */ 
    function getnewsnreviewdata( $elementTable='',$projectId=0,$elementId=0 ) { 
        $this->db->select('p.projId,p.projName,p.projDescription,p.projShortDesc,p.projectType,p.projTag,p.projCategory,p.userContainerId,p.elementImageId,p.isProfileCoverImage,p.isPublished as projPublish,p.isBlocked,p.projRating');	
        $this->db->select('et.*');
        $this->db->from($this->tableProject. ' p');
        $this->db->join($elementTable. ' et', "et.projId = p.projId");
        $this->db->where('p.projId', $projectId);
        $this->db->where('p.isArchive', 'f');
        $this->db->where('et.elementId', $elementId);
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->result();  
    }
    
     //----------------------------------------------------------------------

    /* 
    * @access: public
    * @description: This function is used to get project and element data
    * @return array
    */ 
    function getprojelementrecord( $elementTable='',$projectId=0,$elementId=0 ) { 
        $this->db->select('p.*');	
        $this->db->select('et.*');
        $this->db->from($this->tableProject. ' p');
        $this->db->join($elementTable. ' et', "et.projId = p.projId");
        $this->db->where('p.projId', $projectId);
        $this->db->where('et.elementId', $elementId);
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->result();  
    }
    
    
    
     //----------------------------------------------------------------------

    /* 
    * @access: public
    * @description: This function is used to get project's elements data 
    * @return array
    */ 
    public function getprojectelementdata($elementTable,$projId=0,$limit=0,$offset=0) {
        
        $this->db->select('elementId,title,description,imagePath,elementType,displayImageType');
        $this->db->from($elementTable);
        $this->db->where('projId', $projId);
        $this->db->where('isArchive', 'f');
        $this->db->where('isBlocked', 'f');
        $this->db->where('isPublished', 't');
        $this->db->where('elementType', '0');
        $this->db->order_by('elementId','DESC');
        if(!empty($limit) && !empty($offset)) {
            $this->db->limit($limit);
            $this->db->offset($offset);
        }
        $query = $this->db->get();
        return $query->result(); 
    }
    
      //----------------------------------------------------------------------

    /* 
    * @access: public
    * @description: This function is used to get project's data 
    * @return array
    */ 
    public function getprojectrecords($industry,$isPublished='',$limit=0,$offset=0) {
        $userId = isLoginUser();
        $this->db->select('projId,projName,elementImageId,isProfileCoverImage,projPrice,projDownloadPrice,projPpvPrice,hasDownloadableFileOnly,sellPriceType');
        $this->db->from($this->tableProject);
        $this->db->where('isArchive', 'f');
        $this->db->where('isBlocked', 'f');
        //$this->db->where('IndustryId', $industryId);
        $this->db->where('projectType', $industry);
        $this->db->where('tdsUid', $userId);
        if(!empty($isPublished)) {
            $this->db->where('isPublished', 't');
        }
        $this->db->order_by('projId ','DESC');
        if(!empty($limit) && !empty($offset)) {
            $this->db->limit($limit);
            $this->db->offset($offset);
        }
        $query = $this->db->get();
        return $query->result(); 
    }
    
    
    //-------------------------------------------------------------------------
    
    /*
    * @access: public
    * @description: This method is use to collection media listing
    * @param:  $projId
    * @param:  $elementTblPrefix
    * @param:  $elementId
    * @return: array
    * @auther: lokendra meena
    */
     
    public function collectionmedialist($projId=0,$elementTable, $elementId=0,$orderby='order',$order='ASC',$offSet=0,$perPage=0)
    {
        $table=$this->db->dbprefix($elementTable);			
        $tableLogSummary=$this->db->dbprefix($this->tableLogSummary);			
        $entityId=getMasterTableRecord($table);			
        
        $this->db->select($this->tableMediaEelementType.'.*');
        $this->db->select($this->tableLogSummary.'.*');
        $this->db->select($elementTable.'.*');
        $this->db->select($this->tableMediaFile.'.*');
        $this->db->select($this->tableGenre.'.Genre as genrename');
        $this->db->select('c1.*');
        $this->db->select('pc.category as categoryname, pc.catId');
        $this->db->select($this->tableMasterRating.'.*');
        $this->db->select($this->tableProjectType.'.projectTypeName');
        $this->db->from($elementTable);
        $this->db->join($this->tableMediaEelementType, $this->tableMediaEelementType.".elementTypeId = ".$elementTable.".mediaTypeId", 'left');
        $this->db->join($this->tableLogSummary, $this->tableLogSummary.'.elementId = '.$elementTable.'.elementId AND  "'.$tableLogSummary.'"."entityId"='.$entityId.' ', 'left');
        $this->db->join($this->tableMediaFile, $this->tableMediaFile.".fileId = ".$elementTable.".fileId", 'left');
        $this->db->join($this->tableGenre, $this->tableGenre.".GenreId = ".$elementTable.".projGenre", 'left');
        $this->db->join($this->tableMasterCountry." c1", "c1.countryId = ".$elementTable.".producedInCountry", 'left');
        $this->db->join($this->tableProject." proj", "proj.projId = ".$elementTable.".projId", 'left');
        $this->db->join($this->tableProjCategory." pc", "pc.catId = proj.projCategory", 'left');
        $this->db->join($this->tableMasterRating, $this->tableMasterRating.".ratId = proj.projRating", 'left');
        $this->db->join($this->tableProjectType, $this->tableProjectType.".typeId = ".$elementTable.".projType", 'left');
           
        $this->db->where($elementTable.'.projId',$projId);
        
        $this->db->where($elementTable.'.isPublished','t');
        $this->db->where($elementTable.'.fileId >','1');
        
        if($elementId>0){	
            $this->db->where($elementTable.'.elementId',$elementId);
        }	
        
        if($orderby=='order'){
            $this->db->order_by($this->tableMediaEelementType.".".$orderby, $order);
        }else{
            $this->db->order_by($elementTable.".".$orderby, $order);
        }
        
        if($perPage > 0 || $offSet > 0){
            $this->db->limit($perPage,$offSet);
        } 	
        
        $query = $this->db->get();
        $result=$query->result_array();
        return $result;
    }
    
    
    //----------------------------------------------------------------------
    
    /*
    *  @access: public
    *  @description: This method is use to show my playlist
    *  @auther: lokendra meena
    *  @return: string
    */ 
    
    public function myplaylist($userId){
        $entityId=getMasterTableRecord('MaElement');
        $tableLogSummary=$this->db->dbprefix($this->tableLogSummary);
        $tableMediaFile=$this->db->dbprefix($this->tableMediaFile);
        $this->db->select($this->tableMediaPlaylist.'.*');
        $this->db->select($this->tableMaElement.'.*');
        $this->db->select($this->tableLogSummary.'.viewCount,'.$this->tableLogSummary.'.craveCount');
        $this->db->select($this->tableMediaFile.'.*');
        $this->db->from($this->tableMediaPlaylist);
        $this->db->join($this->tableMaElement, $this->tableMaElement.'.elementId  = '.$this->tableMediaPlaylist.'.elementId');
       	$this->db->join($this->tableProject, $this->tableProject.'.projId  = '.$this->tableMaElement.'.projId');
        $this->db->join($this->tableMediaFile, $this->tableMediaFile.'.fileId  = '.$this->tableMaElement.'.fileId AND "'.$tableMediaFile.'"."isExternal" = false');	
        $this->db->join($this->tableLogSummary, $this->tableLogSummary.'.elementId = '.$this->tableMaElement.'.elementId AND  "'.$tableLogSummary.'"."entityId"='.$entityId);
        $this->db->where($this->tableMediaPlaylist.'.tdsUid',$userId);
        $this->db->where($this->tableMediaPlaylist.'.entityId',$entityId);
        $query = $this->db->get();
        $result=$query->result_array();
        return $result;
    }

}

/* End of file model_media.php */
/* Location: ./application/module/media/model/model_media.php */
