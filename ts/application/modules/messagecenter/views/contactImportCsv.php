<script>
$(document).ready(function(){	
			$("#contactUploadForm").validate();
});
</script>
<style>
#BrowserHiddenPromo  {
    height: 30px;
    opacity: 0;
    position: relative;
    text-align: right;
    width: 495px;
    z-index: 2;
}
</style>
<?php 

$formAttributes = array("name"=>'contactUploadForm','id'=>'contactUploadForm');
echo form_open_multipart($this->uri->uri_string(),$formAttributes);?>
<div class="upload-Content-Box" id="importExportCSV">
<div class="upload_media_left_top2 row height8">
        </div>
<div class="upload_media_left_box">
          <div class="row ">
            <div class="label_wrapper cell">
              <label >Import</label>
            </div>
            <!--label_wrapper-->
            <div class=" cell frm_element_wrapper pt2">
				<div class="tds-button fr btn_span_hover"> <a href="#" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)"><span class="min_widht">Upload</span></a>
                  </div>
				
				<div id="FileUpload" style="width: 420px;">
								<input type="file" size="24" name="userfile" id="BrowserHiddenPromo" onchange="getElementById('PromoFileField').value = getElementById('BrowserHiddenPromo').value;" onmousedown="mousedown_tds_button(getElementById('browse_btn'));" onmouseup="mouseup_tds_button(getElementById('browse_btn'));" class="required error Bdr import-file ptr dash_link_hover"/>
								
								<div id="BrowserVisible" style="width:495px">
									 <input type="text" id="PromoFileField" style="width:356px;" class="formTip Bdr4 " title="<?php echo $label['uploadcsv']; ?>"/><br />
									 <div class="tds-button" style="position:absolute; right:0; top:0;">
									
										<a id="browse_btn"><span>Browse</span></a>
									</div>
								</div>
							</div>
          
            <!--<input type="text" class="Bdr import-file" style="width:356px;" value="Import contact form .csv file"/>-->
              
              
               
               
               
               
               
               
                  
            <div class="tds-button fr mr3"> 
      
         <!--
          <a href="#" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)"><span class="min_widht63">Browse</span></a>
             -->     
              </div>
              
              <div class="row click_here_upload"><span><a href="messagecenter/download" class="dash_link_hover">Click here</a> to find csv file format to upload contacts</span></div>    
                  
            </div>
          </div>
          <!--from_element_wrapper--><!--artical_sub_wp-->
          <div class="row seprator_20"></div>
          <div class="row">
                 <?php echo form_hidden('go','Go');?>               
                             
<div class="cell Fright mr9" style = "float:right;" >
          
                                 
							<!-- <div class="tds-button Fleft "><span class="min_widht63"><div class="Fleft"><?php 
								//	echo form_button($data);
									 ?> </div> <div class="icon-cancel-btn-new"></div></span></div> 
          -->
          <div class="tds-button Fleft "><button type = "reset" onclick = "javascript:calcelUploadForm()" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)" class="dash_link_hover"><span><div class="Fleft"><?php echo $this->lang->line('cancel');?></div><div class="icon-form-cancel-btn"></div></span></button> </div>   
                                     <div class="tds-button Fleft ">

<button value = "save" name = "go" type = "submit" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)" class="dash_link_hover"><span class="min_widht"> <div class="icon-save-btn fr"></div> <div class="fr">Save</div> </span> </button>  </div>
   </div>
                                    
   <div class="row seprator_10"></div>                              
                         
                                
          </div>
          <!--from_element_wrapper-->
         
        </div>
        <!--upload_media_left_box-->
        
        <div class="upload_media_left_bottom row">
        </div><!--upload_media_left_bottom-->
    
       
</div>
<?php echo form_close();?>
<script type="text/javascript">
function calcelUploadForm()
{
	$('#upload-Content-Box').slideToggle('slow');
	//document.getElementById('upload-Content-Box').style.display = 'none';
	document.getElementById('importExportCSV').className = 'upload-Content-Box';
}

$(document).ready(function()
{	
	$('#BrowserHiddenPromo').bind('change', function() {
		var ext = $('#PromoFileField').val().split('.').pop().toLowerCase();
		if($.inArray(ext, ['csv']) == -1) 
		{
			alert('Only csv extension is allowed');
			$('#BrowserHiddenPromo').attr({ value: '' }); 
			$('#PromoFileField').attr({ value: '' }); 
		}
	});	
});
</script>

