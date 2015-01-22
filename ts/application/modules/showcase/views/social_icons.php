<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php 
     if(isset($userSocialLinks) && is_array($userSocialLinks) && count($userSocialLinks)>0) { ?>
		<div class="bdr_4c4c4c ml10 Fleft  pl10 PE_news_scroll_btn_box_enterprise slider pr3" id="slider4">
			   <a href="#" class="buttons prev mr10"></a>
				  <div class="viewport width_139 socialicon_new socialslider_new mt5 social_bookmark_icon_enterprise">
					  					
				<ul class="overview">
					
					<?php foreach($userSocialLinks as $linkImage) { 
						
							if($linkImage->profileSocialMediaPath!='') {
									$link = addhttp($linkImage->socialLink);
									
									 $linkClass ='';
									 if($linkImage->profileSocialMediaName!='') {
										 
										  $linkClass = strtolower(str_replace(' ','_',$linkImage->profileSocialMediaName));					 
										}?>
									
										   <li>
											  <a href="<?php echo $link ?>" class="<?php echo $linkClass ?>" target="_blank">  </a>
										   </li>
					
					<?php }       } ?>
				
				</ul>
					</div>
					 <a href="#" class="buttons next"></a>
					</div>

		
		
		<script type="text/javascript">
		/*tab function*/
			$(document).ready(function(){
					$('#slider4').tinycarousel();
				});
				
		</script>
	

<?php } ?>
