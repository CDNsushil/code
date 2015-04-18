<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="row form_wrapper"> 
		<?php echo $header;?>
			<!-- TOP NAVIGATION-->
			<div class="row padding_top10 position_relative">
					<div class="cell shadow_wp strip_absolute">
						<table width="100%" cellspacing="0" cellpadding="0" border="0" height="940px">
							<tbody>
								<tr>
								   <td height="271">	<img src="<?php echo base_url('images/shadow-top.png');?>"></td>
								</tr>
								<tr>
								   <td class="shadow_mid">&nbsp;</td>
								</tr>
								<tr>
								   <td height="271"><img src="<?php echo base_url('images/shadow-bottom.png');?>"></td>
								</tr>
							</tbody>
						</table>
					    <div class="clear"></div>
					</div>


					<div class="cell width_200"> &nbsp; </div>

					<div class="cell width_569 pl20"> 
							<?php  if(isset($workApplied) && !empty($workApplied))
							{ $i=1;   			
						foreach ($workApplied as $applied) {
							$applied['tmailId'];
							
							
							$urlView = base_url(lang().'/tmail/viewWork/'.$applied['tmailId']);
							$path = 'media/'.$applied['username'].'/profile_image/'; 
							$img=(!empty($applied['imagePath'])) ? $applied['imagePath'] :  $path.$applied['image'];					   
							$thumbImage = addThumbFolder($img,'_s');
							//$imagetype = ($applied['workType']=='wanted')?$this->config->item('defaultWorkWanted_s'):$this->config->item('defaultWorkOffered_s');
							
							$userDefaultImage=($applied['creative']=='t')?$this->config->item('defaultCreativeImg'):($applied['associatedProfessional']=='t'?$this->config->item('defaultAssProfImg'):$this->config->item('defaultEnterpriseImg'));
							
								
					        $thumbImage = addThumbFolder($img,'_s');
							
							$elementImage=getImage($thumbImage,$userDefaultImage);					  
							?>
							<input type="hidden" name="currentRecordId" value="<?php echo $applied['status_id']  ?>" /> 
					        <input type="hidden" name="currentDelId" value="<?php echo $i  ?>" />	
										<div id="workApp<?php echo $i ?>" class="row nocravbg_commonshedow bdr_cacaca common_gradint bdr_bwhite position_relative"> 
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
													  <a target="_blank" href="<?php echo base_url()?>workshowcase/viewproject/<?php echo $applied['tdsUid'].'/'.$applied['workId'] ?>">
														 <?php echo ucfirst($applied['workTitle']) ?>
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
																<a onmousedown="mousedown_small_button(this)" onmouseup="mouseup_small_button(this)" onclick="deleteAppliedTmail('<?php echo $applied['status_id']?>','<?php echo $i ?>');" href="javascript://void(0);">
																	<span><div class="cat_smll_plus_icon"></div></span>
																</a>
															</div>
															
															 <div class="fr mr8 mt2"><a target="_blank" href="<?php echo $urlView ?>"><img src="<?php echo base_url('images/send.png');?>" /></a> </div>
															 
												  </div>
														
														<div class="clear"> </div>
														<div class="seprator_10"> </div>
														
														
														<div class="clr_f1592a font_opensansSBold pr11"> <?php //echo  dateFormatView($applied['expirydate'],'d F Y') ?> </div>
														<?php  $name = $applied['firstName'].' '.$applied['lastName'];?>
														<div class="row">
															<div class="cell  width_60 greyMsg"> To </div>
															<div class="cell width_100 height_18 overflowHid"> <a class="clr_E76D34" target="_blank" href="<?php echo base_url().'en/showcase/index/'.$applied['tdsUid']?>"> <?php echo substr($name,0,20) ?></a> </div>
														</div>
														<div class="row">
															<div class="cell width_60 greyMsg"> Sent </div>
															<div class="cell"><?php echo  dateFormatView($applied['dateApplied'],'d F Y') ?> </div>
														</div> 
														<div class="row">
															<div class="cell width_60 greyMsg"> Industry </div>
															<div class="cel"><?php echo $applied['IndustryName'] ?> </div>
														</div>
											  </div>

												<div class="clear"> </div>
												
										</div><!--Row-->

						     <div class="seprator_15"></div>


						<?php }  }?>

		  </div><!--cell width_569 pl20 -->            
	  </div><!--row padding_top10 -->
</div><!--row form_wrapper -->


<script>

function deleteAppliedTmail(delId,currentId){ 			
		var type = "Inbox";	
		
		$.ajax
		({     
			type: "POST",
			url: "<?php echo base_url() ?>tmail/trashTmailPopupMessage/"+delId+'/'+type,
			success: function(msg)
			{ 				
				$('#workApp'+currentId).remove();				 
			     //refreshPge();								
			}

		});				         
	} 


</script>
