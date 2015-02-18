<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Todasquare comptition Model Class
 *
 *  Fetch data for comptition (Film & Video, Music & Audio, Photography & Art,
 *	 Writing & publishing, Education Material)
 *
 *  @package	Toadsqure
 *  @subpackage	Module
 *  @category	Model
 *  @author		Sushil Mishra
 *  @link		http://toadsquare.com/
 */
class model_competition extends CI_Model {
	
	/**
	 * Constructor
	 *
	 * Loads the calendar language file and sets the default time reference
	 */	
	
	private $tableCompetition			= 'Competition'; 
	private $tableCompetitionLang		= 'CompetitionLang'; 
	private $tableCompetitionMedia		= 'CompetitionMedia'; 
	private $tableCompetitionMediaLang	= 'CompetitionMediaLang'; 
	private $tableMediaFile				= 'MediaFile';
	private $tableLogSummary			= 'LogSummary';	
	private $tableUserContainer			= 'UserContainer';
	private $tableMasterLang			= 'MasterLang';
	private $tableMasterCountry			= 'MasterCountry';
	private $tableMasterIndustry		= 'MasterIndustry';
	private $tblContinent				= 'MasterContinent';	
	private $tableCompetitionEntry		= 'CompetitionEntry';
	private $tableCompetitionVote		= 'CompetitionVote';
	private $tableCompetitionPrizes		= 'CompetitionPrizes';	
	private $tableCompetitionPrizeLang	= 'CompetitionPrizeLang';	
	private $tableUserShowcase			= 'UserShowcase';
	private $tableUserAuth				= 'UserAuth';
	private $tableUserProfile			= 'UserProfile';
	private $tableCompetitionShortlist	= 'CompetitionShortlist';
	private $tableCESupportingMaterial	= 'CESupportingMaterial';
	private $tableCompetitionGroup		= 'CompetitionGroup';
	private $tableLogCrave				= 'LogCrave';
	private $tableCompetitionEntryLang	= 'CompetitionEntryLang';
	private $tableReviewsElement		= 'ReviewsElement';
	
	/**
	 * Constructor
	 *
	 * Loads the calendar language file and sets the default time reference
	 */
	public function __construct(){		
		parent::__construct();			// Call parent constructer
	}
	
	/**
	 * @access	public
	 * @param	string
	 * @return	Object
	*/
	 
	public function getComptitionCriteria($where=array()){
			$this->db->select('c.title, c.criteriaLang1Id,c.criteriaLang2Id,c.mediaType,c.rules, c.teritoryType,c.competitionCountries,c.voteTeritoryType,c.votesCountries,c.ageRequiresFrom,c.ageRequiresTo,c.languageId, c.isMultilingual,c.ageRestriction');
			$this->db->select('cl.title as "lang2_tittle",cl.criteria as "lang2_criteria",cl.languageId as "lang2_languageId"');
			$this->db->select('l1.Language as "lang1_language",l1.Language_local as "lang1_local_language"');
			$this->db->select('l2.Language as "lang2_language",l2.Language_local as "lang2_local_language"');
			$this->db->select('cl1.Language as "cl1_language",cl1.Language_local as "cl1_local_language"');
			$this->db->select('cl2.Language as "cl2_language",cl2.Language_local as "cl2_local_language"');
			
			
			$this->db->from($this->tableCompetition.' as c');
			$this->db->join($this->tableCompetitionLang.' as cl', 'cl.competitionId=c.competitionId', 'left');
			$this->db->join($this->tableMasterLang.' as l1', 'l1.langId = c.languageId', 'left');
			$this->db->join($this->tableMasterLang.' as l2', 'l2.langId = cl.languageId', 'left');
			$this->db->join($this->tableMasterLang.' as cl1', 'cl1.langId = c.criteriaLang1Id', 'left');
			$this->db->join($this->tableMasterLang.' as cl2', 'cl2.langId = c.criteriaLang2Id', 'left');
			
			$this->db->where($where);
			$this->db->limit(1);	
			
			$query = $this->db->get();
			return $query->result();
	}
	
	public function getComptitionDetails($where=array()){
			$this->db->select('comp.*');
			$this->db->select('complang.competitionLangId,complang.languageId as "languageId2"');
			$this->db->select('cont.containerSize,cont.expiryDate');
			$this->db->select('mf.*');
			
			$this->db->select('ind.IndustryName');
			$this->db->select('lang.Language,lang.Language_local');
			$this->db->select('cnt.countryName');
			
			$this->db->from($this->tableCompetition.' as comp');
			$this->db->join($this->tableUserContainer.' as cont', 'cont.userContainerId=comp.userContainerId');
			$this->db->join($this->tableCompetitionLang.' as complang', 'complang.competitionId=comp.competitionId', 'left');
			$this->db->join($this->tableMediaFile.' as mf', 'mf.fileId=comp.sampleFileId', 'left');
			
			$this->db->join($this->tableMasterLang.' as lang', 'lang.langId = comp.languageId', 'left');
			$this->db->join($this->tableMasterCountry.' as cnt', 'cnt.countryId = comp.countryId', 'left');
			$this->db->join($this->tableMasterIndustry.' as ind', 'ind.IndustryId = comp.industryId', 'left');
			
			$this->db->where($where);
			$this->db->limit(1);	
			
			$query = $this->db->get();
			return $query->result();
	}
	
