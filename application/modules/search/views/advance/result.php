<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$thumbFolder ='thumb';
$searchResultCount=count($searchResult);
if($items_total >  $items_per_page){
    echo '<div class="mt-50 position_relative zindex_999 mb10 fr ">';
    $this->load->view('pagination_new',array("pagination_links"=>$pagination_links_withoutButton,"items_total"=>$items_total,"items_per_page"=>$items_per_page,"perPageRecord"=>$perPageRecord,"url"=>base_url(lang().'/search/result/'),"divId"=>"searchResultDiv","formId"=>"advanceSearchForm","unqueId"=>"full","isShowNumber"=>true,"isShowDD"=>false,'isBorder'=>false,"containerClass"=>''));
    echo '</div>';
}
if($searchResult && is_array($searchResult) && $searchResultCount > 0){
    $cnt=0; 
    foreach($searchResult as $k=>$search){
        if(isset($searchResult[$k-1]) && (($searchResult[$k-1]->entityid==($searchResult[$k]->entityid)) && ($searchResult[$k-1]->elementid==($searchResult[$k]->elementid)) && ($searchResult[$k-1]->title==($searchResult[$k]->title))  ) ){
            continue;
        }
        $cacheFile = $search->cachefile;
        $elementid = $search->elementid;
        $projectid = $search->projectid;
        $entityid = $search->entityid;
        $section = $search->section;
        $imagetype=$this->config->item($section.'Image');
        $searchImage='';
        $length=$wordCount='';
        
        
        $search->length=$length;
        $search->wordCount=$wordCount;
        $search->sell_option= ucfirst($search->sell_option);
         
        $ratingAvg=roundRatingValue($search->ratingAvg);
        $ratingImg='images/rating/rating_0'.$ratingAvg.'.png';
        $search->ratingImg=$ratingImg;
        $search->craveFClass=(isset($search->craveId) && $search->craveId > 0)?'cravedALL':'';
        
        $search->type=($search->section=='news' || $search->section=='reviews' || $search->section=='educationMaterial' || $search->section=='upcoming')?$search->industry:$search->type;
        
        $section=$search->section;
        $searchImage = getProjectImage($entityid,$elementid,$projectid,'','_m');
        $search->searchImage=$searchImage;
         
        $isSection = true;
        switch ($section) {
            case 'filmNvideo':
                $linkId=($search->elementid == $search->projectid)?'/mediafrontend/mediagallery/'.$search->userid.'/'.$search->projectid:'/mediafrontend/mediadetails/'.$search->userid.'/'.$search->projectid.'/'.$search->elementid;
                $search->link=base_url(lang().$linkId);
                $viewPage=($search->elementid == $search->projectid)?'fv':'fv_element';
                break;
            case 'musicNaudio':
                $linkId=($search->elementid == $search->projectid)?'/mediafrontend/aboutalbum/'.$search->userid.'/'.$search->projectid:'/mediafrontend/tracklist/'.$search->userid.'/'.$search->projectid.'/'.$search->elementid;
                $search->link=base_url(lang().$linkId);
                $viewPage=($search->elementid == $search->projectid)?'ma':'ma_element';
                break;
            case 'photographyNart':
                $linkId=($search->elementid == $search->projectid)?'/mediafrontend/photoartgallery/'.$search->userid.'/'.$search->projectid:'/mediafrontend/photoartelement/'.$search->userid.'/'.$search->projectid.'/'.$search->elementid;
                $search->link=base_url(lang().$linkId);
                $viewPage=($search->elementid == $search->projectid)?'pa':'pa_element';
                break;  
            case 'writingNpublishing':
                $linkId=($search->elementid == $search->projectid)?'/mediafrontend/writinggallery/'.$search->userid.'/'.$search->projectid:'/mediafrontend/writingelement/'.$search->userid.'/'.$search->projectid.'/'.$search->elementid;
                $search->link=base_url(lang().$linkId);
                $viewPage=($search->elementid == $search->projectid)?'wp':'wp_element';
                break; 
            case 'educationMaterial':
                $linkId=($search->elementid == $search->projectid)?'/mediafrontend/educationelement/'.$search->userid.'/'.$search->projectid:'/mediafrontend/educationelement/'.$search->userid.'/'.$search->projectid.'/'.$search->elementid;
                $search->link=base_url(lang().$linkId);
                $viewPage=($search->elementid == $search->projectid)?'em':'em_element';
                break;
            case 'creatives':
                $linkId=($search->languageid>1)?$search->userid.'/'.$search->elementid.'/':$search->userid.'/';
                $search->link=base_url(lang().'/showcase/index/'.$linkId);
                $viewPage='creatives';
                break;
            case 'associatedprofessionals':
                $linkId=($search->languageid>1)?$search->userid.'/'.$search->elementid.'/':$search->userid.'/';
                $search->link=base_url(lang().'/showcase/index/'.$linkId);
                $viewPage='associatedprofessionals';
                break;
            case 'enterprises':
                $linkId=($search->languageid>1)?$search->userid.'/'.$search->elementid.'/':$search->userid.'/';
                $search->link=base_url(lang().'/showcase/index/'.$linkId);
                $viewPage='enterprises';
                break;
            case 'fans':
                $search->link=base_url(lang().'/showcase/index/'.$search->userid);
                $viewPage='fans';
                break;
            case 'blog':
                $linkId=($search->elementid == $search->projectid)?'/blogshowcase/frontblog/'.$search->userid.'/'.$search->projectid:'/blogshowcase/frontPostDetail/'.$search->userid.'/'.$search->elementid;
                $search->link=base_url(lang().$linkId);
                $viewPage=($search->elementid == $search->projectid)?'blog':'post';
                break;
            
            case 'news':
                $linkId=($search->elementid == $search->projectid)?'/mediafrontend/newscollection/'.$search->userid.'/'.$search->projectid:'/mediafrontend/articledetails/'.$search->userid.'/'.$search->projectid.'/'.$search->elementid;
                $search->link=base_url(lang().$linkId);
                $viewPage=($search->elementid == $search->projectid)?'news':'news_element';
                break;
            case 'reviews':
                $linkId=($search->elementid == $search->projectid)?'/mediafrontend/reviewscollection/'.$search->userid.'/'.$search->projectid:'/mediafrontend/reviewsdetails/'.$search->userid.'/'.$search->projectid.'/'.$search->elementid;
                $search->link=base_url(lang().$linkId);
                $viewPage=($search->elementid == $search->projectid)?'reviews':'reviews_element';
                break;
                
            default:
                $isSection = false;
        }
        
        
        
        if($isSection === true){
            ++$cnt;
            $this->load->view('search/advance/'.$viewPage,array('search'=>$search));
        }
        if($cnt==4){
            $cnt=0;
         echo '<div class="advertiment mb18">';
             if(is_dir(APPPATH.'modules/advertising') && !empty($advertSectionId)){
                //Manage right side advert
                $bannerRhsData =  Modules::run("advertising/getAdvertRecords", array('sectionId'=>$advertSectionId,'advertType'=>'3'));
                if(!empty($bannerRhsData)) {
                    $this->load->view('common/advert',array('bannerData'=>$bannerRhsData,'advertType'=>'3','sectionId'=>$advertSectionId)); 
                } else {
                    $this->load->view('common/adv_content_bot');
                } 
            } else {
                $this->load->view('common/adv_content_bot');
            }
         echo '</div>';
        }
    }
    
   
    if($items_total >  $perPageRecord){
        echo '<div class="sap_30"></div>';
        ?>
        
        <div class="position_absolute width100_per left0 bottom40">
            <div class="pag_1 pl34 pr40">
                <?php
                    $this->load->view('pagination_new',array("pagination_links"=>$pagination_links,"items_total"=>$items_total,"items_per_page"=>$items_per_page,"perPageRecord"=>$perPageRecord,"url"=>base_url(lang().'/search/result/'),"divId"=>"searchResultDiv","formId"=>"advanceSearchForm","unqueId"=>"full","isShowNumber"=>true,"isShowDD"=>true,"pagingWpaerClass"=>'pag_1 pl34 pr40')); 
                ?>
            </div>
        </div><?php
    }
    if($items_total >=1 && $items_total < 4){
      echo '<div class="advertiment mb18">';
             if(is_dir(APPPATH.'modules/advertising') && !empty($advertSectionId)){
                //Manage right side advert
                $bannerRhsData =  Modules::run("advertising/getAdvertRecords", array('sectionId'=>$advertSectionId,'advertType'=>3));
                if(!empty($bannerRhsData)) {
                    $this->load->view('common/advert',array('bannerData'=>$bannerRhsData,'advertType'=>3,'sectionId'=>$advertSectionId)); 
                } else {
                    $this->load->view('common/adv_content_bot');
                } 
            } else {
                $this->load->view('common/adv_content_bot');
            }
         echo '</div>';  
        
    }
     
}else{ 
    $this->load->view('search/advance/no_search_found');
}
    echo '<div class="sap_30"></div>';
?>
