 <?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


$fileType = '2';
$duration = 5;

?>

<div id="popup_close_btn" class="popup_close_btn" onclick="$(this).parent().trigger('close'); $('#popup_box').html(''); "></div>
 
      <div class="darkGrey_bg bdr_7E7E7E" style="width:950px;">
        <div class="gall_btn"><a href="javascript:prevImage()" class=" gall_pre_btn Fleft"></a> <a href="javascript:nextImage()" class="gall_next_btn Fright"></a></div>
        <div class="seprator_30"></div>
        <!-- imageholder -->
        <div class="advance_gallary_img_wrapper">
          <div class="AI_table">
            <div class="AI_cell">
              <div id="imageHolder">
                <div id="imageDiv">
                    <iframe src="" width="762" height="511" webkitAllowFullScreen mozallowfullscreen allowFullScreen scrolling="no" style="margin:0; padding:0; border:0px solid #CC00DD;"></iframe> 	
                </div>
                <div id="loaderDiv"  class="mediaLoadDiv"></div>
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
				  $final_video_img = array();
				  foreach($video_array as $video_count => $video)
				  {	
				
				  if(isset($elementId[$video_count]) && @$elementId[$video_count]!='')	{	
					
					  $final_video_img[$video_count] = getImage($img_array[$video_count],$this->config->item('defaultVideoImg')); 
				  
				  ?>
					<li onclick="javascript:loadMe(this)"  targetpath="<?php echo $video;?>" >
					 
					  <div class="advance_thumbnail">
						<div class="AI_table">
						  <div class="AI_cell"><img src="<?php echo $final_video_img[$video_count];?>" class="max_w200_h150 bdr_cecece"></div>
						</div>
					  </div>
					  <div class="advance_gallery_title"><?php echo @$title_array[$video_count];?></div>
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
					_callBackMethod:movePage,
					_viewerType:'video' }};

function movePage(data){
	$('#slider6').tinycarousel({ axis: 'y', display: 1,groupStep:3, start:Math.round(data.currentImageIndex/3)});
}			
//$('#slider6').tinycarousel({ axis: 'y', display: 1,groupStep:3, start:8});	
	$(document).ready(function() {
		initialise();
	
	});	
loader("loaderDiv");
</script>
