<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

	
	<td class="bg_blog_container" valign="top">
	
	<div class="cell width_476 sub_col_1 p10"> 
		<div class="row">
			<div id="frontPostsInfo">
			<?php
				
				if(!isset($userId) || $userId=='') $userId = isLoginUser();
				
				//This shows posts related with blog
				$defaultPostAttr['showFlag'] = 1;
				$defaultPostAttr['limitPosts'] = 0;
				echo Modules::run("blogshowcase/posts",$blogId,'dateCreated',$defaultPostAttr,$userId);
				
			?>			
			</div>
		</div>
	</div><!-- cell width_476 -->
	
	</td>
	
	<td class="bg_blog_container"  valign="top">       
	
	<?php
	
		$frontRightArray['userId']=@$userId;
		$frontRightArray['blogId']=isset($blogDetail['blogId'])?$blogDetail['blogId']:0;
		$frontRightArray['blogTwitterLink']=@$blogTwitterLink;
		$this->load->view('blogshowcase/front_blog_right',$frontRightArray);
		//echo Modules::run("blogshowcase/frontRight",$frontRightArray);		
	?>
	
	</td>

<?php
if(is_dir(APPPATH.'modules/advertising') && !empty($advertSectionId)) { 
	//manage auto advert params and js methods
	echo $advertChangeView; 
}
/* End of file front_blog_summary.php */
/* Location: ./application/module/blogshowcase/view/front_blog_summary.php */
?>
