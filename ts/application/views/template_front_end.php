<?PHP if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
	echo $head;
	
	$userId = (isset($userId) && is_numeric($userId))?$userId:($this->uri->segment(4)>0?$this->uri->segment(4):isLoginUser());
	
	$modulesNCLS=array('mediafrontend','search','upcomingfrontend','workshowcase','productshowcase','eventfrontend','blogs','package','help','cms');
	$modulesMethodNCLS=array('searchresult','searchform','viewproject','events','frontblog','frontcatposts','frontArchivesPost','frontpost','childposts','packageinformation','externalnews','downloadfile','ppvfile','myplaylist','termsncondition','descofservices','apps','downloadtandc','viewproject');
	$leftSide=true;
	$class_right = 'cell right_coloumn shade_white_body margin_0 bdr_bfbfbf width_798';
	$breadcrumbLeftWidth = '<div class="cell width_196">&nbsp;</div>';
	$sectionIdBg=(isset($sectionIdBg) && ($sectionIdBg!=''))?$sectionIdBg:''; 
	
	$currentModuleClass = $this->router->class;
	$currentModuleSegment = end($this->uri->segments);
	$currentShowcase =  $this->uri->segment(3);
	
/* FOR BG COLOR */
	
	$currentMethodName =  $this->router->method; 
	
    $industryType = (isset($industryType) && ($industryType!='')) ? $industryType : '' ;
	
  if( ($currentMethodName=='searchresult') || ($currentMethodName=='viewproject') )
  {
	//In search result will show related section backgorund in any conidtion wheather news or reviews
	$industryType=$industryType;
  }else
  {
	//In showcase will not show any background as per client's requirement
	$industryType ='';
  }
	
