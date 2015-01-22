<div class="footer_wrapper">
	<div class="footer_top_strip">
		<?php
			$bg_darker=$module=='home'?'class="bg_darker"':'';
		?>
		<div <?php echo $bg_darker;?> >
		 <img src="<?PHP echo  base_url('images/footer_top_strip.png');?>"/> 
	    </div>
	    </div>
		
		<div class="footer_content">
			<!--Set social link box-->
			<div class="row pb3">
				<div class="indexsocial_cont font_opensansSBold font_size14 clr_white">
					<div class="fl">
						<?php 
						/* Set Follow us link*/
						$facebook_url = $this->config->item('facebook_follow_url');
						$linkedin_url = $this->config->item('linkedin_follow_url');
						$twitter_url = $this->config->item('twitter_follow_url');
						$google_url = $this->config->item('google_follow_url');
						$crave_url = $this->config->item('crave_us');
						?>
						<span class="fl mt8"><?php echo $this->lang->line('craveUs');?></span>
						<a href="<?php echo $crave_url;?>" class="indexsocial toadsquare" target="_blank"></a>
					</div>
					<div class="fl ml36">
						<span class="fl mt8"><?php echo $this->lang->line('followUs');?></span>
						<a href="<?php echo $facebook_url;?>" class="indexsocial facebook_footer" target="_blank"></a>
						<a href="<?php echo $twitter_url;?>" class="indexsocial twitter_footer" target="_blank"></a>
						<a href="<?php echo $linkedin_url;?>" class="indexsocial linkedin_footer" target="_blank"></a>
						<a href="<?php echo $google_url;?>" class="indexsocial googleplus_footer" target="_blank"></a>
					</div>
				</div>
				<div class="clear"></div>
			</div>
			<!--Set social link box-->
		<div class="footer_left min_height235 pr mt-50"> 
				<a href="#"><img src="<?php echo base_url();?>templates/default/images/logo_toad_grayscale.png" /></a>
				<div class="footer_search_box">
				<div class="search_box_wrapper">
					<?php
							$formAttributes = array(
								'name'=>'SearchFooterForm',
								'id'=>'SearchFooterForm',
							);
							echo form_open(base_url(lang().'/search/searchform'),$formAttributes);
						?>
						<input name="keyWord" type="text" class="search_text_box" placeholder="<?php echo $this->lang->line('keywordSearch');?>" value="<?php echo $this->lang->line('keywordSearch');?>"  onclick="placeHoderHideShow(this,'<?php echo $this->lang->line('keywordSearch');?>','hide')" onblur="placeHoderHideShow(this,'<?php echo $this->lang->line('keywordSearch');?>','show')" />
						<input name="sectionId" type="hidden" value="">
						<div>
							<input type="submit" name="searchCrave" value="" class="search_btn_glass">
							<!--<input type="image" value="searchCrave" name="searchCrave" src="<?php echo base_url();?>images/btn_search_box.png" >-->
						</div>
					<?php echo form_close(); ?>
			  </div><!--search_box_wrapper-->
			  </div><!--footer_search_box-->
			 
			  <!--Add notorn verified seal start-->
			  <?php
			  if(ENVIRONMENT=='production'){ ?>
				  <div class="pa bottom_0 l10px" id="SSLDiv">
					<table width="135" border="0" cellpadding="2" cellspacing="0" title="Click to Verify - This site chose Symantec SSL for secure e-commerce and confidential communications.">
						<tr>
							<td width="135" align="center" valign="top"><script type="text/javascript" src="https://seal.verisign.com/getseal?host_name=www.toadsquare.com&amp;size=L&amp;use_flash=YES&amp;use_transparent=YES&amp;lang=en"></script><br /><a href="http://www.symantec.com/verisign/ssl-certificates" target="_blank"  style="color:#000000; text-decoration:none; font:bold 7px verdana,sans-serif; letter-spacing:.5px; text-align:center; margin:0px; padding:0px;"><!--ABOUT SSL CERTIFICATES--></a></td>
						</tr>
					</table>
				  </div>
				<?php
			  } ?>
			  <!--Add notorn verified seal end-->
			  
		</div><!--footer_left-->
		
		<div class="footer_right">
		
				<div class="footer_link1">
				<div class="footer_block">
					<a class="<?php echo isset($footerMenu_creatives)?$footerMenu_creatives:'';?>" href="<?php echo base_url(lang().'/creatives/')?>" /><?php echo $this->lang->line('creatives')?></a><br/>
					<a class="<?php echo isset($footerMenu_associateprofessional)?$footerMenu_associateprofessional:'';?>" href="<?php echo base_url(lang().'/associateprofessional/');?>" ><?php echo $this->lang->line('associated').'&nbsp;'.$this->lang->line('professional')?></a><br/>
					<a class="<?php echo isset($footerMenu_enterprises)?$footerMenu_enterprises:'';?>" href="<?php echo base_url(lang().'/enterprises/')?>"/><?php echo $this->lang->line('enterprises')?></a>
		  </div>
		  
		  <div class="footer_block">
					<a class="<?php echo isset($footerMenu_works)?$footerMenu_works:'';?>" href="<?php echo base_url(lang().'/works');?>"><?php echo $this->lang->line('work')?></a><br/>
					<a class="<?php echo isset($footerMenu_products)?$footerMenu_products:'';?>"  href="<?php echo base_url(lang().'/products');?>"><?php echo $this->lang->line('products')?></a>
		
		  </div>
		  
			 </div>
				<div class="footer_link2">
				<div class="footer_block">
					<a class="<?php echo isset($footerMenu_filmnvideo)?$footerMenu_filmnvideo:'';?>" href="<?php echo base_url(lang().'/filmnvideo');?>"><?php echo $this->lang->line('film').'&nbsp;'.$this->lang->line('&').'&nbsp;'.$this->lang->line('video')?> </a><br/>
					<a class="<?php echo isset($footerMenu_musicnaudio)?$footerMenu_musicnaudio:'';?>" href="<?php echo base_url(lang().'/musicnaudio');?>"><?php echo $this->lang->line('music').'&nbsp;'.$this->lang->line('&').'&nbsp;'.$this->lang->line('audio')?></a><br/>
					<a class="<?php echo isset($footerMenu_photographynart)?$footerMenu_photographynart:'';?>" href="<?php echo base_url(lang().'/photographynart/');?>"><?php echo $this->lang->line('photography').'&nbsp;'.$this->lang->line('&').'&nbsp;'.$this->lang->line('art')?> </a></a>
				</div>
		  
		   <div class="footer_block">
					<a  class="<?php echo isset($footerMenu_blogs)?$footerMenu_blogs:'';?>" href="<?php echo base_url(lang().'/blogs/index');?>"><?php echo $this->lang->line('blogs')?></a><br/>
				   <a  href="<?php echo base_url(lang().'/forums');?>"><?php echo $this->lang->line('forums')?></a><br/>
				   <a class="gray_color-3" href="<?php echo base_url(lang().'/tips/front_tips');?>"><?php echo $this->lang->line('tips')?></a>
		  </div> 
		  
				</div>
				
				<div class="footer_link3">
					<div class="footer_block">
					<a class="<?php echo isset($footerMenu_writingnpublishing)?$footerMenu_writingnpublishing:'';?>" href="<?php echo base_url(lang().'/writingnpublishing');?>"><?php echo $this->lang->line('writing').'&nbsp;'.$this->lang->line('&').'&nbsp;'.$this->lang->line('publishing')?></a><br/>
					<a class="<?php echo isset($footerMenu_performancesnevents)?$footerMenu_performancesnevents:'';?>" href="<?php echo base_url(lang().'/performancesnevents');?>"><?php echo $this->lang->line('performances').'&nbsp;&&nbsp;'.$this->lang->line('events')?></a><br/>
					<a class="<?php echo isset($footerMenu_educationnmaterial)?$footerMenu_educationnmaterial:'';?>"  href="<?php echo base_url(lang().'/educationnmaterial');?>"><?php echo $this->lang->line('educational').'&nbsp;'.$this->lang->line('material')?></a>
					</div>
					
					<div class="footer_block">
					<a href="<?php echo base_url(lang().'/cms/apps');?>"><?php echo $this->lang->line('work_profile_apps');?></a><br />
					<a href="<?php echo base_url(lang().'/cms/apps');?>"><?php echo $this->lang->line('meeting_point_apps');?></a>					
					</div>                     
		  
				</div>
				
			<div class="clear"></div>
			
			
			<div class="mostbottom_col1"><a href="<?php echo base_url(lang().'/cms/termsncondition');?>"><?php echo $this->lang->line('termsNcond')?> </a><br /> 
			<?php $this->load->view('common/suggestionView');?>
			
			</div>
			<div class="mostbottom_col2">
				<a href="<?php echo base_url(lang().'/cms/descofservices');?>">Description of Services</a> <br />
				<?php
					$abusiveReportSelect=$this->load->view('common/abusiveReportSelect','',true);
					$abusiveReportComplain=$this->load->view('common/abusiveReportComplain','',true);
					$abusiveReportForm=$this->load->view('common/abusiveReportForm','',true);
				?>
				<script>
					var abusiveReportSelect=<?php echo json_encode($abusiveReportSelect);?>;
					var abusiveReportComplain=<?php echo json_encode($abusiveReportComplain);?>;
					var abusiveReportForm=<?php echo json_encode($abusiveReportForm);?>;
				</script>
				<!--Manage link for Abuse report -->
				<?php $loggedUserId=isloginUser();
				$beforeReportAProblem=$this->lang->line('beforeReportAProblemLoggedIn');
				if($loggedUserId > 0){	?>								  							  
					<a href="<?php echo base_url(lang().'/report_a_problem');?>"><?php echo $this->lang->line('problemReport');?></a><?php
					}
				else{	
					$reportSendSuggest="openLightBox('popupBoxWp','popup_box','/auth/login','".$beforeReportAProblem."')";?>
					<a href="javascript:void(0)" onclick="<?php echo $reportSendSuggest?>"><?php echo $this->lang->line('problemReport');?> </a><?php
				}	
				?>
				<?php //$this->load->view('common/abusiveReportView');?>
				</div>				
				<div class="mostbottom_col3">
					<a href="#" class="footer_right_nohover"><?php echo $this->lang->line('copyRight');?></a><br />
				    <?php 
				    $legalsContactPopup=$this->load->view('common/legals_contact','',true);
					?>
					<script>
						var legalsContactPopup=<?php echo json_encode($legalsContactPopup);?>;
					</script>
									
				   
				    <a href="javascript:void(0)" onclick="loadPopupData('popupBoxWp','popup_box',legalsContactPopup);"><?php echo $this->lang->line('legals&Contact');?></a>
				</div>
			</div>
			<!--foote_right-->
			<div class="clear"></div>
						
			</div>
			<!--footer_content-->
			<div class="footer_bottom_strip"> <img src="<?PHP echo base_url('images/footer_bottom_strip.png');?>"/> </div>
