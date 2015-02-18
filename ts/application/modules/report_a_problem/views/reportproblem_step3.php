<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
		<div id="absReportSuccessMsg" class="f16 ml34 orange_color fm_os tac"></div>
			<div id="second_option">
			<div class="popup_note"> If you consider that any material / content published on Toadsquare website is
			contrary to the law, we will take down the material and inform the Toadsquare
			member who put it up.  Please realise that such accusations are serious and
			the other member of Toadsquare may choose to take follow-up action if they
			wish.
		</div>
		
		<div  class="position_relative">
			<?php
			$formAttributes = array(
				'name'=>'reportForm',
				'id'=>'reportForm',
			);
			echo form_open(base_url(lang().'/report_a_problem/reportproblem_step3'),$formAttributes);
			?>
			 <div class="cell shadow_wp strip_absolute left_260">
					<table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0">
					<tbody>
						<tr>
							<td height="59"><img src="<?php echo base_url();?>images/shadow-top-small.png"></td>
						</tr>
						<tr>
							<td class="shadow_mid_small">&nbsp;</td>
						</tr>
						<tr>
							<td height="63"><img src="<?php echo base_url();?>images/shadow-bottom-small.png"></td>
						</tr>
					</tbody>
					</table>
					<div class="clear"></div>
				</div>
			<div class="seprator_20"></div>
			<div class="row">
				<div class="reportproblem_label_wrapper cell pl15 pr40 width_230">
			
					<div class="reportproblem_req_field"></div>
					<div class="num_01 Fleft"></div>
					<div class="text_with_num"><b class="pl5">&nbsp;</b>Please indicate which material / content you consider to be illegal / inappropriate</div>
				</div>
				<!--label_wrapper-->
				<div class="pop_field_wrapper02 width490px  cell">
					<!--<div class="seprator_5"></div>-->  
					<div class="row">
					<!--search_box_wrapper-->
					<div class="search_box_wrapper ml11 cell">
						
						<input name="keyWord" id="linkToScript" type="text" class="search_text_box" placeholder="<?php echo $this->lang->line('keywordSearch');?>" value="<?php echo $this->lang->line('keywordSearch');?>"  onclick="placeHoderHideShow(this,'<?php echo $this->lang->line('keywordSearch');?>','hide')" onblur="placeHoderHideShow(this,'<?php echo $this->lang->line('keywordSearch');?>','show')" />
						<input name="sectionId" type="hidden" value="">
						<div class="search_btn_glass ptr" onclick="lightBoxWithAjax('popupBoxWp','popup_box','/search/searchontoadsquare/',$('#linkToScript').val(),'report_a_problem','abuseReport');">
							<!--<img src="<?php //echo base_url('images/btn_search_box.png');?>">
							<input type="image" value="searchCrave" name="searchCrave" src="<?php //echo base_url();?>images/btn_search_box.png" >-->
						</div>
						
					</div>
					<!--search_box_wrapper-->
					
					<!--Div contain hidden fields of search-->
					<div class="cell pl16 pt6 width265px">	
						<input type="hidden" id="entityId" name="entityId" value="">
						<input type="hidden" id="elementId" name="elementId" value="">
						<input type="hidden" id="projectId" name="projectId" value="">
						<input type="hidden" id="ownerId" name="ownerId" value="">
						<input type="hidden" id="SupportingProjectName" name="SupportingProjectName" value="">
						<input type="hidden" id="abuse_type" name="abuse_type" value="<?php echo $reasonTypeId;?>">
						<div id="projectName"></div>
					</div>
					<!--Div contain hidden fields of search-->
					</div>
                    <div class="seprator_6"></div>             
				</div>
						
			</div>
			<div class="seprator_34 clear"></div>
			<div class="row">
				<div class="reportproblem_label_wrapper cell pl15 pr40 width_230">
					<div class="reportproblem_req_field"></div>
					<div class="num_02 Fleft"></div>
					<div class="text_with_num"><b class="pl5">&nbsp;</b>Please indicate the reason for the above mentioned material to be considered as illegal / inappropriate</div>
					
				</div>
				
				<!--label_wrapper-->
				<div class="pop_field_wrapper02 width490px cell">
					<div class="mr10 ml10 mt10">
						<div class="defaultP">
							<input type="radio" checked id="reasonType1" value="1" name="reasonType">
						</div>
						<div for="month3" class="pop_radio_label02 width425px">Infringement of third party’s legal rights, including intellectual property rights.</div>
						<div class="clear seprator_13"> </div>
						<div class="defaultP">
							<input type="radio"  id="reasonType2" value="2" name="reasonType">
						</div>
						<div for="month3" class="pop_radio_label02 width425px">Defamatory material.</div>
						<div class="clear seprator_13"> </div>
						<div class="defaultP">
							<input type="radio" id="reasonType3" value="3" name="reasonType" >
						</div>
						<div for="month3" class="pop_radio_label02 width425px">Material offending public morality (including discriminative, xenophobic or racist photos).</div>
						<div class="clear seprator_13"> </div>
						<div class="defaultP">
							<input type="radio" id="reasonType4" value="4" name="reasonType">
						</div>
						<div for="month3" class="pop_radio_label02 width425px">Any violent or pornographic material accessible for minors.</div>
						<div class="clear seprator_13"> </div>
						<div class="defaultP">
							<input type="radio" id="reasonType5" value="5" name="reasonType">
						</div>
						<div for="month3" class="pop_radio_label02 width425px">Privacy concerns.</div>
						<div class="clear seprator_13"> </div>
						<div class="defaultP">
							<input type="radio" id="reasonType6" value="6" name="reasonType">
						</div>
						<div for="month3" class="pop_radio_label02 width425px">Others.</div>
						<div class="clear seprator_13"> </div>
					</div>
				</div>
			</div>
			<div class="clear seprator_30"></div>
			<div class="row">
				<div class="reportproblem_label_wrapper cell pl15 pr40 width_230">
					<div class="reportproblem_req_field"></div>
					<div class="num_03 Fleft"></div>
					<div class="text_with_num">
						<b class="pl5">&nbsp;</b>Please provide the precise explanation as to why the published content / material is to be considered as illegal/inappropriate and should thus be removed:<br><br>

						Please note that if no (or not sufficient) explanation is provided the notification will not be considered and in such case Toadsqaure reserves the right not to remove the notified material
					</div>
				</div>
				<!--label_wrapper-->
				<div class="pop_field_wrapper02 width_409px cell defaultP">
                
				<div class="ml11">
					<?php $value = '';?>
					<textarea onkeyup="checkWordLen(this,'500','descLimitProject')" id="reason_description" wordlength="50,500"  class="textarea_small width460px required" rows="9" cols="65" name="reason_description" original-title="Tag Words"></textarea>
					
					<div id="word_counter" class="row wordcounter">
						<div class="tag_word_orange"> 50 - 500 words 
							<div class="row five_words ml322">
								<div class="cell" id="descLimitProject">
									<?php echo str_word_count($value);
									//echo Report_a_problem::count_words($value);?>
								</div>
								<div class="cell"> words</div>
							</div>
						</div>
						<!--<span class="tag_word_orange"> 50 - 500 words </span>
						<span class="five_words">
						<span id="descLimitProject"></span>
						<span> words</span>
						</span>-->
					</div>
						
				</div>
				<!--<div class="clear seprator_5"></div>
				<div class="pop_field_text mr14 pl12">&gt; 50 words</div>-->
				<div class="seprator_30"></div>
				<div class="pop_field_text mr14 pl12 width460px">
					We will forward the above information provided by you to the
					Toadsquare member who uploaded the material.<br><br>Please note that Toadsquare reserves the right not to remove the notified material / content if it considered that the abuse report is not sufficiently grounded.  <br><br>
					Inappropriate use of this feature exposes you to the deletion of your Toadsquare account.<br><br>
					We will provide the member who uploaded the notified material in question with your name and email address that you have provided to Toadsquare, so that if they choose they may contact you to resolve the issue. 
				</div>
			</div>
		</div>
		<div class="seprator_15 clear"></div>
		<div class="row">
			<div class="cell width_361">
				</div>
				<div class="cell width400px">
					<div class="Fright change_selection lH0">
						<a class="orange_color b gray_clr_hover" href="javascript:void(0)" onclick="selection_change()">Change Selection</a> 
					</div>
				</div>		
			</div>
			<div class="seprator_30 clear"></div>
		<div class="row">
			<div class="cell width400px">
					<div class="Fright mr-6 lh22">
						<div class="reportproblem_req_field reportproblem_arrow_field right_465"></div>Required Fields
					</div>
				</div>	
			
		
		<div class="cell Fright mr_21">
			<div class="tds-button Fright mr18">
				 <button type="submit" name="submit" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)" id="saveAbuseButton" disabled class="disable_btn dash_link_hover"><span><div class="Fleft">Save</div> <div class="icon-save-btn"></div> </span> </button> 
				<!--<button onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" value="Save" name="submit" type="submit" id="saveAbuseButton" class="disable_btn" disabled><span><div class="Fleft">Submit</div> </span></button>-->
			</div>
			<div class="tds-button Fright mr8"> 
				<button type="reset" onclick="selection_change();" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)" class="dash_link_hover"><span><div class="Fleft">Cancel</div> <div class="icon-cancel-btn-new"></div></span> </button> 
				<!--<a href="javascript:void(0)" onclick="selection_change()" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)"><span>Cancel</span></a>-->
			</div>
		</div>
    </div>
    <div class="seprator_34 clear"></div>
    <?php echo form_close();?>
    </div>  
	</div>

