<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$continerSize=isset($values->containerSize)?$values->containerSize:$this->config->item('defaultContainerSize');
$continerSize=bytestoMB($continerSize,'mb');
$dirname=$dirUploadMedia;
$dirSize=bytestoMB(getFolderSize($dirname),'mb');
$reminingSize=($continerSize-$dirSize);
if($reminingSize < 0){
		$reminingSize = 0;
}
$dirSize = number_format($dirSize,2,'.','');
$reminingBytes = mbToBytes($reminingSize,'mb');
$reminingSize = number_format($reminingSize,2,'.','');
$fileMaxSize=$reminingBytes;
/* First save Blog popup Start*/
	$isShowBlogPopup=$this->session->userdata('isShowBlogPopup');
	if(isset($isShowBlogPopup) && $isShowBlogPopup==1){
		$this->session->unset_userdata('isShowBlogPopup');
		$blogUrl['indexUrl'] = site_url(lang()).'/blog';
		$blogUrl['popupSection'] = 'blog';
		$popup_media = $this->load->view('common/afterSavePopup',$blogUrl,true);
		?>
			<script>
				var popup_media = <?php echo json_encode($popup_media);?>;
				loadPopupData('popupBoxWp','popup_box',popup_media);
			</script>
		<?php
	}
/* First save Blog popup End*/
?>
<!--postGalleryBoxWp START-->
<div id="postGalleryBoxWp" class="postGalleryBoxWp" style="display:none;">
	<div id="close-postGalleryBox" title="" class="tip-tr close-customAlert"></div><!-- We have to define "id" in lightboxme-common.js -->
	<div class="postGalleryFormContainer" id="postGalleryFormContainer"></div>
</div>

<script type="text/javascript">

bkLib.onDomLoaded(function() {
  var myNicEditor = new nicEditor({buttonList : ['html','save','bold','italic','underline','left','center','right','justify','ol','ul','fontSize','fontFamily','indent','outdent','strikethrough','removeformat','hr','gallimage','link','unlink', 'mediaimage','image']});
  
  myNicEditor.setPanel('myNicPanel');  
  myNicEditor.addInstance('myInstance1');
});

