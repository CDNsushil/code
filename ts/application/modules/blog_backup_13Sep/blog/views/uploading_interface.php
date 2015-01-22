<script type="text/javascript">
function styleMe() {
  if(window.top && window.top.location.href != document.location.href) {
  // I'm small but I'm not alone

    // all parent's <link>s
    var linkrels = window.top.document.getElementsByTagName('link');
    // my head
    var small_head = document.getElementsByTagName('head').item(0);
    // loop through parent's links
    for (var i = 0, max = linkrels.length; i < max; i++) {
      // are they stylesheets
      if (linkrels[i].rel && linkrels[i].rel == 'stylesheet') {
         // create new element and copy all attributes
        var thestyle = document.createElement('link');
        var attrib = linkrels[i].attributes;
        for (var j = 0, attribmax = attrib.length; j < attribmax; j++) {
          thestyle.setAttribute(attrib[j].nodeName, attrib[j].nodeValue);
        }

         // add the newly created element to the head
        small_head.appendChild(thestyle);

      }
    }

    // maybe, only maybe, here we should remove the kid's own styles...

  } else {
    alert('I hate to tell you that, but you are an orphant :(  ');
  }
}
styleMe();
</script>

<style>
body{background-color:#FFFFFF;}
#uploadgallerybutton{
height:24px;
background:url("<?=base_url();?>images/icons/image_upload.png") 50% no-repeat;
width:24px;
float:right;
padding: 0px;
border:#000000 0px solid;
}


</style>
<div>

<form name="iform" action="" method="post" enctype="multipart/form-data">
<span style="font-size:11px; color:#666666;">Allowed only gif, png, jpg files.</span>

<input type="hidden" value="" name="div_id" />

<?php /*?><div id="uploadgallerybutton" title="Upload Image" onClick="iform.submit();window.parent.upload(document.iform,'<? echo base_url();?>media/sushil/project/blog/gallery/');"></div><?php */?>

<div class="row">
<div class="cell"  style="width:270px;">
	<div id="FileUpload">
			<input type="file" size="17" name="image" id="BrowserHidden" onchange="getElementById('FileField').value = getElementById('BrowserHidden').value;" onmousedown="mousedown_tds_button(getElementById('browse_btn'));" onmouseup="mouseup_tds_button(getElementById('browse_btn'));"/>
			
			<div id="BrowserVisible">
				 <input type="text" id="FileField" class="formTip Bdr4" />
				 <div class="tds-button" style="position:absolute;right:0; top:0; ">
					<a id="browse_btn"><span>Browse</span></a>
				</div>
			</div>
		</div>
</div>
<div class="cell" style="padding-right:30px;"></div>
<div class="cell" align="center">
<div class="tds-button">
	<a id="upload" onclick="iform.submit();window.parent.upload(document.iform,'<? echo base_url();?>media/sushil/project/blog/gallery/');"><span>Upload</span></a>
</div>
</div>
</div><!-- End row -->
					

</form>

</div>
<script language="javascript" type="text/javascript">

$(document).ready(function()
{	

	$('#BrowserHidden').bind('change', function() {
	
		var ext = $('#FileField').val().split('.').pop().toLowerCase();
		if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) 
		{
			alert('Only gif,png,jpg,jpeg extensions are allowed');
			$('#BrowserHidden').attr({ value: '' }); 
			$('#FileField').attr({ value: '' }); 
		}
		
	});	

});

</script>
