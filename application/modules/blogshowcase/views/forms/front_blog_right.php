<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$currentClass = $this->router->class;
$currentMethod = $this->router->method;
$mathod=$this->uri->segment(6);
$postHeading = 'Posts';
if($currentMethod != 'frontblog' && $currentMethod != 'frontblog')
{
	$blogId = isset($postData->blogId)?$postData->blogId:0;
	$href=($currentMethod=='preview')?'/blogshowcase/preview/'.$userId.'/'.$blogId.'/frontblog/':'/'.$currentClass.'/frontblog/'.$userId.'/'.$blogId;
	$href=base_url(lang().$href);
	$postHeading = 'My Posts';
	?>
	<?php echo anchor($href,'<h5 class="fs18 gotham_r mt15 mr20 pl25 red_arrow org_link_hover">Introduction to my blog</h5>');?>	
	<span class="sap_25 bb_F1592A"></span>
<?php 
}
if($postData->custId != $userId) {
	//$postHeading = 'Posts';
}
?>


<div class="pt25 bg_fff fl width100_per pb20"> 
	<div class=" pl35 pr25">
		<h3 class="opens_light fs34 clr_666 bb_e3e3e3 "> <?php echo $postHeading;?></h3>
		<span class="sap_35"></span>

		<?php
		if(!isset($userInfo)) {
			$userInfo =showCaseUserDetails($userId);
		}
		$seller_currency=$userInfo['seller_currency'];
		$seller_currency=($seller_currency>0)?$seller_currency:0;
		$currencySign=$this->config->item('currency'.$seller_currency);	
		$sectionId=$this->config->item('blogsSectionId');
		$currentClass = $this->router->class; ?>
		
		
		<?php
		$frontFlag = 1;
		echo Modules::run("blogshowcase/newblogcategories",$userId,$frontFlag,0);	
		?>
		<span class="sap_30"></span>
		<?php 
		echo Modules::run("blogshowcase/newblogarchive",$userId,$frontFlag,0);
		
		$postAttr['limitPosts'] = 10;
		$postAttr['showFlag'] = 2;
		$postAttr['currentPostId'] = @$postData->postId?@$postData->postId:0;
		//echo Modules::run("blogshowcase/posts",0,'',$postAttr,$userId);
		?>
	</div>
</div>	
	
	<?php
	$resultantTwitterLink='';
	if(isset($blogToTwitter) && $blogToTwitter=='t' && isset($blogTwitterLink) && $blogTwitterLink!=''){
		$resultantTwitterLink = $blogTwitterLink;
	}else if(isset($postData->blogToTwitter) && $postData->blogToTwitter=='t' && isset($postData->blogTwitterLink) && $postData->blogTwitterLink!='' ){
		$resultantTwitterLink = $postData->blogTwitterLink;
	}
	
	if($resultantTwitterLink!='') {	
		$twitsAttr = array('twitUrl'=>$resultantTwitterLink);
		?>
		<span class="sap_20"></span>
		<div id="twitterId"></div>
		<script> 
		$(window).bind("load", function() {
			AJAX('<?php echo base_url(lang()."/blogshowcase/twitter");?>','twitterId','<?php echo $resultantTwitterLink;?>','','','','','','','','','','','','','','true');
		});
		</script>
	<?php
		//$this->load->view('blogshowcase/user_twitters',$twitsAttr);
		//echo Modules::run('blogshowcase/twitter',$twitsAttr);
	} ?>
		  
<div class="cnt_box clearbox ">
	<div class="display_table pt20 pb20 m_auto position_relative ">		
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
	</div>
</div>	


