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


?>
<div class="row form_wrapper">
	<div class="row">
		<div class="cell frm_heading ">
			<h1><?php echo $label['referencesRecommendation'];?></h1>
		</div>
		<?php $this->load->view('workProfile/navigationMenu');?>
	</div>
	
		<div class="row ">
		<div class="cell tab_left">
			<div class="tab_heading">
			<?php echo $label['referencesRecommendation']?>
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
			<?php echo $label['referencesRecommendation']; ?>
		</div><!--tab_heading-->
	</div>
	<div class="cell tab_right">
		<div class="tab_btn_wrapper ">
			<div class="tds-button-top"> 
				<!-- Post add Icon -->
					<a class="formTip formToggleIcon" title="<?php echo $label['add'];?>" onclick='canceltoggle(1);'  toggleDivForm="RefForm-Content-Box" toggleDivIcon="refToggleIcon" >
					<span><div class="projectAddIcon"></div></span>
					</a>

			</div>
		</div>
	</div>
</div><!--row-->
<div class="tab_shadow"></div>
*/?>

<div class="row dn" id="RefForm-Content-Box">
<?php 
	//To load add social link
	$this->load->view('workProfile/addMoreReferencesRecommendations');		
?>
</div>
<div class="row" id="RefContent"><!-- Show List Of SocialContent -->
<?php
	$countRecord =  count($values)-1;
	$i = 0; 
	if(!empty($values))
	{
	echo form_open('workprofile/deleteReferencesRecommendations',"name='referencesRecommendations'");
	echo form_hidden('delRefId','');
	echo form_hidden('refIdForUp','');	
	echo form_hidden('refIdForDown','');
	echo form_input($currentId);	
	echo form_input($swapId);
	echo form_input($currentPosition);
	echo form_input($swapPosition);
	echo form_hidden('refIdForSwap','');
?>

	<div class="row">
			<div class="label_wrapper cell bg-non"><div class="lable_heading"><h1><?php //echo $label['referencesRecommendation'];?></h1></div></div><!--label_wrapper-->
		<div class=" cell frm_element_wrapper lH30">
			<div class="cell width90px height33 pl12"><label class="orange"><?php echo $label['name']?></label></div>
			<div class="cell width90px  ml20"><label class="orange"><?php echo $label['refCompany']?></label></div>
			<div class="cell width90px  ml20"><label class="orange"><?php echo $label['refEmailAdd']?></label></div>
			<div class="cell width90px  ml20"><label class="orange"><?php echo $label['refPhone']?></label></div>
			<div class="cell width90px  ml20"><label class="orange"><?php //echo $label['actions']?></label></div>
	<!--	<div class="row line1"></div> -->
		</div>
	</div>
	
	<div id="pagingContent">
		<?php
		
		foreach($values as $k=>$row)
		{ 
		?>
		<div class="row">
			<div class="empty_label_wrapper cell"></div>
			<div class=" cell frm_element_wrapper extract_content_bg_PRBG width_545 pt5">
				<div class="all_list_item ">
					<div class="pb10 mH30 row">
						<div class="cell width90px fontB">
							<?php echo $row['refFName'].' '.$row['refLName'];?>
						</div>

						<div class="cell width90px ml20">
							<?php echo $row['refCompName'];?>
						</div>

						<div class="cell width90px ml20 wordWrap" >
						<?php if(!empty($row['refEmail'])) { echo $row['refEmail']; } else { echo "N/A";}?>
						</div>

						<div class="cell width90px ml20">
						<?php if(!empty($row['refContact'])) {   echo $row['refContact']; } else { echo "N/A";}?>
						</div>
						<!--<div class="cell" >&nbsp;</div>
						<div class="cell" style="width:100px;" align="center">
							<?php echo $row['refAdd'].', '.$row['refCity'].', '.$row['refState'].', '.$row['refCountry'].', '.$row['refZip'];?>
						</div>-->
						
						<div class="cell width90px ml20">
							<div class="pro_btns">
							<?php
								
								if($i!=$countRecord)
								{
									//$moveDown = array("onclick"=>"moveDown('".encode($row['refId'])."')",'title'=>$label['moveDown'],'class'=>'formTip');
									
									$moveDown =  array("onclick"=>"moveDown('".encode($row['refId'])."','".encode(@$values[$k+1]['refId'])."','".$row['position']."','".@$values[$k+1]['position']."')",'title'=>$label['moveDown'],'class'=>'formTip');
									echo '<div class="small_btn ">'.anchor('javascript://void(0);', '<span><div class="smll_down_arrow_icon"></div></span>',$moveDown).'</div>';
								}else
								{
									$moveDown = array('title'=>$label['notMovable'],'class'=>'formTip');
									echo '<div class="small_btn disable_btn">'.anchor('javascript://void(0);', '<span><div class="smll_down_arrow_icon"></div></span>',$moveDown).'</div>';
								}
								if($i!=0)
								{
									$moveUp = array("onclick"=>"moveUp('".encode($row['refId'])."','".encode(@$values[$k-1]['refId'])."','".$row['position']."','".@$values[$k-1]['position']."')",'title'=>$label['moveUp'],'class'=>'formTip');
									//$moveUp = array("onclick"=>"moveUp('".encode($row['refId'])."')",'title'=>$label['moveUp'],'class'=>'formTip');
									echo '<div class="small_btn">'.anchor('javascript://void(0);', '<span><div class="smll_up_arrow_icon"></div></span>',$moveUp).'</div>';

								}else
								{
									$moveUp = array('title'=>$label['notMovable'],'class'=>'formTip');
									echo '<div class="small_btn disable_btn">'.anchor('javascript://void(0);', '<span><div class="smll_up_arrow_icon"></div></span>',$moveUp).'</div>';
								}
								
								//History Edit Icon
								$editArr = array("onclick"=>"editRecord(this);",'refId'=>$row['refId'],'refFName'=>$row['refFName'],'refLName'=>$row['refLName'],'refCompName'=>$row['refCompName'],'refAdd'=>$row['refAdd'],'refCountry'=>$row['refCountry'],'refState'=>$row['refState'],'refCity'=>$row['refCity'],'refZip'=>$row['refZip'],'refDescription'=>$row['refDescription'],'refEmail'=>$row['refEmail'],'refContact'=>$row['refContact'],'refURL'=>$row['refURL'],'title'=>$label['edit'],'class'=>"formTip");
									
								//History Delete Icon

								$attr = array("onclick"=>"DeleteAction('".encode($row['refId'])."')","title"=>$label['delete'],'class'=>'formTip');

								echo '<div class="small_btn">'.anchor('javascript://void(0);', '<div class="cat_smll_plus_icon"></div>',$attr).'</div>';
								
								echo '<div class="small_btn">'.anchor('javascript://void(0);', '<div class="cat_smll_edit_icon"></div>',$editArr).'</div>';
								
							?>
						</div>
						</div>
					</div><!--End of pb10 -->
				</div><!--End of all_list_item -->
			</div>
			
		</div><!--End of row -->
		<?php 
		$i ++; 
		} //End Foreach	
		?>
		</div>
		<?php 
		echo form_close(); 
		} //End If
		?>
	<div class="clear"></div>				
