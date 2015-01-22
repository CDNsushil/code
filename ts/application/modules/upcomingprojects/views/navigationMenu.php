<?php
$location1 =  $this->uri->segment(1);
$location2 =  $this->uri->segment(2);
$location4 =  $this->uri->segment(4);
$location3 =  $this->uri->segment(3);
$hrefNone='javascript:void(0);';
if(($location3=='newupcomingprojects' || $location3=='additionalInformation' || $location3=='projectPromotionalImages' || $location3=='addPromotionalVideo') &&  $location4==''){ //Insert mode?>

<div class="frm_btn_wrapper mr5">
	<div class="tds-button-big Fleft disable_btn">
		<a href="javascript:void(0);"><span  class="two_line"><?php echo $label['promotionalBRMaterial'];?></span></a>
		<a href="javascript:void(0);"><span  class="two_line"><?php echo $label['additionalInformationTab'];?></span></a>
		
	</div>
	<div class="tds-button-big Fleft">
		<?php echo anchor('upcomingprojects/', '<span>'.$this->lang->line('indexPage').'</span>',array('onmousedown'=>'mousedown_big_button(this)', 'onmouseup'=>'mouseup_big_button(this)','onmouseover'=>'mouseover_big_button(this)'));
		
		?>
	</div>
</div><!--frm_btn_wrapper-->
<div class="row line1 width570px mr9"></div>
<?php }?>

<?php if(($location3=='newupcomingprojects' || $location3=='additionalInformation' || $location3=='projectPromotionalImages' || $location3=='addPromotionalVideo') &&  $location4!=''){ ?>

<div class=" frm_btn_wrapper mr5">
	<div class="tds-button-big Fleft">
	<?php 
		
		if($location3!='newupcomingprojects')
		{		
			echo anchor('upcomingprojects/newupcomingprojects/'.$projId,'<span>'.$label['projectBRInformation'].'</span>',array('onmousedown'=>'mousedown_big_button(this)', 'onmouseup'=>'mouseup_big_button(this)','onmouseover'=>'mouseover_big_button(this)'));
		}
		if($location3!='projectPromotionalImages')
		{
			echo anchor('upcomingprojects/projectPromotionalImages/'.$projId,'<span class="two_line">'.$label['promotionalBRMaterial'].'</span>',array('onmousedown'=>'mousedown_big_button(this)', 'onmouseup'=>'mouseup_big_button(this)','onmouseover'=>'mouseover_big_button(this)'));
		}
		
		
		if($location3!='additionalInformation')
		{
			echo anchor('upcomingprojects/additionalInformation/'.$projId,'<span >'.$label['additionalInformationTab'].'</span>',array('onmousedown'=>'mousedown_big_button(this)', 'onmouseup'=>'mouseup_big_button(this)','onmouseover'=>'mouseover_big_button(this)'));
		}
			
		 echo anchor('upcomingprojects/', '<span>'.$this->lang->line('indexPage').'</span>',array('onmousedown'=>'mousedown_big_button(this)', 'onmouseup'=>'mouseup_big_button(this)','onmouseover'=>'mouseover_big_button(this)'));
		 
		 
		 
	?>
	




	</div>
</div><!--row-->
<div class="row line1 width570px mr9"></div>
<?php } ?>

<?php if($location3=='deletedItems'){ ?>
<div class="row">
		<div class="cell frm_heading clr_red">
			<h1><?php echo $this->lang->line('deletedItems');?></h1>
		</div>
		
		<div class="frm_btn_wrapper mr5">
			<div class="tds-button-big Fleft">
				<?php echo anchor('upcomingprojects',  '<span>'.$this->lang->line('indexPage').'</span>',array('onmousedown'=>'mousedown_big_button(this)', 'onmouseup'=>'mouseup_big_button(this)','onmouseover'=>'mouseover_big_button(this)'));?></div>
		</div>
	</div>
<div class="row line1 width570px mr9"></div>
<?php } ?>

<?php if($location3=='index' || $location3=='' ){ ?>		
<div class="frm_btn_wrapper mr5">
	<div class="tds-button-big Fleft">
		<div>
			<?php
				$sectionId=$this->config->item('upcomingSectionId');
				$newsHref='javascript:getUserContainers(\''.$sectionId.'\',\'/upcomingprojects/newupcomingprojects\');';
				$location = 'upcomingprojects/newupcomingprojects';?>
			<a onmouseover="mouseover_big_button(this)" onmouseup="mouseup_big_button(this)" onmousedown="mousedown_big_button(this)" href="<?php echo $newsHref;?>"><span><?php echo $this->lang->line('new');?></span></a>
			<?php echo anchor('upcomingprojects/deletedItems', '<span class="two_line">'.$this->lang->line('deletedBRItems').'</span>',array('onmousedown'=>'mousedown_big_button(this)', 'onmouseup'=>'mouseup_big_button(this)','onmouseover'=>'mouseover_big_button(this)'));?>
		</div>
		<div class="clear"></div>
	</div>
</div>	
<div class="row line1 width570px mr9"></div>

<?php } ?>
<div class="row seprator_5"></div>
