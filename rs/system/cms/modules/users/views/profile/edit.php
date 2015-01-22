	
<?php 
	$groupId=userGroup();

	$membership_id = (isset($_user) && !empty($_user->membership_type))?$_user->membership_type:'';

?>
<!--/CONTENT OF PRODUCT BANNER/-->
<div class="col-md-10 col-sm-9 content border_left">
<div class="row">
<div class="title_bg col-sm-12 margin10">
		<div class="title_bg col-sm-12 margin10">
			<!--/TITTLE OF CREATE CONTENT/-->
			<div class="title padding_left0">Edit Profile</div>
		</div>
	</div>
	 <!--/END OF TITTLE/-->
	 
	 
	 <div class="row">
		
			<?php echo form_open('users/edit', array('id' => 'user_edit'),'class="form-horizontal" role="form">') ?>
			<div class="form-group">
				<label for="first_name"><?php echo lang('user:first_name') ?><span>*</span></label>
				<input type="text" name="first_name" maxlength="100" value="<?php echo $_user->first_name; ?>" required class="alpha" placeholder="First Name" msg="first name"/>
				<span class="error"></span>
			</div>
			<div class="form-group">
				<label for="last_name"><?php echo lang('user:last_name') ?><span></span></label>
				<input type="text" name="last_name" maxlength="100" value="<?php echo $_user->last_name; ?>" class="alpha" placeholder="Last Name" msg="last name" />
				<span class="error"></span>
			</div>
			
			<div class="form-group">
				<label for="email"><?php echo lang('user:email') ?><span>*</span></label>
				<input type="text" name="email" maxlength="100" value="<?php echo $_user->email; ?>" class="" readonly placeholder="Email" />
				<span class="error"></span>
			</div>
			
			<div class="form-group">
				<label for="password"><?php echo lang('user:password') ?><span></span></label>
				<input type="password" name="password" id="user_password" maxlength="100" placeholder="Password" class="pass copy_paste" autocomplete="off"/>
				<span class="error"></span>
			</div>
			
			<div class="form-group">
				<label for="confirm_password"><?php echo lang('user:confirm_password') ?><span></span></label>
				<input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password" maxlength="100" class="copy_paste" value="" />
				<span class="error"></span>
			</div>
			
			<div class="form-group">
				<label for="phone"><?php echo lang('user:phone') ?><span>*</span></label>
				<input type="text" name="phone" maxlength="13" value="<?php echo $_user->phone; ?>" required class="numeric" placeholder="Phone" />
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
				<?php echo form_input('date_of_birth',date('d-m-Y',strtotime($_user->date_of_birth)),'required  class="datepicker readonly" placeholder="Date Of Birth"'); ?>
			</div>
			<div class="form-group">
				<label for="phone">Address<span>*</span></label>
				<textarea name="address" required placeholder="Address" > <?php echo $_user->address; ?></textarea>
				
			</div>
			
			<div class="form-group">
				<label for="company_name"><?php echo lang('user:company_name') ?><span></span></label>
				<input type="text" name="company" maxlength="100" value="<?php echo $_user->company; ?>" placeholder="Company" />
				 <span class="error"></span>
			</div>
		
			<div class="form-group">
				
				<label for="domain_name">WebSite Address<span><?php if($groupId==3) { ?>* <?php } ?></span></label>
					<input type="text" name="domain_name" id="domain_name"  value="<?php echo $_user->domain_name ?>" <?php if($groupId==3) {?>required <?php } ?>class=" <?php if($groupId==3) {?>valid_url<?php }?>merfield" placeholder="<?php echo lang('user:domain_name') ?>" readonly />
					 <span class="error"></span>
				 <span class="error"></span>
			</div>
				
			<div class="form-group">
				  <button type="button" class="btn btn-primary" onclick="history.go(-1)"> 
					 <i class="fa fa-arrow-circle-left fa-fw fa-1x"></i> 
					 <span><?php echo lang('global:back');?></span> 
				</button>
				
				<button type="submit" class="btn btn-primary "> 
				 <i class="fa fa-plus-square fa-fw fa-1x"></i> 
				 <span>Save</span> 
				</button>
			  
				</div>
			  </div>
		
	   <?php echo form_close();?>
	 </div>
	 
</div>


</div>
<!--/END OF PRODUCT BANNER CONTENT/-->  

