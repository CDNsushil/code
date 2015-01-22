<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$postSectionId=$this->input->post('sectionId');
$industryId=$this->input->post('industryId');
$languageId=$this->input->post('languageId');
$producedInCountry=$this->input->post('producedInCountry');
$projectPart=$this->input->post('projectPart');
$postCatId=$this->input->post('catId');

?>
<style>

#sectiondiv span.selectBox-label {color:#E76D34;}

</style>

<!--left_coloumn-->
<div class="left_coloumn">
		<?php
			$formAttributes = array(
			'name'=>'advanceSearchForm',
			'id'=>'advanceSearchForm',
			);
			echo form_open($this->uri->uri_string(),$formAttributes);
			
		?>
	  
	  <div class="search_left_box ml9 mr10">
		<div class=" ml3 mt6">
		  <div class="search_box_wrapper width_170">
			<input type="text" name="keyWord" value="" class="search_text_box new_keyword_style" placeholder="<?php echo $this->lang->line('keyword');?>">
			<div class="search_btn"> <img src="<?php echo base_url();?>images/btn_search_box.png"> </div>
		  </div>
		  <!--search_box_wrapper-->
		</div>
		<div class="clear"></div>
		<div class="SRleft_select_box ml1 mt6" id="sectiondiv">
		 <?php 
			
			echo form_dropdown('sectionId', $sectionList, $postSectionId,'id="sectionId" onchange="showSectionSerchOption(this);"');
		 ?>
		</div>
	  </div>
	  <!--left_gray_gradient_box-->
	  <div class="search_left_box mt6 ml9 mb6 mr10">
		<div class="SRleft_select_box ml1 mt6" id="languageList">
			<?php
				
				echo form_dropdown('languageId', $languageList, $languageId,'id="languageId"');
			?>
			
		</div>
		<div class="clear"></div>
		
		<div class="SRleft_select_box ml1 mt0">
		  <?php
				echo form_dropdown('producedInCountry', $countryList, $producedInCountry,'id="producedInCountry" ');
			?>
		</div>
		 <div id="townCity">
		 <div class="search_page_input ml3 dn"><input name="city" type="text" placeholder="<?php echo $this->lang->line('city');?>" value="" /></div>
			<div class="row seprator_3"></div>
		</div>
		<div class="clear"></div>
	  </div>
	  
	  <?php
		if($postSectionId==9){
			$displayFormToDate='';
		}else{
			$displayFormToDate='dn';
		}
		
	  ?>
	  <div class="search_left_box mb6 ml9 mr10 <?php echo $displayFormToDate;?> FormToDateList" id="FormToDateList">
		   <div class="calendar_box">
			   <span class="pl15">From</span>
			   <div class="date_bgselected">
				<span class="Fleft">January :  2012</span><a class="cal_icon"></a>
			   </div>
			   <span class="pl15">To</span>
			   <div class="date_bg">
					<span class="Fleft">January :  2012</span><a class="cal_icon"></a>
			   </div>
		   </div>
	   </div>
	   
	  <?php /*?> 
	  <div class="search_left_box mt6 mb6 ml9 mr10 ProjectPart" id="defaultProjectPart"> 
		 
		<div class="defaultP mt10 ml8 float_none">
		  <input type="radio" name="projectPart" value="all" id="DPforAll" class="cell" <?php echo (($projectPart=='all') || !isset($projectPart))?'checked':''?> onchange="serachFormClear('project');"   />
		  <label for="month3" class="ml10 cell"><?php echo $this->lang->line('all');?></label>
		  <br />
		</div>
		
		<div class="defaultP mt10 ml8 float_none">
		  <input type="radio" name="projectPart" value="free"  class="cell" <?php echo (($projectPart=='free'))?'checked':''?> onchange="serachFormClear('project');"  />
		  <label for="month3" class="ml10 cell"><?php echo $this->lang->line('free');?></label>
		  <br />
		</div>
		
		<div class="defaultP mt10 ml8 float_none">
		  <input type="radio" name="projectPart" value="news"  class="cell" <?php echo (($projectPart=='news'))?'checked':''?> onchange="serachFormClear('project');"  />
		  <label for="month3" class="ml10 cell"><?php echo $this->lang->line('news');?></label>
		  <br />
		</div>
		<div class="defaultP mt10 ml8 float_none">
		  <input type="radio" name="projectPart" value="reviews"  class="cell" <?php echo (($projectPart=='reviews'))?'checked':''?> onchange="serachFormClear('project');" />
		  <label for="month3" class="ml10 cell"><?php echo $this->lang->line('reviews');?></label>
		  <br />
		</div>
		<div class="defaultP mt10 ml8 float_none">
		  <input type="radio" name="projectPart" value="top100craved"  class="cell" <?php echo (($projectPart=='top100craved'))?'checked':''?> onchange="serachFormClear('project');" />
		  <label for="month3" class="ml10 cell"><?php echo $this->lang->line('top100craved');?></label>
		  <br />
		</div>
		
		<div class="row seprator_10"></div>
		<div class="clear"></div>
	  </div>
	   
	  <?php */ ?>
	  
	  <div class="search_left_box  mb6 ml9 mr10 dn ProjectPart" id="mediaProjectPart">
		<div class="defaultP mt10 ml8 float_none">
		  <input type="radio" name="projectPart" value="all" id="MPforAll"  class="cell" <?php echo (($projectPart=='all') || !isset($projectPart))?'checked':''?> onchange="serachFormClear('project');"  onclick="if($('#sectionId').val() !='' || $('#sectionId').val() !=10 ){showCurrentHideEach('#projectTypelist'+$('#sectionId').val(), '.projectTypelist')} if($('#sectionId').val() == 10){ showCurrentHideEach('', '.projectTypelist'); showCurrentHideEach('#industryIdDIV',''); showCurrentHideEach('#EmGenreDev', '');}  " />
		  <label for="month3" class="ml10 cell"><?php echo $this->lang->line('all');?></label>
		  <br />
		</div>
		
		<div class="defaultP mt10 ml8 float_none">
		  <input type="radio" name="projectPart" value="free" class="cell" <?php echo (($projectPart=='free'))?'checked':''?> onchange="serachFormClear('project');" onclick="if($('#sectionId').val() !='' || $('#sectionId').val() !=10 ){showCurrentHideEach('#projectTypelist'+$('#sectionId').val(), '.projectTypelist')} if($('#sectionId').val() == 10){ showCurrentHideEach('', '.projectTypelist'); showCurrentHideEach('#industryIdDIV',''); showCurrentHideEach('#EmGenreDev', '');}  " />
		  <label for="month3" class="ml10 cell"><?php echo $this->lang->line('free').' '.$this->lang->line('projects');?></label>
		  <br />
		</div>
		
		<div class="defaultP mt10 ml8 float_none">
		  <input class="cell" type="radio" name="projectPart" value="projects" <?php echo ($projectPart=='projects')?'checked':''?> onchange="serachFormClear('project');"  onclick="if($('#sectionId').val() !='' || $('#sectionId').val() !=10 ){showCurrentHideEach('#projectTypelist'+$('#sectionId').val(), '.projectTypelist')} if($('#sectionId').val() == 10){ showCurrentHideEach('', '.projectTypelist'); showCurrentHideEach('#industryIdDIV',''); showCurrentHideEach('#EmGenreDev', '');}  " />
		  <label for="month3" class="ml10 cell"><?php echo $this->lang->line('projects');?></label>
		  <br />
		</div>
		
		
		<div class="defaultP mt10 ml8 float_none">
		  <input type="radio" name="projectPart" value="news" class="cell" <?php echo (($projectPart=='news'))?'checked':''?> onchange="serachFormClear('project');"  onclick="showCurrentHideEach('', '.projectTypelist'); showCurrentHideEach('', '#industryIdDIV'); showCurrentHideEach('', '#EmGenreDev');" />
		  <label for="month3" class="ml10 cell"><?php echo $this->lang->line('news');?></label>
		  <br />
		</div>
		<div class="defaultP mt10 ml8 float_none">
		  <input type="radio" name="projectPart" value="reviews" class="cell" <?php echo (($projectPart=='reviews'))?'checked':''?> onchange="serachFormClear('project');"  onclick="showCurrentHideEach('', '.projectTypelist'); showCurrentHideEach('', '#industryIdDIV'); showCurrentHideEach('', '#EmGenreDev');" />
		  <label for="month3" class="ml10 cell"><?php echo $this->lang->line('reviews');?></label>
		  <br />
		</div>
		<div class="defaultP mt10 ml8 float_none">
		  <input type="radio" name="projectPart" value="top100craved"  class="cell" <?php echo (($projectPart=='top100craved'))?'checked':''?> onchange="serachFormClear('project');"  onclick="if($('#sectionId').val() !='' || $('#sectionId').val() !=10 ){showCurrentHideEach('#projectTypelist'+$('#sectionId').val(), '.projectTypelist')} if($('#sectionId').val() == 10){ showCurrentHideEach('', '.projectTypelist'); showCurrentHideEach('#industryIdDIV',''); showCurrentHideEach('#EmGenreDev', '');}  " />
		  <label for="month3" class="ml10 cell"><?php echo $this->lang->line('top100craved');?></label>
		  <br />
		</div>
		<div class="defaultP mt10 ml8 float_none">
		  <input class="cell" type="radio" name="projectPart" value="upcomingprojects" id="projectPartUpcomingProjects" <?php echo ($projectPart=='upcomingprojects')?'checked':''?> onchange="serachFormClear('project');"  onclick="showCurrentHideEach('', '.projectTypelist'); showCurrentHideEach('', '#industryIdDIV'); showCurrentHideEach('', '#EmGenreDev');"  />
		  <label for="month3" class="ml10 cell"><?php echo $this->lang->line('upcomingProjects');?></label>
		  <br />
		</div> 
		
		<div class="row seprator_10"></div>
		<div class="clear"></div>
	  </div>
	   
	  <div class="search_left_box  mb6 ml9 mr10 dn ProjectPart" id="PEProjectPart">
		<div class="defaultP mt10 ml8 float_none">
		  <input type="radio" name="projectPart" value="all" id="PEforAll"  class="cell" <?php echo (($projectPart=='all') || !isset($projectPart))?'checked':''?> onchange="serachFormClear('project');"  onclick="showCurrentHideEach('#industryIdDIV',''); showCurrentHideEach('#PE_CTGdev', '');" />
		  <label for="month3" class="ml10 cell"><?php echo $this->lang->line('all');?></label>
		  <br />
		</div>
		
		<div class="defaultP mt10 ml8 float_none">
		  <input type="radio" name="projectPart" value="free" class="cell" <?php echo (($projectPart=='free'))?'checked':''?> onchange="serachFormClear('project');"  onclick="showCurrentHideEach('#industryIdDIV',''); showCurrentHideEach('#PE_CTGdev', '');" />
		  <label for="month3" class="ml10 cell"><?php echo $this->lang->line('free');?></label>
		  <br />
		</div>
		
		<div class="defaultP mt10 ml8 float_none">
		  <input type="radio" name="projectPart" value="news" class="cell" <?php echo (($projectPart=='news'))?'checked':''?> onchange="serachFormClear('project');"  onclick="showCurrentHideEach('','#industryIdDIV'); showCurrentHideEach('', '#PE_CTGdev');" />
		  <label for="month3" class="ml10 cell"><?php echo $this->lang->line('news');?></label>
		  <br />
		</div>
		<div class="defaultP mt10 ml8 float_none">
		  <input type="radio" name="projectPart" value="reviews" class="cell" <?php echo (($projectPart=='reviews'))?'checked':''?> onchange="serachFormClear('project');"  onclick="showCurrentHideEach('','#industryIdDIV'); showCurrentHideEach('', '#PE_CTGdev');" />
		  <label for="month3" class="ml10 cell"><?php echo $this->lang->line('reviews');?></label>
		  <br />
		</div>
		<div class="defaultP mt10 ml8 float_none">
		  <input type="radio" name="projectPart" value="top100craved"  class="cell" <?php echo (($projectPart=='top100craved'))?'checked':''?> onchange="serachFormClear('project');"  onclick="showCurrentHideEach('#industryIdDIV',''); showCurrentHideEach('#PE_CTGdev', '');" />
		  <label for="month3" class="ml10 cell"><?php echo $this->lang->line('top100craved');?></label>
		  <br />
		</div>
		
		<div class="defaultP mt10 ml8 float_none">
		  <input class="cell" type="radio" name="projectPart" value="upcomingprojects" id="projectPartUpcomingProjects" <?php echo ($projectPart=='upcomingprojects')?'checked':''?> onchange="serachFormClear('project');"  onclick="showCurrentHideEach('','#industryIdDIV'); showCurrentHideEach('', '#PE_CTGdev');"  />
		  <label for="month3" class="ml10 cell"><?php echo $this->lang->line('upcomingProjects');?></label>
		  <br />
		</div> 
		
		<div class="row seprator_10"></div>
		<div class="clear"></div>
	  </div>
	  
	  <div class="search_left_box  mb6 ml9 mr10 dn ProjectPart" id="blogProjectPart">
		<div class="defaultP mt10 ml8 float_none">
		  <input type="radio" name="projectPart" value="all" id="BPforAll"  class="cell" <?php echo (($projectPart=='all') || !isset($projectPart))?'checked':''?> onchange="serachFormClear('project');"  />
		  <label for="month3" class="ml10 cell"><?php echo $this->lang->line('all');?></label>
		  <br />
		</div>
		
		<div class="defaultP mt10 ml8 float_none">
		  <input type="radio" name="projectPart" value="top100craved"  class="cell" <?php echo (($projectPart=='top100craved'))?'checked':''?> onchange="serachFormClear('project');"   />
		  <label for="month3" class="ml10 cell"><?php echo $this->lang->line('top100craved');?></label>
		  <br />
		</div>
		
		<div class="row seprator_10"></div>
		<div class="clear"></div>
	  </div>
	   
	  <div class="search_left_box  mb6 ml9 mr10 dn ProjectPart" id="creativesProjectPart">
		<div class="defaultP mt10 ml8 float_none">
		  <input type="radio" name="projectPart" value="all" id="CPforAll"  class="cell" <?php echo (($projectPart=='all') || !isset($projectPart))?'checked':''?> onchange="serachFormClear('project');" onclick="showCurrentHideEach('#industryIdDIV','');"   />
		  <label for="month3" class="ml10 cell"><?php echo $this->lang->line('all');?></label>
		  <br />
		</div>
		
		
		<div class="defaultP mt10 ml8 float_none">
		  <input type="radio" name="projectPart" value="news" class="cell" <?php echo (($projectPart=='news'))?'checked':''?> onchange="serachFormClear('project');"  onclick="showCurrentHideEach('','#industryIdDIV');" />
		  <label for="month3" class="ml10 cell"><?php echo $this->lang->line('news');?></label>
		  <br />
		</div>
		<div class="defaultP mt10 ml8 float_none">
		  <input type="radio" name="projectPart" value="reviews" class="cell" <?php echo (($projectPart=='reviews'))?'checked':''?> onchange="serachFormClear('project');"  onclick="showCurrentHideEach('','#industryIdDIV');" />
		  <label for="month3" class="ml10 cell"><?php echo $this->lang->line('reviews');?></label>
		  <br />
		</div>
		<div class="defaultP mt10 ml8 float_none">
		  <input type="radio" name="projectPart" value="top100craved"  class="cell" <?php echo (($projectPart=='top100craved'))?'checked':''?> onchange="serachFormClear('project');"  onclick="showCurrentHideEach('#industryIdDIV','');" />
		  <label for="month3" class="ml10 cell"><?php echo $this->lang->line('top100craved');?></label>
		  <br />
		</div>
		
		<div class="row seprator_10"></div>
		<div class="clear"></div>
	  </div>
	   
	  <div class="search_left_box  mb6 ml9 mr10 dn ProjectPart" id="productProjectPart">
		 
		<div class="defaultP mt10 ml8 float_none">
		  <input type="radio" name="projectPart" value="all" id="PPforAll" class="cell" <?php echo (($projectPart=='all') || !isset($projectPart))?'checked':''?> onchange="serachFormClear('project');"  onclick="showCurrentHideEach('#industryIdDIV',''); showCurrentHideEach('#ProductGenreDev', '');" />
		  <label for="month3" class="ml10 cell"><?php echo $this->lang->line('all');?></label>
		  <br />
		</div>
		
		<div class="defaultP mt10 ml8 float_none">
		  <input type="radio" name="projectPart" value="news"  class="cell" <?php echo (($projectPart=='news'))?'checked':''?> onchange="serachFormClear('project');"  onclick="showCurrentHideEach('','#industryIdDIV'); showCurrentHideEach('', '#ProductGenreDev');" />
		  <label for="month3" class="ml10 cell"><?php echo $this->lang->line('news');?></label>
		  <br />
		</div>
		<div class="defaultP mt10 ml8 float_none">
		  <input type="radio" name="projectPart" value="reviews"  class="cell" <?php echo (($projectPart=='reviews'))?'checked':''?> onchange="serachFormClear('project');"  onclick="showCurrentHideEach('','#industryIdDIV'); showCurrentHideEach('', '#ProductGenreDev');" />
		  <label for="month3" class="ml10 cell"><?php echo $this->lang->line('reviews');?></label>
		  <br />
		</div>
		<div class="defaultP mt10 ml8 float_none">
		  <input type="radio" name="projectPart" value="top100craved"  class="cell" <?php echo (($projectPart=='top100craved'))?'checked':''?> onchange="serachFormClear('project');"  onclick="showCurrentHideEach('#industryIdDIV',''); showCurrentHideEach('#ProductGenreDev', '');" />
		  <label for="month3" class="ml10 cell"><?php echo $this->lang->line('top100craved');?></label>
		  <br />
		</div>
		
		<div class="row seprator_10"></div>
		<div class="clear"></div>
	  </div>
	 <?php /*  
	  <div class="search_left_box mt6 mb6 ml9 mr10 dn ProjectPart" id="workProjectPart">
		 
		<div class="defaultP mt10 ml8 float_none">
		  <input type="radio" name="projectPart" value="all" id="WPforAll" class="cell" <?php echo (($projectPart=='all') || !isset($projectPart))?'checked':''?>  />
		  <label for="month3" class="ml10 cell"><?php echo $this->lang->line('all');?></label>
		  <br />
		</div>
		
		<div class="defaultP mt10 ml8 float_none">
		  <input type="radio" name="projectPart" value="free" class="cell" <?php echo (($projectPart=='free'))?'checked':''?>  />
		  <label for="month3" class="ml10 cell"><?php echo $this->lang->line('free');?></label>
		  <br />
		</div>
		
		<div class="defaultP mt10 ml8 float_none">
		  <input type="radio" name="projectPart" value="top100craved"  class="cell" <?php echo (($projectPart=='top100craved'))?'checked':''?>  />
		  <label for="month3" class="ml10 cell"><?php echo $this->lang->line('top100craved');?></label>
		  <br />
		</div>
		
		<div class="row seprator_10"></div>
		<div class="clear"></div>
	  </div>
	   
	 <?php */ ?>
	  
	  <!--industry box -->
      <?php
		if($postSectionId==10){
			$displayIndustryList='';
		}else{
			$displayIndustryList='dn';
		}
		
	  ?>
	  <div class="search_left_box mb6 ml9 mr10 <?php echo $displayIndustryList;?>" id="industryIdDIV">
		<div class="defaultP mt10 ml8 float_none">
		  <input type="radio" name="industryId" value="all" id="industryIdAll"  class="cell forAll" <?php echo (($industryId=='all') || !isset($industryId))?'checked':''?> onchange="serachFormClear('project');"   />
		  <label for="month3" class="ml10 cell"><?php echo $this->lang->line('all');?></label>
		  <br />
		</div>
		
		<?php
		if($industryList && is_array($industryList) && count($industryList) > 0 ){
			foreach($industryList as $industryKey=>$industry){
				if($industryKey > 0){?>
					<div class="defaultP mt10 ml8 float_none">
					  <input type="radio" name="industryId" value="<?php echo $industryKey;?>" id="industryId<?php echo $industryKey;?>"  class="cell" <?php echo (($industryId==$industryKey))?'checked':''?> onchange="serachFormClear('project');"  />
					  <label for="month3" class="ml10 cell"><?php echo $industry;?></label>
					  <br />
					</div>
					<?php
				}
			}
		}
		?>
		<div class="row seprator_10"></div>
		<div class="clear"></div>
	  </div>
	   <!--industry box -->
	  
	  
	  <?php /* ?>
	   <div id="projectCategory" class="projectCategory search_left_box mb6 ml9 mr10 dn">
		<div class="defaultP mt10 ml8 float_none">
		  <input class="cell" type="radio" name="catId" value="all" id="catIdallCategory" onchange="serachFormClear('category');"  onclick="showCurrentHideEach('#projectTypelist'+this.value, '.projectTypelist'); " <?php echo (($postCatId=='all') || !isset($postCatId))?'checked':''?> />
		  <label for="month3" class="ml10 cell"><?php echo $this->lang->line('all');?></label>
		  <br />
		</div>
		
		<?php
		
		
			if($sectionCategoryList && is_array($sectionCategoryList) && count($sectionCategoryList) > 0 ){
				foreach($sectionCategoryList as $key=>$categoryList){
					$dn=$postSectionId==$key?'':'dn';?>
					 <div class="<?php echo $dn?> categoryList" id="categoryList<?php echo $key;?>">
						<?php
							if($categoryList && is_array($categoryList) && count($categoryList) > 0 ){
								foreach($categoryList as $catId=>$category){
									$checked=($postCatId==$catId)?'checked':''; ?>
									<div class="defaultP mt10 ml8 float_none">
									  <input class="cell" type="radio" name="catId" value="<?php echo $catId;?>" id="catId<?php echo $catId;?>" <?php echo $checked;?> onclick="showCurrentHideEach('#projectTypelist'+this.value, '.projectTypelist'); " onchange="serachFormClear('category');" />
									  <label class="ml10 cell"><?php echo $category;?></label><br />
									</div>
									<?php
								}
							}
						?>
					</div>		
					<?php
				}
			}
		?>
		<div class="row seprator_10"></div>
			<div class="clear"></div>
	  </div>
		
		
		<?php
		*/
		?>
		
		<?php
		if($catProjectTypelist && is_array($catProjectTypelist) && count($catProjectTypelist) > 0 ){
			
			
			?>
			
			<?php
			foreach($catProjectTypelist as $key=>$projectCatlist){
				$dn=$postSectionId==$key?'':'dn';
				$sectionId=$key;?>
				
				<div class="search_left_box mb6  ml9 mr10 <?php echo $dn?> projectTypelist" id="projectTypelist<?php echo $sectionId?>">
					<div class="seprator_3"></div>
					<div class="tab_search_small">
					  <div class="defaultP">
						  <?php $checkedAll=$this->input->post('alltype')?'checked':''; ?>
						<input class="allCheckBox"  <?php echo $checkedAll;?> type="checkbox" name="alltype[]" id="allItem<?php echo $sectionId?>" value="alltype" onclick="checkUncheck(this, 0, '.CheckBox<?php echo $sectionId?>')"  />
					  </div>
					  <span class="Fleft"><?php echo $this->lang->line('all');?></span>
					  <div class="clear"></div>
					</div>
				
				<?php
				
				
			
				if($projectCatlist && is_array($projectCatlist) && count($projectCatlist) > 0){
					foreach($projectCatlist as $catId=>$projectTypelist){
				?>
					
					<?php
						if($projectTypelist && is_array($projectTypelist) && count($projectTypelist) > 0 ){
							foreach($projectTypelist as $typeId=>$projectTypeName){
								$checked=@in_array($typeId, $this->input->post('typeId'))?'checked':''; ?>
								<div class="tab_search_small">
								  <div class="defaultP">
									<input class="CheckBox<?php echo $sectionId?>" type="checkbox" name="typeId[]" id="typeId<?php echo $typeId;?>" value="<?php echo $typeId;?>" <?php echo $checked;?> onclick="checkUncheck(this, 0, '.checkbox<?php echo $typeId;?>'); checkUncheckParent('.CheckBox<?php echo $sectionId?>','#allItem<?php echo $sectionId?>')" />
								  </div>
								  <span class="Fleft"><?php echo $projectTypeName;?></span>
								  <div class="tab_search_small_btn Fright mr5 ptr" onclick="hideRelationDiv('toggleGenreList<?php echo $typeId;?>')"> </div>
								  <div class="clear"></div>
								</div>
								
								<?php
								if($projectTypeGenerList[$typeId] && is_array($projectTypeGenerList[$typeId]) && count($projectTypeGenerList[$typeId]) > 0 ){
									?>
									<div class="search_tab_checkbox_box dn" id="toggleGenreList<?php echo $typeId;?>">
										<?php
										foreach($projectTypeGenerList[$typeId] as $GenreId=>$Genre){
											$checked=@in_array($GenreId, $this->input->post('GenreId'))?'checked':''; ?>
											<div class="checkbox_div">
											  <div class="defaultP">
												<input class="CheckBox<?php echo $sectionId?> checkbox<?php echo $typeId;?>" type="checkbox" name="GenreId[]" id="GenreId<?php echo $GenreId;?>" value="<?php echo $GenreId;?>" <?php echo $checked;?> onclick="checkUncheckParent('.checkbox<?php echo $typeId;?>','#typeId<?php echo $typeId;?>'); checkUncheckParent('.CheckBox<?php echo $sectionId?>','#allItem<?php echo $sectionId?>')"  />
											  </div>
											  <span class="Fleft"><?php echo $Genre;?></span>
											  <div class="clear"></div>
											</div>
											<?php
										}
										?>
									</div>
									<?php
								}
							}
						}
					?>
					
						
					
					
				<?php
				}
			  }?>
				<div class="clear"></div>
					</div>
				
				<?php
			}?>
					
			
			<?php
		}
		?>
		<!--genre box end-->

	<div class="search_left_box mt6 mb6 ml9 mr10 dn" id="EmGenreDev"> 
			 
			<div class="defaultP mt10 ml8 float_none">
			  <input type="radio" name="EMgenre" value="all" id="EMgenreAll"  class="cell" />
			  <label for="month3" class="ml10 cell">All</label>
			  <br />
			</div>
			<?php
			if(isset($EMGenerList) && is_array($EMGenerList) && count($EMGenerList) > 0){
				
				foreach($EMGenerList as $EM=>$EMGener){
					if($EM > 0){?>
						<div class="defaultP mt10 ml8 float_none">
						  <input type="radio" name="EMgenre" value="<?php echo $EM;?>"  class="cell" />
						  <label for="month3" class="ml10 cell"><?php echo $EMGener;?></label>
						  <br />
						</div>
						<?php
					}
				}
			}
			?>
			<div class="row seprator_10"></div>
			<div class="clear"></div>
		  </div>
	  

	<div id="PE_CTGdev" class="dn mb6">
		<div class="search_left_box mt6 mb6 ml9 mr10 "> 
			<div class="defaultP mt10 ml8 float_none">
			  <input type="radio" name="PEcat" id="allPEcat" value="all" class="cell" />
			  <label for="month3" class="ml10 cell"><?php $this->lang->line('all');?></label>
			  <br />
			</div>
			
			<div class="defaultP mt10 ml8 float_none">
			  <input type="radio" name="PEcat" value="free"  class="cell" />
			  <label for="month3" class="ml10 cell">Events</label>
			  <br />
			</div>
			
			<div class="defaultP mt10 ml8 float_none">
			  <input type="radio" name="PEcat" value="news"  class="cell" />
			  <label for="month3" class="ml10 cell">Launches</label>
			  <br />
			</div>
			<div class="defaultP mt10 ml8 float_none">
			  <input type="radio" name="PEcat" value="reviews"  class="cell" />
			  <label for="month3" class="ml10 cell">Event Notification</label>
			  <br />
			</div>
			<div class="row seprator_10"></div>
			<div class="clear"></div>
		  </div>
		  
		  
		  <div class="search_left_box mt6 mb6 ml9 mr10"> 
			<div class="defaultP mt10 ml8 float_none">
			  <input type="radio" name="PEtype" id="PEtype" value="all" class="cell" />
			  <label for="month3" class="ml10 cell"><?php $this->lang->line('all');?></label>
			  <br />
			</div>
			
			<div class="defaultP mt10 ml8 float_none">
			  <input type="radio" name="PEtype" value="free"  class="cell" />
			  <label for="month3" class="ml10 cell">Live</label>
			  <br />
			</div>
			
			<div class="defaultP mt10 ml8 float_none">
			  <input type="radio" name="PEtype" value="news"  class="cell" />
			  <label for="month3" class="ml10 cell">Online</label>
			  <br />
			</div>
			
			<div class="row seprator_10"></div>
			<div class="clear"></div>
		  </div>
		  
		   <div class="search_left_box mt6 ml9 mr10"> 
			<div class="defaultP mt10 ml8 float_none">
			  <input type="radio" name="PEgenre" value="all" id="PEgenre" class="cell" />
			  <label for="month3" class="ml10 cell"><?php $this->lang->line('all');?></label>
			  <br />
			</div>
			
			<div class="defaultP mt10 ml8 float_none">
			  <input type="radio" name="PEgenre" value="free"  class="cell" />
			  <label for="month3" class="ml10 cell">Entertainment</label>
			  <br />
			</div>
			
			<div class="defaultP mt10 ml8 float_none">
			  <input type="radio" name="PEgenre" value="news"  class="cell" />
			  <label for="month3" class="ml10 cell">Educational Material</label>
			  <br />
			</div>
			<div class="row seprator_10"></div>
			<div class="clear"></div>
		  </div>

		
	</div>
	
	<div class="search_left_box mt6 mb6 ml9 mr10 dn" id="ProductGenreDev"> 
			 
			<div class="defaultP mt10 ml8 float_none">
			  <input type="radio" name="ProductCat" value="all" id="AllProductGenre"  class="cell" />
			  <label for="month3" class="ml10 cell"><?php $this->lang->line('all');?></label>
			  <br />
			</div>
			
			<div class="defaultP mt10 ml8 float_none">
			  <input type="radio" name="ProductCat" value="product_1"  class="cell" />
			  <label for="month3" class="ml10 cell">For Sale</label>
			  <br />
			</div>
			
			<div class="defaultP mt10 ml8 float_none">
			  <input type="radio" name="ProductCat" value="product_3"  class="cell" />
			  <label for="month3" class="ml10 cell">Free</label>
			  <br />
			</div>
			<div class="defaultP mt10 ml8 float_none">
			  <input type="radio" name="ProductCat" value="product_2"  class="cell" />
			  <label for="month3" class="ml10 cell">Wanted</label>
			  <br />
			</div>
			
			<div class="row seprator_10"></div>
			
			<div class="clear"></div>
		  </div>
	 
	<div id="WorkCPG" class="ProductGenresearch_left_box mb6 ml9 mr10 dn">
	<div class="tab_search_small">
		<div class="defaultP">
		<input id="allWorkType" type="checkbox"  value="allWorkType" name="allWorkType" onclick="checkUncheck(this, 0, '.workCheckBox');" >
		</div>
		<span class="Fleft"><?php echo $this->lang->line('all');?> <?php echo $this->lang->line('work');?></span>
		<div class="clear"></div>
	</div>
	<div class="tab_search_small">
		<div class="defaultP">
			<input id="WorkOffered" class="workCheckBox" type="checkbox" value="offered" name="WorkOffered" onclick="checkUncheck(this, 0, '.offerCheckbox'); checkUncheckParent('.workCheckBox','#allWorkType');">
		</div>
		<span class="Fleft"><?php echo $this->lang->line('offered');?></span>
		<div class="clear"></div>
	</div>

	<div class="search_tab_checkbox_box">
		<div class="checkbox_div">
		<div class="defaultP">
			<input class="workCheckBox offerCheckbox" type="checkbox" value="t" name="urgentWorkOffered" onclick="checkUncheckParent('.workCheckBox','#allWorkType'); checkUncheckParent('.offerCheckbox','#WorkOffered');">
		</div>
		<span class="Fleft"><?php echo $this->lang->line('urgent');?></span>
		<div class="clear"></div>
		</div>
		<div class="checkbox_div">
		<div class="defaultP">
			<input class="workCheckBox offerCheckbox" type="checkbox" value="t" name="normalWorkOffered" onclick="checkUncheckParent('.workCheckBox','#allWorkType'); checkUncheckParent('.offerCheckbox','#WorkOffered');">
		</div>
		<span class="Fleft"><?php echo $this->lang->line('normal');?></span>
		<div class="clear"></div>
		</div>
		
		<div class="checkbox_div">
		<div class="defaultP">
			<input class="workCheckBox offerCheckbox" type="checkbox" value="t" name="experienceWorkOffered" onclick="checkUncheckParent('.workCheckBox','#allWorkType'); checkUncheckParent('.offerCheckbox','#WorkOffered');">
		</div>
		<span class="Fleft"><?php echo $this->lang->line('experience');?></span>
		<div class="clear"></div>
		</div>
	</div>
	
	
	<?php /*
	<div class="tab_search_small">
		<div class="defaultP">
			<input class="workCheckBox" type="checkbox" value="t" name="WorkOfferedExp" id="WorkOfferedExp" onclick="checkUncheck(this, 0, '.EOCheckbox'); checkUncheckParent('.workCheckBox','#allWorkType');">
		</div>
		<span class="Fleft"><?php echo $this->lang->line('experience');?> <?php echo $this->lang->line('offered');?> </span>
		<div class="clear"></div>
	</div>

	<div class="search_tab_checkbox_box">
		<div class="checkbox_div">
		<div class="defaultP">
			<input class="workCheckBox EOCheckbox" type="checkbox" value="t" name="urgentWorkExp" onclick="checkUncheckParent('.workCheckBox','#allWorkType'); checkUncheckParent('.EOCheckbox','#WorkEP');">
		</div>
		<span class="Fleft"><?php echo $this->lang->line('urgent');?></span>
		<div class="clear"></div>
		</div>
		<div class="checkbox_div">
		<div class="defaultP">
			<input class="workCheckBox EOCheckbox" type="checkbox" value="t" name="normalWorkExp" onclick="checkUncheckParent('.workCheckBox','#allWorkType'); checkUncheckParent('.EOCheckbox','#WorkEP');">
		</div>
		<span class="Fleft"><?php echo $this->lang->line('normal');?></span>
		<div class="clear"></div>
		</div>
	</div>
	
	*/?>
	
	<div class="tab_search_small" onclick="checkUncheckParent('.workCheckBox','#allWorkType');">
		<div class="defaultP">
			<input class="workCheckBox" type="checkbox" value="wanted" name="WorkWanted">
		</div>
		<span class="Fleft"><?php echo $this->lang->line('wanted');?></span>
		<div class="clear"></div>
	</div>
	<div class="tab_search_small" onclick="checkUncheckParent('.workCheckBox','#allWorkType');">
		<div class="defaultP">
			<input class="workCheckBox" type="checkbox" value="t" name="WorkWantedExperience">
		</div>
		<span class="Fleft"><?php echo $this->lang->line('experience');?> <?php echo $this->lang->line('wanted');?> </span>
		<div class="clear"></div>
	</div>
	
	<div class="clear"></div>
