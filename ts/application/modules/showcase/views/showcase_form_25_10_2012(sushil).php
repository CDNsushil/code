<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<!--/* For video to play*/-->

<!------- Top Most Menu Buttons ------->   
<div class="contactBoxWp dn" id="contactBoxWp">
	<div id="contactContainer" class="contactContainer"></div>
</div>
<?php 

if(isset($values['showcaseId'])) $showcaseId = $values['showcaseId'];
else $showcaseId = 0;

?> 
<!------ End Of Top Menu ------->   
<?php
//echo '<pre />';print_r($values);
$formAttributes = array(
	'name'=>'showcaseForm',
	'id'=>'showcaseForm'
);

$firstName = array(
	'name'	=> 'firstName',
	'id'	=> 'firstName',
	'class' => 'frm_Bdr required width556px',
	'value'	=> set_value('firstName',@$values['firstName']),
	
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50
);

$lastName = array(
	'name'	=> 'lastName',
	'id'	=> 'lastName',
	'class' => 'frm_Bdr required width556px',
	'value'	=> set_value('lastName',@$values['lastName']),
	
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50
);

$enterpriseName = array(
	'name'	=> 'enterpriseName',
	'id'	=> 'enterpriseName',
	'class' => 'frm_Bdr required width556px',
	'value'	=> set_value('enterpriseName',@$values['enterpriseName']),
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50
);

$optionAreaName = array(
	'name'	=> 'optionAreaName',
	'id'	=> 'optionAreaName',
	'class' => 'frm_Bdr required width556px formTip',	
	'value'	=> set_value('optionAreaName',@$values['optionAreaName']),
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50
);

$tagwords = array(
	'name'	=> 'tagwords',
	'id'	=> 'tagwords',
	'class'	=> 'BdrCommonTextarea heightAuto rz  required error',
	'title'=>  $label['add'].' '.$this->lang->line('tagwords').' here'.$label['15_100_words'],
	'value'	=> set_value('tagwords',@$values['tagwords']),
	'minlength'	=> 15,
	'rows'	=> 5,
	'wordlength'=>"15,100",
	'onkeyup'=>"checkWordLen(this,100,'tagwordsLimit')"
);

$creativeFocus = array(
	'name'	=> 'creativeFocus',
	'id'	=> 'creativeFocus',
	'class'	=> 'BdrCommonTextarea heightAuto rz  required error',
	'title'=>  $label['add'].' '.$this->lang->line('onelinedescription').$label['10_50_words'],
	'value'	=> set_value('creativeFocus',@$values['creativeFocus']),
	'minlength'	=> 10,
	'rows'	=> 5,
	'wordlength'=>"10,50",
	'onkeyup'=>"checkWordLen(this,50,'creativeFocusLimit')"
);

$creativePath = array(
	'name'	=> 'creativePath',
	'id'	=> 'creativePath',
	'class'	=> 'BdrCommonTextarea heightAuto rz error clear:both; formTip',
	'value'	=> set_value('creativePath',@$values['creativePath']),
	
	'minlength'	=> 75,
	'rows'	=> 5,
	'wordlength'=>"75,500",
	'onkeyup'=>"checkWordLen(this,500,'creativePathLimit')"
);

$reviewMe = array(
    'name'        => 'reviewMe',
    'id'          => 'reviewMe',
    'value'       => 'accept',
    'checked'     => @$values['reviewMe'] =='t'?TRUE:FALSE,
    'class'	=> 'formTip',
	'title'       => $this->lang->line('toolTipReviewMe')
);

$recommendMe = array(
    'name'        => 'recommendMe',
    'id'          => 'recommendMe',
    'value'       => 'accept',
    'checked'     => @$values['recommendMe'] =='t'?TRUE:FALSE,
    'class'	=> 'formTip',
	'title'       => $this->lang->line('toolTipRecom')
);

$promotionalsection = array(
	'name'	=> 'promotionalsection',
	'id'	=> 'promotionalsection',
	'value'	=> set_value('promotionalsection',@$values['promotionalsection']),	
	'class' => 'required width546px',
	'style' => 'display:none;',
	'minlength'	=> 50,
	'maxlength'	=> 300,
	'rows'	=> 5
);

$sendNotificationtoCraved = array(
    'name'        => 'sendNotificationtoCraved',
    'id'          => 'sendNotificationtoCraved',
    'value'       => 'accept',
    'checked'     => @$values['sendNotificationtoCraved'] =='t'?TRUE:FALSE,
    'class'	=> 'formTip',
	'title' => $this->lang->line('sendNotToCravedToolTip')
);

$reviewMyMedia = array(
    'name'        => 'reviewMyMedia',
    'id'          => 'reviewMyMedia',
    'value'       => 'accept',
    'checked'     => @$values['reviewMyMedia'] =='t'?TRUE:FALSE,
    'class'	=> 'formTip',
	'title'       => $this->lang->line('toolTipRecNotWhn')
);

$contactMe = array(
    'name'        => 'memberReviewMe',
    'id'          => 'memberReviewMe',
    'value'       => 'accept',
    'checked'     => @$values['memberReviewMe'] =='t'?TRUE:FALSE,
    'class'	=> 'formTip',
	'title'       => $this->lang->line('toolTipContactMe')
);
  