	public function getComptitionLangDetails($where=array()){
		
			
			$this->db->select('comp.languageId as "languageId1", comp.isMultilingual');
			$this->db->select('complang.*');
			$this->db->select('lang.Language,lang.Language_local');
			
			$this->db->from($this->tableCompetition.' as comp');
			$this->db->join($this->tableCompetitionLang.' as complang', 'complang.competitionId=comp.competitionId', 'left');
			$this->db->join($this->tableMasterLang.' as lang', 'lang.langId = complang.languageId', 'left');
		
			$this->db->where($where);
			$this->db->limit(1);	
			
			$query = $this->db->get();
			return $query->result();
	}
	
	
	

	
	public function getComptitionPrizeDetails($where=array()){
		
			$this->db->select('prize.compPrizeId,prize.competitionId,prize.image,prize.order');
			$this->db->select('prizelang.prizeLangId,prizelang.title,prizelang.tagwords,prizelang.onelineDescription,prizelang.description');
			
			$this->db->from($this->tableCompetitionPrizes.' as prize');
			$this->db->join($this->tableCompetitionPrizeLang.' as prizelang', 'prizelang.compPrizeId=prize.compPrizeId', 'left');
			
		
			$this->db->where($where);
			
			$this->db->order_by('prize.order','ASC');
			$query = $this->db->get();
			return $query->result();
	}
	
	/*
	 *******************************
	 *  get competition media details of language1
	 ******************************* 
	 */ 
	
	public function getComptitionMediaDetails($where=array()){
		
			$this->db->select('media.*');
			$this->db->select('mf.*');
			$this->db->from($this->tableCompetitionMedia.' as media');
			$this->db->join($this->tableMediaFile.' as mf', 'mf.fileId=media.fileId', 'left');
			$this->db->where($where);
			$this->db->order_by('media.fileOrder','ASC');
			$query = $this->db->get();
			return $query->result();
	}
	
	/*
	 *******************************
	 *  get competition media details of language1
	 ******************************* 
	 */ 
	 
	public function comptitionMediaDetailsLang2($competitionId){
		
			$this->db->select('media.mediaId,media.fileOrder');
			$this->db->select('medialang.mediaLangId,medialang.title,medialang.description');
			$this->db->select('mf.*');
			$this->db->from($this->tableCompetitionMedia.' as media');
			$this->db->join($this->tableCompetitionMediaLang.' as medialang', 'medialang.mediaId=media.mediaId', 'right');
			$this->db->join($this->tableMediaFile.' as mf', 'mf.fileId=media.fileId', 'left');
			$this->db->where('media.competitionId',$competitionId);
			$this->db->order_by('media.fileOrder','ASC');
			$query = $this->db->get();
			return $query->result();
	}
	
	
	public function getComptitionMediaLangDetails($where=array()){
		
			$this->db->select('media.mediaId,media.fileOrder');
			$this->db->select('medialang.mediaLangId,medialang.title,medialang.description');
			$this->db->select('mf.*');
			$this->db->from($this->tableCompetitionMedia.' as media');
			$this->db->join($this->tableCompetitionMediaLang.' as medialang', 'medialang.mediaId=media.mediaId', 'left');
			$this->db->join($this->tableMediaFile.' as mf', 'mf.fileId=media.fileId', 'left');
			$this->db->where($where);
			$this->db->order_by('media.fileOrder','ASC');
			$query = $this->db->get();
			return $query->result();
	}
	

	/*
	 ************************************
	 * This function is used to get competition and competition entry details
	 ************************************ 
	 */ 
	
