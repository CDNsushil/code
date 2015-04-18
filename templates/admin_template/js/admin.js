/*---------------------------*/	
var isuploading=false;		
var insertme='';		
var altforinsertme='';		
var fileMaxSize='';		
var fileTypes='';
var mediaFileTypes='';
var filePath='';
var imagefileTypes='';
var thumbImgPath='';
function customAlert(msg){
	msg='<div id="popup_close_btn" class="popup_close_btn" onclick="$(this).parent().trigger(\'close\');"></div><div class="customAlert">'+msg+'</div>';
	$("#popup_box").html(msg);
	$('#popupBoxWp').lightbox_me({
		centered: true, 
		closeEsc:false,
		closeClick:false,
		onLoad: function() {
		}	
	});			
}
/*---------------------------*/		
/*---------------------------*/		
//ajay//
function loader(Container){
	var loaderImage = baseUrl+"images/loading_wbg.gif";
	var img_url = $("<div id='defaultLoader'><img class='ajax_loader' src='" + loaderImage + "' style=\"margin-left: auto; margin-right: auto;\" alt=\"Loading...\" title=\"Loading...\"/></div>");
	return img_url.appendTo('#'+Container);
}
/*---------------------------*/	

function lightBoxWithAjax(BoxWp,Container,URL,val1,val2,val3,val4){	

	if (val1.constructor == Array){
	   val1 = val1.toString();
	}

	$.ajax({
		  type:'POST',
		  data:{
			ajaxHit:1,
			val1:val1,
			val2:val2,
			val3:val3,
			val4:val4
		  },
		  url: baseUrl+language+URL,
		  cache: false,
		  beforeSend: function( ) {
			  $('#'+Container).html(loader(Container));
		  },
		  success: function(html){	
			$('#'+Container).html(html);
			$('#'+BoxWp).lightbox_me({
				centered: true,
				closeEsc:false,
				closeClick:false,
				onLoad: function(){}	
			});		
			$(this).parent;
		  }
	});
}

/*---------------------------*/		
function openLightBox(BoxWp,Container,URL,val1,val2,val3,val4,val5){	
	$('#'+Container).html('');
	$.ajax({
			  type:'GET',
			  data:{
				ajaxHit:1,
				val1:val1,
				val2:val2,
				val3:val3,
				val4:val4,
				val5:val5
			  },
			  url: baseUrl+URL,
			  cache: false,
			  beforeSend: function( ) {
				$('#'+Container).html(loader(Container));
			  },
			  success: function(html){				  
				$('#'+Container).html(html);
				 $('#'+BoxWp).lightbox_me({
					centered: true,
					closeEsc:false,
					closeClick:false,
					onLoad: function() {
					copyClip.init('.copylink');	
					}	
				});		
				if(val1){
					if($('#email')){
						$('#email').val(val1);
					}
				}
				$(this).parent
				
			  }
			});
//destroyOnClose:true, 		
}

/*-----------This lightbox for player----------------*/		
function openPlayerLightBox(BoxWp,Container,URL,val1,val2,val3,val4,val5){	
	$('#'+Container).html('');
	$.ajax({
			  type:'GET',
			  data:{
				ajaxHit:1,
				val1:val1,
				val2:val2,
				val3:val3,
				val4:val4,
				val5:val5
			  },
			  url: baseUrl+language+URL,
			  cache: false,
			  beforeSend: function( ) {
				$('#'+Container).html(loader(Container));
			  },
			  success: function(html){				  
				$('#'+Container).html(html);
				 $('#'+BoxWp).clone().lightbox_me({
					centered: true,
					closeEsc:false,
					destroyOnClose: true,
					closeClick:false,
					onLoad: function() {
						
					}	
				});		
				if(val1){
					if($('#email')){
						$('#email').val(val1);
					}
				}
				$(this).parent
				
			  }
			});
//destroyOnClose:true, 		
}

