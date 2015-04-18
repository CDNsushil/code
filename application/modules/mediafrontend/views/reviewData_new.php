<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

 if(isset($result) && !empty($result)) { ?>
    
    <!--<div id="showReviews">-->
    <?php
    
    $formAttributes = array(
        'name'=>'reviewList',
        'id'=>'reviewList',
        'toggleDivForm'=>'uploadElementForm'
    );	
    
    echo form_open('',$formAttributes);	

    $resultCount = count($result);	
    
    ?>			
    <input type="text" name="count" id="count" class="dn" value="0">
    <input type="text" name="currentPage" id="currentPage" class="dn" value="1">			  
    <input type="text" name="records" id="records"class="dn" value="<?php echo $resultCount ?>">
    <input type="text" name="entityId" id="entityId" class="dn" value="<?php echo $entityId ?>">
    <input type="text" name="projectElementId" id="projectElementId" class="dn" value="<?php echo $projectElementId ?>" >			  
    <input type="text" name="craveCount" id="craveCount" class="dn" value="<?php echo $craveCount ?>" >
    <input type="text" name="viewCount" id="viewCount" class="dn" value="<?php echo $viewCount ?>" >
    <input type="text" name="industryId" class="dn"  value="<?php echo $industryId ?>" >

            <div class="sub_col_middle global_shadow_light mt18">			
                <?php $space='row  mt5';?>     
                        <!--loop01-->
                    <?php foreach ($result as $proj) {  
                        
                        //print_r($proj);
                        
                        $industryId  = (!empty($proj->industryId))? $proj->industryId : 0;
                        
                        if($industryId==10){
                          $link = "/educationMaterial/piece";
                        }elseif($industryId==2){
                            $link = "/musicNaudio/piece";  
                              
                       }elseif($industryId==3){
                           $link =  "/writingNpublishing/piece";
                           
                       }elseif($industryId==4){
                           $link = "/photographyNart/piece";
                      
                       }elseif($industryId==9){
                           $link =  "/performancesnevents/piece";
                      
                       }elseif($industryId==12){
                          $link = "/productNshowcase/piece";				       
                       
                       }else {
                          $link = "/filmNvideo/piece";	   
                                           
                       }
                            
                       // $reviewsUrl = base_url_lang('mediafrontend/searchresult/'.$proj->userId.'/'.$proj->projId.'/'.$proj->elementId.'/reviews'.$link);
                        $reviewsUrl = base_url_lang('mediafrontend/reviewsdetails/'.$proj->userId.'/'.$proj->projId.'/'.$proj->elementId);
                        // $userData= showCaseUserDetails($proj->userId);

                        $getUserShowcase	= showCaseUserDetails($proj->userId);

                        $craveCount  = (!empty($proj->craveCount))? $proj->craveCount : 0;
                        $viewCount   = (!empty($proj->viewCount))? $proj->viewCount : 0;
                        $ratingAvg   = (!empty($proj->ratingAvg))? $proj->ratingAvg : 0;

                        $path           =   'media/'.$proj->username.'/profile_image/'; 
                        $img            =   (!empty($proj->imagePath)) ? $proj->imagePath :  $path.$proj->profileImageName;  
                        $thumbImage     =   addThumbFolder($img,'_s');
                        $imagetype      =   $this->config->item('defaultReviewsImg_s');
                        $elementImage   =   getImage($thumbImage,$imagetype);
                         ?>  
                          
                          <div class="box_wrap clearb mt10 fl width_542  article">
                                <ul class="my_slide clearb">
                                   <!--id="my_slider" -->
                                   <li>
                                      <span class="table_cell   reviw_thumb">
                                         <h4 class=" fl red mb15">Review</h4>
                                         <img src="<?php echo $elementImage; ?>" alt="" />
                                         <h3 class="fl pb6 pt6  clr8b9c00  fs14"><?php echo $getUserShowcase['userFullName'] ?></h3>
                                      </span>
                                      <div class="side_wrap fl display_inline_block pl23">
                                         <div class="min_H96 clearb ">
                                            <h5 class="bdr_b_b7 mb10 fs16 pb10"><?php echo $proj->title; ?></h5>
                                            <p class="minH87">  <?php echo showString($proj->article,200); ?><br />
                                               
                                            </p>
                                            <a href="<?php echo $reviewsUrl ?>" class="fr  clearb fs12 red opens_light"> Read </a>
                                         </div>
                                         <div class="sap_15"></div>
                                         <div class="fl"><?php echo  dateFormatView($proj->createdDate,'d F Y') ?></div>
                                         <div class="fr head_list pr10 color_666">
                                            <div class="icon_view3_blog icon_so"><?php echo $craveCount ?></div>
                                            <div class="icon_crave4_blog icon_so"><?php echo $viewCount ?></div>
                                            <div class="rating fl pt6">
                                               <img src="<?php echo ratingImagePath($ratingAvg);?>" alt="">
                                            </div>
                                         </div>
                                      </div>
                                   </li>
                                </ul>
                             </div>
                               <?php  $space='row  mt25';?>
                       <?php  $srNumber++; } ?>
                
            </div> 
    
<?php echo form_close();?> 

<div class="clear"></div>
<div class="clear seprator_5"></div>
    <!-- PAGINATION -->  
     <div class="row">
        <?php
        $url =base_url()."en/mediafrontend/getReviewListNew/".$entityId."/".$projectElementId;
        if(isset($items_total)  && isset($perPageRecord) && $items_total >  $perPageRecord){?>
             <div class="row">
                    <?php $this->load->view('pagination_new',array("pagination_links"=>$pagination_links,"items_total"=>$items_total,"items_per_page"=>$items_per_page,"perPageRecord"=>$perPageRecord,"url"=>$url,"divId"=>"showReviews","formId"=>0,"unqueId"=>"full","isShowNumber"=>true,"isShowDD"=>true,"pagingWpaerClass"=>'pagination_wrapper new_page_design new_page_design',"pagingDDDClass"=>'left_site_dropdown m0 new_page_design new_page_design')); ?>
                <div class="clear"></div>
            </div>
        <?php } ?>  
    </div>
 <!-- PAGINATION END --> 
    
    
<div class="box_wrap width_542 text_alignC mt15">
    <?php 
        //----------- advertisement of 468 X 60 ----------//
            if(is_dir(APPPATH.'modules/advertising') && !empty($advertSectionId)){
                //Manage left side content bottom advert
                $bannerRhsData =  Modules::run("advertising/getAdvertRecords", array('sectionId'=>$advertSectionId,'advertType'=>'3'));
                if(!empty($bannerRhsData)) {
                    $this->load->view('common/advert',array('bannerData'=>$bannerRhsData,'advertType'=>'3','sectionId'=>$advertSectionId));
                } else {
                    $this->load->view('common/adv_content_bot'); 
                } 
            } else {
                $this->load->view('common/adv_content_bot');  
            }
        //----------- advertisement of 468 X 60 ----------//
    ?>
</div>

<!--</div>-->
<?php } ?>
