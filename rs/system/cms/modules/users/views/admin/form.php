<?php 
	$checked='checked';

	$membership_id = (isset($membershipId) && !empty($membershipId))?$membershipId:'';
	$membershipType = (isset($_user) && !empty($_user->membership_type))?$_user->membership_type:'';
	//$user_type = (isset($member) && ($member->user_type==1))?'1':'0';
	$groupId = (isset($member) && ($member->group_id!=''))?$member->group_id:'3';


	//to get all membership
	$membershipData=array();
	if(isset($memberships) && !empty($memberships)){
		foreach($memberships as $mebership){
			$membershipData[$mebership->id]=$mebership->membership_title;
		/*	if($mebership->id==$membership_id){
				$membershipName=$mebership->membership_title;
			} */
		}
	}
	

?>

<section class="title">
	<?php if ($this->method === 'create'): ?>
		<h4><?php echo lang('user:add_title') ?></h4>
		<?php echo form_open_multipart(uri_string(), 'class="crud" autocomplete="off"') ?>
	
	<?php else: ?>
		<h4><?php echo sprintf(lang('user:edit_title'), ucfirst($member->first_name)) ?></h4>
		<?php echo form_open_multipart(uri_string(), 'class="crud"') ?>
		<?php //echo form_hidden('row_edit_id', isset($member->row_edit_id) ? $member->row_edit_id : $member->profile_id); ?>
	<?php endif ?>
</section>

