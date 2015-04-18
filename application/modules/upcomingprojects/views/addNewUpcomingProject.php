<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* First save Upcoming popup Start*/
	$isShowUpcomingPopup=$this->session->userdata('isShowUpcomingPopup');
	if(isset($isShowUpcomingPopup) && $isShowUpcomingPopup==1){
		$this->session->unset_userdata('isShowUpcomingPopup');
		$upcomingUrl['descriptionUrl'] = site_url(lang()).'/upcomingprojects/projectPromotionalImages/'.$projId;
		$upcomingUrl['prMaterialUrl'] = site_url(lang()).'/upcomingprojects/additionalInformation/'.$projId;
		$upcomingUrl['indexUrl'] = site_url(lang()).'/upcomingprojects';
		$upcomingUrl['popupSection'] = 'upcoming';
		$popup_media = $this->load->view('common/afterSavePopup',$upcomingUrl,true);
		?>
			<script>
				var popup_media = <?php echo json_encode($popup_media);?>;
				 loadPopupData('popupBoxWp','popup_box',popup_media);
			</script>
		<?php
	}
/* First save Upcoming popup End*/

$lang=lang();
$currentEntityId = $entityId;
$formAttributes = array(
	'name'=>'customForm',
	'id'=>'customForm'
);
$projTitle = array(
	'name'	=> 'projTitle',
	'id'	=> 'projTitle',
	'class'	=> 'required width556px',	
	'value'	=> $projTitle,
	//'placeholder'	=> $label['projectTitle'],
	//'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 30
);

$proShortDescField = array(
	'name'	=> 'proShortDesc',
	'id'	=> 'proShortDesc',
	'class'	=> 'heightAuto rz  required width556px',
	'title'=>   $label['oneLineDescription'],
	'value'	=> $proShortDesc,
	'wordlength'=>"5,30",
	'onkeyup'=>"getRemainingLen(this,30,'descriptionLimit')",
//'placeholder'	=> $label['oneLineDescription'],
	'rows'	=> 2
);

$projTagField = array(
	'name'	=> 'projTag',
	'id'	=> 'projTag',
	'class'	=> 'heightAuto rz required',
	'title'=>  $label['Tags'],
	'wordlength'=>"5,50",
	'onkeyup'=>"getRemainingLen(this,50,'tagLimit')",
	'value'	=> $projTag,
	//'placeholder'	=> $label['Tags'],
	'rows'	=> 5
);

$projDescriptionField = array(
	'name'	=> 'projDescription',
	'id'	=> 'projDescription',
	'class'	=> 'heightAuto rz required',
	'title'=>  $label['Description'],
	'wordlength'=>"5,50",
	'onkeyup'=>"getRemainingLen(this,50,'description')",
	'value'	=> $projDescription,
	//'placeholder'	=> $label['Description'],
	'rows'	=> 5,
	'maxlength'	=> 50,
);


$projCity = array(
	'name'	=> 'projCity',
	'id'	=> 'projCity',
	'class'	=> 'required width246px',

	'value'	=> $projCity,
	//'placeholder'	=> $label['city'],
	//'minlength'	=> 2,
	'maxlength'	=> 30,
	'size'	=> 30
);
$projAddress = array(
	'name'	=> 'projAddress',
	'id'	=> 'projAddress',
	'class'	=> 'width246px',	
	'value'	=> $projAddress,
	//'placeholder'	=> 'Address',
	//'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 30
);
$projAddress2 = array(
	'name'	=> 'projAddress2',
	'id'	=> 'projAddress2',
	'class'	=> 'width246px',	
	'value'	=> $projAddress2,
	//'placeholder'	=> 'Address',
	//'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 30
);
$projStreet = array(
	'name'	=> 'projStreet',
	'id'	=> 'projStreet',
	'class'	=> 'width556px',
	
	'value'	=> $projStreet,
	//'placeholder'	=> $label['street'],
	//'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 30
);
$projZip = array(
	'name'	=> 'projZip',
	'id'	=> 'projZip',
	'class'	=> 'width246px',
	'value'	=> $projZip,
	//'placeholder'	=> $label['zipcode'],
	//'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 30
);
$currentDate = array(
	'name'	=> 'currentDate',
	'id'	=> 'currentDate',	
	'value'	=> date('Y-m-d'),	
	'type' =>'hidden'
);

