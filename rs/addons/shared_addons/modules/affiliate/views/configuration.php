<?php defined('BASEPATH') or exit('No direct script access allowed'); //this form to add/edit configuration settings for merchant?>


<?php
	$userId=is_logged_in();
	
?>


<div class="col-md-10 col-sm-9 content border_left">
	<div class="title_bg col-sm-12 margin10">
		<div class="title padding_left0">Add Paypal Details</div>
		</div>
	<div class="row">

	<div class="tab-content">
		<!--/TAB ONE CONTENT/-->
	  <div class="tab-pane fade active in" id="PaypalAccount">
		
			<?php echo form_open(uri_string(),'','class="form_config" id="PaypalAccountContent"'); ?>
				<div class="col-md-5">
					<div class="form-group">
						<label for="first_name"><?php echo lang('global:first_name');?> <span>*</span></label>
				
						<?php echo form_input('first_name', $_paypal->first_name,'required class="alpha" msg="first name"');?>
						<span class="error"></span>
					</div>
				</div>
				<div class="clearfix"></div>
					<div class="col-md-5">
					<div class="form-group">
						<label for="last_name"><?php echo lang('global:last_name');?> <span>*</span></label>
						<?php echo form_input('last_name', $_paypal->last_name,'required class="alpha" msg="last name"');?>
						<span class="error"></span>
					</div>
				</div>
				<div class="clearfix"></div>
				<div class="col-md-5">
					<div class="form-group">
						<label for="email"><?php echo lang('global:email');?> <span>*</span></label>
					<?php echo form_input('email', $_paypal->email,'required class="width300 email"');?>
					<span class="error"></span>
					</div>
				</div>
				<div class="clearfix"></div>
				<div class="col-md-5">
					<div class="form-group">
						<label for="paypal_id"><?php echo lang('affiliate:paypal_id');?> <span>*</span></label>
					<?php echo form_input('paypal_id', $_paypal->paypal_id,'required class="width300"');?>
					<span class="error"></span>
					</div>
				</div>
				<div class="clearfix"></div>
				
				
				<div class="col-md-5">
					<div class="form-group">
						<label for="address"><?php echo lang('global:address');?> <span>*</span></label>
						<?php echo form_textarea('address', $_paypal->address,'required class="width300"');?>
						<span class="error"></span>
					</div>
				</div>
				<div class="clearfix"></div>
				<div class="col-md-5 marginb10">
				<div class="form-group">
					<button type="submit" class="btn btn-primary">
						<i class="fa fa-save fa-fw fa-1x"></i> <span><?php echo lang('save_label'); ?></span> 
					</button>
				</div>
			   </div>
			     <input type="hidden" name="payment_mode" id="payment_mode" value="0">
				<?php echo form_close(); ?>
				</div>


	</div>
 </div>
	<!--/END OF ROW/-->

</div>
	


