<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
*
* Admin Edit User View
*
* @author			Chris Baines
* @package			Dove Forums
* @copyright		© 2010 - 2011 Dove Forums
* @last modified	03/02/2011
**/
?>

<!--<div class="header_bg"><h1></h1></div>-->

<div class="cell frm_heading row">
<h1><?php echo $this->lang->line('addUser'); ?></h1>
</div>
		<div class="seprator_20"></div>

<div class="clear"></div>
<div class="content_box bdr_non">
	<div class="seprator_20"></div>

<?php //echo form_open(lang().'/admin/users/save_user/', 'class="form"'); ?>
<?php echo form_open(lang().'/admin/', 'class="form"'); ?>


        <!--<h3><?php //echo $this->lang->line('userDetails'); ?></h3>-->
       <p><div class="cell admin_label_width">
			<div class="cell label_wrapper_topic ml10" id="oneLineDescription">
				<label class="">		
					<?php echo $this->lang->line('username'); ?>
				</label>
				</div>
			</div>
			<?php echo form_input($username); ?>
		</p>
			
		<div class="seprator_20"></div>
			
       <p class="clear">
		   <div class="cell admin_label_width">
			<div class="cell label_wrapper_topic ml10" id="oneLineDescription">
				<label class="">		
					<?php echo $this->lang->line('password'); ?>
				</label>
			</div>
			</div>
			<?php echo form_input($password); ?>
		</p>
			
		<div class="seprator_20"></div>


       <p class="clear">
		   <div class="cell admin_label_width ">
				<div class="cell label_wrapper_topic ml10" id="oneLineDescription">
					<label class="">		
						<?php echo $this->lang->line('firstName'); ?>
					</label>
				</div>
			</div>
				<?php echo form_input($first_name); ?>
		</p>

		<div class="seprator_20"></div>

       <p class="clear">
  		   <div class="cell admin_label_width">
				<div class="cell label_wrapper_topic ml10" id="oneLineDescription">
					<label class="">		
						<?php echo $this->lang->line('lastName'); ?>
					</label>
				</div>
			</div>
			<?php echo form_input($last_name); ?>
		</p>

		<div class="seprator_20"></div>

       <p class="clear">
 		   <div class="cell admin_label_width">
				<div class="cell label_wrapper_topic ml10" id="oneLineDescription">
					<label class="">		
						<?php echo $this->lang->line('userEmail'); ?>
					</label>
				</div>
			 </div>
			<?php echo form_input($email); ?>
		</p>
		
	<div class="seprator_20"></div>

		<p class="clear">
		<div class="cell admin_label_width">
			<div class="cell label_wrapper_topic ml10" id="oneLineDescription">
				<label class="">		
					<?php echo $this->lang->line('gender'); ?>
				</label>
			</div>
		   </div>
			<div class="position_relative admin_select cell">
				<?php echo form_dropdown('gender', $gender); ?>&nbsp;&nbsp;
			</div>
		</p>
	
		<div class="clear"></div>
		
	<div class="seprator_20"></div>

<div class="cell frm_heading row ">
<h1><?php echo $this->lang->line('userSettings'); ?></h1>
</div>
	<div class="seprator_20 row"></div>


       <p class="clear">
 		   <div class="cell admin_label_width ml10">
				<div class="cell label_wrapper_topic" id="oneLineDescription">
					<label class="">		
						<?php echo $this->lang->line('userGroup'); ?>
					</label>
				</div>
			 </div>
			 <div class="position_relative admin_select cell">
			<?php echo form_dropdown('group', $group_options); ?>
			</div>
		</p>

			<div class="clear"></div>

		<div class="seprator_20 row"></div>

		
		<p class="clear">
 		   <div class="cell admin_label_width ml10">
				<div class="cell label_wrapper_topic" id="oneLineDescription">
					&nbsp;
				</div>
			 </div>
			 <div class="position_relative admin_select cell">
					<div class="tds-button">
					<button name="save" value="Save" type="submit" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)" onclick="submitform();" >
						<span class="text-indent_0" style="background-position: right -38px;"><?php echo $this->lang->line('addUserButton'); ?></span></button>
					</div>
			</div>
		</p>

			<div class="clear"></div>
			

		
        <?php //echo form_submit('submit', $this->lang->line('addUserButton'));?>
  

<?php echo form_close(); ?>

</div>
