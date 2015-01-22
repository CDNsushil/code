<?php 
$location = $this->uri->segment(3);

$classSelected = "class='Main_btn_box Main_select'";
$class ="class='Main_btn_box'";

$setBackUrl = array('backurl'  => $this->router->method);

$this->session->set_userdata($setBackUrl);
$currentBackUrl      = $this->session->userdata('backurl');

//echo 'echo $currentBackUrl :'.$currentBackUrl;
$currentBackpostId      = $this->session->userdata('postId');
//if(isset($currentBackpostId))
//echo 'currentBackpostId :'.$currentBackpostId;
?>

<!------- Top Most Menu Buttons ------->      
<div class="Main_btn_wp"> 
<div <?php if(($location =='') || (strcmp($location,'postForm')==0) || (strcmp($location,'updatePost')==0)){ echo $classSelected; }else{ echo $class; }?> style="padding-left:20px;">
<?php
if(isset($currentBackpostId) && $currentBackpostId>0) $postLabel = $label['createPost'];
else $postLabel = $label['newPost'];

if(isset($currentBackpostId) && $currentBackpostId>0)
	$postFormUrl = 'blog/postForm/'.$currentBackpostId;
else
	$postFormUrl = 'blog/postForm';	

			if(strcmp($location,'postForm')==0){ 
			?>
			<div class="Main_btn_left">
			<div class="Main_btn_right">
				<?php echo '<label class="commonfontfamily">'.$postLabel.'</label>';?>
			</div><!--Main_btn_right-->
			</div><!--Main_btn_left-->
			<?php
			}
			else
				echo anchor($postFormUrl, '<div class="Main_btn_left"><div class="Main_btn_right">'.$postLabel.'</div></div>',array('class'=>'commonfontfamily'));
			?>
		
</div><!--main_btn_wp-->
 
 <div <?php if(strcmp($location,'mediaGallery')==0 || strcmp($location,'postMediaGalleryForm')==0){ echo $classSelected; }else{ echo $class; }?>>
			<?php
			if(strcmp($location,'mediaGallery')==0 || strcmp($location,'postMediaGalleryForm')==0){ 
			?>
			<div class="Main_btn_left">
			<div class="Main_btn_right">
				<?php echo '<label class="commonfontfamily">'.$label['mediaGallery'].'</label>';?>
			</div><!--Main_btn_right-->
			</div><!--Main_btn_left-->
			<?php
			}
			else 
				echo anchor('blog/mediaGallery', '<div class="Main_btn_left"><div class="Main_btn_right">'.$label['mediaGallery'].'</div></div>',array('class'=>'commonfontfamily'));
			?>
		
</div><!--main_btn_wp-->
 
<div <?php if(strcmp($location,'blogForm')==0){ echo $classSelected; }else{ echo $class; }?>>
	
			<?php
			if(strcmp($location,'blogForm')==0){ 
			?>
			<div class="Main_btn_left">
			<div class="Main_btn_right">
				<?php echo '<label class="commonfontfamily">'.$label['blogSetting'].'</label>';?>
			</div><!--Main_btn_right-->
			</div><!--Main_btn_left-->
			<?php
			}
			else	
				echo anchor('blog/blogForm/', '<div class="Main_btn_left"><div class="Main_btn_right">'.$label['blogSetting'].'</div></div>',array('class'=>'commonfontfamily'));
				?>
		
</div><!--main_btn_wp-->

</div><!--Main_btn_wp-->
<span class="clear_seprator "></span>
<!------ End Of Top Menu ------->  