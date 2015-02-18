<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	$addInfoSection='';
	//addInfoSection in empty then set the last uri segment
	$addInfoSection = end($this->uri->segments);  
	
	$interviewSection='dn';
	$toggle_icon='';
	if(strcmp(@$addInfoSection,'interviews')==0){
		$interviewSection='';
		$toggle_icon='toggle_icon';
	}
	$ownerId =isset($ownerId)?$ownerId:isLoginUser();
	$userId =isLoginUser();
	?>
<div class="row ">
	<div class="cell tab_left">
		<div class="tab_heading">
			<?php echo $label['INTERVIEWS']; ?>
		</div><!--tab_heading-->
	</div>
	<div class="cell tab_right">
		<div class="tab_btn_wrapper">
			<div class="tds-button-top"> 
				<?php if($userId ==$ownerId ){?>
				<!-- Post add Icon -->
				<a id="AddLinkinterv" class="formTip formToggleIcon" title="<?php echo $label['add'];?>" toggleDivId="INTERVIEWS-Content-Box" toggleDivForm="INTERVIEWSForm-Content-Box" toggleDivIcon="intervToggleIcon">
					<span><div id="AddIconinterv" class="projectAddIcon"></div></span>
				</a>
				<?php }?>
				<!--
				<a  class="formTip" onclick="deleteTabelRow('AddInfoInterview','intervId',0,'','.checkBoxInterview','#rowInterview')" >
					<span><div class="projectDeleteIcon"></div></span>
				</a>
				-->
				<a  class="formTip" >
					<span><div class="projectToggleIcon <?php echo $toggle_icon?>" id="intervToggleIcon" toggleDivId="INTERVIEWS-Content-Box"></div></span>
				</a>
			</div>
		</div>
	</div>
</div><!--row-->
<div class="clear"></div>
<div class="form_wrapper toggle frm_strip_bg <?php echo $interviewSection;?>" id="INTERVIEWS-Content-Box">
	<div class="row"><div class="tab_shadow"></div></div>
	<?php 
	$data['entityId'] = $entityId;
	$data['elementId'] = $elementId;
	$data['returnUrl'] = $returnUrl;	
	$data['ownerId'] = $ownerId;	
	$data['userId'] = isLoginUser();
	if($userId ==$ownerId ){?>
	<div class="row dn" id="INTERVIEWSForm-Content-Box">
		<?php 
			
			$this->load->view('additionalInfo/interview_form',$data);
			//echo Modules::run("additionalInfo/interviewForm",$entityId,$elementId,$returnUrl); 
		?>
	</div><!-- End Div NEWSForm-Content-Box -->	
	<?php } ?>
	
	<div class="row" id="InterviewContent"><!-- Show List Of News -->
		<?php  echo Modules::run("additionalInfo/listSectionInterviews",$data); ?> 
	</div>
	<div class="clear"></div>
	<div class="seprator_25 clear"></div>
</div><!-- End Div "NEWSForm-Content-Box" -->
