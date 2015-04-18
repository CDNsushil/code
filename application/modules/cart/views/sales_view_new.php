<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<div class="row content_wrap blog_wrap" >
   <div class="bg_f3f3f3 fl width100_per  title_head">
      <h1 class="fs34imp green letrP-1 opens_light mb0  fl txt_indent  textin30">Sales</h1>
      <?php 
       //-------shopping cart menu navigation start----------//
            echo modules::run('cart/shoppingcartdata');
        //-------shopping cart menu navigation start----------// ?>  
   </div>
   <div class="m_auto display_table width900">
      <ul class="dis_nav green_active display_inline_block fs16 mt32 pr30">
         <li class="active"> <a href="<?php echo base_url('cart/mysales')?>">Sales</a> </li>
         <li> <a href="<?php echo base_url('cart/salesinformation')?>">Sales Information</a> </li>
      </ul>
      <div class="sap_25"></div>
      <div class="sale_wrap pb30" id="showInbox">
          
          <?php $this->load->view('sales_view_container_new'); ?>
     </div>
   </div>
</div>

<script type="text/javascript">

    // This function is used to remove error class if string greater than zero
    function checkFieldBlank(getObject)
        {
            var getValue = getObject.value;
            var getValueId = getObject.id;
            if(getValue.length > 0)
            {
                $("#"+getValueId).removeClass('error');
                
            }else
            {
                $("#"+getValueId).addClass('error');
            }
        }

        // This function is used to submit shipping details
        function shipping_details_submit(formId)
        {   
            $("#shipping_details"+formId).validate({
                submitHandler: function() {
                    var fromData=$("#shipping_details"+formId).serialize();
                    fromData = fromData+'&ajaxHit=1'+'&formId='+formId;

                    $.post(baseUrl+language+'/cart/productshipped',fromData, function(data) {
                      if(data){
                            refreshPge();
                        }

                    });
                }
            });
             return false;
        }
            

</script>
