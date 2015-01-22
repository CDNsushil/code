<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    //------check project data and convert to single diemential array------//
    if(!empty($projectData)):
        $projectData = $projectData[0];
    endif;

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
        $previousPageLink       =     'mediafrontend/educationelement/'.$frentendUserId.'/'.$projectId.'/'.$previousElementId;
        $previousPageLink       =     base_url_lang($previousPageLink);
    endif;
    
    //previous element show page link id get
    if($currentKeyPosition < ($elementNumberCount-1)):
        $nextElementId      =    $elementPrepareList[$currentKeyPosition+1];
        $nextPageLink       =    'mediafrontend/educationelement/'.$frentendUserId.'/'.$projectId.'/'.$nextElementId;
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
    $IndustryId                   =   (!empty($projectData['IndustryId']))?$projectData['IndustryId']:'0';

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
    $producedInCountry      =    (!empty($elementData['producedInCountry']))?getCountry($elementData['producedInCountry']):''; 
    $isPublished            =    $elementData['isPublished']; 
    $categoryId             =   (!empty($elementData['catId']))?$elementData['catId']:'1';
    $isPrice                =    (!empty($elementData['isPrice']))?$elementData['isPrice']:'f'; 
    $isPerViewPrice         =    (!empty($elementData['isPerViewPrice']))?$elementData['isPerViewPrice']:'f'; 
    $isDownloadPrice        =    (!empty($elementData['isDownloadPrice']))?$elementData['isDownloadPrice']:'f'; 
    $mediaFileType   =    (!empty($elementData['mediaFileType']))?$elementData['mediaFileType']:'0'; 
    
    
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
    $aboutPageLink       =     'mediafrontend/educationdetails/'.$frentendUserId.'/'.$projectId;
    $aboutPageLink       =     base_url_lang($aboutPageLink);
    
    $galleryPageLink     =     'mediafrontend/educationelement/'.$frentendUserId.'/'.$projectId;
    $galleryPageLink     =     base_url_lang($galleryPageLink);
    
    $otherCollectionsLink      =    'showproject/othercollections/'.$frentendUserId.'/educationMaterial';
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
           $headingName  = $this->lang->line('educationMaterial_headingName_0_'.$mediaFileType.'_'.$categoryId);
            $craveDetails = $this->lang->line('educationMaterial_craveDetails_0_'.$mediaFileType.'_'.$categoryId);
        break;
        
        case "video_file":
           $headingName  = $this->lang->line('educationMaterial_headingName_1_'.$mediaFileType.'_'.$categoryId);
           $craveDetails = $this->lang->line('educationMaterial_craveDetails_1_'.$mediaFileType.'_'.$categoryId);
        break;
        
        default:
            $headingName  = $this->lang->line('educationMaterial_headingName_1_'.$mediaFileType.'_'.$categoryId);
            $craveDetails = $this->lang->line('educationMaterial_craveDetails_1_'.$mediaFileType.'_'.$categoryId);
    }
?>
    