<?php 
	if(empty($values)) 
	{ 
		 //echo "<div align='center'><a href='addMoreReferencesRecommendations/0'>".$label['clickHere']."</a> ".$label['addReferencesNRecommendations_2']."</div>"; 
?>
<div class="row">
		<div class="empty_label_wrapper cell"></div>
		<div class=" cell frm_element_wrapper">
		<div class='p10'><a href='javascript:void(0);' onclick='canceltoggle(1);' class='a_orange' title='<?php echo $label['addReferencesNRecommendations_2'];?>'><?php echo $label['add'];?></a></div>
		</div>
		<div class="clear"></div>
</div>
<?php			
	}
?>
<?php $data['record_num'] =10;  if(!empty($values) && (count($values) > 10)) { $this->load->view('pagination_view',$data);}?>
</div><!--right_panel-->
</div>
</div><!--Main-->
	<div class="clear"></div>
<div class="row"><div class="tab_shadow"></div></div>
<script language="javascript" type="text/javascript">
function DeleteAction(referencesRecommendationsId)
{
	//alert(referencesRecommendationsId);
	var conBox = confirm(areYouSure);
	if(conBox){
		document.referencesRecommendations.delRefId.value = referencesRecommendationsId;
		document.referencesRecommendations.submit();
	}
	else{
		return false;
	}
}

