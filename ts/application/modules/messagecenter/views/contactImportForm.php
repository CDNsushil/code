<?php $formAttributes = array("name"=>'customForm','id'=>'customForm');
echo form_open_multipart('messagecenter/openinviter',$formAttributes);
?>
<input type="hidden" name="accountType" id="accountType" value="yahoo"/>
<div class="emport-Content-Box" style="float:left width:100%" id='importForm' name='importForm'>
	<div class="row width100percent">
		<div class="cell likeOrng">Login info</div>
		<div class="cell likeOrng" id="account">
			<?php if($this->session->flashdata('error')==''){?>Please insert yahoo Id
			<?php }	else {
				echo '<span class="validation_errorNormal red ml0" id="error">'.$this->session->flashdata('error').'</span>';
				}?>
		</div>
	</div>

	<div class="row">
		<div class="cell block-main-table" style="margin-left:150px;width:5%">
			<div class="row">
				<div class="cell">
					<div align="center">
						<a title="Import Yahoo Contacts" class="formTip ptr" onclick="setValue('yahoo');">
							<img src="<?php echo base_url()?>images/icons/yahoo.png">
						</a>
					</div>
				</div>
			 </div>
			<div class="row">
				<div class="cell">
					<div align="center">
						<a title="Import Hotmail Contacts" class="formTip ptr" onclick="setValue('hotmail');">
							<img src="<?php echo base_url()?>images/icons/hotmail.png">
						</a>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="cell">
					<div align="center">
						<a title="Import Gmail Contacts" class="formTip ptr" onclick="setValue('gmail');">
						  <img src="<?php echo base_url()?>images/icons/gmail.png">
						</a>
					</div>
				</div>
			</div>
		</div>
		<div class="cell" style="margin-left:15px;width:50%">
			
			<div class="row">
				<div class="cell orng" style="width:50px;text-align:left">Email</div>
				<div class="cell"><input type="text" id="username" name="username" class="Bdr8 formTip required error"></div>
			</div>
			<div class="row heightSpacer"></div>
			<div class="row">
				<div class="cell orng" style="width:50px;text-align:left">Password</div>
				<div class="cell"><input type="password" id="password" name="password" class="Bdr8 formTip required error"></div>
			</div>
			<div class="row heightSpacer"></div>

		</div>
			<div class="row">
				<div class="cell">&nbsp;</div>
				<div class="cell">
					<?php echo form_hidden('import','Save');?>
					<div class="Btn_wp">
						<div class="btn_wp" style="margin-left:207px">
							<div class="button_left">
								<div class="button_right">
									<div class="button_text save">
										<?php echo form_submit('save', 'Save', ' class="border0 backgroundNone white bold"'); ?>
									</div>
								</div>
							</div>
						</div><!--submit_btn_wp-->
						<div class="btn_wp pl25">
							<div class="button_left">
								<div class="button_right">
									<div class="button_text save">
										<?php $data = array(
											'name' => 'button',
											'id' => 'button',
											'value' => 'true',
											'type' => 'reset',
											'content' => 'Cancel',
											'class'=> "border0 backgroundNone white bold",
											'onclick'=>"calcelImportForm()",
										);
										echo form_button($data);
										 ?>
									</div>
								</div>
							</div>
						</div>
						<?php echo form_close();?>
					</div>
				</div>
			</div>
	</div>
</div>

<script type="text/javascript">
function setValue(accountType)
{
	$('#accountType').val(accountType);
	$('#account').html('Please insert '+accountType+' Id');
}
</script>
<script type="text/javascript">
function calcelImportForm()
{
	document.getElementById('emport-Content-Box').style.display = 'none';
	document.getElementById('importForm').className = 'emport-Content-Box';
}

$(document).ready(function() {
	if(($('#error').html()!='') && (($.trim($('#account').html()))!='Please insert yahoo Id'))
	{
		document.getElementById('emport-Content-Box').style.display = 'block';
		document.getElementById('importForm').className = 'showElement';
	}
});

</script>
