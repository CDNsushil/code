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
        $previousPageLink       =     'mediafrontend/photoartgallery/'.$frentendUserId.'/'.$projectId.'/'.$previousElementId;
        $previousPageLink       =     base_url_lang($previousPageLink);
    endif;
    
    //previous element show page link id get
    if($currentKeyPosition < ($elementNumberCount-1)):
        $nextElementId      =    $elementPrepareList[$currentKeyPosition+1];
        $nextPageLink       =    'mediafrontend/photoartgallery/'.$frentendUserId.'/'.$projectId.'/'.$nextElementId;
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
   // print_r($elementData);
    
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
    $aboutPageLink          =     'mediafrontend/photoartdetails/'.$frentendUserId.'/'.$projectId;
    $aboutPageLink          =      base_url_lang($aboutPageLink);
    
    $galleryPageLink        =     'mediafrontend/photoartgallery/'.$frentendUserId.'/'.$projectId;
    $galleryPageLink        =      base_url_lang($galleryPageLink);
    
    $moreAboutVideLink      =     'mediafrontend/photoartelement/'.$frentendUserId.'/'.$projectId.'/'.$elementId;
    $moreAboutVideLink      =     base_url_lang($moreAboutVideLink);
    
    $otherCollectionsLink      =    'showproject/othercollections/'.$frentendUserId.'/photographyNart';
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

<div class="newlanding_container wrap_art">
    <?php
        //---------load header navigation menu---------//
        $viewData = array(
            'headingName'   =>   $this->lang->line('photographyNart_detail_heading_'.$categoryId),
            'navigation_1'  =>  $galleryPageLink,
            'navigation_2'  =>  $aboutPageLink,
            'navigation_3'  =>  $otherCollectionsLink,
            'activeMenu'    =>  'menu1',
            'categoryId'    =>  $categoryId,
        );
        $this->load->view('common_view/media_showcase_header_view',$viewData);
    ?>
   <div class="row width_100_per js-idex">
      <div class="banner_2 " >
         <div id="fullscreen" class="zoom_wrap">
            <div class="wrap_tab">
                <div class="sap_25"></div>
               <div class="new_wrap clearb">
                   
                  <div class="fl fs24  pl25 opens_light"><?php echo $projName; ?></div>
                  <div class="fr ps_1 fs14 mt10">
                     <div class="icon_view3_blog icon_so"><?php echo  $viewCount; ?></div>
                     <div class="icon_crave4_blog icon_so <?php echo  $craveDivAction.' '.$cravedALL;?>"><?php echo  $craveCount; ?></div>
                     <div class="fl mt5 mr10  <?php echo $rateDivAction; ?>"> <img src="<?php echo ratingImagePath($ratingAvg);?>" alt=" "  /> </div>
                     <div class="btn_share_icon pr0 icon_so "><?php echo $reviewCount; ?></div>
                  </div>
               </div>
<div class="sap_20"></div>
               <div class="color_bg">
                  <div class="defaultP">
                     <input type="checkbox" name="item[]" id="banana" value="banana" />
                  </div>
                  <p  class="p1">View with white background </p>
                  <p class="p2">View with dark background </p>
               </div>
               <div id="slider" class="flexslider bg_f2f2">
                  <div class="full_wrap"> <a href="#" class="requestfullscreen fs-button" ></a><a href="#" class="exitfullscreen fs-button" style="display: none"></a> </div>
                  <ul class="slides">
                     <li>
                         <?php 
                            $thumbImage      = addThumbFolder($filePath.$fileName,'_xxl',$thumbFolder);	
                            $showElementImage=getImage($thumbImage,$imagetype_xxl);
                        ?>
                        <img src="<?php echo $showElementImage; ?>"  alt=""/>
                        <div class="slide-text box_onbanner">
                           <h2 class="text_alighL fl fnt_mouse "><?php echo $title;?></h2>
                           <a href="<?php echo $moreAboutVideLink; ?>" class="fr fshel_light fs16 more">More About the <?php echo $elementFileType; ?></a>
                           <div class="count"><span class="current-slide"><?php echo $currentElementView; ?></span> / <span class="total-slides"><?php echo $elementNumberCount; ?></span></div>
                        </div>
                     </li>
                  </ul>
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
                    <div class="social_wrap fr box_onbanner "> 
                           <?php 
                                //-------load module of social listing share---------------//
                                $shareData=array('url'=>$currentShortUrl,'isPublished'=>$isPublished,'designType'=>'3');
                                echo Modules::run("share/sharesocialshowview",$shareData);	
                            ?>    
                    </div>
               </div>
            </div>
         </div>
         <div class="thumbnail">
            <ul class="thum_wrap" id="container" >
              <?php 
                    if(!empty($elementDataList)){
                    $elementCount=1;
                    foreach($elementDataList as $getElementData){
                        
                     $elementTitle       =   $getElementData['title'];
                      
                    $fileName               =   (!empty($getElementData['fileName']))?$getElementData['fileName']:''; 
                    $filePath               =   (!empty($getElementData['filePath']))?$getElementData['filePath']:''; 
                    $categoryId             =    (!empty($getElementData['catId']))?$getElementData['catId']:'1';
                    $isPrice                =    (!empty($getElementData['isPrice']))?$getElementData['isPrice']:'f'; 
                    $isPerViewPrice         =    (!empty($getElementData['isPerViewPrice']))?$getElementData['isPerViewPrice']:'f'; 
                    $isDownloadPrice        =    (!empty($getElementData['isDownloadPrice']))?$getElementData['isDownloadPrice']:'f'; 
                    
                    //photo gallery
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
                            $galleryElement = $this->lang->line('photographyNart_element_type_1_'.$categoryId);
                        break;
                        
                        case "media_file":
                            $galleryElement = $this->lang->line('photographyNart_element_type_2_'.$categoryId);
                        break;
                        
                        default:
                            $galleryElement = $this->lang->line('photographyNart_element_type_2_'.$categoryId);
                    }
                    
                    
                    
                    
                        
                    $thumbImage             =   addThumbFolder($filePath.$fileName,'_m',$thumbFolder);	
                    $showElementImage       =   getImage($thumbImage,$imagetype_m);
                    
                    $elementUrl=base_url(lang().$urlUsername.'/mediafrontend/photoartgallery/'.$frentendUserId.'/'.$projectId.'/'.$getElementData['elementId']);

                    $aboutMore=base_url(lang().$urlUsername.'/mediafrontend/photoartelement/'.$frentendUserId.'/'.$projectId.'/'.$getElementData['elementId']);

                ?>
               <li class="item ptr"  >
                    <img src="<?php echo $showElementImage; ?>" alt=""  />
                     <div class="thum_text box_onbanner" onclick="window.location.href='<?php echo $elementUrl; ?>'">
                        <div class="count"><span class=""><?php echo $elementCount; ?></span>/<span class="total-slides"><?php echo $elementNumberCount; ?></span></div>
                        <span class="title"><?php echo $elementTitle; ?></span> 
                        <a href="<?php echo $aboutMore; ?>" class="fshel_light fs16">VIEW <?php echo strtoupper($galleryElement); ?> > </a> 
                     </div>
               </li>
             
             <?php $elementCount++; }   } ?>
            </ul>
         </div>
         <div class="sap_20"></div>
      </div>
</div>
         
<script type="text/javascript" >
    window.onload = function(e){ 
         var container = document.querySelector('#container');
         var msnry = new Masonry( container, {
         "gutter":0,
         "itemSelector": ".item",
         columnWidth: 4,
                layoutMode: 'fitRow'
         
         });
    }

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
