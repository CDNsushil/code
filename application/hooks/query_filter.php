<?php defined('BASEPATH') or die('No direct script access.');

class query_filter {

    public $CI;

    function __construct(){
        $this->CI = &get_instance();
    }
    
    public function filter(){
        $isLogin = isLoginUser();
        if($isLogin && isset($this->CI->db)){
            $dp = $this->CI->db->dbprefix;
            foreach ($this->CI->db->queries as $idx => $query){
                $qType = substr($query,0,6);
                $qType = strtolower($qType);
                switch($qType){
                    case 'update':
                        $res = $this->updateQueryDetails($query);
                    break;
                    
                    case 'delete':
                        $res = $this->deleteQueryDetails($query);
                    break;
                    
                    default:
                        $res = false;
                    break;
                }
                if($res && is_array($res) && count($res)>0){
                   $isData = true;
                   switch($res['table']){
                        case $dp.'UserShowcase':
                            $upData=$this->showcaseData($res,$qType);
                        break;
                        
                        case $dp.'UserShowcaseLang':
                            $upData=$this->showcaseLangData($res,$qType);
                        break;
                        
                        case $dp.'Blogs':
                            $upData=$this->blogData($res,$qType);
                        break;
                        
                        case $dp.'Posts':
                           $upData=$this->postData($res,$qType);
                        break;
                        
                        case $dp.'Project':
                            $upData=$this->mediaData($res,$qType);
                        break;
                        
                        case $dp.'FvElement':
                        case $dp.'MaElement':
                        case $dp.'WpElement':
                        case $dp.'PaElement':
                        case $dp.'EmElement':
                        case $dp.'NewsElement':
                        case $dp.'ReviewsElement':
                            $upData=$this->mediaElementData($res,$qType);
                        break;
                        
                        default:
                            $isData = false;
                        break;
                    }
                    if($isData && $upData){
                      $this->CI->model_common->updateSearch($upData);
                    }
                }
            }
        }
    }
    
    private function showcaseData($res,$qType){
        $upData = array();
        $isData = false;
       
        $sees = $this->CI->session->all_userdata();
        if(!isset($res['where']['showcaseId']) &&  isset($sees['showcaseId'])){
            $res['where']['showcaseId'] = $sees['showcaseId'];
        }
       
        if(isset($res['where']['showcaseId']) && (int)$res['where']['showcaseId'] > 0){
            $dp = $this->CI->db->dbprefix;
            $entityid = getMasterTableRecord($res['table']);
            $upData['where'] = array('entityid'=>$entityid,'elementid'=>$res['where']['showcaseId']);
            $searchRes=$this->CI->model_common->getDataFromTabel('search','id,(item).*',$upData['where']);
            $searchId=0;
            if(isset($searchRes[0]->id) && (int)$searchRes[0]->id >0){
               $sr = $searchRes[0];
               $searchId=$sr->id; 
            }
            $upData['searchId'] = $searchId;
            
            
            $creative_name = $sees['userFullName'];
            if(isset($sees['creative']) && ($sees['creative'] == 't')){
                $sectionid = $this->CI->config->item('creativesSectionId');
                $section   = $this->CI->config->item('sectionId'.$sectionid);
            }elseif(isset($sees['associatedProfessional']) && ($sees['associatedProfessional'] == 't')){
                $sectionid = $this->CI->config->item('associateprofessionalSectionId');
                $section   = $this->CI->config->item('sectionId'.$sectionid);
            }elseif(isset($sees['enterprise']) && ($sees['enterprise'] == 't')){
                $sectionid = $this->CI->config->item('enterprisesSectionId');
                $section   = $this->CI->config->item('sectionId'.$sectionid);
                $creative_name = $sees['enterpriseName'];
            }elseif(isset($sees['fans']) && ($sees['fans'] == 't')){
                $sectionid = $this->CI->config->item('fansSectionId');
                $section   = $this->CI->config->item('sectionId'.$sectionid);
            }else{
                $sectionid = 0;
                $section   = '';
            }
                
            if(($qType == 'delete') && !empty($section) && ((int)($sectionid) > 0)){
                $isData = true;
                $up = array('ispublished'=>'f','isdeleted'=>'t');
                $upWhere = array('projectid'=>$res['where']['showcaseId'], 'section'=>$section);
                $this->CI->model_common->changeProjStatusOfElement($up, $upWhere);
            }elseif(($qType == 'update') && !empty($section) && ((int)($sectionid) > 0) ){
                $isData = true;
                if($searchId == 0){
                    $upData['data']['entityid'] = $entityid;
                    $upData['data']['elementid'] = $res['where']['showcaseId'];
                    $upData['data']['projectid'] = $res['where']['showcaseId'];
                    $upData['data']['sectionid'] = $sectionid;
                    $upData['data']['section'] = $section;
                    $upData['data']['item.userid'] = $sees['user_id'];
                    $projectCreated=(isset($res['data']['dateCreated']) && !empty($res['data']['dateCreated']))?$res['data']['dateCreated']:currntDateTime();
                    $upData['data']['item.creation_date'] = $projectCreated;
                    $upData['data']['item.sell_option'] = 'free' ;
                }
                $isSetPublish = false;
                
                if(isset($res['data']['isPublished'])){
                    $isSetPublish = true;
                    $ispublished = ($res['data']['isPublished'] == 't')?'t':'f';
                    $upData['data']['ispublished'] = $ispublished;
                    if($ispublished == 't'){
                        $projPublisheDate=(isset($res['data']['publisheDate']) && !empty($res['data']['publisheDate']))?$res['data']['publisheDate']:currntDateTime();
                        $upData['data']['item.publish_date'] = $projPublisheDate;
                    }
                }
                if(isset($res['data']['isBlocked'])){
                    $isblocked = ($res['data']['isBlocked'] == 't')?'t':'f';
                    $upData['data']['isblocked'] = $isBlocked;
                    if($isblocked == 't'){
                        $isSetPublish = true;
                        $ispublished = 'f';
                    }
                }
                if(($isSetPublish == true) && (isset($ispublished)) ){
                    $ispublished = ($ispublished == 't') ? 't' : 'f';
                    $up = array('ispublished'=>$ispublished);
                    $upWhere = array('projectid'=>$res['where']['showcaseId'], 'section'=>$section);
                    if($ispublished == 't'){
                        $upWhere['isblocked'] = 'f';
                        $upWhere['isdeleted'] = 'f';
                    }
                    $this->CI->model_common->changeProjStatusOfElement($up, $upWhere);
                }
                if( !isset($sr->title) || ($sr->title != $creative_name) ){
                    $upData['data']['item.title'] = $creative_name;
                    $upData['data']['item.creative_name'] = $creative_name;
                }
                if(isset($res['data']['tagwords'])){
                    $upData['data']['item.tagwords'] = $res['data']['tagwords'];
                }
                if(isset($res['data']['creativeFocus'])){
                    $upData['data']['item.online_desctiption'] = pg_escape_string($res['data']['creativeFocus']);
                }
                
                if(isset($res['data']['optionAreaName'])){
                     $upData['data']['item.creative_area'] = $res['data']['optionAreaName'];
                }
                
                if(isset($res['data']['langaugeId']) && (int)$res['data']['langaugeId'] > 0 ){
                    $upData['data']['item.languageid'] = $res['data']['langaugeId'];
                    $langs=$this->CI->model_common->getDataFromTabel('MasterLang','Language_local',array('langId'=>$res['data']['langaugeId']));
                    if(isset($langs[0]->Language_local)){
                        $upData['data']['item.language'] = $langs[0]->Language_local;
                    }
                }
                
                if( !isset($sr->countryid) || ($sr->countryid != $sees['countryId']) ){
                    $upData['data']['item.countryid'] = $sees['countryId'];
                    $upData['data']['item.country'] = $sees['countryName'];
                }
                if(isset($res['data']['cityName'])){
                    $upData['data']['item.city'] = $res['data']['cityName'];
                }
                if(isset($res['data']['industryId']) && (int)$res['data']['industryId'] > 0 ){
                   $upData['data']['item.industryid'] = $res['data']['industryId'];
                   $upData['data']['item.industry'] = $industry = $this->CI->config->item('industry'.$res['data']['industryId']);
                   
                   $updatesql =  'UPDATE "'.$dp.'search" SET item.industryid = \''.$res['data']['industryId'].'\',item.industry = \''.$industry.'\' WHERE projectid = '.$res['where']['showcaseId'].' AND section = \''.$section.'\' ';
                   $this->CI->model_common->runQuery($updatesql);
                }
                
            }
        }
        if(!$isData){
            $upData = false;
        } return $upData;
    }
    
