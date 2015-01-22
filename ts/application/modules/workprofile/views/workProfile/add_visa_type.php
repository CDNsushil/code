<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php
if(!isset($workProfileId) || $workProfileId==0)
{
?>
<div class="row opacity_4">
	<div class="cell tab_left">
		<div class="tab_heading">
			<?php echo $this->lang->line('visaAvailable'); ?>
		</div><!--tab_heading-->
	</div>
	<div class="cell tab_right">
		<div class="tab_btn_wrapper">
			<div class="tds-button-top"> 
				<!-- Education toggle Icon -->							
				<a  class="formTip" >					
					<span><div class="projectToggleIcon" id="visaToggleIcon" toggleDivId="VISA-Content-Box" ></div></span>
				</a>
			</div>
		</div>
	</div>
</div><!--row-->
<?php
}
else{

	$formName = "addVisaType";
	
	$formAttributes = array(
		'name'=>$formName,
		'id'=>$formName
	);				
		
	$visaCountry = array(
		'name'	=> 'countryId',
		'id'	=> 'visaCountryId',
		'class'	=> 'BdrCommon width90px formTip visaInfoUpdate',
		'title'=>  $this->lang->line('profileCountry'),
		'value'	=> '',
		'placeholder'	=> $this->lang->line('profileCountry'),
		//'minlength'	=> 2,
		'maxlength'	=> 50,
		'size'	=> 10,
		'onchange' => 'checkvisaCountry();'
	);
	
	$visaType = array(
		'name'	=> 'visaType',
		'id'	=> 'visaType',
		'class'	=> 'BdrCommon width_232 formTip visaInfoUpdate',
		'title'=>  $this->lang->line('visaType'),
		'value'	=> '',
		'placeholder'	=> $this->lang->line('visaType'),
		'maxlength'	=> 50,
		'size'	=> 20,
		'onchange' => 'checkvisaType();'
	);
?>
<?php //echo form_open(base_url(lang().'/workprofile/saveVisaType'),$formAttributes); ?>	
<div class="row ">
	<div class="cell tab_left">
		<div class="tab_heading">
			<?php echo $this->lang->line('visaS'); ?>
		</div><!--tab_heading-->
	</div>
	<div class="cell tab_right">
		<div class="tab_btn_wrapper">
			<div class="tds-button-top"> 
				<!-- Education toggle Icon -->							
				<a  class="formTip" >					
					<span><div class="projectToggleIcon" id="visaToggleIcon" toggleDivId="VISA-Content-Box" ></div></span>
				</a>
			</div>
		</div>
	</div>
</div><!--row-->	<div class="clear"></div>
	<div id="VISA-Content-Box" class="frm_strip_bg">	
		<div class="row"><div class="tab_shadow"></div></div>
		<input type="hidden" id="visaId" value="0" />
		<input type="hidden" id="replaceVisaId" value="0" />		
			<div class="row" id="categoryDiv">
				<div class="empty_label_wrapper cell"><?php //echo $this->lang->line('visaInformation');?></div>
				<!--label_wrapper-->
				<div class="cell frm_element_wrapper" style="display:block;">		
						<div class="cell ">
							<div class="profileDropDown">
								
								<?php 
								echo form_dropdown($visaCountry['name'] , $countries, '','id="visaCountryId" class="" onchange="checkvisaCountry()"'); //, 'onclick="selectBox()"'  
								?>
								<div id="visaCountryError" class="dn"><label class="error"><?php echo $this->lang->line('thisReqField');?></label></div>	
							</div>
						</div>
						<div class="cell widthSpacer">&nbsp;</div>
						<div class='tar fl width_232'>				
							<div class="row"><?php echo form_input($visaType); ?></div>
							<?php echo form_error($visaType['name']); ?>
							<?php echo isset($errors[$visaType['name']])?$errors[$visaType['name']]:''; ?>
							<div id="visaTypeError" class="dn"><label class="error"><?php echo $this->lang->line('thisReqField');?></label></div>
						</div>
						<div class="cell widthSpacer">&nbsp;</div>
						<div class="cell widthSpacer">&nbsp;</div>
						<div class="cell cat_btn ml15">
						<?php /*
							
							//echo anchor('javascript://void(0);','<span><div id="addVisaButton" class="cat_plus_icon"></div></span>',array('class'=>'formTip go fl',
							//'title'=>$this->lang->line('save').' '.$this->lang->line('education'),
							//'onclick'=>"addVisaType('".base_url(lang().'/workprofile/saveVisaType')."','visaTypeInfo',$('#visaId').val(),'".$workProfileId."',$('#visaCountryId').val(),'loadImg',$('#visaType').val(),$('#replaceId').val());"));	
							echo anchor('javascript://void(0);','<span><div id="addVisaButton" class="cat_edit_icon"></div></span>',array('class'=>'formTip go fl',
							'title'=>$this->lang->line('save').' '.$this->lang->line('education'),
							'onclick'=>"addVisaType();"));	
							//echo '<div id="catCancel" class="dn">';
							echo anchor('javascript://void(0);','<span><div id="visaCancel" class="cat_cross_icon"></div></span>',array('class'=>'formTip go fl dn',
							'title'=>$this->lang->line('cancel'),
							'onclick'=>"visaCancel();",
							'id'=>'visaCancel',
							'style'=>''));	
						*/ ?>
						</div>
						
						<div class="cell pt5 pl8">
						
						<div class="small_btn mr0">
							<?php
							echo anchor('javascript://void(0);','<span><div id="visaCancel" class="cat_smll_cancel_icon"></div></span>',array('class'=>'formTip go fl dn',
							'title'=>$this->lang->line('cancel'),
							'onclick'=>"visaCancel();",
							'id'=>'visaCancel',
							'style'=>'display:none'
							));	 ?>
							
							
						</div>
						
						<div class="small_btn mr0">
							<?php
							echo anchor('javascript://void(0);','<span><div id="addVisaButton" class="cat_smll_save_icon"></div></span>',array('class'=>'formTip go fl',
							'title'=>$this->lang->line('save'),
							'onclick'=>"addVisaType();"));	?>						
							
							
						</div>					
						
						
						
					</div>
				</div><!-- End insidecategory -->
			</div><!--End categoryDiv-->
			<div id="VISATYPE-Content-Box" style="display:block;">					
				<?php 
					//This shows posts related with blog
					echo Modules::run("workprofile/visaTypeList",$workProfileId); 
				?>	

				<input type="hidden" id="countVisaType" value="<?php echo $countVisaType;?>" />
				<input type="hidden" id="delId" name="delId" value="" />
			</div>
		<div class="seprator_10 row"></div>
	</div>
<div class="row">
<div class="tab_shadow"></div>
<div class="clear"></div>

</div>

<script type="text/javascript">	


	//$(document).ready(function() {
	//$('.visaInfoUpdate').bind("keydown", function(visal) {
	//console.log(l.keyCode);
	//if (visal.keyCode == 13) {
	//addVisaType();
	// return true;
	//} 
	// else 
	//{
	//return true;
	//}
	//});
	//});	

	
	function checkvisaCountry()
	{
		if($('#visaCountryId').val()!='') $('#visaCountryError').hide();
		else $('#visaCountryError').show();
	}
	
	function checkvisaType()
	{
		if($('#visaType').val()!='') $('#visaTypeError').hide();
		else $('#visaTypeError').show();
	}	
	
	function addVisaType()
	{
		
		$('#visaCountryId').addClass('required');
		$('#visaType').addClass('required');
		url = '<?php echo base_url(lang().'/workprofile/saveVisaType');?>';
		var DivID = 'visaTypeInfo';
		var val1 = $('#visaId').val();  
		var val2 = $('<?php echo $workProfileId;?>').val();  
		var val3 = $('#visaCountryId').val();  
		var val4 = 'loadImg';  
		var val5 = $('#visaType').val();  
		var val6 = $('#replaceVisaId').val();  
		 
		var val7 = val6;
		
		if(val3=='') {
			$('#visaCountryError').show();
			$('#visaCountryId').focus();
			//$('#visaCountryId').addClass("required");
		}
		
		if(val5=='') {
			$('#visaTypeError').show();
			$('#visaType').focus();
			//$('#visaType').addClass("required");
		}		
				
		if(val3 != '' && val5 != '')
		{
			
			AJAX(url,DivID,val1,val2,val3,val4,val5,val6,val7);
			
			$('#visaId').attr('value',0);
			$('#visaCountryId').attr('value','');
			$('#visaType').attr('value','');
			if($('#addVisaButton').hasClass('cat_smll_edit_icon'))
			{
				$('#addVisaButton').removeClass('cat_smll_edit_icon');
				$('#addVisaButton').addClass('cat_smll_save_icon');
			}
			$('#workVisaType').show();	
			$('#visaCancel').hide();	
		}
		else 
		{ 
			//alert('<?php echo  $this->lang->line('requiredMsg'); ?>');
			$('#visaCountryId').focus();
			setSeletedValueOnDropDown('visaCountryId','Select Country');
		}			
	}
		
		
	function visaCancel()
	{
		$('#visaId').attr('value',0);
		$('#visaCountryId').attr('value','');
		$('#visaType').attr('value','');

		if($('#addVisaButton').hasClass('cat_smll_edit_icon'))
		{
			$('#addVisaButton').removeClass('cat_smll_edit_icon');
			$('#addVisaButton').addClass('cat_smll_save_icon');
		}
		$('#visaCancel').hide();
		setSeletedValueOnDropDown('visaCountryId','Select Country');	
	}
	
	function removeVisaTypeRow(removeId,flag)
	{
		var delId = $('#delId').attr("value");
		

		var userVisaDelId = $('#useVisaDelId_'+removeId).val();
		
		
		
		if(flag==1)
		{
			alert('<?php echo  $this->lang->line('categoryRelated'); ?>');
			return false;
		}
		else
		{
			var conBox = confirm('<?php echo  $this->lang->line('categoryDelMsg'); ?>');
			if(conBox)
			{						
				if(delId == '')
				{
					delId = userVisaDelId;
				}
				else 
					delId = delId+','+userVisaDelId;
				
				$('#delId').attr('value',delId);
				
				$('#removeVisaID_'+removeId).remove();
			
			}
			else
			{
				return false;
			}
		}		
	}

</script>
<?php 
}// End If
?>
