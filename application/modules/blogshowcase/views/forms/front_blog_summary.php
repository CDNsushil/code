<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<!--  content wrap  start end -->
<div class="newlanding_container bg_f7f7f7">
  <div class="wid940 m_auto pt36"> 
	<!--  Tab Nav -->    
        <!-- Landing content box -->
        <div class="landing_blog clearbox mb20  ">
			<div class="clear_box blog_detail fl width640">
				<?php	
				if(!isset($userId) || $userId=='') $userId = isLoginUser();
				
				//This shows posts related with blog
				$defaultPostAttr['showFlag'] = 1;
				$defaultPostAttr['limitPosts'] = 0;
				echo Modules::run("blogshowcase/newposts",$blogId,'dateCreated',$defaultPostAttr,$userId);
				?>	
			</div>
			<div class="third_intro_cnt  fl widht_300"> 
				<?php
				$frontRightArray['userId']=@$userId;
				$frontRightArray['blogId']=isset($blogDetail['blogId'])?$blogDetail['blogId']:0;
				$frontRightArray['blogTwitterLink']=@$blogTwitterLink;
				$this->load->view('blogshowcase/forms/front_blog_right',$frontRightArray);
				//echo Modules::run("blogshowcase/frontRight",$frontRightArray);		
				?>
			</div>
	</div>
	</div>
</div>
<!--  content wrap  end --> 
<?php
if(is_dir(APPPATH.'modules/advertising') && !empty($advertSectionId)) { 
	//manage auto advert params and js methods
	echo $advertChangeView; 
}
/* End of file front_blog_summary.php */
/* Location: ./application/module/blogshowcase/view/front_blog_summary.php */
?>
