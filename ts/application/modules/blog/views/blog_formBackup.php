<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<!--postGalleryBoxWp START-->
<div id="postGalleryBoxWp" class="postGalleryBoxWp" style="display:none;">
	<div id="close-postGalleryBox" title="Close it" class="tip-tr close-customAlert"></div><!-- We have to define "id" in lightboxme-common.js -->
	<div class="postGalleryFormContainer" id="postGalleryFormContainer"></div>
</div>

<script>
$(document).ready(function(){	
	$("#blogForm").validate();	
});
</script>
<?php
$formAttributes = array(
'name'=>'blog',
'id'=>'blogForm',
);

$blogImgPath = array(
	'name'	=> 'blogImgPath',
	'id'	=> 'blogImgPath',
	'value'	=> set_value('blogImgPath',$values->blogImgPath),
	'maxlength'	=> 80,
	'size'	=> 30,
	'class'       => 'formTip Bdr4',
	'title'       => 'Blog Image Path',
);

$blogTitle = array(
	'name'	=> 'blogTitle',
	'id'	=> 'blogTitle',
	'value'	=> set_value('blogTitle',$values->blogTitle),
	'maxlength'	=> 80,
	'size'	=> 30,
	'class'       => 'formTip Bdr4 required error',
	'title'       => 'Blog Title',
	'style' => 'width:527px;',
);


$blogOneLineDesc = array(
	'name'	=> 'blogOneLineDesc',
	'id'	=> 'blogOneLineDesc',
	'value'	=> set_value('blogOneLineDesc',$values->blogOneLineDesc),
	'size'	=> 30,
	'cols' => 65,
	'rows' => 1,
	
	'class'       => 'formTip  textarea required error',
	'style' => 'border: 1px solid #A0A0A0;outline: 3px solid #E1E1E1;',
	'title'       => 'One Line Description',
);
$blogTagWords = array(
	'name'	=> 'blogTagWords',
	'id'	=> 'blogTagWords',
	'value'	=> set_value('blogTagWords',$values->blogTagWords),
	'size'	=> 30,
	'class'       => 'formTip  textarea',
	'title'       => 'Tag Words',
	'cols' => 65,
	'rows' => 3,
	
);
$blogIndustry = array(
	'name'	=> 'blogIndustry',
	'id'	=> 'blogIndustry',
	'value'	=> set_value('blogIndustry',$values->blogIndustry),
	'maxlength'	=> 80,
	'size'	=> 30,
	'class'       => 'formTip single',
	'title'       => 'Select Industry',
);
$blogLanguage = array(
	'name'	=> 'blogLanguage',
	'id'	=> 'blogLanguage',
	'value'	=> set_value('blogLanguage',$values->blogLanguage),
	'maxlength'	=> 80,
	'size'	=> 30,
	'class'       => 'formTip single',
	'title'       => 'Select Language',
);

$blogToDonate = array(
    'name'        => 'blogToDonate',
    'id'          => 'blogToDonate',
    'value'       => 'accept',
    'checked'     => $values->blogToDonate =='t'?TRUE:FALSE,
    'class'       => 'formTip',
	'title'       => 'Ask For Donations',
);

$blogToShareOn = array(
    'name'        => 'blogToShareOn',
    'id'          => 'blogToShareOn',
    'value'       => 'accept',
    'checked'     => $values->blogToShareOn =='t'?TRUE:FALSE,
    'class'       => 'formTip',
	'title'       => 'Share on',
);
$blogToTwitter = array(
    'name'        => 'blogToTwitter',
    'id'          => 'blogToTwitter',
    'value'       => 'accept',
    'checked'     => $values->blogToTwitter =='t'?TRUE:FALSE,
    'class'       => 'formTip',
	'title'       => 'For Twitter',
);
$blogToFacebook = array(
    'name'        => 'blogToFacebook',
    'id'          => 'blogToFacebook',
    'value'       => 'accept',
    'checked'     => $values->blogToFacebook =='t'?TRUE:FALSE,
    'class'       => 'formTip',
	'title'       => 'For Facebook',
);

if($values->blogFor =='1') $checkedBlogForChildren ="checked";
else $checkedBlogForChildren ="";
$blogForChildren = array(
    'name'        => 'blogFor',
    'id'          => 'blogFor',
    'value'       => '1',
    'checked'     => $checkedBlogForChildren,
    'class'       => 'formTip',
	'title'       => 'For Children',
);

if($values->blogFor =='2') $checkedBlogForAdult ="checked";
else $checkedBlogForAdult ="";
$blogForAdult = array(
    'name'        => 'blogFor',
    'id'          => 'blogFor',
    'value'       => '2',
    'checked'     => $checkedBlogForAdult,
    'class'       => 'formTip',
	'title'       => 'For Adult',
);
if(!isset($values->blogFor) && $values->blogFor =='')
$checkedBlogFor ="checked";
else if($values->blogFor =='3') $checkedBlogFor ="checked";
else $checkedBlogFor ="";
$blogForAll = array(
    'name'        => 'blogFor',
    'id'          => 'blogFor',
    'value'       => '3',
    'checked'     => $checkedBlogFor,
    'class'       => 'formTip',
	'title'       => 'For All',
);

