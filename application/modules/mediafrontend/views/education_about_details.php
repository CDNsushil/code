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
    
    //echo "<pre>";
    //print_r($projectData);
    
    
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
    $projectindustryid          =   (!empty($projectData['projectindustryid']))?$projectData['projectindustryid']:'';
  
    $imageFileCount             =   (!empty($projectData['imageFileCount']))?$projectData['imageFileCount']:'0';
    $videoFileCount             =   (!empty($projectData['videoFileCount']))?$projectData['videoFileCount']:'0';
    $audioFileCount             =   (!empty($projectData['audioFileCount']))?$projectData['audioFileCount']:'0';
    $docFileCount               =   (!empty($projectData['docFileCount']))?$projectData['docFileCount']:'0';
    $cdCount                    =   (!empty($projectData['cdCount']))?$projectData['cdCount']:'0';
    $dvdCount                   =   (!empty($projectData['dvdCount']))?$projectData['dvdCount']:'0';
    $printCount                 =   (!empty($projectData['printCount']))?$projectData['printCount']:'0';
    $docCount                   =   (!empty($projectData['docCount']))?$projectData['docCount']:'0';
    
    
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
    
    //defined default variable
    $previousProjectId      =   0;
    $nextProjectId          =   0;
    $nextPageLink           =   '';
    $previousPageLink       =   '';
   
    //previous project show page link id get
    if($currentKeyPosition > 0):
        $previousProjectId      =     $projectPrepareList[$currentKeyPosition-1];
        $previousPageLink       =     'mediafrontend/educationdetails/'.$frentendUserId.'/'.$previousProjectId.$previewWord;
        $previousPageLink       =      base_url_lang($previousPageLink);
    endif;
    
    //previous project show page link id get
    if($currentKeyPosition < ($projectsNumberCount-1)):
        $nextProjectId      =     $projectPrepareList[$currentKeyPosition+1];
        $nextPageLink       =    'mediafrontend/educationdetails/'.$frentendUserId.'/'.$nextProjectId.$previewWord;
        $nextPageLink       =     base_url_lang($nextPageLink);
    endif;
    
    //------about page link prepare--------//
    $aboutPageLink       =     'mediafrontend/educationdetails/'.$frentendUserId.'/'.$projectId.$previewWord;
    $aboutPageLink       =     base_url_lang($aboutPageLink);
    
    $galleryPageLink       =     'mediafrontend/educationelement/'.$frentendUserId.'/'.$projectId.$previewWord;
    $galleryPageLink       =     base_url_lang($galleryPageLink);
    
    $otherCollectionsLink      =    'showproject/othercollections/'.$frentendUserId.'/educationMaterial'.$previewWord;
    $otherCollectionsLink      =     base_url_lang($otherCollectionsLink);
    
    //------create share link by current url-------//
    $currentShortUrl = uri_string();
    
?>

