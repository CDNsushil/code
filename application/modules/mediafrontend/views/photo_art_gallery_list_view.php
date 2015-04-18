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
        $previousPageLink       =     'mediafrontend/photoartgallery/'.$frentendUserId.'/'.$projectId.'/'.$previousElementId.$previewWord;
        $previousPageLink       =     base_url_lang($previousPageLink);
    endif;
    
    //previous element show page link id get
    if($currentKeyPosition < ($elementNumberCount-1)):
        $nextElementId      =    $elementPrepareList[$currentKeyPosition+1];
        $nextPageLink       =    'mediafrontend/photoartgallery/'.$frentendUserId.'/'.$projectId.'/'.$nextElementId.$previewWord;
        $nextPageLink       =     base_url_lang($nextPageLink);
    endif;
    
    //--------element require default data--------//
    $imagetype_b            =   $fileConfig['defaultImage_b'];
    $imagetype_m            =   $fileConfig['defaultImage_m'];
    $imagetype_l            =   $fileConfig['defaultImage_l'];
    $imagetype_xxl          =   $fileConfig['defaultImage_xxl'];
    $imagetype_xs           =   $fileConfig['defaultImage_xs'];
    $imagetype_s            =   $fileConfig['defaultImage_s'];
   
    //---------preprae project details data----------//
    $projSellstatus         =   $projectData['projSellstatus']=='t'?true:false;
    $projName                    =   (!empty($projectData['projName']))?$projectData['projName']:'';
    $projCraveCount              =   (!empty($projectData['craveCount']))?$projectData['craveCount']:'';
    $projViewCount               =   (!empty($projectData['viewCount']))?$projectData['viewCount']:'';
    $projRatingAvg               =   (!empty($projectData['ratingAvg']))?$projectData['ratingAvg']:'';
    $projReviewCount             =   (!empty($projectData['reviewCount']))?$projectData['reviewCount']:'';
    $imageFileCount              =   (!empty($projectData['imageFileCount']))?$projectData['imageFileCount']:'';
    $printCount                  =   (!empty($projectData['printCount']))?$projectData['printCount']:'';

    //project action variable
    $projRateDivAction              =   'rateDiv'.$entityId.''.$projectId;
    $projCraveDivAction                 =   'craveDiv'.$entityId.''.$projectId;
    
    //------get user craved data ------//
    $projCravedALL='';
    if(!empty($loggedUserId)){
        $where          =   array(
            'tdsUid'        =>  $loggedUserId,
            'entityId'      =>  $entityId,
            'elementId'     =>  $projectId
        );
        $countResult        =   countResult('LogCrave',$where);
        $projCravedALL      =   ($countResult>0)?'cravedALL':'';
    }
    
    //------prepare the element details data---------//
    $mediaId                =   (!empty($elementData['fileId']))?$elementData['fileId']:'0';  
    //$elementId              =   (!empty($elementData['elementId']))?$elementData['elementId']:'0'; 
    //$projectId              =   (!empty($elementData['projId']))?$elementData['projId']:$elementData['projId']; 
    $title                  =   (!empty($elementData['title']))?$elementData['title']:''; 
    $elementImagePath       =   (!empty($elementData['imagePath']))?$elementData['imagePath']:''; 
    $fileName               =   (!empty($elementData['fileName']))?$elementData['fileName']:''; 
    $filePath               =   (!empty($elementData['filePath']))?$elementData['filePath']:''; 
    $fileSize               =   (!empty($elementData['fileSize']))?$elementData['fileSize']:''; 
    $isExternal             =   (!empty($elementData['isExternal']))?$elementData['isExternal']:'f'; 
    $price                  =   (!empty($elementData['price']))?$elementData['price']:''; 
    $downloadPrice          =   (!empty($elementData['downloadPrice']))?$elementData['downloadPrice']:''; 
    $genreName              =   (!empty($elementData['genrename']))?$elementData['genrename']:''; 
    $projGenreFree          =   (!empty($elementData['projGenreFree']))?$elementData['projGenreFree']:''; 
    $projReleaseDate        =   (!empty($elementData['projReleaseDate']))?$elementData['projReleaseDate']:''; 
    $countryName            =   (!empty($elementData['countryName']))?$elementData['countryName']:''; 
    $eleCraveCount          =    (!empty($elementData['craveCount']))?$elementData['craveCount']:'0'; 
    $eleViewCount           =    (!empty($elementData['viewCount']))?$elementData['viewCount']:'0'; 
    $eleRatingAvg           =    (!empty($elementData['ratingAvg']))?$elementData['ratingAvg']:'0'; 
    $eleReviewCoun          =    (!empty($elementData['reviewCount']))?$elementData['reviewCount']:'0'; 
    $elementType            =    (!empty($elementData['elementType']))?$elementData['elementType']:''; 
    $isPrice                =    (!empty($elementData['isPrice']))?$elementData['isPrice']:''; 
    $isPublished            =    $elementData['isPublished']; 
    $categoryId             =    (!empty($elementData['catId']))?$elementData['catId']:'1';
    $isPrice                =    (!empty($elementData['isPrice']))?$elementData['isPrice']:'f'; 
    $isPerViewPrice         =    (!empty($elementData['isPerViewPrice']))?$elementData['isPerViewPrice']:'f'; 
    $isDownloadPrice        =    (!empty($elementData['isDownloadPrice']))?$elementData['isDownloadPrice']:'f'; 
    $mediaFileType          =    $this->config->item('media_type_image'); // set default media type for image
    
   
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
    
    //--------prepare the element thumb image--------//    
    $thumbImage          =  addThumbFolder($elementData['imagePath'],'_b');
    $elementImage        =  getImage($thumbImage,$imagetype);

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
    
    $moreAboutVideLink      =     'mediafrontend/photoartelement/'.$frentendUserId.'/'.$projectId.'/'.$elementId.$previewWord;
    $moreAboutVideLink      =     base_url_lang($moreAboutVideLink);
    
    //------create share link by current url-------//
    $currentShortUrl = uri_string();
    
     //------------element list data prepare--------------//
    $trailerSampleElementList = false;
    $allowElementType = array('1','2'); // for trailer and sample
    $elementCount = 0;
    if(!empty($elementDataList)){
        foreach($elementDataList as $elementData){
            if(in_array($elementData['elementType'], $allowElementType)){
                $trailerSampleElementList[] = $elementData;
            }else{
                $elementCount++;
            }
        }
    }
    
     //get media file type for show details
    $uploadFileType = 'image_file';
    if($isPrice=="t"){
        $uploadFileType = 'print';
    }elseif($isDownloadPrice=="t"){
        $uploadFileType = 'image_file';
    }elseif($isPerViewPrice=="t"){
        $uploadFileType = 'image_file';
    }
    
    //get lable by media type
    switch($uploadFileType){
        case "print":
            $elementFileType = $this->lang->line('photographyNart_element_type_1_'.$categoryId);
        break;
        
        case "media_file":
            $elementFileType = $this->lang->line('photographyNart_element_type_2_'.$categoryId);
        break;
        
        default:
            $elementFileType = $this->lang->line('photographyNart_element_type_2_'.$categoryId);
    }
