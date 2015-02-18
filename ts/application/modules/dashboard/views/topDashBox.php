<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php
$userId = isLoginUser();
$unreadMsgCount = countResult('tmail_participants',array('user_id'=>$userId,'status'=>0,'is_sender'=>'f'));
$unreadMsgCount = ($unreadMsgCount > 0)?$unreadMsgCount:0;
$craveCount = ($cravesCount > 0)?$cravesCount:0;
$craveMeCount = ($craveMeCount > 0)?$craveMeCount:0;
//$workApplicationsReceivedCount=countResult('WorkApplication',array('workOwnerId'=>$userId));
$notificationCount = countResult('NotificationParticipants',array('userId'=>$userId,'isSender'=>'f','status'=>0));
$buyToolCount = countResult('UserMembershipItem',array('tdsUid'=>$userId,'type'=>1));
$orderItemCount = countResult('SalesOrder',array('customerUid'=>$userId));
$createdUser =  $this->session->userdata('username');
$forumCount = countResult('forum_topics',array('CreatedBy'=>$createdUser));
$workApplicationsReceivedCount = ($workApplicationsReceivedCount > 0)?$workApplicationsReceivedCount:0;
$workApplicationsSentCount = ($workApplicationsSentCount > 0)?$workApplicationsSentCount:0;
$meetingpointCount = ($countMeetingPoint > 0)?$countMeetingPoint:0;
$newsCount = 0;
$reviewsCount = 0;
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
?>

<div class="row">
<div class="seprator11"></div>
	<div class="height270 ml10 mr15 position_relative">
		<div class="fl width480px ml21">
			<div class="row"><div class="font_museoSlab font_size19 clr_f1592a ml28 mt6">Communicate</div></div>
			<div class="seprator_10"></div>
			<div class="row">
				<div class="img_containebox pl23 pr10 pt22 pl5 width460">
					<div class="imgcontainer position_relative height172">
						<a href="<?php echo base_url(lang().'/tmail');?>">
							<div class="dash_photo_box_S ml17"> <img src="<?php echo base_url();?>images/dashboard_images/tmail.jpg"/></div>
							<div class="position_absolute top140 text_alignC width100percent font_museoSlab font_size13 clr_444 dash_link_hover"> <?php echo $unreadMsgCount.' '.$this->lang->line('newmessage_s');?></div>
						</a>
					</div>
					
					<div class="imgcontainer position_relative height172">
						<a href="<?php echo base_url(lang().'/notifications/index');?>">	
							<div class="dash_photo_box_S ml17"> <img src="<?php echo base_url();?>images/dashboard_images/notification.jpg"/></div>
							<div class="position_absolute top144 text_alignC width100percent font_museoSlab font_size13 clr_444 dash_link_hover">
								<?php 
								$notifyLabel = $this->lang->line('recivedNotification_s');								
								echo $notificationCount.' '.$notifyLabel;?> 
							</div>
						</a>	
					</div>
					
					<div class="imgcontainer position_relative height172">
						<a href="<?php echo base_url(lang().'/craves');?>">	
							<div class="dash_photo_box_S ml17"> <img src="<?php echo base_url();?>images/dashboard_images/craves_1.jpg"/></div>
							<div class="position_absolute top144 text_alignC width100percent font_museoSlab font_size13 clr_444 dash_link_hover">
							<?php echo $craveCount.' '.$this->lang->line('craves_s');?> <br>
							<?php echo $craveMeCount.' '.$this->lang->line('cravingMe');?>
							</div>
						</a>
					</div>
					
					<div class="imgcontainer position_relative height172">
						<a href="<?php echo base_url(lang().'/forums');?>">
							<div class="dash_photo_box_S ml17"> <img src="<?php echo base_url();?>images/dashboard_images/forum_1.jpg"/></div>
							<div class="position_absolute top144 text_alignC width100percent font_museoSlab font_size13 clr_444 dash_link_hover"><?php echo $forumCount.' items';?></div>
						</a>
					</div>
					
				</div><!-- /img_containebox -->
				
				<div class="clear"></div>
			</div>
		</div>
		
		
		<div class="fl width_252 ml30">
			<div class="row"><div class="font_museoSlab font_size19 clr_f1592a ml28 mt6">Buy</div></div>
			<div class="seprator_10"></div>
			<div class="row">
				<div class="img_containebox pl23 pr8 pt22 pl13">
					<div class="imgcontainer position_relative height172">
						<a href="<?php echo base_url(lang().'/cart/purchase');?>">
							<div class="dash_photo_box_S ml17"> <img src="<?php echo base_url();?>images/dashboard_images/shoppingcart_1.jpg"/></div>
							<div class="position_absolute top140 text_alignC width100percent font_museoSlab font_size13 clr_444 dash_link_hover"><?php echo $orderItemCount.' items';?></div>
						</a>
					</div>
					
					<div class="imgcontainer position_relative height172">
						<a href="<?php echo base_url(lang().'/package/buytools');?>">
							<div class="dash_photo_box_S ml17"> <img src="<?php echo base_url();?>images/dashboard_images/pixelBuyTools72x108.jpg"/></div>
							<div class="position_absolute top140 text_alignC width100percent font_museoSlab font_size13 clr_444 dash_link_hover"><?php echo $buyToolCount.' tools';?></div>
						</a>
					</div>	
				</div><!-- /img_containebox -->
				
				<div class="clear"></div>
			</div>
		</div>
		
		
		<div class="fl ml30 width150px">
			<div class="row"><div class="font_museoSlab font_size17 clr_f1592a mt6">Account Setup</div></div>
			<div class="seprator_10"></div>
			<div class="row">
				<div class="img_containebox pl23 pr2 fl pt22 pl5">
					<a href="<?php echo base_url(lang().'/dashboard/globalsettings');?>">
						<div class="imgcontainer position_relative height172">
							<div class="dash_photo_box_S ml17"> 
								<img src="<?php echo base_url();?>images/dashboard_images/pixelGlobalSettings72x108.jpg"/>
							</div>                       
						</div>
					</a>
				</div><!-- /img_containebox -->
				<div class="clear"></div>
			</div>
		</div>
		
		<div class="dashboard_bottomshedow position_absolute"></div>
	</div> <!-- dashboard_topgbox -->
</div>