$profileImage= '';

if(isset($introFileName))
{
	$firstIntroductoryVideoFile = $introFilePath.'/'.$introFileName;
	//$firstIntroductoryVideoFile =  getImage($introductoryVideoPath);
}

if(isset($interFileName))
{
	$firstInterviewVideoFile = $interFilePath.'/'.$interFileName;
	//echo $firstInterviewVideoFile =  getImage($interviewVideoPath);
	//$InterviewUploadedVideoPath = ROOTPATH.$interviewVideoPath;
}

?>
<!--stockImagesBoxWp START-->

<div id="stockImagesBoxWp" class="customAlert" style="display:none; width:550px; padding:19px 5px 19px 19px; height:auto; border:1px solid #999999; background-color:#FFFFFF;">
	<div id="close-stockImagesBox" title="Close it" class="tip-tr close-customAlert"></div><!-- We have to define "id" in lightboxme-common.js -->
	<div class="stockImagesFormContainer" id="stockImagesFormContainer">
		<?php echo Modules::run("showcase/viewStockImages",$showcaseId); ?> 
	</div>
</div>

<!--stockImagesBoxWp END-->

<!--showcasePreview START-->

<div id="showcasePreviewBoxWp" class="customAlert" style="display:none; width:850px;  width:auto; padding:19px 5px 19px 19px; height:auto; border:1px solid #999999; background-color:#FFFFFF;">
	<div id="close-showcasePreviewBox" title="Close it" class="tip-tr close-customAlert" onclick="$(this).parent().trigger('close');"></div><!-- We have to define "id" in lightboxme-common.js -->
	<div class="showcasePreviewFormContainer" id="showcasePreviewFormContainer"><?php //echo Modules::run("showcase/showcasePreview"); ?> </div>
</div>

<!--showcasePreview END-->

<!--interviewEmbedBoxWp END-->


<div class="row position_relative">	
<?php 
	//LEFT SHADOW STRIP
	echo Modules::run("common/strip");
?>
<?php echo form_open_multipart($this->uri->uri_string(),$formAttributes); 

//Defining label on the basis of saved values(creative,associatedProfessional,enterprise,artist)

	$defaultProfileImage = $this->config->item('defaultCreativeImg_s');	
	
	if($values['optionSelected']==1) 
	{
		$labelOption = $label['creative'].' '.$label['area'];
		$labelFocus =  'creativeFocus';
		$labelPath = 'creativePath';
		$enterpriseStyle =  'style="display:none;"';
		$defaultProfileImage = $this->config->item('defaultCreativeImg_s');
	}
	
	if($values['optionSelected']==2) 
	{
		$labelOption = $label['area'].' '.$label['ofInterest'];
		$labelFocus = 'associatedProfessionalFocus';
		$labelPath = 'associatedProfessionalPath';
		$enterpriseStyle =  'style="display:none;"';
		$defaultProfileImage = $this->config->item('defaultAssProfImg_s');
	}
	
	if($values['optionSelected']==3) 
	{
		$labelOption = $label['enterprise'].' '.$label['area'];
		$labelFocus = 'enterpriseFocus';
		$labelPath = 'enterprisePath';
		$enterpriseStyle =  'style="display:block;"';
		$defaultProfileImage = $this->config->item('defaultEnterpriseImg_s');
	}
	/*
	if($values['optionSelected']==4) 
	{
		$labelOption = $label['artist'].' '.$label['area'];
		$labelFocus = 'artistFocus';
		$labelPath = 'artistPath';
		$enterpriseStyle =  'style="display:none;"';
	}
	*/
	//Setting the ShopwCase ID for Insert or Update Save
	if(isset($values['showcaseId']))
	echo form_hidden('showcaseId',$showcaseId); 
	
	
$lastInsertedMediaId = array(
    'name'        => 'lastInsertedMediaId',
    'id'          => 'lastInsertedMediaId',
    'value'       => $showcaseId,
    'type'		  => 'hidden'
);

	echo form_input($lastInsertedMediaId); 
	//echo '<pre />';
	//print_r($values);
	
