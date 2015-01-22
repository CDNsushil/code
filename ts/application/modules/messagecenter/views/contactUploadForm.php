<script>
$(document).ready(function(){	
			$("#contactUploadForm").validate();	
});
</script>
<style>
#BrowserHiddenPromo  {
    height: 30px;
    opacity: 0;
    position: relative;
    text-align: right;
    width: 260px;
    z-index: 2;
}
</style>
<?php 
$formAttributes = array("name"=>'contactUploadForm','id'=>'contactUploadForm');
echo form_open_multipart($this->uri->uri_string(),$formAttributes);?>
	<div class="upload-Content-Box" id="importExportCSV">
		<div class="cell likeOrng">Upload Contact</div>
		<div class="row rowHeight40">
			<div class="cell orng_lbl" style="vertical-align:top;">Import contacts from .csv file </div>
				<div class="cell">
					<div class="row" >
						<div class="cell" style="padding-left:10px;">&nbsp;</div>
						<div class="cell dblBorder" style="background-color:#E9E9E9; min-height:100px; width:311px; padding:5px;">
						<div class="row" >
						<div class="cell" >Upload CSV file<span class="clear_seprator"></span></div>
						</div>
						<div class="row">
							<div class="cell" align="center">
								<div id="FileUpload">
									<input type="file" size="24" name="userfile" id="BrowserHiddenPromo" onchange="getElementById('PromoFileField').value = getElementById('BrowserHiddenPromo').value;" onmousedown="mousedown_tds_button(getElementById('browse_btn'));" onmouseup="mouseup_tds_button(getElementById('browse_btn'));" class="required error"/>
									<div id="BrowserVisible" style="width:300px">
										 <input type="text" id="PromoFileField" style="width:223px;" class="formTip Bdr4" title="<?php echo $label['uploadImage']; ?>"/><br />
										 <div class="tds-button" style="position:absolute; right:0; top:0;">
											<a id="browse_btn"><span>Browse</span></a>
										</div>
									</div>
								</div>
							</div>
						</div><!-- End row -->
						<div class="row">
							<div class="cell" align="left" style="padding-top:25px;"></div>
						</div><!-- End row -->
					</div>
				</div>
			</div><!-- End of cell for browse button and related text-box-->
		</div><!-- End row rowHeight40 -->
		<div class="row heightSpacer"></div>
		<?php echo form_hidden('go','Go');?>
		<div class="row">
			<!-- Shows Save button -->
			<div class="Btn_wp">
				<div class="btn_wp" style="margin-left:207px">
					<div class="button_left">
						<div class="button_right">
							<div class="button_text save">
								<?php echo form_submit('go', 'Save', ' class="border0 backgroundNone white bold"'); ?>
							</div>
						</div>
					</div>
				</div><!--submit_btn_wp-->
				<div class="btn_wp pl25">
					<div class="button_left">
						<div class="button_right">
							<div class="button_text save">
								<?php $data = array(
									'name' => 'button',
									'id' => 'button',
									'value' => 'true',
									'type' => 'reset',
									'content' => 'Cancel',
									'class'=> "border0 backgroundNone white bold",
									'onclick'=>"calcelUploadForm()",
								);
								echo form_button($data);
								 ?>
							</div>
						</div>
					</div>
				</div>
			</div><!-- End Save button -->
		</div>
		<a href="messagecenter/download">Click here</a> to find csv file format to upload contacts.
	</div>
<?php echo form_close();?>

<script type="text/javascript">
	function calcelUploadForm(){
		document.getElementById('upload-Content-Box').style.display = 'none';
		document.getElementById('importExportCSV').className = 'upload-Content-Box';
	}

	$(document).ready(function(){	
		$('#BrowserHiddenPromo').bind('change', function() {
			var ext = $('#PromoFileField').val().split('.').pop().toLowerCase();
			if($.inArray(ext, ['csv']) == -1){
				alert('Only csv extension is allowed');
				$('#BrowserHiddenPromo').attr({ value: '' }); 
				$('#PromoFileField').attr({ value: '' }); 
			}
		});	
	});
</script>
