<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$sortButton = $industryArray['sortButton'];
?>	
<div class="bdr8_666 bg_white pt12 pb6 bg_444 global_shadow">
	<div class="fl pl8">
	<?php	

		// competition details for share and crave
		$entityId=getMasterTableRecord('TDS_Competition');
		$projectId = $competitionId;
		$userId = $userId;
		$industryType = 'competition';
		$loggedUserId=isloginUser();
		
		/*For Manage view counts */
		if((isset($projectId)) && (!empty($projectId)) && (isset($entityId)) && (isset($projectId)) && (isset($industryType)) && (!empty($industryType))){
			/*Get section Id*/
			$sectionId = $this->config->item($industryType.'SectionId');
			manageViewCount($entityId,$projectId,$userId,$projectId,$sectionId);
		}	
		
		
		//--------share button code--------//
		$currentUrl = base_url().uri_string();
		$relation = array('getShortLink', 'email','share','entityTitle'=> $competitionTitle, 'shareType'=>'competition details', 'shareLink'=> $currentUrl,'id'=> 'Project'.$project['projectid'],'entityId'=>$entityId,'elementid'=>$projectId,'projectType'=>$industryType,'isPublished'=>'t','viewType'=>'showcase');
		$this->load->view('common/relation_to_share',array('relation'=>$relation));
	?>
	</div>
	<?php 	
		//--------crave button  code------//
			
		$this->load->view('craves/craveView',array('craveClass'=>'tds-button_crave cell','elementId'=>$projectId,'entityId'=>$entityId,'ownerId'=>$userId,'projectType'=>$industryType,'isPublished'=>'t'));
	?>

	<div class="cell lineH27 pt5 ml20">
		<div class="icon_crave4_blog clr_white font_size14 craveDiv<?php echo $entityId.$projectId; ?>  <?php echo ($competitionDetail->craveId > 0)?'cravedALL':''; ?>">
			<span class="inline"><?php echo $competitionDetail->craveCount; ?></span>
		</div>
	</div>
	<div class="cell lineH27 pt5 ml10">
		<div class="icon_view3_blog clr_white font_size14 ">
		<?php echo $competitionDetail->viewCount; ?>
		</div>
	</div>
	<div class="<?php echo $sortButton; ?> fr mr36 mt2">
		<a href="<?php echo base_url('competition/sampleentry/'.$userId.'/'.$competitionId); ?>"  onmousedown="mousedown_tds_button_jludark(this)" onmouseup="mouseup_tds_button_jludark(this)"><span class="font_size12 width96"><?php echo $this->lang->line('competitionSampleEntryButton'); ?></span></a>
	</div>
	<div class="clear">
	</div>
	</div>