function editRecord(obj)
{
	var val1 = $(obj).attr('refId');
	var val2 = $(obj).attr('refFName');
	var val3 = $(obj).attr('refLName');
	var val4 = $(obj).attr('refCompName');
	var val5 = $(obj).attr('refAdd');
	var val6 = $(obj).attr('refCountry');
	var val7 = $(obj).attr('refState');
	var val8 = $(obj).attr('refCity');
	var val9 = $(obj).attr('refZip');
	var val10 = $(obj).attr('refDescription');
	var val11 = $(obj).attr('refEmail');
	var val12 = $(obj).attr('refContact');
	var val13 = $(obj).attr('refURL');	
	
	$('#refId').val(val1);
	$('#refFName').val(val2);
	$('#refLName').val(val3);
	$('#refCompName').val(val4);
	$('#refAdd').val(val5);
	$('#refCountry').val(val6);
	$('#refState').val(val7);
	$('#refCity').val(val8);
	$('#refZip').val(val9);
	$('#refDescription').val(val10);
	$('#refEmail').val(val11);
	$('#refContact').val(val12);
	$('#refURL').val(val13);
	$('#mode').val('edit');
	
	selectBox();
	
	$('#RefForm-Content-Box').slideDown("slow");
	$('#RefTitle').html('Edit');	
}

function canceltoggle(showFlag)
{
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
	var val12 = '';
	var val13 = '';	
	var toggleDivIcon = $(this).attr('toggleDivIcon');
	var toggleDivForm = $(this).attr('toggleDivForm');
	var toggleDivFormIsVisible = $('#'+toggleDivForm).is(":visible");
	var togDivId = $(this).attr('toggleDivId');
	var toggleDivVisible = $('#'+togDivId).is(":visible");
		
	$('#refId').val(val1);
	$('#refFName').val(val2);
	$('#refLName').val(val3);
	$('#refCompName').val(val4);
	$('#refAdd').val(val5);
	$('#refCountry').val(val6);
	$('#refState').val(val7);
	$('#refCity').val(val8);
	$('#refZip').val(val9);
	$('#refDescription').val(val10);
	$('#refEmail').val(val11);
	$('#refContact').val(val12);
	$('#refURL').val(val13);
	$('#mode').val('new');
	selectBox();
	
	if(showFlag == 1){	
		$('#RefForm-Content-Box').slideToggle("slow");		
	}
	else
	{
		$('#RefForm-Content-Box').slideUp("slow");
		if($('#'+toggleDivIcon).css("background-position")=='-1px -121px')
		{
			$('#'+toggleDivIcon).css("background-position","-1px -144px");			
		}else
		{
			$('#'+toggleDivIcon).css("background-position","-1px -121px");
		}
	}
		
}

function moveUp(currentId,swapId,currentPosition,swapPosition)
{
	$('#currentId').val(currentId);
	$('#swapId').val(swapId);
	$('#currentPosition').val(currentPosition);
	$('#swapPosition').val(swapPosition);
	document.referencesRecommendations.refIdForSwap.value = 1;
	document.referencesRecommendations.submit();	
}

function moveDown(currentId,swapId,currentPosition,swapPosition)
{
	$('#currentId').val(currentId);
	$('#swapId').val(swapId);
	$('#currentPosition').val(currentPosition);
	$('#swapPosition').val(swapPosition);
	document.referencesRecommendations.refIdForSwap.value = 1;
	document.referencesRecommendations.submit();
}

</script>
