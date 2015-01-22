<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php

$currentStatus = @$currentStatus?$currentStatus:$this->lang->line('Publish');
$changeStatus = @$changeStatus?$changeStatus:$this->lang->line('unPublish');
$deleteCache = @$deleteCache?@$deleteCache:0;
$isElement = isset($isElement)?$isElement:0;
if(!isset($isFARF)) $isFARF = 1;

$titlePublish = $isFARF==0?$this->lang->line('notPublishMsg'):'';

//For giving alert to have session first before publish else one cannot publish the record
$checkSession = (@$checkSession>0)?$checkSession:0;
$isSession = (@$totalSessions>0)?1:0;
$sessionMsg = $this->lang->line('sessionMsg');
$data = $this->load->view('event/meeting_point_popup','',true);
$popupData = json_encode($data);
echo '<script>var popupData='.$popupData.';</script>';
if(strcmp($changeStatus,'Hide')==0){ ?>
	<div id="publishUnpublish" class="tds-button fr formTip" title="<?php echo $titlePublish;?>"><a onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" href="javascript:void(0);" ><span onclick="mettingPoint(this,'<?php echo $tabelName;?>','<?php echo $pulishField;?>','<?php echo $field;?>','<?php echo $fieldValue;?>','<?php echo $currentStatus;?>','<?php echo $changeStatus;?>',<?php echo @$isFARF;?>,'<?php echo @$deleteCache;?>','<?php echo @$checkSession;?>','<?php echo @$isSession;?>','<?php echo @$sessionMsg;?>',popupData)"><?php echo $changeStatus;?></span></a></div>
	<?php 
} 
else {?>
	<div id="publishUnpublish" class="tds-button-orange fr formTip" title="<?php echo $titlePublish;?>"><a onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" href="javascript:void(0);" ><span onclick="mettingPoint(this,'<?php echo $tabelName;?>','<?php echo $pulishField;?>','<?php echo $field;?>','<?php echo $fieldValue;?>','<?php echo $currentStatus;?>','<?php echo $changeStatus;?>',<?php echo @$isFARF;?>,'<?php echo @$deleteCache;?>','<?php echo @$checkSession;?>','<?php echo @$isSession;?>','<?php echo @$sessionMsg;?>',popupData)"><?php echo $changeStatus;?></span></a></div>
	<?php 
} ?>
