<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<div class="row content_wrap blog_wrap" >
   <div class="blog_wrap">
      <div id="TabbedPanels1" class="TabbedPanels">
        <?php 
            //---------shopping cart progress bar steps----------//
                $this->load->view('cart/common_view/shoppingcart_steps');
            //---------shopping cart progress bar steps----------//
        ?>
      
        <div class="m_auto width635">
            <div class="TabbedPanelsContent position_relative">
               <h3>Thank you for your payment.</h3>
               <div class="sap_25"></div>
               <div class="fs17">    To see the details of your purchase, select <a href="<?php echo base_url_lang('cart/mypurchases') ?>">Purchases</a> from <br />
                  <b>Your Toadsquare > Your Shopping Cart</b>.
               </div>
               <div class="sap_15"></div>
               <div class="fs15">From here you can download files, view videos and see shipping details.</div>
               <div class="sap_10"></div>
               <div class="fs15">We will also email you a record of your purchase.</div>
               <div class="fr option_btn btn_wrap display_block mt10 font_weight">
                  <button type="button" class="bg_ededed bdr_b1b1b1  mr5">Cancel </button>
                  <a href="<?php echo base_url_lang('cart/mypurchases') ?>"> <button  type="button" class="b_F1592A  bdr_F1592A ">Go to Purchases</button></a>
               </div>
            </div>
        </div>
               
      </div>
   </div>
</div>
