<script language="javascript" type="text/javascript">
var img, txtFilename;
window.onload = function(){
  img = document.getElementById('btnBrowse');
  txtflName = document.getElementById('txtflName');
};
</script>

<div class="row">
	<div class="cell frm_heading">
		<h1>Media Gallery</h1>
	</div>
	<?php echo Modules::run("blog/navigationMenu"); ?>

	<div class="row padding_top10">
		<div class="cell width_200"></div>
		<!-- Code to uncomment  <div class="cell"> <img src="<?php echo base_url()?>images/strip_blog.png"  border="0"/> </div>-->
	<!-- New Code End  -->
<?php
//echo 'post_media_gallery_form<pre />';
//print_r($postMediaGallery);
$CI = get_instance(); 
$pathToSystemJs=$CI->config->item('system_js');
$pathToUploadPlg=base_url().$pathToSystemJs."jquery-plugin/upload-1.0/";
					
$galTitle =	array(
	'name'        => 'galTitle',
	'id'          => 'galTitle',
	'value'	=> set_value('galTitle',$postMediaGallery['galTitle']),
	'maxlength'	=> 80,
	'size'	=> 20,
	'class'       => 'formTip Bdr4',
	'title'       => 'Title',
	'style'       => 'width:438px;',
	);
	$galAltText =	array(
	'name'        => 'galAltText',
	'value'	=> set_value('galAltText',$postMediaGallery['galAltText']),
	'id'          => 'gal AltText',
	'maxlength'	=> 80,
	'size'	=> 20,
	'class'       => 'formTip Bdr4',
	'title' => 'Alternate Text',
	'style'       => 'width:438px;',
	);

if(isset($postMediaGallery['galPath']))
{
	// Use strrpos() & substr() to get the file extension
	$ext = substr($postMediaGallery['galPath'], strrpos($postMediaGallery['galPath'], "."));
	// Then stitch it together with the new string and file's basename
	$newImageName = basename($postMediaGallery['galPath'], $ext) . $suffix . $ext;
		
$gallery_thumbs_folder = $gallery_thumb_version_folder.'/';
$postMediaGalleryPath = 'media/'.LoginUserDetails('username').'/project/blog/gallery/'.$gallery_thumbs_folder.$newImageName ;
	//$postMediaGalleryPath = 'media/'.LoginUserDetails('username').'/project/blog/gallery/thumbs/'.$newImageName;
	$postMediaGalleryPathTrue =  getImage($postMediaGalleryPath);
	$MediaGalleryAttribute = @getimagesize($postMediaGalleryPath); //To get image attributes
	$countGalleryCount = count($MediaGalleryAttribute);
	
}

$formAttributes = array(
'name'=>'postMediaGalleryForm',
'id'=>'postMediaGalleryForm',
'onafterupdate'=>"OnAfterUpdate();"
);

					
echo form_open_multipart('blog/postMediaGalleryForm',$formAttributes);
if(isset($postMediaGallery['postGalleryId']))
echo form_hidden('postGalleryId',$postMediaGallery['postGalleryId']);
echo form_hidden('save');
if(isset($postMediaGallery['postGalleryId']) && $postMediaGallery['postGalleryId']!=0)
{
?>

<div class="table">
<div class="row rowHeight40">
	<div class="cell orng_lbl" style="vertical-align:top;"><?php echo $label['image'];  ?></div>
	<div class="cell">
		<div class="table" style="width:100%;">
			<div class="row" >
				<div class="cell dblBorder" style="vertical-align:middle; padding:3px;">
					<img style="margin:auto;"  src="<?php echo $postMediaGalleryPathTrue;?>"  title="<?php echo $postMediaGalleryPathTrue;?>" />
				</div>
				<div class="cell" style="padding-left:10px;">&nbsp;</div>
				<div class="cell" style="background-color:#FFFFFF; min-height:100px; width:241px; padding:5px;">
					<div align="left" style="padding-top:0px;">
					<?php
						
						$uploadDate = '';
						if($postMediaGallery['attachedDate']!='')
						$uploadDate = date("F d, Y", strtotime($postMediaGallery['attachedDate']));
						echo 'File name: '.$postMediaGallery['galPath'];
						echo '<span class="clear_seprator "></span>';
						$fileType = strstr($postMediaGallery['galPath'], '.');
						echo 'File type: '.($MediaGalleryAttribute['mime']?$MediaGalleryAttribute['mime']:'No File Type');
						echo '<span class="clear_seprator "></span>';
						echo 'Upload Date: '.$uploadDate;
						echo '<span class="clear_seprator "></span>';
						echo 'Dimensions: '.($MediaGalleryAttribute[0]?$MediaGalleryAttribute[0].' x '.$MediaGalleryAttribute[1]:'0 x 0');						
					?>
					</div>
				</div>
			</div><!-- End Of Row-->
		</div><!-- End Of Table-->
	</div>
</div><!-- End Div class="row rowHeight40" -->
</div><!-- End Of Table-->
<?php
} 
?>

