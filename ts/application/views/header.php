<?PHP if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$p0=isset($p0)?$p0:'';
?>
<div class="header_wrapper pr <?php echo $p0;?>">		
	<?php 
	
	//getVisitorsIp();
	if($moduleMethod=='preview'){
	
		echo '<div id="previewFlag"></div>';
	 }
	 if(is_dir(APPPATH.'modules/competition')){
		 $nav_toad='nav_toad_dev2';
		 $nav_left='nav_left_dev2 ml5';
	 }else{
		 $nav_toad='nav_toad';
		 $nav_left='nav_left';
	 }
	 
	 ?>
		<div class="header_bg">
			<div class="header_toad pt6_imp"> 
			<div class="position_relative"><img src="<?php echo base_url('images/frontend/beta.png');?>" class="beta left_317 mt-1" /></div>
			<a href="<?php echo base_url(lang().'/home');?>"><img src="<?PHP echo $imagePath;?>toadlogo_small.png" alt="ToadSquare" class="toad_logo"/></a>
			
			       
			        <div class="header_right">  
                    <span class="padding-right0 mt-5"><a class="colr_B2B2B2" href="<?php echo base_url(lang().'/tips/front_tips');?>"><?php echo $this->lang->line('tips')?></a></span> 
                    
                    <?php if(isLoginUser()){?>
						<span class="afterLogin mt-5">
								<a href="<?php echo base_url(lang().'/auth/logout');?>" class="colr_B2B2B2"><b><?php echo $this->lang->line('logout')?></b></a>
						</span>
						
						<span class="afterLogin mt-5"><a class="gray_color-3" href="<?php echo base_url(lang().'/cart/wishlist');?>"><?php echo $this->lang->line('cart')?></a> </span> 
						 <span class="afterLogin mt-5"><a class="gray_color-3" href="<?php echo base_url(lang().'/dashboard/');?>"><?php echo $this->lang->line('dashboardHead')?></a></span> 
						<span class="afterLogin mt-5"><a class="gray_color-3" href="<?php echo base_url(lang().'/showcase/index/'.isLoginUser());?>"><?php echo $this->lang->line('showcase')?></a></span> 
					
					
						<?php 
					}else{
							/*
							$loginFrom=$this->load->view('auth/login_form','', true);
							$registerFrom=$this->load->view('auth/register_form','', true);
							$forgot_passwordFrom=$this->load->view('auth/forgot_password_form','', true);
							$emailAlreadyExistFrom=$this->load->view('auth/email_already_exist','', true);
						?>
						<script>
							var loginFrom=<?php echo json_encode($loginFrom);?>;
							var registerFrom=<?php echo json_encode($registerFrom);?>;
							var forgot_passwordFrom=<?php echo json_encode($forgot_passwordFrom);?>;
							var emailAlreadyExistFrom=<?php echo json_encode($emailAlreadyExistFrom);?>;
						</script>
						
						<span>
								<a href="javascript:loadPopupData('popupBoxWp','popup_box',registerFrom)" class="gray_color-0"><b><?php echo $this->lang->line('join')?></b></a>
						</span>
						<span>
								<a href="javascript:loadPopupData('popupBoxWp','popup_box',loginFrom)" class="askForLogin gray_color-0" id="askForLogin"><b><?php echo $this->lang->line('login')?></b></a>
						</span>
						*/?>
						<span class="beforeLogin mt-5">
								<a href="<?php echo base_url(lang().'/package/packagestageone');?>" class="colr_B2B2B2"><?php echo $this->lang->line('membershipInformation')?></a>
						</span>
						<span class="beforeLogin mt-5">
								<!--<a href="javascript:if(checkIsUserLogin('')){refreshPge()}else{openLightBox('popupBoxWp','popup_box','/auth/register')}" class="gray_color-0"><b><?php echo $this->lang->line('join')?></b></a>-->
								<a href="<?php echo base_url(lang().'/package/packagestageone');  ?>" class="colr_B2B2B2"><b><?php echo $this->lang->line('join')?></b></a>
						</span>
						<span class="beforeLogin mt-5">
								<!--<a href="javascript:if(checkIsUserLogin('')){refreshPge()}else{openLightBox('popupBoxWp','popup_box','/auth/login')}" class="askForLogin gray_color-0" id="askForLogin"><b><?php echo $this->lang->line('login')?></b></a>-->
								<a href="javascript:openLightBox('popupBoxWp','popup_box','/auth/login');" class="askForLogin colr_B2B2B2" id="askForLogin"><b><?php echo $this->lang->line('login')?></b></a>
						</span>
						<?php 
					}?>
                   <span class="gray_color-1 welcome_textFleft pl30 mt-4 clr_acacac">
						<?php 
						//Commented to show updated user firstname
						//$userName=isLoginUser()?LoginUserDetails('firstName'):$this->lang->line('guest');
						$isLoginUser=isLoginUser();
						$userName=$isLoginUser?LoginUserDetails('firstName'):$this->lang->line('guest');
						if($isLoginUser && LoginUserDetails('enterprise')=='t'){
							$userName = LoginUserDetails('enterpriseName');
						}
						echo   $this->lang->line('welcome').'&nbsp;<b>'.$userName.'.</b><br>'.$this->lang->line('youAreIn').'&nbsp;<b>'.getCountryFromIP().'.</b>';
						?>
					</span>
                    <div class="search_box_wrapper_header ml_385 width_264px" id="search_div" class="dn">
                    	
						<?php if(!$isLoginUser){?>
						<a href="javascript:void(0);" onclick="javascript:open_window('<?php echo getFacebookLoginUrl(); ?>'); $(this).parent().trigger('close');"><img class="di pa mt-2" src="<?php echo base_url();?>images/parallax/login.png"></a>
						<?php }?>
                    	<?php
							$formAttributes = array(
								'name'=>'SearchHeaderForm',
								'id'=>'SearchHeaderForm',
							);
							echo form_open(base_url(lang().'/search/searchform'),$formAttributes);
						?>
							<input name="keyWord" type="text" class="paralaxinput fr mt-1" placeholder="<?php echo $this->lang->line('keywordSearch');?>" value="<?php echo $this->lang->line('keywordSearch');?>" onclick="placeHoderHideShow(this,'<?php echo $this->lang->line('keywordSearch');?>','hide')" onblur="placeHoderHideShow(this,'<?php echo $this->lang->line('keywordSearch');?>','show')" />
							<input name="sectionId" type="hidden" value="">
							<div>
								<input type="submit" name="searchCrave" value="" class="paralax_searchicon borderNone  mt-8 ptr">
								<!--<input type="image" value="searchCrave" name="searchCrave" src="<?php //echo base_url();?>images/btn_search_box.png">-->
							</div>
                        <?php echo form_close(); ?>
                  </div><!--search_box_wrapper-->
         
          </div>
          <!--header_right-->
          <div class="clear"></div>
			</div><!--header_toad-->
			
			<div class="<?php echo $nav_toad?>">
          <div class="<?php echo $nav_left?>">
            <ul>
								<li class="navfirst_child"><a class="<?php echo isset($topMenu_creatives)?$topMenu_creatives:'';?>" href="<?php echo base_url(lang().'/creatives/');?>"><?php echo $this->lang->line('creatives')?></a> </li>
								<li>
									<a class="<?php echo isset($topMenu_associateprofessional)?$topMenu_associateprofessional:'';?>" href="<?php echo base_url(lang().'/associateprofessional/');?>"><?php echo $this->lang->line('associated')?> <br/> 
									<?php echo $this->lang->line('professional')?></a>
								</li>
								<li><a class="<?php echo isset($topMenu_enterprises)?$topMenu_enterprises:'';?>" href="<?php echo base_url(lang().'/enterprises/');?>"><?php echo $this->lang->line('enterprises')?></a></li>
								
								<?php if(is_dir(APPPATH.'modules/competition')){ ?>
									<li><a class="" href="javascript:void(0)">Fans</a></li>
								<?php  } ?>

							</ul>
          </div><!--nav_left-->
          <div class="nav_right">
            <ul>
				<li><a class="<?php echo isset($topMenu_filmnvideo)?$topMenu_filmnvideo:'';?>" href="<?php echo base_url(lang().'/filmnvideo/');?>"><?php echo $this->lang->line('film').'&nbsp;'.$this->lang->line('&').' <br/>'.$this->lang->line('video')?> </a></li>
				<li><a class="<?php echo isset($topMenu_musicnaudio)?$topMenu_musicnaudio:'';?>" href="<?php echo base_url(lang().'/musicnaudio/');?>"><?php echo $this->lang->line('music').'&nbsp;'.$this->lang->line('&').' <br/>'.$this->lang->line('audio')?></a></li>
				<li><a  class="<?php echo isset($topMenu_photographynart)?$topMenu_photographynart:'';?>" href="<?php echo base_url(lang().'/photographynart/');?>"><?php echo $this->lang->line('photography').'<br/>'.$this->lang->line('&').'&nbsp;'.$this->lang->line('art')?> </a></li>
				<li><a class="<?php echo isset($topMenu_writingnpublishing)?$topMenu_writingnpublishing:'';?>" href="<?php echo base_url(lang().'/writingnpublishing/');?>"><?php echo $this->lang->line('writing').'&nbsp;'.$this->lang->line('&').' <br/>'.$this->lang->line('publishing')?></a></li>
				<li><a class="<?php echo isset($topMenu_performancesnevents)?$topMenu_performancesnevents:'';?>" href="<?php echo base_url(lang().'/performancesnevents/');?>"><?php echo $this->lang->line('performances').'<br/>'.$this->lang->line('&').'&nbsp;'.$this->lang->line('events')?></a></li>
				<li><a class="<?php echo isset($topMenu_educationnmaterial)?$topMenu_educationnmaterial:'';?>"  href="<?php echo base_url(lang().'/educationnmaterial/');?>"><?php echo $this->lang->line('educational')?> <br/> <?php echo $this->lang->line('material')?></a></li>
				<?php
				if(is_dir(APPPATH.'modules/competition')){
					?>
					<li><a class="<?php echo isset($topMenu_competition)?$topMenu_competition:'';?>"  href="<?php echo base_url(lang().'/competition/index');?>"><?php echo $this->lang->line('competitions')?></a></li>
					<?php
				} ?>
				
				<li><a class="<?php echo isset($topMenu_works)?$topMenu_works:'';?>" href="<?php echo base_url(lang().'/works/');?>"><?php echo $this->lang->line('work')?></a></li>
				<li><a class="<?php echo isset($topMenu_products)?$topMenu_products:'';?>" href="<?php echo base_url(lang().'/products/');?>"><?php echo $this->lang->line('products')?></a></li>
				<li><a class="<?php echo isset($topMenu_blogs)?$topMenu_blogs:'';?>" href="<?php echo base_url(lang().'/blogs/index');?>"><?php echo $this->lang->line('blogs')?></a></li>
				<li><a class="<?php echo isset($topMenu_forums)?$topMenu_forums:'';?>" href="<?php echo base_url(lang().'/forums');?>"><?php echo $this->lang->line('forums')?></a></li>
				<li class="width_8">&nbsp;</li>
            </ul>
          </div><!--nav_right-->
        </div>        <!--nav_toad-->
			
		</div><!--header_bg-->
		<div class="clear"></div>
    </div><!--header_wrapper-->
