<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php

$sendPRFormAttributes = array(
	'name'=>'sendPRForm',
	'id'=>'sendPRForm'
);


?>
<script>
	$(document).ready(function(){					
		$("#sendPRForm").validate();	
	});
</script>
<div class="row">
	<div class="cell frm_heading">
		<h1><?php echo $this->lang->line('mainPostlaunchPR');?></h1>
	</div>
	
	<?php 
		$navArray['NatureId'] = $eventNatureId;
		$navArray['EventId'] = (isset($EventId) && is_numeric($EventId) )?$EventId:0;
		$navArray['LaunchEventId'] = (isset($LaunchEventId) && is_numeric($LaunchEventId) )?$LaunchEventId:0;
		$navArray['currentMathod'] = 'launchpostprimg';
		echo Modules::run("event/menuNavigation",$navArray);
	 ?> 
</div>

	<div class="row form_wrapper">	
		<?php 
		//echo '<pre />';print_r($imageShowcase);die;
		$launchExpiryDate = date('Y-m-d',(strtotime($LaunchEventCreated)+(60*60*24*30*6)));	
		$today_time = strtotime(date('Y-m-d'));
		$expire_time = strtotime($launchExpiryDate);
		
		//Show the post launch images when launch is expired
		
		/* commented by sushil issue 1025 start
		 
		 if ($expire_time < $today_time && (strcmp($LaunchType,'Live')==0)) {
			$displayPostPRSection = 1;
		}
		else $displayPostPRSection = 0;
		
		
		
		
		
		if ($displayPostPRSection==1) {
			echo $this->load->view('mediatheme/mediaAccordView',$imageShowcase);
		} commented by sushil issue 1025 End */
		
		$this->load->view('mediatheme/mediaAccordView',$imageShowcase);
		
		
		?>
	</div>
	<?php if($imageShowcase['count'] >0 && $NotificationCount<=0){ ?>
	<div class="row ">
	<div class="cell tab_left">
		<div class="tab_heading">
			<?php echo $this->lang->line('sendPRNotification'); ?>
		</div><!--tab_heading-->
	</div>
	<div class="cell tab_right"><div class="cell pt10 width525px"><?php echo $this->lang->line('PRNotificationHeading'); ?></div>			
		<div class="tab_btn_wrapper">
			<div class="tds-button-top" >
				<a  class="formTip" >					
					<span><div class="projectToggleIcon" id="NotificationToggleIcon" toggleDivId="Notification-Content-Box" ></div></span>
				</a>
			</div>			
		</div>
	</div>
	</div><!--row-->	
	<div id="Notification-Content-Box" class="frm_strip_bg">	
	<?php 
	
		if(isset($cravedUser) && is_array($cravedUser) && count($cravedUser)>0 ){
			//echo '<pre/ >';print_r($cravedUser);
			 $cravedUserArray = array('name'=>'userEmail','id'=>'userEmail','value'=> implode(',',$cravedUser),'type' =>'hidden');
	?>

			<div class="pb20 ">
			<div class="row"><div class="tab_shadow"></div></div>
						 
			<div class="row">
				<div class="cell label_wrapper"><label><?php echo $this->lang->line('title'); ?></label></div>
					<div class="cell frm_element_wrapper_dark font_opensansSBold" >
						<div class="bdr_B_7E7E7E width525px lh30 font_size18">
						<?php  echo $LaunchTitle;?>
						</div>
					</div>
			</div>			 
			
			<!--div class="row">
				<div class="cell label_wrapper"><label><?php echo $this->lang->line('description'); ?></label></div>
				<div class="cell frm_element_wrapper_dark pt10" >
					<?php  echo $OneLineDescription;?>	
				</div>
			</div-->
			<?php echo form_open('/event/postLaunchNotification',$sendPRFormAttributes); ?>	
			 
			<input type="hidden" name="projectId" id="projectId" value="<?php echo $imageShowcase['LaunchEventId'] ;?>">
			<input type="hidden" name="toUsersId" id="toUsersId" value="<?php echo implode(',',$cravedUser);?>">
			<input type="hidden" name="subject" id="subject" value="<?php echo $LaunchTitle;?>">
			<input type="hidden" name="IndustryId" id="IndustryId" value="<?php echo $IndustryId;?>">
			<div class="row">
				<div class="cell label_wrapper"><label><?php echo $this->lang->line('message'); ?></label></div>
				<div class="cell frm_element_wrapper_dark" >					 
				 <?php 
					$msgBox=array('name'=>'message',
					'id'=>'message',
					'value'=>'',
					'rows'=>'5',
					'class'=>'width525px required boxshadow_none background_a3a3a3 clr_2d2d2d',					
					);
					echo form_textarea($msgBox);
				 ?>
				</div>				 
			</div>
			<div class="row">
				<div class="label_wrapper cell bg-non"></div><!--label_wrapper-->		
				 <div class=" cell frm_element_wrapper_dark">		
					<div class="tds-button fr mt15 mb10 mr15">		
					  <button type="submit" id="saveCompose" >
						 <span>
						   <div class="Fleft"><?php echo $this->lang->line('send');?></div>
						   <div class="send_button"></div>
						 </span>
					 </button>
					</div>				
				 <div class="clear"></div>		
				</div>		
			</div>
			 <div class="clear"></div>	
			<?php 
			 echo form_close();
			}		
		
		?>
	</div>
	
	</div>
	<?php } elseif($NotificationCount>0){
		if(isset($FileId) && $FileId>0){
			$imageDetail = getMediaDetail($FileId,'filePath,fileName');
			if(isset($imageDetail[0]->filePath) && $imageDetail[0]->filePath !='' && isset($imageDetail[0]->fileName) && $imageDetail[0]->fileName !='')
				$launchImageSrc = $imageDetail[0]->filePath.$imageDetail[0]->fileName;
			else
				$launchImageSrc = '';
		}else $launchImageSrc = '';
		
		$launchMediaSrc = getImage($launchImageSrc, $this->config->item('defaultEventImg_s'));
		?>
		<div class="row ">
	<div class="cell tab_left">
		<div class="tab_heading">
			<?php echo $this->lang->line('sendPRNotification'); ?>
		</div><!--tab_heading-->
	</div>
	<div class="cell tab_right">
		<div class="tab_btn_wrapper">			
			<div class="tds-button-top" >
				<a  class="formTip" >					
					<span><div class="projectToggleIcon" id="NotificationToggleIcon" toggleDivId="Notification-Content-Box" ></div></span>
				</a>
			</div>			
		</div>
	</div>
	</div><!--row-->
	<div id="Notification-Content-Box" class="frm_strip_bg">	
		<div class="row"><div class="tab_shadow"></div></div>
		<div class="row">
		<div class="label_wrapper cell bg-non"></div><!--label_wrapper-->		
		<div class="cell p10">
		<div class="ver_contact_wp heightAuto pb7">

			<div class="ver_contact_user_pic_box">
				<div class="AI_table">
					<div class="AI_cell">
						<img src="<?php echo $launchMediaSrc;?>" class="max_h_41 max_w_41">
					</div>
				</div>
			</div><!--ver_contact_user_pic_box-->

			<div style="width:370px;" class="var_name_wp">
			<!--div class="var_name_wp width350px">
				<div class="var_name">
					<?php  echo $LaunchTitle;?>
				</div><!--var_name_label-->
			
				<div class="var_name font_size11">
				<?php 
				$ent = LoginUserDetails('enterprise');
				if($ent == 't')
					echo LoginUserDetails('enterpriseName').$this->lang->line('hasLaunchSent').$LaunchTitle.'.';
				else
					echo LoginUserDetails('userFullName').$this->lang->line('hasLaunchSent').$LaunchTitle.'.';?>
				</div><!--var_name_label-->
				
				<div class="font_size11 pt5 pb5">
				<?php echo $NotificationDetails->message;?>
				</div><!--var_name_label-->
				
			</div><!--var_name_wp-->
			
			<div class="var_datbox_wp">
               	<div class="var_name_label">
                      <?php echo $this->lang->line('date');?>
                 </div><!--var_name_label-->
                        
                 <div class="var_date_box">
                        <!--24 December 2012-->
                          <?php echo dateFormatView($NotificationDetails->createdDate,'d M Y') ?>               
                </div><!--var_name_label-->
                        
                </div>
                <div class="clear"></div>
</div>
		<div class="clear"></div>

		</div>
		<div class="clear"></div>
		</div>
		 <div class="clear"></div>	
		</div>
		 <div class="clear"></div>	
		
		
		<?php }?>
		
	<div class="row"><div class="tab_shadow"></div></div>
<script>	
	
	function editMediaWs(mediaAttr,toggleId)
	{		
		//alert(mediaAttr.toSource());
		var mediaPromoId = $(mediaAttr).attr('mediaPromoId');
		var galTitle = $(mediaAttr).attr('mediaTitle');
		var mediafileId = $(mediaAttr).attr('mediafileId');
		var galAltText = $(mediaAttr).attr('mediaDescription');
		var imageName = $(mediaAttr).attr('filename');
		var passImage = $(mediaAttr).attr('passimage');			
		var new_img_src = $('#galImg_'+mediaPromoId).attr('src');		
		$('#<?php echo @$imageShowcase['toggleId']?>promoImage').attr('src',passImage);	
		
		$('#mediaSrc'+toggleId).attr('src',new_img_src);				
		$('#mediaId'+toggleId).val(mediaPromoId);
		$('#fileId').val(mediafileId);
		$('#mediaTitle'+toggleId).val(galTitle);
		$('#mediaDescription'+toggleId).val(galAltText);							 
		$('.promoImageCount').css("display","block");
		$('#'+toggleId+'Form-Content-Box').slideDown("slow");
		$('#fileInput'+toggleId).removeClass('required');		
	
	}	

	
</script>
