<!-- contant div -->
<div  class="Contantpanel">
	<div class="left_panel"></div>
	<!-- register box start-->
	<div class="right_register_panel">
	
		<?php //print_r($plugin);?>

		<?php 
		$form_attributes = array('id' => 'openinviter', 'name' => 'openinviter');
		echo form_open('create_profile/cp_invitefriends',$form_attributes);
		?>
		
		<div class="step"><?php echo $this->lang->line('create_profile_step5');?></div>
		<div class="sprint2_top_crn">
			<p class="sprint_heading2"><?php echo $this->lang->line('create_profile_create_profile');?></p>
			<p class="sprintspace"></p>
			<p class="sprint_heading"><?php echo $this->lang->line('create_profile_invite_your_friends');?></p>
		</div>
		
		<?php if(validation_errors()){?>
		<div class="error_msg">
			<?php echo validation_errors(); ?>
		</div>
		<?php }?>

		<?php if(isset($error_provider)){ ?><div class="error_msg"><?php echo $error_provider; ?></div><?php }?>
		<?php if(isset($error_internal)){ ?><div class="error_msg"><?php echo $error_internal; ?></div><?php }?>
		<?php if(isset($error_session_id)){	?><div class="error_msg"><?php echo $error_session_id; ?></div><?php }?>
		<?php if(isset($error_contacts)){ ?><div class="error_msg"><?php echo $error_contacts; ?></div><?php }?>
		
		<div class="sprint2_mid_crn">

			<p class="sprintspace7">&nbsp;</p>
			<div class="Followmessenger">
	
			<?php 
			if(isset($contacts) && $contacts!=false)
			{
			?>
				<table class='thTable' align='center' cellspacing='0' cellpadding='0' width="100%">
					<tr class='thTableHeader'>
						<td colspan="2">Your contacts</td>
					</tr>
					<?php 
					if (count($contacts)==0) 
					{
					?>
					<tr class='thTableOddRow'>
						<td align='center' style='padding:20px;' colspan="2">
							You do not have any contacts in your address book.
						</td>
					</tr>
					<?php 
					}
					else
					{
					?>
					<tr class='thTableDesc'>
						<td>
							<input type='checkbox' onChange='toggleAll(this)' name='toggle_all' title='Select/Deselect all' checked> Invite All
						</td>
						<td>E-mail</td>
					</tr>
					<?php
						$odd=true; $counter=0;
						foreach($contacts as $email=>$name)
						{
							$counter++;
							if ($odd) $class='thTableOddRow'; else $class='thTableEvenRow';
					?>			
							<tr class='<?php echo $class;?>'>
								<td>
									<input name='check_<?php echo $counter;?>' value='<?php echo $counter;?>' type='checkbox' class='thCheckbox' checked>
									<input type='hidden' name='email_<?php echo $counter;?>' value='<?php echo $email;?>'><input type='hidden' name='name_<?php echo $counter;?>' value='<?php echo $name;?>'>
								</td>
								<td><?php echo $email;?></td>
							</tr>
					<?php		
							$odd=!$odd;
						}
					?>
					<?php	
					}
					?>
				</table>
				<?php
			}			
			?>				

			</div>
		
		</div>
		<div class="sprint4_bottom_crn">

			<div class="clear"></div>
			<div class="spacebar12"></div>
			<!-- paging nation div -->
			<div class="pagingbox2">
				<!-- pageing bullet close -->
				<div class="pagebuttons1 page_button_top_margin" style="margin-top:90px;">
					<button class="reset" onClick="return validateCheckbox();"><span class="button"><span><?php echo $this->lang->line('create_profile_send_invitation');?></span></span></button>
				</div>
				<div class="clear"></div>
			</div>
			<!-- close paging nation div-->
		</div>
		<!-- right register buttom corner end-->
		<?php
			$data = array(
					  'name'		=> 'step',
					  'id'			=> 'step',
					  'type'		=> 'hidden',
					  'value'		=> 'send_invites'
					);
			echo form_input($data);
		?>
		<?php
			$data = array(
					  'name'		=> 'provider_box',
					  'id'			=> 'provider_box',
					  'type'		=> 'hidden',
					  'value'		=> $provider_box
					);
			echo form_input($data);
		?>	
		<?php
			$data = array(
					  'name'		=> 'email_box',
					  'id'			=> 'email_box',
					  'type'		=> 'hidden',
					  'value'		=> set_value('email_box')
					);
			echo form_input($data);
		?>
		<?php
			$data = array(
					  'name'		=> 'oi_session_id',
					  'id'			=> 'oi_session_id',
					  'type'		=> 'hidden',
					  'value'		=> $oi_session_id
					);
			echo form_input($data);
		?>		
		<?php echo form_close(); ?>
	</div>
</div>

<script type='text/javascript'>
function toggleAll(element) 
{
	var form = document.forms.openinviter, z = 0;
	for(z=0; z<form.length;z++)
	{
		if(form[z].type == 'checkbox')
		form[z].checked = element.checked;
	}
}

function validateCheckbox() 
{ 
	var form = document.forms.openinviter, z = 0;
	var isChecked=0;
	for(z=0; z<form.length; z++)
	{
		if(form[z].type == 'checkbox')
		{
			if(form[z].checked==true)
			isChecked++;
		}	
	}
	
	if (isChecked == 0) 
	{ 
		alert('Nothing Selected');
		return false;
	} 
	else return true;
}
</script>
