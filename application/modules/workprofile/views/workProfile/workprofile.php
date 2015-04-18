<div class="row form_wrapper">
	<div class="row">
		<div class="cell frm_heading">
			<h1><?php echo $label['indexPage'];?></h1>
		</div>
		<?php echo $header;?>
	</div>
<?php					
	$mediaDetail = getMediaDetail($workProfile['fileId']);
	if(is_array($mediaDetail) && !empty($mediaDetail))
	{
		$profileImgPath = $mediaDetail[0]->filePath;
		$profileImgName = $mediaDetail[0]->fileName;
	}else
	{
		$profileImgPath = '';
		$profileImgName = '';
	}

	$workProfileThumbImage = addThumbFolder(@$profileImgPath.$profileImgName,'_s');	

	$workProfileSrc = '<img src="'.getImage($workProfileThumbImage,$this->config->item('defaultWorkWanted_s')).'" />';

?>	
	
<?php echo form_open('workprofile/workProfileForm',"name='myForm'");?>
<div class="seprator_5 cell"></div>

<div class="row mr10 pb3 width420px">
	<?php 
	$location2 = $this->uri->segment(2);
	$location3 = $this->uri->segment(3);
	if($location2=='workprofile' && ($location3=='' || $location3=='workprofile')){?>
	<div class="cell ml200 mr-3 pr mt-20">
	<a href="<?php echo base_url(lang().'/workprofile/workshowcase');?>">
		<div class="wp_black_eventcircle font_opensansSBold font_size12 clr_white fl mr10 wp_orange_circle_hover">
			<div class="portfolio_index_icon mt5 ml22"></div>
			<div class="font_opensansSBold font_size13 text_alignC mt-5"><?php echo $this->lang->line('portfolioIndex');?></div>
		</div> 
	</a>
	</div>
	<?php }?>
	<div class="cell mr-3 pr mt-20">
	<a href="<?php echo base_url(lang().'/workprofile/workprofile');?>">
		<div class="wp_orange_eventcircle font_opensansSBold font_size12 clr_white fl mr10">
			<div class="profile_index_icon mt5 ml28"></div>
			 <div class="font_opensansSBold font_size13 text_alignC mt-5 ml-5"><?php echo $this->lang->line('profileIndex');?></div>
		</div> 
	</a>
	</div>
	
</div>

<div class="Fright btn_outer_wrapper mr10 pb3 width_370">
	
	<div class="tds-button fr">
		 <button type="button" onclick="showProfile();" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)" class="dash_link_hover"><span><div class="Fleft"><?php echo $this->lang->line('view');?></div> <div class="preview_button"></div></span> 
		 </button>
	</div>
	 
	<div class="tds-button fr">
     <?php $userId = isloginuser();
		 $slink=base_url(lang().'/workprofilefrontend/viewprofile');		 		
		 $this->load->view('share/share_button_wp',array('shareLink'=> $slink,'isPublished'=>'t'));		
	?> 
	</div> 
            	 
	<div class="tds-button fr mr3">
            <a href="<?php echo base_url()?>workprofile/pdf_generate" target="_blank"  onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)"><span class="pr5 dash_link_hover"><div class="Fleft font_size12 ml5"><?php echo $label['print'];?></div><div class="print_button width_32"></div></span></a></div>   
	         
	<div class="tds-button fr"> 
		<button type="submit" name="submit" value="Save" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)" class="dash_link_hover"><span><div class="Fleft"><?php echo $label['edit'];?></div> <div class="edit_button"></div> </span> 
		</button>  
	</div>		 
	 <!--<div class="tds-button fr"><button type="button" onclick="generate_pdf()"><span><div class="Fleft"><?php// echo $label['print'];?></div> <div class="icon-publish-btn"></div></span> </button> </div>-->
	  
	 <!--<div class="tds-button fr"><button type="button" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)"><span><div class="Fleft"><?php// echo $label['print'];?></div> <div class="icon-publish-btn"></div></span> </button> </div>--> 
 	 	 
