<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php
$PostIdToShow =  $this->uri->segment(4);
if($PostIdToShow !=''){
	$setBackPostId = array('postId' => $PostIdToShow);
	$this->session->set_userdata($setBackPostId);	
}

if(isset($PostIdToShow) && $PostIdToShow>0  && (strcmp($this->uri->segment(3),'postForm')==0)) $postLabel = $label['editPost'];
else $postLabel = $label['newPost'];

?>

<script type="text/javascript">
var cursorpos;

bkLib.onDomLoaded(function() {
   //var myNicEditor = new nicEditor({buttonList : ['html','save','bold','italic','underline','left','center','right','justify','ol','ul','fontSize','fontFamily','fontFormat','indent','outdent','subscript','superscript','strikethrough','removeformat','hr','image','link','unlink','forecolor','xhtml']});
   
   var myNicEditor = new nicEditor({buttonList : ['html','save','bold','italic','underline','left','center','right','justify','ol','ul','fontSize','indent','outdent','strikethrough','removeformat','hr','image','link','unlink', 'mediaimage','gallimage']});
  
  myNicEditor.setPanel('myNicPanel');
  
  myNicEditor.addInstance('myInstance1');
});

</script>

<!-- Loaded the Gallery Images -->
<div id="postViewGalleryBoxWp" class="customAlert" style="display:none; width:500px; padding:19px 5px 19px 19px; height:auto; border:1px solid #999999; background-color:#FFFFFF;">
	<div id="close-postViewGalleryBox" title="Close it" class="tip-tr close-customAlert"></div>			
	<?php echo Modules::run("blogshowcase/viewGallery"); ?>
</div>
<?php

$formAttributes = array(
	'name'=>'mypost',
	'id'=>'postForm',
);

$postTitle = array(
	'name'	=> 'postTitle',
	'id'	=> 'postTitle',
	'value'	=> set_value('postTitle',$values['postTitle']),
	'maxlength'	=> 160,
	'size'	=> 30,
	'class'       => 'formTip frm_Bdr required width556px'
);

$postTagWords = array(
	'name'	=> 'postTagWords',
	'id'	=> 'postTagWords',
	'value'	=> set_value('postTagWords',$values['postTagWords']),	
	'class'       => 'frm_Bdr heightAuto rz formTip required',
	'title'       => 'Post Tag Words',
	'rows'	=> 2,
	'wordlength'=>"5,50",
	'onkeyup'=>"checkWordLen(this,50,'tagLimit')"	
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
	'rows'	=> 2
);

$postDesc = array(
	'name'	=> 'postDesc',
	'id'	=> 'postDesc',
	'value'	=> set_value('postDesc',$values['postDesc']),
	'size'	=> 30,
	'cols' => 70,
	'rows' => 20,
	'class'       => 'formTip textarea  frm_Bdr',
	'style' => 'border: 1px solid #A0A0A0;outline: 3px solid #E1E1E1; display:none;'
);

$blogSelectCat = array(
	'name'	=> 'blogCategoryId',
	'id'	=> 'blogCategoryId',
	'value'	=> set_value('blogCategoryId',$values['blogCategoryId']),
	'maxlength'	=> 80,
	'size'	=> 30,
	'class'       => 'formTip single',
	'title'       => 'Select Category'
);

echo form_open_multipart('blog/postForm',$formAttributes);

$thisPostId = (isset($values['postId']) && @$values['postId']>0)?@$values['postId']:0;
$relocateId = array(
'name'        => 'relocateId',
'id'          => 'relocateId',
'value'       => $thisPostId,
'type'		  => 'hidden'
);	

$thisPostFileId = (isset($values['postFileId']) && @$values['postFileId']>0)?@$values['postFileId']:0;
$currentPostFileId  = array(
'name'	=> 'postFileId',
'id'	=> 'postFileId',
'value'	=> $thisPostFileId ,	
'type' =>'hidden'
);

$thisCustId = (isset($values['custId']) && @$values['custId']>0)?@$values['custId']:0;
$custId  = array(
'name'	=> 'custId',
'id'	=> 'custId',
'value'	=> $thisCustId ,	
'type' =>'hidden'
);

$thisBlogId = (isset($values['blogId']) && @$values['blogId']>0)?@$values['blogId']:0;
$currentBlogId  = array(
'name'	=> 'blogId',
'id'	=> 'blogId',
'value'	=> $thisBlogId ,	
'type' =>'hidden'
);	

$currentPostId  = array(
'name'	=> 'postId',
'id'	=> 'postId',
'value'	=> $thisPostId ,	
'type' =>'hidden'
);

echo form_input($currentPostId);
echo form_input($currentBlogId);
echo form_input($custId);
echo form_input($currentPostFileId);
echo form_input($relocateId);
	
?>

<div class="row form_wrapper">

	<div class="row">
		<div class="cell frm_heading">
			<h1><?=$postLabel;?></h1>
		</div>
		<?php // echo Modules::run("blog/navigationMenu"); ?>		
	</div>
	
	<div class="row position_relative">
