<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//$this->load->view('common/strip',array('class'=>'cell shadow_wp strip_absolute_right left_193'));
//$this->load->view('common/strip',array('class'=>'cell shadow_wp strip_absolute_right right_166'));
?>
	<td valign="top" class="bg_light_gray pt15">
	<!--left_coloumn-->
		<div class="left_coloumn">
		<?php
			$keyword=$this->input->post('keyWord');
			$postSectionId=($this->input->post('sectionId')>0)?$this->input->post('sectionId'):0;
			
			$formAttributes = array(
			'name'=>'advanceSearchForm',
			'id'=>'advanceSearchForm',
			);
			echo form_open($this->uri->uri_string(),$formAttributes);
			$keyword=(isset($keyword) && $keyword !='' )?$keyword:$this->lang->line('keywordSearch');
		?>
	  <div class="search_left_box ml9 mr10">
		<div class=" ml3 mt6">
		  <div class="search_box_wrapper width_170">
			<input type="text" name="keyWord" value="<?php echo $keyword;?>" class="search_text_box new_keyword_style" placeholder="<?php echo $this->lang->line('keywordSearch');?>" onclick="placeHoderHideShow(this,'<?php echo $this->lang->line('keywordSearch');?>','hide')" onblur="placeHoderHideShow(this,'<?php echo $this->lang->line('keywordSearch');?>','show')">
			<div>
				<input type="submit" name="searchSubmitByImage" value="" class="search_btn_glass">
				<!--<input type="image" src="<?php //echo base_url();?>images/btn_search_box.png" name="searchSubmitByImage" />-->
			</div>
		  </div>
		  <!--search_box_wrapper-->
		</div>
		<div class="clear"></div>
		<div class="SRleft_select_box ml1 mt6" id="sectiondiv">
		 <?php 
			echo form_dropdown('sectionId', $sectionList, $postSectionId,'id="sectionId" onchange="showSectionSerchOption(this.value);"');
		 ?>
		</div>
	  </div>
	  
		<?php 
		if(is_file($searchform)){
			require_once($searchform);
		}?>
		
	  <?php echo form_close(); ?>
</div>
	<!--left_coloumn-->
	</td><td valign="top" class="bg_light_gray ">
	<!--right_column-->
	
	<div id="searchResultDiv" class="cell width_602 mt0 ml11 mr11 mb10 pt0 bdr_non bg_light_gray">
        <?php
			if($searchResult){
				echo $searchResult;
			}
        ?>
	 </div>
	  
	<!-- Div for 468x60 advert display -->
	<div class="row width470px ma mt10 mb20" id="advert468_60"><?php 
		if(is_dir(APPPATH.'modules/advertising') && !empty($advertSectionId)) {
			//Manage left side content bottom advert
			$bannerRhsData =  Modules::run("advertising/getAdvertRecords", array('sectionId'=>$advertSectionId,'advertType'=>'3'));
			if(!empty($bannerRhsData)) {
				$this->load->view('common/advert',array('bannerData'=>$bannerRhsData,'advertType'=>'3','sectionId'=>$advertSectionId));
			} else {
				$this->load->view('common/adv_content_bot'); 
			} 
		} else {
			$this->load->view('common/adv_content_bot');  
		}?>
		<div class="clear"></div>
	</div>  
	 
	<!--right_column-->
	</td>
	<td valign="top" class="advert_column">
		<div class="cell advert_column ">
		  <div class="seprator_5"></div>
			<!-- Div for 160x600 advert display -->
			<div class="ad_box ml11 mt10 mb10" id="advert160_600"><?php 
				if(is_dir(APPPATH.'modules/advertising') && !empty($advertSectionId)){
					//Manage right side advert
					$bannerRhsData =  Modules::run("advertising/getAdvertRecords", array('sectionId'=>$advertSectionId,'advertType'=>'2'));
					if(!empty($bannerRhsData)) {
						$this->load->view('common/advert',array('bannerData'=>$bannerRhsData,'advertType'=>'2','sectionId'=>$advertSectionId)); 
					} else {
						$this->load->view('common/adv_rhs');
					} 
				} else {
					$this->load->view('common/adv_rhs');
				}?>
			</div>
		</div>
	</td>
	<?php 
	if(is_dir(APPPATH.'modules/advertising') && !empty($advertSectionId)){
		//manage auto advert params and js methods
		echo $advertChangeView;
	} ?>
