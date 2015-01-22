<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//class Search extends MY_Controller{
class Search extends MX_Controller{
	
	private $data = array();
	private $dirCacheMedia = '';
	private $userId = null;
	
	public function __construct(){
		parent::__construct();
		$this->load->language('search');
        $this->load->library('pagination_new_ajax');
		$this->dirCacheMedia = 'cache/search/';
		$this->userId= isLoginUser()?isLoginUser():0;
		//add advertising module if exists
		if(is_dir(APPPATH.'modules/advertising')){
			$this->load->model(array('advertising/model_advertising'));
		}
	}
	
	public function index()
	{
        $this->load->view('search');
    }
    
    public function helpSearch()
	{
        $this->load->view('help_search');
    }
    
    public function searchAssociated(){
        $sectionId=0;
        $post = $this->input->post();
		$keyword=$post['keyWord'];
		$sectionId = $post['sectionId'];
		$section = $post['section'];
		$isSectionList=(isset($post['isSectionList']) && $post['isSectionList']==1)?1:0;
		$isSectionList= ((int)$isSectionList == 1)?1:0;
        if($isSectionList){
            $this->data['sectionList'] = getSearchIndustryList();
        }else{
            $this->data['sectionList'] = false;   
        }
		$this->data['keyword'] = $keyWord;	
		$this->data['sectionId'] = $sectionId;	
		$this->data['section'] = $section;
		$this->data['isSectionList'] = $isSectionList;
		
        $view='search/search_associated_result';
        
        $this->data['searchResult']=false;
        if((isset($keyword)) || (isset($sectionId))  ){
			$this->data['searchResult']=$this->searchresult(true,$view);
		}
        if(isset($post['viewPage']) && !empty($post['viewPage'])){
           echo $this->data['searchResult'];
        }else{
            $this->load->view('search_popup',$this->data);
        }

    }
    
