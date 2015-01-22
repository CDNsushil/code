<div class="contactBoxWp dn" id="contactBoxWpImport">
	<div id="contactContainerImport" class="contactContainer" align="center">  <img width="100px" height="100px" src="<?php echo base_url()?>images/loading.gif" /></div>
</div>
<?php $formAttributes = array("name"=>'importForm','id'=>'importForm');
echo form_open_multipart('messagecenter/openinviter',$formAttributes);
?>
<input type="hidden" name="accountType" id="accountType" value="yahoo"/>
<div class="upload_media_left_top2 row height8">
</div>
<div class="emport-Content-Box" style="float:left width:100%" id='importForm' name='importForm' >
<div class="upload_media_left_box" id='importForm' name='importForm' >
          <div class="row ">
            <div class="label_wrapper cell bg-non">
              <label class="bg-non"></label>
            </div>
            <!--label_wrapper-->
            <div class=" cell frm_element_wrapper pt2">
          
              <div class="social_email_wp">
              		<div class="social_email_box">
                    		<div class="social_email_absolute_box">
                            		
                                    	<div class="social_fb_box" id="facebook">
                                        		
												<a title="Import Facebook Contacts" class="formTip ptr" onclick="setValue('facebook');">
						  <img src="<?php echo base_url()?>images/icons/icon_grey_fb.png">
						</a>	
                                             
                                        </div><!--social_fb_box-->
                                        
                                        <div class="social_fb_box" id="gmail">
                                        		
													<a title="Import Gmail Contacts" class="formTip ptr" onclick="setValue('gmail');">
						  <img src="<?php echo base_url()?>images/icons/icon_grey_google.png">
						</a>
                                          </div><!--social_fb_box-->
                                        
                                        <div class="social_fb_box social_select" id="yahoo">
                                        		
													<a title="Import Yahoo Contacts" class="formTip ptr" onclick="setValue('yahoo');">
							<img src="<?php echo base_url()?>images/icons/icon_grey_yahoo.png">
						</a>
                                              
                                        </div><!--social_fb_box-->
                                        
                                        <div class="social_fb_box" id="hotmail">
                                        		
							<a title="Import Hotmail Contacts" class="formTip ptr" onclick="setValue('hotmail');">
							<img src="<?php echo base_url()?>images/icons/icon_grey_msn.png">
						</a>
                                             
                                        </div><!--social_fb_box-->
                                   
                            </div><!--social_email_absolute_box-->
                            
                    </div><!--social_email_box-->
              </div><!--social_email_wp-->
            </div>
          </div>
          
          <div class="row ">
            <div class="label_wrapper cell">
              <label class="select_field">Username</label>
            </div>
            <!--label_wrapper-->
            <div class=" cell frm_element_wrapper pt2">
              <input type="text" class="Bdr import-file required restrictEmailType" style="width:356px;" name="username" id="username"/>
            </div>
          </div>
          
          <div class="row ">
            <div class="label_wrapper cell">
              <label class="select_field">Password</label>
            </div>
            <!--label_wrapper-->
            <div class=" cell frm_element_wrapper pt2">
              <input type="password" class="Bdr import-file required" style="width:356px;" name="password"/>
            </div>
          </div>
          
          <!--from_element_wrapper--><!--artical_sub_wp-->
          <div class="row seprator_3"></div>
          <div class="row">
			  <div class="label_wrapper cell bg-non"> </div>
           <div class="cell frm_element_wrapper">
           <div class="Req_fld cell mt6"><?php echo $this->lang->line('requiredFields');?></div>                  
				<div class="cell Fright mr9" style = "float:right;" >

				<div class="tds-button Fleft"><button type = "reset" onclick = "javascript:calcelImportForm()" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)" class="dash_link_hover"><span><div class="Fleft"><?php echo $this->lang->line('cancel');?></div><div class="icon-form-cancel-btn"></div></span> </button></div>
				<div class="tds-button Fleft"><button onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" value="Save" name="submit" type="submit" id="submitButton" class="dash_link_hover" style="background-position: 0px -38px;"><span style="background-position: right -38px;"><div class="Fleft">Import</div> <div class="icon-save-btn"></div></span></button></div>

            </div>               
            <div class="row seprator_10"></div>                   
            </div>        
          </div>
          <!--from_element_wrapper-->         
        </div>        
        <div class="upload_media_left_bottom row"></div>
        <!--upload_media_left_box-->
       
</div>
<?php echo form_close();?>
<script type="text/javascript">
	
function setValue(accountType)
{
	
	$(".social_select").removeClass("social_select");
	$("#"+accountType).addClass("social_select");
	
	$('#accountType').val(accountType);
	$('#account').html('Please insert '+accountType+' Id');
}

function calcelImportForm()
{
	$('#emport-Content-Box').slideToggle('slow');
	//document.getElementById('emport-Content-Box').style.display = 'none';
	document.getElementById('importForm').className = 'emport-Content-Box';
}

$("#importForm").validate({
			
	submitHandler: function() {			
		var countError = $('.error label').length;
		if(countError<=0){
			openLightBoxWithoutAjax('contactBoxWpImport','contactContainerImport');	
			$("#submitButton").click(function() {
				return true;
			});
		}
	}	
});

function validateFreeEmail(email)
	{
			var toValidateAccType = $('#accountType').val()+".com";
		//alert(toValidateAccType);
		var re = new RegExp("\^([\\w-\\.]+@("+toValidateAccType+"))$",""); 
		//var reg = /^([\w-\.]+@({toValidateAccType}$))$/;
		var reg = /^([\w-\.]+@(gmail.com))$/;
		///^(([a-zA-Z]:)|(\\{2}\w+)\$?)(\\(\w[\w].*))+(.mp3|.MP3|.mpeg|.MPEG|.m3u|.M3U)$/;
		if (re.test(email)){
			return true;
	}
	else{
		return false;
	}
	} 

$(document).ready(function() {
	
	if(($('#error').html()!='') && (($.trim($('#account').html()))!='Please insert yahoo Id'))
	{
		//document.getElementById('emport-Content-Box').style.display = 'block';
		document.getElementById('importForm').className = 'showElement';
	}
	
	

});

</script>

