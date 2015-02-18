<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	$loggedInUser = isLoginUser();	
	if(isset($loggedInUser) && $loggedInUser>0) {	
		$addCompetionUrl =  "goTolink('','".base_url('dashboard/competition')."')";
	}
	else{
		$addCompetionUrl =  "openLightBox('popupBoxWp','popup_box','/auth/login','".$this->lang->line('beforeCommonLoggedIn').strtolower($this->lang->line('upcoming')).".')";
	}
	?>
	<div class="pt10 pr10 pb10 pl10">
        <div class="bg_464646">
			<?php
				// login view load
				$this->load->view('competitionlogin'); 
			?>
		<div class="seprator_13"></div>
		<div class="row ml40 mr40">
        
        <div class="tds-button_compeation2 fl mr5 mt3 ml12"> 
			<a href='javascript://void(0);' onclick= " <?php echo $addCompetionUrl ?> " onmousedown="mousedown_tds_competition(this)" onmouseup="mouseup_tds_competition(this)"><span><?php echo $this->lang->line('createCompetition') ?></span></a> 
        </div>
        <form method="post" id="searchform" action="<?php echo ''.site_url().'en/competition/index'; ?>">					
			<div class="fr width_490">
			<div class="cell pl7 position_relative comp_select ml6">
				<?php 
					$selectIndustryValue = ($this->input->post('selectIndustry'))?$this->input->post('selectIndustry'):'';
					$sortByValue = ($this->input->post('sortBy'))?$this->input->post('sortBy'):'';
					$searchWord = ($this->input->post('searchWord'))?$this->input->post('searchWord'):'Keyword Search...';
					$selectIndustry = array(
					''   => 'Select industry',
					'1'  => 'Film & Video',
					'2'  => 'Music & Audio',
					'3'  => 'Writing & Publishing',
					'4'  => 'Photography & Art',
					'5'  => 'Performing Arts',
					);
					$js= 'class="width70px" id="selectIndustry"  onchange="this.form.submit()"';
					echo form_dropdown('selectIndustry', $selectIndustry, $selectIndustryValue,$js);
				?>	
			</div>
			<div class="cell pl7 position_relative comp_select_1 ">
				<?php 
				$sortBy = array(
				'createdDate' => 'Sort By',
				'title'  => 'Title',
				'submissionStartDate'  => 'Entries',
				'submissionEndDate'  => 'Vote'
				);
				$js= 'class="width70px" id="sortBy" onchange="this.form.submit()"';
				echo form_dropdown('sortBy', $sortBy, $sortByValue,$js);
				?>	
			</div>
			</form>
			
			<!-------comman search call here start------>	
				<?php
						$formAttributes = array(
							'name'=>'SearchFooterForm',
							'id'=>'SearchFooterForm',
						);
						echo form_open(base_url(lang().'/search/searchform'),$formAttributes);
					?>
					<div class="search_box_wrapper ml10 wp_serch_box_wrapper  clear_none mt6">
					<input name="keyWord" type="text" class="search_text_box wp_login_serch" placeholder="<?php echo $this->lang->line('keywordSearch');?>" value="<?php echo $this->lang->line('keywordSearch');?>"  onclick="placeHoderHideShow(this,'<?php echo $this->lang->line('keywordSearch');?>','hide')" onblur="placeHoderHideShow(this,'<?php echo $this->lang->line('keywordSearch');?>','show')" />
					<input name="sectionId" type="hidden" value="">
						<input type="submit" name="searchCrave" value="" class="search_btn_glass">
						<!--<input type="image" value="searchCrave" name="searchCrave" src="<?php echo base_url();?>images/btn_search_box.png" >-->
					</div>
				<?php echo form_close(); ?>
			<!-------comman search call here end------>	
		</div>
		
				
		<div class="clear"></div>
		<div class="seprator_22"></div>
        </div>
			
        <div class="clear"></div>
    
    <?php 
    
    //**********make data array industry wise start*********//
		$competitionIndustryData = '';
		
		if(!empty($competition_array) && is_array($competition_array)){
		
		foreach($competition_array as $competitionArray){
		  
		  
			switch($competitionArray->industryId){
			  
				case 1:
				    $industryArray = getIndustryClass(1);
					$competitionIndustryData['0']['borderClass'] = $industryArray['6pxborderClass'];
					$competitionIndustryData['0']['buttonClass'] = $industryArray['commonBigButton'];
					$competitionIndustryData['0']['fontColorClass'] = $industryArray['fontColorClass'];
					$competitionIndustryData['0']['showHeading'] = $industryArray['showHeading'];
					$competitionIndustryData['0']['industryId'] = $industryArray['industryId'];
					$competitionIndustryData['0']['competitionData'][] = $competitionArray;
				break;  
				case 2:
					$industryArray = getIndustryClass(2);
					$competitionIndustryData['1']['borderClass'] = $industryArray['6pxborderClass'];
					$competitionIndustryData['1']['buttonClass'] = $industryArray['commonBigButton'];
					$competitionIndustryData['1']['fontColorClass'] = $industryArray['fontColorClass'];
					$competitionIndustryData['1']['showHeading'] = $industryArray['showHeading'];
					$competitionIndustryData['1']['industryId'] = $industryArray['industryId'];
					$competitionIndustryData['1']['competitionData'][] = $competitionArray;
				break; 
				case 3:
					$industryArray = getIndustryClass(3);
					$competitionIndustryData['2']['borderClass'] = $industryArray['6pxborderClass'];
					$competitionIndustryData['2']['buttonClass'] = $industryArray['commonBigButton'];
					$competitionIndustryData['2']['fontColorClass'] = $industryArray['fontColorClass'];
					$competitionIndustryData['2']['showHeading'] = $industryArray['showHeading'];
					$competitionIndustryData['2']['industryId'] = $industryArray['industryId'];
					$competitionIndustryData['2']['competitionData'][] = $competitionArray;
				break;  
				case 4:
					$industryArray = getIndustryClass(4);
					$competitionIndustryData['3']['borderClass'] = $industryArray['6pxborderClass'];
					$competitionIndustryData['3']['buttonClass'] = $industryArray['commonBigButton'];
					$competitionIndustryData['3']['fontColorClass'] = $industryArray['fontColorClass'];
					$competitionIndustryData['3']['showHeading'] = $industryArray['showHeading'];
					$competitionIndustryData['3']['industryId'] = $industryArray['industryId'];
					$competitionIndustryData['3']['competitionData'][] = $competitionArray;
				break; 
				case 5:
					$industryArray = getIndustryClass(5);
					$competitionIndustryData['4']['borderClass'] = $industryArray['6pxborderClass'];
					$competitionIndustryData['4']['buttonClass'] = $industryArray['commonBigButton'];
					$competitionIndustryData['4']['fontColorClass'] = $industryArray['fontColorClass'];
					$competitionIndustryData['4']['showHeading'] = $industryArray['showHeading'];
					$competitionIndustryData['4']['industryId'] = $industryArray['industryId'];
					$competitionIndustryData['4']['competitionData'][] = $competitionArray;			 
				break; 
				default:
					$competitionIndustryData = '';
				break; 
			}
		}
	
	}

	//**********make data array industry wise end*********//
	
	//**********array sort in assending order**********//
	$competitionIndustryData = asort2ascending($competitionIndustryData,'',false);
	
	/*echo "<pre>";
	print_r($competitionIndustryData);die();*/
	
	//**********display all industry slider data one by one********//
        
    if(!empty($competitionIndustryData) && is_array($competitionIndustryData)){    
        
      foreach($competitionIndustryData as $competitionData){
		  
		?>
			<div class="clear"></div>
			<div class="row">
				<div class="font_helveticaLight  font_size40  <?php echo  $competitionData['fontColorClass']  ?> pl50 lineH_30"><?php echo  $competitionData['showHeading']  ?><span class="display_inline clr_565656"> COMPETITIONS</span>
				</div>
			<div class="seprator_15"></div>
				<?php  
					//loading slider 
					$data['competitionData'] = $competitionData;
					
					if(!$isCompetitionList){
						$data['totalDivShow'] = '3';
						$data['isCompetitionList'] = false;
						echo $this->load->view('competition_landingpage_listing',$data,true);
					}else{
						$data['totalDivShow'] = '12';
						$data['isCompetitionList'] = true;
						echo $this->load->view('competition_landingpage_listing',$data,true);
					}	
				?>
			</div><!-- close main row -->
		  
		<?php	} 
		
		 }
       
		//**********display all industry slider data one by one********//
	    ?>   
        </div>
    </div>
	
	<script>
		function mousedown_tds_competition(obj){
			obj.style.backgroundPosition ='0px -64px';
			obj.firstChild.style.backgroundPosition ='right -64px';
			}
		function mouseup_tds_competition(obj){
			obj.style.backgroundPosition ='0px 0px';
			obj.firstChild.style.backgroundPosition ='right 0px';
		}

		function mousedown_tds_compenter(obj){
			obj.style.backgroundPosition ='0px -60px';
			obj.firstChild.style.backgroundPosition ='right -60px';
			}
		function mouseup_tds_compenter(obj){
			obj.style.backgroundPosition ='0px 0px';
			obj.firstChild.style.backgroundPosition ='right 0px';
		}
	</script>
