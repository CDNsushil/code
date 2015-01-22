<?php 
$groupId=(isset($group_id) && !empty($group_id))?$group_id:'';

$groupIddField=array(
	'type'=>'hidden',
	'name'=>'group_id',
	'id'=>'group_id',
	'value'=>$groupId,
);

?>
<!--/MAIN CONTAINER OF MERCHANT REGISTRATION/-->
<div class="reg_container">
	<div class="row">
	
		 <!--/PAGE LEFT SECTION/-->
		<div class="col-md-4 col-sm-4">
		
			<!--/TITTLE OF LEFT SECTION/-->
			<div class="title_bg col-sm-12 margin10">
				<div style="padding-left:0px;" class="title"><?php echo lang('user:reset_password_title');?></div>
			</div>
			
			<!--/THE FORM OF LOGIN SECTION/-->
			<div class="row">
				<?php echo form_open('users/forgot-password/'.encode($groupId), array('id'=>'reset-pass')) ;
					echo form_input($groupIddField);
					
					?>
				  <div class="form-group">
					<label for="email"><?php echo lang('global:email') ?><span>*</span></label>
					<?php echo form_input('email', $this->input->post('email') ? escape_tags($this->input->post('email')) : '','placeholder="Enter Email" required class="email"')?>
					<span class="error"></span>
				  </div>
				  
						<button type="submit"  name="btnSubmit" class="btn btn-primary col-sm-4" ><?php echo lang('user:submit_title');?></button>
						<button type="button"  onclick="history.go(-1)" class="btn btn-primary ml10" ><?php echo lang('global:back');?></button>

				 <?php echo form_close(); ?>
				 <!--/END OF LOGIN FORM/-->
			</div>
			<!--/END OF ROW/-->
		</div>
		<!--/END OF PAGE LEFT SECTION/-->
	</div>
	<br><br><br>
	 <!--/END OF ROW/-->
</div>
<!--/END OF MERCHANT REGISTRATION CONTAINER/-->
         
         