</script>
<?php

	//if filepath is set for any of the post type it will show the respective image else show the no-image 
	$formAttributes = array(
		'name'=>'blog',
		'id'=>'blogForm'
	);

	$blogImgPath = array(
		'name'	=> 'blogImgPath',
		'id'	=> 'blogImgPath',
		'value'	=> set_value('blogImgPath',@$values->blogImgPath),
		'maxlength'	=> 80,
		'size'	=> 30,
		'class'       => 'formTip Bdr4',
		'title'       => 'Blog Image Path'
	);

	$blogTitle = array(
		'name'	=> 'blogTitle',
		'id'	=> 'blogTitle',
		'value'	=> set_value('blogTitle',@$values->blogTitle),
		'maxlength'	=> 80,
		'size'	=> 30,
		'class'  => 'formTip width556px required',
		'title'  => 'Blog Title'
	);

	$blogOneLineDesc = array(
		'name'	=> 'blogOneLineDesc',
		'id'	=> 'blogOneLineDesc',
		'value'	=> set_value('blogOneLineDesc',@$values->blogOneLineDesc),
		'cols' => 65,
		'rows' => 2,
		'class'  => 'rz formTip required',
		'title'  => 'One Line Description',
		'wordlength' => "15,100",
		'onkeyup' => "checkWordLen(this,100,'descLimit')"
	);

	$blogTagWords = array(
		'name'	=> 'blogTagWords',
		'id'	=> 'blogTagWords',
		'value'	=> set_value('blogTagWords',@$values->blogTagWords),
		'class'       => 'rz formTip required',
		'title'       => 'Tag Words',
		'cols' => 65,
		'rows' => 2,
		'wordlength'=>"5,50",
		'onkeyup'=>"checkWordLen(this,50,'tagLimit')"
		
	);
	
	$blogDesc = array(
	'name'	=> 'blogDesc',
	'id'	=> 'blogDesc',
	'value'	=> set_value('blogDesc',isset($values->blogDesc)?$values->blogDesc:''),
	'size'	=> 30,
	'cols' => 70,
	'rows' => 20,
	'class' => 'formTip textarea  frm_Bdr',
	'style' => 'border: 1px solid #A0A0A0;outline: 3px solid #E1E1E1; display:none;'
	);

	$blogIndustry = array(
		'name'	=> 'blogIndustry',
		'id'	=> 'blogIndustry',
		'value'	=> set_value('blogIndustry',@$values->blogIndustry),
		'size'	=> 30,
		'class'       => 'formTip single',
		'title'       => 'Select Industry'
	);

	$blogLanguage = array(
		'name'	=> 'blogLanguage',
		'id'	=> 'blogLanguage',
		'value'	=> set_value('blogLanguage',@$values->blogLanguage),
		'size'	=> 30,
		'class'       => 'formTip single',
		'title'       => 'Select Language'
	);

	$blogToDonate = array(
		'name'        => 'blogToDonate',
		'id'          => 'blogToDonate',
		'value'       => 'accept',
		'checked'     => @$values->blogToDonate =='t'?TRUE:FALSE,
		'class'       => 'formTip',
		'title'       => 'Ask For Donations'
	);

	$blogToShareOn = array(
		'name'        => 'blogToShareOn',
		'id'          => 'blogToShareOn',
		'value'       => 'accept',
		'checked'     => @$values->blogToShareOn =='t'?TRUE:FALSE,
		'class'       => 'formTip',
		'title'       => 'Share on'
	);

	$blogToTwitter = array(
		'name'        => 'blogToTwitter',
		'id'          => 'blogToTwitter',
		'value'       => 'accept',
		'checked'     => @$values->blogToTwitter =='t'?TRUE:FALSE,
		'class'       => 'formTip',
		'title'       => $this->lang->line('twitterblog')
	);
	
	$blogTwitterLink = array(
		'name'        => 'blogTwitterLink',
		'id'          => 'blogTwitterLink',
		'size'		  => 35,
		//'rel' =>	'twitter.com',
		//'class'		  => 'domain',
		'value'       => @$values->blogTwitterLink
	);
	
	$gototwitterurl = '';
	//If the twitter link is given then show the view button else not
	if(isset($values->blogTwitterLink) && $values->blogTwitterLink!='') {
		if (preg_match(('/^(http|https|www)/'),$values->blogTwitterLink)) 
			$gototwitterurl = $values->blogTwitterLink;
		else 
			$gototwitterurl = 'http://twitter.com/'.$values->blogTwitterLink;
		
		$showTwitButtonClass=''; 
		$attrTwitButton = array('onmousedown'=>'mouseup_tds_button(this)', 'onmouseup'=>'mouseup_tds_button(this)','onmouseover'=>'mouseup_tds_button(this)','onclick'=>'gototwit();');
	}
	else { 
		$showTwitButtonClass='dn';
		$attrTwitButton = array('onmousedown'=>'mouseup_tds_button(this)', 'onmouseup'=>'mouseup_tds_button(this)','onmouseover'=>'mouseup_tds_button(this)');
	}

	$blogToFacebook = array(
		'name'        => 'blogToFacebook',
		'id'          => 'blogToFacebook',
		'value'       => 'accept',
		'checked'     => @$values->blogToFacebook =='t'?TRUE:FALSE,
		'class'       => 'formTip',
		'title'       => 'For Facebook'
	);


	if(@$values->blogFor =='1') $checkedBlogForChildren =  TRUE;
	else $checkedBlogForChildren = FALSE;
	
	$blogForChildren = array(
		'name'        => 'blogFor',
		'id'          => 'blogFor',
		'value'       => '1',
		'checked'     => $checkedBlogForChildren,
		'class'       => 'formTip',
		'title'       => 'For Children'
	);

	if(@$values->blogFor =='2') $checkedBlogForAdult = TRUE;
	else $checkedBlogForAdult = FALSE;

	$blogForAdult = array(
		'name'        => 'blogFor',
		'id'          => 'blogFor',
		'value'       => '2',
		'checked'     => $checkedBlogForAdult,
		'class'       => 'formTip',
		'title'       => 'For Adult'
	);

	if(!isset($values->blogFor) && @$values->blogFor =='') $checkedBlogFor = TRUE;
	else if(@$values->blogFor =='3') $checkedBlogFor = TRUE;
	else $checkedBlogFor = FALSE;

	$blogForAll = array(
		'name'        => 'blogFor',
		'id'          => 'blogFor',
		'value'       => '3',
		'checked'     => $checkedBlogFor,
		'class'       => 'formTip',
		'title'       => 'For All'
	);

	if($this->uri->segment(4)) $blogId = $this->uri->segment(4);
	if(isset($values->blogId)) $blogId = @$values->blogId;

	// UPDATING NAVIGATION BASED ON CONDITION
	// IF USER IS ACCESSING BLOG SETTING FROM "EDIT POST"
	// ELSE IF USER IS ACCESSING BLOG SETTING PAGE AS DEFAULT OR 'NEW POST'
	$thisBlogId = (isset($values->blogId) && @$values->blogId>0)?@$values->blogId:0;
	$relocateId = array(
    'name'        => 'relocateId',
    'id'          => 'relocateId',
    'value'       => $thisBlogId,
    'type'		  => 'hidden'
	);	

	$thisFileId = (isset($values->fileId) && @$values->fileId>0)?@$values->fileId:0;
	$currentFileId  = array(
		'name'	=> 'fileId',
		'id'	=> 'fileId',
		'value'	=> $thisFileId ,	
		'type' =>'hidden'
	);
	
	$thisCustId = (isset($values->custId) && @$values->custId>0)?@$values->custId:0;
	$custId  = array(
		'name'	=> 'custId',
		'id'	=> 'custId',
		'value'	=> $thisCustId ,	
		'type' =>'hidden'
	);	
	
	$currentBlogId  = array(
		'name'	=> 'blogId',
		'id'	=> 'blogId',
		'value'	=> $thisBlogId ,	
		'type' =>'hidden'
	);
	
