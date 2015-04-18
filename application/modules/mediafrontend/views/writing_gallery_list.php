<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    
    //add preview word if preview mode is active
    $previewWord =  (previewModeActive())?"/preview":"";
    
    //------default image details-------//
    $imagetype_m        =   $fileConfig['defaultImage_m'];
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
    }else{
        $projectData  = $projectData[0]; 
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
            'headingName'   =>   $this->lang->line('writingNpublishing_detail_heading_gallery_'.$categoryId),
            'navigation_1'  =>  $galleryPageLink,
            'navigation_2'  =>  $aboutPageLink,
            'navigation_3'  =>  $otherCollectionsLink,
            'activeMenu'    =>  'menu1',
            'categoryId'    =>  $this->config->item('WpCollectionCatId'),
        );
        $this->load->view('common_view/media_showcase_header_view',$viewData);
    ?>
   
   <div class="width930 m_auto  sc_album  display_table">
      <div class="text_bx fs24 pb30 open_sans clr_666 lineH25"> <?php echo $projName; ?> </div>
      <div class="clearbox ">
         <div class="display_inline Writing_img fl mr20  width342">
            <div class=" fl">
               <div class=" position_relative  mb20 fl">
                  <span class="table_cell">
                     <img src="<?php echo $projectImage; ?>" alt="" /> 
                     <div class="fs20 opens_light">
                        <a class="view_musc_btn position_absolute" href="<?php echo $aboutPageLink; ?>">About this Collection</a>
                     </div>
                  </span>
               </div>
            </div>
            <span class="left_w  fl lineH18  mr pr60">
               <div class="fl mt10 open_sans mb15">
                  
                    <?php if($docFileCount >0 || $docCount >0) { ?> 
                        <div class="clearb">
                         <p class="font_bold mb10">Collection Information</p>
                           <?php if($docFileCount >0) { ?> 
                                 <p class="mb5"><span class="red"><?php echo $docFileCount; ?></span> Text File</p>
                           <?php } ?>
                           <?php if($docCount >0) { ?> 
                                <p><span class="red"><?php echo $docCount; ?></span> Text </p>
                           <?php } ?>
                         </div>    
                    <?php } ?>
                  
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
               </div>
            </span>
         </div>
         <div class="rightbox content_list fr width550 ">
            
            <?php 
                if(!empty($elementDataList)){
                $elementCount=1;
                foreach($elementDataList as $getElementData){
                    
                $eleEntityId                =   (!empty($getElementData['entityId']))?$getElementData['entityId']:''; 
                $eleElementId               =   (!empty($getElementData['elementId']))?$getElementData['elementId']:''; 
                $elementTitle               =   (!empty($getElementData['title']))?$getElementData['title']:''; 
                $elementDescrip             =   (!empty($getElementData['description']))?$getElementData['description']:''; 
                $elementImagePath           =   (!empty($getElementData['imagePath']))?$getElementData['imagePath']:''; 
                $eleCraveCount              =   (!empty($getElementData['craveCount']))?$getElementData['craveCount']:''; 
                $eleViewCount               =   (!empty($getElementData['viewCount']))?$getElementData['viewCount']:''; 
                $eleRatingAvg               =   (!empty($getElementData['ratingAvg']))?$getElementData['ratingAvg']:''; 
                $elementType                =    (!empty($getElementData['elementType']))?$getElementData['elementType']:''; 
                $mediaFileType              =    $this->config->item('media_type_document'); // set default media type for document
                
                
                $eleCraveDivAction             =   'craveDiv'.$eleEntityId.''.$eleElementId;
                $eleRateDivAction              =   'rateDiv'.$eleEntityId.''.$eleElementId;
              
                //---------check craved by loggedUserId------------//
                if($loggedUserId){
                    $where=array(
                        'tdsUid'        =>   $loggedUserId,
                        'entityId'      =>   $eleEntityId,
                        'elementId'     =>   $eleElementId
                    );
                    
                    $countResult    =   countResult('LogCrave',$where);
                    $cravedALL      =   ($countResult>0)?'cravedALL':'';
                }else{
                    $cravedALL='';
                }
                
                $thumbImage             =   addThumbFolder($elementImagePath,'_m',$thumbFolder);	
                $showElementImage       =   getImage($thumbImage,$imagetype_m);
                
                $aboutMore=base_url(lang().$urlUsername.'/mediafrontend/writingelement/'.$frentendUserId.'/'.$projectId.'/'.$getElementData['elementId'].$previewWord);
           ?>
           
                <div class="writing_content clearbox bg_f3f3f3 mb20">
                   <div class="fl writing_pro display_table">
                      <div class="table_cell">
                         <img src="<?php echo $showElementImage; ?>" alt="" />
                      </div>
                   </div>
                   <div class="pl10 fl width_400 pr5 mt5 mb5">
                      <div class="width100_per bg_fff pt3 pb3 fl  head_list pr10 color_666">
                         <div class="fr">
                            <div class="icon_view3_blog icon_so"><?php echo $eleViewCount; ?></div>
                            <div class="icon_crave4_blog icon_so <?php echo $eleCraveDivAction.' '.$cravedALL; ?>"><?php echo $eleCraveCount; ?></div>
                            <div class="rating fl pt6 <?php echo  $rateDivAction; ?>">
                               <img src="<?php echo ratingImagePath($eleRatingAvg);?>" alt="">
                            </div>
                         </div>
                      </div>
                      <h3 class="fs16 red pt6 pb5 clearbox"><?php echo $elementTitle; ?> </h3>
                      <p class="fs12 min_h60"> 
                        <?php echo showString($elementDescrip,250); ?>
                      </p>
                      <div class="sap_15"></div>
                        <?php 
                            //element type "0" for main element
                            if($elementType==0){
                                //-------element collection price--------//
                                $elementButtonArray = array('elementId'=>$elementId,'projectData'=>$projectData,'elementDataList'=>$elementDataList,'showview'=>'projectelement','mediaFileType'=>$mediaFileType); 
                                $this->load->view('common_view/project_element_details_show_buttons',$elementButtonArray);
                            }
                        ?>
                      <div class="fr mt26">   
                         <span class="red pr5"><?php echo str_word_count($elementDescrip); ?> words</span>  <a href="<?php echo  $aboutMore; ?>" class="red_arrow pr18"> About this Text</a> 
                      </div>
                   </div>
                </div>
                
            <?php $elementCount++; }   } ?>
            
            <div class="fr pr25 pt10">
                 <?php 
                    //-----------crave button module load view-----------//
                    $craveButtonData= array('buttonDesigntype'=>'1','buttonTitle'=>'Crave this Collection','elementId'=>$projectId,'entityId'=>$entityId,'ownerId'=>$frentendUserId,'projectType'=>$industryType,'isPublished'=>$isPublished,'furteherDetails'=>'{"projectId":"'.$projectId.'","table":"Project","primeryField":"projId","fieldSet":"projId as id,projBaseImgPath as craveImage, projName as craveTitle, projShortDesc as craveShortDescription, tagwords as tagwords","cacheFilePath":"'.$cacheFile.'"}');
                    echo Modules::run("craves/creavebutton",$craveButtonData);

                    //------------rating button module load view------------//
                    $ratingButtonData = array('elementId'=>$projectId,'entityId'=>$entityId,'isPublished'=>$isPublished);
                    echo Modules::run("rating/ratingbutton",$ratingButtonData);

                    //------------review button view load-------------//
                    $this->load->view('media/reviewViewNew',array('reviewdesign'=>'1','reviewProjectId'=>$projectId,'reviewElementId'=>$projectId,'reviewEntityId'=>$entityId,'reviewIndustryId' =>'3','isPublished'=>$isPublished)); 
                
                    //------------add news button button view load-------------//
                    $this->load->view('media/newsViewNew',array('reviewdesign'=>'1','reviewProjectId'=>$projectId,'reviewElementId'=>$projectId,'reviewEntityId'=>$entityId,'reviewIndustryId' =>'1','isPublished'=>$isPublished));	
                ?>
                
            </div>
         </div>
      </div>
   </div>
</div>
         
