<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
	
	   <div class="row ">
		   <div id="meetingPoint">
			<?php 
		
			foreach($purchasesessions as $purchaseData)
				{ 		 
					$ticketInfo = json_decode($purchaseData->ticketInfo);
					
					$sessionDay = date("D", strtotime($ticketInfo->date));
					$sessionDate = date("j", strtotime($ticketInfo->date));
					$sessionMonthYear = date("M Y", strtotime($ticketInfo->date));
					$sessionVenueName = $ticketInfo->venueName;
					$sessionAddress = $ticketInfo->address;
					list($sessionhour, $sessionmin) = explode(":", $ticketInfo->startTime);
			?>
			<div class="row blog_wrapper bg_none clr_444 border_radius boxshadow_none">
						<div class="pt10 pb5 pl15"> 
							<span class="font_opensans font_size18 width_340 Fleft"><?php echo $ticketInfo->Title; ?></span>
							<div class="clear"></div>
						</div>
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
							
							<?php 
								$session_Date = strtotime($ticketInfo->date);
								$close_Date = strtotime(date('Y-m-d 00:00:00'));
									if($session_Date >= $close_Date){
										$session_Data = array('sessionId'=>$purchaseData->sessionId,'endTime'=>$ticketInfo->endTime,'date'=>$ticketInfo->date);
										echo $this->load->view('eventfrontend/join_meeting_point',array('eventList'=>'','sessionData'=>$session_Data,'mt12'=>'ptr','isDetailVal'=>'0'));
									}
								?>
							</div>
							
							<div class="clear"></div>
							</div>
						</div>
						<?php 	echo ' </div>';	?>
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
			<?php $this->load->view('pagination',array("pagination_links"=>$pagination_links,"items_total"=>$items_total,"items_per_page"=>$items_per_page,"perPageRecord"=>$perPageRecord,"url"=>base_url(lang().'/event/purchasesessionlist/'),"divId"=>"meetingPlaceContent","formId"=>0,"unqueId"=>"full","isShowNumber"=>true,"isShowDD"=>true,"pagingWpaerClass"=>'pagination_wrapper new_page_design new_page_design',"pagingDDDClass"=>'left_site_dropdown m0 new_page_design mr20')); ?>
			<div class="clear"></div>
		</div>
	</div>
	<?php }?>
	<!-- PAGINATION END --> 

</div>
</div>
<!-- -->

<div class="clear"></div>





