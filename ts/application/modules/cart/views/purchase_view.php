<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

        <div class="bg_white cart_pattern mh560">
          <div class="seprator_6"></div>
        
         <div class="cart_top_header ml6 mr6">
            <div class="CSEprise_pattern minH110">
              <div class="cell">
                <div class="cart_top_header_heading"><?php echo $this->lang->line('shopping_cart'); ?> </div>
                
              </div>
              <div class="Fright">
                <div class="SCart_subMenu_outer mt10 mr10">
                
					<?php $this->load->view('purchase_common_menu'); ?>  
                
                </div>
                <div class="seprator_30"></div>
                
                
              </div>
              
               <div class="cart_main_nav_box fl"> 
              		&nbsp;
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
			  
			  <?php $this->load->view('purchase_view_container'); ?>
                    
        </div>
         
        
        <!-------------container end here----------> 
          </div>
          <div class="seprator_20"></div>
        </div>
		<div class="ml35 pb5"><?php echo $this->lang->line('request_refund'); ?></div> 
        <!--front_end_mani_content_wp-->

 <script>
		function shipping_details_submit(formId)
		{
				
				
				var fromData=$("#shipping_details"+formId).serialize();
					fromData = fromData+'&ajaxHit=1';
					$.post(baseUrl+language+'/cart/shipping_recieved_submit',fromData, function(data) {
					  if(data){
							$('#shipping_details_div'+formId).html(data);
							$('#shippingStatus'+formId).html('Recieved');

							
							
					  }
				
					});
			
			
		}	
			
		
</script>
