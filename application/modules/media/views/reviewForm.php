<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
	
	$lang=lang();
	
	//$industryId=0;	
	$languageId=0;
	$required='required';
	$entityId=(!empty($entityId)) ? $entityId : 0;
	$elementId=(!empty($elementId)) ? $elementId : 0;	
	
	
	//echo 'PROJ---'.$projectId .'ELEM'.$elementId.'ENT'.$entityId;
	
	$projectID = (!empty($projectId))?$projectId:$elementId;
	
	$section  = (!empty($section)) ? $section : '' ;
	$projName =  (!empty($projName)) ? $projName : '' ;
	$industryId = (!empty($industryId)) ? $industryId : '' ;

	
	$formAttributes = array(
		'name'=>'uploadmediaForm',
		'id'=>'uploadmediaForm',
		'toggleDivForm'=>'uploadElementForm'
	);
	$title = array(
		'name'	=> 'articleTitle',
		'id'	=> 'articleTitle',	
		'class'	=> 'width_487 required',
		'value'	=> '',
		//'minlength'	=> 2,
		'maxlength'	=> 50
	);
	$articleSubjectInput = array(
		'name'	=> 'articleSubject',
		'id'	=> 'articleSubject',	
		'type'	=> 'hidden',
		'value'	=> $projName,
		//'minlength'	=> 2,
		'maxlength'	=> 50
	);
	
	
	$wordCountInput = array(
		'name'	=> 'wordCount',
		'id'	=> 'wordCount',	
		'class'	=> 'width_53 number valid',   
		'value'	=> '',
		'maxlength'	=> 11
	);
	
	$projectId = array(
		'name'	=> 'projectid',
		'type'	=> 'hidden',
		'id'	=> 'projectid',
		'value'	=> $projectID
	);
	$elementId = array(
		'name'	=> 'elementId',
		'id'	=> 'elementId',
		'type'	=> 'hidden',
		'value'	=> $elementId
	);
	$entityId = array(
		'name'	=> 'entityId',
		'id'	=> 'entityId',
		'type'	=> 'hidden',
		'value'	=> $entityId
	);
	
		
	$articleInput = array(
		'id'	=> 'article',
		'name'	=> 'article',
		'class'	=> 'width556px rz required '.$required,
		'rows' => 17,
		'cols' => 45,
		'value'=>''
	);
	
	$industryId = array(
		'id'	=> 'industryId',
		'name'	=> 'industryId',	
		'type'	=> 'hidden',
		'value'	=> $industryId
	);
	
	
	$editProjectId = array(
		'name'	=> 'editProjectId',
		'type'	=> 'hidden',
		'id'	=> 'editProjectId',
		'value'	=> ''
	);
	
	$editElementId = array(
		'name'	=> 'editElementId',
		'type'	=> 'hidden',
		'id'	=> 'editElementId',
		'value'	=> ''
	);
	
	$isEdit = array(
		'name'	=> 'isEdit',
		'type'	=> 'hidden',
		'id'	=> 'isEdit',
		'value'	=> ''
	);

