<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

?>
    <div class="bg_white cart_pattern">
        <div class="seprator_6"></div>
			<div class="cart_top_header ml6 mr6">
				<div class="CSEprise_pattern minH110">
					<div class="cell">
						<div class="cart_top_header_heading"><?php echo $this->lang->line('shopping_cart'); ?></div>
					</div>
              <div class="Fright">
                <div class="SCart_subMenu_outer mt10 mr10">
                 
					<?php $this->load->view('purchase_common_menu'); ?>  
					
                </div>
                <div class="seprator_30"></div>
                
                
              </div>
              
               <div class="cart_main_nav_box fl mt7"> 
              		<a href="<?php echo base_url('cart/sales_order')?>" class="ml40 selected height37 ptr">
                  <div class="mt9 mr8"><?php echo $this->lang->line('sales_menu'); ?></div>
                  </a>
                  <a href="<?php echo base_url('cart/sales_information')?>" class="ml10 height37 ptr">
                  <div class="mt9 mr8"><?php echo $this->lang->line('sales_information'); ?></div>
                  </a>
                  <div class="clear"></div>
                  </div>
              
            <form action="<?php base_url('cart/sales_order')?>" method="get" name="search_sales_order" id="search_sales_order"> 
              
              <div class="fr mr10">
					
					 <div class="fl height_30 date_picker width_212">
						<p class="clr_white font_opensansSBold"><?php echo $this->lang->line('from'); ?> <input readonly type="text" name="from_date" id="from_date" placeholder="DD  MM  YY" class="date-input" value="<?php echo $from_date; ?>"><img  class="ptr" onclick='$("#from_date").focus();' class="ui-datepicker-trigger" src="<?php echo base_url('templates/default'); ?>/images/toadcalender_icon.png" alt="From" title="From" ></p>
					  </div>
					  
					 <div class="fl height_30 date_picker width196 ml10 ">
						<p class="clr_white font_opensansSBold for_to_lab"><?php echo $this->lang->line('to'); ?> <input readonly type="text" dateGreaterThan="#from_date" title="Enter correct date." name="to_date" id="to_date" placeholder="DD  MM  YY"  class="date-input" value="<?php echo $to_date; ?>"><img class="ptr" onclick='$("#to_date").focus();' class="ui-datepicker-trigger" src="<?php echo base_url('templates/default'); ?>/images/toadcalender_icon.png" alt="To" title="To"></p>
					 </div>
					  
					  <div class="tds-button Fright ml18">  <button  onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" type="submit" value="Save" name="save"><span class="text-indent_0"><?php echo $this->lang->line('Refresh'); ?></span></button> </div>
					  
                  
                  </div>
              </form>
              
            </div>
          </div>
           
          <div class="seprator_25"></div>
          
          <div class="mh419">
			  
        <div class="cart_container_outer width940 mH70 ml6" id="showInbox" >
        
        
			 <?php $this->load->view('sales_order_container'); ?>
       
          
        </div>
          
          <div class="seprator_8"></div>
    		
       
    </div>
    
    
    
        <!--front_end_mani_content_wp-->
<script>
$(document).ready(function(){	
			 $("#search_sales_order").validate({
				 
				 }); });	 
	 
 function mousedown_tds_button_pur(obj){
obj.style.backgroundPosition ='0px -42px';
obj.firstChild.style.backgroundPosition ='right -42px';
}
function mouseup_tds_button_pur(obj){
	obj.style.backgroundPosition ='0px 0px';
	obj.firstChild.style.backgroundPosition ='right 0px';
}

 </script> 
