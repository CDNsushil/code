<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<script>
	$.gallery={options:{_imageListUL:'#imageList',
						_imageHolderDIV:'#imageHolder',
						_imageDiv:"#imageDiv",
						_imageDescriptionDiv:'#imageDescription',
						_imageActiveCSS:'imgActiveBorder',
						_imageLoader:'#loaderDiv',
						_autoPlay:true,
						_delay:5000}};
	
	$(document).ready(function(){
		initialise();
	});	
	

	$(document).ready(function() {
		$("#slideshow").css("overflow", "block");	
		$("ul#landingpage_slider").cycle({
			fx: 'fade',
			pause: true,
			prev: '#prev',
			next: '#next',
		});	
		
		/**********Custome play and paush of slider*************/
		$('.worpsliderbg').hover(function(){
		
			$('ul#landingpage_slider').cycle('pause');
			
		});
		
		//***********slider pauch for home and launch video************//
		
		$('#slider_play, #slider_play_launch').hover(function(){
		
			$('ul#landingpage_slider').cycle('pause');
			//alert("test");
		});
		
		$("#slider_play, #slider_play_launch").mouseover(function(){
				$('ul#landingpage_slider').cycle('pause');
		  });
		  $("#slider_play, #slider_play_launch").mouseout(function(){
				$('ul#landingpage_slider').cycle('resume');
		  });
		  
		<?php  if(getOsName()=="mobile")
			{ ?>
		
		
			//_V_.options.flash.swf = "<?php echo base_url(); ?>player/html5_video_player/video-js.swf";
		
			//HTML-5 Video Stop 
			$(".stopVideo").click( function(){
			
				//stop home video player
				var myPlayer = _V_("home_video");
			
				myPlayer.pause();
				myPlayer.load();
				
				//stop launch video player
				var myPlayerLaunch = _V_("launch_video");
			
				myPlayerLaunch.pause();
				myPlayerLaunch.load();
				
			});	
			
			<?php 
			// This code only work on Iphone device
			if(getDeviceType()=="iPhone")
			{ ?>
			
			$(".vjs-big-play-button").live("click", function(){
					$('ul#landingpage_slider').cycle('stop');
			});	
		
		<?php } } ?>
		
	});
	
</script>

<?php

$videoTag = '';
$LanuchVideoTag='';
$currentMethod = $this->router->class; 

if(strcmp($currentMethod,'home')==0) {
	
	
	$bannerClass = 'Banner_box_indexnew'; 
	if(getOsName()=="mobile")
	{
		$videoTag = '
		
		  <script>
			_V_.options.flash.swf = "'.base_url().'player/html5_video_player/video-js.swf";
		  </script> 
					  <div class="videobgcontainer mt-27">
					  <div class="homeVideoHeader"><img src="'.base_url('templates/default/images/insideTheSquare.png').'" /> </div>
					  <video id="home_video" class="video-js vjs-default-skin html5_header_video" controls preload="none" 
							poster="'.base_url().'images/logo-tod-square.png"	data-setup="{}" >
     					<source src="'.base_url().'images/videos/home_new_video.mp4" type="video/mp4">
						<p>Video Playback Not Supported</p>
				      </video> 
					  </div>';
					  
		$LanuchVideoTag = '
		
		  <script>
			_V_.options.flash.swf = "'.base_url().'player/html5_video_player/video-js.swf";
		  </script> 
					  <div class="videobgcontainer mt-27">
					  <div class="homeVideoHeader pl_125"><img src="'.base_url('templates/default/images/toadsquare_launch.png').'" /> </div>
					  <video id="launch_video" class="video-js vjs-default-skin html5_header_video" controls preload="none" 
							poster="'.base_url().'images/logo-tod-square.png"	data-setup="{}" >
     					<source src="'.base_url().'images/videos/o_Toadsquare_event_1080p.mp4" type="video/mp4">
						<p>Video Playback Not Supported</p>
				      </video> 
					  </div>';			  
		
	}else
	{
		//$videoTag = '<div class="videobgcontainer"><iframe src="http://www.cdnsol.com"  class="indexvideobg" ></iframe></div>'; 
		$videoTag = '<div class="videobgcontainer mt-27">
		<div class="homeVideoHeader"><img src="'.base_url('templates/default/images/insideTheSquare.png').'" /> </div>
		<div id="video" class="indexvideobg"></div>
		</div>';
		$LanuchVideoTag = '<div class="videobgcontainer mt-27">
		<div class="homeVideoHeader pl_125"><img src="'.base_url('templates/default/images/toadsquare_launch.png').'" /> </div>
		<div id="launchVideo" class="indexvideobg"></div>
		</div>';
	}
}
else {
	
	$bannerClass = 'Banner_box_wp_new';
	echo '<div class="seprator_40"></div>';
	
}
?>

	<div class="<?php echo $bannerClass;?>">	
		<div id="slideshow">
			 <ul id="nav">
				<li id="prev" class="stopVideo"><a href="#">Previous</a></li>
				<li id="next" class="stopVideo"><a href="#">Next</a></li>
              </ul>	
		<?php
				
		$base_img_url = base_url().'images/frontend/banners/';
		//$imgarray: Passed from the module
		//echo '<div class="dn">';
		echo '<ul id="landingpage_slider">';		
		$i = 0;
		
		if(strcmp($currentMethod,'home')==0) {
			
			foreach($imgarray as $key =>$img){
				
				$dn=($key==0)?'':'dn';
				
				$addvideo = $videoTag;
				
				if(is_array($img)) {
					if(isset($img['html']) && $img['html']!='') 
						echo $img['html'];
				}
				else {
					echo '<li id="slider_play_launch" class="'.$dn.'" >'.$LanuchVideoTag.'<img onclick="javascript:loadMe(this)" src="'.$base_img_url.$img.'" /></li>';
					echo '<li id="slider_play" class="'.$dn.'" >'.$addvideo.'<img onclick="javascript:loadMe(this)" src="'.$base_img_url.$img.'" /></li>';
			
				}
			}
		
	}else{
			
			foreach($imgarray as $key =>$img){
				
				$dn=($key==0)?'':'dn';
				
				if($key==0) $addvideo = $videoTag;
				else $addvideo = '';
				
				//show top craved ditail after one image get shown "image -> top craved -> image"
				if(isset($topCravedHtml) && $topCravedHtml !='' && $key==1)
					echo $topCravedHtml; //having <li> already in html to get shown as images slider element
					
				echo '<li id="slider_play_launch" class="'.$dn.'" >'.$LanuchVideoTag.'<img onclick="javascript:loadMe(this)" src="'.$base_img_url.$img.'" /></li>';
				echo '<li id="slider_play" class="'.$dn.'" >'.$addvideo.'<img onclick="javascript:loadMe(this)" src="'.$base_img_url.$img.'" /></li>';
			} 
	}
        echo '</ul>';
        echo '</div>';