<?php 
	
	//LEFT SHADOW STRIP
	echo Modules::run("common/strip");	
	
	if(!empty($parentPost->postId)) //Checking for parent post 	
	{
		$parentPostIdArr  = array(
		'name'	=> 'parentPostId',
		'id'	=> 'parentPostId',
		'value'	=> $parentPost->postId,	
		'type' =>'hidden'
		);

		echo form_input($parentPostIdArr);
			
?>		
		<div class="row"> 
			<div class="label_wrapper cell">
				<label class="select_field"><?php echo $label['parentPost'];?></label>
			</div><!--label_wrapper-->

			<div class="cell frm_element_wrapper post_sample_heading formTip" title="<?php echo $parentPost->postTitle;?>">
			
				<?php 				
				$restrictedPostTitle = getSubString($parentPost->postTitle,70);	
				echo $restrictedPostTitle; 				
				?>			
			</div>
			<div class="row clear"></div> 
		</div><!--from_element_wrapper--> 
		
<?php
	}

if(!isset($values['filePath']) || @$values['filePath']!='')
{
     $imagePathForEvent = @$values['filePath'].@$values['fileName'];
     $smallImg = addThumbFolder(@$imagePathForEvent,'_xs');
}
else $smallImg = '';

$finalSmallImg = getImage($smallImg,$this->config->item('defaultImg'));

//if filepath is set for any of the post type it will show the respective image else show the no-image 
$postMediaSrc = '<img class="maxWidth165px maxHeight120px ma backgroundBlack" src="'.$finalSmallImg.'">';

	$browseImgJs = '_showcaseImgJs';	
				
	$inputArray = array(
		'name'	=> 'fileInput',
		'class'	=> 'width300px fl',
		'value'	=> '',
		'id'	=> 'fileInput'.$browseImgJs,
		'type'	=> 'text',
		'readonly' => true
	);

	$fileUpload = array(
		'name'	=> 'userfile',
		'class'	=> 'btn_browse',
		'value'	=> '',
		'accept'=> $this->config->item('imageAccept'),
		'onchange'=> "$('#fileInput').val(this.value)",
		'onmousedown'=> "mousedown_tds_button(getElementById('browse_btn'));",
		'onmouseup'=> "mouseup_tds_button(getElementById('browse_btn'));"
	);
	
	$stockImageFlag = 0;	
	$norefresh = 1;
	$required = 0;
	$checksection = 'redirect';
	$imgext = '_s';

	echo Modules::run("mediatheme/promoImgFrmJs",$this->lang->line('image'),$postMediaSrc,$fileUpload,$inputArray,$browseImgJs,$stockImageFlag,$required,$norefresh,$checksection,$imgext);
	
	?>
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
			$data=array('name'=>'postOneLineDesc','value'=>$value, 'view'=>'oneline_description','required'=>'required');
			echo Modules::run("common/formInputField",$data);

			$value=$postTagWords['value']?$postTagWords['value']:@$values['postTagWords'];
			$value=htmlentities($value);
			$data=array('name'=>'postTagWords','value'=>$value, 'view'=>'tag_words','required'=>'required');
			echo Modules::run("common/formInputField",$data);
			
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
			<?php echo form_dropdown($catName, $catList, $catVal ,'id="blogCategoryId"','class="single"');?>				
			<?php echo form_error($blogSelectCat['name']); ?>
			<?php echo isset($errors[$blogSelectCat['name']])?$errors[$blogSelectCat['name']]:''; ?>
		</div>
	</div><!--from_element_wrapper-->

	<div class="row">
		<div class="label_wrapper cell">
			<label class="select_field">Post</label>
		</div><!--label_wrapper-->

		<div class=" cell frm_element_wrapper NIC">
			<div class="sales_infmn p0">
				<div id="myNicPanel" class=" width543px">
					<?php /*if($countGalImg>0){ ?>
					<div onclick="javascript:showgallery();" id="mediagallery" style="float:left; margin-left:430px; margin-top:5px; position:absolute;" class="formTip" title="Insert Media">
					</div>
					<?php } */?>
				</div>
				<div id="myInstance1" class="editordiv frm_Bdr width523px">
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
				
				<div class="frm_btn_wrapper padding-right0">
					 <!--div class="tds-button Fleft"><button name="save" value="Save" type="submit" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)" onclick="submitform();" ><span><div class="Fleft">Save</div> <div class="icon-save-btn"></div> </span> </button>  </div-->
					 <?php			
						$button=array('ajaxSave');
						echo Modules::run("common/loadButtons",$button); 
					?>	
					
					<div class="seprator_5 cell"></div>
				</div>
				<?php 
				if($thisPostId==0)
					echo '<div class="row height25"><div class="cell">*&nbsp;</div><div class="cell" >'.$this->lang->line('descReqFieldMsg').'</div></div>';
				else
					echo '<div class="row height25"><div class="cell">*&nbsp;</div><div class="cell" >'.$this->lang->line('allReqFieldMsg').'</div></div>';
				?>
			</div>
		</div><!--from_element_wrapper-->
