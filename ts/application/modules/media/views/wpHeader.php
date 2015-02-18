<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$sectionId=($indusrtyId > 0)?$indusrtyId:$this->config->item($industryType.'SectionId');
?>
<div class="row">
	<div class=" cell frm_heading">
		<h1><?php echo $constant['project_heading']?></h1>
	</div>
	
	<div class="cell frm_element_wrapper pt15">
		<div class="tds-button-big fl ml-8 "> 
			<?php 
			if($industryType != 'news'){
				/*if(isset($userNavigations) && is_array($userNavigations) && count($userNavigations) > 0 &&(in_arrayr( 'news', $userNavigations, $key='section', $is_object=0 ) )){ 
					$newsHref=base_url(lang().'/media/news/');
				}else{
					$newsHref='javascript:getUserContainers(\'3:1\',\'/media/news/newProject/projectDescription\');';
				}*/
				$newsHref=base_url(lang().'/media/news/');
				?>
				<a onmousedown="mousedown_big_button(this)" onmouseout="mouseout_big_button(this)" onmouseup="mouseup_big_button(this)" href="<?php echo $newsHref;?>"><span class="two_line"><?php echo $this->lang->line('newsCollection');?></span></a>
				<?php
			}
			if($industryType != 'reviews'){
				/*if(isset($userNavigations) && is_array($userNavigations) && count($userNavigations) > 0 &&(in_arrayr( 'reviews', $userNavigations, $key='section', $is_object=0 ) )){ 
					$reviewsHref=base_url(lang().'/media/reviews/');
				}else{
					$reviewsHref='javascript:getUserContainers(\'3:2\',\'/media/reviews/newProject/projectDescription\');';
				}*/
				$reviewsHref=base_url(lang().'/media/reviews/');
				?>
				<a onmousedown="mousedown_big_button(this)" onmouseout="mouseout_big_button(this)" onmouseup="mouseup_big_button(this)" href="<?php echo $reviewsHref;?>"><span class="two_line"><?php echo $this->lang->line('reviewsCollection');?></span></a>
				<?php
			}if($industryType != 'writingNpublishing'){?>
				<a onmousedown="mousedown_big_button(this)" onmouseout="mouseout_big_button(this)" onmouseup="mouseup_big_button(this)" href="<?php echo base_url(lang().'/media/writingNpublishing/');?>"><span class="two_line"><?php echo $this->lang->line('writingNpublishingIndex');?></span></a>
				<?php
			}?>
		</div>
		<div class="row line1"></div>
	</div>
	
	
</div><!--row-->
<div class="row seprator_5"></div>  