/* END */	

 	/* Review & News Background */
 	
 	if (($industryType=='news') || ($industryType=='reviews'))
 	{		
       $industryType= $newsReviewSectionBg;
       $sectionIdBg ='';	
     }
	
	/*End */
	
	$bodyClass='';
	$mainClass='main';
	// For Upcoming media bg color 
	if(isset($upcomingRecord['projIndustry']) && ($upcomingRecord['projIndustry'])!='' && ($currentMethodName!='upcoming') )
	{
		$sectionIdBg = $upcomingRecord['projIndustry'];
	}	
	
		
	if($module=='eventfrontend'){
		$class_right='cell right_coloumn shade_white_body margin_0 bdr_bfbfbf width_798';
	}

	if ((in_array($module,$modulesNCLS) && in_array($moduleMethod,$modulesMethodNCLS)) || ($module=='forums') || ($module=='help') || ($module=='report_a_problem')){
		$leftSide=false;
		$class_right='cell right_coloumn shade_white_body  mt0 ml9 width_auto';
		$breadcrumbLeftWidth='';
		if($module=='search'){
			$breadcrumbLeftWidth='<div class="cell width_196">&nbsp;</div>';
			$class_right='bg_white position_relative';
			$bodyClass='class="search_texture"';
		}
		if($moduleMethod=='events' && ($module=='eventfrontend')){
			$bodyClass='class="PE_Seamless"';
			$mainClass='PE_main_red_texture';
		}
		if($moduleMethod=='packageinformation' && ($module=='package')){
			//$bodyClass='class="lpwh_bg"';
			$bodyClass = 'class="homepage_seamless_texture"';		 
			$class_right='membership_wrapper';
		}
	}
	if($module=='upcomingfrontend'){
	 if($moduleMethod!='viewproject')
		$class_right='right_coloumn rc_purple margin_0';
	else	
		$class_right='cell right_coloumn shade_white_body mt0 ml9 width_auto ';
	
	}
	/*if($module=='blogs' && ($moduleMethod=='frontpost' || $moduleMethod=='frontblog' || $moduleMethod=='maincatposts')){
		$leftSide=false;
		$breadcrumbLeftWidth='';
		$mainClass = 'seamless_bright_yellow';
	}
	* */
	if( ( $moduleMethod=='maincatposts')){
		$leftSide=false;
		$breadcrumbLeftWidth='';
		$mainClass = 'seamless_bright_yellow';
	}
	
	if($moduleMethod=='writingpublishing'){
		$class_right='cell right_coloumn shade_white_body margin_0';
	}
	if($moduleMethod=='craves'){
		$class_right='cell right_coloumn rc_black margin_0';
	}
	if($module=='showcase' && ($moduleMethod=='index' || $moduleMethod=='aboutme' || $moduleMethod=='developementpath' || $moduleMethod=='enterprisesassociates' || $moduleMethod=='creative' ||  $moduleMethod=='creativedeveloperment' || $moduleMethod=='associatedprofessionals' || $moduleMethod=='introductoryvideo' || $moduleMethod=='interview' || $moduleMethod=='reviews' || $moduleMethod=='news' || $moduleMethod=='associatedmembers')){
		$class_right='cell right_coloumn rc_black margin_0';
	}
	
		
	if ((strcmp($industryType,'writingNpublishing')==0) || (strcmp($sectionIdBg,'3')==0 ) )
	 $bodyClass = 'class="seanless_texture_element"';
	 
	 
	 if( (strcmp($currentModuleClass,'upcomingfrontend')==0) && (strcmp($currentShowcase,'upcoming')!=0)) 
	 $bodyClass = 'class="seanless_texture"';
	
	
	if ((strcmp($industryType,'musicNaudio')==0 ) || (strcmp($sectionIdBg,'2')==0 ) )
	 $bodyClass = 'class="MA_Seamless_2_texture_element"';
	
	if(strcmp($currentModuleClass,'blogs')==0)
	 $bodyClass = 'class="seamless_bright_yellow"';
	
	if((strcmp($industryType,'photographyNart')==0) || (strcmp($sectionIdBg,'4')==0 ) ) {
	 $bodyClass = 'class="PA_strip_bg"';
	 $mainClass = 'PA_splash_texture';
	 
	}
	
	if((strcmp($industryType,'filmNvideo')==0) || (strcmp($sectionIdBg,'1')==0 ) ){
	 $bodyClass = 'class="FV_Seamless_element"';	 
	}
	
	if(strcmp($currentModuleClass,'performancesnevents')==0){
	 $bodyClass = 'class="PE_Seamless"';
	 $mainClass = 'PE_main_red_texture';	
	 	 
	}
	
	if((strcmp($industryType,'educationMaterial')==0) || (strcmp($sectionIdBg,'10')==0 )){
	 $bodyClass = 'class="EM_Seamless_element"';	 
	}
	
	if(strcmp($currentModuleClass,'forums')==0){
	 $bodyClass = 'class="Forum_Seamless"';
	 	 	 
	}
	
	if(strcmp($currentModuleClass,'help')==0){
	// $bodyClass = 'class="Help_Seamless"';
	 	$bodyClass = 'class="homepage_seamless_texture"';		 
	}
	
	/*if(strcmp($currentModuleClass,'showcase')==0){
		$bodyClass = 'class="Showcase_main_seamless_texture"';	 
	 
	}*/
	
	if(strcmp($currentModuleClass,'cms')==0){
		$bodyClass = 'class="homepage_seamless_texture"';	 
	 
	}
	
	if(strcmp($currentModuleClass,'report_a_problem')==0){
		$bodyClass = 'class="homepage_seamless_texture"';	 
	 
	}
		
	// MODULE CLASS 
	
	if((strcmp($currentModuleClass,'workshowcase')==0) && (strcmp($currentShowcase,'works')!=0)){
	 $bodyClass = 'class="Work_Seamless_element"';	 
	}
	
	if( (strcmp($currentModuleClass,'productshowcase')==0) && (strcmp($currentShowcase,'products')!=0) ){
	 $bodyClass = 'class="Product_Seamless_element"';	 
	}
	
	if( (strcmp($currentModuleClass,'productshowcase')==0) && (strcmp($currentShowcase,'product')==0) ){
	 $bodyClass = '';	 
	}
	
	if(strcmp($industryType,'productNshowcase')==0){
	 $bodyClass = 'class="Product_Seamless_element"'; 
	}
	
	if( (strcmp($currentShowcase,'preview')==0)){
	 $bodyClass = '';	 
	}
	
	if((strcmp($currentModuleClass,'competition')==0) && (strcmp($currentMethodName,'index')==0) ) {
	 $leftSide=false;	 
    }
    
    if(strcmp($currentModuleClass,'competition')==0){
		
		if($moduleMethod=='index'){
				//this condition for landing page
				$bodyClass = 'class="PA_strip_bg "';	
				$mainClass = 'PA_splash_texture';		
			}else{
				// this for showcase page
				$bodyClass = '';	
				$mainClass = '';
			}
		}
	
	
	if(strcmp($currentModuleClass,'home')==0 || strcmp($currentModuleClass,'my404')==0 ){
	 $bodyClass = 'class="lpwh_bg"';	 
	}
	
	
	
	if((strcmp($industryType,'performancesnevents')==0) || (strcmp($sectionIdBg,'9')==0 )){
	 $bodyClass = 'class="competition_strip_bg"';
	 $mainClass = 'PE_main_red_texture';	
	 	 
	}
	
	if(strcmp($sectionIdBg,'6')==0 )
	$bodyClass = 'class="Creative_Seamless"';
	
	if(strcmp($sectionIdBg,'7')==0 )
	$bodyClass = 'class="AP_Seamless"';
	
	if(strcmp($sectionIdBg,'8')==0 )
	$bodyClass = 'class="Enterprise_Seamless"';	
	
	