    private function showcaseLangData($res,$qType){
        $upData = array();
        $isData = false;
        if(isset($res['where']['showcaseLangId']) && (int)$res['where']['showcaseLangId'] > 0){
            $sees = $this->CI->session->all_userdata();
            $entityid = getMasterTableRecord($res['table']);
            $upData['where'] = array('entityid'=>$entityid,'elementid'=>$res['where']['showcaseLangId']);
            $searchRes=$this->CI->model_common->getDataFromTabel('search','id,(item).*',$upData['where']);
            $searchId=0;
            if(isset($searchRes[0]->id) && (int)$searchRes[0]->id >0){
               $sr = $searchRes[0];
               $searchId=$sr->id; 
            }
            $upData['searchId'] = $searchId;
            
            $creative_name = $sees['userFullName'];
            if(isset($sees['creative']) && ($sees['creative'] == 't')){
                $sectionid = $this->CI->config->item('creativesSectionId');
                $section   = $this->CI->config->item('sectionId'.$sectionid);
            }elseif(isset($sees['associatedProfessional']) && ($sees['associatedProfessional'] == 't')){
                $sectionid = $this->CI->config->item('associateprofessionalSectionId');
                $section   = $this->CI->config->item('sectionId'.$sectionid);
            }elseif(isset($sees['enterprise']) && ($sees['enterprise'] == 't')){
                $sectionid = $this->CI->config->item('enterprisesSectionId');
                $section   = $this->CI->config->item('sectionId'.$sectionid);
                $creative_name = $sees['enterpriseName'];
            }elseif(isset($sees['fans']) && ($sees['fans'] == 't')){
                $sectionid = $this->CI->config->item('fansSectionId');
                $section   = $this->CI->config->item('sectionId'.$sectionid);
            }else{
                $sectionid = 0;
                $section   = '';
            }
                
            if(($qType == 'delete') && !empty($section) && ((int)($sectionid) > 0)){
               $isData = true;
               $upData['data']['isdeleted'] = 't';
               $upData['data']['isPublished'] = 'f';
            }elseif(($qType == 'update') && !empty($section) && ((int)($sectionid) > 0) ){
                $isData = true;
                if($searchId == 0){
                    $upData['data']['entityid'] = $entityid;
                    $upData['data']['elementid'] = $res['where']['showcaseLangId'];
                    $upData['data']['projectid'] = $sees['showcaseId'];
                    $upData['data']['sectionid'] = $sectionid;
                    $upData['data']['section'] = $section;
                    $upData['data']['item.userid'] = $sees['user_id'];
                    $projectCreated=(isset($res['data']['dateCreated']) && !empty($res['data']['dateCreated']))?$res['data']['dateCreated']:currntDateTime();
                    $upData['data']['item.creation_date'] = $projectCreated;
                    $upData['data']['item.sell_option'] = 'free' ;
                    
                    if(!isset($res['data']['langId']) || !((int)$res['data']['langId'] > 0) ){
                        $langs=$this->CI->model_common->getShowcaseLang($res['where']['showcaseLangId']);
                        if(isset($langs[0]->Language_local)){
                            $upData['data']['item.languageid'] = $langs[0]->langId;
                            $upData['data']['item.language'] = $langs[0]->Language_local;
                        }
                    }
                    
                    $inds=$this->CI->model_common->getDataFromTabel('UserShowcase','industryId',array('showcaseId'=>$sees['showcaseId']));
                    if(isset($inds[0]->industryId)){
                        $upData['data']['item.industryid'] = $inds[0]->industryId;
                        $upData['data']['item.industry'] = $this->CI->config->item('industry'.$inds[0]->industryId);
                    }
                }
                
                if(isset($res['data']['isPublished'])){
                    $ispublished = ($res['data']['isPublished'] == 't')?'t':'f';
                }else{
                    $pd = $this->CI->model_common->getDataFromTabel('UserShowcase', 'isPublished', array('showcaseId'=>$sees['showcaseId']));
                    if(isset($pd[0]->isPublished)){
                         $ispublished = $pd[0]->isPublished;
                    }
                    $ispublished = ($ispublished == 't')?'t':'f';
                }
                $upData['data']['ispublished'] = $ispublished;
                
                if(isset($res['data']['isBlocked'])){
                    $isblocked = ($res['data']['isBlocked'] == 't')?'t':'f';
                    $upData['data']['isblocked'] = $isBlocked;
                    if($isblocked == 't'){
                        $upData['data']['ispublished'] = 'f';
                    }
                }
                
                if( !isset($sr->title) || ($sr->title != $creative_name) ){
                    $upData['data']['item.title'] = $creative_name;
                    $upData['data']['item.creative_name'] = $creative_name;
                }
                if(isset($res['data']['tagwords'])){
                    $upData['data']['item.tagwords'] = $res['data']['tagwords'];
                }
                if(isset($res['data']['creativeFocus'])){
                    $upData['data']['item.online_desctiption'] = pg_escape_string($res['data']['creativeFocus']);
                }
                
                if(isset($res['data']['optionAreaName'])){
                     $upData['data']['item.creative_area'] = $res['data']['optionAreaName'];
                }
                
                if(isset($res['data']['langId']) && (int)$res['data']['langId'] > 0 ){
                    $upData['data']['item.languageid'] = $res['data']['langId'];
                    $langs=$this->CI->model_common->getDataFromTabel('MasterLang','Language_local',array('langId'=>$res['data']['langId']));
                    if(isset($langs[0]->Language_local)){
                        $upData['data']['item.language'] = $langs[0]->Language_local;
                    }
                }
                
                if( !isset($sr->countryid) || ($sr->countryid != $sees['countryId']) ){
                    $upData['data']['item.countryid'] = $sees['countryId'];
                    $upData['data']['item.country'] = $sees['countryName'];
                }
                if(isset($res['data']['cityName'])){
                    $upData['data']['item.city'] = $res['data']['cityName'];
                }
            }
        }
        if(!$isData){
            $upData = false;
        } return $upData;
    }
    
