<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<div class="dash_nav">
	<ul>
		<li class="ptr" onclick="window.location.href='<?php echo base_url(lang().'/dashboard/showcase');?>'">
			<a href="<?php echo base_url(lang().'/dashboard/showcase');?>">
				<div class="fl">	
							<img src="<?php echo base_url();?>images/icons/Members_S.jpg" alt="member" class="bdr_white dashbox-shedow"> 
				</div>
			</a>
			<span class="ml8 fl mt15 width_163"> <a href="<?php echo base_url(lang().'/dashboard/showcase');?>" class="<?php echo (isset($smSelected) || $innerPage=='welcome_showcase')?'selected':'';?>">Showcase Homepage</a></span>
		</li>
		
		
		<li class="ptr" onclick="window.location.href='<?php echo base_url(lang().'/dashboard/workprofile');?>'">
			<a href="<?php echo base_url(lang().'/dashboard/workprofile');?>">
				<div class="fl">	
					
							<img src="<?php echo base_url();?>images/icons/Work-Profile_S.jpg" alt="Profile" class="bdr_white dashbox-shedow"> 
						</div>
			</a>
			<span class="ml8 fl mt15 width_163"> <a href="<?php echo base_url(lang().'/dashboard/workprofile');?>" class="<?php echo (isset($wpSelected)|| $innerPage=='welcome_workprofile')?'selected':'';?>">Work Profile</a></span>
		</li>
		<li class="ptr" onclick="window.location.href='<?php echo base_url(lang().'/dashboard/upcoming');?>'">
			<a href="<?php echo base_url(lang().'/dashboard/upcoming');?>">
				<div class="fl">
				
							<img src="<?php echo base_url();?>images/icons/Upcoming_S.jpg" alt="Upcoming" class="bdr_white dashbox-shedow"> 
					
				</div>
			</a>
			<span class="ml8 fl mt15 width_163"> <a href="<?php echo base_url(lang().'/dashboard/upcoming');?>" class="<?php echo (isset($ucSelected)|| $innerPage=='welcome_upcoming')?'selected':'';?>">Upcoming</a></span>
		</li>
		<li class="ptr" onclick="window.location.href='<?php echo base_url(lang().'/dashboard/blog');?>'">
			<a href="<?php echo base_url(lang().'/dashboard/blog');?>">
				<div class="fl">
				
							<img src="<?php echo base_url();?>images/icons/Blog_S.jpg" alt="Blog" class="bdr_white dashbox-shedow"> 
					
				</div>
			</a>
			<span class="ml8 fl mt15 width_163"> <a href="<?php echo base_url(lang().'/dashboard/blog');?>" class="<?php echo (isset($blogSelected)|| $innerPage=='welcome_blog')?'selected':'';?>">Blog</a></span>
		</li>
		
		<li class="ptr" onclick="window.location.href='<?php echo base_url(lang().'/dashboard/filmNvideo');?>'">
			<a href="<?php echo base_url(lang().'/dashboard/filmNvideo');?>">
				<div class="fl">
				
							<img src="<?php echo base_url();?>images/icons/Film-and-Video_S.jpg" alt="filmandvideo" class="bdr_white dashbox-shedow"> 
						
				</div>
			</a>
			<span class="ml8 fl mt15 width_163"> <a href="<?php echo base_url(lang().'/dashboard/filmNvideo');?>" class="<?php echo (isset($fvSelected)|| $innerPage=='welcome_filmvideo')?'selected':'';?>">Film & Video</a></span>
		</li>
		<li class="ptr" onclick="window.location.href='<?php echo base_url(lang().'/dashboard/musicNaudio');?>'">
			<a href="<?php echo base_url(lang().'/dashboard/musicNaudio');?>">
				<div class="fl">
				
							<img src="<?php echo base_url();?>images/icons/Music-and-Audio_S.jpg" alt="musicandaudio" class="bdr_white dashbox-shedow"> 
						
				</div>
			</a>
			<span class="ml8 fl mt15 width_163"> <a href="<?php echo base_url(lang().'/dashboard/musicNaudio');?>" class="<?php echo (isset($maSelected)|| $innerPage=='welcome_musicaudio')?'selected':'';?>">Music & Audio</a></span>
		</li>
		<li class="ptr" onclick="window.location.href='<?php echo base_url(lang().'/dashboard/photographyNart');?>'">
			<a href="<?php echo base_url(lang().'/dashboard/photographyNart');?>">
				<div class="fl">
					
							<img src="<?php echo base_url();?>images/icons/Photography-and-Art_S.jpg" alt="photography" class="bdr_white dashbox-shedow"> 
					
				</div>
			</a>
			<span class="ml8 fl mt15 width_163"> <a href="<?php echo base_url(lang().'/dashboard/photographyNart');?>" class="<?php echo (isset($paSelected)|| $innerPage=='welcome_photographyart')?'selected':'';?>">Photography & Art</a></span>
		</li>
		<li class="ptr" onclick="window.location.href='<?php echo base_url(lang().'/dashboard/writingNpublishing');?>'">
			<a href="<?php echo base_url(lang().'/dashboard/writingNpublishing');?>">
				<div class="fl">
				
							<img src="<?php echo base_url();?>images/icons/Writing-and-Publishing_S.jpg" alt="writingandpub" class="bdr_white dashbox-shedow"> 
						
				</div>
			</a>
			<span class="ml8 fl mt15 width_163"> <a href="<?php echo base_url(lang().'/dashboard/writingNpublishing');?>" class="<?php echo (isset($wnpSelected)|| $innerPage=='welcome_writingpublishing')?'selected':'';?>">Writing & Publishing</a></span>
		</li>
		<li class="ptr" onclick="window.location.href='<?php echo base_url(lang().'/dashboard/performancesevents');?>'">
			<a href="<?php echo base_url(lang().'/dashboard/performancesevents');?>">
				<div class="fl">
					
							<img src="<?php echo base_url();?>images/icons/Performances-and-Events_S.jpg" alt="Performances" class="bdr_white dashbox-shedow"> 
						
				</div>
			</a>
			<span class="ml8 fl mt15 width_163"> <a href="<?php echo base_url(lang().'/dashboard/performancesevents');?>" class="<?php echo (isset($peSelected)|| $innerPage=='welcome_performancesevents')?'selected':'';?>">Performances & Events</a></span>
		</li>
		<li class="ptr" onclick="window.location.href='<?php echo base_url(lang().'/dashboard/educationMaterial');?>'">
			<a href="<?php echo base_url(lang().'/dashboard/educationMaterial');?>">
				<div class="fl">
					
							<img src="<?php echo base_url();?>images/icons/Educational-Material_S.jpg" alt="educationmate" class="bdr_white dashbox-shedow"> 
					
				</div>
			</a>
			<span class="ml8 fl mt15 width_163"> <a href="<?php echo base_url(lang().'/dashboard/educationMaterial');?>" class="<?php echo (isset($emSelected)|| $innerPage=='welcome_educationalmaterial')?'selected':'';?>">Educational Material</a></span>
		</li>
		<li class="ptr" onclick="window.location.href='<?php echo base_url(lang().'/dashboard/work');?>'">
			<a href="<?php echo base_url(lang().'/dashboard/work');?>">
				<div class="fl">
					
							<img src="<?php echo base_url();?>images/icons/Work_S.jpg" alt="Work" class="bdr_white dashbox-shedow"> 
					
				</div>
			</a>
			<span class="ml8 fl mt15 width_163"> <a href="<?php echo base_url(lang().'/dashboard/work');?>" class="<?php echo (isset($workSelected)|| $innerPage=='welcome_work')?'selected':'';?>">Work</a></span>
		</li>
		<li class="ptr" onclick="window.location.href='<?php echo base_url(lang().'/dashboard/products');?>'">
			<a href="<?php echo base_url(lang().'/dashboard/products');?>">
				<div class="fl">
				<img src="<?php echo base_url();?>images/icons/Products_S.jpg" alt="Products" class="bdr_white dashbox-shedow"> 
					
				</div>
			</a>
			<span class="ml8 fl mt15 width_163"> <a href="<?php echo base_url(lang().'/dashboard/products');?>" class="<?php echo (isset($productsSelected)|| $innerPage=='welcome_products')?'selected':'';?>">Products</a></span>
		</li>
		
		<?php 
		if(is_dir(APPPATH.'modules/competition')){?>
			<li class="ptr" onclick="window.location.href='<?php echo base_url(lang().'/dashboard/competition');?>'">
				<a href="<?php echo base_url(lang().'/dashboard/competition');?>">
					<div class="fl">
					<img src="<?php echo base_url();?>images/icons/competition_S.jpg" alt="Products" class="bdr_white dashbox-shedow"> 
						
					</div>
				</a>
				<span class="ml8 fl mt15 width_163"> <a href="<?php echo base_url(lang().'/dashboard/competition');?>" class="<?php echo (isset($competitionSelected)|| $innerPage=='welcome_competition')?'selected':'';?>">Competitions</a></span>
			</li>
			<?php if(isset($userNavigations) && is_array($userNavigations) && count($userNavigations) > 0 &&(in_arrayr( 'competitionentry', $userNavigations, $key='section', $is_object=0 ) )){ ?>
				<li class="ptr" onclick="window.location.href='<?php echo base_url(lang().'/dashboard/competitionentry');?>'">
					<a href="<?php echo base_url(lang().'/dashboard/competitionentry');?>">
						<div class="fl">
						<img src="<?php echo base_url();?>images/icons/competitionentry_S.jpg" alt="Products" class="bdr_white dashbox-shedow"> 
							
						</div>
					</a>
					<span class="ml8 fl mt15 width_163"> <a href="<?php echo base_url(lang().'/dashboard/competitionentry');?>" class="<?php echo (isset($competitionEntrySelected)|| $innerPage=='welcome_competitionentry')?'selected':'';?>">Competition Enteries</a></span>
				</li>
				<?php
			}
		}
		?>
	</ul>
	<div class="clear"></div>
</div>