    public function searchontoadsquare($serchFromSection='showcase')
	{
		
		
        $sectionId=0;
		$keyword=$this->input->post('val1');
		$sectionId=$this->input->post('val2');
		$section=$this->input->post('val3');
		$entityId=$this->input->post('val4');
		$this->data['keyword']=$keyword;	
		$this->data['sectionId']=$sectionId;	
		$this->data['section']=$section;
		if($sectionId=='media'){
			
			$sectionList=LoginUserDetails('sectionMediaListSession');
			if(!$sectionList){
				
				//$this->data['sectionList'] = getIndustryList($lang='',$isSection=1,$isMediaIndustry=0, $isall=0);
				$this->data['sectionList'] = getSearchIndustryList();
				$this->session->set_userdata('sectionMediaListSession',$this->data['sectionList']);
			}else{
				$this->data['sectionList'] = LoginUserDetails('sectionMediaListSession');
			}
			
			//$this->data['sectionList'] = getIndustryList($lang='',$isSection=1,$isMediaIndustry=0, $isall=0);
			$this->data['sectionList'] = getSearchIndustryList();
			$this->data['sectionList']['media']=$this->lang->line('selectSection');
			if(isset($this->data['sectionList']['']))  unset($this->data['sectionList']['']);
			if(isset($this->data['sectionList'][6]))  unset($this->data['sectionList'][6]);
			if(isset($this->data['sectionList'][7])) unset($this->data['sectionList'][7]);
			if(isset($this->data['sectionList'][8])) unset($this->data['sectionList'][8]);
			//if(isset($this->data['sectionList'][9])) unset($this->data['sectionList'][9]);
			if(isset($this->data['sectionList'][11])) unset($this->data['sectionList'][11]);
			if(isset($this->data['sectionList'][12])) unset($this->data['sectionList'][12]);
			$view='search_media_result';
			
		}elseif($sectionId=='news' || $sectionId=='reviews'){
			$view='search_media_result';
		}
		else if($sectionId=='report_a_problem') {
			$sectionList=LoginUserDetails('sectionListSession');
			if(!$sectionList){
				//$this->data['sectionList'] = getIndustryList($lang='',$isSection=0,$isMediaIndustry='', $isall=1);
				$this->data['sectionList'] = getSearchIndustryList();
				$this->session->set_userdata('sectionListSession',$this->data['sectionList']);
			}else{
				$this->data['sectionList'] = LoginUserDetails('sectionListSession');
			}
			if(isset($this->data['sectionList'][5]))  unset($this->data['sectionList'][5]);
			if(isset($this->data['sectionList'][14])) unset($this->data['sectionList'][14]);
			if(isset($this->data['sectionList'][15])) unset($this->data['sectionList'][15]);
			if(isset($this->data['sectionList'][16])) unset($this->data['sectionList'][16]);
			if(isset($this->data['sectionList'][17])) unset($this->data['sectionList'][17]);
			$view='search_media_result';
		}
		else{
			$this->data['sectionList'] = false;
			$view='search_media_result';
		}
		
		if((isset($keyword)) || (isset($sectionId))  ){
			if($sectionId=='media'){
				$projSectionId = 1;
			}else{
				$projSectionId = 0;
			}
			
			$this->data['searchResult']=$this->searchresult(true,$view,$projSectionId);
		}else{
			$this->data['searchResult']=false;
		}
        $this->load->view('searchontoadsquare',$this->data);
	}
    
    
    public function searchform()
	{
		$cacheFile=$this->dirCacheMedia."searchform.html";
		$sectionList=LoginUserDetails('sectionListSession');
		if(!$sectionList){
			//$this->data['sectionList'] = getIndustryList($lang='',$isSection=0,$isMediaIndustry='', $isall=1);
			$this->data['sectionList'] = getSearchIndustryList();
			$this->session->set_userdata('sectionListSession',$this->data['sectionList']);
		}else{
			$this->data['sectionList'] = LoginUserDetails('sectionListSession');
		}
		
		
		if(isset($this->data['sectionList'][5]))  unset($this->data['sectionList'][5]);
		if(isset($this->data['sectionList'][14])) unset($this->data['sectionList'][14]);
		if(isset($this->data['sectionList'][15])) unset($this->data['sectionList'][15]);
		if(isset($this->data['sectionList'][16])) unset($this->data['sectionList'][16]);
		if(isset($this->data['sectionList'][17])) unset($this->data['sectionList'][17]);
		if(isset($this->data['sectionList'][18])) unset($this->data['sectionList'][18]);
		if(isset($this->data['sectionList'][19])) unset($this->data['sectionList'][19]);
		
		if(!is_file($cacheFile) || is_file($cacheFile)){
			$this->data['industryList'] = getIndustryList();
			$this->data['blogIndustryList'] = getBlogIndustryList('search');
			$this->data['sectionCategoryList']=false;
			$this->data['catProjectTypelist']=false;
			$this->data['projectTypeGenerList']=false;
			$lang=lang();
			$EmentityId=getMasterTableRecord('EmElement');
			$this->data['EMGenerList']=getGenerList('','',lang(),'selectGenre',$EmentityId);
			if($this->data['sectionList'] && is_array($this->data['sectionList']) && count($this->data['sectionList']) > 0 ){
				foreach($this->data['sectionList'] as $sectionId=>$sectionName ){
					if($sectionId>0)
					$this->data['sectionCategoryList'][$sectionId]=getProjCategoryList($sectionId, $lang,false);
					if($this->data['sectionCategoryList'][$sectionId] && is_array($this->data['sectionCategoryList'][$sectionId]) && count($this->data['sectionCategoryList'][$sectionId]) > 0 ){
						foreach($this->data['sectionCategoryList'][$sectionId] as $catId=>$category ){
							if($catId>0)
								$this->data['catProjectTypelist'][$sectionId][$catId]=getTypeList('', lang(), false ,$catId);
						}
					}
				
				}
			}
			
			if($this->data['catProjectTypelist'] && is_array($this->data['catProjectTypelist']) && count($this->data['catProjectTypelist']) > 0 ){
				foreach($this->data['catProjectTypelist'] as $sectionId=>$projectCatList){
					
					if($projectCatList && is_array($projectCatList) && count($projectCatList) > 0){
						foreach($projectCatList as $catId=>$projectTypeList){
							if($catId>0 && $projectTypeList && is_array($projectTypeList) && count($projectTypeList) > 0 ){
								foreach($projectTypeList as $typeId=>$projectTypeName ){
									if($typeId>0)
									$this->data['projectTypeGenerList'][$typeId]=getGenerList($typeId, 0, $lang, false);
								}
							}
						}
					}
				}
			}
			
			$this->data['languageList'] = getlanguageList();
			$this->data['countryList'] = getCountryList();
			$this->data['searchform'] =  $this->load->view('searchform',$this->data,true);
			
			if(!is_dir($this->dirCacheMedia)){
				@mkdir($this->dirCacheMedia, 777, true);
			}
			
			$cmd3 = 'chmod -R 777 '.$this->dirCacheMedia;
			exec($cmd3);
			
			if (!write_file($cacheFile, $this->data['searchform'])){	// write cache file
				echo 'Unable to write the file';
			}
		}
			
		$this->data['searchform']=$cacheFile;
		
		$keyword=$this->input->post('keyword')?$this->input->post('keyword'):'';
		$sectionId=$this->input->post('sectionId');
		
		if((isset($keyword)) || (isset($sectionId))  ){
			$this->data['searchResult']=$this->searchresult($loadView=true);
		}else{
			$this->data['searchResult']=false;
		}
		//manage advert types if exists
		if(is_dir(APPPATH.'modules/advertising')) {
			//Get search section id
			$advertSectionId = $this->config->item('searchSectionId');
			//Get banner records based on section and advert type
			$bannerType2 = $this->model_advertising->getBannerRecords($advertSectionId,2,1);
			$bannerType3 = $this->model_advertising->getBannerRecords($advertSectionId,3,1);
			$this->data['advertSectionId'] = $advertSectionId; //set advert section id
			//Load view of advert js functions
			$this->data['advertChangeView'] = $this->load->view('advertising/advertAutoChange',array('bannerType2'=>$bannerType2,'bannerType3'=>$bannerType3,'sectionId'=>$advertSectionId),true);
		} 
        $this->template_front_end->load('template_front_end','searchresult',$this->data);
    }
    