    private function blogData($res,$qType){
        $upData = array();
        $isData = false;
        
        $sees = $this->CI->session->all_userdata();
        if(isset($res['where']['blogId']) && (int)$res['where']['blogId'] > 0){
            $dp = $this->CI->db->dbprefix;
            $entityid = getMasterTableRecord($res['table']);
            $upData['where'] = array('entityid'=>$entityid,'elementid'=>$res['where']['blogId']);
            $searchRes=$this->CI->model_common->getDataFromTabel('search','id,(item).creative_name,(item).creative_area,(item).countryid',$upData['where']);
            $searchId=0;
            if(isset($searchRes[0]->id) && (int)$searchRes[0]->id >0){
               $sr = $searchRes[0];
               $searchId=$sr->id; 
            }
            $upData['searchId'] = $searchId;
            
            $sectionid = $this->CI->config->item('blogsSectionId');
            $section   = $this->CI->config->item('sectionId'.$sectionid);
            
            if(isset($sees['enterprise']) && ($sees['enterprise'] == 't')){
                $creative_name = $sees['enterpriseName'];
            }else{
                $creative_name = $sees['userFullName'];
            }
                
            if(($qType == 'delete') && !empty($section) && ((int)($sectionid) > 0)){
                $isData = true;
                $up = array('ispublished'=>'f','isdeleted'=>'t');
                $upWhere = array('projectid'=>$res['where']['blogId'], 'section'=>$section);
                $this->CI->model_common->changeProjStatusOfElement($up, $upWhere);
            }elseif(($qType == 'update') && !empty($section) && ((int)($sectionid) > 0) ){
                $isData = true;
                if($searchId == 0){
                    $upData['data']['entityid'] = $entityid;
                    $upData['data']['elementid'] = $res['where']['blogId'];
                    $upData['data']['projectid'] = $res['where']['blogId'];
                    $upData['data']['sectionid'] = $sectionid;
                    $upData['data']['section'] = $section;
                    $upData['data']['item.userid'] = $sees['user_id'];
                    $projectCreated=(isset($res['data']['dateCreated']) && !empty($res['data']['dateCreated']))?$res['data']['dateCreated']:currntDateTime();
                    $upData['data']['item.creation_date'] = $projectCreated;
                    $upData['data']['item.sell_option'] = 'free' ;
                }
                $isSetPublish = false;
                
                if(isset($res['data']['isPublished'])){
                    $isSetPublish = true;
                    $ispublished = ($res['data']['isPublished'] == 't')?'t':'f';
                    $upData['data']['ispublished'] = $ispublished;
                    if($ispublished == 't'){
                        $upData['data']['item.publish_date'] = currntDateTime();;
                    }
                }
                if(isset($res['data']['isBlocked'])){
                    $isblocked = ($res['data']['isBlocked'] == 't')?'t':'f';
                    $upData['data']['isblocked'] = $isBlocked;
                    if($isblocked == 't'){
                        $isSetPublish = true;
                        $ispublished = 'f';
                        $upData['data']['ispublished'] = $ispublished;
                    }
                }
                
               /* if(($isSetPublish == true) && (isset($ispublished)) ){
                    $ispublished = ($ispublished == 't') ? 't' : 'f';
                    $up = array('ispublished'=>$ispublished);
                    $upWhere = array('projectid'=>$res['where']['blogId'], 'section'=>$section);
                    if($ispublished == 't'){
                        $upWhere['isblocked'] = 'f';
                        $upWhere['isdeleted'] = 'f';
                    }
                    $this->CI->model_common->changeProjStatusOfElement($up, $upWhere);
                }*/
                
                if( !isset($sr->title) || ($sr->title != $creative_name) ){
                    $upData['data']['item.creative_name'] = $creative_name;
                }
                if(isset($res['data']['blogTitle'])){
                    $upData['data']['item.title'] = $res['data']['blogTitle'];
                }
                if(isset($res['data']['blogTagWords'])){
                    $upData['data']['item.tagwords'] = $res['data']['blogTagWords'];
                }
                if(isset($res['data']['blogOneLineDesc'])){
                    $upData['data']['item.online_desctiption'] = pg_escape_string($res['data']['blogOneLineDesc']);
                }
                
                if( !isset($sr->creative_area) || ($sr->creative_area != $sees['userArea']) ){
                     $upData['data']['item.creative_area'] = $sees['userArea'];
                }
                
                if(isset($res['data']['blogLanguage']) && (int)$res['data']['blogLanguage'] > 0 ){
                    $upData['data']['item.languageid'] = $res['data']['blogLanguage'];
                    $langs=$this->CI->model_common->getDataFromTabel('MasterLang','Language_local',array('langId'=>$res['data']['blogLanguage']));
                    if(isset($langs[0]->Language_local)){
                        $upData['data']['item.language'] = $Language_local = $langs[0]->Language_local;
                    }else{
                        $Language_local ='';
                    }
                    
                    $updatesql =  'UPDATE "'.$dp.'search" SET item.languageid = \''.$res['data']['blogLanguage'].'\',item.language = \''.$Language_local.'\' WHERE projectid = '.$res['where']['blogId'].' AND section = \''.$section.'\' ';
                    $this->CI->model_common->runQuery($updatesql);
                }
                
                if(isset($res['data']['rating']) && (int)$res['data']['rating'] > 0 ){
                    $upData['data']['item.self_ratingid'] = $res['data']['rating'];
                    $upData['data']['item.self_rating'] = $self_rating = $this->CI->config->item('selfRating'.$res['data']['rating']);
                   
                    $updatesql =  'UPDATE "'.$dp.'search" SET item.self_ratingid = \''.$res['data']['rating'].'\',item.self_rating = \''.$self_rating.'\' WHERE projectid = '.$res['where']['blogId'].' AND section = \''.$section.'\' ';
                    $this->CI->model_common->runQuery($updatesql);
                }
                
                if( !isset($sr->countryid) || ($sr->countryid != $sees['countryId']) ){
                    $upData['data']['item.countryid'] = $sees['countryId'];
                    $upData['data']['item.country'] = $sees['countryName'];
                }
                
                if(isset($res['data']['blogIndustry']) && (int)$res['data']['blogIndustry'] > 0 ){
                   $upData['data']['item.industryid'] = $res['data']['blogIndustry'];
                   $upData['data']['item.industry'] = $industry = $this->CI->config->item('industry'.$res['data']['blogIndustry']);
                   
                   $updatesql =  'UPDATE "'.$dp.'search" SET item.industryid = \''.$res['data']['blogIndustry'].'\',item.industry = \''.$industry.'\' WHERE projectid = '.$res['where']['blogId'].' AND section = \''.$section.'\' ';
                   $this->CI->model_common->runQuery($updatesql);
                   
                }
                
            }
        }
        if(!$isData){
            $upData = false;
        } return $upData;
    }
    
