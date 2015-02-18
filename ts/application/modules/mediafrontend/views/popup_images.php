<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
//echo '<pre />';print_r($img_array); die;
$fullscreenArray['fullscreenArray']= $img_array;
$this->load->view('common/full_screen_gallery',$fullscreenArray);
?>


<div id="popup_close_btn" class="popup_close_btn" onclick="$(this).parent().trigger('close');"></div>
 
      <div class="darkGrey_bg bdr_7E7E7E" style="width:950px;">  
      <div class="fr ptr mr52 mt28 gallFullscreen"  id="fullScreenButton" title="<?php echo $this->lang->line('fullScreen');?>" ><input id="fullScreenCurrentImage" type="hidden" value="0"></div>
        <div class="gall_btn"><a href="javascript:prevImage()" class=" gall_pre_btn Fleft"></a> <a href="javascript:nextImage()" class="gall_next_btn Fright"></a></div>
        <div class="seprator_30"></div>
        <!-- imageholder -->
        <div class="advance_gallary_img_wrapper ptr"  id="myToogleSlideshowButton" >
          <div class="AI_table">
            <div class="AI_cell">
              <div id="imageHolder">
                <div id="imageDiv"><img src="" class="max_w762_h500 bdr_5f5f5f_2" />
                </div>
                <div id="loaderDiv" ></div>
                <div id="messageDiv" class="hidden tac clr_white"><?php echo '<img src="'.getImage('',$this->config->item('defaultNoMediaImg')).'" />'; ?></div>
                <div id="imageDescription" class="hidden tac clr_white"></div>
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

				  $defaultImage = $this->config->item('defaultNoMediaImg');
				  foreach($img_array as $img_count => $img)
				  {	
				  //echo '<pre />';print_r($img);die;				
				  if(isset($elementId[$img_count]) && @$elementId[$img_count]!='')	{	 
				  
				  ?>
					<li onclick="javascript:loadMe(this)" originalImage="<?php echo @$img['l'];?>" href="<?php echo @$redirectUrl.'/'.@$elementId[$img_count].'/photographyart';?>">
					 
					  <div class="advance_thumbnail">
						<div class="AI_table">
						  <div class="AI_cell"><img src="<?php echo @$img['m'];?>" class="max_w200_h150 bdr_cecece"></div>
						</div>
					  </div>
					  <div class="advance_gallery_title"><?php echo @$title_array[$img_count];?></div>
					</li>
				  <?php 
					
					}
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
		viewGalleryFullScreen();	
	});	
loader("loaderDiv");

 
</script>
