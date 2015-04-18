<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
if(isset($competi_entry_data['get_num_rows'])){
	$headText = $this->lang->line('edit_competition_entry');
	$competitionId =$competi_entry_data['get_result']->competitionId; 
	$compTitle = $competi_entry_data['get_result']->comptitle; 
	$titleData =$competi_entry_data['get_result']->title; 
	$tagwordsData =$competi_entry_data['get_result']->tagwords; 
	$coverImageData =$competi_entry_data['get_result']->coverImage; 
	$onelineDescriptionData=$competi_entry_data['get_result']->onelineDescription; 
	$descriptionData =$competi_entry_data['get_result']->description; 
	$competitionEntryId =$competi_entry_data['get_result']->competitionEntryId; 
	$fileId =$competi_entry_data['get_result']->fileId; 
	$rawFileName =$competi_entry_data['get_result']->rawFileName; 
	$embedCodeShow =$competi_entry_data['get_result']->filePath; 
	$isExternal =$competi_entry_data['get_result']->isExternal; 
	$fileLength =$competi_entry_data['get_result']->fileLength; 
	$languageIdFirst =$competi_entry_data['get_result']->languageidfirst; 
	$criteriaLang2Id =$competi_entry_data['get_result']->criteriaLang2Id; 
	$ageRequiresFrom =$competi_entry_data['get_result']->ageRequiresFrom; 
	$ageRequiresTo =$competi_entry_data['get_result']->ageRequiresTo; 
	$competitionCountries =$competi_entry_data['get_result']->competitionCountries; 
	$countriesCriteria =$competi_entry_data['get_result']->countriesCriteria; 
	$languageId =$competi_entry_data['get_result']->languageId; 
	$ageCriteriaSelected =$competi_entry_data['get_result']->ageCriteria; 
	$isPublished =$competi_entry_data['get_result']->isPublished; 
	$submitMethod= 'competitionentryupdate';
	$isAdd=false;
	$fileUnit='';
	$fileHeight =$competi_entry_data['get_result']->fileHeight; 
	$fileWidth =$competi_entry_data['get_result']->fileWidth; 
	$fileUnit =$competi_entry_data['get_result']->fileUnit; 
	
	$hh='00';
	$mm='00';
	$ss='00';
		
	if(($fileType==2 || $fileType==2) && !empty($fileLength))
	{
		$fileLengthArr = explode(":",$fileLength);
		$hh=$fileLengthArr[0];
		$mm=$fileLengthArr[1];
		$ss=$fileLengthArr[2];
	}
	$wordCountShow = $fileLength;
	$editFlag=1;
	
	$isMeetCriteria = $competi_entry_data['get_result']->isMeetCriteria; 
	
}else{
	$headText = $this->lang->line('add_competition_entry');
	$titleData =''; 
	$tagwordsData =''; 
	$coverImageData ='';
	$onelineDescriptionData=''; 
	$descriptionData =''; 
	$competitionEntryId =0;
	$fileId ='';
	$submitMethod= 'competitionentryinsert';
	$rawFileName='';
	$isExternal='f';
	$isAdd=true;
	$embedCodeShow='';
	$fileUnit='';
	$hh='00';
	$mm='00';
	$ss='00';
	$fileHeight =''; 
	$fileWidth =''; 
	$fileUnit =''; 
	$fileLength='';
	$wordCountShow = '';
	$editFlag=0;
	$languageIdFirst = $competitionData->criteriaLang1Id;
	$criteriaLang2Id = $competitionData->criteriaLang2Id;
	$ageRequiresFrom = $competitionData->ageRequiresFrom;
	$ageRequiresTo = $competitionData->ageRequiresTo;
	$competitionCountries = $competitionData->competitionCountries;
	$compTitle = $competitionData->title; 
	$languageId = $languageIdFirst;
	$countriesCriteria='';
	$ageCriteriaSelected ='';
	$isMeetCriteria ='f';
	$isPublished='f';
}
//add opactity class
$isOpacity = ($isAdd)?'opacity_4':'';

$lang=lang();
$browseId1='_image';
$browseId2='_sample';
$browseId3='_piece';

$formAttributes = array(
	'name'=>'competitionEntryForm',
	'id'=>'competitionEntryForm',
);
$formPieceAttributes = array(
	'name'=>'competitionEntryPieceForm',
	'id'=>'competitionEntryPieceForm',
);

$sectionIdInput = array(
	'name'	=> 'sectionId',
	'id'	=> 'sectionId',
	'type'	=> 'hidden',
	'value'	=> $sectionId
);

$title = array(
	'name' 		=> 'title',
	'id' 		=> 'title',
	'class' 	=> 'width556px required',
	'maxlength' 	=> '50',
	'size' 	=> '50',
	'value'	=> set_value('title',$titleData),
);


$wordCount = array(
	'name' 		=> 'wordCount',
	'id' 		=> 'wordCount',
	'class' 	=> 'width180px numberGreaterZero valid ml6',
	'value'	=>$wordCountShow,
	'maxlength' => '11',
);



