<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

  //------check project data and convert to single diemential array------//
    if(!empty($projectData)):
        $projectData = $projectData[0];
    endif;

    //------check project element data and convert to single diemential array------//
    $elementData         =   false;
    $elementPrepareList  =   false;
    $currentKeyPosition  =   0;
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
        $previousPageLink       =     'mediafrontend/mediagallery/'.$frentendUserId.'/'.$projectId.'/'.$previousElementId;
        $previousPageLink       =     base_url_lang($previousPageLink);
    endif;
    
    //previous element show page link id get
    if($currentKeyPosition < ($elementNumberCount-1)):
        $nextElementId      =    $elementPrepareList[$currentKeyPosition+1];
        $nextPageLink       =    'mediafrontend/mediagallery/'.$frentendUserId.'/'.$projectId.'/'.$nextElementId;
        $nextPageLink       =     base_url_lang($nextPageLink);
    endif;
    
    
    //--------element require default data--------//
    $imagetype              =   $fileConfig['defaultImage_b'];
    $imagetype_m            =   $fileConfig['defaultImage_m'];
    $imagetype_xs           =   $fileConfig['defaultImage_xs'];
    $imagetype_s            =   $fileConfig['defaultImage_s'];
   
    //---------preprae project details data----------//
    $projSellstatus         =   $projectData['projSellstatus']=='t'?true:false;

    
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
    $isPublished            =    $elementData['isPublished']; 
    
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
    $aboutPageLink          =     'mediafrontend/mediashowcases/'.$frentendUserId.'/'.$projectId;
    $aboutPageLink          =      base_url_lang($aboutPageLink);
    
    $galleryPageLink        =     'mediafrontend/mediagallery/'.$frentendUserId.'/'.$projectId;
    $galleryPageLink        =      base_url_lang($galleryPageLink);
    
    $moreAboutVideLink      =     'mediafrontend/mediadetails/'.$frentendUserId.'/'.$projectId.'/'.$elementId;
    $moreAboutVideLink      =     base_url_lang($moreAboutVideLink);
    
    $otherCollectionsLink      =    'showproject/othercollections/'.$frentendUserId;
    $otherCollectionsLink      =     base_url_lang($otherCollectionsLink);
    
    //------create share link by current url-------//
    $currentShortUrl = uri_string();
    
     //------------element list data prepare--------------//
    $trailerSampleElementList = false;
    $allowElementType = array('1','2'); // for trailer and sample
    if(!empty($elementDataList)){
        foreach($elementDataList as $elementData){
            if(in_array($elementData['elementType'], $allowElementType)){
                $trailerSampleElementList[] = $elementData;
            }
        }
    }
