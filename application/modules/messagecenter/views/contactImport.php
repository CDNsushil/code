<?php $formAttributes = array("name"=>'importForm','id'=>'importForm');
echo form_open_multipart('messagecenter/openinviter',$formAttributes);
?>
      <div class="poup_bx pr50 width513 shadow">
            <div class="close_btn position_absolute " onClick="$(this).parent().trigger('close')"></div>
            <h3 class=" ">Import Contacts</h3>
         <span class="sap_55"></span> <span class="fl mt3 ml10 mr15">Select Email Client</span>
            <div class="cnt_icon fl"> <a class="yahoo_icon fl mail_icon" href=""> </a> <a class="gmail_icon fl mail_icon" href=""> </a> <a class="hotmail_icon fl mail_icon" href=""> </a> <a class="facebook_icon fl common_graphic" href=""> </a></div>
            <span class="sap_45"></span>
	<div class="contact_input">
      <input class=" width490imp bdr_bbb fl required restrictEmailType" name="username" id="username" type="text" onblur="placeHoderHideShow(this,'Email Address*','show')" onclick="placeHoderHideShow(this,'Email Address*','hide')" value="" placeholder="Email Address*">
      <span class="sap_20"></span>
      <input class=" width490imp bdr_bbb fl required" type="password" onblur="placeHoderHideShow(this,'Password*','show')" onclick="placeHoderHideShow(this,'Password*','hide')" value="" name="password" placeholder="Password*">
   </div>
   <button  type="submit" class="ml10 ">Import</button>
   <div class="sap_10"></div>
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



</script>
