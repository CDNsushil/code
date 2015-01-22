
<section class="title">
	
		<h4>Configuration Settings</h4>

</section>


<section class="item">
	<div class="content">
	
		<div class="tabs">
			<?php echo form_open(uri_string()); ?>
			<!-- Content tab -->
			<div class="form_inputs" id="user-basic-data-tab">
				<fieldset>
					<ul>
						
						<li>
						
							<label for="group_id"><?php echo "Support Email"; ?><span>*</span></label>
							<div class="input">
									<span class="error"></span>
									<?php echo form_input('email',$_configuration->email, 'required class="email" ') ?>
							</div>
							
						</li>
						<li>
						
							<label for="group_id"><?php echo "Paypal Email"; ?><span>*</span></label>
							<div class="input">
									<span class="error"></span>
									<?php echo form_input('paypal_id',$_configuration->paypal_id, 'required class="email" ') ?>
							</div>
							
						</li> 
						<li>
						
							<label for="group_id"><?php echo lang('settings:minimum_referral_point'); ?><span>*</span></label>
							<div class="input">
								
									<?php echo form_input('minimum_referral_point',$_configuration->minimum_referral_point, 'required class="numeric" ') ?>
										<span class="error"></span>
							</div>
							
						</li>
						<li >
							
							<div class="input">		
							
							<!--	<div class="ref_point">
									<label for="phone"><?php //echo lang('settings:referral_point'); ?> <span>*</span></label>
									<?php //echo form_input('referral_point', $_configuration->referral_point, 'required class="numeric"') ?>
									<span class="error"></span>
								</div>
								-->
								
								<div class="ref_point mr35">
									<label for="phone"><?php echo lang('settings:each_referral_point_worth'); ?> <span>*</span></label>
									<?php echo form_input('referral_point_amt',$_configuration->referral_point_amt, 'required class="refer_amt"') ?>
									<span class="error"></span>
								</div>
								
								<div class="ref_point">
									<label for="phone"><?php echo lang('settings:currency'); ?> <span>*</span></label>
								<?php $currencies=(isset($currencies)?$currencies:''); ?>
								<div class="currency_type_div">
									<?php echo form_dropdown('currency',$currencies,$_configuration->currency, 'required class="currency_type"') ?>
								</div>
								</div>
								
								
							</div>
							
							
						
						</li>
						<div class="clear"></div>
					
			
				
					</ul>
				</fieldset>
					<div class="buttons">
							<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save') )) ?>
					</div>
			</div>
		
		</div>
		<?php echo form_close(); ?>
	
	

	</div>
</section>

<script>
 $( document).ready(function() {
 $(".refer_amt").keypress(function(e) {
		 
		
			if(((e.which!=43) && (e.which<48 || e.which>57 ) && (e.which!=8 && e.which!=0)) && e.which!=46)
			{
				$(this).next('span').fadeIn('fast');
				$(this).next('span').html('Please enter numeric amount.');
				formError=true;
				return false;
			}	
			
			$(this).next('span').fadeOut(2000);
		});
		$(".refer_amt").blur(function(e) {
			if(((e.which!=43) && (e.which<48 || e.which>57 ) && (e.which!=8 && e.which!=0) && e.which!=46))		{
			$(this).next('span').fadeIn('fast');
			$(this).next('span').html('Please enter numeric amount.');
			formError=true;
			return false;
		}	
		formError=false;
		$(this).next('span').fadeOut(2000);
	});	
	});	

</script>
