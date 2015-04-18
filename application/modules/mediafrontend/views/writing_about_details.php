<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    //add preview word if preview mode is active
    $previewWord =  (previewModeActive())?"/preview":"";
    
    //------default image details-------//
    $imagetype          =   $fileConfig['defaultImage_m'];
    $imagetype_xs       =   $fileConfig['defaultImage_xs'];
    $imagetype_s        =   $fileConfig['defaultImage_s'];
   
    //------check project data and convert to single diemential array------//
    $projectViewNumber   =   1; //defined default value
    $projectPrepareList  =   false;  // defined deafult value in array
    if(!empty($projectDataList)):
        foreach($projectDataList as $key => $getProjectData){
            
            $projectPrepareList[]   =   $getProjectData['projId'];
            if($projectId == $getProjectData['projId']){
                $projectData        = $getProjectData;
                $currentKeyPosition =  $key;
                $projectViewNumber  =   $currentKeyPosition + 1;
            }
        }
    endif;
    
    
    if(empty($projectData)){
        redirectToNorecord404();
    }
    
    //-----------prepare showing data -------------//
    
    $projName                   =   (!empty($projectData['projName']))?$projectData['projName']:'';
    $projDescription            =   (!empty($projectData['projDescription']))?$projectData['projDescription']:'';
    $projShortDesc              =   (!empty($projectData['projShortDesc']))?$projectData['projShortDesc']:'';
    $projSellstatus               =   (!empty($projectData['projSellstatus']))?$projectData['projSellstatus']:'f';
    //$projBaseImgPath            =   (!empty($projectData['projBaseImgPath']))?$projectData['projBaseImgPath']:'';
    $craveCount                 =   (!empty($projectData['craveCount']))?$projectData['craveCount']:'0';
    $viewCount                  =   (!empty($projectData['viewCount']))?$projectData['viewCount']:'0';
    $ratingAvg                  =   (!empty($projectData['ratingAvg']))?$projectData['ratingAvg']:'0';
    $reviewCount                =   (!empty($projectData['reviewCount']))?$projectData['reviewCount']:'0';
    $projReleaseDate            =   (!empty($projectData['projReleaseDate']))?$projectData['projReleaseDate']:'';
    $classification             =   (!empty($projectData['classification']))?$projectData['classification']:'';
    $docCount                   =   (!empty($projectData['docCount']))?$projectData['docCount']:'0';
    $docFileCount               =   (!empty($projectData['docFileCount']))?$projectData['docFileCount']:'0';
    $categoryId                 =   (!empty($projectData['projCategory']))?$projectData['projCategory']:'1';
    $selfClassfication          =   (!empty($projectData['otpion']))?$projectData['otpion']:'';
    $isPublished                =   $projectData['isPublished'];
    $cravedALL                  =   '';
    $craveDivAction             =   'craveDiv'.$entityId.''.$projectId;
    $rateDivAction              =   'rateDiv'.$entityId.''.$projectId;
    $projectsNumberCount        =   count($projectDataList);
    $projectsNumberCount        =   ($projectsNumberCount > 0)?$projectsNumberCount:0;
    
    
    //check project sell status then  show image by type
    if($projSellstatus=="t"){
        $thumbFolder='watermark'; 
    }else{
        $thumbFolder='thumb';
    }
    
    //---------check craved by loggedUserId------------//
    if($loggedUserId){
        $where=array(
            'tdsUid'        =>   $loggedUserId,
            'entityId'      =>   $entityId,
            'elementId'     =>   $projectId
        );
        
        $countResult    =   countResult('LogCrave',$where);
        $cravedALL      =   ($countResult>0)?'cravedALL':'';
    }else{
        $cravedALL='';
    }
    
    //---------- if project image uploaded --------------// 
    $projectImage               =   getProjectCoverImage($projectId,'_b');
    
    //------------element list data prepare--------------//
    $sampleElementList = false;
    $allowElementType = array('1');
    if(!empty($elementDataList)){
        foreach($elementDataList as $elementData){
            if(in_array($elementData['elementType'], $allowElementType)){
                $sampleElementList[] = $elementData;
            }
        }
    }
    
    //defined default variable
    $previousProjectId      =   0;
    $nextProjectId          =   0;
    $nextPageLink           =   '';
    $previousPageLink       =   '';
   
    //previous project show page link id get
    if($currentKeyPosition > 0):
        $previousProjectId      =     $projectPrepareList[$currentKeyPosition-1];
        $previousPageLink       =     'mediafrontend/writingdetails/'.$frentendUserId.'/'.$previousProjectId.$previewWord;
        $previousPageLink       =      base_url_lang($previousPageLink);
    endif;
    
    //previous project show page link id get
    if($currentKeyPosition < ($projectsNumberCount-1)):
        $nextProjectId      =     $projectPrepareList[$currentKeyPosition+1];
        $nextPageLink       =    'mediafrontend/writingdetails/'.$frentendUserId.'/'.$nextProjectId.$previewWord;
        $nextPageLink       =     base_url_lang($nextPageLink);
    endif;
    
    //------about page link prepare--------//
    $aboutPageLink       =     'mediafrontend/writingdetails/'.$frentendUserId.'/'.$projectId.$previewWord;
    $aboutPageLink       =     base_url_lang($aboutPageLink);
    
    $galleryPageLink       =     'mediafrontend/writinggallery/'.$frentendUserId.'/'.$projectId.$previewWord;
    $galleryPageLink       =     base_url_lang($galleryPageLink);
    
    $otherCollectionsLink      =    'showproject/othercollections/'.$frentendUserId.'/writingNpublishing'.$previewWord;
    $otherCollectionsLink      =     base_url_lang($otherCollectionsLink);
    
    //------create share link by current url-------//
    $currentShortUrl = uri_string();
    
