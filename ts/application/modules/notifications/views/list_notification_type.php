<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php
$notificationTypeString = array();
//echo '<pre />';print_r($section_notification_count);die;
$activeAllClass=($selectSection=='' || $selectSection=='all' )?'active':'';

//echo "<pre>";
//print_r($section_notification_count);die;
if($section_notification_count){
$notificationTypeString['all']='<li><a class="'.$activeAllClass.'" href="'.base_url(lang()).'/notifications/index" > '.$this->lang->line('all').' <span> ('.count($section_notification_count).')</span></a></li>';
	 $notification_projectType = search_nested_arrays($section_notification_count,'projectType');
	 $count_array_notification_projectType = array_count_values($notification_projectType);
	 //echo '<pre />';print_r($notification_projectType);
	 //echo '<pre />';print_r($count_array_notification_projectType);die;
	$defaultProjectType='';
	$notificationTypeCount=1;
	
	/*foreach($section_notification_count as $key=>$notificationType){
		//echo $defaultProjectType.' = '.$notificationType['projectType'];
	
		if($defaultProjectType != $notificationType['projectType']){
			$notificationCount[$notificationType['projectType']] = $notificationTypeCount = 1;
			$defaultProjectType=$notificationType['projectType'];
		}else{
			$notificationCount[$notificationType['projectType']]++;
		}
		//echo '<br />'.$notificationType['projectType'];
		$notificationTypeString[$notificationType['projectType']]=$this->lang->line($notificationType['projectType']);
		$activeClass=$notificationType['projectType']==$selectSection?'active':'';
		if($notificationType['projectType']!='postLaunch')
			$notificationTypeString[$notificationType['projectType']]='<li><a class="'.$activeClass.'" href="'.base_url(lang()).'/notifications/index/'. $notificationType['projectType'].'" > '. $this->lang->line($notificationType['projectType']).' <span>('.$notificationCount[$notificationType['projectType']].')</span></a></li>';
	}
	* */
	foreach($count_array_notification_projectType as $key=>$notificationsCount){
		//echo '<pre />'.$key.$notificationType.$count_array_notification_projectType['postLaunch'];
		if(isset($count_array_notification_projectType['postLaunch'])) $countPostLaunch = $count_array_notification_projectType['postLaunch'];
		else $countPostLaunch = 0;
		if($key == 'performancesevents') $notificationTypeCount = $notificationsCount+$countPostLaunch;
		else $notificationTypeCount = $notificationsCount;
		$activeClass= $key==$selectSection?'active':'';
		if($key != $this->config->item('postLaunchNotificationType') && $this->lang->line($key)){
			$notificationTypeString[$key]='<li><a class="'.$activeClass.'" href="'.base_url(lang()).'/notifications/index/'.$key.'" > '. $this->lang->line($key).' <span>('.$notificationTypeCount.')</span></a></li>';
		}
	}
}
//echo '<pre />';print_r($notificationCount);
if(isset($notificationTypeString) && count($notificationTypeString)>0){
	foreach($notificationTypeString as $keyType =>$notificationLiKey){
		echo $notificationLiKey;
	}
}
else { echo '<li class="label_wrapper cell bg-non"></li>'; } 

?>
