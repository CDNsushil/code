<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$location = $this->uri->segment(3);
if(isset($showcaseId) && $showcaseId>0 && $showcaseId !='')
	$currentBackshowcaseId = $showcaseId;
else
	$currentBackshowcaseId = 0;

if(isset($currentBackshowcaseId) && $currentBackshowcaseId>0)
{
	 $showcaseLabel = $this->lang->line('showcaseHomePageLabel');
	 $showHomePageFormUrl = 'showcase/showcaseForm';
}
else 
{
	$showcaseLabel = $this->lang->line('showcaseHomePageLabel');
	$showHomePageFormUrl = 'showcase/showcaseForm';
}
$hrefNone='javascript:void(0);';

if(isset($userNavigations) && is_array($userNavigations) && count($userNavigations) > 0 &&(in_arrayr( 'enterprises', $userNavigations, $key='section', $is_object=0 ) || in_arrayr( 'associatedprofessionals', $userNavigations, $key='section', $is_object=0 ) || in_arrayr( 'creatives', $userNavigations, $key='section', $is_object=0 ))){ 
	$DC='';
}else{
	$DC='disable_btn';
}
?>
<div class="frm_btn_wrapper mr10">
	<div class="tds-button-big Fleft">
		<?php
		if((strcmp($location,'showcaseForm')!=0)&& (strcmp($location,'showcase')!=0))
		{
			if(($location =='') || (strcmp($location,'showcaseForm')==0)|| (strcmp($location,'showcase')==0))
			{
				echo anchor('javascript://void(0);','<span>'.$showcaseLabel.'</span>',array('class'=>'hover_none'));
			}
			else
			{
				echo anchor($showHomePageFormUrl,'<span>'.$showcaseLabel.'</span>',array('onmousedown'=>'mousedown_big_button(this)', 'onmouseup'=>'mouseup_big_button(this)','onmouseover'=>'mouseover_big_button(this)'));
			}
		}
		if((strcmp($location,'additionalInfoForm')!=0))
		{
			if($DC =='disable_btn') 
			{ 
				echo anchor('javascript://void(0);','<span class="nohover">'.$this->lang->line('additionalBRInformation').'</span>',array('class'=>'disable_btn'));
			}
			else
			{
				if(strcmp($location,'additionalInfo')==0 || strcmp($location,'additionalInfoForm')==0)
				{
					echo anchor('javascript://void(0);','<span class="nohover">'.$this->lang->line('additionalBRInformation').'</span>');
				}
				else
				{ 
					echo anchor('showcase/additionalInfoForm','<span >'.$this->lang->line('additionalBRInformation').'</span>',array('onmousedown'=>'mousedown_big_button(this)', 'onmouseup'=>'mouseup_big_button(this)','onmouseover'=>'mouseover_big_button(this)'));
					
				}
			}
		}
		if((strcmp($location,'socialMedia')!=0))
		{
			if($DC=='disable_btn') 
			{ 
				echo anchor('javascript://void(0);','<span class="nohover two_line">'.$this->lang->line('socialBRMediaLink').'</span>',array('class'=>'disable_btn'));
			}
			else
			{
				if(strcmp($location,'socialMedia')==0 || strcmp($location,'socialMedia')==0)
				{
					echo anchor('javascript://void(0);','<span class="nohover two_line">'.$this->lang->line('socialBRMediaLink').'</span>');
				}
				else
				{ 
					echo anchor('showcase/socialMedia','<span class="two_line">'.$this->lang->line('socialBRMediaLink').'</span>',array('onmousedown'=>'mousedown_big_button(this)', 'onmouseup'=>'mouseup_big_button(this)','onmouseover'=>'mouseover_big_button(this)'));
					
				}
			}
		}
		if((strcmp($location,'recommendations')!=0) && (strcmp($location,'recommendationsgiven')!=0))
		{		
			if($DC=='disable_btn') 
			{ 
				echo anchor('javascript://void(0);','<span>'.$this->lang->line('recommendations').'</span>',array('class'=>'disable_btn'));
			}
			else
			{
				if(strcmp($location,'recommendations')==0)
				{
					echo anchor('javascript://void(0);','<span>'.$this->lang->line('recommendations').'</span>');
				}
				else
				{ 
					echo anchor('showcase/recommendations/','<span>'.$this->lang->line('recommendations').'</span>',array('onmousedown'=>'mousedown_big_button(this)', 'onmouseup'=>'mouseup_big_button(this)','onmouseover'=>'mouseover_big_button(this)'));
				}
			}
		}
		?>
	</div>
</div>
<div class="row line1 mr11 width567px"></div>
