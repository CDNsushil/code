<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    //add preview word if preview mode is active
    $previewWord =  (previewModeActive())?"/preview":"";
    
    //--------element require default data--------//
    $imagetype_b            =   $fileConfig['defaultImage_b'];
    $imagetype_m            =   $fileConfig['defaultImage_m'];
    $imagetype_l            =   $fileConfig['defaultImage_l'];
    $imagetype_xxl          =   $fileConfig['defaultImage_xxl'];
    $imagetype_xs           =   $fileConfig['defaultImage_xs'];
    $imagetype_s            =   $fileConfig['defaultImage_s'];
    
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

    //total element of this gallery
    $elementNumberCount    =   count($elementDataList);
    
    //get element data
    $categoryId             =    (!empty($elementData['catId']))?$elementData['catId']:'1';
    
    //------about page link prepare--------//
    $aboutPageLink          =     'mediafrontend/photoartdetails/'.$frentendUserId.'/'.$projectId.$previewWord;
    $aboutPageLink          =      base_url_lang($aboutPageLink);
    
    $galleryPageLink        =     'mediafrontend/photoartgallery/'.$frentendUserId.'/'.$projectId.$previewWord;
    $galleryPageLink        =      base_url_lang($galleryPageLink);
    
    $otherCollectionsLink      =    'showproject/othercollections/'.$frentendUserId.'/photographyNart'.$previewWord;
    $otherCollectionsLink      =     base_url_lang($otherCollectionsLink);
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
            <div class="galleryviewdiv" id="fullscreen">
                
                <?php echo $this->load->view('photo_art_gallery_list_view'); ?>
                
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
                    
                    $elementUrl=base_url(lang().$urlUsername.'/mediafrontend/photoartgallery/'.$frentendUserId.'/'.$projectId.'/'.$getElementData['elementId'].$previewWord);

                    $aboutMore=base_url(lang().$urlUsername.'/mediafrontend/photoartelement/'.$frentendUserId.'/'.$projectId.'/'.$getElementData['elementId'].$previewWord);

                ?>
                   <li class="item"  >
                      <img src="<?php echo $showElementImage; ?>" alt="" />
                      <div class="thum_text box_onbanner" >
                         <div class="count">
                            <span class=""><?php echo $elementCount; ?></span>
                            /
                            <span class="total-slides"><?php echo $elementNumberCount; ?></span>
                         </div>
                         <span class="title"><?php echo $elementTitle; ?></span>
                         <div class="sap_15"></div>
                         <a href="javascript:void(0)"  url="<?php echo $elementUrl; ?>" class="fshel_light fs16 photo_element_view"><span>ABOUT THIS <?php echo strtoupper($galleryElement); ?></span></a> 
                      </div>
                   </li>
               
                 <?php $elementCount++; }   } ?>
            </ul>
         </div>
         <div class="sap_20"></div>
      </div>
   </div>
</div>
          
         
<script type="text/javascript" >
    
    $(document).on("click",".photo_element_view",function(){
        
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
                
                
                if ($.fullscreen.isFullScreen()) {
                    $(".hideshowfullscreen").hide();
                    $('#fullscreen .requestfullscreen').hide();
                    $('#fullscreen .exitfullscreen').show();
                    $('body').removeClass("new");
                }
            }
        });
        
    });
    
</script>  
