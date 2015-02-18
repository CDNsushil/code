<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<div class="row fr mr10 mb5">
		<div class="indexsocial_cont font_opensansSBold font_size14 clr_white">
			<div class="fl">
				<?php 
				/* Set Follow us link*/
				$facebook_url = $this->config->item('facebook_follow_url');
				$linkedin_url = $this->config->item('linkedin_follow_url');
				$twitter_url = $this->config->item('twitter_follow_url');
				$google_url = $this->config->item('google_follow_url');
				$crave_url = $this->config->item('crave_us');
				?>
				<span class="fl mt8 dark_Grey font_opensans b f11"><?php echo $this->lang->line('craveUs');?></span>
				<a href="<?php echo $crave_url;?>" class="indexsocial_press toadsquare" target="_blank"></a>
			</div>
			<div class="fl ml36">
				<span class="fl mt8 dark_Grey font_opensans b f11"><?php echo $this->lang->line('followUs');?></span>
				<a href="<?php echo $facebook_url;?>" class="indexsocial_press facebook_footer" target="_blank"></a>
				<a href="<?php echo $twitter_url;?>" class="indexsocial_press twitter_footer" target="_blank"></a>
				<a href="<?php echo $linkedin_url;?>" class="indexsocial_press linkedin_footer" target="_blank"></a>
				<a href="<?php echo $google_url;?>" class="indexsocial_press googleplus_footer" target="_blank"></a>
			</div>
		</div>
		<div class="clear"></div>
	</div>
<div class="clear"></div>