function openLightBoxWithoutAjax(BoxWp,Container){
	$('#'+Container).show();
	$('#'+Container).html(loader(Container));
    $('#'+BoxWp).lightbox_me({
		centered: true,
		closeEsc:false,
		closeClick:false,
		onLoad: function() {
			if($('#defaultLoader')){
				//$('#defaultLoader').remove();
		    }
			
		}	
	});			
	//destroyOnClose:true,
}
/*-------------------------------------*/


function goTolink(obj,link){
	var value=obj.value;
	if(obj.value != '' && obj.value!=undefined){
		
			link = link+'/'+value;
		
	}
	
	window.location.href=link;
}



function AJAX(url,DivID,val1,val2,val3,val4,val5,val6,val7,val8,val9,val10,val11,val12,val13,val14) {
	
	var returnFlag= false;
	var res;
	
	if (val1.constructor == Array){
	   val1 = val1.toString();
	}
	$.ajax({
		type: 'POST',
		url : url,
		dataType :'html',
		data : {
			val1:val1,
			val2:val2,
			val3:val3,
			val4:val4,
			val5:val5,
			val6:val6,
			val7:val7,
			val8:val8,
			val9:val9,
			val10:val10,
			val11:val11,
			val12:val12,
			val13:val13,
			val14:val14,
			ajaxHit:1
		},		
		beforeSend:function(){
			//alert(val4);
			//alert('AJAX-OUT-PUT-Inside:'+val6);
			if(DivID != '' && (DivID =='catInfo'|| DivID =='educationInfo'|| DivID =='visaTypeInfo'|| DivID =='contentBox'|| DivID =='contentBoxIntro')){
			
				if(DivID != '' && val4!='loadImg' && val4!='loadVideo'){
					$("#"+DivID).html('<img  class="ma ajax_loader" id="loadImg" align="absmiddle" src="'+baseUrl+'images/loading_wbg.gif" />');
				}
			}
			else
			{
				if(DivID != ''){
					if(val11){
						$("#"+DivID).prepend('<img  class="ma ajax_loader" id="loadImg" align="absmiddle" src="'+baseUrl+'images/loading_wbg.gif" />');
					}else{
						$("#"+DivID).html('<img  class="ma ajax_loader" id="loadImg" align="absmiddle" src="'+baseUrl+'images/loading_wbg.gif" />');
					}					
				}
			}
		},
		complete:function(){
			
		},
		success:function(HTML){
			alert(HTML);
			returnFlag= true;
			
			if('#loadImg'){
				$("#loadImg").remove();
			}
			if(DivID=='educationInfo' ||  DivID =='visaTypeInfo'){
				if(val1==0) 
				{					
					$("#"+DivID).prepend(HTML);
				}
				else
				{	
					if(DivID =='visaTypeInfo')
						$("#removeVisaID_"+val7).html(HTML);
					if(DivID =='educationInfo')
						$("#removeID_"+val7).html(HTML);
				}				
				}
			else if(val4=='loadImg'){
				if(DivID != '' && val4=='loadImg' && val3==0)
				{	
					
					$("#"+DivID).prepend(HTML);				
					$("#"+val5).val('');
					$("#"+val6).val(0);
				}
				else
				{					
					res = HTML;
					if(val7)
						$("#removeID_"+val7).html(HTML);
					$('#addCatButton').removeClass('cat_edit_icon');
					$('#addCatButton').addClass('cat_plus_icon');
					$('#catCancel').hide();	
					$("#"+val5).val('');
					$("#"+val6).val(0);
					return res;				
				}
			}
			else{
			
				if(DivID != '')
				{
					if(val11){
						$("#"+DivID).prepend(HTML);
					}else{
						$("#"+DivID).html(HTML);
					}
				}
				else
				{
					res = HTML;
					return res;
				}
			}	
								
		},
		async:false,
        error: function (xhr, ajaxOptions, thrownError) {
			//alert(xhr.status);
			alert(thrownError);
		}
	});
	return returnFlag;
}

