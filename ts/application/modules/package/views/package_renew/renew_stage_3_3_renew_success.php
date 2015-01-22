<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<div class="newlanding_container">
   <div class="wizard_wrap fs14 ">
      <div id="TabbedPanels1" class="TabbedPanels membership">
        <?php $this->load->view('common_view/renew_stage_menus') ?>
         <div class="TabbedPanelsContentGroup width100_per m_auto  display_table ">
            <div class="TabbedPanelsContent TabbedPanelsContentVisible">
               <div id="TabbedPanels5" class="TabbedPanels tab_setting">
                  <?php $this->load->view('common_view/renew_stage_sub_menus') ?>
                  <div class="TabbedPanelsContentGroup ">
                     <div class="TabbedPanelsContent TabbedPanelsContentVisible thankyou_wrap ">
                        <div class="clearb  width_493 m_auto">
                         
                            <h3 class="fs21 red bb_aeaeae "><?php echo $successMsg; ?></h3>
                              <div class="fs18 pt_34 thankyou_wrap">
                               
                                <p>
                                  <?php echo $this->lang->line('packwelcome_msg_heading_3'); ?>
                                </p>
                             
                                <div class="thankyou_img fl">
                                  <h5 class="fs28 width_260   pb20 font_museoSlab lineH35 display_table clearb clr_fff text_alignC  fr"><span> <?php echo $this->lang->line('packfreejoined_thank_you'); ?></span> </h5>
                                  <div class=" fl mt-34">
                                    <img src="<?php echo $imgPath; ?>/forg.png" alt=""/>
                                  </div>
                                </div>
                              </div>
                        </div>
                        <div class="fr option_btn btn_wrap display_block mt10font_weight">
                          <!-- <a href="javascript:void(0)">      <button class=" bg_ededed back back back_click bdr_b1b1b1 mr5"> Back </button></a>-->
                            <a href="<?php echo base_url_lang(); ?>"><button class="b_F1592A next_click bdr_F1592A ">Finish </button></a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
