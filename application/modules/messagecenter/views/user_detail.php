<div class="vcard_popup_wp">
<?php 

$nextContId = getUserRecordforNext($data['0']->contId);
$prevContId = getUserRecordforPrev($data['0']->contId);
$max_id    = get_id_max();
$min_id  = get_id_min();

//echo $max_id['0']->contId;
$max_id1 =  $max_id['0']->contid;
$min_id1 = $min_id['0']->contid;

?>
              
		<div class="vcard_popup_left">
        
        
        <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="center" valign="middle"><?php 
                $profile_img = getContactUserProfileImage($data['0']->emailId);
                
                
                if($profile_img['ContactUserProfileImage']!="")
                {
					$user_image = getDefaultProfileTypeImage($data['0']->UserContactId,$profile_img['ContactUserProfileImage']);								
					?>
				
					<img src="<?php echo $user_image;?>" class="max_h_104 max_w_104"  />
					
					<?php 
				}
				else
				{
					?>
					
					<img src="<?php echo base_url();?>images/var_user_img_default2.jpg" class="max_h_104 max_w_104" />
					<?php
				}
                ?></td>
              </tr>
            </table>        	
        	
        </div><!--vacard_popup_left-->
        
        <div class="vcard_popup_right">
        	<div class="vcard_popup_name"><?php echo $data['0']->firstName." ".$data['0']->lastName; ?></div><!--vcard_popup_right-->
            
            <div class="vcard_popup_occup"><?php echo $data['0']->profession; ?></div>
            
            <div class="vcard_popup_com_name"><?php echo $data['0']->company; ?></div>
            
         <?php if(isset($data['0']->emailId) && !empty($data['0']->emailId)) { ?> 
           
			   <div class="vcard_email_label">
					<?php echo $this->lang->line('email') ?>
			   </div>
			   
				 <div class="vcard_email_box">
					 <?php echo $data['0']->emailId; ?>
				  </div>
			   
			   <div class="row seprator_15"></div>
           
        <?php } ?>
        
         <?php if((isset($data['0']->UserContactId)) && (!empty($data['0']->UserContactId))){ 
				$showcase_url = site_url().lang().'/showcase/aboutme/'.$data['0']->UserContactId;
				?>
             
				<div class="vcard_email_label">
					<?php echo $this->lang->line('showcaseUrl') ?>
				</div>
				
				   <div class="vcard_email_box">
					 <a href="<?php echo site_url().lang().'/showcase/aboutme/'.$data['0']->UserContactId; ?>" target="_blank" class="white" ><?php echo $showcase_url; ?></a>
				   </div>
				
				 <div class="row seprator_15"></div>
				 
          <?php } ?>  
          
         <?php if(isset($data['0']->phone) && !empty($data['0']->phone)) { ?> 
         
				<div class="vcard_email_label">
					<?php echo $this->lang->line('phone') ?> 
				</div>
				
					<div class="vcard_email_box">
						<?php echo $data['0']->phone; ?>
					</div>
				
				 <div class="row seprator_15"></div>
				 
		<?php } ?>  	 
				 
        <?php if(isset($data['0']->address) && !empty($data['0']->address)) { ?> 
            
			   <div class="vcard_email_label">
					<?php echo $this->lang->line('address') ?>
			   </div>
			   
				  <div class="vcard_email_box">
					  <?php echo $data['0']->address; ?>
				</div>
				
       <?php } ?>      
       
            <div class="clear"></div>
            <div class="vcard_next_pre_wp">
           <!----------------->
         <?php  
           if(($max_id1==$data['0']->contId) || ($min_id1==$data['0']->contId)) 
           {
			?>
            <?php if($min_id1==$data['0']->contId) {?>
            <!-- onclick="openLightBox('contactBoxWp','contactContainer','/messagecenter/getpreviousUserContactDetail/<?php //echo $data['0']->contId; ?>')"-->
            
            <div class="vcard_pre_box" onclick="next_prevoius('contactContainer','/messagecenter/getpreviousUserContactDetail/<?php echo $data['0']->contId; ?>')">
                    	<div class="cell mt3"><img src="<?php echo base_url(); ?>templates/system/images/vcard_pre_arrow.jpg"/></div>
                        <div class="cell ml7"><a style="cursor: pointer;">Previous</a></div>
                   
                   
                    </div><!--vcard_pre_box-->
              <?php
		  }
		  ?>
              
              <?php if($max_id1==$data['0']->contId) {?>
                    <!-- onclick="openLightBox('contactBoxWp','contactContainer','/messagecenter/getnextUserContactDetail/<?php //echo $data['0']->contId; ?>')"-->
                    <div class="vcard_next_box" onclick="next_prevoius('contactContainer','/messagecenter/getnextUserContactDetail/<?php echo $data['0']->contId; ?>')">
                    	 <div class="cell "><a style="cursor: pointer;">Next</a></div>
                         <div class="cell ml7 mt3"><img src="<?php echo base_url(); ?>templates/system/images/vcard_next_arrow.jpg"/></div>
                   
                    </div><!--vcard_next_box-->
                    <?php
				}
				?>
           
           <?php }else{?>
           <!----------------->
            <?php if(count($prevContId) != 0 ) {?>
            <!-- onclick="openLightBox('contactBoxWp','contactContainer','/messagecenter/getpreviousUserContactDetail/<?php //echo $data['0']->contId; ?>')"-->
            
            <div class="vcard_pre_box" onclick="next_prevoius('contactContainer','/messagecenter/getpreviousUserContactDetail/<?php echo $data['0']->contId; ?>')">
                    	<div class="cell mt3"><img src="<?php echo base_url(); ?>templates/system/images/vcard_pre_arrow.jpg"/></div>
                        <div class="cell ml7"><a style="cursor: pointer;">Previous</a></div>
                   
                   
                    </div><!--vcard_pre_box-->
              <?php
		  }
		  ?>
              
              <?php if(count($nextContId) != 0 ) {?>
                    <!-- onclick="openLightBox('contactBoxWp','contactContainer','/messagecenter/getnextUserContactDetail/<?php //echo $data['0']->contId; ?>')"-->
                    <div class="vcard_next_box" onclick="next_prevoius('contactContainer','/messagecenter/getnextUserContactDetail/<?php echo $data['0']->contId; ?>')">
                    	 <div class="cell "><a style="cursor: pointer;">Next</a></div>
                         <div class="cell ml7 mt3"><img src="<?php echo base_url(); ?>templates/system/images/vcard_next_arrow.jpg"/></div>
                   
                    </div><!--vcard_next_box-->
                    <?php
				}
			}
			?>
            </div><!--vcard_next_pre_wp-->                                                
                                                            
        </div><!--vcard_popup_right-->
       
       <div class="clear"></div> 
</div><!--vcard-popup_wp-->
 
