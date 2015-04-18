<?php if (!defined('BASEPATH')) exit('No direct script access allowed');   

$packageStage2 = array(
  'name'=>'packageStage2',
  'id'=>'packageStage2'
);

$termCondition = array(
  'name'    =>  'termCondition',
  'id'      =>  'termCondition',
  'value'   =>  '0',
  'type'    =>  'checkbox',
  'class'   => 'chkDisabled',
  'disabled'   => '',
);

$tremReadStatus = array(
  'name'    =>  'tremReadStatus',
  'id'      =>  'tremReadStatus',
  'value'   =>  '1',
  'type'    =>  'hidden',
);
?>

<div class="" id="page">
	<div class="wizard_wrapper " id="wrapperpage">
<!--  content wrap  start end -->
<?php echo form_open($this->uri->uri_string(),$packageStage2); ?>
<div class="close_btn position_absolute"  onClick="$(this).parent().trigger('close')"></div>
<div class="newlanding_container ">
  <div class="wizard_wrap fs14 ">
    <div id="TabbedPanels1" class="TabbedPanels membership">
      <div class="TabbedPanelsContentGroup main_tab m_auto width826 display_table ">
        <div class="TabbedPanelsContent TabbedPanelsContentVisible">
        <!--  Membership wrap start end -->
        <h3 class="red fs21 fnt_mouse pt12 pb10 bb_aeaeae "><?php echo $this->lang->line('packstage2_term_condition'); ?></h3>
        <h4 class="fs18 pt25 pb25 "><?php echo $this->lang->line('packstage2_scroll_descrip'); ?></h4>
        <div class=" bg_fff bdr_aeaeae width788 pl23 pr15 pb15 pt10 display_table trm_wrap radius5">
          <div class=" shiping_csroll ">
            <div class=" height330 content_3 fs12 content overflow_hidden ">
                <?php echo $description; ?>
             </div>
            <label class="defaultP mt5 pb6 shodw width100_per">
				 <span id ="tests" style="opacity:0.5;">
                <?php echo form_input($termCondition); ?> 
                </span>
                <span class=" pt3 pb0">
                   <?php echo $this->lang->line('packstage2_term_msg'); ?>
                </span>
            </label>
            
            <div class="validation_error dn pt5" id="term_error" >
              <?php echo $this->lang->line('packstage2_error_messag'); ?>
            </div>
            
            <span class="download_pdf pdf_dowload fr pt20 pr36 fs12" ><span class="fl pr10">Download the Terms &amp; Conditions in PDF.</span><ul class="fl font_bold"><li><a  href="<?php echo base_url('home/termsncondition/en'); ?>" target="_blank">English</a></li><li><a  href="<?php echo base_url('home/comingsoon'); ?>" target="_blank">Français</a></li><li><a  href="<?php echo base_url('home/comingsoon'); ?>" target="_blank">Deutcsh</a></li></ul></span>
        
          </div>
        </div>
        
		<div class="fr btn_wrap display_block font_weight">
			<button class="bg_ededed bdr_b1b1b1 mr5" onclick="$(this).parent().trigger('close');" type="button">Cancel</button>
			<button class="b_F1592A bdr_F1592A " type="button" onclick="loginWithFb();">Next</button>
		</div>
	 
      </div>
      </div>
    </div>
  </div>
</div>
  <?php
    echo form_input($tremReadStatus); 
    echo form_close();
  ?> 
  </div>     
  </div> 
    
<!--  content wrap  end -->
<script type="text/javascript">
	

	$(document).ready(function() {
		$(".content_3").mCustomScrollbar({
          scrollInertia:600,
          autoDraggerLength:false,
          callbacks:{
            whileScrolling:function(){
            var top_drag = $('.mCSB_dragger').position();
            //alert(top_drag.top);
              if(top_drag.top >='285') {
                $('#termCondition').removeAttr('disabled');
                $('#tests').css({ opacity: 1.5 });
              }
            }
          }
        });
        
		//$('.chkDisabled').each(function() {
         //$('#termCondition').parent().css('opacity','0.5');
        //});
        
		runTimeCheckBox();
	});
	
	//call stage switch method
	function loginWithFb() {
		var  tremChckStatus = $('#termCondition').is(':checked');
		if(!tremChckStatus) {
			$('#term_error').show();
			return false;
		}
		open_window('<?php echo getFacebookLoginUrl(); ?>');
		$('.close_btn').trigger('close');
	}
</script>