if($projReleaseDate!='')
	$releasedDate=date('F Y',strtotime($projReleaseDate));
else
	$releasedDate='';

$projReleaseDate = array(
	'name'	=> 'projReleaseDate',
	'id'	=> 'projReleaseDate',
	'value'	=> $releasedDate,
	'maxlength'	=> 80,
	'size'	=> 30,
	'class' => 'width246px required',
    'readonly' =>true	
);

$showEMIndSel = '';
$showEVIndSel = '';
$showMPIndSel = '';

if(@$projUpType =='1') { 
	$isEducationMaterial =  TRUE; 
	$showEMIndSel =$projIndustry; 
}
else $isEducationMaterial = FALSE; 

if(@$projUpType =='2') { 
	$isEvent =  TRUE; $showEVIndSel =$projIndustry; 
}
else $isEvent = FALSE;

if(@$projUpType =='3' || @$projUpType =='0'|| @$projUpType =='' || !isset($projUpType)) 
{
	$isMediaProject =  TRUE; 
	$showMPIndSel =$projIndustry; 
}
else $isMediaProject = FALSE;

$isEducationMaterial = array(
	'name'        => 'projUpType',
	'id'          => 'projUpType',
	'value'       => '1',
	'checked'     => $isEducationMaterial =='t'?TRUE:FALSE,
	'style'       => 'margin-right:10px',
	'class'       => 'checkbox',
	'onchange'    => "getIndustryList('IndustryTypeList','$showEMIndSel');"	
	);
//		echo $isEvent.'<br />';
$isEvent = array(
	'name'        => 'projUpType',
	'id'          => 'projUpType',
	'value'       => '2',
	'checked'     => $isEvent =='t'?TRUE:FALSE,
	'style'       => 'margin-right:10px',
	'class'       => 'checkbox',
	'onchange'    => "getIndustryList('IndustryTypeList','$showEVIndSel');"
	);
	
$isMediaProject = array(
	'name'        => 'projUpType',
	'id'          => 'projUpType',
	'value'       => '3',
	'checked'     => $isMediaProject =='t'?TRUE:FALSE,
	'style'       => 'margin-right:10px',
	'class'       => 'checkbox',
	'onchange'    => "getIndustryList('IndustryTypeList','$showMPIndSel','t');"
	);	

$askForDonation = array(
	'name'        => 'askForDonation',
	'id'          => 'askForDonation',
	'value'       => 'accept',
	'checked'     => $askForDonation =='t'?TRUE:FALSE,
	'style'       => 'margin-right:10px',
	'class'       => 'checkbox'	
	);
	
$projGenreFree = array(
	'name'	=> 'projGenreFree',
	'id'	=> 'projGenreFree',
	'class'	=> 'width246px formTip',
	'title'=>  'Free Genre',
	'value'	=> $projGenreFree,
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50
	);

?>
<div class="row form_wrapper">
	<div class="row">
		<div class="cell frm_heading">
			<h1><?php echo $label['Description']?></h1>
		</div>
		<?php echo $header;?>
	</div>
	<div class="row position_relative">
	<?php 
		//LEFT SHADOW STRIP
		echo Modules::run("common/strip");
		
		echo form_open_multipart('',$formAttributes);
		echo form_hidden('mode',$mode);
		
		if(@$projId=='') $projId=0;
			echo form_hidden('projId',$projId);
	?>
<script type="text/javascript">
  $(function () {
	  $('#projReleaseDate').monthpicker({selectedYear: <?php echo date('Y')?>, startYear: 1925, finalYear: <?php echo date('Y')?>});
  });
