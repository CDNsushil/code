<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php
$PostIdToShow =  $this->uri->segment(4);
if($PostIdToShow !=''){
	$setBackPostId = array('postId' => $PostIdToShow);
	$this->session->set_userdata($setBackPostId);	
}

if(isset($PostIdToShow) && $PostIdToShow>0) $postLabel = $label['createPost'];
else $postLabel = $label['newPost'];
?>

<script type="text/javascript">
var cursorpos;

bkLib.onDomLoaded(function() {
   //var myNicEditor = new nicEditor({buttonList : ['html','save','bold','italic','underline','left','center','right','justify','ol','ul','fontSize','fontFamily','fontFormat','indent','outdent','subscript','superscript','strikethrough','removeformat','hr','image','link','unlink','forecolor','xhtml']});
   
  var myNicEditor = new nicEditor({buttonList : ['html','save','bold','italic','underline','left','center','right','justify','ol','ul','fontSize','indent','outdent','strikethrough','removeformat','hr','image','link','unlink']});
  
  myNicEditor.setPanel('myNicPanel');
  
  myNicEditor.addInstance('myInstance1');
});

$(document).ready(function(){

$('.galleryImg').click(function() {

	var par = window.document;
	
	var new_img = par.createElement('img');
	
	new_img.src = $(this).attr('src');
	
	var showimg = $(this).attr('name');
		
	var newPath = new_img.src.substring(0, new_img.src.lastIndexOf('/'));
	
	var medium_image_name = newPath+'/'+showimg;
	new_img.src = medium_image_name;
	$('#myInstance1').append(new_img);
	$('#postViewGalleryBoxWp').trigger('close');
});

$('#myInstance1').click(function() { var A=arguments;
	var divsel = window.getSelection();
	var divrange = divsel.getRangeAt(0);
	cursorPos =  divsel.anchorOffset;
	var cursorpos = $('#divpotoinsert').attr({ value:cursorPos });
});
});

function isOrContainsNode(ancestor, descendant) {   
	var node = descendant;
    while (node) {
        if (node === ancestor) {
            return true;
        }
        node = node.parentNode;
    }
    return false;
}

function insertNodeOverSelection(node, containerNode,imgI) {
    var sel, range, html, str;

    if (window.getSelection) {
        sel = window.getSelection();
	var cursorValue = document.getElementById('divpotoinsert').value;
        if (sel.getRangeAt && sel.rangeCount) {
            range = sel.getRangeAt(0);

			if (isOrContainsNode(containerNode, cursorValue)) {			
                range.deleteContents();
				range.selectNode(document.getElementById("myInstance1").item(cursorValue));
                range.insertNode(node);
            } else {			
                containerNode.appendChild(node);
            }
        }
    } else if (document.selection && document.selection.createRange) {
        range = document.selection.createRange();
        if (isOrContainsNode(containerNode, range.parentElement())) {
            html = (node.nodeType == 3) ? node.data : node.outerHTML;
            range.pasteHTML(html);
        } else {
            containerNode.appendChild(node);
        }
    }
	$('#postViewGalleryBoxWp').trigger('close');
}
</script>
<!---->
<!---->

<!-- Loaded the Gallery Images -->
<div id="postViewGalleryBoxWp" class="customAlert" style="display:none; width:500px; padding:19px 5px 19px 19px; height:auto; border:1px solid #999999; background-color:#FFFFFF;">
	<div id="close-postViewGalleryBox" title="Close it" class="tip-tr close-customAlert"></div>			
	<?php echo Modules::run("blog/viewGallery"); ?>
</div>
<?php

$formAttributes = array(
	'name'=>'mypost',
	'id'=>'customForm',
);
$postTitle = array(
	'name'	=> 'postTitle',
	'id'	=> 'postTitle',
	'value'	=> set_value('postTitle',$values['postTitle']),
	'maxlength'	=> 160,
	'size'	=> 30,
	'class'       => 'formTip frm_Bdr required',
	'title'       => 'Post Title',
);

$postTagWords = array(
	'name'	=> 'postTagWords',
	'id'	=> 'postTagWords',
	'value'	=> set_value('postTagWords',$values['postTagWords']),	
	'class'       => 'frm_Bdr heightAuto rz formTip required',
	'title'       => 'Post Tag Words',
	'rows'	=> 2,
	'wordlength'=>"5,50",
	'onkeyup'=>"checkWordLen(this,50,'tagLimit')",
	
);

$postShortDesc = array(
	'name'	=> 'postOneLineDesc',
	'id'	=> 'postOneLineDesc',
	'class'	=> 'frm_Bdr heightAuto rz formTip required',
	'title'=>  'Post Description',
	'value'	=>  set_value('postOneLineDesc',$values['postOneLineDesc']),
	'wordlength'=>"15,100",
	'onkeyup'=>"checkWordLen(this,100,'descriptionLimit')",
	'placeholder'	=> 'Add short description here. ( 15-100 words )',
	'rows'	=> 2,
);

