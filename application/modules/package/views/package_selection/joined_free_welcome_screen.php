<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
//------create share link by current url-------//
$currentShortUrl = uri_string();
?>
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
  
	<!------- Share block start here -------->
	<div class="width560 m_auto display_table"> 
	<?php /*?>
		<div class="bdre6e6 pr10 pt10 pb20 pl30 width100_per  m_auto radius4">
			<?php
			//-------load module of social share---------------//
			//$shareData=array('url'=>$currentShortUrl);
			//echo Modules::run("share/sharesocialjoinbutton",$shareData);		
			?>
		</div>  
		<div class="sap_30"></div>
		<button class="bg_f1592a fr">Finish</button>
	<?php */?>
	<a href="<?php echo base_url('home'); ?>"> 
		<button class="bg_f1592a fr ">Finish </button>
	</a>
		
		<div class="sap_30"></div>
	</div>
	<!------- Share block end here -------->
  
</div>
     
