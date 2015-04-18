<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<div class="row content_wrap" >
    <div class="m_auto search_result clearb  ">
        <div class="width925 fl pl35 pr40">
            <div class="title_head mb6 pt10 width100_per ">
                <h1 class="mb0  fl">Search Results</h1>
            </div>
        <!--  start left bar -->
            <div class="left_wrap width258 fl">
                <?php $this->load->view('advance/searchform');?>
            </div>
            <!--  End left bar -->
            <div id="searchResultDiv" class="right_wrap fr width572 "> 
                 <?php echo $result;?>
            </div>
            
        </div>
    </div>
</div>
<script>
	$(document).ready(function(){
		$('#eventStartDate').monthpicker({selectedYear: <?php echo date('Y')?>, startYear: 1925, finalYear: <?php echo date('Y')?>});
        $('#eventEndDate').monthpicker({selectedYear: <?php echo date('Y')?>, startYear: 1925, finalYear: <?php echo date('Y')?>, pattern: 'mmm : yyyy'});
		$('.sectionId').click(function(){
			var sectionId = $(this).val();
			var not_in_section = $(this).attr('not_in_section');
			var selectedoption = $(this).attr('selectedoption');
            showSerchOption(sectionId,not_in_section,selectedoption);
		});
        
        $("#advanceSearchForm").validate({
			 submitHandler: function() {
				$('html').animate({scrollTop:0}, 'slow');
				$('#searchResultDiv').html('<img  class="ma" id="loadImg" align="absmiddle" src="'+baseUrl+'images/loading_wbg.gif" />');
				var fromData=$("#advanceSearchForm").serialize();
				$.post(baseUrl+language+'/search/result',fromData, function(data) {
				  if(data){
					 $('#searchResultDiv').html(data);
                     selectBox();
				  }
				});
			 }
		});
    });	
    function showSerchOption(sectionId,not_in_section,selectedoption){
        var sectionIdString = '';
        var sectionString = false;
        if(sectionId != undefined && sectionId != ''){
            if ((sectionId.indexOf('-') != -1)){
                sectionString = '|'+sectionId+'|';
                var sectionIds = sectionId.split('-');
                sectionId = sectionIds[0]; 
            }
            if(not_in_section == undefined || not_in_section == ''){
                 not_in_section = '';
            }
            var sectionIdString = '|'+sectionId+'|';
            
            $(".hs").each(function(index){
                var section  = $(this).attr('section');
                var section_name  = $(this).attr('section_name');
                if ( (section.indexOf(sectionIdString) != -1 ) && (not_in_section.indexOf(section_name) == -1)){
                    $(this).show();
                }else if ( sectionString && (section.indexOf(sectionString) != -1 ) && (not_in_section.indexOf(section_name) == -1)){
                    $(this).show();
                }else{
                    $(this).hide();
                }
            });
            
            if(selectedoption != undefined && selectedoption != ''){
               $('#'+selectedoption).attr('checked',true);
               runTimeCheckBox();
            }
        }
    }
</script>