    public function searchresult($loadView=false,$viewPage='result',$prosectionId=0){
	
		$POST=$this->input->post();

		//if(isset($POST) && is_array($POST) && count($POST) > 0){
			$viewPage=$this->input->post('viewPage')?$this->input->post('viewPage'):$viewPage;
			$keyword=$this->input->post('keyWord')?$this->input->post('keyWord'):$this->input->post('val1');
			
			$keyword=trim($keyword);
			$keyword=($keyword==$this->lang->line('keywordSearch'))?'':$keyword;
			
			$sectionId=$this->input->post('sectionId')?$this->input->post('sectionId'):$this->input->post('val2');
			
			$entityId=$this->input->post('entityId')?$this->input->post('entityId'):$this->input->post('val4');
			$entityId=(is_numeric($entityId) && $entityId > 0)?$entityId:0;
				
			$industryId=$this->input->post('industryId');
			$languageId=$this->input->post('languageId');
			$countryId=$this->input->post('producedInCountry');
			$projectPart=$this->input->post('projectPart');
			$catId=$this->input->post('catId');
			$ProductCat=$this->input->post('ProductCat');
			$alltype=$this->input->post('alltype');
			$typeId=$this->input->post('typeId');
			$GenreId=$this->input->post('GenreId');
			$EMgenre=$this->input->post('EMgenre');
			$FromSearchPage=$this->input->post('fromSection');
			
			$tableSearch=$this->db->dbprefix('search');
			$tableLogSummary=$this->db->dbprefix('LogSummary');
			$tableLogCrave=$this->db->dbprefix('LogCrave');
			
			$orderBy=' ORDER BY "'.$tableLogSummary.'"."craveCount","'.$tableLogSummary.'"."elementId" DESC';
			$limit='';
			
			
			$table='"'.$tableSearch.'" ';
			$table.=' LEFT JOIN "'.$tableLogSummary.'" ON ("'.$tableLogSummary.'"."entityId" = "'.$tableSearch.'"."entityid" AND "'.$tableLogSummary.'"."elementId" = "'.$tableSearch.'"."elementid")';
			$field='(item).*, "'.$tableSearch.'".*, "'.$tableLogSummary.'"."reviewCount", "'.$tableLogSummary.'"."viewCount", "'.$tableLogSummary.'"."craveCount", "'.$tableLogSummary.'"."ratingAvg"';
			
			if($this->userId > 0){
				$table.=' LEFT JOIN "'.$tableLogCrave.'" ON ("'.$tableLogCrave.'"."entityId" = "'.$tableSearch.'"."entityid" AND "'.$tableLogCrave.'"."elementId" = "'.$tableSearch.'"."elementid" AND "'.$tableLogCrave.'"."tdsUid" = '.$this->userId.')';
				$field.=', "'.$tableLogCrave.'"."craveId" ';
			}
			
			$where="where ispublished='t' AND sectionid > 0 AND section !='workprofile' AND sectionid != 97 "; //97 is blogs entityId
			
			if($entityId > 0){
				$where.=" AND entityid = '".$entityId."' ";
			}
			
			if(!empty($keyword)){
				$keyword=pg_escape_string($keyword);
				$keywords=explode(' ',$keyword);
				$where.=" AND ( ";
				foreach($keywords as $k=>$keyword){
					$keyword=trim($keyword);
					if($k > 0){
						$where.=" OR ";
					}
					if($keyword != ''){
						$where.="(item).title ILIKE  '%".$keyword."%' OR (item).tagwords ILIKE  '%".$keyword."%' OR (item).online_desctiption ILIKE  '%".$keyword."%' OR (item).creative_name ILIKE  '%".$keyword."%' OR (item).creative_area ILIKE  '%".$keyword."%'";
					}
					
				}
				$where.=" ) ";
			}
			
			if($sectionId=='media'){
				$where.=" AND (sectionid =  1 OR sectionid =  2 OR sectionid =  3 OR sectionid =  4 OR sectionid =  10 OR sectionid =  9 ) AND section !=  'news' AND section !=  'reviews' AND section !=  'post' AND section !=  'upcoming' AND section !=  'notification' ";
			}elseif($sectionId=='news' || $sectionId=='reviews'){
				$where.=" AND section = '".$sectionId."' AND sectionid > 0 ";
			}
			elseif($sectionId==18){
				$where.=" AND section = 'news' AND sectionid > 0 ";
			}
			elseif($sectionId==19){
				$where.=" AND section = 'reviews' AND sectionid > 0 ";
			}elseif($sectionId > 0 && ($FromSearchPage == 'linkToScript' || $FromSearchPage == 'linkToSoundtrack' || $FromSearchPage == 'linkToPoster')){
				$where.=" AND sectionid =  ".$sectionId." AND section !=  'news' AND section !=  'reviews' AND section !=  'post' AND section !=  'upcoming' AND section !=  'notification' ";
			}
			elseif($sectionId > 0 && ($projectPart == 'news' || $projectPart == 'reviews' || $projectPart == 'post')){
				$where.=" AND sectionid =  ".$sectionId." AND section =  '".$projectPart."' ";
			}elseif($sectionId > 0 && !($projectPart == 'news' || $projectPart == 'reviews' || $projectPart == 'post')){
				$where.=" AND sectionid =  ".$sectionId." AND section !=  'news' AND section !=  'reviews' AND section !=  'post' AND section !=  'upcoming' ";
			}
			
			// in showcase case do not show mutlilangual data show  (add by lokendra)
			if($FromSearchPage == 'showcase'){
				$where.=" AND entityid !=  100 ";
			}
			
			if($industryId > 0){
				$where.=" AND (item).industryid =  ".$industryId." ";
			}
			if($languageId > 0){
				$where.=" AND (item).languageid =  ".$languageId." ";
			}
			if($countryId > 0){
				$where.=" AND (item).countryid =  '".$countryId."' ";
			}
			
			if($projectPart == 'news' || $projectPart == 'reviews' || $projectPart == 'post' || $projectPart == 'upcomingprojects'){
				$where.=" AND section =  '".$projectPart."' ";
			}
			elseif($projectPart == 'projects'){
				$where.=" AND section !=  'upcoming' ";
			}
			elseif($projectPart == 'free'){
				$where.=" AND (item).sell_option =  '".$projectPart."' ";;
			}
			elseif($projectPart == 'top100craved'){
				$limit=' limit 100 ';
			}
			
			if($catId > 0){
				$where.=" AND (item).categoryid =  '".$catId."' ";
			}
			if($ProductCat != 'all' && $ProductCat != '' ){
				$where.=" AND (item).categoryid =  '".$ProductCat."' ";
			}
			if(is_array($alltype)){
				$alltype=$alltype[0];
			}
			if($alltype != 'alltype'){
				$countTypeId=count($typeId);
				if(is_array($typeId) && $countTypeId > 0){
					$i=0;
					$where.=" AND ( ";
					foreach($typeId as $typeid){
						$i++;
						if($typeid > 0){
							$where.=" (item).typeid = '".$typeid."' ";
							if($i < $countTypeId){
								$where.=" OR ";
							}
						}
					}
					$where.=" ) ";
				}
				
				$countGenreId=count($GenreId);
				if(is_array($GenreId) && $countGenreId > 0){
					$i=0;
					$where.=" AND ( ";
					foreach($GenreId as $genreid){
						$i++;
						if($genreid > 0){
							$where.="  (item).genreid = '".$genreid."' ";
							if($i < $countGenreId){
								$where.=" OR ";
							}
						}
					}
					$where.=" ) ";
				}
			}
			if($EMgenre>0){
				$where.=" AND (item).genreid = '".$EMgenre."' ";
			}
			
			//work
			$allWorkType=$this->input->post('allWorkType');
			if($allWorkType != 'allWorkType' &&  $sectionId==11){
				$WorkOffered=$this->input->post('WorkOffered');
				$WorkOffered=trim($WorkOffered);
				$WorkWanted=$this->input->post('WorkWanted');
				$WorkWanted=trim($WorkWanted);
				$urgentWorkOffered=$this->input->post('urgentWorkOffered');
				$normalWorkOffered=$this->input->post('normalWorkOffered');
				$experienceWorkOffered=$this->input->post('experienceWorkOffered');
				$expWorkWanted=$this->input->post('expWorkWanted');
				$normalWorkWanted=$this->input->post('normalWorkWanted');
				
				if(($WorkOffered && !empty($WorkOffered) || $urgentWorkOffered=='t' || $normalWorkOffered=='t' || $experienceWorkOffered=='t' ) || ($WorkWanted && !empty($WorkWanted)) || ($expWorkWanted=='t')  || ($normalWorkWanted=='t')){	
					$workOfferedFlag=false;
					if(($WorkOffered && !empty($WorkOffered) || $urgentWorkOffered=='t' || $normalWorkOffered=='t' || $experienceWorkOffered=='t' ) ){
						$workOfferedFlag=true;
						$where.=" AND ( ";
						$where.=" (item).work_type = 'offered' ";
						if($urgentWorkOffered!='t' || $normalWorkOffered !='t'){
							if($urgentWorkOffered=='t'){
								$where.=" AND (item).is_urgent_work = 't' ";
							}
							elseif($normalWorkOffered=='t'){
								$where.=" AND (item).is_urgent_work = 'f' ";
							}
						}
						
						if($experienceWorkOffered == 't'){
								$where.=" AND (item).is_experience_work = 't' ";
						}else{
							$where.=" AND (item).is_experience_work = 'f' ";
						}
						
						$where.=" ) ";
					}
					if(($WorkWanted && !empty($WorkWanted)) || ($expWorkWanted=='t') || ($normalWorkWanted=='t')){
						if($workOfferedFlag){
							$where.=" OR ( ";
						}else{
							$where.=" AND ( ";
						}
						
						$where.=" (item).work_type = 'wanted' ";
						
						if($expWorkWanted!='t' || $normalWorkWanted !='t'){
							if($expWorkWanted=='t'){
								$where.=" AND (item).is_experience_work = 't' ";
							}
							elseif($normalWorkWanted=='t'){
								$where.=" AND (item).is_experience_work = 'f' ";
							}
						}
						$where.=" ) ";
					}
				}
			}
			
			// Performance & Event
			
			$city=$this->input->post('city');
			$city=($city==$this->lang->line('city'))?'':$city;
			if(isset($city) && !empty($city) && $city != ''){
				$where.=" AND (item).city ILIKE  '%".$city."%' ";
			}
			
			$PEcat=$this->input->post('PEcat');
			if(isset($PEcat) && $PEcat && $PEcat !='all'){
				$where.=" AND (item).element_type = '".$PEcat."' ";
			}
			$PEtype=$this->input->post('PEtype');
			if(isset($PEtype) && $PEtype && $PEtype !='all'){
				$where.=" AND (item).type = '".$PEtype."' ";
			}
			$PEgenre=$this->input->post('PEgenre');
			if(isset($PEgenre) && $PEgenre && $PEgenre !='all'){
				$where.=" AND (item).genre = '".$PEgenre."' ";
			}
			
			$eventStartDate=$this->input->post('eventStartDate'); 
			if(isset($eventStartDate) && $eventStartDate && $eventStartDate !=''){
				$eventStartDate=str_replace(':','-',$eventStartDate);
				$eventStartDate=date('Y-m-d',strtotime($eventStartDate));
				$where.=" AND (item).event_start_date >= '".$eventStartDate."' ";
			}
			
			$eventEndDate=$this->input->post('eventEndDate'); 
			if(isset($eventEndDate) && $eventEndDate && $eventEndDate !=''){
				$eventEndDate=str_replace(':','-',$eventEndDate);
				$eventEndDate=date('Y-m-d',strtotime($eventEndDate));
				$where.=" AND (item).event_end_date <= '".$eventEndDate."' ";
			}
			//echo $where;
			
			$isSetCookie = setPerPageCookie('searchPerPageVal',$this->config->item('perPageRecord'));	
			
			$pages = new Pagination_new_ajax;
			$pages->items_total = $this->model_common->getDataFromMixTabel($table, 'id',  $where, '', '',true ); // this is the COUNT(*) query that gets the total record count from the table you are querying
			$this->data['perPageRecord'] = $this->config->item('perPageRecord');
			
			$pages->items_per_page=(isset($_REQUEST['ipp']) && $_REQUEST['ipp'] > 0) ? $_REQUEST['ipp']:$isSetCookie;
			
			$pages->paginate();
			
			$limit=' LIMIT '.$pages->limit.' OFFSET '.$pages->offst.' ';
			$this->data['searchResult']=$this->model_common->getDataFromMixTabel($table, $field,  $where, $orderBy,  $limit);
			
			
            
            //echo $this->db->last_query();die();
			
			$this->data['items_total'] = $pages->items_total;
			$this->data['items_per_page'] = $pages->items_per_page;
			$this->data['pagination_links'] = $pages->display_pages();
			
			$pages->paginate($isShowButton=true,$isShowNumbers=false);
			$this->data['pagination_links_withoutButton'] = $pages->display_pages();
			
			
			if(($this->input->post('val2') == 'media') || ($prosectionId==1)){
				$this->data['prosectionId'] = 1;
			}
			if($this->input->post('prosectionId')==1){
				$this->data['prosectionId'] = $this->input->post('prosectionId');
			}
			
			if($this->input->post('fromSection')!='')
			{
				$this->data['fromSection'] = $this->input->post('fromSection');
			}
			else if($this->input->post('val3')!=''){
				$this->data['fromSection'] = $this->input->post('val3');
			}
			
			
            
			$searchResultView=$this->load->view($viewPage,$this->data,$loadView);
			if($loadView){
				return $searchResultView;
			}
		//}
	}
    
