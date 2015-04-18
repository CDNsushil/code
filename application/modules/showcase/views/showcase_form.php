<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$userId=isLoginUser();

if(isset($values['showcaseId'])) $showcaseId = $values['showcaseId'];
else $showcaseId = 0;

$uniqueId='project'.$showcaseId;
$containerSize=(isset($values['containerSize']) && is_numeric($values['containerSize']))?$values['containerSize']:$this->config->item('defaultContainerSize');
$dirname=$dirUploadMedia;
$dirSize=getFolderSize($dirname);
$remainingBytes =($containerSize - $dirSize);
if(!$remainingBytes > 0){
	$remainingBytes =0;
}
			
$containerSize=bytestoMB($containerSize,'mb');

$dirSize=bytestoMB($dirSize,'mb');
$remainingSize=($containerSize-$dirSize);

if($remainingSize < 0){
	$remainingSize = 0;
}

$dirSize = number_format($dirSize,2,'.','');
$fileMaxSize = $remainingBytes;
$remainingSize = number_format($remainingSize,2,'.','');
?>
<div class="contactBoxWp dn" id="contactBoxWp">
	<div id="contactContainer" class="contactContainer"></div>
</div>
<?php 
$defaultProfileImage = $this->config->item('defaultCreativeImg_s');	

$elementTable='UserShowcase';
$elementFieldId='showcaseId';
$formAttributes = array(
	'name'=>'showcaseForm',
	'id'=>'showcaseForm'
);

$ARS = array(
	'name'	=> 'availableRemainingSpace',
	'value'	=> mbToBytes($remainingSize,'mb'),
	'id'	=> 'availableRemainingSpace',
	'type'	=> 'hidden'
);

