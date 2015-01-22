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
		<div class="cell frm_heading">
			<h1><?php echo $label['socialLink']?></h1>
		</div>
		<?php $this->load->view('workProfile/navigationMenu');?>
</div>

<div class="row position_relative">
	<?php 
//LEFT SHADOW STRIP
echo Modules::run("common/strip");
?>
<div class="row pr10">		
	<div class="tds-button-top">
		<?php
		$attr = array('onclick'=>'canceltoggle(1);');
		echo anchor('javascript://void(0);', '<span><div class="projectAddIcon"></div></span>',$attr);					
		?>		
	</div>	
	
</div><!--End Row-->


<?php /*	
<div class="row ">
	<div class="cell tab_left">
		<div class="tab_heading">
			<?php echo $label['socialLink']; ?>
		</div><!--tab_heading-->
	</div>
	<div class="cell tab_right">
		<div class="tab_btn_wrapper">
			<div class="tds-button-top"> 
				<!-- Post add Icon -->
					<a class="formTip formToggleIcon" title="<?php echo $label['add'];?>" onclick='canceltoggle(1);' toggleDivForm="SocialForm-Content-Box" toggleDivIcon="socialToggleIcon" >
					<span><div class="projectAddIcon"></div></span>
					</a>

			</div>
		</div>
	</div>
</div><!--row-->
<div class="tab_shadow"></div>
* */
?>
	<div class="row" id="SocialForm-Content-Box">
		
	<?php 	
		
		//To load add social link
		$this->load->view('workProfile/add_more_socialmedialink');
	?>
	</div>
	<div class="row" id="SocialContent">
		
		
		
		<!-- Show List Of SocialContent -->
	<?php
		
		echo form_open('workprofile/deleteSocialLink',"name='profileSocialLink'");
		echo form_hidden('delProfileSocialLinkId','');
		echo form_hidden('profileSocialLinkIdForUp','');	
		echo form_hidden('profileSocialLinkIdForDown','');
		echo form_input($currentId);	
		echo form_input($swapId);
		echo form_input($currentPosition);
		echo form_input($swapPosition);
		echo form_hidden('profileSocialLinkIdForSwap','');
	
	?>	
		<div class="row">
			<div class="label_wrapper cell"><div class="lable_heading"><h1><?php echo $label['socialLink'];?></h1></div></div><!--label_wrapper-->
			<div class=" cell frm_element_wrapper lH30">
				<div class="cell width120px"><label class="orange"><?php echo $label['mediaLink']?></label></div>
				<div class="cell width120px ml20" align="center"><label class="orange"><?php echo $label['mediaLinkType']?></label></div>
				<div class="cell width120px ml20" align="center"><label class="orange"><?php echo $label['mediaLinkImage']?></label></div>
				<div class="cell width120px ml20" align="center"><label class="orange"><?php echo $label['actions']?></label></div>
			</div>
		</div>
		
		
		
		<div class="row line1"></div>
		<div class="row">
			<div class="label_wrapper cell bg_none"></div><!--label_wrapper-->
			<div class=" cell frm_element_wrapper lH30">
		<div id="pagingContent">
		<?php 
		//echo "<pre>"; print_r($values);
		$countRecord =  count($values)-1;
		$i = 0; 
		if(!empty($values)){
		foreach($values as $k=>$row){
		?>
		<div class="row">
			<div class="empty_label_wrapper cell"></div>
			<div class="cell frm_element_wrapper">
				<div class="all_list_item ">
					<div class="row pb10 mH30">
					
						<div class="cell width120px">
							<?php echo $row['socialLink'];?>
						</div>
						
						<div class="cell width120px ml20" align="center">
							<?php echo $row['profileSocialMediaName'];?>
						</div>
						
						<div class="cell width120px mt5 ml20" align="center">
							<img class="formTip HoverBorder ma ptr" src="<?php echo base_url().$row['profileSocialMediaPath'];?>" title="<?php echo $row['profileSocialMediaName'];?>" />
						</div>
						<div class="cell  ml40">
							<div class="pro_btns">
							<?php
								
								if($i!=$countRecord)
								{
									$moveDown =  array("onclick"=>"moveDown('".encode($row['profileSocialLinkId'])."','".encode(@$values[$k+1]['profileSocialLinkId'])."','".$row['position']."','".@$values[$k+1]['position']."')",'title'=>$label['moveDown'],'class'=>'formTip');
									
									//$moveDown = array("onclick"=>"moveDown('".encode($row['profileSocialLinkId'])."')",'title'=>$label['moveDown'],'class'=>'formTip');
									echo '<div class="small_btn ">'.anchor('javascript://void(0);', '<div class="smll_down_arrow_icon"></div>',$moveDown).'</div>';
								}else
								{
									$moveDown = array('title'=>$label['notMovable'],'class'=>'formTip');
									echo '<div class="small_btn disable_btn">'.anchor('javascript://void(0);', '<div class="smll_down_arrow_icon"></div>',$moveDown).'</div>';
								}

								if($i!=0)
								{
									$moveUp = array("onclick"=>"moveUp('".encode($row['profileSocialLinkId'])."','".encode(@$values[$k-1]['profileSocialLinkId'])."','".$row['position']."','".@$values[$k-1]['position']."')",'title'=>$label['moveUp'],'class'=>'formTip');
									//$moveUp = array("onclick"=>"moveUp('".encode($row['profileSocialLinkId'])."')",'title'=>$label['moveUp'],'class'=>'formTip');
									echo '<div class="small_btn">'.anchor('javascript://void(0);', '<div class="smll_up_arrow_icon"></div>',$moveUp).'</div>';
								}else
								{
									$moveUp = array('title'=>$label['notMovable'],'class'=>'formTip');
										echo '<div class="small_btn disable_btn">'.anchor('javascript://void(0);', '<div class="smll_up_arrow_icon"></div>',$moveUp).'</div>';
								}
								
								//History Edit Icon
								$editArr = array("onclick"=>"editRecord(this);",'profileSocialLinkId'=>@$values[$k]['profileSocialLinkId'],'profileSocialLinkType'=>@$values[$k]['profileSocialLinkType'],'socialLinkDesc'=>@$values[$k]['socialLink'],'title'=>$label['editRecord'],'class'=>"formTip",'toggleDivForm'=>'SocialForm-Content-Box',);
															
								//History Delete Icon
								$attr = array("onclick"=>"DeleteAction('".encode($row['profileSocialLinkId'])."')","title"=>$label['deleteRecord'],'class'=>'formTip');
								
								echo  '<div class="small_btn">'.anchor('javascript://void(0);','<span><div class="cat_smll_plus_icon"></div></span>',$attr).'</div>';	
								
								echo '<div class="small_btn">'.anchor('javascript://void(0);', '<span><div class="cat_smll_edit_icon"></div></span>',$editArr).'</div>';	
								
							?>
						</div>
						</div>
						
					</div><!--End of pb10 -->
				</div><!--End of all_list_item -->
			</div>
		</div><!--End of row -->
		
	<?php $i++; } } ?>
	</div><!--End of pagingContent -->
	
	<div class="clear"></div>
	
	
	
	
	<?php if(empty($values)) { 
		//echo "<div align='center'><a href='addMoreSocialLinks/0'>".$label['clickHere']."</a> ".$label['addSocialMedia']."</div>"; 
		echo "<div align='center' class='ml10' >".$label['noRecord']."</div>"; 
		}?>

	<?php $data['record_num'] =10; if(!empty($values) && (count($values) > 10)) { $this->load->view('pagination_view',$data);}?>
