<?php if (!defined('BASEPATH')) exit('No direct script access allowed');   

$renewStage2 = array(
  'name'=>'renewStage2',
  'id'=>'renewStage2'
);

if(!empty($isBackStep)) {
	$termCondition = array(
	  'name'    =>  'termCondition',
	  'id'      =>  'termCondition',
	  'value'   =>  '0',
	  'type'    =>  'checkbox',
	  'checked' => true
	);
} else {
	$termCondition = array(
	'name'    =>  'termCondition',
	'id'      =>  'termCondition',
	'value'   =>  '0',
	'type'    =>  'checkbox',
	'class'   => 'chkDisabled',
	'disabled'   => '',
	);
}

$tremReadStatus = array(
  'name'    =>  'tremReadStatus',
  'id'      =>  'tremReadStatus',
  'value'   =>  '1',
  'type'    =>  'hidden',
);
?>

<!--  content wrap  start end -->
<?php echo form_open($this->uri->uri_string(),$renewStage2); ?>
<div class="newlanding_container ">
  <div class="wizard_wrap fs14 ">
    <div id="TabbedPanels1" class="TabbedPanels membership">
      <!-- membership stages start -->
       <?php $this->load->view('common_view/renew_stage_menus') ?>
      <!-- membership stages end-->
      <div class="TabbedPanelsContentGroup main_tab m_auto width826 display_table ">
        <div class="TabbedPanelsContent TabbedPanelsContentVisible">
        <!--  Membership wrap start end -->
        <h3 class="red fs21 fnt_mouse pt12 pb10 bb_aeaeae "><?php echo $this->lang->line('packstage2_term_condition'); ?></h3>
        <h4 class="fs18 pt25 pb25 ">
			<p id="termTopMsg">
				<?php echo $this->lang->line('packstage2_scroll_descrip'); ?>
			</p>	</h4>
        <div class=" bg_fff bdr_aeaeae width788 pl23 pr15 pb15 pt10 display_table trm_wrap radius5">
          <div class=" shiping_csroll ">
            <div class=" height330 content_3 fs12 content overflow_hidden">
                <?php echo $description; ?>
             </div>
            <label class="defaultP mt5 shodw width100_per">
				<?php if(empty($isBackStep)) { ?>
					<!-- shows checkbox image till terms not accepts-->
					<div class="ez-checkbox" style="opacity: 0.5;" id="termBoxImg"></div>
				<?php } ?>
                 <?php echo form_input($termCondition); ?> 
                 <span class=" pt3 pb0">
                   <?php echo $this->lang->line('packstage2_term_msg'); ?>
                </span>
            </label>
            
            <div class="validation_error dn pt5" id="term_error" >
                <?php echo $this->lang->line('packstage2_error_messag'); ?>
            </div>
            
           	<span class="download_pdf pdf_dowload fr pt20 pr36 fs12" ><span class="fl pr10">Download the Terms &amp; Conditions in PDF.</span><ul class="fl font_bold"><li><a  href="<?php echo base_url('/images/Terms and Conditions_18.04.2013.pdf'); ?>" target="_blank">English</a></li><li><a  href="javascript:void(0)" target="_blank">Français</a></li><li><a  href="javascript:void(0)" target="_blank">Deutcsh</a></li></ul></span>
           
           
          </div>
        </div>
        <?php 
           $data['cancelUrl']  =  base_url('package/information'); // set cancel url
           $data['backUrl']    =  base_url('package/packagestageone');
           $this->load->view('common_view/common_buttons',$data);
        ?>
      </div>
      </div>
    </div>
  </div>
</div>
  <?php
    echo form_input($tremReadStatus); 
    echo form_close();
  ?>      
<!--  content wrap  end -->

<script type="text/javascript">
  //call stage switch method
  packageStageSwitch('renewStage2',"/package/renewstagetwopost",true);
  
  $('#termBoxImg').click(function() {
		$('#termTopMsg').addClass('termsTopTxtError');
	});
</script>
