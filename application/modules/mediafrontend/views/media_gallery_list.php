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
    

    //------prepare the element details data---------//
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

    //------about page link prepare--------//
    $aboutPageLink          =     'mediafrontend/mediashowcases/'.$frentendUserId.'/'.$projectId.$previewWord;
    $aboutPageLink          =      base_url_lang($aboutPageLink);
    
    $galleryPageLink        =     'mediafrontend/mediagallery/'.$frentendUserId.'/'.$projectId.$previewWord;
    $galleryPageLink        =      base_url_lang($galleryPageLink);
    
    $otherCollectionsLink      =    'showproject/othercollections/'.$frentendUserId.'/filmNvideo'.$previewWord;
    $otherCollectionsLink      =     base_url_lang($otherCollectionsLink);
   
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
    
?>

<div class="row content_wrap" >
   <?php
        //---------load header navigation menu---------//
        $viewData = array(
            //'headingName'   =>   $this->lang->line('filmNvideo_gallery_heading'),
            'headingName'   =>   '',
            'navigation_1'  =>   $galleryPageLink,
            'navigation_2'  =>   $aboutPageLink,
            'navigation_3'  =>   $otherCollectionsLink,
            'activeMenu'    =>  'menu1',
            'categoryId'    =>  $this->config->item('FvCollectionCatId'),
        );
        $this->load->view('common_view/media_showcase_header_view',$viewData);
    ?>
    
    <div class="galleryviewdiv">   
        <?php $this->load->view('media_gallery_list_view'); ?>
    </div>
    
    
   <div class="thumbnail gallery_thumb">
      <ul class="thumb" >
        <?php
        
             
           if(!empty($elementDataList)){
                $elementSqCount = 1;
                foreach($elementDataList as $element){
                    if($element['elementType']==0 && !in_array($element['elementType'], $allowElementType)){
                        
                    $elementTitle       =   $element['title'];
                    $jobStsatus         =   $element['jobStsatus'];
                    $isElementPrice     =   (!empty($element['isPrice']))?$element['isPrice']:'f';
                    
                    //get element file type
                    $getElementFileType = ($isElementPrice=="t")?'DVD':'VIDEO';
                    $elementPriceShowGallery = ($isElementPrice=="t")?$element['price']:$element['downloadPrice'];
                    
                    if(empty($element['imagePath'])){	
                        $thumbImage = getVideoThumbFolder(@$element['filePath'].$element['fileName'],'_m');	
                        $elementImage=getImage($thumbImage,$imagetype_m);	
                    }else{
                        $thumbImage = addThumbFolder(@$element['imagePath'],'_m');	
                        $elementImage=getImage($thumbImage,$imagetype_m);
                    }
                    
                    if($jobStsatus!="DONE"){
                        $elementImage = $imgPath.'error_small.png';
                    }
                    
                    
                    $elementUrl=base_url(lang().$urlUsername.'/mediafrontend/mediagallery/'.$frentendUserId.'/'.$projectId.'/'.$element['elementId'].$previewWord);
                  
                    $aboutMore=base_url(lang().$urlUsername.'/mediafrontend/mediadetails/'.$frentendUserId.'/'.$projectId.'/'.$element['elementId'].$previewWord);
        ?>
             <li>
                <div class="table_cell">
                   <img src="<?php echo $elementImage; ?>" alt="" />
                   
                    <?php 
                    $isPriceShow = false;
                    if($projSellstatus && $jobStsatus=="DONE" && !empty($elementPriceShowGallery)){ 
                    $priceDetails = getDisplayPrice($elementPriceShowGallery,$sellerCurrency);    
                    ?>
                        <div class="play_btn_vedio"><span class=" p10"> <?php 
                             $isPriceShow = $priceDetails['currencySign'].''.$priceDetails['displayPrice'];
                             echo $isPriceShow;
                        ?></span></div>
                    <?php } ?>
                   
                   <div class="thum_text box_onbanner">
                      <div class="count fs16"><span class=""><?php echo $elementSqCount; ?></span>/<span class="total-slides"><?php echo $elementCount; ?></span></div>
                      <span class="title"><?php echo $elementTitle; ?></span> 
                      <div class="sap_15"></div>
                      <a href="javascript:void(0)" url="<?php echo $elementUrl; ?>" class="fshel_light fs16 video_element_view"><span><?php echo $this->lang->line('filmNvideo_more_about_this'); ?> <?php echo $getElementFileType; ?></span></a> 
                        
                        <?php if($isPriceShow && $jobStsatus=="DONE" && !empty($elementPriceShowGallery)){ ?>
                            <div class="play_btn_vedio"><span class=""> <?php echo  $isPriceShow; ?></span></div>
                        <?php } ?>
                        <?php if($projSellstatus==false && $jobStsatus=="DONE"){ ?>
                            <div class="play_btn_vedio"><img src="<?php echo $imgPath; ?>play_btn_Gsmall.png" alt=""></div>
                        <?php } ?>
                   </div>
                </div>
            </li>
        <?php 
                $elementSqCount++;
                    }
                }
            }
        ?>
         
      </ul>
   </div>
</div>

<script type="text/javascript" >
    
    $(document).on("click",".video_element_view",function(){
        
        var posturl = $(this).attr('url');
        
        $.ajax({     
            type: "POST",
            dataType: 'html',
            data:{'galleryelementview':'yes'},			
            url: posturl,
            beforeSend: function() {
                loader();
            },
            success: function(data){  
                $(".new_verion_loader").loaderHide();
                $(".galleryviewdiv").html(data);
            }
        });
        
    });
    
</script>  

