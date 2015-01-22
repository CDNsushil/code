<div class="Right_side_panel">
	<?php include('navigationMenu.php');?>
<div class="frm_wp">

<? if($this->session->flashdata('success_msg')){?>
	<span class="message success_info">
		<?php echo $this->session->flashdata('success_msg');?>
	</span>
<? }?>

<?php 
echo form_open('workprofile/workProfileForm',"name='myForm'");
//$IsRecord = count($WorkProfile->result_array());
	//if($IsRecord == 0) echo 'No record found!';
	//else
	//{
		//print_r($WorkProfile); 
	//	foreach($WorkProfile->result_array() as $WorkProfileRecord)
	//	{
			?>	
			<div class="block-main" id="block-form">
			
			<table width="100%" border="0" cellspacing="5" bgcolor="#FFFFFF" style="border:1px solid #ccc; color:#000; font-size:12px;">
            <tr>
              <td colspan="2"><div align="center"><span class="style12">Dummy Resume</span><br />
              </div></td>
            </tr>
            <tr>
			<?php //echo "<pre />";print_r($WorkProfileRecord); ?>
				<td>
					<span class="style12">Your Name</span><a href="#" class="tooltip" title="Edit"></a><br />
					Address Details, <br />
					<a href="#" class="tooltip" title="Edit"></a>Contact Details, <a href="#" class="tooltip" title="Edit"></a>
				</td>
				<td>
					<div align="right">
						<div style="float:right" >&nbsp;</div>
						<?php
						//$profileImagePath ='media/'.LoginUserDetails('username').'/profile/images/'.$WorkProfileRecord['profileImgPath'];
						//echo $profileImagePath;
						?>
						<img width="100" src="<?php echo base_url().'images/no_images.jpg'?>" />
					</div>
				</td>
            </tr>
            <tr>
              <td colspan="2"><div class="style12" style="border-bottom:1px dotted #666; margin:2px 0px 2px 0px;"><a href="#" class="tooltip" title="Edit"></a>Synopsis</div>
                <p class="no_margin">Please update your Synopsis!</p>
                <p class="no_margin">&nbsp;</p>
                <div class="style12" style="border-bottom:1px dotted #666; margin:2px 0px 2px 0px;"><a href="#" class="tooltip" title="Edit"></a>Personal Details</div>
            <table width="100%" border="0">
                <tr>
                    <td width="150" valign="top">
						<p class="no_margin"><strong>Languages Known:</strong></p>
						<p class="no_margin"><strong>Nationality:</strong></p>
						<p class="no_margin"><strong>Visa available: </strong></p>
					</td>
                    <td valign="top">
						<p class="no_margin">Languages you Know!</p>
						<p class="no_margin">Update your Nationality</p>
						<p class="no_margin">Visa availability</p>
					</td>
                    <td width="150" valign="top">
						<p class="no_margin"><strong>Availability:</strong></p>
						<p class="no_margin"><strong>Notice period:</strong></p>
						<p class="no_margin"><strong>Remuneration required:</strong></p>
					</td>
                    <td valign="top">
						<p class="no_margin">Availability</p>
						<p class="no_margin">Mention your Notice period</p>
						<p class="no_margin">Mention your required Remuneration</p>
					</td>
                </tr>
            </table>
            <p class="no_margin">&nbsp;</p>
                <div class="style12" style="border-bottom:1px dotted #666; margin:2px 0px 2px 0px;"><a href="#" class="tooltip" title="Edit"></a>Education</div>
                <div style="margin-left:50px;">
                <p class="no_margin">Education Details will come here!</p></div>
                <p class="no_margin">&nbsp;</p>
                <div class="style12" style="border-bottom:1px dotted #666; margin:2px 0px 2px 0px;"><a href="#" class="tooltip" title="Edit"></a>Achievments and Awards</div>
                <div style="margin-left:50px;">
                   <p class="no_margin">Achievments and Awards Detais</p>
                </div>
				<p class="no_margin">&nbsp;</p>
				<?php
	//	}
	//}?>
	<div class="style12" style="border-bottom:1px dotted #666; margin:2px 0px 2px 0px;">
					<a href="#" class="tooltip" title="Add"></a>Employment History
				</div>
                <p class="no_margin">
					<span class="style11">
						<a href="#" class="tooltip" title="Edit">
							
						</a>
						Company Name,
					</span>
					
					<br />
				Designation</p>
				<div style="margin-left:50px;">
                    <p class="no_margin">Company Brief</p>
                    <p class="no_margin">Your Achievments</p>
                </div>
              <p class="no_margin">&nbsp;</p>
			  <div style="border-bottom:1px dotted #666; margin:2px 0px 2px 0px;" class="style12">					
				</div>
             </td>
            </tr>         
          </table>
		 <?php //echo form_hidden('save','Save');?>
		<!-- Shows Save button -->
		<div class="Btn_wp">
		<div class="btn_wp" style="padding-left:145px;">
		<div class="button_left">
		<div class="button_right">
		 <div class="button_text save" onclick="submitform();">
		  Edit
		 </div>
		</div>
		</div>
		</div><!--submit_btn_wp-->
		</div>
		<!-- End Save button -->		
		</div>
</div><!--frm_wp-->
<div class="pb10">&nbsp;</div>
</div><!--right_panel--> 

<script type="text/javascript">
function submitform()
{
    document.myForm.submit();  
}
</script>