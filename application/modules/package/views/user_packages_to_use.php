<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>

<div class="row  ml30" id="furtherDescription1">
<?php			
if($userPkg && count($userPkg) >0){
	$retunUrl = '';
	$formAttributes = array(
		'name'=>'customForm',
		'id'=>'customForm'
	);
	
?>	
	<div class="fontB">
		<?php echo $this->lang->line('availablePackage');?>
	</div>
				
	<?php
	//echo form_open($retunUrl,$formAttributes);
		$i=0;
		foreach($userPkg as $k=>$pkg){
			$i++;?>
			<div class="row heightSpacer"></div>
			<div class="published_box_wp width328px pl50 ml30">
			<div class="cell">
				<input type="radio" id="userPackageKey" name="userPackageKey" value="<?php echo $k; ?>" <?php echo $i==1?'checked':'';?> />
			</div>
			<div class="cell widthSpacer">&nbsp;&nbsp;</div>
			<div class="published_heading"><?php echo $this->lang->line('package');?></div> 
			<div class="published_date"><?php echo $pkg->title; ?></div>
			
			 <div class="clear"></div>
			 
			<div class="published_heading pl25"><?php echo $this->lang->line('size');?></div> 
			<div class="published_date"><?php echo ($pkg->size/1048576); ?> <?php echo $this->lang->line('MB');?></div>
			<?php 
			/*
			 <div class="clear"></div>
			 
			<div class="published_heading"><?php echo $this->lang->line('quantity');?></div> 
			<div class="published_date"><?php echo $pkg->maxqty; ?></div>
			<div class="clear"></div>
											 
			<div class="published_heading"><?php echo $this->lang->line('validity');?></div> 
			<div class="published_date"><?php echo number_format(($pkg->validity/30),0);  ?> <?php echo $this->lang->line('month');?></div>
			*/
			?>
			<div class="clear"></div>								
								
		</div>
			<?php
		}?>
		<div class="row heightSpacer"></div>
		
	<div class="row">
		<?php echo $this->lang->line('purchaceMorePackges');?>
			<b><a href="<?php echo base_url(lang().'/package/buytools'); ?>"><?php echo $this->lang->line('clickHere');?></a></b>
		</div>

	<?php
}else{
	?>
	<div class="row">
		<?php echo $this->lang->line('purchacePackges');?>
			<b><a href="<?php echo base_url(lang().'/package/buytools'); ?>"><?php echo $this->lang->line('clickHere');?></a></b>
	</div>

	<?php
}
?>
</div>