<div class="row content_wrap" >
 
    <?php
        //---------load header navigation menu---------//
        $viewData = array(
            'headingName'   =>   $this->lang->line('educationMaterial_detail_heading_'.$categoryId),
            'navigation_1'  =>  $galleryPageLink,
            'navigation_2'  =>  $aboutPageLink,
            'navigation_3'  =>  $otherCollectionsLink,
            'activeMenu'    =>  'menu2',
            'categoryId'    =>  $this->config->item('EmCorseCatId'),
        );
        $this->load->view('common_view/media_showcase_header_view',$viewData);
    ?>
   <div class="width903 m_auto pt25 sc_album display_table">
      <!--  left Content start  -->
      <div class="left_w width_302  lineH18 fl mr pr30">
         <div class="head_list fl width_273 bg_fdfdfd bdr_ececec ">
            <p class="fs16 fl pr10">Collection</p>
            <div class="fr pr25 color_666">
               <div class="icon_view3_blog icon_so"><?php echo $viewCount; ?></div>
               <div class="icon_crave4_blog icon_so <?php echo $craveDivAction.' '.$cravedALL; ?>"><?php echo $craveCount;?></div>
               <div class="rating fl pt6 <?php echo  $rateDivAction; ?>"> <img src="<?php echo ratingImagePath($ratingAvg);?>" alt=""> </div>
               <div class="btn_share_icon icon_so"><?php echo $reviewCount; ?></div>
            </div>
         </div>
         <div class="sap_15"></div>
         <div class="clearb">
            <?php 
                $buttonArray = array('projectData'=>$projectData,'elementDataList'=>$elementDataList,'showview'=>'project'); 
                $this->load->view('common_view/project_details_show_buttons',$buttonArray);
            ?>
         </div>
         <div class="sap_20 "></div>
       
         <div class=" media_list box" >
            <div class="plut_mark red clearb opens_light mr12 fr"></div>
            <h2 class="opens_light clearb bb_f79b7f ml5 pb14 pt8 lettsp2 fs26"> Collection Media List</h2>
            <div class="sap_20"></div>
            <?php 
                if(!empty($videoFileCount) || !empty($dvdCount) || !empty($docFileCount) || !empty($docCount)
                || !empty($audioFileCount) || !empty($cdCount) || !empty($imageFileCount)  || !empty($printCount)){ ?>
            <div class="clearbox pl16">
               <b class="lett_8p"> Collection Contents</b>
               <ul class="collection_list pt8">
                    <li>
                        <?php if(!empty($videoFileCount)){ ?>
                            <span><b class="red"><?php echo $videoFileCount; ?></b> Video Files</span>
                        <?php  } ?>
                        <?php if(!empty($dvdCount)){ ?>
                            <span> <b class="red"><?php echo $dvdCount; ?> </b> DVDs  </span>
                        <?php  } ?>
                    </li>
                    <li>
                        <?php if(!empty($docFileCount)){ ?>
                            <span><b class="red"><?php echo $docFileCount; ?></b> Text Files </span>
                        <?php  } ?>
                        <?php if(!empty($docCount)){ ?>
                            <span> <b class="red"><?php echo $docCount; ?></b> Texts</span>
                        <?php  } ?>
                    </li>
                    <li>
                        <?php if(!empty($audioFileCount)){ ?>
                            <span><b class="red "><?php echo $audioFileCount; ?></b> Audio Files </span>
                        <?php  } ?>
                        <?php if(!empty($cdCount)){ ?>
                            <span> <b class="red"><?php echo $cdCount; ?></b> CDs</span> 
                        <?php  } ?>
                    </li>
                    <li>
                        <?php if(!empty($imageFileCount)){ ?>
                            <span><b class="red"><?php echo $imageFileCount; ?></b> Image Files</span>
                        <?php  } ?>
                        <?php if(!empty($printCount)){ ?>
                            <span> <b class="red"><?php echo $printCount; ?></b> Prints</span>
                         <?php  } ?>
                    </li>
               </ul>
            </div>
            <?php  } ?>
            <div class="sap_20 bb_d4d4d4"></div>
           
            <div class="clearbox collection_media" id="showCollection">
              
               <?php  $this->load->view('collectionmedialistview'); ?>
               
            </div>
            
            
            
         </div>
         <div class="sap_35"></div>
       
         <div class="clearb">
            <b class="red lettsp-1">Collection Information</b>
            <ul class="edit_list pb2  fs13 lettsp-1 ">
                <?php if(!empty($projReleaseDate)){ ?>
                   <li>
                      <p class="color_999 lineH15">PUBLISHED ON TOADSQUARE</p>
                      <p><?php echo date("d F Y", strtotime($projReleaseDate)); ?></p>
                   </li>
                <?php } ?>
                <?php if($selfClassfication) { ?>
               <li>
                  <p class="color_999 lineH15"> SELF CLASSIFICATION</p>
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
         <div class="fs22  open_sans lienH26"><?php echo html_entity_decode($projName);?>
         </div>
         <div class="sap_25"></div>
         <div class=" position_relative eduaction_right display_table">
            <span class="table_cell">
            <img src="<?php echo $projectImage; ?>" alt="" class="maxW560"  />
            </span>
         </div>
        <?php 
       /* if(!empty($elementDataList)){
            $elementCount = count($elementDataList);
        ?>
         <div class="clearbox bg_444 education_thumb mt1 pt8 pb8">
            <div id="carousel" class="flexslider pl13 pr15 toggle_slider">
               <ul class="slides" id="slide_one">
                    <?php foreach($elementDataList as $element){
                     
                        $elementId = (!empty($element['elementId']))?$element['elementId']:0;
                        
                        $thumbImage = addThumbFolder(@$element['filePath'].$element['fileName'],'_xs',$thumbFolder);	
                        $elementImage=getImage($thumbImage,$imagetype_xs);	
                        
                        $elementPageLink       =     'mediafrontend/educationelement/'.$frentendUserId.'/'.$projectId.'/'.$elementId
                        
                    ?>
                        <li onclick="window.location='<?php echo $elementPageLink; ?>'"><img src="<?php echo $elementImage; ?>"  alt=""/></li>
                    <?php } ?>
               </ul>
            </div>
         </div>
        <?php   }*/  ?>
        
        <div class="clearbox bg_444 mt1  sap_65 pt10 pb10"></div>
         
        <div class="sap_25"></div>
        <div class="fs17">
            <?php
                if(strlen(trim($projShortDesc))>2){ ?>
            <?php echo nl2br($projShortDesc);?>
            <?php } ?>
        </div>
         <div class="bb_b7b7b7 sap_30"></div>
         <div class="sap_30"></div>
         <div class=" cnt">
            <div class="content_collection fs15 lineH20">
                <?php
                    if(strlen(trim($projDescription))>2){ 
                         echo changeToUrl(nl2br($projDescription));
                    }
                ?>
            </div>
            <div class="sap_30"></div>
            <div class="fr">
                <?php 
                    //-----------crave button module load view-----------//
                    $craveButtonData= array('buttonDesigntype'=>'1','buttonTitle'=>'Crave this collection','elementId'=>$projectId,'entityId'=>$entityId,'ownerId'=>$frentendUserId,'projectType'=>$industryType,'isPublished'=>$isPublished,'furteherDetails'=>'{"projectId":"'.$projectId.'","table":"Project","primeryField":"projId","fieldSet":"projId as id,projBaseImgPath as craveImage, projName as craveTitle, projShortDesc as craveShortDescription, tagwords as tagwords","cacheFilePath":"'.$cacheFile.'"}');
                    echo Modules::run("craves/creavebutton",$craveButtonData);

                    //------------rating button module load view------------//
                    $ratingButtonData = array('elementId'=>$projectId,'entityId'=>$entityId,'isPublished'=>$isPublished);
                    echo Modules::run("rating/ratingbutton",$ratingButtonData);

                    //------------review button view load-------------//
                    $this->load->view('media/reviewViewNew',array('reviewdesign'=>'1','reviewProjectId'=>$projectId,'reviewElementId'=>$projectId,'reviewEntityId'=>$entityId,'reviewIndustryId' =>'10','isPublished'=>$isPublished));
                ?>
            </div>
            <div class="sap_10"></div>
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
       
           
      </div>
      <!-- right Content end  -->
   </div>
</div>


 <script type="text/javascript">
    $(window).load(function(){
       $('#carousel').flexslider({
         animation: "slide",
         controlNav: false,
         animationLoop: true,
         slideshow: false,
         itemWidth: 109,
         asNavFor: '#slider'
       });
    });
</script>