    private function postData($res,$qType){
        $upData = array();
        $isData = false;
        $sees = $this->CI->session->all_userdata();
        if(isset($res['where']['postId']) && (int)$res['where']['postId'] > 0){
            $dp = $this->CI->db->dbprefix;
            $entityid = getMasterTableRecord($res['table']);
            $upData['where'] = array('entityid'=>$entityid,'elementid'=>$res['where']['postId']);
            $searchRes=$this->CI->model_common->getDataFromTabel('search','id,(item).creative_name,(item).creative_area,(item).countryid',$upData['where']);
            $searchId=0;
            if(isset($searchRes[0]->id) && (int)$searchRes[0]->id >0){
               $sr = $searchRes[0];
               $searchId=$sr->id; 
            }
            $upData['searchId'] = $searchId;
            
            $sectionid = $this->CI->config->item('blogsSectionId');
            $section   = $this->CI->config->item('sectionId'.$sectionid);
            
            if(isset($sees['enterprise']) && ($sees['enterprise'] == 't')){
                $creative_name = $sees['enterpriseName'];
            }else{
                $creative_name = $sees['userFullName'];
            }
                
            if(($qType == 'delete') && !empty($section) && ((int)($sectionid) > 0)){
                $isData = true;
                $upData['data']['isdeleted'] = 't';
                $upData['data']['isPublished'] = 'f';
            }elseif(($qType == 'update') && !empty($section) && ((int)($sectionid) > 0) ){
                $isData = true;
                if($searchId == 0){
                    $bd=$this->CI->model_common->getBlogDataForPost($res['where']['postId']);
                    if(isset($bd[0]->blogId) && ($bd[0]->blogId > 0)){
                        $blogId = $bd[0]->blogId;
                        $rating = $bd[0]->rating;
                        $blogIndustry = $bd[0]->blogIndustry;
                        $langId = $bd[0]->langId;
                        $Language_local = $bd[0]->Language_local;
                    }else{
                        $blogId = 0;
                        $rating = 0;
                        $langId = 0;
                        $Language_local = '';
                    }
                    $upData['data']['entityid'] = $entityid;
                    $upData['data']['elementid'] = $res['where']['postId'];
                    $upData['data']['projectid'] = $blogId;
                    $upData['data']['sectionid'] = $sectionid;
                    $upData['data']['section'] = $section;
                    $upData['data']['item.userid'] = $sees['user_id'];
                    $projectCreated=(isset($res['data']['dateCreated']) && !empty($res['data']['dateCreated']))?$res['data']['dateCreated']:currntDateTime();
                    $upData['data']['item.creation_date'] = $projectCreated;
                    $upData['data']['item.sell_option'] = 'free' ;
                
                    $upData['data']['item.languageid'] = $langId;
                    $upData['data']['item.language'] = $Language_local;
                    
                    
                    $upData['data']['item.self_ratingid'] = $rating;
                    if((int)$rating > 0 ){
                        $upData['data']['item.self_rating'] = $this->CI->config->item('selfRating'.$rating);
                    }else{
                        $upData['data']['item.self_rating'] = '';
                    }
                    
                    $upData['data']['item.industryid'] = $blogIndustry;
                    if((int)$blogIndustry > 0 ){
                        $upData['data']['item.industry'] = $this->CI->config->item('industry'.$blogIndustry);
                    }else{
                        $upData['data']['item.industry'] = '';
                    }
                }
                $isSetPublish = false;
                
                if(isset($res['data']['isPublished'])){
                    $ispublished = ($res['data']['isPublished'] == 't')?'t':'f';
                    $upData['data']['ispublished'] = $ispublished;
                    if($ispublished == 't'){
                        $upData['data']['item.publish_date'] = currntDateTime();
                    }
                }
                if(isset($res['data']['isBlocked'])){
                    $isblocked = ($res['data']['isBlocked'] == 't')?'t':'f';
                    $upData['data']['isblocked'] = $isBlocked;
                    if($isblocked == 't'){
                        $upData['data']['ispublished'] = 'f';
                    }
                }
                
                if( !isset($sr->title) || ($sr->title != $creative_name) ){
                    $upData['data']['item.creative_name'] = $creative_name;
                }
                if(isset($res['data']['postTitle'])){
                    $upData['data']['item.title'] = $res['data']['postTitle'];
                }
                if(isset($res['data']['postTagWords'])){
                    $upData['data']['item.tagwords'] = $res['data']['postTagWords'];
                }
                if(isset($res['data']['postOneLineDesc'])){
                    $upData['data']['item.online_desctiption'] = pg_escape_string($res['data']['postOneLineDesc']);
                }
                
                if( !isset($sr->creative_area) || ($sr->creative_area != $sees['userArea']) ){
                     $upData['data']['item.creative_area'] = $sees['userArea'];
                }
                
                if(isset($res['data']['blogCategoryId']) && (int)$res['data']['blogCategoryId'] > 0 ){
                    $upData['data']['item.categoryid'] = $res['data']['blogCategoryId'];
                    $cat=$this->CI->model_common->getDataFromTabel('BlogCategory','categoryTitle',array('categoryId'=>$res['data']['blogCategoryId']));
                    if(isset($cat[0]->categoryTitle)){
                        $upData['data']['item.category'] = $cat[0]->categoryTitle;
                    }
                }
                
                if( !isset($sr->countryid) || ($sr->countryid != $sees['countryId']) ){
                    $upData['data']['item.countryid'] = $sees['countryId'];
                    $upData['data']['item.country'] = $sees['countryName'];
                }
            }
        }
        if(!$isData){
            $upData = false;
        } return $upData;
    }
    
    
    private function mediaData($res,$qType){
        $upData = array();
        $isData = false;
        if(isset($res['where']['projId']) && (int)$res['where']['projId'] > 0){
            $entityid = getMasterTableRecord($res['table']);
            $upData['where'] = array('entityid'=>$entityid,'elementid'=>$res['where']['projId']);
            $searchRes=$this->CI->model_common->getDataFromTabel('search','id',$upData['where']);
            $searchId=0;
            if(isset($searchRes[0]->id) && (int)$searchRes[0]->id >0){
               $searchId=$searchRes[0]->id; 
            }
            $upData['searchId'] = $searchId;
            
            $method = $this->CI->router->fetch_method();
            $sectionid = $this->CI->config->item($method.'SectionId');
            
            if($method == 'newswizard'){
                $section = 'news';
                $sectionid = 0;
            }elseif($method == 'reviewswizard'){
                $section = 'reviews';
                $sectionid = 0;
            }
            elseif($sectionid && is_numeric($sectionid)){
                $section = $this->CI->config->item('sectionId'.$sectionid);
            }else{
                $section = '';
                $sectionid = 0;
            }
                
            if(($qType == 'delete') && !empty($section)){
                $isData = true;
                $up = array('ispublished'=>'f','isdeleted'=>'t');
                $upWhere = array('projectid'=>$res['where']['projId'], 'section'=>$section);
                $this->CI->model_common->changeProjStatusOfElement($up, $upWhere);
            }elseif(($qType == 'update') && !empty($section) ){
                $isData = true;
                if($searchId == 0){
                    $upData['data']['entityid'] = $entityid;
                    $upData['data']['elementid'] = $res['where']['projId'];
                    $upData['data']['projectid'] = $res['where']['projId'];
                    $upData['data']['sectionid'] = $sectionid;
                    $upData['data']['section'] = $section;
                    if((int)$sectionid > 0){
                        $upData['data']['item.industryid'] = $sectionid;
                        $upData['data']['item.industry'] = $this->CI->config->item('industry'.$sectionid);   
                    }
                    $upData['data']['item.userid'] = $this->CI->session->userdata('user_id');
                    $projectCreated=(isset($res['data']['createDate']) && !empty($res['data']['createDate']))?$res['data']['createDate']:currntDateTime();
                    $upData['data']['item.creation_date'] = $projectCreated;

                    $upData['data']['item.sell_option'] = 'free' ;

                    if(!isset($res['data']['projCategory']) || !((int)$res['data']['projCategory'] > 0) ){
                        $category=$this->CI->model_common->getDataFromTabel('Project','projCategory',array('projId'=>$res['where']['projId']));
                        if(isset($category[0]->projCategory)){
                            $categoryid = $category[0]->projCategory;
                            $upData['data']['item.categoryid'] = $categoryid;
                            $upData['data']['item.category'] = $this->CI->config->item('projCat'.$categoryid);
                        }
                    }
                }
                $isSetPublish = false;
                
                if(isset($res['data']['isPublished'])){
                    $isSetPublish = true;
                    $ispublished = ($res['data']['isPublished'] == 't')?'t':'f';
                    $upData['data']['ispublished'] = $ispublished;
                    if($ispublished == 't'){
                        $projPublisheDate=(isset($res['data']['projPublisheDate']) && !empty($res['data']['projPublisheDate']))?$res['data']['projPublisheDate']:currntDateTime();
                        $upData['data']['item.publish_date'] = $projPublisheDate;
                    }
                }
                if(isset($res['data']['isBlocked'])){
                    $isblocked = ($res['data']['isBlocked'] == 't')?'t':'f';
                    $upData['data']['isblocked'] = $isBlocked;
                    if($isblocked == 't'){
                        $isSetPublish = true;
                        $ispublished = 'f';
                    }
                }
                
                if(($isSetPublish == true) && (isset($ispublished)) ){
                    $ispublished = ($ispublished == 't') ? 't' : 'f';
                    $up = array('ispublished'=>$ispublished);
                    $upWhere = array('projectid'=>$res['where']['projId'], 'section'=>$section);
                    if($ispublished == 't'){
                        $upWhere['isblocked'] = 'f';
                        $upWhere['isdeleted'] = 'f';
                    }
                    $this->CI->model_common->changeProjStatusOfElement($up, $upWhere);
                }
                
                if(isset($res['data']['projName'])){
                    $upData['data']['item.title'] = $res['data']['projName'];
                }
                if(isset($res['data']['projTag'])){
                    $upData['data']['item.tagwords'] = $res['data']['projTag'];
                }
                if(isset($res['data']['projShortDesc'])){
                    $upData['data']['item.online_desctiption'] = pg_escape_string($res['data']['projShortDesc']);
                }
                if($this->CI->session->userdata('enterprise') == 't'){
                    $creative_name = $this->CI->session->userdata('enterpriseName');
                }else{
                    $creative_name = $this->CI->session->userdata('userFullName');
                }
                $upData['data']['item.creative_name'] = $creative_name;
                $upData['data']['item.creative_area'] = $this->CI->session->userdata('userArea');
                
                if(isset($res['data']['projSellstatus'])){
                    $upData['data']['item.sell_option'] = ($res['data']['projSellstatus']=='t')?'paid':'free' ;
                }elseif(isset($res['data']['projSellType']) && $res['data']['projSellType'] > 0){
                    $upData['data']['item.sell_option'] = 'paid';
                }elseif(isset($res['data']['projPrice']) && $res['data']['projPrice'] > 0){
                    $upData['data']['item.sell_option'] = 'paid';
                }
                elseif(isset($res['data']['projDownloadPrice']) && $res['data']['projDownloadPrice'] > 0){
                    $upData['data']['item.sell_option'] = 'paid';
                }elseif(isset($res['data']['projPpvPrice']) && $res['data']['projPpvPrice'] > 0){
                    $upData['data']['item.sell_option'] = 'paid';
                }
              
                if(isset($res['data']['projCategory']) && (int)$res['data']['projCategory'] > 0 ){
                    $upData['data']['item.categoryid'] = $res['data']['projCategory'];
                    $upData['data']['item.category'] = $this->CI->config->item('projCat'.$res['data']['projCategory']);
                }
                if(isset($res['data']['projRating']) && (int)$res['data']['projRating'] > 0 ){
                    $upData['data']['item.self_ratingid'] = $res['data']['projRating'];
                    $upData['data']['item.self_rating'] = $this->CI->config->item('selfRating'.$res['data']['projRating']);
                }
                if(isset($res['data']['productionHouse']) ){
                    $upData['data']['item.publisher'] = $res['data']['productionHouse'];
                }
            }
        }
        if(!$isData){
            $upData = false;
        } return $upData;
    }
    
