<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<?php /*echo "<pre>";print_r($shippingZones); die;*/ ?>
<div class="row pt5">
	<div class="label_wrapper cell"><label class="select_field_three_arrow"><?php echo $this->lang->line('shippingCharges');?></label></div>
	<div class=" cell frm_element_wrapper">
		<div class="cell width480px">
			
		<?php 
			//echo form_input($SpId);
			if($shippingZones){
				//$countryId = LoginUserDetails('countryId');
				$EEID=$elementId.$entityId;
				$countSP=count($shippingZones);
				
				
				if(is_array($shippingZones) && ($countSP > 0)){
					foreach($shippingZones as $k=>$zone){
						$unqueId=$EEID.''.$zone['zoneId'];
						$formData=$zone;
						$formData['unqueId']=$unqueId;
						$formData['entityId']=$entityId;
						$formData['elementId']=$elementId;
					?>
						<div class="price_trans_wp width210px fl"  id='secriptDiv<?php echo $unqueId;?>'>
							<?php $this->load->view('shippingDetails',array('zone'=>$formData));?>
						</div>
						<?php
						if(($k%2)==0 && ($k < ($countSP-1) )){?>
							<div class="price_trans_wp_space width55px fl">&nbsp;</div>
							<?php
						}
						//$this->load->view('shippingForm',$formData);
					}
				}
			}else{	?>
				<div class="pro_li_content_wp"> <div class="cell pro_title"><?php echo $this->lang->line('noRecord'); ?></div></div><?php
			}
		?>
		</div>
	</div><!--frm_element_wrapper-->
</div><!--row-->

<script>
function shippingDelete(shippingData,unqueId){
		if(confirm(areYouSure)){
			var divId = 'secriptDiv'+unqueId;
			AJAX(baseUrl+language+"/"+"shipping/shippingDelete",divId,shippingData);
		}
}
function shippingEnableDisable(spId,unqueId,obj){
		var status = 'f';
		var priceClass = 'price_input_disable width60px';
		var msg = shippingDisablConfirm;
		if(obj.checked){
			priceClass = 'price_input width60px';
			status = 't';
			msg = shippingEnableConfirm;
			
		}
		
		if(confirm(msg)){
			var res = AJAX(baseUrl+language+"/"+"shipping/shippingEnableDisable",'',spId,status);
			if(res){
				 $('#showAmount'+unqueId).attr('class',priceClass);
				 $('#messageSuccessError').html('<div class="successMsg"><?php echo $this->lang->line('msgSuccessfully');?> <?php echo $this->lang->line('updated');?></div>');
				 timeout = setTimeout(hideDiv, 5000);
			}
		}else{
			if(obj.checked){
				
				$(obj).attr('checked',false);
			}else{
				$(obj).attr('checked',true);
			}
		}
}
</script>