function AJAX_json(url,DivID,val1,val2,val3,val4,val5,val6,val7,val8) {
	var returnFlag= false;
	var res =new Array();
	if (val1.constructor == Array){
	   val1 = val1.toString();
	}
	$.ajax({
		type: 'POST',
		url : url,		
		dataType :'json',
		data : {
			val1:val1,
			val2:val2,
			val3:val3,
			val4:val4,
			val5:val5,
			val6:val6,
			val7:val7,
			val8:val8,
			ajaxHit:1
		},
		beforeSend:function(){
			
		},
		complete:function(){
			
		},
		success:function(res){
			
			returnFlag= res;
			if(res.crtId > 0){
				if(val1>0){
					var str ='<div class="cell pro_title">'+val2+'&nbsp;</div><div class="cell pro_name">'+val3+'&nbsp;</div><div class="cell pro_name">'+val4+'&nbsp;</div><div class="pro_btns"><div class="small_btn"><a href="javascript:void(0)" onclick="deleteAssociative(this)" EEID="'+val7+'" crtId="'+val1+'" ><div class="cat_smll_plus_icon"></div></a></div><div class="small_btn"><a javascript:void(0)" onclick="editAssociative(this)" EEID="'+val7+'" crtId="'+val1+'" crtDesignation="'+val2+'" crtName="'+val3+'" crtEmail="'+val4+'"><div class="cat_smll_edit_icon"></div></a></div></div>';
					$("#"+DivID).html(str);
				}else{
					var str ='<li id="row'+res.crtId+'"><div id="rowData'+res.crtId+'" class="pro_li_content_wp"><div class="cell pro_title">'+val2+'&nbsp;</div><div class="cell pro_name">'+val3+'&nbsp;</div><div class="cell pro_name">'+val4+'&nbsp;</div><div class="pro_btns"><div class="small_btn"><a href="javascript:void(0)" onclick="deleteAssociative(this)" EEID="'+val7+'" crtId="'+res.crtId+'" ><div class="cat_smll_plus_icon"></div></a></div><div class="small_btn"><a javascript:void(0)" onclick="editAssociative(this)" EEID="'+val7+'" crtId="'+res.crtId+'" crtDesignation="'+val2+'" crtName="'+val3+'" crtEmail="'+val4+'"><div class="cat_smll_edit_icon"></div></a></div></div></div></li>';
					$("#"+DivID).prepend(str);
				}
			}
			if(res.SpId > 0){
				if(res.editFlg > 0){
					DivID='rowData'+res.SpId;
					var str ='<div class="cell pro_title">'+res.countryNmame+'</div><div class="cell pro_title">'+val6+val3+'</div><div class="pro_btns"><div class="small_btn"><a href="javascript:void(0)" onclick="deleteShippingCharges(this)" EEID="'+val7+'" SpId="'+res.SpId+'" ><div class="cat_smll_plus_icon"></div></a></div><div class="small_btn"><a javascript:void(0)" onclick="editShippingCharges(this)" EEID="'+val7+'" SpId="'+res.SpId+'" SpCountry="'+val2+'" SpAmount="'+val3+'" ><div class="cat_smll_edit_icon"></div></a></div></div>';
					$("#"+DivID).html(str);
				}else{
					var str ='<li id="row'+res.SpId+'"><div id="rowData'+res.SpId+'" class="pro_li_content_wp"><div class="cell pro_title">'+res.countryNmame+'</div><div class="cell pro_title">'+val6+val3+'</div><div class="pro_btns"><div class="small_btn"><a href="javascript:void(0)" onclick="deleteShippingCharges(this)" EEID="'+val7+'" SpId="'+res.SpId+'" ><div class="cat_smll_plus_icon"></div></a></div><div class="small_btn"><a javascript:void(0)" onclick="editShippingCharges(this)" EEID="'+val7+'" SpId="'+res.SpId+'" SpCountry="'+val2+'" SpAmount="'+val3+'" ><div class="cat_smll_edit_icon"></div></a></div></div></div></li>';
					$("#"+DivID).prepend(str);
				}
			}
		},
		async:false,
		error: function (xhr, ajaxOptions, thrownError) {
			//alert(xhr.status);
			alert(thrownError);
		}
	});
	return returnFlag;
}



		/* Upload heavy files Added by gurutva July 16 2012 */
