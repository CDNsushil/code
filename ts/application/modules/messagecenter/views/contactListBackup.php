<?php

$firstNameArr = array(
	'name'	=> 'firstName',
	'id'	=> 'firstName',
	'class'	=> 'Bdr8 formTip required error',
	'title'	=> 'firstName',
	'value'	=> $firstName,
	'placeholder'	=> 'firstName',
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50
);
$lastNameArr = array(
	'name'	=> 'lastName',
	'id'	=> 'lastName',
	'class'	=> 'Bdr8 formTip required error',
	'title'	=> 'lastName',
	'value'	=> $lastName,
	'placeholder'	=> 'lastName',
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50
);
$professionArr = array(
	'name'	=> 'profession',
	'id'	=> 'profession',
	'class'	=> 'Bdr8 formTip',
	'title'	=> 'profession',
	'value'	=> $profession,
	'placeholder'	=> 'profession',
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50
);
$companyArr = array(
	'name'	=> 'company',
	'id'	=> 'company',
	'class'	=> 'Bdr8 formTip',
	'title'	=> 'company',
	'value'	=> $company,
	'placeholder'	=> 'company',
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50
);
$emailIdArr = array(
	'name'	=> 'emailId',
	'id'	=> 'emailId',
	'class'	=> 'Bdr8 formTip required error',
	'title'	=> 'emailId',
	'value'	=> $emailId,
	'placeholder'	=> 'emailId',
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50
);
$phoneArr = array(
	'name'	=> 'phone',
	'id'	=> 'phone',
	'class'	=> 'Bdr8 formTip',
	'title'	=> 'phone',
	'value'	=> $phone,
	'placeholder'	=> 'phone',
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50
);
$toadsquareUrlArr = array(
	'name'	=> 'toadsquareUrl',
	'id'	=> 'toadsquareUrl',
	'class'	=> 'Bdr8 formTip',
	'title'	=> 'toadsquareUrl',
	'value'	=> $toadsquareUrl,
	'placeholder'	=> 'toadsquareUrl',
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50
);
$addressArr = array(
	'name'	=> 'address',
	'id'	=> 'address',
	'class'	=> 'Bdr8 formTip',
	'title'	=> 'address',
	'value'	=> $address,
	'placeholder'	=> 'address',
	'rows'      => 2,
    'cols'      => 45,
    'style'	=>'width:462px;'
);

