<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
	<div class="dash_nav dashboard_topgbox_1 bdr_non">
		<ul>
			<li class="ptr" onclick="window.location.href='<?php echo base_url(lang().'/dashboard/showcase');?>'">
				<div class="fl ml5 mt3">
					<img class="bdr_white dashbox-shedow" alt="member" src="<?php echo base_url();?>images/icons/Members_S.jpg">  
				</div>              
				<span class="ml8 fl mt15 width_162"> 
					<a href="<?php echo base_url(lang().'/dashboard/showcase');?>" class="<?php echo (isset($smSelected) || $innerPage=='welcome_showcase')?'selected':'';?>">Showcase Homepage</a>
				</span>
			</li>

			<li class="ptr" onclick="window.location.href='<?php echo base_url(lang().'/dashboard/blog');?>'">
				<div class="fl ml5 mt3">
					<img class="bdr_white dashbox-shedow" alt="Blog" src="<?php echo base_url();?>images/icons/Blog_S.jpg">     
				</div>
				<span class="ml8 fl mt15 width_162"> 
					<a href="<?php echo base_url(lang().'/dashboard/blog');?>" class="<?php echo (isset($blogSelected)|| $innerPage=='welcome_blog')?'selected':'';?>">Blog</a>
				</span>  
			</li>

			<li class="ptr" onclick="window.location.href='<?php echo base_url(lang().'/dashboard/workprofile');?>'">
				<div class="fl ml5 mt3">
					<img class="bdr_white dashbox-shedow" alt="Profile" src="<?php echo base_url();?>images/icons/Work-Profile_S.jpg">                   
				</div>
				<span class="ml8 fl mt15 width_162">
					<a href="<?php echo base_url(lang().'/dashboard/workprofile');?>" class="<?php echo (isset($wpSelected)|| $innerPage=='welcome_workprofile')?'selected':'';?>">Work Profile</a>
				</span>
			</li>

			<li class="ptr" onclick="window.location.href='<?php echo base_url(lang().'/dashboard/upcoming');?>'">
				<div class="fl ml5 mt3">
					<img class="bdr_white dashbox-shedow" alt="Upcoming" src="<?php echo base_url();?>images/icons/Upcoming_S.jpg"> 
				</div>
				<span class="ml8 fl mt15 width_162">
					<a href="<?php echo base_url(lang().'/dashboard/upcoming');?>" class="<?php echo (isset($ucSelected)|| $innerPage=='welcome_upcoming')?'selected':'';?>">Upcoming</a>
				</span>
			</li>

			<li class="ptr" onclick="window.location.href='<?php echo base_url(lang().'/dashboard/filmNvideo');?>'">
				<div class="fl ml5 mt3">
					<img class="bdr_white dashbox-shedow" alt="filmandvideo" src="<?php echo base_url();?>images/icons/Film-and-Video_S.jpg">
					
				</div>
				<span class="ml8 fl mt15 width_162"> 
					<a href="<?php echo base_url(lang().'/dashboard/filmNvideo');?>" class="<?php echo (isset($fvSelected)|| $innerPage=='welcome_filmvideo')?'selected':'';?>">Film &amp; Video</a>
				</span>
			</li>

			<li class="ptr" onclick="window.location.href='<?php echo base_url(lang().'/dashboard/musicNaudio');?>'">
				<div class="fl ml5 mt3">
					<img class="bdr_white dashbox-shedow" alt="musicandaudio" src="<?php echo base_url();?>images/icons/Music-and-Audio_S.jpg">     
				</div>
				<span class="ml8 fl mt15 width_162"> 
					<a href="<?php echo base_url(lang().'/dashboard/musicNaudio');?>" class="<?php echo (isset($maSelected)|| $innerPage=='welcome_musicaudio')?'selected':'';?>">Music &amp; Audio</a>
				</span>
			</li>

			<li class="ptr" onclick="window.location.href='<?php echo base_url(lang().'/dashboard/photographyNart');?>'">
				<div class="fl ml5 mt3">
					<img class="bdr_white dashbox-shedow" alt="photography" src="<?php echo base_url();?>images/icons/Photography-and-Art_S.jpg">                
				</div>
				<span class="ml8 fl mt15 width_162">
					<a href="<?php echo base_url(lang().'/dashboard/photographyNart');?>" class="<?php echo (isset($paSelected)|| $innerPage=='welcome_photographyart')?'selected':'';?>">Photography &amp; Art</a>
				</span>
			</li>

			<li class="ptr" onclick="window.location.href='<?php echo base_url(lang().'/dashboard/writingNpublishing');?>'">
				<div class="fl ml5 mt3">
					<img class="bdr_white dashbox-shedow" alt="writingandpub" src="<?php echo base_url();?>images/icons/Writing-and-Publishing_S.jpg">              
				</div>
				<span class="ml8 fl mt15 width_162"> 
					<a href="<?php echo base_url(lang().'/dashboard/writingNpublishing');?>" class="<?php echo (isset($wnpSelected)|| $innerPage=='welcome_writingpublishing')?'selected':'';?>">Writing &amp; Publishing</a>
				</span>
			</li>

			<li class="ptr" onclick="window.location.href='<?php echo base_url(lang().'/dashboard/performancesevents');?>'">
				<div class="fl ml5 mt3">
					<img class="bdr_white dashbox-shedow" alt="Performances" src="<?php echo base_url();?>images/icons/Performances-and-Events_S.jpg">               
				</div>
				<span class="ml8 fl mt15 width_162">
					<a href="<?php echo base_url(lang().'/dashboard/performancesevents');?>" class="<?php echo (isset($peSelected)|| $innerPage=='welcome_performancesevents')?'selected':'';?>">Performances &amp; Events</a>
				</span>
			</li>

			<li class="ptr" onclick="window.location.href='<?php echo base_url(lang().'/dashboard/educationMaterial');?>'">
				<div class="fl ml5 mt3">
					<img class="bdr_white dashbox-shedow" alt="educationmate" src="<?php echo base_url();?>images/icons/Educational-Material_S.jpg">   
				</div>
				<span class="ml8 fl mt15 width_162">
					<a href="<?php echo base_url(lang().'/dashboard/educationMaterial');?>" class="<?php echo (isset($emSelected)|| $innerPage=='welcome_educationalmaterial')?'selected':'';?>">Educational Material</a>
				</span>
			</li>

			<li class="ptr" onclick="window.location.href='<?php echo base_url(lang().'/dashboard/work');?>'">
				<div class="fl ml5 mt3">
					<img class="bdr_white dashbox-shedow" alt="Work" src="<?php echo base_url();?>images/icons/Work_S.jpg">                 
				</div>
				<span class="ml8 fl mt15 width_162"> 
					<a href="<?php echo base_url(lang().'/dashboard/work');?>" class="<?php echo (isset($workSelected)|| $innerPage=='welcome_work')?'selected':'';?>">Work</a>
				</span>
			</li>

			<li class="ptr" onclick="window.location.href='<?php echo base_url(lang().'/dashboard/products');?>'">
				<div class="fl ml5 mt3">
					<img class="bdr_white dashbox-shedow" alt="Products" src="<?php echo base_url();?>images/icons/Products_S.jpg">  
				</div>
				<span class="ml8 fl mt15 width_162"> 
					<a href="<?php echo base_url(lang().'/dashboard/products');?>" class="<?php echo (isset($productsSelected)|| $innerPage=='welcome_products')?'selected':'';?>">Products</a>
				</span>  
			</li>
			<?php 
		if(is_dir(APPPATH.'modules/competition')){?>
			<li class="ptr" onclick="window.location.href='<?php echo base_url(lang().'/dashboard/competition');?>'">
				<div class="fl ml5 mt3">
					<img src="<?php echo base_url();?>images/icons/competition_S.jpg" class="bdr_white dashbox-shedow"> 
				</div>
				<span class="ml8 fl mt15 width_163"> <a href="<?php echo base_url(lang().'/dashboard/competition');?>" class="<?php echo (isset($competitionSelected)|| $innerPage=='welcome_competition')?'selected':'';?>">Competitions</a></span>
			</li>
			<?php if(isset($userNavigations) && is_array($userNavigations) && count($userNavigations) > 0 &&(in_arrayr( 'competitionentry', $userNavigations, $key='section', $is_object=0 ) )){ ?>
				<li class="ptr" onclick="window.location.href='<?php echo base_url(lang().'/dashboard/competitionentry');?>'">
					<div class="fl ml5 mt3">
						<img src="<?php echo base_url();?>images/icons/competitionentry_S.jpg" class="bdr_white dashbox-shedow"> 	
					</div>
					<span class="ml8 fl mt15 width_163"> <a href="<?php echo base_url(lang().'/dashboard/competitionentry');?>" class="<?php echo (isset($competitionEntrySelected)|| $innerPage=='welcome_competitionentry')?'selected':'';?>">Competition Enteries</a></span>
				</li>
				<?php
			}
		}
		?>
		<li class="ptr" onclick="window.location.href='<?php echo base_url(lang().'/dashboard/collaboration');?>'">
				<div class="fl ml5 mt3">
					<img src="<?php echo base_url();?>images/icons/Upcoming_S.jpg" class="bdr_white dashbox-shedow"> 
				</div>
				<span class="ml8 fl mt15 width_163"> <a href="<?php echo base_url(lang().'/dashboard/collaboration');?>" class="<?php echo (isset($collaborationSelected)|| $innerPage=='welcome_collaboration')?'selected':'';?>">Collaboration</a></span>
			</li>
		</ul>
		<?php
		$shareLink = base_url('home');
		$onclickFunction = "getShortLink('".$shareLink."','email');" ;						
		$mouseEvent = 'onmouseup="mouseup_tds_button01(this)" onmousedown="mousedown_tds_button01(this)" ';
		?>
		
		<div class="invite_circlebg font_museoSlab font_size24 text_alignC lineH28 pt15 ml20 mt22">
			<a class="ptr clr_white" <?php echo $mouseEvent ?> onclick="<?php echo $onclickFunction ?>" >
			<div class="AI_table mt-10">								
				<div class="AI_cell textcontainer dash_link_hover">Invite <br />  a friend <br /> to join <br /> Toadsquare</div>
			</div>
			</a>
		</div>
		
	   <div class="advertise_bg font_museoSlab font_size24 text_alignC lineH28 pt15 mt22">
			<a class="ptr clr_green" <?php echo $mouseEvent ?> href="<?php echo base_url(lang().'/dashboard/advertise');?>" >
			<div class="AI_table mt-10">								
				<div class="AI_cell textcontainer dash_link_hover">advertise <br />  on <br /> toadsquare</div>
			</div>
			</a>
		</div>
		

		<div class="clear"></div>
	</div>
