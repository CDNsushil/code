<?php

//echo $firstName."firstName===";
//echo $lastName."lastName===";die;
$firstNameArr = array(
	'name'	=> 'firstName',
	'id'	=> 'firstName',
	'class'	=> 'Bdr width_366 required',
	//'title'	=> 'firstName',
	'value'	=> $firstName,
	//'placeholder'	=> 'firstName',
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50
);
$lastNameArr = array(
	'name'	=> 'lastName',
	'id'	=> 'lastName',
	'class'	=> 'Bdr width_366',
	//'title'	=> 'lastName',
	'value'	=> $lastName,
	//'placeholder'	=> 'lastName',
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50
);
$professionArr = array(
	'name'	=> 'profession',
	'id'	=> 'profession',
	'class'	=> 'Bdr width_366',
	//'title'	=> 'profession',
	'value'	=> $profession,
	//'placeholder'	=> 'profession',
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50
);
$companyArr = array(
	'name'	=> 'company',
	'id'	=> 'company',
	'class'	=> 'Bdr width_366',
	//'title'	=> 'company',
	'value'	=> $company,
	//'placeholder'	=> 'company',
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50
);
$emailIdArr = array(
	'name'	=> 'emailId',
	'id'	=> 'emailId',
	'class'	=> 'Bdr width_366 email required',
	//'title'	=> 'emailId',
	'value'	=> $emailId,
	//'placeholder'	=> 'emailId',
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50
);
$phoneArr = array(
	'name'	=> 'phone',
	'id'	=> 'phone',
	'class'	=> 'Bdr',
	//'title'	=> 'phone',
	'value'	=> $phone,
	//'placeholder'	=> 'phone',
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50,
	'style'	=>'width:191px;'
);
$addressArr = array(
	'name'	=> 'address',
	'id'	=> 'address',
	'class'	=> 'textarea_frm2',
	//'title'	=> 'address',
	'value'	=> $address
	//'placeholder'	=> 'address'	
);

$formAttributes = array("name"=>'contactEntryForm','id'=>'contactEntryForm');
echo form_open_multipart('',$formAttributes);
echo form_hidden('tdsUid',$tdsUid);?>