?>

<div class="row form_wrapper">		
	<div class="row">
		<div class="cell frm_heading">
			<h1><?php echo $label['aboutYourBlog'];?></h1>
		</div>
		<?php echo Modules::run("blog/navigationMenu"); ?>
	</div>	
<?php 
//LEFT SHADOW STRIP
	echo Modules::run("common/strip");
	echo form_open_multipart('blog/blogForm',$formAttributes); 

	echo form_input($currentBlogId);
	echo form_input($custId);
	echo form_input($currentFileId);
	echo form_input($relocateId); 
?>
<div class="row position_relative">

<div class="row">
<?php 	
	

	if(isset($values->filePath) &&  $values->filePath!='')
	{
		$imagePathForEvent = $values->filePath.$values->fileName;
		 $smallImg = addThumbFolder(@$imagePathForEvent,'_xs');
	}
	else $smallImg = '';
	$finalSmallImg = getImage($smallImg,$this->config->item('defaultImg'));
	$blogMediaSrc = '<img id="galImg_'.@$values->blogId.'" class="ma backgroundBlack"  src="'.$finalSmallImg.'" alt="'.@$values->blogTitle.'" />'."";
	$browseImgJs = '_showcaseImgJs';	
				
	$stockImageFlag = 0;	
	$norefresh = 1;
	$required = 0;
	$checksection = 'redirect';
	$imgext = '_m';
	
	$fileData=array('imgSrc'=>$finalSmallImg,'typeOfFile'=>1,'mediaFileTypes'=>$this->config->item('imageType'),'fileMaxSize'=>$fileMaxSize,'isEmbed'=>'f','fileName'=>'','fileSize'=>0,'filePath'=>$promoImagePath,'embedCode'=>'', 'required'=>'', 'label'=>$this->lang->line('coverImage'),'editFlag'=>0,'fileTypeFlag'=>0,'flag'=>1,'browseId'=>$browseImgJs,'imgload'=>1,'norefresh'=>0, 'view'=>'upload_ws_frm');
	echo Modules::run("common/formInputField",$fileData);


?>
</div>
	
