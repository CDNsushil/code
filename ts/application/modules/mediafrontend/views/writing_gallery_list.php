<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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
        $previousPageLink       =     'mediafrontend/writinggallery/'.$frentendUserId.'/'.$projectId.'/'.$previousElementId;
        $previousPageLink       =     base_url_lang($previousPageLink);
    endif;
    
    //previous element show page link id get
    if($currentKeyPosition < ($elementNumberCount-1)):
        $nextElementId      =    $elementPrepareList[$currentKeyPosition+1];
        $nextPageLink       =    'mediafrontend/writinggallery/'.$frentendUserId.'/'.$projectId.'/'.$nextElementId;
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
    $projName               =   (!empty($projectData['projName']))?$projectData['projName']:'';

    
    
    //echo "<pre>";
    //print_r($elementData);
    
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
    $categoryId             =    (!empty($elementData['catId']))?$elementData['catId']:'1';
    $isPrice                =    (!empty($elementData['isPrice']))?$elementData['isPrice']:'f'; 
    $isPerViewPrice         =    (!empty($elementData['isPerViewPrice']))?$elementData['isPerViewPrice']:'f'; 
    $isDownloadPrice        =    (!empty($elementData['isDownloadPrice']))?$elementData['isDownloadPrice']:'f'; 
    $selfClassfication      =    (!empty($elementData['otpion']))?$elementData['otpion']:''; 
    $projectTypeName        =    (!empty($elementData['projectTypeName']))?$elementData['projectTypeName']:''; 
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
    $aboutPageLink          =     'mediafrontend/writingdetails/'.$frentendUserId.'/'.$projectId;
    $aboutPageLink          =      base_url_lang($aboutPageLink);
    
    $galleryPageLink        =     'mediafrontend/writinggallery/'.$frentendUserId.'/'.$projectId;
    $galleryPageLink        =      base_url_lang($galleryPageLink);
    
    $moreAboutVideLink      =     'mediafrontend/writingelement/'.$frentendUserId.'/'.$projectId.'/'.$elementId;
    $moreAboutVideLink      =     base_url_lang($moreAboutVideLink);
    
    $otherCollectionsLink      =    'showproject/othercollections/'.$frentendUserId.'/writingNpublishing';
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
    
     //get media file type for show details
    $uploadFileType = 'text_file';
    if($isPrice=="t"){
        $uploadFileType = 'text';
    }elseif($isPerViewPrice=="t"){
        $uploadFileType = 'text_file';
    }elseif($isDownloadPrice=="t"){
        $uploadFileType = 'text_file';
    }
    
    //get lable by media type
    switch($uploadFileType){
        case "text":
            $elementFileType = $this->lang->line('writingNpublishing_element_type_2_'.$categoryId);
        break;
        
        case "text_file":
            $elementFileType = $this->lang->line('writingNpublishing_element_type_1_'.$categoryId);
        break;
        
        default:
            $elementFileType = $this->lang->line('writingNpublishing_element_type_1_'.$categoryId);
    }
    
    
    //get seller currency
    if(!isset($userInfo)){
        $userInfo = showCaseUserDetails($frentendUserId);
    }
    
    //get seller currency data    
    $sellerCurrency    =   $userInfo['seller_currency'];
    $sellerCurrency    =   (!empty($sellerCurrency) && $sellerCurrency>0)?$sellerCurrency:0;
   
?>

