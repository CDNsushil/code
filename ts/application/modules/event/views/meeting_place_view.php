<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
	<?php

	$formAttributes = array(
		'name'=>'usermeetingpoint',
		'id'=>'usermeetingpoint'
	);	
	echo form_open('',$formAttributes);
	
	$resultCount = count($meetingpoint);
	
	?>
	<input type="text" name="ajaxRequest" id="ajaxRequest" class="dn" value="1">
	<input type="text" name="count" id="count" class="dn" value="0">
	<input type="text" name="currentPage" id="currentPage" class="dn" value="1">
	<input type="text" name="records" id="records"class="dn" value="<?php echo $resultCount ?>">
	   <div class="row ">
		   <div id="meetingPoint">
					<?php 
		
		 foreach($meetingpoint as $k => $mpdetail)
		 { 		 
			$userId = $mpdetail['user_id'];
			 
			 if($mpdetail['event_id'] > 0){
					$id = $mpdetail['event_id'];
					$flag = 0;	
					$title = $mpdetail['eventtitle'];	
				if(!empty($session[$id][0])){
				if($session[$id][0][0]['NatureId']==2)
				 $gotoMP =  getFrontEndLink(9,$id);
				
				if($session[$id][0][0]['NatureId']==4)
				 $gotoMP =  getFrontEndLink(9,$id);	
			 }	
			}
			elseif($mpdetail['launch_id'] > 0){
				$id = $mpdetail['launch_id'];
				$flag = 1;
				$title = $mpdetail['launchtitle'];	
				if(!empty($session[$id][0])){
				if($session[$id][0][0]['NatureId']==3)
				 $gotoMP =  getFrontEndLink(15,$id);
				 
				if($session[$id][0][0]['NatureId']==4)
				$gotoMP =  getFrontEndLink(15,$id);
			 }
			}
			echo '<input id = "flag" name = "flag" value = "'.$flag.'" type = "hidden" />';	
			if(isset($gotoMP) && $gotoMP!='') {
				$divonClass = 'ptr';
				$divonClick = 'onclick='.'gotomeetingpoint("'.$gotoMP.'");';
			}
			else {
				$divonClass = '';
				$divonClick = '';	
			}	
		?>
		<div class="row blog_wrapper bg_none clr_444 border_radius boxshadow_none">
				<div class="sessionT_top_box pb5 global_shadow_light mt5 <?php echo $divonClass;?>"   <?php echo $divonClick;?>>
				   <div class="sessionT_heading pt4 mr8"><?php echo $this->lang->line('meetingPoint');?></div>			
						<div class="pt15 pb10"> 
							<span class="font_opensans font_size18 width_340 Fright dash_link_hover"><?php echo @$title; ?></span>
							<span class="fr mt-5 mr5"> 
								<img alt="aerow" src="<?php echo base_url();?>images/bigmpoint.png">
							</span> 
							<div class="clear"></div>
						</div>
					</div><!-- End sessionT_top_box-->
			
					<div class="seprator_20"></div>
					 <?php 					
					
					foreach($session[$id] as $k => $sessionDetail)
					{ 							
						
						foreach($sessionDetail as $k => $mp)
						{
							if($mpdetail['session_id']===$sessionDetail[$k]['sessionId'])
							{
								$sessionDay = date("D", strtotime($mp['date']));
								$sessionDate = date("j", strtotime($mp['date']));
								$sessionMonthYear = date("M Y", strtotime($mp['date']));
								$sessionVenueName = $mp['venueName'];
								$sessionAddress = $mp['address'];
								list($sessionhour, $sessionmin) = explode(":", $mp['startTime']);
								$countMeetingPoint= $this->model_common->countResult($primaryTable,$primaryKeyForTable,$mp['sessionId'],1);
								//echo 'Session Id:'.$mp['sessionId'];
								?>
								<div>
								<div class="sessionT_list font_size13 font_opensans">
								<div class="sessionT_list_top width510px">
								<div class="width_116 cell pr8 height8 "><span class="position_absolute bottom_0 ml2 font_OpenSansBold"><?php echo $sessionDay;?></span></div>
								<div class="width_216 cell pr8 font_opensans"><?php echo $sessionVenueName;?></div>
								<div class="Fright"></div>
								<div class="clear"></div>
								</div>
								<div class="sessionT_list_bottom pt3">
								<div class="width_116 cell pr8 font_arial"><span class="font_size18 bold clr_ff0000 inline ml2"><?php echo $sessionDate;?> </span><?php echo $sessionMonthYear;?><span class="font_OpenSansBold pl50"><?php echo $sessionhour.':'.$sessionmin;?></span></div>
								<div class="width_216 cell font_OpenSansBold pr8"><?php echo $sessionAddress;?></div>
								<div class="Fright mt_minus22 position_relative mr5 toggle_Ticket">
								<?php if($countMeetingPoint>0) { ?>
								<div class="tds-button mt3"> <a onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)" onclick="toggleuserlist('slider_<?php echo $mp['sessionId'];?>')"><span class="btn_meeting">
								<div class="icon-meeting-btn">&nbsp;</div>
								<div class="btn_content_wp Fleft"><?php echo $this->lang->line('meeting')?><br>
								<?php echo $this->lang->line('point')?></div>
								<div class="meetbtn220"><?php echo $countMeetingPoint;?></div>
								</span></a> </div>
								</div>
								<?php } else { ?>
								<div class="tds-button mt3"> <a onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)" ><span class="btn_meeting">
								<div class="icon-meeting-btn">&nbsp;</div>
								<div class="btn_content_wp Fleft"><?php echo $this->lang->line('meeting')?><br>
								<?php echo $this->lang->line('point')?></div>
								<div class="meetbtn220"><?php echo $countMeetingPoint;?></div>
								</span></a> </div>
								</div>
								<?php } ?>

								<div class="clear"></div>
								</div>
								</div>
								<?php 
								if($countMeetingPoint>0)
								{
									$meetingPointUsers = getMeetingPointUserId($mp['sessionId'],$userId);
									$totalusers = count($meetingPointUsers);
									if($totalusers>0)
									{
										if($totalusers>4) {
											echo '<div class="meetingslider meetingslider_2 global_shadow_medium dn" id="slider_'.$mp['sessionId'].'"> <a href="#" class="buttons prev disable"></a>';                							
											$heightLi = '475px';//if slider then height
											$heightOverview = '';//if slider then height <ul class="overview"						
										}
										else {
											$mainDivHeight = (85*$totalusers).'px'; //if no slider then height	
											$heightLi = (105*$totalusers).'px'; //if no slider then height	
											$heightOverview = (105*$totalusers).'px'; //if no slider then height <ul class="overview"
											echo '<div class="meetingnoslider global_shadow_medium dn" id="slider_'.$mp['sessionId'].'" style="height:'.$mainDivHeight.'">';						
										}
										?>
										<div class="viewport scroll_container01_2" style="height:<?php echo $heightOverview;?>;">
											<ul class="overview pr pl0" style="height:<?php echo $heightLi;?>; top: 0px;">
											<?php
											 
											foreach($meetingPointUsers as $k => $meetingPointUser)
											{ 				
												
												//-----------user details --------//
												$userImage=$meetingPointUser['userImage'];
												$creative=$meetingPointUser['creative'];
												$associatedProfessional=$meetingPointUser['associatedProfessional'];
												$enterprise=$meetingPointUser['enterprise'];
												
												// get enterprise name
												if($enterprise=="t")
												{
													$userFullName= $meetingPointUser['enterpriseName'];
												}else
												{
													$userFullName= $meetingPointUser['userFullName'];
												}
												
												// get user profile image
												$userDefaultImage=($creative=='t')?$this->config->item('defaultCreativeImg'):(($associatedProfessional=='t')?$this->config->item('defaultAssProfImg'):(($enterprise=='t')?$this->config->item('defaultEnterpriseImg'):''));
						
												if(!isset($userDefaultImage) || $userDefaultImage=='') $userDefaultImage=$this->config->item('defaultMemberImg_m'); 
												
												if($meetingPointUser['userImage']!='') {
													$userImage="media/".$meetingPointUser['username']."/profile_image/".$meetingPointUser['userImage'];
												}
												
												
												 //echo $userImage; 
												$userImage=addThumbFolder($userImage,$suffix='_xxs',$thumbFolder ='thumb',$userDefaultImage);  	
												$userImage=getImage($userImage,$userDefaultImage);
											
											
												$gotoUserShowcase = base_url('showcase/index/'.@$meetingPointUser['user_id']);
											
												
												
												?>
												<li>
												<div class="darkGrey_bg ml6 mr6 width542 bg_dropshedow" >
												<div class="cell mt6 mb6 ml18 mr18 width_63 height_68 ptr" onclick="gortoUserShowcase('<?php echo $gotoUserShowcase;?>');">
												<div class="AI_table">
													<div class="AI_cell"> <img class="bdr_white max_w63_h68" src="<?php echo $userImage;?>"> </div>
												</div>
												</div>
												<div class="width416 Fleft min_h60 sessionT_top_box mt5 mb5 clr_444">
													<div class="Fright mt_minus_2 mr-3">
														<?php
														$currentStatus = $meetingPointUser['is_at_meeting_place']=='t'?'checked':'';
														$changeStatus = $meetingPointUser['is_at_meeting_place']=='t'?'':'checked';

														$isAtMeetingPlaceButton = array('currentStatus'=>$currentStatus,'changeStatus'=>$changeStatus,'is_at_meeting_place'=>$meetingPointUser['is_at_meeting_place'],'tabelName'=>'MeetingPoint','pulishField'=>'is_at_meeting_place','field'=>'id','fieldValue'=>@$meetingPointUser['id'], 'view'=>'isAtMeetingPlace');
														//echo '<pre />';print_r($isAtMeetingPlaceButton);die;
														echo Modules::run("common/formInputField",$isAtMeetingPlaceButton);
														?>
													</div>
												<div class="sessionT_heading pt4 lH11 width_366 ml5 font_opensansSBold font_size14 ptr" onclick="gortoUserShowcase('<?php echo $gotoUserShowcase;?>');"><?php echo $userFullName;?></div>
												<span class="Fleft width_366 ml5 mt5 font_opensans"><?php echo $meetingPointUser['userArea']; ?></span> </div>
												<div class="clear"></div>
												<!-- /row -->
												</div>
												</li>
											<?php 
											} //end foreach($meetingPointUsers as $k => $meetingPointUser)
											?>
											</ul>
										</div>
										<a href="#" class="buttons next"></a> 
										</div>					 			
									<?php } //if($totalusers>0) ?>

									<script>
									$(document).ready(function(){
									$('#slider_<?php echo $mp['sessionId'];?>').tinycarousel({ axis: 'y', display: 4}); 
									});
									</script>
								<?php 
								} //if($countMeetingPoint>0)
								echo ' </div>';					  
							}//End if($mpdetail['session_id']===$sessionDetail[$k]['sessionId'])
						} //End foreach($session[$id] as $k => $sessionDetail) 
						
					} //End foreach($session[$id] as $k => $sessionDetail) 
			?>
			</div><!-- row blog_wrapper -->
			<div class="clear mt5"></div>	
<?php
} //End foreach($meetingpoint as $k => $mp) 
?>

	<!-- PAGINATION --> 
	<?php
		if(isset($items_total)  && isset($items_per_page) && $items_total >  $items_per_page){?> 
	<div class="row mt10">
		<div class="cell width_200 Cat_wrapper">&nbsp;</div>
		<div class="cell width_569 margin_left_16 pagingWrapper">
			<?php $this->load->view('pagination',array("pagination_links"=>$pagination_links,"items_total"=>$items_total,"items_per_page"=>$items_per_page,"perPageRecord"=>$perPageRecord,"url"=>base_url(lang().'/event/usermeetingpoint/'.$entityId),"divId"=>"meetingPlaceContent","formId"=>0,"unqueId"=>"full","isShowNumber"=>true,"isShowDD"=>true,"pagingWpaerClass"=>'pagination_wrapper new_page_design new_page_design',"pagingDDDClass"=>'left_site_dropdown m0 new_page_design mr20')); ?>
			<div class="clear"></div>
		</div>
	</div>
	<?php }?>
	<!-- PAGINATION END --> 

</div>
</div>
<!-- -->
<?php echo form_close();?> 	
<div class="clear"></div>