<div class="seprator_40 row"></div>
	<div class="row">
		<div class="label_wrapper cell">
			<label class="select_field"><?php echo $label['title']; ?></label>
		</div><!--label_wrapper-->

		<div class="cell frm_element_wrapper">
			<?php echo form_input($blogTitle); ?>
			<?php echo form_error($blogTitle['name']); ?>
			<?php echo isset($errors[$blogTitle['name']])?$errors[$blogTitle['name']]:''; ?>
		</div>
	</div><!--row-->
	<?php 
			$value=$blogOneLineDesc['value']?$blogOneLineDesc['value']:@$values->postOneLineDesc;
			$value=htmlentities($value);
			$data=array('name'=>'blogOneLineDesc','value'=>$value, 'required'=>'required','labelText'=>'oneLineDescription','view'=>'oneline_description');
			echo Modules::run("common/formInputField",$data);

			$value=$blogTagWords['value']?$blogTagWords['value']:@$values->blogTagWords;
			$value=htmlentities($value);
			$data=array('name'=>'blogTagWords','id'=>'blogTagWords','value'=>$value, 'required'=>'required','labelText'=>'tagWords','view'=>'tag_words');
			echo Modules::run("common/formInputField",$data);
	?>
	<div class="seprator_10 row"></div>
	
	<!--Start Div of Descrition-->
	<div class="row">
		<div class="label_wrapper cell">
			<label><?php echo $label['blogDescription'];?></label>
		</div>
		<?php ?>
		<div class="cell frm_element_wrapper NIC">
			<div class="sales_infmn" style="padding:0px;">
				<div id="myNicPanel" class="cell bdr_e2e2e2 tmailtop_gradient p15 width525px"></div>
				<div id="myInstance1" class="editordiv frm_Bdr minHeight300px width535px">
					<?php echo htmlspecialchars_decode(stripslashes($blogDesc['value'])); ?>
				</div>
				<?php 
					echo form_textarea($blogDesc); 
					//echo form_error($blogDesc['name']); 
					//echo isset($errors[$blogDesc['name']])?$errors[$blogDesc['name']]:''; 
				?>
			</div>
			<div class="row"><div class="cell" ><?php echo $this->lang->line('postMediaMsg');?></div></div>
		</div>
	</div><!--End Div of Descrition-->
	<div class="seprator_40 row"></div>

	<?php
		$workIndustryName = "blogIndustry";
		$workIndustryVal = $blogIndustry['value'];
	?>
	<div class="row">
		<div class="label_wrapper cell">
			<label class="select_field"><?php echo $label['blogTheme']; ?></label>
		</div><!--label_wrapper-->
		<div class="cell frm_element_wrapper">			
			<?php 
				echo form_dropdown($workIndustryName, $workIndustryList, $workIndustryVal ,'id="blogIndustry" class="required"');
				echo form_error($blogIndustry['name']); 
				echo isset($errors[$blogIndustry['name']])?$errors[$blogIndustry['name']]:''; 
			?>
		</div>
	</div><!--row-->

	<div class="row">
		<div class="label_wrapper cell">
			<label class="select_field"><?php echo $label['blogLanguage']; ?></label>
		</div><!--label_wrapper-->
		<div class=" cell frm_element_wrapper">
			<?php
				$blogLanguageName = "blogLanguage";
				if($blogLanguage['value'] =='')	$blogLanguageVal = 1;
				else $blogLanguageVal = $blogLanguage['value'];
				
				echo form_dropdown($blogLanguageName, $workLang, $blogLanguageVal ,'id="blogLanguage" class="required"');
				echo form_error($blogLanguage['name']); 
				echo isset($errors[$blogLanguage['name']])?$errors[$blogLanguage['name']]:''; 
			?>
		</div>
	</div><!--row-->

	<div class="row">
		<div class="label_wrapper cell">
			<label><?php echo $label['donation'];?></label>
		</div><!--label_wrapper-->		
		<div class=" cell frm_element_wrapper lineHeight20px">
		 <div class="row mt5">
			<div class="defaultP">
			 <?php echo form_checkbox($blogToDonate);?>
			</div>	
			<label class="ml5"><?php echo $label['blogToDonate'];?></label> 		
		</div>
		</div>
	</div><!--row-->
	
	<div class="row">
		<div class="cell label_wrapper"><label class="select_field"><?php echo $label['selectRating'];?></label></div>
		<div class="cell frm_element_wrapper">
			<div class="formTip fl" id="ratingTypeList" title="<?php echo $this->lang->line('ratingMsg');?>">
				<?php 
				
					$ratingName = 'rating';
					$selectRating = @$values->rating;						
					
					if( ! $selectRating > 0){
						$selectRating = '';
					}
											
					echo form_dropdown($ratingName, $ratingList,$selectRating ,'id="rating" class="single required" ');
					
				?>
			</div>
			<div class="row wordcounter">
				<span class="tag_word_orange"><?php echo $this->lang->line('adultsMaterialNotAllowed');?></span>
			</div>
			<div class="row wordcounter"><?php echo form_error('selectRating'); ?></div>
		</div>
	</div> <!-- row -->
	<!--div class="row">
		<div class="label_wrapper cell">
			<label><?php //echo $label['twitterfeeds'];?></label>
		</div>
		<div class=" cell frm_element_wrapper lineHeight20px">
			<div class="row mt5">
				<div class="defaultP">
					<?php //echo form_checkbox($blogToShareOn);?>
				</div>
				<label  class="ml5"><?php //echo $label['twitterblog'];?></label>
			</div>			
		</div>
	</div--><!--row-->	
	<div class="row">
		<div class="label_wrapper cell mt10">
			<label><?php echo $label['addTwitterFeed']; ?></label>
		</div><!--label_wrapper-->
		<div class=" cell frm_element_wrapper lineHeight20px">
			<div class="row mt5">				
			<div class="cell mt10">
				<div class="cell">
					<div class="defaultP"><?php echo form_checkbox($blogToTwitter); ?></div>
				</div>				 
			</div>
			 <div class="cell ml10">
				 <div class="frm_btn_wrapper"><?php echo form_input($blogTwitterLink);?>
				 <label  class="ml15 <?php echo $showTwitButtonClass;?>">
					 <div class="tds-button fr mr5 dash_link_hover"><?php echo anchor('javascript://void(0);','<span class="dash_link_hover">'.$this->lang->line('view').'</span>',$attrTwitButton);?></div>
				 </label>
			</div>
			</div>
			
				 <!--div class="cell"><div class="defaultP"><?php echo form_checkbox($blogToFacebook);?></div><label  class="ml5"><?php echo $label['blogFacebook'];?></label></div-->
			</div>
		</div>
	</div><!--from_element_wrapper-->
