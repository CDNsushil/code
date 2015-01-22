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
        $previousPageLink       =     'mediafrontend/writingdetails/'.$frentendUserId.'/'.$previousProjectId;
        $previousPageLink       =      base_url_lang($previousPageLink);
    endif;
    
    //previous project show page link id get
    if($currentKeyPosition < ($projectsNumberCount-1)):
        $nextProjectId      =     $projectPrepareList[$currentKeyPosition+1];
        $nextPageLink       =    'mediafrontend/writingdetails/'.$frentendUserId.'/'.$nextProjectId;
        $nextPageLink       =     base_url_lang($nextPageLink);
    endif;
    
    //------about page link prepare--------//
    $aboutPageLink       =     'mediafrontend/writingdetails/'.$frentendUserId.'/'.$projectId;
    $aboutPageLink       =     base_url_lang($aboutPageLink);
    
    $galleryPageLink       =     'mediafrontend/writinggallery/'.$frentendUserId.'/'.$projectId;
    $galleryPageLink       =     base_url_lang($galleryPageLink);
    
    $otherCollectionsLink      =    'showproject/othercollections/'.$frentendUserId.'/writingNpublishing';
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
            'categoryId'    =>  $categoryId,
        );
        $this->load->view('common_view/media_showcase_header_view',$viewData);
    ?>
   <div class="width903 m_auto pt36 sc_album display_table">
      <!--  left Content start  -->
      <div class="left_w width_302  lineH18 fl mr pr30">
         <div class="head_list fl  width_273 bg_fdfdfd bdr_ececec ">
            <p class="fs16 fl pr10">Collection</p>
            <div class="fr pr25 color_666">
               <div class="icon_view3_blog icon_so"><?php echo $viewCount; ?></div>
               <div class="icon_crave4_blog icon_so <?php echo $craveDivAction.' '.$cravedALL; ?>"><?php echo $craveCount;?></div>
               <div class="rating fl pt6 <?php echo  $rateDivAction; ?>">
                  <img src="<?php echo ratingImagePath($ratingAvg);?>" alt="">
               </div>
               <div class="btn_share_icon icon_so"><?php echo $reviewCount; ?></div>
            </div>
        </div>
      
     
        <?php if($docFileCount >0 || $docCount >0) { ?> 
         <div class="sap_25"></div>
         <div class="clearb pl16">
            <b class=" lettsp-1">Collection Contents</b>
            <ul class="edit_li1 bb_e7e7e7 pb20 fs13">
               <?php if($docFileCount >0) { ?> 
                    <li class="pt7"><b class="red fs14 minw20 fl"><?php echo $docFileCount; ?></b>Text Files</li>
               <?php } ?>
               <?php if($docCount >0) { ?> 
                    <li><b class="red fs14 minw20 fl"><?php echo $docCount; ?></b>Texts</li>
               <?php } ?>
            </ul>
         </div>
         
        <?php }else{ ?>
            <div class="sap_20 bb_e7e7e7"></div>
        <?php } ?> 
         
         
         <div class="sap_15"></div>
         <div class="clearb pl16">
            <p class="red font_bold mt10 ">Collection Information</p>
            <ul class="edit_list pb2 letter_spP7 fs13 pt5  ">
               <!--
               <li>
                  <p class="red lineH15">LANGUAGE</p>
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
         <span class="text_alighC width100_per"	><span class="sap_20"></span>
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
                //---------associative creatives list start----------//
                    echo  Modules::run("creativeinvolved/associativecreativeslist", $entityId,$projectId);
                //---------associative creatives list start----------//
            ?>
       
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
      <div class="rightbox width560 position_relative fr ">
         <div class="banner pl10 width545imp pt10 pb7 pr12 bg_f5f5f5">
            <h3 class=" pl20 clr_fff fs28 pb18 pt15  left0 pr45	 zindex_999  position_absolute mt15 bg_444_8">About the Collection </h3>
            <div class="w_pwrap width_545 height366 display_table">
               <div class="table_cell "><img src="<?php echo $projectImage; ?>" /></div>
            </div>
            <div class="mt28 clearbox">
               <div class="fl ml12 mr30">
               
                    <?php 
                        $buttonArray = array('projectData'=>$projectData,'elementDataList'=>$elementDataList,'showview'=>'project'); 
                        $this->load->view('common_view/project_details_show_buttons',$buttonArray);
                    ?>
                        
               </div>
               
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
                    <div class="fl ml12">
                       <button type="button" class="white_button fs12 min_w135"
                        onclick="<?php echo $functionAction; ?>" >
                        View Extract</button>
                    </div>
                
                <?php  } ?>
                
               
               <div class="fr pt5 text_alignR mr25 letter_spP7 fs13">
                  <p class="red">PUBLISHER</p>
                  Self Published 
               </div>
            </div>
         </div>
         <div class="sap_25"></div>
         <div class="fr white_btns">
                <?php 
                    //-----------crave button module load view-----------//
                    $craveButtonData= array('buttonDesigntype'=>'1','buttonTitle'=>'Crave','elementId'=>$projectId,'entityId'=>$entityId,'ownerId'=>$frentendUserId,'projectType'=>$industryType,'isPublished'=>$isPublished,'furteherDetails'=>'{"projectId":"'.$projectId.'","table":"Project","primeryField":"projId","fieldSet":"projId as id,projBaseImgPath as craveImage, projName as craveTitle, projShortDesc as craveShortDescription, tagwords as tagwords","cacheFilePath":"'.$cacheFile.'"}');
                    echo Modules::run("craves/creavebutton",$craveButtonData);

                    //------------rating button module load view------------//
                    $ratingButtonData = array('elementId'=>$projectId,'entityId'=>$entityId,'isPublished'=>$isPublished);
                    echo Modules::run("rating/ratingbutton",$ratingButtonData);

                    //------------review button view load-------------//
                    $this->load->view('media/reviewViewNew',array('elementId'=>$projectId,'entityId'=>$entityId,'projName'=>$projName,'section' =>'Writing & Publishing','industryId' =>'1','isPublished'=>$isPublished));	
                ?>
         </div>
         <div class="sap_15"></div>
         <h3 class="fs20 mt18 clearbox lineH24 clearb pb15 mb22 bb_b7b7b7 font_bold"><?php echo html_entity_decode($projName);?>
         </h3>
         <div class=" cnt">
            <div class="fs18 lineH20">
                    <?php
                        if(strlen(trim($projShortDesc))>2){ ?>
                    <?php echo nl2br($projShortDesc);?>
                    <?php } ?>
            </div>
            <div class="sap_30"></div>
            <div class="content_collection lineH20">
                
                <?php
                    if(strlen(trim($projDescription))>2){ 
                         echo changeToUrl(nl2br($projDescription));
                    }
                ?>
                
            </div>
         </div>
         <div class="box_wrap socail_icon width_542 pb9">
             
            <div class="nav mb16 pb5 width513 display_inline_block  text_alighC bb_e9e9e9 ">
               
                <?php if(!empty($previousPageLink)): ?> 
                    <a class=" fl text_alighL " href="<?php echo $previousPageLink; ?>">Previous Collection </a> 
                <?php else: ?>
                     <a class=" fl text_alighL disable_link" href="javascript:void(0)">Previous Collection </a> 
                <?php endif; ?> 
               
               <span class="counter"><span class="current_slide"><?php echo $projectViewNumber; ?></span>/<span class="total_slide"></span>
                <?php echo $projectsNumberCount; ?>
               </span> 
            
                <?php if(!empty($nextPageLink)): ?> 
                    <a class=" fr text_alignR" href="<?php echo $nextPageLink; ?>">Next Collection</a>
                <?php else: ?>
                     <a class=" fr text_alignR disable_link" href="javascript:void(0)">Next Collection</a>
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
             <div class="sap_20"></div>
      </div>
   </div>
</div>
      