</div>
	
	  <div class="Fright mr6">
		<div class="tds-button-big Fleft"> <a href="javascript:void(0)" onclick="$('#advanceSearchForm').submit();" onmouseup="mouseout_big_button(this)" onmousedown="mousedown_big_button(this)"><span><?php echo $this->lang->line('searchLabel');?></span></a> </div>
	  </div>
	  <br />
	  <br />
	  <br />
	  <br />
	  <?php echo form_close(); ?>
</div>
<!--left_coloumn-->
<script>
	$('#DPforAll').attr("checked", true);
	function showSectionSerchOption(object){
	
		var sectionId = object.value;	
		
		$('.allCheckBox').attr("checked", false);
		$('.CheckBox').attr("checked", false);
		
		
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
		
		//showCurrentHideEach('','#workProjectPart');
		
		//showCurrentHideEach('','.categoryList');
		
		showCurrentHideEach('','.projectTypelist');
		showCurrentHideEach('','#FormToDateList');
		showCurrentHideEach('','#industryIdDIV');
		
		
		showCurrentHideEach('#languageList',''); 
		
		if(sectionId==1 || sectionId==2 || sectionId==3 || sectionId==4 ){
			
			showCurrentHideEach('#mediaProjectPart',''); 
			//showCurrentHideEach('#categoryList'+this.value,'');
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
			//showCurrentHideEach('#categoryList'+sectionId,'.categoryList'); 
			showCurrentHideEach('','.projectTypelist'); 
			showCurrentHideEach('#EmGenreDev','');
		}else if(sectionId==11){
			showCurrentHideEach('#townCity',''); 
			//showCurrentHideEach('#workProjectPart',''); 
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
		}else{
			//showCurrentHideEach('#townCity',''); 
			//showCurrentHideEach('#defaultProjectPart','');
			//$('#DPforAll').attr("checked", true);
		}
		runTimeCheckBox();
	}
	
	function serachFormClear(section){
		$('.allCheckBox').attr("checked", false);
		$('.CheckBox').attr("checked", false);
		
		if(section=='section'){
			$('#projectPartAll').attr("checked", true);
			$('#catIdallCategory').attr("checked", true);
			
		}
		else if(section=='project'){
			$('#catIdallCategory').attr("checked", true);
		}
		runTimeCheckBox();
	}
	$(document).ready(function(){	
		$("#advanceSearchForm").validate({
			  submitHandler: function() {
				$('html').animate({scrollTop:0}, 'slow');
				$('#searchResultDiv').html('<img  class="ma" id="loadImg" align="absmiddle" src="'+baseUrl+'images/loading.gif" />');
				var fromData=$("#advanceSearchForm").serialize();
				$.post(baseUrl+language+'/search/searchresult',fromData, function(data) {
				  if(data){
					 $('#searchResultDiv').html(data);
				  }
				});
			 }
		});
	});

</script>




