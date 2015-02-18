<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$defaultImage = $this->config->item('defaultUpcomingImg_s');
?>

<div class="row form_wrapper position_relative">

	<div class="row">
		<?php if($this->uri->segment(3)=='' || $this->uri->segment(3)!='deletedItems') { ?>
		<div class="cell frm_heading">
			<h1><?php echo $this->lang->line('indexPage');?></h1>
		</div>
		<?php } ?>
		<?php echo $header; ?>
	</div>
	
	<div class="row ">
	<?php	 
	//LEFT SHADOW STRIP
	echo Modules::run("common/strip");
	
	echo form_open('upcomingprojects/deleteUpcomingProejct/' ,"name='upcomingprojects'");
	echo form_hidden('projId','');
	echo form_close();
	?>
	
	
	<?php
	$count = 0;
	if(isset($recodrSetUpcomingProejct) && is_array($recodrSetUpcomingProejct) && count($recodrSetUpcomingProejct) > 0){
		echo "<div id='elementListingAjaxDiv' class='row'>";
			$this->load->view('upcoming_listing' , array('recodrSetUpcomingProejct'=>$recodrSetUpcomingProejct) );
		echo "</div>";
	}else{ ?>
		<div class="blog_box_wrapper">
			<div class="row">
				<div class=" cell width_200 Cat_wrapper" >
					<?php 
						
					
					echo Modules::run("common/imageSlider",'',0,$defaultImage);
					?>				
				</div>
			
			<div class="cell width_569 margin_left_16">
					<?php
					$sectionId = $this->config->item('upcomingSectionId');
					$newsHref = "javascript:getUserContainers(\"".$sectionId."\",\"/upcomingprojects/newupcomingprojects\");";
					//echo "<span class='tac'>".$this->lang->line('noRecord')."</span>";?>
				</div>
			</div>
		</div><?php
	}
	?>
	
	</div><!-- position_relative-->
	<div class="clear"></div>
</div>

<div class="videoLightBoxWp" id="videoLightBoxWp" style="display:none;">
	<div id="close-postPreviewBox" class="tip-tr close-customAlert" original-title=""></div>
	<div class="productFormContainer1" id="productFormContainer1"></div>
</div>
<div class="workLightBoxWpNew" id="workLightBoxWpNew" style="display:none">
	<div id="close-previewWorkBox" class="tip-tr close-customAlert" original-title=""></div>
	<div class="productFormContainer" id="productFormContainer"></div>
</div>

<script type="text/javascript">
function DeleteAction(projId)
{
	var conBox = confirm('<?php echo $this->lang->line('sureDelMsg')?>');
	if(conBox){
		document.upcomingprojects.projId.value = projId;
		document.upcomingprojects.submit();
	}else{
		return false;
	}
}

function DeletePermanentlyAction(projId)
{
	var conBox = confirm('<?php echo $this->lang->line('sureDelMsg')?>');
	if(conBox){
		location.href=baseUrl+language+"/upcomingprojects/deletePermanently/"+projId;
	}else{
		return false;
	}
}
function restoreRecord(projId)
{
	var conBox = confirm('Are you sure to restore this record?');
	if(conBox){
		location.href=baseUrl+language+"/upcomingprojects/restoreRecord/"+projId;
	}else{
		return false;
	}
}

	function imageSlider(imageSliderInfo)
	{
		//$('#imageviewer').attr('src', "/promo_material/popupimage/"+imageSliderInfo.toString());
		lightBoxWithAjax('popupBoxWp','popup_box','/promo_material/popupimage',imageSliderInfo);
		
	}
</script>