<?php
/*
Client req 6 aug 2012

	<div class="row">
		<div class="label_wrapper cell">
			<label><?php echo $label['blogCreatedFor'];?></label>
		</div><!--label_wrapper-->
		<div class=" cell frm_element_wrapper ">
			 <div class="row mt5">
			 <div class="cell"><div class="defaultP"><?php echo form_radio($blogForChildren);?></div></div> <div class="cell mr10"><label class="ml5">Children</label></div>
			 <div class="cell"><div class="defaultP"><?php echo form_radio($blogForAdult); ?></div></div> <div class="cell mr10"><label  class="ml5">Adult</label></div>
			 <div class="cell"><div class="defaultP"><?php  echo form_radio($blogForAll); ?></div></div> <div class="cell mr10"><label  class="ml5">All</label></div>
			 </div>
		</div>
	</div><!--row-->
	*/
?>	
	
	<?php 
	if(isset($blogId) && $blogId!='' && $blogId>0)
	{
		echo '<div class="seprator_40 row"></div>';
		//This shows add more category form		
		echo Modules::run("blog/addCat",$blogId);
	}
	?>	
	<div class="row">
		<div class="label_wrapper cell bg-non "></div><!--label_wrapper-->
		<div class=" cell frm_element_wrapper pagingWrapper">
			<div class="Req_fld cell"><?php echo $label['requiredFields'];?></div><!--Req_fld-->
			<input type="hidden" name="submit" value="" />
			<div class="frm_btn_wrapper padding-right0 ">				
				 <!--div class="tds-button Fleft"><button id="checkSave" type="submit" name="submit" value="Save" onclick="submitform();" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)"><span><div class="Fleft"><?php echo $this->lang->line('save');?></div><div class="icon-save-btn"></div></span></button></div-->
			<?php			
				$button=array('ajaxSave');
				echo Modules::run("common/loadButtons",$button); 
			 ?>		
			
			</div>
			<div class="row"><div class="cell">*&nbsp;</div><div class="cell" ><?php echo $this->lang->line('descReqFieldMsg');?></div></div>
			<?php 
			if(isset($blogId) && $blogId!='' && $blogId>0)
			{ ?>
			<div class="row makeShowcaseBetter">
				<div class="cell">*&nbsp;</div><div class="cell" ><?php echo $this->lang->line('previewPublishInfoChange');?>
				<a href="<?php echo site_url(lang()).'/blog';?>" target="_blank">Index page</a>.</div>
			</div>
		<?php }?>
		</div>
	</div><!--row-->
	<div class="seprator_55 row"></div>
	<div class="clear"></div>
	</div>
	<?php echo form_close(); ?>
</div>
<?php 

if(!isset($browseImgJs)){ $browseImgJs=''; }
	$fileImg="fileInput".@$browseImgJs;
	$fileNameImage="fileName".@$browseImgJs;
	$catLimit =10;
?>
<script type="text/javascript"> 