$postDesc = array(
	'name'	=> 'postDesc',
	'id'	=> 'postDesc',
	'value'	=> set_value('postDesc',$values['postDesc']),
	'size'	=> 30,
	'cols' => 70,
	'rows' => 20,
	'class'       => 'formTip textarea  frm_Bdr required',
	'style' => 'border: 1px solid #A0A0A0;outline: 3px solid #E1E1E1; display:none;',
	'title'       => 'Post Description',
);

$blogSelectCat = array(
	'name'	=> 'blogCategoryId',
	'id'	=> 'blogCategoryId',
	'value'	=> set_value('blogCategoryId',$values['blogCategoryId']),
	'maxlength'	=> 80,
	'size'	=> 30,
	'class'       => 'formTip single',
	'title'       => 'Select Category',
);
echo form_open_multipart('blog/postForm',$formAttributes);
echo form_hidden('blogId',$values['blogId']);

if(isset($values['postId']))
	echo form_hidden('postId',$values['postId']); 
	 
//////////////////POST IMAGE FILE ID////////////////
if(isset($values['postFileId']))
	$postFileId = $values['postFileId'];
else
	$postFileId = 0;
	
if(isset($postFileId))
	echo form_hidden('postFileId',$postFileId);
/////////////////////////////////////////////////////	  	

echo form_hidden('custId',$values['custId']); //This should be static for now but it becomes dynamic when login functionality is activated.

?>
<div class="row form_wrapper">
	<div class="cell shadow_wp strip_absolute"><!-- <img src="images/strip_blog.png"  border="0"/>-->
		<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
		<td height="271">	<img src="<?php echo base_url('images/shadow-top.png')?>"/></td>
		</tr>
		<tr>
		<td class="shadow_mid">&nbsp;</td>
		</tr>
		<tr>
		<td height="271"><img src="<?php echo base_url('images/shadow-bottom.png')?>"/></td>
		</tr>
		</table>
	 <div class="clear"></div>
	</div>
	
	<div class="row">
		<div class="cell frm_heading">
			<h1><?=$postLabel;?></h1>
		</div>
		<?php echo Modules::run("blog/navigationMenu"); ?>		
	</div>
	
	<div class="row line1"></div>	
	
	<div class="row">
		<div class="row seprator_27"></div>
		<div class="label_wrapper cell">
			<label class="select_field"><?php echo $label['posts'].' '.$label['image']  ?></label>
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
			<label class="select_field">Title</label>
		</div><!--label_wrapper-->

		<div class="cell frm_element_wrapper">
			<?php echo form_input($postTitle); ?>
			<div class="row wordcounter">
				<?php echo form_error($postTitle['name']); ?>
				<?php echo isset($errors[$postTitle['name']])?$errors[$postTitle['name']]:''; ?>
			</div>
		</div>
	</div><!--from_element_wrapper-->  
	<?php 
			$value=$postShortDesc['value']?$postShortDesc['value']:@$values['postOneLineDesc'];
			$value=htmlentities($value);
			$data=array('name'=>'postOneLineDesc','value'=>$value, 'view'=>'oneline_description');
			echo Modules::run("common/formInputField",$data);
	?>

	<?php 
			$value=$postTagWords['value']?$postTagWords['value']:@$values['postTagWords'];
			$value=htmlentities($value);
			$data=array('name'=>'postTagWords','value'=>$value, 'view'=>'tag_words');
			echo Modules::run("common/formInputField",$data);
	?>
	

	<?php
	$catName = "blogCategoryId";
	if($values['blogCategoryId'] =='')
	$catVal = 1;
	else
	$catVal = $values['blogCategoryId'];
	?>

	<div class="row">
		<div class="label_wrapper cell">
			<label>Category</label>
		</div><!--label_wrapper-->
		<div class=" cell frm_element_wrapper">
			<div class="Bdr2">
				<div class="bg_sel"> 
					<span class="abc"><?php echo $label['blogSelectCat'];?></span>
					<?php echo form_dropdown($catName, $catList, $catVal ,'id="blogCategoryId"','class="single"');?>
				</div><!--bg_sel-->
			</div>
			<?php echo form_error($blogSelectCat['name']); ?>
			<?php echo isset($errors[$blogSelectCat['name']])?$errors[$blogSelectCat['name']]:''; ?>
		</div>
	</div><!--from_element_wrapper-->

	<div class="row">
		<div class="label_wrapper cell">
			<label class="select_field">Post</label>
		</div><!--label_wrapper-->

		<div class=" cell frm_element_wrapper">
			<div class="sales_infmn" style="padding:0px;">
				<div id="myNicPanel" style="width: 543px;">
					<div onclick="javascript:showgallery();" id="mediagallery" style="float:left; margin-left:430px; margin-top:5px; position:absolute;" class="formTip" title="Insert Media">
					</div>
				</div>
				<div id="myInstance1" class="editordiv frm_Bdr" style="width:520px">
					<?php echo html_entity_decode($postDesc['value']);?>
				</div>
				<?php echo form_textarea($postDesc); ?>
				<?php echo form_error($postDesc['name']); ?>
			<?php echo isset($errors[$postDesc['name']])?$errors[$postDesc['name']]:''; ?>
			</div>
		</div>
	</div><!--from_element_wrapper-->

	<div class="seprator_27 row"></div>

	<div class="row">
		<div class="label_wrapper cell bg-non"></div><!--label_wrapper-->
		<div class=" cell frm_element_wrapper">
			<div class="Req_fld cell"><?php echo $label['requiredFields'];?></div><!--Req_fld-->

			<input type="hidden" id="divpotoinsert" name="divpotoinsert" value="" />
			<input type="hidden" name="embedgalleryId" id="embedgalleryId" value="" />
			
