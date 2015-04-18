<!--
<div class="poup_bx pr50 width527 shadow">
    <?php 
        //$formAttributes = array("name"=>'contactUploadForm','id'=>'contactUploadForm');
        //echo form_open_multipart(base_url_lang('messagecenter/uploadpostcsv'),$formAttributes);
    ?>

<div class="close_btn position_absolute" onClick="$(this).parent().trigger('close')"></div>
    <h3 class="">Import Contacts</h3>
   
   <div class="sap_35"></div>
   <div class="position_relative">
    <div class=" fl  width_400">
   	<input type="file"  name="userfile" id="BrowserHiddenPromo" onchange="getElementById('PromoFileField').value = getElementById('BrowserHiddenPromo').value;" class="top0 width100_per position_absolute" />
   <input type="text" id="PromoFileField" class="bdr_bbb fl  required  width_360px" />
   
   </div>
   <button class="mt0 mr10" type="button ">Browse</button></div>
   <span class="clearbox pt5">
   <a class="dash_link_hover" href="messagecenter/download">Click here</a>
   to find csv file format to upload contacts
   </span>  
   <div class="sap_35"></div>
   <button class=" " type="submit ">Save</button>  
   <!-- End wrap 1  --> 
   <?php //echo form_close();?>
<!--
</div>
-->
<div class="poup_bx pr50  shadow">
	<?php 
        $formAttributes = array("name"=>'contactUploadForm','id'=>'contactUploadForm');
        echo form_open_multipart(base_url_lang('messagecenter/uploadpostcsv'),$formAttributes);
    ?>
    <div class="close_btn position_absolute " onClick="$(this).parent().trigger('close')"></div>
      <h3 class="">Import CSV file </h3>
         <div class="sap_20"></div>
    <div class="position_relative">
    <div class=" fl width_400">
   	<input type="file"  name="userfile" id="BrowserHiddenPromo" onchange="getElementById('PromoFileField').value = getElementById('BrowserHiddenPromo').value;" class="top0 width100_per position_absolute" />
   <input type="text" id="PromoFileField" class="bdr_bbb fl  required  width_360px" />
 </div>
 
    <button class="mt0 ml10" type="button">Browse</button>
    
  <div class="clearb"></div>
   
    <button class=" " type="submit ">Save</button>  

       <!-- End wrap 1  --> 
   <?php echo form_close();?>
  </div>
<script type="text/javascript">

$(document).ready(function()
{	
    $("#contactUploadForm").validate();
    
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





