<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div id="WorkConformBox" class="customAlert" style="display:none; width:260px;z-index:999999;">			
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


					
    <?php  if(isset($appReceived) && !empty($appReceived))
              { $i=1;   			
			    foreach ($appReceived as $applied) {
					
					  //echo $applied['workType'];
					  
					  //$urlView = base_url(lang().'/tmail/viewWork/'.$applied['tmailId']);
				      $path = 'media/'.$applied['username'].'/profile_image/'; 
				      $img=(!empty($applied['imagePath'])) ? $applied['imagePath'] :  $path.$applied['image'];					   
					  $thumbImage = addThumbFolder($img,'_s');
					  //$imagetype = ($applied['workType']=='wanted')?$this->config->item('defaultWorkWanted_s'):$this->config->item('defaultWorkOffered_s');
					  $userDefaultImage=($applied['creative']=='t')?$this->config->item('defaultCreativeImg'):($applied['associatedProfessional']=='t'?$this->config->item('defaultAssProfImg'):$this->config->item('defaultEnterpriseImg'));
					  $elementImage=getImage($thumbImage,$userDefaultImage);					  
					   ?>	
					<input type="hidden" name="currentRecordId" value="<?php echo $applied['status_id']  ?>" /> 
					 <input type="hidden" name="currentDelId" value="<?php echo $i  ?>" />  
							<div id="workRec<?php echo $i ?>" class="row nocravbg_commonshedow bdr_cacaca common_gradint bdr_bwhite position_relative"> 
											<div class="shadow_wp strip_absolute left_390">
												<table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0">
													<tbody>
														<tr>
														   <td height="42"><img src="<?php echo base_url('images/sent_rectop.png');?>"></td>
														</tr>
														<tr>
														  <td class="sentshadow_mid">&nbsp;</td>
														</tr>
														<tr>
														  <td height="42"><img src="<?php echo base_url('images/sent_recbottom.png');?>"></td>
														</tr>
													</tbody>
												</table>
											</div>
											
											
								<div class="ver_contact_user_pic_box mr5">
								   <img class="max_h_41 max_w_41" src="<?php echo $elementImage; ?>">
								</div>

								<div class="var_name_wp width_305 pl5">
									<div class="crl_726458 pt2 font_opensansSBold font_size13 ml10">
										<a target="_blank" href="<?php echo base_url()?>workshowcase/viewproject/<?php echo $currentUserId.'/'.$applied['workId'] ?>">										
											<?php echo ucfirst($applied['subject']) ?>						
										</a>					
									</div><!--var_name_label-->
									
								<div class="seprator_5"> </div>
								
								<div class="font_arial clr_444 font_size11 comon_insetshedow pt10 pb10 pl12 pr11">
									<?php echo  nl2br(substr($applied['body'],0,100)).'...' ?>								 
								</div><!--var_name_label-->

								</div>

							  <div class="fr width160px font_opensans clr_444 pb10"> 
							<div class="fr mt5"> 
								<div class="small_btn mr5">
								<a onmousedown="mousedown_small_button(this)" onmouseup="mouseup_small_button(this)" onclick="deleteWorkTmail('<?php echo $applied['status_id']?>','<?php echo $i ?>');" href="javascript://void(0);">
								<span><div class="cat_smll_plus_icon"></div></span>
								</a>
								</div>
								
								<?php if (isset($applied['isAttachedProfile']) && ($applied['isAttachedProfile']=='t')) {				
							       								 
								    $userInfo = encode($applied['sender_id'].'-'.$applied['elementid'].'-'.$applied['access_token']);								    
								    $urlView = base_url(lang().'/tmail/viewWork/'.$applied['tmailId'].'/'.$userInfo);	    ?>								    

								<div class="fr mr8 mt2"><a target="_blank" href="<?php echo $urlView ?>"><img src="<?php echo base_url('images/send.png');?>" /></a> </div>						
									 
								<div class="fr mr8 mt2"> <a target="_blank" href="<?php echo base_url().'workprofilefrontend/showProfile/'.$userInfo ?>"><img src="<?php echo base_url('images/tsfolder.png');?>"/></a></div>								   
									 			   
							    <?php } else { 									
									
									$urlView = base_url(lang().'/tmail/viewWork/'.$applied['tmailId']);	?>								
									
									<div class="fr mr8 mt2"><a target="_blank" href="<?php echo $urlView ?>"><img src="<?php echo base_url('images/send.png');?>" /></a> </div>								
									
									
								<?	} ?>
																
							</div>					

							<div class="clear"> </div>
							
							<div class="seprator_10"> </div>
							<?php  $name = $applied['firstName'].' '.$applied['lastName'];?>
								<div class="row">
										<div class="cell width_60 greyMsg"> From </div>
										<div class="cell width_100 height_18 overflowHid"><a class="clr_E76D34" target="_blank" href="<?php echo base_url().'en/showcase/index/'.$applied['tdsUid']?>"> <?php echo substr($name,0,100) ?>  </a> </div>
								</div>
							
							
							<!-- <div class="clr_f1592a greyMsg"> <?php //echo  dateFormatView($applied['workExpireDate'],'d F Y') ?> </div> -->							
								<div class="row">
										<div class="cell width_60 greyMsg"> Received </div>
										<div class="cell"><?php echo  dateFormatView($applied['workCreateDate'],'d F Y') ?></div>
								</div>							
								<div class="row">
										<div class="cell width_60 greyMsg"> Industry </div>
										<div class="cell"><?php echo $applied['IndustryName'] ?> </div>	
								</div>
							</div>
							<div class="clear"> </div>
							</div>
			    			<div class="seprator_15"> </div>

          <?php $i++; }  } ?>
          
          
<script type="text/javascript">
	function conformYesBox()
	{ 
		$("#WorkConformBox").lightbox_me('center:true');
	}
	
	
	function closeBox(){
		$('#WorkConformBox').trigger('close');	
	}
	
	
	function deleteMail(confirmflag){
		if(confirmflag=='t'){
		deleteWorkTmail();
		$('#WorkConformBox').trigger('close');
		}
		else{
		$('#WorkConformBox').trigger('close');	
		}			
	}
	
	
	function deleteWorkTmail(delId,currentId){ 			
		var type = "Inbox";	
		
	//	alert(delId+'CURID'+currentId);
		
		
		//return false;	
		
		$.ajax
		({     
			type: "POST",
			url: "<?php echo base_url() ?>tmail/trashTmailPopupMessage/"+delId+'/'+type,
			success: function(msg)
			{ 
				//alert('#workRec'+currentId);
				$('#workRec'+currentId).remove();				 
			     //refreshPge();
								
			}

		});				         
	} 
	
	 

</script>
          
