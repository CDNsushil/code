<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
$browseid='';
?>
<div id="uploadFileByJquery<?php echo $browseid;?>"></div>
<div id="uploadElementForm<?php echo $browseid;?>" class="width320px row fr dn" >
	<div id="FileContainer<?php echo $browseid;?>"  class="fr">
		<div class="fileInfo" id="fileInfo<?php echo $browseid;?>">
			<div id="progressBar<?php echo $browseid;?>" class="plupload_progress">
				<div class="progressBar_msg fl"><?php echo $this->lang->line('fileUploading');?></div>
				<div class="plupload_progress_container fl"><div id="plupload_progress_bar<?php echo $browseid;?>" class="plupload_progress_bar"></div>
			</div>
		</div>
		<span id="percentComplete<?php echo $browseid;?>" class="percentComplete fl"></span></div>
		<div id="dropArea<?php echo $browseid;?>"></div>
	</div>
				
	
	<form enctype="multipart/form-data" toggledivform="uploadElementForm" id="uploadmediaForm<?php echo $browseid;?>" name="uploadmediaForm" accept-charset="utf-8" method="post" action="<?php echo base_url(lang().'/pressRelease/add_edit_PressReleaseNewsMaterial');?>" novalidate="novalidate">							
		<div class="row">
			<div class="fl">
				<label class="select_field">Title</label>
			</div>
			<div class=" fl">
				<input type="text" class="width246px required" id="fileTitle<?php echo $browseid;?>" value="" name="fileTitle">										<div class="row wordcounter"></div>
			</div>
		</div>

		
		<div class="clear"></div>
		<div class="row" >
			<div class="fl">
				<label class="select_field">File</label>
			</div>
			<div class="fl pl5" id="Uploadvideo<?php echo $browseid;?>"><input type="text" readonly id="fileInput<?php echo $browseid;?>" class="width170px required" value="" name="fileInput"></div>
			<div class="fl">
				<div id="browsebtn<?php echo $browseid;?>" class="tds-button fl ml5" style="position: relative; z-index: 0;"> <a onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" href="javascript:void(0);"><span>Browse</span></a></div>
				
			</div>
			<div class="clear"></div>
			<div class="row wordcounter orange" id="fileError<?php echo $browseid;?>"></div>
			<div class="seprator_5"></div>
		</div>
		
		<div class="clear"></div>

		<div class="row">
			<div class="fl width45px"> &nbsp;
				<input type="hidden" id="pressReleaseNewsId" value="" name="pressReleaseNewsId">
				<input type="hidden" id="id" value="" name="id">
				<input type="hidden" id="fileId" value="" name="fileId">
				<input type="hidden" id="fileName<?php echo $browseid;?>" value="" name="fileName">
				<input type="hidden" id="fileSize" value="0" name="fileSize">
				<input type="hidden" id="isExternal" value="f" name="isExternal">
			</div>
			<div class="fl">
				<div class="tds-button Fleft"><button onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" class="ajaxCancelButton dash_link_hover" type="button" id="AjaxcancelButton<?php echo $browseid;?>"><span><div class="Fleft">Close</div> <div class="icon-form-close-btn"></div></span></button></div>
				<div class="tds-button Fleft"><button class="dash_link_hover" onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" value="Save" name="submit" type="submit" id="saveButton<?php echo $browseid;?>"><span><div class="Fleft">Save</div> <div class="icon-save-btn"></div></span></button></div>
			</div>
		</div>
		
	</form>
	
	<div class="seprator_15 clear "></div> 
	<div class="line"></div>
	<div class="seprator_15 clear "></div> 
</div>


<script>
	$(document).ready(function(){
		uploadMediaFiles('<?php echo $mediaPath;?>','<?php echo $mediaFileTypes;?>','<?php echo $fileMaxSize;?>','<?php echo $browseid;?>',1,1,0,'','','_xs');
		
		$(".ajaxCancelButton").click(function(){
			var toggleDivForm = $(this).closest("form").attr('toggleDivForm');
			var toggleDivFormID = $(this).closest("form").attr('id');
			$('#'+toggleDivFormID)[0].reset();
			$('#'+toggleDivFormID+' form input[type=hidden]').val('');
			//$('#'+toggleDivFormID+': input').val('');
			$("#"+toggleDivForm).slideToggle('slow');
			
		});
		
		$("#uploadmediaForm").validate({
			submitHandler: function() {
				$('html').animate({scrollTop:0}, 'slow');
				var fromData=$("#uploadmediaForm").serialize();
				fromData = fromData+'&pressReleaseId=<?php echo $pressReleaseId;?>&section=<?php echo $section;?>';
				var url = baseUrl+language+'/pressRelease/add_edit_PressReleaseNewsMaterial';
				
				$.post(url,fromData, function(data) {
				
				  if(data){
					  $('#MediaFileIdDiv').html(data);
					  $("#uploadFileByJquery").click();
					  if($('#fileInput') && $('#fileInput').val() == ''){
						  refreshPge();
					 }
				  }
				});
			}
		});
	});
	
	function fillFormValue(data,formId){ 
		var pressReleaseId ='<?php echo $pressReleaseId;?>';
		if(pressReleaseId==0 || pressReleaseId == '0'){
			alert('Please First save the Press Release');
		}else{
			if(!$(formId).is(":visible")){
				$(formId).slideToggle('slow');
			}
			if(data == '0'){
				$(formId+' form')[0].reset();
				$(formId+' form input[type=hidden]').val('');
			}else{
				$.each(data, function(key, value){
				  $(formId+' form [name=' + key + ']').val(value);
				});
				if(data.pressReleaseNewsId && data.pressReleaseNewsId>0){
					$("#fileInput").attr('class', 'width170px');
				}else{
					$("#fileInput").attr('class', 'width170px required');
				}
			}
		}
	}
	
</script>
