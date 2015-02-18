<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	$addInfoSection='';
	//addInfoSection in empty then set the last uri segment
	
	$addInfoSection = end($this->uri->segments);
	
	
	$newsSection='dn';
	$toggle_icon='';
	
	
	if(strcmp(@$addInfoSection,'news')==0 ||  strlen($addInfoSection) <=4){
		$newsSection='';
		$toggle_icon='toggle_icon';
	}
	
	$ownerId =isset($ownerId)?$ownerId:isLoginUser();
	$userId =isLoginUser();
?>
<div class="row ">
	<div class="cell tab_left">
		<div class="tab_heading">
			<?php echo $label['NEWS']; ?>
		</div><!--tab_heading-->
	</div>
	<div class="cell tab_right">
		<div class="tab_btn_wrapper">
			<div class="tds-button-top"> 
				<?php if($userId ==$ownerId ){?>
				<!-- Post add Icon -->
				<a id="AddLinknews" class="formTip formToggleIcon" title="<?php echo $label['add'];?>" toggleDivId="NEWS-Content-Box" toggleDivForm="NEWSForm-Content-Box" toggleDivIcon="newsToggleIcon"  >
					<span><div id="AddIconnews" class="projectAddIcon"></div></span>
				</a>
				<?php } ?>
				<!-- Post Edit Icon
				<a class="formTip"  title="Edit">
					<span><div class="projectEditIcon"></div></span>
				</a>		
				 -->	
				<!-- Post Delete Icon 
				<a  class="formTip" onclick="deleteTabelRow('AddInfoNews','newsId',0,'','.checkBoxNews','#rowNews')" >
					<span><div class="projectDeleteIcon"></div></span>
				</a>
				-->
				<a  class="formTip" >
					<span><div class="projectToggleIcon <?php echo $toggle_icon?>" id="newsToggleIcon" toggleDivId="NEWS-Content-Box" ></div></span>
				</a>
			</div>
		</div>
	</div>
</div><!--row-->
<div class="clear"></div>
<div class="form_wrapper toggle frm_strip_bg <?php echo $newsSection;?>" id="NEWS-Content-Box">
	
	<div class="row"><div class="tab_shadow"></div></div>
	
	<?php 
	$data['entityId'] = $entityId;
	$data['elementId'] = $elementId;
	$data['returnUrl'] = $returnUrl;	
	$data['ownerId'] = $ownerId;	
	$data['userId'] = isLoginUser();
	if($userId ==$ownerId ){?>
	<div class="row dn" id="NEWSForm-Content-Box">
		<?php 
			
			$this->load->view('additionalInfo/news_form',$data);
			//echo Modules::run("additionalInfo/newsForm",$entityId,$elementId,$returnUrl); 
		?>
	</div><!-- End Div NEWSForm-Content-Box -->	
	<?php } ?>
	
	<div class="row" id="NewsContent"><!-- Show List Of News -->
		<?php  echo Modules::run("additionalInfo/listSectionNews",$data); ?> 
	</div>
	<div class="seprator_25 clear"></div>
</div><!-- End Div "NEWSForm-Content-Box" -->
