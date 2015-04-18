<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<!--left_coloumn-->

	  <!--left_gray_gradient_box-->
	  <div class="search_left_box mt6 ml9 mb6 mr10">
		<div class="SRleft_select_box ml1 mt6" id="languageList">
			<?php				
				echo form_dropdown('languageId', $languageList, '','id="languageId"');
			?>			
		</div>
		<div class="clear"></div>
		
		<div class="SRleft_select_box ml1 mt0">
		  <?php
				echo form_dropdown('producedInCountry', $countryList, '','id="producedInCountry" ');
		 ?>
		</div>
		 <div id="townCity" class="dn">
			<div class="search_page_input ml3 "><input type="text" name="city"  placeholder="<?php echo $this->lang->line('twnRcity');?>" onclick="placeHoderHideShow(this,'<?php echo $this->lang->line('twnRcity');?>','hide')" onblur="placeHoderHideShow(this,'<?php echo $this->lang->line('twnRcity');?>','show')" value="" /></div>
			<div class="row seprator_3"></div>
		</div>
		<div class="clear"></div>
	  </div>
	  
	  <div class="search_left_box mb6 ml9 mr10 dn FormToDateList" id="FormToDateList">
		   <div class="calendar_box">
			   <span class="pl15"><?php echo $this->lang->line('from');?></span>
			   <div class="date_bgselected">
				<span class="Fleft"><input id="eventStartDate" name="eventStartDate" type="textbox" class="date_input_search_box" placeholder="<?php echo date('F : Y');?>" value=""></span><a class="cal_icon" onclick='$("#eventStartDate").focus();'></a>
			   </div>
			   <span class="pl15"><?php echo $this->lang->line('to');?></span>
			   <div class="date_bgselected" id="eventEndDateDiv">
					<span class="Fleft"><input id="eventEndDate" name="eventEndDate" type="textbox" disabled="disabled" class="date_input_search_box" placeholder="<?php echo date('F : Y');?>" value=""></span><a class="cal_icon" id="eventEndDateCal" onclick="$('#eventEndDate').focus();"></a>
			   </div>
		   </div>
	   </div>
	   
	  <div class="search_left_box  mb6 ml9 mr10 dn ProjectPart" id="mediaProjectPart">
		<div class="defaultP mt10 ml8 float_none">
		  <input type="radio" name="projectPart" value="all" id="MPforAll"  class="cell allSelect" checked="checked"  onclick="if($('#sectionId').val() !='' || $('#sectionId').val() !=10 ){showCurrentHideEach('#projectTypelist'+$('#sectionId').val(), '.projectTypelist')} if($('#sectionId').val() == 10){ showCurrentHideEach('', '.projectTypelist'); showCurrentHideEach('#industryIdDIV',''); showCurrentHideEach('#EmGenreDev', '');}  " />
		  <label for="month3" class="ml10 cell"><?php echo $this->lang->line('all');?></label>
		  <br />
		</div>
		
		<div class="defaultP mt10 ml8 float_none">
		  <input type="radio" name="projectPart" value="free" class="cell" onclick="if($('#sectionId').val() !='' || $('#sectionId').val() !=10 ){showCurrentHideEach('#projectTypelist'+$('#sectionId').val(), '.projectTypelist')} if($('#sectionId').val() == 10){ showCurrentHideEach('', '.projectTypelist'); showCurrentHideEach('#industryIdDIV',''); showCurrentHideEach('#EmGenreDev', '');}  " />
		  <label for="month3" class="ml10 cell"><?php echo $this->lang->line('free').' '.$this->lang->line('projects');?></label>
		  <br />
		</div>
		
		<div class="defaultP mt10 ml8 float_none">
		  <input class="cell" type="radio" name="projectPart" value="projects" onclick="if($('#sectionId').val() !='' || $('#sectionId').val() !=10 ){showCurrentHideEach('#projectTypelist'+$('#sectionId').val(), '.projectTypelist')} if($('#sectionId').val() == 10){ showCurrentHideEach('', '.projectTypelist'); showCurrentHideEach('#industryIdDIV',''); showCurrentHideEach('#EmGenreDev', '');}  " />
		  <label for="month3" class="ml10 cell"><?php echo $this->lang->line('projects');?></label>
		  <br />
		</div>
		
		
		<div class="defaultP mt10 ml8 float_none">
		  <input type="radio" name="projectPart" value="news" class="cell" onchange="serachFormClear(this, 'project');"  onclick="showCurrentHideEach('', '.projectTypelist'); showCurrentHideEach('', '#industryIdDIV'); showCurrentHideEach('', '#EmGenreDev');" />
		  <label for="month3" class="ml10 cell"><?php echo $this->lang->line('news');?></label>
		  <br />
		</div>
		<div class="defaultP mt10 ml8 float_none">
		  <input type="radio" name="projectPart" value="reviews" class="cell" onchange="serachFormClear(this, 'project');"  onclick="showCurrentHideEach('', '.projectTypelist'); showCurrentHideEach('', '#industryIdDIV'); showCurrentHideEach('', '#EmGenreDev');" />
		  <label for="month3" class="ml10 cell"><?php echo $this->lang->line('reviews');?></label>
		  <br />
		</div>
		<div class="defaultP mt10 ml8 float_none">
		  <input type="radio" name="projectPart" value="top100craved"  class="cell" onclick="if($('#sectionId').val() !='' || $('#sectionId').val() !=10 ){showCurrentHideEach('#projectTypelist'+$('#sectionId').val(), '.projectTypelist')} if($('#sectionId').val() == 10){ showCurrentHideEach('', '.projectTypelist'); showCurrentHideEach('#industryIdDIV',''); showCurrentHideEach('#EmGenreDev', '');}  " />
		  <label for="month3" class="ml10 cell"><?php echo $this->lang->line('top100craved');?></label>
		  <br />
		</div>
		<div class="defaultP mt10 ml8 float_none">
		  <input class="cell" type="radio" name="projectPart" value="upcomingprojects" id="projectPartUpcomingProjects" onchange="serachFormClear(this, 'project');"  onclick="showCurrentHideEach('', '.projectTypelist'); showCurrentHideEach('', '#industryIdDIV'); showCurrentHideEach('', '#EmGenreDev');"  />
		  <label for="month3" class="ml10 cell"><?php echo $this->lang->line('upcomingProjects');?></label>
		  <br />
		</div> 
		
		<div class="row seprator_10"></div>
		<div class="clear"></div>
	  </div>
	   
	  <div class="search_left_box  mb6 ml9 mr10 dn ProjectPart" id="PEProjectPart">
		<div class="defaultP mt10 ml8 float_none">
		  <input type="radio" name="projectPart" value="all" id="PEforAll"  class="cell allSelect" checked="checked"  onclick="showCurrentHideEach('#industryIdDIV',''); showCurrentHideEach('#PE_CTGdev', '');" />
		  <label for="month3" class="ml10 cell"><?php echo $this->lang->line('all');?></label>
		  <br />
		</div>
		
		<div class="defaultP mt10 ml8 float_none">
		  <input type="radio" name="projectPart" value="free" class="cell" onclick="showCurrentHideEach('#industryIdDIV',''); showCurrentHideEach('#PE_CTGdev', '');" />
		  <label for="month3" class="ml10 cell"><?php echo $this->lang->line('free');?></label>
		  <br />
		</div>
		
		<div class="defaultP mt10 ml8 float_none">
		  <input type="radio" name="projectPart" value="news" class="cell" onchange="serachFormClear(this, 'project');"  onclick="showCurrentHideEach('','#industryIdDIV'); showCurrentHideEach('', '#PE_CTGdev');" />
		  <label for="month3" class="ml10 cell"><?php echo $this->lang->line('news');?></label>
		  <br />
		</div>
		<div class="defaultP mt10 ml8 float_none">
		  <input type="radio" name="projectPart" value="reviews" class="cell" onchange="serachFormClear(this, 'project');"  onclick="showCurrentHideEach('','#industryIdDIV'); showCurrentHideEach('', '#PE_CTGdev');" />
		  <label for="month3" class="ml10 cell"><?php echo $this->lang->line('reviews');?></label>
		  <br />
		</div>
		<div class="defaultP mt10 ml8 float_none">
		  <input type="radio" name="projectPart" value="top100craved"  class="cell" onclick="showCurrentHideEach('#industryIdDIV',''); showCurrentHideEach('#PE_CTGdev', '');" />
		  <label for="month3" class="ml10 cell"><?php echo $this->lang->line('top100craved');?></label>
		  <br />
		</div>
		
		<div class="defaultP mt10 ml8 float_none">
		  <input class="cell" type="radio" name="projectPart" value="upcomingprojects" id="projectPartUpcomingProjects" onchange="serachFormClear(this, 'project');"  onclick="showCurrentHideEach('','#industryIdDIV'); showCurrentHideEach('', '#PE_CTGdev');"  />
		  <label for="month3" class="ml10 cell"><?php echo $this->lang->line('upcomingProjects');?></label>
		  <br />
		</div> 
		
		<div class="row seprator_10"></div>
		<div class="clear"></div>
	  </div>
	  
	  <div class="search_left_box  mb6 ml9 mr10 dn ProjectPart" id="blogProjectPart">
		<div class="defaultP mt10 ml8 float_none">
		  <input type="radio" name="projectPart" value="all" id="BPforAll"  class="cell allSelect" checked="checked"  />
		  <label for="month3" class="ml10 cell"><?php echo $this->lang->line('all');?></label>
		  <br />
		</div>
		
		<div class="defaultP mt10 ml8 float_none">
		  <input type="radio" name="projectPart" value="top100craved"  class="cell"  />
		  <label for="month3" class="ml10 cell"><?php echo $this->lang->line('top100craved');?></label>
		  <br />
		</div>
		
		<div class="row seprator_10"></div>
		<div class="clear"></div>
	  </div>
	   
	  <div class="search_left_box  mb6 ml9 mr10 dn ProjectPart" id="creativesProjectPart">
		<div class="defaultP mt10 ml8 float_none">
		  <input type="radio" name="projectPart" value="all" id="CPforAll"  class="cell allSelect" checked="checked" onclick="showCurrentHideEach('#industryIdDIV','');"   />
		  <label for="month3" class="ml10 cell"><?php echo $this->lang->line('all');?></label>
		  <br />
		</div>
		
		
		<div class="defaultP mt10 ml8 float_none">
		  <input type="radio" name="projectPart" value="news" class="cell" onchange="serachFormClear(this, 'project');"  onclick="showCurrentHideEach('','#industryIdDIV');" />
		  <label for="month3" class="ml10 cell"><?php echo $this->lang->line('news');?></label>
		  <br />
		</div>
		<div class="defaultP mt10 ml8 float_none">
		  <input type="radio" name="projectPart" value="reviews" class="cell" onchange="serachFormClear(this, 'project');"  onclick="showCurrentHideEach('','#industryIdDIV');" />
		  <label for="month3" class="ml10 cell"><?php echo $this->lang->line('reviews');?></label>
		  <br />
		</div>
		<div class="defaultP mt10 ml8 float_none">
		  <input type="radio" name="projectPart" value="top100craved"  class="cell" onclick="showCurrentHideEach('#industryIdDIV','');" />
		  <label for="month3" class="ml10 cell"><?php echo $this->lang->line('top100craved');?></label>
		  <br />
		</div>
		
		<div class="row seprator_10"></div>
		<div class="clear"></div>
	  </div>
	   
	  <div class="search_left_box  mb6 ml9 mr10 dn ProjectPart" id="productProjectPart">
		 
		<div class="defaultP mt10 ml8 float_none">
		  <input type="radio" name="projectPart" value="all" id="PPforAll" class="cell allSelect" checked="checked" onclick="showCurrentHideEach('#industryIdDIV',''); showCurrentHideEach('#ProductGenreDev', '');" />
		  <label for="month3" class="ml10 cell"><?php echo $this->lang->line('all');?></label>
		  <br />
		</div>
		
		<div class="defaultP mt10 ml8 float_none">
		  <input type="radio" name="projectPart" value="news"  class="cell" onchange="serachFormClear(this, 'project');"  onclick="showCurrentHideEach('','#industryIdDIV'); showCurrentHideEach('', '#ProductGenreDev');" />
		  <label for="month3" class="ml10 cell"><?php echo $this->lang->line('news');?></label>
		  <br />
		</div>
		<div class="defaultP mt10 ml8 float_none">
		  <input type="radio" name="projectPart" value="reviews"  class="cell" onchange="serachFormClear(this, 'project');"  onclick="showCurrentHideEach('','#industryIdDIV'); showCurrentHideEach('', '#ProductGenreDev');" />
		  <label for="month3" class="ml10 cell"><?php echo $this->lang->line('reviews');?></label>
		  <br />
		</div>
		<div class="defaultP mt10 ml8 float_none">
		  <input type="radio" name="projectPart" value="top100craved"  class="cell" onclick="showCurrentHideEach('#industryIdDIV',''); showCurrentHideEach('#ProductGenreDev', '');" />
		  <label for="month3" class="ml10 cell"><?php echo $this->lang->line('top100craved');?></label>
		  <br />
		</div>
		
		<div class="row seprator_10"></div>
		<div class="clear"></div>
	  </div>
	 
	  <!--industry box -->
      
	  <div class="search_left_box mb6 ml9 mr10 dn" id="industryIdDIV">
		<div class="defaultP mt10 ml8 float_none">
		  <input type="radio" name="industryId" value="all" id="industryIdAll"  class="cell forAll allSelect" checked="checked"  />
		  <label for="month3" class="ml10 cell"><?php echo $this->lang->line('all');?></label>
		  <br />
		</div>
		
		<?php
		if($industryList && is_array($industryList) && count($industryList) > 0 ){
			foreach($industryList as $industryKey=>$industry){
				if($industryKey > 0){?>
					<div class="defaultP mt10 ml8 float_none">
					  <input type="radio" name="industryId" value="<?php echo $industryKey;?>" id="industryId<?php echo $industryKey;?>"  class="cell"   />
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
	   
	  <!--Blog industry box -->
	  <div class="search_left_box mb6 ml9 mr10 dn" id="blogIndustryIdDIV">
		<div class="defaultP mt10 ml8 float_none">
		  <input type="radio" name="blogIndustryId" value="all" id="blogIndustryIdAll"  class="cell forAll allSelect blogAllCheck" checked="checked"  />
		  <label for="month3" class="ml10 cell"><?php echo $this->lang->line('all');?></label>
		  <br />
		</div>
		
		<?php
		if($blogIndustryList && is_array($blogIndustryList) && count($blogIndustryList) > 0 ){
			foreach($blogIndustryList as $industryKey=>$industry){
				if($industryKey > 0){?>
					<div class="defaultP mt7 ml8 float_none">
					  <input type="radio" name="industryId" value="<?php echo $industryKey;?>" id="industryId<?php echo $industryKey;?>"  class="cell blogCheck"   />
					  <label for="month3" class="ml10 cell width120px"><?php echo $industry;?></label>
					 
					  <div class="clear"></div>
					</div>
					<?php
				}
			}
		}
		?>
		<div class="row seprator_10"></div>
		<div class="clear"></div>
	  </div>
	   <!--Blog industry box -->
	   
		<?php
		if($catProjectTypelist && is_array($catProjectTypelist) && count($catProjectTypelist) > 0 ){
			foreach($catProjectTypelist as $key=>$projectCatlist){
				$sectionId=$key;?>
				
				<div class="search_left_box mb6  ml9 mr10 dn projectTypelist" id="projectTypelist<?php echo $sectionId?>">
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
											  <span class="Fleft width120px"><?php echo $Genre;?></span>
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
					
				}
			  }?>
				<div class="clear"></div>
					</div>
				
				<?php
			}
		}
		?>
		<!--genre box end-->
		
<!-- Education Material  Start--> 
	<div class="search_left_box mt6 mb6 ml9 mr10 dn" id="EmGenreDev"> 
			<div class="defaultP mt10 ml8 float_none">
			  <input type="radio" name="EMgenre" value="all" id="EMgenreAll"  class="cell allSelect" />
			  <label for="month3" class="ml10 cell"><?php echo $this->lang->line('all');?></label>
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
<!-- Education Material  End--> 

	  
<!-- P&E  Start--> 
	<div id="PE_CTGdev" class="dn mb6">
		<div class="search_left_box mt6 mb6 ml9 mr10 "> 
			<div class="defaultP mt10 ml8 float_none">
			  <input type="radio" name="PEcat" id="allPEcat" value="all" class="cell allSelect PEcat" />
			  <label for="month3" class="ml10 cell"><?php echo $this->lang->line('all');?></label>
			  <br />
			</div>
			
			<div class="defaultP mt10 ml8 float_none">
			  <input type="radio" name="PEcat" value="event"  class="cell PEcat" />
			  <label for="month3" class="ml10 cell"><?php echo $this->lang->line('events');?></label>
			  <br />
			</div>
			
			<div class="defaultP mt10 ml8 float_none">
			  <input type="radio" name="PEcat" value="launch"  class="cell PEcat" />
			  <label for="month3" class="ml10 cell"><?php echo $this->lang->line('launches');?></label>
			  <br />
			</div>
			<div class="defaultP mt10 ml8 float_none">
			  <input type="radio" name="PEcat" value="notification"  class="cell PEcat" />
			  <label for="month3" class="ml10 cell"><?php echo $this->lang->line('eventNotification');?></label>
			  <br />
			</div>
			<div class="row seprator_10"></div>
			<div class="clear"></div>
		  </div>
		  
		  
		  <div class="search_left_box mt6 mb6 ml9 mr10"> 
			<div class="defaultP mt10 ml8 float_none">
			  <input type="radio" name="PEtype" id="PEtype" value="all" class="cell allSelect" />
			  <label for="month3" class="ml10 cell"><?php echo  $this->lang->line('all');?></label>
			  <br />
			</div>
			
			<div class="defaultP mt10 ml8 float_none">
			  <input type="radio" name="PEtype" value="live"  class="cell" />
			  <label for="month3" class="ml10 cell"><?php echo  $this->lang->line('live');?></label>
			  <br />
			</div>
			
			<div class="defaultP mt10 ml8 float_none">
			  <input type="radio" name="PEtype" value="online"  class="cell" />
			  <label for="month3" class="ml10 cell"><?php echo  $this->lang->line('online');?></label>
			  <br />
			</div>
			
			<div class="row seprator_10"></div>
			<div class="clear"></div>
		  </div>
		  
		   <div class="search_left_box mt6 ml9 mr10"> 
			<div class="defaultP mt10 ml8 float_none">
			  <input type="radio" name="PEgenre" value="all" id="PEgenre" class="cell allSelect" />
			  <label for="month3" class="ml10 cell"><?php echo  $this->lang->line('all');?></label>
			  <br />
			</div>
			
			<div class="defaultP mt10 ml8 float_none">
			  <input type="radio" name="PEgenre" value="entertainment"  class="cell" />
			  <label for="month3" class="ml10 cell"><?php echo $this->lang->line('entertainment');?></label>
			  <br />
			</div>
			
			<div class="defaultP mt10 ml8 float_none">
			  <input type="radio" name="PEgenre" value="educational"  class="cell" />
			  <label for="month3" class="ml10 cell"><?php echo $this->lang->line('educational');?></label>
			  <br />
			</div>
			<div class="row seprator_10"></div>
			<div class="clear"></div>
		  </div>
	</div>
<!-- P&E  End--> 
	
<!-- product Start-->
	<div class="search_left_box mt6 mb6 ml9 mr10 dn" id="ProductGenreDev"> 
			<div class="defaultP mt10 ml8 float_none">
			  <input type="radio" name="ProductCat" value="all" id="AllProductGenre"  class="cell allSelect" />
			  <label for="month3" class="ml10 cell"><?php echo $this->lang->line('all');?></label>
			  <br />
			</div>
			
			<div class="defaultP mt10 ml8 float_none">
			  <input type="radio" name="ProductCat" value="product_1"  class="cell" />
			  <label for="month3" class="ml10 cell"><?php echo $this->lang->line('forSale');?> </label>
			  <br />
			</div>
			
			<div class="defaultP mt10 ml8 float_none">
			  <input type="radio" name="ProductCat" value="product_3"  class="cell" />
			  <label for="month3" class="ml10 cell"><?php echo $this->lang->line('free');?></label>
			  <br />
			</div>
			<div class="defaultP mt10 ml8 float_none">
			  <input type="radio" name="ProductCat" value="product_2"  class="cell" />
			  <label for="month3" class="ml10 cell"><?php echo $this->lang->line('wanted');?></label>
			  <br />
			</div>
			
			<div class="row seprator_10"></div>
			
			<div class="clear"></div>
		  </div>
<!-- product  End-->
	 
<!-- Work Start--> 
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
	
	
	<div class="tab_search_small">
		<div class="defaultP">
			<input class="workCheckBox" type="checkbox" value="wanted" name="WorkWanted" id="WorkWanted" onclick="checkUncheck(this, 0, '.EOCheckbox'); checkUncheckParent('.workCheckBox','#allWorkType');">
		</div>
		<span class="Fleft"><?php echo $this->lang->line('wanted');?></span>
		<div class="clear"></div>
	</div>

	<div class="search_tab_checkbox_box">
		<div class="checkbox_div">
		<div class="defaultP">
			<input class="workCheckBox EOCheckbox" type="checkbox" value="t" name="normalWorkWanted" onclick="checkUncheckParent('.workCheckBox','#allWorkType'); checkUncheckParent('.EOCheckbox','#WorkWanted');">
		</div>
		<span class="Fleft"><?php echo $this->lang->line('normal');?></span>
		<div class="clear"></div>
		</div>
		
		<div class="checkbox_div">
		<div class="defaultP">
			<input class="workCheckBox EOCheckbox" type="checkbox" value="t" name="expWorkWanted" onclick="checkUncheckParent('.workCheckBox','#allWorkType'); checkUncheckParent('.EOCheckbox','#WorkWanted');">
		</div>
		<span class="Fleft"><?php echo $this->lang->line('experience');?></span>
		<div class="clear"></div>
		</div>
		
	
	</div>
	
	<div class="clear"></div>
</div>
<!-- Work  End--> 
	  
	  <div class="Fright mr6">
		<div class="tds-button-big Fleft"> <a href="javascript:void(0)" onclick="$('#advanceSearchForm').submit();" onmouseup="mouseout_big_button(this)" onmousedown="mousedown_big_button(this)"><span><?php echo $this->lang->line('searchLabel');?></span></a> </div>
	  </div>
	  <br />
	  <br />
	  <br />
	  <br />
	  
<!--left_coloumn-->

