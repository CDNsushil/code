<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
// set base url
$baseUrl = base_url_lang('/workprofile');

$mediaNextStepForm = array(
    'name'=>'mediaNextStepForm',
    'id'=>'mediaNextStepForm'
);

$mediaIdInput = array(
    'name'	=> 'mediaId',
    'id'	=> 'mediaId',
    'value'	=> (isset($mediaId) && !empty($mediaId)) ? $mediaId : 0,
    'type'	=> 'hidden'
);
?>
<div class="newlanding_container">
    <div class="showcase_wizard">
        <div id="TabbedPanels1" class="TabbedPanels"> 
			<div class="TabbedPanelsContent wizard_wrap tab_setting width635 m_auto clearb">
				<div class="c_1 ">
						<h3><?php echo $this->lang->line('whatYouWantNow');?></h3>
						<?php echo form_open($baseUrl.'/setportfolionextaction',$mediaNextStepForm); ?>
							<div class="sap_30"></div>
							<div class="width164 fl"> Add another: </div> 
							 <ul class="defaultP fl listpb10">
								<li>
									<input type="radio" value="2" name="mediaType" checked='checked' >
									<?php echo $this->lang->line('mediaType2');?>                    
								</li>
								<li>
									<input type="radio" value="3" name="mediaType" >
									<?php echo $this->lang->line('mediaType3');?>                  
								</li>
								<li>
									<input type="radio" value="4" name="mediaType" >
									<?php echo $this->lang->line('mediaType4');?>                  
								</li>
								<li>
									<input type="radio" value="1" name="mediaType" >
									<?php echo $this->lang->line('mediaType1');?>                  
								</li>
								
								 <li class="or_text">OR</li>
								<li>
									<input type="radio" value="5" name="mediaType" >
									<?php echo $this->lang->line('createYourWP');?>                  
								</li>
								
								<li class="or_text "> OR </li>
								<li>
									<input type="radio" value="6" name="mediaType" >
									<?php echo $this->lang->line('shareYourWP');?>                  
								</li>
							</ul>
						
						<!-- Form buttons -->
						<?php
						echo form_input($mediaIdInput);
					echo form_close();
					// set back url
					$data['backPage'] = '/workprofile/portfoliotitlendesc/'.$mediaId.'/'.$mediaType;
					// set next form name
					$data['formName'] = 'mediaNextStepForm';
					$this->load->view('workProfile/wizardform/common_buttons',$data);
					?>
				</div>
			</div>
		</div>
	</div>
</div>	
<script>
	
    /*$(document).ready(function() {
        // manage employment submit form
		$("#mediaTypeForm").validate({
            submitHandler: function() {
                var fromData=$("#mediaTypeForm").serialize();
                $.post('<?php echo $baseUrl.'/setreferences';?>',fromData, function(data) {
                    if(data){
                        window.location.href = data.nextStep; 
                    }
                }, "json");
            }
        });
    });*/
</script>
