<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<div class="newlanding_container">
   <div class="wizard_wrap fs14 ">
      <div id="TabbedPanels1" class="TabbedPanels membership">
        <?php $this->load->view('common_view/package_stage_menus') ?>
         <div class="TabbedPanelsContentGroup width100_per m_auto  display_table ">
            <div class="TabbedPanelsContent TabbedPanelsContentVisible">
               <div id="TabbedPanels5" class="TabbedPanels tab_setting">
                  <?php $this->load->view('common_view/package_stage_sub_menus') ?>
                  <div class="TabbedPanelsContentGroup ">
                     <div class="TabbedPanelsContent TabbedPanelsContentVisible thankyou_wrap pb0 ">
                        <div class="clearb  width_493 m_auto">
                         
                         
                           <h1 class=" fs36 mt60 pb0 opens_light color_444 lineH27  bb_fac8b8 clr_444 text_alighL">  <?php echo $this->lang->line('packfreejoined_welcome_username'); ?> 
                              <?php 
                                if($this->session->userdata('firstName')){
                                  echo $this->session->userdata('firstName');
                                }
                              ?>
                            </h1>
                              <div class="fs18 pt_34 thankyou_wrap">
                                <p>
                                  <?php echo $this->lang->line('packfreejoined_thank_your_toad_paid_msg'); ?>
                                </p>
                                <p>
                                  <?php echo $this->lang->line('packfreejoined_you_will_receive'); ?>
                                </p>
                                <p>
                                  <?php echo $this->lang->line('packfreejoined_you_have_an_email'); ?>
                                </p>
                                <p>
                                  <?php echo $this->lang->line('packfreejoined_donot_recieve'); ?>
                                </p>
                                <div class="thankyou_img">
                                  <h5 class="fs28 font_museoSlab lineH35 display_table clearb clr_fff text_alignl fr">
                                    <span>
                                      <?php echo $this->lang->line('packfreejoined_dont_forgot'); ?>
                                    </span>
                                  </h5>
                                  <div class=" fl mt-34">
                                    <img src="<?php echo $imgPath; ?>/forg.png" alt=""/>
                                  </div>
                                </div>
                              </div>
                        </div>
                        
                        <!--
						<div class="width560 m_auto display_table"> 
							<div class="bdre6e6 pr10 pt10 pb20 pl30 width100_per  m_auto radius4">
								<ul class="fr list_social">
									 <li><a class="share_icon small_share fl mt10 mr15 pr10 bdr_right_666" href="#"> </a>   </li>    
									 <li><a class="social_btn Facebook" href=""></a></li>
									 <li><a class="social_btn twitter" href=""></a></li>
									 <li><a class="social_btn Linkedin" href=""></a></li>
									 <li><a class="social_btn Linkedin" href=""></a> </li>
								</ul>
								<div class="clearbox pt5  bb_e9e9e9 mb15"> </div>
								<div class="clearbox">
									<div class="fl">
										<img src="<?php echo base_url('/images/toademaillogo.jpg')?>" alt="" /> 
										<div class="sap_20"></div>
										<span>I just joined Toadsquare. <a href=""> www.toadsquare.com </a></span>
									</div>

									<div class="fr btn_wrap mt30">
									<button>Share</button>
								</div>
							</div>
						</div>  
						<div class="sap_30"></div>
						<button class="bg_f1592a fr">Finish</button>
						<div class="sap_30"></div>
					</div>
                        
                        -->
                        <div class="fr option_btn btn_wrap display_block mt10font_weight">
                            <a href="<?php echo base_url('home'); ?>"> <button class="b_F1592A next_click bdr_F1592A ">Finish </button></a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