	function competition_entry_list($userId=0,$compitEntryId=0,$isArchive='f')
	{
		$this->db->select('ent.*');	
		$this->db->select('comp.coverImage as coverImg,comp.title as compTitle,comp.countryId,comp.industryId,comp.mediaType,comp.criteriaLang1Id as languageIdFirst,comp.criteriaLang2Id,comp.ageRequiresFrom,comp.ageRequiresTo,comp.competitionCountries');	
		$this->db->select('cont.containerSize');
		$this->db->select('mf.*');
		$this->db->select('ind.IndustryName');
		$this->db->select('lang.Language_local');
		$this->db->select('cnt.countryName');
		
		$this->db->from($this->tableCompetitionEntry.' as ent');
		
		$this->db->join($this->tableUserContainer.' as cont', 'cont.userContainerId=ent.userContainerId','left');
		$this->db->join($this->tableCompetition.' as comp','comp.competitionId = ent.competitionId','left');		
		$this->db->join($this->tableMediaFile.' as mf', 'mf.fileId=ent.fileId', 'left');
		$this->db->join($this->tableMasterIndustry.' as ind', 'ind.IndustryId = comp.industryId', 'left');
		$this->db->join($this->tableMasterLang.' as lang', 'lang.langId = ent.languageId', 'left');
		$this->db->join($this->tableMasterCountry.' as cnt', 'cnt.countryId = comp.countryId', 'left');
		
		if(is_numeric($compitEntryId) && $compitEntryId > 0){
			$this->db->where('ent.competitionEntryId',$compitEntryId);	
		}
			
		$this->db->where('ent.isArchive',$isArchive);	
		
		if(is_numeric($userId) && $userId > 0){
			$this->db->where('ent.userId',$userId);	
		}
		
		$this->db->order_by("ent.competitionEntryId", "desc");
		$query = $this->db->get();
		
		$result['get_num_rows'] = $query->num_rows();
		$result['get_result'] = $query->row();
		
		return $result;
	}

	
	/*
	 ************************************
	 * This function is used to get competition entry data by competitionId and compitEntryId  
	 ************************************ 
	 */ 
	
	function competition_entry_data($competitionId=0,$userId=0,$compitEntryId=0)
	{
		
		$this->db->select('*');	
		$this->db->from($this->tableCompetitionEntry);
		$this->db->join($this->tableMediaFile,$this->tableCompetitionEntry.'.fileId ='.$this->tableMediaFile.'.fileId','left');		
		
		$this->db->where($this->tableCompetitionEntry.'.competitionId',$competitionId);	
		
		if(is_numeric($userId) && $userId > 0){
			$this->db->where($this->tableCompetitionEntry.'.userId',$userId);
		}
		if(is_numeric($compitEntryId) && $compitEntryId > 0){
			$this->db->where($this->tableCompetitionEntry.'.competitionEntryId',$compitEntryId);		
		}
		$query = $this->db->get();
		$result['get_num_rows'] = $query->num_rows();
		$result['get_result'] = $query->row();
		return $result;
	}
	
	

	public function getCompetitionProjects($IndustryId=''){
		
		$entityId=getMasterTableRecord($this->tableCompetition);
		//$entityId=57;
		
		$this->db->select($this->tableCompetition.'.*');
		$this->db->select('ls.craveCount,ls.viewCount,ls.ratingAvg,i.IndustryName' );		
		
		$this->db->select('p.firstName,p.lastName,s.profileImageName as image,s.creative,s.associatedProfessional,s.enterprise,s.enterpriseName'); 
		$this->db->select('u.username');   
		$this->db->from($this->tableCompetition);
		
		$this->db->join($this->tableLogSummary.' as ls', 'ls.elementId = '.$this->tableCompetition.'.competitionId AND ls."entityId"='.$entityId,'left');
		$this->db->join($this->tableUserShowcase.' as s', 's.tdsUid = '.$this->tableCompetition.'.userId','left');
		$this->db->join($this->tableUserProfile.' as p', 'p.tdsUid = '.$this->tableCompetition.'.userId','left');
		$this->db->join($this->tableUserAuth.' as u', 'u.tdsUid = '.$this->tableCompetition.'.userId','left');
		$this->db->join($this->tableMasterIndustry.' as i', 'i.IndustryId = '.$this->tableCompetition.'.industryId','left');
		
		if($IndustryId!='')
		$this->db->where($this->tableCompetition.'.industryId',$IndustryId);
		
		$this->db->where($this->tableCompetition.'.isPublished','t');	
		$this->db->order_by('createdDate','DESC');		
		$query = $this->db->get();
		
		//echo $this->db->last_query();die;
		return $query->result();		
		
		}
	
