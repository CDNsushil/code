<?php

//echo $firstName."firstName===";
//echo $lastName."lastName===";die;
$firstNameArr = array(
	'name'	=> 'firstName',
	'id'	=> 'firstName',
	'class'	=> ' width490imp bdr_bbb fl required',
	//'title'	=> 'firstName',
	'value'	=> $firstName,
	'placeholder'	=> 'User Name *',
	'minlength'	=> 2,
	'maxlength'	=> 50,
    'onclick'      =>  "placeHoderHideShow(this,'User Name *','hide')",
    'onblur'       =>  "placeHoderHideShow(this,'User Name *','show')",
	'size'	=> 50
);
$lastNameArr = array(
	'name'	=> 'lastName',
	'id'	=> 'lastName',
	'class'	=> ' width490imp bdr_bbb fl_366',
	//'title'	=> 'lastName',
	'value'	=> $lastName,
	'placeholder'	=> 'Last Name',
	'minlength'	=> 2,
	'maxlength'	=> 50,
     'onclick'      =>  "placeHoderHideShow(this,'Last Name','hide')",
    'onblur'       =>  "placeHoderHideShow(this,'Last Name','show')",
	'size'	=> 50
);
$professionArr = array(
	'name'	=> 'profession',
	'id'	=> 'profession',
	'class'	=> ' width490imp bdr_bbb fl required',
	//'title'	=> 'profession',
	'value'	=> $profession,
	'placeholder'	=> 'Role *',
	'minlength'	=> 2,
	'maxlength'	=> 50,
     'onclick'      =>  "placeHoderHideShow(this,'Role *','hide')",
    'onblur'       =>  "placeHoderHideShow(this,'Role *','show')",
	'size'	=> 50
);
$companyArr = array(
	'name'	=> 'company',
	'id'	=> 'company',
	'class'	=> ' width490imp bdr_bbb fl required',
	//'title'	=> 'company',
	'value'	=> $company,
	'placeholder'	=> 'Business Name *',
	'minlength'	=> 2,
	'maxlength'	=> 50,
     'onclick'      =>  "placeHoderHideShow(this,'Business Name *','hide')",
    'onblur'       =>  "placeHoderHideShow(this,'Business Name *','show')",
	'size'	=> 50
);
$emailIdArr = array(
	'name'	=> 'emailId',
	'id'	=> 'emailId',
	'class'	=> ' width490imp bdr_bbb fl email required',
	//'title'	=> 'emailId',
	'value'	=> $emailId,
	'placeholder'	=> 'Email address *',
	'minlength'	=> 2,
	'maxlength'	=> 50,
     'onclick'      =>  "placeHoderHideShow(this,'Email address *','hide')",
    'onblur'       =>  "placeHoderHideShow(this,'Email address *','show')",
	'size'	=> 50
);
$phoneArr = array(
	'name'	=> 'phone',
	'id'	=> 'phone',
	'class'	=> ' width_130 bdr_bbb fl',
	//'title'	=> 'phone',
	'value'	=> $phone,
	'placeholder'	=> 'Phone Number',
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50,
     'onclick'      =>  "placeHoderHideShow(this,'Phone Number','hide')",
    'onblur'       =>  "placeHoderHideShow(this,'Phone Number','show')",
	'style'	=>'width:191px;'
);


$addressArr = array(
	'name'	=> 'address',
	'id'	=> 'address',
	'class'	=> ' width490imp bdr_bbb fl',
	//'title'	=> 'Address',
	'value'	=> $address,
     'onclick'      =>  "placeHoderHideShow(this,'Address','hide')",
    'onblur'       =>  "placeHoderHideShow(this,'Address','show')",
	'placeholder'	=> 'Address'	
);

$formAttributes = array("name"=>'contactEntryForm','id'=>'contactEntryForm');
echo form_open_multipart('',$formAttributes);
echo form_hidden('tdsUid',$tdsUid);
?>

<input type="hidden" value="<?php echo $contId; ?>" name="contId" id="contIdd" />
<input type="hidden" value="" name="already_exist" id="already_exist" />
<div class="poup_bx pr50 width513 shadow">
      <div class="close_btn position_absolute " onClick="$(this).parent().trigger('close')"></div>
            <h3 class=" ">Add Contact</h3>
            <div class="fr pt10 pb6"><span class="fl pr10">Business  </span><span class="defaultP">
			<input type="checkbox" name="userBusinessName" id="userBusinessName" value="t" <?php echo ($userBusinessName=="t")?"checked":""; ?>/>
      </span>
      
      
      
   </div>
   <ul class="contact_input listpb15">
      <li>
         <?php echo form_input($firstNameArr);?>
      </li>
      <li>
         <?php echo form_input($lastNameArr);?>
      </li>
      <li>
          <?php echo form_input($professionArr);?>
      </li>
      <li>
          <?php echo form_input($companyArr);?>
      </li>
      <li>
        <?php echo form_input($emailIdArr);?>
        <span id='emailId_exist' style="display:none;" class='error'><?php echo $this->lang->line('emailExist') ?></span>
      </li>
      <li>
        <?php echo form_input($phoneArr);?>
      </li>
      <li>
          <?php echo form_textarea($addressArr);?>
          <?php //echo form_hidden('save','Save');?>
      </li>
   </ul>
   <button  type="submit" name="save" value="Save"  class="ml10 ">Save</button>
   <div class="sap_10"></div>
</div>

<?php form_close();?>
<script type="text/javascript">
    //new rendered checkbox and radio button show
    radioCheckboxRender();
    
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
                    
                    var userBusinessName = "f";
                    if($('#userBusinessName').is(":checked")){
                        userBusinessName = "t";
                    }
                    
                    var data = {"save":'Save',"userBusinessName":userBusinessName,"firstName":$('#firstName').val(),"firstName":$('#firstName').val(),"lastName":$('#lastName').val(),"profession":$('#profession').val(),"company":$('#company').val(),"emailId":$('#emailId').val(),"phone":$('#phone').val(),"address":$('#address').val(),"tdsUid":$("input[name=tdsUid]").val(),"contId":$('#contIdd').val()}; 
                    
                    //var data = $("#contactEntryForm").serializeArray();
                    
                    AJAX('<?php echo base_url(lang()."/messagecenter/saveusercontact");?>','',data);
                    window.location.href=baseUrl+language+'/messagecenter/contacts';
                }
            }
        });
    });
    
</script>
