<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<div id="YesBoxWpSelf" class="customAlert" style="display:none; width:260px;z-index:999999;">			
	<div class="row">
		<div class="cell mb20"><?php echo $this->lang->line('deletMsgAlert'); ?></div> 
	</div>
	<div class="row">
		<div class="cell ml20">
			<div class="tds-button floatRight">
				<?php echo anchor('javascript://void(0);', '<span>Yes</span>',array('onclick'=>'deleteMailSelf(\'t\');','onmousedown'=>'mousedown_tds_button(this);','onmouseup'=>'mouseup_tds_button(this);')); ?>
			</div>
		</div>
		<div class="cell ml20">
			<div class="tds-button floatRight">
				<?php echo anchor('javascript://void(0);', '<span>No</span>',array('onclick'=>"$(this).parent().trigger('close');",'onmousedown'=>'mousedown_tds_button(this);','onmouseup'=>'mouseup_tds_button(this);')); ?>
			</div>
		</div>
	</div>
</div>
<script>
function mouseout_inputtmail(obj){
obj.style.backgroundPosition ='0px -0px';
obj.firstChild.style.backgroundPosition ='right -0px';
}

function mouseup_inputtmail(obj){
	obj.style.backgroundPosition ='-0px -33px';
	obj.firstChild.style.backgroundPosition ='right -33px';
}
</script>

<?php
$formAttributes = array(
'name'=>'viewTmailList',
'id'=>'viewTmailList'
);	

if(isset($mailThreadData[0]['id']) && !empty($mailThreadData[0]['id'])){
	$nextContId = getUserNextTmail($mailThreadData[0]['id'],$curentUid,$type);
	$prevContId = getUserPrevTmail($mailThreadData[0]['id'],$curentUid,$type);
}
$max_id;
$min_id;
if( isset($nextContId[0]->id) && ($nextContId[0]->id!='') ){
	$nextRecord = $nextContId[0]->id;
}
elseif( isset($prevContId[0]->id) && ($prevContId[0]->id!='') ){
	$nextRecord = $prevContId[0]->id;	
}else {
	$nextRecord = 0;	
}
if($type=='Sent') {
	$receiverId = $mailThreadData[0]['user_id'];
	$userLabel = 'To';
} else {
	$receiverId = $mailThreadData[0]['sender_id'];
	$userLabel = 'From';
}
?>	
<div class="row form_wrapper">
	<div class="row">
		<div class="cell frm_heading">
			<h1><?php echo $this->lang->line('communicationTmail');?></h1>
		</div>	
	</div> <!--row-->
	<div class="clear"></div>
</div><!--row form_wrapper-->

<div class="row pt2 ">
	<div class="row ">
		<div class="cell tab_left width_202">
			<div class="tab_heading_global">
				<div class="tds-button-inbox fl mt5 ml10">
					<a href="<?php echo base_url(lang().'/collaboration/communications/'.$collaborationId.'/1') ?>" onmouseup="mouseout_inputtmail(this)" onmousedown="mouseup_inputtmail(this)">
						<span class="font_arial"><?php echo $this->lang->line('compose');?></span>
					</a>
				</div> 
			</div>
			<!--tab_heading-->
		</div>
		<div class="cell tab_right width_590">
			<div class="tds-button-inbox Fright mt5 mr10">
				<a href="<?php echo base_url(lang().'/collaboration/communications/'.$collaborationId) ?>" onmouseup="mouseout_inputtmail(this)" onmousedown="mouseup_inputtmail(this)">
					<span><?php echo $this->lang->line('communications');?></span>
				</a>
			</div>
		</div> 
	</div>
