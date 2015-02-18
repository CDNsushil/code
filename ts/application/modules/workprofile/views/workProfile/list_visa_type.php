<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<div class="row<?php if($countVisaType<=0)echo ' dn';?>" id="workVisaType">
	<div class="cell empty_label_wrapper"></div>
		<div class="cell frm_element_wrapper">
			<ul class="profile_li_wp ">
			<div id="visaTypeInfo">
			<?php
			for($iVisa=1;$iVisa<=$countVisaType;$iVisa++)
			{
				$nodelete =0;
				?>
				
					<li  id="removeVisaID_<?php echo $visaTypeValues[$iVisa-1]->visaId;?>">
					
					<div class="cell pro_li_content_wp extract_content_bg_PR width_567px pt5" >
						<div class="cell width228px  ml40">
							<?php
							
							//Education Title
							echo getCountry($visaTypeValues[$iVisa-1]->countryId);				               
							?>
							</div><!--div cell-->	
							<div class="cell width174px">
							<?php
							
							//Education University
							if(isset($visaTypeValues[$iVisa-1]->visaType) && $visaTypeValues[$iVisa-1]->visaType !== '')
								echo $visaTypeValues[$iVisa-1]->visaType;	
							else
								echo '&nbsp;';
							?>
							</div><!--div cell-->
												
								<div class="pro_btns width_216 fr mr12">
									<?php 
									
									$delId = $iVisa-1;									
									if($countVisaType > 0)
									{
									?>
										<?php /*<div class="small_btn"><a class=" formTip" onmousedown="mousedown_small_button(this)" onmouseup="mouseup_small_button(this)" Title="<?php echo $this->lang->line('delete');?>" onclick="removeVisaTypeRow('<?php echo $delId;?>','<?php echo $nodelete;?>')"><span><div class="cat_smll_plus_icon"></div></span></a></div><!--small_cross_btn_wp-->*/?>
									
									<div class="small_btn"><a class="formTip" title="<?php echo $this->lang->line('delete')?>" href="javascript:void(0)" onclick="deleteTabelRow('<?php echo $visaTableName;?>','<?php echo $visaElementId;?>',<?php echo $visaTypeValues[$iVisa-1]->visaId;?>,'','','#removeVisaID_','','',0,'',1)"><div class="cat_smll_plus_icon"></div></a></div>									
									<?php
									}
									?>
									
									<div class="small_btn"><a class=" formTip" title="<?php echo $this->lang->line('edit')?>" onclick="EditVisaType('<?php echo $visaTypeValues[$iVisa-1]->visaId;?>','<?php echo $visaTypeValues[$iVisa-1]->countryId;?>','<?php echo $visaTypeValues[$iVisa-1]->visaType;?>','<?php echo $visaTypeValues[$iVisa-1]->visaId;?>')"><span><div class="cat_smll_edit_icon"></div></span></a></div><!--small_cross_btn_wp-->							
									
									<input type="hidden" id="useVisaDelId_<?php echo $iVisa-1;?>" value="<?php echo $visaTypeValues[$iVisa-1]->visaId;?>" />
								</div>		
					</div><!-- removeID -->
					
					</li>
					
				<?php
			}//End For
			?>	
			</div>
		</ul>
		</div><!-- frm_element_wrapper-->
	
</div>
			  
<script language="javascript" type="text/javascript">
function EditVisaType(visaId,visaCouuntry,visaType,replaceVisaId)
{
		var visaId = visaId;
		var visaCountry = visaCouuntry;
		var visaType = visaType;
		
		var replaceVisaId = replaceVisaId;
		
		if($('#addVisaButton').hasClass('cat_smll_save_icona'))
		{
			$('#addVisaButton').removeClass('cat_smll_save_icon');
			$('#addVisaButton').addClass('cat_smll_edit_icon');
		}
				
		$('#replaceVisaId').val(replaceVisaId);
		$('#visaId').val(visaId);
		$('#visaCountryId').val(visaCountry);	
		setSeletedValueOnDropDown('visaCountryId',visaCountry);
		$('#visaType').val(visaType);	
		//selectBox();
		
		$('#visaCancel').show();	
		
}
</script>
