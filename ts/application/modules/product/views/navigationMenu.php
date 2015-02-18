<?php
$location2 =  $this->uri->segment(2);
$location5 =  $this->uri->segment(5);
$location3 =  $this->uri->segment(3);
$location4 =  $this->uri->segment(4);

$endLocation = end($this->uri->segments);
$classSelected = "class='Main_btn_box Main_select'";
$class ="class='Main_btn_box'";
$two_line =' class="two_line"';
	
	if($entityMediaType == 'sell') {
			$description = $this->lang->line('productForSaleBRDescription');
			$indexPage = $this->lang->line('productsForSellBRIndex');
		}
		else if($entityMediaType == 'wanted') {
			$description = $this->lang->line('productWantedBRDescription');
			$indexPage = $this->lang->line('productWantedBRIndex');
		}
		else
			$indexPage = $this->lang->line('freeStuffBRIndex');
//Deleted Items
if($location2=='product' && $endLocation=='deletedItems') { ?>

<div class="row ">
	<div class=" cell frm_heading">
		<h1 class="padding-top7 clr_red">
			<?php echo $label['deletedItems']?>
		</h1>
	</div>
	<div class="frm_btn_wrapper mr10">
		<div class="tds-button-big Fleft"><?php echo anchor('product/'.$entityMediaType, '<span class="two_line">'.$indexPage.'</span>',array('onmousedown'=>'mousedown_big_button(this)', 'onmouseup'=>'mouseup_big_button(this)','onmouseover'=>'mouseover_big_button(this)'));?></div>
	</div>
</div><!--row-->
<div class="row line1 mr11 width567px"></div>
<div class="row seprator_5"></div>
<div class="row position_relative">
	
<?php }else{?>

<?php if($location2=='product' && ($location3=='sell' || $location3=='') && $location4=='') { ?>

<div class="row">
	<div class=" cell width_200 frm_heading">
		<h1 class="padding-top7">
			<?php echo $label['productsForSellIndex'];?>
		</h1>
	</div>
	<div class="cell frm_btn_wrapper margin_left_16 mr10 mt15">
		<div class="tds-button-big Fleft">
			<?php echo anchor('product/wanted','<span'.$two_line .'>'.$label['productBRWanted'].'</span>',array('onmousedown'=>'mousedown_big_button(this)', 'onmouseup'=>'mouseup_big_button(this)','onmouseover'=>'mouseover_big_button(this)'));?></div>
		<div class="tds-button-big Fleft">
			<?php echo anchor('product/freeStuff', '<span'.$two_line .'>'.$label['freeStuffBRIndex'].'</span>',array('onmousedown'=>'mousedown_big_button(this)', 'onmouseup'=>'mouseup_big_button(this)','onmouseover'=>'mouseover_big_button(this)'));?></div>
	</div>
</div><!--row-->


<?php }?>


<?php if($location2=='product' && $location3=='wanted' && $location4=='') { ?>

<div class="row">
	<div class=" cell width_200 frm_heading">
		<h1 class="padding-top7">
			<?php echo $label['productWantedIndex'];?>
		</h1>
	</div>
	<div class="cell frm_btn_wrapper margin_left_16 mt15">
		<div class="tds-button-big Fleft">
			<?php echo anchor('product/sell','<span'.$two_line .'>'.$label['productsForSellBRIndex'].'</span>',array('onmousedown'=>'mousedown_big_button(this)', 'onmouseup'=>'mouseup_big_button(this)','onmouseover'=>'mouseover_big_button(this)'));?></div>
		<div class="tds-button-big Fleft">
			<?php echo anchor('product/freeStuff', '<span'.$two_line .'>'.$label['freeStuffBRIndex'].'</span>',array('onmousedown'=>'mousedown_big_button(this)', 'onmouseup'=>'mouseup_big_button(this)','onmouseover'=>'mouseover_big_button(this)'));?></div>
	</div>
</div><!--row-->


<?php }?>

<?php if($location2=='product' && $location3=='freeStuff' && $location4=='') { ?>

<div class="row">
	<div class=" cell width_200 frm_heading">
		<h1><?php echo $label['freeStuffBRIndex'];?></h1>
	</div>
	<div class="cell frm_btn_wrapper margin_left_16 mt15">
		<div class="tds-button-big Fleft">
			<?php echo anchor('product/sell','<span'.$two_line .'>'.$label['productsForSellBRIndex'].'</span>',array('onmousedown'=>'mousedown_big_button(this)', 'onmouseup'=>'mouseup_big_button(this)','onmouseover'=>'mouseover_big_button(this)'));?></div>
		<div class="tds-button-big Fleft">
			<?php echo anchor('product/wanted','<span'.$two_line .'>'.$label['productBRWanted'].'</span>',array('onmousedown'=>'mousedown_big_button(this)', 'onmouseup'=>'mouseup_big_button(this)','onmouseover'=>'mouseover_big_button(this)'));?></div>
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


<?php if($location2=='product' && ($location3=='wanted' || $location3=='sell' || $location3 =='additionalInformation') && ($location4!=0)) { 	?>


<div class=" frm_btn_wrapper mr10">
	<div class="tds-button-big Fleft">
		

		<?php 
		if($entityMediaType == 'sell') {
			$description = $this->lang->line('productForSaleBRDescription');
			$indexPage = $this->lang->line('productsForSellBRIndex');
		}
		else if($entityMediaType == 'wanted') {
			$description = $this->lang->line('productWantedBRDescription');
			$indexPage = $this->lang->line('productWantedBRIndex');
		}
		else
			$indexPage = $this->lang->line('freeStuffBRIndex');
		if($location5!='description') { 	
		
		?>
		<div class="tds-button-big Fleft"><?php echo anchor('product/'.$entityMediaType.'/'.$productId.'/description','<span class="two_line">'.$description.'</span>',array('onmousedown'=>'mousedown_big_button(this)', 'onmouseup'=>'mouseup_big_button(this)','onmouseover'=>'mouseover_big_button(this)'));?></div>

		<?php } 
	
		if($location5=='promotional_video' || $location5=='description' || $location3=='additionalInformation') { ?>
			<div class="tds-button-big Fleft"><?php echo anchor('product/'.$entityMediaType.'/'.$productId.'/promotional_image','<span class="two_line">'.$this->lang->line('promotionalBRMaterial').'</span>',array('onmousedown'=>'mousedown_big_button(this)', 'onmouseup'=>'mouseup_big_button(this)','onmouseover'=>'mouseover_big_button(this)'));?></div>
		<?php } ?>
		
		<?php if($location3=='sell') { ?>
		 <div class="tds-button-big Fleft"><?php echo anchor('product/additionalInformation/'.$productId.'/'.$entityMediaType, '<span>PR Material</span>',array('onmousedown'=>'mousedown_big_button(this)', 'onmouseup'=>'mouseup_big_button(this)','onmouseover'=>'mouseover_big_button(this)'));?></div>
		
		<?php } ?>
		
		<div class="tds-button-big Fleft"><?php echo anchor('product/'.$entityMediaType, '<span class="two_line">'.$indexPage.'</span>',array('onmousedown'=>'mousedown_big_button(this)', 'onmouseup'=>'mouseup_big_button(this)','onmouseover'=>'mouseover_big_button(this)'));?></div>
		
		
		
	</div>
</div><!--row-->
<?php }
	if($location2=='product' && $location3=='freeStuff' && $location4!='') { 
?>

	<div class=" frm_btn_wrapper pr10">
		<div class="tds-button-big Fleft"><?php echo anchor('product/'.$entityMediaType, '<span class="two_line">'.$label['freeStuffBRIndex'].'</span>',array('onmousedown'=>'mousedown_big_button(this)', 'onmouseup'=>'mouseup_big_button(this)','onmouseover'=>'mouseover_big_button(this)'));?></div>
	</div>
<?php } ?>

<div class="row line1 mr11 width567px"></div>
<div class="row seprator_5"></div>
<?php if($location2=='product' &&($location3=='sell' || $location3=='wanted'|| $location3=='freeStuff' || $location3=='') && $location4=='') {
	if($entityMediaType=='freeStuff'){
		$sectionId=$this->config->item('productClassifiedFreeSectionId');
	}else{
		$sectionId=$this->config->item('productsSellSectionId');
	}
	
	$newsHref='javascript:getUserContainers(\''.$sectionId.'\',\'/product/'.$entityMediaType.'/0/description\');';
	
	?>

		<div class="row">
		<div class=" cell  width_200 Cat_wrapper">&nbsp;</div>
		<div class="btn_outer_wrapper fr width_auto pl5 mr14">
			<div class="fr">
				<div class="tds-button-big Fleft">
					<a onmouseover="mouseover_big_button(this)" onmouseup="mouseup_big_button(this)" onmousedown="mousedown_big_button(this)" href="<?php echo $newsHref;?>"><span><?php echo $this->lang->line('new');?></span></a>
				</div>
				<div class="tds-button-big Fleft"><?php echo anchor('product/'.$entityMediaType.'/deletedItems/', '<span class="two_line">'.$label['deletedBRItems'].'</span>',array('onmousedown'=>'mousedown_big_button(this)', 'onmouseup'=>'mouseup_big_button(this)','onmouseover'=>'mouseover_big_button(this)'));?></div>
			</div>
			<div class="clear"></div>
		</div>
	</div><!--row-->
	
	<?php 
	if($location5!='promotional_video' ||$location5!='description') { echo '<div class="row seprator_5"></div>';}?>

<?php }else{
	echo '<div class="row position_relative">';
	
	if(strcmp($endLocation,'promotional_image')!=0 && strcmp($this->router->method,'additionalInformation')!=0)
		echo Modules::run("common/strip"); 
	}
}

if($location3=='additionalInformation') {
	echo "</div>";	
 }

?>
