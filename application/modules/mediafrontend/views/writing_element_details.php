<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    //add preview word if preview mode is active
    $previewWord =  (previewModeActive())?"/preview":"";

    //------check project data and convert to single diemential array------//
    if(!empty($projectData)):
        $projectData = $projectData[0];
    endif;

    //------check project element data and convert to single diemential array------//
    $elementData         =   false;
    $elementPrepareList  =   false;
    $currentElementView  =   0;
    $currentKeyPosition  =   1;
    if(!empty($elementDataList)):
        foreach($elementDataList as $key => $getElementData){
            
            $elementPrepareList[]        =       $getElementData['elementId'];
        
            //check element id and set data
            if($getElementData['elementId']==$elementId){
                $elementData        =  $getElementData;
                $currentKeyPosition =  $key;
                $currentElementView =  $key+1;
            }
        }
    endif;
    
    //-----------next and previous element link prepare----------//
    
    $elementNumberCount    =   count($elementPrepareList);
        
    //defined default value    
    $previousElementId      =   0;
    $nextElementId          =   0;
    $nextPageLink           =   '';
    $previousPageLink       =   '';
   
    //previous element show page link id get
    if($currentKeyPosition > 0):
        $previousElementId      =     $elementPrepareList[$currentKeyPosition-1];
        $previousPageLink       =     'mediafrontend/writingelement/'.$frentendUserId.'/'.$projectId.'/'.$previousElementId.$previewWord;
        $previousPageLink       =     base_url_lang($previousPageLink);
    endif;
    
    //previous element show page link id get
    if($currentKeyPosition < ($elementNumberCount-1)):
        $nextElementId      =    $elementPrepareList[$currentKeyPosition+1];
        $nextPageLink       =    'mediafrontend/writingelement/'.$frentendUserId.'/'.$projectId.'/'.$nextElementId.$previewWord;
        $nextPageLink       =     base_url_lang($nextPageLink);
    endif;
    
    
    //--------element require default data--------//
    $imagetype_b            =   $fileConfig['defaultImage_b'];
    $imagetype_m            =   $fileConfig['defaultImage_m'];
    $imagetype_l            =   $fileConfig['defaultImage_l'];
    $imagetype_xl           =   $fileConfig['defaultImage_xl'];
    $imagetype_xxl           =   $fileConfig['defaultImage_xxl'];
    $imagetype_xs           =   $fileConfig['defaultImage_xs'];
    $imagetype_s            =   $fileConfig['defaultImage_s'];
   
   
    //---------preprae project details data----------//
    $projSellstatus               =   ($projectData['projSellstatus']=='t')?true:false;
    $projSellType                 =   (!empty($projectData['projSellType']))?$projectData['projSellType']:'0';

    //------prepare the element details data---------//
    $mediaId                =    (!empty($elementData['fileId']))?$elementData['fileId']:'0';  
    //$elementId              =   (!empty($elementData['elementId']))?$elementData['elementId']:'0'; 
    //$projectId              =   (!empty($elementData['projId']))?$elementData['projId']:$elementData['projId']; 
    $title                  =    (!empty($elementData['title']))?$elementData['title']:''; 
    $elementImagePath       =    (!empty($elementData['imagePath']))?$elementData['imagePath']:''; 
    $fileName               =    (!empty($elementData['fileName']))?$elementData['fileName']:''; 
    $filePath               =    (!empty($elementData['filePath']))?$elementData['filePath']:''; 
    $fileSize               =    (!empty($elementData['fileSize']))?$elementData['fileSize']:''; 
    $isExternal             =    (!empty($elementData['isExternal']))?$elementData['isExternal']:'f'; 
    $price                  =    (!empty($elementData['price']))?$elementData['price']:''; 
    $downloadPrice          =    (!empty($elementData['downloadPrice']))?$elementData['downloadPrice']:''; 
    $genreName              =    (!empty($elementData['genrename']))?$elementData['genrename']:''; 
    $projGenreFree          =    (!empty($elementData['projGenreFree']))?$elementData['projGenreFree']:''; 
    $projReleaseDate        =    (!empty($elementData['projReleaseDate']))?$elementData['projReleaseDate']:''; 
    $countryName            =    (!empty($elementData['countryName']))?$elementData['countryName']:''; 
    $craveCount             =    (!empty($elementData['craveCount']))?$elementData['craveCount']:'0'; 
    $viewCount              =    (!empty($elementData['viewCount']))?$elementData['viewCount']:'0'; 
    $ratingAvg              =    (!empty($elementData['ratingAvg']))?$elementData['ratingAvg']:'0'; 
    $reviewCount            =    (!empty($elementData['reviewCount']))?$elementData['reviewCount']:'0'; 
    $elementType            =    (!empty($elementData['elementType']))?$elementData['elementType']:''; 
    $classification         =    (!empty($elementData['classification']))?$elementData['classification']:''; 
    $producedInCountry      =    (!empty($elementData['producedInCountry']))?getCountry($elementData['producedInCountry']):''; 
    $isPublished            =    $elementData['isPublished']; 
    $categoryId             =    (!empty($elementData['catId']))?$elementData['catId']:'1';
    $isPrice                =    (!empty($elementData['isPrice']))?$elementData['isPrice']:'f'; 
    $isPerViewPrice         =    (!empty($elementData['isPerViewPrice']))?$elementData['isPerViewPrice']:'f'; 
    $isDownloadPrice        =    (!empty($elementData['isDownloadPrice']))?$elementData['isDownloadPrice']:'f'; 
    $selfClassfication      =    (!empty($elementData['otpion']))?$elementData['otpion']:''; 
    $mediaFileType          =    $this->config->item('media_type_document'); // set default media type for document
    
    //check project sell status then  show image by type
    if($projSellstatus=="t"){
        $thumbFolder='watermark'; 
    }else{
        $thumbFolder='thumb';
    }
    
    $dirSize                =   bytestoMB($fileSize);
    //$previeLink             =   'media/'.$constant['project_preview'].'/'.$project['projectid'];
    
    $mediaArray['width']    =   '426'; // width
    $mediaArray['height']   =   '298'; // height
    
    //--------crave and rating action data--------//
    $craveDivAction             =   'craveDiv'.$elementEntityId.''.$elementId;
    $rateDivAction              =   'rateDiv'.$elementEntityId.''.$elementId;
    
    if($isExternal=='t'){
        $fileDirPath='';
    }else{
        $fileDirPath=$filePath.$fileName;
    }

    $LogSummarywhere    =   array(
            'entityId'  =>  $elementEntityId,
            'elementId' =>  $elementId
    );			

    //------get user craved data ------//
    $cravedALL='';
    if(!empty($loggedUserId)){
        $where          =   array(
        'tdsUid'        =>  $loggedUserId,
        'entityId'      =>  $elementEntityId,
        'elementId'     =>  $elementId
        );
        $countResult    =   countResult('LogCrave',$where);
        $cravedALL      =   ($countResult>0)?'cravedALL':'';
    }
    
    //------about page link prepare--------//
    $aboutPageLink       =     'mediafrontend/writingdetails/'.$frentendUserId.'/'.$projectId.$previewWord;
    $aboutPageLink       =     base_url_lang($aboutPageLink);
    
    $galleryPageLink     =     'mediafrontend/writinggallery/'.$frentendUserId.'/'.$projectId.$previewWord;
    $galleryPageLink     =     base_url_lang($galleryPageLink);
    
    $otherCollectionsLink      =    'showproject/othercollections/'.$frentendUserId.'/writingNpublishing'.$previewWord;
    $otherCollectionsLink      =     base_url_lang($otherCollectionsLink);
    
    //------create share link by current url-------//
    $currentShortUrl     = uri_string();
    
     //get media file type for show details
    $uploadFileType = 'text_file';
    if($isPrice=="t"){
        $uploadFileType = 'text';
    }elseif($isDownloadPrice=="t"){
        $uploadFileType = 'text_file';
    }elseif($isPerViewPrice=="t"){
        $uploadFileType = 'text_file';
    }
    
    //get lable by media type
    switch($uploadFileType){
        case "text":
            $headingName  = $this->lang->line('writingNpublishing_headingName_2_'.$categoryId);
            $craveDetails = $this->lang->line('writingNpublishing_craveDetails_2_'.$categoryId);
            $infoDetails  = $this->lang->line('writingNpublishing_infoDetails_2_'.$categoryId);
        break;
        
        case "text_file":
            $headingName  = $this->lang->line('writingNpublishing_headingName_1_'.$categoryId);
            $craveDetails = $this->lang->line('writingNpublishing_craveDetails_1_'.$categoryId);
            $infoDetails  = $this->lang->line('writingNpublishing_infoDetails_1_'.$categoryId);
        break;
        
        default:
            $headingName  = $this->lang->line('writingNpublishing_headingName_1_'.$categoryId);
            $craveDetails = $this->lang->line('writingNpublishing_craveDetails_1_'.$categoryId);
            $infoDetails  = $this->lang->line('writingNpublishing_infoDetails_1_'.$categoryId);
    }

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
?>

