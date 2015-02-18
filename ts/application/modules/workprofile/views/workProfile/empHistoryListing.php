<?php 
$currentId = array(
	'name'=>'currentId',
	'id'=>'currentId',
	'type'=>'hidden'
);
$swapId = array(
	'name'=>'swapId',
	'id'=>'swapId',
	'type'=>'hidden'
);
$currentPosition = array(
	'name'=>'currentPosition',
	'id'=>'currentPosition',
	'type'=>'hidden'
);
$swapPosition = array(
	'name'=>'swapPosition',
	'id'=>'swapPosition',
	'type'=>'hidden'
);

$toogleId = 'empHis';
?>

	
<div class="row form_wrapper">
		
<div class="row">
	<div class="cell frm_heading">
		<h1><?php echo $label['employmentHistory']?></h1>
	</div>
<?php $this->load->view('workProfile/navigationMenu');?>
</div>
	<div class="row ">
		<div class="cell tab_left">
			<div class="tab_heading">
			<?php echo $label['employmentHistory']?>
			</div><!--tab_heading-->
		</div>
		<div class="cell tab_right">
			<div class="tab_btn_wrapper">					
				<div class="tds-button-top" id="addIcon"> 				
				<?php
					$attr = array('onclick'=>'canceltoggle(1);');
					echo anchor('javascript://void(0);', '<span><div class="projectAddIcon"></div></span>',$attr);					
				?>		
				</div>			
			</div>
		</div>
		
	</div><!--row-->	
	<div class="clear"></div>
	
<div class="row frm_strip_bg">
<div class="row"><div class="tab_shadow"></div></div>
<?php /*
<div class="row ">
	<div class="cell tab_left">
		<div class="tab_heading">
			<?php echo $label['employmentHistory']; ?>
		</div><!--tab_heading-->
	</div>
	<div class="cell tab_right">
		<div class="tab_btn_wrapper ">
			<div class="tds-button-top"> 
				<!-- Post add Icon -->
					<a class="formTip formToggleIcon" title="<?php echo $label['add'];?>" onclick='canceltoggle(1);' toggleDivForm="EmpForm-Content-Box" toggleDivIcon="empToggleIcon" >
					<span><div class="projectAddIcon"></div></span>
					</a>

			</div>
		</div>
	</div>
</div><!--row-->
<div class="tab_shadow"></div>
* */?>

<div class="row dn" id="EmpForm-Content-Box">	 
<?php 		
	$this->load->view('workProfile/add_more_emphistory');
