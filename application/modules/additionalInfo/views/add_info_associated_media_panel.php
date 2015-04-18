<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$addInfoSection=$this->uri->segment(7);
	
	$interviewSection='dn';
	$toggle_icon='';
	if($addInfoSection=='interviews'){
		$interviewSection='';
		$toggle_icon='toggle_icon';
	}
	
	?>
<div class="row ">
	<div class="cell tab_left">
		<div class="tab_heading">
			<?php echo $label['ASSOCIATEDMEDIAS']; ?>
		</div><!--tab_heading-->
	</div>
	<div class="cell tab_right">
		<div class="tab_btn_wrapper">
			<div class="tds-button-top"> 
				<!-- Post add Icon -->
				<!--<a class="formTip formToggleIcon" title="<?php //echo $label['add'];?>" toggleDivId="ASSOCIATEDMEDIASForm-Content-Box" toggleDivForm="INTERVIEWSForm-Content-Box" toggleDivIcon="intervToggleIcon">
					<span><div class="projectAddIcon"></div></span>
				</a>-->
				<!--
				<a  class="formTip" onclick="deleteTabelRow('AddInfoInterview','intervId',0,'','.checkBoxInterview','#rowInterview')" >
					<span><div class="projectDeleteIcon"></div></span>
				</a>
				-->
				<a  class="formTip" >
					<span><div class="projectToggleIcon <?php echo $toggle_icon?>" id="associatemediaToggleIcon" toggleDivId="ASSOCIATEDMEDIAS-Content-Box"  toggleDivRecords="ASSOCIATEDMEDIAS-No-Records" toggleDivForm="ASSOCIATEDMEDIASForm-Content-Box" ></div></span>
				</a>
			</div>
		</div>
	</div>
</div><!--row-->
<div class="clear"></div>
<div class="form_wrapper toggle frm_strip_bg <?php echo $interviewSection;?>" id="ASSOCIATEDMEDIAS-Content-Box">
	<div class="row"><div class="tab_shadow"></div></div>
	<div class="row dn" id="ASSOCIATEDMEDIASForm-Content-Box">
		<?php echo Modules::run("additionalInfo/associatedMediasList"); ?>
	</div><!-- End Div NEWSForm-Content-Box -->	
	<div class="row" id="associatedMediaContent"><!-- Show List Of News -->

		<?php echo Modules::run("additionalInfo/associatedMediasList"); ?>

	</div>
	
	<div class="clear"></div>
	<div class="seprator_10 row"></div>
</div><!-- End Div "NEWSForm-Content-Box" -->
<div class="row">
		<div class="tab_shadow"></div>
</div>
