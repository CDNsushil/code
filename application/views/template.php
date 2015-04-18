<?PHP if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
	echo $head;
	$bodyClass = '';
	$currentModuleClass = $this->router->class;
	$currentMethodName =  $this->router->method;	 
	if($currentMethodName=='information' && ($currentModuleClass=='package')){
		$bodyClass='class="homepage_seamless_texture"';
	}
?>
<body <?php echo $bodyClass;?> >
<div class="dn" id="popupBoxWp">
	<div class="popup_box" id="popup_box"></div>
</div>

<!--customAlert START-->
<div id="customAlert" class="customAlert dn">
	<div id="close-customAlert" class="tip-tr close-customAlert"></div>
	<div class="customeMessage"></div>
</div>
<!--customAlert END-->

<!--loginLightBoxWp START-->
<div id="loginLightBoxWp" class="loginLightBoxWp dn">
	<div id="close-lightBox" class="tip-tr close-customAlert"></div>
	<div class="loginFormContainer" id="loginFormContainer"></div>
</div>

<!--creativeAssociativeBoxWp START-->
<div id="creativeAssociativeBoxWp" class="creativeAssociativeBoxWp dn">
	<div id="close-creativeAssociativelightBox" class="tip-tr close-customAlert" onclick="$(this).parent().trigger('close');"></div>
	<div class="creativeAssociativeContainer" id="creativeAssociativeContainer"></div>
