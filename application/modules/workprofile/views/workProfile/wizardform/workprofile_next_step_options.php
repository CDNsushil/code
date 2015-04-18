<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
// set base url
$baseUrl = base_url_lang('/workprofile');

$nextStepForm = array(
    'name'=>'nextStepForm',
    'id'=>'nextStepForm'
);

?>
<div class="newlanding_container">
    <div class="showcase_wizard">
        <div id="TabbedPanels1" class="TabbedPanels"> 
			<div class="TabbedPanelsContent wizard_wrap tab_setting width635 m_auto clearb">
				<div class="c_1 ">
					<div class="wra_head clearb pb18 " >
						<h3 class="red fs18 pb10"><?php echo $this->lang->line('whatYouWantNow');?></h3>
						<?php echo form_open($baseUrl.'/setworkprofilenextstep',$nextStepForm); ?>
							<div class="sap_35"></div>
							<ul class=" display_table clearb rate_wrap defaultP mt10">
								<li>
									<label>
										<input type="radio" value="1" name="wpActionType" checked='checked' >
										<?php echo $this->lang->line('setupOnlineWP');?>                    
									</label>
								</li>
								<li>
									<label>
										<input type="radio" value="2" name="wpActionType" >
										<?php echo $this->lang->line('setupOnlinePortfolio');?>                  
									</label>
								</li>
							</ul>
						<span class="sap_30"></span>
					</div>
					<!-- Form buttons -->
					<?php
					echo form_close();
					// set cancle url
					$data['cancleUrlType'] = 0;
					// set back url
					$data['backHistory'] = '1';
					// set next form name
					$data['formName'] = 'nextStepForm';
					$this->load->view('workProfile/wizardform/common_buttons',$data);
					?>
				</div>
			</div>
		</div>
	</div>
</div>	
