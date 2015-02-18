<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$taxSettings=(isset($CTS->taxSettings) && is_numeric($CTS->taxSettings))?$CTS->taxSettings:1;
$taxPercentage=(isset($CTS->taxPercentage) && ($CTS->taxPercentage) > 0)?$CTS->taxPercentage:0;

$projectSpacificTax_popup=$this->load->view('counsumptiontax/projectSpacificTax_popup',array('taxPercentage'=>$taxPercentage),true);
$projectSpacificTax_popup=json_encode($projectSpacificTax_popup);
echo '<script> var projectSpacificTax ='.$projectSpacificTax_popup.';</script>';

$formAttributes = array(
				'name'=>'CTSform',
				'id'=>'CTSform',
				);
echo form_open($this->uri->uri_string(),$formAttributes); ?>
	<div id="consumptionTaxDiv" class="row">
		<div class="label_wrapper cell ">
			<label class="select_field"><?php echo $this->lang->line('consumptionTax');?></label>
		</div>
		<div class=" cell frm_element_wrapper ">	
				<div class="row">
					<div class="cell">
						<div class="defaultP mt2"><input type="radio" value="1" <?php if($taxSettings==1){echo 'checked';}?> name="taxSettings" onclick="if($('#taxSettingsHidden').val() != this.value){$('#CTSform').submit();}" ></div>
					</div>
					<div class="cell font_opensansSBold f11 ml5 mt3 mr10">
						<?php //echo $this->lang->line('useGlobalSettings');
						echo $this->lang->line('usePercentFrmSellerSettings');?>
						</div>
					<div class="cell">
						<div class="defaultP mt2"><input type="radio" value="2" <?php if($taxSettings==2){echo 'checked';}?> name="taxSettings" onclick="showPopup()" ></div>
					</div>
					<div class="cell font_opensansSBold f11 ml5 mt3 mr10">
						<?php //echo $this->lang->line('projectSpacific');
						echo $this->lang->line('prjSpecificPercent');
						?>
					</div>
					<?php /*<div class="cell">
						<div class="defaultP mt2"><input type="radio" value="0" <?php if($taxSettings==0){echo 'checked';}?> name="taxSettings" onclick="if($('#taxSettingsHidden').val() != this.value){$('#CTSform').submit();}"></div>
					</div>
					<div class="cell font_opensansSBold f11 ml5 mt3 mr10"><?php echo $this->lang->line('notRequired');?></div> */?>
					<div class="row f11 pt5">
				<?php echo $this->lang->line('checkYour').'<a href="'.base_url('dashboard/globalsettings').'" class="ptr dash_link_hover">'.$this->lang->line('SellerSetting').'</a>';?>
			</div>
				</div>
		</div>
		<input type="hidden" id="taxPercentage" name="taxPercentage" value="<?php echo $taxPercentage;?>" >
		<input type="hidden" id="entityId" name="entityId" value="<?php echo $entityId;?>" >
		<input type="hidden" id="elementId" name="elementId" value="<?php echo $elementId >0?$elementId:0;?>" >
		<input type="hidden" id="projectId" name="projectId" value="<?php echo $projectId>0?$projectId:0;?>" >
		<input type="hidden" id="taxSettingsHidden" name="taxSettingsHidden" value="<?php echo $taxSettings;?>" >
	</div>
<?php echo form_close(); ?>
<script>
	
	function showPopup(){
			loadPopupData('popupBoxWp','popup_box',projectSpacificTax);
			$('#CTP').val($('#taxPercentage').val());
	}
	$(document).ready(function(){	
		$("#CTSform").validate({
			  submitHandler: function() {
				$('html').animate({scrollTop:0}, 'slow');
				var fromData=$("#CTSform").serialize();
				var taxSettings=$("input[name='taxSettings']:checked").val();
				var taxSettingsHidden=$("#taxSettingsHidden").val();
				$('#taxSettingsHidden').val(taxSettings);
				$.post(baseUrl+language+'/counsumptiontax/counsumptiontaxSettings',fromData, function(data) {
					
					$('#messageSuccessError').html('<div class="successMsg"><?php echo $this->lang->line('msgSuccessfully');?> <?php echo $this->lang->line('updated');?></div>');
					timeout = setTimeout(hideDiv, 5000);
				});
			 }
		});
	});
</script>
