<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$notificationFlag=false;

if($eventList && is_array($eventList) && count($eventList) > 0){
	$countResult=count($eventList);
	$currentDateTime= currntDateTime('y-m-d');
	
	
	
	foreach($eventList as $k=>$event){
	 
	 $cacheFile='cache/event/eventnotification_User_'.$userId.'_event_'.$event['EventId'].'.php';
	 $notificationFlag=true;
	
	  $StartDate=$event['StartDate'];
	  $FinishDate=$event['FinishDate'];
	  
		  $EventTypeImage=($event['EventType']==2)?'launch_ntag.png':'event_ntag.png';
		  $type=($event['Type']==2)?$this->lang->line('online'):$this->lang->line('live');
		  $genre=($event['Genre']==2)?$this->lang->line('educational'):$this->lang->line('entertainment');
		  $EventTypeImage=getImage('images/frontend/'.$EventTypeImage);
		  
		  
		  $isSameDate=(dateFormatView($StartDate,'y-m-d')==dateFormatView($FinishDate,'y-m-d'))?true:false;
		  
		  $StartWD=dateFormatView($StartDate,'D');
		  $StartD=dateFormatView($StartDate,'d');
		  $StartM=dateFormatView($StartDate,'F');
		  $StartY=dateFormatView($StartDate,'Y');
		  
		  if(strlen($FinishDate) > 6 && !$isSameDate ){
			  $FinishWD=dateFormatView($FinishDate,'D');
			  $FinishD=dateFormatView($FinishDate,'d');
			  $FinishM=dateFormatView($FinishDate,'F');
			  $FinishY=dateFormatView($FinishDate,'Y');
		  }else{
			  $isSameDate=true;
		  }
		  
		  $eventImage=$event['filePath'].$event['fileName'];
		  $eventImage=addThumbFolder($eventImage,$suffix='_s',$thumbFolder ='thumb',$defaultThumb='images/default_thumb/events_s.jpg');
		  $eventImage=getImage($eventImage);
		  
		  
		  
		 
		$craveCount=$event['craveCount']>0?$event['craveCount']:0;
		$viewCount=$event['viewCount']>0?$event['viewCount']:0;
		$ratingAvg=$event['ratingAvg']>0?$event['ratingAvg']:0;
		$reviewCount=$event['reviewCount']>0?$event['reviewCount']:0;
		
		 $ratingAvg=roundRatingValue($ratingAvg);
		 $ratingImg=base_url('images/rating/rating_0'.$ratingAvg.'.png');
		 ?>
		  <div class="all_list_item">
			  <div class="eventN_box_shadow bdr_a8a6a6 darkGrey_bg">
				<div class="seprator_10"></div>
				<div class="eventN_box clr_white">
				  <!--transperant box-->
				  <div class="eventN_detail_main">
					<div class="seprator_10"></div>
					<div class="eventN_title"><?php echo $event['Title'];?></div>
					<div class="seprator_20"></div>
					<div class="eventN_thumbnail Fleft">
					  <div class="AI_table">
						<div class="AI_cell"> <img src="<?php echo $eventImage;?>" class="bdr10_555555 max_w115_h184"></div>
					  </div>
					 <div class="row font_opensansSBold lang_shadow grey mt-9"><?php echo $event['Language_local'];?></div>	
					</div>
					<div class="font_opensans font_size13 clr_white Fright width_206 min_h60"><?php echo nl2br($event['OneLineDescription']);?></div>
					<div class="clear seprator_13"></div>
				  </div>
				  <!--date-->
				  <div class="seprator_15"></div>
				  <div class="eventN_side_cat Fright mr7"><div class="AI_table"><div class="AI_cell"><img src="<?php echo $EventTypeImage; ?>" /></div></div></div>
				  <?php
					if(!$isSameDate){
					  ?>
					<div class="eventN_Date Fright mr14"><span class="Eday"><?php echo $FinishWD;?> </span><span class="Edate pt5"><?php echo $FinishD;?></span><span class="Emyear"><?php echo $FinishM;?><br /><?php echo $FinishY;?></span></div>
					<div class="eventN_Date_seprator Fright mr18 mt35"><img src="<?php echo base_url('images/frontend/date_seprator.png');?>" /></div>
					<?php
					}
				  ?>
					  <div class="eventN_Date Fright mr10"><span class="Eday"><?php echo $StartWD;?> </span><span class="Edate pt5"><?php echo $StartD;?></span><span class="Emyear"><?php echo $StartM;?><br /><?php echo $StartY;?></span></div>
					  
				  <div class="clear seprator_16"></div>
				 <div class="eventN_title2_box_main ml24 mr8">
					<div class="eventN_title2_box Fleft">
						<div class="seprator_7"></div>
						<?php if(isset($event['VenueName']) && $event['VenueName']!=''){ ?>
						<span class="eventN_title2 pr6 width420px"><?php echo $event['VenueName'];?></span> 
						<?php } 
						if((isset($event['City']) && $event['City']!='') || (isset($event['countryName']) && $event['countryName']!='')){ 
						?>
						<span class="font_OpenSansBold font_size24 lineH27">
							<?php if(isset($event['City']) && $event['City']!=''){ ?>
							<span class="clr_ff0000 inline"><?php echo $event['City'];?></span> 
							<?php } 
							if(isset($event['countryName']) && $event['countryName']!='') {
							?>
							<span class="clr_b8b8b8 inline"><?php echo $event['countryName'];?></span>
							<?php } ?>
						</span> 
						<?php } ?>
					</div>
					<div class="eventN_cat mt10 mr8"><?php echo $event['IndustryName'];?></div>
					<div class="clear"></div>


					<div class="eventN_mobile Fleft mr10"><?php echo $event['VenuePhone'];?></div>
					<div class="text_alignR font_opensans  mb3 Fright">
						<?php if(!empty($event['URL'])){
							if(strstr($event['URL'], 'http:')){
								echo '<a target="_blank" href="'.$event['URL'].'" clss="clr_white">'.$event['URL'].'</a>';
							}else{
								echo '<a target="_blank" href="http://'.$event['URL'].'" clss="clr_white">'.$event['URL'].'</a>';
							}
						}?>
					</div>
					<div class="clear"></div>
				</div> 				
				<div class="clear seprator_3"></div>
				</div>
				<div class="seprator_3"></div>
				<div class="eventN_action_box font_size11 clr_white">
				  
				   <?php
						$venueOrgniserDetails=array(
													'venueOrgniserClass'=>'width_135 clr_ccc pt2 pl10 pb5',
													'id'=>$event['EventId'],
													'venueName'=>htmlentities($event['VenueName']),
													'venueaddress'=>htmlentities($event['Address']),
													'venueaddress2'=>htmlentities($event['Address2']),
													'venuecountryName'=>htmlentities($event['countryName']),
													'venuestate'=>htmlentities($event['State']),
													'venuecity'=>htmlentities($event['City']),
													'venuezip'=>htmlentities($event['Zip']),
													'venueEmail'=>htmlentities($event['VenueEmail']),
													'venueurl'=>htmlentities($event['URL']),
													'venuephoneNumber'=>htmlentities($event['VenuePhone']),
													
													'OrgName'=>htmlentities($event['OrgName']),
													'OrgAddress'=>htmlentities($event['OrgAddress']),
													'OrgAddress2'=>htmlentities($event['OrgAddress2']),
													'OrgCity'=>htmlentities($event['OrgCity']),
													'OrgState'=>htmlentities( $event['OrgState']),
													'OrgZip'=>htmlentities( $event['OrgZip']),
													'OrgURL'=>htmlentities( $event['OrgURL']),
													'OrgPhone'=>htmlentities( $event['OrgPhone']),
													'OrgEmail'=>htmlentities( $event['OrgEmail']),
													'OrgCountry'=>htmlentities( $event['orgniserCountry'])
													);
						$this->load->view('orgniser_venue_view',array('venueOrgniserDetails'=>$venueOrgniserDetails));
					  ?>
				  <ul class="width_152 mt_minus_2">
					<li>
					<?php
							$loggedUserId=isloginUser();
							if($loggedUserId > 0){
								$where=array(
									'tdsUid'=>$loggedUserId,
									'entityId'=>$entityId,
									'elementId'=>$event['EventId']
								);
								$countResult=countResult('LogCrave',$where);
								$cravedALL=($countResult>0)?'cravedALL':'';
							}else{
								$cravedALL='';
							}
					  ?>
					  <div class="cell">
						<div class="icon_crave4_blog height_24 lineH27 craveDiv<?php echo $entityId.''.$event['EventId'].' '.$cravedALL;?>"> Craves <span class="inline ml5"><?php echo $craveCount; ?></span></div>
					  </div>
					  <div class="cell pt5 width_auto pl6 mt5 rateDiv<?php echo $entityId.''.$event['EventId']?>" >
						<img src="<?php echo $ratingImg; ?>" />
					  </div>
					  <div class="clear"></div>
					</li>
					<li>
					  <div class="width_90 ">
						<div class="icon_view3_blog float_none height_21 lineH27"> Views <span class="inline ml5"><?php echo $viewCount; ?></span></div>
					  </div>
					</li>
				  </ul>
				  <ul class="eventN_cat2 font_size12 pt2 pb5 pr10 Fright text_alignR ">
					<li > <?php echo $type.' '.$genre;?></li>
					<li  class="clr_d6d3d3 pt3 height_18 oh width150px"><?php echo $event['OtherGenre'];?></li>
				  </ul>
				  <div class="clear"></div>
				</div>
				<div class="pt10">
				  <div class="line8 ml9 mr9"></div>
				  <div class="pt7 pb10 ml5">
					<div class="row">
					  
					  <div class="fl blog_links_wrapper pt0">
						<?php	
							//$url = base_url().uri_string();
							$currentUrl = base_url().uri_string();
							$moduleMathod = (isset($moduleMathod) && ($moduleMathod!=''))?$moduleMathod:'';
																	
							$relation = array('getFrontShortLink', 'email','share','entityTitle'=> $event['Title'], 'shareType'=>'performancesevents', 'shareLink'=> $currentUrl,'id'=> 'Project'.$event['EventId'],'entityId'=>$entityId,'elementid'=>$event['EventId'],'projectType'=>'performancesevents','isPublished'=>$event['isPublished'],'viewType'=>'showcase','isPreviewMethod'=>$moduleMathod);
							$this->load->view('common/relation_to_share',array('relation'=>$relation));
						?>							  
					 </div>  
					 
					  <?php $this->load->view('craves/craveView',array('craveClass'=>'tds-button_crave cell mr6','elementId'=>$event['EventId'],'entityId'=>$entityId,'ownerId'=>$event['tdsUid'],'isPublished'=>$event['isPublished'],'isPreviewMethod'=>$moduleMathod,'projectType'=>'performancesevents','furteherDetails'=>'{"projectId":"'.$event['EventId'].'","table":"Events","primeryField":"EventId","fieldSet":"EventId as id,fileName as craveImage, Title as craveTitle, OneLineDescription as craveShortDescription, Tagwords as tagwords","cacheFilePath":"'.$cacheFile.'"}'));?>
					  <?php $this->load->view('rating/ratingView',array('elementId'=>$event['EventId'],'entityId'=>$entityId,'ratingAvg'=>$ratingAvg,'ratingClass'=>'tds-button_rate cell','isPublished'=>$event['isPublished'],'isPreviewMethod'=>$moduleMathod));?>
					  <div class="clear"></div>
					</div>
				  </div>
				</div>
			  </div>
			  <div class="seprator_10"></div>
		  </div>
		<?php
}

	if(isset($items_total) && isset($perPageRecord) && ($items_total >  $perPageRecord)){
		?>
		 <div class="row pt3">
				<?php $this->load->view('pagination',array("pagination_links"=>$pagination_links,"items_total"=>$items_total,"items_per_page"=>$items_per_page,"perPageRecord"=>$perPageRecord,"url"=>$pagingLink,"divId"=>"elementListingAjaxDiv","formId"=>0,"unqueId"=>"full","isShowNumber"=>true,"isShowDD"=>true,"pagingWpaerClass"=>'pagination_wrapper new_page_design new_page_design',"pagingDDDClass"=>'left_site_dropdown m0 new_page_design new_page_design')); ?>
			<div class="clear"></div>
			<div class="seprator_10"></div>
		</div>
		
		<?php
	}
}
if(!$notificationFlag){
	echo $this->lang->line('noRecord');  
}
?>
<!-- ADS FOR CONTENT -->

<!-- Div for 468x60 advert display -->
<div class="row width470px ma mt10" id="advert468_60"><?php 
	if(is_dir(APPPATH.'modules/advertising') && !empty($advertSectionId)){
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
</div>
<div class="clear"></div>	  
<div class="seprator_10"></div>  