$fileHeight = array(
		'name'	=> 'fileHeight',
		'id'	=> 'fileHeight',	
		'class'	=> 'width180px number ml5',
		'value'	=> $fileHeight,
		'maxlength'	=> 10,
		'size'	=> 50,
	);		
	
$fileWidth = array(
	'name'	=> 'fileWidth',
	'id'	=> 'fileWidth',	
	'class'	=> 'width180px number ',
	'value'	=> $fileWidth,
	'maxlength'	=> 10,
	'size'	=> 50,
);

$browseId1stInput = array(
	'name'	=> 'browseId1st',
	'value'	=> $browseId1,
	'id'	=> 'browseId1st',
	'type'	=> 'hidden'
);	

$browseId2ndInput = array(
	'name'	=> 'browseId2nd',
	'value'	=> $browseId2,
	'id'	=> 'browseId2nd',
	'type'	=> 'hidden'
);
$browseId3rdInput = array(
	'name'	=> 'browseId3rd',
	'value'	=> $browseId3,
	'id'	=> 'browseId3rd',
	'type'	=> 'hidden'
);

$ageCriteriaInput = array(
	'name'	=> 'ageCriteria',
	'id'	=> 'ageCriteria',
	'class' 	=> 'width250px number required',
	'value'	=> $ageCriteriaSelected,
	'type'	=> 'text'
);
if(isset($competitionData->ageRestriction) && $competitionData->ageRestriction =='t'){
	$ageCriteriaInput['min'] = $competitionData->ageRequiresFrom;
	$ageCriteriaInput['max'] = $competitionData->ageRequiresTo;
}
	
$hhList=numbersList($startFrom=0, $Upto=23, $interval=1);
$mmList=$ssList=numbersList($startFrom=0, $Upto=59, $interval=1);

?>
	