?>
            <!-- End wp_banner_slider -->
            
  <div class="trans_box_wp_new">
<?php 

$uploadButton =$this->lang->line('uploadCommonMedia');				
				
if( (strcmp($currentMethod,'enterprises')==0) || (strcmp($currentMethod,'associateprofessional')==0) || (strcmp($currentMethod,'creatives')==0)) 
     $uploadButton=$this->lang->line('uploadButtonCreate');
				
if(strcmp($currentMethod,'performancesnevents')==0)  
     $uploadButton=$this->lang->line('uploadButtonPromote');			
				
if( (strcmp($currentMethod,'works')==0) || (strcmp($currentMethod,'products')==0) )				
	 $uploadButton=$this->lang->line('uploadButtonAdvertise');
	
if(strcmp($currentMethod,'blogs')==0)  
     $uploadButton=$this->lang->line('uploadButtonPost');			
				
if(strcmp($currentMethod,'educationnmaterial')==0)  
     $uploadButton=$this->lang->line('promote_material');					
				
if(strcmp($currentMethod,'home')==0)  
     $uploadButton=$this->lang->line('uploadButtonHome');
     
     
if(strcmp($currentMethod,'competition')==0)  
     $uploadButton=$this->lang->line('createCompetetionHome');     				
									
					$loggedInUser = isLoginUser();
					$goToUrl = '/'.$this->config->item($currentMethod.'_dashboard');
					if(isset($loggedInUser) && $loggedInUser>0) {
						$href = $dashboardUrl = base_url(lang().$goToUrl);
						$cssLogin="mt7";
					}
					else{
						$cssLogin="mt7";
						$href = 'javascript://void(0);'; 
						$dashboardUrl="openLightBox('popupBoxWp','popup_box','/auth/login','".$this->lang->line('beforeCommonLoggedIn').strtolower($this->lang->line($currentMethod.'_login_title')).".')";
					}
					
				?>
				<div class="login_input_bg mr10 ml10 <?php echo $cssLogin;?>"><div class="login_Section_upload width140px mH35" ><?php echo $this->lang->line($currentMethod.'_login_title').'.';?></div></div>
							
				<div>
			    <?php 
			     echo anchor($href,'<span><div>'.$uploadButton.'</div></span><span class=""></span>',array('onclick'=>$dashboardUrl, 'onmousedown'=>'mousedown_login_go_btn(this)', 'onmouseup'=>'mouseup_login_go_btn(this)','class'=>'login_go_btn a_darkorange'));
			    ?>	
			    </div>
				<div class="seprator_2 clear"></div>
				
              <!--login & Join box start-->
              <?php $this->load->view('auth/login_form_frontend');?>  <!--login & Join box end-->
              
              <div class="seprator_8"></div>
              <div class="search_box_wrapper ml10 wp_serch_box_wrapper width170px">
                <?php
					$formAttributes = array(
						'name'=>'SearchTopBannerForm',
						'id'=>'SearchTopBannerForm',
					);
					echo form_open(base_url(lang().'/search/searchform'),$formAttributes);
					$sectionId=$this->config->item($currentMethod.'SectionId');
				?>
					<input name="keyWord" type="text" value="<?php echo $this->lang->line('keywordSearch');?>" class="search_text_box wp_login_serch" placeholder="<?php echo $this->lang->line('keywordSearch');?>" onclick="placeHoderHideShow(this,'<?php echo $this->lang->line('keywordSearch');?>','hide')" onblur="placeHoderHideShow(this,'<?php echo $this->lang->line('keywordSearch');?>','show')">
					<div>
						<input name="sectionId" type="hidden" value="<?php echo $sectionId;?>">
						<input type="submit" name="searchCrave" value="" class="search_btn_glass">
						<!--<input type="image" value="searchCrave" name="searchCrave" src="<?php //echo base_url();?>images/btn_search_box.png">-->
					</div>
				<?php echo form_close(); ?>
              </div>
              <div class="seprator_10 clear"></div>
              <!--banner_indigator_wp-->
            </div>
            <div class="clear"></div>
			<?php if(strcmp($currentMethod,'home')!=0) echo '<div class="landingpage_slidershedow"></div>';?>
          </div><!--Banner_box_wp-->
<div class="seprator_5"></div>
