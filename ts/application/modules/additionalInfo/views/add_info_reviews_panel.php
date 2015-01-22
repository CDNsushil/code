<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	$addInfoSection='';
	//addInfoSection in empty then set the last uri segment
	$addInfoSection = end($this->uri->segments);  
	
	$reviewSection=isset($reviewDisplayStyle)?$reviewDisplayStyle:'dn';
	$toggle_icon='';
	
	if(strcmp(@$addInfoSection,'reviews')==0){
		
		$reviewSection='';
		$toggle_icon='toggle_icon';
	}
	$ownerId =isset($ownerId)?$ownerId:isLoginUser();
	$userId =isLoginUser();
	?>
<div class="row ">
	<div class="cell tab_left">
		<div class="tab_heading">
			<?php echo $label['ExternalReviews']; ?>
		</div><!--tab_heading-->
	</div>
	<div class="cell tab_right">
		<div class="tab_btn_wrapper">
			<div class="tds-button-top"> 
				<!-- Post add Icon -->
				<?php if($userId ==$ownerId ){?>
				<a id="AddLinkreviews" class="formTip formToggleIcon" title="<?php echo $label['add'];?>" toggleDivId="REVIEWS-Content-Box" toggleDivForm="REVIEWSForm-Content-Box" toggleDivIcon="reviewToggleIcon">
					<span><div id="AddIconreviews" class="projectAddIcon"></div></span>
				</a>
				<?php } ?>
				<!-- Post Edit Icon
				<a class="formTip"  title="Edit">
					<span><div class="projectEditIcon"></div></span>
				</a>		
				 -->	
				<!-- Post Delete Icon 
				<a  class="formTip" onclick="deleteTabelRow('AddInfoReviews','reviewId',0,'','.checkBoxReview','#rowReview')">
					<span><div class="projectDeleteIcon"></div></span>
				</a>
				-->
				<a  class="formTip">
					<span><div class="projectToggleIcon <?php echo $toggle_icon?>" id="reviewToggleIcon" toggleDivId="REVIEWS-Content-Box"></div></span>
				</a>
			</div>
		</div>
	</div>
</div><!--row-->
<div class="clear"></div>
<div class="form_wrapper toggle frm_strip_bg <?php echo $reviewSection;?>" id="REVIEWS-Content-Box">
	<div class="row"><div class="tab_shadow"></div></div>
	<?php 
	$data['entityId'] = $entityId;
	$data['elementId'] = $elementId;
	$data['returnUrl'] = $returnUrl;	
	$data['ownerId'] = $ownerId;	
	$data['userId'] = isLoginUser();
	if($userId ==$ownerId ){?>
	<div class="row dn" id="REVIEWSForm-Content-Box">
		<?php 
			
			$this->load->view('additionalInfo/review_form',$data);
			//echo Modules::run("additionalInfo/reviewForm",$entityId,$elementId,$returnUrl); 
		?>
	</div><!-- End Div NEWSForm-Content-Box -->	
	<?php } ?>
	<div class="row" id="ReviewContent"><!-- Show List Of News -->
		<?php  echo Modules::run("additionalInfo/listSectionReviews",$data); ?> 
	</div>
	<div class="clear"></div>
	<div class="seprator_25 clear"></div>
</div><!-- End Div "NEWSForm-Content-Box" -->