    private function mediaElementData($res,$qType){
        $upData = array();
        $isData = false;
        if(isset($res['where']['elementId']) && (int)$res['where']['elementId'] > 0){
            $entityid = getMasterTableRecord($res['table']);
            $upData['where'] = array('entityid'=>$entityid,'elementid'=>$res['where']['elementId']);
            $searchRes=$this->CI->model_common->getDataFromTabel('search','id',$upData['where']);
            $searchId=0;
            if(isset($searchRes[0]->id) && (int)$searchRes[0]->id >0){
               $searchId=$searchRes[0]->id; 
            }
            $upData['searchId'] = $searchId;
            $method = $this->CI->router->fetch_method();
            $sectionid = $this->CI->config->item($method.'SectionId');
            if($method == 'newswizard'){
                    $section = 'news';
                    $sectionid = 0;
            }elseif($method == 'reviewswizard'){
                $section = 'reviews';
                $sectionid = 0;
            }
            elseif($sectionid && is_numeric($sectionid)){
                $section = $this->CI->config->item('sectionId'.$sectionid);
            }else{
                $section = '';
                $sectionid = 0;
            }
            if($qType == 'delete'){
                $isData = true;
                $upData['data']['isdeleted'] = 't';
                $upData['data']['isPublished'] = 'f';
            }elseif(($qType == 'update') && !empty($section)){
                $isData = true;
                if($searchId == 0){
                    $upData['data']['entityid'] = $entityid;
                    $upData['data']['elementid'] = $res['where']['elementId'];
                    $upData['data']['section'] = $section;
                    $upData['data']['sectionid'] = $sectionid;
                    if(((int)$sectionid > 0) && !in_array($method,array('educationmaterials','newswizard','reviewswizard'))){
                        $upData['data']['item.industryid'] = $sectionid;
                        $upData['data']['item.industry'] = $this->CI->config->item('industry'.$sectionid);   
                    }
                    $upData['data']['item.userid'] = $this->CI->session->userdata('user_id');
                    $projectCreated=(isset($res['data']['createdDate']) && !empty($res['data']['createdDate']))?$res['data']['createdDate']:currntDateTime();
                    $upData['data']['item.creation_date'] = $projectCreated;
                    $upData['data']['item.sell_option'] = 'free' ;
                }
                    
                if( (isset($res['data']['projId']) && (int)$res['data']['projId'] > 0) || (isset($res['where']['projId']) && (int)$res['where']['projId'] > 0) ){
                    $projectid = (isset($res['data']['projId']) && (int)$res['data']['projId'] > 0) ? $res['data']['projId'] : ((isset($res['where']['projId']) && (int)$res['where']['projId'] > 0) ? $res['where']['projId'] : 0);
                    if(is_numeric($projectid) && $projectid > 0){
                       $upData['data']['projectid'] = $projectid;
                    }
                }

                if(isset($res['data']['industryId']) && (int)$res['data']['industryId'] > 0 && in_array($method,array('educationmaterials','newswizard','reviewswizard'))){
                   $upData['data']['item.industryid'] = $res['data']['industryId'];
                   $upData['data']['item.industry'] = $this->CI->config->item('industry'.$res['data']['industryId']);
                   if($method == 'newswizard' || $method == 'reviewswizard'){
                        $upData['data']['sectionid'] = $res['data']['industryId'];
                   }
                }

                if(isset($res['data']['isPublished'])){
                    $ispublished = ($res['data']['isPublished'] == 't')?'t':'f';
                }else{
                    $ispublished = $this->CI->model_common->getProjStatusOfElement($res['table'], array('e.elementId'=>$res['where']['elementId']));
                    $ispublished = ($ispublished == 't')?'t':'f';
                }
                $upData['data']['ispublished'] = $ispublished;

                if($ispublished == 't'){
                    $upData['data']['item.publish_date'] = currntDateTime();
                }

                if(isset($res['data']['isBlocked'])){
                    $isblocked = ($res['data']['isBlocked'] == 't')?'t':'f';
                    $upData['data']['isblocked'] = $isBlocked;
                    if($isblocked == 't'){
                        $upData['data']['ispublished'] = 'f';
                    }
                }

                if(isset($res['data']['title'])){
                    $upData['data']['item.title'] = $res['data']['title'];
                }
                if(isset($res['data']['tags'])){
                    $upData['data']['item.tagwords'] = $res['data']['tags'];
                }
                if(isset($res['data']['article'])){
                    $upData['data']['item.online_desctiption'] = pg_escape_string($res['data']['article']);
                }elseif(isset($res['data']['description'])){
                    $upData['data']['item.online_desctiption'] = pg_escape_string($res['data']['description']);
                }
                if($this->CI->session->userdata('enterprise') == 't'){
                    $creative_name = $this->CI->session->userdata('enterpriseName');
                }else{
                    $creative_name = $this->CI->session->userdata('userFullName');
                }

                $upData['data']['item.creative_name'] = $creative_name;
                $upData['data']['item.creative_area'] = $this->CI->session->userdata('userArea');

                if(isset($res['data']['projLanguage']) && (int)$res['data']['projLanguage'] > 0 ){
                     $languageid = $res['data']['projLanguage'];
                }elseif(isset($res['data']['languageId']) && (int)$res['data']['languageId'] > 0 ){
                    $languageid = $res['data']['languageId'];
                }else{
                    $languageid = 0;
                }
                
                if((int)$languageid > 0){
                    $upData['data']['item.languageid'] = $languageid;
                    $langs=$this->CI->model_common->getDataFromTabel('MasterLang','Language_local',array('langId'=>$languageid));
                    if(isset($langs[0]->Language_local)){
                        $upData['data']['item.language'] = $langs[0]->Language_local;
                    }
                }

                if(isset($res['data']['producedInCountry']) && (int)$res['data']['producedInCountry'] > 0 ){
                    $upData['data']['item.countryid'] = $res['data']['producedInCountry'];
                    $country=$this->CI->model_common->getDataFromTabel('MasterCountry','countryName',array('countryId'=>$res['data']['producedInCountry']));
                    if(isset($country[0]->countryName)){
                        $upData['data']['item.country'] = $country[0]->countryName;
                    }
                }

                if(isset($res['data']['projType']) && (int)$res['data']['projType'] > 0 ){
                    $upData['data']['item.typeid'] = $res['data']['projType'];
                    $projType=$this->CI->model_common->getDataFromTabel('MasterProjectType','projectTypeName',array('typeId'=>$res['data']['projType']));
                    if(isset($projType[0]->projectTypeName)){
                        $upData['data']['item.type'] = $projType[0]->projectTypeName;
                    }
                }

                if(isset($res['data']['projGenre']) && (int)$res['data']['projGenre'] > 0 ){
                    $upData['data']['item.genreid'] = $res['data']['projGenre'];
                    $genres=$this->CI->model_common->getDataFromTabel('Genre','Genre',array('GenreId'=>$res['data']['projGenre']));
                    if(isset($genres[0]->Genre)){
                        $upData['data']['item.genre'] = $genres[0]->Genre;
                    }
                }elseif(isset($res['data']['genreId']) && (int)$res['data']['genreId'] > 0 ){
                    $upData['data']['item.genreid'] = $res['data']['genreId'];
                    $genres=$this->CI->model_common->getDataFromTabel('Genre','Genre',array('GenreId'=>$res['data']['genreId']));
                    if(isset($genres[0]->Genre)){
                        $upData['data']['item.genre'] = $genres[0]->Genre;
                    }
                }

                if(isset($res['data']['projGenreFree']) && !empty($res['data']['projGenreFree']) ){
                    $upData['data']['item.subgenre'] = $res['data']['projGenreFree'];
                }elseif(isset($res['data']['freeGenre']) && !empty($res['data']['freeGenre']) ){
                    $upData['data']['item.subgenre'] = $res['data']['freeGenre'];
                }

                if(isset($res['data']['mediaTypeId']) && (int)$res['data']['mediaTypeId'] > 0 ){
                    $elementTypes=$this->CI->model_common->getDataFromTabel('MediaEelementType','type',array('elementTypeId'=>$res['data']['mediaTypeId']));
                    if(isset($elementTypes[0]->type)){
                        $upData['data']['item.element_type'] = $elementTypes[0]->type;
                    }
                }

                if(isset($res['data']['productionHouse']) && !empty($res['data']['productionHouse']) ){
                    $upData['data']['item.publisher'] = $res['data']['productionHouse'];
                }elseif(isset($res['data']['productionCompany']) && !empty($res['data']['productionCompany']) ){
                    $upData['data']['item.publisher'] = $res['data']['productionCompany'];
                }

                if( isset($res['data']['isPrice']) || isset($res['data']['isDownloadPrice']) || isset($res['data']['isPerViewPrice'] ) ) {
                    $sell_option = 'paid';
                    if(($res['data']['isPrice'] != 't') && ($res['data']['isDownloadPrice'] != 't') && ($res['data']['isPerViewPrice'] != 't')){
                        $sell_option = 'free';
                    }
                    $upData['data']['item.sell_option'] = $sell_option ;
                }
                        
            }
        }
        if(!$isData){
            $upData = false;
        } return $upData;
    }
    