?>
<div class="row content_wrap" >
    
    <?php
        //---------load header navigation menu---------//
        $viewData = array('navigation_1'=> $galleryPageLink,'navigation_2'=> $aboutPageLink,'navigation_3'=> $otherCollectionsLink,'activeMenu'=>'video_gallery');
        $this->load->view('common_view/media_showcase_header_view',$viewData);
    ?>
    
   <div class="banner_collection gallery_banner " >
      <!--==================  full screen slider  start ============-->
      <div class="width900 display_table m_auto pb30">
         <h2  class=" lineH19 fl"><?php echo $title;?> </h2>
         <div class="fr ps_1 fs14 mt-12">
            <div class="icon_view3_blog icon_so "><?php echo  $viewCount; ?></div>
            <div class="icon_crave4_blog icon_so <?php echo  $craveDivAction.' '.$cravedALL;?>"><?php echo  $craveCount; ?></div>
            <div class="rating fl pt6 <?php echo $rateDivAction; ?>">
               <img src="<?php echo ratingImagePath($ratingAvg);?>" alt="" />
            </div>
            <div class="btn_share_icon icon_so"><?php echo $reviewCount; ?></div>
         </div>
      </div>
      <!--==================  banner start ============-->
      <div class=" bg_444 display_table">
         <div class="width_890 pt25 pb15 display_table m_auto">
            <div class="fr pr10">
                
                <?php 
                    //-------load module of social listing share---------------//
                    $shareData=array('url'=>$currentShortUrl,'isPublished'=>$isPublished,'designType'=>'2');
                    echo Modules::run("share/sharesocialshowview",$shareData);	
                ?>
             
               <span class="clr_fff fl pl15 lineH26"><?php echo $currentElementView; ?>/<?php echo $elementNumberCount; ?></span>
            </div>
         </div>
         <div id="slider" class="flexslider">
            <div class="display_table width900 m_auto">
               <div class="table_cell" style="border:1px solid #fff"> 
                   
                     <?php
                        /*************Here check exnternal and interter media**************/ 
                            //get media file type 
                            $getType = getDataFromTabel('MediaFile','fileType,isExternal,filePath', 'fileId', $mediaId, 'fileId', 'ASC',1,0,true);
                            
                            if($getType && $getType[0]['isExternal']=="t") {
                                //get external video src 
                                $src            =   getExternalMediaSrc($getType[0]['filePath'],$mediaId,$elementEntityId,$elementId,$projectId);
                                $getSrc         =   $src[0];
                                $isvalidUrl     =   ($src[1])?true:false; 
                                    
                            }else {
                                // This code will be play uploaded mp4 video
                                $getSrc = base_url().'en/player/getMainPlayerIframe/'.$mediaId.'_full/'.$elementEntityId.'/'.$elementId.'/'.$projectId;
                                $isvalidUrl=true;
                            }   
                            
                            if($isvalidUrl)   {    ?> 
                                <iframe src="<?php echo $getSrc; ?>" width="895" height="500" frameborder="0"  webkitAllowFullScreen mozallowfullscreen allowFullScreen scrolling="no"></iframe>
                                <?php } else { 
                                    $elementImage   =    $elementImagePath;	
                                    $imagetype      =    $this->config->item('filmNvideoImage_m');
                                    $thumbImage     =    addThumbFolder($elementImage,'_m');
                                    $elementImage   =    getImage($thumbImage,$imagetype);
                                ?>
                                    <p class="tac f16 pb5 white"><?php echo $this->lang->line('This_work_is_hosted_on_another_site'); ?> <a class="white underline hoverOrange" target="_blank" href="<?php echo $getSrc; ?>"><?php echo $this->lang->line('Click_here_to_view_the_url'); ?></a></p>
                                    <img src="<?php echo $elementImage; ?>"  class="max_w408_h305"/>
                        <?php   }   ?> 
                    
                    
                    
                     </div>
            </div>
            <ul class="flex-direction-nav">
               <?php if(!empty($previousPageLink)): ?> 
                    <li>
                        <a class="flex-prev" href="<?php echo $previousPageLink; ?>">Previous</a>
                    </li>
                <?php endif; ?> 
                <?php if(!empty($nextPageLink)): ?> 
                    <li>
                        <a class="flex-next" href="<?php echo $nextPageLink; ?>">Next</a>
                    </li>
                <?php endif; ?>
            </ul>
         </div>
         <div class="width900 pt30 pb20 display_table m_auto">
            
            <?php if(!empty($trailerSampleElementList)){ 
                $videoCount = 1;
                foreach($trailerSampleElementList as $element){
                    
                    $getElementType = $element['elementType'];
                    $elementTypeTitle = ($getElementType==1)?"SAMPLE VIDEO":'TRAILER';
                    
                    if(empty($element['imagePath'])){	
                        $thumbImage = getVideoThumbFolder(@$element['filePath'].$element['fileName'],'_m');	
                        $elementImage=getImage($thumbImage,$imagetype_m);	
                    }else{
                        $thumbImage = addThumbFolder(@$element['imagePath'],'_m');	
                        $elementImage=getImage($thumbImage,$imagetype_m);
                    }
                    
                    $elementUrl=base_url(lang().$urlUsername.'/mediafrontend/mediagallery/'.$frentendUserId.'/'.$projectId.'/'.$element['elementId']);
            ?>
                <a href="<?php echo $elementUrl; ?>">
                     <div class="position_relative text_alighC traler_wrap ptr bdr_c3c3c3 fl <?php echo ($videoCount > 1)?'ml18':''; ?>" >
                        <span class="table_cell">
                            <span class="black_title"><?php echo $elementTypeTitle; ?></span> 
                            <img src="<?php echo $elementImage; ?>" alt=""  />
                        </span>
                    </div>
                </a>
            
            <?php  $videoCount++;   }   } ?>
            
            <div class="fr clr_d6d6">
               <a class="btn_review fs16 clr_d6d6 lineH18 " href="<?php echo $moreAboutVideLink; ?>">More About this Video</a>
               <div class="sap_65 mb10"></div>
                    <div class="fr">
                        <?php 
                            //element type "0" for main element
                            if($elementType==0){
                             
                                //-------project collection price--------//
                                $buttonArray = array('projectData'=>$projectData,'elementDataList'=>$elementDataList,'showview'=>'projectelement'); 
                                $this->load->view('common_view/project_details_show_buttons',$buttonArray);
                                
                                //-------element collection price--------//
                                $elementButtonArray = array('elementId'=>$elementId,'projectData'=>$projectData,'elementDataList'=>$elementDataList,'showview'=>'projectelement'); 
                                $this->load->view('common_view/project_element_details_show_buttons',$elementButtonArray);
                            }
                        ?>
                    </div>
            </div>
         </div>
      </div>
      <!--==================  banner end ============--> 
   </div>
   <div class="sap_10"></div>
   <div class="thumbnail gallery_thumb">
      <!--================== carousel thumnail  start ============--> 
      <ul class="thumb" >
        
        <?php
        
           if(!empty($elementDataList)){
               
                foreach($elementDataList as $element){
                    if(!in_array($element['elementType'], $allowElementType)){
                        
                    $elementTitle    =   $element['title'];
                    
                    if(empty($element['imagePath'])){	
                        $thumbImage = getVideoThumbFolder(@$element['filePath'].$element['fileName'],'_m');	
                        $elementImage=getImage($thumbImage,$imagetype_m);	
                    }else{
                        $thumbImage = addThumbFolder(@$element['imagePath'],'_m');	
                        $elementImage=getImage($thumbImage,$imagetype_m);
                    }
                    
                    $elementUrl=base_url(lang().$urlUsername.'/mediafrontend/mediagallery/'.$frentendUserId.'/'.$projectId.'/'.$element['elementId']);
                  
                    $aboutMore=base_url(lang().$urlUsername.'/mediafrontend/mediadetails/'.$frentendUserId.'/'.$projectId.'/'.$element['elementId']);
        ?>
             <li>
                <div class="table_cell">
                   <img src="<?php echo $elementImage; ?>" alt="" />
                   <div class="thum_text box_onbanner" onclick="window.location.href='<?php echo $elementUrl; ?>'">
                      <div class="count fs16"><span class="">1</span>/<span class="total-slides">89</span></div>
                      <span class="title"><?php echo $elementTitle; ?></span> 
                      <div class="sap_15"></div>
                      <a href="<?php echo $aboutMore; ?>" class="fshel_light fs16"><span>MORE ABOUT THIS VIDEO</span></a> 
                   </div>
                </div>
            </li>
        <?php 
                    }
                }
            }
        ?>
        
      </ul>
      <!--================== carousel slider end ============--> 
   </div>
</div>