<div class="newlanding_container wrap_art">
   
    <?php
        //---------load header navigation menu---------//
        $viewData = array(
            'headingName'   =>   $this->lang->line('writingNpublishing_detail_heading_'.$categoryId),
            'navigation_1'  =>  $galleryPageLink,
            'navigation_2'  =>  $aboutPageLink,
            'navigation_3'  =>  $otherCollectionsLink,
            'activeMenu'    =>  'menu1',
            'categoryId'    =>  $categoryId,
        );
        $this->load->view('common_view/media_showcase_header_view',$viewData);
    ?>
   <div class="row width_100_per js-idex">
      <div class="banner_2 writing_banner" >
         <div id="fullscreen" class="zoom_wrap">
            <div class="wrap_tab">
               <div class="new_wrap clearb">
                  <div class="sap_25"></div>
                  <div class="fl fs24 pl25 open_sans"><?php echo showString($projName,65); ?></div>
                  <div class="fr ps_1 fs14">
                     <div class="icon_view3_blog icon_so"><?php echo  $viewCount; ?></div>
                     <div class="icon_crave4_blog icon_so <?php echo  $craveDivAction.' '.$cravedALL;?>"><?php echo  $craveCount; ?></div>
                     <div class="fl mt5 mr10 <?php echo $rateDivAction; ?>"> <img src="<?php echo ratingImagePath($ratingAvg);?>" alt=" "  /> </div>
                     <div class="btn_share_icon pr0 icon_so "><?php echo $reviewCount; ?></div>
                  </div>
                  <div class="sap_20"></div>
               </div>
               <div class="color_bg">
                  <div class="defaultP">
                     <input type="checkbox" name="item[]" id="banana" value="banana" />
                  </div>
                  <p  class="p1">View with white background </p>
                  <p class="p2">View with dark background </p>
               </div>
               <!--==================  banner start ============-->
               <div id="slider" class="flexslider position_relative bg_f2f2">
                  <div class="full_wrap"> <a href="#" class="requestfullscreen fs-button" ></a><a href="#" class="exitfullscreen fs-button" style="display: none"></a> </div>
                  <div class="width925 m_auto">
                     <h2 class="fs22 pt22 pb16 bb_fac8b8 "><?php echo $title;?></h2>
                     <div class="sap_45"></div>
                     <div class="writing_slider  hieght480 width_485 table_cell">
                        <?php 
                            $thumbImage      = addThumbFolder($elementImagePath,'_b');	
                            $showElementImage=getImage($thumbImage,$imagetype_b);
                        ?>
                        <img src="<?php echo $showElementImage; ?>" alt=""  />
                     </div>
                     <div class="wrintg_sidecnt table_cell verti_top width_333 text_alighL" >
                      
                        <div class="fl wpgallery">
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
                        
                        <div class="sap_30"></div>
                        <div class="pr10 head_list color_666">
                           <div class="icon_view3_blog icon_so"><?php echo  $viewCount; ?></div>
                           <div class="icon_crave4_blog icon_so <?php echo  $craveDivAction.' '.$cravedALL;?>"><?php echo  $craveCount; ?></div>
                           <div class="rating fl pt6 <?php echo $rateDivAction; ?>">
                              <img alt="" src="<?php echo ratingImagePath($ratingAvg);?>">
                           </div>
                           <div class="btn_share_icon icon_so"><?php echo $reviewCount; ?></div>
                        </div>
                        <div class="sap_30"></div>
                        <div class="clearb">
                           <p class="font_bold letter_spP7">Piece Information</p>
                           <ul class="letter_spP7  fs13  ">
                              
                              <?php if(!empty($projectTypeName)){ ?>
                                <li class="pt13">
                                 <p class="color_999 lineH15">TYPE</p>
                                 <p><?php echo $projectTypeName; ?></p>
                                </li>
                              <?php } ?>
                              
                              <?php if(!empty($genreName)){ ?>
                                <li class="pt13">
                                    <p class="color_999 lineH15">GENRE</p>
                                    <p><?php echo $genreName ; ?></p>
                                </li>
                              <?php } ?>
                              <!--<li class="pt13">
                                 <p class="color_999 lineH15">LANGUAGE</p>
                                 <p>English</p>
                              </li>-->
                              <?php if(!empty($selfClassfication)){ ?>
                                  <li class="pt13">
                                     <p class="color_999 lineH15">SELF CLASSIFICATION</p>
                                     <p><?php echo $selfClassfication; ?></p>
                                  </li>
                              <?php } ?>
                           </ul>
                        </div>
                        <div class="sap_45"></div>
                        <div class="fr pr48">
                           <a class="fr red fs16 lettsp3 more_red" href="<?php echo $moreAboutVideLink; ?>">More About the <?php echo $elementFileType; ?></a>
                           <div class="fr fs15 pr25">
                              <span class="current-slide"><?php echo $currentElementView; ?></span>
                              /
                              <span class="total-slides"><?php echo $elementNumberCount; ?></span>
                           </div>
                        </div>
                        <div class="sap_65"></div>
                        <div class="social_wrap pr15 writin_wrap mt5 heightauto bg-non shadownone pl0 mb5 fr  "> 
                            <?php 
                                //-------load module of social listing share---------------//
                                $shareData=array('url'=>$currentShortUrl,'isPublished'=>$isPublished,'designType'=>'3');
                                echo Modules::run("share/sharesocialshowview",$shareData);	
                            ?>  
                        </div>
                     </div>
                     <div class="sap_55"></div>
                  </div>
                  <ul class="flex-direction-nav">
                    <?php if(!empty($previousPageLink)): ?> 
                     <li>
                        <a class="flex-prev flex-disabled" href="<?php echo $previousPageLink; ?>" >Previous</a>
                     </li>
                    <?php endif; ?>  
                     <?php if(!empty($nextPageLink)): ?> 
                     <li>
                        <a class="flex-next flex-disabled" href="<?php echo $nextPageLink; ?>" >Next</a>
                     </li>
                    <?php endif; ?>
                  </ul>
               </div>
               <!--==================  banner end ============--> 
            </div>
         </div>
         <!--==================  full screen banner end ============--> 
         <!--================== thumnail  slider  start ============-->
         <div class="writing_thumb pt15 pb30">
            <!--================== carousel thumnail  start ============-->
            <ul class="m_auto writing_box">
               
                <?php 
                    if(!empty($elementDataList)){
                    $elementCount=1;
                    foreach($elementDataList as $getElementData){
                        
                    $elementTitle       =   $getElementData['title'];
                   
                    $fileName               =    (!empty($getElementData['fileName']))?$getElementData['fileName']:''; 
                    $filePath               =    (!empty($getElementData['filePath']))?$getElementData['filePath']:''; 
                    $elementImagePath       =   (!empty($getElementData['imagePath']))?$getElementData['imagePath']:''; 
                    $categoryId             =    (!empty($getElementData['catId']))?$getElementData['catId']:'1';
                    $price                  =    (!empty($getElementData['price']))?$getElementData['price']:'0'; 
                    $perViewPrice           =    (!empty($getElementData['perViewPrice']))?$getElementData['perViewPrice']:'0'; 
                    $downloadPrice          =    (!empty($getElementData['downloadPrice']))?$getElementData['downloadPrice']:'0'; 
                    $isPrice                =    (!empty($getElementData['isPrice']))?$getElementData['isPrice']:'f'; 
                    $isPerViewPrice         =    (!empty($getElementData['isPerViewPrice']))?$getElementData['isPerViewPrice']:'f'; 
                    $isDownloadPrice        =    (!empty($getElementData['isDownloadPrice']))?$getElementData['isDownloadPrice']:'f'; 
                    
                    //writing gallery
                    //get media file type for show details
                    $uploadFileType = 'text_file';
                    $priceElement = '0';
                    if($isPrice=="t"){
                        $uploadFileType = 'text';
                        $priceElement = $price;
                    }elseif($isPerViewPrice=="t"){
                        $uploadFileType = 'text_file';
                        $priceElement = $perViewPrice;
                    }elseif($isDownloadPrice=="t"){
                        $uploadFileType = 'text_file';
                        $priceElement = $downloadPrice;
                    }
                    
                    //get lable by media type
                    switch($uploadFileType){
                        case "text":
                            $galleryElement = $this->lang->line('writingNpublishing_element_type_2_'.$categoryId);
                        break;
                        
                        case "text_file":
                            $galleryElement = $this->lang->line('writingNpublishing_element_type_1_'.$categoryId);
                        break;
                        
                        default:
                            $galleryElement = $this->lang->line('writingNpublishing_element_type_1_'.$categoryId);
                    }
                    
                       
                    $thumbImage             =   addThumbFolder($elementImagePath,'_m',$thumbFolder);	
                    $showElementImage       =   getImage($thumbImage,$imagetype_m);
                    
                    $diplayPriceShow = "";
                    if($projSellstatus){
                        //get price status
                        $priceDetails = getDisplayPrice($priceElement,$sellerCurrency);
                        if(!empty($priceDetails)){
                            $currencySign     = (!empty($priceDetails['currencySign']))?$priceDetails['currencySign']:'';
                            $displayPrice     = (!empty($priceDetails['displayPrice']))?$priceDetails['displayPrice']:'';
                            $diplayPriceShow  = $currencySign.' '.$displayPrice;
                        }
                    }
                    
                    $elementUrl=base_url(lang().$urlUsername.'/mediafrontend/writinggallery/'.$frentendUserId.'/'.$projectId.'/'.$getElementData['elementId']);

                    $aboutMore=base_url(lang().$urlUsername.'/mediafrontend/writingelement/'.$frentendUserId.'/'.$projectId.'/'.$getElementData['elementId']);
               ?>
               <li>
                  <img src="<?php echo $showElementImage; ?>" alt="" />
                  <div class="thum_text box_onbanner" onclick="window.location.href='<?php echo $elementUrl; ?>'">
                     <div class="pt25 pl15 pr20 clearb ">
                        <p class="lettsp1_5"> <?php echo $elementTitle; ?>
                        </p>
                        <?php if(!empty($diplayPriceShow)){ ?>
                            <b class="red clearb fl pt4"><?php echo $diplayPriceShow; ?></b>
                        <?php } ?>
                     </div>
                     <div class="count fs16"><span class=""><?php echo $elementCount; ?></span>/<span class="total-slides"><?php echo $elementNumberCount; ?></span></div>
                     <a href="<?php echo $aboutMore; ?>" class=" dark_btn fs16">VIEW <?php echo strtoupper($galleryElement); ?> > </a> 
                  </div>
               </li>
             
             <?php $elementCount++; }   } ?>
               
            </ul>
         </div>
         <div class="sap_60"></div>
      </div>
   </div>
</div>
<script type="text/javascript">
     var removeClass = true;
     $("#banana").click(function () {
         $("body").toggleClass('new');
         removeClass = false;
     });
     $("body").click(function() {
         removeClass = true;
     });
     $(".defaultP").mouseover(function(){
            $('.color_bg p').css("display","block");
     });
     $(".defaultP").mouseout(function()
     {
            $('.color_bg p').css("display","none");
            });
  </script>  