?>

          
            <div  class="zoom_wrap">
                <div class="wrap_tab">
                   <div class="new_wrap clearb hideshowfullscreen">
                      <div class="sap_15"></div>
                      <div class="width900 display_table m_auto pb15">
                         <h2 class="lineH22 fs26 opens_light bb_ececec pb10"><?php echo $projName; ?></h2>
                         <span class="sap_20"></span>
                      </div>
                   </div>
                  
                   <div id="slider" class="flexslider position_relative">
                      <div class="full_wrap"> 
                        <a href="javascript:void(0)" class="requestfullscreen fs-button" ></a>
                        <a href="javascript:void(0)" class="exitfullscreen fs-button" style="display: none"></a> </div>
                      <ul class="slides">
                         <li>
                             <?php 
                                $thumbImage      = addThumbFolder($filePath.$fileName,'_xxl',$thumbFolder);	
                                $showElementImage=getImage($thumbImage,$imagetype_xxl);
                            ?>
                             
                            <img src="<?php echo $showElementImage; ?>"  alt=""/>
                            <div class="slide-text box_onbanner">
                               <h2 class="text_alighL fl  opens_light "><?php echo $title;?> </h2>
                            </div>
                         </li>
                      </ul>
                      <ul class="flex-direction-nav">
                        <?php if(!empty($previousPageLink)): ?> 
                            <li>
                                <a class="flex-prev flex-disabled photo_element_view" href="javascript:void(0)" url="<?php echo $previousPageLink; ?>" >Previous</a>
                            </li>
                         <?php endif; ?> 
                        <?php if(!empty($nextPageLink)): ?>  
                            <li>
                                <a class="flex-next flex-disabled photo_element_view" href="javascript:void(0)"   url="<?php echo $nextPageLink; ?>" >Next</a>
                            </li>
                        <?php endif; ?>
                      </ul>
                      <div class="social_wrap fr box_onbanner "> 
                         <a class="btn_review fs16  mr5" href="<?php echo $moreAboutVideLink; ?>"> More about this Photo</a>
                      </div>
                   </div>
                </div>
             </div>
             <div class=" pt30 pb30 clearbox">
            <div class="width900   display_table m_auto">
               <div class="fl width428">
                  <span class="color_999 fl pl12 opensans_semi  number_slide"><?php echo $currentElementView; ?>/<?php echo $elementNumberCount; ?></span>   
                  <div class="sap_20"></div>
                  <div class="fl ps_1 pl8 color_999 fs14 ">
                     <div class="icon_view3_blog icon_so"><?php echo $eleViewCount; ?></div>
                     <div class="icon_crave4_blog icon_so <?php echo  $craveDivAction.' '.$cravedALL;?>"><?php echo  $eleCraveCount; ?></div>
                     <div class="rating fl pt6 <?php echo $rateDivAction; ?>"> <img src="<?php echo ratingImagePath($eleRatingAvg);?>" alt=""> </div>
                     <div class="btn_share_icon icon_so"><?php echo $eleReviewCount; ?></div>
                  </div>
                  <div class="sap_20"></div>
                  <div class="fl pr10"> <span class="fl soc_1 pr10">
                      
                    <?php 
                         //-----short module link by email module array-----//
                        $shortlinkEmailData=array('url'=>$currentShortUrl,'isPublished'=>$isPublished,'designType'=>'3');
                        echo Modules::run("share/shareemailbutton",$shortlinkEmailData);								
                    
                        //-----load module shortlink module array-----//
                        $shortlinkData=array('url'=>$currentShortUrl,'isPublished'=>$isPublished,'designType'=>'2');
                        echo Modules::run("shortlink/shortlinkfrontbuttonnew",$shortlinkData);	
                        
                        
                        //-------load module of social share---------------//
                        $shareData=array('url'=>$currentShortUrl,'isPublished'=>$isPublished,'designType'=>'6');
                        echo Modules::run("share/sharesocialshowview",$shareData);	
                    ?>
                    </span>  
                  </div>
               </div>
               <div class="fr open_sans width410 pl30 bl_dfdf">
                  <div class="fl ">
                     <div class="fl ">
                        <span class="lettsp-1 opensans_semi ">Collection Contents</span> 
                        <div class="sap_20"></div>
                        
                        <?php if($imageFileCount > 0){ ?>
                            <span> <b class="red pr7"><?php echo $imageFileCount; ?></b>Image Files </span> 
                        <?php } ?>
                        <?php if($printCount > 0){ ?>
                            <span class="pl10"> <b class="red pr7"><?php echo $printCount; ?></b>Prints </span> 
                        <?php } ?>
                        
                     </div>
                     <div class="sap_20"></div>
                     <div class="fl head_list pr10 color_666">
                        <div class="icon_view3_blog icon_so"><?php echo $projViewCount; ?></div>
                        <div class="icon_crave4_blog icon_so <?php echo $projCraveDivAction.' '.$projCravedALL; ?>"><?php echo $projCraveCount;?></div>
                        <div class="rating fl pt6 <?php echo  $projRateDivAction; ?>">
                           <img alt="" src="<?php echo ratingImagePath($projRatingAvg);?>">
                        </div>
                        <div class="btn_share_icon icon_so"><?php echo $projReviewCount; ?></div>
                     </div>
                  </div>
                  <div class="fr elementbutton width196">
                        <?php 
                            //element type "0" for main element
                            if($elementType==0){
                             
                                //-------project collection price--------//
                                $buttonArray = array('projectData'=>$projectData,'elementDataList'=>$elementDataList,'showview'=>'projectelement'); 
                                $this->load->view('common_view/project_details_show_buttons',$buttonArray);
                                
                                //-------element collection price--------//
                                $elementButtonArray = array('elementId'=>$elementId,'projectData'=>$projectData,'elementDataList'=>$elementDataList,'showview'=>'projectelement','mediaFileType'=>$mediaFileType); 
                                $this->load->view('common_view/project_element_details_show_buttons',$elementButtonArray);
                            }
                        ?>
                  </div>
               </div>
            </div>
         </div>
    
       
         
<script type="text/javascript" >
    radioCheckboxRender();
</script>  