$("#blogForm").validate({
	groups: {
			myInstance1: "myInstance1"
		},
		errorPlacement: function(error, element) {
			if (element.attr("id") == "myInstance1" )
				error.insertAfter("#errorMyInstance1");
			else
				error.insertAfter(element);
		},
		rules: {
			myInstance1: {
				required: true				
			}
		},	
	submitHandler: function() {
		
		var elementId = $('#blogId').val();
		var fileId = $('#fileId').val();
		var imagePath = '<?php echo $promoImagePath;?>';
		var fileSize=$('#fileSize<?php echo $browseImgJs?>').val();
	
		var blogToDonate = $('#blogToDonate:checked').val()?'t':'f'; 
		var blogToShareOn = $('#blogToShareOn:checked').val()?'t':'f'; 
		var blogToTwitter = $('#blogToTwitter:checked').val()?'t':'f'; 
		//var blogTwitterLink = $('#blogToTwitter:checked').val()?'t':'f'; 
		var blogFor = $('#blogFor:checked').val()?$('#blogFor').val():'0'; 	
	
		var countryId = $('#Country').val()?$('#Country').val():0;
		var OrgCountryId = $('#OrgCountry').val()?$('#OrgCountry').val():0;
		var rating = $('#rating').val()?$('#rating').val():0;
		
		var divContent =$('#myInstance1').html();	
		
		$('#blogDesc').attr({ value:divContent }); 
		
		if($('#fileInput<?php echo $browseImgJs;?>').val()!='')
		{				
			var imgData = {"filePath":imagePath,"rawFileName":$('#fileInput<?php echo $browseImgJs;?>').val(),"fileName":$('#fileName<?php echo $browseImgJs;?>').val(),"fileSize":fileSize,"fileType":"1","isExternal":'f',"fileCreateDate":'<?php echo date('Y-m-d h:i:s'); ?>',"tdsUid":<?php echo isLoginUser(); ?>};
		}
		else
		{
			var imgData = '';
		}	
		
		if(elementId ==0)
			var data = {"blogTitle":$('#blogTitle').val(),"blogOneLineDesc":$('#blogOneLineDesc').val(),"blogTagWords":$('#blogTagWords').val(),"blogDesc":divContent,"blogIndustry":$('#blogIndustry').val(),"blogLanguage":$('#blogLanguage').val(),"blogTwitterLink":$('#blogTwitterLink').val(),"blogToDonate":blogToDonate,"blogToTwitter":blogToTwitter,"rating":rating,"blogFor":blogFor,"custId":<?php echo isLoginUser(); ?>,"dateCreated":'<?php echo date('Y-m-d h:i:s'); ?>',"dateModified":'<?php echo date('Y-m-d h:i:s'); ?>',"isPublished":'f'}; 
		else
			var data = {"blogId":elementId,"blogTitle":$('#blogTitle').val(),"blogOneLineDesc":$('#blogOneLineDesc').val(),"blogTagWords":$('#blogTagWords').val(),"blogDesc":divContent,"blogIndustry":$('#blogIndustry').val(),"blogLanguage":$('#blogLanguage').val(),"blogTwitterLink":$('#blogTwitterLink').val(),"rating":rating,"blogToDonate":blogToDonate,"blogToTwitter":blogToTwitter,"blogToShareOn":blogToShareOn,"blogToShareOn":blogToShareOn,"custId":<?php echo isLoginUser(); ?>,"dateModified":'<?php echo date('Y-m-d h:i:s'); ?>'}; 
		
		if($('#fileError<?php echo @$browseImgJs;?>').text()=='')
		var returnFlag = AJAX_json('<?php echo base_url(lang()."/blog/blogjquerysave");?>','',elementId,data,fileId,imgData,'blogId');
		//alert(returnFlag.id);
		if(returnFlag)
		{			
			var returnform = baseUrl+language+'/blog/blogForm/';				
			$('#relocateId').attr('value',returnform);
			$("#uploadFileByJquery<?php echo $browseImgJs;?>").click();
			$('#messageSuccessError').html('<div class="successMsg"><?php echo $this->lang->line('msgSuccessfully');?> <?php echo $this->lang->line('updated');?></div>');
			timeout = setTimeout(hideDiv, 5000);
			
			if($('#fileName<?php echo $browseImgJs;?>').val() =='') { window.location.href = returnform;}				
			return true;
		}	
	}	
});


function gototwit()
{
	window.open(
	  '<?php echo $gototwitterurl?>',
	  '_blank' // <- This is what makes it open in a new window.
	);
}

$('#myInstance1').keyup(function() {
	var descVal = $('#myInstance1').val();
	checkWordLen(descVal,600,'descLimitBlog')
});

</script>
