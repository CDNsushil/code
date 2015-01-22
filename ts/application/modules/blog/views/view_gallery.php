<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php $browseImgJs = '_blogImg'; ?>
<script language="javascript" type="text/javascript" src="<?php echo $this->config->item('base_url'); ?>templates/system/javascript/imageUpload.js"></script>


<?php

$countDiv = 1;
$gallery_thumbs_folder = $gallery_thumb_version_folder.'/';
$galleryThumbsFolderPath = 'media/'.LoginUserDetails('username').'/project/blog/gallery/'.$gallery_thumbs_folder;//defining the path to show images

?>

<!--div id="iframe_container" align="center">
<iframe src="<?php echo $this->config->item('base_url'); ?>en/blog/display_upload" frameborder="0"  style="height:85px;width:400px;"></iframe>
</div><!-- End Div iframe_container-->


<div id="images_container" class=" width290px max_h_200 overflowAuto">
<?php

if(isset($imagesGal) && count($imagesGal)>0){
	
	foreach($imagesGal as $imagename) {
	
	if($countDiv ==1) echo '<div class="row">';
		// Use strrpos() & substr() to get the file extension
		if(isset($imagename->filePath)){

			$smallimage = addThumbFolder(@$imagename->filePath.'/'.@$imagename->fileName,'_xxs');	
			$mediumimage = addThumbFolder(@$imagename->filePath.'/'.@$imagename->fileName,'_m');	
				
			$defaultImage_xs = $this->config->item('defaultBlogImg_xxs');			
			
			$defaultImage = $this->config->item('defaultBlogImg_s');
			$showImageName = getImage($smallimage,$defaultImage_xs);
			$medImageName = getImage($mediumimage,$defaultImage);
			
			//echo '<div class="img"><img class="galleryImg"  id="'.$imagename->postGalleryId.'" onmousedown="insertNodeOverSelection(this, document.getElementById(\'myInstance1\'),'.$imagename->postGalleryId.');" src="'.$image.'" alt="no Image Avail image" width="80px" height="90px" /></div>';
			?>			
				<div class="cell wp_blog_gal_img mr5 mb5 imgdiv">
					<div class="AI_table">
						<div class="AI_cell">
						<?php
							echo '<div class="img ptr" onclick="selectImage(\''.$medImageName.'\',\''.@$imagename->mediaTitle.'\')"><img class="galleryImg max_w95_h83" name="'.$medImageName.'" id="'.$imagename->mediaId.'"  src="'.$showImageName.'" alt="'.@$imagename->mediaTitle.'" class="review_thumb"/></div>';
						?>
						</div>
					</div>
				</div>			
			<?php
			if($countDiv == 3) {		
				$countDiv = 0;		
				if($countDiv == count($imagesGal))
					echo '</div>';
				else
					echo '</div>';
			}
			$countDiv++;
		}
	}
}else echo '<div class="row orange" align="center">'.$this->lang->line('noGal').'</div>';
?>

</div><!-- End Div images_container-->
<script>
$(function() {
   var links = $(".imgdiv").click(function() {
       links.removeClass('backgroundOrange');
       $(this).addClass('backgroundOrange');
   });
});
</script>
