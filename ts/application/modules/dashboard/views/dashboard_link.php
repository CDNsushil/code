<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$userId=isLoginUser();
$unreadMsgCount=countResult('tmail_participants',array('user_id'=>$userId,'status'=>0,'is_sender'=>'f'));
$unreadMsgCount=($unreadMsgCount > 0)?$unreadMsgCount:0;
$craveCount=($cravesCount > 0)?$cravesCount:0;
$craveMeCount=($craveMeCount > 0)?$craveMeCount:0;
//$workApplicationsReceivedCount=countResult('WorkApplication',array('workOwnerId'=>$userId));
$notificationCount=countResult('NotificationParticipants',array('userId'=>$userId,'isSender'=>'f','status'=>0));
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
?>
<div class="font_museoSlab font_size20 clr_666 ml46 mt6">Links</div>
<div class="clear"></div>
<div class="seprator_6"></div>
<div class="dast_container_outer">
	<div class=" bg_dashbord_gred pall5">
	<div class="cell dash_link_shedow mt0 ml2 mt2">
		<div class="dash_Atool_list_box pl15 pr15 height_122"> 
			<div class="seprator_15"></div>
			<a href="<?php echo base_url(lang().'/event/usermeetingpoint');?>">
				<div class="fl mr20">
				<div class="heightAuto position_relative leftInherit bg_414042 pll10">
				<div class="height_112">
				<div class="AI_table">
				<div class="AI_cell"> <img src="<?php echo base_url();?>images/default_thumb/meetingPoint_110x73.jpg" alt="meetingpoint" class="bdr_white max_w73_h110 dashbox-shedow"> </div>
				</div>
				</div>
				</div>
				<div class="clear"></div>
				<div class="fl width_94 font_museoSlab font_size13 clr_666 text_alignC mt8 line_H13 dash_link_hover"> <?php echo $meetingpointCount.' '.$this->lang->line('meeting_s').' '.$this->lang->line('Sign_In_to').' '.userSignInSessionCount();?>  </div>
				<div class="clear"></div>              
				</div> 
			</a>
			<?php
			if($newsCount > 0){ 
				?>
				<a href="<?php echo base_url(lang().'/media/news');?>">
					<div class="fl mr20">
					<div class="heightAuto position_relative leftInherit bg_414042 pll10">
					<div class="height_112">
					<div class="AI_table">
					<div class="AI_cell"> <img src="<?php echo base_url();?>images/default_thumb/News_110x73.jpg" alt="articles" class="bdr_white max_w73_h110 dashbox-shedow"> </div>
					</div>
					</div>
					</div>
					<div class="clear"></div>
					<div class="fl width_94 font_museoSlab font_size13 clr_666 text_alignC mt8 line_H13 dash_link_hover"><?php echo $newsCount.' '.$this->lang->line('article_s');?>  </div>
					<div class="clear"></div>              
					</div>
				</a>
				<?php
			}
			if($reviewsCount > 0){ 
				?>
				<a href="<?php echo base_url(lang().'/media/reviews');?>">
					<div class="fl mr20">
					<div class="heightAuto position_relative leftInherit bg_414042 pll10">
					<div class="height_112">
					<div class="AI_table">
					<div class="AI_cell"> <img src="<?php echo base_url();?>images/default_thumb/Review_110x73.jpg" alt="review" class="bdr_white max_w73_h110 dashbox-shedow"> </div>
					</div>
					</div>
					</div>
					<div class="clear"></div>
					<div class="fl width_94 font_museoSlab font_size13 clr_666 text_alignC mt8 line_H13 dash_link_hover"> <?php echo $reviewsCount.' '.$this->lang->line('review_s');?>  </div>
					<div class="clear"></div>              
					</div>
				</a>
			<?php	} ?>				
				
			<a href="<?php echo base_url(lang().'/tmail');?>">
				<div class="fl mr20">
				<div class="heightAuto position_relative leftInherit bg_414042 pll10">
				<div class="height_112">
				<div class="AI_table">
				<div class="AI_cell"> <img src="<?php echo base_url();?>images/default_thumb/170x113pixel_Tmail.jpg" alt="messagecenter" class="bdr_white max_w73_h110 dashbox-shedow"> </div>
				</div>
				</div>
				</div>
				<div class="clear"></div>
				<div class="fl width_94 font_museoSlab font_size13 clr_666 text_alignC mt8 line_H13 dash_link_hover"> <?php echo $unreadMsgCount.' '.$this->lang->line('newmessage_s');?></div>
				<div class="clear"></div>              
				</div> 
			</a>
			<a href="<?php echo base_url(lang().'/notifications/index');?>" >	
						<div class="fl mr20">
							<div class="heightAuto position_relative leftInherit bg_414042 pll10">
							<div class="height_112">
							<div class="AI_table">
							<div class="AI_cell"> <img src="<?php echo base_url();?>images/default_thumb/170x113pixel_Notifications.jpg" alt="notifications" class="bdr_white max_w73_h110 dashbox-shedow"> </div>
							</div>
							</div>
							</div>
							<div class="clear"></div>
							<div class="fl width_94 font_museoSlab font_size13 clr_666 text_alignC mt8 line_H13 dash_link_hover"> <?php 
								
								$notifyLabel = $this->lang->line('recivedNotification_s');								
								echo $notificationCount.' '.$notifyLabel;
								
							?>  </div>
							<div class="clear"></div>              
						</div>
					</a>
			<a href="<?php echo base_url(lang().'/craves');?>">	
				<div class="fl">
				<div class="heightAuto position_relative leftInherit bg_414042 pll10">
				<div class="height_112">
				<div class="AI_table">
				<div class="AI_cell"> <img src="<?php echo base_url();?>images/default_thumb/Craves1_110x73.jpg" alt="craves" class="bdr_white max_w73_h110 dashbox-shedow"> </div>
				</div>
				</div>
				</div>
				<div class="clear"></div>
				<div class="fl width_94 font_museoSlab font_size13 clr_666 text_alignC mt8 line_H13 dash_link_hover">
					<?php echo $craveCount.' '.$this->lang->line('craves_s');?> <br>
					<?php echo $craveMeCount.' '.$this->lang->line('cravingMe');?>
				</div>
				<div class="clear"></div>              
				</div>   
			</a>
		</div>
		<div class="clear"></div>
	</div>
	<div class="clear"></div>
	<div class="seprator_10"></div>
	<div class="cell dash_link_shedow mt0 ml2 mt2">
		<div class="dash_Atool_list_box pl15 pr15 height_122"> 
			<div class="seprator_15"></div>
							
			<a href="javascript:viod(0)" class="comingSoon">
				<div class="fl mr20">
				<div class="heightAuto position_relative leftInherit bg_414042 pll10">
				<div class="height_112">
				<div class="AI_table">
				<div class="AI_cell"> <img src="<?php echo base_url();?>images/default_thumb/Shopping-Cart_110x73.jpg" alt="shoppingcart" class="bdr_white max_w73_h110 dashbox-shedow"> </div>
				</div>
				</div>
				</div>
				<div class="clear"></div>
				<div class="fl width_94 font_museoSlab font_size13 clr_666 text_alignC mt8 line_H13 dash_link_hover"> 0 item(s) </div>
				<div class="clear"></div>              
				</div> 
			</a>
			<?php
			if(isset($userNavigations) && is_array($userNavigations) && count($userNavigations) > 0 &&(in_arrayr( 'enterprises', $userNavigations, $key='section', $is_object=0 ) || in_arrayr( 'associatedprofessionals', $userNavigations, $key='section', $is_object=0 ) || in_arrayr( 'creatives', $userNavigations, $key='section', $is_object=0 ))){ 
				if($workApplicationsReceivedCount > 0){ 
					?>
					<a href="<?php echo base_url(lang().'/work/workApplicationsReceived');?>">	
						<div class="fl mr20">
						<div class="heightAuto position_relative leftInherit bg_414042 pll10">
						<div class="height_112">
						<div class="AI_table">
						<div class="AI_cell"> <img src="<?php echo base_url();?>images/default_thumb/Apllications-Received_110x73.jpg" alt="Apllications-Received" class="bdr_white max_w73_h110 dashbox-shedow"> </div>
						</div>
						</div>
						</div>
						<div class="clear"></div> 
						<div class="fl width_94 font_museoSlab font_size13 clr_666 text_alignC mt8 line_H13 dash_link_hover"><?php echo $workApplicationsReceivedCount.' '.$this->lang->line('recieved');?>  </div>
						<div class="clear"></div>             
						</div>
					</a>
					<?php
				}
				if($workApplicationsSentCount > 0){ ?>
					<a href="<?php echo base_url(lang().'/work/workAppliedFor');?>">	
						<div class="fl mr20">
							<div class="heightAuto position_relative leftInherit bg_414042 pll10">
							<div class="height_112">
							<div class="AI_table">
							<div class="AI_cell"> <img src="<?php echo base_url();?>images/default_thumb/Apllications-Sent_110x73.jpg" alt="applicationsent" class="bdr_white max_w73_h110 dashbox-shedow"> </div>
							</div>
							</div>
							</div>
							<div class="clear"></div>
							<div class="fl width_94 font_museoSlab font_size13 clr_666 text_alignC mt8 line_H13 dash_link_hover"> <?php echo $workApplicationsSentCount.' '.$this->lang->line('sent');?>  </div>
							<div class="clear"></div>              
						</div>
					</a>
					<?php
				}
			}	
			 ?>
				
			<a href="<?php echo base_url(lang().'/forums');?>">	
				<div class="fl mr20">
					<div class="heightAuto position_relative leftInherit bg_414042 pll10">
					<div class="height_112">
					<div class="AI_table">
					<div class="AI_cell"> <img src="<?php echo base_url();?>images/default_thumb/Forum_110x73.jpg" alt="forum" class="bdr_white max_w73_h110 dashbox-shedow"> </div>
					</div>
					</div>
					</div>
					<div class="clear"></div>              
				</div> 
			</a>
			<a href="<?php echo base_url(lang().'/tips/front_tips');?>">	
				<div class="fl mr20">
				<div class="heightAuto position_relative leftInherit bg_414042 pll10">
				<div class="height_112">
				<div class="AI_table">
				<div class="AI_cell"> <img src="<?php echo base_url();?>images/default_thumb/Tips_110x73.jpg" alt="tips" class="bdr_white max_w73_h110 dashbox-shedow"> </div>
				</div>
				</div>
				</div>
				<div class="clear"></div>      
				</div> 
			</a>
			<a href="<?php echo base_url(lang().'/package/information');?>">
				<div class="fl">
				<div class="heightAuto position_relative leftInherit bg_414042 pll10">
				<div class="height_112">
				<div class="AI_table">
				<div class="AI_cell"> <img src="<?php echo base_url();?>images/default_thumb/Members-Information_110x73.jpg" alt="member_information" class="bdr_white max_w73_h110 dashbox-shedow"> </div>
				</div>
				</div>
				</div>
				<div class="clear"></div>

				</div> 
			</a>
		</div>
		<div class="clear"></div>
	</div>
	<div class="clear"></div>
	<div class="seprator_10"></div>
</div>
</div>
