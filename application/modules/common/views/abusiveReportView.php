<?php
						$loggedUserId=isloginUser();
						$userInfo = showCaseUserDetails($loggedUserId,'frontend');
						
						//print_r($userInfo);
						$beforeReportFormIn=$this->lang->line('beforeReportFormLoggedIn');
								if($loggedUserId > 0){									  							  
									
										$abusiveReportForm=$this->load->view('common/abusiveReportSelect',array('userId'=>$loggedUserId), true);
										echo "<script>var suggestion =".json_encode($abusiveReportForm)."</script>";
										$functionabusiveReportForm="if(checkIsUserLogin('".$beforeReportFormIn."')){loadPopupData('popupBoxWp','popup_box',suggestion)}";
									}
								
								else{
									
									
									$functionabusiveReportForm="openLightBox('popupBoxWp','popup_box','/auth/login','".$beforeReportFormIn."')";
								}
							?>



	    
         <a href="javascript:void(0)" onclick="<?php echo $functionabusiveReportForm?>"><?php echo $this->lang->line('problemReport');?> </a>             

	 <div class="clear"></div>
