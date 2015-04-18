<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    //add preview word if preview mode is active
    $previewWord =  (previewModeActive())?"/preview":"";

    //get user info for seller currency and currency sign
    if(!isset($userInfo)){
        $userInfo = showCaseUserDetails($frentendUserId);
    }
    
    
    //get seller currency data    
    $sellerCurrency    =   $userInfo['seller_currency'];
    $sellerCurrency    =   (!empty($sellerCurrency) && $sellerCurrency>0)?$sellerCurrency:0;
    $currencySign      =   $this->config->item('currency'.$sellerCurrency);

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
        $previousPageLink       =     'mediafrontend/mediagallery/'.$frentendUserId.'/'.$projectId.'/'.$previousElementId.$previewWord;
        $previousPageLink       =     base_url_lang($previousPageLink);
    endif;
    
    //previous element show page link id get
    if($currentKeyPosition < ($elementNumberCount-1)):
        $nextElementId      =    $elementPrepareList[$currentKeyPosition+1];
        $nextPageLink       =    'mediafrontend/mediagallery/'.$frentendUserId.'/'.$projectId.'/'.$nextElementId.$previewWord;
        $nextPageLink       =     base_url_lang($nextPageLink);
    endif;
    
    
    //--------element require default data--------//
    $imagetype_b            =   $fileConfig['defaultImage_b'];
    $imagetype_m            =   $fileConfig['defaultImage_m'];
    $imagetype_l            =   $fileConfig['defaultImage_l'];
    $imagetype_xs           =   $fileConfig['defaultImage_xs'];
    $imagetype_s            =   $fileConfig['defaultImage_s'];
   
    //---------preprae project details data----------//
    $projSellstatus         =   $projectData['projSellstatus']=='t'?true:false;
    $videoFileCount         =   (!empty($projectData['videoFileCount']))?$projectData['videoFileCount']:'0'; 
    $dvdCount               =   (!empty($projectData['dvdCount']))?$projectData['dvdCount']:'0'; 
    $projName               =   (!empty($projectData['projName']))?$projectData['projName']:''; 
    

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
    $craveCount             =    (!empty($elementData['craveCount']))?$elementData['craveCount']:'0'; 
    $viewCount              =    (!empty($elementData['viewCount']))?$elementData['viewCount']:'0'; 
    $ratingAvg              =    (!empty($elementData['ratingAvg']))?$elementData['ratingAvg']:'0'; 
    $reviewCount            =    (!empty($elementData['reviewCount']))?$elementData['reviewCount']:'0'; 
    $elementType            =    (!empty($elementData['elementType']))?$elementData['elementType']:''; 
    $isPrice                =    (!empty($elementData['isPrice']))?$elementData['isPrice']:''; 
    $isPublished            =    $elementData['isPublished']; 
    $categoryId             =   (!empty($elementData['catId']))?$elementData['catId']:'1';
    $mediaFileType          =    $this->config->item('media_type_video'); // set default media type for video
    
    
    $downloadPrice           =    (!empty($elementData['downloadPrice']))?$elementData['downloadPrice']:''; 
    $perViewPrice            =    (!empty($elementData['perViewPrice']))?$elementData['perViewPrice']:''; 
    $price                   =    (!empty($elementData['price']))?$elementData['price']:''; 
    $isDownloadPrice         =    (!empty($elementData['isDownloadPrice']))?$elementData['isDownloadPrice']:''; 
    $isPerViewPrice          =    (!empty($elementData['isPerViewPrice']))?$elementData['isPerViewPrice']:''; 
    $isPrice                 =    (!empty($elementData['isPrice']))?$elementData['isPrice']:''; 
    
    $jobStsatus                 =    (!empty($elementData['jobStsatus']))?$elementData['jobStsatus']:''; 
    
    $elementPriceShow = false;
    if($isDownloadPrice=="t"){
        $elementPriceShow =  $downloadPrice;
    }elseif($isPerViewPrice=="t"){
        $elementPriceShow =  $perViewPrice;
    }elseif($isPrice=="t"){
        $elementPriceShow =  $price;
    }
    
    
    if(!empty($elementPriceShow)){
        $priceDetails = getDisplayPrice($elementPriceShow,$sellerCurrency);
        $currencySign = $priceDetails['currencySign'];
        $displayPrice = $priceDetails['displayPrice'];
        $elementPriceShow =  $priceDetails['currencySign'].' '.$priceDetails['displayPrice'];
    }
     
     
    
     
    $dirSize                =   bytestoMB($fileSize);
    //$previeLink             =   'media/'.$constant['project_preview'].'/'.$project['projectid'];
    
    
    //print_r($elementData);
    
    
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
    $aboutPageLink          =     'mediafrontend/mediashowcases/'.$frentendUserId.'/'.$projectId.$previewWord;
    $aboutPageLink          =      base_url_lang($aboutPageLink);
    
    $galleryPageLink        =     'mediafrontend/mediagallery/'.$frentendUserId.'/'.$projectId.$previewWord;
    $galleryPageLink        =      base_url_lang($galleryPageLink);
    
    $moreAboutVideLink      =     'mediafrontend/mediadetails/'.$frentendUserId.'/'.$projectId.'/'.$elementId.$previewWord;
    $moreAboutVideLink      =     base_url_lang($moreAboutVideLink);
    
    $otherCollectionsLink      =    'showproject/othercollections/'.$frentendUserId.'/filmNvideo'.$previewWord;
    $otherCollectionsLink      =     base_url_lang($otherCollectionsLink);
    
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
    
    //get media file type
    $elementMediaType  = ($isPrice=="t")?"DVD":"Video";
    
    $videoFileMode = "";
    if($elementType==1){
        $videoFileMode = "SAMPLE";
    }elseif($elementType==2){
        $videoFileMode = "TRAILER";
    }
    