$firstName = array(
	'name'	=> 'firstName',
	'id'	=> 'firstName',
	'class' => 'frm_Bdr required width556px',
	'value'	=> set_value('firstName',@$values['firstName']),
	'readonly' => 'readonly',	
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

$AESD = '';

if($values['optionSelected']==1) 
{
	$labelOption = $label['area'].' '.$label['ofInterest'];
	$labelFocus =  'creativeFocus';
	$labelPath = 'creativePath';
	$enterpriseStyle =  'style="display:none;"';
	$defaultProfileImage = $this->config->item('defaultCreativeImg_s');
	$CreativetoolTip=$this->lang->line('CreativetoolTip');
	$focustoolTip=$this->lang->line('creativeFocusToolTip');	
}

if($values['optionSelected']==2) 
{
	$labelOption = $label['area'].' '.$label['ofInterest'];
	$labelFocus = 'associatedProfessionalFocus';
	$labelPath = 'associatedProfessionalPath';
	$enterpriseStyle =  'style="display:none;"';
	$defaultProfileImage = $this->config->item('defaultAssoProfImg_s');
	$CreativetoolTip=$this->lang->line('AssociatetoolTip');
	$focustoolTip=$this->lang->line('associateFocusToolTip');
	
}

if($values['optionSelected']==3)
{
	$AESD='dn';
	$labelOption = $label['area'].' '.$label['ofInterest'];
	$labelFocus = 'showcaseFocus';
	$labelPath = 'enterprisePath';
	$enterpriseStyle =  'style="display:block;"';
	$defaultProfileImage = $this->config->item('defaultEnterpriseImg_s');
	$CreativetoolTip=$this->lang->line('EnterprisetoolTip');
	$focustoolTip=$this->lang->line('enterpriseFocusToolTip');
}

if($values['enterprise'] != 't' && ($values['from_showcaseid'] > 0)){
	$SCdata=getDataFromTabel('UserShowcase', 'enterpriseName',  array('showcaseId'=>$values['from_showcaseid']), '','', '',1 );
	$values['EpName']=$SCdata[0]->enterpriseName;
}else{
	$values['EpName']='';
	$values['from_showcaseid']=0;
}

$optionAreaName = array(
	'name'	=> 'optionAreaName',
	'id'	=> 'optionAreaName',
	'class' => 'frm_Bdr required width556px formTip',
	'value'	=> set_value('optionAreaName',@$values['optionAreaName']),
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50,
	'title'=>$CreativetoolTip
);

$tagwords = array(
	'name'	=> 'tagwords',
	'id'	=> 'tagwords',
	'class'	=> 'BdrCommonTextarea heightAuto rz  required error',
	'title'=>  $label['add'].' '.$this->lang->line('tagwords').' here'.$label['15_100_words'],
	'value'	=> set_value('tagwords',@$values['tagwords']),
	'minlength'	=> 15,
	'rows'	=> 5,
	'wordlength'=>"3,25",
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
    'checked'     => @$values['reviewMe'] =='f'?FALSE:TRUE,
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
	'value'	=> set_value('promotionalsection',html_entity_decode(isset($values['promotionalsection'])?$values['promotionalsection']:'')),
	'size'	=> 30,
	'cols' => 70,
	'rows' => 20,
	'class' => 'formTip textarea  frm_Bdr required',
	'style' => 'border: 1px solid #A0A0A0;outline: 3px solid #E1E1E1; display:none;',
	'title'       => 'Promotional Description',
);
$contactMe = array(
    'name'        => 'memberReviewMe',
    'id'          => 'memberReviewMe',
    'value'       => 'accept',
    'checked'     => @$values['memberReviewMe'] =='f'?FALSE:TRUE,
    'class'	=> 'formTip',
	'title'       => $this->lang->line('toolTipContactMe')
);

$profileImage= '';
if(isset($introFileName))
{
	$firstIntroductoryVideoFile = $introFilePath.'/'.$introFileName;
}

if(isset($interFileName))
{
	$firstInterviewVideoFile = $interFilePath.'/'.$interFileName;
}

if($values['isPublished']=='t'){
	$viewDisplay='';
	$previewDisplay='style="display: none;"';
	
	$rtspDisplay='';
	$rtsupDisplay='style="display: none;"';
	
	$pDisplay='';
	$upDisplay='style="display: none;"';
}else{
	$viewDisplay='style="display: none;"';
	$previewDisplay='';
	
	$rtspDisplay='style="display: none;"';
	$rtsupDisplay='';
	
	$pDisplay='style="display: none;"';
	$upDisplay='';
}
?>

<div id="stockImagesBoxWp" class="popup_box width_268 heightAuto p12" style="display:none;">
		<div style="background:#fff">
		<div id="close-stockImagesBox" title="" class="tip-tr close-customAlert"></div><!-- We have to define "id" in lightboxme-common.js -->
		<div class="stockImagesFormContainer" id="stockImagesFormContainer">
			<?php echo Modules::run("showcase/viewStockImages",$showcaseId); ?> 
		</div>
	<div style="clear:both"></div>
	</div>
</div>

<div id="showcasePreviewBoxWp" class="customAlert widthAuto heightAuto backgroundWhite" style="display:none; padding:19px 5px 19px 19px; border:1px solid #999999;">
	<div id="close-showcasePreviewBox" title="" class="tip-tr close-customAlert" onclick="$(this).parent().trigger('close');"></div><!-- We have to define "id" in lightboxme-common.js -->
	<div class="showcasePreviewFormContainer" id="showcasePreviewFormContainer"><?php //echo Modules::run("showcase/showcasePreview"); ?> </div>
</div>

<div class="row position_relative">	
<?php 

echo Modules::run("common/strip");
echo form_open_multipart($this->uri->uri_string(),$formAttributes); 
echo form_input($ARS);	
if(isset($values['showcaseId'])) echo form_hidden('showcaseId',$showcaseId); 	
	
$lastInsertedMediaId = array(
    'name'        => 'lastInsertedMediaId',
    'id'          => 'lastInsertedMediaId',
    'value'       => $showcaseId,
    'type'		  => 'hidden'
);

echo form_input($lastInsertedMediaId); 	
?>
	<div class="row"> 
		<div class="label_wrapper cell">
			<label class="select_field"><?php echo $this->lang->line('Type');?></label>
		</div><!--label_wrapper-->

		<div class="cell frm_element_wrapper">
			<?php
				if(isset($showcseIscreated) && $showcseIscreated){
					$showcaseSuccessMsg = $this->lang->line('msgSuccessfully').'&nbsp;'.$this->lang->line('updated');
					$showcaseType=($values['enterprise']=='t')?$label['enterprise']:($values['associatedProfessional']=='t'?$label['associatedProfsional']:$label['creative']);
					?>
					<div class="row pt5">
					<div class="width300px"><?php echo $showcaseType;?></div>
					<div class="clear"></div>
					</div>
				<?php
					echo '<div class="row dn"> <input type="radio"   class="showOption" name="optionSelected" value="'.$values['optionSelected'].'" checked /> </div>';
				
				 }else{
					 $showcaseSuccessMsg = $this->lang->line('msgSuccessfully').'&nbsp;'.$this->lang->line('added');
				?>
					<div class="row width350px pt5">
						<div class="defaultP" id="<?php echo $label['creative']; ?>">
						  <input type="radio"  id="<?php echo $label['creative']; ?>" class="showOption " title="" name="optionSelected" value="1" <?php //if($values['optionSelected']==1) echo 'checked';?> />
						</div>	

						<div class="cell widthSpacer"> &nbsp;</div>
						
						<div class="cell">
						 <label class="lH25"><?php echo $label['creative'];?></label> 
						</div>				
						<div class="cell widthSpacer"> &nbsp;</div>
						 
						<div class="defaultP" id="<?php echo $label['associatedProfessional']; ?>">
							<input type="radio" id="<?php echo $label['associatedProfessional']; ?>" title="" class="showOption " name="optionSelected" value="2" <?php //if($values['optionSelected']==2) echo 'checked';?> />
						</div>				
						<div class="cell widthSpacer"> &nbsp;</div>
						
						<div class="cell">
						  <label class="lH25"><?php echo $label['associatedProfsional'];?></label>
						</div>			
						<div class="cell widthSpacer"> &nbsp;</div>
						
						<div class="defaultP" id="<?php echo $label['enterprise']; ?>">
							<input type="radio" id="<?php echo $label['enterprise']; ?>" class="showOption " title="" name="optionSelected" value="3" <?php //if($values['optionSelected']==3) echo 'checked';?> />					
						</div>					
						<div class="cell widthSpacer"> &nbsp;</div>
						
						<div class="cell">
							<label class="lH25"> <?php echo $label['enterprise'];?></label>
						</div>						
						<div class="cell widthSpacer"> &nbsp;</div>				
						
					  </div>
					  <div class="row error" id="errorOptionSelected"><?php //echo $this->lang->line('thisFieldIsReq');?></div>
				<?php
					echo '<div class="row f11 pt5">'.$this->lang->line('chooseShowcaseType').'</div>';

			}?>
	
		</div><!--from_element_wrapper-->  
	</div>
	
	
	<!-- FIRST NAME -->
	<div class="row"> 
		<div class="label_wrapper cell">
			<label class="select_field"><?php echo $label['firstName'];?></label>
		</div><!--label_wrapper-->

		<div class="cell frm_element_wrapper">
			
			<div class="small_btn mr0 mt5"><a target="_blank" href="<?php echo base_url(lang().'/dashboard/globalsettings')?>" class="formTip" title="<?php echo $this->lang->line('edit')?>" ><div class="cat_smll_edit_icon"></div></a></div><!--small_cross_btn_wp-->
			
			<div class="disable_div width527px"> <?php echo $values['firstName']?> </div>
			<?php //echo form_input($firstName); ?>
			<div class="row wordcounter">
				<?php //echo form_error($firstName['name']); ?>
				<?php // echo isset($errors[$firstName['name']])?$errors[$firstName['name']]:''; ?>
			</div>
		</div>
	</div><!--from_element_wrapper-->  
	
	<!-- LAST NAME -->
	<div class="row"> 
		<div class="label_wrapper cell">
			<label><?php echo $label['lastName'];?></label>
		</div><!--label_wrapper-->

		<div class="cell frm_element_wrapper">
			
			<div class="small_btn mr0 mt5"><a target="_blank" href="<?php echo base_url(lang().'/dashboard/globalsettings')?>" class="formTip" title="<?php echo $this->lang->line('edit')?>" ><div class="cat_smll_edit_icon"></div></a></div><!--small_cross_btn_wp-->	
			
			<div class="disable_div width527px"> <?php echo $values['lastName']?> </div>
			<?php //echo form_input($lastName); ?>
			<div class="row wordcounter">
				<?php // echo form_error($lastName['name']); ?>
				<?php // echo isset($errors[$lastName['name']])?$errors[$lastName['name']]:''; ?>
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
			$value=htmlentities(str_replace('\\','',$value));
			$tagWordsLabel = 'tagWords';
			$data=array('name'=>'tagwords','id'=>'tagwords','value'=>$value, 'view'=>'tag_words','labelText'=>$tagWordsLabel,'required'=>'required','addclass'=>'width556px rz required ');
			echo Modules::run("common/formInputField",$data);
	?> 

	<!-- FOCUS -->
	
	<?php
			$showLabel = $labelFocus;
			$creativeFocusValue=$creativeFocus['value']?$creativeFocus['value']:@$values['creativeFocus'];
			$value=htmlentities(str_replace('\\','',$value));
			$focusDesc=array('name'=>'creativeFocus','id'=>'focusId','value'=>$creativeFocusValue, 'view'=>'oneline_description','required'=>'required','labelText'=>$showLabel,'labelMsg'=>$this->lang->line('onelineDescriptionMsg'),'title'=>$focustoolTip,'addclass'=>'width556px rz formTip ');
			echo Modules::run("common/formInputField",$focusDesc);
			$browseImgJs = '_showcaseImgJs';
	?>
	
	<!-- PATH -->
	
	<?php 			
			if($values['optionSelected']==3)
			{
				$showPathLabel = 'Development Path';
			}else{
				$showPathLabel = $labelPath;
			}
			
			$creativePathValue = $creativePath['value']?$creativePath['value']:@$values['creativePath'];
			
			$wordOption = array('minVal'=>0,'maxVal'=>600,'wordLabel'=>$this->lang->line('0To500MsgNR'));
			
			$pathDesc = array('name'=>'creativePath','value'=>$creativePathValue, 'view'=>'description','labelText'=>$showPathLabel,'labelMsg'=>$label['optionMsg'],'id'=>"pathId",'required'=>'','wordOption'=>$wordOption,'addclass'=>'width556px rz formTip', 'addTitle'=>$this->lang->line('IfTheEnterpriseYouWork'));
			
			if($values['optionSelected']==2) $pathDesc = $pathDesc+array('addclass'=>'formTip','addTitle'=>$label['toolTipDP']);
			
			echo Modules::run("common/formInputField",$pathDesc);	 
			
			echo '<div class="seprator_25 row"></div>';
			$showProfileImage = LoginUserDetails('imagePath');
			if(is_file($showProfileImage)) $profileImageExists = 1;
			else  $profileImageExists = 0;
			
			//-----Commom Image View-----
			$showProfileThumbImage = addThumbFolder($showProfileImage,'_s');	
			$imgsrc = getImage($showProfileThumbImage,$defaultProfileImage);
			
			$img = '<img id="galImg_'.$browseImgJs.'" class="ma backgroundBlack" src="'.$imgsrc.'">';			
				
			
					
			$stockImageFlag = 1;
			if($showcaseId > 0){
				$required='';
			}else{
				$required='required';
			}
			$data=array('typeOfFile'=>1, 'imgSrc'=>$imgsrc, 'stockImageFlag'=>$stockImageFlag,'mediaFileTypes'=>$this->config->item('imageType'),'fileMaxSize'=>$fileMaxSize,'isEmbed'=>'f','fileName'=>'','fileSize'=>0,'filePath'=>$promoImagePath,'embedCode'=>'', 'required'=>$required, 'label'=>$this->lang->line('image'),'editFlag'=>0,'fileTypeFlag'=>0,'flag'=>1,'browseId'=>$browseImgJs,'imgload'=>1,'norefresh'=>0, 'view'=>'upload_ws_frm');
			echo Modules::run("common/formInputField",$data);
				
			//$this->load->view("mediatheme/promoImgFrmJs",$uploadFormData);
			//echo Modules::run("mediatheme/promoImgFrmJs",$label['image'],$img ,$inputArray,$browseImgJs,$stockImageFlag,0);
			
			echo '<div class="seprator_25 row"></div>';
?>
	<!-- Promotional Section SHOWN HERE -->
	<div class="row"> 
		<div class="label_wrapper cell" >
			<label><?php echo $label['aboutMe'];?></label>
		</div><!--label_wrapper-->
		
		<div class="cell frm_element_wrapper NIC">
			<div id="myNicPanel" class="cell bdr_e2e2e2 tmailtop_gradient p15 width_526px"></div>
			<!-- frm_element_wrapper_new minHeight300px   -->
			<div id="promotionalsectionDiv" class="  editordiv frm_Bdr minHeight300px width_536px" >
				<?php echo htmlspecialchars_decode(stripslashes($promotionalsection['value'])); ?>
			</div>
			<?php echo form_textarea($promotionalsection); ?>	
		</div>
	</div><!--from_element_wrapper--> 
	
	<div class="seprator_25 row"></div>
	<div class="row <?php echo $AESD;?>" id="AESD"> 
		<div class="label_wrapper cell"><label><?php echo $this->lang->line('associatEdenterprise');?></label></div>
		<div class="cell frm_element_wrapper">
			<div class="row">
				<?php $displaySearch=(isset($values['from_showcaseid']) && $values['from_showcaseid'] > 0)?'dn':'';?>
				<div id="displaySearchInputDiv" class="cell search_box_wrapper <?php echo $displaySearch;?>">
                    	<input id="searchEnterPrises" type="text" class="search_text_box" value="<?php echo $this->lang->line('keywordSearch');?>" placeholder="<?php echo $this->lang->line('keywordSearch');?>" onclick="placeHoderHideShow(this,'<?php echo $this->lang->line('keywordSearch');?>','hide')" onblur="placeHoderHideShow(this,'<?php echo $this->lang->line('keywordSearch');?>','show')">
                        <div class="search_btn_glass ptr" onclick="lightBoxWithAjax('popupBoxWp','popup_box','/search/searchontoadsquare/',$('#searchEnterPrises').val(),'<?php echo $this->config->item('enterprisesSectionId');?>','showcase','93');">
							<!--<img src="<?php //echo base_url('images/btn_search_box.png');?>">-->
                        </div>
                 </div>
                 
                 <div id="searchEnterPrisesDiv" class="cell pt8 pl20 pr20"><?php echo $values['EpName'];?></div>
                 <div id="row<?php echo $values['from_showcaseid']?>" class="cell pt8">
					 <?php
						if($values['from_showcaseid'] >0){
							 ?>
							  <div  class="small_btn formTip" title="<?php echo $this->lang->line('delete');?>"><a href="javascript:void(0)" onclick="deleteEP()"><div class="cat_smll_plus_icon"></div></a></div>
							<?php
						}
					 ?>
                 </div>
			</div>
			<input id="from_showcaseid" name="from_showcaseid" type="hidden" value="<?php echo isset($values['from_showcaseid'])?$values['from_showcaseid']:0;?>">
		</div>
		<div class="seprator_25 row"></div>	
	</div>
	
	<!-- Review Me And Recommend Me SHOWN HERE -->
	<div class="row"> 
		<div class="label_wrapper cell formTip bg_none" title="<?php /* echo $this->lang->line('addButtonToolTip'); */?>">
			<!--<label><?php /* echo $label['addButton']; */?></label>-->
		</div>
		<!--label_wrapper-->

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
	
	<?php /* ?>
		<div class="row"> 
			<div class="label_wrapper cell bg_none">
					<!--<label><?php // echo $label['sendNotifWhen']; ?></label>-->
			</div><!--label_wrapper-->

			<div class="cell frm_element_wrapper">
				<div class="cell" style="padding: 3px 0 0 2px;" ><div class="defaultP"><?php echo form_checkbox($sendNotificationtoCraved);?></div></div>
				<div class="cell mt5" style="padding: 0 0 0 2px;" ><?php echo $label['sendNotificationtoCraved'];?></div>
			</div>		
		</div>
	<?php */ ?>
	
	<!--from_element_wrapper--> 
	
	<!-- Send Notification to Craved SHOWN HERE -->
	<?php /* ?>
	<div class="row"> 
		<div class="label_wrapper cell bg_none">
			<!--<label><?php // echo $label['receiveNotification']; ?></label>-->
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
	
	<?php */ ?>
	
	<div class="seprator_15 row"></div>
	<div class="row">
		<div class="label_wrapper cell bg_none"></div>
		<div class='cell frm_element_wrapper'>
		<div class="Req_fld cell"><?php echo $this->lang->line('RequiredFields');?>	</div>
		<div class="label_wrapper cell bg_none"></div>
		<div class="cell width96px">
			<?php
			if($values['isPublished'] !='t'){
				if(isset($showcseIscreated) && $showcseIscreated){	
					$section = 'showcase';
					$projectType=($values['enterprise']=='t')?'enterprises':($values['associatedProfessional']=='t'?'associatedprofessionals':'creatives');
					$notificationArray=array('entityId'=>$entityId,'elementId'=>$values['showcaseId'],'industryId'=>0,'projectType'=>$projectType);
				
					$publisButton=array('currentStatus'=>$this->lang->line('Publish'),'changeStatus'=>$this->lang->line('hide'),'isPublished'=>'t','tabelName'=>'UserShowcase','pulishField'=>'isPublished','field'=>'showcaseId','fieldValue'=>$values['showcaseId'],'deleteCache'=>'', 'assignClass'=>'fmoss black_link_hover','section'=>$section,'notificationArray'=>$notificationArray);						
					$unpublisButton=array('currentStatus'=>$this->lang->line('hide'),'changeStatus'=>$this->lang->line('Publish'),'isPublished'=>'f','tabelName'=>'UserShowcase','pulishField'=>'isPublished','field'=>'showcaseId','fieldValue'=>$values['showcaseId'],'deleteCache'=>'', 'assignClass'=>'fmoss black_link_hover','section'=>$section,'notificationArray'=>$notificationArray);						
					
					?>
					<!--<div id="PublishButton<?php echo $uniqueId;?>" class="cell fr PublishButton" <?php echo $pDisplay; ?>>
						<?php  $this->load->view('common/publishUnpublish',$publisButton); ?>
					</div>-->
					
					<div id="UnPublishButton<?php echo $uniqueId;?>" class=" cell fr UnPublishButton" <?php echo $upDisplay; ?>>
						<?php $this->load->view('common/publishUnpublish',$unpublisButton);?>
					</div>
			
					<?php
				}else{ ?>
					<div class="tds-button fr opacity_4" ><a href="javascript:void(0);" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)"><span  class="publishUnpublishSpan orange_clr_imp font_opensans "><?php echo $this->lang->line('Publish');?></span></a></div>
					<?php
					
				}
			}
			?> 
		</div>
		<input type="hidden" id="radioSelected" value="" name="radioSelected" />
		<input type="hidden" id="save" value="" name="save" />
		<input type="hidden" id="stockImageId" value="" name="stockImageId" />
		
		<?php
			$button = array('ajaxSave','buttonId'=>'_showcase');
			
			if(isset($showcseIscreated) && $showcseIscreated){	
				$buttonsVS=array_merge($button,array('viewButton','viewUrl'=>base_url(lang().'/showcase/aboutme/'.$userId)));				
				$buttonsPS=array_merge($button,array('preview','previewUrl'=>base_url(lang().'/showcase/preview/'.$userId),'isPublished'=>'t'));	
				?>
				<div id="viewIcon<?php echo $uniqueId;?>" class="viewIcon" <?php echo $viewDisplay;?>>
					<?php $this->load->view("common/button_collection",array('button'=>$buttonsVS));	?>
				</div>
				<div id="previewIcon<?php echo $uniqueId;?>" class="previewIcon" <?php echo $previewDisplay;?> >
					<?php $this->load->view("common/button_collection",array('button'=>$buttonsPS));	?>
				</div>
				<?php
			
			}else{
				$buttons=($values['isPublished']=='t')?array_merge($button,array('viewButton','viewUrl'=>base_url(lang().'/showcase/aboutme/'.$userId))):array_merge($button,array('preview','previewUrl'=>base_url(lang().'/showcase/preview/'.$userId),'isPublished'=>$values['isPublished']));
				$this->load->view("common/button_collection",array('button'=>$buttons));				
			}
			
		?>	
		<?php echo form_close(); ?>		
		</div>
	</div>
	<div class="row">
		<div class="label_wrapper cell bg_none lineH_Inherit heightAuto mt100"><?php