if($this->uri->segment(4)) $blogId =$this->uri->segment(4);
if(isset($values->blogId)) $blogId = $values->blogId;

?>
<!------- Top Most Menu Buttons ------->   
<?php echo Modules::run("blog/menuNavigation",$blogId); ?> 
<!------ End Of Top Menu ------->     
     
<div class="frm_wp">
<?php
echo form_open_multipart('blog/blogForm',$formAttributes); 
if(isset($values->blogId))
echo form_hidden('blogId', $values->blogId);
echo form_hidden('custId', $values->custId);

		
		if($blogImgPath['value'] == '')
		{
			$profileImagePath = 'media/'.LoginUserDetails('username').'/profileimage/'.getUserImage($values->custId);
			$blogImagePath = $profileImagePath;
		}
		else $blogImagePath ='media/'.LoginUserDetails('username').'/project/blog/'.$blogImgPath['value'];

?>
<div class="table">
<div class="row rowHeight40">
		<div class="cell orng_lbl" style="vertical-align:top;"><?php echo $label['blogHeading'].' '.$label['image']  ?></div>
		<div class="cell">
			<div class="table" style="width:100%;">
				<div class="row" >
					<div class="cell dblBorder" style="vertical-align:middle; height:100px; width:100px; padding:5px;">
					<img style="max-width:100px; min-height:100px; max-height:100px; margin:auto;"  src="<?php echo getImage($blogImagePath);?>" />
					</div>
					<div class="cell" style="padding-left:10px;">&nbsp;</div>
					<div class="cell dblBorder" style="background-color:#E9E9E9; min-height:100px; width:400px; padding:5px;">
					<div class="table">
					<div class="row" >
					<div class="cell" ><?php echo $label['uploadImage']; ?><span class="clear_seprator"></span></div>
					</div>
					<div class="row" >
					<div class="cell" align="center">
						<div id="FileUpload">
                                <input type="file" size="24" name="userfile" id="BrowserHidden" onchange="getElementById('FileField').value = getElementById('BrowserHidden').value;" onmousedown="mousedown_tds_button(getElementById('browse_btn'));" onmouseup="mouseup_tds_button(getElementById('browse_btn'));" style="width:385px;" />
                                
                                <div id="BrowserVisible" style="width:385px;">
                                	 <input type="text" id="FileField" class="formTip Bdr4" style="width:300px;" title="<?php echo $label['uploadImage']; ?>"/>
                                	 <div class="tds-button" style="position:absolute; right:0; top:0;">
                                        <a id="browse_btn"><span>Browse</span></a>
                                    </div>
                                </div>
                            </div>
						</div>
					</div><!-- End Div Row-->
					<div class="row">
						<div class="cell" align="left" style="padding-top:25px;"><?php echo $label['allowed_image_size'].' '.$allowed_image_size.$image_size_unit; ?></div>
					</div><!-- End row -->
					
					</div><!-- End table -->
				</div>
			</div><!-- End row -->
		</div>
    </div>
</div><!-- End row -->
</div><!-- End Table -->
<div class="clear_seprator"></div>
 <div class="orng"><?php echo form_label($label['blogTitle'] , $blogImgPath['id']); ?></div>
 <?php echo form_input($blogTitle); ?>
 <?php echo form_error($blogTitle['name']); ?>
 <?php echo isset($errors[$blogTitle['name']])?$errors[$blogTitle['name']]:''; ?>
<span class="clear_seprator "></span>
 <div class="orng"><?php echo form_label($label['blogOneLineDesc'], $blogOneLineDesc['id']); ?></div>
 <?php echo form_textarea($blogOneLineDesc); ?>
 <?php echo form_error($blogOneLineDesc['name']); ?>
 <?php echo isset($errors[$blogOneLineDesc['name']])?$errors[$blogOneLineDesc['name']]:''; ?>
<span class="clear_seprator "></span>
 
 <div class="orng"><?php echo form_label($label['blogTagWords'], $blogTagWords['id']); ?></div>
 <?php echo form_textarea($blogTagWords); ?>
 <?php echo form_error($blogTagWords['name']); ?>
 <?php echo isset($errors[$blogTagWords['name']])?$errors[$blogTagWords['name']]:''; ?>
<span class="clear_seprator "></span>
 
<div class="orng"><?php echo form_label($label['blogSelectIndustry'], $blogIndustry['id']); ?></div>
<?php
$workIndustryName = "blogIndustry";
$workIndustryVal = $blogIndustry['value'];
?>
<div class="Bdr3">
<div class="bg_sel">
<span class="abc"><?php echo $label['blogSelectIndustry'];?></span>
<?php 
	echo form_dropdown($workIndustryName, $workIndustryList, $workIndustryVal ,'id="blogIndustry"','class="single"');
?>
 </div><!--bg_sel-->
 </div><!--Bdr3-->
 <?php echo form_error($blogIndustry['name']); ?>
 <?php echo isset($errors[$blogIndustry['name']])?$errors[$blogIndustry['name']]:''; ?>
