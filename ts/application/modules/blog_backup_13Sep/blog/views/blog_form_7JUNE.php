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
	'class'       => 'formTip frm_Bdr required',
	'title'       => 'Blog Title',
);

$blogOneLineDesc = array(
	'name'	=> 'blogOneLineDesc',
	'id'	=> 'blogOneLineDesc',
	'value'	=> set_value('blogOneLineDesc',$values->blogOneLineDesc),
	'cols' => 65,
	'rows' => 2,
	'class'       => 'frm_Bdr heightAuto rz formTip required',
	'title'       => 'One Line Description',
	'wordlength'=>"15,100",
	'onkeyup'=>"checkWordLen(this,100,'descLimit')",
);

$blogTagWords = array(
	'name'	=> 'blogTagWords',
	'id'	=> 'blogTagWords',
	'value'	=> set_value('blogTagWords',$values->blogTagWords),
	'class'       => 'frm_Bdr heightAuto rz formTip required',
	'title'       => 'Tag Words',
	'cols' => 65,
	'rows' => 2,
	'wordlength'=>"5,50",
	'onkeyup'=>"checkWordLen(this,50,'tagLimit')",
	
);

$blogIndustry = array(
	'name'	=> 'blogIndustry',
	'id'	=> 'blogIndustry',
	'value'	=> set_value('blogIndustry',$values->blogIndustry),
	'size'	=> 30,
	'class'       => 'formTip single',
	'title'       => 'Select Industry',
);

