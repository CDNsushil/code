<li data-submenu-id="sub_t6" class="Membership_center common_i toad_menu_open">
<?php 
    $selectedPacakge   =  (!empty($packageDetails->subscriptionType))?$packageDetails->subscriptionType:'';
    $packageStartDate  =  (!empty($packageDetails->startDate))?$packageDetails->startDate:'';
    $packageEndDate    =  (!empty($packageDetails->endDate))?$packageDetails->endDate:'';
    $packageSpace      =  (!empty($packageDetails->packageSpace))?$packageDetails->packageSpace:'';
    //get diffrence of date from subscription start date
    $startDateDiffrence = getSubscriptionDayDiff(1);
    //get diffrence of date from subscription end date
    $endDateDiffrence = getSubscriptionDayDiff(2);
    //set day limits 
    $degradeAfterDay = preg_replace("/[^0-9]/", '',$this->config->item('downgrade_button_after_day'));
    $renewBeforeDay = preg_replace("/[^0-9]/", '',$this->config->item('renew_button_before_day'));
    
    $renewDay                 =  $this->config->item('renew_button_before_day');
    $renewDate                =  date('d-M-Y', strtotime($renewDay, strtotime($packageEndDate)));
    $renewDateStrtotime       =  strtotime($renewDate);
    $currentDateStrtotime     =  time();
    
?>
    
   <a href="javascript:void(0)">Your Membership </a> 
   <!--     --- not renew because renew comes at last month  ---    -->
    <ul class="menu_inner popover  menusecond toad_menu_open_sub"  id="sub_t6">
      <li class=" fs20  clr_geern your_toad bg_f8f8f8 display_table"> 
        <span class="display_cell veti_midl">
            You have 
        <?php 
            $toadCurrencySgine   =  $this->config->item('toadCurrencySgine');
            if($selectedPacakge==$this->config->item('package_type_1')){
              $membershipTitle =  $this->lang->line('package_title_1');
              $packagePrice = '';
            }elseif($selectedPacakge==$this->config->item('package_type_2')){
                $membershipTitle = $this->lang->line('package_title_2');
                $packagePrice   =  $toadCurrencySgine.number_format($this->config->item('package_1_year_price'),2);
            }elseif($selectedPacakge==$this->config->item('package_type_3')){
               $membershipTitle = $this->lang->line('package_title_3');
               $packagePrice   =  $toadCurrencySgine.number_format($this->config->item('package_3_year_price'),2);
            }
        ?>   
        <?php echo $membershipTitle; ?>  
        </span></li>
      <li> 
        <span class="width100_per content_menu"> 
      
        <?php  if($selectedPacakge==$this->config->item('package_type_2') || $selectedPacakge==$this->config->item('package_type_3')){ ?>
            <span class=" fs16  fl green opens_light">Expires <span class="red pl10">  <?php echo date('d-M-Y', strtotime($packageEndDate));  ?></span></span> 
        <?php } ?>
        
        <span class="sap_25"></span>
         <a href="<?php echo base_url('/package/index');?>" class="text_alignR fr  clr_444  red_arrow_list">Membership Options</a> 
      
        <?php  if(($selectedPacakge == $this->config->item('package_type_3') || $selectedPacakge == $this->config->item('package_type_2')) && ($startDateDiffrence <= $degradeAfterDay)) { ?>
             <span class="sap_15"></span>
            <a href="<?php echo base_url('/package/refundpackage'); ?>" class="text_alignR fr  clr_444  red_arrow_list">Request a refund</a> 
        <?php } ?>
        
        <?php //if($selectedPacakge==$this->config->item('package_type_1')){ ?>
            <span class="sap_35 bd_t"></span>
        <?php //} ?>
        
        <?php /*if($selectedPacakge==$this->config->item('package_type_2') || $selectedPacakge==$this->config->item('package_type_3')){ ?>
            <div class="your_toad_subhead red fs18"> Renew </div>
        <?php }*/ ?>
            <div class="clearb">
                
                <?php  if($selectedPacakge==$this->config->item('package_type_1') || $selectedPacakge==$this->config->item('package_type_2')){ ?>
                     <span class="fl pt10 width186" ><?php echo $this->lang->line('Your_3year'); ?></span>	<span class="fl pl30 pt10"><?php echo $this->config->item('package_3_year_price_show'); ?></span>
                      <a href="<?php echo base_url(lang().'/package/upgradepackage/3'); ?>">
                     <button class="fr gray_btn"><?php echo $this->lang->line('Your_Upgrade'); ?></button>
                      </a>
                        <span class="sap_30"></span>
                <?php } ?>
                
                <?php
                    if($selectedPacakge==$this->config->item('package_type_1')){ ?>
                        <span class="fl pt10 width186" ><?php echo $this->lang->line('Your_annualmembership_msg'); ?></span>	<span class="fl pl30 pt10"><?php echo $this->config->item('package_1_year_price_show'); ?></span>
                        <a href="<?php echo base_url(lang().'/package/upgradepackage/2'); ?>">
                            <button class="fr gray_btn"><?php echo $this->lang->line('Your_Upgrade'); ?></button>
                        </a>
                          <span class="sap_30"></span>
                <?php } ?>
                
                
                <?php  if($renewDateStrtotime <= $currentDateStrtotime && !empty($packageEndDate)){ ?>
                    <span class="fl pt10 width186" ><?php echo $membershipTitle; ?></span>	<span class="fl pl30 pt10"><?php echo $packagePrice; ?></span>
                      <a href="<?php echo base_url(lang().'/package/renewstageone/1'); ?>">
                     <button class="fr gray_btn"><?php echo $this->lang->line('Your_Renew'); ?></button>
                      </a>
                        <span class="sap_30"></span>
                <?php } ?> 
                 
                 
                <?php  if(($selectedPacakge == $this->config->item('package_type_3') || $selectedPacakge == $this->config->item('package_type_2')) && ($startDateDiffrence <= $degradeAfterDay  || $endDateDiffrence <= $renewBeforeDay)) { ?>
                    <span class="fl pt10 width186" ><?php echo $this->lang->line('Your_freemembership'); ?></span>
                        <a href="<?php echo base_url('/package/degradepackage/1');?>" class="head">
                        <button class="fr"><?php echo $this->lang->line('Your_Downgrade_msg'); ?></button>
                    </a>
                <?php } ?>
               
            </div>
            
            <span class="sap_35 bd_t"></span>
        
       
        <?php 
            $logo1path = encode('images+td_LogoonGray.png');
        ?>
            <a  href="<?php echo base_url(lang().'/common/downloadFileFrmOrigPath/'.$logo1path);?> " class="fr  red_arrow_list text_alignR pr20 ">Download Toadsquare icons </a>
              <span class="sap_20"></span>
            <div class=" display_inline_block fr" >
           <a href="<?php echo base_url(lang().'/common/downloadFileFrmOrigPath/'.$logo1path);?> "  class=" small_icon"><img src="<?php echo $imgPath; ?>gray_toad.png"  /></a> 
           <a href="<?php echo base_url(lang().'/common/downloadFileFrmOrigPath/'.$logo1path);?> " class="small_icon "><img src="<?php echo $imgPath; ?>orange_toad.png"  /></a>
           <a  href="<?php echo base_url(lang().'/common/downloadFileFrmOrigPath/'.$logo1path);?> " class=" small_icon"><img src="<?php echo $imgPath; ?>logo_gray.png"  /></a> </div>
        
        </span> 
      
        </span>
        </li>
      </ul>
</li>