function uploadMediaFiles(fileUploadPath,fileTypes,fileMaxSize,uniId,isMultipleForm,isReloadPage,norefresh,imgload,checksection,imgext)
{ 
	
	//alert(fileUploadPath);
	if(!uniId){uniId='';}
	if(!norefresh){norefresh=0;}
	if(!isReloadPage){isReloadPage=1;}
	var relocate = false;
	var fileSrc='';
	
	var saveButton='#uploadFileByJquery'+uniId; 
	var flash_url=baseUrl+"templates/system/javascript/jquery-upload/plupload.flash.swf"; 
	fileUploadPath = fileUploadPath.replace(/\//g, "+");
	fileTypes = fileTypes.replace(/\|/g, ",");
	var fileExtension ='';
	var uploadedFileName = '';
	var uploaderId = new plupload.Uploader({                    
		runtimes: 'html5,flash,gears,browserplus,silverlight,html4',  
		url:baseUrl+language+"/common/JqueryUploadMediaFile/"+fileUploadPath,
		flash_swf_url:baseUrl+"templates/system/javascript/jquery-upload/plupload.flash.swf",
		max_file_count: 1,
		browse_button : "browsebtn"+uniId,
		button_browse_hover : true,
		drop_element : "dropArea"+uniId,
		autostart : true,
		max_file_size: fileMaxSize,
		container: "FileContainer"+uniId,
		chunk_size: '1mb',
		unique_names: true,
		multi_selection:false           
	 });                

		var fileTypesFilter = 'notallow';
		var $body = $("body");
		var $dropArea = $("#dropArea"+uniId);

		uploaderId.init();
		uploaderId.bind('FilesAdded', function(up, files) {
			if (uploaderId.files.length > 1) {
				for(var j=0; j<(uploaderId.files.length-1); j++){
					uploaderId.removeFile(uploaderId.files[j]);
				}
			}
				
			$dropArea.removeClass();
			
			$.each(files, function(i, file) {
				//Checks a comma delimted list for allowable file types set file types to allow for all
				fileExtension = file.name.substring(file.name.lastIndexOf(".")+1, file.name.length).toLowerCase();
				var fileOriginalExtension = file.name.substring(file.name.lastIndexOf(".")+1, file.name.length);
				var fileTypeRuntime = $('#fileTypeRuntimeDiv'+uniId).is(":visible");
				if(fileTypeRuntime == true) {
					fileTypes = $('#fileTypeRuntime'+uniId).val();
				}
				fileTypes = fileTypes.replace(/\|/g, ",");
				//alert(fileTypes);
				var supportedExtensions = fileTypes.split(",");
				var supportedFileExtension = ($.inArray(fileExtension.toLowerCase(),supportedExtensions) >= 0);
				if(fileTypesFilter == "allow")
				{
					supportedFileExtension = !supportedFileExtension
				}
				filename = file.name;
				if((fileTypes == "all") || supportedFileExtension)
				{
					$('#fileError'+uniId).html('');
					filename = file.name;
					fileSrc = baseUrl+"/"+fileUploadPath+file.id+'.'+fileOriginalExtension;
					uploadedFileName=file.id+'.'+fileOriginalExtension;		  
					if('#fileName'+uniId)
						$('#fileName'+uniId).val(file.id+'.'+fileOriginalExtension);
					if('#fileInput'+uniId)
						$('#fileInput'+uniId).val(filename);
					if('#FileField'+uniId)
						$('#FileField'+uniId).val(filename);
					if('#fileSize'+uniId){
						$('#fileSize'+uniId).val(file.size);
					}
					
					var totalFileSize=file.size;
					var upload2ndFileDiv = $('#upload2ndFileDiv').is(":visible");
					
					if(upload2ndFileDiv){
						var browseId1st =$('#browseId1st').val();
						var browseId2nd =$('#browseId2nd').val();
						var fileSize1st =$('#fileSize'+browseId1st).val();
						var fileSize2nd =$('#fileSize'+browseId2nd).val();
						fileSize1st=parseInt(fileSize1st);
						fileSize2nd=parseInt(fileSize2nd);
						var totalFileSize=(fileSize1st + fileSize2nd);
					}
					
					if(totalFileSize > fileMaxSize){
						  uploaderId.trigger("Error", {
							  code : "-600",
							  message : fileSizeErrorMasg,
							  file : file
						  });
					}
					
					up.refresh();
					$(saveButton).click(function(){
						
						var errorlength = 0;
						$('input.error').each(function(index){
								errorlength=(errorlength+1);
						});
						var inputFilename=$('#fileInput'+uniId).val();
						var inputFileExtension='';
						
						if(inputFilename.length > 4 ){
							inputFileExtension = inputFilename.substring(inputFilename.lastIndexOf(".")+1, inputFilename.length).toLowerCase();
						}							
						
						if(($('#Uploadvideo'+uniId).is(":visible")) && (errorlength==0) && (inputFileExtension!=''))
						{										
							uploaderId.start();
							if(isReloadPage==1){
								openLightBoxWithoutAjax('popupBoxWp','popup_box'); 
							}							
						}					
					});
				}
				else
				{
					$('#fileInput'+uniId).val(filename);
					$('#fileError'+uniId).html(fileNotSupportedMasg);
					uploaderId.stop();
					uploaderId.refresh(); 
				}
			});
		});

		uploaderId.bind('UploadProgress', function(up, file) {
			isuploading=true;
			$("#progressBar"+uniId).show();
			$("#plupload_progress_bar"+uniId).attr("style", "width:"+ file.percent + "%");
			$("#percentComplete"+uniId).html(file.percent+"%");
			window.onbeforeunload = function() {
			  if(isuploading){
				  return leavePageMasg;
			  }
			}
		});
		uploaderId.bind('FileUploaded', function(up, file) {
			
			isuploading=false;	
			var MediaFileId = $('#MediaFileId').val();
			if(MediaFileId && MediaFileId > 0){
				
				var updateData={"jobStsatus":"NEW"};
				var where={"fileId":MediaFileId};
				AJAX( baseUrl+language+'/common/editDataFromTabel','',updateData,'MediaFile',where);
			}
			var imgFile = ["gif","jpeg","jpg","png","exif","tiff","tif","raw","bmp","ppm","pgm","pmb","pnm","tga"];
			if(checkValueInArray(imgFile,fileExtension)){
				var createWaterMarkFlag = $('#createWaterMarkFlag').val();
				if(createWaterMarkFlag && createWaterMarkFlag == 1){}
				else{createWaterMarkFlag=0;}
				
				$returnFlag= AJAX( baseUrl+language+'/common/createthumbimages','',fileUploadPath,uploadedFileName,createWaterMarkFlag);
			}
								 
			$('#progressBar'+uniId).hide() ;						 
			$('#percentComplete'+uniId).html('');						
			
			
			var returnform =  $('#relocateId').val();
			if(returnform && returnform.length >= 5) { 
				
				 window.location.href = returnform;
				 relocate = true;
			}
			
			if(isReloadPage==1 && norefresh != 1 && relocate == false){
				timeout = setTimeout(refreshPge, 1000);
			}else{
				$('#popup_box').parent().trigger('close');
				var popupBoxIsVisible = $('#popupBoxWp').is(":visible");
				if(popupBoxIsVisible == true) {
					$('#popupBoxWp').css("display", "none");;
				}
				$('#defaultLoader').remove();
			}
		});

	   uploaderId.bind('Error', function(up, err) {
			
			$errorPanel = $("div.error:first");
			//-600 means the file is larger than the max allowable file size on the uploader thats set in the options above.
			if(err.code == "-600")
			{
				$('#fileInput'+uniId).val('');
				$('#fileError'+uniId).html(fileSizeErrorMasg);
				lightBoxWithAjax('popupBoxWp','popup_box','/package/notEnoughSpace/','','');
			}
			else
			{
				$('#fileInput'+uniId).val('');
				$('#fileError'+uniId).html(fileErrorMasg+ err.file.name);
			}
			uploaderId.stop();
			uploaderId.refresh(); // Reposition Flash/Silverlight
			
		});
		
	}
	
	function deleteTabelRow(tbl,field,id,divId,checkbox,removeRow,fileId,filePath,isLogSummery,deleteCache,reloadPage,customMsg){
	
	if(!deleteCache){
		deleteCache='';
	}
	if(!removeRow || removeRow == ''){
			removeRow ='#row';
	}
	if(!checkbox || checkbox == ''){
			checkbox ='.CheckBox';
	}
	if(!fileId){
			fileId =0;
	}
	if(!filePath){
			filePath ='';
	}
	if(!isLogSummery){
			isLogSummery =0;
	}
	if(customMsg){
		areYouSure=customMsg;		
	}	
	
	var url = baseUrl+language+'/common/deleteTabelRow';
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
			var returnFlag=AJAX(url,divId,ID,tbl,field,fileId,filePath,isLogSummery,deleteCache);
			if(returnFlag){
				$.each(ID, function(key, value) { 
				  $(removeRow+value).remove();
				});
				
				if($('#uploadElementForm')){
					if($('#uploadElementForm').is(":visible")){
						$("#uploadElementForm").slideToggle('slow');
					}
				}
				if(reloadPage==1){
					setTimeout(refreshPge, 500);
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
	
	
	function deleteTabelRowAdmin(tbl,field,id,divId,checkbox,removeRow,fileId,reloadPage,customMsg){
	
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
	
	var url = baseUrl+language+'/common/deleteTabelRowAdmin';
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
			var returnFlag=AJAX(url,divId,ID,tbl,field,fileId);
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



function mousedown_big_button(obj){
		obj.style.backgroundPosition ='-0px -96px';
		obj.firstChild.style.backgroundPosition ='right -96px';
	}

	function mouseout_big_button(obj){
		obj.style.backgroundPosition ='0px 0px';
		obj.firstChild.style.backgroundPosition ='right -0px';
	}

	function mouseup_big_button(obj){
		obj.style.backgroundPosition ='0px -0px';
		obj.firstChild.style.backgroundPosition ='right -0px';
	}
	function mousedown_tds_button(obj){
		obj.style.backgroundPosition ='0px -76px';
		obj.children[0].style.backgroundPosition ='right -76px';
	}
	function mouseup_tds_button(obj){
		obj.style.backgroundPosition ='0px -38px';
		obj.children[0].style.backgroundPosition ='right -38px';
	}

	function mousedown_blog_button(obj){
	obj.style.backgroundPosition ='0px -26px';
	obj.firstChild.style.backgroundPosition ='right -26px';
	}
	function mouseup_blog_button(obj){
		obj.style.backgroundPosition ='0px -0px';
		obj.firstChild.style.backgroundPosition ='right -0px';
	}


	function mousedown_cat_button(obj){
	obj.style.backgroundPosition ='0px -35px';
	obj.firstChild.style.backgroundPosition ='right -35px';
	}

	function mouseup_cat_button(obj){
		obj.style.backgroundPosition ='0px -0px';
		obj.firstChild.style.backgroundPosition ='right -0px';
	}

	// for the small buttons 
	
	function mousedown_huge_button(obj){
		$(obj).attr('class','huge_btn_down Price_btn_style ptr');
	}
	
	function mouseup_huge_button(obj){
		$(obj).attr('class','huge_btn Price_btn_style ptr');
	}
	
	/*new button function*/
	function mousedown_apply_btn(obj){
		obj.className ='Apply_big_btn_down';
	}
	function mouseup_apply_btn(obj){
		obj.className ='Apply_big_btn';
	}


	function mousedown_small_button(obj){
	obj.style.backgroundPosition ='-0px -39px';
	obj.firstChild.style.backgroundPosition ='right -39px';
	}

	function mouseover_small_button(obj){
	obj.style.backgroundPosition ='-0px -20px';
	obj.firstChild.style.backgroundPosition ='right -20px';
	}


	function mouseout_small_button(obj){
		
	obj.style.backgroundPosition ='0px 0px';
	obj.firstChild.style.backgroundPosition ='right -0px';
	}

	function mouseup_small_button(obj){
		obj.style.backgroundPosition ='0px -0px';
		obj.firstChild.style.backgroundPosition ='right -0px';
	}
	
		
	/* Front End button function start */
	function mousedown_tds_button_front(obj){
	obj.className ='tds-button_new_down';
	}
	
	function mouseup_tds_button_front(obj){
	obj.className ='tds-button_new';
	}


	function mousedown_tds_button01(obj){
		//alert(obj.children[0]);
		obj.style.backgroundPosition ='0px -40px';
		obj.children[0].style.backgroundPosition ='right -40px';
	}
	
	function mouseup_tds_button01(obj){
		obj.style.backgroundPosition ='0px 0px';
		obj.children[0].style.backgroundPosition ='right 0px';
	}
	
	function mousedown_plus_icon(obj){
		obj.style.backgroundPosition ='0px -50px';
	}
	function mouseup_plus_icon(obj){
		obj.style.backgroundPosition ='0px 0px';
	}
	
	function mousedown_tds_download(obj){
		
		$(obj).css("background-position","0px -36px");
		$(obj).children(":first").css("background-position","right -36px");
	}
	function mouseup_tds_download(obj){
		$(obj).css("background-position","0px 0px");
		$(obj).children(":first").css("background-position","right 0px");
	}
	 
	 
	 function refreshPge()
	{ 
		window.location.href=window.location.href;
	}


	function checkValueInArray(array,val){
		
		if($.inArray(val.toLowerCase(),array) > 0){
			return true;
		}else{
			return false;
		}
	}

	/* Function to get listing of project types */
	function getTypeListing(divId1,divId2,val1,val2,val3){
		var url = baseUrl+'/admin/settings/manage_genre/getTypeList';
		$('#'+divId2+' option').each(function(i, option){ $(option).remove(); });
		$('#'+divId2).append( new Option(val3,'') );
		AJAX(url,divId1,val1,val2);
	}

	/* Function to get Project categories and Project types */
	function getStyleProject(divId1,divId2,val1,val2,catId,typeId){
		if(val1!=''){
			$('#projectStyle').show();
			var url = baseUrl+'/admin/settings/manage_genre/getProjectStyle';
			$('#'+divId2+' option').each(function(i, option){ $(option).remove(); });
			$('#'+divId2).append( new Option(val2,'') );
			if(catId!='' && typeId!=''){
				AJAX(url,divId1,val1,catId,typeId);
			}else{
				AJAX(url,divId1,val1);
			}
		}else{
			$('#projectStyle').hide();
		}
	}

function copyStr(id,str)
	{ 
		
		$('#'+id).zclip({
			path:baseUrl+'swf/zeroClipboard.swf',
			copy:str
		});
	}

var copyClip = {
	init: function(controlId) {
		$(controlId).zclip({
			//path: "http://www.steamdev.com/zclip/js/ZeroClipboard.swf",
			path:baseUrl+'swf/zeroClipboard.swf',
			copy: function() {
					return $('#gsInput').val();
			}
		});
	}
}

function runTimeCheckBox(){
		$('.defaultP input').ezMark();
		$('.customP input[type="checkbox"]').ezMark({checkboxCls: 'ez-checkbox-green', checkedCls: 'ez-checked-green'})	
	}
	
function selectBox(){
	if( /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent) ) {			
		$("SELECT").css("visibility", "visible");
		$("SELECT").addClass("pt3");
	}
	else{
		$("SELECT").selectBoxJquery();			
	}
}

$(document).ready(function() {
	
	/********************************************************************************************************************
	CLOSES ALL DIVS ON PAGE LOAD
	********************************************************************************************************************/	
	$("div.accordionContent").hide();
	selectBox();
	runTimeCheckBox();
	
});
