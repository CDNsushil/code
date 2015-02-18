<?php
$location2 =  $this->uri->segment(2);
$location5 =  $this->uri->segment(5);
$location3 =  $this->uri->segment(3);
$location4 =  $this->uri->segment(4);

$classSelected = "class='Main_btn_box Main_select'";
$class ="class='Main_btn_box'";?>


<?php 
//Deleted Items
if($location2=='product' && $location3=='deletedItems') { ?>

<div class="row ">
	<div class=" cell frm_heading">
		<h1 class="padding-top7">
			<?php echo $label['deletedItems']?>
		</h1>
	</div>
	<div class="frm_btn_wrapper mr10">
		<div class="tds-button-big Fleft"><?php echo anchor('product/'.$entityMediaType, '<span>'.$label['indexPage'].'</span>',array('onmousedown'=>'mousedown_big_button(this)', 'onmouseup'=>'mouseup_big_button(this)','onmouseover'=>'mouseover_big_button(this)'));?></div>
	</div>
</div><!--row-->


<?php }?>

<?php if($location2=='product' && ($location3=='sell' || $location3=='') && $location4=='') { ?>

<div class="row">
	<div class=" cell width_200 frm_heading">
		<h1 class="padding-top7">
			<?php echo $label['productsForSell'];?>
		</h1>
	</div>
	<div class="cell margin_left_16 mr10">
		<div class="tds-button-big Fleft">
			<?php echo anchor('product/wanted','<span>'.$label['productBRWanted'].'</span>',array('onmousedown'=>'mousedown_big_button(this)', 'onmouseup'=>'mouseup_big_button(this)','onmouseover'=>'mouseover_big_button(this)'));?></div>
		<div class="tds-button-big Fleft">
			<?php echo anchor('product/freeStuff', '<span>'.$label['freeStuff'].'</span>',array('onmousedown'=>'mousedown_big_button(this)', 'onmouseup'=>'mouseup_big_button(this)','onmouseover'=>'mouseover_big_button(this)'));?></div>
	</div>
</div><!--row-->


<?php }?>


<?php if($location2=='product' && $location3=='wanted' && $location4=='') { ?>

<div class="row">
	<div class=" cell width_200 frm_heading">
		<h1 class="padding-top7">
			<?php echo $label['productWanted'];?>
		</h1>
	</div>
	<div class="cell margin_left_16">
		<div class="tds-button-big Fleft">
			<?php echo anchor('product/sell','<span>'.$label['productsBRForSell'].'</span>',array('onmousedown'=>'mousedown_big_button(this)', 'onmouseup'=>'mouseup_big_button(this)','onmouseover'=>'mouseover_big_button(this)'));?></div>
		<div class="tds-button-big Fleft">
			<?php echo anchor('product/freeStuff', '<span>'.$label['freeStuff'].'</span>',array('onmousedown'=>'mousedown_big_button(this)', 'onmouseup'=>'mouseup_big_button(this)','onmouseover'=>'mouseover_big_button(this)'));?></div>
	</div>
</div><!--row-->


<?php }?>

<?php if($location2=='product' && $location3=='freeStuff' && $location4=='') { ?>

<div class="row">
	<div class=" cell width_200 frm_heading">
		<h1><?php echo $label['freeStuff'];?></h1>
	</div>
	<div class="cell margin_left_16">
		<div class="tds-button-big Fleft">
			<?php echo anchor('product/sell','<span  class="two_line">'.$label['productsBRForSell'].'</span>',array('onmousedown'=>'mousedown_big_button(this)', 'onmouseup'=>'mouseup_big_button(this)','onmouseover'=>'mouseover_big_button(this)'));?></div>
		<div class="tds-button-big Fleft">
			<?php echo anchor('product/wanted','<span>'.$label['productBRWanted'].'</span>',array('onmousedown'=>'mousedown_big_button(this)', 'onmouseup'=>'mouseup_big_button(this)','onmouseover'=>'mouseover_big_button(this)'));?></div>
	</div>
</div><!--row-->

<?php }?>

