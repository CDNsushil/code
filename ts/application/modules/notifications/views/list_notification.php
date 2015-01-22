<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//echo "<pre>";
//print_r($section_craved_list);
if(!empty($section_craved_list)){		
foreach($section_craved_list as $i => $notificationDetail){ 
	
	$notificationProjectType = $notificationDetail['projectType'];

	if(($notificationDetail['entityId'] =='54' || $notificationDetail['entityId'] =='12') && $notificationProjectType==='filmNvideo')
	{
		$linkId=($notificationDetail['elementId'] == $notificationDetail['projectId'])?$notificationDetail['ownerId'].'/'.$notificationDetail['projectId'].'/':$notificationDetail['ownerId'].'/'.$notificationDetail['projectId'].'/'.$notificationDetail['elementId'].'/';
		$notificationDetail['link']=base_url(lang().'/mediafrontend/searchresult/'.$linkId.'filmvideo');
	}
	elseif(($notificationDetail['entityId'] =='54' || $notificationDetail['entityId'] =='25') && $notificationProjectType=='musicNaudio')
	{
		$linkId=($notificationDetail['elementId'] == $notificationDetail['projectId'])?$notificationDetail['ownerId'].'/'.$notificationDetail['projectId'].'/':$notificationDetail['ownerId'].'/'.$notificationDetail['projectId'].'/'.$notificationDetail['elementId'].'/';
		$notificationDetail['link']=base_url(lang().'/mediafrontend/searchresult/'.$linkId.'musicaudio');
	}
	elseif(($notificationDetail['entityId'] =='54' || $notificationDetail['entityId'] =='47') && $notificationProjectType=='photographyNart')
	{
		$linkId=($notificationDetail['elementId'] == $notificationDetail['projectId'])?$notificationDetail['ownerId'].'/'.$notificationDetail['projectId'].'/':$notificationDetail['ownerId'].'/'.$notificationDetail['projectId'].'/'.$notificationDetail['elementId'].'/';
		$notificationDetail['link']=base_url(lang().'/mediafrontend/searchresult/'.$linkId.'photographyart');
	}
	elseif(($notificationDetail['entityId'] =='54' || $notificationDetail['entityId'] =='84') && $notificationProjectType=='writingNpublishing')
	{
		$linkId=($notificationDetail['elementId'] == $notificationDetail['projectId'])?$notificationDetail['ownerId'].'/'.$notificationDetail['projectId'].'/':$notificationDetail['ownerId'].'/'.$notificationDetail['projectId'].'/'.$notificationDetail['elementId'].'/';
		$notificationDetail['link']=base_url(lang().'/mediafrontend/searchresult/'.$linkId.'writingpublishing');
	}
	elseif(($notificationDetail['entityId'] =='54' || $notificationDetail['entityId'] =='7') && $notificationProjectType=='educationMaterial')
	{
		$linkId=($notificationDetail['elementId'] == $notificationDetail['projectId'])?$notificationDetail['ownerId'].'/'.$notificationDetail['projectId'].'/':$notificationDetail['ownerId'].'/'.$notificationDetail['projectId'].'/'.$notificationDetail['elementId'].'/';
		$notificationDetail['link']=base_url(lang().'/mediafrontend/searchresult/'.$linkId.'educationmaterial');
	}
	elseif($notificationDetail['entityId'] =='94')
	{
		$linkId=($notificationDetail['elementId'] == $notificationDetail['projectId'])?$notificationDetail['ownerId'].'/'.$notificationDetail['projectId'].'/':$notificationDetail['ownerId'].'/'.$notificationDetail['projectId'].'/'.$notificationDetail['elementId'].'/';
		$notificationDetail['link']=base_url(lang().'/mediafrontend/searchresult/'.$linkId.'news');
	}
	elseif($notificationDetail['entityId'] =='95')
	{
		$linkId=($notificationDetail['elementId'] == $notificationDetail['projectId'])?$notificationDetail['ownerId'].'/'.$notificationDetail['projectId'].'/':$notificationDetail['ownerId'].'/'.$notificationDetail['projectId'].'/'.$notificationDetail['elementId'].'/';
		$notificationDetail['link']=base_url(lang().'/mediafrontend/searchresult/'.$linkId.'reviews');
	}
	elseif($notificationDetail['entityId'] =='49')
	{
		$linkId=($notificationDetail['elementId'] == $notificationDetail['projectId'])?$notificationDetail['ownerId'].'/'.$notificationDetail['projectId'].'/':$notificationDetail['ownerId'].'/'.$notificationDetail['projectId'].'/'.$notificationDetail['elementId'].'/';
		$notificationDetail['link']=base_url(lang().'/productshowcase/viewproject/'.$linkId);
	}
	elseif($notificationDetail['entityId'] =='82')
	{
		$linkId=($notificationDetail['elementId'] == $notificationDetail['projectId'])?$notificationDetail['ownerId'].'/'.$notificationDetail['projectId'].'/':$notificationDetail['ownerId'].'/'.$notificationDetail['projectId'].'/'.$notificationDetail['elementId'].'/';
		$notificationDetail['link']=base_url(lang().'/workshowcase/viewproject/'.$linkId);
	}
	elseif($notificationDetail['entityId'] =='96')
	{
		$linkId=($notificationDetail['elementId'] == $notificationDetail['projectId'])?$notificationDetail['ownerId'].'/'.$notificationDetail['projectId'].'/':$notificationDetail['ownerId'].'/'.$notificationDetail['projectId'].'/'.$notificationDetail['elementId'].'/';
		$notificationDetail['link']=base_url(lang().'/blogs/frontpost/'.$linkId);
	}
	elseif($notificationDetail['entityId'] =='71')
	{
		$linkId=$notificationDetail['ownerId'].'/'.$notificationDetail['projectId'];
		$notificationDetail['link']=base_url(lang().'/upcomingfrontend/viewproject/'.$linkId);
	}
	elseif($notificationDetail['entityId'] == '9' || $notificationDetail['entityId'] == '15' || $notificationDetail['entityId'] == '10')
	{
		if(isset($notificationDetail['eventnautreid']) && $notificationDetail['eventnautreid']==1)
			$notificationDetail['link']=base_url(lang().'/eventfrontend/events/notification/'.$notificationDetail['ownerId']);
		
		if(isset($notificationDetail['eventnautreid']) && $notificationDetail['eventnautreid']==2)
			$notificationDetail['link']=base_url(lang().'/eventfrontend/events/notification/'.$notificationDetail['ownerId'].'/'.$notificationDetail['projectId']);
		
		if(isset($notificationDetail['launchnautreid']) && $notificationDetail['launchnautreid']==3)
			$notificationDetail['link']=base_url(lang().'/eventfrontend/events/launch/'.$notificationDetail['ownerId'].'/'.$notificationDetail['projectId']);
			
		if(isset($notificationDetail['launchnautreid']) && $notificationDetail['launchnautreid']==4)
			$notificationDetail['link']=base_url(lang().'/eventfrontend/events/launch/'.$notificationDetail['ownerId'].'/'.$notificationDetail['projectId']);
		
		if(isset($notificationDetail['eventnautreid']) && $notificationDetail['eventnautreid']==4)
			$notificationDetail['link']=base_url(lang().'/eventfrontend/events/event/'.$notificationDetail['ownerId'].'/'.$notificationDetail['projectId']);
		
		if(isset($notificationDetail['sessioneventid']) && $notificationDetail['sessioneventid']!='')
			$notificationDetail['link']=base_url(lang().'/eventfrontend/events/eventSession/'.$notificationDetail['ownerId'].'/'.$notificationDetail['sessioneventid']);
		
		if(isset($notificationDetail['sessionlauncheventid']) && $notificationDetail['sessionlauncheventid']!='')
			$notificationDetail['link']=base_url(lang().'/eventfrontend/events/eventSession/'.$notificationDetail['ownerId'].'/'.$notificationDetail['sessioneventid']);
		//echo '<pre />';print_r($notificationDetail);
		//$notificationDetail['link']=base_url(lang().'/eventfrontend/events/'.$notificationDetail['alert_type'].'/'.$linkId);
		//eventfrontend/events/eventSession/21/158
	}
	elseif($notificationDetail['entityId'] == '93')
	{
		$linkId=$notificationDetail['ownerId'];
		$notificationDetail['link']=base_url(lang().'/showcase/index/'.$linkId);
	}
	else{
		$notificationDetail['link']='#';
	}

	$userInfo = userProfileImage($notificationDetail['ownerId']);
	$userDefaultImage = ($userInfo['creative']=='t')?$this->config->item('defaultCreativeImg'):(($userInfo['associatedProfessional']=='t')?$this->config->item('defaultAssProfImg'):(($userInfo['enterprise']=='t')?$this->config->item('defaultEnterpriseImg'):$this->config->item('defaultMemberImg_m')));
										
	$varUserImage = addThumbFolder($userInfo['userImage'],$suffix='_xxs',$thumbFolder ='thumb',$userDefaultImage);  	
	$varUserImage = getImage($varUserImage,$userDefaultImage);

	$mainDivClass='ver_contact_wp pb3 pt5';
	$varLineDividerClass='var_line_divider mt10';


	/* get Project Image */
	$projectImagePath = getProjectImage($notificationDetail['entityId'],$notificationDetail['elementId'],$notificationDetail['projectId'],$notificationProjectType);
	
	if(isset($projectImagePath) && !empty($projectImagePath)){
		$projectImage = $projectImagePath;
	}else{
		$projectImage = $varUserImage;
	}
?>
		<div class="row <?php echo $mainDivClass;?>">
		<?php //echo $notificationDetail['createdDate'].',,,'.$notificationDetail['elementId'].',,,'.$notificationDetail['entityId'];?>
		<div class="cell parent">
		<a onclick="return changeNotificationStatus('<?php echo $notificationDetail['id'];?>','<?php echo $notificationDetail['status'];?>');" href="<?php echo $notificationDetail['link'];?>" target="_blank">
		<div class="detailNF" id="notification_hover">
			<div class="ver_contact_user_pic_box mt11">
			<div class="AI_table">
					<div class="AI_cell">
						<img class="max_h_41 max_w_41" src="<?php echo $projectImage;?>">
					</div>
			</div>
			</div><!--ver_contact_user_pic_box-->		
			<div class="var_name_wp width300px">
			<div class="var_name font_size11">
				<?php 
				//echo '<pre />';print_r($notificationDetail);die;
				// $message = str_replace("{X}", $notificationDetail['creative_name'],$notificationDetail['message']);	
				// $message = str_replace("{Y}", $notificationDetail['title'],$message);	
				  
				//if(isset($section) && $section=='all') echo $this->lang->line($notificationDetail['projectType']).'<br />';
					echo $message = $notificationDetail['message']; 
				?>
			</div><!--var_name font_size11-->						
			</div>

			<div class="var_datbox_wp  mt2">
			<div class="var_name_label">
				<?php echo $this->lang->line('Date');?>
			</div><!--var_name_label-->
				
			<div class="var_date_box">
				<?php echo dateFormatView($notificationDetail['createdDate'],'d F Y');
				?>
			</div><!--var_date_box-->						
			</div><!--var_datbox_wp-->	

			<div class="<?php echo $varLineDividerClass; ?>">
			</div><!--var_line_divider-->
		</div>
		</a> 
		</div> 
		<div class="cell">
		<div class="checkBoxNF">
			<div class="tds-button-top mt8 mr5">
			<div class="defaultP pr0" >
				<input type="checkbox" name="month" value="<?php echo $notificationDetail['id']; ?>" id="id_<?php echo $notificationDetail['id']; ?>" class="case"/>
			</div>
			</div><!--defaultP-->
		</div>
		</div>
			<div class="clear"></div>
			</div><!--ver_contact_wp-->         
		
      <?php } //Foreach ?>
      <div class="clear"></div>
          <div class="row mt25 mb25 width_579" style="min-height:30px">			
			  <?php 								  
				 if(isset($items_total) && isset($perPageRecord) && ($items_total >  $perPageRecord)){
					  $paginationArray = array("pagination_links"=>$pagination_links,"perPageRecord"=>$perPageRecord,"items_total"=>$items_total,"items_per_page"=>$items_per_page,"url"=>base_url(lang().'/notifications/notificationslist/'.$section),"divId"=>"showNotification","formId"=>0,"unqueId"=>"full","isShowNumber"=>true,"isShowDD"=>true,'pagingWpaerClass' => 'pagination_wrapper new_page_design' ,'pagingDDDClass' =>'left_site_dropdown m0 new_page_design');
					  $this->load->view('pagination',$paginationArray);
				  }
			       			      
			  ?>
			    
			 <div class="clear"></div>
			</div>
      <?php
      
		}//If
		
	?>
<script>
function changeNotificationStatus(id,status){
	if(status==0){
		var updateData={"status":'1'};
		var where={"id":id};
		var returnFlag = AJAX('<?php echo base_url(lang()."/common/editDataFromTabel");?>','',updateData,'NotificationParticipants',where,'');
		if(returnFlag){
			return true;
		}
	}else{
		return true;
	}
}	
	
runTimeCheckBox();

$('.parent').hover(function(){

$(this).find('.userNF').toggleClass('gray_color')
$(this).find('.titleNF').toggleClass('gray_color')
});


</script>