</script>

		<div class="row">
			<div class="label_wrapper cell">
				<label class="select_field"><?php echo $label['projectTitle']?></label>
			</div><!--label_wrapper-->
			<div class=" cell frm_element_wrapper">
				<?php echo form_input($projTitle); ?>
				<?php echo form_error($projTitle['name']); ?>
			</div>
		</div><!--from_element_wrapper-->
		<?php 
			$value=$proShortDesc;
			$value=htmlentities($value);
			$data=array('name'=>'proShortDesc','value'=>$value, 'view'=>'oneline_description','required'=>'required');
			echo Modules::run("common/formInputField",$data);
		
			$value=$projTag;
			$value=htmlentities($value);
			$data=array('name'=>'projTag','value'=>$value, 'view'=>'tag_words','required'=>'required');
			echo Modules::run("common/formInputField",$data);
		
			$value=$projDescription;
			$value=htmlentities($value);
			$wordOption=array('minVal'=>0,'maxVal'=>600);
			$data=array('name'=>'projDescription','value'=>$value,'required'=>'', 'view'=>'description','wordOption'=>$wordOption,'labelText'=>'furtherNoBRDescription');
			echo Modules::run("common/formInputField",$data);
					
			$projIndustryName = "projIndustry";
			if($projId > 0) {
				//echo "test--".$projLanguage;
				$projIndustryVal= $projIndustry;
			}else
			{
				$projIndustryVal='';
			}
			
			$defaultOptionType=$this->lang->line('selectProjectType');
			$defaultOptionGenre=$this->lang->line('selectGenre');
			$entityId='';
			
		?>
			
			<div class="seprator_25 row"></div>
			<div class="row">
			<div class="label_wrapper cell">
				<label><?php echo $this->lang->line('variety');?></label>
			</div><!--label_wrapper-->
			<div class=" cell frm_element_wrapper ">
				 <div class="row mt5 lh22">
				 <div class="cell"><div class="defaultP"><?php echo form_radio($isMediaProject); ?></div></div> <div class="cell mr10"><label  class="ml5"><?php echo $this->lang->line('mediaProject');?></label></div>
				 <div class="cell"><div class="defaultP"><?php echo form_radio($isEvent); ?></div></div> <div class="cell mr10"><label  class="ml5"><?php echo $this->lang->language['perOrEvent'];?></label></div>
				 <div class="cell"><div class="defaultP"><?php echo form_radio($isEducationMaterial);?></div></div> <div class="cell mr10"><label class="ml5"><?php echo $label['EducationalMaterial'];?></label></div>				 
				 </div>
			</div>
		</div><!--from_element_wrapper-->
		<div class="clear"></div>	
			
			<div class="row">
				<div class="label_wrapper cell">
					<label class="select_field"><?php echo $label['Industry']?></label>
				</div><!--label_wrapper-->
				<div class="cell frm_element_wrapper">
					<div id="IndustryTypeList" class="fl" >
					<?php
						$attr = 'id="IndustryList" name="projIndustry" class="required");" ';			
						echo form_dropdown($projIndustryName, $industry, $projIndustryVal ,$attr);
					?>
					</div>
					<div class="row wordcounter">
					<?php 
						echo form_error($projIndustry);
						echo isset($errors[$projIndustry])?$errors[$projIndustry]:''; 
					?>
					</div>
				</div>
			</div>
			
			<?php
			//$projCategoryList = getProjCategoryList($projIndustry, $lang, 'selectCategory','');
			
			/* //Commented for client's req 8 aug 2012
			
			<div class="row">
				<div class="label_wrapper cell">
					<label class="select_field"><?php echo $this->lang->line('projectStyle');?></label>
				</div><!--label_wrapper-->
				<div class=" cell frm_element_wrapper">
					<div class="fl" id="projectCategoryList" >
					<?php 
						echo form_dropdown('projCategory', $projCategoryList, $projCategory ,'id="projCategory" class=" required" onchange="getTypeList(\'projectTypeList\',\'projGenre\','.$projIndustry.',this.value,\''.$defaultOptionGenre.'\');" ');
						?>
						<div class="row wordcounter"><?php echo form_error('projCategory'); ?></div>
					</div>	
				</div>
			</div>

			<div class="row">
				<div class="cell label_wrapper"><label class="select_field"><?php echo $label['projectType'];?></label></div>
				<div class="cell frm_element_wrapper">
					<div class="fl" id="projectTypeList" >
						<?php 
							$projType=$projType;
							if( ! $projType > 0){
								$projType = '';
							}
							$projectType = getTypeList($projIndustry, $lang,'selectProjectType',$projCategory);
							echo form_dropdown('projType', $projectType, $projType,'id="projType" class="required " onchange="getGenerList(\'subGenreList\',this.value);"');
						?>
					</div>
					<div class="row wordcounter"><?php echo form_error('projType'); ?></div>
				</div>
			</div>

			<div class="row" id="projGenreDiv">
				 <div class="cell label_wrapper"><label class="select_field"><?php echo $label['Genre']?></label></div>
				 <div class="cell frm_element_wrapper">
						<div class="fl" id="subGenreList">
							<?php 
									if( ! $projGenre > 0){
										$projGenre = '';
									}
									$subgenre = getGenerList($projType, $projIndustryVal,$lang);
									echo form_dropdown('projGenre', $subgenre, $projGenre,'id="projGenre" class="required " ');
							?>
						</div>
						<div class="row wordcounter"><?php echo form_error('projGenre'); ?></div>
				</div>
			</div>
			
			 <div class="row">
				<div class="cell label_wrapper"><label>Free Genre</label></div>
				<div class="cell frm_element_wrapper" >
					<?php echo form_input($projGenreFree); ?>
					<?php echo form_hidden('isPublished', 'f'); ?>
					
					<div class="row wordcounter"><?php echo form_error($projGenreFree['name']); ?></div>
				</div>
			 </div>	
		*/
		?>
		
		<div class="row">
			<div class="label_wrapper cell">
				<label class="select_field"><?php echo $label['ReleaseDate']?></label>
			</div><!--label_wrapper-->
			<?php
			$projReleaseDate['name'] ='';
			$projReleaseDate['name'] = 'projReleaseDate';
			?>
			<div class="cell frm_element_wrapper">
				<div class="cell widthAuto">
					<?php 
					 echo form_input($currentDate);echo form_input($projReleaseDate); 
					 echo form_error($projReleaseDate['name']); 
					 echo isset($errors[$projReleaseDate['name']])?$errors[$projReleaseDate['name']]:''; 
					?>
				</div>
				<div class="cell ml10 mt5">
					<div class="cell pl5"> <img class="ptr" src="<?php echo base_url('images/icons/calendar.png');?>" onclick='$("#projReleaseDate").focus();' /> </div>
				</div>
				
			</div>
		</div><!--from_element_wrapper-->
		
			<div class="row">
			<div class="label_wrapper cell">
				<label class="select_field"><?php echo $label['Language']?></label>
			</div><!--label_wrapper-->
			<?php 
			$projLanguageName = "projLanguage";
			
			if($projId > 0) {
				$projLanguageVal= $projLanguage;
			}
			else
			{
				$projLanguageVal= '';
			}
			?>
			<div class="cell frm_element_wrapper">				
			<?php 
				 $attr = 'id="projLanguage" class="required NumGrtrZero" title="'.$this->lang->line('thisFieldIsReq').'"';
				 echo form_dropdown($projLanguageName, $language, $projLanguageVal ,$attr);
				 echo form_error($projLanguage); 
				 echo isset($errors[$projLanguage])?$errors[$projLanguage]:''; 
			?>
			</div>
		</div><!--from_element_wrapper-->
		<?php 
		/*		
		<div id="show1ForEvent" class="<?php echo $showForEvent_Class;?>">
		
		Commented for client's req 28 Jan 2013
		<div class="row">
			<div class="label_wrapper cell">
				<label ><?php echo $this->lang->line('address1');?></label>
			</div><!--label_wrapper-->
			<div class=" cell frm_element_wrapper">
				<?php echo form_input($projAddress); ?>
				<?php echo form_error($projAddress['name']); ?>
			</div>
		</div><!--from_element_wrapper-->
		<div class="row">
			<div class="label_wrapper cell">
				<label ><?php echo $this->lang->line('address2');?></label>
			</div><!--label_wrapper-->
			<div class=" cell frm_element_wrapper">
				<?php echo form_input($projAddress2); ?>
				<?php echo form_error($projAddress2['name']); ?>
			</div>
		</div><!--from_element_wrapper-->
		*/ 
		?>
		<?php /*
		Commented for client's req 8 aug 2012
		<div class="row">
			<div class="label_wrapper cell">
				<label ><?php echo $label['street']?></label>
			</div><!--label_wrapper-->
			<div class=" cell frm_element_wrapper">
				<?php echo form_input($projStreet); ?>
				<?php echo form_error($projStreet['name']); ?>
			</div>
		</div><!--from_element_wrapper-->
		
		
		</div>
		* */
		?>
		<div class="row">
			<div class="label_wrapper cell">
				<label class="select_field"><?php echo $label['country']?></label>
			</div><!--label_wrapper-->
			<?php	$projCountryName = "projCountry";
			if($projId > 0) {
				$projCountryVal= $projCountry;
			}else
			{
				$projCountryVal= '';
			}?>
		<div class="cell frm_element_wrapper">		
			<?php 
			 $attr = 'id="projCountry" class="required"';
			 echo form_dropdown($projCountryName, $location,$projCountryVal ,$attr);
			 echo form_error($projCountry); 
			 echo isset($errors[$projCountry])?$errors[$projCountry]:''; 
			 ?>
		</div>
		</div><!--from_element_wrapper-->
		<div id="show2ForEvent" class="<?php echo $showForEvent_Class;?>">	
			<div class="row">
				<div class="label_wrapper cell">
					<label class="select_field"><?php echo $label['twnRcity']?></label>
				</div><!--label_wrapper-->
				<div class="cell frm_element_wrapper">
					<?php echo form_input($projCity); ?>
					<?php echo form_error($projCity['name']); ?>
				</div>
			</div><!--from_element_wrapper-->
		<?php 
		/*
			<div class="row">
				<div class="label_wrapper cell">
					<label ><?php echo $label['zipcode']?></label>
				</div><!--label_wrapper-->
				<div class="cell frm_element_wrapper">
					<?php echo form_input($projZip); ?>
					<?php echo form_error($projZip['name']); ?>
				</div>
			</div><!--from_element_wrapper-->
			* */ 
		?>
		</div>		
		<div class="seprator_25 row"></div>
		
		<div class="row">
			<div class="label_wrapper cell">
				<label ><?php echo $label['donation']?></label>
			</div><!--label_wrapper-->
			<div class="cell frm_element_wrapper lineHeight20px">
				<div class="row mt5">
				<div class="cell defaultP"><?php echo form_checkbox($askForDonation); ?></div>
				<label class="ml5"><?php echo $label['askForDonation']?></label>
				<?php 
				echo form_error($askForDonation['name']); 
				echo isset($errors[$askForDonation['name']])?$errors[$askForDonation['name']]:''; 
				?>
				</div>
			</div>
		</div><!-- row -->
		
		<div class="row">
		<div class="cell label_wrapper"><label class="select_field"><?php echo $label['eventRating'];?></label></div>
		<div class="cell frm_element_wrapper">
			<div class="formTip fl" id="ratingTypeList" title="<?php echo $this->lang->line('ratingMsg');?>">
				<?php 
				
					$ratingName = 'rating';
					$selectRating = $rating;						
					
					if( ! $selectRating > 0){
						$selectRating = '';
					}
											
					echo form_dropdown($ratingName, $ratingList,$selectRating ,'id="selectrating" class="single required" ');
					
				?>
			</div>
			<div class="row wordcounter">
				<span class="tag_word_orange"><?php echo $this->lang->line('adultsMaterialNotAllowed');?></span>
			</div>
			<div class="row wordcounter"><?php echo form_error('selectRating'); ?></div>
		</div>
	</div> <!-- row -->
		<?php echo form_hidden('save','Save');?>
		<div class="cell mb25 mt19">
			<div class="row">
				
				<div class="label_wrapper cell bg-non"></div><!--label_wrapper-->
				<div class="cell frm_element_wrapper">
					<div class="Req_fld cell"><?php echo $this->lang->line('requiredFields');?></div>				
					<div class="frm_btn_wrapper padding-right0">
						<?php 
						$button = array('submitSave','cancelForm');
						echo Modules::run("common/loadButtons",$button); 
						?>
						<!--
						 <div class="tds-button Fleft"><button type="button" onclick="calcelForm();" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)"><span><div class="Fleft">Cancel</div> <div class="icon-publish-btn"></div></span> </button> </div>
						  <div class="tds-button Fleft"><button type="submit" name="submit" value="Save" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)"><span><div class="Fleft">Save</div> <div class="icon-save-btn"></div> </span> </button> </div>					
						  -->
					</div>
					<div class="row"><div class="cell">*&nbsp;</div><div class="cell" ><?php echo $this->lang->line('req_field_long_msg');?></div></div>
					
					
					<?php if(@$projId=='' || @$projId==0 ){?>
					<div class="row height25"><div class="cell">*&nbsp;</div><div class="cell" ><?php echo $this->lang->line('msgForKeyPersonnel');?></div></div>
					<?php } else{?>
					<div class="row">
						<div class="cell">*&nbsp;</div>
						<div class="cell makeShowcaseBetter" ><?php echo $this->lang->line('makeShowcaseBetterMsgChange');?> <a href="<?php echo site_url(lang()).'/upcomingprojects/projectPromotionalImages/'.$projId;?>">Promotional Material</a> or 
						<a class="underline" href="<?php echo site_url(lang()).'/upcomingprojects/additionalInformation/'.$projId;?>">PR Material.</a></div>
					</div>
						
					<div class="row"><div class="cell">*&nbsp;</div><div class="cell makeShowcaseBetter" ><?php echo $this->lang->line('previewPublishInfoChange');?> <a href="<?php echo site_url().'upcomingprojects';?>">Index page</a>.</div></div>
					<?php }?>
				</div>
			</div>
			
		</div><!--frm_element_wrapper-->
		
		<?php
		
		echo form_close();
		
		if(isset($projId) && $projId>0 && $projId!='')
			echo  Modules::run("creativeinvolved/associativeCreatives",$projId,$currentEntityId,$this->lang->line('mediaProductionTeam'),'creativeInvolved',true);	  
		?>
		<div class="clear mb25"></div>
	</div>	
