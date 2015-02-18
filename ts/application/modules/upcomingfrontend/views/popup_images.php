<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php

$fullscreenArray['fullscreenArray']= $popupImages;
$this->load->view('common/full_screen_gallery',$fullscreenArray);

?>

 <div class="fr ptr mr62 mt50 pr gallFullscreen" id = "fullScreenButton" title="<?php echo $this->lang->line('fullScreen');?>"  ><input id="fullScreenCurrentImage" type="hidden" value="0"></div>
<div id="popup_close_btn" class="popup_close_btn" onclick="$(this).parent().trigger('close');"></div>
    <div class="bg_white">
		    
      <div class="bg_grey_img pt20 pb20 pl20 pr20">
		
        <div class="up_partition_shadow shade_position"></div>
        <div class="seprator_30"></div>
        <!-- AnythingSlider #2 -->
     
		<div id="imageHolder" class="anythingSlider anythingSlider-default activeSlider">
	
		<div class="gallary_img_wrapper ptr"  id="myToogleSlideshowButton" >	
		<div id="imageDiv">
		<div class="AI_table w568_h380px">
			<div id="loaderDiv">loading..</div>
            <div class="AI_cell">
				<img src=""  onclick="javascript:void(0);"  class="max_w568_h380" />
			</div>
        </div>
	
		</div>
		</div>	
		<div id="messageDiv"></div>
		<div id="imageDescription"></div>

		<?php 
		$base_img_url = base_url().'images/frontend/banners/';
		//$imgarray: Passed from the module
		echo '<div class="dn anythingWindow">';
		echo '<ul id="imageList">';
		$defaultImage = $this->config->item('defaultNoMediaImg');	
		foreach($popupImages as $upcomingPUImg){					
		//echo '<pre />';		print_r($upcomingPUImg);die;
		$thumbImage = addThumbFolder(@$upcomingPUImg['filePath'].'/'.$upcomingPUImg['fileName'],'_l');	
		//if(file_exists($thumbImage))
		{			
			$thumbFinalPromoImg = getImage(@$thumbImage,$defaultImage);
			
			echo '<li originalImage="'.$thumbFinalPromoImg.'"><img onclick="javascript:loadMe(this)" src="'.$thumbFinalPromoImg.'" class="max_w568_h380" />';
			?>
			 <div class="dn">
			   <div class="seprator_55"></div>
				<!--text box-->
				<div class=" pt24 ml10 mr10">
				  <div>
					<div class="up_popup_titlebottom"><?php echo getSubString($upcomingPUImg['mediaTitle'],50);?></div><!-- End  up_popup_titlebottom -->
					<div class="pt15">
					  <p><?php echo changeToUrl(getSubString($upcomingPUImg['mediaDescription'],200));?></p>
					</div>
				  </div>
			  </div><!-- End  pt24 ml10 mr10 -->
			 </div>
			<?
			echo '</li>';
			}
		}//If file exists
		echo '</ul>';
		echo '</div>';
		?>
	<div class="anythingSlider-default">
	<span class="arrow back"><a href="javascript:prevImage()"><span></span></a></span>
	<span class="arrow forward"><a href="javascript:nextImage()"><span></span></a></span>
	</div>
<script>
	$.gallery={options:{_imageListUL:'#imageList',
						_imageHolderDIV:'#imageHolder',
						_imageDiv:"#imageDiv",
						_imageDescriptionDiv:'#imageDescription',
						_imageActiveCSS:'imgActiveBorder',
						_imageLoader:'#loaderDiv',
						_autoPlay:false,
						_delay:5000,
						_currentImageIndex:'<?php echo $activeRecord-1;?>'
						}};
	
	$(document).ready(function(){
		initialise();
		viewGalleryFullScreen();
	});	
</script>