$formAttributes = array("name"=>'customForm','id'=>'customForm');
echo form_open_multipart('',$formAttributes);
echo form_hidden('tdsUid',$tdsUid);?>
<input type="hidden" value="0" name="contId" id="contId" />
<div class="Right_side_panel">
	
	

	<span class="clear_seprator "></span>
	<div class="title-content">
		<div class="title-content-left">
			<div class="title-content-right">
				<div class="title-content-center">
					<div class="title-content-center-label">My Contacts </div>
					<div class="tds-button-top" style="width:50px">
						<a class="tooltip" title="Import Contacts" href="javascript:showElement('importForm')">
							<img height="16" width="16" src="images/icons/1318930947_import.png">
						</a>
						<?php
							echo anchor('javascript://void(0);', '<span><div class="projectAddIcon"></div></span>',array('class'=>'formTip','title'=>$label['add'],'onclick'=>'showNewsRelatedForm(\'NEWSForm-Content-Box\',\'News-No-Records\',\'firstName\',\'lastName\',\'profession\',\'company\',\'emailId\',\'phone\',\'toadsquareUrl\',\'address\',\'contId\');$(\'#NEWS-Content-Box\').show();'));
						?>
						<div class="toggleAdditionalInfo" toggleDivId="NEWS-Content-Box"  toggleDivRecords="News-No-Records" toggleDivForm="NEWSForm-Content-Box"  align="right">
							<img src="<?php echo base_url();?>images/icons/down_arrow.png" border="0" class="formTip" title="<?php echo $label['NEWS']; ?>"/>
						</div>
					</div>
					<div class="clearfix" > </div>
				</div>
			</div>
		</div>
	</div>
	
	<div id="NEWS-Content-Box">
		<div class="hideElement" style="float:left width:100%" id='importForm'>
			<div class="cell block-main-table" style="margin-left:150px;width:5%">
				<div class="row">
					<div class="cell">
						<div align="center">
							<a title="Import Yahoo Contacts" class="tooltip" href="#">
								<img src="<?php echo base_url()?>images/icons/yahoo.png">
							</a>
						</div>
					</div>
				 </div>
				<div class="row">
					<div class="cell">
						<div align="center">
							<a title="Import Hotmail Contacts" class="tooltip" href="#">
								<img src="<?php echo base_url()?>images/icons/hotmail.png">
							</a>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="cell">
						<div align="center">
							<a title="Import Gmail Contacts" class="tooltip" href="#">
							  <img src="<?php echo base_url()?>images/icons/gmail.png">
							</a>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="cell">
						<div align="center">
							<a title="Import Facebook Contacts" class="tooltip" href="#">
								<img src="<?php echo base_url()?>images/icons/facebook1.png">
							</a>
						</div>
					</div>
				</div>
			</div>
			<div class="cell" style="margin-left:15px;width:50%">
				<div class="row">
					<div class="cell">Login Info</div>
				</div>
				<div class="row">
					<div class="cell"><div align="right">Email</div></div>
					<div class="cell"><input type="text" id="textfield8" name="textfield7"></div>
				</div>
				<div class="row">
					<div class="cell"><div align="right">Password</div></div>
					<div class="cell"><input type="text" id="textfield9" name="textfield7"></div>
				</div>
				<div class="row">
					<div class="cell">&nbsp;</div>
					<div class="cell">
						<div style="float:left; width:auto; padding-left:5px; padding-right:5px;" id="schedule_submit" class="button">Import Contacts</div>
					</div>
				</div>
			</div>
		</div>
		<div id="NEWSForm-Content-Box" style="display:none;">
			<div class="frm_wp">
				<div class="row ml10 ">
					<div class="row">
						<div class="cell orng mr10">First Name:</div>
						<div class="cell mr10"><?php echo form_input($firstNameArr);?></div>
					
						<div class="cell orng mr10">Last Name:</div>
						<div class="cell mr10"><?php echo form_input($lastNameArr);?></div>
					</div>
					<div class="row heightSpacer"></div>
					<div class="row">
						<div class="cell orng mr10">Profession:</div>
						<div class="cell mr10"><?php echo form_input($professionArr);?></div>
					
						<div class="cell orng mr10">Compnay:</div>
						<div class="cell mr10"><?php echo form_input($companyArr);?></div>
					</div>
					<div class="row heightSpacer"></div>
					<div class="row">
						<div class="cell orng mr10">Email:</div>
						<div class="cell mr10"><?php echo form_input($emailIdArr);?></div>
					
						<div class="cell orng mr10">Phone:</div>
						<div class="cell mr10"><?php echo form_input($phoneArr);?></div>
					</div>
					<div class="row heightSpacer"></div>
					<div class="row">
						<div class="cell orng mr10">Toadsquare showcase url:</div>
						<div class="cell mr10"><?php echo form_input($toadsquareUrlArr);?></div>
					</div>
					<div class="row heightSpacer"></div>
					<div class="row">
						<div class="cell orng mr10">Address:</div>
						<div class="cell mr10"><?php echo form_textarea($addressArr);?></div>
					</div>
					<div class="row heightSpacer"></div>
					<?php echo form_hidden('save','Save');?>
					<div class="row">
						<!-- Shows Save button -->
						<div class="Btn_wp">
							<div class="btn_wp pl145">
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
												'onclick'=>"calcelForm()",
											);
											echo form_button($data);
											 ?>
										</div>
									</div>
								</div>
							</div>
						</div><!-- End Save button -->
					</div>
					<?php echo form_close();?>
				</div>
			</div>
		</div>
		<div class="frm_wp">
		<div class="row ml10">
			<div class="cell ui-state-focus width150px" align="center">	Thumbnail</div>
			<div class="cell pl2">&nbsp;</div>

			<div class="cell ui-state-focus width120px" align="center">First Name</div>
			<div class="cell pl2">&nbsp;</div>

			<div class="cell ui-state-focus width120px" align="center">Last Name</div>
			<div class="cell pl2">&nbsp;</div>

			<div class="cell ui-state-focus width150px" align="center">	Email Address</div>
			<div class="cell pl2" >&nbsp;</div>

			<div class="cell ui-state-focus width170px" align="center">Actions</div>
		</div>
		<span class="clear_seprator "></span>
		<div class="clearfix" > </div>

	<div id="pagingContent">
		<?php if(!empty($contactList)) { 
			foreach($contactList as $contacs) {?>
		<div class="row">
			<div class="all_list_item ">
				<div class="pb10 mH30">
					<div class="cell width150px mb10" align="center">
					<a href="<?php echo base_url();?>trunk/toadsquare/dev/en/blog/postMediaGalleryForm/6">		<img class="formTip HoverBorder" src="http://localhost/toadsquarenew/trunk/toadsquare/dev/images/no_images.jpg" width="85" height="85" style="margin:auto;" title="">
					</a>
					</div>
					<div class="cell pl2" >&nbsp;</div>
					<div class="cell width120px" align="center">
					<?php echo $contacs['firstName'];?>
					</div>
					<div class="cell pl2">&nbsp;</div>
					<div class="cell width120px" align="center">
					<?php echo $contacs['lastName'];?>
					</div>
					<div class="cell pl2">&nbsp;</div>
					<div class="cell width150px" align="center">
					<?php echo $contacs['emailId'];?>
					</div>
					<div class="cell" style="padding-left:50px;">&nbsp;</div>
					<div class="no_margin width130px cell tac title-content title-content-right title-content-center tds-button-top">
						<?php
						$editArr = array('title'=>'edit',
						'class'=>"formTip contId",
						'id'=>"contId", 
						'firstName'=>$contacs['firstName'], 
						'lastName'=> $contacs['lastName'], 
						'emailId'=>$contacs['emailId'], 
						'profession'=>$contacs['profession'], 
						'company'=> $contacs['company'], 
						'toadsquareUrl'=> $contacs['toadsquareUrl'], 
						'address'=> $contacs['address'], 
						'phone'=>$contacs['phone'],
						'contId'=>$contacs['contId']
						);
						//echo "<pre />"; print_r($editArr);

						echo anchor('javascript://void(0);', '<span><div class="projectEditIcon"></div></span>',$editArr);

							$attr = array("title"=>'','class'=>'formTip');

							echo anchor('javascript://void(0);','<span><div class="projectDeleteIcon"></div></span>',$attr);
						?>
					</div>
					<div class="cell" style="padding-left:2px;">&nbsp;</div>
				</div><!--End of pb10 -->
			</div><!--End of all_list_item -->
		</div><!--End of row -->
		<?php } }?>
	</div><!--End of pagingContent -->