</div>
<div class="row">
<div class="fr pr10 f11 mt-25"><?php echo $this->lang->line('workProfileExpireMsg'); ?></div>
</div>
<!--<div class="row seprator_6"></div>-->
 <div class="row">
	<div class="work_profile_top"></div>
	<div class="work_profile_middle">
		 <div class="profile_nameBox mr14 ml11"><?php echo $workProfile['profileFName'].'&nbsp;'.$workProfile['profileLName'];?></div>
		 <div class="profile_img"><div class="profile_img02"><?php echo $workProfileSrc;?></div></div>
		 <div class="seprator_55"></div>
		 <div class="paddingLR_29 clr_black profile_description">
			 <div class="heading02"><?php echo $label['summary'];?></div>
			 <p><?php echo $workProfile['synopsis'];?></p>			 
			
<?php if($workProfile['languagesKnown'] !='' || $workProfile['nationality'] !='' || $workProfile['visaAvailable'] !='' || $workProfile['availability']!='' || $workProfile['noticePeriod'] !='' || $workProfile['remunerationRequired']!=''){ ?>
                <div class="seprator_45"></div>
                <div class="heading02"><?php echo $label['personalDetails'];?></div>
                <div class="lineH_15">
					<?php if($workProfile['availability'] !='' ) {?>
					<div class="row">
						<span class="cell width156px  fontB"><?php echo $label['availability'];?></span>
						<span class="cell  width_478"><?php
						echo $availability=($workProfile['availability']=='freelance')?$label['freelance']:($workProfile['availability']=='fullTime'?$label['fullTime']:($workProfile['availability']=='partTime'?$label['partTime']:($workProfile['availability']=='casual'?$label['casual']:'')));
					?></span>
					</div>
					
					<?php 
					if($workProfile['minContractMonth'] !='' && $workProfile['maxContractMonth'] !='' && $workProfile['isContractWork']=='t') { ?>
						<div class="row">
							<span class="cell width156px  fontB"><?php echo $label['interestedContractWork'];?></span>
							<span class="cell  width_478"><?php echo 'From '.$workProfile['minContractMonth'] .' to '. $workProfile['maxContractMonth'] .'  months';?></span>
						</div>
					<?php }
					}
					if($workProfile['noticePeriod'] !='' ) { ?>
					<div class="row">
						<span class="cell width156px  fontB"><?php echo $label['noticePeriod'];?></span>
						<span class="cell  width_478"><?php echo $workProfile['noticePeriod'];?></span>
					</div>
					<?php } 
					if($workProfile['remunerationRequired'] !='' ) { ?>
					<div class="row">
						<span class="cell width156px  fontB"><?php echo $label['remuneration'];?></span>
						<span class="cell  width_478"><?php
							$remunerationRate = '';
									if($workProfile['remunerationRate']==1){
										$remunerationRate = 'per annum';
									}
									else if($workProfile['remunerationRate']==2){
										$remunerationRate = 'per month';
									}
									else if($workProfile['remunerationRate']==3){
										$remunerationRate = 'per week';
									}
									else if($workProfile['remunerationRate']==4){
										$remunerationRate = 'per hour';
									}
									if(isset($workProfile['remunerationRequired']) && $workProfile['remunerationRequired']!='')
										echo $workProfile['remunerationRequired'].' '.$remunerationRate;
									//else echo 'N/A';
									?>
						</span>
					</div>
					<div class="clear"></div>
					<div class="seprator_15"></div>
					<?php } 
					if($workProfile['languagesKnown'] !='' ) { ?>
					<div class="row">
						<span class="cell width156px Fleft fontB"><?php echo $label['languagesKnown'];?></span>
						<span class="cell  width_478"><?php echo $workProfile['languagesKnown'];?></span>
					</div>
					<?php } if($workProfile['nationality'] !='' ) { ?>
					<div class="row">
						<span class="cell width156px  fontB"><?php echo $label['nationality'];?></span>
						<span class="cell  width_478"><?php echo $workProfile['nationality'];?></span>
					</div>
					<?php } if(!empty($WorkProfileVisa) && is_array($WorkProfileVisa)){ ?>
					<div class="row">
						<span class="cell width156px  fontB"><?php echo $label['visaS'];?></span>
					    <span class="cell  width_478">
							<?php																			
									echo "<ul>";
										foreach($WorkProfileVisa  as $visaTypeData){
											   echo '<li>'.$visaTypeData->visaType.', '.getCountry($visaTypeData->countryId)."</li>";
										   }
									echo "</ul>";
								  ?>
						</span>	 
					</div>
					<?php } 
					if(!empty($InterestedCountry) && is_array($InterestedCountry)){ ?>	
					<div class="row">
						<span class="cell width156px  fontB"><?php echo $label['countryIntrestedwork'];?></span>
						  <span class="cell  width_478">
							<?php																			
							for($i=0;$i<count($InterestedCountry);$i++){
								if($i!=0) {
									if($i==1) {
										echo getCountry($InterestedCountry[$i]);
									} else {
										echo ', '.getCountry($InterestedCountry[$i]);
									}
								}
							}
						  ?>
						</span>	
					</div>		 
					<?php } ?>
					</div>	
				<?php } //No Personal Detail 
					if(!empty($WorkProfileEducation) && is_array($WorkProfileEducation)){ ?>			   
						<div class="clear seprator_45"></div>
					<span class="heading02"><?php echo $label['education'];?></span>
					    <span class="cell width_520"><?php 								
											echo "<ul>";
													foreach($WorkProfileEducation  as $educationData) {
														   echo '<li><span class="cell width160px  fontB PL0">'.$educationData->year_from.' - '.$educationData->year_to.'</span>';
														   echo '<span class="cell width160px">'.$educationData->degree.'</span>';
														   echo '<span class="cell width_155">'.$educationData->university."</span></li>"; 										
													 }									
											echo "</ul>";
								?>
								
						</span>
					<div class="clear"></div>
					<?php }?>
					<?php  if(!empty($workProfile['achievmentsAndAwards'])){ ?>			   
                <div class="seprator_45"></div>
               
                <div class="heading02"><?php echo $label['achievmentsAndAwards'];?></div>
                <div class="NIC">
							<p class="no_margin">
								<?php echo $workProfile['achievmentsAndAwards'];?>
							</p>
				</div><!-- End NIC -->
				<?php }?>
				<div class="clear seprator_45"></div>
		 </div><!-- End paddingLR_29 -->
		 <?php if(!empty($WorkEmpHistory)){?>
		 <div class="row ">
		 <div class="cell tab_full">
			<span class="heading03 Fleft">
				<?php echo $label['employmentHistory'];?>
			</span><!-- heading03 -->
		
		
			<div class="tab_btn_wrapper">			
				<div class="tds-button-top" >
					<a  class="formTip" >					
						<span><div class="projectToggleIcon" id="empHisToggleIcon" toggleDivId="empHis-Content-Box" ></div></span>
					</a>
				</div>
		</div>	
	</div>
	</div><!--row-->	
	
	<div class="clear"></div>
	<div id="empHis-Content-Box">	
	<div class="tab_bgshadow"></div>
	
	  <div class="clear seprator_10"></div>
                <div class="paddingLR_29 clr_black profile_description">
					<?php 
						foreach($WorkEmpHistory as $empHistory)
						{	//echo "<pre />"; print_r($WorkEmpHistory);die;?>				
					
											          <div>
														   <span class="cell width_200  fontB "> 
																<?php 
																//echo $label['from'].'&nbsp;';
																$startDate = get_timestamp("F Y",$empHistory['empStartDate']) ;
																//$startDate .=' '.$label['to'].' ';

																if($empHistory['empEndDate']=='0'){ 
																$endDate = 'Present';
																echo $startDate.' - '.$endDate;
																}else{
																echo $endDate = ' - ';	
																$endDate .= get_timestamp("F Y",$empHistory['empEndDate']);
																}
																?>                 
														    </span>
														    
														   <span class="cell  width_480 fontB lineH_15 pt2 ml6"><?php echo $empHistory['empDesignation'];?>
																   <div class="clear"> </div> 

																   <?php echo $empHistory['compName'];?>
																   <div class="clear"> </div>
																   
																  <div class="font_normal">
																	
																	<?php if(!empty($empHistory['compCity'])) {echo $empHistory['compCity'];}
																	if(!empty($empHistory['compCountry']))
																	echo $country = ', '. getCountry($empHistory['compCountry']) ;     ?>  

																  </div>
														    </span>
														      <div class="clear"></div>
														      <div class="seprator_13"> </div>
														  
														  <div class="NIC work_nic"> 

															<?php if(isset($empHistory['empAchivments']) && $empHistory['empAchivments']!=''){ ?>

															<?php echo $empHistory['empAchivments'];?>                    
															<?php } ?> 
														 </div>
											      </div>
												  
									 <div class="clear seprator_30"></div>
									 <div class="line2"></div>
								     <div class="seprator_10"></div>
                  
                <?php 	}//End foreach ?>
				</div><!-- End paddingLR_29 -->
				<div class="clear seprator_25"></div>
	</div>
	
	<?php }//End WorkEmpHistory?>
	
	 <?php if(!empty($WorkRecommendation)){?>
		 <div class="row ">
		 <div class="cell tab_full">
			<span class="heading03 Fleft">
				<?php echo $label['referencesRecommendations'];?>
			</span><!-- heading03 -->
		
		
			<div class="tab_btn_wrapper">			
				<div class="tds-button-top" >
					<a  class="formTip" >					
						<span><div class="projectToggleIcon" id="refToggleIcon" toggleDivId="ref-Content-Box" ></div></span>
					</a>
				</div>
		</div>	
	</div>
	</div><!--row-->	
	<div class="clear"></div>
	<div id="ref-Content-Box">	
		<div class="tab_bgshadow"></div>
		<div class="clear seprator_10"></div>
		<div class="paddingLR_29 clr_black profile_description">
			<?php 
				foreach($WorkRecommendation as $referenceRecommendation)
				{ ?>
				
					<div> 
						<span class="cell width_165 mr10 fontB">
							<?php echo $referenceRecommendation['refFName'].' '.$referenceRecommendation['refLName'];?>
						</span> 
						<span class="cell width281px mr10">
							<?php echo $referenceRecommendation['refCompName'];?>
						</span> 
						<span class="cell width150px mr10">
							<?php echo $referenceRecommendation['refEmail'];?>
						</span> 
						<span class="cell width110px">
							<?php echo ($referenceRecommendation['refContact']!=''? '+'.$referenceRecommendation['refContact']: '');?>
						</span>
						<span class="clear seprator_15"></span> 
						
					</div>
			<?php 	}//End foreach ?>
		</div><!-- End paddingLR_29 -->
	</div>
	<?php }//End WorkRecommendation?>
	 <?php if(!empty($WorkSocialMedia)){?>
		 <div class="row ">
				<div class="cell tab_full">
					<span class="heading03 Fleft">
						 <?php echo $label['socialMediaLinks'];?>
					</span><!-- heading03 -->		
			
				<div class="tab_btn_wrapper">			
					<div class="tds-button-top" >
						<a  class="formTip" >					
							<span>
								<div class="projectToggleIcon" id="socialMediaToggleIcon" toggleDivId="socialMedia-Content-Box" ></div>
							</span>
						</a>
				   </div>
			</div>	
		</div>
	</div><!--row-->	
	<div class="clear"></div>
	<div id="socialMedia-Content-Box">	
		<div class="tab_bgshadow"></div>
		<div class="clear seprator_10"></div>
		<div class="paddingLR_29 clr_black profile_description">
			<?php 
				foreach($WorkSocialMedia as $socialMedia)
				{ ?>			
					 <div class="lineH_32"> <span class="cell width_286 b"><?php $URL = $socialMedia['socialLink'];
											if(strpos($URL, "http://") !== false){
													 echo getSubString($URL,45);
												}else {
													$URL = "http://$URL";
													
													echo getSubString($URL,45);
												}
										?></span>
										
										<?php
										$linkClass ='';
											if($socialMedia['profileSocialMediaName']!='')
												{
													$linkClass = strtolower(str_replace(' ','_',$socialMedia['profileSocialMediaName']));					 
												}  ?>
										
										 <span class="cell <?php echo $linkClass ?> mt7">
											
										 </span>
						
						<div class="clear seprator_5"></div>
					  </div>				
			
			<?php 	}//End foreach ?>
		</div><!-- End paddingLR_29 -->
	</div>
	<?php }//End WorkRecommendation?>
	</div><!-- End work_profile_middle -->
	<div class="work_profile_bottom"></div>
 </div><!-- End Row -->
    <div class="row seprator_1"> </div>
         