/*How to publish popup*/
	//$this->load->view('common/howToPublish',array('industryType'=>'showcase'));
/*End How to publish popup */
?>	</div>
		<div class='cell frm_element_wrapper'>
			<div class="pt5">
				<div class="row height25">
					<div class="cell">*&nbsp;</div>
					<div class="cell" ><?php echo $this->lang->line('beforeYouCanSaveShowcase');?></div>
				</div>
				<!--<div class="row height45">
						<div class="cell width_8">*&nbsp;</div>
						<div class="cell width525px" >
							<?php //echo $this->lang->line('townCountryCitySettingbfr');?>&nbsp;<a target="_blank" href="<?php //echo base_url(lang().'/dashboard/globalsettings')?>" class="underline dash_link_hover"><?php //echo $this->lang->line('townCountryCitySettinglink');?></a>.&nbsp;
							
							<?php //echo $this->lang->line('townCountryCitySettingaftr');?>&nbsp;
							<!--<a target="_blank" href="<?php //echo base_url(lang().'/dashboard/globalsettings')?>" class="underline"><?php //echo $this->lang->line('townCountryCitySettinglink')?></a>,&nbsp;<?php// echo $this->lang->line('townCountryCitySettingaftrTwo');?>
						</div>
					</div>-->
			<?php  
			if($values['isPublished']!='t') { ?>
				<div class="row height25" id="publishUnpublishMsg"><div class="cell width_8">*&nbsp;</div><div class="cell width525px" ><?php echo $this->lang->line('publishUnpublishSetting');?></div></div>
				<?php  
			} ?>
			</div>

			<div class="row blog_links_wrapper">
				<div class="fl  cell">
					
					<?php
					 $slink=base_url(lang().'/showcase/aboutme/'.$userId);
					 $relation = array('getShortLink', 'email','share','entityTitle'=> 'Showcase','shareLink'=> $slink,'id'=> 'Showcase','isPublished'=>$values['isPublished']);
					 ?>
					
					<div id="relationToSharePublish<?php echo $uniqueId;?>" class="row rtsp" <?php echo $rtspDisplay; ?> >
						<?php $relation['isPublished']='t';
						 $this->load->view('common/relation_to_share',array('relation'=>$relation));
						 ?>
					</div>
					
					<div id="relationToShareUnPublish<?php echo $uniqueId;?>" class="row rtsup" <?php echo $rtsupDisplay; ?>>
						<?php $relation['isPublished']='f';
						 $this->load->view('common/relation_to_share',array('relation'=>$relation));
						 ?>
					</div>
				</div>
					
				<div class="fr mt5 width_240 tal"><a href="<?php echo site_url(lang()).'/dashboard';?>" class="orange gray_clr_hover" target="_blank"><?php echo $this->lang->line('addMultilingualIns');?></a></div>
			</div> 		
		</div>
	</div>
	<div class="clear seprator_25"></div>
	
	</div><!-- End form_wrapper -->
