<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
  if($eventList && is_array($eventList) && count($eventList) > 0){
	  $countResult=count($eventList);
	  $event=$eventList[0];
	  $OrgURL = @$event['OrgURL'];
	  $OrgPhone = @$event['OrgPhone'];
	  $type=($event['Type']==2)?$this->lang->line('online'):$this->lang->line('live');
	  $genre=($event['Genre']==2)?$this->lang->line('educational'):$this->lang->line('entertainment');
	  
	 // $LaunchDate=$event['LaunchDate'];
	  $LaunchDate=$event['date'];
	  
	  $LaunchWD=dateFormatView($LaunchDate,'D');
	  $LaunchD=dateFormatView($LaunchDate,'d');
	  $LaunchM=dateFormatView($LaunchDate,'F');
	  $LaunchY=dateFormatView($LaunchDate,'Y');
	  
	  $craveCount=$viewCount=$ratingAvg=$reviewCount=0;
	 
	  if($logSummryDta && is_array($logSummryDta) && count($logSummryDta) > 0){
			$log =$logSummryDta[0];
			$craveCount=$log->craveCount>0?$log->craveCount:0;
			$viewCount=$log->viewCount>0?$log->viewCount:0;
			$ratingAvg=$log->ratingAvg>0?$log->ratingAvg:0;
			$reviewCount=$log->reviewCount>0?$log->reviewCount:0;
	  }
	 
	 $ratingAvg=roundRatingValue($ratingAvg);
	 $ratingImg=base_url('images/rating/rating_0'.$ratingAvg.'.png');
	 
	$eventImage=$event['filePath'].$event['fileName'];
	
	//----------make element default launch image code start---------//
	if(!empty($eventImage) && file_exists($eventImage)) {
		$eventImage=addThumbFolder($eventImage,'_s');
		$eventImage=getImage($eventImage,$this->config->item('defaultEventImg_s'));
	} else {
		$getPojrectImage = getEventsPrimaryImage($event['LaunchEventId'],'.launchEventId');
		if($getPojrectImage){
			$eventImage = $getPojrectImage;
		}else{
			$eventImage=addThumbFolder($eventImage,'_s');				
		}
		$eventImage = getImage(@$eventImage,$this->config->item('defaultEventImg_s'));
	}
	//----------make element default launch image code start---------//
	
	$startTime=strlen($event['startTime'])>4?$event['startTime']:'00:00';
	$startTime=substr($startTime, 0, 5);
	//$startTime=str_replace(':','h',$startTime);
	$endTime=strlen($event['endTime'])>4?$event['endTime']:'24:00';
	$endTime=substr($endTime, 0, 5);
	//$endTime=str_replace(':','h',$endTime);
	$posterImage=$event['posterImage'];
	//Set Css for poster image if exists 
	if(!empty($posterImage) && file_exists($posterImage)) {
		$posterUrl = site_url().$posterImage;
	}else{
		$posterUrl = site_url().'images/lunch_reggreenstrip_bg.jpg';	
	}?>
	
	<div class="eventN_box_shadow bdr_a8a6a6 darkGrey_bg">
		<div class="seprator_10"></div>
		
		<div class="eventL_box clr_white bg_595959 position_relative bdr_non minh641"> 
			<img src="<?php echo $posterUrl;?>"  alt="launchesbg" class="position_absolute width_height_100_percent">
            <div class=" position_relative zindex_999 launches_titlebg mt1 top2">
				<img src="<?php echo base_url()?>images/launch_images/general/launch_trans.png">
			</div>
			<div class="clear"></div>
			<div class="seprator_25"></div>
			<div class="eventL_thumbnail Fright position_relative zindex_999">
				<div class="AI_table">
					<div class="AI_cell"><img class="bg_eventLtrans max_w237_h158" src="<?php echo $eventImage;?>"></div>
				</div>
				<div class="row font_opensansSBold lang_shadow tar pr70 mt5 ">
					<span class="clr_909090"><?php echo $event['Language_local'];?></span>
				</div>	
            </div>
            <div class="clear"></div>
            <div class="eventL_detail_main_newbdr ml1 mr1">
				<div class="position_relative eventL_detail_main_new">
					<div class="eventL_Date pl20 pt10 Fleft"><span class="Eday"><?php echo $LaunchWD;?></span><span class="Edate pt5"><?php echo $LaunchD;?></span><span class="Emyear"><?php echo $LaunchM;?><br>
                  <?php echo $LaunchY;?></span></div>
					 <div class="eventL_title Fright clr_ff0000 min_h56"><span class="clr_white"><?php echo $event['Title'];?></span></div>
					<div class="clear"></div>
					<div class="Fleft eventL_time ml34 mt_minus11"><span><?php echo $startTime;?> </span> <?php if($endTime!='00:00'){ ?><span class="text_alignR ml28">- <?php echo $endTime;?></span><?php } ?></div>
					<div class="clear"></div>
					<div class="mr11 ml20 text_shadow text_alignR mt-5 overflow_hidden height38 pr7 whitespace_now fr width_405">
						<span class="font_OpenSansBold font_size24 lineH27"><span class="clr_ff0000 inline"><?php echo $event['city'];?></span>
						<span class="clr_909090 inline"><?php echo $event['countryName'];?></span></span>
					</div>
					<div class="clear"></div>
					<div class="eventL_title2 ml20 mr11 height_21 lineH14 height_21 overflow_hidden whitespace_now">
						<?php echo $event['venueName'];?>
					</div>
					<div class="seprator_20"></div>
					<div class="row PE_industry_bg font_opensansSBold mt-4"><?php echo $event['IndustryName'];?></div>
					<div class="seprator_20"></div>
					<div class="font_opensans font_size13 ml20 mr11 height_90 overflow_hidden">
						<?php echo nl2br($event['OneLineDescription']);?>
					</div>
					<div class="seprator_20"></div>
					<?php if(!empty($event['OrgPhone'])){?>
						<div class="eventL_mobile Fleft ml20 clr_white"><?php echo $event['OrgPhone'];?></div>
					<?php }?>
					<?php if(!empty($event['OrgURL'])){?>
						<div class=" text_alignR font_opensans mr10 mb3 Fright">
							<?php 
							if(strstr($event['OrgURL'], 'http:')){
								echo '<a target="_blank" href="'.$event['OrgURL'].'" class="clr_white">'.$event['OrgURL'].'</a>';
							}else{
								echo '<a target="_blank" href="http://'.$event['OrgURL'].'" class="clr_white">'.$event['OrgURL'].'</a>';
							}
							?>
						</div>
					<?php }?>
					<div class="clear"></div>
					<div class="seprator_5"></div>
				</div>
				<div class="clear"></div>
            </div>
        </div>
		
		<div class="seprator_16 eventL_below_boxshadow"></div>
		<div class="eventN_action_box font_size11 clr_white">
		  <ul>
			<li class="mt5">
			  <?php
				$sectionHeading=$this->lang->line('performances').'&nbsp;'.$this->lang->line('&').'&nbsp;'.$this->lang->line('events');
				$this->load->view('media/reviewView',array('elementId'=>$event['LaunchEventId'],'projectId'=>$event['LaunchEventId'],'entityId'=>$entityId,'projName'=>$event['Title'],'section' =>$sectionHeading,'industryId' =>$event['Industry'],'reviewClass'=>'tds-button01 cell Fright','reviewFrom'=>'P&E','isPublished'=>$event['isPublished']));
			  ?>
			</li>
		  </ul>		  
		  <?php
				$venueOrgniserDetails=array(
										'venueOrgniserClass'=>'width_98 clr_ccc pt2 pl6 pb5 eventL_actionseprator',
										'id'=>$event['LaunchEventId'],
										'venueaddress'=>htmlentities($event['address']),
										'venueaddress2'=>htmlentities($event['address2']),
										'venuecountryName'=>htmlentities($event['countryName']),
										'venuestate'=>htmlentities($event['state']),
										'venuecity'=>htmlentities($event['city']),
										'venuezip'=>htmlentities($event['zip']),
										'venueEmail'=>htmlentities($event['venueEmail']),
										'venueName'=>htmlentities($event['venueName']),
										'venueurl'=>htmlentities($event['url']),
										'venuephoneNumber'=>htmlentities($event['phoneNumber']),
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
		  <ul class="width_142 mt_minus_2 eventL_actionseprator pl5">
			<li>
				<?php
						$loggedUserId=isloginUser();
						if($loggedUserId > 0){
							$where=array(
								'tdsUid'=>$loggedUserId,
								'entityId'=>$entityId,
								'elementId'=>$event['LaunchEventId']
							);
							$countResult=countResult('LogCrave',$where);
							$cravedALL=($countResult>0)?'cravedALL':'';
						}else{
							$cravedALL='';
						}
				?>
			  <div class="cell">
				<div class="icon_crave4_blog height_24 lineH27 craveDiv<?php echo $entityId.''.$event['LaunchEventId'].' '.$cravedALL;?>"> Craves <span class="inline ml5"><?php echo $craveCount; ?></span></div>
			  </div>
			  <div class="cell pt5 width_auto pl6 mt5 rateDiv<?php echo $entityId.''.$event['LaunchEventId']?>" >
					<img src="<?php echo $ratingImg; ?>" />
			  </div>
			  
			  <div class="clear"></div>
			</li>
			<li>
			  <div class="width_90 ">
				<div class="icon_view3_blog float_none height_21 lineH27"> Views <span class="inline ml5"><?php echo $viewCount; ?></span></div>
			  </div>
			</li>
		  </ul><ul class="eventN_cat2 font_size12 pt2 pb5 pl4 pr6 Fright text_alignR ">
			<li><?php echo $type.' '.$genre;?> </li>
			<li class="clr_d6d3d3 pt3 height_18 oh width150px"><?php echo $event['OtherGenre'];?></li>
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
					$relation = array('getFrontShortLink', 'email','share','entityTitle'=> $event['Title'], 'shareType'=>'performancesevents', 'shareLink'=> $currentUrl,'id'=> 'Project'.$event['EventId'],'entityId'=>$entityId,'elementid'=>$event['EventId'],'projectType'=>'performancesevents','isPublished'=>$event['isPublished'],'viewType'=>'showcase');
					$this->load->view('common/relation_to_share',array('relation'=>$relation));
				?>							  
				</div>  			  
				<?php $this->load->view('craves/craveView',array('craveClass'=>'tds-button_crave cell mr6','elementId'=>$event['LaunchEventId'],'entityId'=>$entityId,'isPublished'=>$event['isPublished'],'ownerId'=>$event['tdsUid'],'projectType'=>'performancesevents','furteherDetails'=>'{"projectId":"'.$event['LaunchEventId'].'","table":"LaunchEvent","primeryField":"LaunchEventId","fieldSet":"LaunchEventId as id, Title as craveTitle, OneLineDescription as craveShortDescription, Tagwords as tagwords","cacheFilePath":"'.$cacheFile.'"}'));?>
				<?php $this->load->view('rating/ratingView',array('elementId'=>$event['LaunchEventId'],'entityId'=>$entityId,'ratingAvg'=>$ratingAvg,'ratingClass'=>'tds-button_rate cell','isPublished'=>$event['isPublished']));?>
			  <div class="clear"></div>
			</div>
		  </div>
		</div>
	  </div>
	  <!-- ADS FOR CONTENT -->
	<!-- Div for 468x60 advert display -->
	<div class="width470px ma mt20" id="advert468_60"><?php 
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
	  <?php  
	  $launchExpiryDate = date('Y-m-d',(strtotime($event['LaunchEventCreated'])+(60*60*24*30*6)));	
	  $today_time = strtotime(date('Y-m-d'));
	  $expire_time = strtotime($launchExpiryDate);

		//Show the post launch images when launch is expired
		if ($expire_time < $today_time && $event['Type']==1) $isPostLaunchImages='true';
		else $isPostLaunchImages = 'false';
	
	  $this->load->view('event_promotionalImages',array('promotionalImages'=>$eventList['promotionalImages'],'launchPostPRImages'=>$eventList['launchPostPRImages'],'promotionalClass'=>'mt10 eventN_box_shadow bdr_a8a6a6 darkGrey_bg','isPostLaunchImages'=>$isPostLaunchImages)); 
	 
	echo Modules::run("mediafrontend/getReviewList",$entityId,$event['LaunchEventId'],$craveCount,$viewCount);
}else{
	echo $this->lang->line('noRecord');
}
?>