?>
	
	<!-- OPTIONS -->

	<div class="row"> 
		<div class="label_wrapper cell">
			<label class="select_field"><?php echo $this->lang->line('Type');?></label>
		</div><!--label_wrapper-->

		<div class="cell frm_element_wrapper">
			<div class="row" style="padding-top:0px">
				
				<div class="defaultP" id="<?php echo $label['creative']; ?>">
				  <input type="radio"  id="<?php echo $label['creative']; ?>" class="showOption" name="optionSelected" value="1" <?php if($values['optionSelected']==1) echo 'checked';?> />
				</div>	

				<div class="cell widthSpacer"> &nbsp;</div>
				
				<div class="cell">
				 <label class="lH25"><?php echo $label['creative'];?></label> 
				</div>				
				<div class="cell widthSpacer"> &nbsp;</div>
				 
				<div class="defaultP" id="<?php echo $label['associatedProfessional']; ?>">
					<input type="radio" id="<?php echo $label['associatedProfessional']; ?>" class="showOption" name="optionSelected" value="2" <?php if($values['optionSelected']==2) echo 'checked';?> />
				</div>				
				<div class="cell widthSpacer"> &nbsp;</div>
				
				<div class="cell">
				  <label class="lH25"><?php echo $label['associatedProfessional'];?></label>
				</div>			
				<div class="cell widthSpacer"> &nbsp;</div>
				
				<div class="defaultP" id="<?php echo $label['enterprise']; ?>">
					<input type="radio" id="<?php echo $label['enterprise']; ?>" class="showOption" name="optionSelected" value="3" <?php if($values['optionSelected']==3) echo 'checked';?> />					
				</div>					
				<div class="cell widthSpacer"> &nbsp;</div>
				
				<div class="cell">
				 	<label class="lH25"> <?php echo $label['enterprise'];?></label>
				</div>						
				<div class="cell widthSpacer"> &nbsp;</div>				
				
			  </div>
		</div>
	</div><!--from_element_wrapper-->  
	
	
	<!-- FIRST NAME -->
	<div class="row"> 
		<div class="label_wrapper cell">
			<label class="select_field"><?php echo $label['firstName'];?></label>
		</div><!--label_wrapper-->

		<div class="cell frm_element_wrapper">
			<?php echo form_input($firstName); ?>
			<div class="row wordcounter">
				<?php echo form_error($firstName['name']); ?>
				<?php echo isset($errors[$firstName['name']])?$errors[$firstName['name']]:''; ?>
			</div>
		</div>
	</div><!--from_element_wrapper-->  
	
	<!-- LAST NAME -->
	<div class="row"> 
		<div class="label_wrapper cell">
			<label class="select_field"><?php echo $label['lastName'];?></label>
		</div><!--label_wrapper-->

		<div class="cell frm_element_wrapper">
			<?php echo form_input($lastName); ?>
			<div class="row wordcounter">
				<?php echo form_error($lastName['name']); ?>
				<?php echo isset($errors[$lastName['name']])?$errors[$lastName['name']]:''; ?>
			</div>
		</div>
	</div><!--from_element_wrapper--> 
	
	<!-- TYPE -->
	<!-- Enterprise Input filed get display block when enterprise option is selected -->
	<div id="enterpriseNameTog" <?php echo $enterpriseStyle;?> >
	<div class="row"> 
		<div class="label_wrapper cell">
			<label class="select_field"><?php echo $label['enterpriseName'];?></label>
		</div><!--label_wrapper-->

		<div class="cell frm_element_wrapper">
			<?php echo form_input($enterpriseName); ?>
			<div class="row wordcounter">
				<?php echo form_error($enterpriseName['name']); ?>
				<?php echo isset($errors[$enterpriseName['name']])?$errors[$enterpriseName['name']]:''; ?>
			</div>
		</div>
	</div><!--from_element_wrapper--> 
	</div>

	<!-- OPTION TO GET SHOWN HERE -->
	<div class="row"> 
		<div class="label_wrapper cell" id="areaId">
			<label class="select_field"><?php echo $labelOption;?></label>
		</div><!--label_wrapper-->

		<div class="cell frm_element_wrapper">
			<?php 
			if($values['optionSelected']==2) $optionAreaName = $optionAreaName+array('title'=>$label['toolTipAOI']);
			if($values['optionSelected']==2) $optionAreaName = $optionAreaName+array('title'=>$label['toolTipAOI']);
			echo form_input($optionAreaName); 
			?>
			<div class="row wordcounter">
				<?php echo form_error($optionAreaName['name']); ?>
				<?php echo isset($errors[$optionAreaName['name']])?$errors[$optionAreaName['name']]:''; ?>
			</div>
		</div>
	</div><!--from_element_wrapper--> 
	
	<!-- TAG WORDS -->
	
	<?php 
			$value=$tagwords['value']?$tagwords['value']:@$values['tagwords'];
			$value=htmlentities($value);
			$tagWordsLabel = 'tagWords';
			$data=array('name'=>'tagwords','value'=>$value, 'view'=>'tag_words','labelText'=>$tagWordsLabel,'required'=>'required');
			
			echo Modules::run("common/formInputField",$data);
	?> 

	<!-- FOCUS -->
	
	<?php 
			$showLabel = $labelFocus;
			
			$creativeFocusValue=$creativeFocus['value']?$creativeFocus['value']:@$values['creativeFocus'];
			
			$value=htmlentities($value);
			
			$focusDesc=array('name'=>'creativeFocus','value'=>$creativeFocusValue, 'view'=>'oneline_description','required'=>'required','labelText'=>$showLabel,'labelMsg'=>$label['optionMsg'],'id'=>"focusId");
			
			echo Modules::run("common/formInputField",$focusDesc);	
			$browseImgJs = '_showcaseImgJs';		
	?> 	
	
	<!-- PATH -->
	
	<?php 			
			$showPathLabel = $labelPath;
			
			$creativePathValue = $creativePath['value']?$creativePath['value']:@$values['creativePath'];
			
			$wordOption = array('minVal'=>0,'maxVal'=>500,'wordLabel'=>$this->lang->line('0To500MsgNR'));
			
			$pathDesc=array('name'=>'creativePath','value'=>$creativePathValue, 'view'=>'description','labelText'=>$showPathLabel,'labelMsg'=>$label['optionMsg'],'id'=>"pathId",'required'=>'','wordOption'=>$wordOption);
			
			if($values['optionSelected']==2) $pathDesc = $pathDesc+array('addclass'=>'formTip','addTitle'=>$label['toolTipDP']);
			
			echo Modules::run("common/formInputField",$pathDesc);	 
			
			echo '<div class="seprator_25 row"></div>';
			
			//-----Commom Image View-----
			$showProfileThumbImage = addThumbFolder(@$showProfileImage,'_s');	
			$imgsrc = getImage($showProfileThumbImage,$defaultProfileImage);
			
			$img = '<img id="galImg_'.@$showcaseId.'" class="ma" src="'.$imgsrc.'">';			
				
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
			
			$stockImageFlag = 1;
		
			echo Modules::run("mediatheme/promoImgFrmJs",$label['image'],$img ,$fileUpload,$inputArray,$browseImgJs,$stockImageFlag,0);
			
			echo '<div class="seprator_25 row"></div>';