<?php 
	$proImgJSPath = $profileJsImagePath;
?>

<script type="text/javascript">
	bkLib.onDomLoaded(function() {
	var myNicEditor = new nicEditor({buttonList : ['html','save','bold','italic','underline','left','center','right','justify','ol','ul','fontSize','fontFamily','fontFormat','indent','outdent','subscript','superscript','strikethrough','removeformat','hr','link','unlink','forecolor']});
	myNicEditor.setPanel('myNicPanel');
	myNicEditor.addInstance('promotionalsectionDiv'); 
	
	//myNicEditor.panelInstance('promotionalsection');
});
</script>
<script>
function deleteEP(){
	var del = deleteTabelRow('AssociatedEnterprise','from_showcaseid','<?php echo $values['from_showcaseid'];?>');
	if(del){
		var from_showcaseid = $('#from_showcaseid').val();
		$('#from_showcaseid').val(0);
		$('#searchEnterPrisesDiv').html('');
		$('#displaySearchInputDiv').show();
		$('#row'+from_showcaseid).hide();
	}
}
$(document).ready(function(){
	
	  $("#showcaseForm").validate({
		groups: {
			optionSelected: "optionSelected"
		},
		errorPlacement: function(error, element) {
			if (element.attr("name") == "optionSelected" )
				error.insertAfter("#errorOptionSelected");
			else
				error.insertAfter(element);
		},

		rules: {
			optionSelected: {
				required: true				
			}
		},
		messages: {
			
				tagwords: "<?php echo $this->lang->line('requires_3_25_words');?>",
				creativeFocus: "<?php echo $this->lang->line('requires_3_50_words');?>"
		},
		submitHandler: function() {
		
			var divContent = $('#promotionalsectionDiv').html().replace(/^\s+|\s+$/g,"");
			var fileType = 2;	
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
			
			//var sendNotificationtoCraved = $('#sendNotificationtoCraved:checked').val()?'t':'f'; 
			var sendNotificationtoCraved ='t'; 
			
			//var reviewMyMedia = $('#reviewMyMedia:checked').val()?'t':'f'; 
			var reviewMyMedia = 't'; 
			
			var memberReviewMe = $('#memberReviewMe:checked').val()?'t':'f';						
			
			var optionSelected = $('input:radio[name=optionSelected]:checked').val();	
						
			
			var creative = 'f';
			var associatedProfessional = 'f';
			var enterprise = 'f';
			
			if(optionSelected==1){
				creative = 't';
			}else if(optionSelected==2){
				associatedProfessional = 't';
			}else if(optionSelected==3){
				enterprise = 't';
			}
					
			if(elementId ==0)
				var data = {"creative":creative,"associatedProfessional":associatedProfessional,"enterprise":enterprise,"optionSelected":optionSelected,"enterpriseName":$('#enterpriseName').val(),"optionAreaName":$('#optionAreaName').val(),"tagwords":$('#tagwords').val(),"creativeFocus":$('#creativeFocus').val(),"creativePath":$('#pathId').val(),"profileImageName":profileImageName,"reviewMe":reviewMe,"recommendMe":recommendMe,"sendNotificationtoCraved":sendNotificationtoCraved,"reviewMyMedia":reviewMyMedia,"memberReviewMe":memberReviewMe,"promotionalsection":divContent,"stockImageId":stockImageId,"tdsUid":<?php echo $userId; ?>,"dateCreated":'<?php echo currntDateTime(); ?>',"dateModified":'<?php echo currntDateTime(); ?>'}; 
			else
				var data = {"creative":creative,"associatedProfessional":associatedProfessional,"enterprise":enterprise,"optionSelected":optionSelected,"showcaseId":elementId,"enterpriseName":$('#enterpriseName').val(),"optionAreaName":$('#optionAreaName').val(),"tagwords":$('#tagwords').val(),"creativeFocus":$('#creativeFocus').val(),"creativePath":$('#pathId').val(),"profileImageName":profileImageName,"promotionalsection":divContent,"reviewMe":reviewMe,"recommendMe":recommendMe,"sendNotificationtoCraved":sendNotificationtoCraved,"reviewMyMedia":reviewMyMedia,"memberReviewMe":memberReviewMe,"stockImageId":stockImageId,"tdsUid":<?php echo $userId; ?>,"dateModified":'<?php echo currntDateTime(); ?>'}; 							
			
			// Gets the number of elements with class yourClass
			var AEdata = {"from_showcaseid":$('#from_showcaseid').val(),"to_showcaseid":"<?php echo $showcaseId; ?>","created_date":"<?php echo currntDateTime(); ?>"}; 
			if($('#fileError<?php echo @$browseImgJs;?>').text()=='')
			var returnFlag = AJAX('<?php echo base_url(lang()."/showcase/UpdateShowcaseTable");?>','',AEdata,'',data,'loadVideo',elementId,elementTable,elementFieldId,'','','','','<?php echo $browseImgJs;?>');	
			if(returnFlag){
				$("#uploadFileByJquery<?php echo $browseImgJs;?>").click();
				if($('#fileName<?php echo $browseImgJs;?>').val() ==''){refreshPge();}
				
				$('#messageSuccessError').html('<div class="successMsg"><?php echo $showcaseSuccessMsg; ?></div>');
				timeout = setTimeout(hideDiv, 5000);
			}
			return false;
		}
		
	});
	
	$(".showOption").click(function(){
		   var optionSelected = $('input:radio[name=optionSelected]:checked').val();
			var creativeareatt = '<?php echo $this->lang->line('CreativetoolTip');?>';
			var associatedProfessionalareatt='<?php echo $this->lang->line('AssociatetoolTip');?>';
			var enterpriseareatt='<?php echo $this->lang->line('EnterprisetoolTip');?>';

			var pathIdCreativett='<?php echo $this->lang->line('pathIdCreativett');?>';
			var pathIdAssociatedtt='<?php echo $this->lang->line('pathIdCreativett');?>';
			var pathIdEnterprisett='<?php echo $this->lang->line('pathIdEnterprisett');?>';
			
			$('#AESD').show();
		
			if(optionSelected==1){
				$('#optionAreaName').attr('original-title',creativeareatt);
				$('#pathId').attr('original-title',pathIdCreativett);
				<?php if($profileImageExists==0){ ?>
				var new_img_src = baseUrl+'/<?php echo $this->config->item('defaultCreativeImg_s');?>';
				$('#galImg_<?php echo $browseImgJs?>').attr('src',new_img_src);
				<?php } ?>
				
			}else if(optionSelected==2){
				$('#optionAreaName').attr('original-title',associatedProfessionalareatt);
				$('#pathId').attr('original-title',pathIdAssociatedtt);
				<?php if($profileImageExists==0){ ?>
				var new_img_src = baseUrl+'/<?php echo $this->config->item('defaultAssoProfImg_s');?>';
				$('#galImg_<?php echo $browseImgJs?>').attr('src',new_img_src);
				<?php } ?>
			}else if(optionSelected==3){
				$('#AESD').hide();
				$('#optionAreaName').attr('original-title',enterpriseareatt);
				$('#pathId').attr('original-title',pathIdEnterprisett);
				<?php if($profileImageExists==0){ ?>
				var new_img_src = baseUrl+'/<?php echo $this->config->item('defaultEnterpriseImg_s');?>';
				$('#galImg_<?php echo $browseImgJs?>').attr('src',new_img_src);
				<?php } ?>
			}
			
		});	
});
	
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
			var optionSelected = $('input:radio[name=optionSelected]:checked').val();	
			var creativeareatt = '<?php echo $this->lang->line('CreativetoolTip');?>';
			var associatedProfessionalareatt='<?php echo $this->lang->line('AssociatetoolTip');?>';
			var enterpriseareatt='<?php echo $this->lang->line('EnterprisetoolTip');?>';

			var pathIdCreativett='<?php echo $this->lang->line('pathIdCreativett');?>';
			var pathIdAssociatedtt='<?php echo $this->lang->line('pathIdCreativett');?>';
			var pathIdEnterprisett='<?php echo $this->lang->line('pathIdEnterprisett');?>';

			
			if(optionSelected==1){
				$('#optionAreaName').attr('original-title',creativeareatt);
				$('#pathId').attr('original-title',pathIdCreativett);
				<?php if($profileImageExists==0){ ?>
				var new_img_src = baseUrl+'/<?php echo $this->config->item('defaultCreativeImg_s');?>';
				$('#galImg_<?php echo $browseImgJs?>').attr('src',new_img_src);
				<?php } ?>
				$('#creativeFocus').attr('original-title','<?php echo $this->lang->line('creativeFocusToolTip');?>');
				
			}else if(optionSelected==2){
				$('#optionAreaName').attr('original-title',associatedProfessionalareatt);
				$('#pathId').attr('original-title',pathIdAssociatedtt);
				<?php if($profileImageExists==0){ ?>
				var new_img_src = baseUrl+'/<?php echo $this->config->item('defaultAssoProfImg_s');?>';
				$('#galImg_<?php echo $browseImgJs?>').attr('src',new_img_src);
				<?php } ?>
				$('#creativeFocus').attr('original-title','<?php echo $this->lang->line('associateFocusToolTip');?>');
			}else if(optionSelected==3){
				$('#optionAreaName').attr('original-title',enterpriseareatt);
				$('#pathId').attr('original-title',pathIdEnterprisett);
				<?php if($profileImageExists==0){ ?>
				var new_img_src = baseUrl+'/<?php echo $this->config->item('defaultEnterpriseImg_s');?>';
				$('#galImg_<?php echo $browseImgJs?>').attr('src',new_img_src);
				<?php } ?>
				$('#creativeFocus').attr('original-title','<?php echo $this->lang->line('enterpriseFocusToolTip');?>');
			}
			
		});		   
		
	});
	
	function showstockimages(){
		$("#stockImagesBoxWp").lightbox_me('center:true');
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
