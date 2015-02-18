<?PHP if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
	  <div class="position_relative"><img src="<?php echo base_url();?>images/parallax/beta.png" class="beta left_338 mt-8"></div>	
      <div class="toadlogo pl8"><img class="di" src="<?php echo base_url();?>images/parallax/toadlogo_small_b.png" alt="ToadSquare"></div>
      <?php $isLoginUser = isLoginUser(); 
      $iconPt='';
	  $menuWidth='';
		  $iconPt='mt15';
		  $menuWidth='width331px';
		  ?>
		  <span class="gray_color-paral fl pl50 mt-5 lH18">
			<?php 
			$userName=$isLoginUser?LoginUserDetails('firstName'):$this->lang->line('guest');
			if($isLoginUser && LoginUserDetails('enterprise')=='t'){
				$userName = LoginUserDetails('enterpriseName');
			}
			echo   $this->lang->line('welcome').'&nbsp;<b>'.$userName.'.</b><br>'.$this->lang->line('youAreIn').'&nbsp;<b>'.getCountryFromIP().'.</b>';
			?>
		  </span>
		  <?php
		if(is_dir(APPPATH.'modules/competition')){ 
			$navfirst_child = '';	
			$para_nav_left = 'para_nav_left';	
			$para_nav_right = 'para_nav_right';	
		
		}else { 
			$navfirst_child = 'navfirst_child';	 
			$para_nav_left = '';	
			$para_nav_right = ''; 
		} ?>
   
	<div id="mainmenu" class="width_auto">
		<div class="wrappermenu mt-18">
			<ul class="navigation paralaxnav l_tinynav1" id="nav11">
				<?php 
				if($isLoginUser){?>
				
				<li data-slide="1"><a href="<?php echo base_url(lang().'/showcase/index/'.isLoginUser());?>"><?php echo $this->lang->line('showcase')?></a></li>
				<li data-slide="1"><a href="<?php echo base_url(lang().'/dashboard/');?>"><?php echo $this->lang->line('dashboardHead')?></a></li>
				<li data-slide="1"><a href="<?php echo base_url(lang().'/auth/logout');?>"><?php echo $this->lang->line('logout')?></a></li>
				
				<?php } else{?>
				<li data-slide="1"><a href="javascript:void(0);" onclick="javascript:openLightBox('popupBoxWp','popup_box','/auth/login');">Login</a></li>
				<li data-slide="2"><a href="<?php echo base_url(lang().'/package/packagestageone');  ?>" >Join</a></li>
				<li data-slide="3"><a href="<?php echo base_url(lang().'/package/packagestageone');?>" class="membertips">Membership Information</a></li>
				<?php }?>
				<li data-slide="4"><a href="<?php echo base_url(lang().'/tips/front_tips');?>" class="membertips">Tips</a></li>
			</ul>
		</div>
		<div class="clear">
		</div>
		<div class="fl ml8 mt-8">
			 <?php if(!$isLoginUser){?>
        <div class="fl"><a href="javascript:void(0);" onclick="javascript:open_window('<?php echo getFacebookLoginUrl(); ?>'); $(this).parent().trigger('close');"><img class="di" src="<?php echo base_url();?>images/parallax/login.png"></a></div>
        <?php }?>
		</div>
		<div class="position_relative">
			<form action="<?php echo base_url(lang().'/search/searchform');?>" method="post" accept-charset="utf-8" name="SearchHeaderForm" id="SearchHeaderForm">						
				<input name="keyWord" type="text" class="paralaxinput fr mr8 mt-8 lH5" placeholder="Keyword Search..." value="Keyword Search..." onclick="placeHoderHideShow(this,'Keyword Search...','hide')" onblur="placeHoderHideShow(this,'Keyword Search...','show')">
				<input name="sectionId" type="hidden" value="">
				<div>
					<input type="submit" name="searchCrave" value="" class="paralax_searchicon borderNone  mt-8 ptr">
				</div>
			</form>
		</div>
		<div class="clear">
		</div>
	</div>	
	<div class="clear"></div>
    <?php //if($isLoginUser){?>
    <div class="bg_white_trans">
		<div class="nav_toad mt2 bdrt_e0e0e0 bdrb_none">
			  <div class="nav_left <?php echo $para_nav_left; ?>">
					<ul>
						<li class='<?php echo $navfirst_child; ?>' ><a class="<?php echo isset($topMenu_creatives)?$topMenu_creatives:'';?>" href="<?php echo base_url(lang().'/creatives/');?>"><?php echo $this->lang->line('creatives')?></a> </li>
						<li>
							<a class="<?php echo isset($topMenu_associateprofessional)?$topMenu_associateprofessional:'';?>" href="<?php echo base_url(lang().'/associateprofessional/');?>"><?php echo $this->lang->line('associated')?> <br/> 
							<?php echo $this->lang->line('professional')?></a>
						</li>
						<li><a class="<?php echo isset($topMenu_enterprises)?$topMenu_enterprises:'';?>" href="<?php echo base_url(lang().'/enterprises/');?>"><?php echo $this->lang->line('enterprises')?></a></li>
						<?php	if(is_dir(APPPATH.'modules/competition')){ ?>
						<li><a class="<?php echo isset($topMenu_enterprises)?$topMenu_enterprises:'';?>" href="javascript:void(0)">Fans</a></li>
						<?php } ?>
					</ul>
          			 
			  </div><!--nav_left-->
			  <div class="nav_right <?php echo $para_nav_right; ?>">
				<ul>
					<li><a class="<?php echo isset($topMenu_filmnvideo)?$topMenu_filmnvideo:'';?>" href="<?php echo base_url(lang().'/filmnvideo/');?>"><?php echo $this->lang->line('film').'&nbsp;'.$this->lang->line('&').' <br/>'.$this->lang->line('video')?> </a></li>
					<li><a class="<?php echo isset($topMenu_musicnaudio)?$topMenu_musicnaudio:'';?>" href="<?php echo base_url(lang().'/musicnaudio/');?>"><?php echo $this->lang->line('music').'&nbsp;'.$this->lang->line('&').' <br/>'.$this->lang->line('audio')?></a></li>
					<li><a  class="<?php echo isset($topMenu_photographynart)?$topMenu_photographynart:'';?>" href="<?php echo base_url(lang().'/photographynart/');?>"><?php echo $this->lang->line('photography').'<br/>'.$this->lang->line('&').'&nbsp;'.$this->lang->line('art')?> </a></li>
					<li><a class="<?php echo isset($topMenu_writingnpublishing)?$topMenu_writingnpublishing:'';?>" href="<?php echo base_url(lang().'/writingnpublishing/');?>"><?php echo $this->lang->line('writing').'&nbsp;'.$this->lang->line('&').' <br/>'.$this->lang->line('publishing')?></a></li>
					<li><a class="<?php echo isset($topMenu_performancesnevents)?$topMenu_performancesnevents:'';?>" href="<?php echo base_url(lang().'/performancesnevents/');?>"><?php echo $this->lang->line('performances').'<br/>'.$this->lang->line('&').'&nbsp;'.$this->lang->line('events')?></a></li>
					<li><a class="<?php echo isset($topMenu_educationnmaterial)?$topMenu_educationnmaterial:'';?>"  href="<?php echo base_url(lang().'/educationnmaterial/');?>"><?php echo $this->lang->line('educational')?> <br/> <?php echo $this->lang->line('material')?></a></li>
					<?php
					if(is_dir(APPPATH.'modules/competition')){ ?>
						<li><a class="<?php echo isset($topMenu_competition)?$topMenu_competition:'';?>"  href="<?php echo base_url(lang().'/competition/index');?>"><?php echo $this->lang->line('competitions')?></a></li>
					<?php } ?>
					
					<li><a class="<?php echo isset($topMenu_works)?$topMenu_works:'';?>" href="<?php echo base_url(lang().'/works/');?>"><?php echo $this->lang->line('work')?></a></li>
					<li><a class="<?php echo isset($topMenu_products)?$topMenu_products:'';?>" href="<?php echo base_url(lang().'/products/');?>"><?php echo $this->lang->line('products')?></a></li>
					<li><a class="<?php echo isset($topMenu_blogs)?$topMenu_blogs:'';?>" href="<?php echo base_url(lang().'/blogs/index');?>"><?php echo $this->lang->line('blogs')?></a></li>
					<li><a class="<?php echo isset($topMenu_forums)?$topMenu_forums:'';?>" href="<?php echo base_url(lang().'/forums');?>"><?php echo $this->lang->line('forums')?></a></li>
					<li class="width_8">&nbsp;</li>
				</ul>
			  </div><!--nav_right-->
		</div>
	</div>