    //-------------------------------------------------------------------------
    
     /*
     * @Description: This method is use to search media records
     * @access: public
     * @return: void
     */
    public function searchMediaRecords() {
        
        $sectionId=0;
        // set post data
        $keyword = $this->input->post('val1');
        $sectionId = $this->input->post('val2');
        $section = $this->input->post('val3');
        $entityId = $this->input->post('val4');
        $this->data['keyword']=$keyword;
        $this->data['sectionId']=$sectionId;
        $this->data['section']=$section;
        // set section list
        $sectionList = LoginUserDetails('sectionMediaListSession');
        if(!$sectionList) {
            
            //$this->data['sectionList'] = getIndustryList($lang='',$isSection=1,$isMediaIndustry=0, $isall=0);
            $this->data['sectionList'] = getSearchIndustryList();
            $this->session->set_userdata('sectionMediaListSession',$this->data['sectionList']);
        } else {
            $this->data['sectionList'] = LoginUserDetails('sectionMediaListSession');
        }
        if($sectionId == 'associatedMember') {
            $this->data['sectionList'] = getIndustryList($lang='',$isSection=2,$isMediaIndustry=0, $isall=0);
        } else {
            $this->data['sectionList'] = getIndustryList($lang='',$isSection=1,$isMediaIndustry=1, $isall=0);
        }
        //$this->data['sectionList'] = getSearchIndustryList();
        //$this->data['sectionList']['media']=$this->lang->line('selectSection');
        $view='search_media_result';
            
        //$sectionId = 'media';
        if((isset($keyword)) || (isset($sectionId))) {
            if($sectionId=='media') {
                $projSectionId = 1;
            } else {
                $projSectionId = 0;
            }
            
            $this->data['searchResult'] = $this->searchMediaResult(true,$view,$projSectionId);
        } else {
            $this->data['searchResult'] = false;
        }
    
        $this->load->view('associated_media_search',$this->data);
    }
    
