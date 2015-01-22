<?php

$workTitleArr = array(
	'name'	=> 'workTitle',
	'id'	=> 'workTitle',
	'value'	=> set_value('workTitle',$workTitle),
	'maxlength'	=> 80,
	'size'	=> 30,
	'class'       => 'width556px required'
	
);
$workCityArr = array(
	'name'	=> 'workCity',
	'id'	=> 'workCity',
	'value'	=> $workCity,
	'maxlength'	=> 80,
	'size'	=> 30,
	'class'       => 'width246px required'
	
);

$workShortDescArr = array(
	'name'	=> 'workShortDesc',
	'id'	=> 'workShortDesc',
	'value'	=> $workShortDesc,
	'rows'      => 2,
    'cols'      => 65,
	'class'       => 'width556px heightAuto rz required ',
	'wordlength'=>"5,30",
 	'onkeyup'=>"getRemainingLen(this,30,'oneLineDescLimit')",
);

$workTagArr = array(
	'name'	=> 'workTag',
	'id'	=> 'workTag',
	'value'	=> $workTag,
	'rows'      => 5,
    'cols'      => 65,
	'class'       => 'width556px heightAuto rz required ',
	'wordlength'=>"5,50",
	'onkeyup'=>"getRemainingLen(this,50,'tagLimit')",
);

$workDescArr = array(
	'name'	=> 'workDesc',
	'id'	=> 'workDesc',
	'value'	=> set_value('workDesc',$workDesc),
	'cols' => 65,
	'rows' => 5,
	'style' => 'width:0;height:0;visibility:hidden',
	/*'class'       => 'width556px required heightAuto rz formTip textarea',*/
	'class'       => 'required'
);

$workTypeDescArr = array(
	'name'	=> 'workTypeDesc',
	'id'	=> 'workTypeDesc',
	'value'	=> set_value('workTypeDesc',@$workTypeDesc),
	'cols' => 65,
	'rows' => 5,
	'style' => 'width:0;height:0;visibility:hidden',
	/*'class'       => 'width556px required heightAuto rz formTip textarea',*/
	'class'       => 'required'
);

$workCompanyArr = array(
	'name'	=> 'workCompany',
	'id'	=> 'workCompany',
	'value'	=> $workCompany,
	'maxlength'	=> 80,
	'size'	=> 20,
	'class'       => 'width246px'

	
);

$workLang1Arr = array(
	'name'	=> 'workLang1',
	'id'	=> 'workLang1',
	'value'	=> $workLang1,
	'maxlength'	=> 80,
	'size'	=> 30
	
);

$workCountryIdArr = array(
	'name'	=> 'workCountryId',
	'id'	=> 'workCountryId',
	'value'	=> $workCountryId,
	'maxlength'	=> 80,
	'size'	=> 30,
	'class'       => 'single dropDown  required '	
);

$workLang2Arr = array(
	'name'	=> 'workLang2',
	'id'	=> 'workLang2',
	'value'	=> $workLang2,
	'maxlength'	=> 80,
	'size'	=> 30	
);
/*$workLang3Arr = array(
	'name'	=> 'workLang3',
	'id'	=> 'workLang3',
	'value'	=> $workLang3,
	'maxlength'	=> 80,
	'size'	=> 30
	
);*/
$workRemunerationArr = array(
	'name'	=> 'workRemuneration',
	'id'	=> 'workRemuneration',
	'value'	=> $workRemuneration,
	'maxlength'	=> 15,
	'size'	=> 30,
	'class'       => 'width246px',
	//'onChange' => 'javascript:trimValue();'
);

$workReviewArr = array(
	'name'	=> 'workReview',
	'id'	=> 'workReview',
	'value'	=> $workReview,
	'maxlength'	=> 80,
	'size'	=> 30,
	'class'  => 'width246px cell'
);

$workRecommendationArr = array(
	'name'	=> 'workRecommendation',
	'id'	=> 'workRecommendation',
	'value'	=> $workRecommendation,
	'maxlength'	=> 80,
	'size'	=> 30,
	'class'       => 'width246px'
	
);
$workIndustryIdArr = array(
	'name'	=> 'workIndustryId',
	'id'	=> 'workIndustryId',
	'value'	=> $workIndustryId,
	'maxlength'	=> 80,
	'size'	=> 30,
	'class'       => 'single'
	
);

