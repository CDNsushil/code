<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!-- Promo Image View -->
 <div class="row ">
	<div class="cell tab_left">
		<div class="tab_heading">
			<?php  echo (isset($promoheading) && @$promoheading!='')?$promoheading:$this->lang->line('Promoheading'); ?>
		</div><!--tab_heading-->
	</div>
	<div class="cell tab_right">
		<?php  echo (isset($promomsg) && @$promomsg!='')?'<div class="cell mt7 ml10">'.$promomsg.'</div>':''; ?>
		<div class="tab_btn_wrapper">
			
			<div class="tds-button-top" >
				<a  class="formTip" >					
				<span><div class="projectToggleIcon" id="eventpromoToggleIcon" toggleDivId="EventPromo-Content-Box<?php echo $browseImgJs;?>" ></div></span>
				</a>
			</div>
			<?php if(@$showaddbutton==1){?>
			<div class="tds-button-top" id="addIcon"> 
				<a class="formTip" title="<?php echo  $this->lang->line('add');?>" onclick="canceltoggle(1);"  >
					<span><div class="projectAddIcon"></div></span>
				</a>
			</div>
			<?php } ?>
			
		</div>
	</div>
</div><!--row-->	
	<div class="clear"></div>
	<div id="EventPromo-Content-Box<?php echo $browseImgJs;?>" <?php echo (isset($strip) && @$strip==1)?'class="frm_strip_bg"':'';?> >		
		<div class="row"><div class="tab_shadow"></div>
	</div>
	<?php echo Modules::run("mediatheme/promoImageFormAcc",$promoImageId,'',$promoElementTable,$mediaType,$browseImgJs); ?>
	<div id="EventPromo-Content">
	<div class="row">					

		<div class="label_wrapper cell bg_none">
		</div>
				
		<div class="cell frm_element_wrapper pl0">
			<?php 
				$eventPromoImages['promoElementTable'] = $promoElementTable;
				$eventPromoImages['fileName'] = $promoEntityField;
				$defaultImage = $this->config->item('defaultImg');
				$Image = Modules::run("mediatheme/index",$promoImageId,'',$eventPromoImages); 
				echo $Image; 	
			?>
		</div><!-- END cell frm_element_wrapper -->
		
	   </div><!-- END row -->	
	
	</div> <!-- EventPromo-Content -->
	
	<div class="clear"></div>
	<div class="seprator_10 row"></div>
	</div> <!-- EventPromo-Content-Box -->
<?php if((isset($lastShadow) && @$lastShadow!=1) || (isset($strip) && @$strip==1)){ ?>
<div class="row"><div class="tab_shadow"></div></div>
<?php 
}

//$defaultImage = @$eventPromoImages['defaultImage'];
$defaultImage = $this->config->item('defaultImg');
?>
<script>
	
		
function canceltoggle(toggleFlag)
{
  var new_img_src = baseUrl+'<?php echo @$defaultImage;?>';
  var browseId = '<?php echo $browseImgJs;?>';
  if($('#rawFileNameContainerDiv'+browseId))
		$('#rawFileNameContainerDiv'+browseId).hide()
	if($('#uploadFileSection'+browseId))
		$('#uploadFileSection'+browseId).show()
	if($('#rawFileNameDiv'+browseId))
		$('#rawFileNameDiv'+browseId).html('');
		
	$('#promoImage<?php echo $browseImgJs;?>').attr('src',new_img_src);
	$('#mediaId<?php echo $browseImgJs;?>').val(0);
	$('#lastInsertedMediaId').val();
	$('#fileInput<?php echo $browseImgJs;?>').val('');
	$('#mediaTitle<?php echo $browseImgJs;?>').val('');
	$('#mediaDescription<?php echo $browseImgJs;?>').val('');
	$('#fileName<?php echo $browseImgJs;?>').val('');
	$('#fileSize<?php echo $browseImgJs;?>').val('');
	$('#fileId<?php echo $browseImgJs;?>').val(0);	
	$('#Uploadvideo<?php echo @$browseImgJs;?>').removeClass("dn");		
		
	$('#fileInput<?php echo $browseImgJs;?>').addClass('required');
  if(toggleFlag==0)
  {	
	$('#PromoForm-Content-Box<?php echo @$browseImgJs;?>').slideUp("slow");	
  }
  
  if(toggleFlag ==1)
  {
	
	$('#PromoForm-Content-Box<?php echo @$browseImgJs;?>').show();
	$('#EventPromo-Content-Box<?php echo @$browseImgJs;?>').slideDown("slow");	
		
  }
  
}
</script>