<div id="MediaFileIdDiv" class="row form_wrapper">
	<div class="row">
		<div class="cell frm_heading">
			<h1> <?php echo $headText; ?></h1>
		</div>
		<div class="cell frm_element_wrapper pt1">
			<div class="tds-button-big Fright"><a onmousedown="mousedown_big_button(this)" onmouseout="mouseout_big_button(this)" onmouseup="mouseup_big_button(this)" href="<?php echo base_url('competition/competitionentrylist'); ?>"><span class="two_line"><?php echo $this->lang->line('compti_entries_br_index'); ?> </span></a></div>
			<div class="row line1 mr3"></div>
		</div>
	</div>
	

	
	<div class="row position_relative">	
		<?php //$this->load->view("common/strip");?>
		
		<?php if(isset($isMultilingual) && ($isMultilingual==true)){
	
		$languageLink1=isset($languageLink1)?$languageLink1:'#';
		$languageLink2=isset($languageLink2)?$languageLink2:'#';
		$activeLang1=isset($activeLang1)?$activeLang1:'';
		$activeLang2=isset($activeLang2)?$activeLang2:'';
		$language1=isset($language1)?$language1:$this->lang->line('language1');
		$language2=isset($language2)?$language2:$this->lang->line('language2');
		 ?>
		<div class="row fr pr15 pt10 pb10">
			<div class="cell"><a href="<?php echo $languageLink1; ?>" class="fm_os dash_link_hover <?php echo $activeLang1;?>"><?php echo $language1;?></a></div>
			<div class="cell pl10 pr10 f14 fm_os grey ">|</div>
			<div class="cell"><a href="<?php echo $languageLink2; ?>" class="fm_os <?php echo $activeLang2;?>"><?php echo $language2;?></a></div>
		</div>
		<?php }  ?>

	
	<!----competition entry details section---->	
	
		<div class="row tab_wp pt2 ">
			<?php echo form_open(base_url(SITE_AREA_SETTINGS.'competition/'.$submitMethod),$formAttributes); 
			echo form_input($sectionIdInput);
			?>	
			
			<div id="upload2ndFileDiv">
				<?php
				echo form_input($browseId1stInput);
				echo form_input($browseId2ndInput);
				?>
			</div>
		  <div id="elementTab" class="row ">
			<div class="cell tab_left">
			  <div class="tab_heading">Competition Entry Details</div>
			  <!--tab_heading-->
			</div>
			<div class="cell tab_right"> 
				<span class="according_heading"><?php echo $compTitle; ?></span>
			  <div class="tab_btn_wrapper">
				<div class="tds-button-top">
					<a class="formTip" original-title="">
						<span><div class="projectToggleIcon toggle_icon" id="elementToggelDiv" toggledivid="FDES" style="background-position: -1px -144px; "></div></span>
					</a>
				 </div>
			  </div>
			  
			</div>
		  </div>
		  <!--row-->
		  <div class="clear"></div>
		  <div class="form_wrapper toggle frm_strip_bg " id="FDES" style="display: block; ">
				<div class="row"><div class="tab_shadow"></div></div>
				
		<?php
		if($competitionData){
			/*echo "<pre>";
			print_r($competitionData);
			echo "</pre>";*/
				?>	
			<div class="row">
				<div class="upload_media_left_top row"></div><!--upload_media_left_top-->
				<div class="upload_media_left_box">
					<div class="row">
						<div class="cell label_wrapper">
							<div class="lable_heading_g select_field_g"><h1> <?php echo $this->lang->line('criteria'); ?> </h1></div>
						</div>
						<!--label_wrapper-->
						<div class=" cell frm_element_wrapper pl14">
							  <div class="row font_opensans clr_888">
								<?php echo $this->lang->line('competitionCriteriaMsg'); ?>
							 </div>
							 
							  <div class="row pt10">
								<?php echo $competitionData->rules; ?>
							 </div>
						</div>
					</div>
				
					<div class="row">
						<div class="cell label_wrapper"><label class="select_field"><?php echo $this->lang->line('media_type');?></label></div>
						<div class="cell frm_element_wrapper">
							<div class="pt8"><?php echo $this->config->item('file_type_'.$fileType); ?></div>
						</div>
					</div>
					
					<div class="row">
						<div class="cell label_wrapper"><label class="select_field"><?php echo $this->lang->line('submission_teritory');?></label></div>
						<div class="cell frm_element_wrapper">
							<div class="pt8">
								<?php
								if($competitionData->teritoryType==0){
									$compCountries=$this->lang->line('global');
								}else{
									$compCountries=zoneCountries($competitionData->competitionCountries);
								}
								 echo $compCountries;?>
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="cell label_wrapper"><label class="select_field"><?php echo $this->lang->line('votes_teritory');?></label></div>
						<div class="cell frm_element_wrapper">
							<div class="pt8">
								<?php
								if($competitionData->voteTeritoryType==0){
									$voteCountries=$this->lang->line('global');
								}else{
									$voteCountries=zoneCountries($competitionData->votesCountries);
								}
								 echo $voteCountries;?>
							</div>
						</div>
					</div>
					
					<?php
					if((strlen($competitionData->cl1_language) > 2) || (strlen($competitionData->cl2_language) > 2)){
						if((strlen($competitionData->cl1_language) > 2) && (strlen($competitionData->cl2_language) > 2)){
							$lang1_label= $this->lang->line('language1');
							$lang2_label=$this->lang->line('language2');
						}else{
							$lang1_label=$this->lang->line('language');
							$lang2_label=$this->lang->line('language');
						} 			
						if(strlen($competitionData->cl1_language) > 2){
							?>
							<div class="row">
								<div class="cell label_wrapper"><label class="select_field"><?php echo $lang1_label;?></label></div>
								<div class="cell frm_element_wrapper">
									<div class="pt8">
										<?php echo $competitionData->cl1_local_language;?>
									</div>
								</div>
							</div>
							<?php
						}
						if(strlen($competitionData->cl1_language) > 2){
							?>
							<div class="row">
								<div class="cell label_wrapper"><label class="select_field"><?php echo $lang2_label;?></label></div>
								<div class="cell frm_element_wrapper">
									<div class="pt8">
										<?php echo $competitionData->cl2_local_language;?>
									</div>
								</div>
							</div>
							<?php
						}
					} ?>
					
					<div class="row">
						<div class="cell label_wrapper"><label class="select_field"><?php echo $this->lang->line('ageRequires');?></label></div>
						<div class="cell frm_element_wrapper">
							<div class="row pt8">
								<?php
								if($competitionData->ageRestriction !='t'){
									$ageRequires=$this->lang->line('all');
								}else{
									$ageRequires=$competitionData->ageRequiresFrom.' - '.$competitionData->ageRequiresTo;
								}
								 echo $ageRequires;?>
							</div>
							<?php 
							if($isMeetCriteria=='t'){
									$mcChecked='checked';
									$mcShow='dn';
							}
							else{ 
								$mcChecked='';
								$mcShow='';
							} ?>
							<div class="row pt20">
								<div class="cell defaultP">
									<input type="checkbox" name="isMeetCriteria" id="isMeetCriteria" value="t" <?php echo $mcChecked; ?> onclick="if(this.checked){$('#mcError').hide();} else{$('#mcError').show();}"; />
								</div>
								<div class="cell"><?php echo $this->lang->line('isMeetCriteriaMsg');?></div>
							</div>
							<div class="row <?php echo $mcShow; ?>" id="mcError">
								<?php echo $this->lang->line('meetCompetitionCriteria');?>
							</div>
						</div>
					</div>
					 <div class="seprator_5 clear"></div>
									
				</div>
				<div class="upload_media_left_bottom row"></div><!--upload_media_left_bottom-->
			  </div>
			  <div class="seprator_15 clear"></div>				
			<?php
		}?>		
				
				
				
				<?php
				$required='';
				$competitonImage=$coverImageData;
				$defaultcompetitonImage=$this->config->item('defaultcompetitonImage');
				$competitonThumbImage = addThumbFolder($competitonImage,'_s');	
				$imgsrc = getImage($competitonThumbImage,$defaultcompetitonImage);
				$data=array('typeOfFile'=>1, 'imgSrc'=>$imgsrc,'mediaFileTypes'=>$this->config->item('imageType'),'fileMaxSize'=>$fileMaxSize,'isEmbed'=>'f','fileName'=>'','fileSize'=>0,'filePath'=>$dirMedia,'embedCode'=>'', 'required'=>$required, 'label'=>$this->lang->line('coverImage'),'editFlag'=>0,'fileTypeFlag'=>0,'flag'=>1,'browseId'=>$browseId1,'imgload'=>1,'norefresh'=>0);
				$this->load->view("upload_form",$data);
				?>
					<div class="row">
						<div class="cell label_wrapper"><label class="select_field"><?php echo $this->lang->line('competition_entry_title'); ?></label></div>
						<div class="cell frm_element_wrapper">
							<?php echo form_input($title); ?>
							<div class="row wordcounter"></div>
						</div>
					</div>
					
					<?php 
						$data=array('name'=>'onelineDescription','id'=>'onelineDescription','value'=>$onelineDescriptionData, 'rows' => '2', 'cols' => '90', 'required'=>'required', 'labelText'=>'competition_entry_od');
						$this->load->view("common/oneline_description",$data);
					
						$data=array('name'=>'tagwords','id'=>'tagwords','value'=>$tagwordsData,'required'=>'required', 'labelText'=>'tagWords');
						$this->load->view("common/tag_words",$data);
						$wordOption = array('minVal'=>'0','maxVal'=>'100');
						$data=array('name'=>'description','id'=>'description','value'=>$descriptionData,'required'=>'', 'labelText'=>'competition_entry_descrip','wordOption'=>$wordOption);
						$this->load->view("common/description",$data);
					?>
				
					<div class="row">
						<div class="cell label_wrapper"><label class="select_field"><?php echo $this->lang->line('language_select');?></label></div>
						<div class="cell frm_element_wrapper">
								<?php
									$languageListing='';
									$language = getlanguageList();
									foreach($language as $key=>$value)
									{
										if(($key==$languageIdFirst || $key==$criteriaLang2Id) && $key !=0)
										{
											$languageListing[$key] = $value;
										}
									}
									echo form_dropdown('languageId', $languageListing, $languageId,'id="languageId" class="required" title="'.$this->lang->line('thisFieldIsReq').'"');
								?>
						</div>
					</div>
					
					<div class="row">
						<div class="cell label_wrapper"><label class="select_field"><?php echo $this->lang->line('countries_criteria');?></label></div>
						<div class="cell frm_element_wrapper">
								<?php
									if(isset($competitionData->teritoryType[0]) && ($competitionData->teritoryType[0]==0)){
										$countryListing = getCountryList();
									}else
									{
										$getCountryListing = getCountryList();
										$getCriteriaCountry= explode("|",$competitionCountries);
										foreach($getCountryListing as $key=>$value)
										{
											foreach($getCriteriaCountry as $matchValue)
											{
												if($key==$matchValue)
												{
													$countryListing[$key] = $value;
												}
											}
										}
									}
									echo form_dropdown('countriesCriteria', $countryListing, $countriesCriteria,'id="countriesCriteria" class="required" title="'.$this->lang->line('thisFieldIsReq').'"');
								?>
						</div>
					</div>
					
					
					
					<div class="row">
						<div class="cell label_wrapper"><label class="select_field"><?php echo $this->lang->line('competition_entry_lang');?></label></div>
						<div class="cell frm_element_wrapper">
								<?php echo form_input($ageCriteriaInput);?>
							</div>
						</div>
					<?php 
						
					/*	
						 ?>
					
					<div class="row">
						<div class="cell label_wrapper" id="descdescription">
							<label class=""> <?php echo $this->lang->line('competition_file_type'); ?></label>
						</div>
						<div class="cell frm_element_wrapper pt13">
								<?php echo $this->config->item('file_type_'.$fileType); ?>
						</div>
					</div>
					
					<?php
					*/ ?>
					
					<div class="row">
				<!---sub_heading_media--->
				<div class="label_wrapper cell"><div class="lable_heading"><h1><?php echo $this->lang->line('competition_entry_sm'); ?></h1></div></div><!--label_wrapper-->
				<div class=" cell frm_element_wrapper"></div>
			</div>
			<!---------submit media  section start ----->	
			<div id="uploadElementForm" class="dn" style="display: block; ">
				<div class="upload_media_left_top row"></div><!--upload_media_left_top-->
				<div class="upload_media_left_box">
				
				<?php
				if($isAdd==false && $isExternal=="f"){ 
					?>
					<div class="row " id="rawFileNameContainerDiv">
						<div class="label_wrapper cell">
						  <label class="select_field"><?php echo $this->lang->line('file'); ?></label>
						</div>
						<!--label_wrapper-->
						<div class=" cell frm_element_wrapper mt5" id="rawFileNameDiv">
							<?php echo $rawFileName; ?>
						</div>
					 </div>
					<?php
				}else
				{
					$data=array('typeOfFile'=>$fileType,'mediaFileTypes'=>$mediaFileTypes,'fileMaxSize'=>$fileMaxSize,'isEmbed'=>$isExternal,'fileName'=>'','fileSize'=>0,'filePath'=>$dirMedia,'embedCode'=>$embedCodeShow, 'required'=>'required', 'label'=>$this->lang->line('file'),'editFlag'=>$editFlag,'fileTypeFlag'=>0,'flag'=>0,'browseId'=>$browseId2,'imgload'=>0,'norefresh'=>1);
					$this->load->view("upload_form",$data);
				} ?>
				<div id="fileLengthDiv" class="row " style="">
					<div class="label_wrapper cell">
					  <label id="fileLengthLabel"><?php echo $fileLable; ?></label>
					</div>
						<?php switch($fileType) { 
							case 1:
						?>
						<!--image dimention info div start-->
							<div class=" cell frm_element_wrapper">
								<div class="row">
									<div class="cell">
										<div class="row pr">
										<?php echo form_input($fileHeight);  ?>	
										</div>
									</div>
									<div class="cell ml10 mr10 mr5 mt5"> X </div>	
									<div class="cell pr mr10">
										<div class="row pr">
										<?php echo form_input($fileWidth); ?>
										</div>
									</div>
									<div class="cell pr">
										<div class="row pr">
											<div class="small_select_wp_a pt5">	
											<?php 
												$unitArray = array(
												''  => $this->lang->line('selectUnits'),
												'px'  => $this->lang->line('pixels'),
												'mm'    => $this->lang->line('millimeters'),
												 'inch'   => $this->lang->line('inch'),
												);
												$js= 'class="width_122" id="fileUnit"';
												echo form_dropdown('fileUnit', $unitArray, $fileUnit,$js);
												?>	
											</div>
											
											<div id="fileUnitError" class="dn error"><?php echo $this->lang->line('requiredmSg');?></div>	
										</div>		
									</div>
								</div>
								<div class="row wordcounter"></div>
								<div class="seprator_5"></div>
								</div>
							<!--image and dimention info div end-->	
							<?php
								break;
								case 2:
								case 3: ?>
							<!--length and duration info div start-->
								<div class=" cell frm_element_wrapper">
									<div class="row">
										<div class="cell">
											<div class="row pr">
											<?php echo form_dropdown('hh', $hhList, $hh,'id="hh" class="width80px l0px"');?>	
											</div>
											<div class="greyMsg pt5 pl15">HH</div>
										</div>
										<div class="cell pr">
											<div class="row pr">
											<?php echo form_dropdown('mm', $mmList, $mm,'id="mm" class="width80px l0px"');?>
											</div>
											<div class="greyMsg pt5 pl15">MM</div>
										</div>
										<div class="cell pr">
											<div class="row pr">
											<?php echo form_dropdown('ss', $ssList, $ss,'id="ss" class="width80px l0px"');?>
											</div>
											<div class="greyMsg pt5 pl15">SS</div>
										</div>
									</div>
									<div class="row wordcounter"></div>
									<div class="seprator_5"></div>
								</div>
							<!--length and duration info div end-->	
						<?php break; 
						case 4: ?>
							<!--length and dimention info div start-->
								<div class=" cell frm_element_wrapper">
									<div class="row">
										<?php echo form_input($wordCount); ?>
									</div>
									<div class="row wordcounter"></div>
									<div class="seprator_5"></div>
								</div>
							<!--length and dimention info div end-->
					<?php break; ?>		
					
					<?php    } ?>
					
					</div>
			</div>
			<div class="upload_media_left_bottom row"></div><!--upload_media_left_bottom-->
			
		</div>			
					<!---------submit media  section end ----->	
					<div class="seprator_25 row"></div><!--from_element_wrapper-->
					<div class="row">
							<div class="label_wrapper cell bg-non"></div><!--label_wrapper-->
							<div class=" cell frm_element_wrapper">
								<div class="Req_fld cell"><?php echo $this->lang->line('requiredFields');?></div><!--Req_fld-->
									<div class="fr padding-right0 ">
									
									<?php
										$isEditBlock=false;
										if(isset($competitionEntryId) && $competitionEntryId > 0){
											// if competition entry is published then can't be edit
											if($isPublished=='t'){
												$isEditBlock=true;
											}	
										}else{?>
											<div class="tds-button Fleft"><button id="ajaxPieceCancelButton" type="button" class="ajaxPieceCancelButton dash_link_hover" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)" style="background-position: 0px -38px; "><span style="background-position: 100% -38px; "><div class="Fleft">Close</div> <div class="icon-form-close-btn"></div></span></button></div>
										<?php	}  ?>	    
										    
											 <div class="tds-button Fleft"><button id="submitButton" type="submit" name="submit" value="Save" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)" class="dash_link_hover"><span><div class="Fleft">Save</div> <div class="icon-save-btn"></div></span></button></div>
									</div>
								 <div class="row height25"><div class="cell">*&nbsp;</div><div class="cell"><?php echo $this->lang->line('descReqFieldMsg');?></div></div>
							</div>
						</div>
					<div class="seprator_25 clear row"></div>  
		   
				  </div>
				  <!--tab_wp-->
				  <!--row-->
				  <div class="clear"></div>
				  <!--form_wrapper toogle frm_strip_bg-->
				  <div class="clear"></div>
				  
			<input type="hidden" id="competitionRoundType" value="<?php echo competitionRound($competitionId); ?>" name="competitionRoundType">
			<input type="hidden" id="competitionId" value="<?php echo $competitionId; ?>" name="competitionId">
			<input type="hidden" id="formAction" value="competitionDetails" name="formAction">
			<input type="hidden" id="competitionEntryId" value="<?php echo $competitionEntryId; ?>" name="competitionEntryId">
			<input type="hidden" name="totalFileToupload" id="totalFileToupload" value="0" />
			<div id="MediaFileIdDiv"><input type="hidden" name="MediaFileId" id="MediaFileId" value="0" /></div>
			<input type="hidden" name="relocateId" id="relocateId" value="<?php echo base_url(lang().'/competition/competitionentryedit/'.$competitionId.'/'.$competitionEntryId);?>" />
		<?php echo form_close(); ?>
				  
		</div>
				
			<!----competition submmited section---->		
				
			<div class="row tab_wp ">
			  <div class="row ">
				<div class="cell tab_left">
				  <div class="tab_heading">Piece Details</div>
				  <!--tab_heading-->
				</div>
				<div class="cell tab_right"> 
				  <span class="according_heading"><?php echo $compTitle; ?></span>
				  <div class="tab_btn_wrapper">
					<div class="tds-button-top">
					  <a class="formTip" original-title=""> <span>
					  <div class="projectToggleIcon toggle_icon" toggledivid="FDS" style="background-position: -1px -144px; "></div>
					  </span> </a> 
					  </div>
				  </div>
				</div>
			  </div>
			  <!--row-->
			  <div class="clear"></div>
			  <div class="form_wrapper toggle frm_strip_bg " id="FDS" style="display: block; ">
				  <div class="row"><div class="tab_shadow"></div></div>
					
				<!---piece upload section start--->
				<?php echo form_open(base_url(SITE_AREA_SETTINGS.'competition/'.$submitMethod),$formPieceAttributes);	
				echo form_input($browseId3rdInput);
				?>
				<div id="piceceuploadElementForm" class="dn">
					<div class="upload_media_left_top row"></div>
					<div class="upload_media_left_box">
							  <div class="row">
								<div class="label_wrapper cell">
								  <label class="select_field">Title</label>
								</div>
								<!--label_wrapper-->
								<div class=" cell frm_element_wrapper">
								  <input type="text" name="fileTitle" value="" id="fileTitle" class="width546px required" minlength="2">										<div class="row wordcounter"></div>
								</div>
							  </div>
							  
							  <div class="row " id="rawPieceFileNameContainerDiv">
								<div class="label_wrapper cell">
								  <label class="select_field"><?php echo $this->lang->line('file'); ?></label>
								</div>
								<!--label_wrapper-->
								<div class="cell frm_element_wrapper mt5" id="rawPieceFileNameDiv">
									
								</div>
							 </div>
							 <div id="pieceUploadFormDiv"> 
								<?php 
									$mediaFileTypes = $this->config->item('prNewsAccept');
									$fileMaxSize = $this->config->item('image5MBSize');
									$data=array('mediaFileTypes'=>$mediaFileTypes,'fileMaxSize'=>$fileMaxSize,'isEmbed'=>'f','fileName'=>'','fileSize'=>0,'filePath'=>$dirMedia,'required'=>'required', 'label'=>$this->lang->line('file'),'editFlag'=>false,'fileTypeFlag'=>0,'flag'=>0,'browseId'=>$browseId3,'imgload'=>0,'norefresh'=>1);
									$this->load->view("piece_upload_form",$data);
								?>	
							</div>	
								
							<!--from_element_wrapper-->
							 <div class="row">
								<div class="label_wrapper cell bg-non">
									&nbsp;
								</div>
								<!--label_wrapper-->
								<div class="cell frm_element_wrapper">
									<div class="Req_fld cell">Required Fields </div>
									<div class="price_btn_position pr">
									<div class="fr padding-right0 ">
										<div class="tds-button Fleft"><button id="AjaxcancelButton" type="button" class="ajaxCancelButton dash_link_hover" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)"><span><div class="Fleft">Close</div> <div class="icon-form-close-btn"></div></span></button></div>
										<div class="tds-button Fleft"><button id="saveButton" type="submit" name="submit" value="Save" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)" class="dash_link_hover"><span><div class="Fleft">Save</div> <div class="icon-save-btn"></div></span></button></div>
									</div>
								</div>
								</div>
							</div>
					</div>
					<div class="upload_media_left_bottom row"></div><!--upload_media_left_bottom-->
					<!--upload_media_left_box-->
					<div class="seprator_25 clear"></div> 
				</div>	
				
				<input type="hidden" id="competitionId" value="<?php echo $competitionId; ?>" name="competitionId">
				<input type="hidden" id="formAction" value="pieceUpload" name="formAction">
				<input type="hidden" id="competitionEntryId" value="<?php echo $competitionEntryId; ?>" name="competitionEntryId">
				<input type="hidden" id="ceSupportingId" value="" name="ceSupportingId">
				<input type="hidden" id="pieceFormAction" value="" name="pieceFormAction">
				<input type="hidden" id="pieceOrder" value="" name="pieceOrder">
				<?php echo form_close(); ?>
				<!---piece upload section start--->		
			
			<?php 
			//$competitionprizeQuantity = $this->config->item('ceSupportingMateraiQuantity');
			$ceSupportingQuantity = '4';
			$arraryData='';	
			if(isset($supportingMaterialData) && count($supportingMaterialData) > 0 ) {
			foreach($supportingMaterialData as $supportingMaterial){
				 $arraryData[$supportingMaterial['fileOrder']] = $supportingMaterial;
				}
			} ?>
				<!---------Piece media  section start ----->	
				<?php for($i=1;$i<=$ceSupportingQuantity;$i++) { 
						
					if(isset($arraryData[$i])) { 
					?>
					<!--------piece editing section showing-------->	
					<div class="row" id="row<?php echo $i; ?>">
						
						<script>
							 var data<?php echo $i; ?> = {"isEdit":true,"pieceOrder":<?php echo $i; ?>,"id":<?php echo $arraryData[$i]['CESupportingMaterialid'] ?>,"fileTitle":"<?php echo $arraryData[$i]['title']; ?>","rawFileName":"<?php echo $arraryData[$i]['rawFileName']; ?>"};
						</script>

					  <div class="label_wrapper cell bg-non"></div>
					  <!--label_wrapper-->
					  <div id="rowData268" class=" cell frm_element_wrapper extract_content_bg">
						<div class="extract_img_wp "> 
							<img class="formTip ptr maxWH30 ma" src="<?php echo base_url('images/default_thumb/competitionentry_73x110.jpg');?>" title="<?php echo $arraryData[$i]['title']; ?>">
						</div>
						<!--extract_img_wp-->
						<div class="extract_heading_box "> <?php echo $arraryData[$i]['title']; ?></div>
						<!--extract_heading_box-->
						<div class="extract_button_box">
							<div title="Edit" class="small_btn formTip"><a onclick="changePieceFormValue(data<?php echo $i; ?>)" href="javascript:void(0)"><div class="cat_smll_edit_icon"></div></a></div>
						</div>									
					  </div>
					</div>
				<!--------piece add section showing----------->	
				<?php } else { ?>
					<div class="row" id="row<?php echo $i; ?>">
						<script>
							 var data<?php echo $i; ?> = {"isEdit":false,"pieceOrder":<?php echo $i; ?>};
						</script>
					  <div class="label_wrapper cell bg-non"></div>
					  <!--label_wrapper-->
					  <div id="rowData268" class=" cell frm_element_wrapper extract_content_bg">
						<div class="extract_img_wp opacity_4"> 
							<img class="formTip ptr maxWH30 ma" src="<?php echo base_url('images/default_thumb/competitionentry_73x110.jpg');?>" title="Piece <?php echo $i; ?>">
						</div>
						<!--extract_img_wp-->
						<div class="extract_heading_box opacity_4"> Piece  <?php echo $i; ?></div>
						<!--extract_heading_box-->
						<div class="extract_button_box <?php echo $isOpacity; ?>">
						<?php $actionFunction = (!$isAdd)?'onclick="changePieceFormValue(data'.$i.')"':''; ?>
							<div class="small_btn formTip" title="Add"><a <?php echo $actionFunction; ?> href="javascript:void(0)" ><div class="cat_smll_add_icon"></div></a></div>
						</div>									
					  </div>
					</div>
				<?php }  } ?>	
		
			<div class="clear"></div>
		
			<div class="seprator_25 row"></div><!--from_element_wrapper-->
	
		<div class="row seprator_25"></div>
      <div class="clear"></div>
    </div>
    
    <div class="row"><div class="tab_shadow"></div></div>

  </div>
 		
		<!---------Piece media  section end ----->		
		<div class="seprator_25 clear row"></div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		
		// when competition entry is published and it have one entry then can't be edit
		var isBlockEdit = '<?php echo ($isEditBlock)?"1":"0"; ?>';
		
		$("#competitionEntryForm").validate({
			submitHandler: function() {
				
				var isMeetCriteria = $('#isMeetCriteria').attr('checked');
				if(isMeetCriteria){
					
				}else{
					scrollTo(0,200);
					return false;
				}
				
				var fileWidth = $('#fileWidth').val();
				var fileHeight = $('#fileHeight').val();
				var fileUnit = $('#fileUnit').val();
				
				// Check file height and file Width 
				if(fileHeight!=0 && fileWidth!=0) {
					  if(fileUnit=='')
					  {
						  //alert('Please select unit')
						   $('#fileUnitError').show();
						  return false;
					  }
					  else  $('#fileUnitError').hide();
				}
				if(fileWidth=="" || fileHeight=="")
				{
					$('#fileWidth').val('');
					$('#fileHeight').val('');
					$('#fileUnit').val('');
				}
			
				//---------set lenght and duration---------//	
				var hh=$('#hh').val();
				var mm=$('#mm').val();
				var ss=$('#ss').val();
				if(parseInt(hh) >=0 || parseInt(mm) >=0 || parseInt(ss) >=0){
					var fileLength=hh+':'+mm+':'+ss;
				}else{
					var fileLength='00:00:00';
				}
				
				var fromData=$("#competitionEntryForm").serialize();
				fromData = fromData+'&fileLength='+fileLength;
				
				var url = baseUrl+language+'/competition/<?php echo $submitMethod; ?>';
				if(isBlockEdit=='0'){
				
				$.post(url,fromData, function(data) {
					  if(data){
						  
						 	if(data.fileId){
							  $("#MediaFileId").val(data.fileId);
							}
							
							if(data.uploadedFile && data.uploadedFile > 0){
							  $("#totalFileToupload").val(data.uploadedFile);
							}
							
							var competitionEntryId =  $("#competitionEntryId").val();
							
							competitionEntryId = parseInt(competitionEntryId);
							if(data.competitionEntryId && competitionEntryId == 0){
								$("#relocateId").val(baseUrl+language+'/competition/competitionentryedit/<?php echo $competitionId;?>/'+data.competitionEntryId);
								$("#fileUploadPath<?php echo $browseId1?>").val('<?php echo $mediaPath?>'+data.competitionEntryId);
								$("#fileUploadPath<?php echo $browseId2?>").val('<?php echo $mediaPath?>'+data.competitionEntryId);
							}
							var redirectUrl=$("#relocateId").val();
							$("#uploadFileByJquery<?php echo $browseId1?>").click();
							$("#uploadFileByJquery<?php echo $browseId2?>").click();
							
							var fileName1 =  $("#fileName<?php echo $browseId1?>").val();
							if(fileName1 == undefined){
								fileName1 = '';
							}
							
							var fileName2 =  $("#fileName<?php echo $browseId2?>").val();
							if(fileName2 == undefined){
								fileName2 = '';
							}
							
							if(fileName1.length < 4 && fileName2.length < 4){
								goTolink('',redirectUrl);
							}
						}
				},"json");
				}else{
					customAlert('<?php echo $this->lang->line('cannotEditCompEntryMsg'); ?>');
				}
				
			}
		});
		
		//-----------------hide picece upload form--------------------//
		
		$('.ajaxCancelButton').click(function(){
			$("#piceceuploadElementForm").slideToggle('slow');
		});
		
		$("#competitionEntryPieceForm").validate({
			
			submitHandler: function() {
				
				var pieceFormAction = $("#pieceFormAction").val();
				var pieceOrder = $("#pieceOrder").val();
				var fromData=$("#competitionEntryPieceForm").serialize();
				fromData = fromData+'&pieceFormAction='+pieceFormAction+'&pieceOrder='+pieceOrder;
				var url = baseUrl+language+'/competition/<?php echo $submitMethod; ?>';
				
				if(isBlockEdit=='0'){
					$.post(url,fromData, function(data) {
						  if(data){
							  
								if(data.fileId){
								  $("#MediaFileId").val(data.fileId);
								}
								
								if(data.uploadedFile && data.uploadedFile > 0){
								  $("#totalFileToupload").val(data.uploadedFile);
								}
								
								var competitionEntryId =  $("#competitionEntryId").val();
								
								competitionEntryId = parseInt(competitionEntryId);
								if(data.competitionEntryId && competitionEntryId == 0){
									$("#relocateId").val(baseUrl+language+'/competition/competitionentryedit/<?php echo $competitionId;?>/'+data.competitionEntryId);
									$("#fileUploadPath<?php echo $browseId3?>").val('<?php echo $mediaPath?>'+data.competitionEntryId);
								}
								var redirectUrl=$("#relocateId").val();
								$("#uploadFileByJquery<?php echo $browseId3?>").click();
								
								var fileName1 =  $("#fileName<?php echo $browseId3?>").val();
								
								if(fileName1 == undefined){
									fileName1 = '';
								}
								
								if(fileName1.length < 4){
									goTolink('',redirectUrl);
								}
							}
					},"json");
				
				}else{
					customAlert('<?php echo $this->lang->line('cannotEditCompPieceMsg'); ?>');
				}
			}
			
		});	
	});
	
	//----------change piece value function---------//
	
	function changePieceFormValue(data) {
		$('label.error').remove();
		$('input.error').each(function(index){
			var inputClass =$(this).attr('class').replace('error', '');
			$(this).attr('class',inputClass);
		});
		$("#fileName<?php echo $browseId3?>").val('');
		$("#fileSize<?php echo $browseId3?>").val('');
		$("#isExternal<?php echo $browseId3?>").val('');
		$("#fileUploadPath<?php echo $browseId3?>").val('');
		$('#competitionEntryPieceForm')[0].reset();
		if(!$('#piceceuploadElementForm').is(":visible")){
			$("#piceceuploadElementForm").slideToggle('slow');
		}
		
		if(data.isEdit) {	
			$('#fileTitle').val(data.fileTitle);
			$('#ceSupportingId').val(data.id);
			$('#rawPieceFileNameDiv').html(data.rawFileName);
			$('#pieceUploadFormDiv').hide();
			$('#rawPieceFileNameContainerDiv').show();
			$("#pieceFormAction").val('pieceEdit');
			$("#pieceOrder").val(data.pieceOrder);
			
		}else{
			$("#pieceFormAction").val('pieceAdd')
			$('#rawPieceFileNameContainerDiv').hide();
			$('#pieceUploadFormDiv').show();
			$('#fileTitle').val('');
			$("#pieceOrder").val(data.pieceOrder);
		}
	}

</script>