<script type="text/javascript">
runTimeCheckBox();

/*Function to insert law report in db */
$(document).ready(function(){
	$("#reportForm").validate({
		submitHandler: function() {
			var fromData=$("#reportForm").serialize();
			$('#absReportSuccessMsg').html('<img  class="ma" id="loadImg" align="absmiddle" src="'+baseUrl+'images/loading_wbg.gif" />');
			
			$.post(baseUrl+language+'/report_a_problem/save_abuse_report',fromData, function(data) {
			  if(data){
				$('#second_option').hide();
				$('#absReportSuccessMsg').html(data);
			  }
			});
		}
	});
});

/*
function save_abuse_lawReport() {
	
	var BASEPATH = "<?php echo base_url().lang();?>";
	var entityId=$('#entityId').val();
	var elementId=$('#elementId').val();
	var projectId=$('#projectId').val();
	var ownerId=$('#ownerId').val();
	if(projectId == '') {
		alert("Please Choose Inappropriate Content/Project");
		return false;
	}
	if($('#reasonType1').attr('checked')) {
		var reason_val=$('#reasonType1').val();
	}
	else if($('#reasonType2').attr('checked')) {
		var reason_val=$('#reasonType2').val();
	}
	else if($('#reasonType3').attr('checked')) {
		var reason_val=$('#reasonType3').val();
	}
	else if($('#reasonType4').attr('checked')) {
		var reason_val=$('#reasonType4').val();
	}
	else if($('#reasonType5').attr('checked')) {
		var reason_val=$('#reasonType5').val();
	}
	else if($('#reasonType6').attr('checked')) {
		var reason_val=$('#reasonType6').val();
	}
	else {
		alert("Please Choose Reason Type");
		return false;
	}
	
	var reason_description_val=$('#reason_description').val();
	if(reason_description_val == '') {
		alert("Please Fill Explination Of Abuse Report");
		return false;
	}
	
	
	
	var form_data = {abuse_type: 3,
					reason_val: reason_val,
					entityId: entityId,
					elementId: elementId,
					projectId: projectId,
					ownerId: ownerId,
					reason_description_val : reason_description_val};
	$.ajax
	({
		type: "POST",
		url: BASEPATH+"/report_a_problem/save_abuse_report",
		data: form_data,
		success: function(msg)
		{		
			$('#next_steps').hide();
			$('#default_option').show();
			$('#insert_msg').show();
			$('#insert_msg').html(msg);			
		}
	});
}
*/
</script>