</div>
<!--frm_wp-->
</div>
</div><!--right_panel-->
<script language="javascript" type="text/javascript">
function showNewsRelatedForm(showDiv,hideDiv,firstName,lastName,profession,company,emailId,phone,toadsquareUrl,address,contId){
document.getElementById(showDiv).style.display = 'block';
if(document.getElementById(hideDiv))
document.getElementById(hideDiv).style.display = 'none';

document.getElementById(firstName).value = '';

document.getElementById(lastName).value = '';

document.getElementById(profession).value = '';

document.getElementById(company).value = '';

document.getElementById(emailId).value = '';

document.getElementById(toadsquareUrl).value = '';

document.getElementById(phone).value = '';

document.getElementById(address).value = '';

document.getElementById(contId).value = '';
}
</script>

<script language="javascript" type="text/javascript">
$(document).ready(function() {

	$('.contId').click(function(){
		var firstName = $(this).attr('firstName');
		var lastName = $(this).attr('lastName');
		var profession = $(this).attr('profession');
		var company = $(this).attr('company');
		var emailId = $(this).attr('emailId');
		var toadsquareUrl = $(this).attr('toadsquareUrl');
		var phone = $(this).attr('phone');
		var address = $(this).attr('address');
		var contId = $(this).attr('contId');

		$('#firstName').val(firstName);
		$('#lastName').val(lastName);
		$('#profession').val(profession);
		$('#company').val(company);
		$('#emailId').val(emailId);
		$('#toadsquareUrl').val(toadsquareUrl);
		$('#phone').val(phone);
		$('#address').val(address);
		$('#contId').val(contId);
		document.getElementById('NEWSForm-Content-Box').style.display = 'block';
	});

});


function showElement(elementID){
	alert(elementID);
	alert(document.getElementById(elementID).className);
	if(document.getElementById(elementID).className == "hideElement"){

		document.getElementById(elementID).parentNode.className='showElement';
		document.getElementById(elementID).className = 'showElement';
	}else{
		document.getElementById(elementID).className = 'hideElement';
	}

}
</script>
