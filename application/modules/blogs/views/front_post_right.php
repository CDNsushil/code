<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>	
<?php 

//show the showcase section if user is logged in
$userInfo = showCaseUserDetails($userId);
														
?>
<div class="row summery_right_archive_wrapper">
	<h1 class="swp_user_name clr_white"><?php echo $userInfo['userFullName'];?></h1>
	<ul class="swp_user_name_link">
	  <li class="mt9 ">
		  <?php 
			$showcaseUrl=base_url(lang().'/blogshowcase/index/'.$userId);			
		  ?>
		  <a href="<?php echo $showcaseUrl;?>" class="clr_white"><?php echo $this->lang->line('viewShowcase');?></a>
	  </li>
	</ul>
  </div>
  <div class="seprator_10"></div>
	<div class="row summery_right_archive_wrapper ">
		<?php
		$frontFlag = 1;
		echo Modules::run("blogs/postCategories",$blogId);
		?>
	</div>

	<div class="row summery_right_archive_wrapper ">
		<?php 	
			//echo anchor('javascript://void(0);','<h1><span>'.$label['aboutTheBlog'].'</span><span class="icon_plus"></span></h1>',array('class'=>'formTip go',
			//'title'=>$label['aboutTheBlog'],
			//'onclick'=>"AJAX('".base_url(lang().'/blogshowcase/front_blog/'.$userId)."','frontPostsInfo','".encode($blogId)."','0');"));
			echo anchor(base_url(lang().'/blogs/frontblog/'.@$userId),'<h1 class="sumRtnew_strip clr_white"><span>'.$label['aboutTheBlog'].'</span><span class="icon_plus"></span></h1>',array('class'=>'formTip go',
			'title'=>$label['aboutTheBlog']));
		?>	
	</div>

<?php 
//
?>