	public function getCompetitionProjectsList($isSearchData='',$loggedUserId){
		
		
		$entityId=getMasterTableRecord($this->tableCompetition);
		//$entityId=57;
		
		$this->db->select('comp.*');
		$this->db->select('complang.title as title_lang2');
		$this->db->select('ls.craveCount,ls.viewCount,ls.ratingAvg,i.IndustryName' );		
		
		$this->db->select('p.firstName,p.lastName,s.profileImageName as image,s.creative,s.associatedProfessional,s.enterprise,s.enterpriseName'); 
		$this->db->select('u.username');    
		$this->db->select('lc.craveId');    
		$this->db->from($this->tableCompetition.' as comp' );
		
		$this->db->join($this->tableCompetitionLang.' as complang', 'complang.competitionId=comp.competitionId', 'left');
		$this->db->join($this->tableLogSummary.' as ls', 'ls.elementId = comp.competitionId AND ls."entityId"='.$entityId,'left');
		$this->db->join($this->tableUserShowcase.' as s', 's.tdsUid = comp.userId','left');
		$this->db->join($this->tableUserProfile.' as p', 'p.tdsUid = comp.userId','left');
		$this->db->join($this->tableUserAuth.' as u', 'u.tdsUid = comp.userId','left');
		$this->db->join($this->tableMasterIndustry.' as i', 'i.IndustryId = comp.industryId','left');
		$this->db->join($this->tableLogCrave.' as lc', 'lc.elementId = comp.competitionId AND lc."tdsUid"='.$loggedUserId.' AND lc."entityId"='.$entityId,'left');
		
		if(!empty($isSearchData)){
			//show by industry
			if(!empty($isSearchData['selectIndustry']))
			$this->db->where('comp.industryId',$isSearchData['selectIndustry']);
			
			// show by key words
			/*if(!empty($isSearchData['searchWord'])){
				$this->db->like($this->tableCompetition.'.title', $isSearchData['searchWord']);
			}*/
			if($isSearchData['sortBy']=="title")
				$this->db->order_by('comp.'.$isSearchData['sortBy'],'ASC');
			else
				$this->db->order_by('comp.'.$isSearchData['sortBy'],'DESC');
			
		}else{
			$this->db->order_by('comp.createdDate','DESC');
		}
		
		
		$this->db->where('comp.isPublished','t');	
				
		$query = $this->db->get();
		
		//echo $this->db->last_query();die;
		return $query->result();		
		
		}
		
	
	/*
	 ******************************
	 *  This method get all competiton details by userId wise
	 ****************************** 
	 */ 
	
	public function getUserCompetition($userId='',$groupId,$offset=0,$limit=0){
		
		$loggedUserId=0; 
		if(isloginUser()){
			$loggedUserId= isloginUser();
		}	
		
		$entityId=getMasterTableRecord($this->tableCompetition);
		$this->db->select($this->tableCompetition.'.*');
		$this->db->select('ls.craveCount,ls.viewCount,ls.ratingAvg');		
		$this->db->select('lc.craveId'); 		
		//$this->db->select('cg.title as cgtitle,cg.onelineDescription as cgonelinedescription');		
		$this->db->from($this->tableCompetition);
		$this->db->join($this->tableCompetitionGroup.' as cg', 'cg.competitionGroupId = '.$this->tableCompetition.'.competitionGroupId','left');
		$this->db->join($this->tableLogSummary.' as ls', 'ls.elementId = '.$this->tableCompetition.'.competitionId AND ls."entityId"='.$entityId,'left');
		$this->db->join($this->tableLogCrave.' as lc', 'lc.elementId = '.$this->tableCompetition.'.competitionId AND lc."tdsUid"='.$loggedUserId.' AND lc."entityId"='.$entityId,'left');
				
		$this->db->where($this->tableCompetition.'.userId',$userId);
		$this->db->order_by('createdDate','DESC');
		$this->db->where($this->tableCompetition.'.isPublished','t');	
		$this->db->where($this->tableCompetition.'.competitionGroupId',$groupId);	
		if($offset!=0 || $limit!=0)
		{
			$this->db->limit($limit, $offset);
		}
		$query = $this->db->get();
		return $query->result();		
	}		
		

 /* Get projects of user */	
	
  public function getUserProjects($userId){
		
		$entityId=getMasterTableRecord($this->tableCompetition);
		
		$this->db->select($this->tableCompetition.'.*');
		$this->db->select('compl.languageId as languageId2');
		$this->db->select('ml1.Language_local as criterilalang1');
		$this->db->select('ml2.Language_local as criterilalang2');
		$this->db->select('ls.craveCount,ls.viewCount,ls.ratingAvg');		
		$this->db->from($this->tableCompetition);	
			
		$this->db->join($this->tableLogSummary.' as ls', 'ls.elementId = '.$this->tableCompetition.'.competitionId AND ls."entityId"='.$entityId,'left');
		$this->db->join($this->tableCompetitionLang.' as compl', 'compl.competitionId = '.$this->tableCompetition.'.competitionId','left');
		$this->db->join($this->tableMasterLang.' as ml1', 'ml1.langId = '.$this->tableCompetition.'.criteriaLang1Id','left');
		$this->db->join($this->tableMasterLang.' as ml2', 'ml2.langId = '.$this->tableCompetition.'.criteriaLang2Id','left');
		
		$this->db->where($this->tableCompetition.'.userId',$userId);	
		$this->db->where($this->tableCompetition.'.isPublished','t');	
		$this->db->order_by($this->tableCompetition.'.createdDate','ASC');
		$this->db->limit(1);
		$query = $this->db->get();		
		//echo $this->db->last_query();
		return $query->result();		
	}		
  
  
   public function getDataByCompetitionId($userId,$competitionId){
		
		$loggedUserId=0; 
		if(isloginUser()){
			$loggedUserId= isloginUser();
		}
		
		$entityId=getMasterTableRecord($this->tableCompetition);
		
		$this->db->select($this->tableCompetition.'.*');
		$this->db->select('compl.languageId as languageId2');
		$this->db->select('ml1.Language_local as criterilalang1');
		$this->db->select('ml2.Language_local as criterilalang2');
		$this->db->select('ls.craveCount,ls.viewCount,ls.ratingAvg');	
		$this->db->select('lc.craveId'); 			
		$this->db->from($this->tableCompetition);		
	
		$this->db->join($this->tableCompetitionLang.' as compl', 'compl.competitionId = '.$this->tableCompetition.'.competitionId','left');
		$this->db->join($this->tableMasterLang.' as ml1', 'ml1.langId = '.$this->tableCompetition.'.criteriaLang1Id','left');
		$this->db->join($this->tableMasterLang.' as ml2', 'ml2.langId = '.$this->tableCompetition.'.criteriaLang2Id','left');
		$this->db->join($this->tableLogSummary.' as ls', 'ls.elementId = '.$this->tableCompetition.'.competitionId AND ls."entityId"='.$entityId,'left');
		$this->db->join($this->tableLogCrave.' as lc', 'lc.elementId = '.$this->tableCompetition.'.competitionId AND lc."tdsUid"='.$loggedUserId.' AND lc."entityId"='.$entityId,'left');
	
		$this->db->where($this->tableCompetition.'.competitionId',$competitionId);	
		$this->db->where($this->tableCompetition.'.userId',$userId);	
		$this->db->where($this->tableCompetition.'.isPublished','t');	
		$this->db->order_by($this->tableCompetition.'.createdDate','ASC');
		$this->db->limit(1);
		$query = $this->db->get();		
		//echo $this->db->last_query();
		return $query->result();		
	}	
  
  
  
