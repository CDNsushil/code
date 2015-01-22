<!-- contant div -->
<div  class="Contantpanel">
	<!-- register box start-->
	<div class="right_register_panel">
	<?php 
		$form_attributes = array('id' => 'openinviter', 'name' => 'openinviter', 'onSubmit'=>'return validateForm()');
		echo form_open('contact/ImportContact',$form_attributes); 
		?>
		<div class="sprint2_top_crn">
			<p class="sprint_heading"><?php echo $this->lang->line('create_profile_invite_your_friends');?></p>
		</div>
		
		<?php if(validation_errors()){?>
		<div class="error_msg">
			<?php echo validation_errors(); ?>
		</div>
		<?php }?>
		
		<?php if(isset($inviter)){ ?><div class="error_msg"><?php echo $inviter; ?></div><?php }?>
		<?php if(isset($login)){ ?><div class="error_msg"><?php echo $login; ?></div><?php }?>
		<?php if(isset($contacts)){	?><div class="error_msg"><?php echo $contacts; ?></div><?php }?>
		<?php if(isset($mails)){	?><div class="success_msg"><?php echo $mails; ?></div><?php }?>
		<?php if(isset($success)){	?><div class="success_msg"><?php echo $success; ?></div><?php }?>
		
		
<table align="center" width="100%" cellspacing="5" cellpadding="0" border="0" id="importForm" class="hideElement1">
	<tr>
	  <td align="left" width="20%">
		<table align="left" width="53" cellspacing="0" cellpadding="5" border="0" style="margin-left:15px; " class="block-main-table">
			<tr bgcolor="#CCDCE0">
			  <td align="left"><div align="center"><a title="Import Yahoo Contacts" class="tooltip" href="#"><img src="<?php echo getImage("templates/default/images/yahoo.png");?>"></a></div></td>
			</tr>
			<tr>
			  <td align="right"><div align="center"><a title="Import Hotmail Contacts" class="tooltip" href="#"><img src="<?php echo getImage("templates/default/images/hotmail.png");?>"></a></div></td>
			</tr>
			<tr>
			  <td align="right"><div align="center"><a title="Import Gmail Contacts" class="tooltip" href="#"><img src="<?php echo getImage("templates/default/images/gmail.png");?>"></a></div></td>
			</tr>
			<tr>
			  <td align="right"><div align="center"><a title="Import Facebook Contacts" class="tooltip" href="#"><img src="<?php echo getImage("templates/default/images/facebook1.png");?>"></a></div></td>
			</tr>
		</table>
		<table width="327" cellspacing="5" cellpadding="0" border="0" bgcolor="#CCDCE0">
		  <tr>
			<td class="fildsetHeading" colspan="2">Login Info</td>
		  </tr>
		  <tr>
			<td><div align="right">Email</div></td>
			<td><input type="text" id="textfield8" name="textfield7"></td>
		  </tr>
		  <tr>
			<td><div align="right">Password</div></td>
			<td><input type="text" id="textfield9" name="textfield7"></td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td><div style="float:left; width:auto; padding-left:5px; padding-right:5px;" id="schedule_submit" class="button">Import Contacts</div></td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		</table>
	</td>
  </tr>
