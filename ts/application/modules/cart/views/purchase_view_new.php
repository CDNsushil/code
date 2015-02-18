<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<div class="row content_wrap blog_wrap" >
   <div class="bg_f1f1f1 fl width100_per  title_head">
      <h1 class="fs34imp  letrP-1 opens_light mb0  fl txt_indent  textin30">Purchases</h1>
    <?php 
        //-------shopping cart menu navigation start----------//
            $this->load->view('purchase_common_menu_new'); 
        //-------shopping cart menu navigation start----------//
    ?>  
   </div>
   <div class="m_auto display_table width900">
      <div class="sap_25"></div>
      <!--
      <div class="nav_creave  fr ">
         <span class="prev butn_n">Prev</span>
         <span class=" color_444 pagination">12</span>
         <span class="butn_n next">Next</span>
      </div>
      --->
      <div class="sap_25"></div>
      <div class="purchase_wrap pb30" id="showInbox">

            <?php $this->load->view('purchase_view_container_new'); ?>
      </div>
   </div>
</div>

 <script type="text/javascript">
		function shippingdetailssubmit(formId)
		{
             $("#shipping_details"+formId).validate({
                submitHandler: function() {
                      var fromData=$("#shipping_details"+formId).serialize();
                        fromData = fromData+'&ajaxHit=1'+'&formId='+formId;
                        
                        $.post(baseUrl+language+'/cart/productrecevied',fromData, function(data) {
                          if(data){
                                refreshPge();
                            }
                    
                        });
                 }
            });
            return false;
        }
		
</script>
