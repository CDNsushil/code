<script type="text/javascript">  
  $(document).ready(function(){
    $("#profile_form").validate();
	$("#photo").css('display','none');
	// check points
	
/*  $.ajax({
		url:BASEPATH+'profile/get_milestone_alert',
		type: "POST",
		dataType:"json",
		success:function(data){
		if(data)
		{
			$.fancybox(
				data.tpl,
				{
					'autoDimensions'	: false,
					'width'				:250,
					'height'			:100
				}
			)
			
			setTimeout("triggerClose()",7000);
		}
		},
		error:function(err){
			consol.log(err);
		},
	});
  
  */
  
  }); // end ready
  
function triggerClose()
{
var el = $("#fancybox-close");
el.bind("click", $.fn.fancybox.close);
el.trigger('click'); 
}
  
  function validate_image()
  {
		var profile_picture	=	 $('#profile_picture').val();
		if(profile_picture == "")
		{
			$("#success").css('display','none');
			$("#error").css('display','none');
			$("#photo").css('display','block');
			return false;
		}
		else
		{
			$("#photo").css('display','none');
			return true;
		}
  }
</script>

<!-- mid site panel -->
<div id="columnMidpanel">
        <!-- top panel -->
        <div class="toppanelMid">
          <div class="leftPointsName">
            <div class="spanprofilename"><?php echo get_username($user_id); ?></div>
            <div class="spanproPintsname">
              <p class="pointstext"><?php echo $this->lang->line('user_profile_album');?></p>
              <p class="SpaceFixnew"></p>
              <p class="pointstext2">15</p>
              <p class="pointstext3"><?php echo $this->lang->line('user_profile_photos');?></p>
            </div>
          </div>
			<?php
			// show point on top of the page (If user comes under incentive program)
			echo Modules::run('points',$user_id,2);
			?>
           <?php /*
		  if(is_incentive_user(get_session_user_id()) == 1)
		  { 
		  ?>
          <div class="useItName">
            <p class="Chatching_Points"><?php echo $this->lang->line('user_profile_recent_activity');?></p>
            <p class="linegapR">&nbsp;</p>
            <p class="pointsprofile"><a href="<?php echo BASEURL; ?>profile/get_points"><?php echo $this->lang->line('user_profile_total_points');?></a></p>
            <p class="pointsSmall"><?php echo $user_points; ?> <?php echo $this->lang->line('user_profile_points');?></p>
          </div>
		  <?php
		  }
		  else
		  {
		  ?>
		  	<div class="useItName">
				<p class="use-text">Use It, Own it</p>
				<p class="use-text2">Become a Consultant</p>
				<p class="use-text3">click <img src="<?php echo PROFILE_IMG; ?>here.png" title="here" align="absmiddle" style="margin-bottom:-3px;" /> for more information</p>
			</div>
		  <?php
		  } */
		  ?>
        </div>
        <!-- chanign points -->
        <div class="clear"></div>
        <div class="ChangingPoints">
          <p class="chanchingHeading2"><?php echo $this->lang->line('user_profile_account_settings');?></p>
          <!-- toggle Div li-->
          <div class="uitoggle">
			  
			  <!-- Created by lalit 16/5/2012 -->
			  <ul>
				<li id="security_icon"> <span class="SecurityIcon"><?php echo $this->lang->line('user_profile_security');?></span> <span class="editbutton"><a href="#"><img src="<?php echo PROFILE_IMG; ?>edit.png" title="edit" /></a></span></li>
					<div class="clear"></div>
					<p class="heightFix22"></p>
				  <div id="security_display" style="display:none">

						<div>
							<div class="borderShedow"></div>
							<div class="profiletextBox2">
							  <div class="spanTextP">
								<p class="profiletextChange">Change password</p>
								<!-- password box-->
								<div class="changepassword">
								  <!-- current password-->
								  <div class="currentpassword">
									<p class="lebeltextstep2">Current password</p>
									<span>
									<input name="search2" type="password" value="subhashkumarpatidar" />
									</span> </div>
								  <!-- new password -->
								  <div class="newpassword">
									<p class="lebeltextstep2">New password</p>
									<span>
									<input name="search2" type="password" value="subhashkumarpatidar" />
									</span> </div>
								  <!-- type new password -->
								  <div class="typenewpassword">
									<p class="lebeltextstep2">Type new password</p>
									<span>
									<input name="search2" type="password" value="subhashkumarpatidar" />
									</span> </div>
								  <!-- password box end-->
								</div>
							  </div>
							  <div class="savebuttonSecurity">
								<div class="pagebuttons1">
								  <button class="reset"><span class="button"><span>Save Password</span></span></button>
								</div>
							  </div>
							  <div class="clear"></div>
							</div>
							<div class="SecuritysettingTextwrap">
							  <p class="profiletextChange">Security settings</p>
							  <p class="heightNew9sp3">&nbsp;</p>
							  <p class="textwrapNew">lorem ipsum dolor sit amet consec tetuer adipiscing elit praesent vestibulum molestie lacus aenean nonummy... </p>
							  <div class="table">
								<!-- rowwise table01 -->
								<div class="clear"></div>
								<!----------------------------------------------------->
								<div >
									<span>
										<?php echo $this->lang->line('user_profile_security');?>
									</span> <span class="editbutton"><a href="#"><img id="update_user_security" src="<?php echo PROFILE_IMG; ?>edit2.png" title="edit" /></a></span> 
									<p class="heightFix22"></p>
										<div class="clear"></div>	
										<div>
											<span class="success_message" id="success"><?php echo $this->session->flashdata('success_update_qa');?></span>
												<span class="error_message" id="error"><?php echo $this->session->flashdata('error_update_qa');?></span>
									</div>
									<div class="clear"></div>
									<div id="user_security_content"  style="display:none;">
									<?php	echo form_open('profile/update_security_answer'); ?>
										<div class="fleft">
											<div class="fleft">
												 <div class="lebelboxui1">
															  <!-- lebel step 1-->
															 <span class="security_box_select"><div class="clear"></div> <span class="abc"><?php 
														$selected = "";
														if(isset($get_user_qa[1]['q'])) {echo $get_user_qa[1]['q']; 
														$selected = $get_user_qa[1]['a']; }?></span>
														<?php	
																$options	=	 array();
																$options['0'] = "--Select Question 1--";
																$options['custom1'] = "Add Custom qustion";
																foreach($security_question as $question)
																{	
																	$options[$question->question_id] = $question->question;
																}
																
																$js = 'id="q_select1" class="q_select"';
																echo form_dropdown('security_question1', $options, $selected,$js);
														?>
																 </span>
														
													</div>	
												
														

											</div>

											<div class="fleft">
												<div class="newInputBox">
													<div class="inputbox266_new">
													
																  <span><div class="clear"></div>
														<?php
															$value_name = "";
															if(!empty($get_user_qa)){
															$value_name	=	 $get_user_qa['s_a']['0']->answer;
															}
															$data = array(
																	  'name'		=> 	'security_a1',
																	  'id'			=> 	'name',
																	  'class'		=>	'required',
																	  'title'		=>	'Enter Security Answer',
																	  'maxlength'	=> '40',
																	  'value'		=>	 $value_name
																		);

															echo form_input($data);
															
														?>
														
													  </span> </div></div>
											</div> 
											<div class="clear"></div>
											<div class="fleft">
												<div class="newInputBox">
													<div class="inputbox266_new">
													
																  <span><div class="clear"></div>
														<?php
															$value_name = "";
															$data = array(
																	  'name'		=> 	'custom_q1',
																	  'id'			=> 	'custom_q1',
																	  'class'		=>	'required',
																	  'title'		=>	'Enter Security Answer',
																	  'maxlength'	=> '40',
																	  'value'		=>	 $value_name
																		);

															echo form_input($data);
															
														?>
														
													  </span> </div></div>
											</div> 
											<div class="clear"></div>
											<div class="fleft">
												 <div class="lebelboxui1">
															  <!-- lebel step 1-->
															 <span class="security_box_select"><div class="clear"></div> <span class="abc"><?php 
														$selected = "";
														if(isset($get_user_qa[2]['q'])) {echo $get_user_qa[2]['q']; 
														$selected = $get_user_qa[2]['a']; }?></span>
														<?php	
																$options	=	 array();
																$options['0'] = "--Select Question 1--";
																$options['custom2'] = "Add Custom Question";
																foreach($security_question as $question)
																{	
																	$options[$question->question_id] = $question->question;
																}
																
																$js = 'id="q_select2" class="q_select"';
																echo form_dropdown('security_question2', $options, $selected,$js);
														?>
																 </span>
														
													</div>	
											</div>
											<div class="fleft">
												<div class="newInputBox">
													<div class="inputbox266_new">
													
																  <span><div class="clear"></div>
														<?php
															$value_name = "";
															if(!empty($get_user_qa)){
															$value_name	=	 $get_user_qa['s_a']['0']->answer1;
															}
															
															$data = array(
																	  'name'		=> 	'security_a2',
																	  'id'			=> 	'name',
																	  'class'		=>	'required',
																	  'title'		=>	'Enter Security Answer',
																	  'maxlength'	=> '40',
																	  'value'		=>	 $value_name
																		);

															echo form_input($data);
															
														?>
														
													  </span>
											 </div>
											</div>
											</div>
											
											<div class="clear"></div>
											<div class="fleft">
												<div class="newInputBox">
													<div class="inputbox266_new">
													
																  <span><div class="clear"></div>
														<?php
															$value_name = "";
															$data = array(
																	  'name'		=> 	'custom_q2',
																	  'id'			=> 	'custom_q2',
																	  'class'		=>	'required',
																	  'title'		=>	'Enter Security Answer',
																	  'maxlength'	=> '40',
																	  'value'		=>	 $value_name
																		);

															echo form_input($data);
															
														?>
														
													  </span> </div></div>
											</div> 
											<div class="clear"></div>
											<div class="fleft">
												 <div class="lebelboxui1">
															  <!-- lebel step 1-->
															 <span class="security_box_select"><div class="clear"></div> <span class="abc"><?php 
														$selected = "";
														if(isset($get_user_qa[3]['q'])) {echo $get_user_qa[3]['q']; 
														$selected = $get_user_qa[3]['a']; }?></span>
														<?php	
																$options	=	 array();
																$options['0'] = "--Select Question 1--";
																$options['custom3'] = "Add Custom Question";
																foreach($security_question as $question)
																{	
																	$options[$question->question_id] = $question->question;
																}
																
																$js = 'id="q_select3" class="q_select"  ';
																echo form_dropdown('security_question3', $options, $selected,$js);
														?>
																 </span>
														
													</div>	
											</div>
											
											<div class="fleft">
												<div class="newInputBox">
													<div class="inputbox266_new">
													
																  <span><div class="clear"></div>
														<?php
															$value_name = "";
															if(!empty($get_user_qa)){
															$value_name	=	 $get_user_qa['s_a']['0']->answer2;
															}
															
															$data = array(
																	  'name'		=> 	'security_a3',
																	  'id'			=> 	'name',
																	  'class'		=>	'required',
																	  'title'		=>	'Enter Security Answer',
																	  'maxlength'	=> '40',
																	  'value'		=>	 $value_name
																		);

															echo form_input($data);
															
														?>
														
													  </span> </div></div>
												
											</div> 
											<div class="clear"></div>
												<div class="fleft">
												<div class="newInputBox">
													<div class="inputbox266_new">
													
																  <span><div class="clear"></div>
														<?php
															$value_name = "";
															$data = array(
																	  'name'		=> 	'custom_q3',
																	  'id'			=> 	'custom_q3',
																	  'class'		=>	'required',
																	  'title'		=>	'Enter Security Answer',
																	  'maxlength'	=> '40',
																	  'value'		=>	 $value_name
																		);

															echo form_input($data);
															
														?>
														
													  </span> </div></div>
											<div class="inputbox266"> 
												
													<span class="saveChange"> 
													<button class="reset" type="submit">
														<span class="button next_bt text_caseL">
															<span class="width_85px">Save Changes</span>
														</span>
													</button>
													</span>
													</div>
											</div> 
											<div class="clear"></div>

										</div>
										<?php echo form_close();?>
									</div>
								</div>
									<div class="clear"></div>
								<!----------------------------------------------------->
								
								
								
								
								<!-- rowwise table02 -->
								<div class="rowNewprofile">
								  <div class="LeftClMBoxSP3">Security Question</div>
								  <div class="MidClMBoxSP3">
									<div class="lightclr">Setting a security question will help us identify you.</div>
								  </div>
								  <div class="RightClMBoxSP3" id="secure_button"> <span><img src="<?php echo PROFILE_IMG; ?>edit2.png" title="Edit" /></span> </div>
								  <div class="clear"></div>
								</div>
								<!-- rowwise table02 -->
								<div class="rowNewprofile" style="display:none" id="secure_div">
								  <div class="LeftClMBoxSP3">&nbsp;</div>
								  <div class="MidClMBoxSP3_top">
									<div><span class="lightclr">Secure browsing is currently</span>
							<?php if($secure_browsing==1) { echo "enabled."; } else { echo "desabled."; } ?>
							</div>
								  </div>
								  <div class="clear"></div>
								  <div class="MidClMBoxSP3_below">
									<div class="MidClMBoxSP3"> <span class="BoxSP3checkbox">

								<?php if($secure_browsing==1) { ?>
										   <input name="secure_check" id="secure_check" type="checkbox" value="secure" checked />
								<?php } else { ?>
										   <input name="secure_check" id="secure_check" type="checkbox" value="secure" />
								<?php } ?>

						
									  </span>
									  <label> Browse CC on a secure connection (https) when 
									  possible</label>
									  <div class="clear"></div>
									</div>
									<div class="RightClMBoxSP3"> <span><img src="<?php echo PROFILE_IMG; ?>save.png" title="Save" onClick="saveSequre('secure_browsing','secure_check')" /></span> <span><img src="<?php echo PROFILE_IMG; ?>canecl.png" title="Cancel" onClick="saveCancel('secure_div')" /></span> </div>
								  </div>
								  <div class="clear"></div>
								</div>
								<!--row end-->
								<!-- rowwise table02 -->
								<div class="rowNewprofile" >
								  <div class="LeftClMBoxSP3">Login Notification</div>
								  <div class="MidClMBoxSP3_top">
									<div><span class="lightclr">Email and text message notifications are</span> enabled.</div>
					 <div class="RightClMBoxSP3" id="loign_not_button"> <span><img src="<?php echo PROFILE_IMG; ?>edit2.png" title="Edit" /></span> </div>
								  </div>


								  <div class="clear"></div>
								  <div class="MidClMBoxSP3_below" style="display:none;"; id="login_not_div">
									<div class="MidClMBoxSP3">
									  <p>We can notify you when your account is accessed from
										a computer or mobile device that you haven´t used
										before. Choose a notificaction method below:</p>
									  <div> <span class="BoxSP3checkbox">
										</span>
								<?php
								if($secure_notification==1) { ?>
											<input name="email_noti" id="email_noti" type="checkbox" value="secure" checked /> Email
											<input name="text_noti" id="text_noti" type="checkbox" value="secure" /> Text
								<?php }	else if($secure_notification==2) {  ?>
											<input name="email_noti" id="email_noti" type="checkbox" value="secure" /> Email
											<input name="text_noti" id="text_noti" type="checkbox" value="secure" checked /> Text
								<?php }	else if($secure_notification==3) {  ?>
											<input name="email_noti" id="email_noti" type="checkbox" value="secure" checked /> Email
											<input name="text_noti" id="text_noti" type="checkbox" value="secure" checked /> Text
								<?php } else { ?>
											<input name="email_noti" id="email_noti" type="checkbox" value="secure" /> Email
											<input name="text_noti" id="text_noti" type="checkbox" value="secure" /> Text
								<?php } ?>

										<div class="clear"></div>
									  </div>
									</div>
									<div class="RightClMBoxSP3"> <span><img src="<?php echo PROFILE_IMG; ?>save.png" title="Save" onClick="saveSequrelogin('login_notification','email_noti','text_noti')" /></span> <span><img src="<?php echo PROFILE_IMG; ?>canecl.png" title="Cancel" onClick="saveCancel('login_not_div')" /></span></div>
								  </div>
								  <div class="clear"></div>
								</div>
								<!--row end-->
								<!-- rowwise table02 -->
								<div class="rowNewprofile">
								  <div class="LeftClMBoxSP3">Login Approvals</div>
								  <div class="MidClMBoxSP3_top">
									<div><span class="lightclr">Approval is required when loggin in from an unrecognized device.</span></div>
								  </div>
					 <div class="RightClMBoxSP3" id="loign_app_button"> <span><img src="<?php echo PROFILE_IMG; ?>edit2.png" title="Edit" /></span> </div>

								  <div class="clear"></div>
								  <div class="MidClMBoxSP3_below" style="display:none;"; id="login_app_div">
									<div class="MidClMBoxSP3">
									  <div> <span class="BoxSP3checkbox">

							<?php if($secure_approvals==1) { ?>
										<input name="login_approve" id="login_approve" type="checkbox" value="secure" checked />
							<?php } else { ?>
										<input name="login_approve" id="login_approve" type="checkbox" value="secure" />
							<?php } ?>

										</span>
										<label> Require me to enter a security code each time an
										unrecognized computer or device tries to access
										my account</label>
										<div class="clear"></div>
									  </div>
									</div>
									<div class="RightClMBoxSP3"> <span><a href="javascript:void()"><img src="<?php echo PROFILE_IMG; ?>save.png" title="Save" onClick="saveSequre('login_approvals','login_approve')" /></a></span> <span><img src="<?php echo PROFILE_IMG; ?>canecl.png" title="Cancel" onClick="saveCancel('login_app_div')" /></span> </div>
								  </div>
								  <div class="clear"></div>
								</div>
								<!--row end-->
								<!-- rowwise table02 -->
								<div class="rowNewprofile">
								  <div class="LeftClMBoxSP3">App Passwords</div>
								  <div class="MidClMBoxSP3_top">
									<div><span class="lightclr">You haven´t created App Passwords.</span></div>
								  </div>
					 <div class="RightClMBoxSP3" id="app_button"> <span><img src="<?php echo PROFILE_IMG; ?>edit2.png" title="Edit" /></span> </div>

								  <div class="clear"></div>
								  <div class="MidClMBoxSP3_below" style="display:none;"; id="app_div">
									<div class="MidClMBoxSP3"> <a href="#">Learn more</a> about password &nbsp;&nbsp;&nbsp;<a href="javascript:void()" onClick="generate_app_pass()">Generate app password</a> </div>
									<div class="RightClMBoxSP3"> <span><a href="#"><img src="<?php echo PROFILE_IMG; ?>save.png" title="Save" /></a></span> <span><a href="#"><img src="<?php echo PROFILE_IMG; ?>canecl.png" title="Cancel" /></a></span> </div>
								  </div>
								  <div class="clear"></div>
								</div>
								<!--row end-->
								<!-- rowwise table02 -->
								<div class="rowNewprofile">
								  <div class="LeftClMBoxSP3">Recognized Devices</div>
								  <div class="MidClMBoxSP3_top">
									<div><span class="lightclr">You have <span class="highlight">0</span> recognized devices.</span></div>
								  </div>
					 <div class="RightClMBoxSP3" id="recognized_button"> <span><img src="<?php echo PROFILE_IMG; ?>edit2.png" title="Edit" /></span> </div>

								  <div class="clear"></div>
								  <div class="MidClMBoxSP3_below" style="display:none;"; id="recognized_div">
									<div class="MidClMBoxSP3">
									  <p>You won´t get notified or have to confirm your identity
										when logging in from these devices:</p>
									  <div> <span class="deviceL_txt">Access internet</span> <span class="deviceR_txt lightclr">January 3,   2012</span> <a class="deviceR_link" href="#">Remove</a> </div>
									  <div> <span class="deviceL_txt">Access laptop </span> <span class="deviceR_txt lightclr">January 9,   2012</span> <a class="deviceR_link" href="#">Remove</a> </div>
									  <div> <span class="deviceL_txt">Access lorem ipsum </span> <span class="deviceR_txt lightclr">January 18,   2012</span> <a class="deviceR_link" href="#">Remove</a> </div>
									</div>
									<div class="RightClMBoxSP3"> <span><a href="#"><img src="<?php echo PROFILE_IMG; ?>save.png" title="Save" /></a></span> <span><a href="#"><img src="<?php echo PROFILE_IMG; ?>canecl.png" title="Cancel" /></a></span> </div>
								  </div>
								  <div class="clear"></div>
								</div>
								<!--row end-->
								<!---------------------------------------------------->
								<!-- rowwise table02 -->
									<div class="rowNewprofile">
									  <div class="LeftClMBoxSP3">Active Sessions</div>
									  <div class="MidClMBoxSP3_top">											
										<div><span class="lightclr">Logged from <span class="highlight"><?php echo $cityName.",".$regionName.",".$countryName;?></span> and <span class="highlight">
										 <?php if(count($sessionDetail) > 2 ) {
												echo count($sessionDetail) - 2;
										 } 
										?>

									</span> other location.</span></div>
									 <div class="RightClMBoxSP3" id="active_button"> <span><img src="<?php echo PROFILE_IMG; ?>edit2.png" title="Edit" /></span> </div>
												  </div>
												  <div class="clear"></div>
												  <!-- rowinner start-->
										<div style="display:none;"; id="active_div">
												  <div class="MidClMBoxSP3_below bdr_botm">
													<div class="MidClMBoxSP3">
													  <div class="SpaceFix"></div>
													  <div> <span class="LoggL_txt"><span class="boldtxt">Current Session</span></span> <span class="LoggR_txt lightclr">&nbsp;</span> </div>
													  <div> <span class="LoggL_txt">Device Name:</span> <span class="LoggR_txt lightclr">User Laptop</span> </div>
													  <div> <span class="LoggL_txt">Location:</span> <span class="LoggR_txt lightclr"><?php echo $cityName.",".$regionName.",".$countryName;?></span> </div>
													  <div> <span class="LoggL_txt">Device Type:</span> <span class="LoggR_txt lightclr"><?php echo $device_type;?></span> </div>
													</div>
													<div class="RightClMBoxSP3">
													  <div class="SpaceFix"></div>
													  <span><a href="#"><img src="<?php echo PROFILE_IMG; ?>close2.png" title="Save" /></a></span> </div>
												  </div>
												  <!-- rowinner end-->
												  <!-- rowinner start-->
												  <div class="MidClMBoxSP3_below bdr_botm">
													<p class="lightclr font11px pdgLR10px">If you notice any unfamiliar devices or locations, click 'End Activity' to end the session. This list does not currently include sessions on CC´s mobile site (m.chatching.com).</p>
												  </div>
												  <!-- rowinner end-->
												  <!-- rowinner start-->
												  <div class="MidClMBoxSP3_below bdr_botm">
													  
													<div class="MidClMBoxSP3">
													<?php if(count($sessionDetail) > 0 ) { 
														$last_data = get_time_zone2($sessionDetail[0]->ip);

														?>
													  <div> <span class="LoggL_txt">Last Accessed:</span> <span class="LoggR_txt lightclr"><?php echo $sessionDetail[0]->datetime;?></span> </div>
													  <div> <span class="LoggL_txt">Location:</span> <span class="LoggR_txt lightclr"><?php echo $last_data['cityName'].",".$last_data['regionName'].",".$last_data['countryName'];?></span> </div>
													  <div> <span class="LoggL_txt">Device Type:</span> <span class="LoggR_txt lightclr"><?php echo $sessionDetail[0]->device_type;?></span> </div>
														<?php } else { ?>
													  <div> <span class="LoggL_txt">Last Accessed:</span> <span class="LoggR_txt lightclr">February 6 at 12:02pm</span> </div>
													  <div> <span class="LoggL_txt">Location:</span> <span class="LoggR_txt lightclr">Saturno, FL, USA</span> </div>
													  <div> <span class="LoggL_txt">Device Type:</span> <span class="LoggR_txt lightclr">Unknown</span> </div>
													<?php } ?>
													</div>
													
													<div class="RightClMBoxSP3"> <span class="end_actclr">End Activity</span> </div>
												  </div>
												  <!-- rowinner end-->
												  <!-- rowinner start-->
												  
												  <?php if(count($sessionDetail) > 2 ) { 
														for($counter=1;$counter<count($sessionDetail);$counter++) { 
																if($counter < 3) {
															$data_detail = get_time_zone2($sessionDetail[$counter]->ip);

														?>  
																		  <div class="MidClMBoxSP3_below bdr_botm">
													  
														<div class="MidClMBoxSP3">
														  <div> <span class="LoggL_txt">Device Name:</span> <span class="LoggR_txt lightclr">User Laptop</span> </div>
														  <div> <span class="LoggL_txt">Location:</span> <span class="LoggR_txt lightclr"><?php echo $data_detail['cityName'].",".$data_detail['regionName'].",".$data_detail['countryName'];?></span> </div>
														  <div> <span class="LoggL_txt">Device Type:</span> <span class="LoggR_txt lightclr"><?php echo $sessionDetail[$counter]->device_type;?></span> </div>
														</div>
														
													<div class="RightClMBoxSP3"> <span class="end_actclr">End Activity</span> </div>
													
												  </div>

													<?php } } } ?>
												  
												  <!-- rowinner end-->
												  <!-- rowinner start-->
												
												  
												  <!-- rowinner end-->
												  <div class="clear"></div>
												</div>
												<!--row end-->
											  </div>
								</div>
											  <div class="clear"></div>
											</div>
										  </div>
										<div class="clear"></div>
								  </div>
								<!---------------------------------------------------->
				</div>
							  <div class="clear"></div>
							</div>
						  </div>
						<div class="clear"></div>
				  </div>
				
					<!-- End lalit -->

             
              <li>
				  <p  id ="edit_profile" >
				    <span class="profileIcon">
					   <?php echo $this->lang->line('user_profile_profile');?>
					</span>
					<span class="editbutton">
						<a href="javascript:void(0)">
							<img src="<?php echo PROFILE_IMG; ?>edit.png" title="edit" />
						</a>
					</span>
				  </p>
				  <span class="success_message"><?php echo $this->session->flashdata('success_message');?></span>
				  <span class="error_message"><?php echo $this->session->flashdata('error_message');?></span>
			  </li>
            <div >
              <!--<p  id ="edit_profile" class="profiletextChange pdg_left5px"><?php echo $this->lang->line('user_profile_change_information');?> 
			  <span class="success_message"><?php echo $this->session->flashdata('success_message');?></span>
			  <span class="error_message"><?php echo $this->session->flashdata('error_message');?></span>
			  <span class="editbutton_inprofiletab"><a href="javascript:void(0);"><img id="edit_img" src="<?php echo PROFILE_IMG; ?>edit.png" title="edit" /></a></span></p>
              <p class="heightFix22"></p>-->
			<?php 
			$form_attributes = array('id' => 'profile_form');
			echo form_open('profile/update_profile',$form_attributes); ?>
			  <div id="profile"style="display:none">
			  <!-- first row -->
				<div class="newInputBox">
				<div class="inputbox266_new">
				
                  <p class="lebeltextstep2"><?php echo $this->lang->line('user_profile_name');?></p>
                  <span><div class="clear"></div>
					<?php
						if(isset($user_profile[0]->firstname) && isset($user_profile[0]->lastname))
						{
							$value_name =	ucwords($user_profile[0]->firstname." ".$user_profile[0]->lastname);
						}
						else
						{
							$value_name	=	"";
						}
						$data = array(
								  'name'		=> 	'name',
								  'id'			=> 	'name',
								  'class'		=>	'required',
								  'title'		=>	'Enter your name',
								  'maxlength'	=> '40',
								  'value'		=>	 $value_name
									);

						echo form_input($data);
						
					?>
					
                  </span> </div>
				  
				  
				   <div class="inputbox266_new2">
                  <p class="lebeltextstep2"><?php echo $this->lang->line('user_profile_email');?></p>
                  <span><div class="clear"></div>
				  <?php
						if(isset($user_profile[0]->email))
						{
							$value_email 	=	$user_profile[0]->email;
						}
						else
						{
							$value_email	=	"";
						}
						$data = array(
								  'name'		=> 	'email',
								  'id'			=> 	'email',
								  'class'		=>	"required email",
								  'value'		=>	$value_email
									);

						echo form_input($data);
					?>
                  </span> </div>
				  
				
				</div>
				<div class="clear"></div>
				<!-- first row close here -->
				<!-- second row start here -->
				<div class="newInputBox">
					<div class="inputbox266_new">
                  <p class="lebeltextstep2"><?php echo $this->lang->line('user_profile_home_phone_number');?></p>
                  <span><div class="clear"></div>
				  <?php
						if(isset($user_profile[0]->home_phone))
						{
							$value_home_phone 	=	$user_profile[0]->home_phone;
						}
						else
						{
							$value_home_phone	=	"";
						}
						$data = array(
								  'name'		=> 	'home_phone',
								  'id'			=> 	'home_phone',
								  'title'		=>	'Enter home phone',
								  'value'		=>	 $value_home_phone
									);

						echo form_input($data);
					?>
				  
                  </span> </div>
				
				
				<div class="inputbox266_new2">
                  <p class="lebeltextstep2"><?php echo $this->lang->line('user_profile_secondry_email');?></p>
                  <span><div class="clear"></div>
				  <?php
						if(isset($user_profile[0]->secondary_email))
						{
							$value_secondary_email 	=	$user_profile[0]->secondary_email;
						}
						else
						{
							$value_secondary_email	=	"";
						}
						$data = array(
								  'name'		=> 	'secondary_email',
								  'id'			=> 	'secondary_email',
								  'class'		=>	'email',
								  'title'		=>	'Enter valid secondry email',
								  'value'		=>	$value_secondary_email
									);

						echo form_input($data);
					?>
                  </span> </div>
				
				
				
				</div>
				<div class="clear"></div>
				<!-- second row close here -->
				
				<!-- third row start here -->
				<div class="newInputBox">
				<!--input left-->
					<div class="inputbox266_new">
					 <p class="lebeltextstep2"><?php echo $this->lang->line('user_profile_address');?></p>
                  <span>	<div class="clear"></div>
				  <?php
						if(isset($user_profile[0]->address))
						{
							$value_address 	=	$user_profile[0]->address;
						}
						else
						{
							$value_address	=	"";
						}
						$data = array(
								  'name'		=> 	'address',
								  'id'			=> 	'address',
								  'title'		=>	'Enter address',
								  'value'		=>	 $value_address
									);

						echo form_input($data);
					?>
                  </span>
					</div>
				<!--input right-->
					<div class="input113_new2">
					 <p class="lebeltextstep2"><?php echo $this->lang->line('user_profile_zip_code');?></p>
                  <span> 	<div class="clear"></div>
				  <?php
						if(isset($user_profile[0]->zipcode))
						{
							$value_zipcode 	=	$user_profile[0]->zipcode;
						}
						else
						{
							$value_zipcode	=	"";
						}
						$data = array(
								  'name'		=> 	'zipcode',
								  'id'			=> 	'zipcode',
								  'value'		=>	$value_zipcode
									);

						echo form_input($data);
					?>
                  </span> 
					</div>
				</div>
				<div class="clear"></div>
				<!-- third row close here -->
				
				
				<!-- fourth row start here -->
				<div class="newInputBox">
				<!--input left-->
					<div class="inputbox266_new">
					<p class="lebeltextstep2"><?php echo $this->lang->line('user_profile_political_affiliation');?></p>
                  <span><div class="clear"></div>
				  <?php
						if(isset($user_profile[0]->political_affiliation))
						{
							$value_political_affiliation 	=	$user_profile[0]->political_affiliation;
						}
						else
						{
							$value_political_affiliation	=	"";
						}
						$data = array(
								  'name'		=> 	'political_affiliation',
								  'id'			=> 	'political_affiliation',
								  'value'		=>	 $value_political_affiliation
									);

						echo form_input($data);
					?>
                  </span> 
					</div>
				<!--input right-->
					<div class="inputbox266_new2">
					<p class="lebeltextstep2"><?php echo $this->lang->line('user_profile_religious_view');?></p>
                  <span>	<div class="clear"></div>
				  <?php
						if(isset($user_profile[0]->religious_view))
						{
							$value_religious_view 	=	$user_profile[0]->religious_view;
						}
						else
						{
							$value_religious_view	=	"";
						}
						$data = array(
								  'name'		=> 	'religious_view',
								  'id'			=> 	'religious_view',
								  'value'		=>	$value_religious_view
									);

						echo form_input($data);
					?>
                  </span>
					</div>
				</div>
				<div class="clear"></div>
				<!-- fourth row close here -->
				
				
				<!-- fifth row start here -->
				<div class="newInputBox">
				<!--input left-->
					<div class="inputbox266_new">
					<p class="lebeltextstep2"><?php echo $this->lang->line('user_profile_general_interests');?></p>
                  <span><div class="clear"></div>
				  <?php
						if(isset($user_profile[0]->general_interests))
						{
							$value_general_interests 	=	$user_profile[0]->general_interests;
						}
						else
						{
							$value_general_interests	=	"";
						}
						$data = array(
								  'name'		=> 	'general_interests',
								  'id'			=> 	'general_interests',
								  'value'		=>	 $value_general_interests
									);

						echo form_input($data);
					?>
                  </span>
					</div>
				<!--input right-->
					<div class="inputbox266_new2">
					  <p class="lebeltextstep2"><?php echo $this->lang->line('user_profile_favorite_movies');?></p>
                  <span>	<div class="clear"></div>
				   <?php
						if(isset($user_profile[0]->favorite_movies))
						{
							$value_favorite_movies 	=	$user_profile[0]->favorite_movies;
						}
						else
						{
							$value_favorite_movies	=	"";
						}
						$data = array(
								  'name'		=> 	'favorite_movies',
								  'id'			=> 	'favorite_movies',
								  'value'		=>	$value_favorite_movies
									);

						echo form_input($data);
					?>
                  </span> 
					</div>
				</div>
				<div class="clear"></div>
				<!-- fifth row close here -->
				
				
				<!-- sixth row start here -->
				<div class="newInputBox">
				<!--input left-->
					<div class="inputbox266_new">
					 <p class="lebeltextstep2"><?php echo $this->lang->line('user_profile_favorite_singers');?></p>
                  <span><div class="clear"></div>
				  <?php
						if(isset($user_profile[0]->favorite_singers))
						{
							$value_favorite_singers 	=	$user_profile[0]->favorite_singers;
						}
						else
						{
							$value_favorite_singers	=	"";
						}
						$data = array(
								  'name'		=> 	'favorite_singers',
								  'id'			=> 	'favorite_singers',
								  'value'		=>	 $value_favorite_singers
									);

						echo form_input($data);
					?>
                  
                  </span> 
					</div>
				<!--input right-->
					<div class="inputbox266_new2">
					 <p class="lebeltextstep2"><?php echo $this->lang->line('user_profile_favorite_actors');?></p>
                  <span><div class="clear"></div>
				  <?php
						if(isset($user_profile[0]->favorite_actors))
						{
							$value_favorite_actors 	=	$user_profile[0]->favorite_actors;
						}
						else
						{
							$value_favorite_actors	=	"";
						}
						$data = array(
								  'name'		=> 	'favorite_actors',
								  'id'			=> 	'favorite_actors',
								  'value'		=>	$value_favorite_actors
									);

						echo form_input($data);
					?>
                  </span> 
					</div>
				</div>
				<div class="clear"></div>
				<!-- sixth row close here -->
				
				<!-- seventh row start here -->
				<div class="newInputBox">
				<!--input left-->
					<div class="inputbox266_new">
					<p class="lebeltextstep2"><?php echo $this->lang->line('user_profile_education_level');?></p>
                 <div class="lebelboxui1"> <span class="textbox7select"> <div class="clear"></div> <span class="abc"><?php 
					$selected_level = "";
						if(isset($user_profile[0]->education_level)) {echo $user_profile[0]->education_level; 
						$selected_level = $user_profile[0]->education_level_id; }?></span>
				  <?php
						
						$education_level = get_education_level();
						$options	=	 array();
						foreach($education_level as $education)
						{
							$options[$education->education_level_id] = $education->education_level;
						}
						
						$js = 'id="education_level" ';
						echo form_dropdown('education_level', $options, $selected_level,$js);
					
					?>
                  </span> </div>
					</div>
				<!--input right-->
					<div class="inputbox266_new2">
					 <p class="lebeltextstep2"><?php echo $this->lang->line('user_profile_employer');?></p>
                  <span><div class="clear"></div>
				  <?php
						if(isset($user_profile[0]->employer))
						{
							$value_employer 	=	$user_profile[0]->employer;
						}
						else
						{
							$value_employer	=	"";
						}
						$data = array(
								  'name'		=> 	'employer',
								  'id'			=> 	'employer',
								  'value'		=>	$value_employer
									);

						echo form_input($data);
					?>
                  </span>
					</div>
				</div>
				<div class="clear"></div>
				<!-- seventh row close here -->
				
				<!-- eight row start here -->
				<div class="newInputBox">
				<!--input left-->
					<div class="inputbox266_new">
					 <p class="lebeltextstep2"><?php echo $this->lang->line('user_profile_employment_industry');?></p>
                  <span><div class="clear"></div>
				  <?php
						if(isset($user_profile[0]->employment_industry))
						{
							$value_employment_industry 	=	$user_profile[0]->employment_industry;
						}
						else
						{
							$value_employment_industry	=	"";
						}
						$data = array(
								  'name'		=> 	'employment_industry',
								  'id'			=> 	'employment_industry',
								  'value'		=>	 $value_employment_industry
									);

						echo form_input($data);
					?>
                  </span>
					
					</div>
				<!--input right-->
					<div class="inputbox266_new2">
					<p class="lebeltextstep2"><?php echo $this->lang->line('user_profile_facebook');?></p>
                  <span><div class="clear"></div>
				  <?php
						if(isset($user_profile[0]->facebook))
						{
							$value_facebook 	=	$user_profile[0]->facebook;
						}
						else
						{
							$value_facebook	=	"";
						}
						$data = array(
								  'name'		=> 	'facebook',
								  'id'			=> 	'facebook',
								  'value'		=>	$value_facebook
									);

						echo form_input($data);
					?>
                  </span> 
					</div>
				</div>
				<div class="clear"></div>
				<!-- eight row close here -->
				
				<!-- ninth row start here -->
				<div class="newInputBox">
				<!--input left-->
					<div class="inputbox266_new">
					<p class="lebeltextstep2"><?php echo $this->lang->line('user_profile_mobile_phone_number');?></p>
                  <span><div class="clear"></div>
				  <?php
						if(isset($user_profile[0]->cell_phone))
						{
							$value_cell_phone 	=	$user_profile[0]->cell_phone;
						}
						else
						{
							$value_cell_phone	=	"";
						}
						$data = array(
								  'name'		=> 	'cell_phone',
								  'id'			=> 	'cell_phone',
								  'title'		=>	'Enter mobile number',
								  'value'		=>	$value_cell_phone
									);

						echo form_input($data);
					?>
                  </span>
					</div>
				<!--input right-->
					<div class="inputbox266_new2">
					<p class="lebeltextstep2"><?php echo $this->lang->line('user_profile_mobile_carrier');?></p>
                  <div class="lebelboxui1">
                    <!-- lebel step 1-->
                    <span class="textbox7select"><div class="clear"></div> <span class="abc"><?php 
					$selected = "";
					if(isset($user_profile[0]->carrier_name)) {echo $user_profile[0]->carrier_name; 
					$selected = $user_profile[0]->carrier_id; }?></span>
					<?php	
							$career_db = get_career();
							$options	=	 array();
							foreach($career_db as $career)
							{
								$options[$career->carrier_id] = $career->carrier_name;
							}
							
							$js = 'id="mobile_career" ';
							echo form_dropdown('mobile_career', $options, $selected,$js);
					?>
                    </span>
					</div>
				</div>
				<div class="clear"></div>
				<!-- ninth row close here -->
                <div class="clear"></div>
                <div class="inputbox266"> 
				<span class="saveChange"> 
				<button type="submit" class="reset">
					<span class="button next_bt text_caseL">
						<span class="width_85px" ><?php echo $this->lang->line('user_profile_save_changes');?></span>
					</span>
				</button>
				</span>
				</div>
              </div>
			  </div>

			  <?php echo form_close(); ?>
              <div class="clear"></div>
            </div>
         
          
			  
			  
			  
			  
			  
			  
			  
			  <!-- add view for edit image start-->
			  <div class="edit_photo">
			  <span class="success_message" id="success"><?php echo $this->session->flashdata('image_success_message');?></span>
			  <span class="error_message" id="error"><?php echo $this->session->flashdata('image_error_message');?></span>
			  <span class="error_message" id="photo" style="display:none;"><?php echo $this->lang->line('user_profile_please_upload_photo');?></span>
			  <?php
				$form_attributes = array('id' => 'edit_image' , 'onsubmit' => 'return validate_image()');
				echo form_open('profile/edit_image',$form_attributes);
				?>				
			  <div class="pictureupload" id="FileContainer">
				<p class="addphoto"><a id="pickfiles" href="#"><?php echo $this->lang->line('user_profile_change_photo');?></a></p>
				<div class="picturlebel">
					<p class="displayUploadedFile" id="displayUploadedFile">
					
					<!--img src="<?php //echo IMG;?>picture_upload.png" title="Upload Images" /-->
					<!--set photo here for edit-->
					<?php 
						$user_id = $this->session->userdata('user_user_id');
						// call get image helper function to get url of the image
						// @Input image, type=user, flag=1, user_id 
						$image_src = getimage('user', 2, $user_id);
					?>
		
						<img src="<?php echo $image_src; ?>" title="Change Picture" height="108px;" width="111px;"/>
				
					
					<!-- end set photo -->
					
					</p>
					<p class="sprintspace7">&nbsp;</p>
					<p class="smalltextstep1">
						<?php echo $this->lang->line('user_profile_max_limit_photo');?><br /><?php echo $this->lang->line('user_profile_allowed_extension');?> <br />png, gif, jpg, jpeg
					</p>
				</div>
				<!-- picture view -->
				<div class="error" style="display:none;">
					<p id="errorMessage"></p>
				</div>
					
				<div class="picturlebel2">
					<div id="dropArea">
						<div class="pictureview">
							<div id="crop_container2"></div>
							<span class="picturedragmsg" id="picturedragmsg"><?php echo $this->lang->line('user_profile_drag_photo');?><br><?php echo $this->lang->line('user_profile_here');?></span>
							<div id="pictureloader" style="display:none;">
								<img src="<?php echo IMG;?>/ajax-loader.gif" width="108" height="111" />
							</div>
						</div>
						
						<div class="pictureviewZooming">
							<p><img id="max-pointer" src="<?php echo IMG;?>zoom_plus.png" /></p>
							<p class="slidermid"><img src="<?php echo IMG;?>line.png" align="absmiddle" /></p>
							<p><img id="min-pointer" src="<?php echo IMG;?>zoom_minus.png" /></p>
							
							<p class="sprintspace11">&nbsp;</p>
							<p id="crop2"><img src="<?php echo IMG;?>select.png" title="Select Picture" /></p>
						</div>
					</div>
				</div>
				<!-- Display movement controls after image upload here -->
				<div id="movement"></div>
			</div>
		<?php
			$data = array(
					  'name'		=> 'profile_picture',
					  'id'			=> 'profile_picture',
					  'type'		=> 'hidden',
					  'class'		=> '',
					  'value'		=> ''
					);
					
			echo form_input($data);
			?>
			<?php
			$data = array(
					  'name'		=> 'max_val',
					  'id'			=> 'max_val',
					  'type'		=> 'hidden',
					  'class'		=> '',
					  'value'		=> ''
					);
			echo form_input($data);
			?>			
			<div class="inputbox266"> 
				<span class="saveChange"> 
				<button type="submit" class="reset">
					<span class="button next_bt text_caseL">
						<span id="save_image" class="width_85px" ><?php echo $this->lang->line('user_profile_save_image');?></span>
					</span>
				</button>
				</span>
				</div>
			
		<?php	
			echo form_close();
		?>	
			</div>
			  <!-- add view for edit image end -->
			   </li>
            </ul>
          </div>
          <!-- toggle div-->
          <div>
            <div class="borderShedow"></div>
            <div class="profiletextBox2">
              <div class="spanTextP">
			  	<?php if(validation_errors()){?>
				<div class="error_msg">
					<?php echo validation_errors(); ?>
				</div>
				<?php }?>	
				<?php 
				if($this->session->flashdata('success_message_location'))
				{
				?>
				<span class="success_message"><?php echo $this->session->flashdata('success_message_location');?></span>
				<p>&nbsp;</p>
				<?php 
				}
				?>
				<?php 
				if($this->session->flashdata('error_message_location'))
				{
				?>				
				<span class="error_message"><?php echo $this->session->flashdata('error_message_location');?></span>
				<p>&nbsp;</p>
				<?php 
				}
				?>
				
				<p class="profiletextChange"><?php echo $this->lang->line('user_profile_change_current_location');?>
				<span class="editbutton_inprofiletab">
					<a href="javascript:void(0);"><img  id="change_location_button" src="<?php echo PROFILE_IMG; ?>edit.png" title="edit" /></a></span>
				</p>
                <p class="heightFix11"></p>
				<div id="change_location_box" style="display:none">		
				<p class="profileSmallText2"><?php echo $this->lang->line('user_profile_location');?></p>
                <p class="heightFix10"></p>
				<?php 
					$form_attributes = array('id' => 'profile_location_form');
					echo form_open('profile/update_location',$form_attributes); 
				?>
					<div class="profile_country_box" style="float:left; margin-right:20px;">	
					<p class="lebeltextstep2"><?php echo $this->lang->line('user_profile_country');?><span class="star">*</span></p>
					<span class="textbox7select"><span class="abc" id="country_span"></span>
					<?php 	
						$country_data = array();
						if(isset($country_query)):
						if($country_query->num_rows() > 0):
						$country_data[''] = '';
						foreach($country_query->result() as $row):
							$country_data[$row->country_id] = $row->country_name;
						endforeach;
						endif;
						endif;
					?>
					<?php 		
						$element_attributes = 'id="country" class="required error" onchange="displayStates(this.value);" title="Select Country"';
						echo form_dropdown('country', $country_data, set_value('country', (isset($user_profile[0]->country_id)) ? $user_profile[0]->country_id : '0'), $element_attributes);
					?>
					</span>
					</div>
					<div class="profile_state_box" style="float:left; margin-right:20px;">	
					
					<p class="lebeltextstep2"><?php echo $this->lang->line('user_profile_state');?><span class="star">*</span></p>
					<span class="textbox7select"><span class="abc" id="state_span"></span>
					<?php 	
						$state_data = array();
						if(isset($state_query) && $state_query!=false):
						if($state_query->num_rows() > 0):
						$state_data[''] = '';
						foreach($state_query->result() as $row):
							$state_data[$row->state_id] = $row->state_name;
						endforeach;
						endif;
						endif;
					?>
					<?php 		
						$element_attributes = 'id="state" class="required error" onchange="displayCities(this.value);" title="Select State"';
						echo form_dropdown('state', $state_data, set_value('state', (isset($user_profile[0]->state_id)) ? $user_profile[0]->state_id : '0'),$element_attributes);
					?>
					</span>
					</div>
					<div class="profile_city_box" style="float:left;">	
					
					<p class="lebeltextstep2"><?php echo $this->lang->line('user_profile_city');?><span class="star">*</span></p>
					<span class="textbox7select"><span class="abc" id="city_span"></span>
					<?php 	
					
						$city_data = array();
						
						if(isset($city_query) && $city_query!=false):
						if($city_query->num_rows() > 0):
						$city_data[''] = '';
						foreach($city_query->result() as $row):
							$city_data[$row->city_id] = $row->city_name;
						endforeach;
						endif;
						endif;
					?>
					<?php 		
						$element_attributes = 'id="city" class="required error" title="Select City"';
						echo form_dropdown('city', $city_data, set_value('city', (isset($user_profile[0]->city_id)) ? $user_profile[0]->city_id : '0'),$element_attributes);
					?>	
					</span>
					</div>
					
					<div class="ButtonChnagelocation">
						<button type="submit" class="reset">
						<span class="button next_bt text_caseL">
							<span id="save_image" style="width:92px;"><?php echo $this->lang->line('user_profile_change_location');?></span>
						</span>
						</button>
					</div>
				</div>
				<?php echo form_close();?>
                <p class="profileSmallText" id="display_location">
				<?php if(isset($user_location)) { ?>
				<?php echo $user_location[0]->user_city;?>
				<?php echo $user_location[0]->user_state;?><br />
				<?php echo $user_location[0]->user_country;?>
				<?php }?>
				</p>
              </div>
              <div class="clear"></div>
            </div>
			</div>
          <!-- toggle Div li-->
          <div class="uitoggle">
            <ul>
              <li> <span class="themeIcon"><?php echo $this->lang->line('user_profile_theme');?> </span> <span class="editbutton"><a href="#"><img src="<?php echo PROFILE_IMG; ?>edit.png" title="edit" /></a></span> </li>
              <li> <span class="notifications"><?php echo $this->lang->line('user_profile_notification');?></span> <span class="editbutton"><a href="#"><img src="<?php echo PROFILE_IMG; ?>edit.png" title="edit" /></a></span> </li>
             
            </ul>
             <div>		<?php
						// show point on top of the page (If user comes under incentive program)
						echo Modules::run('notification_setting');
						?>
              </div>
          </div>
          <div class="SpaceFix"></div>
          <!-- network boxex -->
        </div>
	
	<!-- Zoom crop script starts -->	
    <script type="text/javascript" src="<?php echo JS;?>cropzoom/script.js"></script>
    <link href="<?php echo CSS;?>cropzoom/jquery-ui-1.7.2.custom.css" rel="Stylesheet" type="text/css" /> 
    <link href="<?php echo CSS;?>cropzoom/jquery.cropzoom.css" rel="Stylesheet" type="text/css" /> 
    
    <script type="text/javascript" src="<?php echo JS;?>cropzoom/jquery-ui-1.8.2.custom.js"></script>
    <script type="text/javascript" src="<?php echo JS;?>cropzoom/jquery.cropzoom.js"></script>
    <!--<link rel="stylesheet" href="<?php echo CSS;?>cropzoom/style.css" type="text/css" media="screen" />-->
    <!--[if IE 6]><link rel="stylesheet" href="<?php echo CSS;?>cropzoom/style.ie6.css" type="text/css" media="screen" /><![endif]-->
    <!--[if IE 7]><link rel="stylesheet" href="<?php echo CSS;?>cropzoom/style.ie7.css" type="text/css" media="screen" /><![endif]-->
    <style type="text/css">
        #zoom,#rot{
            margin:auto;
            height:25px;
        }
    </style>
	<style type="text/css">
		#img_to_crop{
			-webkit-user-drag: element;
			-webkit-user-select: none;
		}
	</style>
	<!-- Zoom crop script starts ends -->	
		
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo FRONT_TEMPLATE_CSS;?>plupload/main.css" />
<script type='text/javascript' src='<?php echo FRONT_TEMPLATE_JS;?>plupload/plupload.js'></script>
<script type='text/javascript' src='<?php echo FRONT_TEMPLATE_JS;?>plupload/plupload.gears.js'></script>
<script type='text/javascript' src='<?php echo FRONT_TEMPLATE_JS;?>plupload/plupload.silverlight.js'></script>
<script type='text/javascript' src='<?php echo FRONT_TEMPLATE_JS;?>plupload/plupload.flash.js'></script>
<script type='text/javascript' src='<?php echo FRONT_TEMPLATE_JS;?>plupload/plupload.browserplus.js'></script>
<script type='text/javascript' src='<?php echo FRONT_TEMPLATE_JS;?>plupload/plupload.html4.js'></script>
<script type='text/javascript' src='<?php echo FRONT_TEMPLATE_JS;?>plupload/plupload.html5.js'></script>
<!--<script type='text/javascript' src='<?php //echo JS;?>plupload/plupload_onload.js'></script>-->
<script type="text/javascript">
/* Code for display dropdown value selected */  
function displayStates(country_id)
{
	if (country_id > 0)
	{
		$.ajax({
			type: "POST",
			url: "<?php echo BASEURL;?>common/load_states_by_country",
			data: "country_id="+country_id,
			dateType:'JSON',
			success: function(response){	
				if(response!="")
				{
					if(response=="[]")
					{
						$('#state').parent().find('.abc').empty();
						var output = [];
						$('#state').html(output.join(''));
						
						$('#city').parent().find('.abc').empty();
						$('#city').html(output.join(''));
					}	
					else
					{
						//1st method
						/*response= eval("(" +response+ ")");	
						$.each(response, function(key, value){  
							$('#state')
								.append($("<option></option>")
								.attr("value",key)
								.text(value)); 
						});*/
						
						//2nd method
						var output = [];
						response = eval("(" +response+ ")");
						output.push('<option value=""></option>');
						$.each(response, function(key, value)
						{
							output.push('<option value="'+ key +'">'+ value +'</option>');
						});
						$('#state').html(output.join(''));
					}
				}
			}
		});
	}
}

