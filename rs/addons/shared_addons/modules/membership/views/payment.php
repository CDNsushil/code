<?php  defined('BASEPATH') or exit('No direct script access allowed');   ?>
<?php if(isset($form_error)){ ?>
     <div class="frontend_error "><a href="#" class="close"></a>
<?php   echo $form_error;  ?>
</div>
<?php } 

?>

<h4><?php echo 'Registeration for user';?></h4>


<section class="item floatL	">
	<div class="content ">
		<?php echo form_open('https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_express-checkout&', 'class="crud"') ?>
		<div class="form_inputs ">

			<ul>
			
			<li>
				<?php echo form_radio($marchantUser);?> <span>I Am Merchant User</span>&nbsp; &nbsp;
				<?php echo form_radio($referralUser);?> <span>I Am Referral User</span> 
			 </li>
				
			<li>
				<label for="first_name"><?php echo lang('membership:firstname');?> <span>*</span></label>
				<div class="input"><?php echo form_input('first_name', $register->first_name);?></div>
			 </li>
			 <li>
				<label for="lastname"><?php echo lang('membership:lastname');?> <span>*</span></label>
				<div class="input"><?php echo form_input('last_name', $register->last_name);?></div>
			 </li>
			 <li>
				<label for="email"><?php echo lang('membership:email');?> <span>*</span></label>
				<div class="input"><?php echo form_input('email', $register->email);?></div>
			</li>
			<li>
				<label for="phone"><?php echo lang('membership:phone');?> <span>*</span></label>
				<div class="input"><?php echo form_input('phone', $register->phone);?></div>
			</li>
			<li>
				<label for="company"><?php echo lang('membership:company');?> <span>*</span></label>
				<div class="input"><?php echo form_input('company_name',$register->company_name);?></div>
			</li>
			<li>	
				<label for="domainname"><?php echo lang('membership:domainname');?> <span>*</span></label>
				<div class="input"><?php echo form_input('domain_name', $register->domain_name);?></div>
			</li>	
				
			<li>	
					<?php  if(isset($cap['image'])){ echo $cap['image']; }?>
				<label for="domainname"><?php echo lang('membership:captcha_msg');?> <span>*</span></label>
				<div class="input"><?php echo form_input('captcha_code');?></div>
			</li>	
			<div class="input"><?php echo form_submit('submit', 'Register');?></div>
			
			</ul>
		</div>
		
		<input type="hidden" name="cmd" value="_xclick">
		<input type="hidden" name="business" value="rajendrapatidar-facilitator@cdnsol.com">
		<input type="hidden" name="currency_code" value="USD">
		<input type="hidden" name="item_name" value="">
		<input type="hidden" name="amount" value="12.99">
		<input type="image" src="http://www.paypal.com/en_US/i/btn/btn_buynow_LG.gif" border="0" name="submit" alt="Make payments with PayPal - it\'s fast, free and secure!">
		
		<?php form_close(); ?>
		
	
	
	</div>
</section>

	<div class="feature_wrapper">

		<ul>
			<?php if(isset($features) && !empty($features)): ?>
			<h4><?php echo 'Features';?></h4>
			<?php foreach($features as $feature): ?>
			<li>
				<label for="first_name"><?php echo ucfirst($feature->feature_title); ?> </label>
			
			 </li>
			 <?php endforeach; ?>
			 <?php endIf; ?>
		</ul>
	</div>


