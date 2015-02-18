<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
	 
	if($eventList && is_array($eventList) && count($eventList) > 0){
	  $countResult=count($eventList);
	  $event=$eventList[0];
	  //echo '<pre />';print_r($event);
	  $OrgURL = @$event['OrgURL'];
	  $OrgPhone = @$event['OrgPhone'];
	  $StartDate=$event['StartDate'];
	  $FinishDate=$event['FinishDate'];
	  $posterImage=$event['posterImage'];
	
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
	  
	  $type=($event['Type']==2)?$this->lang->line('online'):$this->lang->line('live');
	  $genre=($event['Genre']==2)?$this->lang->line('educational'):$this->lang->line('entertainment');
	  
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

	//----------make element default event image code start---------//
	if(!empty($eventImage) && file_exists($eventImage)) {
		$eventImage=addThumbFolder($eventImage,'_s');
		$eventImage=getImage($eventImage,$this->config->item('defaultEventImg_s'));
	} else {
		$getPojrectImage = getEventsPrimaryImage($event['EventId'],'.eventId');
		if($getPojrectImage){
			$eventImage = $getPojrectImage;
		}else{
			$eventImage=addThumbFolder($eventImage,'_s');				
		}
		$eventImage = getImage(@$eventImage,$this->config->item('defaultEventImg_s'));
	}
	//----------make element default event image code start---------//
	
	
	$address=$address2=$countryName=$state=$city=$zip=$venueEmail=$venueName=$url=$phoneNumber='';
	if(isset($eventList['eventSessions']) && is_array($eventList['eventSessions']) && count($eventList['eventSessions'])> 0){
		$address=$eventList['eventSessions'][0]['address'];
		$address2=$eventList['eventSessions'][0]['address2'];
		$countryName=$eventList['eventSessions'][0]['countryName'];
		$state=$eventList['eventSessions'][0]['state'];
		$city=$eventList['eventSessions'][0]['city'];
		$zip=$eventList['eventSessions'][0]['zip'];
		$venueEmail=$eventList['eventSessions'][0]['venueEmail'];
		$venueName=$eventList['eventSessions'][0]['venueName'];
		$url=$eventList['eventSessions'][0]['url'];
		$phoneNumber=$eventList['eventSessions'][0]['phoneNumber'];		
   }
  
	$loggedUserId=isloginUser();
	//Set Css for poster image if exists
	if(!empty($posterImage) && file_exists($posterImage)) {
		$posterUrl = site_url().$posterImage;
	}else{
		//$posterUrl = site_url().'images/event_green_bg_1.jpg';	
		$posterUrl = '';	
	}?>
    <div class="eventN_box_shadow bdr_a8a6a6 darkGrey_bg">
	    <div class="seprator_10"></div>
             
        <div class="eventL_box clr_white bdr_non position_relative bg_595959">
			<img src="<?php echo $posterUrl;?>" alt="eventv2bg" class="position_absolute width_height_100_percent"/>
			<div class="nationalv2_titlebg">
				<div class="Normalevent_title pt8"><?php echo $event['Title'];?></div>
			</div>
			<div class="darkblackshape">
				<div class="Fleft mt90">
					<div class="Normalevent_Date Fright ml13 pb22"><span class="Eday"><?php echo $StartWD;?></span><span class="Edate pt1"><?php echo $StartD;?></span><span class="Emyear"><?php echo $StartM;?><?php echo $StartY;?></span></div>
					<?php
					if(!$isSameDate){
					?>
						<div class="pb20 font_opensansSBold font_size18 ml13">to</div>
						<div class="Normalevent_Date fl ml13 mt12"><span class="Eday"><?php echo $FinishWD;?>  </span><span class="Edate pt1"><?php echo $FinishD;?></span><span class="Emyear mt15"><?php echo $FinishM;?><?php echo $FinishY;?></span></div>
					<?php
					}?>
				</div>
			</div><!-- /darkblackshape -->
        
			<div class="Normalevent_thumbnail Fright mt133 mr15">
                <div class="AI_table">
					<div class="AI_cell"> <img class="bg_Normaleventtrans max_w237_h158" src="<?php echo $eventImage;?>"></div>
                </div>
            </div>
            <div class="clear"></div>
	  
			<div class="darkgreenbottom mt13">    
				<div class="seprator_25"></div>
				<div class="mt21 pl140  Normalevent_cityplace_right height54 font_OpenSansBold font_size24 text_shadow pr_54 lineH_32">
					<div class="fl clr_c30101 pl77 width_158 height_39 overflow_hidden whitespace_now mt-4">
						<?php 
						echo getSubString($city,10);?>
					</div>
					<div class="clear"></div>
					<div class="fr clr_444 pr6 mt-12 whitespace_now width_230 overflow_hidden text_alignR height_31 mt-4">
						<?php
						echo getSubString($countryName,15);?>
					</div>
				</div>
				<div class="row pl_148 font_opensansSBold lang_shadow fl width_256"><?php echo $event['Language_local'];?>
				<div class="clear"></div>
            </div>  
			<div class="Normalevent_title2 ml50 clr_c30101 height_31 width_361 whitespace_now pr46 overflow_hidden">
                <div class="overflow_hidden"><?php echo getSubString($venueName,25);?></div>
            </div>
            <div class="row musicaudio_bg font_opensansSBold"><span class="mt-5 mr6"><?php echo $event['IndustryName'];?></span></div>
            <div class="seprator_22"></div>
            <div class="font_opensans font_size13 ml28 mr36 clr_333 height_90 overflow_hidden">
				<?php echo nl2br($event['OneLineDescription']);?>
			</div>
            <div class="seprator_22"></div>
            <div class=" font_opensansSBold ml28  Fleft">
				<?php if(!empty($OrgURL)){
					if(strstr($OrgURL, 'http:')){
						echo '<a target="_blank" href="'.$OrgURL.'" class="clr_white">'.$OrgURL.'</a>';
					}else{
						echo '<a target="_blank" href="http://'.$OrgURL.'" class="clr_white">'.$OrgURL.'</a>';
					}
				}?>
			</div>
                 <div class="eventL_mobile Fright  mr23 mb3 clr_white"><?php echo $OrgPhone;?></div>
               <div class="clear seprator_10"></div>
               
                </div><!-- /darkblackshape -->
	 </div>
	  <div class="clear"></div>
	<div class="seprator_16 eventL_below_boxshadow"></div>
	<div class="eventN_action_box font_size11 clr_white">
	  <ul>
		<li class="mt5">
		   <?php
		   
		        // Add to preview method 
			    $moduleMethod= $this->router->method;
				//$url = base_url().uri_string();
				$currentUrl = base_url().uri_string();
				
				$sectionHeading=$this->lang->line('performances').'&nbsp;'.$this->lang->line('&').'&nbsp;'.$this->lang->line('events');
				$this->load->view('media/reviewView',array('elementId'=>$event['EventId'],'projectId'=>$event['EventId'],'entityId'=>$entityId,'projName'=>$event['Title'],'section' =>$sectionHeading,'industryId' =>$event['Industry'],'reviewClass'=>'tds-button01 cell Fright','reviewFrom'=>'P&E','isPublished'=>$event['isPublished'],'isPreviewMethod'=>$moduleMethod));
			  ?>
		</li>
	  </ul>
	  <?php 
		$venueOrgniserDetails=array(
									'venueOrgniserClass'=>'width_98 clr_ccc pt2 pl6 pb5 eventL_actionseprator',
									'id'=>$event['EventId'],
									'venueaddress'=>htmlentities($address),
									'venueaddress2'=>htmlentities($address2),
									'venuecountryName'=>htmlentities($countryName),
									'venuestate'=>htmlentities($state),
									'venuecity'=>htmlentities($city),
									'venuezip'=>htmlentities($zip),
									'venueEmail'=>htmlentities($venueEmail),
									'venueName'=>htmlentities($venueName),
									'venueurl'=>htmlentities($url),
									'venuephoneNumber'=>htmlentities($phoneNumber),
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
	  </ul><ul class="eventN_cat2 font_size12 pt2 pb5 pl4 pr6  Fright text_alignR ">
		<li> <?php echo $type.' '.$genre;?></li>
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
			   														
				$relation = array('getFrontShortLink', 'email','share','entityTitle'=> $event['Title'], 'shareType'=>'performancesevents', 'shareLink'=> $currentUrl,'id'=> 'Project'.$event['EventId'],'entityId'=>$entityId,'elementid'=>$event['EventId'],'projectType'=>'performancesevents','isPublished'=>$event['isPublished'],'viewType'=>'showcase','isPreviewMethod'=>$moduleMethod);
				$this->load->view('common/relation_to_share',array('relation'=>$relation));
			?>							  
		 </div>   	
		  <?php $this->load->view('craves/craveView',array('craveClass'=>'tds-button_crave cell mr6','elementId'=>$event['EventId'],'entityId'=>$entityId,'ownerId'=>$event['tdsUid'],'projectType'=>'performancesevents','isPublished'=>$event['isPublished'],'isPreviewMethod'=>$moduleMethod,'furteherDetails'=>'{"projectId":"'.$event['EventId'].'","table":"Events","primeryField":"EventId","fieldSet":"EventId as id,fileName as craveImage, Title as craveTitle, OneLineDescription as craveShortDescription, Tagwords as tagwords","cacheFilePath":"'.$cacheFile.'"}'));?>
		  <?php $this->load->view('rating/ratingView',array('elementId'=>$event['EventId'],'entityId'=>$entityId,'ratingAvg'=>$ratingAvg,'ratingClass'=>'tds-button_rate cell','isPublished'=>$event['isPublished'],'isPreviewMethod'=>$moduleMethod));?>
		  <div class="clear"></div>
		</div>
	  </div>
	</div>
  </div>
	<!-- ADS FOR CONTENT -->
	
	<!-- Div for 468x60 advert display -->
	<div class="row mt10" id="advert468_60"><?php 
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
  <?php $this->load->view('event_promotionalImages',array('promotionalImages'=>$eventList['promotionalImages'],'launchPostPRImages'=>'','promotionalClass'=>'mt10 eventN_box_shadow bdr_a8a6a6 darkGrey_bg','isPostLaunchImages'=>false)); ?>
  
  <?php
	echo Modules::run("mediafrontend/getReviewList",$entityId,$event['EventId'],$craveCount,$viewCount);
}else{
	echo $this->lang->line('noRecord');
}?>
