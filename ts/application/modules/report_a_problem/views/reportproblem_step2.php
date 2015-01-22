<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<div id="absReportSuccessMsg" class="f16 ml34 orange_color fm_os tac"></div>
	<div id="first_option">
		<div class="popup_note"> Toadsquare is sorry you find material / content published on the website to
		be unacceptable based on your own personal opinion, however we will not
		take down such content / material for reasons of personal taste. </div>
		<div class="pop_bdr"></div>
		<div class="position_relative">
			<?php
			$formAttributes = array(
				'name'=>'absReport',
				'id'=>'absReport',
			);
			echo form_open(base_url(lang().'/report_a_problem/reportproblem_step2'),$formAttributes);
			?>
			<div class="cell shadow_wp strip_absolute left_140">
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
			<div class="seprator_10"></div>
			<div class="row">
				<div class="pop_label_wrapper cell">
					<div class="num_01 Fright width30px"></div>
				</div>
				<!--label_wrapper-->
			
				<div class="cell ml_172 mt_40">If you wish, please write a message explaining why you are offended and we will send it to the Toadsquare member who uploaded the media.  They may choose to respond.</div>
			</div>
			<div class="seprator_20 clear"></div>
			<div class="row">
				<div class="reportproblem_req_field reportproblem_arrow_field cell"></div>
				<div class="row">
				<!--search_box_wrapper-->
				<div class="search_box_wrapper ml_172 cell ">
		
					<input name="keyWord" id="linkToScript" type="text" class="search_text_box" placeholder="<?php echo $this->lang->line('keywordSearch');?>" value="<?php echo $this->lang->line('keywordSearch');?>"  onclick="placeHoderHideShow(this,'<?php echo $this->lang->line('keywordSearch');?>','hide')" onblur="placeHoderHideShow(this,'<?php echo $this->lang->line('keywordSearch');?>','show')" />
					<input name="sectionId" type="hidden" value="">
					<div class="search_btn_glass ptr" onclick="lightBoxWithAjax('popupBoxWp','popup_box','/search/searchontoadsquare/',$('#linkToScript').val(),'report_a_problem','abuseReport');">
	
						<!--<img src="<?php //echo base_url('images/btn_search_box.png');?>">
						<input type="image" value="searchCrave" name="searchCrave" src="<?php //echo base_url();?>images/btn_search_box.png" >-->
					</div>
					
				</div>
				<!--search_box_wrapper-->		
			
			<!--Div contain hidden fields of search-->
			<div class="cell pl20 pt6 width400px required">
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
			
			</div>
			<div class="seprator_20 clear"></div>
			<div class="row">
				<div class="reportproblem_req_field reportproblem_arrow_field cell"></div>
				<div class="ml_172 cell">
					<?php $value = '';?>
					<textarea onkeyup="checkWordLen(this,'250','descLimitProject')" id="reason_description"   wordlength="25,250"  class="textarea_small required" rows="3" cols="65" name="reason_description" original-title="Tag Words"></textarea>
					<div id="word_counter" class="row wordcounter">
						<div class="tag_word_orange"> 25 - 250 words 
							<div class="row five_words ml330">
								<div class="cell" id="descLimitProject">
									<?php echo str_word_count($value);
									//echo Report_a_problem::count_words($value);?>
								</div>
								<div class="cell"> words</div>
							</div>
						</div>
						<!--<span class="five_words width120px">
						<span id="descLimitProject"></span>
						<span> words</span>
						</span>-->
					</div>
				</div>
			</div>
			
			<div class="seprator_20 clear"></div>
			<div class="row">
				<div class="pop_label_wrapper cell">
					<div class="num_02 Fright width30px"></div>
				</div>
				<!--label_wrapper-->
				<div class="cell ml_172 mt_40">Or, if you consider the content to be illegal, please notify Toadsquare by changing your selection.</div>
			</div>
			<div class="seprator_5 clear"></div>
			<div class="row">
				<div class="cell width_273">
			</div>
			<div class="cell width_273">
				<div class="Fright change_selection lH0">
					<a class="orange_color b gray_clr_hover" href="javascript:void(0)" onclick="selection_change()">Change Selection</a> 
				</div>
			</div>		
		</div>
		<div class="seprator_40 clear"></div>
		<div class="row">
			<div class="cell width_273">
				<div class="Fright mr-6 lh21">
					<div class="reportproblem_req_field reportproblem_arrow_field right_589"></div>Required Fields
				</div>
			</div>	
			<div class="cell Fright">
				<div class="tds-button Fright mr18"> 
					 <button type="submit" name="submit" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)" id="saveAbuseButton" disabled class="disable_btn dash_link_hover"><span><div class="Fleft">Save</div> <div class="icon-save-btn"></div> </span> </button> 
					<!--<button onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" value="Save" name="submit" type="submit" id="saveAbuseButton" disabled class="disable_btn"><span><div class="Fleft">Submit</div> </span></button>-->
				</div>
				<div class="tds-button Fright mr8"> 
					<button type="reset" onclick="selection_change();" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)" class="dash_link_hover"><span><div class="Fleft">Cancel</div> <div class="icon-cancel-btn-new"></div></span> </button> 
					<!--<a href="javascript:void(0)" onclick="selection_change()" onmouseup=	"mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)"><span>Cancel</span></a>-->
				</div>
				<div class="clear"></div>
			</div>
			<div class="clear"></div>
		</div>
		<div class="seprator_34 clear"></div>
		<?php echo form_close(); ?>
	</div> 
	</div>

<script type="text/javascript">
/*Function to insert personal report in db */	

$(document).ready(function(){
	$("#absReport").validate({
		 submitHandler: function() {
			var fromData=$("#absReport").serialize(); 	
			
			$('#absReportSuccessMsg').html('<img  class="ma" id="loadImg" align="absmiddle" src="'+baseUrl+'images/loading_wbg.gif" />');
			$.post(baseUrl+language+'/report_a_problem/save_abuse_report',fromData, function(data) {
			  if(data){
				  //alert(data);
				$('#first_option').hide();
				$('#absReportSuccessMsg').html(data);
			  }
			});
		 }
	});
});



/*function save_abuse_personelReport()
{
	var BASEPATH = "<?php echo base_url().lang();?>";
	var entityId=$('#entityId').val();
	var elementId=$('#elementId').val();
	var projectId=$('#projectId').val();
	var ownerId=$('#ownerId').val();
	var reason_description_val=$('#reason_description').val();
	if(projectId == '') {
		alert("Please Choose Inappropriate Content/Project");
		return false;
	}
	
	if(reason_description_val == '') {
		alert("Please Fill Explination Of Abuse Report");
		return false;
	}
	
	var form_data = {abuse_type: 6,
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
}*/
</script>	


