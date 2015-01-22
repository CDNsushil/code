<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<style type="text/css">
div.img
  {
  margin:2px;
  border:1px solid #CCCCCC;
  height:auto;
  width:auto;
  float:left;
  text-align:center;
		background-color:#FFFFFF
  }
div.img img
  {
  display:inline;
  margin:3px;
  border:1px solid #CCCCCC;
  }

</style>

<script language="javascript" type="text/javascript" src="<?php echo $this->config->item('base_url'); ?>templates/system/javascript/imageUpload.js"></script>


<?php

$gallery_thumbs_folder = $gallery_thumb_version_folder.'/';
$galleryThumbsFolderPath = 'media/'.LoginUserDetails('username').'/project/blog/gallery/'.$gallery_thumbs_folder;//defining the path to show images

?>

<div id="iframe_container" align="center">
<iframe src="<?php echo $this->config->item('base_url'); ?>en/blog/display_upload" frameborder="0"  style="height:85px;width:400px;"></iframe>
</div><!-- End Div iframe_container-->


<div id="images_container" style="width:500px;height:300px;overflow:auto;">
<?php
if(isset($imagesGal)){
	foreach($imagesGal as $imagename) {
	// Use strrpos() & substr() to get the file extension
	$ext = substr($imagename->galPath, strrpos($imagename->galPath, "."));
	$showImageName = basename($imagename->galPath, $ext) . $suffix . $ext;
	$medImageName = basename($imagename->galPath, $ext) . $mediumSuffix . $ext;
	$image = getImage($galleryThumbsFolderPath.$showImageName);
		
	if(file_exists($galleryThumbsFolderPath.$showImageName)) $showOrgImage =1;
	else  $showOrgImage =0;
	if($showOrgImage == 1){
		//echo '<div class="img"><img class="galleryImg"  id="'.$imagename->postGalleryId.'" onmousedown="insertNodeOverSelection(this, document.getElementById(\'myInstance1\'),'.$imagename->postGalleryId.');" src="'.$image.'" alt="no Image Avail image" width="80px" height="90px" /></div>';
		echo '<div class="img"><img class="galleryImg" name="'.$medImageName.'" id="'.$imagename->postGalleryId.'"  src="'.$image.'" alt="'.$medImageName.'" height="90px" /></div>';
		}
	}
}
?>
</div><!-- End Div images_container-->
