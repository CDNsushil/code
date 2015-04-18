<?php
$location3 = $this->uri->segment(3);
$location2 = $this->uri->segment(2);
$lableNewPost = '<span>'.$label['newPost'].'</span>';
$labelBlogSetting = '<span>'.$label['aboutYourBlog'].'</span>';
$labelViewBlog = '<span>'.$label['viewAboutYourBlog'].'</span>';

$labelBlogArchive = '<span>'.$label['blogDelItems'].'</span>';
$labelIndexPage = '<span>'.$label['indexPage'].'</span>';
$labelMediaGallery = '<span>'.$label['mediaGallery'].'</span>';
$labelDeletedItems = '<span>'.$label['blogDelItems'].'</span>';
 
$currentBackpostId  = $this->session->userdata('postId');

if(isset($currentBackpostId) && $currentBackpostId>0) 
{
	$postLabel = '<span>'.$label['editPost'].'</span>';
	$postFormUrl = 'blog/postForm/'.$currentBackpostId;
}
else 
{
	$postLabel = '<span>'.$label['newPost'].'</span>';
	$postFormUrl = 'blog/postForm';	
}
 ?>
 <?php //echo 'dddd'.$postFormUrl;?>

<?php if($location3=='showArchives')
{ 
?>

<div class="frm_btn_wrapper">
	<div class="tds-button-big  Fleft mr5">
		<?php echo anchor('blog/postForm/0',$lableNewPost,array('onmousedown'=>'mousedown_big_button(this)', 'onmouseup'=>'mouseup_big_button(this)','onmouseover'=>'mouseover_big_button(this)'));?>
		<?php echo anchor('blog/blogForm',$labelBlogSetting,array('onmousedown'=>'mousedown_big_button(this)', 'onmouseup'=>'mouseup_big_button(this)','onmouseover'=>'mouseover_big_button(this)'));?>
		<?php echo anchor('blog',$labelIndexPage,array('onmousedown'=>'mousedown_big_button(this)', 'onmouseup'=>'mouseup_big_button(this)','onmouseover'=>'mouseover_big_button(this)'));?>
	</div>
</div>
<?php }?>

<?php if($location3=='postForm'){ ?>
<div class=" frm_btn_wrapper">
	<div class="tds-button-big  Fleft mr5">
		<?php //echo anchor('blog/blogForm', $labelBlogSetting,array('onmousedown'=>'mouseup_big_button(this)', 'onmouseup'=>'mouseup_big_button(this)','onmouseover'=>'mouseover_big_button(this)'));?>
		<?php echo anchor('blog/galleryimages',$labelMediaGallery,array('onmousedown'=>'mousedown_big_button(this)', 'onmouseup'=>'mouseup_big_button(this)','onmouseover'=>'mouseover_big_button(this)'));?>
		<?php echo anchor('blog', $labelIndexPage,array('onmousedown'=>'mousedown_big_button(this)', 'onmouseup'=>'mouseup_big_button(this)','onmouseover'=>'mouseover_big_button(this)'));?>
	</div>
</div>
<?php }?>

<?php if($location3=='blogForm'){
?>
<div class="frm_btn_wrapper">
	<!-- Start information about blog cover -->
	<!--<div class="fl f11 width300px mt5 mr85"><?php //echo $label['blogCoverInfo'];?></div>-->
	<!-- End information about blog cover -->
	<div class="tds-button-big Fleft mr5">
		<?php //echo anchor($postFormUrl,$postLabel,array('onmousedown'=>'mousedown_big_button(this)', 'onmouseup'=>'mouseup_big_button(this)','onmouseover'=>'mouseover_big_button(this)'));?>
		<?php echo anchor('blog/galleryimages',$labelMediaGallery,array('onmousedown'=>'mousedown_big_button(this)', 'onmouseup'=>'mouseup_big_button(this)','onmouseover'=>'mouseover_big_button(this)'));?>
		<?php echo anchor('blog',$labelIndexPage,array('onmousedown'=>'mousedown_big_button(this)', 'onmouseup'=>'mouseup_big_button(this)','onmouseover'=>'mouseover_big_button(this)'));?>
	</div>
</div>
<?php }?>

<?php if(($location2=='blog') && (($location3=='')|| ($location3=='index') || ($location3=='childPosts')|| ($location3=='postchild'))){?>
<div class="frm_btn_wrapper">
	<div class="tds-button-big Fleft mr10">
		<?php echo anchor('blog/postForm/0',$lableNewPost,array('onmousedown'=>'mousedown_big_button(this)', 'onmouseup'=>'mouseup_big_button(this)','onmouseover'=>'mouseover_big_button(this)'));?>
		<?php //echo anchor('blog/blogForm/', $labelViewBlog,array('onmousedown'=>'mousedown_big_button(this)', 'onmouseup'=>'mouseup_big_button(this)','onmouseover'=>'mouseover_big_button(this)'));?>
		<?php echo anchor('blog/showArchives/',$labelDeletedItems,array('onmousedown'=>'mousedown_big_button(this)', 'onmouseup'=>'mouseup_big_button(this)','onmouseover'=>'mouseover_big_button(this)'));?>
	</div>
</div>
<div class="row seprator_5"></div>
<?php }?>

<?php if($location3=='mediaGallery' || $location3=='galleryimages'){ ?>
<div class=" frm_btn_wrapper">
	<div class="tds-button-big Fleft mr5">
		<?php //echo anchor($postFormUrl,$postLabel,array('onmousedown'=>'mousedown_big_button(this)', 'onmouseup'=>'mouseup_big_button(this)','onmouseover'=>'mouseover_big_button(this)'));?>
		<?php echo anchor('blog/blogForm', $labelBlogSetting,array('onmousedown'=>'mousedown_big_button(this)', 'onmouseup'=>'mouseup_big_button(this)','onmouseover'=>'mouseover_big_button(this)'));?>
		<?php echo anchor('blog', $labelIndexPage,array('onmousedown'=>'mousedown_big_button(this)', 'onmouseup'=>'mouseup_big_button(this)','onmouseover'=>'mouseover_big_button(this)'));?>
	</div>
</div>
<?php }?>


<?php if($location3=='postMediaGalleryForm'){ ?>
<div class=" frm_btn_wrapper">
	<div class="tds-button-big Fleft mr5">
		<?php echo anchor($postFormUrl,$postLabel,array('onmousedown'=>'mousedown_big_button(this)', 'onmouseup'=>'mouseup_big_button(this)','onmouseover'=>'mouseover_big_button(this)'));?>
		<?php echo anchor('blog/blogForm', $labelBlogSetting,array('onmousedown'=>'mousedown_big_button(this)', 'onmouseup'=>'mouseup_big_button(this)','onmouseover'=>'mouseover_big_button(this)'));?>
		<?php echo anchor('blog', $labelIndexPage,array('onmousedown'=>'mousedown_big_button(this)', 'onmouseup'=>'mouseup_big_button(this)','onmouseover'=>'mouseover_big_button(this)'));?>
	</div>
</div>
<?php }?>
<?php if(($location2=='blog') && (($location3=='')|| ($location3=='index') || ($location3=='childPosts')|| ($location3=='postchild'))){?>
	<div class="row line1 width570px mr9"></div>
<?php } else{ ?>
	<div class="row line1 width570px mr12"></div>
<?php } ?>
