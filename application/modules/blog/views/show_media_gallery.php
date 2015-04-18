
<div id="YesNoBoxWp" class="customAlert" style="display:none; width:430px;">
	<div id="close-YesNoBox" title="" class="tip-tr close-customAlert"></div>			
	<div class="row">
		<div class="cell"><?php echo $label['msgBeforeDelete'];?></div> 
	</div>
	<div class="row">
		<div class="cell">
			<div class="tds-button floatRight">
				<?php echo anchor('javascript://void(0);', '<span>Yes</span>',array('onclick'=>'deleteGallery(\'t\');','onmousedown'=>'mousedown_tds_button(this);','onmouseup'=>'mouseup_tds_button(this);')); ?>
			</div>
		</div>
		<div class="cell">
			<div class="tds-button floatRight">
				<?php echo anchor('javascript://void(0);', '<span>No</span>',array('onclick'=>'noGallery();','onmousedown'=>'mousedown_tds_button(this);','onmouseup'=>'mouseup_tds_button(this);')); ?>
			</div>
		</div>
	</div>
</div>

<div class="row form_wrapper"  >

	<div class="row" >
		<div class="cell frm_heading">
			<h1><?php echo $label['images'];?></h1>
		</div>
		<?php echo Modules::run("blog/navigationMenu"); ?>		
	</div>

<!-- Promo Image View -->

 <div class="row ">
	<div class="cell tab_left">
		<div class="tab_heading">
			<?php echo $this->lang->line('images'); ?>
		</div><!--tab_heading-->
	</div>
	<div class="cell tab_right">
		<div class="tab_btn_wrapper">
			
			<div class="tds-button-top" >
				<?php 				
				 
				$attr = array("onclick"=>"showBrowse();","toggledivicon"=>"eventpromoToggleIcon","toggledivform"=>"PromoForm-Content-Box","toggledivid"=>"EventPromo-Content-Box","class"=>"formTip formToggleIcon");
				echo anchor('javascript://void(0);', '<span><div class="projectAddIcon"></div></span>',$attr);
			
				if($countGalImg > 0)
					{
					?>
					<a href="javascript:void(0);" onclick="showYesNo();" class="formTip" Title="<?php echo $label['Delete'];?>">
						<span>
							<div class="projectDeleteIcon"></div>
						</span>
					</a> 
				<?php }	?>
		<a class="formTip" Title="">					
		<span>
			<div toggledivid="EventPromo-Content-Box" id="eventpromoToggleIcon" class="projectToggleIcon"></div></span>
			</a>
			</div>
			
		</div>
	</div>
</div><!--row-->	
	<div class="clear"></div>
	<div id="EventPromo-Content-Box" class="frm_strip_bg">		
		<div class="row"><div class="tab_shadow"></div></div>
		<div id="PromoForm-Content-Box" class="row dn">
		<div class="upload_media_left_top row"></div>
		
		<?php echo Modules::run("blog/postMediaGalleryForm"); ?>
		
	<div id="EventPromo-Content">
		<div class="row">		
			<div class="label_wrapper cell bg_none">
				<label class="bg_none"><?php //echo $label['images']  ?></label>
			</div><!--label_wrapper-->
			<div class="cell frm_element_wrapper">
				<?php echo Modules::run("blog/mediaGalleryList"); ?>	
			</div><!-- END cell frm_element_wrapper -->	
		</div><!-- END row -->		
	</div> <!-- EventPromo-Content -->
	
	<div class="clear"></div>
	<div class="seprator_10 row"></div>
 </div>

<div class="row">
<div class="tab_shadow"></div>
</div>
</div>


<script language="javascript" type="text/javascript">

function canceltoggleBlog(toggleFlag)
{ 
  
  if(toggleFlag==0)
	$("#showGalForm").slideUp("slow");
  
  if(toggleFlag ==1)
   $("#showGalForm").slideDown("slow");

}

//Functionality for "YES" button of prompt
function deleteGallery(confirmflag){
	if(confirmflag=='t') document.GalleryAction.submit();
	else $('#YesNoBoxWp').trigger('close');			
}

//Functionality for "NO" button of prompt
function noGallery(){
	$('#YesNoBoxWp').trigger('close');	
}

function showBrowse(){	
	$('#browse_button').show();
}

//Delete the selected gallery image if no gallery is selected alert with message
function showYesNo()
{
	var n = $("input:checked").length;
	if(n>0){
		$("#YesNoBoxWp").lightbox_me('center:true');
	}else{
		alert('Please tick the checkbox(s) to delete');
		return false;
	}
}

function toggleChecked() {
	//alert('I am clicked');
	//$(this).addClass("ez-checked");
}

</script>
