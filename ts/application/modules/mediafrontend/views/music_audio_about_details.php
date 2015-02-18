<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    
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
    //$projBaseImgPath            =   (!empty($projectData['projBaseImgPath']))?$projectData['projBaseImgPath']:'';
    $craveCount                 =   (!empty($projectData['craveCount']))?$projectData['craveCount']:'0';
    $viewCount                  =   (!empty($projectData['viewCount']))?$projectData['viewCount']:'0';
    $ratingAvg                  =   (!empty($projectData['ratingAvg']))?$projectData['ratingAvg']:'0';
    $reviewCount                =   (!empty($projectData['reviewCount']))?$projectData['reviewCount']:'0';
    $projReleaseDate            =   (!empty($projectData['projReleaseDate']))?$projectData['projReleaseDate']:'';
    $classification             =   (!empty($projectData['classification']))?$projectData['classification']:'';
    $cdCount                    =   (!empty($projectData['cdCount']))?$projectData['cdCount']:'0';
    $audioFileCount             =   (!empty($projectData['audioFileCount']))?$projectData['audioFileCount']:'0';
    $categoryId                 =   (!empty($projectData['projCategory']))?$projectData['projCategory']:'3';
    $categoryName               =   (!empty($projectData['category']))?$projectData['category']:'0';
    $isPublished                =   $projectData['isPublished'];
    $cravedALL                  =   '';
    $craveDivAction             =   'craveDiv'.$entityId.''.$projectId;
    $rateDivAction              =   'rateDiv'.$entityId.''.$projectId;
    $projectsNumberCount        =   count($projectDataList);
    $projectsNumberCount        =   ($projectsNumberCount > 0)?$projectsNumberCount:0;
    
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
    $projectImage               =   getProjectCoverImage($projectId,'_xxl');
    
    //defined default variable
    $previousProjectId      =   0;
    $nextProjectId          =   0;
    $nextPageLink           =   '';
    $previousPageLink       =   '';
   
    //previous project show page link id get
    if($currentKeyPosition > 0):
        $previousProjectId      =     $projectPrepareList[$currentKeyPosition-1];
        $previousPageLink       =     'mediafrontend/aboutalbum/'.$frentendUserId.'/'.$previousProjectId;
        $previousPageLink       =      base_url_lang($previousPageLink);
    endif;
    
    //previous project show page link id get
    if($currentKeyPosition < ($projectsNumberCount-1)):
        $nextProjectId      =     $projectPrepareList[$currentKeyPosition+1];
        $nextPageLink       =    'mediafrontend/aboutalbum/'.$frentendUserId.'/'.$nextProjectId;
        $nextPageLink       =     base_url_lang($nextPageLink);
    endif;
    
    //------about page link prepare--------//
    $aboutPageLink       =     'mediafrontend/aboutalbum/'.$frentendUserId.'/'.$projectId;
    $aboutPageLink       =     base_url_lang($aboutPageLink);
    
    $galleryPageLink       =     'mediafrontend/tracklist/'.$frentendUserId.'/'.$projectId;
    $galleryPageLink       =     base_url_lang($galleryPageLink);
    
    $otherCollectionsLink      =    'showproject/othercollections/'.$frentendUserId.'/musicNaudio';
    $otherCollectionsLink      =     base_url_lang($otherCollectionsLink);
    
    //------create share link by current url-------//
    $currentShortUrl = uri_string();
    
?>