$workVideo = array(
	'name'	=> 'workVideo',
	'id'	=> 'workVideo',
	'value'	=> set_value('workVideo'),
	'maxlength'	=> 80,
	'size'	=> 30,
	'class'       => 'width200px pl5 ml5'
	
	
);

$workEmbbededURL = array(
	'name'	=> 'workEmbbededURL',
	'id'	=> 'workEmbbededURL',
	'value'	=> set_value('workEmbbededURL'),
	'rows'      => 3,
    'cols'      => 45,
	'class'       => 'textarea pl5 ml5 width360px'
	
);

$isUrgentArr = array(
	'name'        => 'isUrgent',
	'id'          => 'isUrgent',
	'value'       => 'accept',
	'checked'     => $isUrgent =='t'?TRUE:FALSE,
	
	);

$workExperieceArr = array(
	'name'        => 'workExperiece',
	'id'          => 'workExperiece',
	'value'       => 'accept',
	'checked'     => $workExperiece=='t'?TRUE:FALSE,
	'onclick'	  => "setRemunerationZero('workRemuneration')",		
	
	);

if($workType=='wanted'){
$workExperieceWantedArr = array(
		'name'        => 'workExperieceWanted',
		'id'          => 'workExperieceWanted',
		'value'       => 'accept',
		'checked'     => $workExperiece=='t'?TRUE:FALSE,
		
		);
}

if(strcmp($mode,'new')==0) $workId = 0;
		
$formAttributes = array("name"=>'customForm','id'=>'customForm');

echo form_open_multipart('work/addMoreWork/'.$workId.'/'.$workType,$formAttributes);
echo form_hidden('workId',$workId);
echo form_hidden('workType',$workType);
echo form_hidden('tdsUid',$tdsUid);
echo form_hidden('mode',$mode);
echo form_hidden('workArchived',$workArchived);

?>
<div class="row form_wrapper">
	<div class="row">
		<div class="cell frm_heading">
			<h1><?php if($workType=='offered') echo $constant['workOfferedDesc']; else echo $constant['workWantedDesc'];?></h1>
		</div>
		<?php echo $header;?>
	</div>
	
	<div class="row position_relative">
	<?php echo Modules::run("common/strip");?>
	
	<div class="row">
		<div class="label_wrapper cell">
			<label class="select_field"><?php echo $constant['workTitle']; ?></label>
		</div><!--label_wrapper-->
		<div class=" cell frm_element_wrapper">
			<?php echo form_input($workTitleArr); ?>
			<?php echo form_error($workTitleArr['name']); ?>
			<?php echo isset($errors[$workTitleArr['name']])?$errors[$workTitleArr['name']]:''; ?>
		</div>
	</div><!--from_element_wrapper-->
	
	<?php 
		
		$value=$workShortDesc;
		$value=htmlentities($value);
		$data=array('name'=>'workShortDesc','value'=>$value,'labelText'=>'workOneLineDesc' ,'view'=>'oneline_description', 'required'=>'required');
		echo Modules::run("common/formInputField",$data);
	
		$value=$workTag;
		$value=htmlentities($value);
		$data=array('name'=>'workTag','value'=>$value,'labelText'=>'workTagWords','view'=>'tag_words', 'required'=>'required');
		echo Modules::run("common/formInputField",$data);
		
	?>
	<div class="seprator_25 row"></div>
	
	<?php if(strcmp($workType,'wanted')!=0){ ?>
	<div class="row">
		
			<div class="label_wrapper cell">
				<label ><?php echo $constant['urgent']?></label>
			</div>
			
			<div class=" cell frm_element_wrapper lineHeight20px">
				<div class="row mt5">
					<div class="cell">
						<div class="cell defaultP formTip" title="<?php echo $constant['urgentToolTip']; ?>">
							<?php echo form_checkbox($isUrgentArr); ?>
						</div>
					</div>					
				</div>
			</div>
		</div>
	<?php } ?>
		<div class="row">
			<div class="label_wrapper cell">
				<label ><?php echo $constant['workExperience']?></label>
			</div>
		<div class=" cell frm_element_wrapper lineHeight20px">
			<div class="row mt5">
			<div class="cell">
				<div class="cell defaultP">
				<?php echo form_checkbox($workExperieceArr); ?>
				</div>
			</div>
			
			</div>
		</div>
		
		<div class="seprator_25 row"></div>		
	<?php 
		//$value=$workDesc;
		
		//$data=array('name'=>'workDesc','value'=>$value, 'labelText'=>'workDesc','view'=>'description', 'required'=>'required');
		//echo Modules::run("common/formInputField",$data);
	
	
	?>		
	<div class="row">
		<div class="label_wrapper cell">
			<label class="select_field" ><?php echo $constant['workDescription']; ?></label>
		</div><!--label_wrapper-->
		<div class=" cell frm_element_wrapper NIC">
			<div id="myNicPane3"  class="cell bdr_e2e2e2 tmailtop_gradient p15 width_536px"></div>
			<div id="myInstance3" class="editordiv frm_Bdr minHeight200px width_545"  onblur="checktext('myInstance3','workDesc');" style="position:relative;z-index:2;">
				<?php echo html_entity_decode($workDesc);?>				
			</div>
			<?php echo isset($errors[$workDescArr['name']])?$errors[$workDescArr['name']]:''; ?>
			<div style="position:absolute; top:270px;z-index:1"><?php echo form_textarea($workDescArr); ?>	</div>
			<?php echo form_error($workDescArr['name']); ?>				
			</div>					
		</div>		
	</div>
