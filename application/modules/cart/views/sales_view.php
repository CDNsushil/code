<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

        <div class="bg_white cart_pattern mh560">
          <div class="seprator_6"></div>
        
         <div class="cart_top_header ml6 mr6">
            <div class="CSEprise_pattern minH110">
              <div class="cell">
                <div class="cart_top_header_heading">Shopping Cart </div>
                
              </div>
              <div class="Fright">
                <div class="SCart_subMenu_outer mt10 mr10">
                
					<?php $this->load->view('purchase_common_menu'); ?>  
                
                </div>
                <div class="seprator_30"></div>
                
                
              </div>
              
               <div class="cart_main_nav_box fl mt7"> 
					<a href="<?php echo  base_url('cart/sales')?>" class="ml40 selected height37 ptr sale_hover">
						<div class="mt9 mr8">Sales</div>
					</a>
              		<a href="<?php echo base_url('cart/sales_information')?>" class="ml10  height37 ptr sale_hover">
						<div class="mt9 mr8">Sales Information</div>
					</a>
					<div class="clear"></div>
					</div>
           
              <div class="fr mr10">
					&nbsp;                  
                  </div>
              
              
            </div>
          </div>
          
        
          <div class="seprator_25"></div>
          <div class="cart_container_outer " style="min-width: 884px;">
         <!------------container start here--------->
         
         
         <div class="cart_container show_gradiant_inner mH78" id="showInbox">
			  
			  <?php $this->load->view('sales_view_container'); ?>
                    
        </div>
         
        
        <!-------------container end here----------> 
          </div>
          <div class="seprator_20"></div>
        </div>
        <!--front_end_mani_content_wp-->
 <script>
 function mousedown_tds_button_pur(obj){
obj.style.backgroundPosition ='0px -42px';
obj.firstChild.style.backgroundPosition ='right -42px';
}
function mouseup_tds_button_pur(obj){
	obj.style.backgroundPosition ='0px 0px';
	obj.firstChild.style.backgroundPosition ='right 0px';
}

 </script> 


<script>

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
			
				var dataShipping = $.trim($('#shipping_details_data'+formId).val());
				
				if(dataShipping=="")
				{
					$('#shipping_details_data'+formId).addClass('error');
					
				}else
				{
					$('#shipping_details_data'+formId).removeClass('error');
					var fromData=$("#shipping_details"+formId).serialize();
						fromData = fromData+'&ajaxHit=1';
						$.post(baseUrl+language+'/cart/shipping_details_submit',fromData, function(data) {
						  if(data){
								$('#shipping_details_div'+formId).html(data);
								$('#shippingStatus'+formId).html('Shipped');
				
						  }
					
						});
				}	
			
		}	
			
	
</script>
