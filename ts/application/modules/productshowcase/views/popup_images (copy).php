 <?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>


<div id="popup_close_btn" class="popup_close_btn" onclick="$(this).parent().trigger('close');"></div>
 
      <div class="darkGrey_bg bdr_7E7E7E" style="width:950px;">
        <div class="gall_btn"><a href="javascript:prevImage()" class=" gall_pre_btn Fleft"></a> <a href="javascript:nextImage()" class="gall_next_btn Fright"></a></div>
        <div class="seprator_30"></div>
        <!-- imageholder -->
        <div class="advance_gallary_img_wrapper">
          <div class="AI_table">
            <div class="AI_cell">
              <div id="imageHolder">
                <div id="imageDiv"><a href="" target="_blank"><img src="" class="max_w762_h512" /></a>
                  <div id="loaderDiv">loading..</div>
                </div>
                <div id="messageDiv" class="hidden"></div>
                <div id="imageDescription" class="hidden"></div>
              </div>
            </div>
          </div>
        </div>
        <!--imageholder end-->
        <div class="seprator_30"></div>
        <!--thumbnail box start-->
         <div class="advance_gallary_main_box">
          <div id="slider6" class="slider advance_gallary_scroll_btn">
			<a class="buttons prev mb2" href="#"></a>
            <div class="viewport advance_gallary_container" >
              <ul class="overview" id="imageList" style="height: 2820px; top: 0px;">
				  <?php
				
				  foreach($promo_images as $img_count => $promoImagesDetail)
				  {	
				
				   $Img = getImage(@$promoImagesDetail['filePath'].@$promoImagesDetail['fileName'],$this->config->item('defaultreviewsImg'));
				  
				  ?>
					<li onclick="javascript:loadMe(this)" originalImage="<?php echo $Img;?>" >
					 
					  <div class="advance_thumbnail">
						<div class="AI_table">
						  <div class="AI_cell"><img src="<?php echo $Img;?>" class="max_w200_h150 bdr_cecece"></div>
						</div>
					  </div>
					  <div class="advance_gallery_title"><?php echo getSubString($promoImagesDetail['mediaTitle'],60);?></div>
					</li>
				  <?php 
					
					
				  }
				?>
              </ul>
            </div>
            <a class="buttons next mt5" href="#"></a> </div>
        </div>
        <!--thumbnail box end-->
        <div class="seprator_30"></div>
      </div>
    
<script>

$.gallery={options:{_imageListUL:'#imageList',
					_imageHolderDIV:'#imageHolder',
					_imageDiv:"#imageDiv",
					_imageDescriptionDiv:'#imageDescription',
					_imageActiveCSS:'imgActiveBorder',
					_imageLoader:'#loaderDiv',
					_autoPlay:false,
					_delay:3000,
					_borderAreaDivClass:'.advance_thumbnail',
					_currentImageIndex:0,
					_callBackMethod:movePage }};

function movePage(data){
	$('#slider6').tinycarousel({ axis: 'y', display: 1,groupStep:3, start:Math.round(data.currentImageIndex/3)});
}			
//$('#slider6').tinycarousel({ axis: 'y', display: 1,groupStep:3, start:8});	
	$(document).ready(function() {
		initialise();	
	});	

</script>