/*				
			//-----Commom Promotional Video Upload-----
			$videoSize = $this->config->item('videoSize');
			$videoType = $this->config->item('videoAccept');
			
			$browseId = '_interview';
			$browseIntroId = '_introductory';
			
			$videoLabel = $label['interviews'];
			
			if(isset($values['uploadInterviewType']) && $values['uploadInterviewType']!='')
			 $videoType = $values['uploadInterviewType'];
			else
			 $videoType = 0;			
			
			if($videoType == 1 && isset($values['interviewFileId']) && $values['interviewFileId']>0)
			{
				//$imgInterviewSrc = anchor('javascript://void(0);','<span><img width="100" src="'.base_url().'images/stockphoto_FnV.jpg" /></span>',array('class'=>'','id'=>'idInterviewVideoEmbed'));
				$interFileDetail = getMediaDetail($interviewFileId,'fileName,filePath');
				if(is_array($interFileDetail)){
				$file = $firstInterviewVideoFile =  $interFileDetail[0]->filePath.'/'.$interFileDetail[0]->fileName;
				}
				else $file = $firstInterviewVideoFile = '';
				
				$fileType = 2;
				
				if($file=='')
				{
					$imgInterviewSrc = '<img class="ui-state-disabled" width="100" src="'.base_url().'images/stockphoto_FnV.jpg" />';
				}
				else
				{
					$imgInterviewSrc = '<img  id ="showVideo'.$browseId.'"  width="100" src="'.base_url().'images/stockphoto_FnV.jpg" onclick="openLightBox(\'loginLightBoxWp\',\'loginFormContainer\',\'/common/playMediaFile\',\''.$file.'\',\''.$fileType.'\',5);" />';
				}				
			}			
			else if($videoType == 0 && isset($values['interviewEmbed']) && $values['interviewEmbed']!='')
			{
				$file=urlencode($values['interviewEmbed']);
				$fileType='external';
				$imgInterviewSrc = '<img  width="100" id ="showVideo'.$browseId.'"  src="'.base_url().'images/stockphoto_FnV.jpg" onclick="openLightBox(\'loginLightBoxWp\',\'loginFormContainer\',\'/common/playMediaFile\',\''.$file.'\',\''.$fileType.'\',5);" />';
			}
			else 
			{
				$imgInterviewSrc = '<img class="ui-state-disabled" width="100" src="'.base_url().'images/stockphoto_FnV.jpg" />';
			}
			
			$embedArray = '';
			
			$inputArray = array(
				'name'	=> 'interviewFilename',
				'class'	=> 'width327px BdrCommon fl',
				'value'	=> '',
				'id'	=> 'FileField'.$browseId,
				'type'	=> 'text',
				'readonly' => true
			);
				
			$uploadArray = array(
			'id'	=> 'BrowserHidden'.$browseId,	
			'name'	=> 'interviewVideoPath',
			'class'	=> 'BrowserHidden btn_browse',
			'value'	=> '',
			'accept'=> $this->config->item('videoAccept'),
			'onchange'=> "getElementById('FileField".$browseId."').value = getElementById('BrowserHidden".$browseId."').value",
			'style'=>"width:385px;"
			);
			
			$embedArray = array(
			'name'	=> 'interviewEmbed',
			'id'	=> 'interviewEmbed',
			'title'=>  $label['profileImage'],
			'class'	=> 'dblBorder rz width405px',
			'rows' => 2,
			'cols' => 45,
			'value' => @$values['interviewEmbed']	
			//'value' => $values['interviewEmbed']	
			);
			
			$interData=array('videoLabel'=>$videoLabel,'imgInterviewSrc'=>$imgInterviewSrc,'embedArray'=>$embedArray,'uploadArray'=>$uploadArray,'inputArray'=>$inputArray,'browseId'=>$browseId,'videoType'=>$videoType,'fileType'=>$this->config->item('videoUploadAccept'),'fileMaxSize'=>$this->config->item('videoMaxSize'),'fileSize'=>$this->config->item('videoSize'),'filePath'=>$interviewVideoPathForm);
			?>
			<div id="FileContainer<?php echo $browseId;?>" class="fr">
				<div class="fileInfo" id="fileInfo<?php echo $browseId;?>">
					<div id="progressBar<?php echo $browseId;?>" class="plupload_progress">
						<div class="progressBar_msg fl">Please wait. File loading</div>
						<div class="plupload_progress_container fl"><div id="plupload_progress_bar<?php echo $browseId;?>" class="plupload_progress_bar"></div></div></div><span id="percentComplete<?php echo $browseId;?>" class="percentComplete fl"></span>
				</div>
				<div id="dropArea<?php echo $browseId;?>"></div>
		</div>
		<?php
			echo Modules::run("mediatheme/promoVideoForm",$interData);
			
			//-----Commom Promotional Introductory Video Upload-----

			$introVideoLabel = $label['introductoryVideo'];
			
			if(isset($values['uploadIntroductoryType']) && $values['uploadIntroductoryType']!='')
				$uploadIntroType = $values['uploadIntroductoryType'];
			else
				$uploadIntroType = 0;
			
			if($uploadIntroType == 1)
			{
				//$imgInterviewSrc = anchor('javascript://void(0);','<span><img width="100" src="'.base_url().'images/stockphoto_FnV.jpg" /></span>',array('class'=>'','id'=>'idInterviewVideoEmbed'));
				//echo $values['introductoryFileId'];
				$introFileDetail = getMediaDetail($introductoryFileId,'fileName,filePath');
				if(is_array($introFileDetail)){
				$fileIntro = $firstIntroductoryVideoFile = $introFileDetail[0]->filePath.'/'.$introFileDetail[0]->fileName;
				}
				else $fileIntro = $firstIntroductoryVideoFile = '';
				
				$fileTypeIntro = 'video';
				
				if($fileIntro=='')
				{
					$imgIntroSrc = '<img class="ui-state-disabled" width="100" src="'.base_url().'images/stockphoto_FnV.jpg" />';
				}
				else
				{
					$imgIntroSrc = '<img id ="showVideo'.$browseIntroId.'" width="100" src="'.base_url().'images/stockphoto_FnV.jpg" onclick="openLightBox(\'loginLightBoxWp\',\'loginFormContainer\',\'/common/playMediaFile\',\''.$fileIntro.'\',\''.$fileTypeIntro.'\',5);" />';
				}
			}
			
			else if($uploadIntroType == 0 && isset($values['introductoryEmbed'])&& $values['introductoryEmbed']!='')
			{
				$fileIntro = urlencode($values['introductoryEmbed']);
				$fileTypeIntro='external';
				$imgIntroSrc = '<img id ="showVideo'.$browseIntroId.'" width="100" src="'.base_url().'images/stockphoto_FnV.jpg" onclick="openLightBox(\'loginLightBoxWp\',\'loginFormContainer\',\'/common/playMediaFile\',\''.$fileIntro.'\',\''.$fileTypeIntro.'\',5);" />';
			}
			else 
			{
				$imgIntroSrc = '<img class="ui-state-disabled" width="100" src="'.base_url().'images/stockphoto_FnV.jpg" />';
			}
			
			$embedArray = '';			
			
			$inputIntroArray = array(
				'name'	=> 'introductoryFilename',
				'class'	=> 'width327px BdrCommon fl',
				'value'	=> '',
				'id'	=> 'FileField'.$browseIntroId,
				'type'	=> 'text',
				'readonly' => true				
			);
				
			$uploadIntroArray = array(
			'id'	=> 'BrowserHidden'.$browseIntroId,	
			'name'	=> 'introductoryVideoPath',
			'class'	=> 'BrowserHidden  btn_browse',
			'value'	=> '',
			'accept'=> $this->config->item('videoAccept'),
			'onchange'=> "getElementById('FileField".$browseIntroId."').value = getElementById('BrowserHidden".$browseIntroId."').value",
			'style'=>"width:385px;"
			);
			
			$embedIntroArray = array(
			'name'	=> 'introductoryEmbed',
			'id'	=> 'introductoryEmbed',
			'title'=>  $label['profileImage'],
			'class'	=> 'dblBorder rz width405px',
			'rows' => 2,
			'cols' => 45,
			'value' => @$values['introductoryEmbed']
			//'value' => $values['introductoryEmbed']	
			);
		
		$isEmbed='f';	
		if($isEmbed == 'f') $embedPath= '';
		
		$introData = array('videoLabel'=>$introVideoLabel,'imgInterviewSrc'=>$imgIntroSrc,'embedArray'=>$embedIntroArray,'uploadArray'=>$uploadIntroArray,'inputArray'=>$inputIntroArray,'browseId'=>$browseIntroId,'videoType'=>$uploadIntroType,'fileType'=>$this->config->item('videoUploadAccept'),'fileMaxSize'=>$this->config->item('videoMaxSize'),'fileSize'=>$this->config->item('videoSize'),'filePath'=>$introVideoPathForm);
		?>
		<div id="FileContainer<?php echo $browseIntroId;?>" class="fr">
				<div class="fileInfo" id="fileInfo<?php echo $browseIntroId;?>">
					<div id="progressBar<?php echo $browseIntroId;?>" class="plupload_progress">
						<div class="progressBar_msg fl">Please wait. File loading</div>
						<div class="plupload_progress_container fl"><div id="plupload_progress_bar<?php echo $browseIntroId;?>" class="plupload_progress_bar"></div></div></div><span id="percentComplete<?php echo $browseIntroId;?>" class="percentComplete fl"></span>
				</div>
				<div id="dropArea<?php echo $browseIntroId;?>"></div>
		</div>
		<?php
			echo Modules::run("mediatheme/promoVideoForm",$introData);
		?>
*/ 
?>
	<!-- Promotional Section SHOWN HERE -->
	<div class="row"> 
		<div class="label_wrapper cell">
			<label class="select_field"><?php echo $label['promotionalsection'];?></label>
		</div><!--label_wrapper-->

		<div class="cell frm_element_wrapper NIC">
			<div id="myNicPanel" class="width567px">	</div>	
				<div id="myShowcase" class="editordiv dblBorder Bdr width546px nicEditorVal" onblur="checktext();">
					<?php 
					if($promotionalsection['value']!='')
						echo html_entity_decode($promotionalsection['value']);?>				
				</div>
				
				<?php echo form_textarea($promotionalsection); ?>	
				<div id="promoSectionError" class="dn orange">This field is required.</div>
								
		</div>
	
	</div><!--from_element_wrapper--> 
	
	<div class="seprator_25 row"></div>
	
	<!-- Review Me And Recommend Me SHOWN HERE -->
	<div class="row"> 
		<div class="label_wrapper cell">
			<label><?php echo $label['addButton']; ?></label>
		</div><!--label_wrapper-->

		<div class="cell frm_element_wrapper">
			<div class="cell" style="padding: 3px 0 0 2px;" >
				<div class="defaultP">
					<?php echo form_checkbox($reviewMe);?>
				</div>
			</div>
			<div class="cell mt5">				
					<?php echo $label['reviewMe'];?>				
			</div>
			<div class="cell" style="padding: 3px 0 0 12px;" >
				<div class="defaultP">
					<?php echo form_checkbox($contactMe);?>
				</div>
			</div>
			<div class="cell mt5">				
					<?php echo $label['contactMe'];?>				
			</div>
			<div class="cell" style="padding: 3px 0 0 12px;" >
				<div class="defaultP">
					<?php echo form_checkbox($recommendMe);?>
				</div>
			</div>
			<div class="cell mt5">				
					<?php echo $label['recommendMe'];?>				
			</div>
			
		</div>		
	</div><!--from_element_wrapper--> 	
	
	<!-- Send Notification To Craved SHOWN HERE -->
	<div class="row"> 
		<div class="label_wrapper cell">
				<label><?php echo $label['sendNotifWhen'];?></label>
		</div><!--label_wrapper-->

		<div class="cell frm_element_wrapper">
			<div class="cell" style="padding: 3px 0 0 2px;" ><div class="defaultP"><?php echo form_checkbox($sendNotificationtoCraved);?></div></div>
			<div class="cell mt5" style="padding: 0 0 0 2px;" ><?php echo $label['sendNotificationtoCraved'];?></div>
		</div>		
	</div><!--from_element_wrapper--> 
	
	<!-- Send Notification to Craved SHOWN HERE -->
	<div class="row"> 
		<div class="label_wrapper cell">
			<label><?php echo $label['receiveNotification'];?></label>
		</div><!--label_wrapper-->

		<div class="cell frm_element_wrapper">
			 <div class="row" style="padding:2px  0px  0px 0px;">
					 <div class="cell" style="padding: 3px 0 0 2px;" >
						 <div class="defaultP">
							 <?php echo form_checkbox($reviewMyMedia);?>
						 </div>
					 </div>
					 <div class="cell mt5" style="padding: 0 0 0 2px;" >
						 <?php echo $label['reviewMyMedia'];?>
					 </div>				
				 </div><!-- End row -->
				
		</div>		
	</div><!--from_element_wrapper-->
	<?php /* 	
	<div class="row"> 
		<div class="label_wrapper cell">
			<label><?php echo $label['memberReviewMeWhen'];?></label>
		</div><!--label_wrapper-->

		<div class="cell frm_element_wrapper">
			 	 <div class="row" style="padding:2px  0px  0px 0px;">
					 <div class="cell" style="padding: 3px 0 0 2px;" >
						 <div class="defaultP">
							 <?php echo form_checkbox($memberReviewMe);?>
						 </div>
					 </div>
					 <div class="cell mt5" style="padding: 0 0 0 2px;" >
						 <?php echo $label['memberReviewMe'];?>
					 </div>					
				 </div><!-- End row -->
		</div>		
	</div><!--from_element_wrapper--> 	
	*/ ?>
	
		<input type="hidden" id="radioSelected" value="" name="radioSelected" />
		<input type="hidden" id="save" value="" name="save" />
		<?php
			$button = array('ajaxSave','preview');
			echo Modules::run("common/loadButtons",$button); 
		?>	
		<div class="clear seprator_10"></div>
		<?php echo form_close(); ?>
	</div><!-- End form_wrapper -->
