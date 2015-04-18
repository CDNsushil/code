<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if(isset($milestoneData) && count($milestoneData) > 0 && !empty($milestoneData) ) { ?>

	<div class="row frm_heading"><h1 class="">Milestones</h1></div>
	<div class="seprator_15"></div> 
	
	<?php
	foreach($milestoneData as $i=>$data ){
		
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
		<div id="PendingData<?php  echo $data->milestoneId; ?>" class="row p5 <?php echo $dn;?>">
				<?php if($userId==$ownerId || checkCollabAccess($userCollabAccess, 'change_milestone_status')){?>
					<div class="cell" >
						<div class="defaultP"><input type="checkbox" class="milestoneIdInput" value="3" id="PendingMilestoneId<?php  echo $data->milestoneId; ?>" onclick="changeMilestoneStatus(this,'<?php  echo $data->milestoneId; ?>',1);" ></div>
					</div>
				<?php }?>
				
				<div class="cell ptr" onclick="lightBoxWithAjax('popupBoxWp','popup_box','/collaboration/milestoneDetails/',dataCM<?php echo $i;?>);">
					<div class="row" >
						<div class="cell width200px b"> <?php  echo getSubString($data->title, 35); ?>: </div>
						
						<div class="cell width400px"> <?php  echo getSubString($data->description, 65); ?> </div>
						
						<div class="cell width100px"> <?php  echo date("d M Y", strtotime($startDate)); ?> </div>
						<!--<div class="cell width100px"> <?php  echo date("d M Y", strtotime($endDate )); ?> </div> -->
					</div>
				</div>
				<?php if($userId==$ownerId || checkCollabAccess($userCollabAccess, 'delete_milestone')){?>						 
				<div class="cell fr">
					<div  class="small_btn formTip mr0" title="<?php echo $this->lang->line('delete');?>"><a href='javascript:collaborationmilestoneDelete(<?php echo $data->milestoneId;?>,<?php echo $data->fileId;?>)' ><div class="cat_smll_plus_icon"></div></a></div>
					<div class="small_btn formTip mr0" title="<?php echo $this->lang->line('edit');?>"><a href="javascript:void(0)" onclick="fillFormValueCM(dataCM<?php echo $i;?>,'#collaborationmilestoneFormDiv');" ><div class="cat_smll_edit_icon"></div></a></div>
				</div>
				<?php }?>
			<div class="clear"></div>
		</div>
		<?php  	
	} ?>
	
	<div class="seprator_25 clear"></div>
	<div class="row frm_heading"><h1 class="">Completed Milestones</h1></div>
	<div class="seprator_15"></div> 
	
	<?php
	foreach($milestoneData as $i=>$data ){
		
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
		<script>var dataCM<?php echo $i;?> = <?php echo $jsonData;?>;</script>
		<div id="compeletedData<?php  echo $data->milestoneId; ?>" class="row clr_999 p5 <?php echo $dn;?>">
				<?php if($userId==$ownerId || checkCollabAccess($userCollabAccess, 'change_milestone_status')){?>
				<div class="cell" >
					<div class="defaultP"><input type="checkbox" checked class="milestoneIdInput" value="3" id="compeletedMilestoneId<?php  echo $data->milestoneId; ?>" onclick="changeMilestoneStatus(this,'<?php  echo $data->milestoneId; ?>',0);" ></div>
				</div>
				<?php }?>
				
				<div class="cell ptr" onclick="lightBoxWithAjax('popupBoxWp','popup_box','/collaboration/milestoneDetails/',dataCM<?php echo $i;?>);">
					<div class="row" >
						<div class="cell width200px b"> <?php  echo getSubString($data->title, 35); ?>: </div>
						
						<div class="cell width400px"> <?php  echo getSubString($data->description, 65); ?> </div>
						
						<div class="cell width100px"> <?php  echo date("d M Y", strtotime($startDate)); ?> </div>
						<!--<div class="cell width100px"> <?php  echo date("d M Y", strtotime($endDate )); ?> </div> -->
					</div>
				</div>
											 
				<?php if($userId==$ownerId || checkCollabAccess($userCollabAccess, 'delete_milestone')){?>	
				<div class="cell fr">
					<div  class="small_btn formTip mr0" title="<?php echo $this->lang->line('delete');?>"><a href='javascript:collaborationmilestoneDelete(<?php echo $data->milestoneId;?>,<?php echo $data->fileId;?>)' ><div class="cat_smll_plus_icon"></div></a></div>
					<div class="small_btn formTip mr0" title="<?php echo $this->lang->line('edit');?>"><a href="javascript:void(0)" onclick="fillFormValueCM(dataCM<?php echo $i;?>,'#collaborationmilestoneFormDiv');" ><div class="cat_smll_edit_icon"></div></a></div>
				</div>
				<?php }?>
				
			<div class="clear"></div>
		</div>
		<?php  	
	} ?>
	
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
		}
		
		function changeMilestoneStatus(obj,milestoneId,action){
			var data= '&milestoneId='+milestoneId+'&action='+action;
			var url = baseUrl+language+'/collaboration/changeMilestoneStatus/';
			$.post(url,data, function(data) {
			  if(data){
				  if(data.statuschanged){
					if(action==1){
						$("#PendingData"+milestoneId).fadeOut("slow");
						$("#PendingData"+milestoneId).removeClass(' dn').addClass(' dn');
						
						$("#compeletedData"+milestoneId).fadeIn("slow");
						$("#compeletedData"+milestoneId).removeClass(' dn')
					}else{
						$("#compeletedData"+milestoneId).fadeOut("slow");
						$("#compeletedData"+milestoneId).removeClass(' dn').addClass(' dn');
						
						$("#PendingData"+milestoneId).fadeIn("slow");
						$("#PendingData"+milestoneId).removeClass(' dn')
					}
					$("#PendingMilestoneId"+milestoneId).attr("checked",false);
					$("#compeletedMilestoneId"+milestoneId).attr("checked",true);
					runTimeCheckBox();
				  }
			  }
			},"json");
		}
	</script>
	
	<?php
}
?>
		
