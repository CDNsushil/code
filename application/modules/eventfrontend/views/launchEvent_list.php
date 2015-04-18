<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
   $pieceSrartFrom=1;
	if(isset($LaunchEvents) && is_array($LaunchEvents) && count($LaunchEvents)> 0){
		$countLaunchEvents=count($LaunchEvents);
		if($method == 'eventlaunch'){
			$displyList='';
			$style= '';
		}else{
			$displyList='dn';
			$style= 'style="background-position: -1px -144px;"';
		}
		?>
			<div>
			<div class="colap_leftSide ptr hoverOrange" onclick="togRelDiv('launchCollectionToggle','toggle_leftside','PElistingtoggle')"> <span class="Fleft">Launches  (<?php echo $countLaunchEvents;?>)</span>
			  <div class="tds-button-top mr5"> <a class="formTip"> <span>
				<div id="toggle_leftside" class="projectToggleIcon" <?php echo $style;?>></div>
				</span> </a> </div>
			  <div class="clear"></div>
			</div>
			<div id="launchCollectionToggle" class="PElistingtoggle <?php echo $displyList;?>">
			  <div class="scroll_box global_shadow bdr_non mb2">
				<div id="launchCollectionSlider" class="slider"> <a class="buttons prev" href="#"></a>
				  <div class="viewport scroll_container02">
					<ul class="overview">
					  <?php
						foreach($LaunchEvents as $Lkesy=>$LE){
						   $LaunchDate=$LE->LaunchDate;
						   $craveCount=$LE->craveCount>0?$LE->craveCount:0;
						   $viewCount=$LE->viewCount>0?$LE->viewCount:0;
						   
						   
						   $eventImage=$LE->filePath.$LE->fileName;
						   //$eventImage=addThumbFolder($eventImage,$suffix='_xxs',$thumbFolder ='thumb',$defaultThumb='images/default_thumb/events_s.jpg');
						   //$eventImage=getImage($eventImage);
						   //----------make element default launch image code start---------//
							if(!empty($eventImage) && file_exists($eventImage)) {
								$eventImage=addThumbFolder($eventImage,'_xxs');
								$eventImage=getImage($eventImage,$this->config->item('defaultEventImg_s'));
							} else {
								$getPojrectImage = getEventsPrimaryImage($LE->LaunchEventId,'.launchEventId');
								if($getPojrectImage){
									$eventImage = $getPojrectImage;
								}else{
									$eventImage=addThumbFolder($eventImage,'_xxs');				
								}
								$eventImage = getImage(@$eventImage,$this->config->item('defaultEventImg_s'));
							}
							//----------make element default launch image code start---------//
						   
						   $loggedUserId=isloginUser();
							if($loggedUserId > 0){
								$where=array(
									'tdsUid'=>$loggedUserId,
									'entityId'=>$entityId,
									'elementId'=>$LE->LaunchEventId
								);
								$countResult=countResult('LogCrave',$where);
								$cravedALL=($countResult>0)?'cravedALL':'';
							}else{
								$cravedALL='';
							}
							 $elementTextColor='';
							 if(isset($launchEventId) && ($launchEventId> 0) && $launchEventId==$LE->LaunchEventId){
								 $elementTextColor='orange_color';
								 $pieceSrartFrom=ceil(($Lkesy+1)/3);
							 }
							 $launchLink=base_url(lang().'/eventfrontend/eventlaunch/'.$userId.'/'.$LE->LaunchEventId);
							 $launchLink=(isset($moduleMathod) && $moduleMathod=='preview')?base_url(lang().'/eventfrontend/preview/'.$userId.'/'.$LE->LaunchEventId).'/eventlaunch':$launchLink;
							 $launchLink=(isset($evantMathod) && $evantMathod=='events')?base_url(lang().'/eventfrontend/events/launch/'.$userId.'/'.$LE->LaunchEventId):$launchLink;
						  ?>
						  <li>
							<div class="row recent_box_wrapper01">
							  <div class="row">
								<div class="cell recent_thumb_PApage thumb_absolute01">
								  <div class="AI_table">
									<div class="AI_cell"> <a href="<?php echo $launchLink;?>"><img src="<?php echo $eventImage;?>" class="bdr_cecece max_w68_h68"> </a></div>
								  </div>
								</div>
								<div class="cell ml71 width_197">
								  <div class="recent_two_line01 pl10 height_42 mw186px ptr"><a href="<?php echo  $launchLink;?>" class="<?php echo $elementTextColor;?> dash_link_hover"><?php echo $LE->Title;?></a></div>
								  <div class="SMA_blog_status_bar "><div class="mt7"> <span class="blogS_view_btn Fright "><?php echo $viewCount;?></span><span class="blogS_crave_btn Fright width_20 craveDiv<?php echo $entityId.''.$LE->LaunchEventId.' '.$cravedALL;?>"><span class="inline"><?php echo $craveCount;?></span></span> </div> </div>
								  <div class="clear"></div>
								</div>
							  </div>
							  <div class="clear"></div>
							</div>
						  </li>
						<?php
					  }
						?>
					 </ul>
				  </div>
				  <a class="buttons next" href="#"></a> </div>
			  </div>
			</div>
		  </div>
		<?php
	}
  ?>
<script type="text/javascript">
	$(document).ready(function(){
		if($('#launchCollectionSlider'))	
		$('#launchCollectionSlider').tinycarousel({ axis: 'y', display: 3, start:<?php echo $pieceSrartFrom; ?>});
	});
</script>