</div><!--footer-wrapper-->
<div class="footer_spacer"></div>
<div class="clear"></div>
<?php
$InternetExplorerMsgClose=$this->session->userdata('InternetExplorerMsgClose');
$isIE8=get_user_browser($checkI8=true);
if($isIE8 && $InternetExplorerMsgClose != 1){?> 
	<div id="InternetExplorerMsg" class="InternetExplorerMsg">
		<?php echo $this->lang->line('InternetExplorerMsg');?>
		<div class="fr mr20">
			<div class="tds-button-top">
				<a onclick="InternetExplorerMsgClose();" href="javascript:void(0);" ><span><div class="projectDeleteIcon"></div></span></a>
			</div>
		</div>
	</div>
	<?php
}
echo get_global_messages();


if($this->session->flashdata('verifiedEmailPopup')){
	?>
	<script>
		customAlert('<?php echo $this->session->flashdata('verifiedEmailPopup'); ?>');
	</script>
	<?php 
}elseif($loggedUserId && $this->session->userdata('showwelcomepopup')){
	$this->session->unset_userdata('showwelcomepopup');
	echo "<script>openLightBox('popupBoxWp','popup_box','/auth/selectPage');</script>";
}elseif(!$loggedUserId && isset($loadLoinPopup) && $loadLoinPopup){
	$message=isset($message)?$message:'';
	?>
	<script>
		openLightBox('popupBoxWp','popup_box','/auth/login','<?php echo $message;?>');
	</script>
	<?php
}else{
		//$this->load->view('unreadTmailAlert'); 
}
     

/*
if(ENVIRONMENT=='production'){ ?>
<script>
	$( document ).ready(function(){
		//loadssl();
		$("#SSLDiv").load(baseUrl+language+'/common/loadssl');
	});
</script>
<?php 
}*/