<div class="seprator_18 row"></div>
	<div class="row">
		<div class="label_wrapper cell">
			<label class="select_field" ><?php  if(strcmp($workType,'wanted')!=0) echo $constant['workJobRequir']; else  echo $constant['workSkills']; ?></label>
		</div><!--label_wrapper-->
		<div class=" cell frm_element_wrapper NIC">
			<div id="myNicPane4" class="cell bdr_e2e2e2 tmailtop_gradient p15 width_536px"></div>
			<div id="myInstance4" class="editordiv formTip frm_Bdr minHeight200px width_545" onblur="checktext('myInstance4','workTypeDesc');" style="position:relative;z-index:2;">
				<?php if(isset($workTypeDesc) && $workTypeDesc != '') echo html_entity_decode(@$workTypeDesc);?>				
			</div>
			<?php echo isset($errors[$workTypeDescArr['name']])?$errors[$workTypeDescArr['name']]:''; ?>
			<div style="position:absolute; top:270px;z-index:1"><?php echo form_textarea($workTypeDescArr); ?>	</div>
			<?php echo form_error($workTypeDescArr['name']); ?>
				
			</div>	
				
		</div>		
		<div class="seprator_25 row"></div>
<?php if(strcmp($workType,'offered')==0) { ?>		
		<div class="row">
			<div class="label_wrapper cell">
				<label><?php echo $constant['workCompany']; ?></label>
			</div>
			
			<div class=" cell frm_element_wrapper">
				<?php echo form_input($workCompanyArr); ?>
			</div>
		</div>
	<?php } ?>
		
	<!-- <div class="row">
		<div class="label_wrapper cell">
			<label><?php //echo $constant['workReview']; ?></label>
		</div>
		<div class=" cell frm_element_wrapper">
			<?php //echo form_input($workReviewArr); ?>
			<div class="cell">
				<img src="<?php //echo base_url().'images/Search.png'?>" class="formTip ptr searchReviewImage" title="Search Review from Toadsquare" style="margin: 5px 5px 5px 15px; cursor:pointer"/>	
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="label_wrapper cell">
			<label><?php //echo $constant['workRecommendation']; ?></label>
		</div><!--label_wrapper
		<div class=" cell frm_element_wrapper">
			<?php //echo form_input($workRecommendationArr); ?>
			<?php //echo form_error($workRecommendationArr['name']); ?>
			<?php //echo isset($errors[$workRecommendationArr['name']])?$errors[$workRecommendationArr['name']]:''; ?>
		</div>
	</div><!--from_element_wrapper-->	
	
	<div class="row">
		<div class="label_wrapper cell">
			<label class="select_field"><?php echo $constant['workLang1']; ?></label>
		</div><!--label_wrapper-->
		<?php
		$workLang1Name = "workLang1";
		if($mode=='edit')
			$workLang1Val = $workLang1;
		else
			$workLang1Val = '';
		?>
		<div class=" cell frm_element_wrapper">			
			<?php 
			$attr = "id='workLang1' class= 'single dropDown required NumGrtrZero' title='".$this->lang->line('thisFieldIsReq')."'";
				echo form_dropdown($workLang1Name, $language, $workLang1Val ,$attr );
				echo form_error($workLang1Arr['name']); 
				echo isset($errors[$workLang1Arr['name']])?$errors[$workLang1Arr['name']]:''; 
			?>
		</div>
	</div><!--from_element_wrapper-->
	<div class="seprator_5 row"></div>
	<div class="row">
		<div class="label_wrapper cell">
			<label><?php echo $constant['workLang2']; ?></label>
		</div><!--label_wrapper-->
		<?php
		$workLang2Name = "workLang2";
		if($mode=='edit')
			$workLang2Val = $workLang2;
		else
			$workLang2Val = '';
		
		?>
		<div class=" cell frm_element_wrapper">			
			<?php 
			echo form_dropdown($workLang2Name, $language, $workLang2Val ,'id="workLang2"');
			echo form_error($workCountryIdArr['name']); 
			echo isset($errors[$workCountryIdArr])?$errors[$workCountryIdArr]:''; 
			?>
		</div>
	</div><!--from_element_wrapper-->
	<div class="seprator_5 row"></div>
	
	<div class="row">
		<div class="label_wrapper cell">
			<label class="select_field"><?php echo $constant['workCountry']; ?></label>
		</div><!--label_wrapper-->
		<?php
		$workCountryIdName = "workCountryId";
		if($mode=='edit')
			$workCountryIdval = $workCountryId;
		else
			$workCountryIdval = '';
		?>
		<div class="cell frm_element_wrapper">			
			<?php 
				$attr = "id='workCountry' class= 'single dropDown  required '";
				echo form_dropdown($workCountryIdName , $location, $workCountryIdval,$attr ); 
				echo form_error($workCountryIdArr['name']); 
				echo isset($errors[$workCountryIdArr])?$errors[$workCountryIdArr]:''; 
			?>
		</div>
	</div><!--from_element_wrapper-->
	<div class="seprator_5 row"></div>
	
	<div class="row">
		<div class="label_wrapper cell">
			<label class="select_field"><?php echo $constant['workTownCity']; ?></label>
		</div><!--label_wrapper-->
		<div class=" cell frm_element_wrapper">
			<div class="cell"><?php echo form_input($workCityArr); ?></div>
			<?php echo form_error($workCityArr['name']); ?>
			<?php echo isset($errors[$workCityArr['name']])?$errors[$workCityArr['name']]:''; ?>
		</div>
	</div><!--from_element_wrapper-->
	<div class="seprator_5 row"></div>
	<div class="row">
		<div class="label_wrapper cell">
			<label class="select_field"><?php echo $constant['workIndustry']; ?></label>
		</div><!--label_wrapper-->
		<?php
		if($mode=='edit')
			$workIndustryIdVal = $workIndustryId;
		else
			$workIndustryIdVal = '';

		$workIndustryIdName = "workIndustryId";
		?>
		<div class=" cell frm_element_wrapper">			
			<?php	
			$attr = "id='workIndustryId' class= 'dropDown required '";
			echo form_dropdown($workIndustryIdName, $industry, $workIndustryIdVal ,$attr);
			echo form_error($workIndustryIdArr['name']); 
			echo isset($errors[$workIndustryIdArr['name']])?$errors[$workIndustryIdArr['name']]:''; 
			?>
		</div>
	</div><!--from_element_wrapper-->
	
	<!--<div class="row">
		<div class="label_wrapper cell">
			<label><?php //echo $constant['workLang3']; ?></label>
		</div><!--label_wrapper-->
		<?php
		/*$workLang3Name = "workLang3";
		if($mode=='edit')
			$workLang3Val = $workLang3;
		else
			$workLang3Val = '';*/
		?>
		<!--<div class=" cell frm_element_wrapper">
			
			<?php// $attr = "id='workLang1' class= 'single dropDown '";
			//echo form_dropdown($workLang3Name, $language, $workLang3Val ,'id="workLang3"');
			?>
			
			<?php// echo form_error($workCountryIdArr['name']); ?>
			<?php //echo isset($errors[$workCountryIdArr])?$errors[$workCountryIdArr]:''; ?>
		</div>
	</div><!--from_element_wrapper-->
		<div class="row">
			<div class="label_wrapper cell"> 
				<label><?php  if(strcmp($workType,'wanted')!=0) echo $constant['workStyle']; else  echo $constant['availability']; ?></label>
			</div>
			<div class=" cell frm_element_wrapper">
				<div>
					<select id="workTypeAdditional" name="workTypeAdditional"  >
					<option  value=""><?php echo $constant['workSelect']; ?></option>
					<option <?php if($workTypeAdditional=="F"){?>selected <?php }?> value="F"><?php echo $constant['workFree']; ?></option>
					<option <?php if($workTypeAdditional=="FT"){?>selected <?php }?> value="FT"><?php echo $constant['workFullTime']; ?></option>
					<option <?php if($workTypeAdditional=="PT"){?>selected <?php }?> value="PT"><?php echo $constant['workPartTime']; ?></option>
					<option <?php if($workTypeAdditional=="CA"){?>selected <?php }?> value="CA"><?php echo $constant['workCasual']; ?></option>
					
					</select>
				</div>
			</div>
		</div>	

	<div class="seprator_5 row"></div>	
	
	<div class="row">
		<div class="label_wrapper cell">
			<label><?php echo $constant['workRemuneration']; ?></label>
		</div><!--label_wrapper-->
		<div class="cell frm_element_wrapper">
			<div class="row mt5 lh22">
			<div class="cell"><?php echo form_input($workRemunerationArr); ?></div>
			
			<div class="cell pl10 pr">				
				<div class="small_select_wp"> 

					<select id="workRenumUnit" name="workRenumUnit" class="mt-6"  >
					<option  value=""><?php echo $constant['workSelectperiod']; ?></option>
					<option <?php if($workRenumUnit=="PA"){?>selected <?php }?> value="PA"><?php echo $constant['renumUnitPerAnnum']; ?></option>					
					
				<!--	<option <?php /* if($workRenumUnit=="PF"){?>selected <?php }?>value="PF"><?php echo $constant['renumUnitPerFortnight']; ?>
				  
				        <option <?php if($workRenumUnit=="PY" || $workRenumUnit==""){?>selected <?php }?> value="PY"><?php echo $constant['renumUnitPerYear']; */?></option>  				 
				
				</option> -->
				
					<option <?php if($workRenumUnit=="PM" || $workRenumUnit==""){?>selected <?php }?> value="PM"><?php echo $constant['renumUnitPerMonth']; ?></option>					
					<option <?php if($workRenumUnit=="PW"){?>selected <?php }?>value="PW"><?php echo $constant['renumUnitPerWeek']; ?></option>
					<option <?php if($workRenumUnit=="PH"){?>selected <?php }?> value="PH"><?php echo $constant['renumUnitPerHour']; ?></option>
					
					</select>				
				</div>
			</div>			
			</div>
			<?php echo form_error($workRemunerationArr['name']); ?>
			<?php echo isset($errors[$workRemunerationArr['name']])?$errors[$workRemunerationArr['name']]:''; ?>
		
		</div>
	</div><!--from_element_wrapper-->
	<div class="seprator_5 row"></div>	
	</div>
	<?php echo form_hidden('save','Save');?>
	<div class="cell mt19 mb25">
	<div class="row">
		<div class="label_wrapper cell bg-non"></div><!--label_wrapper-->
		<div class=" cell frm_element_wrapper">
			<div class="Req_fld cell"><?php echo $constant['requiredFields']?></div><!--Req_fld-->
			
			<div class="frm_btn_wrapper padding-right0">
				 <!--<div class="tds-button Fleft"> <button type="submit" name="submit" value="Save" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)"><span><div class="Fleft">Save</div> <div class="icon-save-btn"></div> </span> </button>  </div>
				 <div class="tds-button Fleft"><button type="button" onclick="calcelForm('<?php echo $workType?>');" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)"><span><div class="Fleft">Cancel</div> <div class="icon-publish-btn"></div></span> </button> </div>
				<div class="seprator_5 cell"></div>-->
				<div class="tds-button fl">
					<button type="button" onclick="cancelForm('<?php echo $workType?>');" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)" class="dash_link_hover"><span><div class="Fleft"><?php echo $this->lang->line('cancel');?></div><div class="icon-form-cancel-btn"></div></span> </button>
				</div>
				<?php
					$button = array('save');
					echo Modules::run("common/loadButtons",$button); 
				?>
			</div>
				<div class="row"><div class="cell">*&nbsp;</div><div class="cell" ><?php echo $this->lang->line('descReqFieldMsg');?></div></div>
				<!--add instructins-->
				<?php if(isset($workId) && !empty($workId)){?>
				<div class="row makeShowcaseBetter">
				<div class="cell">*&nbsp;</div><div class="cell" ><?php echo $this->lang->line('makeShowcaseBetterMsgChange');?>
				<a href="<?php echo site_url(lang()).'/work/'.$workType.'/'.$workId.'/promotional_image';?>" target="_blank">Promotional Material</a>.</div>
				</div>
				<?php }?>
				<div class="row makeShowcaseBetter">
				<div class="cell">*&nbsp;</div><div class="cell" ><?php echo $this->lang->line('previewPublishInfoChange');?>
				<a href="<?php echo site_url(lang()).'/work/'.$workType;?>" target="_blank">Index page</a>.</div>
				</div>
		</div>
		</div>
	</div><!--from_element_wrapper-->
	<div class="clear"></div>