   /* Get all projects of same Indusrty Type */	
	
	public function getVotes($competitionId){
				
		$this->db->select($this->tableCompetitionVote.'.*');
		$this->db->select('s.profileImageName as image,s.creative,s.associatedProfessional,s.enterprise,s.enterpriseName'); 
		$this->db->select('u.username'); 
		
		$this->db->from($this->tableCompetitionVote);
		
		$this->db->join($this->tableUserShowcase.' as s', 's.tdsUid = '.$this->tableCompetitionVote.'.userId','left');		
		$this->db->join($this->tableUserAuth.' as u', 'u.tdsUid = '.$this->tableCompetitionVote.'.userId','left');
		
		$this->db->where($this->tableCompetitionVote.'.competitionId',$competitionId);
		$this->db->order_by('date','ASC');	
		$this->db->limit(3);
		$query = $this->db->get();
		
		//echo $this->db->last_query();
		return $query->result();		
		
		}
		
  
  
   public function getCompetitionEntries($competitionId){
				
		$this->db->select($this->tableCompetitionEntry.'.*');
		$this->db->select('s.profileImageName as image,s.creative,s.associatedProfessional,s.enterprise,s.enterpriseName'); 
		$this->db->select('u.username'); 
		$this->db->select('up.firstName,up.lastName'); 
		
		$this->db->from($this->tableCompetitionEntry);
		
		$this->db->join($this->tableUserShowcase.' as s', 's.tdsUid = '.$this->tableCompetitionEntry.'.userId','left');		
		$this->db->join($this->tableUserAuth.' as u', 'u.tdsUid = '.$this->tableCompetitionEntry.'.userId','left');
		$this->db->join($this->tableUserProfile.' as up', 'up.tdsUid = '.$this->tableCompetitionEntry.'.userId','left');
		
		$this->db->where($this->tableCompetitionEntry.'.competitionId',$competitionId);
		$this->db->where($this->tableCompetitionEntry.'.isPublished','t');
		$this->db->where($this->tableCompetitionEntry.'.isArchive','f');
		$this->db->order_by('createdDate','ASC');	
		$query = $this->db->get();
		
		//echo $this->db->last_query();
		return $query->result();		
		
	}
	
	
	/*
	 *************************** 
	 * This function is used to showing competition entries date popup by competition entries data 
	 *************************** 
	 */ 
	