</div>
</div>
	</div>
<?php echo form_close(); ?>
</div>
</div>
<script language="javascript" type="text/javascript">
function DeleteAction(profileSocialLinkId)
{
	var conBox = confirm(areYouSure);
	if(conBox){
		
		document.profileSocialLink.delProfileSocialLinkId.value = profileSocialLinkId;
		document.profileSocialLink.submit();
	}
	else{
		return false;
	}	
}

function editRecord(obj)
{
	var val1 = $(obj).attr('profileSocialLinkId');
	var val2 = $(obj).attr('profileSocialLinkType');
	var val3 = $(obj).attr('socialLinkDesc');
	$('#profileSocialLinkId').val(val1);
	$('#socialLinkType').val(val2);
	$('#socialLink').val(val3);
	$('#mode').val('edit');
	selectBox();
	$('#SocialForm-Content-Box').slideDown();
	$('#socialMediaLinkTitle').html('Edit');
	
}

function canceltoggle(showFlag){
	
	var val1 = 0;
	var val2 = '';
	var val3 = '';
	$('#profileSocialLinkId').val(val1);
	$('#socialLinkType').val(val2);
	$('#socialLink').val(val3);
	$('#mode').val('new');
	if(showFlag == 1)
	{
		$('#socialMediaLinkTitle').html('Add');
		$('#SocialForm-Content-Box').slideDown();
		//$('#Social-Content-Box').slideToggle();
		
	}
	else
	{
		$('#socialMediaLinkTitle').html('Add');
		$('#SocialForm-Content-Box').slideUp();
		if($('#'+toggleDivIcon).css("background-position")=='-1px -121px')
		{
			$('#'+toggleDivIcon).css("background-position","-1px -144px");			
		}else
		{
			$('#'+toggleDivIcon).css("background-position","-1px -121px");
		}
	}
	selectBox();
	
}
function moveUp(currentId,swapId,currentPosition,swapPosition)
{
	$('#currentId').val(currentId);
	$('#swapId').val(swapId);
	$('#currentPosition').val(currentPosition);
	$('#swapPosition').val(swapPosition);
	document.profileSocialLink.profileSocialLinkIdForSwap.value = 1;
	document.profileSocialLink.submit();	
}

function moveDown(currentId,swapId,currentPosition,swapPosition)
{
	$('#currentId').val(currentId);
	$('#swapId').val(swapId);
	$('#currentPosition').val(currentPosition);
	$('#swapPosition').val(swapPosition);
	document.profileSocialLink.profileSocialLinkIdForSwap.value = 1;
	document.profileSocialLink.submit();
}
</script>
