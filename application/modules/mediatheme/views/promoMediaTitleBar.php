<span class="clear_seprator "></span>
<div class="title-content" style="width:742px">
	<div class="title-content-left">
		<div class="title-content-right">
			<div class="title-content-center"  onmouseover="this.style.cursor='pointer'" >
				<div class="title-content-center-label"  style="width:677px">
					<?php echo $label['PROMOTIONALIMAGE'].$label['10_images']; ?>
				</div>
				<div class="tds-button-top"> 
					<?php 
					if($count>=10){if($count!=100){
						echo "Can not add more than 10 records! ";
					}}else
					{
						echo anchor('javascript://void(0);', '<span><div class="projectAddIcon"></div></span>',array('class'=>'formTip','title'=>$label['add'],'onclick'=>'showRelatedForm(\'PROMOTIONALIMAGEForm-Content-Box\',\'PROMOTIONALIMAGE-No-Records\',\'mediaTitle\',\'mediaId\',\'BrowserHiddenPromo\',\'PromoFileField\',\'mediaDescription\');$(\'#PROMOTIONALIMAGE-Content-Box\').show();'));
					}
					?>
				</div>
				<div class="toggleAdditionalInfo" toggleDivId="PROMOTIONALIMAGE-Content-Box"  toggleDivRecords="PROMOTIONALIMAGE-No-Records" toggleDivForm="PROMOTIONALIMAGEForm-Content-Box"  align="right">
					<img src="<?php echo base_url();?>images/icons/down_arrow.png" border="0" class="formTip" title="<?php echo $label['PROMOTIONALIMAGE']; ?>"/>
				</div>
			</div><!-- End class="title-content-center" -->
		</div><!-- End title-content-right-->
	</div><!-- End title-content-left-->
</div><!-- End title-content-->
