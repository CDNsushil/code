 <?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

 $showGallery = (isset($showGallery)) ? $showGallery : 1;
 
 if($showGallery==1){   ?>

	<div class="row summery_right_archive_wrapper width_auto">
		<h1 class="sumRtnew_strip"><?php echo $this->lang->line('gallery');?>
			 <div class="text_indent0 Fright mr28 ">
				 <a class="veiw_gallary_btn" onmouseup="mouseup_viewG_btn(this)" onmousedown="mousedown_viewG_btn(this)" onclick="loadPopupData('popupBoxWp','popup_box',popup_images);"><div class="Fleft "><?php echo ucfirst($this->lang->line('view'));?></div><div class="btn_gallary_icon"></div></a>
			</div>
		</h1>
	</div>

<?php } else { ?>

<div class="row summery_right_archive_wrapper width_auto">
		<h1 class="sumRtnew_strip"><?php echo $this->lang->line('gallery');?>
			 <div class="text_indent0 Fright mr28 ">
				 <a class="veiw_gallary_btn opacity_4 formTip"><div class="Fleft"><?php echo ucfirst($this->lang->line('view'));?></div><div class="btn_gallary_icon"></div></a>
			</div>
		</h1>
	</div>


<?php } ?>