?>
</div>
<div class="row" id="EmpContent"><!-- Show List Of SocialContent -->
<?php	
	$countRecord =  count($values)-1;
	$countTotalRecord =  count($values);
		$i = 0; 
		if($values !=''){
			//echo "<pre>"; print_r($values);
			$attributes = array('name' => 'empHistory', 'id' => 'empHistory');
			echo form_open('workprofile/deleteEmpHistory',$attributes);
			echo form_hidden('delEmpHistId','');
			echo form_hidden('empHistoryIdForUp','');	
			echo form_hidden('empHistoryIdForDown','');
			echo form_input($currentId);	
			echo form_input($swapId);
			echo form_input($currentPosition);
			echo form_input($swapPosition);
			echo form_hidden('empIdForSwap','');
?>



		<div class="row"> 
			<div class="empty_label_wrapper cell"><label><?php //echo $label['employmentHistory'];?></label></div><!--label_wrapper-->
			<div class="cell frm_element_wrapper lH30">
				<div class="cell width120px pl10">
					<label class="orange"><?php echo $label['compName']?></label></div>
<?php /* commented as required by client
				<div class="cell width82px ml20">
					<label class="orange"><?php echo $label['startDate']?></label></div>

				<div class="cell width82px ml20">
					<label class="orange"><?php echo $label['endDate']?></label></div>
*/ ?>
				<div class="cell width300px ml20">
					<label class="orange"><?php echo $label['empDesignation']?></label></div>

				<div class="cell width100px ml20">
					<label class="orange"><?php //echo $label['actions']?></label></div>
				
			</div>
		</div>
	<div class="row line1"></div>
	<div id="pagingContent">
		<div class="row">
			<div class="empty_label_wrapper cell"></div>
			<div class=" cell frm_element_wrapper width_551 pt5 pl10 mb0">
		<?php
		$empEndDate_array = search_nested_arrays($values,'empEndDate');
		
		$checkTillDate = 1;
		
		if (in_array("0", $empEndDate_array)) {
			$checkTillDate=0;
			
		}
		foreach($values as $k=>$row){
		
		//echo $countRecord."<br />";
		?>		
			
			<div class=" cell extract_content_bg_PR width_551 pt5 pl20 mb10">
				<div class="all_list_item ">
					<div class="pb10">
						<div class="cell width120px fontB oh height_22">
							<?php echo $row['compName'];?>
						</div>
						<?php /* commented as required by client
						<div class="cell width82px ml20">
						<?php
							$startDate = get_timestamp("d F Y",$row['empStartDate']);
							echo $startDate;?>
						</div>
						<div class="cell width82px ml20">
						<?php
						if($row['empEndDate']== 0){
							$endDate = 'Till Date';
							echo $endDate;
							}else{
							$endDate = get_timestamp("d F Y",$row['empEndDate']);
							}
							?>
						</div>
						*/ ?>
						<div class="cell width_310 ml20">
							<?php echo $row['empDesignation'];?>
						</div>
						<div class="pro_btns ml20">
							<?php //echo '<pre />';print_r($row);
								
								if($i!=$countRecord)
								{
									$moveDown =  array("onclick"=>"moveDown('".encode($row['empHistId'])."','".encode(@$values[$k+1]['empHistId'])."','".$row['position']."','".@$values[$k+1]['position']."')",'title'=>$label['moveDown'],'class'=>'formTip');
									
									echo '<div class="small_btn ">'.anchor('javascript://void(0);', '<div class="smll_down_arrow_icon"></div>',$moveDown).'</div>';
								}
								else
								{
									$moveDown = array('title'=>$label['notMovable'],'class'=>'formTip');
									echo '<div class="small_btn disable_btn">'.anchor('javascript://void(0);', '<div class="smll_down_arrow_icon"></div>',$moveDown).'</div>';
								}

								if($i!=0)
								{
									$moveUp = array("onclick"=>"moveUp('".encode($row['empHistId'])."','".encode(@$values[$k-1]['empHistId'])."','".$row['position']."','".@$values[$k-1]['position']."')",'title'=>$label['moveUp'],'class'=>'formTip');
									echo '<div class="small_btn ">'.anchor('javascript://void(0);', '<div class="smll_up_arrow_icon"></div>',$moveUp).'</div>';
								}
								else
								{
									$moveUp = array('title'=>$label['notMovable'],'class'=>'formTip ');
									echo '<div class="small_btn disable_btn">'.anchor('javascript://void(0);', '<div class="smll_up_arrow_icon"></div>',$moveUp).'</div>';
								}
								
								//echo '<pre />';print_r($row);
								
								//History Edit Icon
								
								$empStartDate= date('F Y',strtotime(@$row['empStartDate']));
							
								if(isset($row['empEndDate']) && @$row['empEndDate']!='0'){
								
									//$checkTillDate =0;
									$empEndDate= date('F Y',strtotime(@$row['empEndDate']));
									//$empEndDate =  date('F Y',strtotime(@$row['empEndDate']));
								}
								else{
									//$checkTillDate=1;
									$empEndDate = 0;
								}
									
								$editArr = array("onclick"=>"editRecord(this);",'empHistId'=>$row['empHistId'],'compName'=>$row['compName'],'empStartDate'=>$empStartDate,'empEndDate'=>$empEndDate,'compAdd'=>$row['compAdd'],'compCountry'=>$row['compCountry'],'compState'=>$row['compState'],'compCity'=>$row['compCity'],'compZip'=>$row['compZip'],'compDesc'=>$row['compDesc'],'empAchivments'=>htmlentities($row['empAchivments']),'empDesignation'=>htmlentities($row['empDesignation']),'neverShowCheckBox'=>$checkTillDate,'period'=>$row['period'],'title'=>$label['edit'],'class'=>"formTip");								
								
								//History Delete Icon
								$attr = array("onclick"=>"DeleteAction('".encode($row['empHistId'])."')","title"=>$label['delete'],'class'=>'formTip');
							
								echo '<div class="small_btn">'.anchor('javascript://void(0);','<span><div class="cat_smll_plus_icon"></div></span>',$attr).'</div>';	
								
								echo '<div class="small_btn">'.anchor('javascript://void(0);', '<span><div class="cat_smll_edit_icon"></div></span>',$editArr).'</div>';		
								
							?>
							<input type="hidden" id="neverShowCheckBox" value="<?php echo $checkTillDate;?>" />
						</div>
						<div class="cell" style="padding-left:2px;">&nbsp;</div>
					</div><!--End of pb10 -->
				</div><!--End of all_list_item -->
			</div><!--  cell frm_element_wrapper-->
		<!--End of row -->
		<?php $i ++; } ?>
		</div>
		</div>
		</div><!--End of pagingContent -->
	<div class="clear"></div>
	<?php 
	} //End if 	
		
	if(empty($values)) 
	{ 
	?>
	<div class="row">
			<div class="empty_label_wrapper cell"></div>
			<div class=" cell frm_element_wrapper">
				<div class='p10'><a href='javascript:void(0);' onclick='canceltoggle(1);' class='a_orange' ><?php echo $label['add'];?></a></div>
			</div>
			<div class="clear"></div>
	</div>
	<?php			
	}
	
	$data['record_num'] =10; if(!empty($values) && (count($values) > 10)) { $this->load->view('pagination_view',$data);}
	
	?>
