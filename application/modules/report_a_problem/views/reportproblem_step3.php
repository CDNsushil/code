<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>

<div class=" text_alighL table_cell verti_top wizard_wrap">
     
    <div id="absReportSuccessMsg" class="width780	  text_alighL table_cell verti_top wizard_wrap"></div>
     
     <div id="second_option" class="width_635 ml86">
        <?php
            $formAttributes = array(
            'name'=>'reportForm',
            'id'=>'reportForm',
            );
            echo form_open(base_url(lang().'/report_a_problem/reportproblem_step3'),$formAttributes);
        ?>
            <h4 class="mt8 fs21 pt10 lineH24 bb_aeaeae pb15">If you consider that any material / content published on Toadsquare website is contrary to the law, we will take down the material and inform the Toadsquare member who put it up. Please realise that such accusations are serious and the other member of Toadsquare may choose to take follow-up action if they wish. </h4>
            <div class="sap_40"></div>
            <p><b>Please indicate which material / content you consider to be illegal / inappropriate.</b></p>
            <div class="sap_15"></div>
            <div class="position_relative fl">
                <input name="keyWord" id="linkToScript" type="text" class="search_text_box font_w width170 minheight18" placeholder="<?php echo $this->lang->line('keywordSearchNew');?>" value="<?php echo $this->lang->line('keywordSearchNew');?>"  onclick="placeHoderHideShow(this,'<?php echo $this->lang->line('keywordSearchNew');?>','hide')" onblur="placeHoderHideShow(this,'<?php echo $this->lang->line('keywordSearchNew');?>','show')" />
                <input name="sectionId" type="hidden" value="">
                <input class="searchbtbbg" type="button"  value="Submit" name="Submit" onclick="lightBoxWithAjax('popupBoxWp','popup_box','/search/searchontoadsquare/',$('#linkToScript').val(),'report_a_problem','abuseReport');">
            </div>
            
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
            
            <div class="sap_45"></div>
            <p><b>Please indicate the reason for the above mentioned material to be considered as
               illegal / inappropriate.</b>
            </p>
            <ul class="defaultP report_list pt20 pb20">
               <li>
                  <input type="radio" checked id="reasonType1" value="1" name="reasonType">
                  Infringement of third party’s legal rights, including intellectual property rights.
               </li>
               <li>
                 <input type="radio"  id="reasonType2" value="2" name="reasonType">
                  Defamatory material.
               </li>
               <li>
                  <input type="radio" id="reasonType3" value="3" name="reasonType" >
                  Material offending public morality (including discriminative, xenophobic or racist photos).
               </li>
               <li>
                  <input type="radio" id="reasonType4" value="4" name="reasonType">
                  Any violent or pornographic material accessible for minors.
               </li>
               <li>
                 <input type="radio" id="reasonType5" value="5" name="reasonType">
                  Privacy concerns.
               </li>
               <li>
                  <input type="radio" id="reasonType6" value="6" name="reasonType">
                  Others.
               </li>
            </ul>
            <p><b>Please provide the precise explanation as to why the published content / material is to be      considered as illegal/inappropriate and should thus be removed:</b></p>
            <div class="sap_20"></div>
            <p><b>Please note that if no (or not sufficient) explanation is provided the notification will not be     considered and in such case Toadsqaure reserves the right not to remove the notified material. </b></p>
            <div class="sap_35"></div>
            <div class="clearbox"> 
                <span class="fs13 pl10 fshel_midum">50 - 500 words </span> 
                <span class="red fr pr10 fs13 fshel_midum"> <span id="descLimitProject">
                    <?php echo str_word_count($value);
                    //echo Report_a_problem::count_words($value);?>
                </span> words </span>
               	<textarea onkeyup="checkWordLen(this,'500','descLimitProject')" id="reason_description" wordlength="50,500"  class="font_wN width_615 mt5  red_bdr_2 mt16 height150 required" rows="9" cols="65" name="reason_description" original-title="Tag Words"></textarea>
	        </div>
            <div class="sap_30"></div>
            <p> We will forward the above information provided by you to the Toadsquare member who uploaded the material.</p>
            <div class="sap_20"></div>
            <p>Please note that Toadsquare reserves the right not to remove the notified material / content if it considered that the abuse report is not sufficiently grounded.</p>
            <div class="sap_20"></div>
            <p>Inappropriate use of this feature exposes you to the deletion of your Toadsquare account.</p>
            <div class="sap_20"></div>
            <p>We will provide the member who uploaded the notified material in question with your name and email address that you have provided to Toadsquare, so that if they choose they may contact you to resolve the issue.</p>
            <div class="sap_20"></div>
            <p><a href="javascript:void(0)" onclick="selection_change()">Change your selection.</a></p>
            <div class="btn_wrap mt30 mb20 clearb fr display_block ">
               <button  type="reset" onclick="selection_change();" class="bg_ededed">Cancel</button>
               <button type="submit" name="submit" class="bg_f1592a disable_btn" id="saveAbuseButton" disabled>Submit</button>
            </div>
        
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
