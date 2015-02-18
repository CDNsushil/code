<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<div class="row content_wrap blog_wrap" >
   <div class="blog_wrap">
      <div id="TabbedPanels1" class="TabbedPanels">
        <?php 
            //---------shopping cart progress bar steps----------//
                $this->load->view('cart/common_view/shoppingcart_steps');
            //---------shopping cart progress bar steps----------//
        ?>
        <div class="TabbedPanelsContentGroup width100_per m_auto  display_table ">
            <div class="TabbedPanelsContent TabbedPanelsContentVisible">
               <div id="TabbedPanels5" class="TabbedPanels tab_setting">
                   <div class="TabbedPanelsContentGroup ">
                     <div class="TabbedPanelsContent TabbedPanelsContentVisible thankyou_wrap ">
                        <div class="clearb  width_493 m_auto">
                         
                            <h3 class="fs21 red bb_aeaeae "><?php echo $paymentMessage; ?></h3>
                              <div class="fs18 pt_34 thankyou_wrap">
                               
                                <div class="thankyou_img fl">
                                 <h5 class="fs20 width_260   pb20 font_museoSlab display_table clearb clr_fff fr">
                                   <span class="lineH23">“<?php echo $paymentHeading; ?>”</span> </h5>
                                  <div class=" fl  mt-34">
                                    <img src="<?php echo $imgPath; ?>/forg.png" alt=""/>
                                  </div>
                                </div>
                              </div>
                        </div>
                        <div class="fr option_btn btn_wrap display_block mt10font_weight">
                           <a href="<?php echo base_url_lang('cart/mywishlist/euro'); ?>"><button class="b_F1592A next_click bdr_F1592A ">Finish </button></a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
