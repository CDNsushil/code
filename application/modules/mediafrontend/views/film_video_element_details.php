<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    
    //add preview word if preview mode is active
    $previewWord =  (previewModeActive())?"/preview":"";
    
    //------check project data and convert to single diemential array------//
    if(!empty($projectData)):
        $projectData = $projectData[0];
    endif;
    
    
    //get user info for seller currency and currency sign
    if(!isset($userInfo)){
        $userInfo = showCaseUserDetails($frentendUserId);
    }
    
    
    //get seller currency data    
    $sellerCurrency    =   $userInfo['seller_currency'];
    $sellerCurrency    =   (!empty($sellerCurrency) && $sellerCurrency>0)?$sellerCurrency:0;
    $currencySign      =   $this->config->item('currency'.$sellerCurrency);

    //------check project element data and convert to single diemential array------//
    $elementData         =   false;
    $elementPrepareList  =   false;
    $currentElementView  =   0;
    $currentKeyPosition  =   0;
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
        $previousPageLink       =     'mediafrontend/mediadetails/'.$frentendUserId.'/'.$projectId.'/'.$previousElementId.$previewWord;
        $previousPageLink       =     base_url_lang($previousPageLink);
    endif;
    
    //previous element show page link id get
    if($currentKeyPosition < ($elementNumberCount-1)):
        $nextElementId      =    $elementPrepareList[$currentKeyPosition+1];
        $nextPageLink       =    'mediafrontend/mediadetails/'.$frentendUserId.'/'.$projectId.'/'.$nextElementId.$previewWord;
        $nextPageLink       =     base_url_lang($nextPageLink);
    endif;
    
    
    //--------element require default data--------//
    $imagetype_b            =   $fileConfig['defaultImage_b'];
    $imagetype_m            =   $fileConfig['defaultImage_m'];
    $imagetype_l            =   $fileConfig['defaultImage_l'];
    $imagetype_xs           =   $fileConfig['defaultImage_xs'];
    $imagetype_s            =   $fileConfig['defaultImage_s'];
   
   
    //---------preprae project details data----------//
    $projSellstatus               =   ($projectData['projSellstatus']=='t')?true:false;
    $projSellType                 =   (!empty($projectData['projSellType']))?$projectData['projSellType']:'0';

    //------prepare the element details data---------//
    
    //echo "<pre>";
    //print_r($elementData);
    
    
    
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
    $productionHouse        =    (!empty($elementData['productionHouse']))?$elementData['productionHouse']:''; 
    $producedInCountry      =    (!empty($elementData['producedInCountry']))?getCountry($elementData['producedInCountry']):''; 
    $isPublished            =    $elementData['isPublished']; 
    $categoryId             =    (!empty($elementData['catId']))?$elementData['catId']:'1';
    $isPrice                =    (!empty($elementData['isPrice']))?$elementData['isPrice']:'f'; 
    $isPerViewPrice         =    (!empty($elementData['isPerViewPrice']))?$elementData['isPerViewPrice']:'f'; 
    $isDownloadPrice        =    (!empty($elementData['isDownloadPrice']))?$elementData['isDownloadPrice']:'f'; 
    $projLanguage           =    (!empty($elementData['projLanguage']))?$elementData['projLanguage']:'0'; 
    
    $mediaFileType          =    $this->config->item('media_type_video'); // set default media type for video
    
    $downloadPrice           =    (!empty($elementData['downloadPrice']))?$elementData['downloadPrice']:''; 
    $perViewPrice            =    (!empty($elementData['perViewPrice']))?$elementData['perViewPrice']:''; 
    $price                   =    (!empty($elementData['price']))?$elementData['price']:''; 
    
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
    $aboutPageLink       =     'mediafrontend/mediashowcases/'.$frentendUserId.'/'.$projectId.$previewWord;
    $aboutPageLink       =     base_url_lang($aboutPageLink);
    
    $galleryPageLink     =     'mediafrontend/mediagallery/'.$frentendUserId.'/'.$projectId.$previewWord;
    $galleryPageLink     =     base_url_lang($galleryPageLink);
    
    $otherCollectionsLink      =    'showproject/othercollections/'.$frentendUserId.'/filmNvideo'.$previewWord;
    $otherCollectionsLink      =     base_url_lang($otherCollectionsLink);
    
    //------create share link by current url-------//
    $currentShortUrl     = uri_string();
    
    //get media file type for show details
    $uploadFileType = 'video_file';
    if($isPrice=="t"){
        $uploadFileType = 'DVD';
    }elseif($isDownloadPrice=="t"){
        $uploadFileType = 'video_file';
    }elseif($isPerViewPrice=="t"){
        $uploadFileType = 'video_file';
    }
    
    //condition for heading and creave details heading
    switch($uploadFileType){
        case "DVD":
            $headingName  = $this->lang->line('filmNvideo_headingName');
            $craveDetails = $this->lang->line('filmNvideo_craveDetails');
            $infoDetails  = $this->lang->line('filmNvideo_infoDetails');
        break;
        
        case "video_file":
            $headingName  = $this->lang->line('filmNvideo_headingName_1');
            $craveDetails = $this->lang->line('filmNvideo_craveDetails_1');
            $infoDetails  = $this->lang->line('filmNvideo_infoDetails_1');
        break;
        
        default:
            if($elementType=='1'){
                //condition for sample
                $headingName  = $this->lang->line('filmNvideo_headingName_2_1');
            }elseif($elementType=='2'){
                //condition for trailer
                $headingName  = $this->lang->line('filmNvideo_headingName_2_2');
            }elseif($projSellType==1){
                //condition  paid project 
                $headingName  = $this->lang->line('filmNvideo_headingName_2_3');
            }else{
                $headingName  = $this->lang->line('filmNvideo_headingName_2_4');
            }
            
            $craveDetails = $this->lang->line('filmNvideo_craveDetails_2');
            $infoDetails  = $this->lang->line('filmNvideo_infoDetails_2');
    }
