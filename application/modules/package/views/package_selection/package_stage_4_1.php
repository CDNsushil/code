<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$packageStage4_1 = array(
  'name'=>'packageStage4_1',
  'id'=>'packageStage4_1'
);

$promoBtn = array(
	'name'    =>  'promoBtn',
	'id'      =>  'promoBtn',
	'content' =>  $this->lang->line('packstage_promo_submit'),
	'class'   =>  'back bdr_b1b1b1 mr5 mt10 promoCodeCheck',
	'type'    =>  'button'
);
?>
<!--  content wrap  start end -->
<?php echo form_open($this->uri->uri_string(),$packageStage4_1); ?>
<div class="newlanding_container">
	<div class="wizard_wrap fs14 ">
    <div id="TabbedPanels1" class="TabbedPanels membership">
       <?php $this->load->view('common_view/package_stage_menus') ?>
      <div class="TabbedPanelsContentGroup width100_per m_auto  display_table ">
          <div class="TabbedPanelsContent TabbedPanelsContentVisible">
             <div id="TabbedPanels5" class="TabbedPanels tab_setting">
               <?php $this->load->view('common_view/package_stage_sub_menus') ?>
                <div class="TabbedPanelsContentGroup ">
                   <div class="TabbedPanelsContent TabbedPanelsContentVisible">
                      <div class="wra_head clearb width635">
                         <h3 class="red   fs21 fnt_mouse bb_aeaeae">
                            <?php 
                                if($selectedPacakge==$this->config->item('package_type_2')){
                                  echo $this->lang->line('packpayment_annual_membership_payment'); 
                                }elseif($selectedPacakge==$this->config->item('package_type_3')){
                                  echo $this->lang->line('packpayment_three_year_membership'); 
                                }
                             ?>
                         </h3>
                         <ul class="display_table clearb mt40 defaultP ">
                            <li class=" font_weight">
                               <label>
                               <input  type="radio" name="item12" value="2" checked="checked" />
                               <?php 
                                  if($selectedPacakge==$this->config->item('package_type_2')){
                                     echo '€ '.number_format($this->config->item('package_1_year_price'),2); 
                                  }elseif($selectedPacakge==$this->config->item('package_type_3')){
                                    echo '€ '.number_format($this->config->item('package_3_year_price'),2); 
                                  }
                                ?>
                               </label>
                            </li>
                            
                           <!-- <li class="clearb fl fs17 pt15 mb5 ml36">  </li> -->
                            
                            <?php 
                                if(!isLoginUser()){
                            ?>
                            <li class="clearb  pl30">
								   <label class="pt30">
								   <input  type="text" id="promoCode" name="promoCode" class="font_wN" onclick ="placeHoderHideShow(this,'Promotional Code','hide')",
									onblur = "placeHoderHideShow(this,'Promotional Code','show')" placeholder="Promotional Code" value=""  />
								   </label>   
								   
								   <span class="fl mt15">
									<?php echo form_button($promoBtn); ?>
								</span>
								<span class="red mt35 pl10	" id="promoAvailMsg"></span>
								             
                            </li>
                        
                            <?php } ?>
                            
                         </ul>
                         <div class="sap_40"></div>
                          <?php 
                            $data['cancelUrl'] =  base_url('package'); // set cancel url
                            $data['backUrl']   = base_url('package/packagestagethree');
                            $this->load->view('common_view/common_buttons',$data);
                          ?>
                      </div>
                   </div>
                </div>
             </div>
          </div>
       </div>
    </div>
  </div>
</div>
<?php echo form_close(); ?>  
<!--  content wrap  end -->

<script type="text/javascript">
  //call stage switch method
  packageStageSwitch('packageStage4_1',"/package/membershipselectedpost");
  
	//check user email availability
    $('.promoCodeCheck').click(function(){
		
		var promoCode = $('#promoCode').val();
		
		if(promoCode == '') {
			$('#promoCode').addClass('error');
			$('#promoAvailMsg').html('This Promotional Code is not valid.');
			return false; 
        }
		var promoCheckUrl =  '<?php echo base_url(lang().'/package/promocodeavailcheck');?>';
		 $.ajax({
                  type: 'POST',
                  url : promoCheckUrl,
                  dataType :'json',
                  data : {
						promoCode:promoCode,
						ajaxHit:1
                  },
                  beforeSend:function(){
                      //show loader
                      $("#promoAvailMsg").html('<img  class="ma ajax_loader" align="absmiddle"src="'+baseUrl+'images/loading_wbg.gif" />');
                  },
                  complete:function(){
                    
                  },
                  success:function(data){
                   
                    if(data.errorStatus == false){
                        //show error message condition
                        $('#promoAvailMsg').html(data.errorMessage);
                        $('#promoCode').addClass('error');
                    }else{
                        $('#promoAvailMsg').html(data.errorMessage);
                         $('#promoCode').removeClass('error');
                    }
                  },
                  error: function (xhr, ajaxOptions, thrownError) {
                    $("#successMsg").html('');
                  }
            });
	});
</script>
