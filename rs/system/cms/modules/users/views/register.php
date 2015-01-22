
<?php 
	$memPrice=0;
	$membershipName='';
	$groupId = (isset($group_id) && ($group_id==2))?$group_id:'3'; 
	$membership_id = (isset($membershipId) && !empty($membershipId))?$membershipId:'';
	$membershipType = (isset($_user) && !empty($_user->membership_type))?$_user->membership_type:'';
	$hide = ($groupId==2)?'hide':'';
	$userType = (isset($group_id) && ($group_id==2))?'Affiliate':'Merchant';
	$loginBtn = (isset($group_id) && ($group_id==2))?'Affiliate Login':'Merchant Login';
	$formURL=(isset($group_id) && ($group_id==2))?'login':'login_m';
	$bannerId = (isset($banner_id))?$banner_id:'';
	
	if($membershipType){
			$membership_id=$membershipType;
	}
	//to get all membership
	$membershipData=array(''=>'Select membership type');
	if(isset($memberships) && !empty($memberships)){
		foreach($memberships as $mebership){
			$membershipData[$mebership->id]=$mebership->membership_title;
			if($mebership->id==$membership_id){
				$membershipName=$mebership->membership_title;
				$memPrice=$mebership->membership_price;
			}
		}
		
	}
?>
<link type="text/css" rel="Stylesheet" href="<?php echo CaptchaUrls::LayoutStylesheetUrl() ?>" />	
              