?>

<div class="row content_wrap" >
    <?php
        //---------load header navigation menu---------//
        $viewData = array(
            'headingName'   =>   $this->lang->line('writingNpublishing_detail_heading_'.$categoryId),
            'navigation_1'  =>  $galleryPageLink,
            'navigation_2'  =>  $aboutPageLink,
            'navigation_3'  =>  $otherCollectionsLink,
            'activeMenu'    =>  'menu2',
            'categoryId'    =>  $this->config->item('WpCollectionCatId'),
        );
        $this->load->view('common_view/media_showcase_header_view',$viewData);
    ?>
   <div class="width930 m_auto  sc_album  display_table">
      <!--  left Content start  -->
      <div class="clearbox ">
         <div class="display_inline  Writing_img fl mr20  width342">
            <div class=" fl">
               <span class="header_dark  box_siz lineH33   fs30  " >About the Collection</span>
               <div class=" position_relative  mb20 fl"> <span class="table_cell"> <img src="<?php echo $projectImage; ?>" alt="" /> </span> </div>
            </div>
            <span class="left_w  fl lineH18  mr pr60">
               <div class="fl mt10 open_sans mb15">
                  <div class="clearb">
                     <p class="font_bold ">Collection Information</p>
                     <ul class="edit_list  ">
                        
                        <!--
                        <li>
                           <p class="red opens_light ">LANGUAGE</p>
                           <p>English</p>
                        </li>-->
                       
                       <?php if(!empty($projReleaseDate)){ ?>
                           <li>
                              <p class="red lineH15">PUBLISHED ON TOADSQUARE</p>
                              <p><?php echo date("d F Y", strtotime($projReleaseDate)); ?></p>
                              </p>
                           </li>
                       <?php } ?>
                       
                        <?php if($selfClassfication) { ?>
                           <li>
                              <p class="red lineH15"> SELF CLASSIFICATION</p>
                              <p><?php echo $selfClassfication;?></p>
                           </li>
                        <?php } ?>
                     </ul>
                  </div>
                  <div class="sap_30"></div>
                  
                    <?php 
                        //---------associative creatives list start----------//
                            echo  Modules::run("creativeinvolved/associativecreativeslist", $entityId,$projectId);
                        //---------associative creatives list start----------//
                    ?>
                    
                    
                    <span class="text_alighC width100_per">
                        <span class="sap_20"></span>
                        <?php 
                            //----------- advertisement of 250 X 250----------//
                                if(is_dir(APPPATH.'modules/advertising') && !empty($advertSectionId)){
                                    //Manage right side forum advert
                                    $bannerRhsData =  Modules::run("advertising/getAdvertRecords", array('sectionId'=>$advertSectionId,'advertType'=>'1'));
                                    if(!empty($bannerRhsData)) {
                                        $this->load->view('common/advert',array('bannerData'=>$bannerRhsData,'advertType'=>'1','sectionId'=>$advertSectionId));
                                    } else {
                                        $this->load->view('common/adv_rhs_forum');
                                    }
                                } else {
                                    $this->load->view('common/adv_rhs_forum');
                                }
                            //----------- advertisement of 250 X 250----------//
                        ?>
                    </span>
                  <div class="sap_25"></div>
                  <?php 
                    //----------additional info show section------------//
                           
                        //call module for showing supporting material listing     
                        echo Modules::run("mediafrontend/supportingmaterialshow",$elementEntityId,$projectId); 
                        
                         $tableInfo=array(
                                            'entityId'=>$entityId,
                                            'elementId'=>$projectId,
                                            'tableName'=>array('AddInfoNews','AddInfoInterview','AddInfoReviews'),
                                            'sections'=>array($this->lang->line('NEWS'),$this->lang->line('INTERVIEWS'),$this->lang->line('externalReviews')),
                                            'sectionsname'=>array('defaultNewsImg_s','defaultInterviewImg_s','defaultReviewsImg_s'),
                                            'orderBy'=>array('news','interv','review'),
                                            'sectionBgcolor'=>$sectionBgcolor
                                         );
                                         
                        echo Modules::run("additionalInfo/additionalInfoListNew", $tableInfo);
                        
                    //----------additional info show section------------//
                ?> 
               
               </div>
            </span>
         </div>
         <div class="rightbox fl width562 ">
            <div class="text_bx fs20 pb10 open_sans clr_666 lineH25 "> <?php echo html_entity_decode($projName);?></div>
            <h3 class="fs17">  <?php
                        if(strlen(trim($projShortDesc))>2){ ?>
                    <?php echo nl2br($projShortDesc);?>
                    <?php } ?> 
            </h3>
            <span class="bg_f3f3f3 bt_c2 mt30 bb_c2c2 mb25 p10 width100_per ">
               <div class="fr head_list pr10 color_666">
                  <div class="icon_view3_blog icon_so"><?php echo $viewCount; ?></div>
                  <div class="icon_crave4_blog icon_so <?php echo $craveDivAction.' '.$cravedALL; ?>"><?php echo $craveCount;?></div>
                  <div class="rating fl pt6 <?php echo  $rateDivAction; ?>"> <img alt="" src="<?php echo ratingImagePath($ratingAvg);?>"> </div>
                  <div class="btn_share_icon icon_so"><?php echo $reviewCount; ?></div>
               </div>
               <div class="clearbox">
                   
                   <?php if($docFileCount >0 || $docCount >0) { ?> 
                       
                        <div class=" mt10 mb15 "> <span class=" pr15 font_bold">Collection Contents</span> 
                           <?php if($docFileCount >0) { ?> 
                                <span class="pr10"> <b class="red pr7"><?php echo $docFileCount; ?></b> Text Files </span> 
                           <?php } ?>
                           <?php if($docCount >0) { ?> 
                                <span class="pl10"> <b class="red pr7"><?php echo $docCount; ?></b> Texts </span> 
                           <?php } ?>
                       </div>
                  
                    <?php } ?> 
         
                    <?php 
                        $buttonArray = array('projectData'=>$projectData,'elementDataList'=>$elementDataList,'showview'=>'project'); 
                        $this->load->view('common_view/project_details_show_buttons',$buttonArray);
                    ?>
                    
                    <?php 
                        // if sample element exist then show 
                        if(!empty($sampleElementList)){
                            $sampleElementList  =   $sampleElementList[0];
                            
                            $sampleElementId    =   $sampleElementList['elementId'];
                            $sampleProjId       =   $sampleElementList['projId'];
                            $sampleEntityId     =   $sampleElementList['entityId'];
                            $sampleFileId       =   $sampleElementList['fileId'];
                            $functionAction     =   "openLightBox('popupBoxWp','popup_box','/mediafrontend/samplemediafile',".$sampleFileId.",".$sampleEntityId.",".$sampleElementId.",".$sampleProjId.");";
                    ?>
                        
                         <button class="ml10" type="button" <?php echo $functionAction; ?> role="button"> View Extarct </button>
                    
                    <?php  } ?>
                    
                    
                 <!-- <div class="clearb mt10"> <span class="fr lineH23"><span class="red ">PUBLISHER</span> Self Published</span> </div>-->
               </div>
            </span>
            <div class="fr">
                <?php 
                    //-----------crave button module load view-----------//
                    $craveButtonData= array('buttonDesigntype'=>'1','buttonTitle'=>'Crave','elementId'=>$projectId,'entityId'=>$entityId,'ownerId'=>$frentendUserId,'projectType'=>$industryType,'isPublished'=>$isPublished,'furteherDetails'=>'{"projectId":"'.$projectId.'","table":"Project","primeryField":"projId","fieldSet":"projId as id,projBaseImgPath as craveImage, projName as craveTitle, projShortDesc as craveShortDescription, tagwords as tagwords","cacheFilePath":"'.$cacheFile.'"}');
                    echo Modules::run("craves/creavebutton",$craveButtonData);

                    //------------rating button module load view------------//
                    $ratingButtonData = array('elementId'=>$projectId,'entityId'=>$entityId,'isPublished'=>$isPublished);
                    echo Modules::run("rating/ratingbutton",$ratingButtonData);

                    //------------review button view load-------------//
                    $this->load->view('media/reviewViewNew',array('reviewdesign'=>'1','reviewProjectId'=>$projectId,'reviewElementId'=>$projectId,'reviewEntityId'=>$entityId,'reviewIndustryId' =>'3','isPublished'=>$isPublished)); 
                    
                    //------------article button view load-------------//
                    $this->load->view('media/newsViewNew',array('reviewdesign'=>'1','reviewProjectId'=>$projectId,'reviewElementId'=>$projectId,'reviewEntityId'=>$entityId,'reviewIndustryId' =>'3','isPublished'=>$isPublished)); 
                ?>
            </div>
            <div class="sap_30"></div>
            <div class="cnt display_inline music_cnt ">
                <?php
                    if(strlen(trim($projDescription))>2){ 
                         echo changeToUrl(nl2br($projDescription));
                    }
                ?>
            </div>
            <div class=" position_relative fr">
               <div class="sap_20"></div>
              
               <div class="nav open_sans  width513 display_inline_block bt_ebeb  pt20  width100_per  text_alighC   ">
                   <?php if(!empty($previousPageLink)): ?> 
                        <a class=" fl lineH20 text_alighL " href="<?php echo $previousPageLink; ?>">
                        <i class="next_collection collection_nav"></i>
                        Previous Collection </a> 
                   <?php else: ?>
                         <a class=" fl lineH20 text_alighL disable_link" href="javascript:void(0)">
                        <i class="next_collection collection_nav"></i>     
                        Previous Collection </a> 
                   <?php endif; ?> 
                   
                    <span class="counter pt3">
                        <span class="current_slide"><?php echo $projectViewNumber; ?></span>/<span class="total_slide"></span><?php echo $projectsNumberCount; ?>
                    </span> 
                    
                    <?php if(!empty($nextPageLink)): ?> 
                        <a class="  fr text_alignR lineH20" href="<?php echo $nextPageLink; ?>">
                       <span class="fl"> Next Collection</span>
                        <i class="prev_collection fr  collection_nav"></i>
                        </a>
                    <?php else: ?>
                         <a class="  fr text_alignR lineH20 disable_link" href="javascript:void(0)">
                              <span class="fl">  Next Collection</span>
                         <i class="prev_collection fr  collection_nav"></i>
                         </a>
                    <?php endif; ?>
                </div>
                
                <div class="sap_20"></div>
                 <ul class="socail_list">
                
                    <li>  
                        <?php 
                        echo ' <span class="fl">';
                            
                            //-----short module link by email module array-----//
                            $shortlinkEmailData=array('url'=>$currentShortUrl,'isPublished'=>$isPublished,'designType'=>'1');
                            echo Modules::run("share/shareemailbutton",$shortlinkEmailData);								

                            //-----load module shortlink module array-----//
                            $shortlinkData=array('url'=>$currentShortUrl,'isPublished'=>$isPublished,'designType'=>'1');
                            echo Modules::run("shortlink/shortlinkfrontbuttonnew",$shortlinkData);								

                        echo '</span>';

                            //-------load module of social share---------------//
                            $shareData=array('url'=>$currentShortUrl,'isPublished'=>$isPublished,'designType'=>'1');
                            echo Modules::run("share/sharesocialshowview",$shareData);		
                        ?>
                   </li>
                    
                </ul>
                
               <div class="sap_20"></div>
                <div class="box_wrap width_542 text_alignC">
                     <?php 
                        //----------- advertisement of 468 X 60----------//
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
                        //----------- advertisement of 468 X 60----------//
                    ?>
                </div>
                
                <?php
                    //--------review list start-----------//
                        echo Modules::run("mediafrontend/getReviewListNew",$entityId,$projectId);
                    //---------review list end-----------//
                ?>
                           
            </div>
         </div>
      </div>
   </div>
</div>
