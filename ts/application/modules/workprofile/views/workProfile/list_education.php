<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<div class="row <?php if($countEducation<=0)echo ' dn';?>" id="workProEducation">	
	<div class="cell empty_label_wrapper"></div>
	
		<div class="cell frm_element_wrapper">
			<ul class="profile_li_wp">
			<div id="educationInfo">
			<?php
			for($icat=1;$icat<=$countEducation;$icat++)
			{
				$nodelete =0;
				
			?>				
					<li  id="removeID_<?php echo $educationValues[$icat-1]->educationId;?>">
					
					<div class="cell pro_li_content_wp extract_content_bg_PR width_567px pt5" >
						<div class="cell width70px  ml40">
							<?php
							
							//Education Title
							echo $educationValues[$icat-1]->year_from;				               
							?>
							</div><!--div cell-->	
							
							<div class="cell width70px">
							<?php
							
							if(isset($educationValues[$icat-1]->year_to) && $educationValues[$icat-1]->year_to !== '')
							echo $educationValues[$icat-1]->year_to;
							else
								echo '&nbsp;';				               
							?>
							</div><!--div cell-->	
							
							
							
							
							<div class="cell width170px">
							<?php
							
							//Education University
							if(isset($educationValues[$icat-1]->university) && $educationValues[$icat-1]->university !== '')
								echo $educationValues[$icat-1]->university;	
							else
								echo '&nbsp;';
							?>
							</div><!--div cell-->
							<div class="cell width170px">
							<?php
							
							//Education Degree
							if(isset($educationValues[$icat-1]->degree) && $educationValues[$icat-1]->degree !== '')
								echo $educationValues[$icat-1]->degree;	
							else
								echo '&nbsp;';
							
							?>
							</div><!--div cell-->						
								<div class="pro_btns">
								<?php 
								
								$delId = $icat-1;									
								if($countEducation>0)
								{
								?>
									<?php /*<div class="small_btn"><a class=" formTip" onmousedown="mousedown_small_button(this)" onmouseup="mouseup_small_button(this)" Title="<?php echo $this->lang->line('delete');?>" onclick="removeEducationRow('<?php echo $delId;?>','<?php echo $nodelete;?>')"><span><div class="cat_smll_plus_icon"></div></span></a></div><!--small_cross_btn_wp-->*/?>
									
									<div class="small_btn"><a class="formTip" title="<?php echo $this->lang->line('delete')?>" href="javascript:void(0)" onclick="deleteTabelRow('<?php echo $educationTableName;?>','<?php echo $eduElementId;?>',<?php echo $educationValues[$icat-1]->educationId;?>,'','','#removeID_','','',0,'',1)"><div class="cat_smll_plus_icon"></div></a></div>				
								<?php
								}
								?>
								
								<div class="small_btn"><a class="formTip" title="<?php echo $this->lang->line('edit')?>" onclick="EditEducation('<?php echo $educationValues[$icat-1]->year_from;?>','<?php echo $educationValues[$icat-1]->year_to;?>','<?php echo $educationValues[$icat-1]->educationId;?>','<?php echo $educationValues[$icat-1]->university;?>','<?php echo $educationValues[$icat-1]->degree;?>','<?php echo $educationValues[$icat-1]->educationId;?>')"><span><div class="cat_smll_edit_icon"></div></span></a></div><!--small_cross_btn_wp-->							
								
								<input type="hidden" id="useDelId_<?php echo $icat-1;?>" value="<?php echo $educationValues[$icat-1]->educationId;?>" />
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
function EditEducation(year_from,year_to,educationId,educationUniversity,educationDegree,replaceId)
{
		var educationId = educationId;
		var educationYearFrom =year_from;
		var educationYearTo = year_to;
		var educationUniversity = educationUniversity;
		var educationDegree = educationDegree;
		var replaceId = replaceId;		

		if($('#addCatButton').hasClass('cat_smll_save_icona'))
		{
			$('#addCatButton').removeClass('cat_smll_save_icon');
			$('#addCatButton').addClass('cat_smll_edit_icon');
		}
				
		$('#replaceId').val(replaceId);
		$('#educationId').val(educationId);
		$('#educationUniversity').val(educationUniversity);	
		$('#educationDegree').val(educationDegree);	
		$('#educationYear').val(educationYearFrom);	
		$('#educationYearTo').val(educationYearTo);	
		
		setSeletedValueOnDropDown('educationYear',educationYearFrom);
		setSeletedValueOnDropDown('educationYearTo',educationYearTo);
		
		//selectBox();
		$('#catCancel').show();	
		
}
</script>