</form>
</div><!--main row end-->
	<!--postPreviewBoxWp START-->
	<div id="postPreviewBoxWp" class="postPreviewBoxWp" style="display:none;">
		<div id="close-postPreviewBox" title="Close it" class="tip-tr close-customAlert"></div>			
		<div class="postPreviewFormContainer" id="postPreviewFormContainer">
		<?php 
					//This shows posts related with blog
					echo Modules::run("blogshowcase/previewPostNew"); 
		?>	
		</div>
	</div>
<div class="clear"></div>
</div>
<?php 

if(!isset($browseImgJs)){ $browseImgJs=''; }
	$fileImg="fileInput".@$browseImgJs;
	$fileNameImage="fileName".@$browseImgJs;
?>
<script>

function showgallery()
{
	$("#postViewGalleryBoxWp").lightbox_me('center:true');
}

function postpreview()
{
	$("#postPreviewBoxWp").lightbox_me('center:true');
	$('#previewPostTitle').text($("#postTitle").val()); 
	$('#previewPostTagWords').text($("#postTagWords").val());
	
	<?php	
	if($currentPostId == 0)
	{
	?>
		$('#previewPostedDate').text('<?php echo date("F d, Y");?>');		
	<?php
	}
	else
	{ 
	?>
		$('#previewPostedDate').text('<?php echo date("l F d  Y", strtotime($values['dateCreated']));?>');
	<?php
	}
	?>
	//alert('<?php echo $postMediaSrc;?>');
	$('#previewPostedImg').html('<?php echo $postMediaSrc;?>');
	//This is done to pass the div value of Nic Editor to textarea to get posted through form
	var divContent = $('#myInstance1').html();
	
	//End for editor value
	$('#previewPostDescription').html(divContent);
}

	
$("#postForm").validate({
	//ignore: '',
		groups: {
			postDesc: "postDesc"
		},
		rules: {
			postDesc: {
				required: true			
			}
		},
	submitHandler: function() {
		
		var elementId = $('#postId').val();
		var fileId = $('#postFileId').val();
		var imagePath = '<?php echo $postPath;?>';
		var fileSize=$('#fileSize<?php echo $browseImgJs?>').val();
		var parentPostId = $('#parentPostId').val()?$('#parentPostId').val():0;
		var blogCategoryId = $('#blogCategoryId').val()?$('#blogCategoryId').val():0;
		var divContent = $('#myInstance1').html();		
		$('#postDesc').attr({ value:divContent }); 
		if($('#<?php echo $fileImg;?>').val()!='')
		{				
			var imgData = {"filePath":imagePath,"rawFileName":$('#<?php echo $fileImg;?>').val(),"fileName":$('#<?php echo $fileNameImage;?>').val(),"fileSize":fileSize,"fileType":'1',"isExternal":'f',"fileCreateDate":'<?php echo date('Y-m-d h:i:s'); ?>',"tdsUid":<?php echo isLoginUser(); ?>};
		}
		else
		{
			var imgData = '';
		}	
		
		if(elementId ==0)
				var data = {"postTitle":$('#postTitle').val(),"parentPostId":$('#parentPostId').val(),"blogCategoryId":blogCategoryId,"postOneLineDesc":$('#postOneLineDesc').val(),"postTagWords":$('#postTagWords').val(),"postDesc":divContent,"custId":<?php echo isLoginUser(); ?>,"dateCreated":'<?php echo date('Y-m-d h:i:s'); ?>',"dateModified":'<?php echo date('Y-m-d h:i:s'); ?>'}; 
		else
				var data = {"postId":elementId,"parentPostId":$('#parentPostId').val(),"blogCategoryId":blogCategoryId,"postTitle":$('#postTitle').val(),"postOneLineDesc":$('#postOneLineDesc').val(),"postTagWords":$('#postTagWords').val(),"postDesc":divContent,"custId":<?php echo isLoginUser(); ?>,"dateModified":'<?php echo date('Y-m-d h:i:s'); ?>'}; 
		
		if($('#fileError<?php echo @$browseImgJs;?>').text()=='')
		var returnFlag = AJAX_json('<?php echo base_url(lang()."/blog/blogjquerysave");?>','',elementId,data,fileId,imgData,'postId',divContent);
		//alert(returnFlag.id);
		if(returnFlag){		
			var returnform = baseUrl+language+'/blogshowcase/frontPostDetail/'+<?php echo $parentPost->custId; ?>+'/'+parentPostId;	
			//alert(returnform);		
			$('#relocateId').attr('value',returnform);
			$("#uploadFileByJquery<?php echo $browseImgJs;?>").click();	
			if($('#fileName<?php echo $browseImgJs;?>').val() =='') 
			{
				window.location.href = returnform;
			}				
			$('#messageSuccessError').html('<div class="successMsg"><?php echo $this->lang->line('msgSuccessfully');?> <?php echo $this->lang->line('updated');?></div>');
			timeout = setTimeout(hideDiv, 5000);					
			return true;
		}	
	}	
		

});
</script>

