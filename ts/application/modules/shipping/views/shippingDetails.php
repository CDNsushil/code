<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
	$unqueId=isset($zone['unqueId'])?$zone['unqueId']:'';
	$amountInput = array(
						'name'	=> 'amount',
						'id'	=> 'showAmount'.$unqueId,
						'class'	=> 'price_input width60px',
						'value'	=> $zone['amount']>0?$zone['amount']:0.00,
						'readonly'	=> true
					);
	if($zone['status']=='f'){
		$amountInput['class']='price_input_disable width60px';
		
	}
					
	$statusInput = array(
		'name'	=> 'status',
		'id'	=> 'status'.$unqueId,
		'type'	=> 'checkbox',
		'value'	=> 't'
	);
	
	if($zone['status']=='t'){
		$statusInput['checked']=true;
	}
	
	if($zone['spId'] > 0){
		$statusInput['onclick']="shippingEnableDisable('".$zone['spId']."','".$unqueId."',this)";
		$opacity_4='';
	}else{
		$statusInput['disabled']=true;
		$opacity_4='opacity_4';
	}
	$zoneEncode=str_replace("'","&apos;",json_encode($zone));
?>
	<?php echo "<script>var parameter".$unqueId."=".$zoneEncode."; runTimeCheckBox();</script>"; ?>
	<div class="price_trans_checkbox_wp Fleft">
		<div class="defaultP mt2  "> 
			<div class="defaultP <?php echo $opacity_4;?>"><?php echo form_input($statusInput);?></div>
		</div>
	</div>
	<div class="price_trans_heading pl5 width55px"> <?php echo $zone['title'];?> </div>
	<div class="cell">
		<?php echo form_input($amountInput); ?>
	</div>
	<div class="extract_button_box pt3 pr7">
	  <?php
			if($zone['spId'] > 0){?>
				<div  class="small_btn formTip" title="<?php echo $this->lang->line('delete');?>"><a href="javascript:void(0)" onclick="shippingDelete(parameter<?php echo $unqueId;?>,'<?php echo $unqueId;?>')"><div class="cat_smll_plus_icon"></div></a></div>
				<div class="small_btn formTip" title="<?php echo $this->lang->line('edit');?>"><a href="javascript:void(0)" onclick="openLightBox('popupBoxWp', 'popup_box', '/shipping/shippingform', parameter<?php echo $unqueId;?>)" ><div class="cat_smll_edit_icon"></div></a></div>
				<?php
			}else{ ?>
				<div class="small_btn formTip" title="<?php echo $this->lang->line('add');?>"><a href="javascript:void(0)" onclick="openLightBox('popupBoxWp', 'popup_box', '/shipping/shippingform', parameter<?php echo $unqueId;?>)"><div class="cat_smll_add_icon"></div></a></div>
				<?php
			}
	  ?>
	</div>
