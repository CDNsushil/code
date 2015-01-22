<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<div class="cell width_284 pl10 pr10 sub_col_2">
	<?php
	if(!isset($userInfo)){
		$userInfo =showCaseUserDetails($userId);
	}
	$seller_currency=$userInfo['seller_currency'];
	$seller_currency=($seller_currency>0)?$seller_currency:0;
	$currencySign=$this->config->item('currency'.$seller_currency);	
	$sectionId=$this->config->item('blogsSectionId');
	$currentClass = $this->router->class;
	if(strcmp($currentClass,'blogs')==0){ ?>
		<div class="row summery_right_archive_wrapper pr10 pt10">
			<h1 class="swp_user_name clr_white"><?php echo $userInfo['userFullName'];?></h1>
			<ul class="swp_user_name_link">
			  <li class="mt9 ">
				  <?php 
					$showcaseUrl=base_url(lang().'/blogshowcase/index/'.$userId);			
				  ?>
				  <a href="<?php echo $showcaseUrl;?>" class="clr_white dash_link_hover"><?php echo $this->lang->line('viewShowcase');?></a>
			  </li>
			</ul>
		 </div>
		<?php 
	}
	
	//User feed link 
	$this->load->view('feed/rss');
	
	if((isset($postData->blogToDonate) && $postData->blogToDonate=='t') || ((isset($blogDetail['blogToDonate']) && $blogDetail['blogToDonate']=='t')) || ((isset($blogToDonate) && $blogToDonate=='t'))){
		$blogEntityId=getMasterTableRecord('Blogs');
		$donorDetail=array('entityId'=>$blogEntityId,'elementId'=>$blogId,'projId'=>$blogId,'sectionId'=>$sectionId,'ownerId'=>$userId,'seller_currency'=>$seller_currency);
		?>
		<div class="row mr39 mt20">
			<?php $this->load->view("shipping/donate_frontend_view",$donorDetail); ?>
		</div>
		<?php 
	} ?>
	<div class="clear"></div>
	<?php 
	$currentMethod = $this->router->method;
	$mathod=$this->uri->segment(6);
	//if(strcmp($currentMethod,'frontblog')!=0 && (strcmp($mathod,'frontblog')!=0)) 
	if($currentMethod != 'frontblog' && $currentMethod != 'frontBlog')
	{
		$blogId = isset($postData->blogId)?$postData->blogId:0;
		$href=($currentMethod=='preview')?'/blogshowcase/preview/'.$userId.'/'.$blogId.'/frontblog/':'/'.$currentClass.'/frontblog/'.$userId.'/'.$blogId;
		$href=base_url(lang().$href);	
	?>
		<div class="row summery_right_archive_wrapper">
			<?php echo anchor($href,'<h1 class="sumRtnew_strip clr_white gray_light_hover"><span>'.$label['aboutTheBlog'].'</span><span class="icon_plus"></span></h1>');?>	
		</div>
	<?php } ?>
	<div class="cell padding_right10 sub_col_2">		
	<?php
		
		$frontFlag = 1;
		echo Modules::run("blogshowcase/blogArchive",$userId,$frontFlag,0);
		echo Modules::run("blogshowcase/blogCategories",$userId,$frontFlag,0);		
		
		$postAttr['limitPosts'] = 10;
		$postAttr['showFlag'] = 2;
		$postAttr['currentPostId'] = @$postData->postId?@$postData->postId:0;
		echo Modules::run("blogshowcase/posts",0,'',$postAttr,$userId);
		
	?>
	</div>		
	<div class="clear mb40"></div>
	<?php
	
		$resultantTwitterLink='';
		if(isset($blogToTwitter) && $blogToTwitter=='t' && isset($blogTwitterLink) && $blogTwitterLink!=''){
			$resultantTwitterLink = $blogTwitterLink;
		}else if(isset($postData->blogToTwitter) && $postData->blogToTwitter=='t' && isset($postData->blogTwitterLink) && $postData->blogTwitterLink!='' ){
			$resultantTwitterLink = $postData->blogTwitterLink;
		}
		
		if($resultantTwitterLink!=''){	
			$twitsAttr = array('twitUrl'=>$resultantTwitterLink);
	?>
		<div id="twitterId"></div>
		<script> 
		$(window).bind("load", function() {
			AJAX('<?php echo base_url(lang()."/blogshowcase/twitter");?>','twitterId','<?php echo $resultantTwitterLink;?>','','','','','','','','','','','','','','true');
		});
		</script>
	<?php
			//$this->load->view('blogshowcase/user_twitters',$twitsAttr);
			//echo Modules::run('blogshowcase/twitter',$twitsAttr);
		}
	?>
		
		<div class="clear seprator_24"></div>			  
		
		<!-- Div for 250x250 advert display-->
		 <div class="ad_box_shadow width250px mb20" id="advert250_250"><?php 
			if(is_dir(APPPATH.'modules/advertising') && !empty($advertSectionId)){
				//Manage right side forum advert
				$bannerRhsData =  Modules::run("advertising/getAdvertRecords", array('sectionId'=>$advertSectionId,'advertType'=>'1'));
				if(!empty($bannerRhsData)) {
					$this->load->view('common/advert',array('bannerData'=>$bannerRhsData,'advertType'=>'1','sectionId'=>$advertSectionId));
				} else {
					$this->load->view('common/adv_rhs_forum');
				}
			} else {
				$this->load->view('common/adv_rhs_forum');
			}?>
		</div>

	<div class="seprator_24 row"></div>
</div>