//$userId=isLoginUser();
//$isProject = isReviewProject($userId);	
$isProject = (isset($isProject))?$isProject:'';
?>


   <div onclick="$(this).parent().trigger('close');" class="popup_close_btn" id="popup_close_btn"></div>
   
   
        <div class="popup_gredient">
			<div id="msg" class="width_516 Fright orange_color font_opensans font_size18 pt10"></div><div class="clear"></div>
				<div id="uploadElementForm"> 
					 <div class="width_770">  
						<div class="popupCat_place mr20 pt5"><?php echo $section ?></div>
						  <div class="row">
							  
								 <div class="cell join_heading ml18 mr17 width_142 text_alignR"><?php echo $this->lang->line('review');?></div>
								 <div class="cell font_opensans font_size18 pt10 bdr_Borange height_16 width_516">
								 <div class="clr_666 pl20"><?php echo $projName ?></div>
								 </div>
								 <div class="clear"></div>
							</div> <!--row -->
								 <div class="seprator_10"></div>
									
						<?php echo form_open_multipart($this->uri->uri_string(),$formAttributes); 	?>									
							<div class="position_relative">
								  <div class="cell shadow_wp strip_absolute left_178">
									 
									  
										<!-- <img src="images/strip_blog.png"  border="0"/>-->
										<table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0">
											<tbody>
											<tr>
											<td height="59"><img src="<?php echo base_url()?>images/shadow-top-review.png"></td>
											</tr>
											<tr>
											<td class="shadow_mid">&nbsp;</td>
											</tr>
											<tr>
											<td height="63"><img src="<?php echo base_url()?>images/shadow-bottom-review.png"></td>
											</tr>
											</tbody>
										</table>
									  <div class="clear"></div>
								  </div>
								  <div class="seprator_10"></div>
								  <div class="row">
										<div class="join_label_wrapper cell">
										<label class="req_field"><?php echo $this->lang->line('title');?></label>
										</div>
										<div class=" cell join_frm_element_wrapper">
										<?php echo form_input($title); ?>
										<div class="row wordcounter"><?php echo form_error($title['name']); ?></div>
										</div>
										<div class="clear"></div>
								  </div> <!--row -->
								  
								<!------  <div class="row">
									  
										<div class="join_label_wrapper cell">
										   <label class="req_field"><?php //echo $this->lang->line('originalLanguage');?></label>
										</div>
										<div class=" cell join_frm_element_wrapper pl25">

											<?php
											
												//$language = getlanguageList();
												  //// echo form_dropdown('languageId', $language, $languageId,'id="languageId" class="main_SELECT selectBox required width266px ml2  NumGrtrZero" title="'.$this->lang->line('thisFieldIsReq').'"');	?>

											</div>
											<div class="clear"></div>
								  </div> 
								  
								  ---->
								 <input type="hidden" name="languageId"  id="languageId" value="0">
								  <div class="row">
										<div class="join_label_wrapper cell">
										<label class="req_field"><?php echo $this->lang->line('review');?></label>
										</div>
										<div class=" cell join_frm_element_wrapper pt2">
										<?php echo form_textarea($articleInput); ?>
										<div class="row wordcounter orange" id="articleMsg"></div>	  
										</div>
										<div class="clear"></div>
								  </div> <!--row -->
								  
								  <div class="seprator_14"> </div>
								  <div class="row">
										<div class="join_label_wrapper cell">
										<label><?php echo $this->lang->line('wordCount');?></label>
										</div>
										<div class=" cell join_frm_element_wrapper">
										<?php echo form_input($wordCountInput);?>
										</div>
										<div class="clear"></div>
								  </div><!--row -->
								  
								  <div class="row">
										<div class="join_label_wrapper cell"> </div>
										<div class=" cell join_frm_element_wrapper">
										<div class="Req_fld font_opensansSBold font_size12 mt7 "><?php echo $this->lang->line('requiredFields');?> </div>
										</div>
								  </div> <!--row -->
								  
								  <div class="row">
												<div class="join_label_wrapper cell"> </div>
												<div class=" cell  join_frm_element_wrapper width_554">
												<div class="popup_msgbox_bottom pb10">
											<div class ="height_50" id="showButtons">
													<div class="cell font_opensansSBold pt15 pl15"><?php echo $this->lang->line('reviewFormCotentFirst_1'); ?><br>
													   <span class="inline"><?php echo $this->lang->line('reviewFormCotentFirst_2'); ?></span> 
													
													</div>												
											</div>
											
									<?php if($isProject==0) { ?>		
											<div class ="height_50" id="showButtonsFirsts">
													<div class="cell font_opensansSBold pt15 pl15"><?php echo $this->lang->line('reviewFormCotentSecond_1_1'); ?>
														<a href="<?php echo base_url('dashboard/writingNpublishing'); ?>" class="orange_color gray_clr_hover underline"><?php echo $this->lang->line('reviewFormCotentSecond_1_2'); ?></a>
														<?php echo $this->lang->line('reviewFormCotentSecond_1_3'); ?><br>
													   <span class="inline"><?php echo $this->lang->line('reviewFormCotentSecond_2'); ?></span> 
													
													</div>												
											</div>
										<? } ?>	
											
											<div class ="dn height_50" id="showButton">
													<div class="cell font_opensansSBold pt15 pl15"><?php echo $this->lang->line('reviewFormCotentThree_1'); ?><br>
													   <span class="inline"><a target='_blank' class="orange_color inline ptr" id="showLink" href="#"><?php echo $this->lang->line('reviewFormCotentThree_2'); ?> </a><?php echo $this->lang->line('reviewFormCotentThree_3'); ?></span> 
													
													</div>												
											</div>
										<?php if($isProject==0) { ?>		
											<div class ="dn height_50" id="showButtonsFirst">
													<div class="cell font_opensansSBold pt15 pl15"><?php echo $this->lang->line('reviewFormCotentFourth_1'); ?><br>
													   <span class="inline"><?php echo $this->lang->line('reviewFormCotentFourth_2'); ?> <a target='_blank' class="orange_color inline ptr" id="showLink" href="<?php echo base_url(lang().'/dashboard/loadPage/welcome_writingpublishing')?>"><?php echo $this->lang->line('reviewFormCotentFourth_3'); ?></a><?php echo $this->lang->line('reviewFormCotentFourth_4'); ?></span> 
													
													</div>												
											</div>
											
										<?php 
										} ?>		
												<div class="row pt30">

												<!--label_wrapper-->

													<div class="price_btn_position pb5">
															<?php
															echo form_input($projectId);
															echo form_input($elementId);
															echo form_input($entityId);
															echo form_input($industryId);
															echo form_input($articleSubjectInput);
															
															echo form_input($isEdit);
															echo form_input($editProjectId);
															echo form_input($editElementId);

															?>	
																					 
															<div class="tds-button Fleft"><button id="AjaxcancelButtonreview" type="button" class="ajaxCancelButton" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)"><span><div class="Fleft width_60"><?php echo $this->lang->line('cancel');?></div> <div></div></span></button></div>
															
															 <div class="tds-button Fleft"><button id="saveButtonreview" type="submit" name="submit" value="Save" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)"><span><div class="Fleft orange_color gray_clr_hover width_60"><?php echo $this->lang->line('save');?></div> <div class=""></div></span></button></div>
															<?php
															//$button=array('ajaxSave', 'ajaxCancel','buttonId'=>'review');
															//echo Modules::run("common/loadButtons",$button); 
															?>


													</div>

												<div class="clear seprator_5"></div>
												</div> <!-- Fright -->
												<div class="clear"></div>
												</div>
												</div>
									  </div> <!--row -->
											   <div class="clear"></div>
							   </div> <!--position_relative -->
						<?php echo form_close(); 	?>
											<div class="seprator_10"></div>
											<div class="seprator_15 clear"></div>
						   </div> <!-- width_770 -->
				  </div> <!-- uploadElementForm -->
		  </div> <!-- popup_gredient -->



	<script>
	selectBox();
	$(document).ready(function(){

			$("#uploadmediaForm").validate({

				messages: {
				wordCount: "Please enter a number."
				},			
				submitHandler: function() {					

					var fromData=$("#uploadmediaForm").serialize();

					$.post(baseUrl+language+'/media/updateReview',fromData, function(data) {
						if(data){
							
							openLightBox('popupBoxWp','popup_box','/media/afterSaveReview',data.projId,data.elemId);							
							
							$('#showButton').removeClass('dn');
							$('#showButtons').addClass('dn');
							
							$('#showButtonsFirst').removeClass('dn');
							$('#showButtonsFirsts').addClass('dn');
							

							$('#showLink').attr('href','<?php echo base_url() ?>media/reviews/editProject/uploadMedia/'+data.projId +'/'+data.elemId);

							
							$('#isEdit').val('1');
							$('#editProjectId').val(data.projId);
							$('#editElementId').val(data.elemId);

							$('#msg').html(data.msg);
							$("#msg").show().delay(5000).fadeOut();
							// $("#uploadElementForm").html('<div class="width_280 minHeight54px">'+ data +'</div>');
						}

					},"json" );				

				}
			});


			//Close form when click on cancel button

				$('#AjaxcancelButtonreview').click(function(){

						$('#popup_box').trigger('close');	
				});

			$('#showLink').click(function(){

			    $('#popup_box').trigger('close');

			});

	});


	</script>