</table>
			
			
			<p class="stepText"><?php echo $this->lang->line('create_profile_or_enter_your_email_and_password_to_invite');?></p>
				<div class="Followmessenger">
					<div class="Followmessengerbox"><img src="<?php echo getImage("templates/default/images/gmail.png");?>" title="G-Talk Mail" /></div>
					<div class="Followmessengerbox3"><img src="<?php echo getImage("templates/default/images/yahoo.png");?>" title="Yahoo Mail" /></div>
					<div class="Followmessengerbox2"><img src="<?php echo getImage("templates/default/images/hotmail.png");?>" title="Hotmail" /></div>
				</div>
				<!-- row first start  -->
				<!-- row first end  -->
		</div>
		<div class="sprint4_bottom_crn">
			<div class="Followmessenger">
				<!-- input row user 1-->
				<div>
					<div id="labelboxselect">
						<!-- Country -->
						<div class="lebelboxui_step4">
							<!-- lebel step 1-->
							<p class="lebeltextstep2"><?php echo $this->lang->line('create_profile_user');?></p>
							<p class="textbox7selectStep4">
								<?php
									$data = array(
											  'size'        => '27',
											  'name'		=> 'email_box',
											  'id'			=> 'email_box',
											  'class'		=> 'required error',
											  'title'		=> '',
											  'value'		=>  set_value('email_box')
											);

									echo form_input($data);
								?>
							</p>
						</div>
						<div class="lebelboxui_step4">
							<!-- lebel step 1-->
							<p class="lebeltextstep2"><?php echo $this->lang->line('create_profile_user');?></p>
							<p class="textbox7selectStep4">
								<?php
									$data = array(
											  'size'        => '27',
											  'name'		=> 'email_box1',
											  'id'			=> 'email_box1',
											  'class'		=> 'required error',
											  'title'		=> '',
											  'value'		=>  set_value('email_box1')
											);

									echo form_input($data);
								?>
							</p>
						</div>
						<div class="lebelboxui_step4 remove_right_margin">
							<!-- lebel step 1-->
							<p class="lebeltextstep2"><?php echo $this->lang->line('create_profile_user');?></p>
							<p class="textbox7selectStep4">
								<?php
									$data = array(
											  'size'        => '27',
											  'name'		=> 'email_box2',
											  'id'			=> 'email_box2',
											  'class'		=> 'required error',
											  'title'		=> '',
											  'value'		=>  set_value('email_box2')
											);

									echo form_input($data);
								?>
							</p>
						</div>
						<div class="clear"></div>
					</div>
				</div>
				<!-- password user 2-->
				<div>
					<div id="labelboxselect">
						<!-- Country -->
						<div class="lebelboxui_step4">
							<!-- lebel step 1-->
							<p class="lebeltextstep2"><?php echo $this->lang->line('create_profile_password');?></p>
							<p class="textbox7selectStep4">
								<?php
									$data = array(
											  'size'        => '27',
											  'name'		=> 'password_box',
											  'id'			=> 'password_box',
											  'type'		=> 'password',
											  'class'		=> 'required error',
											  'title'		=> '',
											  'value'		=>  set_value('password_box')
											);
									echo form_input($data);
								?>
							</p>
						</div>
						<div class="lebelboxui_step4">
							<!-- lebel step 1-->
							<p class="lebeltextstep2"><?php echo $this->lang->line('create_profile_password');?></p>
							<p class="textbox7selectStep4">
								<?php
									$data = array(
											  'size'        => '27',
											  'name'		=> 'password_box1',
											  'id'			=> 'password_box1',
											  'type'		=> 'password',
											  'class'		=> 'required error',
											  'title'		=> '',
											  'value'		=>  set_value('password_box1')
											);
									echo form_input($data);
								?>
							</p>
						</div>
						<div class="lebelboxui_step4 remove_right_margin">
							<!-- lebel step 1-->
							<p class="lebeltextstep2"><?php echo $this->lang->line('create_profile_password');?></p>
							<p class="textbox7selectStep4">
								<?php
									$data = array(
											  'size'        => '27',
											  'name'		=> 'password_box2',
											  'id'			=> 'password_box2',
											  'type'		=> 'password',
											  'class'		=> 'required error',
											  'title'		=> '',
											  'value'		=>  set_value('password_box2')
											);
									echo form_input($data);
								?>
							</p>
						</div>
						<div class="clear"></div>
					</div>
				</div>
			</div>
			<div class="clear"></div>
			<!-- close paging nation div-->
		</div>
		<!-- right register buttom corner end-->
		<?php
			$data = array(
					  'name'		=> 'step',
					  'id'			=> 'step',
					  'type'		=> 'hidden',
					  'class'		=> 'required error',
					  'value'		=> 'get_contacts'
					);
			echo form_input($data);
		?>
		<div class="pagebuttons1">
			<button class="reset"><span class="button"><span><?php echo $this->lang->line('create_profile_connect');?></span></span></button>
		</div>
		<?php echo form_close(); ?>
	</div>
</div>