?>
    
    <div class="row content_wrap fvelement" >
       <?php
            //---------load header navigation menu---------//
            $viewData = array(
                'headingName'   =>  $headingName,
                'navigation_1'  =>  $galleryPageLink,
                'navigation_2'  =>  $aboutPageLink,
                'navigation_3'  =>  $otherCollectionsLink,
                'activeMenu'    =>  'menu1',
                'categoryId'    =>  $this->config->item('FvCollectionCatId'),
                'genreName'    =>  $genreName,
            );
            $this->load->view('common_view/media_showcase_header_view',$viewData);
        ?>
       
       <div class="banner_collection pt0 gallery_banner " >
          <!--==================  full screen slider  start ============-->
          <!--==================  banner start ============-->
          <div class="bg_f3f3f3 ">
             <div id="slider" class="flexslider vedio_gall">
                <div class="display_table height564 width100_per m_auto">
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
                                        <p class="tac f16 pb5 white"><?php echo $this->lang->line('This_work_is_hosted_on_another_site'); ?> <a class="white underline hoverOrange"  href="<?php echo $getSrc; ?>"><?php echo $this->lang->line('Click_here_to_view_the_url'); ?></a></p>
                                        <img src="<?php echo $elementImage; ?>"  class="max_w408_h305"/>
                                <?php   }  
                                    
                                    }else{ 
                                            
                                            //paid video image here 
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
                            <a class="flex-prev" href="<?php echo $previousPageLink; ?>"><?php echo $this->lang->line('m_previous_button'); ?></a>
                        </li>
                    <?php endif; ?>
                    
                    <?php if(!empty($nextPageLink)): ?> 
                        <li>
                            <a class="flex-next" href="<?php echo $nextPageLink; ?>"><?php echo $this->lang->line('m_next_button'); ?></a>
                        </li>
                    <?php endif; ?>
                </ul>
             </div>
             <div class="width_890 pt23 pb20 display_table m_auto">
                <div class="fl ps_1 color_999 fs14 mt5">
                   <div class="icon_view3_blog icon_so"><?php echo $viewCount; ?></div>
                   <div class="fvelementcrave icon_crave4_blog  icon_so <?php echo  $craveDivAction.' '.$cravedALL;?>"><?php echo $craveCount;?></div>
                    <div class="rating fl pt6 <?php echo $rateDivAction; ?>"> 
                        <img src="<?php echo ratingImagePath($ratingAvg);?>" alt=""> 
                    </div>
                   <div class="btn_share_icon icon_so"><?php echo $reviewCount; ?></div>
                </div>
                <div class="fr pr10"> <span class="fl soc_1 pr10">
                   
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
                   </span> <span class="color_999 fl pl15 opensans_semi  number_slide"><?php echo $currentElementView; ?>/<?php echo $elementNumberCount; ?></span> 
                </div>
             </div>
          </div>
       </div>
       <div class="width900 m_auto sc_album pt0">
          <!--  left Content start  -->
          <h2  class="lineH14 bb_ececec pb10"><?php echo $title;?> </h2>
          <div class="sap_30"></div>
          <div class="left_w lineH18 fl mr pr30">
             <div class="bb_e7e7e7 fl width100_per pb20">
               <?php 
                    //-----------crave button load view-----------//
                    $showSocialData= array('buttonDesigntype'=>'1','buttonTitle'=>'Crave','elementId'=>$elementId,'entityId'=>$elementEntityId,'ownerId'=>$frentendUserId,'projectType'=>$industryType,'isPublished'=>$isPublished,'furteherDetails'=>'');
                    echo Modules::run("craves/creavebutton",$showSocialData);
                    
                     //------------rating button module load view------------//
                    $ratingButtonData = array('elementId'=>$elementId,'entityId'=>$elementEntityId,'ratingAvg'=>$ratingAvg,'ratingClass'=>'width_auto ml5 Fleft','isPublished'=>$isPublished);
                    echo Modules::run("rating/ratingbutton",$ratingButtonData);
                   
                    //------------review button view load-------------//
                    $this->load->view('media/reviewViewNew',array('reviewdesign'=>'1','reviewProjectId'=>$projectId,'reviewElementId'=>$elementId,'reviewEntityId'=>$elementEntityId,'reviewIndustryId' =>'1','isPublished'=>$isPublished));
                
                ?>
             </div>
             <div class="sap_20"></div>
             <div class="clearb fl fvelementprice">
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
             <!--<div class="sap_20 bb_e7e7e7"></div>-->
             <div class="clearb">
                <ul class="edit_list pb2 pl17 ">
                   <!--<li>
                      <p class="red lineH15">Genre</p>
                      <b> <?php //echo $genreName; ?></b> 
                   </li>-->
                   
                    <?php if(!empty($projGenreFree)){ ?>
                   <li>
                      <p class="red lineH15">Subgenre</p>
                      <b> <?php echo $projGenreFree; ?></b> 
                   </li>
                   <?php } ?>
                   <!--
                   <li>
                      <p class="red lineH15">Length</p>
                      <b> 120 Minutes</b> 
                   </li>
                   -->
                    
                    <?php if(!empty($projLanguage)){ ?>
                   
                       <li>
                          <p class="red lineH15">Language</p>
                          <b> <?php echo getLanguage($projLanguage); ?></b> 
                       </li>
                   <?php } ?>
                   <!--
                   <li>
                      <p class="red lineH15">Subtitles</p>
                      <b> Croation </b><b class="pl10"> German</b> 
                   </li>
                   <li>
                      <p class="red lineH15">Dubbed</p>
                      <b> French       Spanish</b> 
                   </li>
                   -->
                   
                    <?php if(!empty($producedInCountry)){ ?>
                        <li>
                            <p class="red lineH15">Country of Origin</p>
                            <b> <?php echo $producedInCountry; ?></b> 
                        </li>
                    <?php } ?>
                   
                   
                   <li>
                      <p class="red lineH15">Release Date </p>
                      <b> <?php echo date("d F Y", strtotime($projReleaseDate)); ?></b> 
                   </li>
                   
                   
                    <?php if(!empty($productionHouse)){ ?>
                       <li>
                          <p class="red lineH15">Distributor</p>
                          <b> <?php echo $productionHouse; ?></b> 
                       </li>
                    <?php } ?>
                    
                    <?php if(!empty($classification)){ ?>
                       <li>
                          <p class="red lineH15">Copyright</p>
                          <b> <?php echo $classification; ?></b> 
                       </li>
                    <?php } ?>
                    
                </ul>
             </div>
            
             <div class="sap_20"></div> 
            <?php 
                //---------associative creatives list start----------//
                    echo  Modules::run("creativeinvolved/associativecreativeslist", $elementEntityId,$elementId);
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
          </div>
          <!-- left content end --> 
          <!-- right Content start -->
          <div class="rightbox width560 position_relative fr mt1">
             <div class=" cnt clearb mt3 mb20 fl content_collection lineH20">
                <?php
                    if(strlen(trim(@$elementData['description']))>2){ ?>
                            <?php echo changeToUrl(nl2br($elementData['description']));?>
                        <?php		
                    }
                 ?>
               
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
                        echo Modules::run("mediafrontend/getReviewListNew",$elementEntityId,$elementId);
                    //---------review list end-----------//
                ?>
                
          </div>
       </div>
    </div>
          