	/*
	 * 
	 * old function some change in 
	 * 
	public function getCompetitionEntriesData($competitionEntryId){
				
		$this->db->select($this->tableCompetitionEntry.'.*');
		$this->db->select('s.profileImageName as image,s.creative,s.associatedProfessional,s.enterprise,s.enterpriseName'); 
		$this->db->select('u.username'); 
		$this->db->select('up.firstName,up.lastName'); 
		
		$this->db->from($this->tableCompetitionEntry);
		
		$this->db->join($this->tableUserShowcase.' as s', 's.tdsUid = '.$this->tableCompetitionEntry.'.userId','left');		
		$this->db->join($this->tableUserAuth.' as u', 'u.tdsUid = '.$this->tableCompetitionEntry.'.userId','left');
		$this->db->join($this->tableUserProfile.' as up', 'up.tdsUid = '.$this->tableCompetitionEntry.'.userId','left');
		
		$this->db->where($this->tableCompetitionEntry.'.competitionEntryId',$competitionEntryId);
		$this->db->where($this->tableCompetitionEntry.'.isPublished','t');
		$this->db->where($this->tableCompetitionEntry.'.isArchive','f');
		$this->db->order_by('createdDate','ASC');	
		$query = $this->db->get();
		return $query->row();		
	}*/
	
	
	public function getCompetitionEntriesData($userId,$competitionEntryId){
		
		$entityId=getMasterTableRecord($this->tableCompetitionEntry);
		
		$this->db->select($this->tableCompetitionEntry.'.*');
		$this->db->select('comp.industryId,comp.isMultilingual,comp.createdDate as compcreateddate,comp.submissionStartDate,comp.submissionEndDate,comp.votingStartDate,comp.votingEndDate,comp.competitionRoundType,comp.submissionStartDateRound2,comp.submissionEndDateRound2,comp.votingStartDateRound2,comp.votingEndDateRound2');
		$this->db->select('compel.competitionEntryLangId, compel.title as titlelang2, compel.tagwords as tagwordslang2, compel.onelineDescription as onelineDescriptionlang2, compel.description as descriptionlang2, compel.languageId as languageId2');
		$this->db->select('s.profileImageName as profileimage,s.creative,s.associatedProfessional,s.enterprise,s.enterpriseName'); 
		$this->db->select('u.username'); 
		$this->db->select('up.firstName,up.lastName'); 
		$this->db->select('ls.craveCount,ls.viewCount,ls.ratingAvg');	
		$this->db->select('mf.*');
		$this->db->from($this->tableCompetitionEntry);
		$this->db->join($this->tableCompetition.' as comp', 'comp.competitionId = '.$this->tableCompetitionEntry.'.competitionId','left');		
		$this->db->join($this->tableCompetitionEntryLang.' as compel', 'compel.competitionEntryId = '.$this->tableCompetitionEntry.'.competitionEntryId','left');		
		$this->db->join($this->tableUserShowcase.' as s', 's.tdsUid = '.$this->tableCompetitionEntry.'.userId','left');		
		$this->db->join($this->tableUserAuth.' as u', 'u.tdsUid = '.$this->tableCompetitionEntry.'.userId','left');
		$this->db->join($this->tableUserProfile.' as up', 'up.tdsUid = '.$this->tableCompetitionEntry.'.userId','left');
		$this->db->join($this->tableLogSummary.' as ls', 'ls.elementId = '.$this->tableCompetitionEntry.'.competitionEntryId AND ls."entityId"='.$entityId,'left');
		$this->db->join($this->tableMediaFile.' as mf', 'mf.fileId='.$this->tableCompetitionEntry.'.fileId','left');
		$this->db->where($this->tableCompetitionEntry.'.competitionEntryId',$competitionEntryId);
		$this->db->where($this->tableCompetitionEntry.'.isPublished','t');
		$this->db->where($this->tableCompetitionEntry.'.isArchive','f');
		$this->db->where('comp.userId',$userId);
		$this->db->order_by('createdDate','ASC');	
		$query = $this->db->get();
		//echo $this->db->last_query();die();
		return $query->row();		
	}
	
	
	/*
	 **************************** 
	 *  This function is used to show showcase competition entries list by 
	 *  comptition and userId
	 ***************************
	 */  
	
	
	 public function getShowcaseEntries($competitionId,$roundtype,$isShowResult){
		
		$loggedUserId=0; 
		if(isloginUser()){
			$loggedUserId= isloginUser();
		}
		
		$entityId=getMasterTableRecord($this->tableCompetitionEntry);	
				
		$this->db->select($this->tableCompetitionEntry.'.*');
		$this->db->select('s.profileImageName as profileimage,s.creative,s.associatedProfessional,s.enterprise,s.enterpriseName'); 
		$this->db->select('u.username'); 
		$this->db->select('up.firstName,up.lastName'); 
		$this->db->select('ls.craveCount,ls.viewCount,ls.ratingAvg');	
		$this->db->select('lc.craveId'); 
		$this->db->select('cel.competitionEntryLangId,cel.title as titlelang2,cel.onelineDescription as onelineDescriptionlang2'); 
		$this->db->from($this->tableCompetitionEntry);
		
		$this->db->join($this->tableUserShowcase.' as s', 's.tdsUid = '.$this->tableCompetitionEntry.'.userId','left');		
		$this->db->join($this->tableUserAuth.' as u', 'u.tdsUid = '.$this->tableCompetitionEntry.'.userId','left');
		$this->db->join($this->tableUserProfile.' as up', 'up.tdsUid = '.$this->tableCompetitionEntry.'.userId','left');
		$this->db->join($this->tableLogSummary.' as ls', 'ls.elementId = '.$this->tableCompetitionEntry.'.competitionEntryId AND ls."entityId"='.$entityId,'left');
		$this->db->join($this->tableLogCrave.' as lc', 'lc.elementId = '.$this->tableCompetitionEntry.'.competitionEntryId AND lc."tdsUid"='.$loggedUserId.' AND lc."entityId"='.$entityId,'left');
		$this->db->join($this->tableCompetitionEntryLang.' as cel', 'cel.competitionEntryId = '.$this->tableCompetitionEntry.'.competitionEntryId','left');
		
		$this->db->where($this->tableCompetitionEntry.'.competitionId',$competitionId);
		$this->db->where($this->tableCompetitionEntry.'.entryRoundType',$roundtype);
		$this->db->where($this->tableCompetitionEntry.'.isPublished','t');
		$this->db->where($this->tableCompetitionEntry.'.isArchive','f');
		if($isShowResult){
			$this->db->where($this->tableCompetitionEntry.'.voteCount >','0');
			$this->db->order_by($this->tableCompetitionEntry.'.voteCount','DESC');
			$this->db->order_by($this->tableCompetitionEntry.'.competitionEntryId','DESC');
			$this->db->limit(10);	
		}else{
			$this->db->order_by('createdDate','DESC');	
		}	
		$query = $this->db->get();
		
		//echo $this->db->last_query();
		return $query->result();		
		
	}
	
		
	/*
	 ***************************** 
	 * This function is used to showing winning listing
	 ***************************** 
	 */ 	
	