    private function deleteQueryDetails($sql=''){
        $data = array();
        if(!empty($sql)){
            $data['table'] = $table =  $sub = str_replace(array('\'', '"'), '', getStringBetween($sql,'FROM','WHERE'));
            $dp = $this->CI->db->dbprefix;
            $searchTables = array($dp.'Project',$dp.'FvElement',$dp.'MaElement',$dp.'PaElement',$dp.'WpElement',$dp.'EmElement',$dp.'NewsElement',$dp.'ReviewsElement',$dp.'Blogs',$dp.'UserShowcase',$dp.'UserShowcaseLang');
            if(in_array($table, $searchTables)){
                $fdData = explode('WHERE',$sql);
                if(!empty($fdData) && count($fdData)>=2){
                    $fdString = trim(str_replace(array('\'', '"'), '', $fdData[1]));
                    $fdData = explode('AND',$fdString);
                    if(!empty($fdData)){
                        foreach($fdData as $k=>$v){
                            $v =  trim($v);
                            $dt = explode('=',$v);
                            if(!empty($dt) && count($dt)>=2){
                                $field = trim($dt[0]);
                                if(count($dt)>2){
                                    $value = '';
                                    foreach($dt as $c=>$d){
                                        if($c > 0){
                                            if($c > 1){
                                                $value.=' = ';
                                            }
                                            $value.=trim($d);
                                        }
                                    }
                                }else{
                                    $value = trim($dt[1]);
                                }
                                $data['where'][$field]=$value;
                            }
                        }
                    }
                }
            }
        } return $data;
    }
    