</div><!--right_panel-->
</div>
</div><!--Main-->
<div class="row"><div class="tab_shadow"></div></div>
<script language="javascript" type="text/javascript">
function DeleteAction(empHistoryId)
{
	var conBox = confirm(areYouSure);
	if(conBox){
		document.empHistory.delEmpHistId.value = empHistoryId;
		document.empHistory.submit();
	}
	else{
		return false;
	}
}
	
function editRecord(obj)
{	
	var val1 = $(obj).attr('empHistId');
	var val2 = $(obj).attr('compName');
	var val3 = $(obj).attr('empStartDate');
	var val4 = $(obj).attr('empEndDate');
	var val5 = $(obj).attr('compAdd');
	var val6 = $(obj).attr('compCountry');
	var val7 = $(obj).attr('compState');
	var val8 = $(obj).attr('compCity');
	var val9 = $(obj).attr('compZip');
	var val10 = $(obj).attr('empAchivments');
	var val11 = $(obj).attr('empDesignation');
	var val12 = $(obj).attr('compDesc');	
	var val13 = $(obj).attr('neverShowCheckBox');
	var val14 = $(obj).attr('period');
	
	$('#compName').focus();
	$('#empHistId').val(val1);
	$('#compName').val(val2);
	$('#empStartDate').val(val3);
	$('#empEndDate').val(val4);
	$('#compAdd').val(val5);
	$('#compCountry').val(val6);
	setSeletedValueOnDropDown('compCountry',val6);
	$('#compState').val(val7);
	$('#compCity').val(val8);
	$('#compZip').val(val9);
	$('#empAchivments').val(val10);
	$('#myInstance1').html(val10);
	$('#empDesignation').val(val11);
	$('#compDesc').val(val12);	
	$('#period').val(val14);	
	
	if(val13 ==1) $('#endDateCHeckBoxDiv').show();
	else $('#endDateCHeckBoxDiv').hide();
	
	if(val4==0)
	{
		 $('#endDateCHeckBoxDiv').show();				
		 $('#tillDate').attr('checked','checked');
		 $('#empEndDate').attr('disabled','disabled');
		 $('#empEndDate').val(' ');
		 runTimeCheckBox();
	}
	else  
	{
		$('#tillDate').removeAttr('checked');
		$('#empEndDate').removeAttr('disabled');
		runTimeCheckBox();	
		
		if(val13 !=1){				
			$('#endDateCHeckBoxDiv').hide();			
		}		
	}
	$('#mode').val('edit');
	//selectBox();
	$('#EmpForm-Content-Box').slideDown("slow");
	$('#EmpHistoryTitle').html('Edit');
	
}

