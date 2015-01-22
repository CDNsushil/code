<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if(isset($taskData) && count($taskData) > 0 && !empty($taskData) ) { ?>
		<div class="row todo_filter_box ml5">
			<div class="cell milestone_box width200px">
				<div class=" row ml3 mt6 pb5">Filter By Members</div>
				<div class="clear"></div>
				<?php
					if(isset($taskData) && is_array($taskData) && count($taskData) > 0){
						$assigneeList= array('0'=>'All Members');
						foreach($taskData as $td){
							if(is_numeric($td->memberId) && ($td->memberId >=1)){
								$assigneeList[$td->memberId]=$td->firstName.' '.$td->lastName;
							}
						}
					}
					echo '<div class=" row   pb10 pr">';
					echo form_dropdown('assignee', $assigneeList, 0,'id="assignee" class="selectBox width150px l0px" onchange="showTasks(this, this.value,\'memberId\');" ');
					echo '</div>';
				?>
			 </div>
			
			 <?php 
			 if(isset($assignedMilestonData) && is_array($assignedMilestonData) && count($assignedMilestonData) > 0){
			 ?>
				<div class="cell milestone_box ">
					<div class="rpw ml3 mt6 pb5 ptr miletoneLink" onclick="showTasks(this, 0,'milestone');">Milestones</div>
					
					
					<div id="pMilestone" class="slider event_scroll_btn_box ">		
						<div style="height:80px; width:200px" class="viewport cs_article">
							<ul class="overview" style="width: 200px; left: -175px;">
								
								<?php
									foreach($assignedMilestonData as $i=>$amd){
										if($i % 2 == 0){
											echo '<li style="height:60px; width:230px; float:left">';
											$liOpenFlag=true;
										}
										echo '<div class="row "><a class="miletoneLink f11" href="javascript:void(0);" onclick="showTasks(this, '.$amd->milestoneId.',\'milestone\');">'.getSubString($amd->title, 30).'</a></div>';
									
										if(($i-1) % 2 == 0){
											echo '</li>';
											$liOpenFlag=false;
										}
									}
									if($liOpenFlag){
										echo '</li>';
									}
								?>
							</ul>
							<div class="clear"></div>
						</div><!-- End viewport-->

						<div class="clear"></div>
						<div class="pr">
							<div class="z_index_2 position_relative">
								<a href="#" class="buttons next disable"></a><a href="#" class="buttons prev mr15"></a>
							</div>

							<div class="fakebtn z_index_1">
								<span class="buttons next"></span><span class="buttons prev mr15"></span>
							</div>
						</div>	
						<div class="clear"></div>
					</div>
					
					
					
					
				 </div>
				<?php 
			 }
			 
			 if(isset($completedMilestonData) && is_array($completedMilestonData) && count($completedMilestonData) > 0){
			 ?>
				<div class="cell milestone_box ">
					<div class="rpw ml3 mt6 pb5 ptr miletoneLink" onclick="showTasks(this, 0,'milestone');">Completed Milestones</div>
					
					
					<div id="cMilestone" class="slider event_scroll_btn_box ">		
						<div style="height:80px; width:200px" class="viewport cs_article">
							<ul class="overview" style="width: 200px; left: -175px;">
								
								<?php
									foreach($completedMilestonData as $i=>$amd){
										if($i % 2 == 0){
											echo '<li style="height:60px; width:230px; float:left">';
											$liOpenFlag=true;
										}
										echo '<div class="row "><a class="miletoneLink f11" href="javascript:void(0);" onclick="showTasks(this, '.$amd->milestoneId.',\'milestone\');">'.getSubString($amd->title, 30).'</a></div>';
									
										if(($i-1) % 2 == 0){
											echo '</li>';
											$liOpenFlag=false;
										}
									}
									if($liOpenFlag){
										echo '</li>';
									}
								?>
							</ul>
							<div class="clear"></div>
						</div><!-- End viewport-->

						<div class="clear"></div>
						<div class="pr">
							<div class="z_index_2 position_relative">
								<a href="#" class="buttons next disable"></a><a href="#" class="buttons prev mr15"></a>
							</div>

							<div class="fakebtn z_index_1">
								<span class="buttons next"></span><span class="buttons prev mr15"></span>
							</div>
						</div>	
						<div class="clear"></div>
					</div>
					
					
					
					
				 </div>
				<?php 
			 }?>
				 
				 
			 
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
			
			?>
			<script>var dataCM<?php echo $i;?> = <?php echo $jsonData;?>;</script>
			
			<div id="PendingData<?php  echo $data->taskId; ?>" class="row p5 taskData <?php echo $dn;?> memberId0 memberId<?php echo $data->memberId;?> milestone0 milestone<?php echo $data->milestoneId;?>">
				<!--extract_heading_box-->
				<div class="cell" >
					<div class="defaultP"><input type="checkbox" class="taskIdInput" value="3" id="PendingTaskId<?php  echo $data->taskId; ?>" onclick="changeTaskStatus(this,'<?php  echo $data->taskId; ?>',1);" ></div>
				</div>
				
				<div class="cell ptr" onclick="lightBoxWithAjax('popupBoxWp','popup_box','/collaboration/taskDetails/',dataCM<?php echo $i;?>);">
					<div class="row" >
						<div class="cell width200px b"> <?php  if($data->memberId==0) echo 'All Mebers'; else echo $data->firstName.' '.$data->lastName; ?>: </div>
						
						<div class="cell width400px"> <?php  echo getSubString($data->title, 60); ?> </div>
						
						<div class="cell width100px"> <?php  echo date("d M Y", strtotime($startDate)); ?> </div>
						<!--<div class="cell width100px"> <?php  echo date("d M Y", strtotime($endDate )); ?> </div> -->
					</div>
				</div>
				
				<div class="cell fr">
					<div  class="small_btn formTip mr0" title="<?php echo $this->lang->line('delete');?>"><a href='javascript:collaborationtaskDelete(<?php echo $data->taskId;?>,<?php echo $data->fileId;?>)' ><div class="cat_smll_plus_icon"></div></a></div>
					<div class="small_btn formTip mr0" title="<?php echo $this->lang->line('edit');?>"><a href="javascript:void(0)" onclick="fillFormValueCM(dataCM<?php echo $i;?>,'#collaborationtaskFormDiv');" ><div class="cat_smll_edit_icon"></div></a></div>
				</div>
				<div class="clear"></div>
			</div>
			
			<?php  	
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
			
			?>
			
			
			<div id="compeletedData<?php  echo $data->taskId; ?>" class="row p5 taskData <?php echo $dn;?> memberId0 memberId<?php echo $data->memberId;?> milestone0 milestone<?php echo $data->milestoneId;?>">
				<!--extract_heading_box-->
				<div class="cell" >
					<div class="defaultP"><input checked type="checkbox" id="compeletedTaskId<?php  echo $data->taskId; ?>" class="taskIdInput" value="3" onclick="changeTaskStatus(this,'<?php  echo $data->taskId; ?>',0);" ></div>
				</div>
				<div class="cell ptr" onclick="lightBoxWithAjax('popupBoxWp','popup_box','/collaboration/taskDetails/',dataCM<?php echo $i;?>);">
					<div class="row" >
						<div class="cell width200px b"> <?php  if($data->memberId==0) echo 'All Mebers'; else echo $data->firstName.' '.$data->lastName; ?>: </div>
						
						<div class="cell width400px"> <?php  echo getSubString($data->title, 60); ?> </div>
						
						<div class="cell width100px"> <?php  echo date("d M Y", strtotime($startDate)); ?> </div>
						<!--<div class="cell width100px"> <?php  echo date("d M Y", strtotime($endDate )); ?> </div> -->
					</div>
				</div>
				<div class="cell fr">
					<div  class="small_btn formTip mr0" title="<?php echo $this->lang->line('delete');?>"><a href='javascript:collaborationtaskDelete(<?php echo $data->taskId;?>,<?php echo $data->fileId;?>)' ><div class="cat_smll_plus_icon"></div></a></div>
					<div class="small_btn formTip mr0" title="<?php echo $this->lang->line('edit');?>"><a href="javascript:void(0)" onclick="fillFormValueCM(dataCM<?php echo $i;?>,'#collaborationtaskFormDiv');" ><div class="cat_smll_edit_icon"></div></a></div>
				</div>
				<div class="clear"></div>
			</div>
			
			<?php  	
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
		
		$('.miletoneLink').each(function(index){
			$(this).removeClass(' orange')
		});
		
		$(obj).addClass(' orange');
			
	}
	
	$(document).ready(function(){
		$('#pMilestone').tinycarousel({ axis: 'x', display: 1, start:1});	
		
		$('#cMilestone').tinycarousel({ axis: 'x', display: 1, start:1});		
	});

	</script> <?php
} ?>

