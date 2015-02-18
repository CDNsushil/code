<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div id="YesBoxWp" class="customAlert" style="display:none; width:260px;z-index:999999;">			
	<div class="row">
		<div class="cell mb20"><?php echo $this->lang->line('deletMsgAlert'); ?></div> 
	</div>
	<div class="row">
		<div class="cell ml20">
			<div class="tds-button floatRight">
				<?php echo anchor('javascript://void(0);', '<span>Yes</span>',array('onclick'=>'deleteMail(\'t\');','onmousedown'=>'mousedown_tds_button(this);','onmouseup'=>'mouseup_tds_button(this);')); ?>
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
/* $userImage=$data->image;
$creative=$data->creative; 
$associatedProfessional=$data->associatedProfessional;
$enterprise=$data->enterprise;
$imageType=($creative=='t')?$this->config->item('defaultCreativeImg'):(($associatedProfessional=='t')?$this->config->item('defaultAssProfImg'):(($enterprise=='t')?$this->config->item('defaultEnterpriseImg'):''));
$userImage=addThumbFolder($userImage,$suffix='_xxs',$thumbFolder ='thumb',$imageType);
$userImage=getImage($userImage);
*/
if(isset($data->id) && !empty($data->id)){
	$nextContId = getUserNextTmail($data->id,$curentUid,$type);
	$prevContId = getUserPrevTmail($data->id,$curentUid,$type);
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
?>	


			      <div class="row form_wrapper">
							<div class="row">
									<div class="cell frm_heading">
										<h1>Tmail</h1>
									</div>
									
									<?php $this->load->view('tmail_common_button'); ?>		
											
						   </div> <!--row-->

					<div class="clear"></div>

			</div><!--row form_wrapper-->


			<div class="row pt2 ">
					<div class="row ">
                <div class="cell tab_left width_202">
                  <div class="tab_heading_global"><div class="tds-button-inbox fl mt5 ml10 btn_span_hover"><a href="<?php echo base_url(lang().'/tmail/compose') ?>" onmouseup="mouseout_inputtmail(this)" onmousedown="mouseup_inputtmail(this)"><span class="font_arial">Compose
                  </span></a></div> </div>
                  <!--tab_heading-->
                </div>
                <div class="cell tab_right width_590">
                  <div class="tds-button-inbox Fright mt5 mr10 btn_span_hover"><a href="<?php echo base_url(lang().'/tmail') ?>" onmouseup="mouseout_inputtmail(this)" onmousedown="mouseup_inputtmail(this)"><span>Inbox
                  </span></a></div>
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


						<?php echo form_open(base_url(lang().'/tmail/replyTmail'),$formAttributes); ?>

								<input type="hidden" id="currentRecordId" name="currentRecordId" value="<?php echo $data->status_id; ?>" />
								<input type="hidden" id="nextRecordId" name="nextRecordId" value="<?php echo $nextRecord; ?>" />
								<input type="hidden" id="viewType"name="viewType" value="<?php echo $type; ?>" />
								<input type="hidden" id="subject" name="subject" value="<?php echo $data->subject; ?>" />
								<input type="hidden" id="reply_msg_id" name="reply_msg_id" value="<?php echo $data->id; ?>" />
								<input type="hidden" id="receiverid" name="receiverid" value="<?php echo $data->sender_id; ?>" />
								<input type="hidden" id="body" name="body" value='<?php echo htmlspecialchars($data->body); ?>' />
								<input type="hidden" name="userName" value="<?php echo isGetUserName($data->tdsUid); ?>"/>
								<input type="hidden" name="threadId" value="<?php echo $data->thread_id;?>" />
								<input type="hidden" name="msgType" value="<?php echo $data->type;?>" />

								<?php
								//print_r($data);
								
								if($data->type==5) { ?>
								
										<div class="row">
											<div class="">
												<div class="clr_666 font_opensans"><?php //echo $this->lang->line('showOnKeyPersonelShowcase');?></div>
											</div>
											<div class="clear"></div>
										</div>
										<?php
										$subjectLebel= $this->lang->line('request');
										$where=array('msgid'=>$data->id,'senderid'=>$data->sender_id,'receiverid'=>isloginUser());
										$showResult=showProjectDetails($where);
										
										if($showResult){
											$projName=$showResult->title;
											$projId=$showResult->elementid;
											$projUser=$showResult->userid;
											$section=$showResult->section;
											$projectType=$showResult->projectType;
											if($projectType=='filmNvideo')$projLink=base_url(lang().'/mediafrontend/searchresult/'.$projUser.'/'.$projId.'/filmvideo');
											elseif($projectType=='musicNaudio')$projLink=base_url(lang().'/mediafrontend/searchresult/'.$projUser.'/'.$projId.'/musicaudio');
											elseif($projectType=='photographyNart')$projLink=base_url(lang().'/mediafrontend/searchresult/'.$projUser.'/'.$projId.'/photographyart');
											elseif($projectType=='writingNpublishing')$projLink=base_url(lang().'/mediafrontend/searchresult/'.$projUser.'/'.$projId.'/writingpublishing');
											elseif($projectType=='educationMaterial')$projLink=base_url(lang().'/mediafrontend/searchresult/'.$projUser.'/'.$projId.'/educationmaterial');
											elseif($projectType=='upcoming')$projLink=base_url(lang().'/upcomingfrontend/viewproject/'.$projUser.'/'.$projId.'/'.$projectType);
											else $projLink='#';
										}else{
											$projName='';
											$projLink='#';
										}

								}else{  
								       $subjectLebel= $this->lang->line('subject');
								} ?>


							<div class="width100percent minHeight200px">

									<div class="row width_791">
										<div class="label_wrapper_global cell heightAuto">
											<label  class=" height_30 mt5"><?php echo $subjectLebel;?></label>
											<label class=" height_30">From</label>
											<div class="clear"></div>
										</div> 

										<!--label_wrapper-->
										<div class=" cell frm_element_wrapper pl14">
											<div class="bdr_c9c9c9">
											<div class="tmailtop_gradient minH60 bdr_e2e2e2 mt1 ml1 mr1">
												
											<div class=" font_opensansSBold font_size14 clr_444 ml15 mr15 mt7">
												<div class="fl width_400" >
													<?php 
													
														if($data->type!=5) {
															echo  $data->subject;
														} 
														else {
														
																echo $this->lang->line('showOnKeyPersonelWorkMsg'); }												
													
													?>													
																									
													</div>
												 <span class=" display_inline fr font_opensans font_size11 mt3">
													 <?php echo dateFormatView($data->cdate,$fmt = 'd F Y');?>
												</span>
												
												
											<div class="clear"></div>
											<div class="dashbdrstrip"></div>
											</div>
											<div class="fl font_opensans font_size13 ml15 mr15 mt5"><?php
											echo isGetUserName($data->tdsUid);
											
											?></div> 


									<div class="fr mr15 mt7">           
											<?php   
											if($nextContId != $prevContId ){ 
												if(($max_id==$data->id) || ($min_id==$data->id)) 
												{

													if($min_id==$data->id && isset($prevContId[0]->id )) {  ?>                
													   <div class="fl"> <a href="<?php echo base_url(lang().'/tmail/viewTmail/'.$prevContId[0]->id.'/'.$type) ?>" onclick="next_prevoius('contactMeDiv','/tmail/getPrevTmailDetail/<?php echo $data->id; ?>/<?php echo  $type; ?>')" id="slide_up"> <img src="<?php echo base_url('/images/tmail_aerrowup.png')?>" alt=""/></a></div>
										    <?php }

													if($max_id==$data->id && isset($nextContId[0]->id )) {  ?>				
													   <div class="fl ml5"><a href="<?php echo base_url(lang().'/tmail/viewTmail/'.$nextContId[0]->id.'/'.$type) ?>" onclick="next_prevoius('contactMeDiv','/tmail/getNextTmailDetail/<?php echo $data->id; ?>/<?php echo  $type; ?>')" id="slide_down"> <img src="<?php echo base_url('/images/tmail_aerrowdown.png')?>" alt=""/></a></div>
									          <?php  }

												}else{

													if(count($prevContId) != 0 && isset($prevContId[0]->id )) {?>
													   <div class="fl"> <a href="<?php echo base_url(lang().'/tmail/viewTmail/'.$prevContId[0]->id.'/'.$type) ?>" onclick="next_prevoius('contactMeDiv','/tmail/getPrevTmailDetail/<?php echo $data->id; ?>/<?php echo  $type; ?>')" id="slide_up"> <img src="<?php echo base_url('/images/tmail_aerrowup.png')?>" alt=""/></a></div>
									          <?php  }

													if(count($nextContId) != 0 && isset($nextContId[0]->id) ) { ?>				
													   <div class="fl ml5"><a href="<?php echo base_url(lang().'/tmail/viewTmail/'.$nextContId[0]->id.'/'.$type) ?>" onclick="next_prevoius('contactMeDiv','/tmail/getNextTmailDetail/<?php echo $data->id; ?>/<?php echo  $type; ?>')" id="slide_down"> <img src="<?php echo base_url('/images/tmail_aerrowdown.png')?>" alt=""/></a></div>
								            <?php    }
												}
											}
											?>

							</div> <!--fr mr15 mt7-->							
								   <div class="clear"></div>
					</div> <!-- tmailtop_gradient minH60 -->
					
											<div id="show_hide">  												

												<div class="seprator_14"></div>
													<div class="minHeight200px pl16 pr15 clr_444 ">
															<?php
															
															if($data->type!=5) { 
																
																if($data->type == 7 || $data->type == 8 || $data->type == 9) 
																	{
																		echo $data->body; 
																	}else
																	{
																	   //echo $data->body;
																	   echo nl2br($data->body);
																	}
															
															 } else { 

																	   echo nl2br($data->body) ?>
																	<div class="pt20">
																		<a class="orange font_opensansSBold" target="_blank" href="<?php echo $projLink;?>">
																		   <?php echo $projName;?>
																		</a>
																	</div>
														<?php } ?>
														
															<div class="clear"></div>
													</div>
													
							<?php
							//Set attachment of tmail start here
							 if(!empty($attachmentData->fileId) && !empty($attachmentData->filePath) && !empty($attachmentData->fileName) && file_exists(ROOTPATH.$attachmentData->filePath.$attachmentData->fileName)) {?>
								<div>
									<div class="Fleft ml20">
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
													
							<?php
							    $labelWorkProfile ='';
							// echo $data->type;
							
								if ( ($data->type == 5) && ($type=='Inbox') ) {
											$isParrent=countResult('tmail_messages',array('parent_message_id'=>$data->id));
											if(!($isParrent > 0)){
											?>
											<div id="showProjectAccept" class="tds-button Fright pt20 mr10"> <button type="button" onclick="acceptShowProjectRequest();" onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" class="font_arial"><span><div class="Fleft orange"><?php echo $this->lang->line('accept');?></div> </span> </button>  </div>
											<?php
											}else{ 
												
												$labelWorkProfile = $this->lang->line('acceptedRequestAlready');
												
												?>
											<div class="orange fr pr10 pb10 pt5 font_opensansSBold"><?php //echo $this->lang->line('acceptedRequestAlready');?></div>
											<?php
											}
											}					
																										
													
					 if( ($data->type==5) && ($type=='Inbox')){ ?>								
													
							<div class="mt10">
								<div class="tmai_profiledivider"></div>																
										<div class="fl">										
									<div class="fl width510px font_opensansSBold font_size14 clr_444 text_alignR mt18 areowarchive_tmail_B pr20 tmail_bottomstrip position_relative"> <?php echo $labelWorkProfile ?></div></div>
									
									<div class="clear"></div>
									<div class="seprator_10"></div>
                           </div>	
                                    
                                      
                   <?php } else if ( ($data->type == 2) && ($type=='Inbox')    ) {
					 	$threadId=$data->thread_id; 
						$senderId=isLoginUser(); 
						$getMainMsgId=countResultFirstInsert('tmail_messages',array('thread_id'=>$threadId,'parent_message_id' => 0));
						$isParrent=countResult('tmail_messages',array('parent_message_id'=>$getMainMsgId->id));
					  ?>
                   
							<div class="position_relative">
							<div class="tmai_profiledivider"></div>															
							
							<div class="fl width_551 mt5 pr20 position_relative"> 

                     <?php
					
						if($isParrent > 0)
						{
							$getAttMainMsgId=countResultFirstInsert('tmail_messages',array('parent_message_id' => $getMainMsgId->id));
							$isAttachPro=countResult('tmail_attachment',array('msg_id'=>$getAttMainMsgId->id));
							
							if($getAttMainMsgId->sender_id==$senderId)
							{?>
								
								<div class="orange fr pr10 pb10 pt5 font_opensansSBold"><?php echo $this->lang->line('profileAlreadySnt') ?></div>
								
							<?php
							 }else
							{   
								$isWorkprofile = getAttacmentWorkProfile($getAttMainMsgId->id); 
							
								if (isset($isWorkprofile) && ($isWorkprofile!="") && ($type=='Inbox')) {	?>
							
								<div class="position_relative">
							<!---<div class="tmai_profiledivider"></div>--->			
								<div class="tmail_bottomstrip_B fl">
								<a  target="_blank" href="<?php echo base_url().'workprofilefrontend/showProfile/'.$isWorkprofile ?>">			
								<div class="position_absolute mt7 ml_327"><img src="<?php echo base_url('/images/tmail_profileicon.png')?>" alt="tmail_workprofile"/></div>
								<div class="fl width510px font_opensansLight font_size14 clr_444 text_alignR mt18 areowarchive_tmail_B pr20 tmail_bottomstrip position_relative dash_link_hover"> View Work Profile</div></div>
								</a>   
								<div class="clear"></div>
								<div class="fr pr25 pt5"><?php echo $this->lang->line('Thislinkwillworkfor15days') ?></div>
								<div class="clear"></div>
								<div class="seprator_10"></div>
								</div>	
								
							<?php } }
							
						}else
						{?>
							
							<div id="send_work_profile_not_sent" class="tds-button fr mt5"> <button type="button" onclick= "replayTmail()"  onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" class="font_arial dash_link_hover"><span><div class="Fleft">Send WorK Profile</div> <div class="icon-save-btn"></div> </span> </button>  </div>	
							 <div id="send_work_profile_sent" class="orange fr pr10 pb10 pt5 font_opensansSBold dn"><?php echo $this->lang->line('profileAlreadySnt') ?></div>
							
						<?php }	?>

							</div>

							<div class="clear"></div>
							<div class="seprator_10"></div>
							</div>			
						<?php 	} ?>
                   
					<div class="tmailtop_gradient min_h60 bdr_e2e2e2 mt1 ml1 mr1">
					<div class="tmail_bottomstrip fl">
					<div class="fl width_242 font_opensansLight font_size14 clr_444 text_alignR mt18 areowarchive_tmail pr20 tmail_bottomstrip org_anchor_hover">
					<a target="_blank" href="<?php echo base_url(lang().'/showcase/aboutme/'.$data->sender_id) ?>">View Showcase</a>
					</div>
					</div> 
												
										<div class="fr mt10 mr5">		
												
											<div class="tds-button fr mt5"> <button type="button" onclick="javascript:$(this).parent().trigger('close');" onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" class="font_arial dash_link_hover"><span><div class="Fleft">Print</div> <div class="print_button"></div> </span> </button>  </div>
											<div class="tds-button fr mt5"> <button type="button" onclick="conformYesBox();" onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" class="font_arial dash_link_hover"><span><div class="Fleft">Delete</div> <div class="delete_button"></div> </span> </button>  </div>

									<?php	if($type!='Trash')	{ ?>
											
											<div class="tds-button fr mt5"> <button type="submit" type="button" onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" class="font_arial dash_link_hover"><span><div class="Fleft">Reply</div> <div class="reply_button"></div> </span> </button>  </div>
									<?php } ?>	
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
			<?php if($type=='Inbox') { ?>		
					<div id="showThreads">				
					<?php
					  $this->load->view('show_thread',array('mailThreadData'=>$mailThreadData, 'current_view_id'=>$data->id)); ?>			 
				   </div>	
			<?php } ?>						

		     </div> <!--tab_wp-->
	    </div> <!--row pt2-->