</div>
 <div class="main">
 	<!--<div class="top_strip">
    </div><!--top_strip-->
    
	<div class="wrapper_toad">
   
    <?php $this->load->view('header');?>
   
    <div class="content_wrapper">
				<?php
				if($this->router->fetch_class()=='frontend'){
					$class_right='gray_content_box';
				}else{
					$class_right='right_coloumn_full gray_content_box';
				}
				
				/*commented to solve the userId issue of showcase #7407
				/* Old code
				 * $userId= $this->uri->segment(4);*/
				/* New code 3 aug 2012*/
				
				$leftSide=true;
				$class_right='right_coloumn_full gray_content_box';
				$breadcrumbLeftWidth='<div class="cell width_196">&nbsp;</div>';
				
				if ($module=='home'){
					$leftSide=false;
					$breadcrumbLeftWidth='';
				} 
				
				$userId = isLoginUser();
				
				if(isLoginUser() && ($this->router->fetch_class()!='frontend') && $leftSide){
					if(isset($userId) && $userId>0) $userId = $userId;
					else $userId = isLoginUser();
					
					$userInfo = showCaseUserDetails($userId,'userBackend');
					
					if(isset($userNavigations) && is_array($userNavigations) && count($userNavigations) > 0 &&(in_arrayr( 'enterprises', $userNavigations, $key='section', $is_object=0 ) || in_arrayr( 'associatedprofessionals', $userNavigations, $key='section', $is_object=0 ) || in_arrayr( 'creatives', $userNavigations, $key='section', $is_object=0 ))){ 
						$userDefaultImage=($userInfo['enterprise']=='t')?$this->config->item('defaultEnterpriseImg_152_210'):($userInfo['associatedProfessional']=='t'?$this->config->item('defaultAssProfImg_152_210'):$this->config->item('defaultCreativeImg_152_210'));
					}else{
						$userDefaultImage=$this->config->item('defaultMemberImg_m');
					}
					$userTemplateThumbImage = addThumbFolder($userInfo['userImage'],'_m');	
					$userImage = getImage($userTemplateThumbImage,$userDefaultImage);
					$class_right='right_coloumn';
					
					?>
					<div class="left_coloumn">
						<div class="user_name_wp_front bdr_646464 mt7">
						<div class="lhsleft_imgbg ml9 mt9">
							<div class="AI_table">
								<div class="AI_cell">
									<a href="<?php echo base_url(lang().'/showcase/index/'.$userId);?>">
										<img class="user_photo_new" src="<?PHP echo $userImage;?>" /> 
									</a>
								</div>
							</div>
						</div>
						
						<div class="pr pt10">
						  <div class="name_box_front pt0"><?php echo ($userInfo['enterprise']=='t')?$userInfo['enterpriseName']:$userInfo['userFullName'];?></div>
						  <div class="artist_type_front"> <?php echo (isset($userInfo['userArea']) && $userInfo['userArea'] != '')?$userInfo['userArea']:$userInfo['countryName']; ?></div>
						</div>
						</div>
						<div class="seprator_20"></div>		
				
						<div class="Left_side_menu">
								<ul>
									
									<li class="<?php echo isset($select_dashboard)?$select_dashboard:'';?>"> <a href="<?php echo base_url(lang().'/dashboard');?>" class=""><span><span><?php echo $this->lang->line('dashboard')?></span></span></a></li>	
									<li><a  href="<?php echo base_url(lang().'/cart/wishlist');?>"><span><span><?php echo $this->lang->line('cart')?></span></span></a></li>
									<li class="<?php echo isset($select_tmail)?$select_tmail:'' ; echo isset($select_messagecenter)?$select_messagecenter:''  ;?>"><a  href="<?php echo base_url(lang().'/tmail');?>"><span><span><?php echo $this->lang->line('messageCentre')?></span></span></a></li>
									<?php
									if(in_arrayr( 'blog', $userNavigations, $key='section', $is_object=0 ) || in_arrayr( 'post', $userNavigations, $key='section', $is_object=0 )){?>
										<li class="<?php echo isset($select_blog)?$select_blog:'';?>"><a href="<?php echo base_url(lang().'/blog/index');?>" class="nav_blog"><span><span><?php echo $this->lang->line('blog')?></a></span></span></li>
										<?php
									} 
									?>
									<li class="<?php echo isset($select_craves)?$select_craves:'';?>"><a href="<?php echo base_url(lang().'/craves');?>" class="nav_my_craves" ><span><span><?php echo $this->lang->line('craves')?></span></span></a></li>
									
									<?php
									if(isset($userNavigations) && is_array($userNavigations) && count($userNavigations) > 0 &&(in_arrayr( 'enterprises', $userNavigations, $key='section', $is_object=0 ) || in_arrayr( 'associatedprofessionals', $userNavigations, $key='section', $is_object=0 ) || in_arrayr( 'creatives', $userNavigations, $key='section', $is_object=0 ))){ ?>
										<li  class="<?php echo isset($select_showcase)?$select_showcase:'';?>"> <a href="<?php echo base_url(lang().'/showcase/showcaseForm');?>" class="nav_showcase"><span><span><?php echo $this->lang->line('showcaseHomepage');?> </span></span> </a></li>
										<?php
									} 
									if(in_arrayr( 'workprofile', $userNavigations, $key='section', $is_object=0 )){?>
										<li class="<?php echo isset($select_workprofile)?$select_workprofile:''; echo isset($select_workshowcase)?$select_workshowcase:'';?>"><a href="<?php echo base_url(lang().'/workprofile');?>" class="nav_workprofile"><span><span><?php echo $this->lang->line('work').'&nbsp;'.$this->lang->line('profile');?></span></span> </a></li>
										<?php
									}
									if(in_arrayr( 'upcoming', $userNavigations, $key='section', $is_object=0 )){?>
										<li class="<?php echo isset($select_upcomingprojects)?$select_upcomingprojects:'';?>"><a href="<?php echo base_url(lang().'/upcomingprojects');?>" class="nav_upcome"><span><span><?php echo $this->lang->line('upcoming');?> </span></span></a></li>
										<?php
									}
									if(in_arrayr( 'filmNvideo', $userNavigations, $key='section', $is_object=0 )){?>
										<li class="<?php echo isset($select_mediafilmNvideo)?$select_mediafilmNvideo:'' ;  echo isset($select_mediaindex)?$select_mediaindex:'' ;?>"> <a href="<?php echo base_url(lang().'/media/filmNvideo');?>" class="nav_film"><span><span><?php echo $this->lang->line('film').'&nbsp;'.$this->lang->line('&').'&nbsp;'.$this->lang->line('video')?></span></span></a></li>
										<?php
									}
									if(in_arrayr( 'musicNaudio', $userNavigations, $key='section', $is_object=0 )){?>
										<li class="<?php echo isset($select_mediamusicNaudio)?$select_mediamusicNaudio:''  ;?>"> <a href="<?php echo base_url(lang().'/media/musicNaudio');?>" class="nav_music"><span><span><?php echo $this->lang->line('music').'&nbsp;'.$this->lang->line('&').'&nbsp;'.$this->lang->line('audio')?></span></span></a></li>
										<?php
									}
									if(in_arrayr( 'photographyNart', $userNavigations, $key='section', $is_object=0 )){?>
										<li class="<?php echo isset($select_mediaphotographyNart)?$select_mediaphotographyNart:''  ;?>"> <a href="<?php echo base_url(lang().'/media/photographyNart');?>" class="nav_photo"><span><span><?php echo $this->lang->line('photography').'&nbsp;'.$this->lang->line('&').'&nbsp;'.$this->lang->line('art')?></span></span></a></li>
										<?php
									}
									if(in_arrayr( 'writingNpublishing', $userNavigations, $key='section', $is_object=0 ) || in_arrayr( 'news', $userNavigations, $key='section', $is_object=0 ) || in_arrayr( 'reviews', $userNavigations, $key='section', $is_object=0 )){?>
										<li class="<?php echo isset($select_mediawritingNpublishing)?$select_mediawritingNpublishing:''; echo isset($select_medianews)?$select_medianews:''; echo isset($select_mediareviews)?$select_mediareviews:'';?>"> <a href="<?php echo base_url(lang().'/media/writingNpublishing');?>" class="nav_writing"><span><span>
										<?php echo $this->lang->line('writing').'&nbsp;'.$this->lang->line('&').'&nbsp;'.$this->lang->line('publishing')?></span></span>
										</a></li> <?php
									}
									if(in_arrayr( 'event', $userNavigations, $key='section', $is_object=0 ) || in_arrayr( 'launch', $userNavigations, $key='section', $is_object=0 ) || in_arrayr( 'notification', $userNavigations, $key='section', $is_object=0 )){?>
										<li class="<?php echo isset($select_event)?$select_event:''  ;?>"> <a class="nav_performaces" href="<?php echo base_url(lang().'/event/eventnotifications');?>"><span><span><?php echo $this->lang->line('performances').'&nbsp;&amp;&nbsp;'.$this->lang->line('events')?></span></span></a></li>
										<?php
									}
									if(in_arrayr( 'educationMaterial', $userNavigations, $key='section', $is_object=0 )){?>
										<li class="<?php echo isset($select_mediaeducationMaterial)?$select_mediaeducationMaterial:''  ;?>"><a class="nav_educational" href="<?php echo base_url(lang().'/media/educationMaterial');?>" class="nav_education">
											<span><span><?php echo $this->lang->line('educational').'&nbsp;'.$this->lang->line('material')?></span></span>
											</a>
										</li><?php
									}
									if(in_arrayr( 'work', $userNavigations, $key='section', $is_object=0 )){?>
										<li class="<?php echo isset($select_work)?$select_work:'' ;?>"><a href="<?php echo base_url(lang().'/work');?>" class="nav_work"><span><span><?php echo $this->lang->line('work')?></span></span></a></li>
										<?php
									}
									if(in_arrayr( 'product', $userNavigations, $key='section', $is_object=0 )){?>
										<li class="<?php echo isset($select_product)?$select_product:'' ;?>"><a href="<?php echo base_url(lang().'/product/sell');?>" class="nav_product"><span><span><?php echo $this->lang->line('products')?></span></span></a></li>
										<?php
									}
									if(is_dir(APPPATH.'modules/competition') && in_arrayr( 'competition', $userNavigations, $key='section', $is_object=0 )){
										$compHref=base_url(lang().'/competition/competitionlist');
										?>
										<li class="<?php echo (isset($select_competition) && !(strstr(strtolower($moduleMethod),'competitionentr')))?$select_competition:'' ;?>"><a href="<?php echo $compHref;?>" class="nav_competition"><span><span><?php echo $this->lang->line('competitions')?></span></span></a></li>
										<?php
									}
									if(is_dir(APPPATH.'modules/competition') && in_arrayr( 'competitionentry', $userNavigations, $key='section', $is_object=0 ) ){
										$compHref=base_url(lang().'/competition/competitionentrylist');
										if(strstr(strtolower($moduleMethod),'competitionentr')){
											$slected_entry='LSM_select';
										}else{
											$slected_entry='';
										}
										?>
										<li class="<?php echo isset($slected_entry)?$slected_entry:'' ;?>"><a href="<?php echo $compHref;?>" class="nav_competition"><span><span><?php echo $this->lang->line('competitionEntries')?></span></span></a></li>
										<?php
									}
									?>
								</ul>
								
						<div class="clear"></div>	
						
						</div><!--Left_side_menu-->
						<div class="seprator_15"></div>
						<div class="clear"></div>
						
						<!-- <div class="ml40">
							<a href="#" class="ptr"><img border="0" src="<?php echo base_url();?>images/downloadbadge_wc.png">
							
							 Invite a friend to join Toadsquare
							</a>
						</div>	-->

						 <?php
						 $shareLink = base_url('home');
						 $onclickFunction = "getShortLink('".$shareLink."','email');" ;						
					     $mouseEvent = 'onmouseup="mouseup_tds_button01(this)" onmousedown="mousedown_tds_button01(this)" ';
					   
						?>
						<div class="rouncircle_dastboard mb14">
							<a class="ptr" <?php echo $mouseEvent ?> onclick="<?php echo $onclickFunction ?>" >
								<div class="AI_table">								
									<div class="AI_cell textcontainer dash_link_hover"><?php echo $this->lang->line('inviteFrnToJoinTdq');?></div>
								</div>
							</a>
						</div>
					
						
				 </div><!--left_coloumn-->
				 
				 
				<?php
            }?>        
			<div class="<?php echo $class_right;?> new_theme-gray">				
					<?php 
					if(isLoginUser() && ($this->router->fetch_class()!='frontend')){ ?>
						<div class="row heightSpacer">
								<div class="Fleft breadcrumb"><!-- removed the class cell-->
									<?php echo isset($breadcrumbString)?$breadcrumbString:set_breadcrumb(); ?>
								</div>
						 </div>
						<?php
					}  
					echo $content?>
					<!--</div>-->
			</div><!--right_column-->
            
            <div class="clear"></div>
            </div><!--content_wrapper-->   
   
   <?php $this->load->view('footer');?>
            
		<div class="clear"></div> 
         
    </div><!--wrapper_toad-->
    </div><!--main-->   

<script>
$('.Main_btn_right a').click(function(){
						
		$(this).parent().parent().parent().addClass('Main_select ');
		$(this).parent().parent().parent().siblings().removeClass('Main_select ');
	 })
		
  renderMaxHeight()


  function getShortLink (url,viewType) {	
  	
		$.ajax
		({     
			type: "POST",
			dataType: 'json',
			data:{url:url},			
			url: baseUrl+language+"/shortlink/addShortLink",

				success: function(msg){  									
					 if(viewType=='share') {															
						openUserLightBox('popupBoxWp','popup_box','/share/socialShare',msg.shortlink);
					 }
					 else if(viewType=='email') {						   
						  openUserLightBox('popupBoxWp','popup_box','/share/shareEmail',msg.shortlink);
					 }      
				}
		});			
	}	

</script>
</body>
</html>