	function getCurrentPlacing($competitionId,$closedRound='1')
	{
		$entityId=getMasterTableRecord($this->tableCompetitionEntry);
		$this->db->select($this->tableCompetitionEntry.'.*');
		$this->db->select('ls.craveCount,ls.viewCount,ls.ratingAvg');		
		$this->db->from($this->tableCompetitionEntry);
		$this->db->join($this->tableLogSummary.' as ls', 'ls.elementId = '.$this->tableCompetitionEntry.'.competitionEntryId AND ls."entityId"='.$entityId,'left');
		$this->db->where($this->tableCompetitionEntry.'.competitionId',$competitionId);
		$this->db->where($this->tableCompetitionEntry.'.isPublished','t');
		$this->db->where($this->tableCompetitionEntry.'.isArchive','f');
		$this->db->where($this->tableCompetitionEntry.'.voteCount >','0');
		$this->db->where($this->tableCompetitionEntry.'.entryRoundType',$closedRound);
		$this->db->limit(10);	
		$this->db->order_by($this->tableCompetitionEntry.'.voteCount','DESC');	
		$this->db->order_by($this->tableCompetitionEntry.'.competitionEntryId','DESC');
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();	
	} 
		
  
  
	public function addCompetitionPrize($data){	
		$this->db->insert($this->tableCompetitionPrizes,$data); 		
		return true; 
	}
	
	
	/*
	 * this function is used to show piece listing by userId and Competition Entry Id
	 * 
	 */ 
	 
	 //
	 function getCESupportingMaterail($competitionEntryId)
		{
			$this->db->select('cesm.*');	
			$this->db->select('mf.*');
			$this->db->from($this->tableCESupportingMaterial.' as cesm');
			$this->db->join($this->tableMediaFile.' as mf', 'mf.fileId=cesm.fileId', 'left');
			$this->db->where('cesm.competitionEntryId',$competitionEntryId);	
			$this->db->order_by("cesm.fileOrder", "asc");
			$query = $this->db->get();
			return $query->result_array();
		}
  
  
     function getIndustryCount(){
		 $this->db->select("industryId");
		 $this->db->select('COUNT("industryId") AS count ');			 				 
		 $this->db->from($this->tableCompetition);
		 $this->db->where($this->tableCompetition.'.isPublished','t');
		 $this->db->group_by("industryId", "asc");
		 $this->db->order_by("industryId", "asc");	 
		 $query = $this->db->get();
		//echo $this->db->last_query();
		 return $query->result();
		 }
		 
		/*
		 ************************** 
		 * this function is used show lanauge2 prize list
		 ************************** 
		 */ 
		 
		function prizeListLanguage2($competitionId){
			
			//private $tableCompetitionPrizes		= 'CompetitionPrizes';	
			//private $tableCompetitionPrizeLang	= 'CompetitionPrizeLang';	
			
			$this->db->select('cpl.*');	
			$this->db->select('cp.title as cptitle, cp.tagwords as cptagwords, cp.onelineDescription as cponelineDescription, cp.description as cpdescription,cp.image,cp.order');
			$this->db->from($this->tableCompetitionPrizeLang.' as cpl');
			$this->db->join($this->tableCompetitionPrizes.' as cp', 'cp.compPrizeId=cpl.compPrizeId', 'left');
			$this->db->where('cpl.competitionId',$competitionId);	
			$this->db->order_by("cp.order", "asc");
			$query = $this->db->get();
			//echo $this->db->last_query();die();
			return $query->result();
			
		} 
		
		
		