<div class="row content_wrap" >
   <?php
        //---------load header navigation menu---------//
        $viewData = array(
        'headingName'   =>   $this->lang->line('musicNaudio_detail_heading_'.$categoryId),
        //'navigation_1'  =>  $galleryPageLink,
        'navigation_1'  =>  "javascript:openLightBox('popupBoxWp','popup_box','/mediafrontend/albumplaylist',".$projectId.");",
        'navigation_2'  =>  $aboutPageLink,
        'navigation_3'  =>  $otherCollectionsLink,
        'activeMenu'    =>  'menu2',
        'categoryId'    =>  $categoryId,
        );
        $this->load->view('common_view/media_showcase_header_view',$viewData);
   ?>
   <div class="width903 m_auto pt25 sc_album display_table">
      <!--  left Content start  -->
      <div class="left_w width_302  lineH18 fl mr pr30">
         <div class="head_list fl width_273 bg_fdfdfd bdr_ececec ">
            <p class="fs16 fl pr10"><?php echo $this->lang->line('musicNaudio_crave_detail_'.$categoryId); ?></p>
            <div class="fr pr25 color_666">
               <div class="icon_view3_blog icon_so"><?php echo $viewCount; ?></div>
               <div class="icon_crave4_blog icon_so <?php echo $craveDivAction.' '.$cravedALL; ?>"><?php echo $craveCount;?></div>
               <div class="rating fl pt6 <?php echo  $rateDivAction; ?>">
                  <img src="<?php echo ratingImagePath($ratingAvg);?>" alt="">
               </div>
               <div class="btn_share_icon icon_so"><?php echo $reviewCount; ?></div>
            </div>
         </div>
         
         <?php if($audioFileCount >0 || $cdCount >0) { ?> 
         <div class="sap_25"></div>
         <div class="clearb pl16 bb_e7e7e7">
            <b class=" lettsp-1"><?php echo $this->lang->line('musicNaudio_crave_contents_'.$categoryId); ?></b>
            <ul class="edit_li1  pb20  fs13">
               <?php if($audioFileCount >0) { ?> 
                    <li class="pt7"><b class="red fs14 minw20 fl"><?php echo $audioFileCount; ?></b><?php echo $this->lang->line('musicNaudio_music_track_'.$categoryId); ?></li>
               <?php } ?>
               <?php if($cdCount >0) { ?> 
                    <li><b class="red fs14 minw20 fl"><?php echo $cdCount; ?></b><?php echo $this->lang->line('musicNaudio_music_physical'); ?></li>
               <?php } ?>
            </ul>
         </div>
         
        <?php }else{ ?>
            <div class="sap_20 bb_e7e7e7"></div>
        <?php } ?> 
         
        
        <div class="sap_20 "></div>

        <div class="clearb">
            <?php 
                $buttonArray = array('projectData'=>$projectData,'elementDataList'=>$elementDataList,'showview'=>'project'); 
                $this->load->view('common_view/project_details_show_buttons',$buttonArray);
            ?>
        </div>
         
         
         
         <div class="clearb pl16">
            <b class="red lettsp-1"> <?php echo $this->lang->line('musicNaudio_music_info_'.$categoryId); ?></b>
            <ul class="edit_list pb2   fs13 lettsp-1 ">
               <li>
                  <p class="color_999 lineH15"><?php echo $this->lang->line('musicNaudio_published_toadsquare'); ?></p>
                  <p><?php echo date("d F Y", strtotime($projReleaseDate)); ?></p>
               </li>
                <?php if($classification) { ?>
                   <li>
                      <p class="color_999 lineH15"><?php echo $this->lang->line('musicNaudio_self_classification'); ?></p>
                      <p><?php echo $classification;?></p>
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
         
         <span class="text_alighC width100_per"	>
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
      <!-- left content end --> 
      <!-- right Content start -->
      <div class="rightbox width562 position_relative fr">
         <div class="music_collection position_relative  display_table">
            <span class="table_cell">
               <img src="<?php echo $projectImage; ?>" alt="" class="maxW560"  />
               <div class="fs29 opens_light"><a href="javascript:viod(0)" onclick="openLightBox('popupBoxWp','popup_box','/mediafrontend/albumplaylist','<?php echo $projectId; ?>');"  class="view_musc_btn  position_absolute">	
                    <?php echo $this->lang->line('musicNaudio_media_file_view_'.$categoryId); ?>
               </a></div>
            </span>
         </div>
         <div class="sap_25 bt6_444"></div>
         <div class="fs18 font_bold lineH23"> <?php echo html_entity_decode($projName);?>
         </div>
         <div class="bb_b7b7b7 sap_20 mb23"></div>
         <div class=" cnt">
            <div class="fs17">
                <?php
                    if(strlen(trim($projShortDesc))>2){ ?>
                <?php echo nl2br($projShortDesc);?>
                <?php } ?>
                     </div>
            <div class="sap_50"></div>
            <div class="content_collection fs15 lineH20">
                <?php
                    if(strlen(trim($projDescription))>2){ ?>
                        <?php echo changeToUrl(nl2br($projDescription));?>
                <?php 
                    }
                ?>
               
            </div>
            <div class="sap_30"></div>
            <div class="fr">
                
                <?php 
                    //-----------crave button module load view-----------//
                    $craveButtonTitle  = $this->lang->line('musicNaudio_crave_button_'.$categoryId);
                    $craveButtonData   = array('buttonDesigntype'=>'1','buttonTitle'=>$craveButtonTitle,'elementId'=>$projectId,'entityId'=>$entityId,'ownerId'=>$frentendUserId,'projectType'=>$industryType,'isPublished'=>$isPublished,'furteherDetails'=>'{"projectId":"'.$projectId.'","table":"Project","primeryField":"projId","fieldSet":"projId as id,projBaseImgPath as craveImage, projName as craveTitle, projShortDesc as craveShortDescription, tagwords as tagwords","cacheFilePath":"'.$cacheFile.'"}');
                    echo Modules::run("craves/creavebutton",$craveButtonData);

                    //------------rating button module load view------------//
                    $ratingButtonData = array('elementId'=>$projectId,'entityId'=>$entityId,'isPublished'=>$isPublished);
                    echo Modules::run("rating/ratingbutton",$ratingButtonData);

                    //------------review button view load-------------//
                    $this->load->view('media/reviewViewNew',array('elementId'=>$projectId,'entityId'=>$entityId,'projName'=>$projName,'section' =>'Music & Audio','industryId' =>'1','isPublished'=>$isPublished));	
                ?>
            
            </div>
            <div class="sap_10"></div>
         </div>
         <div class="box_wrap socail_icon width_542 pb9">
            <div class="nav mb16 pb5 width513 display_inline_block  text_alighC bb_e9e9e9 ">
               
                <?php if(!empty($previousPageLink)): ?> 
                    <a class=" fl text_alighL " href="<?php echo $previousPageLink; ?>">Previous <?php echo $this->lang->line('musicNaudio_media_type_'.$categoryId); ?> </a> 
                <?php else: ?>
                     <a class=" fl text_alighL disable_link" href="javascript:void(0)">Previous <?php echo $this->lang->line('musicNaudio_media_type_'.$categoryId); ?> </a> 
                <?php endif; ?> 
               
               <span class="counter"><span class="current_slide"><?php echo $projectViewNumber; ?></span>/<span class="total_slide"></span>
                <?php echo $projectsNumberCount; ?>
               </span> 
            
                <?php if(!empty($nextPageLink)): ?> 
                    <a class=" fr text_alignR" href="<?php echo $nextPageLink; ?>">Next <?php echo $this->lang->line('musicNaudio_media_type_'.$categoryId); ?></a>
                <?php else: ?>
                     <a class=" fr text_alignR disable_link" href="javascript:void(0)">Next <?php echo $this->lang->line('musicNaudio_media_type_'.$categoryId); ?></a>
                <?php endif; ?>
                
            </div>
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
         </div>
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
      </div>
      <!-- right Content end  --> 
   </div>
</div>