<?php 

	$interJSPath = $interviewVideoPathForm.'/';
	$introJSPath = $introVideoPathForm.'/';
	$proImgJSPath = $profileJsImagePath;
	
?>
<script>
$('#browsebtn<?php echo @$browseImgJs;?>').click(function(){		
	fileTypes = '<?php echo $this->config->item('imageAccept');?>';
	fileTypes = fileTypes.replace(/\|/g, ",");		
});
	
uploadMediaFiles('<?php echo $proImgJSPath?>',fileTypes,'<?php echo $this->config->item('imagemaxSize');?>','<?php echo $browseImgJs;?>',1,1,0,1);
	
$(document).ready(function(){
	 	//alert('<?php echo $showProfileImage;?>');
		$("#myProfileImage").attr("src",'<?php echo getImage($showProfileImage);?>');	
	
		//$('#myProfileImage').empty().html( '<img width="173" src="<?php echo getImage($showProfileImage);?>">' );
  
		//$("#myProfileImage").html($("<img>").attr("src",'<?php echo getImage($showProfileImage);?>'));

		
		if($('#firstName').val()!='' && $('#lastName').val()!=''){
			//To change the breadcrumb user name  && left end user info dynamically
			$("div.breadcrumb a:first-child").html($('#firstName').val()+' '+$('#lastName').val());
			$("#myProfileFullName").html($('#firstName').val()+' '+$('#lastName').val());
		}	
		
		if($('#optionAreaName').val() != '')		
			$("#myArea").html($('#optionAreaName').val());			
		
		$("#showcaseForm").validate({
				
		submitHandler: function() {		
			var goforsave = 1;						
			//To Check Is There Any Error While uploading the Video Files If So Do not Go For Save 
			
			//if((interviewError == false) && (introError == false)) var goforsave = 1;
			//else var goforsave = 0;
			var divContent = $.trim($('#myShowcase').text());

			if(goforsave==1)
			{
				
				if(divContent =='<br>' || divContent =='' ) 
				{
					divContent='';
				}
		
				if( divContent == '' )
				{
					$('#promoSectionError').removeClass('dn');			
					$('#myShowcase').focus();
					return false;
				}
				else
				{			
			$("#myProfileImage").attr("src",'<?php echo getImage($showProfileImage);?>');	

			//$('#myProfileImage').empty().html( '<img width="173" src="<?php echo getImage($showProfileImage);?>">' );

			//$("#myProfileImage").html($("<img>").attr("src",'<?php echo getImage($showProfileImage);?>'));


			if($('#firstName').val()!='' && $('#lastName').val()!=''){
			//To change the breadcrumb user name  && left end user info dynamically
			$("div.breadcrumb a:first-child").html($('#firstName').val()+' '+$('#lastName').val());
			$("#myProfileFullName").html($('#firstName').val()+' '+$('#lastName').val());
			}	

			if($('#optionAreaName').val() != '')		
			$("#myArea").html($('#optionAreaName').val());	
					
			$('#promoSectionError').addClass('dn');			
			$('#promotionalsection').attr({ value:divContent }); 
			$('#save').val('Save');		
			
			var fileType = 'video';	
			//End for editor value
			var elementId = <?php echo $showcaseId;?>;  
			var elementTable = '<?php echo $elementTable;?>';  
			var elementFieldId = '<?php echo $elementFieldId;?>';  
			 
			var interviewEmbed = $('#interviewEmbed').val();   
			var introductoryEmbed = $('#introductoryEmbed').val();  
			var numErrorItems = 0;
			
			var introType = $('#uploadIntroductoryType').val();  
			var interviewType = $('#uploadInterviewType').val();  
			
			if($('#fileName<?php echo $browseImgJs;?>').val() =='')
				var profileImageName = '<?php echo @$values['profileImageName'];?>';
			else {
				var profileImageName = $('#fileName<?php echo $browseImgJs;?>').val();
				$('#stockImageId').val('');
				stockImageId = 0;
			}
			
			if($('#stockImageId').val()=='') stockImageId = '0';						
			else 
			{
				if($('#stockImageId').val()!='' && $('#stockImageId').val()>0) 
					profileImageName = '';
				stockImageId = $('#stockImageId').val();
			}
				
			var reviewMe = $('#reviewMe:checked').val()?'t':'f'; 
			
			var recommendMe = $('#recommendMe:checked').val()?'t':'f'; 
			
			var sendNotificationtoCraved = $('#sendNotificationtoCraved:checked').val()?'t':'f'; 
			
			var reviewMyMedia = $('#reviewMyMedia:checked').val()?'t':'f'; 
			
			var memberReviewMe = $('#memberReviewMe:checked').val()?'t':'f';						
			
			var optionSelected = $('input:radio[name=optionSelected]:checked').val();	
		
			if(elementId ==0)
				var data = {"optionSelected":optionSelected,"firstName":$('#firstName').val(),"lastName":$('#lastName').val(),"enterpriseName":$('#enterpriseName').val(),"optionAreaName":$('#optionAreaName').val(),"tagwords":$('#tagwords').val(),"creativeFocus":$('#creativeFocus').val(),"creativePath":$('#creativePath').val(),"profileImageName":profileImageName,"reviewMe":reviewMe,"recommendMe":recommendMe,"sendNotificationtoCraved":sendNotificationtoCraved,"reviewMyMedia":reviewMyMedia,"memberReviewMe":memberReviewMe,"promotionalsection":divContent,"stockImageId":stockImageId,"optionSelected":optionSelected,"tdsUid":<?php echo isLoginUser(); ?>,"dateCreated":'<?php echo date('Y-m-d h:i:s'); ?>',"dateModified":'<?php echo date('Y-m-d h:i:s'); ?>'}; 
			else
				var data = {"showcaseId":elementId,"firstName":$('#firstName').val(),"lastName":$('#lastName').val(),"enterpriseName":$('#enterpriseName').val(),"optionAreaName":$('#optionAreaName').val(),"tagwords":$('#tagwords').val(),"creativeFocus":$('#creativeFocus').val(),"creativePath":$('#creativePath').val(),"optionSelected":optionSelected,"profileImageName":profileImageName,"promotionalsection":divContent,"reviewMe":reviewMe,"recommendMe":recommendMe,"sendNotificationtoCraved":sendNotificationtoCraved,"reviewMyMedia":reviewMyMedia,"memberReviewMe":memberReviewMe,"stockImageId":stockImageId,"tdsUid":<?php echo isLoginUser(); ?>,"dateModified":'<?php echo date('Y-m-d h:i:s'); ?>'}; 							
			
			// Gets the number of elements with class yourClass
			numErrorItems = $('.error').length;
			
			if(numErrorItems>0)
			{ 
				return false;
			}
			else
			{
			var returnFlag = AJAX('<?php echo base_url(lang()."/showcase/UpdateShowcaseTable");?>','','','',data,'loadVideo',elementId,elementTable,elementFieldId,'','','','','<?php echo $browseImgJs;?>');	
			
				if(returnFlag){
						
					$("#uploadFileByJquery<?php echo $browseImgJs;?>").click();
					
					if(goforsave==1 && returnFlag) $('#messageSuccessError').html('<div class="successMsg"><?php echo $this->lang->line('showcase').' '.$this->lang->line('recordSaveDeleted');?></div>');
					
					if($('#fileName<?php echo $browseImgJs;?>').val() =='') location.reload();
					return true;
				}								
			}
			}							
		  }
		}
	});
});
	
	function submitform() {
			
		var divContent = $.trim($('#myShowcase').text());

		if(divContent =='<br>' || divContent =='' ) 
		{
			divContent='';
		}
	
		if( divContent == '' )
		{
			$('#promoSectionError').removeClass('dn');
			
			$('#myShowcase').focus();
			return false;
		}
		else
		{
			$('#promoSectionError').addClass('dn');
			
			$('#promotionalsection').attr({ value:divContent }); 
			//End for editor value
			document.showcaseForm.save.value= 'Save'; 
			//$('#showcaseForm').submit();
			//document.showcaseForm.submit();  
			return true;
		}
	}

	function checktext(){
		
		var divContent = $.trim($('#myShowcase').text());
		
		if( divContent == '' ||  divContent == '<br>')
			$('#promoSectionError').removeClass('dn');
		else
			$('#promoSectionError').addClass('dn');
	}

	$(function(){	
		
		$(".showOption").click(function(){
		
		   $("#radioSelected").val($(this).attr('id'));
			
			 if($(this).attr('id') == '<?php echo $label['enterprise']; ?>')
			 {
				$("#enterpriseNameTog").show();
			 }
			 else
			 {
				$("#enterpriseNameTog").hide();
			 }
			 
			 var changedLabel ='';
			 
			 changedLabel = $(this).attr('id');
			 //alert(changedLabel);
			
			 if($(this).attr('id') == '<?php echo $label['associatedProfessional']; ?>')
			 {
				$("#areaId").html('<label class="select_field"> <?php echo $label['area'].'&nbsp;'.$label['ofInterest'];?></label>');
 			    $("#pathId").html('<label><?php echo $label['development'].'&nbsp;'.$label['path'];?></label>');
 			    $("#focusId").html('<label class="select_field"><?php echo $label['current'].'&nbsp;'.$label['focus'];?></label>');
			 }
			 else
			 {
			   $("#areaId").html('<label class="select_field">'+changedLabel+' <?php echo $label['area'];?>'+'</label>');
			   $("#pathId").html('<label>'+changedLabel+' <?php echo $label['path'];?>'+'</label>');
			   $("#focusId").html('<label class="select_field">'+changedLabel+' <?php echo $label['focus'];?>'+'</label>');
			 }
		});		   
		var myNicEditor = new nicEditor({buttonList : ['html','save','bold','italic','underline','left','center','right','justify','ol','ul','fontSize','fontFamily','fontFormat','indent','outdent','subscript','superscript','strikethrough','removeformat','hr','image','link','unlink','forecolor']});
		myNicEditor.setPanel('myNicPanel');
		myNicEditor.addInstance('myShowcase');
	});


	function showstockimages()
	{
		$("#stockImagesBoxWp").lightbox_me('center:true');
	}

	function preview()
	{
		openLightBox('showcasePreviewBoxWp','showcasePreviewFormContainer','/showcase/showcasePreview');
	}
</script>
<?php
	if(@$this->input->post('ajaxHit')==1){ 
		?>
		<script>
			selectBox();
			runTimeCheckBox();
		</script>
		<?
	}
?>