</div>

<?php echo form_close(); ?>
<script type="text/javascript">


function checktext(id,field){
	
	var sectionContent = $.trim($('#'+id).html());
	
	if( sectionContent == '' ||  sectionContent == '<br>'){
		$('#'+field).text('');		 
	}
	else{
		$('#'+field).html(sectionContent);
		//alert($('#workDesc').text());		 
	}
}


function updateTextArea() {         
	 var allVals = [];
	 $('[name=chk1]:checked').each(function() {
	   allVals=$(this).val();
	 });

	 $('#workReview').val(allVals);
	} 
	

$( document ).ready( function() {	
  $('#review-title #chkreview input').click(updateTextArea);  
  setRemunerationZero("workRemuneration");
  
 });



function cancelForm(workType)
{
	location.href=baseUrl+language+"/work/"+workType;
}

function trimValue()
{
	var workRemuneration=$("#workRemuneration").val();
	$('#workRemuneration').val($.trim(workRemuneration));
}

function setRemunerationZero(id){
		if($("#workExperiece").attr('checked'))
		{
			$("#"+id).attr('disabled', true);
			$("#"+id).val('');
			$("#"+id).removeClass('required');
			setSeletedValueOnDropDown('workRenumUnit','');
			$("#workRenumUnit").attr("disabled", true);		
			$('#workRenumUnit').next("a").css("opacity","0.4");
			$('#workRenumUnit').next("a").addClass("selectBox-disabled ");      
		}
		else
		{
			
			if("<?php echo $workRemuneration ?>"!='')
			var renumValue="<?php echo $workRemuneration ?>";
			else
			var renumValue="";
			
			$("#"+id).attr('disabled', false);
			$("#"+id).val(renumValue); 
			//$("#"+id).addClass('required');
			
			$('#workRenumUnit').next("a").removeClass("selectBox-disabled ");
			$('#workRenumUnit').next("a").css("opacity","1");
			
			setSeletedValueOnDropDown('workRenumUnit','<?php echo @$workRenumUnit;?>');
				
		}
}
		/*bkLib.onDomLoaded(function() {
		var myNicEditor = new nicEditor({buttonList : ['save','bold','italic','underline','left','center','right','justify','ol','ul']});
		myNicEditor.setPanel('myNicPane3');
		myNicEditor.addInstance('myInstance3');
});*/
</script>


<script type="text/javascript">
	bkLib.onDomLoaded(function() {
		var myNicEditor = new nicEditor({buttonList : ['save','bold','italic','underline','left','center','right','justify','ol','ul']});
		myNicEditor.setPanel('myNicPane3');
		myNicEditor.addInstance('myInstance3');
		myNicEditor.setPanel('myNicPane4');
		myNicEditor.addInstance('myInstance4');
});
</script>