<section class="item">
	<div class="content">
	
		<div class="tabs">
	
			<!-- Content tab -->
			<div class="form_inputs" id="user-basic-data-tab">
				<fieldset>
					<ul>
						
						<li class="even">
							<label for="first_name"><?php echo lang('user:first_name') ?> <span>*</span></label>
							<div class="input">
								<?php echo form_input('first_name', $member->first_name, 'id="first_name" required class="alpha" msg="first name"') ?>
								<span class="error"></span>
							</div>
						</li>
						
						<li class="even">
							<label for="last_name"><?php echo lang('user:last_name') ?> <span>*</span></label>
							<div class="input">
								<?php echo form_input('last_name', $member->last_name, 'id="last_name" required class="alpha" msg="last name"') ?>
								<span class="error"></span>
							</div>
						</li>
						
						<li class="even">
							<label for="email"><?php echo lang('global:email') ?> <span>*</span></label>
							<div class="input">
								<?php $readonly='';  if ($this->method != 'create'): $readonly='readonly'; endif; ?>
								<?php echo form_input('email', $member->email, 'id="email" required  class="email" '.$readonly.'') ?>
								<span class="error"></span>
							</div>
						</li>
						
						<li class="even">
							<label for="phone"><?php echo lang('user:phone') ?> <span>*</span></label>
							<div class="input">
								<?php echo form_input('phone', $member->phone, 'id="phone" required class="numeric"') ?>
								<span class="error"></span>
							</div>
						</li>
						
						
						<li>
							<label for="user_block"><?php echo lang('user:user_block') ?><span>*</span></label>
							<div class="input">
								<?php $block=array(lang('user:no'),lang('user:yes')); //array('' => lang('global:select-pick')) +?>
								<?php echo form_dropdown('user_block',  $block, $member->user_block, 'id="user_block" required') ?>
							
							</div>
						</li>
	
						<li>
							<label for="group_id"><?php echo lang('user:group_label') ?><span>*</span></label>
							<div class="input">
								<?php echo form_dropdown('group_id', $groups_select, $groupId, 'id="group_id" required class="user_type"') ?>
								
							</div>
						</li>
						
						<li class="even">
							<label for="active"><?php echo lang('user:activate_label') ?><span>*</span></label>
							<div class="input">
								<?php $options = array(0 => lang('user:do_not_activate'), 1 => lang('user:active'), 2 => lang('user:send_activation_email')) ?>
								<?php echo form_dropdown('active', $options, $member->active, 'id="active"') ?>
								
							</div>
						</li>
						
						<li class="even">
							<label for="active">Sex<span>*</span></label>
							<div class="input">
									<?php $male='checked'; $female=''; if($member->sex=='1'){ $female="checked"; $male=''; }?>
									<div class="sex"><?php echo form_radio('sex','0',$male) ?>Male </div>
									<div class=""><?php echo form_radio('sex','1',$female) ?>Female </div>
							</div>
						</li>
						
					<li class="even">
							<label for="active">Date Of Birth<span>*</span></label>
							<div class="input">
								<?php $dateOfBirth=''; if($member->date_of_birth!=''): $dateOfBirth=date('d-m-Y',strtotime($member->date_of_birth)); endif;?>
								<?php echo form_input('date_of_birth',$dateOfBirth,'required  class="datepicker" placeholder="dd-mm-yyyy"'); ?>
								<span class="error"></span>
							</div>
						</li>	
						
						<li class="even">
							<label for="active">Address<span>*</span></label>
							<div class="input">
								<textarea name="address" required rows="3" class="width210" > <?php echo $member->address; ?></textarea>
							</div>
						</li>
		
		
						<!--
						<li>
							<label for="user_type"><?php //echo lang('user:user_type') ?><span>*</span></label>
							<div>
								
							<?php //echo form_radio($marchentUser);?> <span><?php //echo lang('user:merchant_user_msg'); ?></span>&nbsp; &nbsp;
							<?php //echo form_radio($referralUser);?> <span><?php //echo lang('user:referral_user_msg'); ?></span> 	
							</div>
						</li> -->
						
						<li class="field_row">
							<label for="membership_type"><?php echo lang('user:membership_type') ?><span>*</span></label>
							<div class="input">
									<?php $required=''; if($groupId==3){ $required='required'; }?>
									<?php  $other='class="select_feature" id="membership_type" '.$required.'';
									echo form_dropdown('membership_type',$membershipData, $member->membership_type, $other); ?>
							</div>		
						</li>
						
						<li class="field_row">
							<label for="domain_name"><?php echo lang('user:domain_name') ?> <span>*</span></label>
							<div class="input">
								<?php echo form_input('domain_name', $member->domain_name, 'id="domain_name" class="valid_url"'.$required.'') ?>
								<span class="error"></span>
							</div>
						</li>
						
						<li class="even">
							<label for="company"><?php echo lang('user:company_name') ?> <span></span></label>
							<div class="input">
								<?php echo form_input('company', $member->company, 'id="company"') ?>
								<span class="error"></span>
							</div>
						</li>
						
						<li class="even">
							<label for="password">
								<?php echo lang('global:password') ?>
								<?php $required=''; if ($this->method == 'create'):  $required='required';?> <span>*</span><?php endif ?>
							</label>
							<div class="input">
								<?php echo form_password('password', '', 'id="user_password" autocomplete="off"  class="pass copy_paste" '.$required.'') ?>
								<span class="error"></span>
							</div>
						</li>
						
						<li class="even">
							<label for="confirm_password">
								<?php echo lang('user:confirm_password') ?>
								<?php  if ($this->method == 'create'): ?> <span>*</span><?php endif ?>
							</label>
							<div class="input">
								<?php echo form_password('confirm_password', '', 'id="confirm_password" autocomplete="off" class="pass copy_paste" '.$required.'') ?>
								<span class="error"></span>
							</div>
						</li>
						
						
					</ul>
				</fieldset>
			</div>
		
		</div>

		<div class="buttons">
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'save_exit', 'cancel') )) ?>
		</div>
	
	<?php echo form_close() ?>

	</div>
</section>

<script>
	$( document).ready(function() {
	var groupId='<?php echo $groupId; ?>';

	$('.user_type').change(function(){
		
		var value=$(this).val();
		if(value==3){
			slideDown('.field_row');
			$('#membership_type').attr('required');
			$('#domain_name').attr('required');
			return true;
		}
		slideUp('.field_row');
		$('#membership_type').removeAttr('required');
		$('#domain_name').removeAttr('required');
	});
		if(groupId==2){
			slideUp('.field_row');
		}

	var error=false;
$('.datepicker').change(function(){
	
	var txtDate=$(this).val();
	if(txtDate==''){
		$(this).next('span').fadeOut(2000);
		error=false;
		return true;
	}
	var re = /^([0]?[1-9]|[1|2][0-9]|[3][0|1])[./-]([0]?[1-9]|[1][0-2])[./-]([0-9]{4}|[0-9]{2})$/ ; 
	if(!re.test(txtDate)){

		$(this).next('span').fadeIn('fast');
		$(this).next('span').html('Please enter valid date formate dd-mm-yyyy.');
		error=true;
	}else{

		$(this).next('span').fadeOut(2000);
		error=false;
	}
	});
	$('form').submit(function(){
		if(error){
			return false;
		}
	});
	$( ".datepicker" ).datepicker({
		  dateFormat: 'dd-mm-yy',
	});
});
</script>
