<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$userId=isLoginUser();
$unreadMsgCount=countResult('tmail_participants',array('user_id'=>$userId,'status'=>0,'is_sender'=>'f'));
$unreadMsgCount=($unreadMsgCount > 0)?$unreadMsgCount:0;
$craveCount=($cravesCount > 0)?$cravesCount:0;
$craveMeCount=($craveMeCount > 0)?$craveMeCount:0;
//$workApplicationsReceivedCount=countResult('WorkApplication',array('workOwnerId'=>$userId));
$notificationCount = countResult('NotificationParticipants',array('userId'=>$userId,'isSender'=>'f','status'=>0));
$postCount = countResult('Posts',array('custId'=>$userId,'postArchived'=>'f'));
$eventNotificationCount = countResult('Events',array('tdsUid'=>$userId,'EventArchive'=>'f','NatureId'=>1));
$productCount = countResult('Product',array('tdsUid'=>$userId,'productArchived'=>'f'));
$workApplicationsReceivedCount=($workApplicationsReceivedCount > 0)?$workApplicationsReceivedCount:0;
$workApplicationsSentCount=($workApplicationsSentCount > 0)?$workApplicationsSentCount:0;
$meetingpointCount=($countMeetingPoint > 0)?$countMeetingPoint:0;
$newsCount=0;
$reviewsCount=0;
if(isset($userNavigations) && is_array($userNavigations) && count($userNavigations) > 0 ){ 
	foreach($userNavigations as $key=>$val){
		if($val['section']=='news' && $val['sectionid']>0){
			$newsCount++;
		}
		if($val['section']=='reviews' && $val['sectionid']>0){
			$reviewsCount++;
		}
	}
}
$isMediaAvail = getMyPlaylistCount($userId);
if($newsCount>0 || $reviewsCount>0 || $postCount>0 || $eventNotificationCount>0 || $productCount>0 || $isMediaAvail!=false) {
?>

<div class="fl ml8">
	<div class="row"><div class="font_museoSlab font_size19 clr_f1592a mt6 pl34">Quick Dashboard Links</div></div>
	<div class="seprator_10"></div>
	<div class="row">
		<div class="img_containebox img_containeboxSLeft pt22 pl5 width709">
			<?php if($newsCount>0) {?>
				<div class="imgcontainer position_relative width_118 height172">
					<a href="<?php echo base_url(lang().'/media/news');?>">
						<div class="dash_photo_box_S ml17"> <img alt="tmail" src="<?php echo base_url();?>images/default_thumb/News_110x73.jpg"></div>
						<div class="position_absolute top144 pl20 width100percent font_museoSlab font_size13 clr_444 lineH_15 dash_link_hover"><?php echo $newsCount.' '.$this->lang->line('article_s');?> </div>
					</a>
				</div>
		  <?php }
		   if($reviewsCount>0) { ?>
				<div class="imgcontainer position_relative width_118 height172">
					<a href="<?php echo base_url(lang().'/media/reviews');?>">
						<div class="dash_photo_box_S ml17"> <img alt="notification" src="<?php echo base_url();?>images/default_thumb/Review_110x73.jpg"></div>
						<div class="position_absolute top144 pl20 width100percent font_museoSlab font_size13 clr_444 lineH_15 dash_link_hover"><?php echo $reviewsCount.' '.$this->lang->line('review_s');?></div>
					</a>
				</div>
			<?php }
		   if($postCount>0) { ?>
				<div class="imgcontainer position_relative width_118 height172">
					<a href="<?php echo base_url(lang().'/blog/index');?>"> 
						<div class="dash_photo_box_S ml17"> <img alt="craves" src="<?php echo base_url();?>images/default_thumb/Blog_110x73.jpg"></div>
						<div class="position_absolute top144 pl20 width100percent font_museoSlab font_size13 clr_444 lineH_15 dash_link_hover">
							<?php echo $postCount.' '.$this->lang->line('posts'); ?> </div>
					</a>
				</div>
			<?php }
		   if($eventNotificationCount>0) { ?>
				<div class="imgcontainer position_relative width_118 height172">
					<a href="<?php echo base_url(lang().'/event/eventnotifications');?>"> 
						<div class="dash_photo_box_S ml17"> <img alt="forum_1" src="<?php echo base_url();?>images/dashboard_images/pixel_Performances-and-Events_72x108.jpg"></div>
						<div class="position_absolute top144 pl20 width100percent font_museoSlab font_size13 clr_444 lineH_15 dash_link_hover"><?php echo $eventNotificationCount.' '.$this->lang->line('eventNotification');?> </div>
						</a>
				</div>
			<?php }
		   if($productCount>0) { ?>
				<div class="imgcontainer position_relative width_118 height172">
					 <a href="<?php echo base_url(lang().'/product');?>"> 
						<div class="dash_photo_box_S ml17"> <img alt="forum_1" src="<?php echo base_url();?>images/dashboard_images/pixelProducts72x108.jpg"></div>
						<div class="position_absolute top144 pl20 width100percent font_museoSlab font_size13 clr_444 lineH_15 dash_link_hover"><?php echo $productCount.' '.$this->lang->line('products');?></div>
					</a>
				</div>
			<?php } 
			// if($isMediaAvail!=false) { ?>
				<div class="imgcontainer position_relative width_118 height172">
					<a href="<?php echo base_url(lang().'/mediafrontend/myplaylist/'.$userId);?>"> 
						<div class="dash_photo_box_S ml17"> <img alt="forum_1" src="<?php echo base_url();?>images/dashboard_images/pixelPlayList72x108.jpg"></div>
						<div class="position_absolute top144 pl20 width100percent font_museoSlab font_size13 clr_444 lineH_15 dash_link_hover">
						<?php echo $this->lang->line('playlist');?></div>
					</a>
				</div>
			<?php //}?>
		</div><!-- /img_containebox -->
		
		<div class="clear"></div>
	</div>
</div>
<?php }?>
