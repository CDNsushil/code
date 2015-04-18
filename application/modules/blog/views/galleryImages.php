<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<div id="YesNoBoxWp" class="customAlert" style="display:none; width:430px;">
	<div id="close-YesNoBox" title="" class="tip-tr close-customAlert"></div>			
	<div class="row">
		<div class="cell"><?php echo $label['msgBeforeDelete'];?></div> 
	</div>
	<div class="row">
		<div class="cell">
			<div class="tds-button floatRight">
				<?php echo anchor('javascript://void(0);', '<span>Yes</span>',array('onclick'=>'deleteGallery(\'t\');','onmousedown'=>'mousedown_tds_button(this);','onmouseup'=>'mouseup_tds_button(this);')); ?>
			</div>
		</div>
		<div class="cell">
			<div class="tds-button floatRight">
				<?php echo anchor('javascript://void(0);', '<span>No</span>',array('onclick'=>'noGallery();','onmousedown'=>'mousedown_tds_button(this);','onmouseup'=>'mouseup_tds_button(this);')); ?>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="cell frm_heading">
		<h1><?php echo $label['mediaGallery'];?></h1>
	</div>
	<?php echo Modules::run("blog/navigationMenu",$blogId); ?>
</div>	
<?php

	if((isset($userId) && $userId>0) )
	{
		$galleryImages['strip'] = 1;//echo '<pre />';print_r($galleryImages);
		$galleryImages['promomsg'] = $this->lang->line('mediaGalleryMsg');//echo '<pre />';print_r($galleryImages);
		$galleryImages['showaddbutton'] = 1;//echo '<pre />';print_r($galleryImages);
		$galleryImages['promoImgTitle'] = $this->lang->line('altTags');//echo '<pre />';print_r($galleryImages);
		$galleryImages['blogId'] = $blogId;//echo '<pre />';print_r($galleryImages);
		echo $this->load->view('mediatheme/promoImgAccordView',$galleryImages);
	} 

?>
<script>
//Functionality for "YES" button of prompt
function deleteGallery(confirmflag){
	if(confirmflag=='t'){
		document.GalleryAction.submit();
	}
	else{
		$('#YesNoBoxWp').trigger('close');	
	}			
}

//Functionality for "NO" button of prompt
function noGallery(){
	$('#YesNoBoxWp').trigger('close');	
}

//Delete the selected gallery image if no gallery is selected alert with message
function showYesNo()
{
	var n = $("input:checked").length;
	if(n>0){
		$("#YesNoBoxWp").lightbox_me('center:true');
	}else{
		alert('Please tick the checkbox(s) to delete');
		return false;
	}
}
</script>
