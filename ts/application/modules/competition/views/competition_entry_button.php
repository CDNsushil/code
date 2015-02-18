<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$loggedUserId=isloginUser();
if(is_numeric($loggedUserId) && ($loggedUserId > 0) && is_numeric($competitionId) && ($competitionId > 0)){
	if($userId==$loggedUserId){
		$cannotEnterComptition=$this->lang->line('cannotEnterComptition');
		$function="customAlert('".$cannotEnterComptition."')";
	}else{
		$entryEndDate = date('d-m-Y',strtotime($submissionEndDate)); // set entry end date
		$currentDate = date('d-m-Y'); // set current date
		if(!empty($submissionEndDate) && $entryEndDate<$currentDate) {
			$missedEntryDate=$this->lang->line('missedEntryDate');
			$function="customAlert('".$missedEntryDate."')";
		}else{
			$sectionId=$this->config->item('competitionEntrySectionId');
			$function="javascript:getUserContainers('".$sectionId."','competition/competitionentry/".$competitionId."');";
		}
	}
}else{
	$beforeEnterComptition=$this->lang->line('beforeEnterComptition');
	$function="openLightBox('popupBoxWp','popup_box','/auth/login','".$beforeEnterComptition."')";
}


$label = isset($label) && ($label!='') ? $label : $this->lang->line('enterCompetition');
$class = isset($class) && ($class!='') ? $class : 'black_link_hover orange';
$mouse_up = isset($mouse_up) && ($mouse_up!='') ? $mouse_up : 'mouseup_tds_button01(this)';
$mouse_down = isset($mouse_down) && ($mouse_down!='') ? $mouse_down : 'mousedown_tds_button01(this)';
?>


<div onclick="<?php echo $function;?>" class="tds-button_compenter cell mt5 ml-34"> <a onmousedown="mousedown_tds_compenter(this)" onmouseup="mouseup_tds_compenter(this)" ><span class="width_220 pr">Enter <?php if(isset($competitionRoundType) && ($competitionRoundType ==2) ) { ?><div class="btnround">Round 2</div> <?php }?></span></a>