<div class="row content_wrap" >
    
    <?php
        //---------load header navigation menu---------//
        $viewData = array(
            'headingName' => $headingName,
            'navigation_1'=> $galleryPageLink,
            'navigation_2'=> $aboutPageLink,
            'navigation_3'=> $otherCollectionsLink,
            'activeMenu'=>'menu2',
            'categoryId'    =>  $categoryId,
        );
        $this->load->view('common_view/media_showcase_header_view',$viewData);
    ?>
    <div class="banner_collection mb15 " >
       <!--==================  full screen slider  start ============-->
       <div class="width908 display_table m_auto pb8">
          <h2  class="font_bold lineH19 width650 fl"><?php echo $title;?></h2>
          <div class="color_bg pr20">
             <div class="defaultP">
                <form autocomplete="off">
                   <label>
                      <input id="banana" class="ez-hide" type="checkbox" value="banana" name="item[]">
                      <p class="p1"><?php echo $this->lang->line('m_white_bg'); ?> </p>
                      <p class="p1 display_block"><?php echo $this->lang->line('m_dark_bg'); ?> </p>
                   </label>
                </form>
             </div>
          </div>
       </div>
       <!--==================  banner start ============-->
        <div  class="flexslider">
           <div class="display_table width_890 m_auto bdr_a1a1a1 collection_banner height500">
              <div class="table_cell height500"> 
                  
                <?php
                 if($elementType=='1' || $elementType=='2'){
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
                        <iframe src="<?php echo $getSrc; ?>" width="890" height="500" frameborder="0"  webkitAllowFullScreen mozallowfullscreen allowFullScreen scrolling="no"></iframe>
                        <?php } else { 
                            $elementImage   =    $elementImagePath;	
                            $imagetype      =    $this->config->item('educationMaterialImage_m');
                            $thumbImage     =    addThumbFolder($elementImage,'_m');
                            $elementImage   =    getImage($thumbImage,$imagetype);
                        ?>
                            <p class="tac f16 pb5 white"><?php echo $this->lang->line('This_work_is_hosted_on_another_site'); ?> <a class="white underline hoverOrange" target="_blank" href="<?php echo $getSrc; ?>"><?php echo $this->lang->line('Click_here_to_view_the_url'); ?></a></p>
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
                                
                            ?>
                                 <img src="<?php echo $showElementImage; ?>"  alt=""/>
                        <?php } ?>
                </div>
           </div>
        </div>
         
       <!--==================  banner end ============--> 
    </div>
    <div class="width900 m_auto sc_album pt0">
       <!--  left Content start  -->
       <div class="left_w width_302  lineH18 fl mr pr30">
          <div class="head_list fl  width288 pr5  bg_fdfdfd bdr_ececec ">
             <p class="fl fs16"><?php echo $craveDetails; ?></p>
             <div class="fr pr25 color_666">
                <div class="icon_view3_blog icon_so"><?php echo $viewCount; ?></div>
                <div class="icon_crave4_blog icon_so <?php echo  $craveDivAction.' '.$cravedALL;?>"><?php echo $craveCount;?></div>
                <div class="rating fl pt6 <?php echo $rateDivAction; ?>"> <img src="<?php echo ratingImagePath($ratingAvg);?>" alt=""> </div>
                <div class="btn_share_icon icon_so"><?php echo $reviewCount; ?></div>
             </div>
          </div>
          <div class="sap_15"></div>
          <div class="green opens_light fs30 pl16 clearb lineH30" >Type</div>
          <div class="sap_15"></div>
          <div class="clearbox">
             <div class="fs16 lettsp1 pl16">Film &amp; Video Education</div>
             <div class="sap_25"></div>
             <b class="red letter_spP7 pl16">Media Information</b>
             <ul class="edit_list pl16 pb2">
                <li>
                   <p class="red lineH15">LENGTH</p>
                   <p>02.73 Min</p>
                </li>
                <!--<li>
                   <p class="red lineH15">LANGUAGE</p>
                   <p> Afrikaans</p>
                </li>-->
               <li>
                  <p class="red lineH15"><?php echo $this->lang->line('m_date_release_show'); ?></p>
                  <b> <?php echo date("d F Y", strtotime($projReleaseDate)); ?></b> 
               </li>
             </ul>
          </div>
          <div class="sap_35"></div>
            <?php 
                //---------associative creatives list start----------//
                    echo  Modules::run("creativeinvolved/associativecreativeslist", $elementEntityId,$elementId);
                //---------associative creatives list start----------//
            ?> 
          <span class="text_alighC width100_per"><span class="sap_20"></span>
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
           <div class="bb_aeaeae pb15 fl width100_per">
              <div class="fl">  <?php 
                    //-----------crave button load view-----------//
                    $showSocialData= array('buttonDesigntype'=>'1','buttonTitle'=>'Crave','elementId'=>$elementId,'entityId'=>$elementEntityId,'ownerId'=>$frentendUserId,'projectType'=>$industryType,'isPublished'=>$isPublished,'furteherDetails'=>'{"projectId":"'.$projectId.'","table":"Project","primeryField":"projId","fieldSet":"projId as id,projBaseImgPath as craveImage, projName as craveTitle, projShortDesc as craveShortDescription, tagwords as tagwords","cacheFilePath":"'.$cacheFile.'"}');
                    echo Modules::run("craves/creavebutton",$showSocialData);
                    
                     //------------rating button module load view------------//
                    $ratingButtonData = array('elementId'=>$elementId,'entityId'=>$elementEntityId,'ratingAvg'=>$ratingAvg,'ratingClass'=>'width_auto ml5 Fleft','isPublished'=>$isPublished);
                    echo Modules::run("rating/ratingbutton",$ratingButtonData);
                  //$this->load->view('rating/rating_form_design',array('elementId'=>$elementId,'entityId'=>$entityId));
                  
                    //------------review button view load-------------//
                    $this->load->view('media/reviewViewNew',array('elementId'=>$elementId,'entityId'=>$elementEntityId,'projName'=>$title,'section' =>'Creative-Industry Educational','industryId' =>$IndustryId,'isPublished'=>$isPublished));
                     
                ?></div>
               
                <!---
                <div class="fr">
                   <button class="bdr_a0a0a0 bg_f7f7f7 fs14 lineH20  text_alighL pl10 pr10 " type="button" >Collection<span class="red pl15 font_bold">&euro;124.95</span></button>
                </div>--->
                
                <div class="fr width280">
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
                
                <?php  if($elementType==1 || $elementType==2){ ?>
                    <div class="fr">
                        <div class=" bg_f7f7f7 fs27 font_bold tralerbtn width250 text_alignR" ><?php echo strtoupper($headingName); ?></div>
                    </div>
                <?php } ?>
           
                </div>
             </div>
            
          <div class=" cnt clearb mt10 mb20 fl content_collection lineH20">
                <?php
                    if(strlen(trim(@$elementData['description']))>2){ ?>
                            <div class="seprator_14"></div>
                            <div class="row pt18">
                                <?php echo changeToUrl(nl2br($elementData['description']));?>
                            </div>
                        <?php		
                    }
                 ?>
             <div class="sap_20"></div>
             <div class="box_wrap socail_icon width_542 pb9">
                <div class="nav mb16 pb5 width513 display_inline_block  text_alighC bb_e9e9e9 "> 
                     <?php if(!empty($previousPageLink)){ ?>  
                        <a class=" fl text_alighL previous_collection" href="<?php echo $previousPageLink; ?>">Previous Media </a> 
                      <?php }else{ ?>
                        <a class=" fl text_alighL disable_link previous_collection" href="javascript:void(0)">Previous Media </a> 
                      <?php  } ?>
                      <span class="counter"><span class="current_slide"><?php echo $currentElementView; ?></span>/<span class="total_slide"></span><?php echo  $elementNumberCount; ?></span> 
                      
                      <?php if(!empty($nextPageLink)){ ?> 
                        <a class=" fr text_alignR next_collection" href="<?php echo $nextPageLink; ?>">Next Media</a>
                      <?php }else{ ?>
                        <a class=" fr text_alignR disable_link next_collection" href="javascript:void(0)">Next Media</a>
                       <?php  } ?> 
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
                    echo Modules::run("mediafrontend/getReviewListNew",$elementEntityId,$elementId);
                //---------review list end-----------//
            ?>
            <div class="box_wrap width_542 text_alignC mt15"> 
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
          </div>
          <!-- right Content end  --> 
       </div>
    </div>
</div>