<?php

echo '<span class="clear_seprator "></span>';
if($postMediaGallery['postGalleryId']==0)
{
?>
<div class="table">
<div class="row rowHeight40">
		<div class="cell orng_lbl" style="vertical-align:top;"><?php echo $label['addImage'];  ?></div>
		<div class="cell">
			<div class="table" style="width:100%;">
				<div class="row" >
					<div class="cell dblBorder" style="vertical-align:middle; height:100px; width:100px; padding:5px;">
						<img style="max-width:100px; min-height:100px; max-height:100px; margin:auto;"  src="<?php echo $postMediaGalleryPathTrue;?>"  title="<?php echo $postMediaGalleryPathTrue;?>" />
					</div>
					<div class="cell" style="padding-left:10px;">&nbsp;</div>
					<div class="cell dblBorder" style="background-color:#E9E9E9; min-height:100px; width:311px; padding:5px;">
					<div class="table">
					<div class="row" >
					<div class="cell" ><?php echo $label['uploadImage']; ?><span class="clear_seprator"></span></div>
					</div>
					<div class="row">
					<div class="cell" align="center">
						<div id="FileUpload">
                                <input type="file" size="24" name="image" id="BrowserHidden" onchange="getElementById('FileField').value = getElementById('BrowserHidden').value;" onmousedown="mousedown_tds_button(getElementById('browse_btn'));" onmouseup="mouseup_tds_button(getElementById('browse_btn'));"/>
                                
                                <div id="BrowserVisible">
                                	 <input type="text" id="FileField" class="formTip Bdr4" title="<?php echo $label['uploadImage']; ?>"/>
                                	 <div class="tds-button" style="position:absolute; right:0; top:0;">
                                        <a id="browse_btn"><span>Browse</span></a>
                                    </div>
                                </div>
                            </div>
						</div>
					</div><!-- End row -->
					<div class="row">
						<div class="cell" align="left" style="padding-top:25px;"><?php echo $label['allowed_image_size'].' '.$allowed_image_size.$image_size_unit; ?></div>
					</div><!-- End row -->
					</div>
				</div><!-- End Of Table-->
				</div>
			</div><!-- End Of Table-->
		</div><!-- End of cell for browse button and related text-box-->
    </div><!-- End row rowHeight40 -->
	</div><!-- End Of Table-->
<?php
}

echo '<span class="clear_seprator"></span>';
echo '<div class="orng">Title</div>';
echo form_input($galTitle); 
echo '<span class="clear_seprator "></span>';
echo '<div class="orng">Alternate Text</div>';
echo form_input($galAltText);  
?>

<span class="clear_seprator "></span>
<div class="Btn_wp">
<div class="btn_wp" style="padding-left:145px;">
<div class="button_left">
<div class="button_right">
 <div class="button_text save" onclick="submitform();">
  Save
 </div>
</div>
</div>
</div><!--submit_btn_wp-->
</div>

<!-- End of Old Code  -->
</div>	
</div>
<script>
$(document).ready(function()
{
	var needToConfirm = false;
	var status = true;
	var flag=0;	
	var ua = $.browser;
	$("select,input,textarea").blur(function ()
	{
		needToConfirm = true;
	})
		
	
	window.onbeforeunload = function() {
    if(ua.msie){ 
		if(needToConfirm == true){
			if (needToConfirm && document.postMediaGalleryForm.save.value!='Save')
			{
				return "Do you want to save the modification before leaving the page.";
			} 
		}
	  }
	  else{
		if (needToConfirm && document.postMediaGalleryForm.save.value!='Save')
		{
			return "Do you want to save the modification before leaving the page.";
		}
		else return null;	
		}		
	}
		
});

//To check for image type 
//customAlert("Coming Soon...",e);

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

function submitform()
{
    window.onbeforeunload = null;
	document.postMediaGalleryForm.save.value= 'Save'; 
	document.postMediaGalleryForm.submit();  
}
</script>

