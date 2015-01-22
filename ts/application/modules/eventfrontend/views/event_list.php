<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	$pieceSrartFrom=1;
	if(isset($events) && is_array($events) && count($events)> 0){
		$countEvents=count($events);
		if($method == 'event'){
			$displyList='';
			$style= '';
		}else{
			$displyList='dn';
			$style= 'style="background-position: -1px -144px;"';
		}
		?>
		<div>
			<div class="colap_leftSide ptr hoverOrange" onclick="togRelDiv('eventCollectionToggle','toggle_leftside2','PElistingtoggle')"> <span class="Fleft">Events  (<?php echo $countEvents;?>)</span>
			  <div class="tds-button-top mr5"> <a class="formTip"> <span>
				<div id="toggle_leftside2" class="projectToggleIcon"  <?php echo $style;?>></div>
				</span> </a> </div>
			  <div class="clear"></div>
			</div>
			<div id="eventCollectionToggle" class="PElistingtoggle <?php echo $displyList;?>">
			  <div class="scroll_box global_shadow bdr_non mb2 ">
				<div id="eventCollectionSlider" class="slider"> <a class="buttons prev" href="#"></a>
				  <div class="viewport scroll_container02">
					<ul class="overview"> <?php
					  foreach($events as $Ekey=>$event){
						   $craveCount=$event->craveCount>0?$event->craveCount:0;
						   $viewCount=$event->viewCount>0?$event->viewCount:0;
						   
						   $eventImage=$event->filePath.$event->fileName;
						   //$eventImage=addThumbFolder($eventImage,$suffix='_xxs',$thumbFolder ='thumb',$defaultThumb='images/default_thumb/events_s.jpg');
						  //$eventImage=getImage($eventImage);
						   
						    //----------make element default event image code start---------//
							if(!empty($eventImage) && file_exists($eventImage)) {
								$eventImage=addThumbFolder($eventImage,'_xxs');
								$eventImage=getImage($eventImage,$this->config->item('defaultEventImg_s'));
							} else {
								$getPojrectImage = getEventsPrimaryImage($event->EventId,'.eventId');
								if($getPojrectImage){
									$eventImage = $getPojrectImage;
								}else{
									$eventImage=addThumbFolder($eventImage,'_xxs');				
								}
								$eventImage = getImage(@$eventImage,$this->config->item('defaultEventImg_s'));
							}
							//----------make element default event image code start---------//
						   
						   
						   $loggedUserId=isloginUser();
							if($loggedUserId > 0){
								$where=array(
									'tdsUid'=>$loggedUserId,
									'entityId'=>$entityId,
									'elementId'=>$event->EventId
								);
								$countResult=countResult('LogCrave',$where);
								$cravedALL=($countResult>0)?'cravedALL':'';
							}else{
								$cravedALL='';
							}
							 $elementTextColor='';
							 if(isset($EventId) && ($EventId> 0) && $EventId==$event->EventId){
								 $elementTextColor='orange_color';
								 $pieceSrartFrom=ceil(($Ekey+1)/3);
							 }
							 $eventLink=base_url(lang().'/eventfrontend/event/'.$userId.'/'.$event->EventId);
							 $eventLink=(isset($moduleMathod) && $moduleMathod=='preview')?base_url(lang().'/eventfrontend/preview/'.$userId.'/'.$event->EventId).'/event':$eventLink;
							 $eventLink=(isset($evantMathod) && $evantMathod=='events')?base_url(lang().'/eventfrontend/events/event/'.$userId.'/'.$event->EventId):$eventLink;
						  ?>
						  <li>
							<div class="row recent_box_wrapper01">
							  <div class="row">
								<div class="cell recent_thumb_PApage thumb_absolute01">
								  <div class="AI_table">
									<div class="AI_cell"> <a href="<?php echo $eventLink;?>"><img src="<?php echo $eventImage;?>" class="bdr_cecece max_w68_h68"> </a></div>
								  </div>
								</div>
								<div class="cell ml71 width_197">
								  <div class="recent_two_line01 pl10 height_42 mw186px ptr"><a href="<?php echo $eventLink;?>" class="<?php echo $elementTextColor;?> dash_link_hover"><?php echo $event->Title;?></a></div>
								  <div class="SMA_blog_status_bar"><div class="mt7"><span class="blogS_view_btn Fright "><?php echo $viewCount;?></span><span class="blogS_crave_btn Fright width_20 craveDiv<?php echo $entityId.''.$event->EventId.' '.$cravedALL;?>"><span class="inline"><?php echo $craveCount;?></span></span> </div></div>
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
	}?>
<script type="text/javascript">
	$(document).ready(function(){
		if($('#eventCollectionSlider'))	
		$('#eventCollectionSlider').tinycarousel({ axis: 'y', display: 3, start:<?php echo $pieceSrartFrom; ?>});
	});
</script>