		/*
		 *************************** 
		 * This function get competition Details by competitionId and userId
		 ***************************
		 */  
		
		
		public function getCompetitionDetail($userId,$competitionId){
		
			$loggedUserId=0; 
			if(isloginUser()){
				$loggedUserId= isloginUser();
			}
			
			$entityId=getMasterTableRecord($this->tableCompetition);
			
			$this->db->select($this->tableCompetition.'.*');
			$this->db->select('ls.craveCount,ls.viewCount,ls.ratingAvg');	
			$this->db->select('lc.craveId'); 			
			$this->db->from($this->tableCompetition);		
			$this->db->join($this->tableLogSummary.' as ls', 'ls.elementId = '.$this->tableCompetition.'.competitionId AND ls."entityId"='.$entityId,'left');
			$this->db->join($this->tableLogCrave.' as lc', 'lc.elementId = '.$this->tableCompetition.'.competitionId AND lc."tdsUid"='.$loggedUserId.' AND lc."entityId"='.$entityId,'left');
			$this->db->where($this->tableCompetition.'.userId',$userId);	
			$this->db->where($this->tableCompetition.'.competitionId',$competitionId);	
			$this->db->where($this->tableCompetition.'.isPublished','t');	
			$this->db->order_by($this->tableCompetition.'.createdDate','ASC');
			$this->db->limit(1);
			$query = $this->db->get();		
			//echo $this->db->last_query();
			return $query->result();		
		}
  
  
		function getCompetitionShortData($userId,$competitionId,$offset=0,$limit=0) {
			$this->db->select($this->tableCompetition.'.*');
			$this->db->select($this->tableCompetitionEntry.'.*');
			$this->db->from($this->tableCompetitionShortlist);
			$this->db->join($this->tableCompetitionEntry, $this->tableCompetitionEntry.'.competitionEntryId  = '.$this->tableCompetitionShortlist.'.competitionEntryId');
			$this->db->join($this->tableCompetition, $this->tableCompetition.'.competitionId  = '.$this->tableCompetitionShortlist.'.competitionId');
			$this->db->where($this->tableCompetitionShortlist.'.userId',$userId);
			if(isset($competitionId) && !empty($competitionId)) {
				$this->db->where($this->tableCompetitionShortlist.'.competitionId',$competitionId);
			}
			if($offset!=0 || $limit!=0)
			{
				$this->db->limit($limit, $offset);
			}
			$query = $this->db->get();
			return $result=$query->result_array();
		}
		
		
		function getCompetitionData($userId) {
			$tableCompetitionShortlist=$this->db->dbprefix($this->tableCompetitionShortlist);
			$tableCompetition=$this->db->dbprefix($this->tableCompetition);
			$this->db->select($this->tableCompetitionShortlist.'"'.'."competitionId", COUNT("'.$tableCompetitionShortlist.'"."competitionId"),'.$this->tableCompetition.'.title'); 
			$this->db->from($this->tableCompetitionShortlist);
			$this->db->join($this->tableCompetition, $this->tableCompetition.'.competitionId  = '.$this->tableCompetitionShortlist.'.competitionId');
			$this->db->group_by($tableCompetitionShortlist.'.competitionId,'.$tableCompetition.'.title');  
			$this->db->where($this->tableCompetitionShortlist.'.userId',$userId);
			$query = $this->db->get();
			return $result=$query->result_array();
		}
		
		
		/*
		 *  This function is used to get user review 
		 *  @param @competitionEntryId
		 *  @return object
		 * 
		 */ 
		 
		 
		function gerReviewData($competitionEntryId=0,$offset=0,$limit=0){
			
			$entityId=getMasterTableRecord($this->tableCompetitionEntry);
			$this->db->select($this->tableReviewsElement.'.*');
			$this->db->select('s.profileImageName as profileimage,s.creative,s.associatedProfessional,s.enterprise,s.enterpriseName'); 
			$this->db->select('u.username'); 
			$this->db->select('up.firstName,up.lastName'); 
			
			$this->db->from($this->tableReviewsElement);
			$this->db->join($this->tableUserShowcase.' as s', 's.tdsUid = '.$this->tableReviewsElement.'.userId','left');		
			$this->db->join($this->tableUserAuth.' as u', 'u.tdsUid = '.$this->tableReviewsElement.'.userId','left');
			$this->db->join($this->tableUserProfile.' as up', 'up.tdsUid = '.$this->tableReviewsElement.'.userId','left');
			
			$this->db->where($this->tableReviewsElement.'.projectElementId',$competitionEntryId);
			$this->db->where($this->tableReviewsElement.'.entityId',$entityId);
			$this->db->where($this->tableReviewsElement.'.isPublished','t');
			$this->db->where($this->tableReviewsElement.'.isBlocked','f');
			$this->db->where($this->tableReviewsElement.'.isArchive','f');
			
			$this->db->limit(10);	
			$this->db->order_by($this->tableReviewsElement.'.elementId','DESC');	
			if($offset!=0 || $limit!=0)
			{
				$this->db->limit($limit, $offset);
			}
			$query = $this->db->get();
			//echo $this->db->last_query();
			return $query->result();	
		} 
		
  
}