    //-------------------------------------------------------------------------
    
     /*
     * @Description: This method is use to search media records results
     * @access: public
     * @return: void
     */
    public function searchMediaResult($loadView=false,$viewPage='result',$prosectionId=0) {

        $POST = $this->input->post();

        $viewPage=$this->input->post('viewPage')?$this->input->post('viewPage'):$viewPage;
        $keyword=$this->input->post('keyWord')?$this->input->post('keyWord'):$this->input->post('val1');
        
        $keyword=trim($keyword);
        $keyword=($keyword==$this->lang->line('keywordSearch'))?'':$keyword;
        
        $sectionId=$this->input->post('sectionId')?$this->input->post('sectionId'):$this->input->post('val2');
        $searchSectionId = $this->input->post('searchSectionId')?$this->input->post('searchSectionId'):$this->input->post('val2');
        
        $entityId=$this->input->post('entityId')?$this->input->post('entityId'):$this->input->post('val4');
        $entityId=(is_numeric($entityId) && $entityId > 0)?$entityId:0;
            
        $industryId=$this->input->post('industryId');
        $languageId=$this->input->post('languageId');
        $countryId=$this->input->post('producedInCountry');
        $projectPart=$this->input->post('projectPart');
        $catId=$this->input->post('catId');
        $ProductCat=$this->input->post('ProductCat');
        $alltype=$this->input->post('alltype');
        $typeId=$this->input->post('typeId');
        $GenreId=$this->input->post('GenreId');
        $EMgenre=$this->input->post('EMgenre');
        $FromSearchPage=$this->input->post('fromSection');
        if($searchSectionId=='media') {
            $tableSearch=$this->db->dbprefix('search');
            $tableLogSummary=$this->db->dbprefix('LogSummary');
            $tableLogCrave=$this->db->dbprefix('LogCrave');
            
            $orderBy=' ORDER BY "'.$tableLogSummary.'"."craveCount","'.$tableLogSummary.'"."elementId" DESC';
            $limit='';
            
            
            $table='"'.$tableSearch.'" ';
            $table.=' LEFT JOIN "'.$tableLogSummary.'" ON ("'.$tableLogSummary.'"."entityId" = "'.$tableSearch.'"."entityid" AND "'.$tableLogSummary.'"."elementId" = "'.$tableSearch.'"."elementid")';
            $field='(item).*, "'.$tableSearch.'".*, "'.$tableLogSummary.'"."reviewCount", "'.$tableLogSummary.'"."viewCount", "'.$tableLogSummary.'"."craveCount", "'.$tableLogSummary.'"."ratingAvg"';
            if($this->userId > 0){
                $table.=' LEFT JOIN "'.$tableLogCrave.'" ON ("'.$tableLogCrave.'"."entityId" = "'.$tableSearch.'"."entityid" AND "'.$tableLogCrave.'"."elementId" = "'.$tableSearch.'"."elementid" AND "'.$tableLogCrave.'"."tdsUid" = '.$this->userId.')';
                $field.=', "'.$tableLogCrave.'"."craveId" ';
            }
            
            $where="where ispublished='t' AND sectionid > 0 AND section !='workprofile' AND sectionid != 97 "; //97 is blogs entityId
            
            if($entityId > 0){
                $where.=" AND entityid = '".$entityId."' ";
            }
            
            if(!empty($keyword)){
                $keyword=pg_escape_string($keyword);
                $keywords=explode(' ',$keyword);
                $where.=" AND ( ";
                foreach($keywords as $k=>$keyword){
                    $keyword=trim($keyword);
                    if($k > 0){
                        $where.=" OR ";
                    }
                    if($keyword != ''){
                        $where.="(item).title ILIKE  '%".$keyword."%' OR (item).tagwords ILIKE  '%".$keyword."%' OR (item).online_desctiption ILIKE  '%".$keyword."%' OR (item).creative_name ILIKE  '%".$keyword."%' OR (item).creative_area ILIKE  '%".$keyword."%'";
                    }
                    
                }
                $where.=" ) ";
            }
            
            if($sectionId=='media'){
                $where.=" AND (sectionid =  1 OR sectionid =  2 OR sectionid =  3 OR sectionid =  4 OR sectionid =  10 OR sectionid =  9 ) AND section !=  'news' AND section !=  'reviews' AND section !=  'post' AND section !=  'upcoming' AND section !=  'notification' ";
            } 
            elseif($sectionId=='news' || $sectionId=='reviews'){
                $where.=" AND section = '".$sectionId."' AND sectionid > 0 ";
            }
            elseif($sectionId==18){
                $where.=" AND section = 'news' AND sectionid > 0 ";
            }
            elseif($sectionId==19){
                $where.=" AND section = 'reviews' AND sectionid > 0 ";
            }elseif($sectionId > 0 && ($FromSearchPage == 'linkToScript' || $FromSearchPage == 'linkToSoundtrack' || $FromSearchPage == 'linkToPoster')){
                $where.=" AND sectionid =  ".$sectionId." AND section !=  'news' AND section !=  'reviews' AND section !=  'post' AND section !=  'upcoming' AND section !=  'notification' ";
            }
            elseif($sectionId > 0 && ($projectPart == 'news' || $projectPart == 'reviews' || $projectPart == 'post')){
                $where.=" AND sectionid =  ".$sectionId." AND section =  '".$projectPart."' ";
            }elseif($sectionId > 0 && !($projectPart == 'news' || $projectPart == 'reviews' || $projectPart == 'post')){
                $where.=" AND sectionid =  ".$sectionId." AND section !=  'news' AND section !=  'reviews' AND section !=  'post' AND section !=  'upcoming' ";
            }
            
            // in showcase case do not show mutlilangual data show  (add by lokendra)
            if($FromSearchPage == 'showcase'){
                $where.=" AND entityid !=  100 ";
            }
            
            if($industryId > 0){
                $where.=" AND (item).industryid =  ".$industryId." ";
            }
            if($languageId > 0){
                $where.=" AND (item).languageid =  ".$languageId." ";
            }
            if($countryId > 0){
                $where.=" AND (item).countryid =  '".$countryId."' ";
            }
            
            if($projectPart == 'news' || $projectPart == 'reviews' || $projectPart == 'post' || $projectPart == 'upcomingprojects'){
                $where.=" AND section =  '".$projectPart."' ";
            }
            elseif($projectPart == 'projects'){
                $where.=" AND section !=  'upcoming' ";
            }
            elseif($projectPart == 'free'){
                $where.=" AND (item).sell_option =  '".$projectPart."' ";;
            }
            elseif($projectPart == 'top100craved'){
                $limit=' limit 100 ';
            }
            
            if($catId > 0){
                $where.=" AND (item).categoryid =  '".$catId."' ";
            }
            if($ProductCat != 'all' && $ProductCat != '' ){
                $where.=" AND (item).categoryid =  '".$ProductCat."' ";
            }
            if(is_array($alltype)){
                $alltype=$alltype[0];
            }
            if($alltype != 'alltype'){
                $countTypeId=count($typeId);
                if(is_array($typeId) && $countTypeId > 0){
                    $i=0;
                    $where.=" AND ( ";
                    foreach($typeId as $typeid){
                        $i++;
                        if($typeid > 0){
                            $where.=" (item).typeid = '".$typeid."' ";
                            if($i < $countTypeId){
                                $where.=" OR ";
                            }
                        }
                    }
                    $where.=" ) ";
                }
                
                $countGenreId=count($GenreId);
                if(is_array($GenreId) && $countGenreId > 0){
                    $i=0;
                    $where.=" AND ( ";
                    foreach($GenreId as $genreid){
                        $i++;
                        if($genreid > 0){
                            $where.="  (item).genreid = '".$genreid."' ";
                            if($i < $countGenreId){
                                $where.=" OR ";
                            }
                        }
                    }
                    $where.=" ) ";
                }
            }
            if($EMgenre>0){
                $where.=" AND (item).genreid = '".$EMgenre."' ";
            }
            
            //work
            $allWorkType=$this->input->post('allWorkType');
            if($allWorkType != 'allWorkType' &&  $sectionId==11){
                $WorkOffered=$this->input->post('WorkOffered');
                $WorkOffered=trim($WorkOffered);
                $WorkWanted=$this->input->post('WorkWanted');
                $WorkWanted=trim($WorkWanted);
                $urgentWorkOffered=$this->input->post('urgentWorkOffered');
                $normalWorkOffered=$this->input->post('normalWorkOffered');
                $experienceWorkOffered=$this->input->post('experienceWorkOffered');
                $expWorkWanted=$this->input->post('expWorkWanted');
                $normalWorkWanted=$this->input->post('normalWorkWanted');
                
                if(($WorkOffered && !empty($WorkOffered) || $urgentWorkOffered=='t' || $normalWorkOffered=='t' || $experienceWorkOffered=='t' ) || ($WorkWanted && !empty($WorkWanted)) || ($expWorkWanted=='t')  || ($normalWorkWanted=='t')){	
                    $workOfferedFlag=false;
                    if(($WorkOffered && !empty($WorkOffered) || $urgentWorkOffered=='t' || $normalWorkOffered=='t' || $experienceWorkOffered=='t' ) ){
                        $workOfferedFlag=true;
                        $where.=" AND ( ";
                        $where.=" (item).work_type = 'offered' ";
                        if($urgentWorkOffered!='t' || $normalWorkOffered !='t'){
                            if($urgentWorkOffered=='t'){
                                $where.=" AND (item).is_urgent_work = 't' ";
                            }
                            elseif($normalWorkOffered=='t'){
                                $where.=" AND (item).is_urgent_work = 'f' ";
                            }
                        }
                        
                        if($experienceWorkOffered == 't'){
                                $where.=" AND (item).is_experience_work = 't' ";
                        }else{
                            $where.=" AND (item).is_experience_work = 'f' ";
                        }
                        
                        $where.=" ) ";
                    }
                    if(($WorkWanted && !empty($WorkWanted)) || ($expWorkWanted=='t') || ($normalWorkWanted=='t')){
                        if($workOfferedFlag){
                            $where.=" OR ( ";
                        }else{
                            $where.=" AND ( ";
                        }
                        
                        $where.=" (item).work_type = 'wanted' ";
                        
                        if($expWorkWanted!='t' || $normalWorkWanted !='t'){
                            if($expWorkWanted=='t'){
                                $where.=" AND (item).is_experience_work = 't' ";
                            }
                            elseif($normalWorkWanted=='t'){
                                $where.=" AND (item).is_experience_work = 'f' ";
                            }
                        }
                        $where.=" ) ";
                    }
                }
            }
            
            // Performance & Event
            
            $city=$this->input->post('city');
            $city=($city==$this->lang->line('city'))?'':$city;
            if(isset($city) && !empty($city) && $city != ''){
                $where.=" AND (item).city ILIKE  '%".$city."%' ";
            }
            
            $PEcat=$this->input->post('PEcat');
            if(isset($PEcat) && $PEcat && $PEcat !='all'){
                $where.=" AND (item).element_type = '".$PEcat."' ";
            }
            $PEtype=$this->input->post('PEtype');
            if(isset($PEtype) && $PEtype && $PEtype !='all'){
                $where.=" AND (item).type = '".$PEtype."' ";
            }
            $PEgenre=$this->input->post('PEgenre');
            if(isset($PEgenre) && $PEgenre && $PEgenre !='all'){
                $where.=" AND (item).genre = '".$PEgenre."' ";
            }
            
            $eventStartDate=$this->input->post('eventStartDate'); 
            if(isset($eventStartDate) && $eventStartDate && $eventStartDate !=''){
                $eventStartDate=str_replace(':','-',$eventStartDate);
                $eventStartDate=date('Y-m-d',strtotime($eventStartDate));
                $where.=" AND (item).event_start_date >= '".$eventStartDate."' ";
            }
            
            $eventEndDate=$this->input->post('eventEndDate'); 
            if(isset($eventEndDate) && $eventEndDate && $eventEndDate !=''){
                $eventEndDate=str_replace(':','-',$eventEndDate);
                $eventEndDate=date('Y-m-d',strtotime($eventEndDate));
                $where.=" AND (item).event_end_date <= '".$eventEndDate."' ";
            }
        }
        $isSetCookie = setPerPageCookie('searchPerPageVal',$this->config->item('perPageRecord'));	
        
        $pages = new Pagination_new_ajax;
        if($searchSectionId=='associatedMember') {
            $resData =  $this->model_common->getToadUsersData($sectionId, $keyword, '','');
            $pages->items_total = count($resData);
        } else {
            $pages->items_total = $this->model_common->getDataFromMixTabel($table, 'id',  $where, '', '',true ); // this is the COUNT(*) query that gets the total record count from the table you are querying
        }
        
        $this->data['perPageRecord'] = $this->config->item('perPageRecord');
        
        $pages->items_per_page=(isset($_REQUEST['ipp']) && $_REQUEST['ipp'] > 0) ? $_REQUEST['ipp']:$isSetCookie;
        
        $pages->paginate();
        
        $limit=' LIMIT '.$pages->limit.' OFFSET '.$pages->offst.' ';
       
        if($searchSectionId == 'associatedMember') {
            $this->data['searchResult']=$this->model_common->getToadUsersData( $sectionId, $keyword, '','',$pages->limit,$pages->offst);
            // set associated membber result view 
            $searchView = 'media/form/creative_members_search_result';
            // set view header and title
            $searchHeader = $this->lang->line('memberSearchHead');
            $searchTitle = $this->lang->line('memberSearchTitle');
        } else {
            $this->data['searchResult']=$this->model_common->getDataFromMixTabel($table, $field,  $where, $orderBy,  $limit);
            // set associated media result view 
            $searchView = 'search_associated_media_result';
            // set view header and title
            $searchHeader = $this->lang->line('mediaSearchHead');
            $searchTitle = $this->lang->line('mediaSearchTitle');
        }
        
        $this->data['items_total'] = $pages->items_total;
        $this->data['items_per_page'] = $pages->items_per_page;
        $this->data['pagination_links'] = $pages->display_pages();
        
        $pages->paginate($isShowButton=true,$isShowNumbers=false);
        $this->data['pagination_links_withoutButton'] = $pages->display_pages();
        
        
        if(($this->input->post('val2') == 'media') || ($prosectionId==1)){
            $this->data['prosectionId'] = 1;
        }
        if($this->input->post('prosectionId')==1){
            $this->data['prosectionId'] = $this->input->post('prosectionId');
        }
        
        if($this->input->post('fromSection')!='')
        {
            $this->data['fromSection'] = $this->input->post('fromSection');
        }
        else if($this->input->post('val3')!=''){
            $this->data['fromSection'] = $this->input->post('val3');
        }
        $this->data['searchHeader'] = $searchHeader;
        $this->data['searchTitle']  = $searchTitle;
        $searchResultView = $this->load->view($searchView,$this->data,$loadView);
        if($loadView){
            return $searchResultView;
        }
       
    }
	 
 }
