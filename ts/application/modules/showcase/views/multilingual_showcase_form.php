<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

if(isset($langValues['showcaseLangId']) && is_numeric($langValues['showcaseLangId'])){
	$showcaseLangId = $langValues['showcaseLangId'];
}else{
	 $showcaseLangId = 0;
}
$uniqueId='element'.$showcaseLangId;
$entityId = getMasterTableRecord('UserShowcaseLang');
$multiligualFrmAttr = array(
	'name' => 'multiligualShowcaseForm',
	'id' => 'multiligualShowcaseForm'
);

if($defaultValues['optionSelected']==1) 
{
	$labelOption = $label['area'].' '.$label['ofInterest'];
	$labelFocus =  'creativeFocus';
	$labelPath = 'creativePath';
	$enterpriseStyle =  'style="display:none;"';
	$defaultProfileImage = $this->config->item('defaultCreativeImg_s');
	$CreativetoolTip=$this->lang->line('CreativetoolTip');
	$focustoolTip=$this->lang->line('creativeFocusToolTip');	
}

if($defaultValues['optionSelected']==2) 
{
	$labelOption = $label['area'].' '.$label['ofInterest'];
	$labelFocus = 'associatedProfessionalFocus';
	$labelPath = 'associatedProfessionalPath';
	$enterpriseStyle =  'style="display:none;"';
	$defaultProfileImage = $this->config->item('defaultAssoProfImg_s');
	$CreativetoolTip=$this->lang->line('AssociatetoolTip');
	$focustoolTip=$this->lang->line('associateFocusToolTip');
	
}

if($defaultValues['optionSelected']==3)
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

$isPublishedInput = array(
	'name'	=> 'isPublished',
	'id'	=> 'isPublished',	
	'value'	=> (isset($langValues['isPublished']) && $langValues['isPublished']=='t')?'t':'f',
	'type'=>'hidden'
);
$langAbbr = array(
	'name'	=> 'lang',
	'id'	=> 'lang',	
	'value'	=> set_value('langAbbr',$langValues['lang']),
	'type'=>'hidden'
);

$optionAreaName = array(
	'name'	=> 'optionAreaName',
	'id'	=> 'optionAreaName',
	'class' => 'frm_Bdr required width556px formTip',
	'value'	=> set_value('optionAreaName',$langValues['optionAreaName']),
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
	'value'	=> set_value('tagwords',$langValues['tagwords']),
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
	'value'	=> set_value('creativeFocus',$langValues['creativeFocus']),
	'minlength'	=> 10,
	'rows'	=> 5,
	'wordlength'=>"10,50",
	'onkeyup'=>"checkWordLen(this,50,'creativeFocusLimit')"
);

$promotionalsection = array(
	'name'	=> 'promotionalsection',
	'id'	=> 'promotionalsection',
	'value'	=> set_value('promotionalsection',html_entity_decode(isset($langValues['promotionalsection'])?$langValues['promotionalsection']:'')),
	'size'	=> 30,
	'cols' => 70,
	'rows' => 20,
	'class' => 'formTip textarea  frm_Bdr required',
	'style' => 'border: 1px solid #A0A0A0;outline: 3px solid #E1E1E1; display:none;',
	'title'       => 'Promotional Description',
);

$creativePath = array(
	'name'	=> 'creativePath',
	'id'	=> 'creativePath',
	'class'	=> 'BdrCommonTextarea heightAuto rz error clear:both; formTip',
	'value'	=> set_value('creativePath',$langValues['creativePath']),
	'minlength'	=> 75,
	'rows'	=> 5,
	'wordlength'=>"75,500",
	'onkeyup'=>"checkWordLen(this,500,'creativePathLimit')"
);

