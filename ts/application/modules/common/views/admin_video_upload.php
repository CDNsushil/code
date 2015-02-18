<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
$browseid='newsVideo';
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
				
	
	<form enctype="multipart/form-data" toggledivform="uploadElementForm<?php echo $browseid;?>" id="uploadmediaForm<?php echo $browseid;?>" name="uploadmediaForm" accept-charset="utf-8" method="post" action="<?php echo base_url(lang().'/pressRelease/add_edit_PressReleaseNewsMaterial');?>" novalidate="novalidate">							
		
		<div class="clear"></div>
		<div class="row pl45" >
				<div class="tds-button Fleft"><button onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" class="videoUploadButton orange_clr_imp" type="button" id="videoUploadButton"><span><div class="Fleft">Upload</div> <div class="icon-form-cancel-btn"></div></span></button></div>
				<div class="tds-button Fleft"><button onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" class="videoEmbedButton" type="button" id="videoEmbedButton"><span><div class="Fleft">Embed</div> <div class="icon-form-cancel-btn"></div></span></button></div>
			<div class="clear"></div>
			<div class="seprator_5"></div>
		</div>
		
		<div class="clear"></div>
		
		<div class="row" id="uploadField" >
			<div class="fl">
				<label class="select_field pt10">File</label>
			</div>
			<div class="fl pl5" id="Uploadvideo<?php echo $browseid;?>"><input type="text" readonly id="fileInput<?php echo $browseid?>" class="width170px required" value="" name="fileInput"></div>
			<div class="fl">
				<div id="browsebtn<?php echo $browseid?>" class="tds-button fl ml5" style="position: relative; z-index: 0;"> <a onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" href="javascript:void(0);"><span>Browse</span></a></div>
				
			</div>
			<div class="clear"></div>
			<div class="row wordcounter orange" id="fileError<?php echo $browseid?>"></div>
			<div class="seprator_5"></div>
		</div>
		
		
		<div class="row dn" id="embededField" >
			<div class="fl">
				<label class="select_field pt10 pr5">Embed</label>
			</div>
			<div class="fl" id="Embedvideocode"><textarea name="embbededURL" cols="45" rows="2" id="embbededURL" class="width225px rz embededURL required"></textarea></div>
			
			
			
			<div class="clear"></div>
			<div class="row wordcounter orange" id="fileError<?php echo $browseid?>"></div>
			<div class="seprator_5"></div>
		</div>
		
		<div class="clear"></div>

		<div class="row">
			<div class="fl width45px"> &nbsp;
				
				<input type="hidden" id="fileId<?php echo $browseid?>" value="" name="fileId">
				<input type="hidden" id="fileName<?php echo $browseid?>" value="" name="fileName">
				<input type="hidden" id="fileSize<?php echo $browseid?>" value="0" name="fileSize">
				<input type="hidden" id="isExternal<?php echo $browseid?>" value="f" name="isExternal">
			</div>
			<div class="fl">
				<div class="tds-button Fleft"><button onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" class="videoCancelButton dash_link_hover" type="button" id="AjaxcancelButton<?php echo $browseid?>"><span><div class="Fleft">Close</div> <div class="icon-form-close-btn"></div></span></button></div>
				<div class="tds-button Fleft"><button class="dash_link_hover" onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" value="Save" name="submit" type="submit" id="saveButton<?php echo $browseid?>"><span><div class="Fleft">Save</div> <div class="icon-save-btn"></div></span></button></div>
			</div>
		</div>
		
	</form>
	
	<div class="seprator_15 clear "></div> 
	<div class="line"></div>
	<div class="seprator_15 clear "></div> 
</div>


<script>
	$(document).ready(function(){
	
		uploadMediaFiles('<?php echo $mediaPath;?>','<?php echo $mediaFileTypes;?>','<?php echo $fileMaxSize;?>','<?php echo $browseid?>',1,1,0,'','','_xs');
		
		$("#AjaxcancelButton<?php echo $browseid?>").click(function(){
			
			var toggleDivForm = $(this).closest("form").attr('toggledivform');
			var toggleDivFormID = $(this).closest("form").attr('id');
			$('#'+toggleDivFormID)[0].reset();
			$('#'+toggleDivFormID+' form input[type=hidden]').val('');
			//$('#'+toggleDivFormID+': input').val('');
			$("#"+toggleDivForm).slideToggle('slow');
			
		});
		
		$("#uploadmediaForm<?php echo $browseid?>").validate({
			submitHandler: function() {
				$('html').animate({scrollTop:0}, 'slow');
				var fromData=$("#uploadmediaForm<?php echo $browseid?>").serialize();
				fromData = fromData+'&pressReleaseId=<?php echo $pressReleaseId;?>';
				var url = baseUrl+language+'/news/add_edit_news_video';
				
				$.post(url,fromData, function(data) {
				
				  if(data){
					  $('#MediaFileIdDiv').html(data);
					  $("#uploadFileByJquery<?php echo $browseid?>").click();
					  if($('#fileInput<?php echo $browseid?>') && $('#fileInput<?php echo $browseid?>').val() == ''){
						  refreshPge();
					 }
				  }
				});
			}
		});
		
		//This code for hide and show upload video field
		$(".videoUploadButton").click(function() {
			
			$("#isExternal<?php echo $browseid?>").val('f');
			$("#embededField").hide();
			$("#uploadField").show();
			$("#videoUploadButton").addClass("orange_clr_imp");
			$("#videoEmbedButton").removeClass("orange_clr_imp");
			});
			
			
		//This code for hide and show embed video field
		$(".videoEmbedButton").click(function() {
			
			$("#isExternal<?php echo $browseid?>").val('t');
			$("#embededField").show();
			$("#uploadField").hide();
			$("#videoEmbedButton").addClass("orange_clr_imp");
			$("#videoUploadButton").removeClass("orange_clr_imp");
			
			});	
		
		
	});
	
	function fillVideoFormValue(data,formId){ 
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
				
				if(data.isExternal && data.isExternal == 't'){
					$(".videoEmbedButton").click();
				}else{
					$(".videoUploadButton").click();
				}
			}
		}
	}
	
	
	/*********delete news video************/
	
	function deleteNewsVideoRowAdmin(tbl,field,id,divId,checkbox,removeRow,updateRow,fileId,reloadPage,customMsg){
		
	if(!removeRow || removeRow == ''){
			removeRow ='#row';
	}
	if(!checkbox || checkbox == ''){
			checkbox ='.CheckBox';
	}
	if(!fileId){
			fileId =0;
	}
	if(customMsg){
		areYouSure=customMsg;		
	}	
	
	var url = baseUrl+language+'/news/deleteNewsVideoRowAdmin';
	var ID = new Array();
	if(id>0)
	{
		ID[0] = id;
	}
	else
	{
		ID = checkCheckbox(checkbox);
	}
	if(ID){
		if(confirm(areYouSure)){
			var returnFlag=AJAX(url,divId,ID,tbl,field,fileId,updateRow);
			if(returnFlag){
				if(reloadPage==1){
					setTimeout(refreshPge, 500);
				}else{
					$.each(ID, function(key, value) { 
					  $(removeRow+value).remove();
					});
				}
			}
			return 1;
		}else{
				return 0;
		}
		
	}else{
		alert(atleastSelect);
	}
}
	
</script>
