<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

$isAdd=true;
$titleData =''; 
$tagwordsData =''; 
$coverImageData ='';
$onelineDescriptionData=''; 
$headText = $this->lang->line('add_competition_entry');
$competitionEntryLangId = 0;
$languageIdFirst = $competitionData->criteriaLang1Id;
$criteriaLang2Id = $competitionData->criteriaLang2Id;
$languageId = $languageIdFirst;
$isPublished='f';
// check competition entry lang1 data
if(isset($competi_entry_data['get_num_rows'])){
	$isPublished =$competi_entry_data['get_result']->isPublished; 
}

if($competitionEntryLang2 && !empty($competitionEntryLang2)){
	$competitionEntryLang2 = $competitionEntryLang2[0];
	$headText = $this->lang->line('edit_competition_entry');
	$titleData =$competitionEntryLang2->title; 
	$tagwordsData =$competitionEntryLang2->tagwords; 
	$onelineDescriptionData=$competitionEntryLang2->onelineDescription; 
	$descriptionData =$competitionEntryLang2->description; 
	$competitionEntryLangId =$competitionEntryLang2->competitionEntryLangId; 
	$languageId =$competitionEntryLang2->languageId; 
	$isAdd=false;
}
//add opactity class
$isOpacity = ($isAdd)?'opacity_4':'';

$formAttributes = array(
	'name'=>'competitionEntryLangForm',
	'id'=>'competitionEntryLangForm',
);


$title = array(
	'name' 		=> 'title',
	'id' 		=> 'title',
	'class' 	=> 'width556px required',
	'maxlength' 	=> '50',
	'size' 	=> '50',
	'value'	=> set_value('title',$titleData),
);


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
			<?php echo form_open(base_url(SITE_AREA_SETTINGS.'competition/'.$submitMethod),$formAttributes); 	?>	
			
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
										<?php } ?>	
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
				  
			<input type="hidden" id="competitionEntryLangId" value="<?php echo $competitionEntryLangId; ?>" name="competitionEntryLangId">
			<input type="hidden" id="competitionEntryId" value="<?php echo $competitionEntryId; ?>" name="competitionEntryId">
			<input type="hidden" name="relocateId" id="relocateId" value="<?php echo base_url(lang().'/competition/competitionentryedit/'.$competitionId.'/'.$competitionEntryId);?>" />
		<?php echo form_close(); ?>
				  
		</div>
				
	
	 <div class="row"><div class="tab_shadow"></div></div>
		<!---------Piece media  section end ----->		
		<div class="seprator_25 clear row"></div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		
		// when competition entry is published and it have one entry then can't be edit
		var isBlockEdit = '<?php echo ($isEditBlock)?"1":"0"; ?>';
		
		$("#competitionEntryLangForm").validate({
			submitHandler: function() {
				
				var fromData=$("#competitionEntryLangForm").serialize();
				
				var url = baseUrl+language+'/competition/entrylanginsertupdate';
				
				if(isBlockEdit=='0'){
					$.post(url,fromData, function(data) {
						  if(data){
							  refreshPge();
							}
					},"json");
				}else{
					customAlert('<?php echo $this->lang->line('cannotEditCompEntryMsg'); ?>');
				}
			}
		});
		
	
	});
	
	
</script>