<div class="row content_wrap" >
      
        <?php
            //---------load header navigation menu---------//
            $viewData = array(
                'headingName'   =>  $headingName,
                'navigation_1'  =>  $galleryPageLink,
                'navigation_2'  =>  $aboutPageLink,
                'navigation_3'  =>  $otherCollectionsLink,
                'activeMenu'    =>  'menu1',
                'categoryId'    =>  $this->config->item('WpCollectionCatId'),
                'genreName'    =>  $genreName,
            );
            $this->load->view('common_view/media_showcase_header_view',$viewData);
        ?>
       
       <div class="width930 m_auto  sc_album  display_table">
          <!--  left Content start  -->
          <div class="clearbox ">
             <div class="display_inline  Writing_img fl mr20  width342">
                <div class=" fl">
                   <span class="header_dark  box_siz lineH33   fs30  " >About the <?php echo $this->lang->line('writingNpublishing_media_type_'.$categoryId); ?>  <span class="fs15 pl20 pr20 "><?php echo $currentElementView; ?>/<?php echo $elementNumberCount; ?></span></span>
                    <div class=" position_relative writing_element mb20 fl"> 
                        <span class="table_cell"> 
                            <?php 
                                $thumbImage       =  addThumbFolder($elementImagePath,'_l',$thumbFolder);	
                                $showElementImage =  getImage($thumbImage,$imagetype_l);
                            ?>
                           <img src="<?php echo $showElementImage; ?>" alt="" /> 
                        </span> 
                    </div>
                </div>
                <span class="left_w  fl lineH18  mr pr60">
                   <div class="fl mt10 open_sans mb15">
                      <div class="clearb">
                         <p class="font_bold ">Collection Information</p>
                         <ul class="edit_list  ">
                            <!--<li>
                               <p class="red opens_light ">LANGUAGE</p>
                               <p>English</p>
                            </li>-->
                            <li>
                               <p class="red opens_light ">PUBLISHED ON TOADSQUARE</p>
                               <p><?php echo date("d F Y", strtotime($projReleaseDate)); ?></p>
                            </li>
                            
                             <?php if(!empty($selfClassfication)){ ?>
                               <li>
                                  <p class="red opens_light">SELF CLASSIFICATION</p>
                                  <p><?php echo $selfClassfication; ?></p>
                               </li>
                               <?php } ?>
                         </ul>
                      </div>
                      
                       <span class="text_alighC width100_per"	>
                          <span class="sap_30"></span>
                      
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
                      
                      <div class="sap_20"></div>
                        
                        <?php 
                            //---------associative creatives list start----------//
                                echo  Modules::run("creativeinvolved/associativecreativeslist", $elementEntityId,$elementId);
                            //---------associative creatives list start----------//
                        ?> 
                   
                   </div>
                </span>
             </div>
             <div class="rightbox fl width562 ">
                <div class="text_bx fs20 pb10 open_sans clr_666 lineH25 ">  <?php echo $title;?></div>
               
                <span class="bg_f3f3f3 bt_c2 mt30 bb_c2c2 mb25 p10 width100_per ">
                   <div class="fr head_list pr10 color_666">
                      <div class="icon_view3_blog icon_so"><?php echo $viewCount; ?></div>
                      <div class="icon_crave4_blog icon_so <?php echo $craveDivAction.' '.$cravedALL; ?>"><?php echo $craveCount;?></div>
                      <div class="rating fl pt6 <?php echo  $rateDivAction; ?>"> <img alt="" src="<?php echo ratingImagePath($ratingAvg);?>"> </div>
                      <div class="btn_share_icon icon_so"><?php echo $reviewCount; ?></div>
                   </div>
                   <div class="clearbox">
                      <div class=" mt10 mb15 "> 
                        <?php 
                            //element type "0" for main element
                            if($elementType==0){
                             
                                //-------project collection price--------//
                                $buttonArray = array('projectData'=>$projectData,'elementDataList'=>$elementDataList,'showview'=>'project'); 
                                $this->load->view('common_view/project_details_show_buttons',$buttonArray);
                                
                                //-------element collection price--------//
                                $elementButtonArray = array('elementId'=>$elementId,'projectData'=>$projectData,'elementDataList'=>$elementDataList,'showview'=>'project','mediaFileType'=>$mediaFileType); 
                                $this->load->view('common_view/project_element_details_show_buttons',$elementButtonArray);
                                
                            }
                        ?>
                        
                         <?php 
                        // if sample element exist then show 
                            if(!empty($sampleElementList) && $elementType==1){
                                $sampleElementList  =   $sampleElementList[0];
                                
                                $sampleElementId    =   $sampleElementList['elementId'];
                                $sampleProjId       =   $sampleElementList['projId'];
                                $sampleEntityId     =   $sampleElementList['entityId'];
                                $sampleFileId       =   $sampleElementList['fileId'];
                                $functionAction     =   "openLightBox('popupBoxWp','popup_box','/mediafrontend/samplemediafile',".$sampleFileId.",".$sampleEntityId.",".$sampleElementId.",".$sampleProjId.");";
                        ?>
                            
                             <button class="ml10" type="button" <?php echo $functionAction; ?> role="button"> View Extarct </button>
                        
                        <?php  } ?>
                        
                      <div class="clearb mt10">  <!--<span class="fr lineH23"><span class="red ">PUBLISHER</span> Self Published</span>--> </div>
                    </div>
                   </div>
                </span>
                <div class="fr">
                    <?php 
                        //-----------crave button load view-----------//
                        $creaveButtonTitle = 'Crave';
                        $showSocialData= array('buttonDesigntype'=>'1','buttonTitle'=>$creaveButtonTitle,'elementId'=>$elementId,'entityId'=>$elementEntityId,'ownerId'=>$frentendUserId,'projectType'=>$industryType,'isPublished'=>$isPublished,'furteherDetails'=>'{"projectId":"'.$projectId.'","table":"Project","primeryField":"projId","fieldSet":"projId as id,projBaseImgPath as craveImage, projName as craveTitle, projShortDesc as craveShortDescription, tagwords as tagwords","cacheFilePath":"'.$cacheFile.'"}');
                        echo Modules::run("craves/creavebutton",$showSocialData);
                        
                         //------------rating button module load view------------//
                        $ratingButtonData = array('elementId'=>$elementId,'entityId'=>$elementEntityId,'ratingAvg'=>$ratingAvg,'ratingClass'=>'width_auto ml5 Fleft','isPublished'=>$isPublished);
                        echo Modules::run("rating/ratingbutton",$ratingButtonData);
                      //$this->load->view('rating/rating_form_design',array('elementId'=>$elementId,'entityId'=>$entityId));
                      
                        //------------review button view load-------------//
                        $this->load->view('media/reviewViewNew',array('reviewdesign'=>'1','reviewProjectId'=>$projectId,'reviewElementId'=>$elementId,'reviewEntityId'=>$elementEntityId,'reviewIndustryId' =>'3','isPublished'=>$isPublished));
                         
                    ?>
                </div>
                <div class="sap_30"></div>
                <div class="cnt display_inline music_cnt ">
                    <?php
                        if(strlen(trim(@$elementData['description']))>2){ ?>
                                <div class="seprator_14"></div>
                                <div class="row pt18">
                                    <?php echo changeToUrl(nl2br($elementData['description']));?>
                                </div>
                            <?php		
                        }
                    ?> 
                </div>
                <div class=" position_relative fr">
                   <div class="sap_20"></div>
                   
                   
                   <div class="nav open_sans  width513 display_inline_block bt_ebeb  pt20  width100_per  text_alighC   ">
                       <?php if(!empty($previousPageLink)): ?> 
                            <a class=" fl lineH20 text_alighL " href="<?php echo $previousPageLink; ?>">
                            <i class="next_collection collection_nav"></i>
                            Previous <?php echo $this->lang->line('writingNpublishing_media_type_'.$categoryId); ?> </a> 
                       <?php else: ?>
                             <a class=" fl lineH20 text_alighL disable_link" href="javascript:void(0)">
                            <i class="next_collection collection_nav"></i>     
                            Previous <?php echo $this->lang->line('writingNpublishing_media_type_'.$categoryId); ?> </a> 
                       <?php endif; ?> 
                       
                        <span class="counter pt3">
                            <span class="current_slide"><?php echo $currentElementView; ?></span>/<span class="total_slide"></span><?php echo $elementNumberCount; ?>
                        </span> 
                        
                        <?php if(!empty($nextPageLink)): ?> 
                            <a class="  fr text_alignR lineH20" href="<?php echo $nextPageLink; ?>">
                           <span class="fl"> Next <?php echo $this->lang->line('writingNpublishing_media_type_'.$categoryId); ?></span>
                            <i class="prev_collection fr  collection_nav"></i>
                            </a>
                        <?php else: ?>
                             <a class="  fr text_alignR lineH20 disable_link" href="javascript:void(0)">
                                  <span class="fl">  Next <?php echo $this->lang->line('writingNpublishing_media_type_'.$categoryId); ?></span>
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
                            echo Modules::run("mediafrontend/getReviewListNew",$elementEntityId,$elementId);
                        //---------review list end-----------//
                    ?> 
                   
                </div>
             </div>
          </div>
       </div>
    </div>
          
