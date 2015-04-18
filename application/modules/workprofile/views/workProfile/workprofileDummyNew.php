<div class="row summery_post_wrapper">

	

	

	<? if($this->session->flashdata('success_msg')){?>
		<span class="message success_info">
			<?php echo $this->session->flashdata('success_msg');?>
		</span>
	<? }?>
	<?php
	echo form_open('workprofile/workProfileForm',"name='myForm'");?>
	<div align="center">&nbsp; <?php echo $label['createProfileMessage'];?></div>
	
	
	<div class="row tac" align="center">
		<div class="label_wrapper cell bg-non"></div><!--label_wrapper-->
		<div class="frm_element_wrapper" style="width: 465px;">
			
			<div class="frm_btn_wrapper padding-right0">
				 <div class="tds-button Fleft"> <button type="button"  onclick="submitform();" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)"><span><div class="Fleft"> <?php echo $label['createProfile'];?></div> <div class="icon-save-btn"></div> </span> </button>  </div>
			</div>
		</div>
	</div><!--from_element_wrapper-->
</div><!--summery_post_wrapper--> 

<script type="text/javascript">
function submitform()
{
    document.myForm.submit();  
}
</script>
