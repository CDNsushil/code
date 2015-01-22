<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$href = 'javascript://void(0);'; 
$topCravedArray = array('entityId'=>$projectEntityId,'projectType'=>'filmNvideo');
$topCravedElementArray = array('entityId'=>12,'projectType'=>'filmNvideo');
$topCravedData['defaultProfileImage'] = $this->config->item('filmNvideoImage_s');	
$topCravedData['data'] = topCraved($topCravedArray);
$topCravedData['elementData'] = topCravedElement($topCravedElementArray);

if(is_array($topCravedData['data']) && count($topCravedData['data'])>0){		
	$topCravedHtml = $this->load->view('common/top_craved_filmnvideo',$topCravedData,true);
}else{
	$topCravedHtml = '';
}
			
$currentMethod = $this->router->class;

$loggedInUser = isLoginUser();
$goToSectionUrl = '/'.$this->config->item($currentMethod.'_dashboard');
$goToUpcomingUrl = '/'.$this->config->item('upcoming_dashboard');
$goToNewsUrl = '/'.$this->config->item('news_dashboard');
$goToReviewsUrl = '/'.$this->config->item('review_dashboard');

if(isset($loggedInUser) && $loggedInUser>0) {
	$dashboardSectionUrl = "goTolink('','".base_url(lang().$goToSectionUrl)."')";
	$dashboardUpcomingUrl = "goTolink('','".base_url(lang().$goToUpcomingUrl)."')";
	$dashboardNewsUrl = "goTolink('','".base_url(lang().$goToNewsUrl)."')";
	$dashboardReviewUrl = "goTolink('','".base_url(lang().$goToReviewsUrl)."')";
	$cssLogin="mt7";
}
else{
	$cssLogin="mt7";
	
	$dashboardSectionUrl="openLightBox('popupBoxWp','popup_box','/auth/login','".$this->lang->line('beforeCommonLoggedIn').strtolower($this->config->item($currentMethod)).".')";
	$dashboardNewsUrl="openLightBox('popupBoxWp','popup_box','/auth/login','".$this->lang->line('beforeCommonLoggedIn').strtolower($this->lang->line('article')).".')";
	$dashboardReviewUrl="openLightBox('popupBoxWp','popup_box','/auth/login','".$this->lang->line('beforeCommonLoggedIn').strtolower($this->lang->line('Reviews')).".')";
	$dashboardUpcomingUrl="openLightBox('popupBoxWp','popup_box','/auth/login','".$this->lang->line('beforeCommonLoggedIn').strtolower($this->lang->line('upcoming')).".')";
}

$addNewsButton = 	 anchor($href,$this->lang->line('addArticle'),array('onclick'=>$dashboardNewsUrl, 'onmousedown'=>'mousedown_promote_btn(this)', 'onmouseup'=>'mouseup_promote_btn(this)','class'=>'promote_btn dash_link_hover'));    
$addReviewsButton =  anchor($href,$this->lang->line('addReview'),array('onclick'=>$dashboardReviewUrl, 'onmousedown'=>'mousedown_promote_btn(this)', 'onmouseup'=>'mouseup_promote_btn(this)','class'=>'promote_btn dash_link_hover'));  		    
$addSectionButton = 	 anchor($href,$this->lang->line('uploadCommonMedia'),array('onclick'=>$dashboardSectionUrl, 'onmousedown'=>'mousedown_promote_btn(this)', 'onmouseup'=>'mouseup_promote_btn(this)','class'=>'promote_btn dash_link_hover'));  
$addUpcomingButton = 	 anchor($href,$this->lang->line('promote_upcoming'),array('onclick'=>$dashboardUpcomingUrl, 'onmousedown'=>'mousedown_promote_btn(this)', 'onmouseup'=>'mouseup_promote_btn(this)','class'=>'promote_btn dash_link_hover'));  

$bannerarray['imgarray']=array("banner_front_film-and-video_show-off-your-films-and-video_HR.jpg","banner_front_film-and-video_sick-of-what's-on-tv_HR.jpg");
$bannerarray['topCravedHtml'] = $topCravedHtml;

$this->load->view('common/common_banner',$bannerarray); //common view for image banner placed in main view folder

if( (isset($proj_array) && (!empty($proj_array))) || (isset($upcoming_array) && (!empty($upcoming_array))) || (isset($news_array) && (!empty($news_array))) || (isset($reviews_array) && (!empty($reviews_array))) ){	
	$activeApplied=false;
	$projDisplay=$upcomingDisplay=$newsDisplay=$reviewsDisplay='dn';
	if(!empty($proj_array)){
		$activeApplied=true;
		$projDisplay='';
	}
	if(!empty($upcoming_array)){ 
		if(!$activeApplied){
			$upcomingDisplay='';
			$activeApplied=true;
		}
	}
	if(!empty($news_array)){
		if(!$activeApplied){
			$newsDisplay='';
			$activeApplied=true;
		}
	}
	if(!empty($reviews_array)){
		if(!$activeApplied){
			$reviewsDisplay='';
			$activeApplied=true;
		}
	}
	?>
	<div class="row">
		<div class=" bdr_fv10 global_shadow bg_white ml40  mr40">
			<?php 
			$this->load->view('common/landingpage/media_tab');
			
			if(isset($proj_array) && !empty($proj_array)){
				$projdata=array('proj_array'=>$proj_array,'projDisplay'=>$projDisplay,'addSectionButton'=>$addSectionButton);
				$this->load->view('common/landingpage/media_listing',$projdata);
			}

			if(isset($upcoming_array) && !empty($upcoming_array)){
				$upcomngdata=array('upcoming_array'=>$upcoming_array,'upcomingDisplay'=>$upcomingDisplay,'addUpcomingButton'=>$addUpcomingButton);
				$this->load->view('common/landingpage/upcoming_listing',$upcomngdata);
			}
			
			if(isset($news_array) && !empty($news_array)){
				$newsData=array('news_array'=>$news_array, 'newsDisplay'=>$newsDisplay, 'addNewsButton'=>$addNewsButton);
				$this->load->view('common/landingpage/news_listing',$newsData);
			}
			
			if(isset($reviews_array) && !empty($reviews_array)){
				$reviewsData=array('reviews_array'=>$reviews_array, 'reviewsDisplay'=>$reviewsDisplay, 'addReviewsButton'=>$addReviewsButton);
				$this->load->view('common/landingpage/reviews_listing',$reviewsData);
			}?>
		    <div class="clear"></div> 
		</div>
	</div>
	<?php
}?>		  
<div class="row seprator_40"></div>
<div class="clear"></div> 

<script type="text/javascript">
	$(document).ready(function(){
		$('.tabMenuFrontEnd').click(function(){
			var tab = $(this).attr('tab');
			$(this).addClass('wp_tab_selected ');	
			$(this).siblings().removeClass('wp_tab_selected');
			
			$('.tabFrontEnd').each(function(index){
				$(this).hide();
			});
			$('#'+tab).show();
		})
		$('#latestProjectSlider').tinycarousel({ axis:'x', display:1, start:1});
		$('#upcomingProjectSlider').tinycarousel({ axis:'x', display:1, start:1});
		$('#newsSlider').tinycarousel({ axis: 'x', display:1, start:1});
		$('#reviewsSlider').tinycarousel({ axis: 'x', display:1, start:1});
	});
</script>
