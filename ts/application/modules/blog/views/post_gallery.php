<div class="Right_side_panel" style="background-color:#FFFFFF">
Post Gallery
<div style="padding:20px">
<div style="border-bottom:solid 1px #999999; height:20px;">
<div style="float:left;">#</div><div style="float:left; padding:0 75px 5px 5px;">Image</div><div style="float:left; padding:0 5px 5px 5px;">File</div><div style="float:left; padding:0 5px 5px 5px;">Attached to</div><div style="float:left; padding:0 5px 5px 5px;">Date</div>
</div>
<span class="clear_seprator "></span>

<?php
$i=0;
foreach($postGalleryResults as $row){

	$galleryImage = $row->galPath;
	if (@getimagesize(urlencode(base_url("images/Blog/".$galleryImage)))) {
		$galleryImageAvail = $galleryImage;
	}
	else {
		$galleryImageAvail ="noImgAvail.jpg";
		
	}
	
	$attachedDate = date("m/d/Y", strtotime($row->attachedDate));
	$galleryImageUrl = '<img src="'.base_url("images/Blog/".$galleryImageAvail).'" alt="no Image Avail image" width="100px" height="100px" />'."<br /><br />";
	
	echo '<div style="float:left; padding:0px;"><input type="checkbox" name="ckb'.$i++.'" value="'.$galleryImageAvail.'"></div>
	<div style="float:left; padding:0px;">'.$galleryImageUrl.'</div>
	<div style="float:left; padding:0 20px 5px 5px;">'.$row->galPath.'</div>
	<div style="float:left; padding:0 35px 5px 5px;">'.$row->postId.'</div>
	<div style="float:left; padding:0 5px 5px 5px;">'.$attachedDate.'</div>
	<span class="clear_seprator "></span>';


	
}//End ForEach
?>
</div>
</div>