<?php /*
			<div class="frm_btn_wrapper padding-right0">
				 <div class="tds-button Fleft"> <button type="submit" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)"><span><div class="Fleft">Save</div> <div class="icon-save-btn"></div> </span> </button>  </div>
                 <div class="tds-button Fleft"><button type="button" onclick="postpreview();" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)"><span><div class="Fleft">Preview</div> <div class="icon-publish-btn"></div></span> </button> </div>
				<div class="seprator_5 cell"></div>
			</div>
			* */
?>
				<div class="frm_btn_wrapper padding-right0">
				 <div class="tds-button Fleft"><button name="save" value="Save" type="submit" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)" onclick="submitform();" ><span><div class="Fleft">Save</div> <div class="icon-save-btn"></div> </span> </button>  </div>
                 <div class="tds-button Fleft"><button type="button" onclick="postpreview();" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)"><span><div class="Fleft">Preview</div> <div class="icon-publish-btn"></div></span> </button> </div>
				<div class="seprator_5 cell"></div>
			</div>
		</div>
	</div><!--from_element_wrapper-->
</form>
	<!--postPreviewBoxWp START-->
	<div id="postPreviewBoxWp" class="postPreviewBoxWp" style="display:none;">
		<div id="close-postPreviewBox" title="Close it" class="tip-tr close-customAlert"></div>			
		<div class="postPreviewFormContainer" id="postPreviewFormContainer">
		<?php 
					//This shows posts related with blog
					echo Modules::run("blog/previewPostNew"); 
		?>	
		</div>
	</div>

</div>

<script>


$('.Left_side_menu ul li a').click(function(){
										   
		$(this).parent().addClass('LSM_select ');	
		$(this).parent().siblings().removeClass('LSM_select ');
		
		 })



$('.Main_btn_right a').click(function(){
						
		$(this).parent().parent().parent().addClass('Main_select ');
		$(this).parent().parent().parent().siblings().removeClass('Main_select ');
	 })
		
		
$('select').each(function(){
		var str = $(this).val();
		
		 $(this).parent().find('.abc').text(str );
	});	
	
		$('select').keyup(function(){
		var str = $(this).val();
		
		 $(this).parent().find('.abc').text(str );
	});
		
						   
	$('select').change(function(){
		var singleValues = $(this).val();	
		 $(this).parent().find('.abc').text(singleValues );
	});
</script>

<script type="text/javascript">

$(document).ready(function()
{	
	var needToConfirm = false;
	var ua = $.browser;
	var flag = 0;		

		$("select,input,textarea").change(function ()
        {
            needToConfirm = true;
        });		

  		window.onbeforeunload = function() {
   
			if(ua.msie){ 
				if(needToConfirm == true){
					if (needToConfirm && document.mypost.save.value!='Save')
					{
						return "Do you want to save the modification before leaving the page.";
					} 
				}
			}
			else{
				if (needToConfirm && document.mypost.save.value !='Save')
				{
					return "Do you want to save the modification before leaving the page.";
				}
				else return null;	
			}		
		}
});

function submitform()
{
	//This is done to pass the div value of Nic Editor to textarea to get posted through form
		var divContent = $('#myInstance1').html();		
		$('#postDesc').attr({ value:divContent }); 
	//End for editor value
	document.mypost.save.value= 'Save'; 
    document.mypost.submit();  
}

function showgallery()
{
	$("#postViewGalleryBoxWp").lightbox_me('center:true');
}

function postpreview()
{
	$("#postPreviewBoxWp").lightbox_me('center:true');
	$('#previewPostTitle').text($("#postTitle").val()); 
	
	//This is done to pass the div value of Nic Editor to textarea to get posted through form
	var divContent = $('#myInstance1').html();
	
	//End for editor value
	$('#previewPostDescription').html(divContent);
}

</script>