<span class="clear_seprator "></span>
<div class="orng"><?php echo form_label($label['blogSelectLanguage'] ,$blogLanguage['id']); ?></div>
<?php
$blogLanguageName = "blogLanguage";
if($blogLanguage['value'] =='')
$blogLanguageVal = 1;
else
$blogLanguageVal = $blogLanguage['value'];
?>
<div class="Bdr3">
<div class="bg_sel">
<span class="abc"><?php echo $label['blogSelectLanguage']; ?></span>
<?php 
	echo form_dropdown($blogLanguageName, $workLang, $blogLanguageVal ,'id="blogLanguage"','class="single"');
?>
</div><!--bg_sel-->
</div><!--Bdr3-->
 <?php echo form_error($blogLanguage['name']); ?>
 <?php echo isset($errors[$blogLanguage['name']])?$errors[$blogLanguage['name']]:''; ?>
<span class="clear_seprator "></span>

 <div class="orng">&nbsp;</div>
 <div class="commonBorderArea inpt"style="margin-top:4px;height:auto;">
	<div class="row" style="margin-top:4px;">
	<div class="cell"> <?php echo form_checkbox($blogToDonate);?></div>
	<div class="cell" style="min-width:500px;max-width:500px;padding-left:10px;"><?php echo $label['blogToDonate']; ?></div>
	</div>
 </div>
<span class="clear_seprator "></span>
	
 <div class="orng"></div>
 <div class="commonBorderArea inpt">
	<div class="row"  style="margin-top:4px;">
	<div class="cell"><?php echo form_checkbox($blogToShareOn);?></div>
	  <div class="cell">&nbsp;<?php echo $label['blogToShareOn'];?></div>
	</div>
</div>
<span class="clear_seprator "></span>

 <div class="orng">&nbsp;</div>
 <div class="commonBorderArea inpt" style=" height: 45px;">
 <div class="row">
 <div class="cell"><?php echo $label['blogWishToShareOn'];?></div> </div>
 <div class="row">
 <div class="cell" ><label for="Children"><?php echo form_checkbox($blogToTwitter); ?>
 </div>
 <div class="cell" style="padding-left:5px;"><?php echo '&nbsp;'.$label['blogTwitter'];?> </label></div>
 <div class="cell" style="padding-left:5px;">&nbsp;</div>
 <div class="cell" style="padding-left:5px;"><label for="Adult"><?php echo form_checkbox($blogToFacebook);?>
 </div>
 <div class="cell" style="padding-left:5px;"><?php echo '&nbsp;'.$label['blogFacebook'];?> </label></div>

 </div><!-- End DIV row -->
 </div><!--commonBorderArea-->
<span class="clear_seprator "></span>
 <div class="orng">&nbsp;</div>  
 <div class="commonBorderArea inpt" style="height:auto">
 <?php echo $label['blogCreatedFor'];?><br />
 <div class="stand_alone">
 <div class="row"><div class="cell"> <div class="radio" id="Children">
 <?php echo form_radio($blogForChildren);?>
 </div></div><div class="cell"> 
 <label for="Children">Children</label></div></div>
 </div><!--stan_alone-->
 <div class="stand_alone">
  <div class="row"><div class="cell"> <div class="radio" id="Adult">
 <?php echo form_radio($blogForAdult); ?>
 </div></div><div class="cell"> 
 <label for="Adult">Adult</label></div></div>
 </div><!--stan_alone-->
 <div class="stand_alone">
<div class="row"><div class="cell">  <div class="radio" id="All">
 <?php  echo form_radio($blogForAll); ?>
 </div></div><div class="cell"> 
 <label for="All">All</label></div></div>
 </div><!--stan_alone-->
 </div><!--sales_infrmn-->
<span class="clear_seprator "></span>
<?php 
				//This shows add more category form
				echo Modules::run("blog/addCat",$blogId); 
?>
<!--
<p>Blog created for :<input type="radio" name="blogFor" value="0"/>Children<input type="radio" name="blogFor" value="1"/>Adults<input type="radio" name="blogFor" value="2"/>All
-->

<input type="hidden" name="save" value="" />
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
<?php echo form_close(); ?>
</div>



<?php $catLimit =10;?>
<script type="text/javascript"> 
		$(document).ready(function() {
			$(".catDetails").EnableMultiField({
					 maxItemsAllowedToAdd: <?php echo $catLimit?>,
					  linkText: ' <div>Add</div> ',
			});
		});

$(document).ready(function()
{
		var needToConfirm = false;
		var flag=0;
		 var ua = $.browser;

		$("select,input,textarea").blur(function ()
        {
            needToConfirm = true;
        })
		
  	window.onbeforeunload = function() {
    
	  if(ua.msie){ 
		if(needToConfirm == true){
			if (needToConfirm && document.blog.save.value!='Save')
			{
				return "Do you want to save the modification before leaving the page.";
			} 
		}
	  }
	  else{
			if (needToConfirm && document.blog.save.value!='Save')
            {
               return "Do you want to save the modification before leaving the page.";
            }
			else return null;		
			}
	  }			
 });

function submitform()
{
    document.blog.save.value= 'Save'; 
	document.blog.submit();  
}

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
