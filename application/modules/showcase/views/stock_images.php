<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$browseImgJs = '_showcaseImgJs';
?>

<script language="javascript" type="text/javascript">
$(document).ready(function(){
  
$('.stockImg').click(function() {

	var par = window.document;
	
	var new_img = par.createElement('img');
	
	new_img.src = $(this).attr('src');
	
	var showimg = $(this).attr('name');
		
	var newPath = new_img.src.substring(0, new_img.src.lastIndexOf('/')); // let's get file name without filename
	
	var medium_image_name = newPath+'/'+showimg;
	
	new_img.src = medium_image_name;
	
	$('#galImg_<?php echo $browseImgJs;?>').attr('src',new_img.src);
	$('#fileInput<?php echo $browseImgJs;?>').val('');
	$('#fileInput<?php echo $browseImgJs;?>').removeClass('required');
	$('#stockImageId').val($(this).attr('id'));

	$('#stockImagesBoxWp').trigger('close');

});
});
</script>
<?php

foreach($stockImages as $imagename) {
	
	$showImageName = $imagename->stockFilename;
	$stockImagesFolderPath = $imagename->stockImgPath.'/';
	
	$image = getImage($stockImagesFolderPath.$showImageName);
		
	
		//echo '<div class="img"><img class="galleryImg"  id="'.$imagename->postGalleryId.'" onmousedown="insertNodeOverSelection(this, document.getElementById(\'myInstance1\'),'.$imagename->postGalleryId.');" src="'.$image.'" alt="no Image Avail image" width="80px" height="90px" /></div>';
		echo '<div class="stockimg ptr"><img class="stockImg" name="'.$showImageName.'" id="'.$imagename->stockImgId.'"  src="'.$image.'" alt="'.$showImageName.'" /></div>';
	
	}
?>