<?php if($location2=='product' && ($location3=='wanted' || $location3=='sell') && ($location4!='' && $location4==0)) { ?>
<div class="frm_btn_wrapper mr10">
		<div class="tds-button-big Fleft  disable_btn">
			<a href="javascript:void(0);"><span  class="two_line"><?php echo $this->lang->line('promotionalBRMaterial');?></span></a>
		</div>

			<div class="tds-button-big Fleft"><?php echo anchor('product/'.$entityMediaType, '<span>'.$label['indexPage'].'</span>',array('onmousedown'=>'mousedown_big_button(this)', 'onmouseup'=>'mouseup_big_button(this)','onmouseover'=>'mouseover_big_button(this)'));?></div>
</div><!--frm_btn_wrapper-->
<?php }?>

<?php if($location2=='product' && ($location3=='wanted' || $location3=='sell') && ($location4!=0)) { 
	
		
	?>
<div class=" frm_btn_wrapper mr10">
	<div class="tds-button-big Fleft">
		

		<?php if($location5!='description') { ?>
		<div class="tds-button-big Fleft"><?php echo anchor('product/'.$entityMediaType.'/'.$productId.'/description','<span>'.$label['productBRInformation'].'</span>',array('onmousedown'=>'mousedown_big_button(this)', 'onmouseup'=>'mouseup_big_button(this)','onmouseover'=>'mouseover_big_button(this)'));?></div>

		<?php } 
	
		if($location5=='promotional_video' ||$location5=='description') { ?>
			<div class="tds-button-big Fleft"><?php echo anchor('product/'.$entityMediaType.'/'.$productId.'/promotional_image','<span class="two_line">'.$this->lang->line('promotionalBRMaterial').'</span>',array('onmousedown'=>'mousedown_big_button(this)', 'onmouseup'=>'mouseup_big_button(this)','onmouseover'=>'mouseover_big_button(this)'));?></div>
		<?php } ?>
		
		<div class="tds-button-big Fleft"><?php echo anchor('product/'.$entityMediaType, '<span>'.$label['indexPage'].'</span>',array('onmousedown'=>'mousedown_big_button(this)', 'onmouseup'=>'mouseup_big_button(this)','onmouseover'=>'mouseover_big_button(this)'));?></div>
	</div>
</div><!--row-->
<?php }?>


<?php if($location2=='product' && $location3=='freeStuff' && $location4!='') { 
	
	?>

	<div class=" frm_btn_wrapper">
		<div class="tds-button-big Fleft"><?php echo anchor('product/'.$entityMediaType, '<span>'.$label['indexPage'].'</span>',array('onmousedown'=>'mousedown_big_button(this)', 'onmouseup'=>'mouseup_big_button(this)','onmouseover'=>'mouseover_big_button(this)'));?></div>
	</div>
<?php }?>

<div class="row line1 mr11 width567px"></div>
<div class="row seprator_5"></div>
<?php if($location2=='product' &&($location3=='sell' || $location3=='wanted'|| $location3=='freeStuff' || $location3=='') && $location4=='') { ?>

		<div class="row">
		<div class=" cell  width_200 Cat_wrapper">&nbsp;</div>
		<div class="btn_outer_wrapper fr width_auto pl5 mr14">
			<div class="fr">
				<div class="tds-button-big Fleft"><?php echo anchor('product/'.$entityMediaType.'/0/description','<span>'.$label['new'].'</span>',array('onmousedown'=>'mousedown_big_button(this)', 'onmouseup'=>'mouseup_big_button(this)','onmouseover'=>'mouseover_big_button(this)'));?></div>
				<div class="tds-button-big Fleft"><?php echo anchor('product/deletedItems/'.$entityMediaType, '<span class="two_line">'.$label['deletedBRItems'].'</span>',array('onmousedown'=>'mousedown_big_button(this)', 'onmouseup'=>'mouseup_big_button(this)','onmouseover'=>'mouseover_big_button(this)'));?></div>
			</div>
			<div class="clear"></div>
		</div>
	</div><!--row-->
	<?php if($location5!='promotional_video' ||$location5!='description') { echo '<div class="row seprator_5"></div>';}?>

<?php }else{
	echo '<div class="row position_relative">';
	if(strcmp($location5,'promotional_image')!=0)
		echo Modules::run("common/strip"); 
	}
?>
