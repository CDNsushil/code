<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$currentStatus = isset($currentStatus)?$currentStatus:$this->lang->line('Publish');
$changeStatus = isset($changeStatus)?$changeStatus:$this->lang->line('hide');
$deleteCache =isset($deleteCache)?$deleteCache:0;
$assignClass =isset($assignClass)?$assignClass:'';
$elementTable =isset($elementTable)?$elementTable:'';
$elementField =isset($elementField)?$elementField:'';
$isFARF =isset($isFARF)?$isFARF:1;
$titlePublish = $isFARF==0?(isset($sessionMsg) && $sessionMsg!='')?$sessionMsg:$this->lang->line('notPublishMsg'):'';
$checkSession = (isset($checkSession) && $checkSession>0)?$checkSession:0;
$isSession = (isset($totalSessions) && $totalSessions>0)?1:0;
$section = isset($section)?$section:'';
$projectId = isset($projectId)?$projectId:0;
$isElement = isset($isElement)?$isElement:0;
$isPublished = (isset($isPublished) && $isPublished=='t')?'t':'f';
$sessionMsg = isset($sessionMsg)?$sessionMsg:$this->lang->line('sessionMsg');


if(!isset($notificationArray)) $notificationArray = '';

$publishUnpublishInfo=array(
							'isPublished'=>$isPublished,	
							'tabelName'=>$tabelName,	
							'pulishField'=>$pulishField,	
							'field'=>$field,	
							'fieldValue'=>$fieldValue,	
							'elementTable'=>$elementTable,	
							'elementField'=>$elementField,	
							'deleteCache'=>$deleteCache,
							'projectId'=>$projectId,
							'isElement'=>$isElement,
							'notificationArray'=>$notificationArray
						  );


$publishUnpublishInfo=json_encode($publishUnpublishInfo);
$publishUnpublishSpan='';
if($isFARF){
	$publishUnpublishSpan='publishUnpublishSpan ';
}
echo '<script>var publishData'.$tabelName.$fieldValue.'='.$publishUnpublishInfo.';</script>';
if(strcmp($changeStatus,'Hide')==0){ ?>
	<div id="publishUnpublish" class="tds-button fr formTip" title="<?php echo $titlePublish;?>"><a onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" href="javascript:void(0);" ><span class ="<?php echo $publishUnpublishSpan.$assignClass;?> dash_link_hover"onclick="publishUnpulish(this,publishData<?php echo $tabelName.$fieldValue;?>,'<?php echo $currentStatus;?>','<?php echo $changeStatus;?>',<?php echo $isFARF;?>,'<?php echo $checkSession;?>','<?php echo $isSession;?>','<?php echo $sessionMsg;?>','<?php echo $section;?>')"><?php echo $changeStatus;?></span></a></div>
	<?php 
} 
else {?>
	<div id="publishUnpublish" class="tds-button-orange fr formTip" title="<?php echo $titlePublish;?>"><a onmousedown="mousedown_tds_button_orange(this)" onmouseup="mouseup_tds_button_orange(this)" href="javascript:void(0);" ><span class ="<?php echo $publishUnpublishSpan.$assignClass;?> fmoss black_link_hover "onclick="publishUnpulish(this,publishData<?php echo $tabelName.$fieldValue;?>,'<?php echo $currentStatus;?>','<?php echo $changeStatus;?>',<?php echo $isFARF;?>,'<?php echo $checkSession;?>','<?php echo $isSession;?>','<?php echo $sessionMsg;?>','<?php echo $section;?>')"><?php echo $changeStatus;?></span></a></div>
	<?php 
} ?>
