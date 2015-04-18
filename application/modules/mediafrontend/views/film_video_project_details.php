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
    //$projBaseImgPath            =   (!empty($projectData['projBaseImgPath']))?$projectData['projBaseImgPath']:'';
    $craveCount                 =   (!empty($projectData['craveCount']))?$projectData['craveCount']:'0';
    $viewCount                  =   (!empty($projectData['viewCount']))?$projectData['viewCount']:'0';
    $ratingAvg                  =   (!empty($projectData['ratingAvg']))?$projectData['ratingAvg']:'0';
    $reviewCount                =   (!empty($projectData['reviewCount']))?$projectData['reviewCount']:'0';
    $projReleaseDate            =   (!empty($projectData['projReleaseDate']))?$projectData['projReleaseDate']:'';
    $classification             =   (!empty($projectData['classification']))?$projectData['classification']:'';
    $dvdCount                   =   (!empty($projectData['dvdCount']))?$projectData['dvdCount']:'0';
    $videoFileCount             =   (!empty($projectData['videoFileCount']))?$projectData['videoFileCount']:'0';
    $categoryId                 =   (!empty($projectData['projCategory']))?$projectData['projCategory']:'1';
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
    
    //------------element list data prepare--------------//
    $trailerSampleElementList = false;
    $allowElementType = array('1','2');
    if(!empty($elementDataList)){
        foreach($elementDataList as $elementData){
            if(in_array($elementData['elementType'], $allowElementType)){
                $trailerSampleElementList[] = $elementData;
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
        $previousPageLink       =     'mediafrontend/mediashowcases/'.$frentendUserId.'/'.$previousProjectId.$previewWord;
        $previousPageLink       =      base_url_lang($previousPageLink);
    endif;
    
    //previous project show page link id get
    if($currentKeyPosition < ($projectsNumberCount-1)):
        $nextProjectId      =     $projectPrepareList[$currentKeyPosition+1];
        $nextPageLink       =    'mediafrontend/mediashowcases/'.$frentendUserId.'/'.$nextProjectId.$previewWord;
        $nextPageLink       =     base_url_lang($nextPageLink);
    endif;
    
    //------about page link prepare--------//
    $aboutPageLink       =     'mediafrontend/mediashowcases/'.$frentendUserId.'/'.$projectId.$previewWord;
    $aboutPageLink       =     base_url_lang($aboutPageLink);
    
    $galleryPageLink       =     'mediafrontend/mediagallery/'.$frentendUserId.'/'.$projectId.$previewWord;
    $galleryPageLink       =     base_url_lang($galleryPageLink);
    
    $otherCollectionsLink      =    'showproject/othercollections/'.$frentendUserId.'/filmNvideo'.$previewWord;
    $otherCollectionsLink      =     base_url_lang($otherCollectionsLink);
    
    //------create share link by current url-------//
    $currentShortUrl = uri_string();
    
?>

<div class="row content_wrap" >
   
   <?php
        //---------load header navigation menu---------//
        $viewData = array(
            'headingName'   =>  $this->lang->line($industryType.'_detail_heading'),
            'navigation_1'  =>  $galleryPageLink,
            'navigation_2'  =>  $aboutPageLink,
            'navigation_3'  =>  $otherCollectionsLink,
            'activeMenu'    =>  'menu2',
            'categoryId'    =>  $this->config->item('FvCollectionCatId'),
        );
        $this->load->view('common_view/media_showcase_header_view',$viewData);
   ?>
   
    <div class="text_bx  fs20 pt25 pb20 open_sans clr_666 lineH25 width900 m_auto display_table ">
        <?php echo html_entity_decode($projName);?>
    </div>
    
     <div id="slider" class="flexslider width100_per bg_f3f3f3 vedio_gall">
          <div class="display_table heigt566 width100_per m_auto">
             <div class="table_cell collection_banner"> <img src="<?php echo $projectImage; ?>"  alt=""/>
             </div>
          </div>
          <div class="width900 pt23 pb20 display_table m_auto">
              <div class="fl pr10">
                    <span class="fl soc_1 pr10">
                        <?php 
                            //-------load module of social share---------------//
                            $shareData=array('url'=>$currentShortUrl,'isPublished'=>$isPublished,'designType'=>'5');
                            echo Modules::run("share/sharesocialshowview",$shareData);
                        
                            //-----short module link by email module array-----//
                            $shortlinkEmailData=array('url'=>$currentShortUrl,'isPublished'=>$isPublished,'designType'=>'2');
                            echo Modules::run("share/shareemailbutton",$shortlinkEmailData);
                            
                            //-----load module shortlink module array-----//
                            $shortlinkData=array('url'=>$currentShortUrl,'isPublished'=>$isPublished,'designType'=>'2');
                            echo Modules::run("shortlink/shortlinkfrontbuttonnew",$shortlinkData);	
                        ?>
                    </span>
                 </div>
             <div class="fr">
                <?php 
                    //-----------crave button module load view-----------//
                    $craveButtonData= array('buttonDesigntype'=>'1','buttonTitle'=>$this->lang->line('filmNvideo_crave_btn_proj'),'elementId'=>$projectId,'entityId'=>$entityId,'ownerId'=>$frentendUserId,'projectType'=>$industryType,'isPublished'=>$isPublished,'furteherDetails'=>'{"projectId":"'.$projectId.'","table":"Project","primeryField":"projId","fieldSet":"projId as id,projBaseImgPath as craveImage, projName as craveTitle, projShortDesc as craveShortDescription, tagwords as tagwords","cacheFilePath":"'.$cacheFile.'"}');
                    echo Modules::run("craves/creavebutton",$craveButtonData);

                    //------------rating button module load view------------//
                    $ratingButtonData = array('elementId'=>$projectId,'entityId'=>$entityId,'isPublished'=>$isPublished);
                    echo Modules::run("rating/ratingbutton",$ratingButtonData);

                    //------------review button view load-------------//
                    $this->load->view('media/reviewViewNew',array('reviewdesign'=>'1','reviewProjectId'=>$projectId,'reviewElementId'=>$projectId,'reviewEntityId'=>$entityId,'reviewIndustryId' =>'1','isPublished'=>$isPublished));	
                    
                    //------------add news button button view load-------------//
                    $this->load->view('media/newsViewNew',array('reviewdesign'=>'1','reviewProjectId'=>$projectId,'reviewElementId'=>$projectId,'reviewEntityId'=>$entityId,'reviewIndustryId' =>'1','isPublished'=>$isPublished));	
                ?>
                
             </div>
          </div>
       </div>
               
    
   <div class="width900 m_auto sc_album">
      <!--  left Content start  -->
        <div class="left_w width_302 pt6 lineH18 fl mr pr30">
             
              <div class="fl open_sans width385">
                <div class="fl ">
                   <div class="fl "> <span class="lettsp-1 red pb15"><?php echo $this->lang->line('filmNvideo_crave_details_proj'); ?></span> <br>
                        <?php if($videoFileCount >0 || $dvdCount >0) { ?> 
                            
                            <?php if($videoFileCount >0) { ?> 
                                <span> <b class="red pr7"><?php echo $videoFileCount; ?></b><?php echo $this->lang->line('filmNvideo_collection_contents_1'); ?> </span> 
                            <?php  } ?>
                            
                            <?php if($dvdCount >0) { ?> 
                                <span class="pl10"> <b class="red pr7"><?php echo $dvdCount; ?></b><?php echo $this->lang->line('filmNvideo_collection_contents_2'); ?> </span> 
                            <?php  } ?>
                      
                        <?php } ?>
                   </div>
                   <div class="sap_15"></div>
                   <div class="fl head_list pr10 color_666">
                      <div class="icon_view3_blog icon_so"><?php echo $viewCount; ?></div>
                      <div class="icon_crave4_blog icon_so <?php echo $craveDivAction.' '.$cravedALL; ?>"><?php echo $craveCount;?></div>
                      <div class="rating fl pt6 <?php echo  $rateDivAction; ?>">
                         <img alt="" src="<?php echo ratingImagePath($ratingAvg);?>">
                      </div>
                      <div class="btn_share_icon icon_so"><?php echo $reviewCount; ?></div>
                   </div>
                </div>
             </div>
             <div class="sap_20 bb_e7e7e7"></div>
             <div class="sap_20"></div>
             <div class="clearb">
                    <?php 
                        $buttonArray = array('projectData'=>$projectData,'elementDataList'=>$elementDataList,'showview'=>'project'); 
                        $this->load->view('common_view/project_details_show_buttons',$buttonArray);
                    ?>
             </div>
             <!--
             <div class="sap_20 bb_e7e7e7"></div>
             <div class="sap_10"></div>-->
             
            
             
              
            <div class="clearb">
                <ul class="edit_list  pl17 lettsp-1 ">
                   <li class="pb5">
                      <p class="red opens_light "><?php echo $this->lang->line('filmNvideo_published_toadsquare'); ?></p>
                      <p><?php echo date("d F Y", strtotime($projReleaseDate)); ?></p>
                   </li>
                   <?php if($classification) { ?>
                   <li>
                      <p class="red opens_light "><?php echo $this->lang->line('filmNvideo_self_classification'); ?></p>
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
            <div class="rightbox width560 position_relative fr">
                 <div class="bg_f3f3f3 fr pt17 pb20 pl20 ml19 width519 pr20">
                    <div class="clearb">
                        
                        <?php if(!empty($trailerSampleElementList)){ 
                            $videoCount = 1;
                            foreach($trailerSampleElementList as $element){
                                
                                $elementType = $element['elementType'];
                                $elementTypeTitle = ($elementType==1)?"SAMPLE VIDEO":'TRAILER';
                                $elementTypeClass = ($elementType==1)?"sample_wrap":'traler_wrap';
                                
                                if(empty($element['imagePath'])){	
                                    $thumbImage = getVideoThumbFolder(@$element['filePath'].$element['fileName'],'_m');	
                                    $elementImage=getImage($thumbImage,$imagetype);	
                                }else{
                                    $thumbImage = addThumbFolder(@$element['imagePath'],'_m');	
                                    $elementImage=getImage($thumbImage,$imagetype);
                                }
                                
                                $elementUrl=base_url(lang().$urlUsername.'/mediafrontend/mediadetails/'.$frentendUserId.'/'.$projectId.'/'.$element['elementId'].$previewWord);
                        ?>
                            <a href="<?php echo $elementUrl;?>">
                                <div class="position_relative <?php echo $elementTypeClass; ?> text_alighC  ptr bdr_c3c3c3  fl <?php echo ($videoCount > 1)?'ml18':''; ?>">
                                    <span class="table_cell">
                                        <span class="title_img"><?php echo $elementTypeTitle; ?></span> 
                                        <img src="<?php echo $elementImage; ?>" alt=""  />
                                    </span>
                                </div>
                            </a>
                        
                        <?php  $videoCount++; } ?>
                        <?php  } ?>    
                    </div>
                    
                 </div>
                 <div class="sap_20"></div>
                 <div class=" cnt">
                    <div class="fs17 font_bold "> 
                    <?php
                        if(strlen(trim($projShortDesc))>2){ ?>
                    <?php echo nl2br($projShortDesc);?>
                    <?php } ?> </div>
                    <div class="bb_b7b7b7 sap_15 mb15"></div>
                    <div class="content_collection lineH20">
                       
                        <?php
                            if(strlen(trim($projDescription))>2){ ?>
                                <?php echo changeToUrl(nl2br($projDescription));?>
                        <?php 
                            }
                        ?>
                    </div>
                 </div>
                 
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
                 <div class="sap_30"></div>
                
                 
            </div>

      <!-- right Content end  --> 
   </div>
</div>
