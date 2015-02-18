<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
 <div class="newlanding_container">
  <div class="wizard_wrap fs14 ">
    <div class="clearb width_493 m_auto display_table" >
       <h1 class=" fs36 mt60 pb0 opens_light color_444 lineH27  bb_fac8b8 clr_444 text_alighL"> 
            <?php echo $this->lang->line('packfreejoined_welcome_username'); ?> 
            <?php 
              if($this->session->userdata('firstName')){
                echo $this->session->userdata('firstName');
              }
            ?>
        </h1>
       <div class="fs18 pt24 thankyou_wrap">
          <p> <?php echo $this->lang->line('packfreejoined_thank_your_toad'); ?></p>
          <p><?php echo $this->lang->line('packfreejoined_you_will_receive'); ?></p>
          <p> <?php echo $this->lang->line('packfreejoined_you_have_an_email'); ?> </p>
          <p><?php echo $this->lang->line('packfreejoined_donot_recieve'); ?></p>
          <div class="thankyou_img fl">
             <h5 class="fs28 font_museoSlab lineH35 display_table clearb clr_fff fr">
                <span ><?php echo $this->lang->line('packfreejoined_dont_forgot'); ?>
                </span> 
             </h5>
             <div class=" fl mt-34"><img src="<?php echo $imgPath; ?>/forg.png" alt="" /></div>
          </div>
       </div>
    </div>
  </div>
</div>
     
