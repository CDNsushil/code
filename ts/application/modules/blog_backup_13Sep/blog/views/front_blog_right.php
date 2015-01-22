<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

	<div class="social_bookmark_wrapper">		
		<?php
			//This shows posts related with blog
			$frontFlag = 1;
			echo Modules::run("blog/blogIcon",$blogId,$frontFlag);
		?>
	</div><!--social_bookmarking_icon_box-->

	<div class="row summery_right_archive_wrapper">
		<?php
		//This shows posts related with blog
		$frontFlag = 1;
		echo Modules::run("blog/blogArchive",$blogId,$frontFlag);
		?>
	</div> 
	<div class="row summery_right_archive_wrapper">
		<?php
		$frontFlag = 1;
		echo Modules::run("blog/blogCategories",$blogId,$frontFlag);
		?>
	</div>

	<div class="row summery_right_archive_wrapper">
		<?php 	
			echo anchor('javascript://void(0);','<h1><span>'.$label['aboutTheBlog'].'</span><span class="icon_plus"></span></h1>',array('class'=>'formTip go',
			'title'=>$label['aboutTheBlog'],
			'onclick'=>"AJAX('".base_url(lang().'/blog/index')."','frontPostsInfo','".encode($blogId)."','0');"));
		?>	
	</div>

	<div class="row summery_right_archive_wrapper">
	
			<?php			
			$recentPostAttr['showFlag'] = 2;
			$recentPostAttr['limitPosts'] = 2;
			echo Modules::run("blog/posts",$blogId,'',$recentPostAttr);
			?>
	</div>
<?php 
//
?>


