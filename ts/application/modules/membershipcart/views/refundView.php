<?php 

$formAttributes = array(
'name'=>'refundPayment',
'id'=>'refundPayment'
);

$receiverEmail = (isset($orderDetails->paypalEmail) && ($orderDetails->paypalEmail!='')) ? $orderDetails->paypalEmail :'';  ?>


  <div onclick="$(this).parent().trigger('close');" class="popup_close_btn dn" id="popup_close_btn"></div>
  <div onclick="$(this).parent().trigger('close');refreshPage();" class="dn" id="popup_close_btn_ref"></div>
  
    <div class="popup_gredient ">
     
 <?php if($price>0) { ?>		
        <div class="width425px">  
	  <?php echo form_open(base_url(lang().'/membershipcart/payments_pro/Refund_transaction'),$formAttributes); ?>	  
        <div class="joinpopup_msg_box"> <div class="Fright mr13"><img src="<?php echo base_url('images/join-popup_logo.png') ?>" alt="logo"/></div> <div class="clear"> </div></div>
        <div class=" seprator_10 clear"></div>
         <div class="position_relative">
          <div class="cell shadow_wp strip_absolute left100">
            <!-- <img src="images/strip_blog.png"  border="0"/>-->
            <table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0">
              <tbody>
                <tr>
                  <td height="59"><img src="<?php echo base_url('images/shadow-top-small.png') ?>"></td>
                </tr>
                <tr>
                  <td class="shadow_mid_small height_68">&nbsp;</td>
                </tr>
                <tr>
                  <td height="63"><img src="<?php echo base_url('images/shadow-bottom-small.png') ?>"></td>
                </tr>
              </tbody>
            </table>
            <div class="clear"></div>
          </div>
          <div class=" seprator_27"></div>
          
          <input type="hidden" value="<?php echo $orderDetails->ordNumber;?>" name="transactionid" />
          <input type="hidden" value="Full" name="refundtype" />
          <input type="hidden" value="EUR" name="currencycode" />
          <input type="hidden" value="<?php echo $price ?>" name="amt" />
          <input type="hidden" value="<?php echo $userContainerId ?>" name="containerId" id ="currentContainer" />
          <input type="hidden" value="<?php echo $currentOrderId ?>" name="currentOrderId" />
          <input type="hidden" value="<?php echo $sectionName ?>" name="sectionName" />
                              
         <div class="row">
			<div class="join_label_wrapper cell min_widht100"> </div>			
		</div>
			
			 <div class="join_heading ml130 lineh_20 "> This Tool cost you €<?php  echo number_format($price,2) ?>.</div>
			 
			<div class="join_heading pt30 ml130 lineh_20 font_size13">
		    	We will send the refund to your PayPal account.								
			</div>
			<div class="clear"></div>
	   <div class="seprator_15"></div>
       
        <div class="pop_bdr"></div>                
          
          <div class="row">
			<div class="join_label_wrapper cell min_widht100 pl10 pt8">
			  <label class="req_field backposition_72">PayPal ID</label>
			</div>
			<div class=" cell join_frm_element_wrapper pl16 width285">
			  <div class="row">
				  <div class="input_container fl">
				  <input type="text" size="30" maxlength="80" id="paypalId" class="required email form formTip" readonly="readonly" value="<?php echo $receiverEmail?>" name="paypalId">
				  </div>
				  </div>
			  <div id="emailMsg" class=" row dark_Grey">
							</div>
			</div>
			
		  </div>
		  <div class="clear"> </div>
		  
		   <div id="loaderDiv"></div>
		  <div class="font_size15 ml130 lineh_20 red " id="errorPaypal"></div>

          <div class="clear"> </div>
        </div>
         <div class="seprator_26"></div>
         
        <div class="row">
				<div class=" cell join_frm_element_wrapper width_130 pl16">
		<div class="Req_fld font_opensansSBold font_size12 mt7 "><?php echo $this->lang->line('requiredFields');?> </div>
		</div>
          <div class="tds-button fl ml60 "> <a onclick="$(this).parent().trigger('close');" onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" ><span class=" hoverOrange font_opensansSBold width_60" >Cancel</span></a>
          <div class="tds-button fl 10" id="RefundBtn"> <a onclick="sendRefundRequest();" href="javascript:void(0);" onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" ><span class="hoverOrange font_opensansSBold width100" >Request a Refund</span></a> </div>
          <div class="tds-button fl 10 opacity_4 dn" id="RefundDisableBtn"> <a href="javascript:void(0);"><span class="font_opensansSBold width100" >Request a Refund</span></a> </div>
        </div>
       
        
        <div class=" seprator_10 clear"></div>
      </div>
    </div>
<?php echo form_close(); 
}
else { ?>

<div class="customAlert">This was a free container.</div>



<?php } ?>

 </div>
 
 <script>
	 
$(document).ready(function(){
			$("#refundPayment").validate();			
			//setCount();				
	});				 
 	 
 
 // Send Refund request
 function sendRefundRequest () {
	 
	   $('#RefundBtn').addClass('dn');	
	   $('#RefundDisableBtn').removeClass('dn');	
	 				
		var fromData=$("#refundPayment").serialize();
		fromData = fromData;
		var containerId = $('#currentContainer').val();
		
		$('#loaderDiv').html('<img  class="ma pt10" id="loadImg" align="absmiddle" src="'+baseUrl+'images/loading_wbg.gif" />');
			
		$.post(baseUrl+language+'/membershipcart/payments_pro/Refund_transaction/',fromData, function(data) {
		  if(data){
			  
			  $('#loaderDiv').html('');
			  
			    if(data==1){					
					$('#errorPaypal').html('Refunded to your PayPal Account.');
					$('#errorPaypal').addClass('pt10');			
					$('#popup_close_btn_ref').addClass('popup_close_btn');			
					$('#popup_close_btn').removeClass('popup_close_btn');			
					$('.row_'+containerId).remove();
					
					return false;
				
					setTimeout(function(){							
							refreshPage();	
						 }, 3000);
									
				  }
				 else{ 
						$('#errorPaypal').html('Transaction Refused.');
						$('#errorPaypal').addClass('pt10');	
						setTimeout(function(){
							$('#popup_close_btn').trigger('close');	
						 },3000);				
					 }	
				 
		  }else{
			customAlert("Please Try Again !...");  
		  }
		});		
	}		
 
 
  function refreshPage(){	 
	   window.location.reload(true);		  
	  }
 
 
 
 /* Get purchase type of items 
 function setCount(){	
   var formNameId = '<?php echo $formNameId ?>'; 
   var numItems = $('.count'+formNameId).length;
 
	var count = 1;	
		$('.count'+formNameId).each(function(i){	
			$(this).html(count);			
			count++;					  	 
		});		
	return true;
	}
 
 */
 
 </script>
 