</div>

<script type="text/javascript">
$(document).ready(function(){
	    
	    var checkedVal = $("input[@name=projUpType]:checked").val();
	    
		if(checkedVal !=2){	
				
			$('#show1ForEvent').addClass('dn');
			$('#show2ForEvent').addClass('dn');
			
		}else{
		
			if($('#show1ForEvent').hasClass('dn') == true)				
			 $('#show1ForEvent').removeClass('dn');
			
			if($('#show2ForEvent').hasClass('dn') == true)				
			 $('#show2ForEvent').removeClass('dn');
		}
});	
	$( function() {		
		
		$('input[type="radio"]').click( function() {
					
			var selectedValue = $(this).attr('value');
			
			if(selectedValue == 2) { // only if the radio button has a dob-field				
				if($('#show1ForEvent').hasClass('dn') == true) $('#show1ForEvent').removeClass('dn');				
				if($('#show2ForEvent').hasClass('dn') == true) $('#show2ForEvent').removeClass('dn');					
			}
			else {
				$('#show1ForEvent').addClass('dn');
				$('#show2ForEvent').addClass('dn');
			}
			
		});

	});
	
	//To set focus on first field
	$('#projTitle').focus();
	function calcelForm()
	{
		location.href=baseUrl+language+"/upcomingprojects";
	}
	
	function checkDate()
	{
		var flag ;
		var projReleaseDate = document.getElementById("projReleaseDate").value;

		
			var yrSelected  = parseInt(projReleaseDate.substring(0,4),10);		
			
			var monSelected = parseInt(projReleaseDate.substring(5,7),10);
		
			var dtSelected  = parseInt(projReleaseDate.substring(8,10),10);
			
			
			var currentTime = new Date()
			var month = currentTime.getMonth() + 1;
			var day = currentTime.getDate();
			var year = currentTime.getFullYear();

			var date1_val = new Date(yrSelected,monSelected,dtSelected);
			//alert('date----'+date1_val);
			var date2_val =  new Date(year,month,day);
			//alert('date2_val'+date2_val);

			if(date1_val <  date2_val)
			{
				$('#msg').html(releaseDateCheck);
				$('#projReleaseDate').val('');
				flag 	= true;
			}else
			{
				$('#msg').html("");
			}
		return flag;
	}

</script>