<script>
	showSectionSerchOption(<?php echo $postSectionId;?>);
	function showSectionSerchOption(sectionId){
			$("form input:checkbox").attr("checked", false);
			$("form input:radio").attr("checked", false);
			$(".allSelect").each(function(index){
				$(this).attr("checked", true);
			});
			
			showCurrentHideEach('','#WorkCPG');
			showCurrentHideEach('','#ProductGenreDev');
			showCurrentHideEach('','#PE_CTGdev');
			showCurrentHideEach('','#EmGenreDev');
			showCurrentHideEach('','#townCity');
			showCurrentHideEach('','#defaultProjectPart');
			showCurrentHideEach('','#mediaProjectPart');
			showCurrentHideEach('','#PEProjectPart');
			showCurrentHideEach('','#blogProjectPart');
			showCurrentHideEach('','#creativesProjectPart');
			showCurrentHideEach('','#productProjectPart');
			
			showCurrentHideEach('','.projectTypelist');
			showCurrentHideEach('','#FormToDateList');
			showCurrentHideEach('','#industryIdDIV');
			showCurrentHideEach('','#blogIndustryIdDIV');
			
			showCurrentHideEach('#languageList',''); 
			
			if(sectionId==1 || sectionId==2 || sectionId==3 || sectionId==4 ){
				
				showCurrentHideEach('#mediaProjectPart',''); 
				$('#MPforAll').attr("checked", true); 
				showCurrentHideEach('#projectTypelist'+sectionId, '.projectTypelist');
			}
			if(sectionId==4){
				showCurrentHideEach('','#languageList'); 
			}
			else if(sectionId==6 || sectionId==7 || sectionId==8 ){
				showCurrentHideEach('#townCity',''); 
				showCurrentHideEach('#creativesProjectPart',''); 
				showCurrentHideEach('#industryIdDIV','');
				$('#CPforAll').attr("checked", true);
				$('#industryIdAll').attr("checked", true);
				
			}else if(sectionId==9){
				showCurrentHideEach('#townCity',''); 
				showCurrentHideEach('#FormToDateList','');
				showCurrentHideEach('#PEProjectPart',''); 
				showCurrentHideEach('#industryIdDIV','');
				showCurrentHideEach('#PE_CTGdev','');
				$('#PEforAll').attr("checked", true);
				$('#industryIdAll').attr("checked", true);
				$('#PEgenre').attr("checked", true);
				$('#PEtype').attr("checked", true);
				$('#allPEcat').attr("checked", true);
			}else if(sectionId==10){
				showCurrentHideEach('#mediaProjectPart',''); 
				showCurrentHideEach('#industryIdDIV','');
				$('#MPforAll').attr("checked", true);
				$('#EMgenreAll').attr("checked", true);
				$('#industryIdAll').attr("checked", true);
				showCurrentHideEach('','.projectTypelist'); 
				showCurrentHideEach('#EmGenreDev','');
			}else if(sectionId==11){
				showCurrentHideEach('#townCity',''); 
				showCurrentHideEach('#industryIdDIV','');
				showCurrentHideEach('#WorkCPG','');
				$('#WPforAll').attr("checked", true);
				$('#industryIdAll').attr("checked", true);
			}else if(sectionId==12){
				showCurrentHideEach('#townCity',''); 
				showCurrentHideEach('#productProjectPart',''); 
				showCurrentHideEach('#industryIdDIV','');
				showCurrentHideEach('#ProductGenreDev','');
				$('#PPforAll').attr("checked", true);
				$('#industryIdAll').attr("checked", true);
				$('#AllProductGenre').attr("checked", true);
			}
			else if(sectionId==13){
				showCurrentHideEach('#blogIndustryIdDIV','');
				$('#blogIndustryIdAll').attr("checked", true);
			}
			
		
		runTimeCheckBox();
	}
	
	function serachFormClear(obj, section){
		$("form input:checkbox").attr("checked", false);
		$("form input:radio").attr("checked", false);
		
		$(".allSelect").each(function(index){
			$(this).attr("checked", true);
		});
		$(obj).attr("checked", true);
		runTimeCheckBox();
	}
	$(document).ready(function(){
		
		$('#eventStartDate').attr('placeholder','<?php echo date('F : Y');?>');
		$('#eventEndDate').attr('placeholder','<?php echo date('F : Y');?>');
		
		$('.PEcat').click(function(){
			if($(this).attr('value')=='launch'){
				$('#eventEndDateDiv').attr('class','date_bg');
				$('#eventEndDate').attr('class','date_input_search_box date_input_search_box_disable');
				$('#eventEndDate').attr('disabled',true);
				$('#eventEndDateCal').removeAttr('onclick');
			}else{
				$('#eventEndDateDiv').attr('class','date_bgselected');
				$('#eventEndDate').attr('class','date_input_search_box');
				$('#eventEndDate').attr('disabled',false);
				$('#eventEndDateCal').attr("onclick","$('#eventEndDate').focus();");
			}
		});	
		
		$("#advanceSearchForm").validate({
			 submitHandler: function() {
				$('html').animate({scrollTop:0}, 'slow');
				$('#searchResultDiv').html('<img  class="ma" id="loadImg" align="absmiddle" src="'+baseUrl+'images/loading_wbg.gif" />');
				var fromData=$("#advanceSearchForm").serialize();
				fromData = fromData+'&viewPage=result';
				$.post(baseUrl+language+'/search/searchresult',fromData, function(data) {
				  if(data){
					 $('#searchResultDiv').html(data);
				  }
				});
			 }
		});
		
		$('#eventStartDate').monthpicker({selectedYear: <?php echo date('Y')?>, startYear: 1925, finalYear: <?php echo date('Y')?>, pattern: 'mmm : yyyy'});
		$('#eventEndDate').monthpicker({selectedYear: <?php echo date('Y')?>, startYear: 1925, finalYear: <?php echo date('Y')?>, pattern: 'mmm : yyyy'});
		
		//Manage blog search section
		$('.blogCheck').click(function(){
			$('#blogIndustryIdAll').attr("checked", false);
			runTimeCheckBox();
		});	
		$('.blogAllCheck').click(function(){
			$('.blogCheck').attr("checked", false);
			runTimeCheckBox();
		});	
		
	});
</script>