function displayCities(state_id)
{
	if (state_id > 0)
	{
		$.ajax({
			type: "POST",
			url: "<?php echo BASEURL;?>common/load_cities_by_state",
			data: "state_id="+state_id,
			success: function(response){	
				if(response!="")
				{		
					if(response=="[]")
					{
						$('#city').parent().find('.abc').empty();
						var output = [];
						$('#city').html(output.join(''));
					}	
					else
					{
						var output = [];
						response = eval("(" +response+ ")");
						output.push('<option value=""></option>');
						$.each(response, function(key, value)
						{
							output.push('<option value="'+ key +'">'+ value +'</option>');
						});
						$('#city').html(output.join(''));
					}	
				}	
			}
		});
	}	
}


$(document).ready(function(){

$("#profile_location_form").validate();

	/* Code for display dropdown value selected */  
	var singleValues1 = $("#country").find(":selected").text();
	$("#country").parent().find('#country_span').html(singleValues1);
	var singleValues2 = $("#state").find(":selected").text();
	$("#state").parent().find('#state_span').html(singleValues2);
	var singleValues3 = $("#city").find(":selected").text();
	$("#city").parent().find('#city_span').html(singleValues3);

	/* Code for display dropdown value selected */  
	$("#country").change(function(){
		var singleValues1 = $(this).find(":selected").text();
		$("#country").parent().find('#country_span').html(singleValues1);
		$("#state").parent().find('#state_span').html('');
		$("#city").parent().find('#city_span').html('');
	});	
	$("#state").change(function(){
		var singleValues2 = $(this).find(":selected").text();
		$("#state").parent().find('#state_span').html(singleValues2);
		$("#city").parent().find('#city_span').html('');
	});
	$("#city").change(function(){
		var singleValues3 = $(this).find(":selected").text();
		$("#city").parent().find('#city_span').html(singleValues3);
	});	
	
	
	$("#pictureloader").hide();
	
	var uploader = new plupload.Uploader({
		
		runtimes: 'html5,flash,gears,browserplus,silverlight,html4', 
		url:"<?php echo BASEURL;?>uploader/upload",
		browse_button : "pickfiles",
		button_browse_hover : true,
		drop_element : "dropArea",
		autostart : true,
		max_file_size: '10mb',
		container: "FileContainer",
		chunk_size: '1mb',
		unique_names: true,
		// Flash settings
		flash_swf_url: "<?php echo JS;?>plupload/plupload.flash.swf",
		// Silverlight settings
		silverlight_xap_url: "<?php echo JS;?>plupload/plupload.silverlight.xap"
	});
	
	var fileTypes = 'jpg,jpeg,png,gif';
	/*var fileTypes = 'all';*/
	//var fileTypesFilter = 'allow';
	var fileTypesFilter = 'notallow';
	var $body = $("body");
	var $dropArea = $("#dropArea");

	$body.bind("dragenter", function(e){ 
		$dropArea.addClass("draggingFile");
		e.stopPropagation();
		e.preventDefault();
	});

	$body.bind("dragleave", function(e){ $dropArea.removeClass("draggingFile"); });
	
	$body.bind("dragover", function(e){
		$dropArea.addClass("draggingFile");
		e.stopPropagation();
		e.preventDefault();
	});

	$body.bind("drop", function(e){
		e.stopPropagation();
		e.preventDefault();
		$dropArea.removeClass();
	});

	$dropArea.bind("dragenter", function(e){
		$dropArea.addClass("draggingFileHover");
		e.stopPropagation();
		e.preventDefault();
	});
	$dropArea.bind("dragleave", function(e){ $dropArea.removeClass("draggingFileHover"); });
	$dropArea.bind("dragover", function(e){
		$dropArea.addClass("draggingFileHover");
		e.stopPropagation();
		e.preventDefault();
	});
	
	//Checks to make sure the browser supports drag and drop uploads
	uploader.bind('Init', function(up, params){
		if(window.FileReader && $.browser.webkit && !((params.runtime == "flash") || (params.runtime == "silverlight")))
		{
			$("#dropArea").show();
			$("#fileSelectMsg").hide();
		}
	});

	uploader.init();
	uploader.bind('FilesAdded', function(up, files) {
		$dropArea.removeClass();
		$.each(files, function(i, file) {
			
			//Checks a comma delimted list for allowable file types set file types to allow for all
			var fileExtension = file.name.substring(file.name.lastIndexOf(".")+1, file.name.length).toLowerCase();
			var supportedExtensions = fileTypes.split(",");
			var supportedFileExtension = ($.inArray(fileExtension, supportedExtensions) >= 0);

			if(fileTypesFilter == "allow")
			{
				supportedFileExtension = !supportedFileExtension
			}
			
			if((fileTypes == "all") || supportedFileExtension)
			{
				var filename = file.name;
				if(filename.length > 25)
				{
					filename = filename.substring(0,25)+"...";       
				}
				
				//Add div block for each file uploaded
				$('#filelist').append(
					'<div id="' + file.id + '" class="fileItem"><div class="name">' +
					filename + '</div><div class="fileRename hide"><div class="fileInfo"><span class="size">' + plupload.formatSize(file.size) + '</span>' +
					'<div class="plupload_progress"><div class="plupload_progress_container"><div class="plupload_progress_bar"></div></div></div>'+
					'<span class="percentComplete"></span></div></div>');
		
				//Fire Upload Event
				up.refresh(); // Reposition Flash/Silverlight
				uploader.start();
				// code for loader
				$("#picturedragmsg").hide();
				$("#pictureloader").show();
				
				//Bind cancel click event
				$('#cancel'+file.id).click(function(){
					$fileItem = $('#' + file.id);
					$fileItem.addClass("cancelled");
					uploader.removeFile(file);
					currentStorage -= ((file.size)/(1024*1024));
					$(this).remove();
				});
			}
			else
			{
				//Not a supported file extension
				$errorPanel = $('div.error:first');
				$errorPanel.show().html('<p>The file you selected is not supported in this section.');
			}
		});
	});

	uploader.bind('UploadProgress', function(up, file) {

		var  $fileWrapper = $('#' + file.id);
		$fileWrapper.find(".plupload_progress").show();
		$fileWrapper.find(".plupload_progress_bar").attr("style", "width:"+ file.percent + "%");
		$fileWrapper.find(".percentComplete").html(file.percent+"%");
		$fileWrapper.find('#cancel'+file.id).addClass('hide');
	});

	uploader.bind('Error', function(up, err) {
		$errorPanel = $("div.error:first");
		//-600 means the file is larger than the max allowable file size on the uploader thats set in the options above.
		if(err.code == "-600")
		{
			$errorPanel.show().html('<p>The file you are trying to upload exceeds the single file size limit of 250MB</p>');
		}
		else
		{
			$errorPanel.show().html('<p>There was an error uploading your file '+ err.file.name +'.</p>');
		}

		$('#' + err.file.id).addClass("cancelled");
		uploader.stop();
		uploader.refresh(); // Reposition Flash/Silverlight
	});
	
	uploader.bind('FileUploaded', function(up, file, response) {
		if(uploader.total.uploaded == uploader.files.length) {
			var filename;
			var filepath;
			$.each(response, function(key, value){  
				if(key == "response")
				{
					var obj = $.parseJSON(value);
					if(obj.error)
					{
						var error_code = obj.error.code;
						var error_message = obj.error.message;
						
						if(error_code == "99")
						{
							$errorPanel.show().html('<p>'+error_message+'</p>');
						}	
					}
					else
					{
						filename = obj.filename;
						filepath = obj.filepath;
					}
				}
			});
			
			if(filename!="" && filepath!="")
			{
				var image_path = filepath;
				
				$('#profile_picture').val(filename);
				$("#pictureloader").hide();
				//$("#picturedragmsg").show();
				
				var cropzoom2 = $('#crop_container2').cropzoom({
				width:126,
				height:140,
				bgColor: '#fff',
				enableRotation:true,
				enableZoom:true,
				zoomSteps:10,
				rotationSteps:10,
				expose:{
					slidersOrientation: 'vertical',
					zoomElement: '#zoom',
					rotationElement: '#rot',
					elementMovement:'#movement'
				},
				selector:{        
				  centered:true,
				  borderColor:'blue',
				  borderColorHover:'yellow',
				  startWithOverlay: false,
				  hideOverlayOnDragAndResize: true,
				  w : 108,
				  h : 111				  
				},
				image:{
					source:image_path,
					width:1024,
					height:768,
					minZoom:50,
					maxZoom:200,
					startZoom:20,
					useStartZoomAsMinZoom:true,
					snapToContainer:true
				}
			});
				$('#restore2').click(function(){
					cropzoom2.restore();
				});
				$('#crop2').click(function(){ 
					cropzoom2.send('<?php echo BASEURL;?>uploader/crop','POST',{},function(rta){
						var image_parts = rta.split("|");
						$('#profile_picture').val(image_parts[0]);
						//$('#result_image').find('img').remove();
						var img = $('<img />').attr('src',image_parts[1]);
						$('#displayUploadedFile').html(img);
						$("#picturedragmsg").html('<?php echo $this->lang->line('create_profile_drag_photo_here');?>');
						$("#crop_container2").html('');
					});
				});
			}
		}
	});
});
</script>       