$blogLanguage = array(
	'name'	=> 'blogLanguage',
	'id'	=> 'blogLanguage',
	'value'	=> set_value('blogLanguage',$values->blogLanguage),
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

if($values->blogFor =='1') $checkedBlogForChildren =  TRUE;
else $checkedBlogForChildren = FALSE;
$blogForChildren = array(
    'name'        => 'blogFor',
    'id'          => 'blogFor',
    'value'       => '1',
    'checked'     => $checkedBlogForChildren,
    'class'       => 'formTip',
	'title'       => 'For Children',
);

if($values->blogFor =='2') $checkedBlogForAdult = TRUE;
else $checkedBlogForAdult = FALSE;

$blogForAdult = array(
    'name'        => 'blogFor',
    'id'          => 'blogFor',
    'value'       => '2',
    'checked'     => $checkedBlogForAdult,
    'class'       => 'formTip',
	'title'       => 'For Adult',
);

if(!isset($values->blogFor) && $values->blogFor =='')
$checkedBlogFor = TRUE;
else if($values->blogFor =='3') $checkedBlogFor = TRUE;
else $checkedBlogFor = FALSE;

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

// UPDATING NAVIGATION BASED ON CONDITION
//	IF USER IS ACCESSING BLOG SETTING FROM "EDIT POST"
//	ELSE IF USER IS ACCESSING BLOG SETTING PAGE AS DEFAUTL OR 'NEW POST'
	

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

<div class="row form_wrapper">
<?php 
	//LEFT SHADOW STRIP
	echo Modules::run("common/strip");
?>
	<div class="row">
		<div class="cell frm_heading">
			<h1><?php echo $label['blogSettings'];?></h1>
		</div>
		<?php echo Modules::run("blog/navigationMenu"); ?>
	</div>
	<div class="row line1"></div>

	<div class="row">
		<div class="row seprator_27"></div>
		<div class="label_wrapper cell">
			<label class="select_field"><?php echo $label['blogHeading'].' '.$label['image']  ?></label>
		</div><!--label_wrapper-->
		<div class="cell frm_element_wrapper">
			<div id="FileUpload">
				<input type="file" size="24" name="userfile" id="BrowserHidden" onchange="getElementById('FileField').value = getElementById('BrowserHidden').value;" onmousedown="mousedown_tds_button(getElementById('browse_btn'));" onmouseup="mouseup_tds_button(getElementById('browse_btn'));"/>
				<div id="BrowserVisible">
					 <input type="text" id="FileField" class="formTip Bdr" title="<?php echo $label['uploadImage']; ?>"/>
					 <div class="tds-button" style="position:absolute; right:0; top:0;">
						<a id="browse_btn"><span>Browse</span></a>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="label_wrapper cell">
			<label class="select_field"><?php echo $label['blogTitle']; ?></label>
		</div><!--label_wrapper-->

		<div class="cell frm_element_wrapper">
			<?php echo form_input($blogTitle); ?>
			<?php echo form_error($blogTitle['name']); ?>
			<?php echo isset($errors[$blogTitle['name']])?$errors[$blogTitle['name']]:''; ?>
		</div>
	</div><!--from_element_wrapper-->
	
	
	<?php 
			$value=$blogOneLineDesc['value']?$blogOneLineDesc['value']:@$values->postOneLineDesc;
			$value=htmlentities($value);
			$data=array('name'=>'blogOneLineDesc','value'=>$value, 'view'=>'oneline_description');
			echo Modules::run("common/formInputField",$data);
	?>

	<?php 
			$value=$blogTagWords['value']?$blogTagWords['value']:@$values->blogTagWords;
			$value=htmlentities($value);
			$data=array('name'=>'blogTagWords','value'=>$value, 'view'=>'tag_words');
			echo Modules::run("common/formInputField",$data);
	?>

	<?php
		$workIndustryName = "blogIndustry";
		$workIndustryVal = $blogIndustry['value'];
	?>

	<div class="row">
		<div class="label_wrapper cell">
			<label><?php echo $label['blogSelectIndustry']; ?></label>
		</div><!--label_wrapper-->
		<div class=" cell frm_element_wrapper">
			<?php 
				echo form_dropdown($workIndustryName, $workIndustryList, $workIndustryVal ,'id="blogIndustry"','class="single"');
				echo form_error($blogIndustry['name']); 
				echo isset($errors[$blogIndustry['name']])?$errors[$blogIndustry['name']]:''; ?>
		</div>
	</div><!--from_element_wrapper-->

	<div class="row">
		<div class="label_wrapper cell">
			<label><?php echo $label['blogSelectLanguage']; ?></label>
		</div><!--label_wrapper-->
		<div class=" cell frm_element_wrapper">
			<?php
				$blogLanguageName = "blogLanguage";
				if($blogLanguage['value'] =='')
				$blogLanguageVal = 1;
				else
				$blogLanguageVal = $blogLanguage['value'];
			
				echo form_dropdown($blogLanguageName, $workLang, $blogLanguageVal ,'id="blogLanguage"','class="single"');
				echo form_error($blogLanguage['name']);  
				echo isset($errors[$blogLanguage['name']])?$errors[$blogLanguage['name']]:''; 
			?>
		</div>
	</div><!--from_element_wrapper-->

	<div class="row">
		<div class="empty_label_wrapper cell"></div>
		<!--label_wrapper-->
		<div class=" cell frm_element_wrapper ">
			 <div class="checkbox">
			 <?php echo form_checkbox($blogToDonate);?>
			</div>
			 <?php echo $label['blogToDonate']; ?>
		</div>
	</div><!--from_element_wrapper-->

	<div class="row">
		<div class="empty_label_wrapper cell"></div>
		<!--label_wrapper-->
		<div class=" cell frm_element_wrapper ">
			<div class="checkbox">
			<?php echo form_checkbox($blogToShareOn);?>
			</div>
			<?php echo $label['blogToShareOn'];?>
		</div>
	</div><!--from_element_wrapper-->

	<div class="row">
		<div class="label_wrapper cell">
			<label> <?php echo $label['blogWishToShareOn']; ?></label>
		</div><!--label_wrapper-->
		<div class=" cell frm_element_wrapper ">
			<div class="cell mr10"><div class="checkbox"><?php echo form_checkbox($blogToTwitter); ?></div><?php echo $label['blogTwitter'];?></div>
			<div class="cell mr10"><div class="checkbox"><?php echo form_checkbox($blogToFacebook);?></div><?php echo $label['blogFacebook'];?></div>
		</div>
	</div><!--from_element_wrapper-->

	<div class="row">
		<div class="label_wrapper cell">
			<label><?php echo $label['blogCreatedFor'];?></label>
		</div><!--label_wrapper-->
		<div class=" cell frm_element_wrapper ">
			 <div class="cell"><div class="radio"><?php echo form_radio($blogForChildren);?></div></div> <div class="cell mr10 mt5" style="line-height:24px;">Children</div>
			 <div class="cell"><div class="radio"><?php echo form_radio($blogForAdult); ?></div></div> <div class="cell mr10 mt5" style="line-height:24px;">Adult</div>
			 <div class="cell"><div class="radio"><?php  echo form_radio($blogForAll); ?></div></div> <div class="cell mr10 mt5" style="line-height:24px;">All</div>
		</div>
	</div><!--from_element_wrapper-->
	
	
	<?php 
		//This shows add more category form
		echo Modules::run("blog/addCat",$blogId);
	?>
	
	<div class="seprator_27 row"></div>

	<div class="row">
		<div class="label_wrapper cell bg-non"></div><!--label_wrapper-->
		<div class=" cell frm_element_wrapper">
			<div class="Req_fld cell"><?php echo $label['requiredFields'];?></div><!--Req_fld-->
			<input type="hidden" name="submit" value="" />
			<div class="frm_btn_wrapper padding-right0">
				
				<button class="tds-button Fleft" onclick="submitform();">					
					<a href="javascript:void(0);" id="checkSave"><span>Save<div class="icon-save-btn"></div></span></a>										
				</button>
				<div class="seprator_5 cell"></div>
			</div>
		</div>
	</div><!--from_element_wrapper-->
	<?php echo form_close(); ?>
</div>

<?php $catLimit =10;?>
<script type="text/javascript"> 
		
			

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
			if (needToConfirm && document.blog.submit.value!='Save')
			{
				return "Do you want to save the modification before leaving the page.";
			} 
		}
	  }
	  else{
			if (needToConfirm && document.blog.submit.value!='Save')
            {
               return "Do you want to save the modification before leaving the page.";
            }
			else return null;		
			}
	  }	
	  
 });

function submitform()
{
    document.blog.submit.value= 'Save'; 
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
