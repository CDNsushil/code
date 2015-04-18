<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php if(isset($userSocialLinks) && is_array($userSocialLinks)  && count($userSocialLinks)>0 ) {  ?>

         <div class="bdr_595959 ml10 Fleft  pl15 PE_news_scroll_btn_box_enterprise slider pr3 bg_leftMenu" id="sliderIcons">
			   <a href="#" class="buttons prev mr10"></a>
		   <div class="viewport socialicon_new socialsliderleft mt5 social_bookmark_icon_enterprise">
				<ul class="overview">
					
				<?php foreach($userSocialLinks as $linkImage) { 
					
					
					 $link = addhttp($linkImage->socialLink);
					 $linkClass ='';
					 if($linkImage->profileSocialMediaName!='')
					 {
						$linkClass = strtolower(str_replace(' ','_',$linkImage->profileSocialMediaName));					 

					 }
					else{
						$linkClass = 'blink_list';
					}	 
					?>

				<li> 
					 <a href="<?php echo $link ?>" class="<?php echo $linkClass ?>" target="_blank">
						
					 </a> 
				</li>
				
					<?php 
				
				} ?>
				
				</ul>
				</div>
				 <a href="#" class="buttons next"></a>
				</div>

		<script type="text/javascript">
		/*tab function*/
			$(document).ready(function(){
					$('#sliderIcons').tinycarousel();
				});
				
		</script>

<?php } ?>