</div>
<!--row-->
<div class="clear"></div>
<div class="form_wrapper toggle pr5"  id="NEWS-Content-Box2" >
	<div class="shadow_wp strip_absolute">
		<table width="100%" cellspacing="0" cellpadding="0" border="0" height="100%">
			<tbody>
				<tr>
				   <td height="271"><img src="<?php echo base_url('/images/shadow-top.png')?>"></td>
				</tr>
				<tr>
				   <td class="shadow_mid">&nbsp;</td>
				</tr>
				<tr>
					<td height="271"><img src="<?php echo base_url('/images/shadow-bottom.png')?>"></td>
				</tr>
			</tbody>
		</table>
	</div> <!-- shadow_wp strip_absolute -->
	<div class="row">
	   <div class="tab_shadow tab_shadow_g"> </div>
	</div>
	<div class="shadow_sep row"> </div>
	<div class="clear"></div>
	<div class="seprator_10"> </div>
	<?php
	echo form_open(base_url(lang().'/collaboration/replyTmail'),$formAttributes); ?>
	<input type="hidden" id="currentRecordId" name="currentRecordId" value="<?php echo $mailThreadData[0]['pr_id']; ?>" />
	<input type="hidden" id="nextRecordId" name="nextRecordId" value="<?php echo $nextRecord; ?>" />
	<input type="hidden" id="viewType"name="viewType" value="<?php echo $type; ?>" />
	<input type="hidden" id="subject" name="subject" value="<?php echo $mailThreadData[0]['subject']; ?>" />
	<input type="hidden" id="reply_msg_id" name="reply_msg_id" value="<?php echo $mailThreadData[0]['pr_id']; ?>" />
	<input type="hidden" id="receiverid" name="receiverid" value="<?php echo $receiverId; ?>" />
	<input type="hidden" id="body" name="body" value='<?php //echo htmlspecialchars($data->body); ?>' />
	<input type="hidden" name="userName" value="<?php //echo $data->firstName.' '.$data->lastName ;?>" />
	<input type="hidden" name="threadId" value="<?php echo $mailThreadData[0]['thread_id'];?>" />
	<input type="hidden" name="msgType" value="<?php echo $mailThreadData[0]['type'];?>" />
	<input type="hidden" name="collaborationId" value="<?php echo $collaborationId;?>" />
	<?php $subjectLebel= $this->lang->line('subject');?>
	<div class="width100percent minHeight200px">
		<div class="row width_791">
			<div class="label_wrapper_global cell heightAuto">
				<label  class=" height_30 mt5"><?php echo $subjectLebel;?></label>
				<label class=" height_30"><?php echo $userLabel;?></label>
				<div class="clear"></div>
			</div> 
			<!--label_wrapper-->
			<div class=" cell frm_element_wrapper pl14">
				<div class="bdr_c9c9c9">
					<div class="tmailtop_gradient minH60 bdr_e2e2e2 mt1 ml1 mr1">		
						<div class=" font_opensansSBold font_size14 clr_444 ml15 mr15 mt7">
							<div class="fl width_400" >
								<?php echo $mailThreadData[0]['subject'];?>													
							</div>
							<span class=" display_inline fr font_opensans font_size11 mt3">
								 <?php echo dateFormatView($mailThreadData[0]['cdate'],$fmt = 'd F Y');?>
							</span>																						
							<div class="clear"></div>
							<div class="dashbdrstrip"></div>
						</div>
						<div class="fl font_opensans font_size13 ml15 mr15 mt5">
							<?php echo $mailThreadData[0]['firstName'].' '.$mailThreadData[0]['lastName'];?>
						</div> 
						<div class="fr mr15 mt7">           
							<?php   
							if($nextContId != $prevContId ){ 
								if(($max_id==$mailThreadData[0]['id']) || ($min_id==$mailThreadData[0]['id'])) 
								{

									if($min_id==$mailThreadData[0]['id'] && isset($prevContId[0]->id )) {  ?>                
									   <div class="fl"> <a href="<?php echo base_url(lang().'/tmail/viewTmail/'.$prevContId[0]->id.'/'.$type) ?>" onclick="next_prevoius('contactMeDiv','/tmail/getPrevTmailDetail/<?php $mailThreadData[0]['id']; ?>/<?php echo  $type; ?>')" id="slide_up"> <img src="<?php echo base_url('/images/tmail_aerrowup.png')?>" alt=""/></a></div>
									<?php }

									if($max_id==$mailThreadData[0]['id'] && isset($nextContId[0]->id )) {  ?>				
									   <div class="fl ml5"><a href="<?php echo base_url(lang().'/tmail/viewTmail/'.$nextContId[0]->id.'/'.$type) ?>" onclick="next_prevoius('contactMeDiv','/tmail/getNextTmailDetail/<?php $mailThreadData[0]['id']; ?>/<?php echo  $type; ?>')" id="slide_down"> <img src="<?php echo base_url('/images/tmail_aerrowdown.png')?>" alt=""/></a></div>
									<?php  }
								}else{
									if(count($prevContId) != 0 && isset($prevContId[0]->id )) {?>
									   <div class="fl"> <a href="<?php echo base_url(lang().'/tmail/viewTmail/'.$prevContId[0]->id.'/'.$type) ?>" onclick="next_prevoius('contactMeDiv','/tmail/getPrevTmailDetail/<?php echo $mailThreadData[0]['id']; ?>/<?php echo  $type; ?>')" id="slide_up"> <img src="<?php echo base_url('/images/tmail_aerrowup.png')?>" alt=""/></a></div>
									<?php  }

									if(count($nextContId) != 0 && isset($nextContId[0]->id) ) { ?>				
									   <div class="fl ml5"><a href="<?php echo base_url(lang().'/tmail/viewTmail/'.$nextContId[0]->id.'/'.$type) ?>" onclick="next_prevoius('contactMeDiv','/tmail/getNextTmailDetail/<?php echo $mailThreadData[0]['id']; ?>/<?php echo  $type; ?>')" id="slide_down"> <img src="<?php echo base_url('/images/tmail_aerrowdown.png')?>" alt=""/></a></div>
									<?php }
								}
							}?>
						</div> <!--fr mr15 mt7-->							
						<div class="clear"></div>
					</div> <!-- tmailtop_gradient minH60 -->
					<div id="show_hide">  												
						<div class="seprator_14"></div>
							<div class="minHeight200px pl15 pr15 clr_444">
								<?php echo $mailThreadData[0]['body'];?>
								<div class="clear"></div>
							</div>
							<?php
							//Set attachment of tmail start here
							 if(!empty($attachmentData->fileId) && !empty($attachmentData->filePath) && !empty($attachmentData->fileName) && file_exists(ROOTPATH.$attachmentData->filePath.$attachmentData->fileName)) { ?>
								<div>
									<div class="Fleft ml10">
										<a class="formTip fl dash_link_hover" href="<?php echo base_url().$attachmentData->filePath.$attachmentData->fileName;?>" original-title="Download" download="<?php echo $attachmentData->rawFileName;?>">
											<span>
												<div class="fl mt-2">
													<?php echo $attachmentData->rawFileName;?>
												</div>
												<div id="addCatButton" class="cat_smll_save_icon eduInfoUpdate fr mr5">
												</div>
											</span>	
										</a>
									</div>
								</div>
								<div class="clear seprator_14"></div>
							<?php }
							//Set attachment of tmail end here
							?>
							<div class="tmailtop_gradient min_h60 bdr_e2e2e2 mt1 ml1 mr1">
								<div class="tmail_bottomstrip fl">	
									<div class="fl width_242 font_opensansLight font_size14 clr_444 text_alignR mt18 areowarchive_tmail pr20 tmail_bottomstrip org_anchor_hover">
										<a  target="_blank" href="<?php echo base_url(lang().'/showcase/aboutme/'.$receiverId) ?>"><?php echo $this->lang->line('viewShowcase');?></a>
									</div>	
								</div> 		
								<div class="fr mt10 mr5">			
									<!--<div class="tds-button fr mt5"> 
										<button type="button" onclick="javascript:$(this).parent().trigger('close');" onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" class="font_arial dash_link_hover"><span><div class="Fleft">Print</div> <div class="print_button"></div> </span> </button>  
									</div>-->
									<div class="tds-button fr mt5">
										<button type="button" onclick="conformYesBoxSelf();" onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" class="font_arial dash_link_hover"><span><div class="Fleft"><?php echo $this->lang->line('delete');?></div> <div class="delete_button"></div> </span> </button>  
									</div>
									<?php if(!empty($type) && $type=='Inbox') {?>
										<div class="tds-button fr mt5"> <button type="submit" type="button" onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" class="font_arial dash_link_hover"><span><div class="Fleft"><?php echo $this->lang->line('reply');?></div> <div class="reply_button"></div> </span> </button>  </div>
									<?php }?>
								</div>	
								<div class="clear"></div>
							</div> <!-- Tmailtop_gradient -->
						</div>  <!-- Show Hide -->										
					<?php echo form_close(); ?>
				</div><!-- bdr_c9c9c9 -->
			</div>
			<div class="clear"></div>
		</div> <!--row width791-->
	</div> <!--width100percent minH900 -->		
	<div class="seprator_10"> </div>	
</div> <!--tab_wp-->
	   
<script type="text/javascript">
	function conformYesBoxSelf()
	{ 
		$("#YesBoxWpSelf").lightbox_me('center:true');
	}
	function closeBox(){
		$('#YesBoxWpSelf').trigger('close');	
	}
	function deleteMailSelf(confirmflag){
		
		if(confirmflag=='t'){
		deletTmailPopupSelf();
		$('#YesBoxWpSelf').trigger('close');
		}
		else{
		$('#YesBoxWpSelf').trigger('close');	
		}			
	}
	
	function deletTmailPopupSelf() { 					 
		var val = parseInt($('#currentRecordId').val());			
		var nextRecord = parseInt($('#nextRecordId').val());
		var type = ($('#viewType').val());		
		
		$.ajax
		({     
			type: "POST",
			url: "<?php echo base_url() ?>tmail/trashTmailPopupMessage/"+val+'/'+type+'/'+nextRecord,
			success: function(msg)
			{
				window.location.href= "<?php echo base_url().lang() ?>/collaboration/communications/<?php echo $collaborationId;?>";								
			}
		});	
		runTimeCheckBox();          
	}
	
</script>
