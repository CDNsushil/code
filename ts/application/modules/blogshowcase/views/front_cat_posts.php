<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<td class="bg_blog_container" valign="top">
<div class="cell width_476 sub_col_1 p10">
 
	<div class="row">
		<?php if(!empty($parentPost['postResults'][0]->postTitle)) { ?>
		<div class="row parent_post_sample_heading clr_white">					
			<?php echo $restrictedPostTitle = getSubString($parentPost['postResults'][0]->postTitle,50); ?>						
		</div>	
		<?php } ?>
		<div id="frontPostsInfo" >
			<?php
				//This shows posts related with blog
				$defaultPostAttr['showFlag'] = 1;
				$defaultPostAttr['limitPosts'] = 0;
				$this->load->view('front_posts');
			?>			
		</div>
	</div>
</div><!-- cell width_476 -->	

</td><td class="bg_blog_container" valign="top">
	<?php
		$frontRightArray['userId']=@$userId;
		$frontRightArray['blogId']=0;
		echo Modules::run("blogshowcase/frontRight",$frontRightArray);
	?>
</td>

<?php
if(is_dir(APPPATH.'modules/advertising') && !empty($advertSectionId)) { 
	//manage auto advert params and js methods
	echo $advertChangeView; 
}
/* End of file front_cat_posts.php */
/* Location: ./application/module/blogshowcase/view/front_cat_posts.php */
?>