?>

<body <?php echo $bodyClass;?> >


<!--customAlert START-->
<div class="dn" id="popupBoxWp">
	<div class="popup_box" id="popup_box"></div>
</div>
<div id="customAlert" class="customAlert dn">
	<div id="close-customAlert" class="tip-tr close-customAlert"></div>
	<div class="customeMessage"></div>
</div>
<!--loginLightBoxWp START-->
<div id="loginLightBoxWp" class="loginLightBoxWp dn">
	<div id="close-lightBox" class="tip-tr close-customAlert"></div>
	<div class="loginFormContainer" id="loginFormContainer"></div>
</div>
<div class="contactBoxWp dn" id="contactBoxWp">
	<div id="contactContainer" class="contactContainer"></div>
</div>	
<div class="<?php echo $mainClass;?>">
 	<div class="wrapper_toad">
		<?php $this->load->view('header');?>
		<div class="content_wrapper_front">
			  <!--breadcrum-->
			<?php  if($module!='home' && ($module!='competition' || $moduleMethod=='associatedcompetition' || $moduleMethod=='showcase') ){ ?>
				<div class="row heightSpacer">
				
				<?php echo $breadcrumbLeftWidth;?>
				
				<div class="cell Fleft breadcrumb lineH_15 pb3">
					<?php echo isset($breadcrumbString)?$breadcrumbString:set_breadcrumb(); ?>
				</div>
			  </div>
			  <!--breadcrum-->
			  <div class="clear"></div>
			  <?php } ?>			  
			  <div style="position:relative; <?PHP if(!$leftSide && $module != 'search' && $module!='competition'){ echo 'margin-left:9px;'; } ?>" >
			  
				<table border="1" cellspacing="0" cellpadding="0" height="100%" class="sub_col_tbl">
					<tr>
				  
				<?php
				
				//if(isLoginUser() && $leftSide){
				 
				
				if($leftSide){
					if(isset($userNavigations) && is_array($userNavigations) && count($userNavigations) > 0 &&(in_arrayr( 'enterprises', $userNavigations, $key='section', $is_object=0 ) || in_arrayr( 'associatedprofessionals', $userNavigations, $key='section', $is_object=0 ) || in_arrayr( 'creatives', $userNavigations, $key='section', $is_object=0 ))){ 
						$userDefaultImage=($userInfo['enterprise']=='t')?$this->config->item('defaultEnterpriseImg_152_210'):($userInfo['associatedProfessional']=='t'?$this->config->item('defaultAssProfImg_152_210'):$this->config->item('defaultCreativeImg_152_210'));
					}else{
						$userDefaultImage=$this->config->item('defaultMemberImg_m');
					}
					
					$userTemplateThumbImage = addThumbFolder($userInfo['userImage'],'_m');	
					$userImage = getImage($userTemplateThumbImage,$userDefaultImage);
				
				?>

				  <td valign="top">
					<div class="left_coloumn">
						<div class="user_name_wp_front bdr_646464">
						<div class="lhsleft_imgbg ml9 mt9">
							<div class="AI_table">
								<div class="AI_cell profileieimg">
									<a href="<?php echo base_url(lang().'/showcase/index/'.$userId);?>">
										<img class="user_photo_new" src="<?PHP echo $userImage;?>" /> 
									</a>
								</div>
							</div>
						</div>
						
						<div class="pr pt10">
						  
						  <div class="name_box_front pt0 pr"><?php echo ($userInfo['enterprise']=='t')?$userInfo['enterpriseName']:$userInfo['userFullName'];?>
							<!---<div class="name_icon_box_front"> <img src="<?php //echo base_url();?>images/icon_name_box_small.png"> </div>--->
						  </div>
						  <div class="artist_type_front"> <?php echo (isset($userInfo['userArea']) && $userInfo['userArea'] != '')?$userInfo['userArea']:$userInfo['countryName']; ?></div>
						  
						</div>
						</div>
					   <?php
					   if(isset($userNavigations) && is_array($userNavigations) && count($userNavigations) > 0 &&(in_arrayr( 'enterprises', $userNavigations, $key='section', $is_object=0 ) || in_arrayr( 'associatedprofessionals', $userNavigations, $key='section', $is_object=0 ) || in_arrayr( 'creatives', $userNavigations, $key='section', $is_object=0 ))){
						   $loggedUserId=isloginUser();						        
						   $beforereqWorkProfile=$this->lang->line('beforereqWorkProfile');
						   if($loggedUserId!=$userId) {
															   
								   $recipientsId=$userId ;								    
						   }if($loggedUserId > 0){
								if($loggedUserId==$userId){
									$canNotReqOwn=$this->lang->line('canNotReqOwn');
									$functionRequestme="customAlert('".$canNotReqOwn."')";
								}else{
									$requestMe=$this->load->view('common/request_work_profile',array('userFullName'=>$userInfo['userFullName'],'userImage'=>$userImage,'recipientsId'=>$recipientsId), true);
									echo "<script>var requestProfile=".json_encode($requestMe)."</script>";
									$functionRequestme="if(checkIsUserLogin('".$beforereqWorkProfile."')){loadPopupData('popupBoxWp','popup_box',requestProfile)}";
								}
						  }else{
								
								$functionRequestme="openLightBox('popupBoxWp','popup_box','/auth/login','".$beforereqWorkProfile."')";
						  }
						   ?>
							<!--div class="seprator_3"></div-->
						
						<?php 
						if(in_arrayr( 'workprofile', $userNavigations, $key='section', $is_object=0 )){
							
							$isShowCase=true;
							if($loggedUserId > 0){
								$isShowCase= userNavigations($loggedUserId,$publishCheck=true, array('enterprises','associatedprofessionals','creatives'));
							}
							if($isShowCase){
								?>	
								<div class="position_relative mt_minus2 z_index_1">
									 <div class="left_work_profile_icon">
										<img src="<?php echo base_url('images/icon_name_box_small.png');?>">
									  </div> 
									  <ul class="leftnav_second"><li> 
										<a href="javascript:void(0)" class="left_work_profile_link dash_link_hover"  onclick="<?php echo $functionRequestme;?>" ><?php echo $this->lang->line('requestWorkProfile');?></a></li>
										
									  </ul>
																	  
									<div class="seprator_1"></div>
							   </div>
							 <?php 
							 }
						 }?>	  										
						   <div class="clear"></div>
							<div class="Left_side_menu_front">
							  <ul>
								<li class="<?php echo isset($select_showcase)?$select_showcase:'';?>"> <a href="<?php echo base_url(lang().'/showcase/index/'.$userId);?>"><span><span><?php echo $this->lang->line('showcaseHomepage');?></span></span></a></li>

								<?php
								$urlUsername = isset($urlUsername)?$urlUsername:'';
								if(in_arrayr( 'blog', $userNavigations, $key='section', $is_object=0 ) || in_arrayr( 'post', $userNavigations, $key='section', $is_object=0 )){?>
									<li class="<?php echo isset($select_blogshowcase)?$select_blogshowcase:'';?>"><a href="<?php echo base_url(lang()).'/blogshowcase/index/'.$userId;?>"><span><span><?php echo $this->lang->line('blog')?></span></span></a></li>
									<?php
								}
								if(in_arrayr( 'upcoming', $userNavigations, $key='section', $is_object=0 )){?>
									<li class="<?php echo isset($select_upcomingfrontendupcoming)?$select_upcomingfrontendupcoming:'';?>"><a href="<?php echo base_url(lang().'/upcomingfrontend/upcoming/'.$userId);?>"><span><span><?php echo $this->lang->line('upcoming')?></span></span></a></li>
									<?php
								}
								if(in_arrayr( 'filmNvideo', $userNavigations, $key='section', $is_object=0 )){?>
									<li class="<?php echo isset($select_mediafrontendfilmvideo)?$select_mediafrontendfilmvideo:'';?>"><a href="<?php echo base_url(lang().$urlUsername.'/mediafrontend/filmvideo/'.$userId);?>"><span><span><?php echo $this->lang->line('film').'&nbsp;'.$this->lang->line('&').'&nbsp;'.$this->lang->line('video')?></span></span></a></li>
									<?php
								}
								if(in_arrayr( 'musicNaudio', $userNavigations, $key='section', $is_object=0 )){?>
									<li class="<?php echo isset($select_mediafrontendmusicaudio)?$select_mediafrontendmusicaudio:'';?>"><a href="<?php echo base_url(lang().'/mediafrontend/musicaudio/'.$userId);?>"><span><span><?php echo $this->lang->line('music').'&nbsp;'.$this->lang->line('&').'&nbsp;'.$this->lang->line('audio')?></span></span></a></li>
									<?php
								}
								if(in_arrayr( 'photographyNart', $userNavigations, $key='section', $is_object=0 )){?>
									<li class="<?php echo isset($select_mediafrontendphotographyart)?$select_mediafrontendphotographyart:'';?>"><a href="<?php echo base_url(lang().'/mediafrontend/photographyart/'.$userId);?>"><span><span><?php echo $this->lang->line('photography').'&nbsp;'.$this->lang->line('&').'&nbsp;'.$this->lang->line('art')?></span></span></a></li>
									<?php
								}
								if(in_arrayr( 'writingNpublishing', $userNavigations, $key='section', $is_object=0 ) || in_arrayr( 'news', $userNavigations, $key='section', $is_object=0 ) || in_arrayr( 'reviews', $userNavigations, $key='section', $is_object=0 )){?>
									<li class="<?php echo isset($select_mediafrontendwritingpublishing)?$select_mediafrontendwritingpublishing:''; echo isset($select_mediafrontendnews)?$select_mediafrontendnews:''; echo isset($select_mediafrontendreviews)?$select_mediafrontendreviews:'';?>">
										<a href="<?php echo base_url(lang().'/mediafrontend/writingpublishing/'.$userId);?>"><span><span><?php echo $this->lang->line('writing').'&nbsp;'.$this->lang->line('&').'&nbsp;'.$this->lang->line('publishing')?></span></span></a>
									</li> <?php
								}
								if(in_arrayr( 'event', $userNavigations, $key='section', $is_object=0 ) || in_arrayr( 'launch', $userNavigations, $key='section', $is_object=0 ) || in_arrayr( 'notification', $userNavigations, $key='section', $is_object=0 )){?>
									<li class="<?php echo isset($select_eventfrontend)?$select_eventfrontend:'';?>"><a href="<?php echo base_url(lang().'/eventfrontend/eventnotification/'.$userId);?>"><span><span><?php echo $this->lang->line('performances').'&nbsp;'.$this->lang->line('&').'&nbsp;'.$this->lang->line('events')?></span></span></a></li>
									<?php
								}
								if(in_arrayr( 'educationMaterial', $userNavigations, $key='section', $is_object=0 )){?>
									<li class="<?php echo isset($select_mediafrontendeducationmaterial)?$select_mediafrontendeducationmaterial:'';?>"><a href="<?php echo base_url(lang().'/mediafrontend/educationmaterial/'.$userId);?>"><span><span><?php echo $this->lang->line('educational').'&nbsp;'.$this->lang->line('material')?></span></span></a></li>
									<?php
								}
								
								if(is_dir(APPPATH.'modules/competition') && in_arrayr( 'competition', $userNavigations, $key='section', $is_object=0 )){
									$compHref=base_url(lang().'/competition/showcase/'.$userId);
									?>
									<li class="<?php echo isset($select_competition)?$select_competition:'' ;?>"><a href="<?php echo $compHref;?>" ><span><span><?php echo $this->lang->line('competitions')?></span></span></a></li>
									<?php
								}
								if($userOtherProject>0){?>
									<li class="<?php echo isset($select_showprojectindex)?$select_showprojectindex:'';?>">
										<a href="<?php echo base_url(lang().'/showproject/index/'.$userId);?>"><span><span><?php echo $this->lang->line('otherProjects')?></span></span></a>
									</li><?php
								}
								if(in_arrayr( 'work', $userNavigations, $key='section', $is_object=0 )){?>
									<li class="<?php echo isset($select_workshowcase)?$select_workshowcase:'';?>"><a  href="<?php echo base_url(lang().'/workshowcase/works/'.$userId);?>"><span><span><?php echo $this->lang->line('work')?></span></span></a></li>
									<?php
								}
								if(in_arrayr( 'product', $userNavigations, $key='section', $is_object=0 )){?>
									<li class="<?php echo isset($select_productshowcase)?$select_productshowcase:'';?>"><a href="<?php echo base_url(lang().'/productshowcase/products/'.$userId);?>"><span><span><?php echo $this->lang->line('products')?></span></span></a></li>
									<?php
								}
								if($cravesCount >0 || $cravingmeCount>0){
									if($cravesCount >0){
										$craveLink=base_url(lang().'/craves/craveslist/'.$userId);
									}else{
										$craveLink=base_url(lang().'/craves/cravingmefrontend/'.$userId);
									}
									?>
									<li class="<?php echo isset($select_cravescraveslist)?$select_cravescraveslist:'';?>">
										<a href="<?php echo $craveLink;?>"><span><span><?php echo $this->lang->line('craves')?></span></span></a>
									</li><?php
								}
								if($buyerCommentsCount>0){?>
									<li class="bg-non"><a href="<?php echo base_url(lang().'/buyer_comment/index/'.$userId);?>"><span><span><?php echo $this->lang->line('buyersComment')?></span></span></a></li>
									<?php
								}
															
								?>
							  </ul>
							  <div class="clear"></div>
							</div>
							<div class="clear"></div>
							<div class="seprator_3"></div>
							<?php 
							
								//To show social icons of showcase
								$socialMediaCondition = array('userId'=>$userId,'for'=>'showcase');
								echo Modules::run('showcase/showUserSocialLinks',$socialMediaCondition); 
							
							?>
							<div class="clear"></div>
							<?php
							$loggedUserId=isloginUser();
							
							   
								$beforeContactmeIn=$this->lang->line('beforeContactmeIn');
								if($loggedUserId > 0){
									if($loggedUserId==$userId){
										$canNotContactme=$this->lang->line('canNotContactme');
										$functionContactme="customAlert('".$canNotContactme."')";
									}else{
										$contactMe=$this->load->view('common/contactme',array('userId'=>$userId,'userFullName'=>$userInfo['userFullName'],'userImage'=>$userImage), true);
										echo "<script>var contactMe=".json_encode($contactMe)."</script>";
										$functionContactme="if(checkIsUserLogin('".$beforeContactmeIn."')){loadPopupData('popupBoxWp','popup_box',contactMe)}";
									}
								
								}else{
									
									$functionContactme="openLightBox('popupBoxWp','popup_box','/auth/login','".$beforeContactmeIn."')";
								}
								?>
									
								<div class="seprator_3"></div>
								<div class="Left_side_menu_front contactme">
									 <a class="contact_me dash_link_hover" href="javascript:void(0)" onclick="<?php echo $functionContactme;?>"><?php echo $this->lang->line('contactMe')?></a><span class="clear"></span>
								</div>
								<?php
							
						}?>
						
						<div class="clear"></div>
						<div class="seprator_10"></div>
						<?php
						if(is_dir(APPPATH.'modules/advertising') && !empty($advertSectionId)){
							//manage auto advert params and js methods
							if($advertSectionId==6 || $advertSectionId==7 || $advertSectionId==8 || $advertSectionId==16 || $advertSectionId==25 || $advertSectionId==26 ||  $advertSectionId==27) {
								echo $advertChangeView; 
							}
						}
						?>
						<div class="ad_box ml11 width172px height172" id="advert170_170">
							<?php 
							if(is_dir(APPPATH.'modules/advertising') && !empty($advertSectionId)){
								//Manage right side advert
								$bannerRhsData =  Modules::run("advertising/getAdvertRecords", array('sectionId'=>$advertSectionId,'advertType'=>'4'));
								if(!empty($bannerRhsData)) {
									$this->load->view('common/advert',array('bannerData'=>$bannerRhsData,'advertType'=>'4','sectionId'=>$advertSectionId)); 
								} else { 
									$this->load->view('common/adv_lhs_bot');
								} 
							} else {
								$this->load->view('common/adv_lhs_bot');
							}?> 	
						</div>
					  </div>
				  </td>
				  <!--left_coloumn-->
				 <?php
				} 
			 ?>
			 
				
				<?php echo $content?>
				
				
			</tr></table>
			<?php if($module=='forums' || $module=='help')
								{ ?>
			<div class="pt5"></div>
			
			<?php }  
					
					if($leftSide){

						if($module!='competition' &&  $module!='buyer_comment' &&   $module!='showcase' && $module!='upcomingfrontend' && $module!='craves' && $module!='showproject' && $module!='report_a_problem'){						

							$this->load->view('common/strip',array('class'=>'cell shadow_wp strip_absolute_right'));	
						}
					}else if($module!='upcomingfrontend' && $module != 'search' && $module != 'report_a_problem' && $module != 'cms'  && $module != 'competition' ){
						if($module!='package' && $moduleMethod!='packageinformation'){
							if(!($moduleMethod =='externalnews' || $moduleMethod =='downloadfile'|| $moduleMethod =='ppvfile' || $moduleMethod =='myplaylist')){
								
								//This Condition for showing view in forums and help 
								if($module=='forums' || $module=='help')
								{
									$this->load->view('common/strip',array('class'=>'cell shadow_wp strip_absolute_right right_446'));
								}else
								{
									$this->load->view('common/strip',array('class'=>'cell shadow_wp strip_absolute_right right_480'));
								}	
							}
						}
						$this->load->view('common/strip',array('class'=>'cell shadow_wp strip_absolute_right left_801'));
					}else if($module == 'search'){
						$this->load->view('common/strip',array('class'=>'cell shadow_wp strip_absolute_right left_193'));
						$this->load->view('common/strip',array('class'=>'cell shadow_wp strip_absolute_right right_166'));
					
					}
					else if($module == 'report_a_problem' || $module == 'cms'){
						$this->load->view('common/strip',array('class'=>'cell shadow_wp strip_absolute_right left_801'));
					}
				?>
				
			</div>
			
			 
		</div>
		<!--content_wrapper-->
		<?php $this->load->view('footer',array('module'=>$module));?> 
            
  </div><!--wrapper_toad-->
</div><!--main--> 
</body>
</html>
