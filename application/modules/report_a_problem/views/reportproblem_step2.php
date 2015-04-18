<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<div id="absReportSuccessMsg" class="width780	text_alighL table_cell verti_top wizard_wrap">
    <div    class=" text_alighL table_cell verti_top wizard_wrap">
     <div id="first_option" class="width_635 ml86">
        
        <?php
        $formAttributes = array(
            'name'=>'absReport',
            'id'=>'absReport',
        );
        echo form_open(base_url(lang().'/report_a_problem/reportproblem_step2'),$formAttributes);
        ?>
        
            <h4 class="mt8 fs21 pt10 lineH24 bb_aeaeae pb20">Toadsquare is sorry you find material / content published on the website to be unacceptable based on your own personal opinion, however we will not take down such content / material for reasons of personal taste. </h4>
            <div class="sap_40"></div>
            <p>If you wish, please write a message explaining why you are offended and we will send it to the Toadsquare member who uploaded the media. They may choose to respond.</p>
            <div class="sap_20"></div>
            <div class="position_relative fl">
           
                <input name="keyWord" id="linkToScript" type="text" class="search_text_box font_w width170 minheight18" placeholder="<?php echo $this->lang->line('keywordSearchNew');?>" value="<?php echo $this->lang->line('keywordSearchNew');?>"  onclick="placeHoderHideShow(this,'<?php echo $this->lang->line('keywordSearchNew');?>','hide')" onblur="placeHoderHideShow(this,'<?php echo $this->lang->line('keywordSearchNew');?>','show')" />
                <input name="sectionId" type="hidden" value="">
                
               <input class="searchbtbbg" onclick="lightBoxWithAjax('popupBoxWp','popup_box','/search/searchontoadsquare/',$('#linkToScript').val(),'report_a_problem','abuseReport');" type="button" value="Submit" name="Submit">
           
           
            </div>
            
            <div class="cell pl20 pt6 width400px required">
                <input type="hidden" id="entityId" name="entityId" value="">
                <input type="hidden" id="elementId" name="elementId" value="">
                <input type="hidden" id="projectId" name="projectId" value="">
                <input type="hidden" id="ownerId" name="ownerId" value="">
                <input type="hidden" id="SupportingProjectName" name="SupportingProjectName" value="">
                <input type="hidden" id="abuse_type" name="abuse_type" value="<?php echo $reasonTypeId;?>">
                <div id="projectName"></div>
            </div>
            
            <div class="sap_25"></div>
            <div class="clearbox">
                <span class="fs13 pl10 fshel_midum">1 - 15 words </span> 
                <span class="red fr pr10 fs13 fshel_midum"> 
                    <span id="descLimitProject" > 
                        <?php 
                            $value = '';
                            echo str_word_count($value);
                        ?> 
                    </span> words 
                </span>
                <textarea onkeyup="checkWordLen(this,'250','descLimitProject')" id="reason_description"   wordlength="1,15"  class="font_wN width_615 mt5  red_bdr_2 mt16 height51 required" rows="3" cols="65" name="reason_description" original-title="Tag Words"></textarea>
            </div>
            <div class="sap_30"></div>
            <p class="fs16">OR</p>
            <div class="sap_30"></div>
            <p>If you consider the content to be illegal, please notify Toadsquare by <a  href="javascript:void(0)" onclick="selection_change()">changing your selection.</a></p>
            <div class="sap_50"></div>
            <div class="btn_wrap mt40 clearb fr display_block ">
               <button type="reset" onclick="selection_change();" class="bg_ededed">Cancel</button>
               <button type="submit" name="submit" id="saveAbuseButton" disabled  class="bg_f1592a disable_btn">Submit</button>
            </div>
            
        <?php echo form_close(); ?>
     </div>
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