function canceltoggle(showFlag){
	
	var val1 = 0;
	var val2 = '';
	var val3 = '';
	var val4 = '';
	var val5 = '';
	var val6 = '';
	var val7 = '';
	var val8 = '';
	var val9 = '';
	var val10 = '';
	var val11 = '';
	var val12 = $('#neverShowCheckBox').val();	
	$('#empHistId').val(val1);
	$('#compName').val(val2);
	$('#empStartDate').val(val3);
	$('#empEndDate').val(val4);
	$('#compAdd').val(val5);
	$('#compCountry').val(val6);
	$('#compState').val(val7);
	$('#compCity').val(val8);
	$('#compZip').val(val9);
	$('#empAchivments').val(val10);
	$('#empDesignation').val(val11);
	
	$('#mode').val('new');
	//selectBox();
	
	if(showFlag == 1)
	{		
		$('#EmpForm-Content-Box').slideToggle("slow");
		if(<?php echo $countTotalRecord;?>==0){
			$('#endDateCHeckBoxDiv').show();
			$('#empEndDate').attr('disabled','disabled');	
		}
		else{		
			if(val12 == 1 ) {
				$('#endDateCHeckBoxDiv').show();	
				$('#empEndDate').attr('disabled','disabled');
			}		
			else { 
				$('#endDateCHeckBoxDiv').hide();
				$('#empEndDate').removeAttr('disabled');
			}
		}	
	}
	else
	{
		
		$('#EmpForm-Content-Box').slideUp("slow");
		
		if($('#'+toggleDivIcon).css("background-position")=='-1px -121px')
		{
			$('#'+toggleDivIcon).css("background-position","-1px -144px");			
		}else
		{
			$('#'+toggleDivIcon).css("background-position","-1px -121px");
		}
	}
		
}

function moveUp(empHistoryIdForUp)
{  
	document.empHistory.empHistoryIdForUp.value = empHistoryIdForUp;
	document.empHistory.submit();
	//window.location = "<?php base_url()?>workprofile/moveUp/"+empHistoryId;
}


function moveUp(currentId,swapId,currentPosition,swapPosition)
{	 
	$('#currentId').val(currentId);
	$('#swapId').val(swapId);
	$('#currentPosition').val(currentPosition);
	$('#swapPosition').val(swapPosition);
	document.empHistory.empIdForSwap.value = 1;
	document.empHistory.submit();	

	 
}

function moveDown(currentId,swapId,currentPosition,swapPosition)
{	 
	$('#currentId').val(currentId);
	$('#swapId').val(swapId);
	$('#currentPosition').val(currentPosition);
	$('#swapPosition').val(swapPosition);
	document.empHistory.empIdForSwap.value = 1;
	document.empHistory.submit();
	
}

$(document).ready(function() {
	
	if(<?php echo $countTotalRecord;?>==0) { $('#endDateCHeckBoxDiv').removeClass('dn'); }
	else $('#endDateCHeckBoxDiv').hide();
});
</script>

