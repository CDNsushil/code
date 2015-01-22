<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

?>
 <div>
          <div class="seprator_6"></div>
          <div class="cart_top_header ml6 mr6">
            <div class="CSEprise_pattern">
              <div class="cart_top_header_heading"> <?php echo $this->lang->line('membershipcart'); ?></div>
              <div class="cart_main_nav_box font_opensans">
               <a class=" ml40">
                <div class="CMN_count">1</div>
                <div class="ml60 mt9 mr30 font_opensans"><?php echo $this->lang->line('choosespace'); ?></div>
                </a> 
                
                <a class="ml40 ">
                <div class="CMN_count">2</div>
                <div class="ml60 mt9 mr30 font_opensans"><?php echo $this->lang->line('confirmbilling'); ?></div>
                </a> 
                
                <a class="ml40">
                <div class="CMN_count">3</div>
                <div class="ml60 mt9 mr30 font_opensans"><?php echo $this->lang->line('summary'); ?></div>
                </a>
                
                <!-- <a class="ml40">
                <div class="CMN_count">4</div>
                <div class="ml52 mt9 mr12">Confirm Purchase</div>
                </a>-->
                
                 <a class="ml40 selected">
                <div class="CMN_count">4</div>
                <div class="ml60 mt9 mr30 font_opensans"><?php echo $this->lang->line('payment'); ?></div>
                </a>
                
                
                 </div>
              <div class="clear"></div>
            </div>
          </div>
          <div class="seprator_25"></div>
          <div class="cart_container_outer ">
          	<div class="cart_container min_h558 pl30 pr30 pr30 pt20 pb20">
				<div class="seprator_15"></div>
					<div class="SCart_form_heading ml160  pt10 orange_color"> <?php echo $this->lang->line('thankYouMessage'); ?> </div>
                
                <?php 
               //echo "<pre>";
                //print_r($PayPalResult); ?>
                    
				<!-- / Relative -->
            <div class="seprator_40"></div>
            <div>
				
            <div class="tds-button-orange Fright mr10"> 
			
			</div>
            
            </div>
            
            </div> <!-- /cart_container -->
          </div>
          <div class="seprator_20"></div>
        </div>

<script>
$(document).ready(function(){
	$("#confirmBilling").validate();
});


 function saveForm(){	 
	  $('#confirmBilling').submit();	 
	 }
	 
function mousedown_tds_button_orange(obj){
obj.style.backgroundPosition ='0px -76px';
obj.firstChild.style.backgroundPosition ='right -76px';
}
function mouseup_tds_button_orange(obj){
	obj.style.backgroundPosition ='0px 0px';
	obj.firstChild.style.backgroundPosition ='right 0px';
}	 
	 
function checkCountry()
{
	var countryId = $("#billing_country").val();
		
	$.ajax
		({     
		   type: "POST",
		   url: "<?php echo base_url() ?>membershipcart/checkBillingCountry/"+countryId,

			success: function(msg)
			{  
				if(msg==true){
					$('.EuVat').removeClass('dn');
					//$('#EuVatIdentificationNumber').val('0');
					} else {
						  $('.EuVat').addClass('dn');
						}
				
		     }
	});	 
	
		
	
	}	 
	 

</script>