<!--/MAIN CONTAINER OF MERCHANT REGISTRATION/-->
<div class="reg_container">
	<div class="row">
	
		 <!--/PAGE LEFT SECTION/-->
		<div class="col-md-4 col-sm-4">
		
			<!--/TITTLE OF LEFT SECTION/-->
			<div class="title_bg col-sm-12 margin10">
				<div style="padding-left:0px;" class="title">Log In</div>
			</div>
			
			<!--/THE FORM OF LOGIN SECTION/-->
			<div class="row">
				<?php echo form_open(base_url().'users/'.$formURL); ?>
				  <div class="form-group">
					<label for="email"><?php echo lang('global:email') ?><span>*</span></label>
					<?php $loginEmail=(isset($login_email))?$login_email:''; ?>
					<?php echo form_input('email',$loginEmail ,'placeholder="Enter Email" required maxlength="60"')?>
					
				  </div>
				  <div class="form-group">
				
					<?php $loginPass=(isset($login_pass))?$login_pass:''; ?>
					<label for="password"><?php echo lang('global:password') ?><span>*</span></label>
					<input type="password" id="password" name="password" maxlength="20" placeholder="Enter Password" required value="<?php echo $loginPass; ?>" class="copy_paste"> 
		 
				  </div>
				  <div class="checkbox">
					  <?php  $checked=(isset($login_pass) && !empty($login_pass))?'checked':'';  ?>
					<label><input type="checkbox" name="remember_user" id="remember_user" <?php echo $checked; ?>> Remember Me <a class="pull-right" href="users/forgot-password/<?php echo encode($groupId); ?>">Forgot Password?</a></label>
					 
				  </div>
				  <input type="hidden" name="group_id" id="group_id" value="<?php echo $groupId; ?>">
						<input type="hidden" name="memId" id="memId" value="<?php echo $membership_id; ?>" >
						<input type="hidden" id="banner_id" name="banner_id" value="<?php echo $bannerId; ?>" />
						<button type="submit"  name="btnLogin" class="btn btn-primary col-sm-9" ><?php echo $loginBtn; ?></button>
				 <?php echo form_close(); ?>
				 <!--/END OF LOGIN FORM/-->
			</div>
			<!--/END OF ROW/-->
		</div>
		<!--/END OF PAGE LEFT SECTION/-->
		
		<!--/PAGE MIDDLE SECTION/-->
		<div class="col-md-5 col-sm-4">
			<div class="row">
				<?php $formURL=($membership_id!='')?base_url().'register/id/'.encode($membership_id):base_url().'register/'; ?>
				<?php echo form_open($formURL, array('id' => 'register')) ?>
				<!--/TITTLE MIDDLE SECTION/-->
				<div class="title_bg col-sm-12 margin10">
					<div style="padding-left:0px;" class="title">Registration</div>
				</div>
				
					
					<div class="form-group">
						<label for="RegInputName"><?php echo lang('user:first_name'); ?><span>*</span></label>
						<input type="text" class="form-control alpha" id="first_name" name="first_name" maxlength="250" value="<?php echo $_user->first_name ?>" placeholder="<?php echo lang('user:first_name'); ?>" required msg="first name" >
						<span class="error"></span>
					</div>
					<div class="form-group">
						<label for="RegInputName"><?php echo lang('user:last_name'); ?><span>*</span></label>
						<input type="text" class="form-control alpha" id="last_name" name="last_name" maxlength="250" value="<?php echo $_user->last_name ?>" placeholder="<?php echo lang('user:last_name'); ?>" required msg="last name" >
						<span class="error"></span>
					</div>
					<div class="form-group">
						<label for="RegInputEmail"><?php echo lang('user:email'); ?><span>*</span></label>
						<input type="text" class="form-control email" id="email" name="email" maxlength="60" placeholder="<?php echo lang('user:email') ?>" value="<?php echo $_user->email ?>" required placeholder="<?php echo lang('user:email'); ?>"  >
						<span class="error"></span>
					</div>
					<div class="form-group">
						<label for="password"><?php echo lang('user:password'); ?><span>*</span></label>
						<input type="password" name="password" id="user_password" maxlength="20" class="pass copy_paste" required autocomplete="off" placeholder="<?php echo lang('user:password') ?>" value="<?php echo $_user->password; ?>"  />
						<span class="error"></span>
					</div>
					<div class="form-group">
						<label for="confirm_password"><?php echo lang('user:confirm_password') ?><span>*</span></label>
						<input type="password" name="confirm_password" id="confirm_password"  class="pass copy_paste" maxlength="20" required placeholder="<?php echo lang('user:confirm_password') ?>" value="<?php echo $_user->password; ?>" />
						<span class="pass_error error"></span>
					</div>
					
					<div class="form-group">
						<label for="phone">Tel#<span>*</span></label>
							<input type="text" name="phone" maxlength="13" value="<?php echo $_user->phone ?>" value="<?php echo $_user->phone; ?>" required class="valid_phone" placeholder="Telephone"/>
							 <span class="error"></span>
					</div>
					
					<div class="form-group">
						<label for="phone">Sex<span>*</span></label>
						<?php $male='checked'; $female=''; if($_user->sex=='1'){ $female="checked"; $male=''; }?>
						 <div class="sex"><?php echo form_radio('sex','0',$male) ?>Male </div>
							<div class=""><?php echo form_radio('sex','1',$female) ?>Female </div>
					</div>
					<div class="form-group">
						<label for="phone">Date Of Birth<span>*</span></label>
						<?php echo form_input('date_of_birth',$_user->date_of_birth,'required class="datepicker readonly"'); ?>
					</div>
					<div class="form-group">
						<label for="phone">Address<span>*</span></label>
						<textarea name="address" required > <?php echo $_user->address; ?></textarea>
						
					</div>
					
					<div class="form-group">
					   <label for="company_name"><?php echo lang('user:company_name') ?><span></span></label>
						<input type="text" name="company_name"  value="<?php echo $_user->company_name ?>" placeholder="<?php echo lang('user:company_name') ?>" maxlength="250"/>
						 <span class="error"></span>
					</div>
					
				 
					<div class="form-group">
					<?php if($groupId==3): ?>
					<label for="feature"><?php echo lang('user:membership_type') ?><span>*</span></label>
							<?php  $other='class="select_feature merfield" id="membership_type" required';
							echo form_dropdown('membership_type',$membershipData, $membership_id, $other); ?>
							
					</div>
					<?php endif;?>
				   <div class="form-group">
						<label for="domain_name">WebSite Address<span><?php if($groupId==3) { ?>* <?php } ?></span></label>
						<input type="text" name="domain_name" id="domain_name" maxlength="250"  value="<?php echo $_user->domain_name ?>" <?php if($groupId==3) {?>required <?php } ?>class="valid_url merfield" placeholder="<?php echo lang('user:domain_name') ?>" />
						 <span class="error"></span>
					</div>
					
					<div class="form-group">
						
					<label for="captcha_msg"><?php echo 'Enter Code';?> <span>*</span></label>
					<div class="captcha_box">
						<div class="pull-left">
								<?php //echo form_input('captcha_code','','required placeholder="Enter Code"');
								// Show captcha error message
									echo ( ! empty($captchaValidationMessage)? $captchaValidationMessage : '' );
								?> 
								</div>
								<?php // BotDetect Captcha
									echo $captchaHtml; 
								?>
						</div>
						<?php
						$botdetectCaptcha = array(
							'name'        => 'CaptchaCode',
							'id'          => 'CaptchaCode',
							'value'       => '',
							'maxlength'   => '100',
							'size'        => '50',
							'required'    => '',
							'placeholder'=>'Enter Code',
							
						);
						echo form_input($botdetectCaptcha);?>
						<!--<div class="pull-right"> <div id="cap_image"></div><a href="javascript:void(0)" class="change_captcha">Change</a></div>-->
					
						
					</div>
					<div class="form-group">
						<div class="clearfix"></div>

						<label>
							<?php  echo form_checkbox('term_condition','checked',$_user->term_condition,'class="term" required'); ?>	
							<div class="terms">I acknowledge to have read, understood and agreed the <a href="javascript:void(0)" class="term_cond"><?php echo lang('user:terms_conditions'); ?> </a>of the Syrecohk website.	</div>
						</label>
				  </div>
				  
				  <div class="form-group">
						<div class="clearfix"></div>

						<label>
							<?php  echo form_checkbox('direct_deposit','checked',$_user->term_condition,'class="" required'); ?>	
							<div class="terms">I acknowledge to have read, understood and agreed to <a href="javascript:void(0)" class="direct_deposit">Direct Deposit </a>of the Syrecohk website.	</div>
						</label>
				  </div>
				  
				  <div class="form-group">
					<input type="hidden" name="group_id" id="group_id" value="<?php echo $groupId; ?>">
					<input type="hidden" id="banner" name="banner_id" value="<?php echo $this->uri->segment(3);?>" />
					<?php 
					 $extraSave	= 'class="btn btn-primary col-sm-9" id="btnSubmit"';
					if($groupId==2){
						echo form_submit('button',lang('user:create_account'),$extraSave); 
					}else{
						echo form_submit('button',lang('user:account_continue_checkout'),$extraSave); 
					}
					?>
					</div>
				<?php echo form_close();?>
			</div>
			
		</div>
		<!--/END OF PAGE MIDDLE SECTION/-->
		
	 
	   <?php if($groupId==3): ?>
		<!--/PAGE RIGHT SECTION/-->
		<div class="col-md-3 col-sm-4 feature_wrapper">

			<!--/TITTLE RIGHT SECTION/-->
			<div class="title_bg col-sm-12 margin10">
				<div style="padding-left:0px;" class="title">Selected Plan</div>
			</div>
			<!--/DETAILS OF SELECTED PLAN/-->
			
			<div class="widget">     
					
					 <h4> <div class="feature_head heading"><span class="payprice"><?php echo $membershipName; ?> <?php if($memPrice!=0){ echo '(Price $'.$memPrice.')'; }?></span> </div></h4>
					<div class="feature_data ">
						
					<ul class="plan_list">
					  <?php $amt=0; if(isset($features) && !empty($features)): ?>
						<?php foreach($features as $feature): $amt=$feature->membership_price; ?>
							
							<li class="feature_disc">
								<label for="first_name"><?php echo ucfirst($feature->feature_title); ?>  </label>
							</li>
							<div class="hide"><?php echo $feature->feature_description; ?></div>
						 <?php endforeach; ?>
					 <?php endIf; ?>
					</ul>
					</div>
		   </div>
		   
			<div class="widget">     
			 <p>
				 <div class="pay_get_logo"></div>
				<!-- <img src="<?php //echo base_url().'system/cms/themes/referral/img//PaymentGateway.jpg'?>" alt="" class=""> -->
				</p>
			</div>
		</div>
		<?php else :?>
		<!--/PAGE RIGHT SECTION/-->
		<?php endif;?>
		
		<!--END OF PAGE RIGHT SECTION/-->
		<?php 
	   if(isset($memberships) && !empty($memberships)){
			foreach($memberships as $mebership){
				?>
				 <input type="hidden" id="memPrice<?php echo $mebership->id; ?>" value="<?php echo $mebership->membership_price; ?>">
				<?php
			}
		}
			$membershipField=array(
			'type'=>'hidden',
			'name'=>'membershipId',
			'id'=>'membershipId',
			'value'=>$membership_id,
			);
			echo form_input($membershipField);
		?>
	</div>
	 <!--/END OF ROW/-->
</div>
<!--/END OF MERCHANT REGISTRATION CONTAINER/-->

                 
                    
                    
            

<script>

	var base_url='<?php echo base_url();?>';
	//to hide right side sectin
	var mId='<?php echo $membership_id;?>';
	if(!mId){
			$('.merfield').attr('required',false);
	}else{ $(".affi_head").hide(); }
	$( document).ready(function() {
	$('.affiUser').click(function(){
		$('.merfield').attr('required',false);
		$('#group_id').val('2');
		$('.feature_wrapper').hide();
		$(".affi_head").show();
		$(".mer_head").hide();
		slideUp( ".field_row");
	});
	$('.marUser').click(function(){
		
		$('.merfield').attr('required',true);
		slideDown(".field_row");
		$(".affi_head").hide();
		$(".mer_head").show();
		$('#group_id').val('3');
		slideUp(".affi_head");
		if(mId){
			$('.feature_wrapper').show();
		}
	});
		

	$(document).on('click','.feature_disc', function() {
	  $(this).next('div').slideToggle( "slow");
	});
	//to remove default calendar
	$('.ui-datepicker').remove();	
	});
	

</script>
