<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div id="wrapperL">
	<h1>Templates Manager</h1>
	<div class="box menu">
			<a href="#">Home</a>
	</div>
	
	<div class="box ">
		
		<?php if($template_view != 0) {
			
			$image_base_url = base_url('images/email_images/');
			/* Set Follow us link*/
			
			$facebook_url = $this->config->item('facebook_follow_url');
			$linkedin_url = $this->config->item('linkedin_follow_url');
			$newTemplatDetail=$template_view[0]->templates;
			
			$searchArray = array("{image_base_url}","{facebook_url}","{linkedin_url}");
			$replaceArray = array($image_base_url.'/',$facebook_url,$linkedin_url);
			$newTemplatDetail=str_replace($searchArray, $replaceArray, $template_view[0]->templates);
			
			echo $newTemplatDetail; 
			
			}
		?>
	</div>
</div>