<input type="hidden" value="0" name="contId" id="contId" />
<input type="hidden" value="" name="already_exist" id="already_exist" />
<div id="NEWSForm-Content-Box" class="show" style="display:none;">
	<div class="upload_media_left_top2 row height8"></div><!--upload_media_left_top-->	
	<div class="upload_media_left_box">
          <div class="row ">
            <div class="label_wrapper cell">
              <label class="select_field"><?php echo $this->lang->line('firstName') ?></label>
            </div>
            <!--label_wrapper-->
            <div class=" cell frm_element_wrapper pt2">
              <?php echo form_input($firstNameArr);?>
            </div>
          </div>
          <!--from_element_wrapper--><!--artical_sub_wp-->
          <div class="row  ">
            <div class="label_wrapper cell">
              <label ><?php echo $this->lang->line('lastName') ?></label>
            </div>
            <!--label_wrapper-->
            <div class=" cell frm_element_wrapper  ">
             <?php echo form_input($lastNameArr);?>
              
            </div>
          </div>
          
          
          <div class="row  ">
            <div class="label_wrapper cell">
              <label ><?php echo $this->lang->line('profession') ?></label>
            </div>
            <!--label_wrapper-->
            <div class=" cell frm_element_wrapper  ">
              <?php echo form_input($professionArr);?>
              
            </div>
          </div>
          
          
          <div class="row ">
            <div class="label_wrapper cell">
              <label ><?php echo $this->lang->line('company') ?></label>
            </div>
            <!--label_wrapper-->
            <div class=" cell frm_element_wrapper  ">
             <?php echo form_input($companyArr);?>
              
            </div>
          </div>
          
          <div class="row ">
            <div class="label_wrapper cell">
              <label class="select_field" ><?php echo $this->lang->line('email') ?></label>
            </div>
            <!--label_wrapper-->
            <div class=" cell frm_element_wrapper  ">
              <?php echo form_input($emailIdArr);?>
              <span id='emailId_exist' style="display:none;" class='error'><?php echo $this->lang->line('emailExist') ?></span>
              
            </div>
          </div>
          
          <div class="row  ">
            <div class="label_wrapper cell">
              <label ><?php echo $this->lang->line('phone') ?></label>
            </div>
            <!--label_wrapper-->
            <div class=" cell frm_element_wrapper  ">
              <?php echo form_input($phoneArr);?>
              
            </div>
          </div>
         
          <div class="row  ">
            <div class="label_wrapper cell">
              <label ><?php echo $this->lang->line('address') ?></label>
            </div>
            <!--label_wrapper-->
            <div class=" cell frm_element_wrapper  ">
             <?php echo form_textarea($addressArr);?>
              <?php echo form_hidden('save','Save');?>
            </div>
          </div>
                     
	<div class="row"> 
	
	 <div class="label_wrapper cell bg-non"></div><!--label_wrapper-->
	     <div class="cell frm_element_wrapper mt10 mb10">             
				<div class="Req_fld cell"><?php echo $this->lang->line('requiredFields') ?></div> 	
				
				<div class="row">
					<div class="cell">*&nbsp;<?php echo $this->lang->line('descReqFieldMsg') ?> </div>
				 </div>
								 
			<div class="frm_btn_wrapper padding-right0">				
				<div class="tds-button Fleft mr5"><button type="reset" onclick="calcelForm();" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)" class="dash_link_hover"><span><div class="Fleft">Cancel</div> <div class="icon-form-cancel-btn"></div></span> </button> </div>
				<div class="tds-button Fleft"> <button type="submit" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)" class="dash_link_hover"><span><div class="Fleft">Save</div> <div class="icon-save-btn"></div> </span> </button>  </div>                                    
			</div>
      </div><!--element_wrapper-->      
   </div><!-- row-->
         
   </div><!--upload_media_left_box-->
	<div class="upload_media_left_bottom row"></div><!--upload_media_left_bottom-->
	<div class="row seprator_20"></div>   
</div>
<?php form_close();?>
<script type="text/javascript">
function calcelForm()
{
	//document.getElementById('NEWSForm-Content-Box').style.display = 'none';	
	document.getElementById('contactEntryForm').reset();
	$("#emailId_exist").css("display","none");
	$("label.error").css("display","none");
	$("#emailId").removeClass("error");
	
	$('#NEWSForm-Content-Box').slideToggle('slow');
}

$(document).ready(function(){	
	$("#emailId").blur(function(){				
	var emailId = $("#emailId").val();	
		$.post("<?php echo base_url();?>en/messagecenter/check_already_exist_email/", { emailId: emailId },
		 function(data){
			if(data == 1)
			{
				//alert("Email Id already exists!");	
				var msg = "Email Id already exists!";
				
			   $("#emailId_exist").css("display","block");
		
				$("#already_exist").val(data);
				return false;
			}
			else
			{
				$("#emailId_exist").css("display","none");
				$("#already_exist").val(data);
			}	
	   });			
	});	
	
	$("#contactEntryForm").validate({
		submitHandler: function() {
			//	alert($("#already_exist").val());
			//	return false;
			//alert($("#already_exist").val());
				
			if($("#already_exist").val() == 0)
			{
				var data = {"save":'Save',"firstName":$('#firstName').val(),"lastName":$('#lastName').val(),"profession":$('#profession').val(),"company":$('#company').val(),"emailId":$('#emailId').val(),"phone":$('#phone').val(),"address":$('#address').val(),"tdsUid":$("input[name=tdsUid]").val(),"contId":$('#contId').val()}; 
				
				AJAX('<?php echo base_url(lang()."/messagecenter");?>','',data);
				//$('#NEWSForm-Content-Box').slideUp('slow');
				window.location.href=baseUrl+language+'/messagecenter/contacts';
				//getSortedList('#');
			}
		}
	});
});
</script>
