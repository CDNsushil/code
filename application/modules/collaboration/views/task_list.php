<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if(isset($taskData) && count($taskData) > 0 && !empty($taskData) ) { ?>
		<div class="row todo_filter_box ml5">
			<div class="cell milestone_box ml28">
				<div class=" row ml3 mt6 pb5">Filter By Members</div>
				<div class="clear"></div>
				<?php
					$assignee=0;
					if(isset($taskData) && is_array($taskData) && count($taskData) > 0){
						$assigneeList= array('0'=>'All Members');
						foreach($taskData as $td){
							if(is_numeric($td->memberId) && ($td->memberId >=1)){
								$memberName= ($td->enterprise == 't')?$td->enterpriseName:$td->firstName.' '.$td->lastName;
								$assigneeList[$td->memberId]=$memberName;
								if($td->userId==$userId){
									$assignee=$td->memberId;
								}
							}
						}
					}
					
					echo '<div class=" row   pb10 pr">';
					echo form_dropdown('assignee', $assigneeList, $assignee,'id="assignee" class="selectBox width200px l0px" onchange="showTasks(this, this.value,\'memberId\');" ');
					echo '</div>';
					
				?>
			 </div>
			 
			
			
			 <?php 
			 if(isset($assignedMilestonData) && is_array($assignedMilestonData) && count($assignedMilestonData) > 0){
			 ?>
				<div class="cell milestone_box ml28">
					<div class=" row ml3 mt6 pb5">Milestones</div>
					<div class="clear"></div>
					<?php
						$assignedMilestonList= array('0'=>'All Milestones');
						foreach($assignedMilestonData as $amd){
							if(is_numeric($amd->milestoneId) && ($amd->milestoneId >=1)){
								$assignedMilestonList[$amd->milestoneId]=$amd->title;
							}
						}
						echo '<div class=" row   pb10 pr">';
						echo form_dropdown('miletoneLink', $assignedMilestonList, 0,'id="miletoneLink" class="selectBox width200px l0px" onchange="showTasks(this, this.value,\'milestone\');" ');
						echo '</div>';
					?>
				 </div>
				<?php 
			 }
			 
			 if(isset($completedMilestonData) && is_array($completedMilestonData) && count($completedMilestonData) > 0){
				?>
				<div class="cell milestone_box ml28">
					<div class=" row ml3 mt6 pb5">Completed Milestones</div>
					<div class="clear"></div>
					<?php
						$assignedMilestonList= array('0'=>'All Milestones');
						foreach($completedMilestonData as $amd){
							if(is_numeric($amd->milestoneId) && ($amd->milestoneId >=1)){
								$assignedMilestonList[$amd->milestoneId]=$amd->title;
							}
						}
						echo '<div class=" row   pb10 pr">';
						echo form_dropdown('compeletedMiletoneLink', $assignedMilestonList, 0,'id="compeletedMiletoneLink" class="selectBox width200px l0px" onchange="showTasks(this, this.value,\'milestone\');" ');
						echo '</div>';
					?>
				 </div>
				<?php 
			 } ?>
			 
		<div class="clear"></div>
	</div>
	<!--To - Do Lists Start -->
		<div class="seprator_25 clear"></div>
		<div class="row frm_heading"><h1 class="">To - Do Lists</h1></div>
		<div class="seprator_15"></div> 
		<?php
		foreach($taskData as $i=>$data ){
			$startDate = $data->startDate;
			$endDate = $data->endDate;
			
			$data->startDate = date("d M Y", strtotime($data->startDate));
			$data->endDate = date("d M Y", strtotime($data->endDate));
			
			$jsonData=json_encode($data);
			$dn='';
			if($data->status==3 || $data->status==5){
				$dn='dn';
			}
			
			$memberName = ($data->enterprise == 't')?$data->enterpriseName:$data->firstName.' '.$data->lastName;
			$countComments[$data->taskId]=countResult('CollaborationComments',array('elementId'=>$data->taskId,'entityId'=>getMasterTableRecord('CollaborationTasks')));
			
			if($userId==$ownerId || $assignee > 0 && $assignee==$data->memberId || checkCollabAccess($userCollabAccess, 'view_others_task')){
				?>
				<script>var dataCM<?php echo $i;?> = <?php echo $jsonData;?>;</script>
				
				<div id="PendingData<?php  echo $data->taskId; ?>" class="row p5 taskData <?php echo $dn;?> memberId0 memberId<?php echo $data->memberId;?> milestone0 milestone<?php echo $data->milestoneId;?>">
					<!--extract_heading_box-->
					<div class="cell width30px" >
					<?php if($userId==$ownerId || ($assignee > 0 && $assignee==$data->memberId && checkCollabAccess($userCollabAccess, 'change_own_task_status')) || checkCollabAccess($userCollabAccess, 'change_others_task_status')){?>
						<div class="defaultP"><input type="checkbox" class="taskIdInput" value="3" id="PendingTaskId<?php  echo $data->taskId; ?>" onclick="changeTaskStatus(this,'<?php  echo $data->taskId; ?>',1);" ></div>
					<?php }else echo "&nbsp;"; ?>
					</div>
					<div class="cell ptr" onclick="window.location.href='<?php echo base_url(lang().'/collaboration/taskDetails/'.$data->taskId.'/'.$collaborationId);?>'; ">
						<div class="row" >
							<div class="cell width150px b"> <?php  if($data->memberId==0) echo 'All Mebers'; else echo $memberName; ?>: </div>
							
							<div class="cell width350px"> <?php  echo getSubString($data->title, 60); ?> </div>
							
							<div class="cell width100px"> <?php  echo date("d M Y", strtotime($startDate)); ?> </div>
							<?php if($countComments[$data->taskId] >=1){?>
							<div class="cell width100px"><div class="icon_comments"><?php echo $countComments[$data->taskId];?></div></div>
							<?php }?>
							<!--<div class="cell width100px"> <?php  echo date("d M Y", strtotime($endDate )); ?> </div> -->
						</div>
					</div>
					<?php if($userId==$ownerId || checkCollabAccess($userCollabAccess, 'delete_task')){?>
					<div class="cell fr">
						<div  class="small_btn formTip mr0" title="<?php echo $this->lang->line('delete');?>"><a href='javascript:collaborationtaskDelete(<?php echo $data->taskId;?>,<?php echo $data->fileId;?>)' ><div class="cat_smll_plus_icon"></div></a></div>
						<div class="small_btn formTip mr0" title="<?php echo $this->lang->line('edit');?>"><a href="javascript:void(0)" onclick="fillFormValueCM(dataCM<?php echo $i;?>,'#collaborationtaskFormDiv');" ><div class="cat_smll_edit_icon"></div></a></div>
					</div>
					<?php }?>
					<div class="clear"></div>
				</div>
				
				<?php
			}  	
		}?>
	<!--To - Do Lists End -->
	
	<!--To - Completed To - Do Lists Start -->
		<div class="seprator_25 clear"></div>
		<div class="row frm_heading"><h1 class="">Completed To - Do Lists</h1></div>
		<div class="seprator_15"></div> 
		<?php
		foreach($taskData as $i=>$data ){
			$startDate = $data->startDate;
			$endDate = $data->endDate;
			
			$data->startDate = date("d M Y", strtotime($data->startDate));
			$data->endDate = date("d M Y", strtotime($data->endDate));
			
			$jsonData=json_encode($data);
			$dn='dn';
			if($data->status==3 || $data->status==5){
				$dn='';
			}
			$memberName = ($data->enterprise == 't')?$data->enterpriseName:$data->firstName.' '.$data->lastName;
			
			if($userId==$ownerId || $assignee > 0 && $assignee==$data->memberId || checkCollabAccess($userCollabAccess, 'view_others_task')){

				?>
				<div id="compeletedData<?php  echo $data->taskId; ?>" class="row clr_999 p5 taskData <?php echo $dn;?> memberId0 memberId<?php echo $data->memberId;?> milestone0 milestone<?php echo $data->milestoneId;?>">
					<!--extract_heading_box-->
					<div class="cell width30px" >
					<?php if($userId==$ownerId || ($assignee > 0 && $assignee==$data->memberId && checkCollabAccess($userCollabAccess, 'change_own_task_status')) || checkCollabAccess($userCollabAccess, 'change_others_task_status')){?>
						<div class="defaultP"><input checked type="checkbox" id="compeletedTaskId<?php  echo $data->taskId; ?>" class="taskIdInput" value="3" onclick="changeTaskStatus(this,'<?php  echo $data->taskId; ?>',0);" ></div>
					<?php }else echo "&nbsp;";?>
					</div>
					<div class="cell ptr" onclick="window.location.href='<?php echo base_url(lang().'/collaboration/taskDetails/'.$data->taskId.'/'.$collaborationId);?>'; ">
						<div class="row" >
							<div class="cell width150px b"> <?php  if($data->memberId==0) echo 'All Mebers'; else echo $memberName; ?>: </div>
							
							<div class="cell width350px"> <?php  echo getSubString($data->title, 60); ?> </div>
							
							<div class="cell width100px"> <?php  echo date("d M Y", strtotime($startDate)); ?> </div>
							<?php if($countComments[$data->taskId] >=1){?>
							<div class="cell width100px"><div class="icon_comments formTip" title="Comments"><?php echo $countComments[$data->taskId];?></div></div>
							<?php }?>
							<!--<div class="cell width100px"> <?php  echo date("d M Y", strtotime($endDate )); ?> </div> -->
						</div>
					</div>
					<?php if($userId==$ownerId || checkCollabAccess($userCollabAccess, 'delete_task')){?>
						<div class="cell fr">
							<div  class="small_btn formTip mr0" title="<?php echo $this->lang->line('delete');?>"><a href='javascript:collaborationtaskDelete(<?php echo $data->taskId;?>,<?php echo $data->fileId;?>)' ><div class="cat_smll_plus_icon"></div></a></div>
							<div class="small_btn formTip mr0" title="<?php echo $this->lang->line('edit');?>"><a href="javascript:void(0)" onclick="fillFormValueCM(dataCM<?php echo $i;?>,'#collaborationtaskFormDiv');" ><div class="cat_smll_edit_icon"></div></a></div>
						</div>
					<?php } ?>
					<div class="clear"></div>
				</div>
				<?php
			} 	
		}
	?>
	<!--To - Completed To - Do Lists Start -->
	
	<div class="seprator_25 clear"></div>
	<script>
	function fillFormValueCM(data,formId){
		var browseId = '<?php echo $browseId;?>';
		$('label.error').remove();
		$('input.error').each(function(index){
			var inputClass =$(this).attr('class').replace('error', '');
			$(this).attr('class',inputClass);
		});
		if(!$(formId).is(":visible")){
				$(formId).slideToggle('slow');
		}
		//-----------file add condition------------//
			$.each(data, function(key, value){
			  if($(formId+' form [name=' + key + ']') !='undefind'){
				  $(formId+' form [name=' + key + ']').val(value);
			  }
			});
			setSeletedValueOnDropDown('milestoneId',data.milestoneId);
			setSeletedValueOnDropDown('status',data.status);
			setSeletedValueOnDropDown('priority',data.priority);
			setSeletedValueOnDropDown('completePercentage',data.completePercentage);
			setSeletedValueOnDropDown('memberId',data.memberId);
	}
	
	function changeTaskStatus(obj,taskId,action){
		
		var data= '&taskId='+taskId+'&action='+action;
		var url = baseUrl+language+'/collaboration/changeTaskStatus/';
		$.post(url,data, function(data) {
		  if(data){
			  if(data.statuschanged){
				if(action==1){
					$("#PendingData"+taskId).fadeOut("slow");
					$("#PendingData"+taskId).removeClass(' dn').addClass(' dn');
					
					$("#compeletedData"+taskId).fadeIn("slow");
					$("#compeletedData"+taskId).removeClass(' dn')
				}else{
					$("#compeletedData"+taskId).fadeOut("slow");
					$("#compeletedData"+taskId).removeClass(' dn').addClass(' dn');
					
					$("#PendingData"+taskId).fadeIn("slow");
					$("#PendingData"+taskId).removeClass(' dn')
				}
				$("#PendingTaskId"+taskId).attr("checked",false);
				$("#compeletedTaskId"+taskId).attr("checked",true);
				runTimeCheckBox();
			  }
		  }
		},"json");
	}
	
	function showTasks(obj, val, section){
		
		$('.taskData').each(function(index){
			var classname =$(this).attr('class');
			var pos=classname.indexOf(section+val);
			var pos_dn=classname.indexOf(' dn');
			if(pos_dn == -1){
				if(pos==-1){
					$(this).fadeOut("slow");
				}else{
					$(this).fadeIn("slow");
				}
			}
		});
	}

	</script> <?php
	if($assignee > 0){
		echo "<script> showTasks('#assignee', ".$assignee.",'memberId'); </script>";
	}
} ?>