?>

   <div class="banner_collection gallery_banner " >
      <!--==================  full screen slider  start ============-->
      <div class="width900 display_table m_auto pb15">
         <h2  class="lineH14 bb_ececec pb10"><?php echo $projName;?> </h2>
          <!--<a href="<?php //echo $aboutPageLink; ?>" class="btn_review mt20 fs14 lineH18  " href="">More about this Collection</a>-->
          <span class="sap_20"></span>
         <hr class=" width100_per clearb"  />
      </div>
      <!--==================  banner start ============-->
      <div class=" bg_444 display_table">
         <div class="display_table height67 width900 m_auto ">
            <?php if($elementType==1 || $elementType==2){ ?> 
                <a class=" org_header clr_fff fs22 opens_light"  ><?php echo $videoFileMode; ?></a>
            <?php }else{ ?>
                <h2 class="lineH15 color_999 opens_light fs16 fl mt28  pb10"><?php echo  $title; ?> </h2>
            <?php } ?>
            <a class="btn_review mt28 fs16 color_999 lineH18 " href="<?php echo $moreAboutVideLink; ?>"><?php echo $this->lang->line('filmNvideo_more_about_this_1'); ?> <?php echo $elementMediaType; ?></a>
         </div>
         <div id="slider" class="flexslider vedio_gall">
            <div class="display_table heigt566 width100_per m_auto">
               <div class="table_cell collection_banner">
                     <?php
                        if($elementType=='1' || $elementType=='2' || $projSellstatus==false){
                        /*************Here check exnternal and interter media**************/ 
                            //get media file type 
                            $getType = getDataFromTabel('MediaFile','fileType,isExternal,filePath', 'fileId', $mediaId, 'fileId', 'ASC',1,0,true);
                            
                            if($getType && $getType[0]['isExternal']=="t") {
                                //get external video src 
                                $src            =   getExternalMediaSrc($getType[0]['filePath'],$mediaId,$elementEntityId,$elementId,$projectId);
                                $getSrc         =   $src[0];
                                $isvalidUrl     =   ($src[1] && !empty($src[0]))?true:false; 
                                    
                            }else {
                                // This code will be play uploaded mp4 video
                                $getSrc = base_url().'en/player/getMainPlayerIframe/'.$mediaId.'_full/'.$elementEntityId.'/'.$elementId.'/'.$projectId;
                                $isvalidUrl=true;
                            }   
                            
                            if($isvalidUrl)   {    ?> 
                                <iframe src="<?php echo $getSrc; ?>" width="100%" height="100%" frameborder="0"  webkitAllowFullScreen mozallowfullscreen allowFullScreen scrolling="no"></iframe>
                                <?php } else { 
                                    $elementImage   =    $elementImagePath;	
                                    $imagetype      =    $this->config->item('filmNvideoImage_m');
                                    $thumbImage     =    addThumbFolder($elementImage,'_m');
                                    $elementImage   =    getImage($thumbImage,$imagetype);
                                ?>
                                    <p class="tac f16 pb5 white"><?php echo $this->lang->line('This_work_is_hosted_on_another_site'); ?> <a class="white underline hoverOrange" href="<?php echo $getSrc; ?>"><?php echo $this->lang->line('Click_here_to_view_the_url'); ?></a></p>
                                    <img src="<?php echo $elementImage; ?>"  class="max_w408_h305"/>
                        <?php   } 
                                
                            }else{ 
                                
                                //padi video image here 
                            
                                if(empty($elementImagePath)){	
                                    $thumbImage = getVideoThumbFolder($filePath.$fileName,'_xxl');	
                                    $showElementImage=getImage($thumbImage,$imagetype_b);	
                                }else{
                                    $thumbImage      = addThumbFolder($elementImagePath,'_xxl');	
                                    $showElementImage=getImage($thumbImage,$imagetype_b);
                                }
                                
                                 if($jobStsatus!="DONE"){
                                    $showElementImage = $imgPath.'error_1.jpg';
                                }
                                
                            ?>
                                 <img src="<?php echo $showElementImage; ?>"  alt=""/>
                        <?php } ?>
                    
                  <div class="play_btn_vedio"><span class=" whitespace_now   pt10 pr15"> 
                      
                        <?php
                            if(!empty($elementPriceShow) && $jobStsatus=="DONE"){
                                echo $elementPriceShow; 
                            }   
                        ?>
                      
                      </span></div>
               </div>
            </div>
            <ul class="flex-direction-nav">
              <?php if(!empty($previousPageLink)): ?> 
                    <li>
                        <a class="flex-prev video_element_view" href="javascript:void(0)" url="<?php echo $previousPageLink; ?>"><?php echo $this->lang->line('m_previous_button'); ?></a>
                    </li>
                <?php endif; ?> 
                <?php if(!empty($nextPageLink)): ?> 
                    <li>
                        <a class="flex-next video_element_view" href="javascript:void(0)" url="<?php echo $nextPageLink; ?>"><?php echo $this->lang->line('m_next_button'); ?></a>
                    </li>
                <?php endif; ?>
            </ul>
         </div>
         <div class="width_890 pt23 pb20 display_table m_auto">
            <div class="fl ps_1 color_999 fs14 mt5">
               <div class="icon_view3_blog icon_so"><?php echo  $viewCount; ?></div>
               <div class="icon_crave4_blog icon_so <?php echo  $craveDivAction.' '.$cravedALL;?>"><?php echo  $craveCount; ?></div>
               <div class="rating fl pt6 <?php echo $rateDivAction; ?>"> <img src="<?php echo ratingImagePath($ratingAvg);?>" alt=""> </div>
               <div class="btn_share_icon icon_so"><?php echo $reviewCount; ?></div>
            </div>
            <div class="fr pr10"> 
              <?php 
                    //-------load module of social listing share---------------//
                    $shareData=array('url'=>$currentShortUrl,'isPublished'=>$isPublished,'designType'=>'2');
                    echo Modules::run("share/sharesocialshowview",$shareData);	
                ?> 
               
               <span class="color_999 fl pl15 opensans_semi  number_slide"><?php echo $currentElementView; ?>/<?php echo $elementNumberCount; ?></span> 
            </div>
         </div>
      </div>
      <!--==================  banner end ============--> 
   </div>
   <div class="width900 pb20 display_table m_auto">
      
       <?php if(!empty($trailerSampleElementList)){ 
        $videoCount = 1;
        $totalVideoCount = count($trailerSampleElementList);
        foreach($trailerSampleElementList as $element){
            
            
            $getElementType = $element['elementType'];
            $titleShow = $element['title'];
            $elementTypeTitle = ($getElementType==1)?"SAMPLE VIDEO":'TRAILER';
            $elementTypeClass = ($getElementType==1)?"sample_thumb":'trailer_thumb';
            $elementTypeImgClass = ($getElementType==1)?"max_w_228_h152_sample":'max_w_269_h152_trailer';
            
            if(empty($element['imagePath'])){	
                $thumbImage = getVideoThumbFolder(@$element['filePath'].$element['fileName'],'_m');	
                $elementImage=getImage($thumbImage,$imagetype_m);	
            }else{
                $thumbImage = addThumbFolder(@$element['imagePath'],'_m');	
                $elementImage=getImage($thumbImage,$imagetype_m);
            }
            
            $elementUrl=base_url(lang().$urlUsername.'/mediafrontend/mediagallery/'.$frentendUserId.'/'.$projectId.'/'.$element['elementId'].$previewWord);
        ?>
          
              <span  class="position_relative ptr bdr_c3c3c3 <?php echo $elementTypeClass; ?>  display_table  fl <?php echo ($videoCount>1)?'ml18':''; ?> ">
                <span class="table_cell"><span class="black_title topauto  org_light fs14 font_bold" href=""><?php echo $elementTypeTitle; ?></span>
                    <img class="<?php echo $elementTypeImgClass; ?>" alt="image" src="<?php echo $elementImage; ?>">
               
                    <div class="thum_text box_onbanner">
                        <div class="pl15 pt10 pb10 opensans_semi"><span class=""><?php echo $videoCount; ?></span>/<span class="total-slides"><?php echo $totalVideoCount; ?></span></div>
                        <span class="title"><?php echo $titleShow; ?></span>
                        <div class="sap_20"></div>
                        <a href="javascript:void(0)" url="<?php echo $elementUrl; ?>" class="fshel_light video_element_view"><span>MORE ABOUT THIS VIDEO</span></a> 
                        <div class="play_btn_vedio"><img src="<?php echo base_url('templates/new_version/images'); ?>/play_btn_Gsmall.png" alt=""></div>
                    </div>
                
                </span>
                
                
                
              </span>
         
          
      <?php  $videoCount++;   }   } ?>
     
      
      <div class="fr mr-17 open_sans width385">
         <div class="fl ">
            <div class="fl "> <span class="lettsp-1 opensans_semi pb15">Collection Contents</span> <br>
                <?php if($videoFileCount > 0){ ?>
                    <span> <b class="red pr7"><?php echo $videoFileCount; ?></b>Video Files </span> 
                <?php } ?>
                <?php if($dvdCount > 0){ ?>
                    <span class="pl10"> <b class="red pr7"><?php echo $dvdCount; ?></b>DVDs </span> 
                <?php } ?>
            </div>
            <div class="sap_15"></div>
            <div class="fl head_list pr10 color_666">
               <div class="icon_view3_blog icon_so ml0"><?php echo  $viewCount; ?></div>
               <div class="icon_crave4_blog icon_so <?php echo  $craveDivAction.' '.$cravedALL;?>"><?php echo  $craveCount; ?></div>
               <div class="rating fl pt6 <?php echo $rateDivAction; ?>">
                  <img alt="" src="<?php echo ratingImagePath($ratingAvg);?>">
               </div>
               <div class="btn_share_icon icon_so"><?php echo $reviewCount; ?></div>
            </div>
         </div>
         <div class="fr elementbutton">
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
