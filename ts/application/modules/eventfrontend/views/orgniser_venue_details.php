<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
  <div class="popup_close_btn" onclick="$(this).parent().trigger('close');"></div>
    <div class="popup_gredient " >
      <div class="width_490">
        <div class="row">
          <div class="width_35 height_auto cell mt38">
            <ul id="tabs_link">
               <?php if(@$venueName != ''){ ?>
              <li class="btngradient liVOD " id="venueTab<?php echo $id;?>" onclick="venueOrgniserDetails('','#venueTab<?php echo $id;?>','#venueDetails<?php echo $id;?>')"> <a href="javascript:void(0);"> <span class="a_venutest"> </span> </a> </li>
              <?php 
              }
              if(@$OrgName != ''){ 
			 ?>
              <li class="btngradient mt_minus_2 liVOD" id="orgniserTab<?php echo $id;?>" onclick="venueOrgniserDetails('','#orgniserTab<?php echo $id;?>','#orgniserDetails<?php echo $id;?>')"> <a href="javascript:void(0);"> <span class="a_organitest"> </span> </a> </li>
              <?php } ?>
            </ul>
          </div>
          <div class="outetab divVOD " id="venueDetails<?php echo $id;?>">
            <div class="cell  position_relative ml46 mt35 min_h292">
              <div class="cell shadow_wp position_absolute">
                <table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0">
                  <tbody>
                    <tr>
                      <td height="59"><img src="<?php echo base_url();?>images/shadow-top-small.png"></td>
                    </tr>
                    <tr>
                      <td class="shadow_mid_small"></td>
                    </tr>
                    <tr>
                      <td height="63"><img src="<?php echo base_url();?>images/shadow-bottom-small.png"></td>
                    </tr>
                  </tbody>
                </table>
                <div class="clear"></div>
              </div>
              <?php
				if($venueName != ''){ ?>
					 <div class="font_opensans font_size18 bdr_Bgray height_18 width_345 ml60">
						<div class="clr_666 width_338 font_opensansLight font_size22"><?php echo htmlspecialchars_decode($venueName);?></div>
					</div>
				<?php
				}
				
              ?>
             
              <div class="seprator_20"></div>
              <div class="join_frm_element_wrapper pt30 font_size13 pl0 ml60 width_auto">
				<?php
				if($venueName == ''){ ?>
					  <p class="minWidth260px"> <?php echo $this->lang->line('venueNA');?> </p>
					<?php
				}else{
					?>
				  
					<p><?php echo htmlspecialchars_decode($OrgName);?> </p>
					<div class="seprator_16"></div>
					<?php 
						if($venueaddress != ''){ ?>
							 <p> <?php echo $venueaddress;?> </p>
							<?php
						}
						if($venueaddress2 != ''){ ?>
							 <p> <?php echo $venueaddress2;?> </p>
							<?php
						}
						
						if($venuecountryName != ''){ ?>
							 <p> <?php echo $venuecountryName;?> </p>
							<?php
						}
						
						if($venuestate != ''){ ?>
							 <p> <?php echo $venuestate;?> </p>
							<?php
						}
						if($venuecity != ''){ ?>
							 <p> <?php echo $venuecity;?> </p>
							<?php
						}
						
						if($venuezip != ''){ ?>
							 <p> <?php echo $venuezip;?> </p>
							<?php
						}
						if($venuephoneNumber != ''){ ?>
							 <p class="pt12"> <?php echo $venuephoneNumber;?> </p>
							<?php
						}
						if($venueEmail != ''){ ?>
							 <p class="pt12"> <?php echo $venueEmail;?> </p>
							<?php
						}
						if($venueurl != ''){ ?>
							 <p class="pt12"> <?php echo $venueurl;?> </p>
							<?php
						}
				}
				?>
              </div>
              <div class="seprator_20"></div>
            </div>
          </div>
          <!-- /close tab -->
          <div class="outetab divVOD" id="orgniserDetails<?php echo $id;?>">
            <div class="cell  position_relative ml46 mt35 min_h292">
              <div class="cell shadow_wp position_absolute">
                <table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0">
                  <tbody>
                    <tr>
                      <td height="59"><img src="<?php echo base_url();?>images/shadow-top-small.png"></td>
                    </tr>
                    <tr>
                      <td class="shadow_mid_small"></td>
                    </tr>
                    <tr>
                      <td height="63"><img src="<?php echo base_url();?>images/shadow-bottom-small.png"></td>
                    </tr>
                  </tbody>
                </table>
                <div class="clear"></div>
              </div>
              
              <?php
				if($OrgName != ''){ ?>
					 <div class="font_opensans font_size18 bdr_Bgray height_18 width_345 ml60">
						<div class="clr_666 width_338 font_opensansLight font_size22"><?php echo htmlspecialchars_decode($OrgName);?></div>
					  </div>
				<?php
				}
				
              ?>
                            
              <div class="seprator_20"></div>
              <div class="join_frm_element_wrapper pt30 font_size13 pl0 ml60 width_auto">
				  <?php
				if($OrgName == ''){ ?>
					  <p class="minWidth260px"> <?php echo $this->lang->line('orgniserNA');?> </p>
					<?php
				}else{
					
					if($OrgAddress != ''){ ?>
						 <p> <?php echo $OrgAddress;?> </p>
						<?php
					}
					if($OrgAddress2 != ''){ ?>
						 <p> <?php echo $OrgAddress2;?> </p>
						<?php
					}
					if($OrgCity != ''){ ?>
						 <p> <?php echo $OrgCity;?> </p>
						<?php
					}
					if($OrgState != ''){ ?>
						 <p> <?php echo $OrgState;?> </p>
						<?php
					}
					if($OrgCountry != ''){ ?>
						 <p> <?php echo $OrgCountry;?> </p>
						<?php
					}
					if($OrgZip != ''){ ?>
						 <p> <?php echo $OrgZip;?> </p>
						<?php
					}
					if($OrgPhone != ''){ ?>
						 <p class="pt12"> <?php echo $OrgPhone;?> </p>
						<?php
					}
					if($OrgEmail != ''){ ?>
						 <p class="pt12"> <?php echo $OrgEmail;?> </p>
						<?php
					}
					if($OrgURL != ''){ ?>
						 <p class="pt12"> <?php echo $OrgURL;?> </p>
						<?php
					}
				}
					?>
              </div>
              <div class="seprator_20"></div>
            </div>
          </div>
          <!-- /close tab -->
			<div class="tds-button Fright mr7"> 
				<!--<a onclick="$(this).parent().trigger('close');" onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)"><span class=" font_opensans"><?php //echo $this->lang->line('close');?></span></a>-->
				<button class="font_arial" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)" onclick="$(this).parent().trigger('close');" type="button"><span><div class="Fleft"><?php echo $this->lang->line('close');?></div> 
				<div class="icon-form-close-btn"></div> </span> </button>
			</div>
          <div class="clear"></div>
          
        </div>
	<div class="row ">
	  <div class="clear"></div>
	</div>
	<div class="seprator_7 clear"></div>
  </div>
</div>