    private function updateQueryDetails($sql=''){
        $data = array();
        if(!empty($sql)){
            $data['table'] =  $table = $sub = str_replace(array('\'', '"'), '', getStringBetween($sql,'UPDATE','SET'));
            $dp = $this->CI->db->dbprefix;
            $searchTables = array($dp.'Project',$dp.'FvElement',$dp.'MaElement',$dp.'PaElement',$dp.'WpElement',$dp.'EmElement',$dp.'NewsElement',$dp.'ReviewsElement',$dp.'Blogs',$dp.'Posts',$dp.'UserShowcase',$dp.'UserShowcaseLang');
            if(in_array($table, $searchTables)){
                $fdString = getStringBetween($sql,'SET','WHERE');
                $fdData = explode(', "',$fdString);
                if(!empty($fdData)){
                    foreach($fdData as $k=>$v){
                        $v =  trim(str_replace(array('\'', '"'), '', $v));
                        $dt = explode('=',$v);
                        if(!empty($dt) && count($dt)>=2){
                            $field = trim($dt[0]);
                            if(count($dt)>2){
                                $value = '';
                                foreach($dt as $c=>$d){
                                    if($c > 0){
                                        if($c > 1){
                                            $value.=' = ';
                                        }
                                        $value.=trim($d);
                                    }
                                }
                            }else{
                                $value = trim($dt[1]);
                            }
                            $data['data'][$field]=$value;
                        }
                    }
                    
                    $fdData = explode('WHERE',$sql);
                    if(!empty($fdData) && count($fdData)>=2){
                        $fdString = trim(str_replace(array('\'', '"'), '', $fdData[1]));
                        $fdData = explode('AND',$fdString);
                        if(!empty($fdData)){
                            foreach($fdData as $k=>$v){
                                $v =  trim($v);
                                $dt = explode('=',$v);
                                if(!empty($dt) && count($dt)>=2){
                                    $field = trim($dt[0]);
                                    if(count($dt)>2){
                                        $value = '';
                                        foreach($dt as $c=>$d){
                                            if($c > 0){
                                                if($c > 1){
                                                    $value.=' = ';
                                                }
                                                $value.=trim($d);
                                            }
                                        }
                                    }else{
                                        $value = trim($dt[1]);
                                    }
                                    $data['where'][$field]=$value;
                                }
                            }
                        }
                    }
                }
            }
        } return $data;
    }
}