<!--<div class="fl mt-12">
	<?php
	/*How to publish popup*/
		//$this->load->view('common/howToPublish',array('industryType'=>'workprofile'));
	/*End How to publish popup */
	?>
</div>-->

<div class="Fright btn_outer_wrapper mr10 pb3 width_370 cell">
	<?php 
	/* for future use */
	/*if($workProfile['isPublished']=='t') $buttonLabel = $this->lang->line('view');
	else $buttonLabel = $this->lang->line('preview');	*/	
	?>
	<div class="tds-button fr">
		 <button type="button" onclick="showProfile();" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)" class="dash_link_hover"><span><div class="Fleft"><?php echo $this->lang->line('view');?></div> <div class="preview_button"></div></span> 
		 </button>
	</div>
	 
	<div class="tds-button fr">
     <?php $userId = isloginuser();
		 $slink=base_url(lang().'/workprofilefrontend/viewprofile');		 		
		 $this->load->view('share/share_button_wp',array('shareLink'=> $slink,'isPublished'=>'t'));		
		 ?> 
	</div> 
     
     <div class="tds-button fr mr3">
            <a href="<?php echo base_url()?>workprofile/pdf_generate" target="_blank"  onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)"><span class="pr5 dash_link_hover"><div class="Fleft font_size12 ml5"><?php echo $label['print'];?></div><div class="print_button width_32"></div></span></a></div>                            
          	 
	<!--<div class="tds-button fr mr3">
		<a href="<?php //echo base_url()?>workprofile/pdf_generate" target="_blank" >
			<span class="pr5"><div class="Fleft font_size12 ml5"><?php //echo $label['print'];?></div><div class="print_button width_32"></div></span>
		</a>
	</div>-->
	    
	
	         
	<div class="tds-button fr"> 
		<button type="submit" name="submit" value="Save" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)" class="dash_link_hover"><span><div class="Fleft"><?php echo $label['edit'];?></div> <div class="edit_button"></div> </span> 
		</button>  
	</div>		 			 	 	 