if(isset($langValues['isPublished']) && $langValues['isPublished'] == 't'){
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

$showcaseLanguage = 'showcaseLanguage';
$originalLanguageList = getMultilingualLanguageListing($langValues['langId']);

$langValue = $langValues['langId'];
$userId = isLoginUser();
?>
<div id="multilangualMsg" class="f16 ml34 orange_color fm_os tac"></div>
<div class="row">
	<div class="cell frm_heading">
		<h1>Multilingual Showcase</h1>
	</div>
</div>
<div class="row position_relative">	
	<?php 
	echo Modules::run("common/strip");
	echo form_open_multipart($this->uri->uri_string(),$multiligualFrmAttr);
	echo form_input($langAbbr);
	echo form_input($isPublishedInput);
	?>
	<div class="row"> 
		<div class="label_wrapper cell">
			<label class="select_field"><?php echo $this->lang->line('Type');?></label>
		</div><!-- label_wrapper -->
		<div class="cell frm_element_wrapper">
			<?php
				$showcaseType=($defaultValues['enterprise']=='t')?$label['enterprise']:($defaultValues['associatedProfessional']=='t'?$label['associatedProfsional']:$label['creative']);
				echo '<div class="row pt5">'.$showcaseType.'</div>';
			?>			
		</div><!-- from_element_wrapper -->  
	</div><!-- row --> 
	
	<!-- FIRST NAME -->
	<div class="row"> 
		<div class="label_wrapper cell">
			<label class="select_field"><?php echo $label['firstName'];?></label>
		</div><!--label_wrapper-->

		<div class="cell frm_element_wrapper"> 
			<div class="disable_div width527px"> <?php echo LoginUserDetails('firstName');?> </div>
		</div>
	</div><!--from_element_wrapper-->  

	<!-- LAST NAME -->
	<div class="row"> 
		<div class="label_wrapper cell">
			<label><?php echo $label['lastName'];?></label>
		</div><!--label_wrapper-->

		<div class="cell frm_element_wrapper">
			<div class="disable_div width527px"> <?php echo LoginUserDetails('lastName');?> </div>
		</div>
	</div><!--from_element_wrapper--> 


	<!-- Language field row -->
	<div class="row">
		<div class="label_wrapper cell">
			<label class="select_field"><?php echo $label['language']; ?></label>
		</div><!--label_wrapper-->
		<div class="cell frm_element_wrapper">						
			<?php 
			 echo form_dropdown($showcaseLanguage , $originalLanguageList, set_value($showcaseLanguage , ( ( !empty($langValue) ) ? "$langValue" : 0 )),'id="showcaseLanguage" class="required error"');
			 echo form_error($showcaseLanguage); 
			?>			
		</div>
	</div><!-- row -->


	<!-- OPTION TO GET SHOWN HERE -->
	<div class="row"> 
		<div class="label_wrapper cell" id="areaId">
			<label class="select_field"><?php echo $labelOption;?></label>
		</div><!--label_wrapper-->

		<div class="cell frm_element_wrapper">
			<?php
			if($defaultValues['optionSelected']==2) $optionAreaName = $optionAreaName+array('title'=>$label['toolTipAOI']);
			if($defaultValues['optionSelected']==2) $optionAreaName = $optionAreaName+array('title'=>$label['toolTipAOI']);
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
		$value=$tagwords['value']?$tagwords['value']:$langValues['tagwords'];
		
		$value=htmlentities(str_replace('\\','',$value));
		$tagWordsLabel = 'tagWords';
		$data=array('name'=>'tagwords','id'=>'tagwords','value'=>$value, 'view'=>'tag_words','labelText'=>$tagWordsLabel,'required'=>'required','addclass'=>'width556px rz required ');
		echo Modules::run("common/formInputField",$data);
	?> 

	<!-- FOCUS -->
	
	<?php
		$showLabel = $labelFocus;
		$creativeFocusValue=$creativeFocus['value']?$creativeFocus['value']:$langValues['creativeFocus'];
		
		$value=htmlentities(str_replace('\\','',$value));
		$focusDesc=array('name'=>'creativeFocus','id'=>'focusId','value'=>$creativeFocusValue, 'view'=>'oneline_description','required'=>'required','labelText'=>$showLabel,'labelMsg'=>$this->lang->line('onelineDescriptionMsg'),'title'=>$focustoolTip,'addclass'=>'width556px rz formTip ');
		echo Modules::run("common/formInputField",$focusDesc);
		$browseImgJs = '_showcaseImgJs';
	?>
	
	<!-- PATH -->
	
	<?php 			
		if($defaultValues['optionSelected']==3)
		{
			$showPathLabel = 'Development Path';
		}else{
			$showPathLabel = $labelPath;
		}
		//$creativeFocusValue=$creativeFocus['value']?$creativeFocus['value']:$langValues['creativeFocus'];
		$creativePathValue = $langValues['creativePath'];
		
		$wordOption = array('minVal'=>0,'maxVal'=>600,'wordLabel'=>$this->lang->line('0To500MsgNR'));
		
		$pathDesc = array('name'=>'creativePath','value'=>$creativePathValue, 'view'=>'description','labelText'=>$showPathLabel,'labelMsg'=>$label['optionMsg'],'id'=>"pathId",'required'=>'','wordOption'=>$wordOption,'addclass'=>'width556px rz formTip', 'addTitle'=>$this->lang->line('IfTheEnterpriseYouWork'));
		
		if($defaultValues['optionSelected']==2) $pathDesc = $pathDesc+array('addclass'=>'formTip','addTitle'=>$label['toolTipDP']);
		
		echo Modules::run("common/formInputField",$pathDesc);		
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
				<?php echo $langValues['promotionalsection']; ?>
			</div>
			<?php echo form_textarea($promotionalsection); ?>	
		</div>
	</div><!--from_element_wrapper--> 
	
	<div class="seprator_15 row"></div>
	<div class="row">
		<div class="label_wrapper cell bg_none"></div>
		<div class='cell frm_element_wrapper'>
			<div class="Req_fld cell"><?php echo $this->lang->line('RequiredFields');?>	</div>
			<div class="label_wrapper cell bg_none"></div>
			<div class="cell width75px">
				<?php
				
				
				
				
				if(isset($langValues['showcaseLangId']) && !empty($langValues['showcaseLangId'])){
					if($langValues['isPublished']!='t'){
						$section = 'showcase';
						$notificationArray = array('entityId'=>$entityId,'ownerId'=>$langValues['tdsUid'],'elementId'=>$langValues['showcaseLangId'],'projectId'=>$langValues['showcaseId'],'industryId'=>0,'projectType'=>'showcase','alert_type'=>'element');
						
						$publisButton=array('currentStatus'=>$this->lang->line('Publish'),'changeStatus'=>$this->lang->line('hide'),'isPublished'=>'t','tabelName'=>'UserShowcaseLang','pulishField'=>'isPublished','field'=>'showcaseLangId','fieldValue'=>$langValues['showcaseLangId'],'assignClass'=>'mr_18','isElement'=>1,'elementTable'=>'', 'elementField'=>'','section'=>$section,'notificationArray'=>$notificationArray);
						
						$unpublisButton=array('currentStatus'=>$this->lang->line('hide'),'changeStatus'=>$this->lang->line('Publish'),'isPublished'=>'f','tabelName'=>'UserShowcaseLang','pulishField'=>'isPublished','field'=>'showcaseLangId','fieldValue'=>$langValues['showcaseLangId'],'assignClass'=>'mr_18','isElement'=>1,'elementTable'=>'', 'elementField'=>'','section'=>$section,'notificationArray'=>$notificationArray);
						?>
						<!--<div id="PublishButton<?php echo $uniqueId;?>" class="cell fr PublishButton" <?php echo $pDisplay; ?>>
							<?php  $this->load->view('common/publishUnpublish',$publisButton); ?>
						</div>-->
						
						<div id="UnPublishButton<?php echo $uniqueId;?>" class=" cell fr UnPublishButton" <?php echo $upDisplay; ?>>
							<?php $this->load->view('common/publishUnpublish',$unpublisButton);?>
						</div>
				
						<?php	
					
					}
				}else { ?>
					<div class="tds-button fr opacity_4 mr_18" ><a href="javascript:void(0);" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)"><span  class="publishUnpublishSpan font_opensans "><?php echo $this->lang->line('Publish');?></span></a></div>
				<?php } ?> 
			</div>
			<input type="hidden" id="showcaseLangId" name="showcaseLangId" value="<?php echo $langValues['showcaseLangId'];?>">			
			<?php
			$button = array('ajaxSave','buttonId'=>'_showcase');
			if(isset($langValues['showcaseLangId']) && !empty($langValues['showcaseLangId'])){
				$buttonsVS=array_merge($button,array('viewButton','viewUrl'=>base_url(lang().'/showcase/index/'.$userId.'/'.$langValues['showcaseLangId'])));
				$buttonsPS=array_merge($button,array('preview','previewUrl'=>base_url(lang().'/showcase/preview/'.$userId.'/'.$langValues['showcaseLangId'],'index'),'isPublished'=>'t'));
				?>
				<div id="viewIcon<?php echo $uniqueId;?>" class="viewIcon" <?php echo $viewDisplay;?>>
					<?php $this->load->view("common/button_collection",array('button'=>$buttonsVS));	?>
				</div>
				<div id="previewIcon<?php echo $uniqueId;?>" class="previewIcon" <?php echo $previewDisplay;?> >
					<?php $this->load->view("common/button_collection",array('button'=>$buttonsPS));	?>
				</div>
				<?php	
			}else{		
				$this->load->view("common/button_collection",array('button'=>$button));
			}
			?>
		</div>
	</div>
