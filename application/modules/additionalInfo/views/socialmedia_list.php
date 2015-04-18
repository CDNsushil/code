<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$controllerVal=$this->uri->segment(2);

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

$controller= array(
	'name'=>'controllerName',
	'id'=>'controllerName',
	'type'=>'hidden',
	'value'=>$controllerVal
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
$entityId = array(
	'name'=>'entityId',
	'id'=>'entityId',
	'type'=>'hidden',
	'value'=>$entityId
);	
$socialMediaIdForSwap = array(
	'name'=>'socialMediaIdForSwap',
	'id'=>'socialMediaIdForSwap',
	'type'=>'hidden',
	'value'=>'1'
);	
	
?>
<?php if(!empty($socialMedia)){?>
<div class="row" id="socialMediaDataHeading" >
			<div class="empty_label_wrapper cell"><div class="lable_heading"><h1><?php //echo $label['socialLinks'];?></h1></div></div><!--label_wrapper-->
			<div class=" cell frm_element_wrapper lH30 ">
				<div class="cell width200px"><label class="orange"><?php echo $label['mLink']?></label></div>
				<div class="cell width120px ml20 tal"><label class="orange"><?php echo $label['socialLinkSite']?></label></div>
				<div class="cell width100px ml5"  align="center"><label class="orange"><?php echo $label['mediaIcon']?></label></div>
				<div class="cell ml40" align="center"><label class="orange"><?php //echo $this->lang->line('actions');?></label></div>
			</div>
		</div>
		<?php }?>	
		<div class="row mr10"></div>
		<div class="row" id="socialMediaData">
		<?php 
		echo form_open('additionalInfo/shiftSMPosition',"name='socialMediaListFrm'");
		echo form_hidden('profileSocialLinkIdForUp','');	
		echo form_hidden('profileSocialLinkIdForDown','');
		echo form_input($currentId);	
		echo form_input($swapId);
		echo form_input($controller);
		echo form_input($socialMediaIdForSwap);
		echo form_input($currentPosition);
		echo form_input($swapPosition);
		echo form_input($entityId);
	    echo form_hidden('profileSocialLinkIdForSwap','');?>
	    <input type="hidden" name="userShowcaseId" id="userShowcaseId" value="<?php echo $showcaseId?>">
			<div class="label_wrapper cell bg_none"></div><!--label_wrapper-->
			<div class=" cell">
		
		<?php 
		//print_r($socialMedia);
		$countRecord =  count($socialMedia)-1;
		$i = 0; 
		$dn='';
		
		if(!empty($socialMedia)){
		
		$dn='dn';
			
		foreach($socialMedia as $k=>$row){
		
		$id=$row['profileSocialLinkId'];
		$socialLink = htmlentities(addslashes($row['socialLink']),ENT_QUOTES);
	
	?>	
	
		<div class="row rowCount" id="rowSocialMedia<?php echo $id;?>">
			
			<div class="extract_content_bg_PRBG width_545 pt5 pl10">
				
					<div class="row">					
						<div class="cell width200px var_name pt0 word_wrap">
							<?php echo $row['socialLink'];?>
						</div>
						
						<div class="cell width120px ml20 tal">
							<?php echo $row['profileSocialMediaName'];?>
						</div>
						
						<?php
						
						 $linkClass ='';
							if($row['profileSocialMediaName']!='')
							{
								$linkClass = strtolower(str_replace(' ','_',$row['profileSocialMediaName']));					 
							}  
							?>						
						
						<div class="cell width60px ml20">
							<img class="formTip HoverBorder ma ptrcell <?php echo $linkClass ?>" title="<?php echo $row['profileSocialMediaName'];?>" />
						</div>
						<div class="cell ml40">
							<div class="pro_btns">
							<?php
								
								if($i!=$countRecord)
								{
									$moveDown =  array("onclick"=>"moveDown('".encode( $row['profileSocialLinkId'])."','".encode(@$socialMedia[$k+1]['profileSocialLinkId'])."','".$row['position']."','".@$socialMedia[$k+1]['position']."')",'title'=>$label['moveDown'],'class'=>'formTip');
									
									//$moveDown = array("onclick"=>"moveDown('".encode($row['profileSocialLinkId'])."')",'title'=>$label['moveDown'],'class'=>'formTip');
									echo '<div class="small_btn ">'.anchor('javascript://void(0);', '<div class="smll_down_arrow_icon"></div>',$moveDown).'</div>';
								}else
								{
									$moveDown = array('title'=>$label['notMovable'],'class'=>'formTip');
									echo '<div class="small_btn disable_btn">'.anchor('javascript://void(0);', '<div class="smll_down_arrow_icon"></div>',$moveDown).'</div>';
								}

								if($i!=0)
								{
									$moveUp = array("onclick"=>"moveUp('".encode($row['profileSocialLinkId'])."','".encode(@$socialMedia[$k-1]['profileSocialLinkId'])."','".$row['position']."','".@$socialMedia[$k-1]['position']."')",'title'=>$label['moveUp'],'class'=>'formTip');
									//$moveUp = array("onclick"=>"moveUp('".encode($row['profileSocialLinkId'])."')",'title'=>$label['moveUp'],'class'=>'formTip');
									echo '<div class="small_btn">'.anchor('javascript://void(0);', '<div class="smll_up_arrow_icon"></div>',$moveUp).'</div>';
								}else
								{
									$moveUp = array('title'=>$label['notMovable'],'class'=>'formTip');
										echo '<div class="small_btn disable_btn">'.anchor('javascript://void(0);', '<div class="smll_up_arrow_icon"></div>',$moveUp).'</div>';
								}
								
								//History Edit Icon
								$elementId = $socialMedia[$k]['workProfileId'];//herer workProfileId is acting as elementId for usershaocase and workprofileId
								$editArr = 
								array('section'=>'#socialMedia',
								'profileSocialLinkId'=>$socialMedia[$k]['profileSocialLinkId']
								,'socialLinkType'=>$socialMedia[$k]['profileSocialLinkType']
								,'socialLink'=>$socialLink
								,'id'=>$id
								,'elementId'=>$elementId
								,'title'=>$label['edit']
								,'class'=>"formTip editAdditionalSocialMediaInfo",
								'onclick'=>'editSocialMedia(this)',
								'toggleDivForm'=>'SocialMediaForm-Content-Box'
								);
															
								//History Delete Icon
								$attr = array(
								'title'=>$label['delete'],
								'class'=>"formTip",
								'id'=>$id,
								'section'=>'#socialMedia',
								'tbl'=>'profileSocialLink',
								'field'=>'profileSocialLinkId',
								'checkbox'=>'checkBoxNews',
								'rowData'=>'#rowSocialMedia',
								'onclick'=>'delePRSocialMedia(this)'
								);
								

								
							
								
					echo  '<div class="small_btn">'.anchor('javascript://void(0);','<span><div class="cat_smll_plus_icon"></div></span>',$attr).'</div>';	
								

				echo '<div class="small_btn">'.anchor('javascript://void(0);', '<div class="cat_smll_edit_icon"></div>',$editArr).'</div>';	
								
							?>
						</div>
						</div>
						<div class="clear"></div>
					</div><!--End of pb10 -->
				
			</div>
		</div><!--End of row -->
		
	<?php $i++; } } 
	?>
	
	
	<div class="clear"></div>
	
		<div style="padding:10px;width:100%;border:0px solid #000; text-align:center;"  class="row txtError pl20 <?php echo $dn;?>" id="socialMediaNoRecords" >
			<?php
			echo anchor('javascript://void(0);', $label['add'],array('class'=>'a_orange formTip','title'=>$label['add'],'onclick'=>"canceltoggle(1);"));
			echo '</div>';
	?>
<div class="row mt25 mb25">
	<?php //$data['record_num'] = 5; if(!empty($socialMedia) && (count($socialMedia) > 10)) { $this->load->view('pagination_view',$data);}?>
	<div class="clear"></div>
</div>

	</div>
<?php echo form_close(); ?>
<div class="clear"></div>
<!--26 JUL</div>
</div>-->
</div>

<script>

/*function moveUp(empHistoryIdForUp)
{  
	document.socialMediaListFrm.socialMediaIdForUp.value = socialMediaIdForUp;
	document.socialMediaListFrm.submit();
}*/


function moveUp(currentId,swapId,currentPosition,swapPosition)
{
	$('#currentId').val(currentId);
	$('#swapId').val(swapId);
	$('#currentPosition').val(currentPosition);
	$('#swapPosition').val(swapPosition);
	document.socialMediaListFrm.socialMediaIdForSwap.value = 1;
	document.socialMediaListFrm.submit();	

	 
}

function moveDown(currentId,swapId,currentPosition,swapPosition)
{	 
	
	$('#currentId').val(currentId);
	$('#swapId').val(swapId);
	$('#currentPosition').val(currentPosition);
	$('#swapPosition').val(swapPosition);
	document.socialMediaListFrm.socialMediaIdForSwap.value = 1;
	document.socialMediaListFrm.submit();
	
}
</script>