</div>


<div class="row">
<div class="fr pr10 f11"> <?php echo $this->lang->line('workProfileExpireMsg'); ?></div>
</div>

<!--<div class="Fright btn_outer_wrapper mr10 width_348 pb3">
	  <div class="tds-button fr"><button type="button" onclick="showProfile();" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)"><span><div class="Fleft"><?php //echo $label['preview'];?></div> <div class="preview_button"></div></span> </button> </div>
	 
	 <div class="tds-button fr"><button type="button" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)"><span><div class="Fleft"><?php //echo $label['email'];?></div> <div class="icon-publish-btn"></div></span> </button> </div>
	 
	  <div class="tds-button fr mr3"> <a href="<?php //echo base_url()?>workprofile/pdf_generate" target="_blank" ><span><div class="Fleft"><?php //echo $label['print'];?></div> <div class="icon-publish-btn"></div> </span> </a></div>-->
	 
	 <!--<div class="tds-button fr"><button type="button" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)"><span><div class="Fleft"><?php //echo $label['print'];?></div> <div class="icon-publish-btn"></div></span> </button> </div>-->
	 
	 <!--<div class="tds-button fr"> <button type="submit" name="submit" value="Save" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)"><span><div class="Fleft"><?php //echo $label['edit'];?></div> <div class="icon-save-btn"></div> </span> </button>  </div>-->
	 
	 
	
	
	
<!--</div> LATEST COMMIT AMIT -->
<div class="seprator_5 cell"></div>
</div>

<div class="pb10">&nbsp;</div>

<script type="text/javascript">

function showProfile(){
	
	window.open("<?php echo base_url()?>workprofilefrontend/")	
  }

</script>