<!--Required field instruction -->
<div class="row">
	<div class="label_wrapper cell bg_none"></div>
	<div class="pl20 fl">
		<div class="cell">*&nbsp;</div>
		<div class="cell" ><?php echo $this->lang->line('beforeYouCanSaveShowcase');?></div>
	</div>
	<div>
		<!--Link to showcase--> 
		<div class="fr width_240 tar mr10"><a href="<?php echo site_url(lang()).'/showcase/showcaseForm';?>" class="orange gray_clr_hover" target="_blank"><?php echo $this->lang->line('mainShowcasePage');?></a>
		</div>
	</div>
</div>	
	
<div class="seprator_20 row"></div>
<?php
echo form_close();
?>

</div>
<!--add script for Editor -->
<script type="text/javascript">
		bkLib.onDomLoaded(function() {
	var myNicEditor = new nicEditor({buttonList : ['html','save','bold','italic','underline','left','center','right','justify','ol','ul','fontSize','fontFamily','fontFormat','indent','outdent','subscript','superscript','strikethrough','removeformat','hr','link','unlink','forecolor']});
	myNicEditor.setPanel('myNicPanel');
	myNicEditor.addInstance('promotionalsectionDiv'); 
});
</script>
<!--End Editor script -->

<script>
	$(document).ready(function(){
	$("#multiligualShowcaseForm").validate({
		 submitHandler: function() {
			var fromData=$("#multiligualShowcaseForm").serialize(); 
			var divContent = $('#promotionalsectionDiv').html().replace(/^\s+|\s+$/g,"");
			var multiLangId = $('#showcaseLangId').val();
			var userId = <?php echo $userId;?>;
			fromData = fromData+'&promotionalsection1='+divContent;
			$.post(baseUrl+language+'/showcase/save_multilangual_form',fromData, function(data) {
				if(data){
					if(data!=0){
						multiLangId=$.trim(data);
					}
			window.location.href=baseUrl+language+'/showcase/multilingaul_showcase_form/'+userId+'/'+multiLangId;
			  }
			});
		 }
	});
});	
</script>
