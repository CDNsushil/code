<!-- Invite friends -->
          <div class="OSMainBoxapps">
<script language="javascript" type="text/javascript">
function app_responce(act,res){
		var ajaxApplication;
		var msg;
		ajaxApplication = 	$.ajax({
					url:BASEPATH+'openapp_setting/invites_from_friends_responce/'+act+'/'+res,
					dataType:'html',	
					beforeSend:function(){
					$('#'+act).html('<div id="ajaxLoading" class="ajaxLoading"></div>');
					},
					success: function(data) {
						if(res == 1){
							msg = 'Request Accesepted';
						}else{
							msg ='Ignored';
						}
						$('#OS_button').html(msg);
						$('#'+act).slideUp().delay(800);

					}
				});
}
</script>

            <div class="inviteFriendsOS">
              <div class="inviteFrdLeft">
                <?php foreach($requests as $request ){ ?>
				<div class="inviteboxOS" id ="<?php echo $request->activity_id; ?>">
                  <div class="SmallimgOS"><img height="46" width="46" src="<?php echo $request->app_image; ?>" /></div>
                  <div> <span class="OS_Invite_Heading"><?php echo $request->title; ?></span>
					<div class="OS_button"> 
						<span><a href="javascript:void(0);" onclick="app_responce('<?php echo $request->activity_id; ?>','1')"><img src="<?php echo OPENSOCIAL_IMG; ?>accept.png" title="Accept" /></a></span> 
						<span><a href="javascript:void(0);" onclick="app_responce('<?php echo $request->activity_id; ?>','0')"><img src="<?php echo OPENSOCIAL_IMG; ?>ignore.png" title="Ignore" /></a></span>
					</div>
                  </div>
                  <br />
                  <div class="OS_smallText"><?php echo $request->friend_name; ?></div>
                  <div class="OS_smallText2">invites you play</div>
                </div>
				<?php } ?>
               <!--  <div class="inviteboxOS">
                  <div class="SmallimgOS"><img src="<?php //echo OPENSOCIAL_IMG; ?>os_img4.jpg" /></div>
                  <div> <span class="OS_Invite_Heading">Frontier Ville</span>
                    <div class="OS_button"> <span><a href="javascript:void(0);"><img src="<?php //echo OPENSOCIAL_IMG; ?>accept.png" title="Accept" /></a></span> <span><a href="#"><img src="<?php //echo OPENSOCIAL_IMG; ?>ignore.png" title="Ignore" /></a></span> </div>
                  </div>
                  <br />
                  <div class="OS_smallText">Laurie Brozoski, Jamie Burrows <span class="OS_smallText2">invites you
                    play</span></div>
                </div>
               <div class="inviteboxOS">
                  <div class="SmallimgOS"><img src="<?php //echo OPENSOCIAL_IMG; ?>os_img4.jpg" /></div>
                  <div> <span class="OS_Invite_Heading">Frontier Ville</span>
                    <div class="OS_button"> <span><a href="#"><img src="<?php //echo OPENSOCIAL_IMG; ?>accept.png" title="Accept" /></a></span> <span><a href="#"><img src="<?php //echo OPENSOCIAL_IMG; ?>ignore.png" title="Ignore" /></a></span> </div>
                  </div>
                  <br />
                  <div class="OS_smallText">Laurie Brozoski, Jamie Burrows <span class="OS_smallText2">invites you
                    play</span></div>
                </div>
              </div>
              <div class="inviteFrdRight">
                <div class="inviteboxOS">
                  <div class="SmallimgOS"><img src="<?php //echo OPENSOCIAL_IMG; ?>os_img2.jpg" /></div>
                  <div> <span class="OS_Invite_Heading">Zynga Poker</span>
                    <div class="OS_button"> <span><a href="#"><img src="<?php //echo OPENSOCIAL_IMG; ?>accept.png" title="Accept" /></a></span> <span><a href="#"><img src="<?php //echo OPENSOCIAL_IMG; ?>ignore.png" title="Ignore" /></a></span> </div>
                  </div>
                  <br />
                  <div class="OS_smallText">Rachel Bing, David Parkes, Sara Malone</div>
                  <div class="OS_smallText2">invites you play</div>
                </div>
                <div class="inviteboxOS">
                  <div class="SmallimgOS"><img src="<?php //echo OPENSOCIAL_IMG; ?>os_img3.jpg" /></div>
                  <div> <span class="OS_Invite_Heading">Treasure Isle</span>
                    <div class="OS_button"> <span><a href="#"><img src="<?php //echo OPENSOCIAL_IMG; ?>accept.png" title="Accept" /></a></span> <span><a href="#"><img src="<?php //echo OPENSOCIAL_IMG; ?>ignore.png" title="Ignore" /></a></span> </div>
                  </div>
                  <br />
                  <div class="OS_smallText">Benjamin Harrol, Sharon Taylor<span class="OS_smallText2"> invites you
                    play</span></div>
                </div>
                <div class="inviteboxOS">
                  <div class="SmallimgOS"><img src="<?php //echo OPENSOCIAL_IMG; ?>os_img3.jpg" /></div>
                  <div> <span class="OS_Invite_Heading">Treasure Isle</span>
                    <div class="OS_button"> <span><a href="#"><img src="<?php //echo OPENSOCIAL_IMG; ?>accept.png" title="Accept" /></a></span> <span><a href="#"><img src="<?php //echo OPENSOCIAL_IMG; ?>ignore.png" title="Ignore" /></a></span> </div>
                  </div>
                  <br />
                  <div class="OS_smallText">Benjamin Harrol, Sharon Taylor<span class="OS_smallText2"> invites you
                    play</span></div>
                </div> -->
              </div>
            </div>
          </div>
        